<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PaymentController extends Controller {

    public $testing_schema = 'beta_testing.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requests() {
        $this->data['requests'] = \App\Request::latest()->paginate();
        return view('payment.api_requests', $this->data);
    }

    public function invoices() {
        $where = request()->segment(3) == 0 ? '=' : '!=';
        $this->data['invoices'] = DB::table('api.invoices')->where('schema_name', $where, 'beta_testing')->get();
        return view('payment.invoices', $this->data);
    }

    public function createInvoice() {
        if ($_POST) {
            $schema = request('schema');
            $schema_setting = DB::table($schema . ".setting")->first();
            $limit = request('limit');
            $students = DB::table($this->testing_schema . 'student')->inRandomOrder()->limit($limit)->get();
            foreach ($students as $student) {
                $this->createSingleStudentInvoice($student->studentID, $student->classesID, $student->academic_year_id, $schema_setting,$schema);
            }
            return redirect('api/invoices/0')->with('success','Success');
        }
        $this->data['schemas'] = (new \App\Http\Controllers\DatabaseController())->loadSchema();
        return view('payment.create_invoice', $this->data);
    }

    public function createInvoiceNo($schema_setting) {
///concatenate with registration number of the school.

        $invoiceNo = $schema_setting->institution_code . rand(1, 999) . substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ'), 0, 3) . rand(1, 999);
        $data = DB::table($this->testing_schema . 'invoices')->where('invoiceNO', $invoiceNo)->first();
        if (!empty($data)) {
            return $this->createInvoiceNo($schema_setting);
        } else {
            return $invoiceNo;
        }
    }

    public function createSingleStudentInvoice($studentID, $classesID, $year_id, $schema_setting,$schema) {
        $academic_year_id = $year_id;
        $timedate = date("Y-m-d");

        $fee_installment_ids = DB::table($this->testing_schema . 'fee_installment_classes')->where('class_id', $classesID)->get();
        $student_invoice = DB::SELECT('SELECT * FROM ' . $this->testing_schema . 'invoices where "studentID"=' . $studentID . ' AND academic_year_id=' . $academic_year_id . ' and status <>\'3\' order by date desc');

        //Start Transaction
        try {
            DB::beginTransaction();
            if (count($student_invoice) == 0) {
                $invoice_no = $this->createInvoiceNo($schema_setting);
                $array = array(
                    'classesID' => $classesID,
                    'studentID' => $studentID,
                    'invoice_title' => $schema_setting->sname,
                    'optional_name' => $schema,
                    'invoiceNO' => $invoice_no,
                    'academic_year_id' => $academic_year_id,
                    'date' => $timedate
                );

                $returnID = DB::table($this->testing_schema . 'invoices')->insertGetId($array, 'id');
            } else {

                $returnID = $student_invoice[0]->id;
            }
            $message = 'Invoices are successfully created';
            $type = 'success';
            $is_subscribe = 0;
            foreach ($fee_installment_ids as $fee_installment_id) {
                // $fee_subscription = $this->fee_m->get_fee_subscription_by_student($fee_installment_id->fee_id, $studentID, $academic_year_id);
                if (TRUE) {
                    $is_subscribe = $is_subscribe + 1;
                    $fee_installment_info = DB::table($this->testing_schema . 'fee_installment')->where('id', $fee_installment_id->id)->first();
//check if a student is subscribed to that fee;
                    $check = DB::select('SELECT "c".*, "b"."fee_installment_id" FROM ' . $this->testing_schema . 'fee_installment a
JOIN ' . $this->testing_schema . 'invoice_fee b ON "b"."fee_installment_id" = "a"."id"
JOIN ' . $this->testing_schema . 'invoices c ON "c"."id" = "b"."invoices_id"
WHERE "c"."studentID" =  ' . $studentID . '
AND "b"."fee_installment_id" =  ' . $fee_installment_id->id . '');

                    if (count($check) == 0) {
                        $check_discount = DB::table($this->testing_schema . 'fee_discount')->where(array('studentID' => $studentID, 'fee_id' => $fee_installment_info->fee_id, 'academic_year_id' => $academic_year_id))->get();
                        $amount = $fee_installment_info->amount;
                        if (count($check_discount) > 0) {
                            if ($check_discount[0]->fee_installment_id == NULL) {
                                $amount = $fee_installment_info->amount - ($check_discount[0]->discount * $fee_installment_info->fee_percent) / 100;
                            } else {
                                foreach ($check_discount as $fee_install_discount) {
                                    if ($fee_install_discount->fee_installment_id == $fee_installment_info->id) {
                                        $amount = $fee_installment_info->amount - $fee_install_discount->discount;
                                    }
                                }
                            }
                        }

                        $check_due = collect(\DB::SELECT('select amount,installment_id from ' . $this->testing_schema . ' due_amount   where  fee_id=' . $fee_installment_info->fee_id . ' AND student_id=' . $studentID . ''))->first();
                        if (count($check_due) > 0 && ($check_due->installment_id == $fee_installment_info->installment_id)) {
                            $amount = $amount + $check_due->amount;
                        }
                        $invoice_fee_array = array(
                            'fee_installment_id' => $fee_installment_id->id,
                            'amount' => $amount,
                            'invoices_id' => $returnID,
                            'date' => date("Y-m-d")
                        );

                        DB::table($this->testing_schema . 'invoice_fee')->insert($invoice_fee_array);
                        $data = array('academic_year_id' => $academic_year_id, 'student_id' => $studentID);
                        $last_due_amount = DB::table($this->testing_schema . 'student_archive')->where($data)->first();
                        if (!empty($last_due_amount)) {
                            $due_amount = $last_due_amount->due_amount + $amount;
                            DB::table($this->testing_schema . 'student_archive')->where($data)->update(array('due_amount' => $due_amount));
                        }
                    } else {
                        $message = 'Invoices are successfully created skipping already generated invoices';
                        $type = 'success';
                    }
                }
            }
            //throw new Exception("something happened");
            DB::commit();
        } catch (Exception $e) {
            //Log::debug("something bad happened");
            $message = 'Invoices are successfully created skipping already generated invoices';
            $type = 'success';
            DB::rollBack();
        }
        return $returnID;
    }

    public function payment($school = null) {
        $this->data['schools'] = DB::select("select distinct table_schema from information_schema.tables where table_schema not in ('admin','pg_catalog','information_schema','api','app')");
        if ($school != null) {
            $this->data['payments'] = DB::table('admin.all_payment')->join($school . '.invoices', 'admin.all_payment.invoiceID', $school . '.invoices.id')->join($school . '.invoices', 'admin.all_payment.invoiceID', $school . '.invoices.id')->where('schema_name', $school)->get();
            //dd($this->data['payments']);
        } else {
            $this->data['payments'] = array();
        }
        return view('payment.payment', $this->data);
    }

}

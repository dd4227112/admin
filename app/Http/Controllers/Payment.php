<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Model\Api_invoice;
use \App\Model\All_payment;
use DB;

class Payment extends Controller {

     public function __construct() {
        $this->middleware('auth');
    }
    public $testing_schema = 'beta_testing.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requests() {
        $this->data['requests'] = \App\Model\Request::orderBy('created_at', 'desc')->paginate();
        return view('payment.api_requests', $this->data);
    }

    public function invoices() {
        $where = request()->segment(3) == 0 ? '=' : '!=';
        $this->data['invoices'] = DB::table('api.invoices')->where('schema_name', $where, 'beta_testing')->where('amount', '>', 0)->get();
        return view('payment.invoices', $this->data);
    }

    public function show($id) {
        $where = request()->segment(3) == 0 ? '=' : '!=';
        if ($id == 'paid') {
            $this->data['invoices'] = All_payment::whereIn('status', ['3', '1'])->where('amount', '>', 0)->get();
            return view('payment.paid', $this->data);
        } else if ($id == 'posted') {
            $this->data['invoices'] = Api_invoice::where('schema_name', $where, 'beta_testing')->where('amount', '>', 0)->get();
            return view('payment.paid', $this->data);
        } else if ($id == 'info') {
            
        } else {
            $this->data['invoices'] = Api_invoice::where('schema_name', $where, 'beta_testing')->where('amount', '>', 0)->get();
            return view('payment.paid', $this->data);
        }
    }

    public function syncInvoice() {
        $invoices = DB::select('select * from api.invoices where sync=0 and amount >0 order by random() limit 10');
        if (count($invoices) > 0) {
            foreach ($invoices as $invoice) {
                $token = $this->getToken($invoice);
                if (strlen($token) > 4) {
                    $fields = array(
                        "reference" => $invoice->reference,
                        "student_name" => $invoice->student_name,
                        "student_id" => $invoice->student_id,
                        "amount" => $invoice->amount,
                        "type" => $this->getFeeNames($invoice->id, $invoice->schema_name),
                        "code" => "10",
                        "callback_url" => "http://158.69.112.216:8081/api/init",
                        "token" => $token
                    );
                    if ($invoice->schema_name == 'beta_testing') {
                        //testing invoice
                        $setting = DB::table($invoice->optional_name . '.setting')->first();
                        $url = 'https://wip.mpayafrica.com/v2/invoice_submission';
                    } else {
                        //live invoice
                        $setting = DB::table($invoice->schema_name . '.setting')->first();
                        $url = 'https://api.mpayafrica.co.tz/v2/invoice_submission';
                    }
                    $curl = $this->curlServer($fields, $url);
                    $result = json_decode($curl);
                    if (($result->status == 1 && strtolower($result->description) == 'success') || $result->description == 'Duplicate Invoice Number') {
//update invoice no
                        DB::table($invoice->schema_name . '.invoices')
                                ->where('reference', $invoice->reference)->update(['sync' => 1, 'return_message' => $curl]);
                    } else {
                        DB::table('api.requests')->insert(['content' => $curl . ', request=' . json_encode($fields)]);
                    }
                }
            }
        }
    }

    public function createInvoice() {
        if ($_POST) {
            $schema = request('schema');
            $schema_setting = DB::table($schema . ".setting")->first();
            $limit = request('limit');
            $students = DB::select('select * from ' . $this->testing_schema . 'student order by random() limit ' . $limit);
            foreach ($students as $student) {
                $this->createSingleStudentInvoice($student->student_id, $student->classesID, $student->academic_year_id, $schema_setting, $schema);
            }
            return redirect('api/invoices/0')->with('success', 'Success');
        }
        $this->data['schemas'] = (new \App\Http\Controllers\DatabaseController())->loadSchema();
        return view('payment.create_invoice', $this->data);
    }

    public function cancelInvoice() {
        $invoice = \collect(DB::select('select * from admin.api_invoices where "reference"=\'' . request('invoice') . '\' limit 1'))->first();
        $token = $this->getToken($invoice);
        if (strlen($token) > 4) {
            $fields = array(
                "reference" => $invoice->reference,
                "token" => $token
            );
            if ($invoice->schema_name == 'beta_testing') {
                //testing invoice
                $setting = DB::table($invoice->optional_name . '.setting')->first();
                $url = 'https://wip.mpayafrica.com/v2/invoice_cancel';
            } else {
                //live invoice
                $setting = DB::table($invoice->schema_name . '.setting')->first();
                $url = 'https://api.mpayafrica.co.tz/v2/invoice_cancel';
            }
            $curl = $this->curlServer($fields, $url);
            $result = json_decode($curl);
            if ($result->status == 1) {
//update invoice no
                DB::table($invoice->schema_name . '.invoices')
                        ->where('reference', $invoice->reference)->update(['sync' => 0, 'return_message' => $curl]);
                return redirect('api/invoices/0')->with('success', 'success');
            } else {
                DB::table('api.requests')->insert(['content' => $curl . ', request=' . json_encode($fields)]);
                return redirect('api/invoices/0')->with('error', 'error');
            }
        }
    }

    private function curlServer($fields, $url) {
// Open connection
        $ch = curl_init();
// Set the url, number of POST vars, POST data

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'application/x-www-form-urlencoded'
        ));

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function getToken($invoice) {
        if ($invoice->schema_name == 'beta_testing') {
            //  $setting = DB::table('beta_testing.setting')->first();
            $url = 'https://wip.mpayafrica.com/v2/auth';
            $credentials = DB::table('admin.all_bank_accounts_integrations')->where('invoice_prefix', $invoice->prefix)->first();
            if (count($credentials) == 1) {
                $user = trim($credentials->sandbox_api_username);
                $pass = trim($credentials->sandbox_api_password);
            } else {
                $user = '';
                $pass = '';
            }
        } else {
            //live invoice
            // $setting = DB::table($invoice->schema_name . '.setting')->first();
            $url = 'https://api.mpayafrica.co.tz/v2/auth';
            $credentials = DB::table($invoice->schema_name . '.bank_accounts_integrations')->where('invoice_prefix', $invoice->prefix)->first();
            if (count($credentials) == 1) {
                $user = trim($credentials->api_username);
                $pass = trim($credentials->api_password);
            } else {
                $user = '';
                $pass = '';
            }
        }
        $request = $this->curlServer([
            'username' => $user,
            'password' => $pass
                ], $url);

        $obj = json_decode($request);
        //DB::table('api.requests')->insert(['return' => json_encode($obj), 'content' => json_encode($request)]);
        if (isset($obj) && is_object($obj) && isset($obj->status) && $obj->status == 1) {
            return $obj->token;
        }
    }

    public function createInvoiceNo($schema_setting) {
///concatenate with registration number of the school.

        $invoiceNo = $schema_setting->institution_code . rand(1, 999) . substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ'), 0, 3) . rand(1, 999);
        $data = DB::table($this->testing_schema . 'invoices')->where('reference', $invoiceNo)->first();
        if (!empty($data)) {
            return $this->createInvoiceNo($schema_setting);
        } else {
            return $invoiceNo;
        }
    }

    public function createSingleStudentInvoice($student_id, $classesID, $year_id, $schema_setting, $schema) {
        $academic_year_id = $year_id;
        $timedate = date("Y-m-d");

        $fee_installment_ids = DB::table($this->testing_schema . 'fees_installments_classes')->where('class_id', $classesID)->get();
        $student_invoice = DB::SELECT('SELECT * FROM ' . $this->testing_schema . 'invoices where "student_id"=' . $student_id . ' AND academic_year_id=' . $academic_year_id . ' order by date desc');

        //Start Transaction
        try {
            DB::beginTransaction();
            if (count($student_invoice) == 0) {
                $invoice_no = $this->createInvoiceNo($schema_setting);
                $array = array(
                    'classesID' => $classesID,
                    'student_id' => $student_id,
                    'invoice_title' => $schema_setting->sname,
                    'optional_name' => $schema,
                    'reference' => $invoice_no,
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
                // $fee_subscription = $this->fee_m->get_fee_subscription_by_student($fee_installment_id->fee_id, $student_id, $academic_year_id);
                if (TRUE) {
                    $is_subscribe = $is_subscribe + 1;
                    $fee_installment_info = DB::table($this->testing_schema . 'fee_installments')->where('id', $fee_installment_id->id)->first();
//check if a student is subscribed to that fee;
                    $check = DB::select('SELECT "c".*, "b"."fee_installment_id" FROM ' . $this->testing_schema . 'fee_installments a
JOIN ' . $this->testing_schema . 'invoice_fee b ON "b"."fee_installment_id" = "a"."id"
JOIN ' . $this->testing_schema . 'invoices c ON "c"."id" = "b"."invoices_id"
WHERE "c"."student_id" =  ' . $student_id . '
AND "b"."fee_installment_id" =  ' . $fee_installment_id->id . '');

                    if (count($check) == 0) {
                        $check_discount = DB::table($this->testing_schema . 'fee_discount')->where(array('student_id' => $student_id, 'fee_id' => $fee_installment_info->fee_id, 'academic_year_id' => $academic_year_id))->get();
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

                        $check_due = collect(\DB::SELECT('select amount,installment_id from ' . $this->testing_schema . ' due_amount   where  fee_id=' . $fee_installment_info->fee_id . ' AND student_id=' . $student_id . ''))->first();
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
                        $data = array('academic_year_id' => $academic_year_id, 'student_id' => $student_id);
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
            $this->data['setting'] = DB::table($school . '.setting')->first();
            if ($school == 'beta_testing') {
                $this->data['payments'] = DB::table($school . '.payment')->join($school . '.invoices', $school . '.payment.invoiceID', $school . '.invoices.id')->join($school . '.student', $school . '.invoices.student_id', $school . '.student.student_id')->join($school . '.receipt', $school . '.receipt.paymentID', $school . '.payment.paymentID')->get();
            } else {
                $this->data['payments'] = DB::table('admin.all_payment')->join($school . '.invoices', 'admin.all_payment.invoiceID', $school . '.invoices.id')->join($school . '.student', $school . '.invoices.student_id', $school . '.student.student_id')->join($school . '.receipt', $school . '.receipt.paymentID', $school . '.payment.paymentID')->where('schema_name', $school)->get();
            }
        } else {
            $this->data['setting'] = array();
            $this->data['payments'] = array();
        }
        return view('payment.payment', $this->data);
    }

    public function transactions() {
        $this->data['setting'] = array();
        $this->data['payments'] = array();
        $this->data['schools'] = DB::select("select distinct table_schema from information_schema.tables where table_schema not in ('admin','pg_catalog','information_schema','api','app')");
        if ($_POST) {
            $school = request('school');
            $invoice = DB::table('api.invoices')->where('schema_name', $school)->first();
            $token = $this->getToken($invoice);
            $fields = array(
                "reconcile_date" => date('d-m-Y', strtotime(request('from'))),
                "callback_url" => "http://158.69.112.216:8081/api/init",
                "token" => $token
            );
            $url = 'https://api.mpayafrica.co.tz/v2/reconcilliation';
            $curl = $this->curlServer($fields, $url);
            $result = json_decode($curl);
            dd($result);
        }
        return view('payment.transactions', $this->data);
    }

}
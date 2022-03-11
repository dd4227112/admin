<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use \App\Model\UserDeduction;
use DB;
use App\Rules\InterestRateRule;

class Loan extends Controller {

    function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        if (can_access('manage_payroll')) {

          $this->data['type'] = $id = (request()->segment(3));
            if ((int) $id > 0) {
                $this->data['applications'] = \App\Models\LoanApplication::where('approval_status', $id)->latest()->get();
            } else {
                $this->data['applications'] = \App\Models\LoanApplication::latest()->get();
            }
            return view('account.payroll.loan.index',$this->data);

        } else if (!can_access('manage_payroll')) {
             $this->data['type']  = $id = (request()->segment(3));
            if ((int) $id > 0) {
                $this->data['applications'] = \App\Models\LoanApplication::where('approval_status', $id)->where('user_id', Auth::user()->id)->latest()->get();
            } else {
                $this->data['applications'] = \App\Models\LoanApplication::where('user_id', Auth::user()->id)->latest()->get();
            }
            return view('account.payroll.loan.index',$this->data);

        } else {
            return view('account.payroll.loan.index',$this->data);
        }
    }

      public function type() {
        $this->data['breadcrumb'] = array('title' => 'Loan types','subtitle'=>'loans','head'=>'payroll');
               $id = request()->segment(3);
               $loan_id = request()->segment(4);

            if ($id == 'edit' && (int) $loan_id > 0) {
                $this->data['breadcrumb'] = array('title' => 'Edit  types','subtitle'=>'loans','head'=>'payroll');
                $this->data['type'] = \App\Models\LoanType::find($loan_id);
                if ($_POST) {
                    $this->data['type']->update(request()->all());
                    return redirect('loan/type')->with('success','Successfully updated!');
                 }
                return view('account.payroll.loan.type.edit',$this->data);
            } else if ($id == 'delete' && (int) $loan_id > 0) {
                \App\Models\LoanType::find($loan_id)->delete();
                return redirect()->back()->with('success','Successfully deleted!');
            } else {
                $this->data['types'] = \App\Models\LoanType::latest()->get();
                return view('account.payroll.loan.type.index',$this->data);
            }
    }

    private function saveLoanApplication() {
        //get all loan parameters
        //insert in application table
            $user_id = request('user_id') == null ? Auth::user()->id : request('user_id');
             $data=[
            'user_id' => $user_id, 
            'created_by' => Auth::user()->id,
            'amount' => remove_comma(request('amount')),
            'payment_start_date' => date('Y-m-d'),
            'loan_type_id' => request('loan_type_id'),
            'qualify' => request('qualify'),
            'months' => request('months'),
            'description' => request('description'),
            'loan_source_id' => request('loan_source_id'),
            'monthly_repayment_amount' => request('loan_monthly_repayment')
           ]; 
    
         \App\Models\LoanApplication::create($data);
          return redirect('loan/index')->with('success','Loan created successfull');
     }

    public function loanAdd() {
        $this->data['breadcrumb'] = array('title' => 'Add loan','subtitle'=>'loans','head'=>'payroll');
        $this->data['type'] = 0;
        $this->data['loan_types'] = \App\Models\LoanType::all();
        if (can_access('manage_payroll')) {
            if ($_POST) { 
                return $this->saveLoanApplication();
            }
            return view('account.payroll.loan.add',$this->data);
        } else if (!can_access('manage_payroll')) {
            if ($_POST) {
                return $this->saveLoanApplication();
            }
            return view('account.payroll.loan.add',$this->data);
        } else {
            return view('account.payroll.loan.type.index',$this->data);
        }
    }

    //once admin approve that loan, take application loan ID and associate it with deduction loan, by setting start date and end date for that loan to be taken from the system
    //be careful, if school offer interest, then each month, calculate interest rate and take a profit out of it to be stored in school as revenue
    // test for loan, and now connect ALL banks, but first, hire a BDM with great experience in banking and finance
    public function approveLoan() {
        $application_id = request()->segment(3);
        $deduction = \collect(DB::select("select * from deductions where predefined=1 and lower(name)='loan'"))->first();
       
        if (empty($deduction)) {
            //create deduction and name it, a loan
            $deduction = \App\Models\Deduction::create(['name' => 'Loan', 'description' => 'Staff Loan Application', 'predefined' => 1]);
        }
        $application = \App\Models\LoanApplication::find($application_id);
           $arr = [
                'user_id' => $application->user_id,
                'deduction_id' => $deduction->id, 
                'created_by' => Auth::user()->id, 
                'deadline' => date('Y-m-d', strtotime("+ {$application->months} months")),
                'type' => 0,
                'amount' => $application->monthly_repayment_amount, 
                'loan_application_id' => $application->id
                ];
          \App\Models\UserDeduction::create($arr);

        //reduce this amount from cash and record it in account receivable
        $refer_expense = \collect(DB::select("select * from refer_expense where lower(name) like '%account receivable%' "))->first();
        if (empty($refer_expense)) {
            $predefineds = ['name' => "Account Receivable", 'financial_category_id' => 5, 'predefined' => 1];
            $refer_expense = \App\Models\ReferExpense::create($predefineds);
        }

        \App\Models\Revenue::create([
            'refer_expense_id' => $refer_expense->id, 
            'amount' => $application->amount,
            //'created_by_id' => session('id'),
            'created_by_id' => Auth::user()->id,
            'loan_application_id' => $application->id,
            'user_in_shulesoft' => 1, 'user_id' => $application->user_id
        ]);
        \App\Models\LoanApplication::where('id', $application_id)->update([
            'approval_status' => 1, 'approved_by' => Auth::user()->id, 'payment_start_date' => 'now()'
        ]);
        // $this->session->set_flashdata('success', $this->lang->line('menu_success'));
         return redirect()->back()->with('success','Approved successfull!');
        // return redirect(url('loan/index'));
    }

    public function getDetails() {
        $loan_id = request('id');
        $loan = \App\Models\LoanType::find($loan_id);
        echo json_encode($loan);
        
    }

    public function getNetPayment() {
        $user_id = request('user_id') == null ? \Auth::user()->id : request('user_id');
    
        $usalary = \App\Models\Salary::where('user_id', $user_id)->orderBy('id', 'desc')->first();
        if (empty($usalary)) {
            $user_salary = \collect(DB::select('select salary from admin.users where id =' . $user_id))->first();
            $pensions = \App\Models\UserPension::where('user_id', $user_id)->get();
            $pension_employee_contribution = 0;
            $gross_pay = $user_salary->salary;
            foreach ($pensions as $pension) {
                $pension_employee_contribution += $pension->pension->employee_percentage * ($gross_pay) / 100;
            }
            $taxable_amount = $gross_pay - $pension_employee_contribution;
            $tax = \App\Models\Paye::where('from', '<=', round($taxable_amount, 0))->where('to', '>=', round($taxable_amount, 0))->first();
            $paye = (!empty($tax)) ? ($taxable_amount - $tax->from) * $tax->tax_rate / 100 + $tax->tax_plus_amount : 0;
            $salary = ['salary' => $gross_pay - $paye];
        } else {
            $salary = ['salary' => $usalary->net_pay];
        }
        echo json_encode($salary);
    }

    public function getRepayment() {
        $loan_amount = request('amount');
        $months = (int) request('month') <= 0 ? 1 : request('month');
        $rate = request('rate');
        echo $this->calculateMonthlyPayments($loan_amount, $rate, $months);
    }

    /**
     * @desc    Calculates the monthly payments of a loan
     *             based on the APR and Term.
     *
     * @param    Float    $fLoanAmount    The loan amount.
     * @param    Float    $fAPR            The annual interest rate.
     * @param    Integer    $iTerm            The length of the loan in months.
     * @return    Float    Monthly Payment.
     */
    function calculateMonthlyPayments($fLoanAmount, $fAPR, $iTerm) {
        return ($fLoanAmount / $iTerm) + (($fLoanAmount / $iTerm) / 100 * ($fAPR / 12 * $iTerm));
    }

    function calcPayment($loanAmount, $totalPayments, $interest) {
        //***********************************************************
        //              INTEREST * ((1 + INTEREST) ^ TOTALPAYMENTS)
        // PMT = LOAN * -------------------------------------------
        //                  ((1 + INTEREST) ^ TOTALPAYMENTS) - 1
        //***********************************************************

        $value1 = $interest * pow((1 + $interest), $totalPayments);
        $value2 = pow((1 + $interest), $totalPayments) - 1;
        $pmt = $loanAmount * ($value1 / $value2);
        return $pmt;
    }

    
    public function add() {
        $this->data['breadcrumb'] = array('title' => 'Add loan type','subtitle'=>'loans','head'=>'payroll');

            $this->data['type'] = $id = request()->segment(3);
            if ($_POST) {
                request()->validate([
                'name' => 'required|max:255',
                remove_comma("minimum_amount") => "required|min:0|max:3000000000",
                remove_comma("maximum_amount") => "required|max:3000000000|gt:minimum_amount",
                "minimum_tenor" => "required|max:1200|min:0",
                "maximum_tenor" => "required|max:1200|min:0|gt:minimum_tenor",
                "interest_rate" => ["required",  new InterestRateRule()],
                "credit_ratio"  => "required|min:0",
                "description"   => "required"
                ]);
               
                \App\Models\LoanType::create(['name' => request('name'),
                'minimum_amount' => remove_comma(request('minimum_amount')),
                'maximum_amount' => remove_comma(request('maximum_amount')),
                'minimum_tenor'  => remove_comma(request('minimum_tenor')),
                'maximum_tenor'  => remove_comma(request('maximum_tenor')),
                'interest_rate'  => request('interest_rate'),
                'credit_ratio'   => request('credit_ratio'),
                'description'    => request('description'),
                'created_by'     => \Auth::user()->id
               ]); 
                return redirect('loan/type')->with('success','Successfully!');
            } else {
                $this->data["subview"] = "account.payroll.loan.type.add";
                return view($this->data['subview'], $this->data);
            }
    }

    public function edit() {
        if (can_access('manage_payroll')) {
            $id = request()->segment(3);
            if ((int) $id) {
                $this->data['deduction'] = \App\Models\Deduction::find($id);
                if ($this->data['deduction']) {
                    if ($_POST) {
                        $this->validate(request(), [
                            'name' => 'required|max:255',
                            "is_percentage" => "required",
                            "description" => "required"
                                ]);
                        $this->data['deduction']->update(request()->except('_token'));
                        if ((int) $this->data['deduction']->employer_percent > 0 || (int) $this->data['deduction']->employer_amount > 0) {
                            $scheck = \App\Models\ReferExpense::where('name', $this->data['deduction']->name)->first();
                            if (empty($scheck)) {
                                $code = strtoupper(substr(set_schema_name(), 0, 2));
                                \App\Models\ReferExpense::create(['name' => $this->data['deduction']->name, 'financial_category_id' => 2, 'note' => 'Deductions', 'code' => 3232, 'code' => $code . '-OPEX-' . rand(1900, 582222),
                                    'predefined' => 1]);
                            }
                        }
                       // $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                        return redirect(base_url("deduction/index/" . $this->data['deduction']->category))->with('success','Success');
                    } else {
                        $this->data["subview"] = "deduction/edit";
                     //   $this->load->view('_layout_main', $this->data);
                    }
                } else {
                    $this->data["subview"] = "error";
                 //   $this->load->view('_layout_main', $this->data);
                }
            } else {
                $this->data["subview"] = "error";
              //  $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
           // $this->load->view('_layout_main', $this->data);
        }
    }

    public function delete() {
            $id = request()->segment(3);
            if ((int) $id) {

                //bad enought, there are transactions that dont have reference
                //check if there are any payments, and reject
                if (!can_access('manage_payroll')) {
                    //we prevent normal user to delete other people application
                    $loan_applications = \App\Models\LoanApplication::where('id', $id)->where('user_id', \Auth::user()->id)->get();
                    if (empty($loan_applications)) {
                        return redirect()->back()->with('warning', 'Sorry, you can only delete your own application');
                    }
                }
                $user_applications = DB::table('loan_payments')->where('loan_application_id', $id)->first();

                if (!empty($user_applications)) {
                   return redirect()->back()->with('error','You cannot delete this loan because payments already done  on this loan!');
                } else {
                  $user_deductions = DB::table('user_deductions')->where('loan_application_id', $id)->first();
                  $user_revenues = DB::table('revenues')->where('loan_application_id', $id)->first();
                    // Prevent deleting a Approved loan
                     if(!empty($user_deductions) || !empty($user_revenues)) {
                        return redirect()->back()->with('error','You cannot delete this loan because its already approved!');
                    }
                   // Once loan is unApproved you can delete it
                    DB::table('user_deductions')->where('loan_application_id', $id)->delete();
                    DB::table('revenues')->where('loan_application_id', $id)->delete();
                    DB::table('loan_applications')->where('id', $id)->delete();
                   return redirect()->back()->with('success','Loan deleted successfull!');
                }
                return redirect()->back();
            } else {
                return redirect()->back();
            }
         
    }

    public function subscribe() {
        $id = clean_htmlentities(($this->uri->segment(3)));
        if ((int) $id) {
            $this->data['set'] = $id;
            $this->data['type'] = 'deduction';
            $this->data['allowance'] = \App\Models\Deduction::find($id);
            $subscriptions = \App\Models\UserDeduction::where('deduction_id', $id)->get();
            $data = [];
            foreach ($subscriptions as $value) {
                $data = array_merge($data, array($value->user_id . $value->table));
            }
            $this->data['users'] = (new \App\Http\Controllers\Payroll())->getUsers();
            $this->data['subscriptions'] = $data;
            $this->data["subview"] = "payroll/subscribe";
            $this->load->view('_layout_main', $this->data);
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

 
    public function uploadFileByExcel() {
        ini_set('max_execution_time', 300); //overwrite execution time, 5min
        $data = $this->uploadExcel();
        $status = $this->excelCheckKeysExists($data, array('phone', 'amount', 'deadline', 'deduction_name'));
        if ((int) $status == 1 && count($data) > 0) {
            $status = '';
            foreach ($data as $val) {
                $value = array_change_key_case($val, CASE_LOWER);

                $deduction_name = isset($value['deduction_name']) ? $value['deduction_name'] : 'null';
                $deduction = \App\Model\Deduction::where(DB::raw('lower(name)'), strtolower($deduction_name))->first();

                $phone = isset($value['phone']) ? $value['phone'] : 'null';
                $valid = validate_phone_number($phone);

                $valid_phone = is_array($valid) ? $valid[1] : 'null';
                $user = \App\Model\User::where('phone', $valid_phone)->first();
                if (empty($user)) {
                    $status .= '<p class="alert alert-danger">User with this number ' . $value['phone'] . ' does not exists</p>';
                } else if (empty($deduction)) {
                    $status .= '<p class="alert alert-danger">This deduction name ' . $value['dediction_name'] . ' does not exists. Please define it first or write it correctly</p>';
                } else {
                    $user_deduction = UserDeduction::where('user_id', $user->id)->where('table', $user->table)->where('type', 0)->where('deadline', '>', date('Y-m-d', strtotime($value['deadline'])));

                    $obj = ['user_id' => $user->id, 'table' => $user->table, 'deduction_id' => $deduction->id, 'deadline' => date('Y-m-d', strtotime($value['deadline'])), 'type' => 0, 'amount' => $value['amount']];

                    if (!empty($user_deduction->first())) {
                        $user_deduction->update($obj);
                    } else {
                        UserDeduction::create($obj);
                    }
                    $status .= '<p class="alert alert-success">Deduction for user "' . $user->name . '" '
                            . '  added successfully</p>';
                }
            }
        }
        $this->data['status'] = $status;
        $this->data["subview"] = "mark/upload_status";
        $this->load->view('_layout_main', $this->data);
    }

}

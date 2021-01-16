<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use DB;

class Payroll extends Controller {

    function __construct() {
        $this->middleware('auth');
    }

    public function taxes() {
        $this->data['taxes'] = DB::table('constant.paye')->get();
        $this->data['subview'] = 'account.payroll.taxes';
        return view($this->data['subview'], $this->data);
    }

    public function pension() {
        $this->data['pensions'] = \App\Models\Pension::all();
        $id = (request()->segment(3));
        $this->data['set'] = $id;
        if ((int) $id) {
            $this->data['type'] = 'pension';
            $this->data['users'] = $this->getUsers();
            $subscriptions = DB::table('user_pensions')->where('pension_id', $id)->get();
            $data = [];
            foreach ($subscriptions as $value) {
                $data = array_merge($data, array($value->user_id . $value->table));
            }
            $this->data['subscriptions'] = $data;
            $this->data["subview"] = "account/payroll/subscribe";
            return view($this->data['subview'], $this->data);
        } else {
            $this->data['subview'] = 'account/payroll/pension';
            return view($this->data['subview'], $this->data);
        }
    }

    function addPension() {
        if (!empty($_POST)) {
            $this->validate(request(), [
                'name' => 'required|iunique:pensions,name',
                'employer_percentage' => 'required|min:1|numeric',
                'employee_percentage' => 'required|min:1|numeric',
                'refer_pension_id' => 'required',
                'address' => 'required',
                'status' => 'required|min:0|numeric',
                    ], $this->custom_validation_message);
            $pensions = request()->all();
            $pension = \App\Model\Pension::create($pensions);
            $group = \App\Model\AccountGroup::where('name', 'Employer Contributions')->first();
            $account_group_id = $group ? $group->id : \App\Model\AccountGroup::create(['name' => 'Employer Contributions', "financial_category_id" => 3, 'predefined' => 1])->id;
            // auto Add it to the chart of accounts
            DB::table('refer_expense')->insert([
                    ["name" => request('name') . ' Contributions', "financial_category_id" => 3, "account_group_id" => $account_group_id, 'code' => 'EC-1001' . $pension->id, 'predefined' => $pension->id]]);

            $this->session->set_flashdata('success', $this->lang->line('menu_success'));
            return redirect(base_url('payroll/pension'));
        } else {
            $this->data['subview'] = 'payroll/add_pension';
            $this->load->view('_layout_main', $this->data);
        }
    }

    function deletePension() {
        $id = $this->segment(3);
        $pension = \App\Model\Pension::find($id);
        if (!empty($pension)) {
            //check if there are members
            $user_pension = \App\Model\UserPension::where('pension_id', $id)->get();
            if (empty($user_pension)) {
                $pension->delete();
                DB::table('refer_expense')->where("predefined", $pension->id)->where("financial_category_id", 3)->where('code', 'EC-1001' . $pension->id)->delete();

                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                return redirect(base_url('payroll/pension'));
            } else {
                $this->session->set_flashdata('error', 'You cannot delete this pension fund. There are members already subscribed');
                return redirect(base_url('payroll/pension'));
            }
        }
    }

    function editPension() {
        $id = $this->segment(3);
        $this->data['pension'] = \App\Model\Pension::find($id);
        if (!empty($_POST)) {
            $this->validate(request(), [
                'name' => ['required', Rule::unique('pensions')->ignore($id, 'id')],
                'employer_percentage' => 'required|min:1|numeric',
                'employee_percentage' => 'required|min:1|numeric',
                'address' => 'required',
                'status' => 'required|min:0|numeric',
                    ], $this->custom_validation_message);
            $pensions = request()->all();
            $this->data['pension']->update($pensions);
            DB::table('refer_expense')->where("predefined", $this->data['pension']->id)->where("financial_category_id", 3)->where('code', 'EC-1001' . $this->data['pension']->id)->update(['name' => request('name') . ' Contributions']);
            $this->session->set_flashdata('success', $this->lang->line('menu_success'));
            return redirect(base_url('payroll/pension'));
        } else {
            $this->data['subview'] = 'payroll/edit_pension';
            $this->load->view('_layout_main', $this->data);
        }
    }

    function pensionContribution() {
        $pension_id = request('id');
        $set = request('set');
        if (strlen($set) > 5 && (int) $pension_id > 0) {
            $salary = \App\Model\Salary::where('payment_date', $set)->get();
            $salary_ids = array();
            foreach ($salary as $value) {
                array_push($salary_ids, $value->id);
            }
            $this->data['pension'] = \App\Model\Pension::find($pension_id);
            $this->data['pensions'] = count($salary) > 0 ?
                    \App\Model\SalaryPension::where('pension_id', $pension_id)->whereIn('salary_id', $salary_ids)->get() : array();
            $this->data['subview'] = 'payroll/pensioncontribution';
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function deleteSubscriber() {
        $user_id = request('user_id');
        $table = request('table');
        $type = request('type');
        $id = request('set');
        switch ($type) {
            case 'pension':
                DB::table('user_pensions')->where('user_id', $user_id)->where('pension_id', $id)->where('table', $table)->delete();
                $url = base_url("payroll/pension/" . $id);
                break;
            case 'allowance':
                DB::table('user_allowances')->where('user_id', $user_id)->where('allowance_id', $id)->where('table', $table)->delete();
                $url = base_url("allowance/subscribe/" . request('set'));
                break;
            case 'deduction':
                DB::table('user_deductions')->where('user_id', $user_id)->where('deduction_id', $id)->where('table', $table)->delete();
                $url = base_url("deduction/subscribe/" . request('set'));
                break;
            default:
                $url = base_url("allowance/index/");
                break;
        }
        return request()->ajax() == TRUE ? 'success' : redirect($url)->with('success', 'Successfully Unsubscribed');
    }

    public function subscribe() {
        $type = request('datatype');
        if ($type == 'allowance') {
            $table = 'user_allowances';
            $table_id = 'allowance_id';
        } else if ($type == 'pension') {
            $table = 'user_pensions';
            $table_id = 'pension_id';
        } else if ($type == 'deduction') {
            $table = 'user_deductions';
            $table_id = 'deduction_id';
        }
        $insert_array = array(
            'user_id' => request('user_id'),
            'table' => request('table'),
            $table_id => request('tag_id'),
            'created_by' => '{' . session('id') . ',' . session('table') . '}'
        );
        $insert = $type == 'pension' ?
                array_merge(array('checknumber' => request('checknumber')), $insert_array) :
                array_merge($insert_array, ['amount' => (bool) request('is_percentage') == 0 ? (float) request('checknumber') : null,
                    'percent' => (bool) request('is_percentage') == 1 ? (float) request('checknumber') : null]);
        $final_array = $type == 'deduction' ? array_merge($insert, [
                    (bool) request('is_percentage') == 1 ? 'employer_percent' : 'employer_amount' => request('employer_amount')
                ]) : $insert;
        $check = ['user_id' => request('user_id'), 'table' => request('table'), $table_id => request('tag_id')];
        $validate = DB::table($table)->where($check)->first();
        if (empty($validate)) {
            $user_pensions = DB::table($table)->insertGetId($final_array);
            echo (int) $user_pensions > 0 ? 'Successfully Added' : 'Error occurs on subscribe, please try again later';
        } else {
            echo 'This Staff Already Subscribed ';
        }
    }

    public function checknumber() {
        $insert = array(
            'checknumber' => request('inputs'),
        );
        $user_pension = DB::table('user_pensions')->where('user_id', request('user_id'))->where('table', request('table'))->first();
        $pension_id = !empty($user_pension) ? $user_pension->id : request('pension_id');
        $user_pensions = DB::table('user_pensions')->where('id', $pension_id)->update($insert);
        echo (int) $user_pensions > 0 ? 'Success' : 'Error';
    }

    public function index() {

        $id = (request()->segment(3));
        $this->data['set'] = $id;
        $this->data['salaries'] = DB::select('select count(*) as total_users, sum(basic_pay) as basic_pay, sum(allowance) as allowance, sum(gross_pay)'
                        . ' as gross_pay, sum(pension_fund) as pension, sum(deduction) as deduction, sum(tax) as tax, sum(paye) as paye, sum(net_pay) as net_pay, '
                        . ' payment_date,reference FROM salaries group by payment_date,reference order by payment_date');
        return view('account/payroll/index', $this->data);
    }

    public function show() {
        if (can_access('manage_payroll') || session('table') == 'user' || session('table') == 'teacher') {
            $id = (request()->segment(3));
            $this->data['set'] = $id;
            $this->data['salaries'] = \App\Model\Salary::where('payment_date', $id)->get();
            $this->data["subview"] = "payroll/view";
            $this->load->view('_layout_main', $this->data);
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    private function getSalaryCategory() {
        $id = \DB::table('refer_expense')->where('name', 'ilike', 'salary')->value('id');
        if ((int) $id > 0) {
            return $id;
        } else {
            $code = strtoupper(substr(set_schema_name(), 0, 2));
            $array = array(
                "name" => 'salary',
                "financial_category_id" => 2, //fixed category for OPEX
                "note" => 'Salary Expense',
                'code' => $code . '-OPEX-' . rand(1900, 582222),
                "status" => "",
                'predefined' => 1
            );
            return DB::table('refer_expense')->insertGetId($array);
        }
    }

    public function create() {
        if (can_access('manage_payroll')) {
            $this->data['create'] = 0;
            $this->data['special'] = (int) request()->segment(3) > 0 ? 1 : 0;
            if ($_POST) {
                $payroll_date = request('payroll_date');
                $refer_expense_id = $this->getSalaryCategory();
                if ((int) $refer_expense_id > 0) {
                    $this->data['create'] = 1;
                    $this->data['refer_expense_id'] = $refer_expense_id;
                    $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                    $this->data['users'] = $this->getUsers();
                    $this->data["subview"] = "payroll/create";
                    $this->load->view('_layout_main', $this->data);
                } else {
                    //less likely to occur
                    $this->session->set_flashdata('error', 'Please define first expense category called salary in Account setting');
                    return redirect(base_url('payroll/create'));
                }
            } else {
                $this->data['users'] = $this->getUsers();
                $this->data["subview"] = "payroll/create";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function getUsers() {
        return \App\Model\User::whereIn('table', ['user', 'teacher'])->where('status', 1)->where('payroll_status', 1)->get();
    }

    public function payslip() {
        $this->data['set'] = request('set');
        $this->data['salary'] = \App\Model\Salary::where('payment_date', request('set'))->where('user_id', request('id'))->where('table', request('table'))->first();

        $user = \App\Model\User::where('id', request('id'))->where('table', request('table'))->first();
        if ($_POST) {
            $settings = DB::table('payslip_settings')->first();
            $vars = get_object_vars($settings);
            $obj = array();
            foreach ($vars as $key => $variable) {
                if (!in_array($key, array('id', 'created_at'))) {
                    $obj = array_merge($obj, array($key => request($key) == null ? 0 : request($key)));
                }
            }
            !empty($obj) ? \App\Model\PayslipSetting::first()->update($obj) : '';
        }
        $this->data['user'] = !empty($user) ? $user : die('User not found');
        $this->data["subview"] = "payroll/payslip";
        $this->load->view('_layout_main', $this->data);
    }

    public function salary() {

        $this->data['salaries'] = DB::select('select count(*) as total_users, sum(basic_pay) as basic_pay, sum(allowance) as allowance, sum(gross_pay) as gross_pay, sum(pension_fund) as pension, sum(deduction) as deduction, sum(tax) as tax, sum(paye) as paye, sum(net_pay) as net_pay, payment_date,reference,user_id,id FROM ' . set_schema_name() . 'salaries  where user_id=' . session('id') . ' and "table"=\'' . session('table') . '\' group by payment_date,reference,user_id,id');
        $this->data["subview"] = "payroll/salary";
        $this->load->view('_layout_main', $this->data);
    }

    public function payslipAll() {
        $salaries = \App\Model\Salary::where('payment_date', request('set'))->get();
        $this->data['salaries'] = count($salaries) > 0 ? $salaries : die('User not found');
        return view('payroll.payslip_print_all', $this->data);
    }

    public function summary() {
        if (request('set') != '' && strlen(request('set') > 8)) {
            $this->data['basic_payments'] = DB::select('select count(*), sum(basic_pay)  as amount, "table" from ' . set_schema_name() . 'salaries where payment_date=\'' . request('set') . '\' group by "table" ');
            $this->data['allowances'] = DB::select('select  sum(a.amount), a.allowance_id, b.name from ' . set_schema_name() . 'salary_allowances a join ' . set_schema_name() . 'allowances b on b.id=a.allowance_id  where salary_id IN (SELECT id FROM ' . set_schema_name() . 'salaries where payment_date=\'' . request('set') . '\')group by a.allowance_id,b.name');

            $this->data['deductions'] = DB::select('select  sum(a.amount), sum(a.employer_amount) as employer_amount,a.deduction_id, b.name from ' . set_schema_name() . 'salary_deductions a join ' . set_schema_name() . 'deductions b on b.id=a.deduction_id  where salary_id IN (SELECT id FROM ' . set_schema_name() . 'salaries where payment_date=\'' . request('set') . '\')group by a.deduction_id,b.name');


            $this->data['pensions'] = DB::select('select a.pension_id, sum(a.amount) as employee_contribution, sum(a.employer_amount) as employer_contribution, b.name from ' . set_schema_name() . 'salary_pensions a join ' . set_schema_name() . 'pensions b on b.id=a.pension_id  where salary_id IN (SELECT id FROM ' . set_schema_name() . 'salaries where payment_date=\'' . request('set') . '\')group by a.pension_id,b.name');

            $this->data["subview"] = "payroll/summary";
            $this->load->view('_layout_main', $this->data);
        } else {
            return redirect(base_url("payroll/index"));
        }
    }

    function delete($id, $x, $y) {
        DB::statement('delete FROM ' . set_schema_name() . 'salaries where reference=\'' . $y . '\'');
        DB::statement('delete from ' . set_schema_name() . 'expense where ref_no=\'' . $y . '\'');
        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
        return redirect(base_url("payroll/index"));
    }

    public function viewTaxSummary() {
        if (request('set') != '') {
            $this->data['set'] = request('set');
            $this->data['salaries'] = \App\Model\Salary::where('payment_date', request('set'))->get();
            $this->data["subview"] = "payroll/tax_summary";
            $this->load->view('_layout_main', $this->data);
        } else {
            return redirect(base_url("payroll/index"));
        }
    }

    public function summaryForm() {
        //$deduction_id = request('type');
        $set = request('set');
        $ded_id = request('ded_id');
        if (strlen($set) > 5) {
            $salary = \App\Model\Salary::where('payment_date', $set)->get();
            $salary_ids = array();
            foreach ($salary as $value) {
                array_push($salary_ids, $value->id);
            }

            $this->data['deductions'] = (int) $ded_id == 0 ? \App\Model\Deduction::all() : \App\Model\Deduction::where('id', $ded_id)->get();
            $this->data['users'] = count($salary) > 0 ? $salary : array();

            $this->data['subview'] = 'payroll/summaryform';
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function bankSubmission() {
        $id = request('set');
        $this->data['set'] = request('set');
        $this->data['month'] = request('set');
        $this->data['skip'] = (int) request('skip') == 0 ? 1 : 0;
        $this->data['deductions'] = DB::select('select  sum(a.amount), sum(a.employer_amount) as employer_amount, c.name as bank_name, a.deduction_id, b.account_number, b.name from ' . set_schema_name() . 'salary_deductions a join ' . set_schema_name() . 'deductions b on b.id=a.deduction_id  left join ' . set_schema_name() . 'bank_accounts c on c.id=b.bank_account_id  where salary_id IN (SELECT id FROM ' . set_schema_name() . 'salaries where payment_date=\'' . request('set') . '\')group by a.deduction_id,b.name,c.name, b.account_number');
        $this->data['salaries'] = \App\Model\Salary::where('payment_date', $id)->get();
        $this->data['subview'] = 'payroll/banksubmission';
        $this->load->view('_layout_main', $this->data);
    }

    public function allowanceIndex() {
        $this->data['category'] = $id = ((request()->segment(3)));
        if ((int) $id > 0) {
            $this->data['allowances'] = \App\Models\Allowance::where('category', $id)->get();
        } else {
            $this->data['allowances'] = [];
        }
        return view('account.payroll.allowance.index', $this->data);
    }

    public function deductionIndex() {

        $this->data['type'] = $id = (request()->segment(3));
        if ((int) $id > 0) {
            $this->data['deductions'] = \App\Models\Deduction::where('category', $id)->get();
        } else {
            $this->data['deductions'] = [];
        }
        $this->data['subview'] = '';
        return view('account/payroll/deduction/index', $this->data);
    }

    public function loanType() {

        $id = request()->segment(3);
        $loan_id = request()->segment(4);
        if ($id == 'edit' && (int) $loan_id > 0) {
            $this->data['type'] = \App\Models\LoanType::find($loan_id);
            if ($_POST) {
                $this->validate(request(), [
                    'name' => 'required|max:255',
                    "minimum_amount" => "required|numeric|min:0|max:3000000000",
                    "maximum_amount" => "required|max:3000000000|gt:minimum_amount",
                    "minimum_tenor" => "required|max:1200|min:0",
                    "maximum_tenor" => "required|max:1200|min:0|gt:minimum_tenor",
                    "interest_rate" => "required|min:0|max:100",
                    "credit_ratio" => "required|min:0|max:100",
                    "description" => "required"
                        ], $this->custom_validation_message);
                $this->data['type']->update(request()->all());
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                return redirect(base_url("loan/type/"));
            }
            $this->data['subview'] = 'loan.type.edit';
            $this->load->view('_layout_main', $this->data);
        } else if ($id == 'delete' && (int) $loan_id > 0) {
            \App\Model\LoanType::find($loan_id)->delete();
            $this->session->set_flashdata('success', $this->lang->line('menu_success'));
            return redirect(base_url("loan/type/"));
        } else {
            $this->data['types'] = \App\Models\LoanType::all();
            $this->data['subview'] = 'loan.type.index';
            return view('account.payroll.loan.type.index', $this->data);
        }
    }
    
      public function loanIndex() {
      
            $this->data['type'] = $id =request()->segment(3);
            if ((int) $id > 0) {
                $this->data['applications'] = \App\Models\LoanApplication::where('approval_status', $id)->get();
            } else {
                $this->data['applications'] = \App\Models\LoanApplication::all();
            }
            $this->data['subview'] = 'loan/index';
            return view('account.payroll.loan.index', $this->data);
     
            
            if (in_array(session('table'), ['user', 'teacher']) && !can_access('manage_payroll')) {
            $this->data['type'] = $id = clean_htmlentities(($this->uri->segment(3)));
            if ((int) $id > 0) {
                $this->data['applications'] = \App\Model\LoanApplication::where('approval_status', $id)->where('user_id', session('id'))->where('table', session('table'))->get();
            } else {
                $this->data['applications'] = \App\Model\LoanApplication::where('user_id', session('id'))->where('table', session('table'))->get();
            }
            $this->data['subview'] = 'loan/index';
            $this->load->view('_layout_main', $this->data);
        }
    }

}
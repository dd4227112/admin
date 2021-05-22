<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;
use \App\Model\ReferExpense;
use \App\Model\Invoice;
use \App\Model\Student;
use \App\Model\Payment;
use \App\Model\Revenue;

class Expense extends Controller {

    /**
     * -----------------------------------------
     * 
     * ******* Address****************
     * INETS COMPANY LIMITED
     * P.O BOX 32258, DAR ES SALAAM
     * TANZANIA
     * 
     * 
     * *******Office Location *********
     * 11th block, Bima Road, Mikocheni B, Kinondoni, Dar es salaam
     * 
     * 
     * ********Contacts***************
     * Email: <info@inetstz.com>
     * Website: <www.inetstz.com>
     * Mobile: <+255 655 406 004>
     * Tel:    <+255 22 278 0228>
     * -----------------------------------------
     */
    function __construct() {
        $this->middleware('auth');
    }

    public function index() {
         $this->data['id'] = $id = request()->segment(3);

            if ((int) $id) {
                $this->data['id'] = $id;
                if ($_POST) {
                    $to_date = request("to_date");
                    $from_date = request("from_date");
                } else {
                    $academic_year_to = \App\Models\AcademicYear::whereYear('start_date', date('Y'))->first();
                    $academic_year_from = \App\Models\AcademicYear::orderBy('start_date', 'asc')->first();

                    $from_date = $academic_year_from->start_date;
                    !empty($academic_year_to) ? $to_date = $academic_year_to->end_date : $to_date = date("Y-12-30");
                  //  $to_date = $academic_year_to->end_date;

                    // $academic_year = \App\Model\AcademicYear::whereYear('start_date', date('Y'))->first();
                    // $from_date = count($academic_year) == 1 ? $academic_year->start_date : date('Y-01-01');
                    // $to_date = $academic_year->end_date;
                    // $to_date = date("Y-m-d");
                }
                $this->data['from_date'] = $from_date;
                $this->data['to_date'] = $to_date;
                $this->data['expenses'] = $this->getCategories_by_date($id, $from_date, $to_date);
            }
            $this->data["subview"] = "expense/index";
            $this->load->view('_layout_main', $this->data);
      
    }

    public function getBanktransactions($from_date, $to_date) {
        $sql = 'select sum(coalesce(a.amount,0)) as amount,a.bank_account_id,b.name from ' . set_schema_name() . ' bank_transactions a join bank_accounts b on b.id=a.bank_account_id where a."date" >= ' . "'$from_date'" . ' AND  a."date" <= ' . "'$to_date'" . ' and a.payment_type_id <>1 group by a.bank_account_id,b.name';

        return DB::SELECT($sql);
    }

    public function getCashtransactions($from_date, $to_date, $payment_type_id) {
        return \collect(DB::SELECT('select sum(coalesce(amount,0)) as amount from ' . set_schema_name() . ' bank_transactions where payment_type_id=' . $payment_type_id . ' and "date" >= ' . "'$from_date'" . ' AND  "date" <= ' . "'$to_date'" . ''))->first();
    }

    public function getCategories($id) {
        switch ($id) {
            case 1:
                $result = ReferExpense::where('financial_category_id', 4)->get();
                break;
            case 2:
                $result = ReferExpense::where('financial_category_id', 6)->get();
                break;
            case 3:
                $result = ReferExpense::where('financial_category_id', 7)->get();
                break;
            case 4:
                $result = ReferExpense::whereIn('financial_category_id', [2, 3])->get();
                break;
            case 5:
                $result = ReferExpense::where('financial_category_id', 5)->get();
                break;
            case 6:
                $result = ReferExpense::where('financial_category_id', 6)->get();
                break;
            default:
                $result = array();
                break;
        }
        return $result;
    }

    public function getCategories_by_date($id, $from_date, $to_date) {
        switch ($id) {
            case 1:
                $result = ReferExpense::where('financial_category_id', 4)->get();
                break;
            case 2:
                $result = ReferExpense::where('financial_category_id', 6)->get();
                break;
            case 3:
                $result = ReferExpense::where('financial_category_id', 7)->get();
                break;
            case 4:
                $result = ReferExpense::whereIn('financial_category_id', [2, 3])->get();
                break;
            case 5:
                $result = ReferExpense::where('financial_category_id', 5)->get();
                break;
            default:
                $result = array();
                break;
        }
        return $result;
    }

    public function view_expense() {
        $id = clean_htmlentities(($this->uri->segment(3)));
        $refer_id = clean_htmlentities(($this->uri->segment(4)));
        $bank_id = clean_htmlentities(($this->uri->segment(5)));
        $academic_year_to = \App\Model\AcademicYear::whereYear('start_date', date('Y'))->first();
        $academic_year_from = \App\Model\AcademicYear::orderBy('start_date', 'asc')->first();

        $from_date = $academic_year_from->start_date;
        $to_date = $academic_year_to->end_date;
        if ((int) $id) {
            $refer_expense = \App\Model\ReferExpense::find($id);

            if (can_access('view_expense')) {
                if ($_POST) {
                    if (request("to_date")) {
                        $d1 = request("to_date");
                        $to_date = $this->createDate($d1);
                    } else {
                        $to_date = request("to_date");
                    }
                    if (request("from_date")) {
                        $d2 = request("from_date");
                        $from_date = $this->createDate($d2);
                    } else {
                        $from_date = request("from_date");
                    }
                }
                if ($refer_id == 5) {
                    if (strtoupper($refer_expense->name) == 'CASH') {

                        $this->data['expenses'] = DB::SELECT('SELECT * from ' . set_schema_name() . ' bank_transactions WHERE  payment_type_id =1 and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . '');

                        $this->data['current_assets'] = DB::SELECT('SELECT * from ' . set_schema_name() . ' current_asset_transactions WHERE refer_expense_id=' . $id . ' and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . ' ');
                    } else if (strtoupper($refer_expense->name) == 'ACCOUNT RECEIVABLE') {

                        $this->data['expenses'] = array();
                        $this->data['current_assets'] = DB::SELECT('SELECT * from ' . set_schema_name() . ' current_asset_transactions WHERE refer_expense_id=' . $id . ' and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . ' ');

                        $this->data['fees'] = DB::select('select sum(a.balance + coalesce((c.amount-c.due_paid_amount),0)) as total_amount,b.name from ' . set_schema_name() . ' invoice_balances a join ' . set_schema_name() . ' student b on b.student_id=a.student_id LEFT JOIN ' . set_schema_name() . ' dues_balance c on c.student_id=b.student_id WHERE  a.balance <> 0.00 AND a."created_at" >= \'' . $from_date . '\' AND a."created_at" <= \'' . $to_date . '\' group by b.name');

                        $this->data['bank_opening_balance'] = \collect(DB::select('select sum(coalesce(opening_balance,0)) as opening_balance from ' . set_schema_name() . ' bank_accounts'))->first();
                    } else if ((int) $bank_id) {
                        $this->data['expenses'] = DB::SELECT('SELECT transaction_id,date,amount,' . "'Bank'" . ' as payment_method , payment_type_id,note from ' . set_schema_name() . ' bank_transactions WHERE bank_account_id=' . $bank_id . ' and payment_type_id <> 1 and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . 'order by date desc');

                        $this->data['current_assets'] = DB::SELECT('SELECT * from ' . set_schema_name() . ' current_asset_transactions WHERE refer_expense_id=' . $id . ' and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . 'order by date desc');
                        $this->data['bank_id'] = $bank_id;
                    } else {
                        $this->data['expenses'] = array();
                        $this->data['current_assets'] = DB::SELECT('SELECT * from ' . set_schema_name() . ' current_asset_transactions WHERE refer_expense_id=' . $id . ' and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . ' ');
                    }
                } else if (in_array(strtolower($refer_expense->name), array('inventory', 'dispensary')) && (int) $refer_id == 4) {
                    
                    $this->data['expenses'] = \App\Model\Expense::where('refer_expense_id', $id)->where('date', '>=', $from_date)->where('date', '<=', $to_date)->get();
                
                }  else if ((int) $refer_id == 4) {

                    if (preg_match('/EC-1001/', $refer_expense->code) && (int) $refer_expense->predefined > 0) {
                        $sql = 'select sum(b.employer_amount) as amount ,payment_date as date,\'' . $refer_expense->name . '\' as note,\' ' . $refer_expense->name . '\' as name, \'Payroll\' as payment_method,null as "expenseID",extract(month from payment_date)||\'\'||extract(year from payment_date) as ref_no, 1 AS predefined, null as id  from ' . set_schema_name() . 'salaries a join ' . set_schema_name() . 'salary_pensions b on a.id=b.salary_id where b.pension_id=' . $refer_expense->predefined . '  group by a.payment_date UNION ALL (SELECT a.amount, a.date, a.note, b.name, a.payment_method, a."expenseID", a.ref_no, null as predefined, b.id FROM ' . set_schema_name() . 'expense a JOIN ' . set_schema_name() . 'refer_expense b ON a.refer_expense_id=b.id WHERE b.id=' . $refer_expense->id . ' ORDER BY a.date DESC)';
                        $this->data['expenses'] = DB::SELECT($sql);
                    } else {
                        $this->data['expenses'] = \App\Model\ReferExpense::where('refer_expense.id', $id)->LeftJoin('expense', 'expense.refer_expense_id', 'refer_expense.id')->where('expense.date', '>=', $from_date)->where('expense.date', '<=', $to_date)->get();
                    }
                } else if (strtoupper($refer_expense->name) == 'DEPRECIATION') {

                    $this->data['expenses'] = DB::select('select coalesce(sum(b.open_balance::numeric * b.depreciation*(\'' . $to_date . '\'::date-a.date::date)/365),0) as open_balance,sum(amount-amount* a.depreciation *(\'' . $to_date . '\'::date-a.date::date)/365) as total,sum(amount* a.depreciation*(\'' . $to_date . '\'::date-a.date::date)/365) as amount, refer_expense_id,a.date,a.note,a.recipient,b.name,a."expenseID",b.predefined from ' . set_schema_name() . 'expense a join ' . set_schema_name() . 'refer_expense b  on b.id=a.refer_expense_id where b.financial_category_id=4 AND  a.date  <= \'' . $to_date . '\' group by a.refer_expense_id,b.open_balance,a.date,a.note,b.name,a."expenseID",b.predefined  ORDER BY a.date desc');
                    $this->data['depreciation'] = 1;
                } else {

                    //$this->data['expenses'] = DB::SELECT('SELECT b.*,a.* FROM ' . set_schema_name() . 'expense a JOIN ' . set_schema_name() . 'refer_expense b ON a.refer_expense_id=b.id WHERE b.id=' . $id . ' and a."date" >= ' . "'$from_date'" . ' AND a."date" <= ' . "'$to_date'" . ' ');

                    $this->data['expenses'] = \App\Model\ReferExpense::where('refer_expense.id', $id)->JOIN('expense', 'expense.refer_expense_id', 'refer_expense.id')->where('expense.date', '>=', $from_date)->where('expense.date', '<=', $to_date)->get();
                }
                //$this->data['refer_id'] = $id;
                $this->data['period'] = 1;
                $this->data['predefined'] = $refer_expense->predefined;
                $this->data['id'] = $refer_id;
                $this->data['refer_id'] = $refer_id;
                $this->data['refer_expense_name'] = $refer_expense->name;
            if (in_array(strtolower($refer_expense->name), array('inventory', 'dispensary')) && (int) $refer_id == 4) {
                $this->data["subview"] = "expense/inventory_category";
                $this->load->view('_layout_main', $this->data);
            }else{
                $this->data["subview"] = "expense/expense_category";
                $this->load->view('_layout_main', $this->data);
            }
            } else {
                redirect()->back()->with('warning', 'You Do not have Permission to View Expenses, Kindly COntact Your Admin..');
            }
        } else {
            redirect()->back()->with('warning', 'Something Went Wrong Please Try Again......!');
        }
    }

    protected function rules() {
        return $this->validate(request(), [
                    'date' => 'required|max:20|date',
                    'expense' => 'required|numeric|min:1',
                    'amount' => 'required|numeric',
                    'payment_type_id' => 'required|min:1',
                    'note' => 'required:max:600',
                    'depreciation' => 'numeric'
                        ], $this->custom_validation_message);
    }

    protected function rules_asset() {
        return $this->validate(request(), [
                    'date' => 'required|max:20|date',
                    'from_expense' => 'required|numeric|min:1',
                    'to_expense' => 'required|numeric|min:1',
                    'amount' => 'required|numeric',
                    'note' => 'required:max:600',
                        ], $this->custom_validation_message);
    }

    public function add() {
        if (can_access('add_expense')) {
            $id = $this->data['check_id'] = clean_htmlentities(($this->uri->segment(3)));
            $this->data['sub_id'] = clean_htmlentities(($this->uri->segment(4)));
            $this->data['banks'] = \App\Model\BankAccount::all();
            $this->data["payment_types"] = \App\Model\PaymentType::where('id', '<>', 7)->get();
            $this->data['transaction_id'] = $transaction_id = time() . rand(10 * 45, 100 * 98);
            $this->data['id'] = $id;
            if ($_POST) {
                if ($id == 5) {

                    $this->rules_asset();
                } else {
                    $this->rules();
                }

                $insert_id = 0;
                $depreciation = (float) request("depreciation") > 0 ? (float) request("depreciation") : (float) request("dep");
                // $type=request("type");
                if ($id == 2) {

                    $amount = request("type") == 1 ? remove_comma(request("amount")) : -remove_comma(request("amount"));
                } else {

                    $amount = remove_comma(request("amount"));
                }

                if ($id == !5) {
                    $refer_expense_id = request("expense");
                    $refer_expense_name = \App\Model\ReferExpense::find($refer_expense_id)->name;
                    if (strtolower($refer_expense_name) == 'depreciation') {

                        $this->session->set_flashdata('error', 'Sorry ! Depreciation is added through fixed assets');
                        return redirect()->back();
                    }
                }

                $array = array(
                    "create_date" => date("Y-m-d"),
                    "date" => date("Y-m-d", strtotime(request('date'))),
                    "note" => request("note"),
                    "ref_no" => request("transaction_id"),
                    "payment_type_id" => request("payment_type_id"),
                    "refer_expense_id" => request("expense"),
                    "bank_account_id" => request("bank_account_id"),
                    "expenseyear" => date("Y"),
                    "expense" => request("note"),
                    "depreciation" => $depreciation,
                    'userID' => session('id'),
                    'uname' => session('username'),
                    'usertype' => session('usertype'),
                    'created_by' => $this->createdBy()
                );

                $payer_name = \collect(DB::select('select * FROM ' . set_schema_name() . session('table') . ' where "' . session('table') . 'ID"=\'' . session('id') . '\' '))->pluck('name')->first();

                $voucher_no = \collect(DB::select('select max(voucher_no)as voucher_no from (select  CASE 
         WHEN EXISTS (SELECT * FROM ' . set_schema_name() . ' expense LIMIT 1) THEN  voucher_no
         ELSE 0  END AS voucher_no
		 from ' . set_schema_name() . ' expense union all 
		 select  CASE 
         WHEN EXISTS (SELECT * FROM ' . set_schema_name() . ' current_assets LIMIT 1) THEN  voucher_no
         ELSE 0  END AS voucher_no
		 from ' . set_schema_name() . ' current_assets ) as t'))->first();


                if ($id == 4 || $id == 1) {

                    //$voucher_no = DB::table('expense')->max('voucher_no');


                    if (request('user_in_shulesoft') == 1) {

                        $user_request = explode(',', request('user_id'));
                        $user = \App\Model\User::where('id', $user_request[0])->where('table', $user_request[1])->first();

                        $obj = array_merge($array, [
                            'recipient' => $user->name,
                            'voucher_no' => $voucher_no->voucher_no + 1,
                            'payer_name' => $payer_name,
                            "amount" => $amount,
                            "transaction_id" => request("transaction_id"),
                            "bank_account_id" => request("bank_account_id"),
                        ]);



                        $insert_id = DB::table('expense')->insertGetId($obj, "expenseID");
                    } else {

                        $obj = array_merge($array, [
                            'recipient' => request('payer_name'),
                            'voucher_no' => $voucher_no->voucher_no + 1,
                            'payer_name' => $payer_name,
                            "amount" => $amount,
                            "transaction_id" => request("transaction_id"),
                            "bank_account_id" => request("bank_account_id"),
                        ]);


                        $insert_id = DB::table('expense')->insertGetId($obj, "expenseID");
                    }
                    if ((int) request('payment_type_id') == 6) {
                        if (request('user_in_shulesoft') == 1) {

                            $user_request = explode(',', request('user_id'));
                            $user = \App\Model\User::where('id', $user_request[0])->where('table', $user_request[1])->first();

                            $predefined = ['name' => $user->name, 'financial_category_id' => 6, 'predefined' => 1];

                            $check = DB::table('account_groups')->where(DB::raw('lower(name)'), $user->name)->first();
                            $account_group_id = !empty($check) ? $check->id : DB::table('account_groups')->insertGetId($predefined);
                            //payment on credit
                            $chart_records = ['name' => $user->name, 'financial_category_id' => 6, 'note' => 'On Credit From ' . $user->name, 'status' => 1, 'account_group_id' => $account_group_id];
                            $record = \App\Model\ReferExpense::where($chart_records)->first();
                            $chart = !empty($record) ? $record : \App\Model\ReferExpense::create(['name' => $user->name, 'create_date' => 'now()', 'financial_category_id' => 6, 'note' => 'On Credit From ' . $user->name, 'status' => 1, 'code' => time(), 'account_group_id' => $account_group_id]);
                        } else {
                            $user = request('payer_name');
                            $predefined = ['name' => $user, 'financial_category_id' => 6, 'predefined' => 1];

                            $check = DB::table('account_groups')->where(DB::raw('lower(name)'), $user)->first();
                            $account_group_id = !empty($check) ? $check->id : DB::table('account_groups')->insertGetId($predefined);
                            //payment on credit
                            $chart_records = ['name' => $user, 'financial_category_id' => 6, 'note' => 'On Credit From ' . $user, 'status' => 1, 'account_group_id' => $account_group_id];
                            $record = \App\Model\ReferExpense::where($chart_records)->first();
                            $chart = !empty($record) ? $record : \App\Model\ReferExpense::create(['name' => $user, 'create_date' => 'now()', 'financial_category_id' => 6, 'note' => 'On Credit From ' . $user, 'status' => 1, 'code' => time(), 'account_group_id' => $account_group_id]);
                        }

                        $array_liability = array_merge($array, [
                            "refer_expense_id" => $chart->id,
                            'recipient' => request('payer_name'),
                            'voucher_no' => $voucher_no->voucher_no + 1,
                            'payer_name' => $payer_name,
                            "amount" => $amount,
                            "bank_account_id" => request("bank_account_id"),
                            "transaction_id" => request("transaction_id"),
                        ]);

                        DB::table('expense')->insert($array_liability, "expenseID");
                    }
                    $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                    return redirect(base_url("expense/voucher/$insert_id/$id"));
                } else if ($id == 5) {

                    //$voucher_no = DB::table('current_assets')->max('voucher_no');
                    $array = array(
                        "date" => request('date'),
                        "note" => request("note"),
                        "from_refer_expense_id" => request("from_expense"),
                        "to_refer_expense_id" => request("to_expense"),
                        'userID' => session('id'),
                        'uname' => session('username'),
                        "amount" => $amount,
                        'voucher_no' => $voucher_no->voucher_no + 1,
                        "transaction_id" => request("transaction_id"),
                        'usertype' => session('usertype'),
                        'created_by' => $this->createdBy()
                    );

                    if (request("from_expense") == request("to_expense")) {
                        $this->session->set_flashdata('error', 'You can not transfer to the same account');
                        return redirect()->back();
                    }
                    $refer_expense = \App\Model\ReferExpense::find(request("from_expense"));
                    $total_amount = 0;
                    if ((int) $refer_expense->predefined && $refer_expense->predefined > 0) {
                        $total_bank = \collect(DB::SELECT('SELECT sum(coalesce(amount,0)) as total_bank from ' . set_schema_name() . ' bank_transactions WHERE bank_account_id=' . $refer_expense->predefined . ' and payment_type_id <> 1 '))->first();

                        $total_current_assets = \collect(DB::SELECT('SELECT sum(coalesce(amount,0)) as total_current from ' . set_schema_name() . ' current_asset_transactions WHERE predefined=' . $refer_expense->predefined . ''))->first();
                        $total_amount = $total_bank->total_bank + $total_current_assets->total_current;
                    } else if (strtoupper($refer_expense->name) == 'CASH') {

                        $total_cash_transaction = \collect(DB::SELECT('SELECT sum(coalesce(amount,0)) as total_cash from ' . set_schema_name() . ' bank_transactions WHERE  payment_type_id =1'))->first();

                        $total_current_assets_cash = \collect(DB::SELECT('select sum(coalesce(amount,0)) as amount from bank_transactions where payment_type_id=1 '))->first();
                        $total_amount = $total_cash_transaction->total_cash + $total_current_assets_cash->amount;
                    }


                    if (-$amount > $total_amount) {
                        $this->session->set_flashdata('warning', 'No enough Credit to transfer');
                        return redirect()->back();
                    }



                    if (request('user_in_shulesoft') == 1) {


                        $user_request = explode(',', request('user_id'));
                        $user = \App\Model\User::where('id', $user_request[0])->where('table', $user_request[1])->first();

                        $obj = array_merge($array, [
                            'recipient' => $user->name,
                            'payer_name' => $payer_name,
                        ]);

                        $insert_id = DB::table('current_assets')->insertGetId($obj, "id");
                    } else {

                        $obj = array_merge($array, [
                            'recipient' => request('payer_name'),
                            'payer_name' => $payer_name,
                        ]);
                        $insert_id = DB::table('current_assets')->insertGetId($obj, "id");
                    }
                    $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                    return redirect(base_url("expense/voucher/$insert_id/$id"));
                } else {
                    $obj = array_merge($array, [
                        'amount' => $amount,
                    ]);

                    $insert_id = DB::table('expense')->insertGetId($obj, "expenseID");


                    if ($insert_id > 0) {
                        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                    } else {
                        $this->session->set_flashdata('error', 'There Is error in adding new expense');
                    }
                    return redirect(base_url("expense/index/$id"));
                }
            } else {

                if ($id == 5) {
                    $this->data["subview"] = "expense/add_current_asset";
                } else {

                    $this->data["subview"] = "expense/add";
                }
                $this->data["category"] = $this->getCategories($id);
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            redirect()->back()->with('warning', 'You Do not have Permission to Add Expenses, Kindly COntact Your Admin..');
        }
    }

    public function voucher() {
            $id = request()->segment(3);
          //  $cat_id = clean_htmlentities(($this->uri->segment(4)));
            $cat_id = request()->segment(4);
            if ($cat_id == 5) {
                $this->data['voucher'] = \collect(DB::SELECT('SELECT * from  current_assets WHERE id=' . $id . ''))->first();
            } else {
                $this->data['voucher'] = \App\Models\Expense::find($id);
                $this->data['productexpenses'] = \App\Models\ProductPurchase::where('expense_id', $id)->get();
            }
            return view('account.transaction.voucher', $this->data);
    }


    public function  distribution(){
        if ($_POST) { 
             dd(request('year'));
             $this->data['payments'] = \App\Models\Payment::all();
             $this->data['months'] = \App\Models\Month::all();
          }
        $this->data['payments'] = \App\Models\Payment::all();
        $this->data['months'] = \App\Models\Month::all();
        return view('account.report.distribution', $this->data);
    }

    protected function category_rules($id) {
        $this->validate(request(), [
            "subcategory" => "required|regex:/(^([a-zA-Z ]+)(\d+)?$)/u",
            "code" => "regex:/(^[ A-Za-z0-9_@.#&+-]*$)/u|required|iunique:refer_expense,code," . $id
                ], $this->custom_validation_message);
    }

    public function createCode($last_code = 12345) {
        $number_part = substr($last_code, -3);
        return strtoupper(substr(set_schema_name(), 0, 2)) . '-' . ((int) $number_part + 1);
    }

    public function financial_category() {
        $id = request()->segment(3);
            //  if((int)$id){
            $this->data['set'] = $id;
            $this->data['id'] = $id;
            $this->data["category"] = \App\Models\FinancialCategory::all();
            $this->data['groups'] = \App\Models\AccountGroup::all();
            $this->data['expenses'] = \App\Models\ReferExpense::all();
            $this->data["subview"] = "expense/charts_of_accounts";
           // $this->load->view('_layout_main', $this->data);
            return view('expense.charts_of_accounts', $this->data);
            //  } else {
            //       redirect()->back()->with('warning', 'Something Went Wrong Please Try Again......!');
            //    }
      
    }

    public function add_chart() {
        $id = request()->segment(3);
        if ((int) $id) {
            $this->data['set'] = $id;
            $this->data['id'] = $id;
            $this->data["category"] = \App\Model\FinancialCategory::all();
            $this->data['groups'] = \App\Model\AccountGroup::all();
            $this->data['expenses'] = ReferExpense::all();
            if ($_POST) {

                $obj = [
                    'name' => request('subcategory'),
                    "financial_category_id" => request('financial_category_id'),
                ];
                $chart_no = \collect(DB::select('select max(chart_no) as chart_no from ' . set_schema_name() . 'refer_expense WHERE financial_category_id=' . request('financial_category_id')))->first();

                $this->validate(request(), [
                    "subcategory" => "required|regex:/(^([a-zA-Z0-9,. ]+)(\d+)?$)/u",
                    'financial_category_id' => 'numeric|min:1'
                        ], $this->custom_validation_message);
                $obj = [
                    'name' => request('subcategory'),
                    "financial_category_id" => request('financial_category_id'),
                ];

                if ((int) request("account_group_id") > 0) {
                    $account_group_id = request("account_group_id");
                    // $account_group_id = request("group") > 0 ? request("group") : DB::table('account_groups')->insertGetId($obj);
                } else {
                    $check = DB::table('account_groups')->where($obj)->first();
                    $account_group_id = !empty($check) ? $check->id : DB::table('account_groups')->insertGetId($obj);
                }
                $array = array(
                    "name" => trim(request("subcategory")),
                    "financial_category_id" => request('financial_category_id'),
                    "note" => request("note"),
                    "account_group_id" => $account_group_id,
                    'code' => request('code') == '' ? $this->createCode() : request('code'),
                    'open_balance' => (float) request('open_balance') > 0 ? (float) request('open_balance') : 0,
                    "status" => "$id",
                    "chart_no" => $chart_no->chart_no + 1
                );

                ReferExpense::create($array);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                return redirect(base_url("expense/financial_category/$id"));
            } else {
                $this->data["subview"] = "expense/add_category";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            redirect()->back()->with('warning', 'Something Went Wrong Please Try Again......!');
        }
    }

    public function financial_index(Request $request) {
        $id = request()->segment(3);
        if ((int) $id) {
            $this->data["type"] = $id;
            if ($_POST) {
                $this->data['expense_info'] = \App\Models\FinancialCategory::find($id);
                if ($id == 1) {
                      $validated = $request->validate([
                        'to_date' => 'required|date|min:to_date',
                        'from_date' => 'required|date'
                    ]);
                   
                    $this->data['from_date'] = date('Y-m-d', strtotime(request("from_date")));
                    $this->data['to_date'] = date('Y-m-d', strtotime(request("to_date")));
                    $this->data['unique_opex'] = $this->getUniqueOpexp(request("from_date"), request("to_date"));
                    $this->data['unique_opex_grouped'] = $this->getUniqueOpexp_grouped(request("from_date"), request("to_date"));
                 //   $this->data['fees'] = DB::select('select sum(a.total_amount) as total,sum(a.discount_amount) as total_discount,a.fee_id as id,b.name from ' . set_schema_name() . ' invoice_balances a join ' . set_schema_name() . ' fees b on b.id=a.fee_id WHERE  a."created_at" >= \'' . $this->data['from_date'] . '\' AND a."created_at"<= \'' . $this->data['to_date'] . '\' group by a.fee_id,b.name');
                 //   $this->data['depreciation'] = $this->getDepresiation($this->data['from_date'], $this->data['to_date']);
                  //  $this->data['depreciation_grouped'] = $this->getDepresiation_grouped($this->data['from_date'], $this->data['to_date']);
                 //   $this->createProfitAndLossStatement($this->data['from_date'], $this->data['to_date']);
                } else if ($id == 2 || $id == 4) {
                    $this->data['to_date'] = date('Y-m-d', strtotime(request("to_date")));
                    $this->data['unique_opex'] = $this->getUniqueOpexb($this->data['to_date']);
                    $this->data['unique_opex_grouped'] = $this->getUniqueOpexb_grouped($this->data['to_date']);
                    $sql = 'select sum(a.total_amount) as total,SUM(d.SumPaid) as sum_paid_to_date,b."id" from ' . set_schema_name() . 'invoice_balances a JOIN ' . set_schema_name() . 'fees b ON a."fee_id"=b."id"  LEFT JOIN (select e.invoices_fees_installment_id, SUM(e.amount+f.amount) as SumPaid from ' . set_schema_name() . 'payments_invoices_fees_installments e full outer join ' . set_schema_name() . 'advance_payments_invoices_fees_installments f on e.invoices_fees_installment_id=f.invoices_fees_installments_id where e."created_at" <= \'' . $this->data['to_date'] . '\' Group by e.invoices_fees_installment_id)d on a.id=d.invoices_fees_installment_id  where a."created_at" <= \'' . $this->data['to_date'] . '\' group by b.id';
                    $this->data['fees'] = DB::select($sql);
                    $this->data['depreciation'] = $this->getNetDepreciation($this->data['to_date']);
                    $this->data['depreciation_grouped'] = $this->getNetDepreciation_grouped($this->data['to_date']);
                    $this->createBalanceSheet($this->data['to_date']);
                    if ($id == 4) {
                        $this->data['fees'] = DB::select('select sum(a.total_amount) as total,sum(a.discount_amount) as total_discount,a.fee_id as id,b.name from ' . set_schema_name() . ' invoice_balances a join ' . set_schema_name() . ' fee b on b.id=a.fee_id WHERE  a."created_at"<= \'' . $this->data['to_date'] . '\' group by a.fee_id,b.name');
                        $this->data['total_opex'] = $this->getGeneralOperationalExpense_grouped($this->data['to_date']);
                        $this->data['fee_total'] = $this->getFeeTotal($this->data['to_date']);
                        $this->data['express_revenues_grouped'] = $this->GetexpressRevenues_grouped($this->data['to_date']);
                        $this->data['total_general_admin'] = $this->getGeneralExpenseGeneral($this->data['to_date']);
                        $this->data["subview"] = "expense/accounting_report/trial_balance";
                    } else {
                        $this->data["subview"] = "expense/accounting_report/balance_sheet";
                    }
                    $this->load->view('_layout_main', $this->data);
                } else {

                    $this->validate(request(), [
                        'to_date' => 'required|date|min:to_date',
                        'from_date' => 'required|date'
                            ], $this->custom_validation_message);

                    $this->data['from_date'] = date('Y-m-d', strtotime(request("from_date")));
                    $this->data['to_date'] =date('Y-m-d', strtotime(request("to_date")));
                    $this->data['net_depreciation'] = $this->getNoDepreciation($this->data['from_date'], $this->data['to_date']);
                    $this->data['unique_opex'] = $this->getUniqueOpexp($this->data['from_date'], $this->data['to_date']);
                    $this->data['unique_opex_grouped'] = $this->getUniqueOpexp_grouped($this->data['from_date'],$this->data['to_date']);
                  //  $this->data['fees'] = DB::select('select sum(a.total_amount) as total,sum(a.discount_amount) as total_discount,a.fee_id as id,b.name from ' . set_schema_name() . ' invoice_balances a join ' . set_schema_name() . ' fee b on b.id=a.fee_id WHERE  a."created_at" >= \'' . $this->data['from_date'] . '\' AND  a."created_at" <= \'' . $this->data['to_date'] . '\' group by a.fee_id,b.name');
                    $this->data['balance_at'] = $this->BalanceAt($this->data['from_date']);
                    $this->createCashflowStatement($this->data['from_date'], $this->data['to_date']);
                }
            } else {
                return view('account.report.accounting_report.financial_index', $this->data);
            }
        }
    }
    
    public function discount_due_report(){
        if ($_POST) {
            $this->data['from_date'] = $from_date = date('Y-m-d', strtotime(request("from_date")));
            $this->data['to_date'] = $to_date = date('Y-m-d', strtotime(request("to_date")));
           
        }else {
            $this->data['from_date'] = $from_date = date('Y-01-01');
            $this->data['to_date'] = $to_date = date('Y-m-d');
        }
        $this->data['discount_fees'] = $discount_fees = DB::select('select c.id, c.name as fee_name, sum(a.amount) as total_discounts from '. set_schema_name() .' discount_fees_installments a join '.set_schema_name().' fees_installments b on a.fees_installment_id = b.id join '.set_schema_name().' fees c on b.fee_id=c.id WHERE a."created_at" >=\''.$this->data['from_date'].'\' AND a."created_at"<= \''.$this->data['to_date'].'\' group by c.id, c.name ORDER BY c.id' );
            
        $this->data['due_fees'] = $this->getTotalDueAmount($this->data['from_date'], $this->data['to_date']);
        $this->data["subview"] = "expense/accounting_report/discount_due_reports";
        $this->load->view('_layout_main', $this->data);
        
    }
    public function getTotalDueAmount($from_date, $to_date){
        
        $sql = 'WITH feesAmountCTE AS( SELECT f.id fee_id,f.name fee_name, SUM(fic.amount) fee_payments, sum(pifi.amount) paid_fees, (SUM(fic.amount)-SUM(pifi.amount)) due_amount
                     FROM '. set_schema_name() .' fees_installments fi 
					 JOIN '. set_schema_name() .' fees_installments_classes fic ON fic.fees_installment_id=fi.id
					 JOIN '. set_schema_name() .' fees f ON fi.fee_id=f.id 
					 JOIN '. set_schema_name() .' invoices_fees_installments ifi ON ifi.fees_installment_id=fi.id 
					 JOIN '. set_schema_name() .' installments i ON i.id=fi.installment_id 
					 JOIN '. set_schema_name() .' payments_invoices_fees_installments pifi ON pifi.invoices_fees_installment_id=ifi.id
                     WHERE i.start_date >=\''.$from_date.'\' AND i.end_date<= \''.$to_date.'\' GROUP BY f.id, fee_name)
                  SELECT fee_id,fee_name, fee_payments, paid_fees, due_amount 
                 FROM feesAmountCTE ORDER BY fee_id';

                 $fee_records = DB::select($sql);
            return $fee_records;
    }

    public function fee_collection() {
            if ($_POST) {
                $this->data['from_date'] = $from_date = date('Y-m-d', strtotime(request("from_date")));
                $this->data['to_date'] = $to_date = date('Y-m-d', strtotime(request("to_date")));
               
            }else {
                $this->data['from_date'] = $from_date = date('Y-01-01');
                $this->data['to_date'] = $to_date = date('Y-m-d');
            }
            $sql = 'select d.fee_id, g.name,  SUM(e.amount) as total from ' . set_schema_name() . 'payments_invoices_fees_installments e 
            JOIN ' . set_schema_name() . 'invoices_fees_installments c on e.invoices_fees_installment_id=c.id
            JOIN  ' . set_schema_name() . 'fees_installments d on d.id=c.fees_installment_id JOIN  ' . set_schema_name() . 'fees g on g.id=d.fee_id JOIN ' . set_schema_name() . 'payments b ON b.id = e.payment_id where b.created_at::date BETWEEN  \'' . $from_date . '\' AND  \'' . $to_date . '\' GROUP BY d.fee_id, g.name';
            $this->data['fees'] =  DB::select($sql);

            $condition = $to_date == null ? 'b.date <= \'' . date('Y-m-d', strtotime($from_date)) . '\'' : 'b.date between \'' . date('Y-m-d', strtotime($from_date)) . '\' AND \'' . date('Y-m-d', strtotime($to_date)) . '\'';
            $this->data['expenses']  = DB::SELECT('select sum(b.amount), a.name from ' . set_schema_name() . 'expense b  JOIN ' . set_schema_name() . 'refer_expense c on c.id = b.refer_expense_id  JOIN ' . set_schema_name() . 'account_groups a  on a.id=c.account_group_id where '.$condition.' group by a.name');
            $this->data['revenues']  = DB::SELECT('select sum(b.amount), a.name from ' . set_schema_name() . 'revenues b  JOIN ' . set_schema_name() . 'refer_expense c on c.id = b.refer_expense_id  JOIN ' . set_schema_name() . 'account_groups a  on a.id=c.account_group_id where '.$condition.' group by a.name');

            $this->data["subview"] = "expense/accounting_report/fee_collection";
            $this->load->view('_layout_main', $this->data);
        
        }

    public function createBalanceSheet($to_date) {
        $this->data['expense_fixedasset'] = $this->getExpenseFixedAssetsToDate($to_date);
        $this->data['expense_fixedasset_grouped'] = $this->getExpenseFixedAssetsToDate_grouped($to_date);

        $this->data['g_expenses'] = $this->db->query('select SUM(c.amount) as total from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" WHERE c."date" <=\'' . $to_date . '\' and a."financial_category_id" IN (2,3)')->row();

        $this->data['expense_liabilities'] = DB::select('select  c.refer_expense_id,a.name,a.open_balance::numeric from ' . set_schema_name() . 'refer_expense a LEFT JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" WHERE c."date" <= \'' . $to_date . '\' and a."financial_category_id"=6 group by c.refer_expense_id,a.name,a.open_balance');

        $this->data['expense_liabilities_grouped'] = DB::select('select  a.account_group_id,d.name,a.open_balance::numeric as open_balance from ' . set_schema_name() . 'refer_expense a LEFT JOIN constant.financial_category b ON a."financial_category_id"=b."id" LEFT JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" JOIN ' . set_schema_name() . ' account_groups d on d.id=a.account_group_id WHERE (c."date" <= \'' . $to_date . '\' OR a."create_date" <= \'' . $to_date . '\')  and a."financial_category_id"=6 group by a.account_group_id,d.name,a.open_balance');

        $sql = 'select  c.refer_expense_id,a.name,a.open_balance::numeric from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" WHERE c."date" <= \'' . $to_date . '\' and a."financial_category_id"=7 group by c.refer_expense_id,a.name,a.open_balance';

        $sql_grouped = 'select  a.account_group_id,d.name,SUM(a.open_balance::numeric) AS open_balance from ' . set_schema_name() . 'refer_expense a LEFT JOIN constant.financial_category b ON a."financial_category_id"=b."id" LEFT JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" LEFT JOIN ' . set_schema_name() . ' account_groups d ON d.id=a.account_group_id WHERE (c."date" <= \'' . $to_date . '\' or a.create_date <= \'' . $to_date . '\') and a."financial_category_id"=7 group by a.account_group_id,d.name';


        $sql_current_assets_grouped = 'select  a.account_group_id,d.name,SUM(a.open_balance::numeric) AS open_balance from ' . set_schema_name() . 'refer_expense a LEFT JOIN ' . set_schema_name() . ' current_asset_transactions b ON a."id"=b."refer_expense_id" JOIN  ' . set_schema_name() . ' account_groups d ON d.id=a.account_group_id  where a."financial_category_id"=5 group by a.account_group_id,d.name';

        // $capital_grouped = 'select  a.account_group_id,d.name,SUM(a.open_balance::numeric) AS open_balance from ' . set_schema_name() . 'refer_expense a LEFT JOIN '.set_schema_name().' current_asset_transactions b ON a."id"=b."refer_expense_id" JOIN  ' . set_schema_name() . ' account_groups d ON d.id=a.account_group_id  where a."financial_category_id"=3 group by a.account_group_id,d.name';


        $this->data['receivable_from_invoice'] = collect(\DB::select('select sum(a.balance + coalesce((c.amount-c.due_paid_amount),0)) as total_amount,b.name from ' . set_schema_name() . ' invoice_balances a join ' . set_schema_name() . ' student b on b.student_id=a.student_id LEFT JOIN ' . set_schema_name() . ' dues_balance c on c.student_id=b.student_id WHERE  a.balance <> 0.00 AND a."created_at" <= \'' . $to_date . '\' group by b.name'))->first();

        $total_bank = \collect(DB::SELECT('SELECT coalesce(sum(coalesce(amount,0)),0) as total_bank from ' . set_schema_name() . ' bank_transactions where payment_type_id <> 1 and "date" <= ' . "'$to_date'" . ''))->first();

        $due_amount = \App\Model\DueAmount::all()->where('created_at', '<=', $to_date)->sum('amount');
        $this->data['current_asset'] = DB::select($sql_current_assets_grouped);

        $this->data['expense_equity'] = DB::select($sql);
        $this->data['expense_equity_grouped'] = DB::select($sql_grouped);

        //$this->data['capital_retained_grouped'] = DB::select($capital_grouped);       
        $this->data['net_depreciation'] = $this->getNetDepreciation($to_date);
        $this->data['unearned'] = \App\Model\AdvancePayment::where('created_at', '<=', $to_date)->sum('amount') - \App\Model\AdvancePaymentsInvoicesFeesInstallment::sum('amount');


        $this->data['net_depreciation_grouped'] = $this->getNetDepreciation_grouped($to_date);

        $this->data['bank'] = $total_bank->total_bank + \App\Model\BankAccount::sum('opening_balance');


        $this->data['cash'] = $this->cashCollection($to_date);


        $this->data['fee_total'] = $this->getFeePaidTotal($to_date);
        $this->data['express_revenue_total'] = $this->GetexpressRevenue_total($to_date);
        $this->data['feereceivable_total'] = $this->getFeeReceivable($to_date);
        $this->data['bank_opening_balance'] = \collect(DB::select('select sum(coalesce(opening_balance,0)) as opening_balance from ' . set_schema_name() . ' bank_accounts'))->first();
        $this->data['total_receivable'] = $due_amount + $this->getgeneralFeeTotal($to_date) - $this->getTotalFeePaidTotal($to_date);
    }

    public function createProfitAndLossStatement($from_date, $to_date) {
        $this->data['fee_total'] = $this->getFeeTotal($from_date, $to_date);
        $this->data['express_revenues'] = $this->GetexpressRevenues($from_date, $to_date);
        $this->data['express_revenues_grouped'] = $this->GetexpressRevenues_grouped($from_date, $to_date);

        $this->data['expense_operational'] = $this->getOperationalExpense($from_date, $to_date);
        $this->data['expense_operational_grouped'] = $this->getOperationalExpense_grouped($from_date, $to_date);

        $this->data['expense_general'] = $this->getExpenseGeneral($from_date, $to_date);
        $this->data['expense_general_grouped'] = $this->getExpenseGeneral_grouped($from_date, $to_date);
        $this->data['expense_fixedasset'] = $this->getExpenseFixedAssets($from_date, $to_date);

        $this->data['expense_fixedasset_grouped'] = $this->getExpenseFixedAssets_grouped($from_date, $to_date);

        $this->data["subview"] = "expense/accounting_report/profit_loss_statement";
        $this->load->view('_layout_main', $this->data);
    }

    public function createCashflowStatement($from_date, $to_date) {
        $this->data['fee_total'] = $this->getgeneralFeeTotal($from_date, $to_date);
        $this->data['paid_fee_total'] = $this->getTotalFeePaidTotal($from_date, $to_date);
        $this->data['total_express_revenues'] = $this->GetGeneralexpressRevenues($from_date, $to_date);
        $this->data['total_expense_operational'] = $this->getGeneralOperationalExpense($from_date, $to_date);
        $this->data['total_expense_general'] = $this->getGeneralExpenseGeneral($from_date, $to_date);
        $this->data['total_expense_fixedasset'] = $this->getGeneralExpenseFixedAssets($from_date, $to_date);
        $this->data['expense_equity'] = $this->getTotalExpenseEquity($from_date, $to_date);
        $this->data['expense_equity_grouped'] = $this->getTotalExpenseEquity_grouped($from_date, $to_date);
        $this->data['expense_liabilities'] = $this->getExpenseLiabilityFromTo($from_date, $to_date);
        $this->data['expense_liabilities_grouped'] = $this->getExpenseLiabilityFromTo_grouped($from_date, $to_date);

        $this->data['feereceivable_total'] = $this->getFeeReceivable($to_date);

        $this->data['depreciation_grouped'] = $this->getNoDepreciation_grouped($this->data['from_date'], $this->data['to_date']);

        //$this->data['net_depreciation_grouped'] = $this->getNetDepreciation_grouped($to_date);

        $this->data['liability_total'] = $this->getTotalExpenseLiability($from_date, $to_date);
        $this->data['expense_fixedasset'] = $this->getExpenseFixedAssetsFromToDate($from_date, $to_date);
        $this->data['expense_fixedasset_grouped'] = $this->getExpenseFixedAssetsFromToDate_grouped($from_date, $to_date);
        //$this->data['total_general_exp'] = $this->getTotalGeneralExpense($from_date,$to_date);
        $this->data["subview"] = "expense/accounting_report/cash_flow_statement";
        $this->load->view('_layout_main', $this->data);
    }

    function getExpenseLiabilityFromTo($from_date, $to_date = null) {
        $condition = $to_date == null ? 'c."date" <= \'' . $from_date . '\'' : 'c."date" between \'' . $from_date . '\' AND \'' . $to_date . '\'';
        return DB::select('select  c.refer_expense_id,a.name from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" WHERE  ' . $condition . ' and a."financial_category_id"=6 group by c.refer_expense_id,a.name');
    }

    function getExpenseLiabilityFromTo_grouped($from_date, $to_date = null) {
        $condition = $to_date == null ? 'c."date" <= \'' . $from_date . '\'' : 'c."date" between \'' . $from_date . '\' AND \'' . $to_date . '\'';
        return DB::select('select  d.id as account_group_id,d.name from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" JOIN ' . set_schema_name() . ' account_groups d on d.id=a.account_group_id WHERE  ' . $condition . ' and a."financial_category_id"=6 group by d.id,d.name');
    }

    function getTotalExpenseLiability($from_date, $to_date = null) {
        $condition = $to_date == null ? 'c."date" <= \'' . $from_date . '\'' : 'c."date" between \'' . $from_date . '\' AND \'' . $to_date . '\'';
        $expense_liabilities = DB::select('select  c.refer_expense_id,a.name from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" WHERE  ' . $condition . ' and a."financial_category_id"=6 group by c.refer_expense_id,a.name');

        $unique_opex = $this->getUniqueOpexp($from_date, $to_date);

        $li_total = 0;
        if (!empty($expense_liabilities)) {
            foreach ($expense_liabilities as $liability) {
                $li_total = isset($unique_opex[$liability->refer_expense_id][0]['total']) ? $unique_opex[$liability->refer_expense_id][0]['total'] : null;
            }
        }
        return $li_total;
    }

    function getTotalExpenseLiability_grouped($from_date, $to_date = null) {
        $condition = $to_date == null ? 'c."date" <= \'' . $from_date . '\'' : 'c."date" between \'' . $from_date . '\' AND \'' . $to_date . '\'';
        $expense_liabilities = DB::select('select  d.id as account_group_id,d.name from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" JOIN ' . set_schema_name() . ' account_groups d ON d.id=a.account_group_id WHERE  ' . $condition . ' and a."financial_category_id"=6 group by d.id,d.name');

        $unique_opex = $this->getUniqueOpexp_grouped($from_date, $to_date);

        $li_total = 0;
        if (!empty($expense_liabilities)) {
            foreach ($expense_liabilities as $liability) {
                $li_total = isset($unique_opex[$liability->account_group_id][0]['total']) ? $unique_opex[$liability->account_group_id][0]['total'] : null;
            }
        }
        return $li_total;
    }

    function getTotalExpenseEquity($from_date, $to_date = null) {
        $condition = $to_date == null ? 'c."date" <= \'' . $from_date . '\'' : 'c."date" between \'' . $from_date . '\' AND \'' . $to_date . '\'';

        $sql = 'select  c.refer_expense_id,a.name from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" WHERE  ' . $condition . ' and a."financial_category_id"=7 GROUP BY c.refer_expense_id,a.name';
        return DB::select($sql);
        /* $unique_opex=$this->getUniqueOpexp($from_date,$to_date);

          $sum_equity=0;
          if(!empty($expense_equity)>0) {
          foreach ($expense_equity as $value1) {
          $capital_total = isset($unique_opex[$value1->refer_expense_id][0]['total']) ? $unique_opex[$value1->refer_expense_id][0]['total'] : 0;
          $sum_equity = $sum_equity + $capital_total;
          }
          }
          return $sum_equity; */
    }

    function getTotalExpenseEquity_grouped($from_date, $to_date = null) {


        $condition = $to_date == null ? '(c."date" <= \'' . $from_date . '\' OR a."create_date" <= \'' . $from_date . '\')' : 'c."date" >= \'' . $from_date . '\' AND  c.date <= \'' . $to_date . '\'';

        $sql_grouped = 'select  a.account_group_id,d.name,SUM(a.open_balance::numeric) AS open_balance from ' . set_schema_name() . 'refer_expense a LEFT JOIN constant.financial_category b ON a."financial_category_id"=b."id" LEFT JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" LEFT JOIN ' . set_schema_name() . ' account_groups d ON d.id=a.account_group_id WHERE  ' . $condition . ' and a."financial_category_id"=7 group by a.account_group_id,d.name';
        return DB::select($sql_grouped);
    }

    function getFeeReceivable($to_date) {

        $general_expense = DB::select('select sum(a.total_amount) as total,SUM(coalesce(d.SumPaid,0)) as sum_paid_to_date,b."id" from ' . set_schema_name() . 'invoice_balances a JOIN ' . set_schema_name() . 'fees b ON a."fee_id"=b."id"  LEFT JOIN (select e.invoices_fees_installment_id, SUM(coalesce(e.amount,0)+coalesce(f.amount,0)) as SumPaid from ' . set_schema_name() . 'payments_invoices_fees_installments e full outer join ' . set_schema_name() . 'advance_payments_invoices_fees_installments f on e.invoices_fees_installment_id=f.invoices_fees_installments_id where e."created_at" <= \'' . $to_date . '\' Group by e.invoices_fees_installment_id)d on a.id=d.invoices_fees_installment_id  where a."created_at" <= \'' . $to_date . '\' group by b.id');


        $fees = array();
        foreach ($general_expense as $key => $value) {
            $fees[$value->id] = array();
        }

        foreach ($general_expense as $key => $value) {

            array_push($fees[$value->id], (array) $value);
        }

        return $fees;
    }

    function getFeeReceivableBefore($from_date) {
        $general_expense = DB::select('select sum(a.total_amount) as total,SUM(d.SumPaid) as sum_paid_to_date,b."id" from ' . set_schema_name() . 'invoice_balances a JOIN ' . set_schema_name() . 'fees b ON a."fee_id"=b."id"  LEFT JOIN (select e.invoices_fees_installment_id, SUM(e.amount+f.amount) as SumPaid from ' . set_schema_name() . 'payments_invoices_fees_installments e full outer join ' . set_schema_name() . 'advance_payments_invoices_fees_installments f on e.invoices_fees_installment_id=f.invoices_fees_installments_id where e."created_at" < \'' . $from_date . '\' Group by e.invoices_fees_installment_id)d on a.id=d.invoices_fees_installment_id  where a."created_at" < \'' . $from_date . '\' group by b.id');

        $fees = array();
        foreach ($general_expense as $key => $value) {
            $fees[$value->id] = array();
        }

        foreach ($general_expense as $key => $value) {

            array_push($fees[$value->id], (array) $value);
        }

        return $fees;
    }

    public function chartof_account_bank($to_date) {


        $sql = collect(\DB::SELECT('SELECT sum(coalesce(amount,0)) as total_amount,sum(COALESCE(open_balance,0)) as total_open_balance FROM ' . set_schema_name() . 'expense a JOIN ' . set_schema_name() . 'refer_expense b ON a.refer_expense_id=b.id WHERE a.payment_type_id!=1 and a."date" <= \'' . $to_date . '\''))->first();

        return $sql;
    }

    function getFeePaidTotal($to_date) {

        $general_expense = DB::select('select sum(a.total_amount) as total,SUM(d.SumPaid) as sum_paid_to_date,b."id" from ' . set_schema_name() . 'invoice_balances a JOIN ' . set_schema_name() . 'fees b ON a."fee_id"=b."id"  LEFT JOIN (select e.invoices_fees_installment_id, SUM(e.amount+f.amount) as SumPaid from ' . set_schema_name() . 'payments_invoices_fees_installments e full outer join ' . set_schema_name() . 'advance_payments_invoices_fees_installments f on e.invoices_fees_installment_id=f.invoices_fees_installments_id where e."created_at" <= \'' . $to_date . '\' Group by e.invoices_fees_installment_id)d on a.id=d.invoices_fees_installment_id   group by b.id');


        $fees = array();

        foreach ($general_expense as $key => $value) {
            $fees[$value->id] = array();
        }
        foreach ($general_expense as $key => $value) {

            array_push($fees[$value->id], (array) $value);
        }

        return $fees;
    }

    function getTotalFeePaidTotal($from_, $to_ = null) {
        $from_date = date('Y-m-d', strtotime($from_));
        $to_date = date('Y-m-d', strtotime($to_));
        $condition = $to_date == null ? '"created_at" <= \'' . $from_date . '\'' : '"created_at" between \'' . $from_date . '\' AND \'' . $to_date . '\'';
        $general_expense = collect(\DB::select('select sum(coalesce(amount,0)) as total from ' . set_schema_name() . 'payments  where ' . $condition . ''))->first();

        if (!empty($general_expense)) {
            return $general_expense->total;
        } else {
            return 0;
        }
    }

    public function cashCollection($from_, $to_ = null) {
        $from_date = date('Y-m-d', strtotime($from_));
        $to_date = date('Y-m-d', strtotime($to_));
        $condition = $to_date == null ? '"date" <= \'' . $from_date . '\'' : '"date" between \'' . $from_date . '\' AND \'' . $to_date . '\'';

        $cash1 = collect(\DB::SELECT('SELECT sum(coalesce(amount,0)) as total from ' . set_schema_name() . ' bank_transactions WHERE  payment_type_id =1 and ' . $condition . ''))->first();


        $cash2 = collect(\DB::SELECT('SELECT sum(coalesce(amount,0)) as total from ' . set_schema_name() . ' current_asset_transactions WHERE ' . $condition . ' AND UPPER(name)= \'CASH\''))->first();
        return $cash1->total + $cash2->total;
    }

    function getExpenseFixedAssetsToDate($to_) {
        $to_date = date('Y-m-d', strtotime($to_));
        return DB::select('select c.refer_expense_id,a.name from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" WHERE c."date" <= ' . "'$to_date'" . ' and a."financial_category_id"=4 group by c.refer_expense_id,a.name');
    }

    function getExpenseFixedAssetsToDate_grouped($to_) {
        $to_date = date('Y-m-d', strtotime($to_));
        return DB::select('select b.id as account_group_id,b.name from ' . set_schema_name() . 'refer_expense a LEFT JOIN ' . set_schema_name() . ' account_groups b ON a.account_group_id=b.id LEFT JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" WHERE  a."financial_category_id"=4  and  a.account_group_id is not null group by b.id,b.name');
    }

    public function getExpenseFixedAssets_grouped($from_, $to_) {
        $from_date = date('Y-m-d', strtotime($from_));
        $to_date = date('Y-m-d', strtotime($to_));
        $sql = 'select  d.id as account_group_id,d.name,sum(COALESCE(c.amount, 0 )) as amount from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" JOIN ' . set_schema_name() . ' account_groups d on d.id=a.account_group_id where  a."financial_category_id"=4 GROUP BY d.id,d.name';

        return DB::select($sql);
    }

    function getExpenseFixedAssetsFromToDate($from_, $to_ = null) {
        $from_date = date('Y-m-d', strtotime($from_));
        $to_date = date('Y-m-d', strtotime($to_));
        $condition = $to_date == null ? 'c."date" <= \'' . $from_date . '\'' : 'c."date" >= \'' . $from_date . '\' AND c.date<= \'' . $to_date . '\'';
        return DB::select('select c.refer_expense_id,a.name from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" WHERE ' . $condition . ' and a."financial_category_id"=4 group by c.refer_expense_id,a.name');
    }

    function getExpenseFixedAssetsFromToDate_grouped($from_, $to_ = null) {
        $from_date = date('Y-m-d', strtotime($from_));
        $to_date = date('Y-m-d', strtotime($to_));
        $condition = $to_date == null ? 'c."date" <= \'' . $from_date . '\'' : 'c."date" >= \'' . $from_date . '\' AND  c.date <=\'' . $to_date . '\'';
        return DB::select('select d.id as account_group_id,d.name from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" JOIN ' . set_schema_name() . ' account_groups d ON d.id=a.account_group_id WHERE  ' . $condition . ' and  a."financial_category_id"=4 group by d.id,d.name');
    }

    public function getDepreciation($to_date) {
        $general_expense = DB::select('select sum(amount-amount* depreciation) as total,sum(amount* depreciation) as deprec, refer_expense_id from ' . set_schema_name() . 'expense  where date  <= \'' . $to_date . '\' group by refer_expense_id');
        $fees = array();
        foreach ($general_expense as $key => $value) {
            $fees[$value->refer_expense_id] = array();
        }
        foreach ($general_expense as $key => $value) {

            array_push($fees[$value->refer_expense_id], (array) $value);
        }
        return $fees;
    }

    public function getNoDepreciation($from_, $to_ = null) {
        $from_date = date('Y-m-d', strtotime($from_));
        $to_date = date('Y-m-d', strtotime($to_));
        $condition = $to_date == null ? '"date" <= \'' . $from_date . '\'' : '"date" between \'' . $from_date . '\' AND \'' . $to_date . '\'';

        $general_expense = DB::select('select sum(amount) as total,sum(amount* depreciation*(\'' . $from_date . '\'::date-expense.date::date)/365) as deprec, refer_expense_id from ' . set_schema_name() . 'expense  where ' . $condition . ' group by refer_expense_id');
        $fees = array();
        foreach ($general_expense as $key => $value) {
            $fees[$value->refer_expense_id] = array();
        }
        foreach ($general_expense as $key => $value) {

            array_push($fees[$value->refer_expense_id], (array) $value);
        }
        return $fees;
    }

    public function getNoDepreciation_grouped($from_date, $to_date = null) {
        $condition = $to_date == null ? 'b."date" <= \'' . $from_date . '\'' : 'b."date" between \'' . $from_date . '\' AND \'' . $to_date . '\'';

        $general_expense = DB::select('select sum(b.amount) as total,sum(b.amount* b.depreciation*(\'' . $from_date . '\'::date-b.date::date)/365) as deprec,d.id as account_group_id from ' . set_schema_name() . 'expense b JOIN ' . set_schema_name() . ' refer_expense c ON c.id=b.refer_expense_id  JOIN ' . set_schema_name() . ' account_groups d on d.id=c.account_group_id where ' . $condition . ' group by d.id');

        $fees = array();
        foreach ($general_expense as $key => $value) {
            $fees[$value->account_group_id] = array();
        }
        foreach ($general_expense as $key => $value) {

            array_push($fees[$value->account_group_id], (array) $value);
        }
        return $fees;
    }

    public function getNetDepreciation($to_date) {
       //here you need to get the  depreciated amount as per passed days

        $general_expense = DB::select('select sum(coalesce(b.open_balance::numeric,0)) as open_balance,sum(b.open_balance::numeric * b.depreciation * (\'' . $to_date . '\'::date-b.create_date::date)/365) as depre_open_balance,sum(amount-amount* a.depreciation *(\'' . $to_date . '\'::date-a.date::date)/365) as total,sum(amount* a.depreciation*(\'' . $to_date . '\'::date-a.date::date)/365) as deprec, b.id as refer_expense_id from ' . set_schema_name() . 'expense a RIGHT JOIN  ' . set_schema_name() . 'refer_expense b  on b.id=a.refer_expense_id where a.date  <= \'' . $to_date . '\' group by b.id,b.open_balance');


        $fees = array();
        foreach ($general_expense as $key => $value) {
            $fees[$value->refer_expense_id] = array();
        }
        foreach ($general_expense as $key => $value) {

            array_push($fees[$value->refer_expense_id], (array) $value);
        }
        return $fees;
    }

    public function getNetDepreciation_grouped($to_date) {
             //here you need to get the  depreciated amount as per passed days 
        $sql = 'select SUM(coalesce(b.open_balance::numeric,0)) AS open_balance,sum(coalesce(amount,0)) as total,case when  sum(\'' . $to_date . '\'-b.create_date::date)<=0 then 0 else sum(coalesce(b.open_balance,0)* coalesce(a.depreciation,0) * coalesce(((\'' . $to_date . '\'::date-b.create_date::date)),0)/365) END as deprec_open_balance,case when sum(\'' . $to_date . '\'-a.date)<=0 then 0 else sum(coalesce(amount,0)* coalesce(a.depreciation,0)* coalesce(((\'' . $to_date . '\'::date-a.date::date)),0)/365) END as deprec,b.account_group_id from ' . set_schema_name() . ' expense a RIGHT JOIN ' . set_schema_name() . ' refer_expense b  on b.id=a.refer_expense_id  where  b.account_group_id is not null group by b.account_group_id';
        $general_expense = DB::select($sql);
        $fees = array();
        foreach ($general_expense as $key => $value) {
            $fees[$value->account_group_id] = array();
        }
        foreach ($general_expense as $key => $value) {

            array_push($fees[$value->account_group_id], (array) $value);
        }
        return $fees;
    }

    public function getNetDepreciationFromTo($from_date, $to_date = null) {

        $condition = $to_date == null ? '"date" <= \'' . $from_date . '\'' : '"date" between \'' . $from_date . '\' AND \'' . $to_date . '\'';

        $general_expense = DB::select('select sum(amount-amount* depreciation *(\'' . $to_date . '\'::date-expense.date::date)/365) as total,sum(amount* expense.depreciation *(\'' . $to_date . '\'::date-expense.date::date)/365) as deprec, refer_expense_id from ' . set_schema_name() . 'expense  where ' . $condition . ' group by refer_expense_id');

        $fees = array();
        foreach ($general_expense as $key => $value) {
            $fees[$value->refer_expense_id] = array();
        }
        foreach ($general_expense as $key => $value) {

            array_push($fees[$value->refer_expense_id], (array) $value);
        }
        return $fees;
    }

    public function getTotalGeneralExpense($from_date, $to_date) {
        $sql = 'select sum(amount) as total from ' . set_schema_name() . 'expense WHERE date between \'' . $from_date . '\' AND \'' . $to_date . '\' ';

        $total_general = collect(\DB::select('select sum(amount) as total from ' . set_schema_name() . 'expense WHERE date between \'' . $from_date . '\' AND \'' . $to_date . '\' '))->first();

        if (!empty($total_general)) {
            return $total_general->total;
        } else {
            return 0;
        }
    }

    public function getGeneralExpense($from_date, $to_date) {
        $general_expense = DB::select('select sum(amount) as total,refer_expense_id from ' . set_schema_name() . 'expense WHERE date between \'' . $from_date . '\' AND \'' . $to_date . '\' group by refer_expense_id');
        $fees = array();

        foreach ($general_expense as $key => $value) {
            $fees[$value->refer_expense_id] = array();
        }
        foreach ($general_expense as $key => $value) {

            array_push($fees[$value->refer_expense_id], (array) $value);
        }
        return $fees;
    }

    public function getDepresiation($from_date, $to_date = null) {
        $condition = $to_date == null ? '"date" <= \'' . $from_date . '\'' : '"date" between \'' . $from_date . '\' AND \'' . $to_date . '\'';
        $depreciation = DB::select('select sum (amount*depreciation) as total, refer_expense_id from ' . set_schema_name() . 'expense WHERE ' . $condition . ' group by refer_expense_id');
        $fees = array();

        foreach ($depreciation as $key => $value) {
            $fees[$value->refer_expense_id] = array();
        }
        foreach ($depreciation as $key => $value) {

            array_push($fees[$value->refer_expense_id], (array) $value);
        }
        return $fees;
    }

    public function getDepresiation_grouped($from_date, $to_date = null) {
        $sql = 'select SUM(coalesce(b.open_balance::numeric,0)) AS open_balance,sum(coalesce(amount,0)) as total,case when sum(\'' . $from_date . '\'- b.create_date::date) <= 0 and sum(\'' . $to_date . '\'-b.create_date::date)<=0 then 0 when sum(\'' . $from_date . '\'- b.create_date::date) <= 0 and sum(\'' . $to_date . '\'- b.create_date::date) >= 0 then sum(coalesce(b.open_balance,0)* coalesce(a.depreciation,0) * coalesce(((\'' . $to_date . '\'::date-b.create_date::date)),0)/365) else sum(coalesce(b.open_balance,0)* coalesce(a.depreciation,0) * coalesce(((\'' . $to_date . '\'::date-b.create_date::date)-(\'' . $from_date . '\'::date-b.create_date::date)),0)/365) END as deprec_open_balance, case when sum(\'' . $from_date . '\'- a.date) <= 0 and sum(\'' . $to_date . '\'-a.date)<=0 then 0 when sum(\'' . $from_date . '\'- a.date) <= 0 and sum(\'' . $to_date . '\'- a.date) >= 0 then sum(coalesce(amount,0)* coalesce(a.depreciation,0)* coalesce(((\'' . $to_date . '\'::date-a.date::date)),0)/365) else sum(coalesce(amount,0)* coalesce(a.depreciation,0)* coalesce(((\'' . $to_date . '\'::date-a.date::date)-(\'' . $from_date . '\'::date-a.date::date)),0)/365) END as deprec,b.account_group_id from ' . set_schema_name() . ' expense a RIGHT join ' . set_schema_name() . ' refer_expense b  on b.id=a.refer_expense_id  where  b.account_group_id is not null group by b.account_group_id';
        $depreciation = DB::select($sql);
        $fees = array();
        foreach ($depreciation as $key => $value) {
            $fees[$value->account_group_id] = array();
        }
        foreach ($depreciation as $key => $value) {

            array_push($fees[$value->account_group_id], (array) $value);
        }
        return $fees;
    }

    public function getExpenseFixedAssets($from_date, $to_date) {
        return DB::select('select  c.refer_expense_id,a.name,c.amount from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" WHERE c."date" between \'' . $from_date . '\' AND \'' . $to_date . '\' and a."financial_category_id"=4');
    }

    public function getGeneralExpenseFixedAssets($from_date, $to_date = null) {

        $sql = 'select b.id as account_group_id,b.name from ' . set_schema_name() . 'refer_expense a LEFT JOIN ' . set_schema_name() . ' account_groups b ON a.account_group_id=b.id LEFT JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" where a."financial_category_id"=4  and  a.account_group_id is not null group by b.id,b.name';


        $expense_fixedasset = DB::select($sql);

        $depreciation = $this->getDepresiation_grouped($from_date, $to_date);

        $sum_depreciation = 0;
        foreach ($expense_fixedasset as $fixed_asset) {


            $depreciation_total = isset($depreciation[$fixed_asset->account_group_id][0]['deprec']) ? $depreciation[$fixed_asset->account_group_id][0]['deprec'] : 0;

            $deprec_open_balance = isset($depreciation[$fixed_asset->account_group_id][0]['deprec_open_balance']) ? $depreciation[$fixed_asset->account_group_id][0]['deprec_open_balance'] : 0;


            $sum_depreciation = $sum_depreciation + $depreciation_total + $deprec_open_balance;
        }
        return $sum_depreciation;
    }

    public function getGeneralExpenseFixedAssets_grouped($from_date, $to_date = null) {

        $sql = 'select b.id as account_group_id,b.name from ' . set_schema_name() . 'refer_expense a LEFT JOIN ' . set_schema_name() . ' account_groups b ON a.account_group_id=b.id LEFT JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" WHERE a."financial_category_id"=4  and  a.account_group_id is not null group by b.id,b.name';

        $expense_fixedasset = DB::select($sql);

        $depreciation = $this->getNetDepreciation_grouped($from_date, $to_date);
        $sum_depreciation = 0;
        $total_no_depreciation = 0;
        foreach ($expense_fixedasset as $fixed_asset) {
            $no_depreciation = isset($depreciation[$fixed_asset->account_group_id][0]['total']) ? $depreciation[$fixed_asset->account_group_id][0]['total'] : 0;

            $open_balance = isset($depreciation[$fixed_asset->account_group_id][0]['open_balance']) ? $depreciation[$fixed_asset->account_group_id][0]['open_balance'] : 0;

            $depreciation_total = isset($depreciation[$fixed_asset->account_group_id][0]['deprec']) ? $depreciation[$fixed_asset->account_group_id][0]['deprec'] : 0;

            $deprec_open_balance = isset($depreciation[$fixed_asset->account_group_id][0]['deprec_open_balance']) ? $depreciation[$fixed_asset->account_group_id][0]['deprec_open_balance'] : 0;


            $total_no_depreciation = $total_no_depreciation + $no_depreciation + $open_balance;

            $sum_depreciation = $sum_depreciation + $depreciation_total + $deprec_open_balance;
        }

        return $total_no_depreciation - $sum_depreciation;
    }

    public function GetexpressRevenues($from_date, $to_date) {
        return DB::select('select  b.refer_expense_id,a.name,sum(b.amount) as total from ' . set_schema_name() . 'refer_expense a  JOIN ' . set_schema_name() . 'revenues b ON a."id"=b."refer_expense_id" WHERE b."date" between \'' . $from_date . '\' AND \'' . $to_date . '\' GROUP BY b.refer_expense_id,a.name');
    }

    public function GetexpressRevenues_grouped($from_date, $to_date = null) {
        $condition = $to_date == null ? 'b."date" <= \'' . $from_date . '\'' : 'b."date" >= \'' . $from_date . '\' AND b.date <= \'' . $to_date . '\'';

        return DB::select('select  d.id as account_group_id,d.name,sum(b.amount) as total from ' . set_schema_name() . 'refer_expense a  JOIN ' . set_schema_name() . 'revenues b ON a."id"=b."refer_expense_id" JOIN ' . set_schema_name() . ' account_groups d ON d.id=a.account_group_id WHERE ' . $condition . ' GROUP BY d.id,d.name');
    }

    public function GetGeneralexpressRevenues($from_date, $to_date = null) {
        $condition = $to_date == null ? 'b."date" <= \'' . $from_date . '\'' : 'b."date" between \'' . $from_date . '\' AND \'' . $to_date . '\'';
        $revenues = collect(\DB::select('select  sum(b.amount) as total  from ' . set_schema_name() . 'refer_expense a  JOIN ' . set_schema_name() . 'revenues b ON a."id"=b."refer_expense_id" WHERE ' . $condition . ' '))->first();
        if (!empty($revenues)) {
            return $revenues->total;
        } else {
            return 0;
        }
    }

    public function getExpenseGeneral($from_date, $to_date) {
        return DB::select('select a.name,(select sum(amount) from ' . set_schema_name() . 'expense where refer_expense_id=a.id AND "date" between \'' . $from_date . '\' AND \'' . $to_date . '\')  from ' . set_schema_name() . 'refer_expense a WHERE a."financial_category_id"=3 ');
    }

    public function getExpenseGeneral_grouped($from_date, $to_date) {
        $sql = 'select d.name,sum(b.amount+COALESCE(a.open_balance, 0 )) from ' . set_schema_name() . 'expense b JOIN ' . set_schema_name() . 'refer_expense a ON b.refer_expense_id=a.id JOIN ' . set_schema_name() . 'account_groups d ON a.account_group_id=d.id WHERE a."financial_category_id"=3 AND b."date" >= \'' . $from_date . '\' AND  b.date<=\'' . $to_date . '\' group by d.name  UNION ALL (SELECT c.name, sum(b.employer_amount) from ' . set_schema_name() . 'refer_expense a join ' . set_schema_name() . 'salary_pensions b on b.pension_id=a.predefined JOIN ' . set_schema_name() . ' account_groups c on c.id=a.account_group_id  WHERE a."financial_category_id"=3 AND b."created_at" >= \'' . $from_date . '\' AND  b.created_at <=\'' . $to_date . '\' group by c.name)';


        RETURN DB::SELECT($sql);
    }

    public function getGeneralExpenseGeneral($from_date, $to_date = null) {
        $condition = $to_date == null ? 'b."date" <= \'' . $from_date . '\'' : 'b."date" >= \'' . $from_date . '\' AND  b.date <=\'' . $to_date . '\'';

        $condition2 = $to_date == null ? 'b."created_at" <= \'' . $from_date . '\'' : 'b."created_at" >= \'' . $from_date . '\' AND  b.created_at <=\'' . $to_date . '\'';

        $sql = 'select coalesce(sum(b.amount+COALESCE(a.open_balance, 0 )),0) as total from ' . set_schema_name() . 'expense b JOIN ' . set_schema_name() . 'refer_expense a ON b.refer_expense_id=a.id JOIN ' . set_schema_name() . 'account_groups d ON a.account_group_id=d.id WHERE a."financial_category_id"=3 AND ' . $condition . '   UNION ALL (SELECT coalesce(sum(b.employer_amount),0) as total from ' . set_schema_name() . 'refer_expense a join ' . set_schema_name() . 'salary_pensions b on b.pension_id=a.predefined JOIN ' . set_schema_name() . ' account_groups c on c.id=a.account_group_id  WHERE a."financial_category_id"=3  AND ' . $condition2 . ' )';


        $total_general_expense = DB::select($sql);

        $total = 0;

        if (!empty($total_general_expense)) {
            foreach ($total_general_expense as $value) {
                $total = $total + $value->total;
            }

            return $total;
        } else {
            return 0;
        }
    }

    public function getUniqueOpexp($from_date, $to_date = null) {
        $condition = $to_date == null ? '"date" <= \'' . date('Y-m-d', strtotime($from_date)) . '\'' : '"date" between \'' . date('Y-m-d', strtotime($from_date)) . '\' AND \'' . date('Y-m-d', strtotime($to_date)) . '\'';
        $refer_expense = DB::select('select sum(amount) as total,refer_expense_id from expenses where ' . $condition . ' group by refer_expense_id');
        $fees = array();

        foreach ($refer_expense as $key => $value) {
            $fees[$value->refer_expense_id] = array();
        }
        foreach ($refer_expense as $key => $value) {
            array_push($fees[$value->refer_expense_id], (array) $value);
        }
        return $fees;
    }

    public function getUniqueOpexp_grouped($from_date, $to_date = null) {
        $condition = $to_date == null ? 'a."date" <= \'' . date('Y-m-d', strtotime($from_date)) . '\'' : 'a."date" between \'' . date('Y-m-d', strtotime($from_date)) . '\' AND \'' . date('Y-m-d', strtotime($to_date)) . '\'';
        $refer_expense = DB::select('select sum(a.amount) as total,b.account_group_id from expenses a JOIN  refer_expense b ON b.id=a.refer_expense_id where ' . $condition . ' group by b.account_group_id');
        $fees = array();
        foreach ($refer_expense as $key => $value) {
            $fees[$value->account_group_id] = array();
        }
        foreach ($refer_expense as $key => $value) {
            array_push($fees[$value->account_group_id], (array) $value);
        }
        return $fees;
    }

    public function getUniqueOpexb($to_date) {
        $refer_expense = DB::select('select sum(amount) as total,refer_expense_id from ' . set_schema_name() . 'expense where date <=\'' . $to_date . '\' group by refer_expense_id');
        $fees = array();

        foreach ($refer_expense as $key => $value) {
            $fees[$value->refer_expense_id] = array();
        }
        foreach ($refer_expense as $key => $value) {

            array_push($fees[$value->refer_expense_id], (array) $value);
        }
        return $fees;
    }

    public function getUniqueOpexb_grouped($to_date) {
        $refer_expense = DB::select('select sum(coalesce(a.amount,0)) as total,b.account_group_id from ' . set_schema_name() . 'expense a RIGHT JOIN ' . set_schema_name() . 'refer_expense b ON a.refer_expense_id=b.id where (a.date <=\'' . $to_date . '\' OR b.create_date <=\'' . $to_date . '\')  group by b.account_group_id');


        $fees = array();
        foreach ($refer_expense as $key => $value) {

            $fees[$value->account_group_id] = array();
        }

        foreach ($refer_expense as $key => $value) {

            array_push($fees[$value->account_group_id], (array) $value);
        }

        return $fees;
    }

    public function getOperationalExpense($from_date, $to_date) {
        return DB::select('select distinct c.refer_expense_id,a.name from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b.id JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" WHERE c."date" >= \'' . $from_date . '\' AND  c.date<=\'' . $to_date . '\' and a."financial_category_id"=2');
    }

    public function getOperationalExpense_grouped($from_date, $to_date) {
        $sql = 'select distinct d.id as account_group_id,d.name from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b.id LEFT JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" JOIN ' . set_schema_name() . ' account_groups d on d.id=a.account_group_id WHERE c."date" >=\'' . $from_date . '\' AND  c.date <=\'' . $to_date . '\' and a."financial_category_id"=2';

        return DB::select($sql);
    }

    public function getGeneralOperationalExpense($from_date, $to_date = null) {
        $condition = $to_date == null ? 'c."date" <= \'' . $from_date . '\'' : 'c."date" >= \'' . $from_date . '\' AND c.date <=\'' . $to_date . '\'';
        $expense_operational = DB::select('select distinct d.id as account_group_id,d.name from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b.id JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" JOIN ' . set_schema_name() . ' account_groups d on d.id=a.account_group_id WHERE ' . $condition . ' and a."financial_category_id"=2');

        $sum_operational = 0;
        $unique_opex = $this->getUniqueOpexp_grouped($from_date, $to_date);
        foreach ($expense_operational as $value) {
            $opex = isset($unique_opex[$value->account_group_id][0]['total']) ? $unique_opex[$value->account_group_id][0]['total'] : null;
            $sum_operational = $sum_operational + $opex;
        }

        return $sum_operational;
    }

    public function getGeneralOperationalExpense_grouped($from_date, $to_date = null) {
        $condition = $to_date == null ? 'c."date" <= \'' . $from_date . '\'' : 'c."date" >= \'' . $from_date . '\' AND c.date <= \'' . $to_date . '\'';
        $expense_operational = DB::select('select distinct d.id as account_group_id,d.name from ' . set_schema_name() . 'refer_expense a JOIN constant.financial_category b ON a."financial_category_id"=b."id" JOIN ' . set_schema_name() . 'expense c ON a."id"=c."refer_expense_id" JOIN ' . set_schema_name() . ' account_groups d ON d.id=a.account_group_id WHERE ' . $condition . ' and a."financial_category_id"=2');

        $sum_operational = 0;
        $unique_opex = $this->getUniqueOpexp_grouped($from_date, $to_date);
        foreach ($expense_operational as $value) {
            $opex = isset($unique_opex[$value->account_group_id][0]['total']) ? $unique_opex[$value->account_group_id][0]['total'] : null;
            $sum_operational = $sum_operational + $opex;
        }
        return $sum_operational;
    }

    public function getgeneralFeeTotal($from_date, $to_date = null) {
        $condition = $to_date == null ? 'a."created_at" <= \'' . $from_date . '\'' : 'a."created_at" between \'' . $from_date . '\' AND \'' . $to_date . '\'';

        $total_fee = collect(\DB::select('select sum(coalesce(a.total_amount,0)-coalesce(a.discount_amount,0)) as total from ' . set_schema_name() . 'invoice_balances a  JOIN  ' . set_schema_name() . 'fees b ON b."id"=a."fee_id" WHERE  ' . $condition . ' '))->first();

        if (!empty($total_fee)) {
            return $total_fee->total;
        } else {

            return 0;
        }
    }

    public function getFeeTotal($from_date, $to_date = null) {
        //here created_at date should be date
        $condition = $to_date == null ? 'a."created_at" <= \'' . $from_date . '\'' : 'a."created_at" between \'' . $from_date . '\' AND \'' . $to_date . '\'';
        $fee_total = DB::select('select sum(a.total_amount)  as total,sum(a.discount_amount) as total_discount, a.fee_id from ' . set_schema_name() . 'invoice_balances a JOIN ' . set_schema_name() . 'fees b ON a."fee_id"=b."id"  WHERE ' . $condition . ' group by a.fee_id');
        $fees = array();

        foreach ($fee_total as $key => $value) {
            $fees[$value->fee_id] = array();
        }
        foreach ($fee_total as $key => $value) {

            array_push($fees[$value->fee_id], (array) $value);
        }
        return $fees;
    }

    public function GetexpressRevenue_total($to_date) {
        return collect(\DB::select('select  sum(amount) as total from ' . set_schema_name() . 'revenues where date <= \'' . $to_date . '\''))->first();
    }

    public function financial_expense($id, $from_date, $to_date) {

        return $this->expense_m->get_account_report($id, $from_date, $to_date);
    }

    public function edit() {
        if (can_access('edit_expense')) {
            $id = clean_htmlentities(($this->uri->segment(3)));
            $this->data['check_id'] = $expense_id = clean_htmlentities(($this->uri->segment(4)));

            $this->data['banks'] = \App\Model\BankAccount::all();
            $this->data["payment_types"] = \App\Model\PaymentType::all();

            if ((int) $id) {
                //$this->data['expense'] = $this->expense_m->get_expense_by_id($id);
                $this->data['expense'] = \App\Model\Expense::where('expense.expenseID', $id)->first();

                if ($this->data['expense']) {
                    if ($_POST) {
                        $refer_expense_id = $this->data['expense']->refer_expense_id;
                        $rules = $this->rules();

                        $this->form_validation->set_rules($rules);
                        if ($this->form_validation->run() == FALSE) {
                            $this->data["subview"] = "expense/edit";
                            $this->load->view('_layout_main', $this->data);
                        } else {
                            //dd($expense_id);
                            if ($expense_id == 2) {

                                $amount = request("type") == 1 ? request("amount") : -request("amount");
                            } else {

                                $amount = request("amount");
                            }

                            $array = array(
                                "date" => date("Y-m-d", strtotime(request("date"))),
                                "amount" => $amount,
                                "transaction_id" => request("transaction_id"),
                                "note" => request("note"),
                                "payment_type_id" => request("payment_type_id"),
                                "ref_no" => request("transaction_id"),
                            );

                            $this->data['expense']->update($array);
                            $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                            return redirect(base_url("expense/view_expense/$refer_expense_id/$expense_id"));
                        }
                    } else {
                        $this->data["subview"] = "expense/edit";
                        $this->load->view('_layout_main', $this->data);
                    }
                } else {
                    $this->data["subview"] = "error";
                    $this->load->view('_layout_main', $this->data);
                }
            } else {
                $this->data["subview"] = "error";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function category_edit() {
        if (can_access('edit_chart_of_account')) {
            $id = clean_htmlentities(($this->uri->segment(3)));
            $categ_id = clean_htmlentities(($this->uri->segment(4)));
            $this->data['editable'] = (int) clean_htmlentities(($this->uri->segment(5))) == 1 ? 'disabled' : '';
            if ((int) $id) {
                $this->data['refer_expense'] = ReferExpense::find($id);
                $this->data["category"] = \App\Model\FinancialCategory::all();
                $this->data["groups"] = \App\Model\AccountGroup::all();
                if ($this->data['refer_expense']) {
                    if ($_POST) {
                        if ($this->data["refer_expense"]->chart_no > 0) {
                            $chart_no = \collect(DB::select('select chart_no from ' . set_schema_name() . 'refer_expense WHERE id=' . $id))->first();
                            $chart_number = $chart_no->chart_no;
                        } else {
                            $chart_no = \collect(DB::select('select max(chart_no) as chart_no from ' . set_schema_name() . 'refer_expense WHERE financial_category_id=' . $this->data["refer_expense"]->financial_category_id))->first();
                            $chart_number = $chart_no->chart_no + 1;
                        }

                        $array = array();

                        if ($this->data['refer_expense']->predefined > 0) {
                            $array = array(
                                "note" => request("note"),
                                'open_balance' => (float) request('open_balance') > 0 ? (float) request('open_balance') : 0,
                            );
                        } else {

                            $this->validate(request(), [
                                "subcategory" => "required",
                                "account_group_id" => "required",
                                "financial_category_id" => "required|min:1",
                                    ], $this->custom_validation_message);

                            $obj = [
                                'name' => request('subcategory'),
                                "financial_category_id" => request('financial_category_id'),
                            ];
                            $account_group_id = (int) trim(request("account_group_id")) > 0 ? (int) trim(request("account_group_id")) : DB::table('account_groups')->insertGetId($obj);

                            $array = array(
                                "name" => trim(request("subcategory")),
                                "account_group_id" => $account_group_id,
                                "financial_category_id" => request("financial_category_id"),
                                "note" => request("note"),
                                "chart_no" => $chart_number,
                                'open_balance' => (float) request('open_balance') > 0 ? (float) request('open_balance') : 0,
                                'code' => request('code') == '' ? $this->createCode() : request('code')
                            );
                        }


                        $affected_number = $this->data['refer_expense']->update($array);
                        if ($affected_number > 0) {
                            $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                        } else {
                            $this->session->set_flashdata('error', 'Update failed , please try again');
                        }

                        return redirect(base_url("expense/financial_category/$categ_id"));
                    } else {
                        $this->data["subview"] = "expense/expense_category_edit";
                        $this->load->view('_layout_main', $this->data);
                    }
                } else {
                    $this->data["subview"] = "error";
                    $this->load->view('_layout_main', $this->data);
                }
            } else {
                $this->data["subview"] = "error";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function delete() {
        if (can_access('delete_expense')) {
            $id = clean_htmlentities(($this->uri->segment(3)));
            $expense_id = clean_htmlentities(($this->uri->segment(4)));

            if ($expense_id == 5) {
                DB::table('current_assets')->where('id', $id)->delete();
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                return redirect()->back();
            } else if ((int) $id && $expense_id != 5) {
                DB::table('expense_cart')->where('expense_id', $id)->delete();
                $this->expense_m->delete_expense($id);

                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                return redirect()->back();
            } else {
                return redirect(base_url("expense/index/$expense_id"));
            }
        } else {

            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function category_delete() {
        if (can_access('delete_expense')) {
            $id = clean_htmlentities(($this->uri->segment(3)));
            $type = clean_htmlentities(($this->uri->segment(4)));
            if ((int) $id) {
                $check_expense = $this->expense_m->get_order_by_expense(array('refer_expense_id' => $id));
                if (empty($check_expense)) {
                    $this->expense_m->delete_refer_expense($id);
                    $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                    return redirect(base_url("expense/financial_category/$type"));
                } else {
                    $f = clean_htmlentities(($this->uri->segment(5)));
                    if ($f == 1) {
                        //delete by force
                        \App\Model\Expense::where('refer_expense_id', $id)->delete();
                        \App\Model\ReferExpense::find($id)->delete();
                        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                        return redirect(base_url("expense/financial_category/$type"));
                    }
                    $this->data['message'] = 'There are transactions belong to this account. If you delete this account, all transactions associated with this account will be deleted. Are you sure you want to delete this fee and all transactions associated with it?';
                    $this->data['return_url'] = 'expense/financial_category';
                    $this->data['del_by_force_url'] = 'expense/category_delete/' . $id . '/f/1';
                    $this->data["subview"] = "layouts/delete_force";
                    $this->load->view('_layout_main', $this->data);
                    //$this->session->set_flashdata('error', 'Please Delete expenses recorded under this category first');
                    //return redirect(base_url("expense/financial_category/$type"));
                }
            } else {
                return redirect(base_url("expense/index/$type"));
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function category_index() {
        if (can_access('view_expense')) {
            $this->data['feetypecategory'] = $this->fee_m->feetype_category_all();
            $this->data["subview"] = "fee/feetype_category/category_index";
            $this->load->view('_layout_main', $this->data);
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function customSummary() {
        $report_type = $this->data['report_type'] = request('report_type');
        $start = $this->data['from'] = date("Y-m-d", strtotime(request('from_date')));
        $end = $this->data['to'] = date("Y-m-d", strtotime(request('to_date')));
        $check_fee = explode(',', $report_type);
     
        if ((int) $report_type == 1 && count($check_fee) < 2) {
            //expenses 
            $this->data['type'] = 'Expense';
            $transactions = \App\Model\Expense::whereBetween('date', [$start, $end])->get();
        } else if ((int) $report_type == 2 &&  count($check_fee) < 2) {
            //payments 
            $this->data['type'] = 'Payments';
            $transactions = \App\Model\Payment::whereBetween('date', [$start, $end])->orderBy('id', 'desc')->get();
        } else if ((int) $report_type == 3 &&  count($check_fee) < 2) {
            //revenues 
            $this->data['type'] = 'Revenues';
            $transactions = \App\Model\Revenue::whereBetween('date', [$start, $end])->get();
        } else {
            //Single Fee Report 
            $fee_id = $check_fee[0];
            $this->data['type'] = $check_fee[1];
          
            $transactions = \App\Model\PaymentsInvoicesFeesInstallment::whereIn('invoices_fees_installment_id', \App\Model\InvoicesFeesInstallment::whereIn('fees_installment_id', \App\Model\FeesInstallment::where('fee_id', $fee_id)->get(['id']))->get(['id']))
           ->whereIn('payment_id', \App\Model\Payment::whereBetween('date', [$start, $end])->orderBy('id', 'desc')->get(['id']))->get();
          //  dd($transactions);
        $this->data['transactions'] = $transactions;
        $this->data["subview"] = "fee/fee_payment_summary";
        $this->load->view('_layout_main', $this->data);
        exit;
        }
        $this->data['transactions'] = $transactions;
        $this->data["subview"] = "fee/custom_summary";
        $this->load->view('_layout_main', $this->data);
    }

    function summary() {
        if ($_POST) {
            return $this->customSummary();
        }
        $this->data['today_amount'] = \collect(DB::select("select sum(amount) from " . set_schema_name() . "total_revenues where date::date='" . date('Y-m-d') . "'"))->first();
        $this->data['weekly_amount'] = \collect(DB::select("select sum(amount) from " . set_schema_name() . "total_revenues where date_trunc('week', date) = date_trunc('week', current_date)"))->first();
        $this->data['monthly_amount'] = \collect(DB::select("select sum(amount) from " . set_schema_name() . "total_revenues where date_trunc('month', date) = date_trunc('month', current_date)"))->first();
        $this->data['revenue'] = $this->getExpenseRevenueByMonth();
        $this->data['expected_amount'] = \collect(DB::select('select sum(total_amount) as sum from ' . set_schema_name() . ' invoices_fees_installments_balance'))->first();
        $this->data['collected_amount'] = \collect(DB::select('select sum(amount) from ' . set_schema_name() . 'total_revenues'))->first();

        $this->data['expected_expense'] = \collect(DB::select('select (select sum(salary)*12 from ' . set_schema_name() . 'teacher) + (select sum(salary)*12 from ' . set_schema_name() . 'user) + (select case when sum(amount)*12 is null then 0 else sum(amount)*12 end as sum  from (select distinct refer_expense_id,amount from ' . set_schema_name() . 'expense  where expense !=\'Payroll\') a) + (select sum(salary)*12 from ' . set_schema_name() . 'setting)  as sum'))->first();
        $this->data['expense'] = \collect(DB::select('select sum(amount::numeric) from ' . set_schema_name() . 'expense'))->first();
        $students_in_invoices = Invoice::get(['student_id']);
        $academic_years = \App\Model\AcademicYear::where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->get(['id'])->toArray();
        $student_array = DB::table('invoices')->get(['student_id']);
        $ar = array();
        foreach ($student_array as $student) {
            array_push($ar, $student->student_id);
        }
        $this->data["no_invoice"] = Student::whereNotIn('student_id', $ar)->whereIn('academic_year_id', $academic_years)->where('status', 1)->count();
        $this->data["no_payments"] = Student::whereNotIn('student_id', Payment::get(['student_id']))->where('status', 1)->whereIn('student_id', $students_in_invoices)->whereIn('academic_year_id', $academic_years)->count();
        $this->data["payments_received"] = Payment::count();
        $this->data["revenue_received"] = Revenue::count();

        $this->data["subview"] = "fee/summary";
        $this->load->view('_layout_main', $this->data);
    }

    public function getExpenseRevenueByMonth() {
        return DB::select("with tempa as (
    select a.date,a.revenue, b.expense from 
    (
select  sum(amount) as revenue,date_trunc('month', date) as date from " . set_schema_name() . "total_revenues group by date_trunc('month', date) order by date_trunc('month', date) asc
    )
    as a left join 
    (
  select  sum(amount::numeric) as expense,date_trunc('month', create_date) as create_date from " . set_schema_name() . "expense group by date_trunc('month', create_date) order by date_trunc('month', create_date) asc
    ) as b on date_trunc('month', b.create_date)= date_trunc('month', a.date) ),
tempb as ( select * from tempa ) 
select * from tempb");
    }

    function global_exchange() {
        $this->data['exchanges'] = DB::table('exchange_rates')->get();
        $this->data["subview"] = "expense/global_exchange";
        $this->load->view('_layout_main', $this->data);
    }

    public function globalExhangeRate() {
        $from_currency = $this->data['siteinfos']->currency_symbol;
        if (strtoupper($from_currency) != request('to_currency')) {
            $obj = [
                'from_currency' => $from_currency,
                'to_currency' => request('to_currency'),
                'rate' => request('val'),
                'note' => request('note'),
                'created_by_id' => session('id'),
                'created_by_table' => session('table')
            ];
            if (count(DB::table('exchange_rates')->where($obj)->get()) == 0) {
                DB::table('exchange_rates')->insert($obj);
                DB::table('setting')->update(['currency_symbol' => request('to_currency')]);
            }
            return 1;
        } else {
            echo 'Default currency is the same as the one you want to convert to';
        }
    }

    function delete_exchange() {
        $id = clean_htmlentities(($this->uri->segment(3)));
        $exchange = \App\Model\ExchangeRate::find($id);
        DB::table('setting')->update(['currency_symbol' => $exchange->from_currency]);
        $exchange->delete();
        return redirect()->back()->with('success', 'success');
    }

    function BalanceAt($from_date) {

        $net_depreciation = $this->getNoDepreciation_grouped($from_date);
        //dd($net_depreciation);
        $unique_opex = $this->getUniqueOpexp_grouped($from_date);

        $fee_total = $this->getgeneralFeeTotal($from_date);
        $paid_fee_total = $this->getTotalFeePaidTotal($from_date);
        $total_express_revenues = $this->GetGeneralexpressRevenues($from_date);
        $total_expense_operational = $this->getGeneralOperationalExpense_grouped($from_date);
        $total_expense_general = $this->getGeneralExpenseGeneral($from_date);

        $total_expense_fixedasset = $this->getGeneralExpenseFixedAssets_grouped($from_date);

        $expense_equity = $this->getTotalExpenseEquity_grouped($from_date);

        $expense_liabilities = $this->getExpenseLiabilityFromTo_grouped($from_date);
        //$this->data['feereceivable_total'] = $this->getFeeReceivableBefore($from_date);
        $liability_total = $this->getTotalExpenseLiability_grouped($from_date);
        $expense_fixedasset = $this->getExpenseFixedAssetsFromToDate_grouped($from_date);

        $income = ($fee_total + $total_express_revenues) - ( $total_expense_operational + $total_expense_fixedasset + $total_expense_general);
        $receivable = $fee_total - $paid_fee_total;

        $a = $income + $total_expense_fixedasset - $receivable;

        $sum_fixedasset = 0;
        $i = 0;
        //print_r($expense_fixedasset);exit;
        foreach ($expense_fixedasset as $fixed_asset) {
            $fa_total = isset($net_depreciation[$fixed_asset->account_group_id][0]['total']) ? $net_depreciation[$fixed_asset->account_group_id][0]['total'] : null;


            $sum_fixedasset = $sum_fixedasset + $fa_total;
        }

        $sum_equity = 0;
        foreach ($expense_equity as $value1) {
            $capital_total = isset($unique_opex[$value1->account_group_id][0]['total']) ? $unique_opex[$value1->account_group_id][0]['total'] : null;
            $sum_equity = $sum_equity + $capital_total;
        }
        $b = $sum_fixedasset * -1;

        $sum_liabilities = 0;
        foreach ($expense_liabilities as $liability) {
            $li_total = isset($unique_opex[$liability->account_group_id][0]['total']) ? $unique_opex[$liability->account_group_id][0]['total'] : null;

            $sum_liabilities = $sum_liabilities + $li_total;
        }
        $c = $sum_liabilities + $sum_equity;
        $d = $a + $b + $c;

        return $d;
    }

    private function checkKeysExists($value) {
        $required = array('date', 'amount', 'account_number', 'expense_name');

        $data = array_change_key_case(array_shift($value), CASE_LOWER);
        $keys = str_replace(' ', '_', array_keys($data));
        $results = array_combine($keys, array_values($data));
        if (count(array_intersect_key(array_flip($required), $results)) === count($required)) {
            //All required keys exist!            
            $status = 1;
        } else {
            $missing = array_intersect_key(array_flip($required), $results);
            $data_miss = array_diff(array_flip($required), $missing);
            $status = ' Column with title <b>' . implode(', ', array_keys($data_miss)) . '</b>  miss from Excel file. Please make sure file is in the same format as a sample file';
        }

        return $status;
    }

    function uploadByFile($account_data = null) {


        if (!empty($_POST)) {
            $data = $account_data == 'expense' || $account_data == null ? $this->uploadExcel() : $account_data;
            $status = $this->checkKeysExists($data);


            if ((int) $status == 1) {
                foreach ($data as $value_array) {

                    $call_array = new \App\Http\Controllers\Student();
                    $value = $call_array->modify_keys_to_upper_and_underscore($value_array);


                    $bank = \App\Model\BankAccount::where('number', $value['account_number'])->first();
                    $refer_expense = \App\Model\ReferExpense::where('name', $value['expense_name'])->first();
                    if (empty($refer_expense)) {
                        $status .= '<p class="alert alert-danger">Expense not defined. This expense name <b>' . $value['expense_name'] . '</b> must be defined first in charts of account. This record skipped to be uploaded</p>';
                    } else {

                        $dor = str_replace('/', '-', $value['date']);

                        $array = array(
                            "create_date" => date("Y-m-d"),
                            "date" => date("Y-m-d", strtotime($dor)),
                            "amount" => $value['amount'],
                            "note" => isset($value["note"]) ? $value["note"] : 0,
                            "ref_no" => isset($value["transaction_id"]) ? $value["transaction_id"] : 0,
                            "payment_method" => isset($value["payment_method"]) ? $value["payment_method"] : 0,
                            "bank_account_id" => !empty($bank) ? $bank->id : NULL,
                            "transaction_id" => $value["transaction_id"],
                            "refer_expense_id" => $refer_expense->id,
                            "expenseyear" => date("Y"),
                            "expense" => isset($value["note"]) ? $value["note"] : 0,
                            "depreciation" => isset($value["depreciation"]) ? $value["depreciation"] : 0,
                            'userID' => session('id'),
                            'uname' => session('username'),
                            'usertype' => session('usertype'),
                            'created_by' => $this->createdBy()
                        );




                        $expense = \App\Model\Expense::create($array);
                        $status .= '<p class="alert alert-success">Expense for ' . $expense->expense . ' added successfully</p>';
                    }
                }
            }
        }
        if ($account_data == null || $account_data == 'expense') {
            $this->data['status'] = $status;
            $this->data["subview"] = "mark/upload_status";
            $this->load->view('_layout_main', $this->data);
        } else {
            return '<b> Expense:</b> ' . $status;
        }
    }

    function uploadByFileChart($account_data = null) {
        if (!empty($_POST)) {
            $data = $data = $account_data == null || $account_data == 'expense' ? $this->uploadExcel() : $account_data;
            $status = $this->excelCheckKeysExists($data, ['code', 'name', 'type', 'description']);
            if ((int) $status == 1) {
                $status = '';
                foreach ($data as $value) {
                    $category = \App\Model\FinancialCategory::where(DB::raw('lower(name)'), trim(strtolower($value['type'])))->first();
                    $code = $value['code'] == '' ? $this->createCode() : $value['code'];
                    $name_or_code = \App\Model\ReferExpense::where(['name' => trim($value["name"]), 'code' => $code])->first();
                    if (!empty($name_or_code)) {
                        $status .= '<p class="alert alert-danger">Account name <b>' . $value['name'] . '</b> or account code ' . $code . ' already exists. This record skipped to be uploaded</p>';
                    } else if (empty($category)) {
                        $status .= '<p class="alert alert-danger">This fee type <b>' . $value['type'] . '</b> does not exists. This record skipped to be uploaded</p>';
                    } else {
                        $group_name = isset($value['group']) ? trim($value['group']) : trim($value["name"]);
                        $group = \App\Model\AccountGroup::where(DB::raw('lower(name)'), trim(strtolower($group_name)))->first();
                        $account_group_id = !empty($group) ? $group->id :
                                DB::table('account_groups')->insertGetId(['name' => $group_name]);
                        $array = array(
                            "name" => trim($value["name"]),
                            "financial_category_id" => $category->id,
                            "note" => $value["description"],
                            "account_group_id" => $account_group_id,
                            'code' => $value['code'] == '' ? $this->createCode() : $value['code'],
                            'open_balance' => isset($value['open_balance']) && (float) $value['open_balance'] > 0 ? (float) $value['open_balance'] : 0,
                            "status" => ""
                        );
                        DB::table('refer_expense')->insert($array);
                        $status .= '<p class="alert alert-success">Expense for ' . $value["name"] . ' added successfully</p>';
                    }
                }
            }
        }
        $this->data['status'] = $status;
        $this->data["subview"] = "mark/upload_status";
        $this->load->view('_layout_main', $this->data);
    }

    public function addDefaultChart() {
        DB::statement('insert into ' . set_schema_name() . 'refer_expense(name,create_date,financial_category_id,note,status, code,date,open_balance, account_group_id) select name,create_date,financial_category_id,note,status, code,date,open_balance, account_group_id from constant.refer_expense');
        return redirect()->back()->with('success', 'Success');
    }

    public function cash_request() {
        if (can_access('view_cash_request')) {
            $id = clean_htmlentities(($this->uri->segment(3)));
            $cash_request_id = clean_htmlentities(($this->uri->segment(4)));
            if ($id == 'add') {
                if ($_POST) {
                    $total_amount = 0;
                    foreach (request('particular') as $key => $value) {
                        $total_amount += request('amount')[$key] * request('quantity')[$key];
                    }

                    $object = [
                        'particulars' => json_encode(array_merge(request()->except('_token'))),
                        'amount' => $total_amount,
                        'requested_by' => session('id'),
                        'requested_by_table' => session('table'),
                        'requested_date' => 'now()',
                    ];
                    \App\Model\CashRequest::create(can_access('approve_checked_by') ? array_merge($object, ['checked_by' => session('id'),
                                        'checked_by_table' => session('table'),
                                        'checked_date' => 'now()']) : $object);
                    return redirect(url('expense/cash_request'))->with('success', 'success');
                }
                $this->data["subview"] = "expense/cash_request/add";
                $this->load->view('_layout_main', $this->data);
            } else if ($id == 'edit') {
                $this->data['requests'] = \App\Model\CashRequest::find($cash_request_id);
                if ($_POST) {
                    $total_amount = 0;
                    foreach (request('particular') as $key => $value) {
                        $total_amount += request('amount')[$key] * request('quantity')[$key];
                    }

                    $object = [
                        'particulars' => json_encode(array_merge(request()->except('_token'))),
                        'amount' => $total_amount,
                        'requested_by' => session('id'),
                        'requested_by_table' => session('table')
                    ];
                    $this->data['requests']->update(can_access('approve_checked_by') ? array_merge($object, ['checked_by' => session('id'),
                                        'checked_by_table' => session('table'),
                                        'checked_date' => 'now()']) : $object);
                    return redirect(url('expense/cash_request'))->with('success', 'success');
                }
                $this->data["subview"] = "expense/cash_request/edit";
                $this->load->view('_layout_main', $this->data);
            } else if ($id == 'view') {
                $this->data['requests'] = \App\Model\CashRequest::find($cash_request_id);
                $this->data["subview"] = "expense/cash_request/view";
                $this->load->view('_layout_main', $this->data);
            } else if ($id == 'delete') {
                \App\Model\CashRequest::find($cash_request_id)->delete();
                return redirect(url('expense/cash_request'))->with('success', 'success');
            } else {
                $this->data['requests'] = \App\Model\CashRequest::all();
                $this->data["subview"] = "expense/cash_request/index";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function cash_approve() {
        $request = \App\Model\CashRequest::find(request('id'));
        if (!empty($request)) {
            $request->update([request('tag') . '_by' => session('id'),
                request('tag') . '_by_table' => session('table'),
                request('tag') . '_date' => 'now()']);
            echo 'Success';
        }
        exit;
    }

}

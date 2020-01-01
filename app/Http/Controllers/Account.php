<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Invoice;
use \App\Models\Project;
use \App\Models\InvoiceFee;
use Illuminate\Validation\Rule;
use \App\Models\ReferExpense;
use \App\Models\Expense;
use DB;
use Auth;

class Account extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $this->data['users'] = [];
        // $this->data['log_graph'] = $this->createBarGraph();
        return view('analyse.index', $this->data);
    }

    public function projection() {
        $this->data['budget'] = [];
        return view('account.projection', $this->data);
    }

    public function invoice() {
        $this->data['budget'] = [];
        $project_id = request()->segment(3);
        if ((int) $project_id == 1) {
            //create shulesoft invoices
            //check in client table if all schools with students and have generated reports are registered
            // if exists, check if invoice exists, else, create new invoice
            $this->getShuleSoftInvoice();
        }
        if ($project_id == 'delete') {
            $invoice_id = request()->segment(4);
            \App\Models\Invoice::find($invoice_id)->delete();
            return redirect()->back()->with('success', 'success');
        }

        if ($project_id == 'edit') {
            $id = request()->segment(4);
            $this->data['invoice'] = Invoice::find($id);

            return view('account.invoice.edit', $this->data);
        } else {
            $from = $this->data['from'] = request('from');
            $to = $this->data['to'] = request('to');
            $from_date = date('Y-m-d H:i:s', strtotime($from . ' -1 day'));
            $to_date = date('Y-m-d H:i:s', strtotime($to . ' +1 day'));
            $this->data['invoices'] = ($from != '' && $to != '') ?
                    Invoice::whereBetween('date', [$from_date, $to_date])->where('project_id', $project_id)->get() :
                    Invoice::whereIn('id', InvoiceFee::where('project_id', $project_id)->get(['invoice_id']))->get();
            return view('account.invoice.index', $this->data);
        }
    }

    public function invoiceView() {
        $invoice_id = (int) request()->segment(3);
        $this->data['invoice'] = Invoice::find($invoice_id);
        return view('account.invoice.single', $this->data);
    }

    private function getShuleSoftInvoice() {
        $nonclients = \DB::select('select distinct a."schema_name",b.name,b.sname,b.phone,b.email,b.address,(select count(*) from admin.all_student where "schema_name"=a."schema_name") as total_students from admin.all_exam_report a join admin.all_setting b on a."schema_name"=b."schema_name" where a."schema_name" not in (select username from admin.clients)');
        foreach ($nonclients as $client) {
            $client_record = \App\Models\Client::create(['name' => $client->sname, 'email' => $client->email, 'phone' => $client->phone, 'address' => $client->address, 'username' => $client->schema_name]);
            $reference = 'SASA11' . date('Y') . $client_record->id;
            $invoice = Invoice::create(['reference' => $reference, 'client_id' => $client_record->id, 'date' => 'now()', 'year' => date('Y'), 'sync', 'user_id' => Auth::user()->id]);
            $amount = $client->total_students * 1000;
            \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => 1]);
        }
    }

    public function project() {
        $this->data['projects'] = Project::all();
        return view('account.project', $this->data);
    }

    public function createInvoice() {
        $this->data['projects'] = Project::all();
        if (request('noexcel')) {
            $data = request('users');
            $client_id = request('client_id');
            $client_record = \App\Models\Client::find($client_id);
            if (request('force_new') == true) {
                $user_invoice = [];
                $reference = 'SASA11' . date('Y') . $client_record->id . rand(10, 100);
            } else {
                $user_invoice = Invoice::where('client_id', $client_id)->first();
                $reference = 'SASA11' . date('Y') . $client_record->id;
            }


            if (count($user_invoice) == 0) {


                $invoice = Invoice::create(['reference' => $reference, 'client_id' => $client_record->id, 'date' => date('d M Y', strtotime(request('date'))), 'due_date' => date('d M Y', strtotime(' +30 day')), 'year' => date('Y', strtotime(request('date'))), 'sync', 'user_id' => Auth::user()->id]);

                foreach ($data as $value) {
                    //check if this user has invoice already 
                    $project = Project::where('name', 'ílike', $value['project'])->first();
                    $amount = (float) $value['quantity'] * (float) $value['unit_price'];
                    \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => count($project) == 1 ? $project->id : request('project_id'), 'item_name' => $value['name'], 'quantity' => (int) $value['quantity'], 'unit_price' => (float) $value['unit_price']]);
                }
                echo 1;
            } else {
                echo ' <div class="alert alert-warning">User <b>' . $client_record->name . '</b>  has an invoice number ' . $user_invoice->reference . ' already generated on ' . $user_invoice->created_at . '. Please update</div>';
            }
        }
        return view('account.invoice.create', $this->data);
    }

    public function getClient() {
        $project_id = request('project_id');
        $clients_projects = \App\Models\ClientProject::where('project_id', $project_id)->get();
        foreach ($clients_projects as $client) {
            echo '<option value="' . $client->client->id . '">' . $client->client->name . '</option>';
        }
    }

    public function client() {
        $this->data['clients'] = \App\Models\Client::all();
        $seg = request()->segment(3);
        $id = request()->segment(4);
        if ($seg == 'edit' && (int) $id > 0) {
            $this->data['projects'] = Project::all();
            $this->data['client'] = \App\Models\Client::find($id);
            if ($_POST) {
                $this->validate(request(), [
                    'phone' => ['required', Rule::unique('clients')->ignore($id, 'id')],
                    'name' => 'required|string',
                    'address' => 'required|string',
                    'project_ids' => 'required',
                    'email' => ['required', Rule::unique('clients')->ignore($id, 'id')]]
                );
                $this->data['client']->update(request()->all());
                \App\Models\ClientProject::where('client_id', $id)->delete();
                foreach (request('project_ids') as $project_id) {
                    \App\Models\ClientProject::create(['project_id' => $project_id, 'client_id' => $id]);
                }
                return redirect(url('account/client'))->with('success', 'success');
            }
            return view('account.client.edit', $this->data);
        }
        if ($seg == 'delete' && (int) $id > 0) {
            $client = \App\Models\Client::find($id);
            if ($client->payments()->sum('amount') == 0) {
                $client->delete();
            } else {
                $this->data['message'] = 'This client cannot be deleted';
            }
            return redirect()->back();
        }
        return view('account.client.index', $this->data);
    }

    public function createClient() {
        $this->data['projects'] = Project::all();
        if ($_POST) {
            $this->validate(request(), [
                'phone' => 'required|unique:clients,phone',
                'name' => 'required|string',
                'address' => 'required|string',
                'project_ids' => 'required',
                'email' => 'required|email|unique:clients,email']
            );
            $client = \App\Models\Client::create(request()->all());
            foreach (request('project_ids') as $project_id) {
                \App\Models\ClientProject::create(['project_id' => $project_id, 'client_id' => $client->id]);
            }
            return redirect(url('account/client'))->with('success', 'success');
        }
        return view('account.client.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addPayment() {

        $invoice = Invoice::where("number", request('number'))->first();
        if (count($invoice) > 0) {


// This is when a bank return payment status to us
//save it in the database
            $this->validate(request(), ['amount' => 'required|numeric', 'transaction_id' => 'required']);
            if (in_array(request('paymentType'), ['BANK', 'MPESA'])) {
                $payments = Payment::where('transaction_id', request('transaction_id'))->first();
                if (count($payments) > 0) {
                    $data = array(
                        'status' => 1,
                        'success' => 0,
                        'reference' => $invoice->number,
                        'description' => 'Transaction ID has been used already to commit transaction'
                    );
                    die(json_encode($data));
                }
            }
            $mobile_transaction_id = request('mobile_transaction_id');
            if (request('amount') > $invoice->invoiceFee()->sum('amount')) {
                return redirect()->back()->with('error', 'Payment not accepted. Amount paid is greater than amount required');
            }
            $payment = $this->acceptPayment(request('amount'), $invoice->id, request('method'), request('transaction_id'), $mobile_transaction_id, request('name'), request('account_number'), request('transaction_time'), request('token'));
        }
        $this->sendNotification($invoice);
        return redirect('account/invoice')->with('success', json_decode($payment)->description);
    }

    public function acceptPayment($amount, $invoice_id, $payment_method, $receipt, $mobile_transaction_id, $customer_name, $account_number, $timestamp, $token) {

        $financial_id = count($this->api_info) == 1 ? $this->api_info->financial_entity_id : \App\Model\Financial_entity::where('name', request('method'))->first()->id;

        $payment_array = array(
            "invoice_id" => $invoice_id,
            "amount" => $amount,
            "method" => $payment_method,
            "transaction_id" => $receipt,
            "mobile_transaction_id" => $mobile_transaction_id,
            'account_number' => $account_number,
            'note' => $customer_name,
            'transaction_time' => $timestamp,
            'token' => $token,
            'financial_entity_id' => $financial_id,
            //special case for CRDB payments only
            'checksum' => $this->request_value('checksum'),
            'payment_type' => $this->request_value('paymentType'),
            'amount_type' => $this->request_value('amountType'),
            'currency' => $this->request_value('currency')
        );

        $payment_id = DB::table('payments')->insertGetId($payment_array);
        $invoice_fee_ids = \App\Model\Invoice_fee::where('invoice_id', $invoice_id)->get();
        $status = 1;
        foreach ($invoice_fee_ids as $invoice_fee_data) {
            if ($invoice_fee_data->status <> 1 && $amount > 0) {
                if ($amount >= $invoice_fee_data->amount) {
                    $status = 1;
                    Invoice_fees_payment::create([
                        'invoice_fee_id' => $invoice_fee_data->id,
                        'payment_id' => $payment_id,
                        'paid_amount' => $invoice_fee_data->amount,
                        'status' => $status
                    ]);
                    $amount = $amount - $invoice_fee_data->amount;
                } else {
                    //amount is less than invoice paid amount
                    $status = 2;
                    Invoice_fees_payment::create([
                        'invoice_fee_id' => $invoice_fee_data->id,
                        'payment_id' => $payment_id,
                        'paid_amount' => $amount,
                        'status' => $status
                    ]);
                    $amount = $amount - $amount;
                }
            }
        }
        $invoice = Invoice::find($invoice_id);
        $invoice->update(['status' => $status]);
        $amount > 0 ? \App\Model\Wallet::create(['user_id' => $invoice->user_id, 'amount' => $amount, 'invoice_id' => $invoice_id, 'status' => 1]) : '';
        return $this->paymentBalance($payment_id, $status);
    }

    public function paymentBalance($payment_id, $status) {
        $code = 'ERB' . rand(43, 43434);
        DB::table('receipts')->insert(['payment_id' => $payment_id, 'code' => $code]);
        $invoice = Payment::find($payment_id)->invoice;
        $this->sendBarcodeForm($payment_id);
        (new PaymentController())->sendNotification($invoice);
        if ($status == 1) {
            //amount has been paid correctly to more than one id so the returned id should be changed.
            return json_encode(array('control' => 1, 'description' => 'Invoice fully paid', 'payment_id' => $payment_id));
        } else if ($status == 2) {
            return json_encode(array('control' => 2, 'description' => 'Invoice partially paid', 'payment_id' => $payment_id));
        } else {
            return json_encode(array('control' => 3, 'description' => 'Invoice is paid amount more than invoiced amount', 'payment_id' => $payment_id));
        }
    }

    /**
     * 
     * @param type $payment_id
     * @access : Via kernel background operation
     */
    function sendBarcodeForm($payment_id = null) {
        $payment = $this->data['payment'] = Payment::find($payment_id);
        $id = $payment->invoice->user_id;
        $content = 'Please Click the link below to download/print your barcode form'
                . '<br/>'
                . '<br/>'
                . '<a href="https://engineersday.co.tz/user/ticket/' . $id . '?auth=' . encrypt($id) . '" style="display: inline-block; margin-bottom: 0; font-weight: 40px; text-align: center;
    vertical-align: middle; cursor: pointer; background-image: none; border: 1px solid transparent; white-space: nowrap; padding: 12px 24px; font-size: 14px; line-height: 1.428571429; border-radius: 4px;color: #fff; background-color: #5cb85c; border-color: #4cae4c;">EVENT BARCODE</a>';
        $this->send_email($payment->invoice->user->email, 'ERB Payment Accepted - Event Barcode ticket', $content);
    }

    public function revenue() {
        if (can_access('view_revenue')) {
            $id = request()->segment(3);
            $this->data['id'] = $id;
            if ((int) $id) {
                if ($_POST) {
                    $this->data['revenues'] = \App\Models\Revenue::where('refer_expense_id', $id)->where('date', '>=', request('from_date'))->where('date', '<=', request('to_date'))->get();
                } else {

                    $this->data['revenues'] = \App\Models\Revenue::where('refer_expense_id', $id)->get();
                }
                $this->data["subview"] = "revenue/index";
            } else {
                $this->data['id'] = null;
                $this->data['revenues'] = \App\Models\Revenue::all();
                $this->data['expenses'] = \App\Models\ReferExpense::whereIn('financial_category_id', [1])->get();

                $this->data["subview"] = "revenue/index_main";
            }
            return view('account.transaction.revenue', $this->data);
        }
    }

    public function revenueAdd() {
        $this->data['projects'] = Project::all();
        $this->data["payment_types"] = \App\Models\PaymentType::all();
        $this->data['banks'] = \App\Models\BankAccount::all();
        $this->data["category"] = DB::table('refer_expense')->whereIn('financial_category_id', [1])->get();
        if ($_POST) {
            $this->validate(request(), [
                'phone' => 'required|unique:clients,phone',
                'name' => 'required|string',
                'address' => 'required|string',
                'project_ids' => 'required',
                'email' => 'required|email|unique:clients,email']
            );
            $client = \App\Models\Client::create(request()->all());
            foreach (request('project_ids') as $project_id) {
                \App\Models\ClientProject::create(['project_id' => $project_id, 'client_id' => $client->id]);
            }
            return redirect(url('account/client'))->with('success', 'success');
        }
        return view('account.transaction.create', $this->data);
    }

    public function transaction() {
        $id = request()->segment(3);
        $this->data['id'] = $id;
        if ((int) $id) {

            if ($_POST) {
                $to_date = request("to_date");
                $from_date = request("from_date");
            } else {
                $from_date = date('Y-01-01');
                $to_date = date('Y-m-d');
            }
            $this->data['from_date'] = $from_date;
            $this->data['to_date'] = $to_date;
            $this->data['expenses'] = $this->getCategories_by_date($id, $from_date, $to_date);
        }

        return view('account.transaction.expense', $this->data);
    }

    public function getCategories_by_date($id, $from_date, $to_date) {
        $ids = Expense::where('date', '>=', $from_date)->where('date', '<=', $to_date)->get(['refer_expense_id']);
        switch ($id) {
            case 1:
                $result = ReferExpense::where('financial_category_id', 4)->whereIn('id', $ids)->get();
                break;
            case 2:
                $result = ReferExpense::where('financial_category_id', 6)->whereIn('id', $ids)->get();
                break;
            case 3:
                $result = ReferExpense::where('financial_category_id', 7)->whereIn('id', $ids)->get();
                break;
            case 4:
                $result = ReferExpense::whereIn('financial_category_id', [2, 3])->whereIn('id', $ids)->get();
                break;
            case 5:
                $result = ReferExpense::where('financial_category_id', 5)->whereIn('id', $ids)->get();
                break;
            default:
                $result = array();
                break;
        }
        return $result;
    }

    public function addTransaction() {
        $this->data['banks'] = \App\Models\BankAccount::all();
        $id = request()->segment(3);
        $this->data["category"] = DB::table('refer_expense')->whereIn('financial_category_id', [2, 3])->get();

        $this->data['id'] = $id;
        $this->data['check_id'] = $id;
        $this->data['sub_id'] = request()->segment(4);
        $this->data['banks'] = \App\Models\BankAccount::all();
        $this->data["payment_types"] = \App\Models\PaymentType::all();
        $this->data['transaction_id'] = $transaction_id = time() . rand(10 * 45, 100 * 98);
        if ($_POST) {
            //   dd(request()->all());
//            if ($id == 5) {
//                $this->rules_asset();
//            } else {
//                $this->rules();
//            }

            $insert_id = 0;
            $depreciation = (float) request("depreciation") > 0 ? (float) request("depreciation") : (float) request("dep");
            // $type=request("type");
            if ($id == 2 || $id == 5) {

                $amount = request("type") == 1 ? (request("amount")) : -(request("amount"));
            } else {

                $amount = (request("amount"));
            }

            if ($id == !5) {
                $refer_expense_id = request("expense");
                $refer_expense_name = \App\Models\ReferExpense::find($refer_expense_id)->name;
                if (strtolower($refer_expense_name) == 'depreciation') {

                    $this->session->set_flashdata('error', 'Sorry ! Depreciation is added through fixed assets');
                    return redirect()->back();
                }
            }


            $payer_name = request('payer_name');

            $array = array(
                "date" => request('date'),
                "note" => request("note"),
                "ref_no" => request("transaction_id"),
                "payment_type_id" => request("payment_type_id"),
                "transaction_id" => request("transaction_id"),
                "refer_expense_id" => request("expense"),
                "expenseyear" => date("Y"),
                "expense" => request("note"),
                "depreciation" => $depreciation,
                'user_id' => Auth::user()->id
            );
            //dd(request()->all());

            if ($id == 4 || $id == 1) {

                $voucher_no = DB::table('expense')->max('voucher_no');


                if (request('user_in_shulesoft') == 1) {

                    $user_request = explode(',', request('user_id'));
                    $user = \App\Models\User::where('id', $user_request[0])->first();

                    $obj = array_merge($array, [
                        'recipient' => $user->name,
                        'voucher_no' => $voucher_no + 1,
                        'payer_name' => $payer_name,
                        "amount" => $amount,
                        "bank_account_id" => request("bank_account_id"),
                    ]);



                    $insert_id = DB::table('expense')->insertGetId($obj);
                } else {

                    $obj = array_merge($array, [
                        'recipient' => request('payer_name'),
                        'voucher_no' => $voucher_no + 1,
                        'payer_name' => $payer_name,
                        "amount" => $amount,
                        "bank_account_id" => request("bank_account_id"),
                    ]);


                    DB::table('expense')->insert($obj);
                }

                // $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                return redirect(url("account/transaction/$id"))->with('success', 'success');
            } else if ($id == 5) {

                $voucher_no = DB::table('current_assets')->max('voucher_no');
                $array = array(
                    "date" => request('date'),
                    "note" => request("note"),
                    "from_refer_expense_id" => request("from_expense"),
                    "to_refer_expense_id" => request("to_expense"),
                    'userID' => session('id'),
                    'uname' => session('username'),
                    "amount" => request('amount'),
                    'voucher_no' => $voucher_no + 1,
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

                    $total_current_assets = \collect(DB::SELECT('SELECT sum(coalesce(amount,0)) as total_current from ' . set_schema_name() . ' current_asset_transactions WHERE refer_expense_id=' . $refer_expense->predefined . ''))->first();
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
                    'amount' => request('amount'),
                ]);

                $insert_id = DB::table('expense')->insertGetId($obj, "expenseID");


                if ($insert_id > 0) {
                    $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                } else {
                    $this->session->set_flashdata('error', 'There Is error in adding new expense');
                }
                return redirect(base_url("expense/index/$id"));
            }
        }
        return view('account.transaction.create_trans', $this->data);
    }

    public function bank() {
        $this->data['bankaccounts'] = \App\Models\BankAccount::all();
        return view('account.bank.index', $this->data);
    }

    public function group() {

        $this->data['id'] = null;
        $this->data['groups'] = \App\Models\AccountGroup::all();
        $this->data["category"] = \App\Models\FinancialCategory::all();
        return view('account.group', $this->data);
    }

    public function chart() {

        $this->data['set'] = 0;
        $this->data['id'] = 0;
        $this->data['expenses'] = ReferExpense::all();
        $this->data["subview"] = "expense/charts_of_accounts";
        $this->data["category"] = \App\Models\FinancialCategory::all();
        $this->data['groups'] = \App\Models\AccountGroup::all();
        if($_POST){
            
            
          
            $this->validate(request(), [
                "subcategory" => "required|regex:/(^([a-zA-Z,. ]+)(\d+)?$)/u",
                "code" => "regex:/(^[ A-Za-z0-9_@.#&+-]*$)/u|required|iunique:refer_expense,code," . $id,
                'financial_category_id' => 'numeric|min:1'
                    ], $this->custom_validation_message);
            $obj = [
                'name' => request('subcategory'),
                "financial_category_id" => request('financial_category_id'),
            ];

            if ((int) request("group") > 0) {
                $account_group_id = request("group");
                // $account_group_id = request("group") > 0 ? request("group") : DB::table('account_groups')->insertGetId($obj);

            } else {
                $check = DB::table('account_groups')->where($obj)->first();
                $account_group_id = count($check)>0 ? $check->id : DB::table('account_groups')->insertGetId($obj);
            }
            $array = array(
                "name" => trim(request("subcategory")),
                "financial_category_id" => request('financial_category_id'),
                "note" => request("note"),
                "account_group_id" => $account_group_id,
                'code' => request('code') == '' ? $this->createCode() : request('code'),
                'open_balance' => (float) request('open_balance') > 0 ? (float) request('open_balance') : 0,
                "status" => "$id"
            );

            ReferExpense::create($array);
            $this->session->set_flashdata('success', $this->lang->line('menu_success'));
            return redirect()->back()->with('success','success');
        }
        return view('account.charts', $this->data);
    }

    public function report() {
        $this->data['set'] = 0;
        $this->data['id'] = 0;
        $this->data['expenses'] = ReferExpense::all();
        return view('account.report.index', $this->data);
    }

    public function view_expense() {
        $id = ((request()->segment(3)));
        $refer_id = ((request()->segment(4)));
        $bank_id = ((request()->segment(5)));
        $academic_year_to = \App\Models\AccountYear::whereYear('start_date', date('Y'))->first();
        $academic_year_from = \App\Models\AccountYear::orderBy('start_date', 'asc')->first();

        $from_date = $academic_year_from->start_date;
        $to_date = $academic_year_to->end_date;

        $refer_expense = \App\Models\ReferExpense::find($id);

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
            }

            if (strtoupper($refer_expense->name) == 'ACCOUNT RECEIVABLE') {

                $this->data['expenses'] = array();
                $this->data['current_assets'] = DB::SELECT('SELECT * from ' . set_schema_name() . ' current_asset_transactions WHERE refer_expense_id=' . $id . ' and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . ' ');
                $this->data['fees'] = DB::select('select sum(a.balance + coalesce((c.amount-c.due_paid_amount),0)) as total_amount,b.name from ' . set_schema_name() . ' invoice_balances a join ' . set_schema_name() . ' student b on b.student_id=a.student_id LEFT JOIN ' . set_schema_name() . ' dues_balance c on c.student_id=b.student_id WHERE  a.balance <> 0.00 AND a."created_at" between \'' . $from_date . '\' AND \'' . $to_date . '\' group by b.name');
                $this->data['bank_opening_balance'] = \collect(DB::select('select sum(coalesce(opening_balance,0)) as opening_balance from ' . set_schema_name() . ' bank_accounts'))->first();
            } else if ((int) $bank_id) {
                $this->data['expenses'] = DB::SELECT('SELECT transaction_id,date,amount,' . "'Bank'" . ' as payment_method , note from ' . set_schema_name() . ' bank_transactions WHERE bank_account_id=' . $bank_id . ' and payment_type_id <> 1 and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . 'order by date desc');

                $this->data['current_assets'] = DB::SELECT('SELECT * from ' . set_schema_name() . ' current_asset_transactions WHERE refer_expense_id=' . $id . ' and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . 'order by date desc');
            } else {
                $this->data['expenses'] = array();
                $this->data['current_assets'] = DB::SELECT('SELECT * from ' . set_schema_name() . ' current_asset_transactions WHERE refer_expense_id=' . $id . ' and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . ' ');
            }
        } else if (preg_match('/EC-1001/', $refer_expense->code) && $id = 4 && (int) $refer_expense->predefined > 0) {
            $sql = 'select sum(b.employer_amount) as amount ,payment_date as date,\'' . $refer_expense->name . '\' as note,\' ' . $refer_expense->name . '\' as name, \'Payroll\' as payment_method,null as "expenseID",extract(month from payment_date)||\'\'||extract(year from payment_date) as ref_no, 1 AS predefined, null as id  from ' . set_schema_name() . 'salaries a join ' . set_schema_name() . 'salary_pensions b on a.id=b.salary_id where b.pension_id=' . $refer_expense->predefined . '  group by a.payment_date UNION ALL (SELECT a.amount, a.date, a.note, b.name, a.payment_method, a."expenseID", a.ref_no, null as predefined, b.id FROM ' . set_schema_name() . 'expense a JOIN ' . set_schema_name() . 'refer_expense b ON a.refer_expense_id=b.id WHERE b.id=' . $refer_expense->id . ' ORDER BY a.date DESC)';
            $this->data['expenses'] = DB::SELECT($sql);
        } else if (strtoupper($refer_expense->name) == 'DEPRECIATION') {

            $this->data['expenses'] = DB::select('select coalesce(sum(b.open_balance::numeric * b.depreciation*(\'' . $to_date . '\'::date-a.date::date)/365),0) as open_balance,sum(amount-amount* a.depreciation *(\'' . $to_date . '\'::date-a.date::date)/365) as total,sum(amount* a.depreciation*(\'' . $to_date . '\'::date-a.date::date)/365) as amount, refer_expense_id,a.date,a.note,a.recipient,b.name,a."expenseID",b.predefined from ' . set_schema_name() . 'expense a join ' . set_schema_name() . 'refer_expense b  on b.id=a.refer_expense_id where b.financial_category_id=4 AND  a.date  <= \'' . $to_date . '\' group by a.refer_expense_id,b.open_balance,a.date,a.note,b.name,a."expenseID",b.predefined  ORDER BY a.date desc');
            $this->data['depreciation'] = 1;
        } else {

            //$this->data['expenses'] = DB::SELECT('SELECT b.*,a.* FROM ' . set_schema_name() . 'expense a JOIN ' . set_schema_name() . 'refer_expense b ON a.refer_expense_id=b.id WHERE b.id=' . $id . ' and a."date" >= ' . "'$from_date'" . ' AND a."date" <= ' . "'$to_date'" . ' ');

            $this->data['expenses'] = \App\Models\ReferExpense::where('refer_expense.id', $id)->JOIN('expense', 'expense.refer_expense_id', 'refer_expense.id')->where('expense.date', '>=', $from_date)->where('expense.date', '<=', $to_date)->get();
        }
        //$this->data['refer_id'] = $id;
        $this->data['period'] = 1;
        $this->data['predefined'] = $refer_expense->predefined;
        $this->data['id'] = $refer_id;
        $this->data['refer_id'] = $refer_id;
        $this->data['refer_expense_name'] = $refer_expense->name;
        return view("account.transaction.expense_category", $this->data);
    }

    public function editExpense($id) {

        $this->data['expense'] = \App\Models\Expense::where('id', $id)->first();
        $this->data['id'] = 4;
        $this->data['check_id'] = $id;
        $this->data["category"] = DB::table('refer_expense')->whereIn('financial_category_id', [2, 3])->get();
        //dd($this->data['expense']);
        if ($this->data['expense']) {
            if ($_POST) {
                $refer_expense_id = $this->data['expense']->refer_expense_id;

                if ($id == 2) {

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
                    'recipient' => request('recipient')
                );

                $this->data['expense']->update($array);
                return redirect(url("account/view_expense/$refer_expense_id/$id"))->with('success', 'success');
            } else {
                return view("account.transaction.edit", $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function expense() {

        $id = request()->segment(3);
        $this->data['check_id'] = $expense_id = request()->segment(4);
        $this->data['sub_id'] = request()->segment(4);
        $this->data["payment_types"] = \App\Models\PaymentType::all();
        $this->data['banks'] = \App\Models\BankAccount::all();
        if ($id == 'edit') {
            return $this->editExpense($expense_id);
        } else {
            echo 'page not found';
        }
    }

}

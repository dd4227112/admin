<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExpense;
use Illuminate\Validation\Rule;
use App\Charts\SimpleChart;
use DB;
use Auth;

class Revenue extends Controller {

  
    public function __construct() {
        $this->middleware('auth');
    }



    public function index() {
        $id = request()->segment(3);
      //  dd(request('from_date'));
       $page = 'index';
       if ((int) $id) {
           $this->data['id'] = $id;
           if ($_POST) {
               $this->data['revenues'] = \App\Models\Revenue::where('refer_expense_id', $id)->where('date', '>=', request('from_date'))->where('date', '<=', request('to_date'))->get();
           } else {
               $this->data['revenues'] = \App\Models\Revenue::where('refer_expense_id', $id)->get();
           }
           $page = 'revenue';
       } else {
           $this->data['id'] = null;
           $this->data['revenues'] = \App\Models\Revenue::all();
           $this->data['expenses'] = \App\Models\ReferExpense::whereIn('financial_category_id', [1])->get();
       }
       return view('account.transaction.' . $page, $this->data);
    }


    public function add() {
        $this->data['projects'] = \App\Models\Project::all();
        $this->data["payment_types"] = \App\Models\PaymentType::all();
        $this->data['banks'] = \App\Models\BankAccount::all();
        $this->data["category"] = DB::table('refer_expense')->whereIn('financial_category_id', [1])->get();
        if ($_POST) {
            $array = array_merge(['user_id' => (int) request('user_id')], request()->except('user_id','amount'));
           \App\Models\Revenue::create(array_merge($array, ['amount' => remove_comma(request('amount'))]));
          return redirect(url('revenue/index'))->with('success', 'success');
        }
        return view('account.transaction.create', $this->data);
    }


    public function edit() {
        $id = request()->segment(3);
        if ((int) $id > 0) {
            $this->data['invoice'] = \App\Models\Invoice::find($id);
            $this->data["payment_types"] = \App\Models\PaymentType::all();
            $this->data['banks'] = \App\Models\BankAccount::all();
            $this->data['revenue'] = \App\Models\Revenue::where('id', $id)->first();
            if ($this->data['revenue']) {
                $this->data["category"] = \App\Models\ReferExpense::whereIn('financial_category_id',[1])->get();
                if ($_POST) {
                    $this->data['revenue']->update(request()->all());
                    return redirect(url("revenue/index"));
                } else {    
                  return view('account.transaction.revenue.edit', $this->data);
                }
            }
         
        } else {
            return redirect()->back()->with('error', 'Sorry ! Something is wrong try again!!');
        }
    }

    public function delete() {
        $id = request()->segment(3);
        if ((int) $id > 0) {
            $this->data['invoice'] = \App\Models\Invoice::find($id);
            \App\Models\Revenue::where('id', $id)->delete();
            return redirect()->back()->with('success', 'Revenue Delete Successfully!!');
        } else {
            return redirect()->back()->with('error', 'Sorry ! Something is wrong try again!!');
        }
    }


    public function receipt() {
        $id = request()->segment(3);
        if ((int) $id) {
            $this->data['revenue'] = \App\Models\Revenue::find($id);
            $receipt_setting = \DB::table('receipt_settings')->first();
            $template = $receipt_setting->template;
            $file = 'invoices.receipt_templates.' . $template;
            if ($_POST) {
                $settings = DB::table('receipt_settings')->first();
                $vars = get_object_vars($settings);
                $obj = array();
                foreach ($vars as $key => $variable) {
                    if (!in_array($key, array('id', 'available_templates', 'created_at'))) {
                        $obj = array_merge($obj, array($key => request($key) == null ? 0 : request($key)));
                    }
                }
                !empty($obj) ? \App\Models\ReceiptSetting::first()->update($obj) : '';
            }
            $this->data['productcart'] = \App\Models\ProductCart::where('revenue_id', $id)->get();
            $this->data['invoice'] = \App\Models\Invoice::find($id);
            return view('account.transaction.revenue.receipt', $this->data);
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }


    public function uploadRevenue() {
        if ($_POST) {
            $address = request()->file('file');
            dd($address);
            $results = Excel::load($address)->all();
            //once we upload excel, register students and marks in mark_info table
            $status = '';
            foreach ($results as $value) {
                $check = $this->checkKeysExists($value, ['amount', 'transaction_id', 'account_number', 'payment_method', 'revenue_name', 'date']);
                if ((int) $check <> 1) {
                    return redirect()->back()->with('error', $check);
                }
                $refer_expense = \App\Models\ReferExpense::where('name', $value['revenue_name'])->first();
                if (empty($refer_expense)) {
                    $status .= '<p class="alert alert-danger">Revenue not defined. This expense name <b>' . $value['revenue_name'] . '</b> must be defined first in charts of account. This record skipped to be uploaded</p>';
                    continue;
                }
                $check_unique = \App\Models\Revenue::where('transaction_id', $value['transaction_id'])->first();
                if (empty($check_unique)) {
                    $status .= '<p class="alert alert-danger">This transaction ID <b>' . $value['transaction_id'] . '</b> already being used. Information skipped</p>';
                    continue;
                }
                $bank = \App\Models\BankAccount::where('number', $value['account_number'])->first();

                $in_data = [
                    'created_by_id' => Auth::user()->id,
                    'amount' => $value['amount'],
                    'payment_method' => $value['payment_method'],
                    'transaction_id' => $value['transaction_id'],
                    "refer_expense_id" => $refer_expense->id,
                    "bank_account_id" => !empty($bank) ? $bank->id : NULL,
                    'date' => date("Y-m-d", strtotime($value['date'])),
                    'note' => $value['note']
                ];
//                dd($in_data);
                if ((int) $value['user_in_shulesoft'] == 1) {

                    $user = \App\Models\User::where('name', 'ilike', '%' . $value['payer_name'] . '%')->first();
                    if (!empty($user)) {
                        $data = array_merge($in_data, [
                            'payer_name' => $user->name,
                            'user_id' => $user->id,
                            'user_table' => $user->table,
                            'payer_email' => $user->email,
                            'payer_phone' => $user->phone
                        ]);
                    } else {
                        $user = Auth::user();
                        $data = array_merge($in_data, [
                            'payer_name' => $user->firstname . ' ' . $user->lastname,
                            'user_id' => $user->id,
                            'payer_email' => $user->email,
                            'payer_phone' => $user->phone
                        ]);
                    }
                } else {
                    $data = [
                        'payer_name' => $value['payer_name'],
                        'payer_phone' => $value['payer_phone'],
                        'payer_email' => $value['payer_email'],
                        'created_by_id' => session('id'),
                        'amount' => $value['amount'],
                        "refer_expense_id" => $refer_expense->id,
                        "bank_account_id" => !empty($bank) ? $bank->id : NULL,
                        'payment_method' => $value['payment_method'],
                        'transaction_id' => $value['transaction_id'],
                        'date' => date("Y-m-d", strtotime($value['date'])),
                        'note' => $value['note']
                    ];
                }

                \App\Models\Revenue::create($data);
            }
            return redirect('account/revenue')->with('success', $status);
        }
    }

  

}
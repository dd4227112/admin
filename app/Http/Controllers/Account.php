<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExpense;
use \App\Models\Invoice;
use \App\Models\Project;
use \App\Models\InvoiceFee;
use Illuminate\Validation\Rule;
use \App\Models\ReferExpense;
use \App\Models\Expense;
use App\Charts\SimpleChart;
use DB;
use Auth;

class Account extends Controller {

  
    public function __construct() {
        $this->middleware('auth');
        $this->data['insight'] = $this;
    }

    public function index() {
        $this->data['users'] = [];
        // $this->data['log_graph'] = $this->createBarGraph();
        return view('account.report.index', $this->data);
    }

    public function projection() {
        $this->data['budget'] = [];
        return view('account.projection', $this->data);
    }

    public function getInvoices($project_id = null, $account_year_id = null) {
        $from = $this->data['from'] = request('from');
        $to = $this->data['to'] = request('to');
        $from_date = date('Y-m-d H:i:s', strtotime($from . ' -1 day'));
        $to_date = date('Y-m-d H:i:s', strtotime($to . ' +1 day'));
        $this->data['invoices'] = ($from != '' && $to != '') ?
                Invoice::whereBetween('date', [$from_date, $to_date])->latest()->get() :
                Invoice::whereIn('id', InvoiceFee::where('project_id', $project_id)->get(['invoice_id']))->where('account_year_id', $account_year_id)->latest()->get();
        $this->data['accountyear']= \App\Models\AccountYear::where('id', $account_year_id)->first();
        return $this;
    }


    public function createInvoices($client_id) {
        $client = \App\Models\Client::findorFail($client_id);
        $year = \App\Models\AccountYear::where('name', date('Y'))->first();
        $reference = time().rand(777, 123); // to be changed for selcom ID
        
        $start_date = $client->invoice_start_date;
        $end_date = $client->invoice_end_date;

        if($client->invoice_start_date == '' &&  $client->invoice_end_date == ''){
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d',strtotime('+30 days',strtotime($start_date)));
        }

        $check=\DB::select("select reference from admin.invoices where reference = '. $reference .'");
        if(!empty($check)){
          $reference = time().rand(456, 789);
         } 


        $data = ['reference' => $reference, 
                 'client_id' => $client_id, 
                 'date' => $start_date, 
                 'due_date' => $end_date, 
                 'year' => date('Y'), 
                 'user_id' => Auth::user()->id, 
                 'account_year_id' => $year->id
                ];

        if ((int) $client->price_per_student == 0 || (int) $client->estimated_students == 0) {
            //both price per students and Estimated students cannot be 0
            return redirect()->back()->with('error', 'Both price per students and Estimated students cannot be 0, please set them first');
        }
      
        $invoice = Invoice::create($data);

        //once we introduce packages (module pricing), we will just loop here for modules selected by specific user
        //validate for simple missing inputs
     
        if ((int) $client->price_per_student == 10000) {
            $months_remains = 12 - (int) date('m', strtotime($client->created_at)) + 1;
            $unit_price = $months_remains * $client->price_per_student / 12;
            $amount = $unit_price * $client->estimated_students;
        } else {
            $unit_price = $client->price_per_student;
            $amount = $unit_price * $client->estimated_students;
        }
        \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => 1, 'item_name' => 'ShuleSoft Service Fee', 'quantity' => $client->estimated_students, 'unit_price' => $unit_price]);
      //  return redirect()->back()->with('success', 'Invoice Created Successfully');
    }

    public function invoice() {
        $this->data['budget'] = [];
        $project_id = $this->data['project_id'] = request()->segment(3);
        $this->data['account_year_id'] = $account_year_id = request()->segment(4);
     
        if ((int) $project_id == 1) {
            //create shulesoft invoices
            //check in client table if all schools with students and have generated reports are registered
            $clients=\DB::select("select * from admin.clients where id not in (select client_id from admin.invoices where account_year_id=(select id from admin.account_years where name='".date('Y')."')) order by created_at desc");

        // if exists, check if invoice exists, else, create new invoice

        //    if(!empty($clients)){
        //     foreach($clients as $client)
        //       {
        //          $invoice = \App\Models\Invoice::where('client_id',$client->id)->where('account_year_id',$account_year_id)->first();
        //          if(empty($invoice)){
        //           $this->createInvoices($client->id);
        //        }
        //       }
        //    }

            $this->getInvoices($project_id, $account_year_id);
        }
      /*    if ($project_id == 'delete') {
            $invoice_id = request()->segment(4);
            $payments = \App\Models\Payment::where('invoice_id', $invoice_id)->first();
            if (!empty($payments)) {
                \App\Models\Revenue::where('transaction_id', $payments->transaction_id)->delete();
            }
            \App\Models\Invoice::find($invoice_id)->delete();

            return redirect()->back()->with('success', 'success');
        } */


        if ($project_id == 'edit') {
            $id = request()->segment(4);
            $this->data['invoice'] = Invoice::find($id);
            return view('account.invoice.edit', $this->data);
        } else {
            switch ($project_id) {
                case 4:
                    $this->data['invoices'] = DB::connection('karibusms')->select('select a.transaction_code,a.method, a.amount, a.currency,a.sms_provided,a.time,a.invoice, b.name,a.confirmed,a.approved,a.payment_id from payment a join client b using(client_id)');
                    break;
                default:
                    $this->getInvoices($project_id, $account_year_id);
                    break;
            }

            return view('account.invoice.index', $this->data);
            
        }
    }

    public function invoiceReport() {
        $project_id = $this->data['project_id'] = request()->segment(3);
        $this->data['account_year_id'] = $account_year_id = request()->segment(4);
        if ((int) $project_id == 1) {
           !empty(request('from')) ? $from = request('from') : $from = date('Y-01-01');
            $this->data['from'] = $from;
            $this->data['id'] = 4;
            !empty(request('to')) ? $to = request('to') : $to = date('Y-m-d');
            $to = $this->data['to'] = $to;
            $from_date = date('Y-m-d H:i:s', strtotime($from . ' -1 day'));
            $to_date = date('Y-m-d H:i:s', strtotime($to . ' +1 day'));
            $this->data['invoices'] = ($from != '' && $to != '') ? Invoice::whereBetween('date', [$from_date, $to_date])->get() :
                    Invoice::whereIn('id', InvoiceFee::where('project_id', $project_id)->get(['invoice_id']))->where('account_year_id', $account_year_id)->get();
            return view('account.invoice.report', $this->data);
        }
    }


    
    public function invoiceView() {
        $invoice_id = request()->segment(3);
        $set = $this->data['set'] = 1;
        if ((int) $invoice_id > 0) {
            $request_control = request()->segment(4);
            if ((int) $request_control > 0) {
                $this->createSelcomControlNumber($invoice_id);
                return redirect()->back()->with('success', 'success');
            }
            $this->data['invoice'] = Invoice::find($invoice_id);
            $this->data['usage_start_date'] = $this->data['invoice']->client->start_usage_date;
           
        
            $start_usage_date = !empty($this->data['usage_start_date']) ? date('Y-m-d',strtotime($this->data['usage_start_date'])) : date('Y-m-d', strtotime('Jan 01'));
           
            $yearEnd = date('Y-m-d', strtotime('Dec 31'));

            $to = \Carbon\Carbon::createFromFormat('Y-m-d',  $yearEnd);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $start_usage_date);
            $this->data['diff_in_months'] = $diff_in_months = $to->diffInMonths($from);
               
            return view('account.invoice.single', $this->data);
        }
    }



 // Edit invoice details such as description,quantity and price
    public function editInvoice()
    {   $invoice_id = request()->segment(3);
        $quantity  = request('quantity');
        $unit_price = request('price');
        $invoice = Invoice::find($invoice_id);
     
        $date = date("Y-m-d H:i:s");
        $prev_amount = \App\Models\InvoiceFee::where('invoice_id',$invoice_id)->first()->unit_price;
        if ((int) $unit_price == 10000) {
            $months_remains = 12 - (int) date('m', strtotime($invoice->date)) + 1;
            $unit_price = $months_remains * $unit_price / 12;
            $amount = $unit_price * $quantity;
        } else {
            $unit_price = $unit_price;
            $amount = $unit_price * $quantity;
        }
        \App\Models\InvoiceFee::where('invoice_id',$invoice_id)->where('project_id', 1)->update(['amount' => $amount,
        'quantity' => $quantity,'unit_price' => $unit_price]);

        \App\Models\InvoiceTracker::create(['invoice_id' => $invoice_id,'prev_amount' => $prev_amount,
        'new_amount'=>$unit_price,'user_id'=> Auth::user()->id,'date'=>$date]);
        return redirect()->back()->with('success','Updated successful!');
    }

// This method only create selcom booking ID, we don't detect errors due to its
    //sensitivity but in the future, we can add error control in case of anything
    public function createSelcomControlNumber($invoice_id) {
        $invoice = Invoice::find($invoice_id);
        $amount = $invoice->invoiceFees()->sum('amount');
        $order_id = rand(454, 4557) . time();
        if (strlen($invoice->token) < 4) {
            $phone_number = validate_phone_number($invoice->client->phone);
            if (is_array($phone_number)) {
                $phone = str_replace('+', null, validate_phone_number($invoice->client->phone)[1]);
            } else {
                $phone = '255754406004';
            }
            $order = array("order_id" => $order_id, "amount" => $amount,
                'buyer_name' => $invoice->client->name, 'buyer_phone' => $phone, 'end_point' => '/checkout/create-order', 'action' => 'createOrder', 'client_id' => $invoice->client_id, 'source' => $invoice->client_id);

            $this->curlPrivate($order);
        }
        return TRUE;
    }

    private function getShuleSoftInvoice() {
        $account_year_id = request()->segment(4);
        $year = \App\Models\AccountYear::find($account_year_id);
        $nonclients = \DB::select('select  a."schema_name",a.name,a.sname,a.phone,a.email,a.address,(select count(*) from admin.all_student where "schema_name"::text=a."schema_name"::text and status=1 and created_at::date <=\'' . date('Y-m-d', strtotime($year->end_date)) . '\') as total_students,a.price_per_student,b.id as client_id from admin.all_setting a left join admin.clients b on b."username"=a."schema_name"');
        foreach ($nonclients as $client) {
            if ((int) $client->client_id > 0) {

                $invoice_status = Invoice::where('client_id', $client->client_id)->where('account_year_id', $account_year_id)->first();
                $reference = 'SASA11' . $year->name . $client->client_id;
                $invoice = !empty($invoice_status) ? $invoice_status : Invoice::create(['reference' => $reference, 'client_id' => $client->client_id, 'date' => 'now()', 'year' => date('Y'), 'user_id' => Auth::user()->id, 'account_year_id' => $account_year_id, 'due_date' => date('Y-m-d', strtotime('+ 30 days'))]);

                $amount = $client->total_students * $client->price_per_student;
                (int) \App\Models\InvoiceFee::where('invoice_id', $invoice->id)->count() > 0 ?
                                \App\Models\InvoiceFee::where('invoice_id', $invoice->id)->update(['amount' => $amount, 'project_id' => 1, 'item_name' => 'ShuleSoft Service Fee For ' . $client->total_students . ' Students ', 'quantity' => $client->total_students, 'unit_price' => $client->price_per_student]) :
                                \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => 1, 'item_name' => 'ShuleSoft Service Fee For ' . $client->total_students . ' Students ', 'quantity' => $client->total_students, 'unit_price' => $client->price_per_student]);
            } else {
                $client_record = \App\Models\Client::create(['name' => $client->sname, 'email' => $client->email, 'phone' => $client->phone, 'address' => $client->address, 'username' => $client->schema_name, 'created_at' => date('Y-m-d H:i:s')]);
                $reference = 'SASA11' . $year->name . $client_record->id;
                $invoice = Invoice::create(['reference' => $reference, 'client_id' => $client_record->id, 'date' => 'now()', 'year' => date('Y'), 'user_id' => Auth::user()->id, 'account_year_id' => $account_year_id, 'due_date' => date('Y-m-d', strtotime('+ 30 days'))]);
                $amount = $client->total_students * $client->price_per_student;
                \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => 1, 'item_name' => 'ShuleSoft Service Fee For ' . $client->total_students . ' Students ', 'quantity' => $client->total_students, 'unit_price' => $client->price_per_student]);
            }
        }
    }

    
    public function project() {
        $this->data['projects'] = Project::all();
        return view('account.project', $this->data);
    }


    public function sendInvoice() {
        $invoice = Invoice::find(request('invoice_id'));
        $message = request('message');
        $email = request('email');
        $client = \App\Models\Client::where('email',$email)->first();
        if(empty($client)){
         $client = \App\Models\Client::where('email',$invoice->client->email)->first();
        }
        $search  = array("#name","#amount","#invoice");
        $replace = array($client->name, $invoice->invoiceFees()->sum('amount'), $invoice->reference);
        $newmessage = str_replace($search, $replace, $message);
        
        $arr = [
            'amount' => $invoice->invoiceFees()->sum('amount'),
            'schema_name' => $invoice->client->username,
            'user_id' => Auth::user()->id,
            'date' => date('Y-m-d'),
            'email' => request('email'),
            'phone_number' => request('phone_number'),
            'message' => $newmessage,
            'student' => $invoice->client->estimated_students
        ];
        \App\Models\InvoiceSent::create($arr);

        $invoice_task = [
            "activity" => 'Invoice sent to '.$invoice->client->name,
            "task_type_id" => "9",
            "to_user_id" => Auth::user()->id,
            "status" => "complete",
            "client_id" => $invoice->client->id,
            "user_id" => Auth::user()->id,
            "start_date" => date('Y-m-d H:i:s'),
            "end_date" => date('Y-m-d H:i:s')
        ];
        $task = \App\Models\Task::create($invoice_task);

        //tasks_users table
         if ((int) Auth::user()->id > 0) {
             DB::table('tasks_users')->insert([
                 'task_id' => $task->id,
                 'user_id' => Auth::user()->id 
             ]);
           }

        //task_clients table
        DB::table('tasks_clients')->insert([
            'task_id' => $task->id,
            'client_id' => (int) $invoice->client->id
        ]);

        //modules_task table
        if (!empty($task->id)) {
            $array = [
                'module_id' => 15,
                'task_id' => (int) $task->id
            ];
            \App\Models\ModuleTask::create($array);
        }
        
        //detect if #invoice have been set, then ensure you have
        //selcom control number and put it there
        //generate a random link and include it in the email and 
        //in the sms
        if (preg_match('/invoice/i', $message)) {
            $this->createSelcomControlNumber(request('invoice_id'));
            $invoice = Invoice::find(request('invoice_id'));
        }
        $replacements = array(
            $invoice->client->name, money($invoice->invoiceFees()->sum('amount') - $invoice->payments()->sum('amount')), $invoice->token
        );
        $sms = preg_replace(array(
            '/#name/i', '/#amount/i', '/#invoice/i'
                ), $replacements, $message);

        if (preg_match('/#/', $sms)) {
            //try to replace that character
            $sms = preg_replace('/\#[a-zA-Z]+/i', '', $sms);
        }

        $button = '<p align="center"><a style="padding:8px 16px;color:#ffffff;white-space:nowrap;font-weight:500;display:inline-block;text-decoration:none;border-color:#0073b1;background-color:green;border-radius:2px;border-width:1px;border-style:solid;margin-bottom:4px" href="' . url('epayment/i/' . $invoice->id) . '" target="_blank">Click to View Your Invoice</a></p>';

        $this->send_sms(validate_phone_number(request('phone_number'))[1], $sms . '. Open ' . url('epayment/i/' . $invoice->id) . ' to view Invoice');
        $this->send_email(request('email'), 'ShuleSoft Invoice of Service', nl2br($sms) . '<br/><br/>' . $button);
        return redirect()->back()->with('success', 'Sent successfully');
    }

    public function editShuleSoftInvoice() {
        $invoice_id = request()->segment(3);
        $invoice = Invoice::find($invoice_id);
        $date = date("Y-m-d H:i:s");
        $invoice->update(['due_date' => date('d M Y', strtotime(request('due_date')))]);
        $client = \App\Models\Client::find($invoice->client_id);
        $client->update(['price_per_student' => request('price_per_student'), 'estimated_students' => request('estimated_students')]);

        // if ((int) request('price_per_student') == 10000) {
        //     $months_remains = 12 - (int) date('m', strtotime(request('onboard_date'))) + 1;
        //     $unit_price = $months_remains * request('price_per_student') / 12;
        //     $amount = $unit_price * request('estimated_students');
        // } else {
            $unit_price = request('price_per_student');
            $amount = $unit_price * request('estimated_students');
       // }

        if (date('Y', strtotime($client->created_at)) == 1970) {
            $client->update([
                'created_at' => date('Y-m-d', strtotime(request('onboard_date')))]);
        }
        \App\Models\InvoiceFee::where('invoice_id', $invoice->id)->where('project_id', 1)->update(['amount' => $amount, 'quantity' => $client->estimated_students, 'unit_price' => $unit_price]);
        return redirect(url('account/invoice'))->with('success', 'success');
    }

    public function createShuleSoftInvoice() {
        $client_id = request()->segment(3);
        // $startdate = request('start_date');
        // $enddate = request('end_date');
        $client = \App\Models\Client::find($client_id);
        $year = \App\Models\AccountYear::where('name', date('Y'))->first();
        $reference = time(); // to be changed for selcom ID
       
        if (empty($client->start_usage_date)) {
            //If start usage date 
            return redirect()->back()->with('error', 'You must specify '.$client->username.' start usage date !');
        }
        
        $data = ['reference' => $reference, 
                 'client_id' => $client_id, 
                 'date' => $client->invoice_start_date, 
                 'due_date' => $client->invoice_end_date, 
                 'year' => date('Y'), 
                 'user_id' => Auth::user()->id, 
                 'account_year_id' => $year->id];
        $invoice = Invoice::create($data);
        //once we introduce packages (module pricing), we will just loop here for modules selected by specific user
        //validate for simple missing inputs
        if ((int) $client->price_per_student == 0 || (int) $client->estimated_students == 0) {
            //both price per students and Estimated students cannot be 0
            return redirect()->back()->with('error', 'Both price per students and Estimated students cannot be 0, please set them first');
        }
        // if ((int) $client->price_per_student == 10000) {
        //     $months_remains = 12 - (int) date('m', strtotime($client->created_at)) + 1;
        //     $unit_price = $months_remains * $client->price_per_student / 12;
        //     $amount = $unit_price * $client->estimated_students;
        // } else {
            $unit_price = $client->price_per_student;
            $amount = $unit_price * $client->estimated_students;
           // dd($amount);
        //}
        \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => 1, 'item_name' => 'ShuleSoft Service Fee', 'quantity' => $client->estimated_students, 'unit_price' => $unit_price]);
        return redirect()->back()->with('success', 'Invoice Created Successfully');
    }

    public function createInvoice() {
        $this->data['projects'] = Project::all();
        if (request('noexcel')) {
            $data = request('users');
            $client_id = request('client_id');
            $client_record = \App\Models\Client::find($client_id);
            if (request('project_id') == 1) {
                $user_invoice = [];
                $reference = 'SASA11' . date('Y') . $client_record->id . rand(10, 100);
            } else {
                $user_invoice = Invoice::where('client_id', $client_id)->first();
                $reference = 'SASA11' . date('Y') . $client_record->id;
            }
            $this->data["payment_types"] = \App\Models\PaymentType::all();
            if (empty($user_invoice)) {
                $invoice = Invoice::create(['reference' => $reference, 'client_id' => $client_record->id, 'date' => date('d M Y', strtotime(request('date'))), 'due_date' => date('d M Y', strtotime(' +30 day')), 'year' => date('Y', strtotime(request('date'))), 'sync', 'user_id' => Auth::user()->id]);
                foreach ($data as $value) {
                    //check if this user has invoice already 
                    $project = Project::where('name', 'ílike', $value['project'])->first();
                    $amount = (float) $value['quantity'] * (float) $value['unit_price'];
                    \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => !empty($project) ? $project->id : request('project_id'), 'item_name' => $value['name'], 'quantity' => (int) $value['quantity'], 'unit_price' => (float) $value['unit_price']]);
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
            \App\Models\Client::where('id', $client->id)->update(['created_at' => date("Y-m-d H:i:s")]);
            foreach (request('project_ids') as $project_id) {
                \App\Models\ClientProject::create(['project_id' => $project_id, 'client_id' => $client->id]);
            }
            return redirect(url('account/client'))->with('success', 'success');
        }
        return view('account.client.create', $this->data);
    }

    public function payment() {
        $id = request()->segment(3);
        $this->data['invoice'] = Invoice::find($id);
        $this->data["payment_types"] = \App\Models\PaymentType::all();
        $this->data['banks'] = \App\Models\BankAccount::all();
        if ($_POST) {
            return $this->addPayment($id);
        }
        $this->data["category"] = DB::table('refer_expense')->whereIn('financial_category_id', [1])->get();
        return view('account.invoice.payment', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addPayment($id) {
        $invoice = Invoice::find($id);
   
        if (!empty($invoice)) {
                // This is when a bank return payment status to us
                //save it in the database
            $this->validate(request(), ['amount' => 'required|numeric', 'payment_type' => 'required', 'date' => 'required']);
            $transaction_id = (int) request('transaction_id') == 0 ? time() : request('transaction_id');
            $payments = \App\Models\Payment::where('transaction_id', $transaction_id)->first();
            if (!empty($payments)) {
                $data = array(
                    'status' => 1,
                    'success' => 0,
                    'reference' => $invoice->reference,
                    'description' => 'Transaction ID has been used already to commit transaction'
                );
                die(json_encode($data));
            }
            $am = $invoice->invoiceFees()->sum('amount');
            $paid = $invoice->payments()->sum('amount');
            $unpaid = $am - $paid;
            $advanced_amount = 0;
            $amount = request('amount');
            $mobile_transaction_id = request('mobile_transaction_id');
           // dd($mobile_transaction_id);
            if (request('amount') > $unpaid) {
                $advanced_amount = request('amount') - $unpaid;
                $amount = $unpaid;
                //return redirect()->back()->with('error', 'Payment not accepted. Amount paid is greater than amount required');
            }
            $refer_expense_id = request('refer_expense_id');
            $payment_type = \App\Models\PaymentType::find(request('payment_type'));
            $payment = $this->acceptPayment($amount, $invoice->id, $payment_type->name, $transaction_id, $mobile_transaction_id, request('name'), request('bank_account_id'), request('transaction_time'), request('token'), $invoice->client_id, $refer_expense_id, request('date'));
            if ((int) $advanced_amount > 0) {
                DB::table('admin.advance_payments')->insert([
                    'client_id' => $invoice->client_id,
                    'payment_id' => json_decode($payment)->payment_id,
                    'amount' => $advanced_amount
                ]);
            }
        }
        // $this->sendNotification($invoice);
        // if(request('status') == 1){
        // }
        return redirect('account/invoice/1/' . $invoice->account_year_id)->with('success', json_decode($payment)->description);
    }

    public function acceptPayment($amount, $invoice_id, $payment_method, $receipt, $mobile_transaction_id, $customer_name, $bank_account_id, $timestamp, $token, $client_id, $refer_expense_id, $date = null) {
        //$financial_id = count($this->api_info) == 1 ? $this->api_info->financial_entity_id : \App\Model\Financial_entity::where('name', request('method'))->first()->id;
        $payment_array = array(
            'client_id' => $client_id,
            "invoice_id" => $invoice_id,
            "amount" => $amount,
            "method" => $payment_method,
            "transaction_id" => $receipt,
            "mobile_transaction_id" => $mobile_transaction_id,
            'bank_account_id' => $bank_account_id,
            'note' => $customer_name,
            'transaction_time' => $timestamp,
            'token' => $token,
            'date' => date('Y-m-d', strtotime($date)),
        // 'financial_entity_id' => $financial_id,
        //  special case for CRDB payments only
        // 'checksum' => request('checksum'),
        // 'payment_type_id' => request('payment_type'),
       //  'amount_type' => request('amountType'),
       //   'currency' => request('currency')
        );

        $payment_id = DB::table('admin.payments')->insertGetId($payment_array);
        $client = DB::table('admin.clients')->where('id', $client_id)->first();

        $data = [
            'payer_name' => $client->name,
            'payer_phone' => $client->phone,
            'payer_email' => $client->name,
            'created_by_id' => $payment_id,
            'amount' => $amount,
            "refer_expense_id" => $refer_expense_id,
            "bank_account_id" => $bank_account_id,
            'payment_method' => $payment_method,
            'transaction_id' => $receipt,
            'date' => 'now()',
            'note' => ''
        ];
        // \App\Models\Revenue::create($data);
        $invoice_fee = \App\Models\InvoiceFee::where('invoice_id', $invoice_id);
        $status = 1;

        $invoice_fee_ids = $invoice_fee->get();
        foreach ($invoice_fee_ids as $invoice_fee_data) {
            if ($invoice_fee_data->status <> 1 && $amount > 0) {
                if ($amount >= $invoice_fee_data->amount) {
                    $status = 1;
                    \App\Models\InvoiceFeesPayment::create([
                        'invoice_fee_id' => $invoice_fee_data->id,
                        'payment_id' => $payment_id,
                        'paid_amount' => $invoice_fee_data->amount,
                        'status' => $status
                    ]);
                    $amount = $amount - $invoice_fee_data->amount;
                } else {
                    //amount is less than invoice paid amount
                    $status = 2;
                    \App\Models\InvoiceFeesPayment::create([
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
        $budget_rations = DB::table('budget_ratios')->where('project_id', $invoice_fee->first()->project_id)->get();
        foreach ($budget_rations as $ratio) {
            DB::table('payments_budget_ratios')->insert([
                'budget_ratio_id' => $ratio->id,
                'payment_id' => $payment_id,
                'amount' => $ratio->percent * request('amount') / 100
            ]);
        }
        if ($status == 1) {
            //amount has been paid correctly to more than one id so the returned id should be changed.
            return json_encode(array('control' => 1, 'description' => 'Invoice fully paid', 'payment_id' => $payment_id));
        } else if ($status == 2) {
            return json_encode(array('control' => 2, 'description' => 'Invoice partially paid', 'payment_id' => $payment_id));
        } else {
            return json_encode(array('control' => 3, 'description' => 'Invoice is paid amount more than invoiced amount', 'payment_id' => $payment_id));
        }
        // $amount > 0 ? \App\Model\Wallet::create(['user_id' => $invoice->user_id, 'amount' => $amount, 'invoice_id' => $invoice_id, 'status' => 1]) : '';
        // return $this->paymentBalance($payment_id, $status);
        //return redirect(url('invoiceView/' . $invoice->id))->with('success', 'success');
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


    public function receipts() {
        $id = request()->segment(3);
        if ((int) $id > 0) {
            $this->data['invoice'] = Invoice::find($id);
            return view('account.transaction.receipt_sort', $this->data);
        } else {
            return redirect()->back()->with('error', 'Sorry ! Something is wrong try again!!');
        }
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

    public function transaction() {
        $this->data['id'] = $id = request()->segment(3);
        if ((int) $id) {
            if ($_POST) {
                $from_date = request("from_date");
                $to_date = request("to_date");
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
        switch ($id) {
            case 1:
                $result = \App\Models\ReferExpense::whereBetween('created_at', [$from_date, $to_date])->where('financial_category_id', 4)->orderBy('created_at', 'desc')->get();
                break;
            case 2:
                $result = \App\Models\ReferExpense::whereBetween('created_at', [$from_date, $to_date])->where('financial_category_id', 6)->orderBy('created_at', 'desc')->get();
                break;
            case 3:
                $result = \App\Models\ReferExpense::whereBetween('created_at', [$from_date, $to_date])->where('financial_category_id', 7)->orderBy('created_at', 'desc')->get();
                break;
            case 4:
                $result = \App\Models\ReferExpense::whereBetween('created_at', [$from_date, $to_date])->whereIn('financial_category_id', [2, 3])->orderBy('created_at', 'desc')->get();
                break;
            case 5:
                $result = \App\Models\ReferExpense::whereBetween('created_at', [$from_date, $to_date])->where('financial_category_id', 5)->orderBy('created_at', 'desc')->get();
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
        $this->data["category"] = $this->getCategories($id);
      //$this->data["category"] = DB::table('refer_expense')->whereIn('financial_category_id', [2, 3])->get();
        $this->data['id'] = $id;
        $this->data['check_id'] = $id;
        $this->data['sub_id'] = request()->segment(4);
        $this->data['banks'] = \App\Models\BankAccount::all();
        $this->data["payment_types"] = \App\Models\PaymentType::all();
        $this->data['transaction_id'] = $transaction_id = time() . rand(10 * 45, 100 * 98);
        if($_POST) {
            $insert_id = 0;
            $depreciation = (float) request("depreciation") > 0 ? (float) request("depreciation") : (float) request("dep");
            // $type=request("type");
            if ($id == 2 || $id == 5) {
                $amount = request("type") == 1 ? remove_comma(request("amount")) : -remove_comma(request("amount"));
            } else {
                $amount = remove_comma(request("amount"));
            }
            if ($id == !5) {
                $refer_expense_id = request("expense");
                $refer_expense_name = \App\Models\ReferExpense::find($refer_expense_id)->name;
                if (strtolower($refer_expense_name) == 'depreciation') {
                 return redirect()->back()->with('error', 'Sorry ! Depreciation is added through fixed assets');
                }
            }
            $transaction = \App\Models\Expense::where('transaction_id', request("transaction_id"))->count();
            if ($transaction > 0) {
                return redirect()->back()->with('error', 'Sorry ! Transaction ID already exists');
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
                'expense_subcategories_id' => request('expense_subcategories_id'),
                "expense" => request("note"),
                "depreciation" => $depreciation,
                'user_id' => Auth::user()->id,
                "bank_account_id" => request("bank_account_id"),
                "amount" => $amount,
            ); 

            if ($id == 4 || $id == 1) {
                $voucher_no = DB::table('expenses')->max('voucher_no');
                if ((int) request('user_in_shulesoft') == 1) {
                    $user = \App\Models\User::findOrFail(request('user_id'));
                    $obj = array_merge($array, [
                        'recipient' => $user->firstname . ' ' . $user->lastname,
                        'voucher_no' => $voucher_no + 1,
                        'payer_name' => $payer_name,
                    ]);             
                    //dd($obj); 
                    $insert_id = DB::table('expenses')->insertGetId($obj);
                  } else {
                    $obj = array_merge($array, [
                        'recipient' => request('payer_name'),
                        'voucher_no' => $voucher_no + 1,
                        'payer_name' => $payer_name,
                    ]);
                    DB::table('expenses')->insert($obj);
                } 
               // return redirect( url('account/transaction/' . $id))->with('success', 'success');
                return redirect( url("account/transaction/$id"))->with('success', 'success');
            } else if ($id == 5) {
                $voucher_no = DB::table('current_assets')->max('voucher_no');
                $array = array(
                    "date" => request('date'),
                    "note" => request("note"),
                    "from_refer_expense_id" => request("from_expense"),
                    "to_refer_expense_id" => request("to_expense"),
                    'userID' => request('id'),
                    'uname' => request('username'),
                    "amount" => remove_comma(request('amount')),
                    'voucher_no' => $voucher_no + 1,
                   // "transaction_id" => request("transaction_id"),
                   // 'usertype' => session('usertype')
                    'created_by' => Auth::user()->id
                );

                 

                if (request("from_expense") == request("to_expense")) {
                    return redirect()->back()->with('error', 'You can not transfer to the same account');
                }
                $refer_expense = \App\Models\ReferExpense::find(request("from_expense"));
               
                $total_amount = 0;
                if ((int) $refer_expense->predefined && $refer_expense->predefined > 0) {
                    $total_bank = \collect(DB::SELECT('SELECT sum(coalesce(amount,0)) as total_bank from admin. bank_transactions WHERE bank_account_id=' . $refer_expense->predefined . ' and payment_type_id <> 1 '))->first();

                    $total_current_assets = \collect(DB::SELECT('SELECT sum(coalesce(amount,0)) as total_current from admin. current_asset_transactions WHERE refer_expense_id=' . $refer_expense->predefined . ''))->first();
                    $total_amount = $total_bank->total_bank + $total_current_assets->total_current;
                } else if (strtoupper($refer_expense->name) == 'CASH') {
                    $total_cash_transaction = \collect(DB::SELECT('SELECT sum(coalesce(amount,0)) as total_cash from admin. bank_transactions WHERE  payment_type_id =1'))->first();
                    $total_current_assets_cash = \collect(DB::SELECT('select sum(coalesce(amount,0)) as amount from bank_transactions where payment_type_id=1 '))->first();
                    $total_amount = $total_cash_transaction->total_cash + $total_current_assets_cash->amount;
                }

                if (-$amount < $total_amount) {
                    return redirect()->back()->with('warning','No enough credit to transfer');
                }
                     
                if (request('user_in_shulesoft') == 1) {
                    $user_request = explode(',', request('user_id'));
                  
                    $user = \App\Models\User::where('id', $user_request)->first();
                   
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
                return redirect(url("account/transaction/$id"))->with('success', 'success');
                // return redirect()->back()->with('success','Success');
            } else {
                $obj = array_merge($array, [
                    'amount' => remove_comma(request('amount')),
                ]); 
                $insert_id = DB::table('expenses')->insertGetId($obj);
                $type = (int) $insert_id ? 'success' : 'error';
             
                return redirect()->back()->with($type, $type);
            }
        }
             if($id == 5) {
             $this->data["subview"] = "account.transaction.add_current_asset";
             } else {
             $this->data["subview"] = "account.transaction.create_trans";
           }
        return view($this->data["subview"], $this->data);
    }


        
    // function uploadByFile($account_data = null) {
    //     if (!empty($_POST)) {
    //         $data = $account_data == 'expense' || $account_data == null ? $this->uploadExcel() : $account_data;
    //         $status = $this->checkKeysExists($data);
    //         if ((int) $status == 1) {
    //             foreach ($data as $value_array) {
    //                 $call_array = new \App\Http\Controllers\Student();
    //                 $value = $call_array->modify_keys_to_upper_and_underscore($value_array);
    //                 $bank = \App\Models\BankAccount::where('number', $value['account_number'])->first();
    //                 $refer_expense = \App\Models\ReferExpense::where('name', $value['expense_name'])->first();
    //                 if (empty($refer_expense)) {
    //                     $status .= '<p class="alert alert-danger">Expense not defined. This expense name <b>' . $value['expense_name'] . '</b> must be defined first in charts of account. This record skipped to be uploaded</p>';
    //                 } else {
    //                     $dor = str_replace('/', '-', $value['date']);
    //                     $array = array(
    //                         "create_date" => date("Y-m-d"),
    //                         "date" => date("Y-m-d", strtotime($dor)),
    //                         "amount" => $value['amount'],
    //                         "note" => isset($value["note"]) ? $value["note"] : 0,
    //                         "ref_no" => isset($value["transaction_id"]) ? $value["transaction_id"] : 0,
    //                         "payment_method" => isset($value["payment_method"]) ? $value["payment_method"] : 0,
    //                         "bank_account_id" => !empty($bank) ? $bank->id : NULL,
    //                         "transaction_id" => $value["transaction_id"],
    //                         "refer_expense_id" => $refer_expense->id,
    //                         "expenseyear" => date("Y"),
    //                         "expense" => isset($value["note"]) ? $value["note"] : 0,
    //                         "depreciation" => isset($value["depreciation"]) ? $value["depreciation"] : 0,
    //                         'userID' => Auth::user()->id,
    //                         'uname' => Auth::user()->name,
    //                         // 'usertype' => session('usertype'),
    //                         // 'created_by' => $this->createdBy()
    //                     );
    //                     $expense = \App\Models\Expense::create($array);
    //                     $status .= '<p class="alert alert-success">Expense for ' . $expense->expense . ' added successfully</p>';
    //                 }
    //             }
    //         }
    //     }
    //     if ($account_data == null || $account_data == 'expense') {
    //         $this->data['status'] = $status;
    //         $this->data["subview"] = "mark/upload_status";
    //         $this->load->view('_layout_main', $this->data);
    //     } else {
    //         return '<b> Expense:</b> ' . $status;
    //     }
    // }

    public function bank() {
        $this->data['bankaccounts'] = \App\Models\BankAccount::latest()->get();
        return view('account.bank.index', $this->data);
    }


    function reconciliation() {
        $this->data['payments'] = array();
        $this->data['set'] = '';
        $this->data['banks'] = \App\Models\BankAccount::latest()->get();
        if ($_POST) {
            $to = date('Y-m-d', strtotime(request("to")));
            $from = date('Y-m-d', strtotime(request("from")));
            $this->data['bank_id'] = $bank_account_id = request('bank_account_id');
            if (request('method') == 'received') {
                $table = 'total_revenues';
            } else if (request('method') == 'expense') {
                $table = 'total_expenses';
            } else {
                $table = 'all_transactions';
            }
            $this->data['table'] = $table;
            $payments = DB::table($table)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to);
            $this->data['bank_info'] = (int) $bank_account_id == 0 ? 'All' : \App\Models\BankAccount::find($bank_account_id);
            $this->data['payments'] = (int) $bank_account_id == 0 ?
                    $payments->get() :
                    $payments->where('bank_account_id', request('bank_account_id'))->get();
        }
        return view('payment.reconciliation', $this->data);
    }


    function reconcile() {
        $payment_id = request('id');
        $type = request('type');
        $table = request('table');
        if ($table == 'total_expenses') {
            $payment = \App\Models\Expense::find($payment_id);
            !empty($payment) ? $payment->update(['reconciled' => 1]) : '';
        } else {
            $payment = $type == 1 ? \App\Models\Payment::find($payment_id) : \App\Models\Revenue::find($payment_id);
            !empty($payment) ? $payment->update(['reconciled' => 1]) : '';
        }
        echo 'success';
    }

    function unreconcile() {
        $payment_id = request('id');
        $type = request('type');
        $payment = $type == 1 ? \App\Models\Payment::find($payment_id) : \App\Models\Revenue::find($payment_id);
        $payment->reconciled = 0;
        $payment->save();
        echo 'success';
    }

    public function groups() {
        $this->data['id'] = null;
        $this->data['groups'] = \App\Models\AccountGroup::latest()->get();
        $this->data["category"] = \App\Models\FinancialCategory::latest()->get();
        $tag = request()->segment(3);
        $id = request()->segment(4);
        if ($tag == 'delete') {
            \App\Models\AccountGroup::find($id)->delete();
            return redirect()->back()->with('success', 'success deleted!');
        } else if ($tag == 'edit') {
            
        }
        if ($_POST) {
            (int) request('group_id') == 0 ?
                            \App\Models\AccountGroup::create(request()->all()) :
                            \App\Models\AccountGroup::find(request('group_id'))->update(request()->all());
            return redirect()->back()->with('success', 'success');
        }
        return view('account.group', $this->data);
    }

    public function chart() {
        $this->data['set'] = 0;
        $this->data['id'] = 0;
        $this->data['expenses'] = ReferExpense::all();
        $this->data["subview"] = "expense/charts_of_accounts";
        $this->data["category"] = \App\Models\FinancialCategory::all();
        $this->data['groups'] = \App\Models\AccountGroup::all();
        $tag = request()->segment(3);
        $id = request()->segment(4);
        if ($tag == 'delete') {
            ReferExpense::find($id)->delete();
            return redirect()->back()->with('success', 'success');
        }
        if ($_POST) {
            $this->validate(request(), [
                "subcategory" => "required|regex:/(^([a-zA-Z,. ]+)(\d+)?$)/u",
                "code" => (int) request('expense_id') == 0 ? "regex:/(^[ A-Za-z0-9_@.#&+-]*$)/u|required|unique:refer_expense,code" : 'required',
                'financial_category_id' => 'numeric|min:1'
            ]);
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
                "status" => 1
            );

            (int) request('expense_id') == 0 ? ReferExpense::create($array) :
                            ReferExpense::find(request('expense_id'))->update($array);
            return redirect()->back()->with('success', 'success');
        }
        return view('account.charts', $this->data);
    }

    public function checkCategory() {
        $group_id = request('financial_category_id');
        $groups = \App\Models\AccountGroup::where('financial_category_id', $group_id)->get();
        echo '<select  name="account_group_id" class="form-control">';
        echo '<option  value=""></option>';
        foreach ($groups as $group) {
            echo '<option  value="' . $group->id . '">' . $group->name . '</option>';
        }
        echo '</select>';
    }

    public function report() {
        $this->data['set'] = 0;
        $this->data['id'] = 0;
        $this->data['expenses'] = ReferExpense::all();
        return view('account.report.index', $this->data);
    }


    function createDate($date, $format = 'm-d-Y', $return = 'Y-m-d') {
        return date('Y-m-d', strtotime($date));
    }

    public function view_expense() {
        $id = request()->segment(3);
        $refer_id = request()->segment(4);
        $bank_id = request()->segment(5);
       
        $year = \App\Models\AccountYear::orderBy('start_date', 'asc')->first();
        $account_year = empty($year) ? \App\Models\AccountYear::create(['name' => date('Y'), 'status' => 1, 'start_date' => date('Y-01-01'), 'end_date' => date('Y-12-31')]) : $year;
        $from_date = $account_year->start_date;
        $to_date = date('Y-m-d');
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
                $this->data['expenses'] = DB::SELECT('SELECT * from admin.bank_transactions WHERE  payment_type_id =1 and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . '');
                $this->data['current_assets'] = DB::SELECT('SELECT * from admin.current_asset_transactions WHERE refer_expense_id=' . $id . ' and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . ' ');
            }
            if (strtoupper($refer_expense->name) == 'ACCOUNT RECEIVABLE') {
                $this->data['expenses'] = array();
                $this->data['current_assets'] = DB::SELECT('SELECT * from admin. current_asset_transactions WHERE refer_expense_id=' . $id . ' and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . ' ');
               // $this->data['fees'] = DB::select('select sum(a.balance + coalesce((c.amount-c.due_paid_amount),0)) as total_amount,b.name from admin. invoice_balances a join admin. student b on b.student_id=a.student_id LEFT JOIN admin. dues_balance c on c.student_id=b.student_id WHERE  a.balance <> 0.00 AND a."created_at" between \'' . $from_date . '\' AND \'' . $to_date . '\' group by b.name');
                $this->data['bank_opening_balance'] = \collect(DB::select('select sum(coalesce(opening_balance,0)) as opening_balance from admin. bank_accounts'))->first();
            } else if ((int) $bank_id) {
                $this->data['expenses'] = DB::SELECT('SELECT transaction_id,date,amount,' . "'Bank'" . ' as payment_method , note from admin. bank_transactions WHERE bank_account_id=' . $bank_id . ' and payment_type_id <> 1 and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . 'order by date desc');
                $this->data['current_assets'] = DB::SELECT('SELECT * from admin. current_asset_transactions WHERE refer_expense_id=' . $id . ' and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . 'order by date desc');
            } else {  
                $this->data['expenses'] = array();
                $this->data['current_assets'] = DB::SELECT('SELECT * from admin.current_asset_transactions WHERE refer_expense_id=' . $id . ' and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . ' ');
            }
        } else if (preg_match('/EC-1001/', $refer_expense->code) && $id = 4 && (int) $refer_expense->predefined > 0) {
            $sql = 'select sum(b.employer_amount) as amount ,payment_date as date,\'' . $refer_expense->name . '\' as note,\' ' . $refer_expense->name . '\' as name, \'Payroll\' as payment_method,null as "expenseID",extract(month from payment_date)||\'\'||extract(year from payment_date) as ref_no, 1 AS predefined, null as id  from admin.salaries a join admin.salary_pensions b on a.id=b.salary_id where b.pension_id=' . $refer_expense->predefined . '  group by a.payment_date UNION ALL (SELECT a.amount, a.date, a.note, b.name, a.payment_method, a."expenseID", a.ref_no, null as predefined, b.id FROM admin.expenses a JOIN admin.refer_expense b ON a.refer_expense_id=b.id WHERE b.id=' . $refer_expense->id . ' ORDER BY a.date DESC)';
            $this->data['expenses'] = DB::SELECT($sql);
        } else if (strtoupper($refer_expense->name) == 'DEPRECIATION') {
            $this->data['expenses'] = DB::select('select coalesce(sum(b.open_balance::numeric * b.depreciation*(\'' . $to_date . '\'::date-a.date::date)/365),0) as open_balance,sum(amount-amount* a.depreciation *(\'' . $to_date . '\'::date-a.date::date)/365) as total,sum(amount* a.depreciation*(\'' . $to_date . '\'::date-a.date::date)/365) as amount, refer_expense_id,a.date,a.note,a.recipient,b.name,a."expenseID",b.predefined from admin.expenses a join admin.refer_expense b  on b.id=a.refer_expense_id where b.financial_category_id=4 AND  a.date  <= \'' . $to_date . '\' group by a.refer_expense_id,b.open_balance,a.date,a.note,b.name,a."expenseID",b.predefined  ORDER BY a.date desc');
             $this->data['depreciation'] = 1;
        } else {
           // $this->data['expenses'] = DB::SELECT('SELECT b.*,a.* FROM admin.expenses a JOIN admin.refer_expense b ON a.refer_expense_id=b.id WHERE b.id=' . $id . ' and a."date" >= ' . "'$from_date'" . ' AND a."date" <= ' . "'$to_date'" . ' ');
            $this->data['expenses'] = \App\Models\ReferExpense::where('refer_expense.id', $id)
            ->join('expenses', 'expenses.refer_expense_id', 'refer_expense.id')
            ->select('payment_types.name as payment_method', 'expenses.recipient as recipient', 'expenses.date', 'expenses.amount', 'expenses.note', 'expenses.transaction_id', 'expenses.id', 'refer_expense.predefined')->leftJoin('payment_types', 'payment_types.id', 'expenses.payment_type_id')
            ->where('expenses.date', '>=', $from_date)->where('expenses.date', '<=', $to_date)->get();
         // dd($this->data['expenses']);
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
                    "ref_no" => request("transaction_id")
                   // 'recipient' => request('recipient')
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
        } else if ($id == 'delete') {
            \App\Models\Expense::find($expense_id)->delete();
            return redirect()->back()->with('success', 'success');
        } else if ($id == 'voucher') {
            return $this->voucher();
        } else {
            echo 'page not found';
        }
    }

    public function voucher() {
        $id = request()->segment(4);
        $cat_id = request()->segment(5);
        if ($cat_id == 5) {
            $this->data['voucher'] = \collect(DB::SELECT('SELECT * from admin. current_assets WHERE id=' . $id . ''))->first();
        } else {
            $this->data['voucher'] = \App\Models\Expense::find($id);
        }
        return view('account.transaction.voucher', $this->data);
    }

    public function payment_history() {
        $this->data['voucher'] = [];
        return view('account.report.payment_history', $this->data);
    }

  

    public function uploadExpense() {
        if ($_POST) {
            $address = request()->file('file');
          
            $results = Excel::load($address)->all();
            dd($results);
            //once we upload excel, register students and marks in mark_info table
            $status = '';
            foreach ($results as $value) {
                $check = $this->checkKeysExists($value, ['amount', 'transaction_id', 'account_number', 'payment_method', 'expense_name', 'date', 'user_in_shulesoft', 'payer_name']);
                if ((int) $check <> 1) {
                    return redirect()->back()->with('error', $check);
                }
                $refer_expense = \App\Models\ReferExpense::where(DB::raw('lower(name)'), strtolower($value['expense_name']))->first();
                if (empty($refer_expense)) {
                    $status .= '<p class="alert alert-danger">Revenue not defined. This expense name <b>' . $value['expense_name'] . '</b> must be defined first in charts of account. This record skipped to be uploaded</p>';
                    continue;
                }
                $check_unique = \App\Models\Expense::where('transaction_id', $value['transaction_id'])->first();
                if (!empty($check_unique)) {
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
                    'note' => $value['note'],
                    'ref_no' => $value['transaction_id'],
                    "expenseyear" => date("Y", strtotime($value['date'])),
                    "expense" => $value['note'],
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
                        'ref_no' => $value['transaction_id'],
                        'date' => date("Y-m-d", strtotime($value['date'])),
                        "expenseyear" => date("Y", strtotime($value['date'])),
                        "expense" => $value['note'],
                        'note' => $value['note']
                    ];
                }

                \App\Models\Expense::create($data);
            }
            return redirect('account/transaction/4')->with('success', $status);
        }
    }

    private function checkKeysExists($value, $keys_array = null) {

        $required = $keys_array;
        $msg = '';
        foreach ($required as $key) {
            if (!isset($value[$key])) {
                $msg .= $key . ', ';
            }
        }
        return $msg == '' ? 1 : 'Column ' . $msg . ' are missing from Excel file. Please Ensure an excel file has all basic fields';
    }

    public function uploadPayments() {
        if ($_POST) {
            $address = request()->file('file');
            $results = Excel::load($address)->all();
            //once we upload excel, register students and marks in mark_info table
            $status = '';

            foreach ($results as $value) {

                $check = $this->checkKeysExists($value, ['amount', 'invoice', 'email', 'transaction_id', 'account_number', 'payment_method', 'revenue_name', 'date']);
                if ((int) $check <> 1) {
                    return redirect()->back()->with('error', $check);
                }
                $invoice = Invoice::where(DB::raw('lower(reference)'), strtolower($value['invoice']))->first();
                if (empty($invoice)) {
                    //create invoice

                    $client = \App\Models\Client::where('email', strtolower($value['email']))->first();

                    $client_record = empty($client) ?
                            \App\Models\Client::create(['name' => $value['email'], 'email' => $value['email'], 'phone' => time(), 'address' => '', 'username' => $value['email'], 'created_at' => date('Y-m-d H:i:s')]) : $client;


                    $account_year = \App\Models\AccountYear::where('start_date', '<=', date('Y-m-d', strtotime($value['date'])))->where('end_date', '>=', date('Y-m-d', strtotime($value['date'])))->first();

                    $year = !empty($account_year) ? $account_year : \App\Models\AccountYear::create(['name' => date('Y', strtotime($value['date'])), 'status' => 1, 'start_date' => date('Y-01-01', strtotime($value['date'])), 'end_date' => date('Y-12-31', strtotime($value['date']))]);
                    $invoice_id = \collect(DB::select('select max(id) as max_id from invoices limit 1'))->first();
                    $reference = 'SASA11' . ($invoice_id->max_id + 1);

                    $invoice = Invoice::create(['reference' => $reference, 'client_id' => $client_record->id, 'date' => 'now()', 'year' => date('Y'), 'user_id' => Auth::user()->id, 'account_year_id' => $year->id, 'due_date' => date('Y-m-d', strtotime('+ 30 days'))]);
                    $amount = $value['amount'];
                    $project = DB::table('projects')->where(DB::raw('lower(name)'), 'ilike', '%' . strtolower($value['revenue_name']) . '%')->first();
                    $project_id = !empty($project) ? $project->id : 1; //default shulesoft
                    \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => $project_id, 'item_name' => 'ShuleSoft Service Fee For ', 'quantity' => 1, 'unit_price' => 1]);
                }

                $transaction_id = (int) $value['transaction_id'] == 0 ? time() : $value['transaction_id'];
                $payments = \App\Models\Payment::where('transaction_id', $transaction_id)->first();
                if (!empty($payments)) {
                    $status .= '<p class="alert alert-danger">This transaction ID <b>' . $value['transaction_id'] . '</b> already being used. Information skipped</p>';
                    continue;
                }

                $mobile_transaction_id = isset($value['mobile_transaction_id']) ? $value['mobile_transaction_id'] : rand(454, 4787557);
                if ($value['amount'] > $invoice->invoiceFees()->sum('amount')) {

                    $status .= '<p class="alert alert-danger">Payment not accepted. Amount paid is greater than amount required</p>';
                    continue;
                }
                $refer_expense = \App\Models\ReferExpense::where(DB::raw('lower(name)'), 'ilike', '%' . $value['revenue_name'] . '%')->first();
                if (empty($refer_expense)) {
                    $status .= '<p class="alert alert-danger">Revenue not defined. This expense name <b>' . $value['revenue_name'] . '</b> must be defined first in charts of account. This record skipped to be uploaded</p>';
                    continue;
                }
                $check_unique = \App\Models\Revenue::where('transaction_id', $value['transaction_id'])->first();
                if (!empty($check_unique)) {
                    $status .= '<p class="alert alert-danger">This transaction ID <b>' . $value['transaction_id'] . '</b> already being used. Information skipped</p>';
                    continue;
                }
                $bank = \App\Models\BankAccount::where('number', $value['account_number'])->first();

                $v = $this->acceptPayment($value['amount'], $invoice->id, $value['payment_method'], $transaction_id, $mobile_transaction_id, isset($value['note']) ? $value['note'] : '', $bank->id, 'now()', time(), $invoice->client_id, $refer_expense->id);
                $status .= is_object(json_decode($v)) ? '<p class="alert alert-success">' . json_decode($v)->description . '/p>' : '';
            }
            return redirect('account/revenue')->with('success', $status);
        }
    }

    public function createInitialInvoice() {
        $payer_name = request('payer_name');
        $amount_to_pay = request('amount');
        $payment_method = request('payment_method');
        $inssued_date = request('inssued_date');
        $note = request('note');

        $data_to_be_inserted = [
            '' => request('payer_name'),
            '' => request('amount'),
            '' => request('payment_method'),
            '' => request('inssued_date'),
        ];
    }

    public function epayment() {
        
    }

    public function getExpenseRevenueByMonth() {
        return DB::select("with tempa as (
    select a.date,a.revenue, b.expense from 
    (
select  sum(amount) as revenue,date_trunc('month', date) as date from admin.revenues group by date_trunc('month', date) order by date_trunc('month', date) asc
    )
    as a left join 
    (
  select  sum(amount::numeric) as expense,date_trunc('month', date) as date from admin.expenses group by date_trunc('month', date) order by date_trunc('month', date) asc
    ) as b on date_trunc('month', b.date)= date_trunc('month', a.date) ),
tempb as ( select * from tempa ) 
select * from tempb");
    }

    public function customSummary() {
        $report_type = $this->data['report_type'] = request('report_type');
        $start = $this->data['from'] = request('from_date');
        $end = $this->data['to'] = request('to_date');
        
        if ((int) $report_type == 1) {
            //expenses 
            $this->data['type'] = 'Expense';
            $transactions = \App\Models\Expense::whereBetween('date', [$start, $end])->get();
        } else if ((int) $report_type == 2) {
            //payments 
            $this->data['type'] = 'Payments';
            $transactions = \App\Models\Payment::whereBetween('date', [$start, $end])->orderBy('id', 'desc')->get();
        } else {
            //revenues 
            $this->data['type'] = 'Revenues';
            $transactions = \App\Models\Revenue::whereBetween('date', [$start, $end])->get();
        }
        $this->data['transactions'] = $transactions;
        $this->data["subview"] = "fee.custom_summary";
        return view($this->data["subview"], $this->data);
      //  $this->load->view('_layout_main', $this->data);
    }

    function summary() {
        if ($_POST) {
            return $this->customSummary();
        }
        $this->data['today_amount'] = \collect(DB::select("select sum(amount) from admin.revenues where date::date='" . date('Y-m-d') . "'"))->first();
        $this->data['weekly_amount'] = \collect(DB::select("select sum(amount) from admin.revenues where date_trunc('week', date) = date_trunc('week', current_date)"))->first();
        $this->data['monthly_amount'] = \collect(DB::select("select sum(amount) from admin.revenues where date_trunc('month', date) = date_trunc('month', current_date)"))->first();
        $this->data['revenue'] = $this->getExpenseRevenueByMonth();
        $this->data['expected_amount'] = \collect(DB::select('select sum(amount) as sum from admin.invoices'))->first();
        $this->data['collected_amount'] = \collect(DB::select('select sum(amount) from admin.revenues'))->first();
        $this->data['expected_expense'] = \collect(DB::select('select sum(amount::numeric) from admin.expenses'))->first();
        ;
        $this->data['expense'] = \collect(DB::select('select sum(amount::numeric) from admin.expenses'))->first();
        $this->data['no_invoice'] = \App\Models\Invoice::count();
        $this->data['no_payments'] = 0;
        $this->data['payments_received'] = \App\Models\Payment::count();
        $this->data['revenue_received'] = \App\Models\Revenue::count();
        return view('account.report.summary', $this->data);
    }


    // List of standing orders
    public function standingOrders() {              
         $this->data['standingorders'] = \App\Models\StandingOrder::get();
         $this->data['schools'] = \App\Models\Client::get();
        return view('account.standing_order', $this->data);
    }

    // Approve standing orders
    public function approveStandingOrder() { 
        $this->data['so_id'] = $so_id = request()->segment(3);
        if(!empty($so_id)){
            \App\Models\StandingOrder::where('id', $so_id)->update(['is_approved' => 1,'approved_by' => Auth::user()->id]);
        }
        return redirect()->back()->with('success', 'Standing order approved!');
    } 



    // Confirm standing order
    public function confirmSI(){
        $this->data['so_id'] = $so_id = request()->segment(3);
        $standing = \App\Models\StandingOrder::where('id', $so_id)->first();
        $invoice = \App\Models\Invoice::where('client_id',$standing->client_id)->first();
        if(!empty($invoice)){
            return redirect('account/payment/'.$invoice->id);
        }
        //After add payment the receipt should be sent to client
    }

    // Reject standing order, specify reason send email to school associate
    public function rejectStandingOrder(){  
        $this->data['id'] = $id = request()->segment(3);
        $this->data['standing']  = $standing = \App\Models\StandingOrder::where('id',$id)->first();
        if($_POST){ 
            \App\Models\StandingOrder::where('id', $id)->update(['note' => request('reason')]);
            $client = \App\Models\Client::where('id',$standing->client_id)->first();
            $message =  request('reason');
            $this->send_email($standing->user->email,'Standing Order Rejection',$message);
            return redirect('account/standingorders')->with('success', 'Sent successful to '.$standing->user->name);
        }
        return view('account.standingorder.reject', $this->data);
    }



    public function editStandingOrder(){
        $this->data['id'] = $id = request()->segment(3);
        $this->data['order'] = \App\Models\StandingOrder::findOrFail($id);
      
        if ($_POST) {
            $order = \App\Models\StandingOrder::findOrFail($id);
            $data = ['school_contact_id' => request('school_contact_id'), 'type' => request('which_basis'),
            'occurance_amount' => remove_comma(request('occurance_amount')),'total_amount' => remove_comma(request('total_amount')),
            'payment_date' => request('maturity_date'),'refer_bank_id' => request('refer_bank_id'),'branch_id' => request('branch_id'),
            'client_id' => request('client_id'),'created_by' => Auth::user()->id,'occurrence' => request('occurrence'),'contract_type_id' => 8];
            
            $order->update($data);
                
            // if(date('Y-m-d') < date('Y-m-d',strtotime(request('maturity_date')))) {
            //     echo 'greater than';
            // }
            // $maturity_date = request('maturity_date');
            // dd($maturity_date);
             return redirect('account/standingOrders')->with('success', 'Succeessful updated');
        }
         // If maturity date is greater than today send email to accountant
          
        return view('account.standingorder.edit', $this->data);
    }


    public function budget(){
        $id = request()->segment(3);
        if ($_POST) {
            $array = [
                'created_by' => Auth::user()->id,
                'type' => request('type'),
                'amount' => request('amount'),
                'description' => request('description'),
            ];
            return redirect('users/kpi_list')->with('success', 'KPI Updated successfully');
         }

         return view('account.budget.index', $this->data);
    }

}
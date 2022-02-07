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
use PDF;
use Storage;



class Account extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->data['insight'] = $this;
    }

    public function index() {
        $this->data['users'] = [];
        return view('account.report.index', $this->data);
    }

    public function projection() {
        $this->data['invoice_type'] = $invoice_type = request()->segment(3);
        $this->data['client_id']= $client_id = request()->segment(4);
        $this->data['invoice_types'] = DB::table('constant.invoices_type')->whereNotIn('id',[3])->orderBy('id','asc')->get();
        $this->data['services'] = \App\Models\CompanyService::latest()->get();

        $this->data['schools'] = \App\Models\School::whereNotIn('id',\App\Models\ClientSchool::get(['school_id']))->get();
        $this->data['clients'] = \App\Models\Client::latest()->get();

        if($client_id > 0){
            $type = \DB::table('constant.invoices_type')->where('id', (int) $invoice_type)->first();
            if (preg_match('/proforma invoice/i', strtolower($type->name) )) {
                $this->data['client'] = \App\Models\School::where('ownership','<>','Government')->where('id', (int) $client_id)->first();
            }else{
                $this->data['client'] = \App\Models\Client::where('id', (int)$client_id)->first();
            }
        }

        if( (int) $client_id > 0 && $_POST){
             $service_data = request()->all();
             $data = array('invoice_type' => $invoice_type, 'client_id' => $client_id );
             return $this->createInvoice($service_data,$data,$type);
        }
        return view('account.projection', $this->data);
    }


      public function createInvoice($service,$invoice,$type){
           $reference = time(); // to be changed for selcom ID
           $client_id = $invoice['client_id'];
           $client = \App\Models\Client::find($client_id);
           $year = \App\Models\AccountYear::where('name', date('Y'))->first();

          if(empty($client)  && preg_match('/proforma invoice/i', strtolower($type->name)) ){
                $school_id = $invoice['client_id'];
                $school = \App\Models\School::find($school_id);

                $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
                if (empty($school_contact)) {
                DB::table('admin.school_contacts')->insert([
                    'name' => $school->name, 'email' => $service['email'], 'phone' => $service['phone'], 'school_id' => $school_id, 'user_id' => \Auth::user()->id, 'title' => ''
                ]); 
                  $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
                } 

                $code = rand(343, 32323) . time();
                $arr = explode(' ',trim($school->name));
                $username = strtolower($arr[0]) == 'st' ? trim(strtolower($arr[0].$arr[1])) : strtolower($arr[0]);
                $schema_name = clean(preg_replace('/[^a-z]/', null, $username));
                
                $client_id = DB::table('admin.clients')->insertGetId([
                    'name' => $school->name,
                    'address' => $school->wards->name . ' ' . $school->wards->district->name . ' ' . $school->wards->district->region->name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'phone' => $school_contact->phone,
                    'email' => $school_contact->email,
                    'estimated_students' => $school->students ?? 0,
                    'status' => 3,
                    'code' => $code,
                    'region_id' => $school->wards->district->region->id,
                    'email_verified' => 0,
                    'phone_verified' => 0,
                    'created_by' => \Auth::user()->id,
                    'username' => $schema_name,
                    'start_usage_date' => date('Y-m-d'),
                    'owner_email' => '',
                    'owner_phone' => ''
                ]);

                //client school
                DB::table('admin.client_schools')->insert([
                    'school_id' => $school_id, 'client_id' => $client_id
                ]);
                 //support person
                DB::table('admin.users_schools')->insert([
                    'school_id' => $school_id, 'client_id' => $client_id, 'user_id' => \Auth::user()->id, 'role_id' => \Auth::user()->role_id, 'status' => 1
                ]);

                $data = ['user_id' => \Auth::user()->id, 'school_id' => $school_id, 'activity' => 'Issue School Invoice', 'task_type_id' => 68, 'user_id' => \Auth::user()->id];
                $task = \App\Models\Task::create($data);
                DB::table('tasks_schools')->insert([
                    'task_id' => $task->id,
                    'school_id' => $school_id
                ]);
                $client = \App\Models\Client::find($client_id);
             }                            

                 $start_date = !empty($service['invoice_start_date']) ? date('Y-m-d', strtotime($service['invoice_start_date'])) : date('Y-m-d');
                 $end_date   = date('Y-m-d', strtotime($start_date. " + 30 days"));

                 $invoice_data = ['reference' => $reference, 
                    'client_id' => $client_id, 
                    'date' => $start_date, 
                    'due_date' => $end_date, 
                    'year' => date('Y'), 
                    'user_id' => \Auth::user()->id, 
                    'account_year_id' => $year->id,
                    'invoice_type' => $invoice['invoice_type']
                ];

             $invoice_id = \DB::table('invoices')->insertGetId($invoice_data);
             if( !is_null($service['service_ids']) ) {
              for($i = 0; $i < count($service['service_ids']); $i++){
                    $service_ = \App\Models\CompanyService::where('id',$service['service_ids'][$i])->first();
                         \App\Models\InvoiceFee::create([ 'invoice_id' => $invoice_id, 'amount' => $service['amounts'][$i]*$service['quantity'][$i], 
                          'item_name' => $service_->name, 'note' => $service['note'][$i],'quantity' => $service['quantity'][$i], 'unit_price' => $service['amounts'][$i] ,'service_id' => $service['service_ids'][$i] ]);
                  }
                } 
                 else{
                     return redirect()->back()->with('error', 'You must specify choose at least one service');
              }

           return redirect(url('account/invoiceView/'. $invoice_id))->with('success', 'Invoice Created Successfully');
      }



    public function createShuleSoftInvoice() {
        $client_id = request()->segment(3);
        $school = \App\Models\ClientSchool::where('client_id',(int)$client_id)->first();
        // if(!empty($school)){
        //    $temp_client = collect(\DB::select("select * from admin.temp_clients where school_id ='$school->school_id'"))->first();
        //     // use reference number from temp_clients if client has proforma invoice
        //    $reference = $temp_client->reference;
        // } else {
           $reference = time(); // to be changed for selcom ID
       // }

        $client = \App\Models\Client::find($client_id);
        $year = \App\Models\AccountYear::where('name', date('Y'))->first();
      //  $reference = time(); // to be changed for selcom ID
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
        $unit_price = $client->price_per_student;
        $amount = $unit_price * $client->estimated_students;
        \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => 1, 'item_name' => 'ShuleSoft Service Fee', 'quantity' => $client->estimated_students, 'unit_price' => $unit_price]);
       // return redirect()->back()->with('success', 'Invoice Created Successfully');
         return redirect(url('account/invoice/1/'.$year->id))->with('success', 'Invoice Created Successfully');
    }


     public function getClients() {
        $invoice_type = request()->segment(3);
        $clients = \App\Models\Client::latest()->get();

        if (!empty($clients)) {
            echo '<option value="">select class</option>';
            foreach ($clients as $value) {
                echo '<option value="' . $value->id . '">' . $value->name . '</option>';
            }
        } else {
            echo "0";
        }
    }


    public function getSchools(){
         $invoice_type = request()->segment(3);
         $clients = \App\Models\School::where('ownership','<>','Government')->get();
        if (!empty($clients)) {
            echo '<option value="">select class</option>';
            foreach ($clients as $value) {
                echo '<option value="' . $value->id . '">' . $value->name . '</option>';
            }
        } else {
            echo "0";
        }
    }


    public function getInvoices($type_id = null, $account_year_id = null) {
        $from = $this->data['from'] = request('from');
        $to = $this->data['to'] = request('to');
        $from_date = date('Y-m-d H:i:s', strtotime($from . ' -1 day'));
        $to_date = date('Y-m-d H:i:s', strtotime($to . ' +1 day'));
        $this->data['invoices'] = ($from != '' && $to != '') ? Invoice::whereBetween('date', [$from_date, $to_date])->latest()->get() : 
        // Invoice::whereIn('id', InvoiceFee::where('project_id', $project_id)->get(['invoice_id']))->where('account_year_id', $account_year_id)->latest()->get();
        Invoice::whereIn('id', InvoiceFee::get(['invoice_id']))->where('invoice_type',$type_id)->where('account_year_id', $account_year_id)->latest()->get();
        $this->data['accountyear']= \App\Models\AccountYear::where('id', $account_year_id)->first();
        return $this;
    }


    public function invoice() {
        $this->data['budget'] = [];
        $accountyear = \App\Models\AccountYear::where('name', date('Y'))->first();
        $type_id = $this->data['type_id'] = !empty(request()->segment(3)) ? request()->segment(3) : 1;
        $this->data['account_year_id'] = $account_year_id = empty(request()->segment(4)) ? $accountyear->id : request()->segment(4);
                  
        if ((int) $type_id > 0) {
            $this->data['invoice_type'] = \DB::table('constant.invoices_type')->where('id',$type_id)->first();

            //create shulesoft invoices
            //check in client table if all schools with students and have generated reports are registered
            $clients=\DB::select("select * from admin.clients where id not in (select client_id from admin.invoices where account_year_id=(select id from admin.account_years where name='".date('Y')."')) order by created_at desc");
            $this->getInvoices($type_id, $account_year_id);
        }

        if ($type_id == 'delete') {
            $invoice_id = request()->segment(4);
            \App\Models\Invoice::find($invoice_id)->delete();
            $invoice_fee = \App\Models\InvoiceFee::where('invoice_id',$invoice_id)->first();
            $payments = \App\Models\Payment::where('invoice_id', $invoice_id)->first();
            if (!empty($payments)) {
                \App\Models\Payment::where('invoice_id', $invoice_id)->delete();
                \App\Models\InvoiceFeesPayment::where('invoice_fee_id', $invoice_fee->id)->delete();
                 $invoice_fee->delete();
            }
            return redirect()->back()->with('success', 'deleted successfully');
          }

        if ($type_id == 'edit') {
            $id = request()->segment(4);
            $this->data['invoice'] = Invoice::find($id);
            $this->data['invoicefee'] = InvoiceFee::where('invoice_id',$this->data['invoice']->id)->get();
            $this->data['payments'] = \App\Models\Payment::where('invoice_id', $id)->sum('amount');
            return view('account.invoice.edit', $this->data);
        } else {
            switch ($type_id) {
                case 4:
                    $this->data['invoices'] = DB::connection('karibusms')->select('select a.transaction_code,a.method, a.amount, a.currency,a.sms_provided,a.time,a.invoice, b.name,a.confirmed,a.approved,a.payment_id from payment a join client b using(client_id)');
                    break;
                default:
                     !empty(request('from_date')) && !empty(request('to_date')) ? $this->getInvoiceReports(request('from_date'),request('to_date'),$type_id) : $this->getInvoices($type_id, $account_year_id);
                    break;
            }
            return view('account.invoice.index', $this->data);
        }
    }

      // Get invoice payment reports based on date ranges
    public function getInvoiceReports($from,$to,$project_id) {
            $from = !empty($from) ? $from : date('Y-01-01');
            $this->data['from'] = $from;
            $this->data['id'] = 4;
            $to = !empty($to) ? $to : date('Y-m-d');
            $this->data['to'] = $to;
            $from_date = date('Y-m-d H:i:s', strtotime($from . ' -1 day'));
            $to_date = date('Y-m-d H:i:s', strtotime($to . ' +1 day'));
            $this->data['payments']  = DB::select("select i.id,i.reference,c.name,p.id as p_id,p.created_at,p.amount,i.due_date from admin.payments p join admin.invoices i on i.id = p.invoice_id join admin.clients c on c.id = i.client_id join admin.invoice_fees f on f.invoice_id = i.id where f.project_id = '{$project_id}' and p.date::date between '{$from_date}' and '{$to_date}' order by p.date desc");
            $this->data['invoice_reports'] = DB::select("select extract(month from p.created_at) as month,sum(p.amount) from admin.payments p join admin.invoices i on i.id = p.invoice_id join admin.clients c on c.id = i.client_id join admin.invoice_fees f on f.invoice_id = i.id where f.project_id = '{$project_id}' and p.date::date between '{$from_date}' and '{$to_date}' group by month order by month");
            return $this;
        } 

    
    public function invoiceView() {
        $invoice_id = request()->segment(3);
        $set = $this->data['set'] = 1;
        if ((int) $invoice_id > 0) {
            $this->data['request_control'] = $request_control = request()->segment(4);
            if ((int) $request_control > 0) {
                $this->createSelcomControlNumber($invoice_id);
                return redirect()->back()->with('success', 'success');
            }

            $this->data['invoice'] = $invoice = Invoice::find($invoice_id);
            $this->data['invoicefee'] = InvoiceFee::where('invoice_id',$invoice_id)->first();
        
            $this->data['invoice_name'] = $invoice->invoice_type == 1 ? 'Invoice' : 'Proforma Invoice';
           
            $start_usage_date = !empty($this->data['usage_start_date']) ? date('Y-m-d',strtotime($this->data['usage_start_date'])) : date('Y-m-d', strtotime('Jan 01'));
            $yearEnd = date('Y-m-d', strtotime('Dec 31'));

            $to = \Carbon\Carbon::createFromFormat('Y-m-d',  $yearEnd);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $start_usage_date);
            $this->data['diff_in_months'] = $diff_in_months = $to->diffInMonths($from);


            if($request_control == 'send'){ 
                $this->data['export'] = 'export';
                $pdf = PDF::loadView('account.invoice.whatsapp_invoice', $this->data);
                // $pdf->setPaper('A4', 'landscape');
                 $pdf->stream('Single_Exam_Report.pdf');
               
                  Storage::put($invoice->client->name.'-Invoice-'.date("Y").'.pdf', $pdf->output());
                  $path = url('/') . '/storage/app/'. $invoice->client->name.'-Invoice-'.date("Y"). '.pdf';
                  $filename = $invoice->client->name.'-Invoice-'.date("Y");
               //  $path = "https://admin.shulesoft.com/storage/uploads/images/68481642407170.pdf";
                 $chatId = '255655007457@c.us';
               //  $this->sendMessageFile($chatId,$caption = 'hello',$filename,$path);

                return view('account.invoice.whatsapp_invoice', $this->data);
            //  return redirect()->back()->with('success',' successful!');


            }

            return view('account.invoice.single', $this->data);

        }
    }


      public function whatsappSend(){
            $invoice_id = request()->segment(3);
             
             $set = $this->data['set'] = 1;
          if ((int) $invoice_id > 0) {
           
            $this->data['invoice'] = $invoice = Invoice::find($invoice_id);
            $this->data['invoicefee'] = InvoiceFee::where('invoice_id',$invoice_id)->first();
        
            $this->data['invoice_name'] = $invoice->invoice_type == 1 ? 'Invoice' : 'Proforma Invoice';
           
            $start_usage_date = !empty($this->data['usage_start_date']) ? date('Y-m-d',strtotime($this->data['usage_start_date'])) : date('Y-m-d', strtotime('Jan 01'));
            $yearEnd = date('Y-m-d', strtotime('Dec 31'));
  
            $to = \Carbon\Carbon::createFromFormat('Y-m-d',  $yearEnd);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $start_usage_date);
            $this->data['diff_in_months'] = $diff_in_months = $to->diffInMonths($from);
            $pdf = PDF::loadView('account.invoice.single', $this->data);
            Storage::put($invoice->client->name.'-Invoice-'.date("Y").'.pdf', $pdf->output());
            $path = url('/') . '/storage/app/'. $invoice->client->name.'-Invoice-'.date("Y"). '.pdf';
            $filename = $invoice->client->name.'-Invoice-'.date("Y");

            dd($path);

          //  return view('account.invoice.whatsapp_invoice', $this->data);


        
            // Storage::disk('local')->put($invoice->client->name.'.pdf', $pdf->output());

          //  return $pdf->download($invoice->client->name.'.pdf', array('Content-Type: application/pdf'));
           //    return redirect()->back()->with('success',' successful!');
         }
      }


       public function receiptView() {
        $invoice_id = request()->segment(3);
        $set = $this->data['set'] = 1;
        if ((int) $invoice_id > 0) {
            $payment_id = request()->segment(4);
            $this->data['invoice'] = \collect(DB::select("select i.id,f.amount,i.reference,i.date,i.token,c.username,c.name,c.phone,c.email,
            c.start_usage_date,p.amount as paid,i.due_date from admin.payments p join admin.invoices i on i.id = p.invoice_id join 
            admin.clients c on c.id = i.client_id join admin.invoice_fees f on f.invoice_id = i.id where p.id = '{$payment_id}' and i.id ='{$invoice_id}' "))->first();
        
            $this->data['usage_start_date'] = $this->data['invoice']->start_usage_date;
           
            $start_usage_date = !empty($this->data['usage_start_date']) ? date('Y-m-d',strtotime($this->data['usage_start_date'])) : date('Y-m-d', strtotime('Jan 01'));
           
            $yearEnd = date('Y-m-d', strtotime('Dec 31'));

            $to = \Carbon\Carbon::createFromFormat('Y-m-d',  $yearEnd);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $start_usage_date);
            $this->data['diff_in_months'] = $diff_in_months = $to->diffInMonths($from);
            return view('account.invoice.single_receipt', $this->data);
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

    
    public function services() {
         $financial_category = \App\Models\FinancialCategory::where('name','Revenue')->first();
         $this->data['services'] = \App\Models\CompanyService::latest()->get();

          if($_POST) {
                $validated = request()->validate([
                     'name' => 'required|max:255',
                ]);
                \App\Models\CompanyService::create(request()->except('_token'));
                 $obj = [
                     'name' => request('name'),
                     "financial_category_id" => $financial_category->id,
                 ];

                  $check = DB::table('admin.account_groups')->where($obj)->first();
                  $account_group_id = !empty($check) ? $check->id : DB::table('admin.account_groups')->insertGetId($obj);

                  $array = array(
                    "name" => trim(request("name")),
                    "financial_category_id" => $financial_category->id,
                    "note" => request("description"),
                    "account_group_id" => $account_group_id,
                    'code' => createCode(),
                    'open_balance' =>  0,
                    "status" => 1
                  );
               \App\Models\ReferExpense::create($array);
                return redirect()->back()->with('success', 'Service created succesfully');
           }
        return view('account.services', $this->data);
    }


    public function sendInvoice() {
        $invoice = Invoice::find(request('invoice_id'));
        $message = request('message');
        $email = request('email');
        $phone_number = request('phone_number');
        $company_file_id = null;
        
        $file = request()->file('invoice_file');
        if(!empty($file)){
          $company_file_id =  $this->saveFile($file, 'company/contracts',TRUE);
        }


        $client = \App\Models\Client::where('id',$invoice->client->id)->first();
       
        $search  = array("#name","#amount","#invoice");
        $replace = array($invoice->client->name, $invoice->invoiceFees()->sum('amount'), $invoice->reference);
        $newmessage = str_replace($search, $replace, $message);

        $arr = [
            'amount' => $invoice->invoiceFees()->sum('amount'),
            'schema_name' => $invoice->client->username,
            'user_id' => Auth::user()->id,
            'date' => date('Y-m-d'),
            'email' => request('email'),
            'phone_number' => !empty($phone_number) ? $phone_number : $invoice->client->phone,
            'message' => $newmessage,
            'student' => $invoice->client->estimated_students
        ];
        \App\Models\InvoiceSent::create($arr);

        $invoice_task = [
            "activity" => 'Invoice sent to '.$invoice->client->name,
            "task_type_id" => "9",
            "to_user_id" => \Auth::user()->id,
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
                 'user_id' => \Auth::user()->id 
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
          //  $this->createSelcomControlNumber(request('invoice_id'));
            $invoice = Invoice::find(request('invoice_id'));
        }
        // $replacements = array(
        //     $invoice->client->name, money($invoice->invoiceFees()->sum('amount') - $invoice->payments()->sum('amount')), $invoice->token
        // );
        // $sms = preg_replace(array(
        //     '/#name/i', '/#amount/i', '/#invoice/i'
        //         ), $replacements, $message);

        // if (preg_match('/#/', $sms)) {
        //     //try to replace that character
        //     $sms = preg_replace('/\#[a-zA-Z]+/i', '', $sms);
        // }  

      //  $button = '<p align="center"><a style="padding:8px 16px;color:#ffffff;white-space:nowrap;font-weight:500;display:inline-block;text-decoration:none;border-color:#0073b1;background-color:green;border-radius:2px;border-width:1px;border-style:solid;margin-bottom:4px" href="' . url('epayment/i/' . $invoice->id) . '" target="_blank">Click to View Your Invoice</a></p>';

        $this->send_whatsapp_sms($phone_number, $newmessage,$company_file_id);
       // $this->send_sms(validate_phone_number(request('phone_number'))[1], $sms . '. Open ' . url('epayment/i/' . $invoice->id) . ' to view Invoice');
       // $this->send_email(request('email'), 'ShuleSoft Invoice of Service', nl2br($sms) . '<br/><br/>' . $button);
        return redirect()->back()->with('success', 'Sent successfully');
    }

    public function editShuleSoftInvoice() {
        $invoice_id = request()->segment(3);
        $invoice = Invoice::find($invoice_id);
        $date = date("Y-m-d H:i:s");

        $invoice->update(['due_date' => date('Y-m-d',strtotime(request('due_date')))]);
        $client = \App\Models\Client::find($invoice->client_id);
        $data = ['start_usage_date' => request('start_usage_date')];
        $client->update($data);

        for($i = 0;$i < count(request('service_id')); $i++){
             \App\Models\InvoiceFee::where(['invoice_id' => $invoice_id, 'service_id' => (int) request('service_id')[$i]])
             ->update(['unit_price' => request('amounts')[$i],'quantity'=> request('quantity')[$i],'amount' => request('amounts')[$i]*request('quantity')[$i] ]);
        }
       
       return redirect(url('account/invoiceView/'. $invoice_id))->with('success', 'Invoice Edited Successfully');
    }

    
    


    //   public function createinvoices() {
    //     $school_id =  (int) request('school_id');
        
    //     $due_date = request('due_date');
    //     $reference = time(); // to be changed for selcom ID
    //     $start_date = date('Y-m-d', strtotime($due_date. ' - 30 days'));
    //     $client = \App\Models\ClientSchool::where('school_id',(int) $school_id)->first();

        
    //     $school = \App\Models\School::find($school_id);
    //     $year = \App\Models\AccountYear::where('name', date('Y'))->first();

    //     // If school is not client, create pro forma invoice
    //      if (is_null($client) && request('type')== '4') {
    //         DB::table('admin.temp_clients')->insert([
    //             'name' => $school->name, 'email' => request('email'), 'phone' => request('phone'), 'school_id' => $school->id, 'user_id' => \Auth::user()->id,
    //             'reference' => $reference, 'date' => $start_date, 'due_date' => $due_date, 'account_year_id' => $year->id,
    //             'amount' => remove_comma(request('amount'))*request('students'), 'project_id' => request('type'),
    //             'students' => request('students'), 'unit_amount'=> request('amount')
    //         ]);
    //      } else { 
    //     $client = \App\Models\Client::find($client->client_id);
    //     $project_id = request('type');
    //     $item = \App\Models\InvoiceType::where('id', (int) $project_id)->first();
        
    //     $item_name = $item->name;
    //     $data = array('reference' => $reference, 
    //                     'client_id' => $client->id, 
    //                     'date' => $start_date, 
    //                     'due_date' => $due_date, 
    //                     'year' => date('Y'), 
    //                     'user_id' => \Auth::user()->id, 
    //                     'account_year_id' => $year->id
    //                 );

    //     $invoice = Invoice::create($data);
    //     $amount = remove_comma(request('amount'));
    //     $total_amount = request('students') * $amount;
    //      \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $total_amount, 'project_id' => $project_id, 'item_name' => $item_name, 'unit_price' => $amount , 'quantity' => request('students')]);
    //     }
    //      return redirect(url('account/invoice/1/'.$year->id))->with('success', 'Invoice Created Successfully');

    // }


    // public function createInvoice() {
    //     $this->data['projects'] = Project::all();
    //     if (request('noexcel')) {
    //         $data = request('users');
    //         $client_id = request('client_id');
    //         $client_record = \App\Models\Client::find($client_id);
    //         if (request('project_id') == 1) {
    //             $user_invoice = [];
    //             $reference = 'SASA11' . date('Y') . $client_record->id . rand(10, 100);
    //         } else {
    //             $user_invoice = Invoice::where('client_id', $client_id)->first();
    //             $reference = 'SASA11' . date('Y') . $client_record->id;
    //         }
    //         $this->data["payment_types"] = \App\Models\PaymentType::all();
    //         if (empty($user_invoice)) {
    //             $invoice = Invoice::create(['reference' => $reference, 'client_id' => $client_record->id, 'date' => date('d M Y', strtotime(request('date'))), 'due_date' => date('d M Y', strtotime(' +30 day')), 'year' => date('Y', strtotime(request('date'))), 'sync', 'user_id' => Auth::user()->id]);
    //             foreach ($data as $value) {
    //                 //check if this user has invoice already 
    //                 $project = Project::where('name', 'ílike', $value['project'])->first();
    //                 $amount = (float) $value['quantity'] * (float) $value['unit_price'];
    //                 \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => !empty($project) ? $project->id : request('project_id'), 'item_name' => $value['name'], 'quantity' => (int) $value['quantity'], 'unit_price' => (float) $value['unit_price']]);
    //             }
    //             echo 1;
    //         } else {
    //             echo ' <div class="alert alert-warning">User <b>' . $client_record->name . '</b>  has an invoice number ' . $user_invoice->reference . ' already generated on ' . $user_invoice->created_at . '. Please update</div>';
    //         }
    //     }
    //     return view('account.invoice.create', $this->data);
    // }

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
        $this->data['invoice'] = $invoice = Invoice::find($id);
        $this->data['invoicefee'] = $invoicefee = InvoiceFee::where('invoice_id',$id)->get();
        $year = \App\Models\AccountYear::where('name', date('Y'))->first();
        $this->data["payment_types"] = \App\Models\PaymentType::all();
        $this->data['banks'] = \App\Models\BankAccount::all();
        $this->data["category"] = DB::table('refer_expense')->whereIn('financial_category_id', [1])->get();

        if ($_POST) {
           $this->validate(request(), ['payment_type' => 'required', 'date' => 'required']);
           $refer_expense_id = request('refer_expense_id');
           $mobile_transaction_id = request('mobile_transaction_id');
           $payment_type = \App\Models\PaymentType::find(request('payment_type'));

            $sum = 0;
            $unit_amount = 0;
            for($i=0;$i < count(request('service_id')); $i++){
                  $unit_amount = !is_null(remove_comma(request('amounts')[$i])) ? remove_comma(request('amounts')[$i]) : 0;
                  $sum += (int) $unit_amount; 
            } 
             if($sum == 0){
                return redirect()->back()->with('error', 'Both payments can not be empty!');
            }

            $transaction_id =  request('transaction_id') == 0 ?  time() : request('transaction_id');
            $payments = collect(\DB::select("select * from admin.payments where transaction_id = '.$transaction_id.' "))->first();
            if (!empty($payments)) {
                $data = array(
                    'status' => 1,
                    'success' => 0,
                    'reference' => $invoice->reference,
                    'description' => 'Transaction ID has been used already to commit transaction'
                );
                die(json_encode($data));
            }
        
           $payment = $this->acceptPayment($sum, $invoice->id, $payment_type->name, $transaction_id, $mobile_transaction_id, request('name'), request('bank_account_id'), request('transaction_time'), request('token'), $invoice->client_id, $refer_expense_id, request('date'));
            for($i=0;$i < count(request('amounts')); $i++){  
                 $single_amount = request('amounts')[$i];
                 if(!empty($single_amount)){
                   \App\Models\ServicePayment::create(['invoice_id'=>$id,'service_id'=>request('service_id')[$i], 'unit_amount' => (int) remove_comma($single_amount) ]);
                   $this->addPayment($id,json_decode($payment)->payment_id,(int) remove_comma($single_amount), request('service_id')[$i]);
                 }
            }
           

            // $previous_amount = collect(\DB::SELECT("select sum(coalesce(balance,0))  as last_balance from 
            // admin.client_invoice_balances where client_id = '$invoice->client_id' and extract(year from created_at) < '$year->name' "))->first();
            //  if($previous_amount->last_balance > 0){
            //     $invoices = \DB::table('admin.client_invoice_balances')->where('client_id',$invoice->client_id)->get();
            //      foreach($invoices as $invoice){
            //         // to be reviewed
            //           return $this->addPayment($invoice->invoice_id);
            //      }
            //  } else{
           return redirect(url('account/invoice/'.$invoice->invoice_type.'/'.$invoice->account_year_id))->with('success', 'success');
               
        }
        return view('account.invoice.payment', $this->data);

    }

   
    public function addPayment($id,$payment_id,$paid_amount,$service_id) {
        $invoice = Invoice::find($id);
        
        if (!empty($invoice)) {
            $am = \App\Models\InvoiceFee::where('invoice_id', $invoice->id)->where('service_id',$service_id);
            $invoice_service = $am->first();
            $paid = \App\Models\InvoiceFeesPayment::where('invoice_fee_id',$invoice_service->id)->sum('paid_amount');

            $unpaid = $invoice_service->amount - $paid;

            $advanced_amount = 0;
             if ($paid_amount > $unpaid) {
                $advanced_amount = $paid_amount - $unpaid;
                $paid_amount = $unpaid;
            }

          
            if ($invoice_service->status <> 1 && $paid_amount > 0) {
                if ($paid_amount >= $invoice_service->amount) {
                    $status = 1;
                    \App\Models\InvoiceFeesPayment::create([
                        'invoice_fee_id' => $invoice_service->id,
                        'payment_id' => $payment_id,
                        'paid_amount' => $invoice_service->amount,
                        'status' => $status,
                    ]);
                  //  $amount = $paid_amount - $invoice_service->amount;
                } else {
                    //amount is less than invoice paid amount
                    $status = 2;
                    \App\Models\InvoiceFeesPayment::create([
                        'invoice_fee_id' => $invoice_service->id,
                        'payment_id' => $payment_id,
                        'paid_amount' => $paid_amount,
                        'status' => $status,
                    ]);
                   // $amount = $paid_amount - $amount;
                  }
              }

         if ((int) $advanced_amount > 0) {
            DB::table('admin.advance_payments')->insert([
                'client_id' => $invoice->client_id,
                'payment_id' => $payment_id,
                'amount' => $advanced_amount
             ]);
            }
         }
       // return redirect('account/invoice/1/' . $invoice->account_year_id)->with('success', 'success');
    }

    public function acceptPayment($amount, $invoice_id, $payment_method, $receipt, $mobile_transaction_id, $customer_name, $bank_account_id, $timestamp, $token, $client_id, $refer_expense_id, $date = null) {
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
        );
         

        $payment_id = DB::table('admin.payments')->insertGetId($payment_array);
        $client = DB::table('admin.clients')->where('id', $client_id)->first();


        // $data = [
        //     'payer_name' => $client->name,
        //     'payer_phone' => $client->phone,
        //     'payer_email' => $client->name,
        //     'created_by_id' => $payment_id,
        //     'amount' => $amount,
        //     "refer_expense_id" => $refer_expense_id,
        //     "bank_account_id" => $bank_account_id,
        //     'payment_method' => $payment_method,
        //     'transaction_id' => $receipt,
        //     'date' => 'now()',
        //     'note' => ''
        // ];
        // \App\Models\Revenue::create($data);

        

    //    $budget_rations = DB::table('budget_ratios')->where('project_id', $invoice_fee->first()->project_id)->get();

    //     foreach ($budget_rations as $ratio) {
    //         DB::table('payments_budget_ratios')->insert([
    //             'budget_ratio_id' => $ratio->id,
    //             'payment_id' => $payment_id,
    //             'amount' => $ratio->percent * $total_amount / 100
    //         ]);
    //     }

        $status = 1;

        
        $invoice = Invoice::find($invoice_id);
        $invoice->update(['status' => $status]);

        if ($status == 1) {
            //amount has been paid correctly to more than one id so the returned id should be changed.
            return json_encode(array('control' => 1, 'description' => 'Invoice fully paid', 'payment_id' => $payment_id));
        } else if ($status == 2) {
            return json_encode(array('control' => 2, 'description' => 'Invoice partially paid', 'payment_id' => $payment_id));
        } else {
            return json_encode(array('control' => 3, 'description' => 'Invoice is paid amount more than invoiced amount', 'payment_id' => $payment_id));
        }
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
        $this->data['id'] = $id;
        $this->data['check_id'] = $id;
        $this->data['sub_id'] = request()->segment(4);
        $this->data['banks'] = \App\Models\BankAccount::all();
        $this->data["payment_types"] = \App\Models\PaymentType::all();
        $this->data['transaction_id'] = $transaction_id = time() . rand(10 * 45, 100 * 98);
        if($_POST) {
            $insert_id = 0;
            $depreciation = (float) request("depreciation") > 0 ? (float) request("depreciation") : (float) request("dep");
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
                  
                    $insert_id = DB::table('expenses')->insertGetId($obj);
                  } else {
                    $obj = array_merge($array, [
                        'recipient' => request('payer_name'),
                        'voucher_no' => $voucher_no + 1,
                        'payer_name' => $payer_name,
                    ]);
                    DB::table('expenses')->insert($obj);
                } 
               
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
                    'created_by' => Auth::user()->id
                );

                
                if (request("from_expense") == request("to_expense")) {
                    return redirect()->back()->with('error', 'You can not transfer to the same account');
                }
                $refer_expense = \App\Models\ReferExpense::find(request("from_expense"));
               
                $total_amount = 0;
                if ((int) $refer_expense->predefined && $refer_expense->predefined > 0) {
                    $total_bank = \collect(DB::SELECT('SELECT sum(coalesce(amount,0)) as total_bank from admin.bank_transactions WHERE bank_account_id=' . $refer_expense->predefined . ' and payment_type_id <> 1 '))->first();

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
            $this->data['expenses'] = \App\Models\ReferExpense::where('refer_expense.id', $id)
            ->join('expenses', 'expenses.refer_expense_id', 'refer_expense.id')
            ->select('payment_types.name as payment_method', 'expenses.recipient as recipient', 'expenses.date', 'expenses.amount', 'expenses.note', 'expenses.transaction_id', 'expenses.id', 'refer_expense.predefined')->leftJoin('payment_types', 'payment_types.id', 'expenses.payment_type_id')
            ->where('expenses.date', '>=', $from_date)->where('expenses.date', '<=', $to_date)->get();
        }
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
        return DB::select("with tempa as (select a.date,a.revenue, b.expense from (select  sum(amount) as revenue,date_trunc('month', date) as date from admin.revenues group by date_trunc('month', date) order by date_trunc('month', date) asc)as a left join 
    (select  sum(amount::numeric) as expense,date_trunc('month', date) as date from admin.expenses group by date_trunc('month', date) order by date_trunc('month', date) asc
    ) as b on date_trunc('month', b.date)= date_trunc('month', a.date) ),tempb as ( select * from tempa ) select * from tempb");
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
         $this->data['standingorders'] = \App\Models\StandingOrder::latest()->get();
         $this->data['schools'] = \App\Models\Client::get();
        return view('account.standing', $this->data);
    }

    // Approve standing orders
    public function approveStandingOrder() { 
        $this->data['so_id'] = $so_id = request()->segment(3);
        if(!empty($so_id)){
            \App\Models\StandingOrder::where('id', $so_id)->update(['is_approved' => 1,'approved_by' => \Auth::user()->id]);
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
            return redirect('account/standingOrders')->with('success', 'Succeessful updated');
        }  
        return view('account.standingorder.edit', $this->data);
    }

    public function holidays(){
        $option = request()->segment(3);
        $id = request()->segment(4);
        $this->data['holidays'] = DB::select("select * from admin.public_days where country_id = '1' order by date desc limit 10");
      
          if($_POST){
              $data = ['name'=>request('holiday_name'), 'date'=>request('holiday_date'),'country_id' => '1'];
              DB::table('admin.public_days')->insert($data);
             return redirect()->back()->with('success','Holiday created successfully');
          }

            if($option == 'delete'){
              DB::table('admin.public_days')->where('id',$id)->delete();
              return redirect()->back()->with('info','Holiday deleted successfully');;
           }
        return view('account.holidays', $this->data);
    }


    public function proinvoiceView(){
            $id = request()->segment(3);
            $this->data['invoice'] = \App\Models\TempClients::find($id);
            return view('account.invoice.pro_forma', $this->data);

            if($id == 'edit'){
               return view('account.invoice.pro_forma', $this->data);
            }
    }



       public function editProfile() {
        $new_value = request('newvalue');
        $column = request('column');
        
        if (request('column') == 'email') {
            if (!filter_var($new_value, FILTER_VALIDATE_EMAIL)) {
                die('<span class="red">This email is not valid</span>');
            }
            $user = \App\Model\User::where('email', $new_value)->first();
            if (!empty($user)) {
                die('<span class="red">This email already exists</span>');
            }
        } else if (request('column') == 'phone') {
           // $new_value = $valid[1];
            $user = \App\Model\User::where('phone', $new_value)->first();           
            $valid = validate_phone_number($user->phone);
            if (count($valid) != 2) {
                die('<span class="red">This phone number is not valid</span>');
            }
            
            if (!empty($user)) {
                die('<span class="red">This phone already exists</span>');
            }
        } else if (request('column') == 'username') {
            $user = \App\Model\User::where('username', $new_value)->first();
            if (!empty($user)) {
                die('<span class="red">This username already exists</span>');
            }
        } 

        $update = DB::table('admin.users')->where('id',request('id'))->update([$column => $new_value]);
        echo $update > 0 ? $new_value : 'No changes happened';
    }



     public function editSetting() {
        $id =  request('id');
        $newvalue = request('newvalue');
        $column = request('column');
        $table = request('table'); 
        $update = DB::table('admin.'.$table)->where('id',request('id'))->update([$column => $newvalue]);
        echo $update > 0 ? $newvalue : 'No changes happened';
    }



    public function getClientInfo(){
       $client_id = request()->segment(3);


    }


}


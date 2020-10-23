<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;

class Partner extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index() {
            $this->data['requests'] = \App\Models\IntegrationRequest::get();
            $this->data['invoices'] = \App\Models\Invoice::whereIn('client_id', \App\Models\IntegrationRequest::get(['client_id']))->get();
            return view('users.partners.requests', $this->data);
        }
        
        public function show() {
            $id = request()->segment(3);
            $this->data['request'] = $request = \App\Models\IntegrationRequest::find($id);
            $school = DB::table('admin.schools')->where('schema_name', $request->client->username)->first();
            $this->data['school'] = \App\Models\SchoolContact::where('school_id', $school->id)->first();
            $this->data['client'] = \App\Models\ClientSchool::where('client_id', $request->client_id)->first();
            return view('users.partners.view_request', $this->data);
        }

    public function add() {
        $id = request()->segment(3);
        $this->data['districts'] = \App\Models\District::get();
        if ($_POST) {
            //   $data = request()->all();
            //   dd($data);
            //  exit;
            $code = rand(343, 32323) . time();
            if(!empty(request('ward'))){
                $ward = \App\Models\Ward::find(request('ward'));
            }
           
            $username = request('username');
            $array = [
                'name' => strtoupper(request('school_name')),
                'region' => $ward->district->region->name,
                'district' => $ward->district->name,
                'ownership' => request('ownership'),
                'type' => request('type'),
                'students' => request('students'),
                'schema_name' => $username,
                'ward_id' => request('ward'),
                'ward' => $ward->name
            ];
            $check_school = DB::table('admin.schools')->where('name', strtoupper(request('school_name')))->where('schema_name', $username)->first();
            if (empty($check_school)) {
                $school_id = DB::table('admin.schools')->insertGetId($array);
                $school = \App\Models\School::where('id', $school_id)->first();
            }else{
            $school = \App\Models\School::where('id', $check_school->id)->first();
                $school_id = $school->id;
            }
            $school_id = $school->id;

            $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
            if (empty($school_contact)) {
                DB::table('admin.school_contacts')->insert([
                    'name' => request('fullname'), 'email' => request('email'), 'phone' => request('phone'), 'school_id' => $school_id, 'user_id' => Auth::user()->id, 'title' => request('title')
                ]);
                $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
            }

            $schema_name = request('username') != '' ? strtolower(trim(request('username'))) : $username;
            $check_client = DB::table('admin.clients')->where('username', $schema_name)->first();
            if (!empty($check_client)) {
                $client_id = $check_client->id;
            } else {
                $client_id = DB::table('admin.clients')->insertGetId([
                    'name' => $school->name,
                    'address' => request('address'),
                    'phone' => $school_contact->phone,
                    'email' => $school_contact->email,
                    'estimated_students' => request('students'),
                    'status' => 3,
                    'code' => $code,
                    'email_verified' => 0,
                    'phone_verified' => 0,
                    'created_by' => Auth::user()->id,
                    'username' => $schema_name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'price_per_student' => 12000,
                    'registration_number' => request('registration_number')
                ]);
                  //add company file
            $check_contract = DB::table('admin.client_contracts')->where('client_id', $client_id)->first();
            if (empty($check_contract)) {
                $file =  request()->file('attachments')[0];
                $file_id = $this->saveFile($file, 'company/contracts');
                //save contract
                $contract_id = DB::table('admin.contracts')->insertGetId([
                    'name' => 'ShuleSoft', 'company_file_id' => $file_id, 'start_date' => request('implementation_date'), 'end_date' =>  date('Y-m-d', strtotime('+1 years')), 'contract_type_id' => request('contract_type_id'), 'user_id' => Auth::user()->id
                ]);
                //client contracts
                DB::table('admin.client_contracts')->insert([
                    'contract_id' => $contract_id, 'client_id' => $client_id
                ]);

             }
                //client school
                DB::table('admin.client_schools')->insert([
                    'school_id' => $school_id, 'client_id' => $client_id
                ]);
                
                //client projects
                DB::table('admin.client_projects')->insert([
                    'project_id' => 1, 'client_id' => $client_id //default ShuleSoft project
                ]);
            }
                //Bank Accounts Intergration Details
                $check_req = DB::table('admin.integration_requests')->where('client_id', $client_id)->first();
                    if (empty($check_req)) {
                        $request_id = DB::table('admin.integration_requests')->insertGetId([
                       'client_id' => $client_id, 'user_id' => Auth::user()->id, 'refer_bank_id' => 8, 'schema_name' => $schema_name, 'bank_approved' => 0, 'shulesoft_approved' => 1, 'created_at' => date('Y-m-d H:i:s')
                    ]);
                    }else{
                        $request_id = $check_req->id;
                    }
                    
                 //Bank Accounts Details
                    DB::table('admin.bank_accounts_integrations')->insert([
                        'number' => request('account_number'), 'branch' => request('branch_name'),  'name' => request('account_name'), 'refer_currency_id' => request('refer_currency_id'), 'opening_balance' => request('opening_balance'), 'integration_request_id' => $request_id,  'refer_bank_id' => 8 
                    ]);
                    
                    //Install School Levels
                    $levels = request('classlevel');
                    if(!empty($levels)){
                        foreach($levels as $level){
                            DB::table('admin.school_levels')->insert([
                                'name' => $level, 'client_id' => $client_id, 'schema_name' => $username 
                            ]);
                        }
                    }
                  
                //post task, onboarded
                $data = ['user_id' => Auth::user()->id, 'school_id' => $school_id, 'activity' => 'Onboarding', 'task_type_id' => request('task_type_id'), 'user_id' => Auth::user()->id];
                $task = \App\Models\Task::create($data);
                DB::table('tasks_schools')->insert([
                    'task_id' => $task->id,
                    'school_id' => $school_id
                ]);
                
            //add company file
            
            $attachments = request()->file('attachments');
            foreach($attachments as $file){
               $file_id = $this->saveFile($file, 'company/contracts');
               // Integration requests documents
           
               $bank_file_id = DB::table('admin.integration_bank_documents')->insertGetId([
                   'refer_bank_id' => 8, 'company_file_id' => $file_id, 'created_by' => Auth::user()->id
               ]);

               DB::table('admin.integration_requests_documents')->insertGetId(['integration_bank_document_id' => $bank_file_id, 'integration_request_id' => $request_id]);
            }

 
            //once a school has been installed, now create an invoice for this school or create a promo code
                // create an invoice for this school
                $check_booking = DB::table('admin.invoices')->where('client_id', $client_id)->first();
                if (!empty($check_booking)) {
                    $booking = $check_booking;
                } else {
               
                    $client = \App\Models\Client::find($client_id);
                    $year = \App\Models\AccountYear::where('name', date('Y'))->first();
                    $reference = time(); // to be changed for selcom ID
                    $invoice = \App\Models\Invoice::create(['reference' => $reference, 'client_id' => $client_id, 'date' => date('d M Y'), 'due_date' => date('d M Y', strtotime(' +30 day')), 'year' => date('Y'), 'user_id' => Auth::user()->id, 'account_year_id' => $year->id]);
                    //once we introduce packages (module pricing), we will just loop here for modules selected by specific user

                    $months_remains = 12 - (int) date('m', strtotime($client->created_at)) + 1;
                    $unit_price = $months_remains * $client->price_per_student / 12;
                    $amount = $unit_price * $client->estimated_students;

                    \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => 1, 'item_name' => 'ShuleSoft Service Fee', 'quantity' => $client->estimated_students, 'unit_price' => $unit_price]);
                }

            //send onboarding message to customer directly
            
            return redirect('account/InvoiceView/'.$invoice->id);
            //return redirect('https://' . $username . '.shulesoft.com/database/'.$username);
           // }
        }
        return view('users.partners.add_new', $this->data);
    }
    public function InvoicePrefix() {
        $id = request()->segment(3);
        DB::statement("select constant.create_invoice_prefix_trigger()");
        return redirect()->back()->with('success', 'Bank Account Prefix updated successfully');
    }
    public function viewFile() {
        $id = request()->segment(3);
        $this->data['path'] = \App\Models\CompanyFile::where('id', $id)->first();
        return view('users.partners.file_view', $this->data);
    }
    
    public function school() {
        $this->data['use_shulesoft'] = DB::table('admin.all_setting')->count() - 5;
        $this->data['school_types'] = DB::select("select type, count(*) from admin.schools where ownership='Non-Government' group by type,ownership");
        return view('users.partners.school_list', $this->data);
    }
}
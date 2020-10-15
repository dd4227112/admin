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
            $this->data['users'] = User::where('status', 1)->where('role_id', '<>', 7)->get();
            return view('users.partners.requests', $this->data);
        }
        
    public function add() {
        $id = request()->segment(3);
        $partner = \App\Models\District::get();
        $this->data['districts'] = $partner;
        if ($_POST) {
            $code = rand(343, 32323) . time();

            $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
            if (empty($school_contact)) {
                DB::table('admin.school_contacts')->insert([
                    'name' => request('name'), 'email' => request('email'), 'phone' => request('phone'), 'school_id' => $school_id, 'user_id' => Auth::user()->id, 'title' => request('title')
                ]);
                $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
            }
            DB::table('admin.schools')->where('id', $school_id)->update(['students' => request('students')]);

            $schema_name = request('username') != '' ? strtolower(trim(request('username'))) : $username;
            $check_client = DB::table('admin.clients')->where('username', $schema_name)->first();
            if (!empty($check_client)) {
                $client_id = $check_client->id;
            } else {
                $client_id = DB::table('admin.clients')->insertGetId([
                    'name' => $school->name,
                    'address' => $school->ward . ' ' . $school->district . ' ' . $school->region,
                    'phone' => $school_contact->phone,
                    'email' => $school_contact->email,
                    'estimated_students' => request('students'),
                    'status' => 3,
                    'code' => $code,
                    'email_verified' => 0,
                    'phone_verified' => 0,
                    'created_by' => Auth::user()->id,
                    'username' => $schema_name,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                //client school
                DB::table('admin.client_schools')->insert([
                    'school_id' => $school_id, 'client_id' => $client_id
                ]);
                //client projects
                DB::table('admin.client_projects')->insert([
                    'project_id' => 1, 'client_id' => $client_id //default ShuleSoft project
                ]);
                //sales person
                //support person
                DB::table('admin.users_schools')->insert([
                    'school_id' => $school_id, 'client_id' => $client_id, 'user_id' => request('support_user_id'), 'role_id' => 8, 'status' => 1
                ]);
                //post task, onboarded
                $data = ['user_id' => Auth::user()->id, 'school_id' => $school_id, 'activity' => 'Onboarding', 'task_type_id' => request('task_type_id'), 'user_id' => Auth::user()->id];
                $task = \App\Models\Task::create($data);
                DB::table('tasks_schools')->insert([
                    'task_id' => $task->id,
                    'school_id' => $school_id
                ]);
            }


            //add company file
            $check_contract = DB::table('admin.client_contracts')->where('client_id', $client_id)->first();
            if (empty($check_contract)) {
                $file = request()->file('file');
                $file_id = $this->saveFile($file, 'company/contracts');
                //save contract
                $contract_id = DB::table('admin.contracts')->insertGetId([
                    'name' => 'ShuleSoft', 'company_file_id' => $file_id, 'start_date' => request('start_date'), 'end_date' => request('end_date'), 'contract_type_id' => request('contract_type_id'), 'user_id' => Auth::user()->id
                ]);
                //client contracts
                DB::table('admin.client_contracts')->insert([
                    'contract_id' => $contract_id, 'client_id' => $client_id
                ]);
            }

            //once a school has been installed, now create an invoice for this school or create a promo code
            if (request('payment_status') == 1) {
                // create an invoice for this school
                $check_booking = DB::table('admin.invoices')->where('client_id', $client_id)->first();
                if (!empty($check_booking)) {
                    $booking = $check_booking;
                } else {
                    // $order_id = time() . $client_id;
                    // $client = DB::table('admin.clients')->where('id', $client_id)->first();
                    // $total_price = (int) request('students') < 100 ? 100000 : $client->estimated_students * 1000;
                    // $order = array("order_id" => $order_id, "amount" => $total_price,
                    //     'buyer_name' => $client->name, 'buyer_phone' => $client->phone, 'end_point' => '/checkout/create-order', 'action' => 'createOrder', 'client_id' => $client->id, 'source' => $client->id);
                    // $this->curlPrivate($order);

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
                $this->scheduleActivities($client_id);
                return redirect('sales/customerSuccess/1/' . $client_id);
            } else {
                //create a trial code for this school
                $trial_code = $client_id . time();
                $client = DB::table('admin.clients')->where('id', $client_id);
                DB::table('admin.clients')->where('id', $client_id)->update(['code' => $trial_code]);
                $user = $client->first();
                $message = 'Hello ' . $user->name . '. Your Trial Code is ' . $trial_code;
                //$this->send_sms($user->phone, $message, 1);
                //$this->send_email($user->email, 'Success: School Onboarded Successfully', $message);
                $this->scheduleActivities($client_id);
                return redirect('sales/customerSuccess/2/' . $client_id);
            }
            //send onboarding message to customer directly
            $this->onboardMessage($client);
            return redirect('https://' . $username . '.shulesoft.com');
        }
        return view('users.partners.add_new', $this->data);
    }
}
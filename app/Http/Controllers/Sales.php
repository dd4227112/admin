<?php

namespace App\Http\Controllers;

use App\Jobs\PushSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class Sales extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->data['faqs'] = [];
        return view('sales.index', $this->data);
    }

    function faq() {
        if ((int) request('id') > 0 && request('action') == 'delete') {
            DB::table('faq')->where('id', request('id'))->delete();
        }
        $this->data['faqs'] = DB::table('faq')->get();
        return view('market.faq', $this->data);
    }

    function lead() {
        $this->data['demo_requests'] = DB::table('website_demo_requests')->where('status', 0)->get();
        $this->data['join_requests'] = DB::table('website_join_shulesoft')->where('status', 0)->get();
        return view('sales.leads', $this->data);
    }

    public function prospect() {
        $this->data['demo_requests'] = DB::table('website_demo_requests')->where('status', 0)->get();
        $this->data['join_requests'] = DB::table('website_join_shulesoft')->where('status', 0)->get();
        $this->data['page'] = $page = request()->segment(3);
        if ($page == 'add') {
            $id = request()->segment(4);
            if ($_POST) {
                $task_id = DB::table('tasks')->insertGetId(
                        [
                            'activity' => request('message'), 'date' => date('Y-m-d', strtotime(request('action_date'))), 'user_id' => Auth::user()->id, 'action' => request('action'), 'time' => 'now()'
                ]);
                DB::table('prospects')->insert([
                    'school_id' => $id,
                    'title' => request('title'),
                    'name' => request('name'),
                    'email' => request('email'),
                    'phone_number' => request('phone_number'),
                    'software_status' => request('software_status'),
                    'software_name' => request('software_name'),
                    'task_id' => $task_id,
                    'user_id' => Auth::user()->id
                ]);
                return redirect('sales/prospect')->with('success', 'Success');
            }
            return view('sales.add_prospect', $this->data);
        } else if ($page == 'delete') {
            $id = request()->segment(4);
            DB::table('prospects')->where('id', $id)->delete();
            return redirect('sales/prospect')->with('success', 'Success');
        } else if ($page == 'demo') {
            
        } else if ($page == 'join') {
            
        }
        return view('sales.prospects', $this->data);
    }

    public function customer() {
        $this->data['customers'] = DB::table('all_setting')->count();
        $this->data['active_customers'] = DB::table('all_setting')->where('payment_status', 1)->count();
        return view('sales.customers', $this->data);
    }

    function downloadMaterial($type) {

        if ($type == 'shulesoft_brochure') {
            $headers = array(
                'Content-Type: image/jpg',
            );
            $extension = 'jpg';
        } else {
            $headers = array(
                'Content-Type: application/pdf',
            );
            $extension = 'pdf';
        }
        return response()->download("resources/materials/$type.$extension", "$type.$extension", $headers);
    }

    function materials() {
        return view('market.material');
    }

    function legal() {
        return view('market.legal');
    }

    public function school() {
        $this->data['use_shulesoft'] = DB::table('admin.all_setting')->count() - 5;
        $this->data['nmb_schools'] = DB::table('admin.nmb_schools')->count();
        $this->data['nmb_shulesoft_schools'] = \collect(DB::select("select count(distinct schema_name) as count from admin.all_bank_accounts where refer_bank_id=22"))->first()->count;
        $this->data['school_types'] = DB::select("select type, count(*) from admin.schools where ownership='Non-Government' group by type,ownership");
        $this->data['ownerships'] = DB::select('select ownership, COUNT(*) as count, 
SUM(COUNT(*)) over() as total_schools, 
(COUNT(*) * 1.0) / SUM(COUNT(*)) over() as percent
FROM admin.schools
group by ownership');

        return view('market.allocation', $this->data);
    }

    function objective() {
        return view('market.objective');
    }

    function schoolStatus() {
        $id = request()->segment(3);
        if ($id == 'shulesoft') {
            $this->data['title'] = "Schools Alreardy Onboarded";
            $this->data['all_schools'] = DB::table('admin.schools')->whereNotNull('schema_name')->get();
        }
        if ($id == 'bank') {
            $this->data['title'] = "Schools With Bank Payment Integrarion";
            $this->data['all_schools'] = DB::select('select * from admin.schools WHERE schema_name IN (select distinct schema_name from admin.all_bank_accounts where refer_bank_id=22)');
        }
        return view('sales.school_status', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (request('message') != '') {
            $script = $this->pushSMS();
            $message_success = 'Message sent ';
        } else {
            $script = '';
            $message_success = '';
        }
        $usertypes = DB::select('select distinct usertype from admin.all_users');
        return view('message.create', compact('script', 'usertypes', 'message_success'));
    }

    public function pushSMS($slave_schema = null) {
        $skip = request('skip');
        $database = new DatabaseController();
        $skip_schema = preg_match('/,/', $skip) ? explode(',', $skip) : array($skip);
        $db_schema = $database->loadSchema();
        $schemas = $slave_schema == null ? $db_schema : array($slave_schema);
        $q = '';
        $sch = '';

        foreach ($schemas as $key => $value) {
            $sch .= in_array($value->table_schema, $skip_schema) ? '' : "'" . $value->table_schema . "',";
        }
        $list_schema = rtrim($sch, ',');
        $message = request('message');
        if (request('usertype') == '' && strlen(request('userype')) < 3) {
            $in_array = '';
        } else {
            $usr = explode(',', request('usertype'));
            $usr_type = '';
            foreach ($usr as $value) {
                $usr_type .= "'" . $value . "',";
            }
            $type = rtrim($usr_type, ',');
            $in_array = " AND usertype IN (" . $type . ")";
        }
        $sql = "insert into public.sms (body,users_id,type,phone_number) select '{$message}',id,'0',phone from admin.all_users WHERE schema_name::text IN ($list_schema) AND usertype !='Student' {$in_array} AND phone is not NULL ";
        DB::statement($sql);
        return redirect('message/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    public function psms($param) {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show() {
        $page = request('page');
        switch ($page) {
            case 'leads':
                $sql = 'select a.* from admin.leads a join admin.schools b on a.school_id=b.id join admin.users c on c.id=a.user_id join admin.prospects d on d.id=a.prospect_id join admin.tasks e on e.id=a.task_id';
                return $this->ajaxTable('schools', ['b.name'], $sql);
                break;
            case 'schools':
                if ((int) request('type') == 3) {
                    $sql = "select * from (select a.*, (select count(*) from admin.tasks where school_id=a.id) as activities from admin.schools a   where lower(a.ownership) <>'government') a where activities >0";
                } else if ((int) request('type') == 2) {
                    $sql = "select a.*, (select count(*) from admin.tasks where client_id in (select id from admin.clients where username in (select schema_name from admin.all_setting where school_id=a.id))) as activities from admin.schools a   where lower(a.ownership) <>'government' and a.id in (select school_id from admin.all_setting)";
                } else {
                    $sql = "select a.*, (select count(*) from admin.tasks where school_id=a.id) as activities from admin.schools a   where lower(a.ownership) <>'government'";
                }
                return $this->ajaxTable('schools', ['a.name', 'a.region', 'a.ward', 'a.district'], $sql);
                break;
            case 'prospects':
                $sql = "select a.id, b.name, a.title||' '||a.name||' <br/> Email: '||a.email||' , phone: '||a.phone_number  as contact_name, c.name as person_in_charge,  b.region||' '||b.district||' '||b.ward as location, e.created_at as last_activity, e.date || ' at '||e.time as action_date, e.action||' : '|| e.activity as last_message from admin.prospects a join admin.schools b on a.school_id=b.id join admin.users c on c.id=a.user_id join admin.tasks e on e.id=a.task_id";
                return $this->ajaxTable('schools', ['b.name', 'contact_name', 'person_in_charge', 'location', 'last_activity', 'action_date', 'last_message'], $sql);
                break;
            case 'customers':
                //$sql = 'select * fr';
                return $this->ajaxTable('all_setting', ['sname', 'phone', 'address', 'email', 'payment_integrated', 'created_at']);
                break;
            case 'errors':
                $sql = "select * from (select * from admin.error_logs where deleted_at is null order by id desc limit 5000) y where deleted_at is null";
                return $this->ajaxTable('error_logs', ['file', 'error_message', 'route', 'url', 'error_instance', 'created_at', 'schema_name'], $sql);
                break;
            case 'errors_resolved':
                $sql = "select a.*,b.name as resolved_by from admin.error_logs a left join admin.users b on b.id=a.deleted_by where deleted_at is not null";
                return $this->ajaxTable('error_logs', ['file', 'error_message', 'route', 'url', 'error_instance', 'created_at', 'schema_name'], $sql);
                break;
            case 'sms_reply_logs':
                return $this->ajaxTable('all_reply_sms', ['from', 'message', 'table', 'user_id', 'sent_timestamp', 'created_at', 'schema_name']);
                break;
            case 'opened_sms':
                $sql = "select  * from admin.all_reply_sms where opened=1";
                return $this->ajaxTable('error_logs', ['from', 'message', 'table', 'user_id', 'sent_timestamp', 'created_at', 'schema_name'], $sql);
                break;

            case 'requirements':
                $sql = "select b.id, b.activity,b.created_at,a.name,c.firstname  from admin.clients a join admin.tasks b on a.id=b.client_id join admin.users c on c.id=b.to_user_id ";
                return $this->ajaxTable('tasks', ['activity', 'name', 'firstname', 'created_at'], $sql);
                break;
            case 'payments':
                $sql = "select a.id,b.name, a.amount, a.method,a.created_at,a.transaction_id, d.name as bank_name,'Client Payment' as payment_type from admin.payments a join admin.clients b on b.id=a.client_id left join admin.bank_accounts c on c.id=a.bank_account_id left join constant.refer_banks d on d.id=c.refer_bank_id
union all
select a.id,a.payer_name as name, a.amount, 'cash' as method, a.created_at, a.transaction_id, d.name as bank_name, 'Revenue' as payment_type from admin.revenues a left join admin.bank_accounts c on c.id=a.bank_account_id left join constant.refer_banks d on d.id=c.refer_bank_id ";
                return $this->ajaxTable('payments', ['a.id', 'amount', 'name', 'a.created_at'], $sql);
                break;
            case 'tasks':
                $user_id=(int) request('user_id') > 0 ? request('user_id'):Auth::user()->id;
                $sql = "select t.id,substring(t.activity from 1 for 70) as activity,t.date, t.start_date,t.end_date, t.created_at,p.school_name,p.client,u.firstname||' '||u.lastname as user_name, substring(tt.name from 1 for 10) as task_name, t.status,t.priority from admin.tasks t left join (
select a.task_id, c.name as school_name,'Client' as client from admin.tasks_clients a join admin.clients c on c.id=a.client_id
UNION ALL
SELECT b.task_id, s.name as school_name, 'Not Client' as client from admin.tasks_schools b join admin.schools s on s.id=b.school_id ) p on p.task_id=t.id join admin.users u on u.id=t.user_id join admin.task_types tt on tt.id=t.task_type_id where u.id=" .$user_id. " OR t.id in (select task_id from admin.tasks_users where user_id=" .$user_id . " )";
                return $this->ajaxTable('tasks', ['activity', 'u.firstname', 'p.school_name', 't.created_at', 't.date', 'u.lastname','t.start_date','t.end_date'], $sql);
                break;
            default:
                break;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function profile() {
        $id = request()->segment(3);
        if ((int) $id == 0) {
            return false;
        }
        $this->data['school'] = \App\Models\School::find($id);
        if ($_POST) {
            if ((int) request('add_sale') == 1) {
                \App\Models\School::find(request('client_id'))->update(request()->all());
                return redirect()->back()->with('success', 'School record updated successfully');
            } else if ((int) request('add_user') == 1) {
                \App\Models\SchoolContact::create([
                    'name' => request('name'),
                    'email' => request('email'),
                    'phone' => request('phone'),
                    'school_id' => request('school_id'),
                    'user_id' => Auth::user()->id,
                    'title' => request('title')
                ]);
                return redirect()->back()->with('success', 'user recorded successfully');
            } else {
                $data = array_merge(request()->all(), ['user_id' => Auth::user()->id, 'school_id' => request('client_id')]);

                $task = \App\Models\Task::create($data);
                \App\Models\UsersSchool::create([
                    'user_id' => Auth::user()->id, 'school_id' => request('client_id'), 'role_id' => Auth::user()->role->id, 'status' => 1,
                ]);
                $school_id = request('client_id');

                DB::table('tasks_schools')->insert([
                    'task_id' => $task->id,
                    'school_id' => (int) $school_id
                ]);

                return redirect()->back()->with('success', 'Report added successfully');
            }
        }
        return view('sales.profile', $this->data);
    }

    public function updateStudent() {
        $id = request('school_id');
        \App\Models\School::find($id)->update(['students' => request('no')]);
        echo 'success';
    }

    public function request() {
        $type = request()->segment(3);
        $source = request()->segment(4);
        $id = request()->segment(5);
        $table = $source == 'demo' ? 'website_demo_requests' : 'website_join_shulesoft';
        $status = $type == 'attend' ? 1 : 3;
        $info = DB::table($table)->where('id', $id);
        $record = $info->first();
        $info->update(['status' => $status]);
        if ((int) $record->school_id > 0) {
            $data = ['user_id' => Auth::user()->id, 'school_id' => $record->school_id, 'task_type_id' => 6, 'next_action' => 'closed', 'activity' => 'School has been attended and closed'];
            $contact = \App\Models\SchoolContact::where('school_id', $record->school_id)->where('phone', $record->contact_phone)->first();
            if (count($contact) == 0) {
                \App\Models\SchoolContact::create(['name' => $record->contact_name, 'school_id' => $record->school_id, 'email' => $record->contact_email, 'phone' => $record->contact_phone, 'user_id' => Auth::user()->id, 'title' => $record->contact_title]);
            }
            \App\Models\Task::create($data);
        }
        return redirect()->back()->with('success', 'success');
    }

    function addSchool() {
        if ($_POST) {

            $array = [
                'name' => strtoupper(request('name')),
                'ward_id' => request('ward'),
                'ownership' => request('ownership')
            ];
            DB::table('admin.schools')->insert($array);
            return redirect('sales/school')->with('success', request('name') . ' successfully');
        }
        return view('sales.add_school');
    }

    public function onboard() {
        $school_id = request()->segment(3);

        $this->data['school'] = $school = DB::table('admin.schools')->where('id', $school_id)->first();
        $username = preg_replace('/[^a-z]/', null, strtolower($school->name));
        $this->data['staffs'] = DB::table('users')->where('status', 1)->get();
        if ($_POST) {
            $code = rand(343, 32323);

            $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
            if (count($school_contact) == 0) {
                DB::table('admin.school_contacts')->insert([
                    'name' => request('name'), 'email' => request('email'), 'phone' => request('phone'), 'school_id' => $school_id, 'user_id' => Auth::user()->id, 'title' => request('title')
                ]);
                $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
            }
            DB::table('admin.schools')->where('id', $school_id)->update(['students' => request('students')]);

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
                'username' => $username
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

            //add company file

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

            //once a school has been installed, now create an invoice for this school or create a promo code
            if (request('payment_status') == 1) {
                // create an invoice for this school
                $check_booking = DB::table('admin.invoices')->where('client_id', $client_id)->first();
                if (count($check_booking) == 1) {
                    $booking = $check_booking;
                } else {
                    $order_id = time() . $client_id;
                    $client = DB::table('admin.clients')->where('id', $client_id)->first();
                    $total_price = (int) request('students') < 100 ? 100000 : $client->estimated_students * 1000;

                    $order = array("order_id" => $order_id, "amount" => $total_price,
                        'buyer_name' => $client->name, 'buyer_phone' => $client->phone, 'end_point' => '/checkout/create-order', 'action' => 'createOrder', 'client_id' => $client->id, 'source' => $client->id);
                    $this->curlPrivate($order);
                    $booking = DB::table('admin.invoices')->where('order_id', $order_id)->first();
                }
                $this->scheduleActivities($client->id);
                return redirect('sales/customerSuccess/1/' . $booking->id);
            } else {
                //create a trial code for this school
                $trial_code = $client_id . time();
                $client = DB::table('admin.clients')->where('id', $client_id);
                DB::table('admin.clients')->where('id', $client_id)->update(['code' => $trial_code]);
                $user = $client->first();
                $message = 'Hello ' . $user->name . '. Your Trial Code is ' . $trial_code;
                $this->send_sms($user->phone, $message, 1);
                $this->send_email($user->email, 'Success: School Onboarded Successfully', $message);
                $this->scheduleActivities($client->id);
                return redirect('sales/customerSuccess/2/' . $trial_code);
            }
            return redirect('https://' . $username . '.shulesoft.com');
        }
        return view('sales.onboarding_school', $this->data);
    }

    /**
     * Make this very easy for users to get a specific schedule
     * @param type $client_id
     */
    public function scheduleActivities($client_id) {
        return false;
        $sections = \App\Models\TrainingSections::orderBy('id', 'asc')->get();
        foreach ($sections as $section) {
            $data = [
                'activity' => $section->title,
                'date' => date('d-m-Y', strtotime(request('implementation_date'))),
                'user_id' => request('support_user_id'),
                'start_date' => $start_date,
                'end_date' => $end_date
            ];
            $task = \App\Models\Task::create($data);

            DB::table('tasks_users')->insert([
                'task_id' => $task->id,
                'user_id' => request('support_user_id'),
            ]);

            DB::table('tasks_clients')->insert([
                'task_id' => $task->id,
                'client_id' => (int) $client_id
            ]);
            \App\Models\TaskSchedule::create([
                'task_id' => $task->id,
                'training_section_id' => $section->id,
                'client_role' => request(),
            ]);
        }
    }

    //algorithm is very very simple
    /**
     * 1. check that user if he has a task at that particular time
     * 2. if user has a time, return an error to adjust
     * 3. if user does have a time, then fix that initial time there
     * 4. check the specific task has been allocated how many minutes to be accomplished
     * 5. add that minutes to the time specified and fix end datetime
     * 6. if you find occupied time slot in between, add that time slot in between to extend time for end datetime
     * 7. return both, start datetime and end datetime respectively
     */
    public function taskStartTime($start_date, $timeframe, $iterate = false) {

        $end_time = date('d-m-Y H:i', strtotime("+{$timeframe} minutes", time()));
        $start_time = date('d-m-Y H:i', strtotime($start_date));
        $slot_available = \collect(DB::select("SELECT * FROM   admin.tasks WHERE  start_date::timestamp <='" . $start_time . "'::timestamp and end_date::timestamp >='" . $end_time . "'::timestamp"))->first();
        if (count($slot_available) == 1) {
            //slot not available
            // so check the last slot and add next slot for the person to work
            
            return FALSE;
        } else {
            //slot available
            return array($start_date, $end_time);
        }
        if ($iterate == true) {
            
        }
    }

    /**
     * Redirect to this page to finalize onboarding
     */
    public function customerSuccess() {

        $id = request()->segment(3);
        if ((int) $id == 2) {
            $this->data['trial_code'] = request()->segment(4);
            $this->data['client'] = DB::table('admin.clients')->where('code', $this->data['trial_code'])->first();
            if (count($this->data['client']) == 1) {
                return view('sales.customer_success', $this->data);
            } else {

                die('Invalid URL');
            }
        } else {
            $client_id = request()->segment(4);
            $this->data['client'] = $client = \App\Models\Client::where('id', $client_id)->first();
            $this->data['siteinfos'] = DB::table($this->data['client']->username . '.setting')->first();
            $this->data['students'] = $this->data['client']->estimated_students;
            if (count($client) == 1) {
                $this->data['booking'] = $this->data['invoice'] = Invoice::where('client_id', $client->id)->first();
            } else {
                $this->data['booking'] = $this->data['invoice'] = [];
            }

            return view('account.invoice.shulesoft', $this->data);
        }
    }

    public function curlPrivate($fields, $url = null) {
        // Open connection
        $url = 'http://51.77.212.234:8081/api/payment';
        $ch = curl_init();
// Set the url, number of POST vars, POST data

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'application/x-www-form-urlencoded'
        ));

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}

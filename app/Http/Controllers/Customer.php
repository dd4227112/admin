<?php

namespace App\Http\Controllers;

use App\Jobs\PushSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \App\Models\User;
use DB;

use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;

class Customer extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $patterns = array(
        '/#name/i', '/#username/i', '/#default_password/i', '/#email/i', '/#phone/i', '/#role/i', '/#student_name/i', '/#invoice/i', '/#balance/i'
    );

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pg = null) {
        //
        if (method_exists($this, $pg) && is_callable(array($this, $pg))) {
            return $this->$pg();
        } else {
            die('Page under construction');
        }
    }

    function faq() {
        if ((int) request('id') > 0 && request('action') == 'delete') {
            DB::table('faq')->where('id', request('id'))->delete();
            return redirect()->back()->with('success', 'success');
        }
        if ($_POST) {
            $id = DB::table('faq')->insertGetId(['question' => request('question'), 'answer' => request('answer'), 'created_by' => Auth::user()->id]);
            echo $id > 0 ? 'Success' : ' Error, try again later';
        }

        $this->data['faqs'] = DB::table('faq')->get();
        return view('customer.faq', $this->data);
    }

    public function getSlot($user_id, $date) {
        $start_date = date('Y-m-d', strtotime($date));
        $sql = "select * from admin.slots where status=1 and id not in (select slot_id from admin.tasks where slot_id is not null and start_date::date='{$start_date}' and id in (select task_id from admin.tasks_users where user_id={$user_id}) ) order by id asc limit 1 ";
        return \collect(\DB::select($sql))->first();
    }

    function config() {
        $status_id = request('id'); //1=complete, 2 =pending, 3 =not yet
        $schema = request('school_id');
        $train_item_id = request('training_id');
        $client = \App\Models\Client::where('username', $schema)->first();
        $train_item = \App\Models\TrainItem::find($train_item_id);
        //create a tasks in task table
        $time = 0;
        $activity = '';
        if (strtolower($status_id) == 'complete') {
            $activity = 'Complete : ' . $train_item->content;
            $start_date = date('Y-m-d H:i');
            $end_date = date('Y-m-d H:i', strtotime("+{$time} minutes", strtotime($start_date)));
        } else {
            //not yet and pending are tasks needed to be allocated
            $activity = 'Pending Tasks: ' . $train_item->content;
            $time += $train_item->time;
            $end = \App\Models\Task::where('user_id', Auth::user()->id)->orderBy('end_date', 'desc')->first();

            $start_date = !empty($end) && strtotime($end->end_date) > time() ? date('Y-m-d H:i', strtotime("+{$time} minutes", strtotime($end->end_date))) : date('Y-m-d H:i');

            if (date('H', strtotime($start_date)) > 16) {
                //its end of the time, just add a new day
                $sat_add_time = (int) $time + 16 * 60;
                $start_date = date('Y-m-d H:i', strtotime("+{$sat_add_time} minutes", strtotime($start_date)));
            }

            if (date('D', strtotime($start_date)) == 'Sat') {
                //its saturday, so add 48 hours
                $sat_add_time = (int) $time + 48 * 60;
                $start_date = date('Y-m-d H:i', strtotime("+{$sat_add_time} minutes", strtotime($start_date)));
            }

            if (date('l', strtotime($start_date)) == 'Sunday') {
                // its sunday, so add 24 hours
                $sun_add_time = (int) $time + 24 * 60;
                $start_date = date('Y-m-d H:i', strtotime("+{$sun_add_time} minutes", strtotime($start_date)));
            }

            $end_date = date('Y-m-d H:i', strtotime("+{$time} minutes", strtotime($start_date)));
        }
        $slot = $this->getSlot(Auth::user()->id, $start_date);
        $date = date('Y-m-d', strtotime($start_date));
        $data = [
            'activity' => $activity,
            'date' => date('Y-m-d'),
            'user_id' => Auth::user()->id,
            'status' => ucfirst($status_id),
            'task_type_id' => preg_match('/data/i', $activity) ? 3 : 4,
            'start_date' => date('Y-m-d H:i', strtotime($date . ' ' . $slot->start_time)),
            'end_date' => date('Y-m-d H:i', strtotime($date . ' ' . $slot->end_time)),
            'slot_id' => $slot->id
        ];

        $is_selected = $train_item->trainItemAllocation()->where('client_id', $client->id)->orderBy('id', 'desc')->first();
        if (!empty($is_selected)) {
            \App\Models\Task::where('id', $is_selected->task->id)->update([
                'activity' => $activity,
                'user_id' => Auth::user()->id,
                'status' => ucfirst($status_id)
            ]);
            echo 'updated';
        } else {
            $task = \App\Models\Task::create($data);

            DB::table('tasks_users')->insert([
                'task_id' => $task->id,
                'user_id' => Auth::user()->id,
            ]);

            DB::table('tasks_clients')->insert([
                'task_id' => $task->id,
                'client_id' => (int) $client->id
            ]);
            \App\Models\TrainItemAllocation::create([
                'task_id' => $task->id,
                'client_id' => $client->id,
                'user_id' => Auth::user()->id,
                'train_item_id' => $train_item->id,
                'school_person_allocated' => '',
                'max_time' => $train_item->time
            ]);
            //insert into training allocation
            $this->send_email(Auth::user()->email, 'Task Allocation', $activity . ' <br/>Start Date: ' . $start_date . ' <br/>End Date: ' . $end_date);
            echo 'success';
        }
    }

    function setup() {
        return $this->types();
        if (request('type')) {
            echo json_encode(array('data' =>
                array(
                    array('James John', 'PZ-32', '0714852214', 'juma', '1', '3'),
                    array('Ana Juma', 'PQ-44', '0144555', 'CHEMCHEM', 'AMBAKISYE', 'TAUNI'),
                )
            ));
        } else {
            $this->data['schools'] = DB::select("SELECT distinct table_schema as schema_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema NOT IN ('admin','beta_testing','accounts','pg_catalog','constant','api','information_schema','public')");
            return view('customer.setup', $this->data);
        }
    }

    function typeConfig() {
        $classlevel_id = request('classlevel_id'); //1=complete, 2 =pending, 3 =not yet
        $schema = request('schema_name');
        $value_id = request('value_id');

        \DB::table($schema . '.classlevel')->where('classlevel_id', $classlevel_id)->update([request('tag') => (int) $value_id]);
        echo 'success';
    }

    function types() {

        if (request('type')) {
            echo json_encode(array('data' =>
                array(
                    array('James John', 'PZ-32', '0714852214', 'juma', '1', '3'),
                    array('Ana Juma', 'PQ-44', '0144555', 'CHEMCHEM', 'AMBAKISYE', 'TAUNI'),
                )
            ));
        } else {
            $this->data['schools'] = DB::select("SELECT * FROM admin.all_classlevel");
            return view('customer.types', $this->data);
        }
    }

    public function editTrain() {
        $task_id = request('task_id');
        $user_id = request('user_id');
        $start_date = request('start_date');
        $end_date = request('end_date');
        $attr = request('attr');
        $value = request('value');
        if ((int) $user_id > 0 && (int) $task_id > 0) {
            $task = \App\Models\Task::find($task_id)->update(['user_id' => $user_id, 'updated_at' => date('Y-m-d H:i:s')]);
            DB::table('tasks_users')->where('task_id', $task_id)->update([
                'user_id' => $user_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            \App\Models\TrainItemAllocation::where('task_id', $task_id)->update([
                'user_id' => $user_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        if ($attr == 'school_person' && (int) $task_id > 0) {
            \App\Models\TrainItemAllocation::where('task_id', $task_id)->update([
                'school_person_allocated' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        if ($attr == 'start_date' && (int) $task_id > 0) {
            $slot_id = request('slot_id');
            $slot = DB::table('admin.slots')->where('id', $slot_id)->first();
            $obj = [
                'start_date' => date('Y-m-d H:i', strtotime($value . ' ' . $slot->start_time)),
                'end_date' => date('Y-m-d H:i', strtotime($value . ' ' . $slot->end_time)),
                'updated_at' => date('Y-m-d H:i:s'),
                'slot_id' => $slot_id];
            \App\Models\Task::find($task_id)->update($obj);
            die(json_encode(array_merge(array('task_id' => $task_id), $obj)));
        }
        if ($attr == 'end_date' && (int) $task_id > 0) {
            \App\Models\Task::find($task_id)->update(['end_date' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
        }
        //insert into training allocation
        echo 'success';
    }

    public function getData() {
        if (request('tag') == 'users') {
            $req = [];
            $users = DB::select('select count(*),"table","schema_name" from admin.all_users  where "table" !=\'setting\'  group by "table","schema_name" order by "table"');
            foreach ($users as $user) {
                $obj = [$user->schema_name, $user->parent, $user->student, $user->user, $user->teacher];
                array_push($req, $obj);
            }
        }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createGuide() {
        $obj = [
            'permission_id' => request()->permission_id,
            'content' => str_replace('src="../../storage/images', 'src="' . url('/') . '/storage/images', request()->content),
            'created_by' => Auth::user()->id,
            'language' => 'eng'
        ];
        DB::table('constant.guides')->insert($obj);
        return redirect('customer/guide');
    }

    public function psms($param) {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $page = null) {
        //

        if (method_exists($this, $id) && is_callable(array($this, $id))) {
            return $this->$id();
        } else {
            die('Page under construction');
        }
    }

    public function getPermission() {
        $group_id = request('group_id');
        $permissions = \DB::table('constant.permission')->where('permission_group_id', $group_id)->get();
        foreach ($permissions as $value) {
            echo '<input type="radio" name="permission_id" value="' . $value->id . '" />' . $value->display_name;
        }
    }

    public function guide() {
        if (request()->segment(3) == 'delete') {
            \App\Model\Guide::find(request()->segment(4))->delete();
            return redirect()->back();
        } else if (request('pg') == 'add') {
            $this->data['guides'] = [];
            $page = 'add_guide';
        } else if (request()->segment(3) == 'edit') {
            $this->data['guide'] = \App\Model\Guide::find(request()->segment(4));
            $page = 'edit_guide';
            if ($_POST) {
                $request = request()->all();

                $obj = [
                    'permission_id' => request()->permission_id,
                    'content' => str_replace('src="../../../storage/images', 'src="' . url('/') . '/storage/images', request()->content),
                    "is_edit" => request()->is_edit,
                    'language' => 'eng'
                ];
                \App\Model\Guide::find(request('guide_id'))->update($obj);
                return redirect('customer/guide');
            }
        } else {
            $page = 'guide';
            $this->data['guides'] = \App\Model\Guide::all();
        }
        return view('customer.' . $page, $this->data);
    }

    public function parents() {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update() {

        $this->data['faqs'] = DB::table('faq')->get();
        return view('customer.message.updates', $this->data);
    }

    public function createUpdate() {
        if ($_POST) {
            $this->validate(request(), [
                'for' => 'required',
                'message' => 'required',
                'release_date' => 'date'
            ]);
            DB::table('admin.updates')->insert(array_merge(request()->except(['_token', '_wysihtml5_mode', 'for', 'subject']), ['for' => implode(',', request('for'))]));

            $users = DB::table('all_users')->whereIn('usertype', request('for'))->where('table', '<>', 'setting')->where('status', 1)->get();
            foreach ($users as $user) {

                $replacements = array(
                    $user->name
                );
                $sms = $this->getCleanSms($replacements, strip_tags(request('message')));

                if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                    DB::table($user->schema_name . '.email')->insert(array(
                        'email' => $user->email,
                        'body' => str_replace('href="', 'href="' . $user->schema_name . '.shulesoft.com/', $sms),
                        'subject' => strlen(request('subject')) > 4 ? request('subject') : 'ShuleSoft Latest Updates: ' . request('release_date'),
                        'user_id' => $user->id,
                        'table' => $user->table
                    ));
                }
                DB::table($user->schema_name . '.sms')->insert(array(
                    'phone_number' => $user->phone,
                    'body' => $sms,
                    'table' => $user->table,
                    'user_id' => $user->id,
                ));
            }

            return redirect('customer/update')->with('success', 'success');
        }
        $this->data['usertypes'] = DB::select('select distinct usertype from admin.all_users');
        return view('customer.message.add_updates', $this->data);
    }

    public function getCleanSms($replacements, $message) {
        $sms = preg_replace($this->patterns, $replacements, $message);
        if (preg_match('/#/', $sms)) {
            //try to replace that character
            return preg_replace('/\#[a-zA-Z]+/i', '', $sms);
        } else {
            return $sms;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function report() {
        return view('customer.training.report');
    }

    public function usage() {
        return view('customer.usage');
    }

    public function profile() {
        $school = $this->data['schema'] = request()->segment(3);
        $id = request()->segment(4);
        $this->data['shulesoft_users'] = \App\Models\User::where('status', 1)->where('role_id', '<>', 7)->get();
        $is_client = 0;
        if ($school == 'school') {
            $id = request()->segment(4);
            $this->data['client_id'] = $id;
            $this->data['school'] = \collect(DB::select('select name as sname, name,schema_name, region , ward, district as address  from admin.schools where id=' . $id))->first();
        } else {
            $is_client = 1;
            $this->data['school'] = DB::table($school . '.setting')->first();
            $this->data['levels'] = DB::table($school . '.classlevel')->get();
            $client = \App\Models\Client::where('username', $school)->first();
            if (empty($client)) {
                $client = \App\Models\Client::create(['name' => $this->data['school']->sname, 'email' => $this->data['school']->email, 'phone' => $this->data['school']->phone, 'address' => $this->data['school']->address, 'username' => $school, 'created_at' => date('Y-m-d H:i:s')]);
            }
            $this->data['client_id'] = $client->id;

            $this->data['top_users'] = DB::select('select count(*), user_id,a."table",b.name,b.usertype from ' . $school . '.log a join ' . $school . '.users b on (a.user_id=b.id and a."table"=b."table") where user_id is not null group by user_id,a."table",b.name,b.usertype order by count desc limit 5');
        }
        $this->data['profile'] = \App\Models\ClientSchool::where('client_id', $client->id)->first();

        $this->data['is_client'] = $is_client;

        $year = \App\Models\AccountYear::where('name', date('Y'))->first();
        $this->data['invoices'] = \App\Models\Invoice::where('client_id', $client->id)->where('account_year_id', $year->id)->get();

        if ($_POST) {
            $data = array_merge(request()->except(['start_date', 'end_date']), ['user_id' => Auth::user()->id, 'start_date' => date("Y-m-d H:i:s", strtotime(request('start_date'))), 'end_date' => date("Y-m-d H:i:s", strtotime(request('end_date')))]);
            $task = \App\Models\Task::create($data);
            if ((int) request('to_user_id') > 0) {
                DB::table('tasks_users')->insert([
                    'task_id' => $task->id,
                    'user_id' => request('to_user_id')
                ]);
                $user = \App\Models\User::find(request('to_user_id'));
                $message = 'Hello ' . $user->firstname . '<br/>'
                        . 'A task has been allocated to you'
                        . '<ul>'
                        . '<li>Task: ' . $task->activity . '</li>'
                        . '<li>Type: ' . $task->taskType->name . '</li>'
                        . '<li>Deadline: ' . $task->start_date . '</li>'
                        . '</ul>';
                $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);
            }

            DB::table('tasks_clients')->insert([
                'task_id' => $task->id,
                'client_id' => (int) request('client_id')
            ]);
            if (!empty($task->id) && request('module_id')) {
                $modules = request('module_id');
                foreach ($modules as $key => $value) {
                    if (request('module_id')[$key] != '') {
                        $array = ['module_id' => request('module_id')[$key], 'task_id' => $task->id];
                        $check_unique = \App\Models\ModuleTask::where($array);
                        if (empty($check_unique->first())) {
                            \App\Models\ModuleTask::create($array);
                        }
                    }
                }
            }
            return redirect('customer/profile/' . $school)->with('success', 'success');
        }
        if ((int) $id > 0) {
            return view('customer/addtask', $this->data);
        } else {
            return view('customer/profile', $this->data);
        }
    }

 

    public function createSI() {
        if ($_POST) {
           $file = request('standing_order_file');
           $company_file_id = $file  ? $this->saveFile($file, 'company/contracts') : 1;
           // $company_file_id = 1;
            $data = [
                'client_id' => request('client_id'),
                'branch_id' => request('branch_id'),
                'company_file_id' => $company_file_id,
                'school_contact_id' => request('school_contact_id'),
                'created_by' => Auth::user()->id,
                'occurrence' => request('number_of_occurrence'),
                'type' => request('which_basis'),
                'total_amount' => remove_comma(request('total_amount')),
                'occurance_amount' => remove_comma(request('occurance_amount')),
                'payment_date' => request('maturity_date'),
                'refer_bank_id' => request('refer_bank_id'),
                'note' => request('note'),
                'contract_type_id' => 8
            ];  
            DB::table('standing_orders')->insert($data);
            return redirect('account/standingOrders')->with('success', 'Standing order added successfully!');
        }
        
    }


    public function activity() {
        $tab = request()->segment(3);
        $id = request()->segment(4);
        if ($tab == 'add') {
            $this->data['types'] = DB::table('task_types')->where('department', Auth::user()->department)->get();
            $this->data['departments'] = DB::table('departments')->get();
            if ($_POST) {
               // $random = time();
             
                $data = array_merge(request()->except(['to_user_id','start_date', 'end_date']), 
                ['user_id' => Auth::user()->id, 'start_date' => date("Y-m-d H:i:s", strtotime(request('start_date'))), 
                'end_date' => date("Y-m-d H:i:s", strtotime(request('end_date')))]);
               
                $task = \App\Models\Task::create($data);
                $users = request('to_user_id');
                if (!empty($users)) {
                    foreach ($users as $user_id) {
                        DB::table('tasks_users')->insert([
                            'task_id' => $task->id,
                            'user_id' => $user_id
                        ]);
                        $user = \App\Models\User::find($user_id);
                        $message = 'Hello ' . $user->firstname . '<br/>'
                                . 'A task has been allocated to you'
                                . '<ul>'
                                . '<li>Task: ' . $task->activity . '</li>'
                                . '<li>Type: ' . $task->taskType->name . '</li>'
                                . '<li>Deadline: ' . $task->date . '</li>'
                                . '</ul>';
                        $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);
                    }
                }
                $school_id = request('school_id');
                if (preg_match('/c/i', $school_id)) {

                    DB::table('tasks_clients')->insert([
                        'task_id' => $task->id,
                        'client_id' => (int) $school_id
                    ]);
                }
                if ((int) $school_id > 0 && !preg_match('/c/i', $school_id)) {

                    DB::table('tasks_schools')->insert([
                        'task_id' => $task->id,
                        'school_id' => (int) $school_id
                    ]);
                }
                if (!empty($task->id) && request('module_id')) {
                    $modules = request('module_id');
                    foreach ($modules as $key => $value) {
                        if (request('module_id')[$key] != '') {
                            $array = ['module_id' => request('module_id')[$key], 'task_id' => $task->id];
                            $check_unique = \App\Models\ModuleTask::where($array);
                            if (empty($check_unique->first())) {
                                \App\Models\ModuleTask::create($array);
                            }
                        }
                    }
                }
//                tasks_schedules::create([
//                    'task_id',
//                    'training_section_id',
//                    'client_role',
//                ]);
                //If we schedule this task, save this into schedule and add details to label it

                return redirect('customer/activity')->with('success', 'success');
            }

            return view('customer/addtask', $this->data);
        } elseif ($tab == 'show' && $id > 0) {
            $this->data['activity'] = \App\Models\Task::findOrFail($id);
            $this->data['client'] = \App\Models\TaskClient::where('task_id', $id)->first();
            $this->data['school'] = \App\Models\TaskSchool::where('task_id', $id)->first();
            return view('customer/view_task', $this->data);
        } else {
            $date = request('taskdate');

            $this->data['activities'] = [];
            return view('customer/activity', $this->data);
        }
    }



    public function getschools() {
        $sql = "SELECT A.id,upper(A.name)|| ' '||upper(A.type) as name, CASE WHEN B.client_id is not null THEN 1 ELSE 0 END AS client FROM admin.schools A left join admin.client_schools B on A.id = B.school_id WHERE lower(A.name) LIKE '%" . str_replace("'", null, strtolower(request('term'))) . "%' LIMIT 10";
        die(json_encode(DB::select($sql)));
    }

        public function choices(){
            $type = request('type');
            if($type == 'year'){
                 if (Auth::user()->role_id == 1) {
            $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->whereYear('updated_at', date('Y'))->orderBy('updated_at', 'desc')->get();
                 } else {
            $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->where('user_id',Auth::user()->id)->whereYear('updated_at', date('Y'))->orderBy('updated_at', 'desc')->get();  
                 }
            } else if($type == 'quoter'){
                $date = \Carbon\Carbon::today()->subDays(120);
                if (Auth::user()->role_id == 1){
                    $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->where('updated_at','>=',$date)->orderBy('updated_at', 'desc')->get();
                } else {
                      $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->where('user_id',Auth::user()->id)->where('updated_at','>=',$date)->orderBy('updated_at', 'desc')->get();
                }
            } else if($type == 'month'){
                   if (Auth::user()->role_id == 1){
                     $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->whereMonth('updated_at', Carbon::now()->month)->whereYear('updated_at', date('Y'))->orderBy('updated_at', 'desc')->get();
                   } else{
                     $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->where('user_id',Auth::user()->id)->whereMonth('updated_at', Carbon::now()->month)->whereYear('updated_at', date('Y'))->orderBy('updated_at', 'desc')->get();
                   }
            } else if($type == 'week'){
                 if (Auth::user()->role_id == 1){
                    $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('updated_at', 'desc')->get();
                 } else{
                    $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->where('user_id',Auth::user()->id)->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('updated_at', 'desc')->get();
                 }
            } else if($type == 'yesterday'){
                if (Auth::user()->role_id == 1){
                     $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->whereDate('updated_at', Carbon::yesterday())->orderBy('updated_at', 'desc')->get();
                } else{
                     $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->where('user_id',Auth::user()->id)->whereDate('updated_at', Carbon::yesterday())->orderBy('updated_at', 'desc')->get();
                }
            } else if($type == 'today') {
                if (Auth::user()->role_id == 1){
                    $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->whereDate('updated_at', Carbon::today())->orderBy('updated_at', 'desc')->get();
                } else{
                    $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->where('user_id',Auth::user()->id)->whereDate('updated_at', Carbon::today())->orderBy('updated_at', 'desc')->get();
                }
            } else{
                if (Auth::user()->role_id == 1){
                   $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->orderBy('updated_at', 'desc')->limit(100)->get();
                } else {
                    $this->data['completetasks']  = \App\Models\Task::where('status', 'complete')->where('user_id',Auth::user()->id)->orderBy('updated_at', 'desc')->limit(100)->get();
                }
            }
            return view('customer.activity', $this->data);
        }

    public function changeStatus() {
        if (request('status') == 'complete') {
            \App\Models\Task::where('id', request('id'))->update(['status' => request('status'), 'end_date' => date("Y-m-d H:i:s"), 'updated_at' => 'now()']);
        } else {
            \App\Models\Task::where('id', request('id'))->update(['status' => request('status'), 'updated_at' => 'now()']);
        }
        $users = DB::table('tasks_users')->where('task_id', request('id'))->get();
        if (!empty($users)) {

            $task = \App\Models\Task::find(request('id'));
            foreach ($users as $user_task) {

                $user = \App\Models\User::find($user_task->user_id);
                $message = 'Hello ' . $user->firstname . '<br/>'
                        . 'Task Status has been updated to :' . request('status')
                        . '<ul>'
                        . '<li>Task: ' . $task->activity . '</li>'
                        . '<li>Type: ' . $task->taskType->name . '</li>'
                        . '<li>Deadline: ' . $task->date . '</li>'
                        . '</ul>';
                $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);
            }
        }
        echo request('status');
    }



    public function changepriority() {
         if(request('priority') == 1){
            $priority = "High";
         } else if(request('priority') == 2){
            $priority = "Medium";
         } else{
            $priority = "Less";
         }
        \App\Models\Task::where('id', request('id'))->update(['priority' => request('priority'), 'updated_at' => 'now()']);
        
        $users = DB::table('tasks_users')->where('task_id', request('id'))->get();
        if (!empty($users)) {
            $task = \App\Models\Task::find(request('id'));
            foreach ($users as $user_task) {
                $user = \App\Models\User::find($user_task->user_id);
                $message = 'Hello ' . $user->firstname . '<br/>'
                        . 'Task Priority has been updated to :' . $priority
                        . '<ul>'
                        . '<li>Task: ' . $task->activity . '</li>'
                        . '<li>Type: ' . $task->taskType->name . '</li>'
                        . '<li>Deadline: ' . $task->date . '</li>'
                        . '</ul>';
                $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);
            }
        }
        echo $priority;
    }

    public function getTaskByDepartment() {
        $dep_id = request('dep_id');
        $types = DB::table('task_types')->where('department', $dep_id)->get();
        $select = '';
        if (!empty($types)) {
            foreach ($types as $type) {
                $select .= '<option value="' . $type->id . '"> ' . $type->name . '</option>';
            }
            echo $select;
        } else {
            $types = DB::table('task_types')->where('department', Auth::user()->department)->get();
            $select = '';
            foreach ($types as $type) {
                $select .= '<option value="' . $type->id . '"> ' . $type->name . '</option>';
            }
            echo $select;
        }
    }

    public function removeTag() {
        $id = request('id');
        $tag = \App\Models\Task::find($id);
        !empty($tag) ? $tag->delete() : '';
        echo 1;
    }

    public function updateTask() {
        $id = request('id');
        $action = request('action');
        \App\Models\Task::where('id', $id)->update(['status' => $action]);
        echo '<small style="color: red">Success</small>';
    }

    public function allocate() {
        $school_id = request('school_id');
        $schema = request('schema');
        $user_id = request('user_id');
        $role_id = request('role_id');
        $date = date("Y-m-d H:i:s");
        if (strlen($schema) > 2) {
            if ((int) $role_id == 5) {
                $sch = DB::table($schema . '.setting')->update(['source' => request('val')]);
                echo 1;
                exit;
            }
            if ((int) $school_id == 0) {
                $sch = DB::table('admin.all_setting')->where('schema_name', $schema)->first();
                $obj = DB::table('schools')->where('name', 'ilike', '%' . substr($schema, 0, 4) . '%')->first();
                $school_id = !empty($sch) ? $sch->school_id : '';
                //$school=count($obj) == 1 ? $obj->id :'';
            }
            if ((int) $school_id == 0) {
                //this school does not exists, try to add it in a list of schols
                $school_id = DB::table('schools')->insertGetId(['name' => $schema, 'ownership' => 'Non-Government', 'schema_name' => $schema]);
            }
            $school_info = DB::table('clients')->where('username', $schema)->first();
            if (!empty($school_info)) {
                $check = DB::table('user_clients')->where('client_id', $school_info->id)->orderBy('created_at', 'desc')->first();
                if (!empty($check)) {
                    if ($check->user_id <> $user_id) {
                        DB::table('user_clients')->where('id', $check->id)->update(['status' => 0]);
                        DB::table('user_clients')->insert(['client_id' => $school_info->id, 'user_id' => $user_id, 'status' => 1]);
                    } else {
                        DB::table('user_clients')->where('id', $check->id)->update(['user_id' => $user_id, 'updated_at' => $date, 'status' => 1]);
                        echo "Success Updated";
                    }
                } else {
                    DB::table('user_clients')->insert(['client_id' => $school_info->id, 'user_id' => $user_id, 'status' => 1]);
                    echo "Success Added";
                }
                DB::table($schema . '.setting')->update(['school_id' => $school_id]);
            } else {
                echo "Failed to Add";
            }
        } else {
            echo "Failed";
        }
    }

    public function requirements() {

        $tab = request()->segment(3);
        $id = request()->segment(4);
        if ($tab == 'show' && $id > 0) {
            $this->data['requirement'] = \App\Models\Requirement::where('id', $id)->first();
            $this->data['next'] = \App\Models\Requirement::whereNotIn('id', [$id])->where('status', 'New')->first()->id;
            return view('customer/view_requirement', $this->data);
        }
        $this->data['levels'] = [];
        if ($_POST) {

            $data = array_merge(request()->all(), ['user_id' => Auth::user()->id]);

            $req = \App\Models\Requirement::create($data);
            if ((int) request('to_user_id') > 0) {

                $user = \App\Models\User::find(request('to_user_id'));
                $message = 'Hello ' . $user->name . '<br/><br/>'
                        . 'There is New School Requirement from ' . $req->school->name . ' (' . $req->school->region . ')'
                        . '<br/><br/><p><b>Requirement:</b> ' . $req->note . '</p>'
                        . '<br/><br/><p><b>By:</b> ' . $req->user->name . '</p>';
                $this->send_email($user->email, 'ShuleSoft New Customer Requirement', $message);
            }
        }
        $this->data['requirements'] = \App\Models\Requirement::orderBy('id', 'DESC')->get();
        return view('customer/analysis', $this->data);
    }

    public function updateReq() {
        $id = request('id');
        $action = request('action');
        \App\Models\Requirement::where('id', $id)->update(['status' => $action]);
        return redirect()->back()->with('success', 'success');
    }

    public function modules() {
        //    $schemas = $this->data['schools'] = DB::select("SELECT distinct table_schema as schema_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema NOT IN ('admin','accounts','pg_catalog','constant','api','information_schema','public')");
        //    Remove comment if you want support person to see only schools allocated to them
        //  if (Auth::user()->department == 1) {
        // $schemas = $this->data['schools'] = DB::select("SELECT distinct schema_name FROM admin.all_setting WHERE schema_name NOT IN ('admin','accounts','pg_catalog','constant','api','information_schema','public') and schema_name in (select schema_name from users_schools where user_id=" . Auth::user()->id . "  and status=1)");
        //   } else {
        $schemas = $this->data['schools'] = DB::select("SELECT distinct schema_name FROM admin.all_setting WHERE schema_name NOT IN ('admin','accounts','pg_catalog','constant','api','information_schema','public','academy','forum') ");
        //  }

        $sch = [];
        foreach ($schemas as $schema) {
            array_push($sch, $schema->schema_name);
        }
        if ($_POST) {
            $schools = trim(rtrim(request('schools'), ','), ',');
            $message = request('message');
            $usr = request('usertype');
            $usr_type = '';
            $schema_name = '';
            foreach (explode(',', $schools) as $val) {
                $schema_name .= "'" . $val . "',";
            }
            $schema = trim(rtrim($schema_name, ','), ',');
            if (!empty($usr)) {
                foreach ($usr as $val) {
                    $usr_type .= "'" . $val . "',";
                }
                $type = rtrim($usr_type, ',');
                $in_array = " AND usertype IN (" . $type . ")";
            } else {
                $in_array = '';
            }
            $patterns = array(
                '/#name/i', '/#username/i'
            );
            $replacements = array(
                "'||name||'", "'||username||'"
            );
            $sms = preg_replace($patterns, $replacements, $message);

            $sql = "insert into public.sms (body,user_id,type,phone_number) select '{$sms}',id,'0',phone from admin.all_users WHERE schema_name::text IN ($schema) AND usertype !='Student' {$in_array} AND  phone is not NULL  AND \"table\" !='student' ";
            DB::statement($sql);
            $email_sql = "insert into public.email (subject,body,user_id,email) select 'ShuleSoft Notification', '{$sms}',id,email from admin.all_users WHERE schema_name::text IN ($schema) AND usertype !='Student' {$in_array} AND  phone is not NULL  AND \"table\" !='student' ";
            DB::statement($email_sql);
        }
        $this->data['dschools'] = \App\Models\School::whereIn('schema_name', $sch)->get();
        return view('customer.modules', $this->data);
    }

    public function taskComment() {
        if (request('content') != '' && (int) request('task_id') > 0) {
            \App\Models\TaskComment::create(array_merge(request()->all(), ['user_id' => Auth::user()->id]));
            echo ' <div class="media m-b-20"><a class="media-left" href="#"><img class="media-object img-circle m-r-20" src="' . url('/') . '/public/assets/images/avatar-1.png" alt="Image"></a> <div class="media-body b-b-muted social-client-description"><div class="chat-header">' . Auth::user()->name . '<span class="text-muted">' . date('d M Y') . '</span></div><p class="text-muted">' . request('content') . '</p></div> </div>';
        }
    }

    public function calls() {
        $schema = request()->segment(3);
        $where = strlen($schema) > 3 ? ' where "schema_name"=\'' . $schema . '\' ' : '';
        $this->data['call_logs'] = DB::select('select * from admin.calls ' . $where);
        $this->data['danger_schema'] = \collect(DB::select('select count(*), "schema_name" from admin.calls  group by "schema_name" order by count desc limit 1 '))->first();
        $this->data['schools_connected'] = DB::select('select count(*), "table" from admin.calls  group by "table" order by "table"');
        return view('customer.call.index', $this->data);
    }

    public function logs() {
        $this->data['start'] = request('start_date');
        $this->data['end'] = request('end_date');
        $this->data['schema'] = request('schema');
        $this->data['user'] = request('usertype');
        $this->data['schemas'] = (new \App\Http\Controllers\Software())->loadSchema();
        $this->data['users'] = DB::table('admin.all_users')->distinct('usertype')->get(['usertype']);
        $this->data['data'] = DB::select('select count(*) as total_logs,"schema_name"::text from admin.all_log group by "schema_name"::text order by count(*)');
        return view('customer.logsummary', $this->data);
    }

    public function pages() {
        $this->data['start'] = request('start_date');
        $this->data['end'] = request('end_date');
        $this->data['schema'] = request('schema');
        $this->data['user'] = request('usertype');
        $this->data['schemas'] = (new \App\Http\Controllers\Software())->loadSchema();
        $this->data['users'] = DB::table('admin.all_users')->distinct('usertype')->get(['usertype']);
        $this->data['data'] = DB::select('select count(*) as total_logs,"schema_name"::text from admin.all_log group by "schema_name"::text order by count(*)');
        return view('customer.logsummary', $this->data);
    }

    public function karibu() {

        $this->data['clients'] = DB::connection('karibusms')->table('client')->whereNotNull('keyname')->get();
        $this->data['shulesoft'] = DB::connection('karibusms')->table('client')->where('client_id', 318)->first();
        if ((int) request()->segment(3) > 0) {
            $client_id = request()->segment(3);
            DB::connection('karibusms')->table('client')->where('client_id', $client_id)->update([
                'gcm_id' => $this->data['shulesoft']->gcm_id
            ]);
            return redirect()->back()->with('success', 'success');
        }
        return view('customer.karibusms', $this->data);
    }

    public function feedbacks() {
        $feedbacks = \App\Model\Feedback::orderBy('id', 'desc')->paginate();
        return view('customer.feedback', compact('feedbacks'));
    }

    public function sequence() {
        $this->data['sequences'] = \App\Models\Sequence::all();
        return view('customer.training.sequence', $this->data);
    }

    public function updateProfile() {
        $schema = request('schema');
        $tag = request('tag');
        $table = 'clients';
        $user_id = request('user_id');
        $value = request('val');
       // dd($value);
        $column = 'username';
        if ($table == 'bank') {
            return $this->setBankParameters();
        } else {
            $table == 'setting' ? DB::table($schema . '.' . $table)->update([$tag => $value]) : 
            DB::table($table)->where($column, $schema)->update([$tag => $value]);
                          
            if ($tag == 'institution_code') {
                //update existing invoices
                DB::statement('UPDATE ' . $schema . '.invoices SET "reference"=\'' . $value . '\'||"reference"');
            }
            echo '<b class="label label-success">success</b>';
        }
    }

    public function training() {
        $type = request()->segment(3);
        $this->data['trainings'] = \App\Models\Training::all();
        return view('customer.training.guide.' . $type, $this->data);
    }

    public function search() {
        $val = request('val');
        $schema = request('schema');
        if (strlen($val) > 3) {
            $schools = DB::select('select * from admin.schools where lower("name") like \'%' . strtolower($val) . '%\'');
            if (!empty($schools)) {
                foreach ($schools as $school) {

                    echo '<p><a href="' . url('customer/map/' . $schema . '/' . $school->id) . '">' . $school->name . '( ' . $school->region . ' )</a></p>';
                }
            }
        } else {
            echo '<p id="new_id"> This School does not exist <button type="button" class="btn btn-link">Click to add</button></p>';
        }
    }

    public function schoolStatus() {
        if ($_POST) {
            $schema = request('schema_name');
            $status = request('status');
            if ((int) $status > 0) {
                DB::table($schema . '.setting')->update(['school_status' => $status]);
                return redirect()->back()->with('success', $schema . ' Status Updated successfuly');
            }
        }
    }

    public function resetPassword() {
        $schema = request()->segment(3);
        if ($schema != '') {
            $pass = $schema . rand(5697, 33);
            $username = $schema . date('Hi');
            DB::table($schema . '.setting')->update(['password' => bcrypt($pass), 'username' => $username]);
            $this->data['school'] = DB::table($schema . '.setting')->first();
            $this->data['schema'] = $schema;
            $this->data['pass'] = $pass;
            return view('customer.view', $this->data)->with('success', 'Password Updated Successfully');
        } else {
            return redirect()->back()->with('warning', 'Please Define Specific School');
        }
    }

    public function map() {
        $schema = request()->segment(3);
        $school_id = request()->segment(4);
        DB::table($schema . '.setting')->update(['school_id' => $school_id]);
        return redirect()->back()->with('success', 'success');
    }

    public function emailsms() {
        $schema = request()->segment(3);
        $where = strlen($schema) > 3 ? ' where "schema_name"=\'' . $schema . '\' ' : '';
        $this->data['sms_logs'] = DB::select('select * from admin.all_reply_sms ' . $where);
        $this->data['danger_schema'] = \collect(DB::select('select count(*), "schema_name" from admin.all_reply_sms  group by "schema_name" order by count desc limit 1 '))->first();
        $this->data['user_groups'] = DB::select('select count(*), "table" from admin.all_reply_sms  group by "table" order by "table"');
        return view('customer.message.incoming_sms', $this->data);
    }

    public function epayments() {
        $schema = request()->segment(3);
        $where = strlen($schema) > 3 ? ' and "schema_name"=\'' . $schema . '\' ' : '';
        $this->data['epayment_logs'] = DB::select('select * from admin.all_payments where token is not null ' . $where);
        $this->data['danger_schema'] = \collect(DB::select('select count(*), "schema_name" from admin.all_payments where token is not null  group by "schema_name" order by count desc limit 1 '))->first();
        $this->data['schools_connected'] = \collect(DB::select('select count(*) as count from admin.all_setting where payment_integrated=1 '))->first()->count;
        return view('customer.epayment.index', $this->data);
    }

    public function addCall() {
        $this->data['create'] = [];
        if (request('file')) {
            $path = request()->file('file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                        
                    })->get();
            $insert_data = [];
            if (!empty($data) && $data->count()) {

                foreach ($data->toArray() as $key => $value) {
                    /**
                     * add these filters
                     * 
                     * 1. ensure no duplicates are recorded
                     * 2. ensure you match phone number with what is in the system and update according
                     * 
                     * all those will be done with updated query outise for each
                     */
                    if (!empty($value) && isset($value['number'])) {
                        $obj = (object) $value;
                        $phone = validate_phone_number($obj->number);
                        if (!is_array($phone)) {
                            continue;
                        }
                        $object = [
                            'name' => $obj->name,
                            'number' => $phone[1],
                            'type' => $obj->call_type,
                            'time' => $obj->time,
                            'duration' => $obj->durationseconds,
                            'created_by' => \Auth::user()->id,
                            'about' => request('about'),
                        ];
                        array_push($insert_data, $object);
                    }
                }
                if (!empty($insert_data)) {
                    DB::table('calls')->insert($insert_data);
                    return back()->with('success', 'Insert Record successfully.');
                }
            }
        } else if ($_POST) {
            $table = request('source');
            $phone = validate_phone_number(request('phone'));
            if (!is_array($phone)) {
                return redirect()->back()->with('error', 'This phone number is not valid ');
            }
            $object = [
                'name' => request('name'),
                'number' => $phone[1],
                'type' => request('type'),
                'time' => request('date'),
                'schema_name' => request('schema_name'),
                'table' => in_array(strtolower($table), ['parent', 'teacher', 'student', 'setting', 'user']) ? strtolower($table) : '',
                'created_by' => \Auth::user()->id,
                'about' => request('about'),
                'source' => request('source')
            ];
            DB::table('calls')->insert($object);
            return redirect('customer/calls')->with('success', 'Call Recorded Successfully ');
        }
        return view('customer.call.create', $this->data);
    }

    public function viewContract() {
        $contract_id = request()->segment(3);
        $type = request()->segment(4);
        if($type == 'standing'){
            $contract = \App\Models\StandingOrder::find($contract_id);
            if(empty($contract)) {
              $contract = \App\Models\Contract::findOrFail($contract_id);
            }
            $this->data['path'] = $contract->companyFile->path;
        }
        else if($type == 'legal'){
            $contract = \App\Models\LegalContract::find($contract_id);
            $this->data['path'] = $contract->companyFile->path;
        }
        else if($type == 'absent'){
            $document = \App\Models\Absent::find($contract_id);
            $this->data['path'] = $document->companyFile->path;
        }
        else{
            $contract = \App\Models\Contract::find($contract_id);
            $this->data['path'] = $contract->companyFile->path;
        }
        return view('layouts.file_view', $this->data);
    }


    public function viewStandingOrder(){
        $company_file_id = request()->segment(3);
        $this->data['path'] = \App\Models\CompanyFile::where('id',$company_file_id)->first()->path;
        return view('layouts.file_view', $this->data);
    }


     // method to share receipt link
    public function ShareReceiptWhatsApp() {
        $id = request()->segment(3);
        if ((int) $id > 0) {
            $this->data['invoice'] = \App\Models\Invoice::find($id);
            $this->data["payment_types"] = \App\Models\PaymentType::all();
            $this->data['banks'] = \App\Models\BankAccount::all();
            $this->data['revenue'] = \App\Models\Revenue::where('id', $id)->first();
            return view('layouts.receipt_to_share', $this->data);
        } else {
            return redirect()->back()->with('error', 'Sorry ! Something is wrong try again!!');
        }
    }

    // Share receipt by email
    public function ShareReceiptEmail() {
        $id = request()->segment(3);
        if ((int) $id > 0) {
            $this->data['invoice'] = \App\Models\Invoice::find($id);
            $this->data["payment_types"] = \App\Models\PaymentType::all();
            $this->data['banks'] = \App\Models\BankAccount::all();
            $this->data['revenue'] = \App\Models\Revenue::where('id', $id)->first();
            return view('layouts.receipt_to_share', $this->data);
        } else {
            return redirect()->back()->with('error', 'Sorry ! Something is wrong try again!!');
        }
    }

     // method to share invoice link
     public function ShareInvoiceWhatsApp() {
        $invoice_id = request()->segment(3);
        $set = $this->data['set'] = 1;
        if ((int) $invoice_id > 0) {
            $this->data['invoice'] = \App\Models\Invoice::find($invoice_id);
            $this->data['usage_start_date'] = $this->data['invoice']->client->start_usage_date;
            $start_usage_date = date('Y-m-d',strtotime($this->data['usage_start_date']));
            $yearEnd = date('Y-m-d', strtotime('Dec 31'));
            $to = \Carbon\Carbon::createFromFormat('Y-m-d',  $yearEnd);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $start_usage_date);
            $this->data['diff_in_months'] = $diff_in_months = $to->diffInMonths($from);
            return view('layouts.invoice_to_share', $this->data);
        }
        else {
            return redirect()->back()->with('error', 'Sorry ! Something is wrong try again!!');
        }
    }

    public function ShareInvoiceEmail() {
        $invoice_id = request()->segment(3);
        $set = $this->data['set'] = 1;
        if ((int) $invoice_id > 0) {
            $this->data['invoice'] = \App\Models\Invoice::find($invoice_id);
            return view('layouts.invoice_to_share', $this->data);
        }
        else {
            return redirect()->back()->with('error', 'Sorry ! Something is wrong try again!!');
        }

    }


    public function deleteContract() {
        $contract_id = request()->segment(3);
        $contract = \App\Models\Contract::where('id', $contract_id)->delete();
        return redirect()->back()->with('success', 'Contract Deleted');
    }

    public function contract() {
        $client_id = request()->segment(3);
        $file = request()->file('file');
      //  $file_id = $this->saveFile($file, 'company/contracts');
        //save contract
      
        $contract_id = DB::table('admin.contracts')->insertGetId([
            'name' => request('name'), 'company_file_id' => $file_id, 'start_date' => request('start_date'), 'end_date' => request('end_date'), 'contract_type_id' => request('contract_type_id'), 'user_id' => Auth::user()->id, 'note' => request('description')
        ]);
        //client contracts
        DB::table('admin.client_contracts')->insert([
            'contract_id' => $contract_id, 'client_id' => $client_id
        ]);
        return redirect()->back()->with('success', 'Succeess');
    }

    public function taskGroup() {
        $type = request()->segment(3);
        $id = request()->segment(4);
        if ($type == 'user') {
            $sql = "select a.id, a.activity,a.created_at::date, a.date,d.name as user ,e.name as type  from admin.tasks a join admin.tasks_clients c on a.id=c.task_id
            join admin.users d on d.id=a.user_id join admin.task_types e on a.task_type_id=e.id WHERE a.user_id = $id order by a.id asc";
            $this->data['activities'] = \App\Models\Task::where('user_id', $id)->orderBy('id', 'DESC')->get();
        } elseif ($type == 'task') {
            $this->data['activities'] = \App\Models\Task::where('task_type_id', $id)->orderBy('id', 'DESC')->get();
        } else {
            $this->data['activities'] = \App\Models\Task::where('task_type_id', $id)->orderBy('id', 'DESC')->get();
        }
        return view('customer.task_group', $this->data);
        return view('layouts.file_view', $this->data);
    }

    /**
     * 1. we check available date start from the end date of the respective csr
     * 2. We loop through dates, and return a range of next 10 days
     * 3. We skip sunday and saturday, otherwise if a person accept that
     * 4. we return range of available dates
     */
    public function getDate($id = null, $default_dates = null) {
        $user_id = $id = null || (int) $id == 0 ? request('user_id') : $id;
        $task_user = \App\Models\TaskUser::where('user_id', $user_id)->orderBy('id', 'desc')->first();
        $task_date = !empty($task_user) ? $task_user->task->end_date : date('Y-m-d');
        $end_date = date('Y-m-d');
        $option = '<option></option>';
        for ($i = 0; $i <= 10; $i++) {
            $date = date('Y-m-d', strtotime('+' . $i . ' days', strtotime($end_date)));
            if (date('D', strtotime($date)) == 'Sat' || date('l', strtotime($date)) == 'Sunday') {
                continue;
            }
            $selected = $default_dates != null && date('Y-m-d', strtotime($default_dates)) == $date ? 'selected' : '';
            $option .= '<option value="' . $date . '" ' . $selected . '>' . $date . '</option>';
        }
        echo $option;
    }

    /**
     * 1. check available date
     * 2. find active slots that are not available in the that day and show it to users
     * 3.
     */
    public function getAvailableSlot() {
        $user_id = request('user_id');
        $start_date = request('start_date');
        $sql = "select * from admin.slots where status=1 and id not in (select slot_id from admin.tasks where slot_id is not null and start_date::date='{$start_date}' and id in (select task_id from admin.tasks_users where user_id={$user_id}) ) ";
        $slots = \DB::select($sql);
        $option = '<option></option>';
        foreach ($slots as $slot) {
            $option .= '<option value="' . $slot->id . '">' . $slot->start_time . ' - ' . $slot->end_time . '</option>';
        }
        echo $option;
    }




    

    public function download() {
        $client = request()->segment(3);
        $this->data['show_download'] = request()->segment(4);
        $this->data['client'] = \App\Models\Client::find($client);
        $this->data['shulesoft_users'] = \App\Models\User::where('status', 1)->get();
        $view = view('customer.training.implementation', $this->data);
        if ((int) $this->data['show_download'] == 1) {
            echo $view;
            $file_name = $this->data['client']->username . '.doc';
            $headers = array(
                "Content-type" => "text/html",
                "Content-Disposition" => "attachment;Filename=$file_name"
            );
            return response()->download('storage/app/' . $file_name, $file_name, $headers);
        }
        return $view;
    }

    public function createJobCard(){
        if($_POST){
            $module_ids = request('module_ids');
            $client_id = request('client_id');
            $user_id  = Auth::user()->id;
            $date     = request('date');
        }
        foreach($module_ids as $module_id) {
            \App\Models\JobCard::create(['module_id' => $module_id, 'client_id' =>$client_id,'user_id' => $user_id,'date'=> $date]);
        }
        return redirect()->back()->with('success','Job card modules uploaded succesfully!');
    }


    public function uploadJobCard(){
        if($_POST){
            
            $file = request()->file('job_card_file');
            $company_file_id = $file ? $this->saveFile($file, 'company/employees') : 1; 
          
            $data = [
                'company_file_id' => $company_file_id,
                'client_id' => request('client_id'),
                'created_by'  => Auth::user()->id,
                'date'    => request('date')
            ]; 
            \App\Models\ClientJobCard::create($data);
          }
          return redirect()->back()->with('success','uploaded succesfully!');
       
    }


    public function viewFile() {
        $value = request()->segment(3);
        $type = request()->segment(4);
        if($type == 'jobcard'){
            $contract = \App\Models\ClientJobCard::where('date',$value)->first();
            $this->data['path'] = $contract->companyFile->path;
        }

        if($type == 'course_certificate'){
            $certificate = \App\Models\Learning::where('id',$value)->first();
            $this->data['path'] = $certificate->companyFile->path;
        }
        return view('layouts.file_view', $this->data);
    }


    public function Jobcard() {
        $client = request()->segment(3);
        $date = request()->segment(4);
        $this->data['show_download'] = request()->segment(5);
        $this->data['client'] = \App\Models\Client::find($client);
        $this->data['job_card_modules'] = \App\Models\JobCard::whereDate('date', '=', $date)->get();
        $view = view('customer.jobcard', $this->data);
        return $view;
    }

    public function whatsappIntegration() {
        $this->data['whatsapp_requests'] = DB::table('whatsapp_integrations')->get();
        return view('customer.message.whatsapp_requests', $this->data);
    }

    public function approveIntegration() {
        $id = request()->segment(3);
        if ($id == 'delete') {
            //COMPLETELY bad design but implemented for quick start
            DB::table('whatsapp_integrations')->where('id', request()->segment(4))->delete();
            return redirect('customer/whatsappIntegration')->with('success', 'Succeess');
        }
        if ($_POST) {
            $id = request('id');
            $schema_name = request('schema_name');
            $school = DB::table($schema_name . '.sms_keys')->where('api_secret', request('token'))->where('api_key', request('url'))->first();
            empty($school) ? DB::table($schema_name . '.sms_keys')->insert([
                                'api_secret' => request('token'),
                                'api_key' => request('url'),
                                'name' => 'whatsapp',
                                'phone_number' => request('phone')
                            ]) : '';
            DB::table('whatsapp_integrations')->where('id', $id)->update(['approved' => 1]);
            return redirect('customer/whatsappIntegration')->with('success', 'Succeess');
        }
        $this->data['request'] = DB::table('whatsapp_integrations')->where('id', $id)->first();
        return view('customer.message.approve_integration', $this->data);
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

}

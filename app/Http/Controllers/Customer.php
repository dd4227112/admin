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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

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
        if (!preg_match('/898uuhihdsdskj/i', request()->segment(1))) {
            $this->middleware('auth');
        }
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
            return redirect()->back()->with('success', 'successfully');
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
        $ttask_id = request('task_id');
        $section_id = request('section_id');
        $start_date = request('start_date');
        $task_user = request('task_user');
        $attr = request('attr');
        $school_person = request('school_person');

        if ((int) $task_user == 0) {
            $sales = new \App\Http\Controllers\Sales();
            $user_id = $sales->getSupportUser($section_id);
        } else {
            $user_id = (int) $task_user;
        }

        $train = \App\Models\TrainItemAllocation::find($ttask_id);
        $task_id = $train->task_id;

        if ((int) $user_id > 0 && (int) $task_id > 0) {

            $section = \App\Models\TrainItem::find($section_id);
            $obj = [
                'start_date' => date('Y-m-d H:i:s', strtotime($start_date)),
                'end_date' => date('Y-m-d H:i:s', strtotime($start_date . " + {$section->time} days")),
                'updated_at' => date('Y-m-d H:i:s'),
                'user_id' => $user_id,
                'is_allocated' => 1,
                'school_person_allocated' => trim($school_person)
            ];

            DB::table('admin.train_items_allocations')->where('id', (int) $ttask_id)->update($obj);
            DB::table('tasks_users')->where('task_id', (int) $task_id)->update([
                'user_id' => $user_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $user = \App\Models\User::where('id', (int) $user_id)->first();
            $start_date = date('d-m-Y', strtotime($start_date)) == '01-01-1970' ? date('Y-m-d') : date('d-m-Y', strtotime($start_date));
            // email to shulesoft personel
            $message = 'Hello ' . $user->firstname . '<br/>'
                    . 'A task ' . $train->trainItem->content . ' been allocated to you'
                    . '<ul>'
                    . '<li>At : ' . $train->client->name . '</li>'
                    . '<li>Start date: ' . date('Y-m-d H:i:s', strtotime($start_date)) . '</li>'
                    . '<li>Deadline: ' . date('Y-m-d H:i:s', strtotime($start_date . " + {$section->time} days")) . '</li>'
                    . '</ul>';
            $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);

            $message = 'Hello ' . $user->firstname . ' ' . $user->lastname . '.'
                    . chr(10) . 'A task of ' . $train->trainItem->content . 'at ' . $train->client->name
                    . chr(10) . 'Has been allocated to you'
                    . chr(10) . 'The taks is expected to start at ' . date('d-m-Y', strtotime($start_date)) . ' to  ' . date('d-m-Y', strtotime($start_date . " + {$section->time} days")) . '.'
                    . chr(10) . 'By :' . \Auth::user()->name
                    . chr(10) . 'Thank You.';
            $this->send_whatsapp_sms($user->phone, $message);
            $this->send_sms($user->phone, $message, 1);

            //email to zone manager
            // findOrFail zone manager based on school location
            $user_manager = $this->zonemanager($train->client->id);
            if (isset($user_manager->user_id) && !empty((int) $user_manager->user_id)) {
                $manager = \App\Models\User::where('id', $user_manager->user_id)->first();
                $manager_message = 'Hello ' . $manager->firstname . '<br/>'
                        . 'A task ' . $train->trainItem->content . ' been scheduled to'
                        . '<li>' . $train->client->name . '</li>'
                        . '<li>Start date: ' . date('Y-m-d H:i:s', strtotime($start_date)) . '</li>'
                        . '<li>Deadline: ' . date('Y-m-d H:i:s', strtotime($start_date . " + {$section->time} days")) . '</li>'
                        . '</ul>';
                $this->send_email($manager->email, 'ShuleSoft Task Allocation', $manager_message);

                $wmessage = 'Hello ' . $manager->firstname . ' ' . $manager->lastname . '.'
                        . chr(10) . 'A task of ' . $train->trainItem->content . 'at ' . $train->client->name
                        . chr(10) . 'Has been allocated to ' . $user->firstname . ' ' . $user->lastname
                        . chr(10) . 'The project is expected to start at ' . date('d-m-Y', strtotime($start_date)) . ' to  ' . date('d-m-Y', strtotime($start_date . " + {$section->time} days")) . '.'
                        . chr(10) . 'Thank You.';
                $this->send_whatsapp_sms($manager->phone, $wmessage);
                $this->send_sms($manager->phone, $wmessage, 1);
            }


            //sms to school person
            // $school_personel = '';
            // if ($school_personel) {
            //     $message = 'Hello #someone task #something will start at ' . date('Y-m-d H:i:s', strtotime($start_date)) . '';
            //     $this->send_sms($school_personel->phone, 'ShuleSoft Task Allocation', $message);
            // }
            //die(json_encode(array_merge(array('task_id' => $task_id), $obj)));
            echo 'Success'; // we disable json returns 
        }
        //insert into training allocation
        echo 'success';
    }

    public function zonemanager($id) {
        return \collect(DB::select("select user_id from admin.zone_managers where zone_id in ( select refer_zone_id from admin.regions where id in(select region_id from admin.districts where id in (select district_id from admin.wards where id in (select ward_id from admin.schools where id in (select school_id from admin.client_schools where client_id =  $id )))) )"))->first();
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

    public function createGuide() {
        $file = request()->file('image_file');
        if (filesize($file) > 2015110) {
            return redirect()->back()->with('error', 'File must have less than 2MBs');
        }
        $company_file_id = $file ? $this->saveFile($file, TRUE) : 1;

        $obj = [
            'permission_id' => request()->permission_id,
            'content' => str_replace('src="../../storage/images', 'src="' . url('/') . '/storage/images', request()->content),
            'created_by' => \Auth::user()->id,
            'language' => 'eng',
            'company_file_id' => $company_file_id
        ];
        DB::table('constant.guides')->insert($obj);
        return redirect('customer/guide');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $page = null) {
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
            \App\Models\Guide::findOrFail(request()->segment(4))->delete();
            return redirect()->back();
        } else if (request('pg') == 'add') {
            $this->data['guides'] = [];
            $page = 'add_guide';
        } else if (request()->segment(3) == 'edit') {
            $this->data['guide'] = $guide = \App\Models\Guide::find(request()->segment(4));
            $page = 'edit_guide';
            if ($_POST) {
                $file = request()->file('image_file');
                if (filesize($file) > 2015110) {
                    return redirect()->back()->with('error', 'File must have less than 2MBs');
                }
                $company_file_id = $file ? $this->saveFile($file, TRUE) : $guide->company_file_id;

                $obj = [
                    'permission_id' => request()->permission_id,
                    'content' => str_replace('src="../../../storage/images', 'src="' . url('/') . '/storage/images', request()->content),
                    "is_edit" => request()->is_edit,
                    'language' => 'eng',
                    'company_file_id' => $company_file_id
                ];

                \App\Models\Guide::find(request('guide_id'))->update($obj);
                return redirect('customer/guide');
            }
        } else {
            $page = 'guide';
            $this->data['guides'] = \App\Models\Guide::latest()->get();
        }
        return view('customer.' . $page, $this->data);
    }

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
            /*    $users = DB::table('all_users')->whereIn('usertype', request('for'))->where('table', '<>', 'setting')->where('status', 1)->get();
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
              } */

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

    public function profile() {
        $school = $this->data['schema'] = request()->segment(3);
        $id = request()->segment(4);
        $this->data['shulesoft_users'] = (new \App\Http\Controllers\Users)->shulesoftUsers();
        $schema = \collect(DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES WHERE lower(table_schema) = '{$school}' "))->first();
        $status =  DB::table('admin.all_setting')->where('schema_name', $school)->first();

        if (empty($status)) {
            return redirect('https://' . $school . '.shulesoft.com');
        }

        $client = \App\Models\Client::where('username', $school)->first();

        $is_client = 0;
        if ($school == 'school') {
            $id = request()->segment(4);
            $this->data['client_id'] = $id;
            $this->data['school'] = \collect(DB::select('select id,name as sname, name,schema_name, region, ward, district as address,students  from admin.schools where id=' . $id))->first();
        } elseif (empty($status) && isset($client->username)) {
            return redirect('https://' . $school . '.shulesoft.com');
        } elseif (empty($status) && empty($client->username)) {
            return view('customer.checkinstallation', $this->data);
        } else {
            $is_client = 1;
            $this->data['school'] = !empty($schema) ? DB::table($school . '.setting')->first() : \DB::table('shulesoft.setting')->where('schema_name', $school)->first(); 
            $this->data['levels'] = !empty($schema) ? DB::table($school . '.classlevel')->get() : \DB::table('shulesoft.classlevel')->where('schema_name', $school)->get();
            $this->data['client'] = $client = \App\Models\Client::where('username', $school)->first();
            $this->data['trial'] = DB::table('admin.client_trials')->where('client_id', $client->id)->first();

            if (empty($client)) {
                $client = \App\Models\Client::create(['name' => $this->data['school']->sname, 'email' => $this->data['school']->email, 'phone' => $this->data['school']->phone, 'address' => $this->data['school']->address, 'username' => $school, 'created_at' => date('Y-m-d H:i:s')]);
            }
            $this->data['client_id'] = $client->id;

            $client_school = \App\Models\ClientSchool::where('client_id', $this->data['client_id'])->first();
            $this->data['school_id'] = $client_school->school_id;

            $this->data['agreement'] = \App\Models\SchoolAgreement::where('school_id', $this->data['school_id'])->first();

            $zone_manager = $this->zonemanager($this->data['client_id']);
            if ($zone_manager) {
                $this->data['manager'] = \App\Models\User::where(['id' => $zone_manager->user_id, 'status' => 1]);
            }
            $this->data['top_users'] = !empty($school) ? DB::select('select count(*), user_id,a."table",b.name,b.usertype from ' . $school . '.log a join ' . $school . '.users b on (a.user_id=b.id and a."table"=b."table") where user_id is not null group by user_id,a."table",b.name,b.usertype order by count desc limit 5') :  DB::select('select count(*), user_id,a."table",b.name,b.usertype from shulesoft.log a join shulesoft.users b on (a.user_id=b.id and a."table"=b."table") where schema_name=' . $school . ' user_id is not null group by user_id,a."table",b.name,b.usertype order by count desc limit 5');
        }


        $this->data['profile'] = \App\Models\Client::where('id', $client->id)->first();
        $this->data['is_client'] = $is_client;

        $year = \App\Models\AccountYear::where('name', date('Y'))->first();
        if (empty($year)) {
            $year = \App\Models\AccountYear::create(['name' => date('Y'), 'status' => 1,
                        'start_date' => date('Y') . '-01-01',
                        'end_date' => date('Y') . '-12-31']);
        }

        $this->data['invoices'] = \App\Models\Invoice::where('client_id', (int) $client->id)->where('account_year_id', (int) $year->id)->get();
        $this->data['standingorders'] = \App\Models\StandingOrder::where('client_id', $client->id)->latest()->get();

        if ($_POST) {
            $validated = request()->validate([
                'activity' => 'required|min:12',
                'start_date' => 'required',
                'end_date' => 'nullable|after:start_date',
                'remainder_date' => 'nullable|after:start_date|before:end_date'
            ]);

            $remainder = empty(request('remainder_date')) ? 1 : 0;
            $end_date = strtolower(request('status')) == 'complete' ? date("Y-m-d") : request('end_date');
            $remainder_date = !empty(request('remainder_date')) ? date('Y-m-d', strtotime(request('remainder_date'))) : null;
            $data = array_merge(request()->except(['start_date', 'end_date', 'to_user_id', 'activity']), ['user_id' => Auth::user()->id, 'start_date' => date("Y-m-d H:i:s", strtotime(request('start_date'))), 'end_date' => $end_date, 'remainder' => $remainder, 'remainder_date' => $remainder_date, 'activity' => nl2br(request('activity'))]);

            $task = \App\Models\Task::create($data);
            DB::table('tasks_clients')->insert([
                'task_id' => $task->id,
                'client_id' => (int) request('client_id')
            ]);

            if (!empty(request('to_user_id'))) {
                $to_users = request('to_user_id');
                foreach ($to_users as $key => $user_id) {
                    DB::table('tasks_users')->insert([
                        'task_id' => $task->id,
                        'user_id' => $user_id
                    ]);
                    $user = \App\Models\User::find($user_id);
                    $message = 'Hello ' . $user->firstname . ' ' . $user->lastname . '.'
                            . chr(10) . 'A task has been allocated to you'
                            . chr(10) . 'Task: ' . $task->activity . '.'
                            . chr(10) . 'Type: ' . $task->taskType->name . '.'
                            . chr(10) . 'Deadline: ' . $task->start_date . '.'
                            . chr(10) . 'Thanks.';
                    // $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);
                }
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
            return redirect('customer/profile/' . $school)->with('success', 'success');
        }
        if ((int) $id > 0) {
            return view('customer/addtask', $this->data);
        } else {
            return view('customer/profile', $this->data);
        }
    }

    public function editdetails() {
        $id = request()->segment(3);
        $data = [
            'name' => request('name'),
            'estimated_students' => request('estimated_students'),
            'address' => request('address'),
            'email' => request('email'),
            'phone' => request('owner_phone'),
            'owner_phone' => request('owner_phone'),
            'owner_email' => request('owner_email')
        ];

        $number_of_students = request('estimated_students');

        DB::transaction(function () use ($id, $data, $number_of_students) {
            $update = \App\Models\Client::where('id', (int) $id)->first();
            \App\Models\Client::where('id', (int) $id)->update($data);
            $data = \App\Models\ClientSchool::where('client_id', (int) $id)->first();
            \App\Models\School::where('id', \App\Models\ClientSchool::where('client_id', (int) $id)->first()->school_id)->update(['students' => $number_of_students, 'name' => request('name')]);
            \DB::table($update->username . '.setting')->update(['estimated_students' => $number_of_students]);
            return redirect('customer/profile/' . $update->username)->with('success', 'successful updated!');
        });
    }

    public function addstandingorder() {
        if ($_POST) {
            $file = request('standing_order_file');
            if (filesize($file) > 2015110) {
                return redirect()->back()->with('error', 'File must have less than 2MBs');
            }
            $total_amount = empty(request('total_amount')) ? request('occurance_amount') * request('number_of_occurrence') : request('total_amount');
            $company_file_id = $file ? $this->saveFile($file, TRUE) : 1;

            $data = [
                'client_id' => request('client_id'),
                // 'branch_id' => request('branch_id'),
                'company_file_id' => $company_file_id,
                'school_contact_id' => request('school_contact_id'),
                'created_by' => \Auth::user()->id,
                'occurrence' => request('number_of_occurrence'),
                'type' => request('which_basis'),
                'occurance_amount' => remove_comma(request('occurance_amount')),
                'total_amount' => remove_comma($total_amount),
                'payment_date' => request('maturity_date'),
                'contact_person' => request('contact_person'),
                'note' => request('note'),
                'contract_type_id' => 8,
                'branch_name' => request('branch_name')
            ];
            $contract_id = DB::table('admin.standing_orders')->insertGetId($data);
            //client contracts
            DB::table('admin.client_contracts')->insert(['contract_id' => $contract_id, 'client_id' => request('client_id')]);
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
                $data = array_merge(request()->except(['to_user_id', 'start_date', 'end_date']), ['user_id' => Auth::user()->id, 'start_date' => date("Y-m-d H:i:s", strtotime(request('start_date'))),
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
                        // $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);
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
        $sql = "SELECT A.id,upper(A.name)|| ' '||upper(A.type) as name, CASE WHEN B.client_id is not null THEN 1 ELSE 0 END AS client FROM admin.schools A left join admin.client_schools B on A.id = B.school_id WHERE lower(A.name) LIKE 
        '%" . str_replace("'", null, strtolower(request('term'))) . "%' LIMIT 10";
        die(json_encode(DB::select($sql)));
    }

    public function getCLientschools() {
        $sql = "SELECT A.id,upper(A.name)|| ' '||upper(A.type) as name, CASE WHEN B.client_id is not null THEN 1 ELSE 0 END AS client FROM admin.schools A JOIN admin.client_schools B on A.id = B.school_id WHERE lower(A.name) LIKE 
        '%" . str_replace("'", null, strtolower(request('term'))) . "%' LIMIT 10";
        die(json_encode(DB::select($sql)));
    }

    public function choices() {
        $type = request('type');
        if ($type == 'year') {
            if (Auth::user()->role_id == 1) {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->whereYear('updated_at', date('Y'))->orderBy('updated_at', 'desc')->get();
            } else {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->where('user_id', Auth::user()->id)->whereYear('updated_at', date('Y'))->orderBy('updated_at', 'desc')->get();
            }
        } else if ($type == 'quoter') {
            $date = \Carbon\Carbon::today()->subDays(120);
            if (Auth::user()->role_id == 1) {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->where('updated_at', '>=', $date)->orderBy('updated_at', 'desc')->get();
            } else {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->where('user_id', Auth::user()->id)->where('updated_at', '>=', $date)->orderBy('updated_at', 'desc')->get();
            }
        } else if ($type == 'month') {
            if (Auth::user()->role_id == 1) {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->whereMonth('updated_at', Carbon::now()->month)->whereYear('updated_at', date('Y'))->orderBy('updated_at', 'desc')->get();
            } else {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->where('user_id', Auth::user()->id)->whereMonth('updated_at', Carbon::now()->month)->whereYear('updated_at', date('Y'))->orderBy('updated_at', 'desc')->get();
            }
        } else if ($type == 'week') {
            if (Auth::user()->role_id == 1) {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('updated_at', 'desc')->get();
            } else {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->where('user_id', Auth::user()->id)->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('updated_at', 'desc')->get();
            }
        } else if ($type == 'yesterday') {
            if (Auth::user()->role_id == 1) {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->whereDate('updated_at', Carbon::yesterday())->orderBy('updated_at', 'desc')->get();
            } else {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->where('user_id', Auth::user()->id)->whereDate('updated_at', Carbon::yesterday())->orderBy('updated_at', 'desc')->get();
            }
        } else if ($type == 'today') {
            if (Auth::user()->role_id == 1) {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->whereDate('updated_at', Carbon::today())->orderBy('updated_at', 'desc')->get();
            } else {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->where('user_id', Auth::user()->id)->whereDate('updated_at', Carbon::today())->orderBy('updated_at', 'desc')->get();
            }
        } else {
            if (Auth::user()->role_id == 1) {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->orderBy('updated_at', 'desc')->limit(100)->get();
            } else {
                $this->data['completetasks'] = \App\Models\Task::where('status', 'complete')->where('user_id', Auth::user()->id)->orderBy('updated_at', 'desc')->limit(100)->get();
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
                        . '<li>Deadline: ' . date('d-m-Y', strtotime($task->date)) . '</li>'
                        . '</ul>';
                $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);

                $sms = 'Hello ' . $user->firstname . ' ' . $user->lastname
                        . chr(10) . 'Task Status has been updated to :' . request('status')
                        . chr(10) . 'Task of : ' . $task->activity
                        . chr(10) . 'Type : ' . $task->taskType->name . '.'
                        . chr(10) . 'Deadline : ' . date('d-m-Y', strtotime($task->date)) . '.'
                        . chr(10) . 'Thanks and regards,';
                $this->send_whatsapp_sms($user->phone, $sms);
            }
        }
        echo request('status');
    }

    public function changepriority() {
        if (request('priority') == 1) {
            $priority = "High";
        } else if (request('priority') == 2) {
            $priority = "Medium";
        } else {
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

                $sms = 'Hello ' . $user->firstname . ' ' . $user->lastname
                        . chr(10) . 'Task Priority has been updated to :' . $priority
                        . chr(10) . 'Task of : ' . $task->activity
                        . chr(10) . 'Type : ' . $task->taskType->name . '.'
                        . chr(10) . 'Deadline : ' . date('d-m-Y', strtotime($task->date)) . '.'
                        . chr(10) . 'Thanks and regards,';
                $this->send_whatsapp_sms($user->phone, $sms);
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
        $tag = \App\Models\Task::where('id', (int) $id);
        $reply = !empty($tag) ? $tag->delete() : '';
        echo $reply > 0 ? 'Task deleted' : 'No changes happened';
    }

    public function updateTask() {
        $id = request('id');
        $action = request('action');
        \App\Models\Task::where('id', $id)->update(['status' => $action]);
        echo 'Success';
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
            $this->data['requirement'] = \App\Models\Requirement::where('id', (int) $id)->first();
            $next_id = \App\Models\Requirement::whereNotIn('id', [$id])->where('status', 'New')->first();
            $this->data['next'] = is_null($next_id) ? '' : $next_id->id;
            return view('customer/view_requirement', $this->data);
        }

        if ($tab == 'edit' && $id > 0) {
            $this->data['requirement'] = \App\Models\Requirement::where('id', $id)->first();
            return view('customer/edit_requirement', $this->data);
        }

        if ($tab == 'range') {
            $startDate = request('start');
            $endDate = request('end');
            $this->data['stats'] = $this->checkTaskProgress($startDate, $endDate);
            $this->data['requirements'] = \App\Models\Requirement::whereBetween('created_at', [$startDate, $endDate]);
            return view('customer/analysis', $this->data);
        }


        if ($tab == 'allocated') {
            $to_user_id = \Auth()->user()->id;
            $this->data['startDate'] = $startDate = date("Y-m-d", strtotime('monday this week'));
            $this->data['endDate'] = $endDate = date('Y-m-d', strtotime($startDate . ' + 6 days'));

            if ($_POST) {
                $to_user_id = request('to_user_id') != '' ? request('to_user_id') : \Auth()->user()->id;
                $this->data['startDate'] = $startDate = date('Y-m-d', strtotime(request('week')));
                $this->data['endDate'] = $endDate = date('Y-m-d', strtotime($startDate . ' + 6 days'));
                $this->data['person_stats'] = $this->checkTaskProgress($startDate, $endDate, $to_user_id);
                $this->data['requirements'] = \App\Models\Requirement::whereBetween('created_at', [$startDate, $endDate]);
            }
            $this->data['person_stats'] = $this->checkTaskProgress($startDate, $endDate, $to_user_id);
            return view('customer/analysis', $this->data);
        }

        $this->data['levels'] = [];
        if ($_POST) {
            $validated = request()->validate([
                'note' => 'required|min:12',
            ]);

            $requirement = [
                'school_id' => is_null(request('school_id')) ? '0' : request('school_id'),
                'to_user_id' => request('to_user_id'),
                'project_id' => 1,
                'due_date' => request('due_date'),
                'note' => request('note'),
            ];

            $data = array_merge($requirement, ['user_id' => \Auth::user()->id]);

            $req = \App\Models\Requirement::create($data);
            if ((int) request('to_user_id') > 0) {
                $user = \App\Models\User::find(request('to_user_id'));
                $new_req = isset($req->school->name) && (int) $req->school_id > 0 ? ' - from ' . $req->school->name . ' on ' . request('module') : ' - ' . request('module');
                $message = 'Hello ' . $user->name . '<br/>'
                        . 'There is ' . $new_req . '</p>'
                        . '<br/><p><b>Requirement:</b> ' . $req->note . '</p>'
                        . '<br/><br/><p><b>By:</b> ' . $req->user->name . '</p>';
                $this->send_email($user->email, 'ShuleSoft New Customer Requirement', $message);

                $sms = 'Hello ' . $user->name . '.'
                        . chr(10) . 'There is ' . $new_req . '.'
                        . chr(10) . strip_tags($req->note)
                        . chr(10) . 'By: ' . $req->user->name . '.'
                        . chr(10) . 'Thanks and regards.';

                $url = 'https://www.pivotaltracker.com/services/v5/projects/2553591/stories';

                $fields = [
                    "current_state" => request('current_state'),
                    "name" => 'Hello ' . $user->name . ' - ' . $new_req,
                    "estimate" => 1,
                    "story_type" => request("feature"),
                    "current_state" => request("accepted"),
                    "requested_by_id" => request('requested_by_id'),
                    "story_priority" => request('story_priority'),
                    "token" => "c3c067a65948d99055ab1ac60891c174",
                    "description" => Auth::User()->name . ' - ' . strip_tags(request('note'))
                ];
                $story = new \App\Http\Controllers\General();
                $data1 = $story->post($url, $fields);

                $this->send_whatsapp_sms($user->phone, $sms);
                $this->send_sms($user->phone, $sms, 1);
            }
        }
        $this->data['requirements'] = \App\Models\Requirement::latest();
        return view('customer/analysis', $this->data);
    }

    public function editReq() {
        $id = request('req_id');
        $data = request()->except('_token', 'req_id');
        \App\Models\Requirement::where('id', $id)->update($data);
        return redirect('customer/requirements')->with('success', 'Edited successfully!');
    }

    public function updateReq() {
        $id = request('id');
        $action = request('action');
        \App\Models\Requirement::where('id', $id)->update(['status' => $action]);
        $data = \App\Models\Requirement::where('id', $id)->first();
        $user = \App\Models\User::where('id', $data->user_id)->first();

        if ($action == 'On Progres') {
            $status = ' is now on progress. You will be notified as soon as its Completed.';
        } elseif ($action == 'Completed') {
            $status = ' is now complete. Login into your shulesoft account.';
        } elseif ($action == 'Resolved') {
            $status = ' is resolved. Login into your shulesoft account.';
        } elseif ($action == 'Canceled') {
            $status = ' is Canceled. Contact responsible person.';
        }
        $message = 'Hello ' . $user->name . '.'
                . chr(10) . 'The requirement of : ' . strip_tags($data->note) . '.'
                . chr(10) . 'You requested on ' . date('d-m-Y', strtotime($data->created_at)) . ' ' . $status . ''
                . chr(10) . 'Thanks and regards,'
                . chr(10) . 'Technical Team.';
        $this->send_whatsapp_sms($user->phone, $message);
        $this->send_sms($user->phone, $message, 1);

        if (preg_match('/[0-9]/', $data->contact) && $action == 'Completed') {
            $message1 = 'Hello '
                    . chr(10) . 'Thanks for using Shulesoft Services'
                    . chr(10) . 'The requirement of : ' . strip_tags($data->note) . '.'
                    . chr(10) . 'Requested on ' . date('d-m-Y', strtotime($data->created_at)) . ' is now complete. Login into your shulesoft account'
                    . chr(10) . 'Thanks and regards,'
                    . chr(10) . 'Shulesoft Team'
                    . chr(10) . 'Call: +255 655 406 004';
            $this->send_whatsapp_sms($data->contact, $message1);
            $this->send_sms($data->contact, $message1, 1);
        }

        echo $action;
    }

    public function usageAnalysis() {
        $skip = ['admin', 'accounts', 'pg_catalog', 'constant', 'api', 'information_schema', 'public', 'academy', 'forum',
            'betatwo', 'jifunze', 'beta_testing'];
        $sql = DB::table('admin.all_setting')
                ->whereNotIn('schema_name', $skip);
        strlen(request('schools')) > 3 ? $sql->whereIn('schema_name', explode(',', request('schools'))) : '';
        strlen(request('regions')) > 3 ? $sql->whereIn('regions', explode(',', request('regions'))) : '';

        (int) request('is_client') == 1 ? $sql->whereIn('schema_name', \App\Models\Client::whereIn('id', \App\Models\Payment::whereYear('date', '>=', date('Y'))->get(['client_id']))->get(['username'])) : '';
        $this->data['schools'] = $sql->get();
        return view('customer.usage.modules', $this->data);
    }

    public function bankAnalysis() {
        $this->data['schools'] = [];
        return view('customer.usage.bank_analysis', $this->data);
    }

    public function schoolBanks() {
        $skip = ['admin', 'accounts', 'pg_catalog', 'constant', 'api', 'information_schema', 'public', 'academy', 'forum'];
        $sql = DB::table('admin.all_setting')
                ->whereNotIn('schema_name', $skip);
        $this->data['schools'] = $sql->get();
        return view('customer.usage.schoolbanks', $this->data);
    }

    public function Banksbranches() {
        $sql = DB::select("select distinct p.id,p.name,d.name as district,r.name as region,z.name as zone_name, t.branch_id,count(t.school_id) 
                            as schools  from admin.partner_branches p join admin.districts d 
                            on p.district_id = d.id join admin.regions r on r.id = d.region_id join constant.refer_zones z on 
                            z.id = r.refer_zone_id join admin.partner_schools t on t.branch_id = p.id 
                            group by t.branch_id,p.id,d.name,r.name,z.name");
        $this->data['branches'] = $sql;
        return view('customer.usage.banksbranches', $this->data);
    }

    public function IntegrationStatus() {
        $skip = ['admin', 'accounts', 'pg_catalog', 'constant', 'api', 'information_schema', 'public', 'academy', 'forum',
            'beta_testing', 'beta', 'betatwo'];
        $sql = DB::table('admin.all_setting')->whereNotIn('schema_name', $skip);
        $this->data['schools'] = $sql->get();
        return view('customer.usage.inter_status', $this->data);
    }

    public function BankStatus() {
        $skip = ['admin', 'accounts', 'pg_catalog', 'constant', 'api', 'information_schema', 'public', 'academy', 'forum'];
        $sql = DB::table('admin.all_setting')
                ->whereNotIn('schema_name', $skip);
        $this->data['schools'] = $sql->get();
        return view('customer.usage.bank_status', $this->data);
    }

    public function Emplist() {
        $this->data['users'] = User::where('status', 1)->whereNotIn('role_id', array(7, 15))->get();
        return view('customer.usage.empl_list', $this->data);
    }

    public function customerslist() {
        $skip = ['admin', 'accounts', 'pg_catalog', 'constant', 'api', 'information_schema', 'public', 'academy', 'forum'];
        $sql = DB::table('admin.all_setting')->whereNotIn('schema_name', $skip);
        strlen(request('region')) > 3 ? $sql->whereIn(DB::raw('lower(region)'), explode(',', strtolower(request('region')))) : '';
        $this->data['customers'] = $sql->get();
        return view('customer.usage.customer_list', $this->data);
    }

    public function customSqlReport() {
        $sql = strlen(request('q')) > 3 ? request('q') : exit;
        // $view = strlen(request('v')) > 3 ? request('v') : exit;
        //if (preg_match('/school_sales_status/i', $sql)) {
        //  DB::statement('select admin.sales_report()');
        //}
        // DB::select('Create or replace view ' . $view . ' AS ' . $sql);
        $this->data['contents'] = DB::select($sql);
        $this->data['headers'] = \collect($this->data['contents'])->first();
        return view('customer.usage.custom_report', $this->data);
    }

    public function implementationReport() {
        $user_id = request()->segment(2);

        $where_user = (int) $user_id == 0 ? ' ' : ' user_id=' . $user_id . ' and ';
        $sql = 'select distinct b.username as school_name, f.content as activity, a.created_at, a.created_at + make_interval(days => a.max_time) as deadline, 
        a.completed_at, 1 as status from admin.train_items_allocations a join admin.clients b on b.id=a.client_id join admin.tasks c on c.id=a.task_id 
        JOIN admin.all_setting d on d."schema_name"=b.username join admin.train_items f on f.id=a.train_item_id where a.is_allocated=1 and f.status=1 and
         (a.client_id in (select client_id from admin.payments where extract(year from date) >= 2021) OR a.client_id in (select client_id from admin.standing_orders) OR a.client_id in (select client_id from admin.client_trials)) and 
          a.train_item_id in (select train_item_id from admin.user_train_items where ' . $where_user . '  user_id=a.user_id)';

        $this->data['contents'] = DB::select($sql);
        $this->data['headers'] = \collect($this->data['contents'])->first();
        return view('customer.usage.implementation', $this->data);
    }

    public function modules() {
        $schemas = $this->data['schools'] = DB::select("SELECT distinct schema_name FROM admin.all_setting WHERE schema_name NOT IN 
                                                        ('admin','accounts','pg_catalog','constant','api','information_schema','public','academy','forum') ");
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
        $this->data['schools'] = \App\Models\School::whereIn('schema_name', $sch)->get();
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
        $this->data['schema'] = request()->segment(3);
        $this->data['client'] = strlen($this->data['schema']) > 2 ? DB::table('clients')->where('username', $this->data['schema'])->first() : '';
        $this->data['schemas'] = DB::select('select username as "table_schema"  from admin.clients where id in (select client_id from admin.payments) or id in (select client_id from admin.standing_orders) or id in (select client_id from admin.client_trials)');
        $this->data['shulesoft_users'] = \App\Models\User::where('status', 1)->whereNotIn('role_id', array(7, 15))->get();

        //check allocation of trainings
        if (strlen($this->data['schema']) > 2) {
            $checks = DB::select('select * from admin.train_items where status=1');
            foreach ($checks as $check) {
                $check_train = \App\Models\TrainItemAllocation::where('client_id', $this->data['client']->id)->where('train_item_id', $check->id)->first();
                if (empty($check_train)) {
                    \App\Models\TrainItemAllocation::create([
                        'task_id' => 1,
                        'client_id' => $this->data['client']->id,
                        'user_id' => Auth::user()->id,
                        'train_item_id' => $check->id,
                        'school_person_allocated' => '',
                        'max_time' => $check->time
                    ]);
                }
            }
        }

        return view('customer.usage.implementation_allocation', $this->data);
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
        $feedbacks = \App\Models\Feedback::orderBy('id', 'desc')->paginate();
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
        $this->data['trainings'] = \App\Models\Training::latest()->all();
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
        if (Auth::user()->id <> 2) {
            //only main user can perform this with care
            return redirect()->back()->with('warning', 'Note: We No Longer allow you to change School password. Use demo system for reference');
        } else {
            $schema = request()->segment(3);
            if ($schema != '' && $schema != 'accounts') {
                $pass = $schema . rand(5697, 33);
                $username = $schema . date('Hi');
                DB::table('shulesoft.setting')->where('schema_name',$schema)->update(['password' => bcrypt($pass), 'username' => $username]);
                $this->data['school'] = DB::table('shulesoft.setting')->where('schema_name',$schema)->first();
                $this->data['schema'] = $schema;
                $this->data['pass'] = $pass;
                return view('customer.view', $this->data)->with('success', 'Password Updated Successfully');
            } else {
                return redirect()->back()->with('warning', 'Please Define Specific School');
            }
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
            $data = Excel::load($path, function ($reader) {
                        
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
        if ($type == 'standing') {
            $contract = \App\Models\StandingOrder::find($contract_id);
            if (empty($contract)) {
                $contract = \App\Models\Contract::findOrFail($contract_id);
            }
            $this->data['path'] = $contract->companyFile->path;
        } else if ($type == 'legal') {
            $contract = \App\Models\LegalContract::find($contract_id);
            $this->data['path'] = $contract->companyFile->path;
        } else if ($type == 'absent') {
            $document = \App\Models\Absent::find($contract_id);
            $this->data['path'] = $document->companyFile->path;
        } else if ($type == 'jobcard') {
            $contract = \App\Models\ClientJobCard::find($contract_id);
            $this->data['path'] = $contract->companyFile->path;
        } else if ($type == 'agreement') {
            $contract = \App\Models\SchoolAgreement::find($contract_id);
            $this->data['path'] = $contract->companyFile->path;
        } else {
            $contract = \App\Models\Contract::find($contract_id);
            $this->data['path'] = $contract->companyFile->path;
        }
        return view('layouts.file_view', $this->data);
    }

    public function viewStandingOrder() {
        $company_file_id = request()->segment(3);
        $this->data['path'] = \App\Models\CompanyFile::where('id', $company_file_id)->first()->path;
        return view('layouts.file_view', $this->data);
    }

    public function deleteContract() {
        $contract_id = request()->segment(3);
        $contract = \App\Models\Contract::where('id', $contract_id)->delete();
        return redirect()->back()->with('success', 'Contract Deleted');
    }

    public function contract() {
        $client_id = request()->segment(3);
        $file = request()->file('file');
        if (filesize($file) > 2015110) {
            return redirect()->back()->with('error', 'File must have less than 2MBs');
        }
        $file_id = $this->saveFile($file, TRUE);
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

    public function createJobCard() {
        if ($_POST) {
            $module_ids = request('module_ids');
            $client_id = request('client_id');
            $user_id = Auth::user()->id;
            $date = request('date');
        }
        foreach ($module_ids as $module_id) {
            \App\Models\JobCard::create(['module_id' => $module_id, 'client_id' => $client_id, 'user_id' => $user_id, 'date' => $date]);
        }
        return redirect('customer/Jobcard/' . $client_id . '/' . $date);
    }

    public function uploadJobCard() {
        if ($_POST) {
            $file = request()->file('job_card_file');

            if (($file)->getSize() > 2015110) {
                return redirect()->back()->with('error', 'File must have less than 2MBs');
            }

            $company_file_id = $file ? $this->saveFile($file, TRUE) : 1;
            $where = ['date' => request('job_date'), 'client_id' => request('client_id')];
            $card = DB::table('client_job_cards')->where($where)->first();
            $data = [
                'company_file_id' => $company_file_id,
                'client_id' => (int) request('client_id'),
                'created_by' => \Auth::user()->id,
                'date' => request('job_date')
            ];
            if (empty($card)) {
                \App\Models\ClientJobCard::create($data);
            } else {
                \App\Models\ClientJobCard::where($where)->update($data);
            }
        }
        return redirect()->back()->with('success', 'Uploaded succesfully!');
    }

    public function viewFile() {
        $value = request()->segment(3);
        $type = request()->segment(4);
        if ($type == 'course_certificate') {
            $certificate = \App\Models\Learning::where('id', $value)->first();
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

    public function allusers() {
        $notIn = ['Student', 'Teacher', 'Parent', 'Descipline Master', 'Head Teacher', 'Academic Master'];
        $this->data['allusers'] = DB::table('admin.all_users')->where('status', 1)->get();
        return view('customer.usage.alluser', $this->data);
    }

    public function expenseRecords() {
        $this->data['expenses'] = DB::table('admin.expense_report_by_month')->get();
        return view('customer.usage.expense_report', $this->data);
    }

    public function churnReport() {
        $year = $this->data['year'] = (int) request()->segment(2) == 0 ? date('Y') : request()->segment(2);
        $this->data['fetch_url'] = 'https://admin.shulesoft.com/898uuhihdsdskjdde/custrpt/12/?q=';
        $object = [
            'fees' => 'all_payments',
            'expenses' => 'all_expense',
            'salaries' => 'all_salaries',
            'inventory' => 'all_product_alert_quantity',
            'sattendance' => 'all_sattendances',
            'characters' => 'all_general_character_assessment',
            'digital' => 'all_assignments',
            'parents' => 'all_login_locations',
            'students' => 'all_login_locations',
            'login_staffs' => 'all_login_locations',
            'epayments_nmb' => 'all_payments',
            'epayments_crdb' => 'all_payments',
            'exams' => 'all_exam_report'
        ];
        $data = [];
        foreach ($object as $key => $value) {
            $this->data[$key . '_table'] = $value;

            switch ($key) {
                case 'parents':
                    $sql = ' and "table"=\'parent\' ';
                    break;
                case 'login_staffs':
                    $sql = '  and "table" in (\'user\',\'teacher\' ) ';
                    break;
                case 'epayments_nmb':
                    $sql = " and token like '%E%' ";
                    break;
                case 'epayments_crdb':
                    $sql = "  and token like '%cbb%' ";
                    break;
                case 'students':
                    $sql = ' and "table"=\'student\'  ';

                    break;

                default:
                    $sql = '';
                    break;
            }

            $data[$key] = $this->createChurnSql($value, $year, $sql);
            $this->data['new_customers_' . $key] = $this->getNewCustomers($value, $year, $sql);
        }
        $this->data['items'] = $data;
        return view('customer.usage.churn_report', $this->data);
    }

    private function createChurnSql($table, $year, $customer_other_sql = '') {
        return DB::select("select case when count is null then 0 else count end as count, extract(month from default_month)  as months  from ( SELECT count(distinct schema_name) as count,extract(month from created_at) as months from"
                        . " admin." . $table . " where extract(year from created_at)=$year   "
                        . " $customer_other_sql and  schema_name not in ('public','betatwo','jifunze','beta_testing','accounts') group by months) a 
    right JOIN admin.default_months b on months=extract(month from default_month)");
    }

    public function getNewCustomers($table, $year, $customer_other_sql = '') {
        $sql = '';
        for ($s = 1; $s <= 12; $s++) {
            $sql .= '  select count(*),x.months from (select distinct schema_name,extract(month from created_at) as months from admin.' . $table . ' where extract(year from created_at)=' . $year . ' and extract(month from created_at)=' . $s . '  ' . $customer_other_sql . ' and  schema_name not in (\'public\',\'betatwo\',\'jifunze\',\'beta_testing\')  ) x LEFT OUTER JOIN (select distinct schema_name,extract(month from created_at) as months from admin.' . $table . ' where extract(year from created_at)=' . $year . ' and extract(month from created_at)<' . $s . '  ' . $customer_other_sql . ' and  schema_name not in (\'public\',\'betatwo\',\'jifunze\',\'beta_testing\') ) y using(schema_name) where y.schema_name is null group by x.months UNION ALL';
        }
        $final = rtrim($sql, 'UNION ALL');
        return DB::select($final);
    }

    public function remaindpayment() {
        $year = (int) date('Y');
        // $this->data['unpaidclients'] = DB::select("select * from admin.clients where id in ( select client_id from admin.invoices where extract(year from created_at::date) = extract(year from current_date)
        //                                             and pay_status = '1' and id not in (select invoice_id from admin.payments ))");
        $account = \collect(DB::select("select id from admin.account_years where name='{$year}' "))->first();
        $this->data['unpaidclients'] = \App\Models\Invoice::whereIn('id', \App\Models\InvoiceFee::get(['invoice_id']))->whereNotIn('id', \App\Models\Payment::get(['invoice_id']))->where('account_year_id', $account->id)->latest()->get();
        return view('customer.remaindpayment', $this->data);
    }

    public function paymendRemainderMessages() {
        $unpaid_clients = \DB::select("select * from admin.clients_remain_payments where payment_deadline_date::date <= '2021-10-15' and username = 'public'");
        foreach ($unpaid_clients as $schema) {
            //  $directors =DB::select("select * from admin.all_users where usertype ilike '%director%' or usertype ilike '%Admin%' and schema_name = 'public'");
            $directors = DB::select("select * from admin.all_users where  schema_name = 'public' and username in ('0684033878','0655007457')");
            if (!empty($directors)) {
                foreach ($directors as $director) {
                    $message = 'A reminder to  ' . $schema->school_name . '.'
                            . chr(10) . 'a deadline for making payments for ShuleSoft system has passed, '
                            . chr(10) . 'kindly make payments before the system deactivates to avoid the inconvenience  for your school system users'
                            . chr(10) . 'Thanks.';

                    $ujumbe = 'Habari  ' . $director->name . '.'
                            . chr(10) . 'napenda kukutaarifu kwamba tarehe ya malipo ya mfumo wa ShuleSoft system umepita na unahitajika kufanya malipo kuondoa namna yeyote ya usumbufu ikiwemo system kujifunga'
                            . chr(10) . 'Asante.';

                    //  $this->send_sms($director->phone, $message, 1);
                    $this->send_sms($director->phone, $ujumbe, 1);
                    $controller = new \App\Http\Controllers\Controller();
                    //  $controller->send_whatsapp_sms($director->phone, $message);
                    $controller->send_whatsapp_sms($director->phone, $ujumbe);
                }
            }
        }
    }

    public function createTodayReport() {
        $schemas = DB::select("select distinct schema_name from admin.all_payments where extract(year from created_at)>2020 and schema_name not in ('jknyerere')");
        foreach ($schemas as $schema_) {
            $schema = $schema_->schema_name;
            $info = \collect(DB::select('select sum(amount) as payments from ' . $schema . '.payments where created_at::date=current_date'))->first();
            $info_electronic = \collect(DB::select('select sum(amount) as payments from ' . $schema . '.payments where transaction_id is not null and created_at::date=current_date'))->first();
            $expense = \collect(DB::select('select sum(amount) as expense from ' . $schema . '.expense where created_at::date=current_date'))->first();
            $list = \collect(DB::select('select email_list,sname from ' . $schema . '.setting'))->first();

            $electronic = !empty($info_electronic) && $info_electronic->payments > 0 ? ' _Malipo kwa control namba, jumla ni_ *Tsh ' . $info_electronic->payments . ' /=* ' : '';
            $message_kw = 'Habari ' . chr(10) . chr(10) . 'Repoti ya leo : *' . date('d M Y') . '*  kutoka *' . ucwords(strtolower($list->sname)) . '* ' . chr(10) . chr(10) . ''
                    . 'Jumla ya Makusanyo  ni : *Tsh ' . number_format($info->payments) . ' /=*' . $electronic . chr(10)
                    . 'Jumla ya matumizi ni : *Tsh ' . number_format($expense->expense) . ' /=*' . chr(10) . chr(10) . ''
                    . 'Kwa taarifa kamili, ingia katika mfumo wa ShuleSoft' . chr(10) . chr(10) .
                    '[_Hii repoti  imetengenezwa automatically kutoka https://' . $schema . '.shulesoft.com na hutumwa kila siku. Kubadili, kuongeza au kuondoa hii namba, nenda sehemu ya settings kwenye mfumo wako wa ShuleSoft_]';
            $phones = explode(',', $list->email_list);

            foreach ($phones as $phone) {
                if (filter_var($phone, FILTER_VALIDATE_EMAIL)) {
                    $this->send_email($phone, 'ShuleSoft : Repoti ya ' . date('d M Y'), preg_replace('/*/i', NULL, $message_kw));
                }
                if (!filter_var($phone, FILTER_VALIDATE_EMAIL)) {
                    $chat_id = ltrim(trim($phone), 0);
                    $this->send_whatsapp_sms($chat_id, $message_kw);
                }
            }
        }
    }

    public function updateSchoolTrialPeriod() {
        $client_id = request('client_id');
        $period = request('period');
        $start_date = request('start_date');
        $end_date = date('Y-m-d', strtotime($start_date . " + $period days"));
        $exist = \App\Models\ClientTrial::where('client_id', $client_id)->first();
        $data = ['client_id' => $client_id, 'period' => $period, 'start_date' => $start_date, 'end_date' => $end_date, 'status' => 1];
        empty($exist) ? \App\Models\ClientTrial::create($data) : \App\Models\ClientTrial::where('client_id', $client_id)->update($data);
        \App\Models\Client::where('id', $client_id)->update(['trial' => 1]);
        return redirect()->back()->with('success', 'Trial period updated successfull');
    }

    public function sendInvoice() {
        $caption = request('message');
        $phone = request('phone_number');
        $file = request()->file('invoice_file');
        if ($_POST) {

            //   $path = $this->uploadFileLocal($file);
            $path = "https://admin.shulesoft.com/storage/uploads/images/90221642764123.pdf";
            //   $filename = $file->getClientOriginalName();
            $filename = 'TEST';
            $this->sendWhatsappFiles($phone, $filename, $path);
        }
    }

    public function requirementUpload() {
        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\RequirementImport, request()->file('excel_tasks'));
        return redirect('customer/requirements')->with('success', 'All requirements uploaded successfully!');
    }

    public function searchRequirement() {
        $this->data['from_date'] = request('from_date');
        $this->data['to_date'] = request('to_date');
        return view('customer/analysis', $this->data);
    }

    public function checkTaskProgress($from_date, $to_date, $to_user_id = null) {
        if ($to_user_id == null) {
            $data = \collect(DB::select("select A.new_task,B.complete,C.progress,F.canceled,D.resolved,E.total,
                        (A.new_task::float/NULLIF(E.total::float,0))*100 as percentage_new,
                        (B.complete::float/NULLIF(E.total::float,0))*100 as percentage_complete,
                        (C.progress::float/NULLIF(E.total::float,0))*100 as percentage_progress,
                        (F.canceled::float/NULLIF(E.total::float,0))*100 as percentage_canceled,
                        (D.resolved::float/NULLIF(E.total::float,0))*100 as percentage_resolved from 
                        (select count(*) as new_task from admin.requirements where status ilike '%new%' and created_at::date >= '{$from_date}' and 
                        created_at::date <= '{$to_date}') A,
                        (select count(*) as complete from admin.requirements where status ilike '%completed%' and created_at::date >= '{$from_date}' and 
                        created_at::date <= '{$to_date}') B,
                        (select count(*) as progress from admin.requirements where status ilike '%on progres%' and created_at::date >= '{$from_date}' and 
                        created_at::date <= '{$to_date}') C,
                        (select count(*) as resolved from admin.requirements where status ilike '%resolved%' and created_at::date >= '{$from_date}' and 
                        created_at::date <= '{$to_date}' ) D,
                        (select count(*) as canceled from admin.requirements where status ilike '%canceled%' and created_at::date >= '{$from_date}' and 
                        created_at::date <= '{$to_date}' ) F,
                        (select count(*) as total from admin.requirements where created_at::date >= '{$from_date}' and 
                        created_at::date <= '{$to_date}' ) E"))->first();
        } else {
            $data = \collect(DB::select("select A.new_task,B.complete,C.progress,F.canceled,D.resolved,E.total,
                        (A.new_task::float/NULLIF(E.total::float,0))*100 as percentage_new,
                        (B.complete::float/NULLIF(E.total::float,0))*100 as percentage_complete,
                        (C.progress::float/NULLIF(E.total::float,0))*100 as percentage_progress,
                        (F.canceled::float/NULLIF(E.total::float,0))*100 as percentage_canceled,
                        (D.resolved::float/NULLIF(E.total::float,0))*100 as percentage_resolved from 
                        (select count(*) as new_task from admin.requirements where to_user_id = '{$to_user_id}' and status ilike '%new%' and created_at::date >= '{$from_date}' and 
                        created_at::date <= '{$to_date}') A,
                        (select count(*) as complete from admin.requirements where to_user_id = '{$to_user_id}' and status ilike '%completed%' and created_at::date >= '{$from_date}' and 
                        created_at::date <= '{$to_date}') B,
                        (select count(*) as progress from admin.requirements where to_user_id = '{$to_user_id}' and status ilike '%on progres%' and created_at::date >= '{$from_date}' and 
                        created_at::date <= '{$to_date}') C,
                        (select count(*) as resolved from admin.requirements where to_user_id = '{$to_user_id}' and status ilike '%resolved%' and created_at::date >= '{$from_date}' and 
                        created_at::date <= '{$to_date}' ) D,
                        (select count(*) as canceled from admin.requirements where to_user_id = '{$to_user_id}' and status ilike '%canceled%' and created_at::date >= '{$from_date}' and 
                        created_at::date <= '{$to_date}' ) F,
                        (select count(*) as total from admin.requirements where to_user_id = '{$to_user_id}' and created_at::date >= '{$from_date}' and 
                        created_at::date <= '{$to_date}' ) E"))->first();
        }

        return $data;
    }

}

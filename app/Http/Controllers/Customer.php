<?php

namespace App\Http\Controllers;

use App\Jobs\PushSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \App\Models\User;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class Customer extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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

    function setup() {
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
    public function store(Request $request) {

        DB::table('constant.guides')->insert([
            'permission_id' => $request->permission_id,
            'content' => $request->content,
            'created_by' => Auth::user()->id,
            'language' => 'eng'
        ]);
        return redirect('support/guide');
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
                \App\Model\Guide::find(request('guide_id'))->update($request);
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

            $users = DB::table('all_users')->whereIn('usertype', request('for'))->get();
            foreach ($users as $user) {
                if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                    DB::table($user->schema_name . '.email')->insert(array(
                        'email' => $user->email,
                        'body' => str_replace('href="', 'href="' . $user->schema_name . '.shulesoft.com/', request('message')),
                        'subject' => strlen(request('subject')) > 4 ? request('subject') : 'ShuleSoft Latest Updates: ' . request('release_date'),
                        'user_id' => $user->id,
                        'table' => $user->table
                    ));
                    DB::table('public.sms')->insert(array(
                        'phone_number' => $user->phone,
                        'body' => strip_tags(request('message')),
                        'table' => $user->table,
                        'user_id' => $user->id,
                        'table' => $user->table
                    ));
                }
            }
            return redirect('customer/update')->with('success','success');
        }
        $this->data['usertypes'] = DB::select('select distinct usertype from admin.all_users');
        return view('customer.message.add_updates', $this->data);
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
        $this->data['shulesoft_users'] = \App\Models\User::all();
        $is_client = 0;
        if ($school == 'school') {
            $id = request()->segment(4);
            $this->data['client_id'] = $id;
            $this->data['school'] = \collect(DB::select(' select name as sname, name, region , ward, district as address  from admin.schools where id=' . $id))->first();
        } else {
            $is_client = 1;
            $this->data['school'] = DB::table($school . '.setting')->first();
            $this->data['levels'] = DB::table($school . '.classlevel')->get();
            $client = \App\Models\Client::where('username', $school)->first();
            if (count($client) == 0) {

                $client = \App\Models\Client::create(['name' => $this->data['school']->sname, 'email' => $this->data['school']->email, 'phone' => $this->data['school']->phone, 'address' => $this->data['school']->address, 'username' => $school]);
            }
            $this->data['client_id'] = $client->id;
            $this->data['top_users'] = DB::select('select count(*), user_id,a."table",b.name,b.usertype from ' . $school . '.log a join ' . $school . '.users b on (a.user_id=b.id and a."table"=b."table") where user_id is not null group by user_id,a."table",b.name,b.usertype order by count desc limit 5');
        }
        $this->data['is_client'] = $is_client;
        if ($_POST) {

            $data = array_merge(request()->all(), ['user_id' => Auth::user()->id]);
            $task = \App\Models\Task::create($data);
            if ((int) request('to_user_id') > 0) {
                $user = \App\Models\User::find(request('to_user_id'));
                $message = 'Hello ' . $user->firstname . '<br/>'
                        . 'A task has been allocated to you'
                        . '<ul>'
                        . '<li>Task: ' . $task->activity . '</li>'
                        . '<li>Type: ' . $task->taskType->name . '</li>'
                        . '<li>Deadline: ' . $task->date . '</li>'
                        . '</ul>';
                $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);
            }
            return redirect()->back()->with('success', 'success');
        }

        return view('customer/profile', $this->data);
    }

    public function allocate() {
        $school_id = request('school_id');
        $schema = request('schema');
        $user_id = request('user_id');
        $role_id = request('role_id');
        $school_info = DB::table('schools')->where('id', $school_id);
        count($school_info->first()) == 1 ? DB::table('users_schools')->insert(['school_id' => $school_id, 'user_id' => $user_id, 'role_id' => $role_id]) : '';
        $school_info->update(['schema_name' => $schema]);
        echo 1;
    }

    public function requirements() {
        $this->data['levels'] = [];
        return view('customer/analysis', $this->data);
    }

    public function modules() {
        $schemas = $this->data['schools'] = DB::select("SELECT distinct table_schema as schema_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema NOT IN ('admin','beta_testing','accounts','pg_catalog','constant','api','information_schema','public')");
        $sch = [];
        foreach ($schemas as $schema) {
            array_push($sch, $schema->schema_name);
        }
        $this->data['dschools'] = \App\Models\School::whereIn('schema_name', $sch)->get();
        return view('customer.modules', $this->data);
    }

    public function taskComment() {
        if (request('content') != '' && (int) request('task_id') > 0) {
            \App\Models\TaskComment::create(array_merge(request()->all(), ['user_id' => Auth::user()->id]));
            echo ' <div class="media m-b-20"><a class="media-left" href="#"><img class="media-object img-circle m-r-20" src="' . url('/') . '/public/assets/images/avatar-1.png" alt="Generic placeholder image"></a> <div class="media-body b-b-muted social-client-description"><div class="chat-header">' . Auth::user()->name . '<span class="text-muted">' . date('d M Y') . '</span></div><p class="text-muted">' . request('content') . '</p></div> </div>';
        }
    }

    public function calls() {
        $this->data['levels'] = [];
        return view('customer/analysis', $this->data);
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
        $table = request('table');
        $user_id = request('user_id');
        $value = request('val');
        $column = $table == 'student' ? 'student_id' : $table . 'ID';
        if ($table == 'bank') {
            return $this->setBankParameters();
        } else {
            DB::table($schema . '.' . $table)->where($column, $user_id)->update([$tag => $value]);
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
            foreach ($schools as $school) {

                echo '<p><a href="' . url('customer/map/' . $schema . '/' . $school->id) . '">' . $school->name . '( ' . $school->region . ' )</a></p>';
            }
        }
    }

    public function map() {
        $schema = request()->segment(3);
        $school_id = request()->segment(4);
        DB::table($schema . '.setting')->update(['school_id' => $school_id]);
        return redirect()->back()->with('success', 'success');
    }

}

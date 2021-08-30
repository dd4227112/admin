<?php

namespace App\Http\Controllers;

use App\Jobs\PushSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class Marketing extends Controller {

    public $patterns = array(
        '/#name/i', '/#username/i', '/#default_password/i', '/#email/i', '/#phone/i', '/#role/i', '/#student_name/i', '/#invoice/i', '/#balance/i', '/#student_username/i'
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
        }
        $this->data['faqs'] = DB::table('faq')->get();
        return view('market.faq', $this->data);
    }

    function presentation() {
        return view('market.presentation');
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

    function material() {
        return view('market.material');
    }

    function legal() {
        return view('market.legal');
    }

    function brand() {
        return view('market.brand');
    }

    public function allocation() {
        $this->data['school_types'] = DB::select('select type, COUNT(*) as count, 
SUM(COUNT(*)) over() as total_schools, 
(COUNT(*) * 1.0) / SUM(COUNT(*)) over() as percent
FROM admin.schools
group by type');
        $this->data['ownerships'] = DB::select('select ownership, COUNT(*) as count, 
SUM(COUNT(*)) over() as total_schools, 
(COUNT(*) * 1.0) / SUM(COUNT(*)) over() as percent
FROM admin.schools
group by ownership');
        // $this->data['schools']=DB::table('schools')->get();
        $this->data['regions'] = DB::select('select distinct region from admin.schools');
        if (request('region')) {
            $this->data['schools'] = DB::select("select * from admin.schools where region='" . request('region') . "'");
        } else {
            $this->data['schools'] = array();
        }
        return view('market.allocation', $this->data);
    }

    function getSchools() {
        return response()->json(DB::table('schools')->get());
    }

    function objective() {
        return view('market.objective');
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
    public function show($id) {
        //
        return $id;
        $this->data['type'] = $id;
          $table = $id == 'sms' ? 'all_sms' : 'all_email';
          $this->data['messages'] = DB::select('select * from admin.' . $table);
       //   $this->data['messages'] = [];

        return view('message.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function socialMedia() {
        $tab = request()->segment(3);
        $id = request()->segment(4);
        if ($tab == 'add') {
            if ($_POST) {
                $data = [
                    'user_id' => Auth::user()->id,
                    'type' => request('type'),
                    'category' => request('category'),
                    'note' => request('note'),
                    'title' => request('title')
                ];
                //    dd($data);
                $post = \App\Models\MediaPost::create($data);
                /*  $user = \App\Models\User::find($user_id);
                  $message = 'Hello ' . $user->firstname . '<br/>'
                  . 'A task has been allocated to you'
                  . '<ul>'
                  . '<li>Task: ' . $post->activity . '</li>'
                  . '<li>Type: ' . $post->taskType->name . '</li>'
                  . '<li>Deadline: ' . $post->date . '</li>'
                  . '</ul>';
                  $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);
                 */


                if (!empty($post->id) && request('socialmedia_id')) {
                    $modules = request('socialmedia_id');
                    foreach ($modules as $key => $value) {
                        if (request('socialmedia_id')[$key] != '') {
                            $array = ['socialmedia_id' => request('socialmedia_id')[$key], 'post_id' => $post->id];
                            $check_unique = \App\Models\SocialMediaPost::where($array);
                            if (empty($check_unique->first())) {
                                \App\Models\SocialMediaPost::create($array);
                            }
                        }
                    }
                }
                return redirect('Marketing/socialMedia')->with('success', 'success');
            }
            $this->data['socialmedia'] = \App\Models\SocialMedia::all();
            return view('market/addpost', $this->data);
        } elseif ($tab == 'show' && $id > 0) {
            $status = request()->segment(5);
            $this->data['published'] = $status;
            $this->data['post'] = \App\Models\MediaPost::find($id);
            return view('market/view_media', $this->data);
        } else {

            $this->data['posts'] = \App\Models\MediaPost::orderBy('id', 'DESC')->get();
            return view('market/medias', $this->data);
        }
    }

    public function socialMediaUpdate() {
        $media = request("socialmedia_id");
        $post = request("post_id");
        $type = request("type_id");
        $number = request("inputs");
        if ($number == '') {
            $number = 0;
        }
        $now = date('Y=m-d H:i:s');
        if ((float) request("inputs") >= 0 && request("post_id") != '' && request("socialmedia_id") != '') {
            \App\Models\SocialMediaPost::where('post_id', $post)->where('socialmedia_id', $media)->update([$type => $number, 'updated_at' => $now]);
            echo "success";
        } else {
            echo "Class can not be empty";
        }
    }

    public function addEvent() {
        if ($_POST) {
            $file_id = null;
            $attach_id = null;
            if (!empty(request('attached'))) {
                $file_id = $this->saveFile(request('attached'), 'company/contracts');
            }

            if (!empty(request('image'))) {
                $attach_id = $this->saveFile(request('image'), 'company/contracts');
            }
            $array = [
                'title' => request('title'),
                'note' => request('note'),
                'event_date' => request('event_date'),
                'start_time' => request('start_time'),
                'end_time' => request('end_time'),
                'category' => request('category'),
                'department_id' => request('department_id'),
                'meeting_link' => request('meeting_link'),
                'user_id' => Auth::user()->id,
                'file_id' => $file_id,
                'attach_id' => $attach_id
            ];
            $minute = \App\Models\Events::create($array);
            return redirect('marketing/events')->with('success', request('title') . ' added successfully');
        }
        $this->data['users'] = \App\Models\User::all();
        return view('market.add_event', $this->data);
    }

    public function Events() {
        /**
         * add option for someone to write an attendance and upload via excel in case you visit TAMONGSCO 
         */
        $id = request()->segment(3);
        if ((int) $id > 0) {

            if ($_POST) {

                $body = request('message');
                $sms = request('sms');
                $email = request('email');
                $events = \App\Models\EventAttendee::where('event_id', $id)->get();
                $workshop = \App\Models\Events::where('id', $id)->first();
                foreach ($events as $event) {
                    if ($event->email != '' && (int) $email > 0) {
                        $message = '<h4>Dear ' . $event->name . '</h4>'
                                . '<h4>I trust this email finds you well.</h4>'
                                . '<h4>' . $body . '</h4>'
                                . '<p><br>Looking forward to hearing your contribution in the discussion.</p>'
                                . '<br>'
                                . '<p>Thanks and regards,</p>'
                                . '<p><b>Shulesoft Team</b></p>'
                                . '<p>Call: +255 655 406 004 </p>';
                        $this->send_email($event->email, 'ShuleSoft Webinar on ' . $workshop->title, $message);
                    }
                    if ($event->phone != '' && (int) $sms > 0) {
                        $message1 = 'Dear ' . $event->name . '.'
                                . chr(10) . $body
                                . chr(10)
                                . chr(10) . 'Shulesoft Team'
                                . chr(10) . 'Call: +255 655 406 004 ';
                        $sql = "insert into public.sms (body,user_id, type,phone_number) values ('$message1', 1, '0', '$event->phone')";
                        $chatId = $event->phone . '@c.us';
                        $this->sendMessage($chatId, $message1);

                        DB::statement($sql);
                    }
                }
                return redirect()->back()->with('success', 'Message Sent Successfully to ' . count($events) . ' Attendees.');
            }
            $this->data['event'] = \App\Models\Events::where('id', $id)->first();
            return view('market.view_event', $this->data);
        }
        $this->data['events'] = \App\Models\Events::orderBy('id', 'DESC')->get();
        return view('market.events', $this->data);
    }

    public function deleteMinute() {
        $id = request()->segment(3);
        \App\Models\Minutes::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Minute Deleted');
    }

    public function tasks() {
        $this->data['users'] = 1;
        return view('users.tasks', $this->data);
    }

    public function getDistrict() {
        $id = request('region');
        $districts = \App\Models\District::where('region_id', $id)->get();
        if (count($districts) > 0) {
            $select = '';
            foreach ($districts as $type) {
                $select .= '<option value="' . $type->id . '"> ' . $type->name . '</option>';
            }
            echo $select;
        } else {
            $districts = \App\Models\District::all();
            $select = '';
            foreach ($districts as $type) {
                $select .= '<option value="' . $type->id . '"> ' . $type->name . '</option>';
            }
            echo $select;
        }
    }

    public function getWard() {
        $id = request('district');
        $districts = \App\Models\Ward::where('district_id', $id)->get();
        if (count($districts) > 0) {
            $select = '';
            foreach ($districts as $type) {
                $select .= '<option value="' . $type->id . '"> ' . $type->name . '</option>';
            }
            echo $select;
        }
    }

    public function school() {
        $end_date = date('Y-m-01');
        $where = "a.created_at::date >='" . $end_date . "'";
        $this->data['use_shulesoft'] = DB::table('admin.all_setting')->count() - 5;
        $this->data['active_school'] = \collect(DB::select('SELECT count(distinct "schema_name") from admin.all_login_locations a  WHERE "table" in (\'setting\',\'users\',\'teacher\') and ' . $where))->first()->count;
        $this->data['zero_student'] = DB::select('SELECT distinct("schema_name") as tables from admin.all_setting a  WHERE a.school_status= 1 and "schema_name" not in (select distinct "schema_name" from admin.all_student group by "schema_name")');
        $this->data['never_use'] = DB::table('admin.nmb_schools')->count();
        $this->data['never_use'] = DB::table('admin.nmb_schools')->count();
        $this->data['nmb_shulesoft_schools'] = \collect(DB::select("select count(distinct schema_name) as count from admin.all_bank_accounts where refer_bank_id=22"))->first()->count;
        $this->data['school_types'] = DB::select("select type, count(*) from admin.schools where ownership='Non-Government' group by type,ownership");
        $this->data['ownerships'] = DB::select('select ownership, COUNT(*) as count, SUM(COUNT(*)) over() as total_schools, 
        (COUNT(*) * 1.0) / SUM(COUNT(*)) over() as percent FROM admin.schools group by ownership');
        return view('market.schools', $this->data);
    }

    public function moduleUsage() {
        $end_date = date('Y-m-01');
        $where = "a.created_at::date >='" . $end_date . "'";
        $this->data['use_shulesoft'] = DB::table('admin.all_setting')->count() - 5;
        $this->data['active_school'] = \collect(DB::select('SELECT count(distinct "schema_name") from admin.all_login_locations a  WHERE "table" in (\'setting\',\'users\',\'teacher\') and ' . $where))->first()->count;
        $this->data['zero_student'] = DB::select('SELECT distinct("schema_name") as tables from admin.all_setting a  WHERE a.school_status= 1 and "schema_name" not in (select distinct "schema_name" from admin.all_student group by "schema_name")');
        $this->data['never_use'] = DB::table('admin.nmb_schools')->count();
        $this->data['never_use'] = DB::table('admin.nmb_schools')->count();
        $this->data['nmb_shulesoft_schools'] = \collect(DB::select("select count(distinct schema_name) as count from admin.all_bank_accounts where refer_bank_id=22"))->first()->count;
        $this->data['school_types'] = DB::select("select type, count(*) from admin.schools where ownership='Non-Government' group by type,ownership");
        $this->data['ownerships'] = DB::select('select ownership, COUNT(*) as count, SUM(COUNT(*)) over() as total_schools, 
        (COUNT(*) * 1.0) / SUM(COUNT(*)) over() as percent FROM admin.schools group by ownership');

        return view('market.module_usage', $this->data);
    }

    public function systemUser() {
        $this->data['type'] = $type = request()->segment(4);
        $this->data['status'] = $status = request()->segment(3);
        $end_date = date('Y-m-01');
        // dd($end_date);
        $this->data['where'] = $where = "a.created_at::date >='" . $end_date . "'";
        // $this->data['active_users'] = DB::SELECT('SELECT "table", count(*) as count from admin.all_users where status=1 and ("table",id) in (select "table", user_id from admin.all_log a where ' . $where .' group by "table",user_id) group by "table"  order by "table"');
        //$this->data['notactive_users'] = DB::SELECT('SELECT "table", count(*) as count from admin.all_users where status=1 and ("table",id) in (select "table", user_id from admin.all_log a where ' . $where .'group by "table",user_id) group by "table"  order by "table"');
        $this->data['users'] = DB::SELECT('SELECT "table", count(*) as count from admin.all_users where status=1  group by "table" order by "table"');
        if ($type != '' && $status != '') {
            $table = "'" . $type . "'";
            if ($status == 'active') {
                //   $this->data['list_of_users'] = DB::SELECT('SELECT schema_name, count(*) as count from admin.all_users where status=1 and ("table",id) in (select a."table", a.user_id from admin.all_log a where ' . $where . '  and "table" = ' . $table . ' group by a."table", a.user_id) group by schema_name order by count(schema_name) desc');
            }if ($status == 'notactive') {
                //  $this->data['list_of_users'] = DB::SELECT('SELECT schema_name, count(*) as count from admin.all_users where status=1 and  ("table",id) not in (select a."table", a.user_id from admin.all_log a where ' . $where . '  and "table" = ' . $table . '  group by a."table", a.user_id) group by schema_name order by count(schema_name) desc');
            }if ($status == 'all') {
                $this->data['list_of_users'] = DB::SELECT('SELECT schema_name, count(*) as count from admin.all_users where status=1 and "table" = ' . $table . ' group by schema_name order by count(schema_name) desc');
            }
        }

        return view('market.system_user', $this->data);
    }

    public function Users() {
        $type = request()->segment(3);
        $id = request()->segment(4);
        $end_date = date('Y-m-01');
        $where = "a.created_at::date >='" . $end_date . "'";

        $this->data['active_parents'] = \collect(DB::select('select count(*) as count from admin.all_parent where status=1'))->first()->count;
        $this->data['active_students'] = \collect(DB::select('select count(*) as count from admin.all_student where status=1'))->first()->count;
        $this->data['active_teachers'] = \collect(DB::select('select count(*) as count from admin.all_teacher where status=1'))->first()->count;
        $this->data['active_users'] = DB::SELECT('select "table", count(*) as count from admin.all_users where status=1 and ("table",id) in (select "table", user_id from admin.all_log where ' . $where . ' group by "table"');

        $this->data['parents'] = \collect(DB::select('select count(*) as count from admin.all_parent where status=1'))->first()->count;
        $this->data['students'] = \collect(DB::select('select count(*) as count from admin.all_student  where status=1'))->first()->count;
        $this->data['teachers'] = \collect(DB::select('select count(*) as count from admin.all_teacher  where status=1'))->first()->count;
        $this->data['users'] = \collect(DB::select('select count(*) as count from admin.all_users  where status=1'))->first()->count;

        echo json_call($this->data);
    }

    public function Communication() {
        $this->data['never_use'] = DB::table('admin.nmb_schools')->count();
        if ($_POST) {
            $this->validate(request(), [
                'message' => 'required'
            ]);
            $fee_id = request("fee_id");
            $message = request("message");
            $module_id = request("module_id");
            $section_id = 0;
            $criteria = request('criteria');
            $firstCriteria = request('firstCriteria');
            $student_type = request('student_type');
            $student_type_value = request('student_type_value');
            $payment_status = request('payment_status');



            /* --- --- --- firstCriteria is parents - Send SMS to parents --- --- */
            if ($firstCriteria == 00) {
                //customers First
                return $this->sendCustomSmsToCustomers($criteria, $section_id, $module_id, $fee_id, $student_type_value, $payment_status, $message);
            } else if ($firstCriteria == '02') {
                $custom_numbers = request('custom_numbers');
                $sms = request('message');
                $numbers = [];
                if (preg_match('/,/', $custom_numbers)) {
                    $numbers = explode(',', $custom_numbers);
                } else if (preg_match('/ /', $custom_numbers)) {
                    $numbers = explode(' ', $custom_numbers);
                } else {
                    $numbers = [$custom_numbers];
                }
                $sent_to = 0;
                $wrong = 0;
                $invalid_numbers = '';

                foreach ($numbers as $number) {
                    $valid = validate_phone_number($number);
                    if (is_array($valid)) {
                        $sent_to++;
                        $this->send_sms($valid[1], $sms);
                    } else {
                        $wrong++;
                        $invalid_numbers .= $number . ',';
                    }
                }
                return redirect(base_url("mailandsms/add"))->with('success', 'sent successfully to ' . $sent_to . ' people. ' . $wrong . ' invalid number (' . $invalid_numbers . ')');
            } else {
                /* --- --- ---Send message to prospects--- --- --- */
                return $this->sendCustomSmsToTeachers($patterns, $section_id, $class_id, $message);
            }
        }
        return view('market.communication.index', $this->data);
    }

    public function sendCustomSmsToCustomers($criteria, $section_id = 0, $class_id = null, $fee_id = null, $student_type_value = null, $payment_status = null, $message = null) {
        switch ($criteria) {
            case 0:
                $parents = DB::select('select p.*, s.username as student_username, s.name as student_name from ' . set_schema_name() . 'student_parents sp join ' . set_schema_name() . 'parent p on p."parentID"=sp.parent_id join ' . set_schema_name() . 'student s on s."student_id"=sp.student_id where s.status=1');
                break;
            case 1:
                //all active customers with specific module

                $module_id = $class_id;
                $module = \DB::table('admin.modules')->where('id', $module_id)->first();
                if (!empty($module)) {
                    $check = DB::select("select * from information_schema.tables where table_name='all_student' and table_schema='admin'  limit 1");
                    if (empty($check)) {
                        DB::statement("select * from admin.join_all({$module->table},'created_at')");
                    }
                    $sql = "select name,phone,email,schema_name,username from admin.all_users where status=1 and lower(usertype)='admin' and schema_name in (select  distinct schema_name from admin.all_{$module->table} where created_at >= date_trunc('month', now()) - interval '1 month' and created_at < date_trunc('month', now()))";
                    $parents = DB::select($sql);
                }
                break;
            case 2:
                //Not active modules
                $module_id = $class_id;
                $module = \DB::table('admin.modules')->where('id', $module_id)->first();
                if (!empty($module) && strlen($module->table) > 3) {
                    $check = \collect(DB::select("select * from information_schema.tables where table_name='all_student' and table_schema='admin'  limit 1"))->first();
                    if (empty($check)) {
                        DB::statement("select * from admin.join_all({$module->table},'created_at')");
                    }
                    $sql = "select name,phone,email,schema_name,username from admin.all_users where status=1 and lower(usertype)='admin' and schema_name NOT in (select distinct schema_name from admin.all_{$module->table} where created_at >= date_trunc('month', now()) - interval '3 month' and created_at < date_trunc('month', now()))";
                    $parents = DB::select($sql);
                }


                break;
            case 3:

                if ($payment_status == 0) {
                    //payments not being done
                    return $this->smsWithPendingBalance($message);
                } else if ($payment_status == 1) {
                    //parents with discount
                    $parents = DB::select('select * from ' . set_schema_name() . 'parent WHERE "parentID" IN (SELECT parent_id from ' . set_schema_name() . 'student_parents WHERE student_id IN (SELECT "student_id" from ' . set_schema_name() . 'discount where discount>0  ' . $this->getLeastAmount('discount') . '))');
                } else if ($payment_status == 2) {
                    //with discount
                    return $this->smsWithPendingBalance($message);
                    //return $this->smsWithPendingBalance($message);
                }
                break;
            case 4:

                $parents = DB::select('select * from ' . set_schema_name() . 'parent where "parentID" IN (' . implode(',', request('parents')) . ')');
                break;
            case 5:
                //based on transport routes

                $parents = DB::select('select * from ' . set_schema_name() . 'parent where "parentID" IN (select parent_id from ' . set_schema_name() . 'student_parents where student_id in (select "student_id" FROM ' . set_schema_name() . 'tmembers where transport_route_id in (' . implode(',', request('transport_id')) . ' ) ))');
                break;
            case 6:
                //based on hostel routes

                $sql = 'select * from ' . set_schema_name() . 'parent where "parentID" IN (select parent_id from ' . set_schema_name() . 'student_parents where student_id in (select a."student_id" FROM ' . set_schema_name() . 'hmembers a join ' . set_schema_name() . 'student b on b.student_id=a.student_id  where hostel_id in (select id from ' . set_schema_name() . 'hostels where id in (' . implode(',', request('hostel_id')) . ' )) and b.status=1 ))';



                $parents = DB::select($sql);

                break;
            case 9:

                $parents = DB::select('select * from ' . set_schema_name() . 'parent where "parentID" IN (' . implode(',', request('parents')) . ')');
                break;

            case 10:
                $parents = DB::select('select * from ' . set_schema_name() . 'parent where "parentID" IN (' . implode(',', request('parents')) . ')');
                break;

            default:
                break;
        }

        if (isset($parents) && count($parents) > 0) {
            foreach ($parents as $parent) {

                $replacements = array(
                    $parent->name, $parent->username, $parent->schema_name
                );

                $sms = $this->getCleanSms($replacements, $message, array(
                    '/#name/i', '/#username/i', '/#schema_name/i',
                ));

                $this->send_sms($parent->phone, $sms);
            }

            return redirect()->back()->with('success', 'Message sent successfuly');
        } else {
            return redirect()->back()->with('error', 'Message Failed to be sent');
        }
    }

    public function getCleanSms($replacements, $message, $pattern = null) {

        $sms = preg_replace($pattern != null ? $pattern : $this->patterns, $replacements, $message);
        if (preg_match('/#/', $sms)) {
            //try to replace that character
            return preg_replace('/\#[a-zA-Z]+/i', '', $sms);
        } else {
            return $sms;
        }
    }

    public function sendCustomSmsToTeachers($patterns, $section_id = 0, $class_id = null, $message = null) {


        $teachersCriteria = request('teachersCriteria');
        $success_message = [];

        switch ($teachersCriteria) {


            case 001:

                //Send SMS to all teachers
                $teachers = Teacher::where('status', 1)->get();

                $success_message = 'SMS successfully sent to all teachers';

                break;
            case 002:

                //Send SMS to teachers of a specified $section_id section
                if ($section_id == 0) {
                    $class = \App\Model\Classes::find($class_id);
                    $classlevel_id = $class->classlevel->classlevel_id;
                    $academic_id = $this->academic_year_m->get_current_year($classlevel_id)->id;
                    $teachers = \App\Model\SectionSubjectTeacher::whereIn("sectionID", \App\Model\Section::where('classesID', $class_id)->get(['sectionID']))
                            ->join('teacher as t', "section_subject_teacher.teacherID", '=', 't.teacherID')
                            ->where("t.status", 1)
                            ->get();
                } else {
                    $teachers = \App\Model\SectionSubjectTeacher::where("sectionID", $section_id)
                            ->join('teacher as t', "section_subject_teacher.teacherID", '=', 't.teacherID')
                            ->where("t.status", 1)
                            ->get();
                }
                $success_message = 'SMS successfully sent to all teachers teaching ' . \App\Model\Section::where(['sectionID' => $section_id])->value('section');
                break;

            case 003:

                //Send SMS to specified teachers according to phone number or names
                $teachers = DB::select('select * from ' . set_schema_name() . 'teacher where "teacherID" IN (' . implode(',', request('teachers')) . ') and status=1');
                $success_message = 'SMS successfully sent to selected teacher(s)';
                break;
            default:
                break;
        }


        if (isset($teachers) && count($teachers) > 0) {
            foreach ($teachers as $teacher) {
                $default_password = $teacher->default_password == '' ? random_string() : $teacher->default_password;
                $replacements = array(
                    $teacher->name, $teacher->username, $default_password
                );

                $sms = $this->getCleanSms($replacements, $message);
                $this->send_sms($teacher->phone, $sms);
            }
            return redirect()->back()->with('success', $success_message);
        } else {

            return redirect()->back()->with('error', $this->lang->line('no_teachers_error'));
        }
    }

}

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

     
    public function DeleteMedia(){
        $id = request()->segment(3);
        if($id){
         \App\Models\Events::where('id', $id)->delete();
           return redirect()->back()->with('success', 'Deleted Successfully');
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
        return $id;
        $this->data['type'] = $id;
          $table = $id == 'sms' ? 'all_sms' : 'all_email';
         // $this->data['messages'] = DB::select('select * from admin.' . $table);
          $this->data['messages'] = [];
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
            
                $post = \App\Models\MediaPost::create($data);
            
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
        $now = date('Y-m-d H:i:s');
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
                $file_id = $this->saveFile(request('attached'), 'company/contracts',TRUE);
            }

            if (!empty(request('image'))) {
                $attach_id = $this->saveFile(request('image'), 'company/contracts',TRUE);
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

    
     function getTemplateContent() {
        $id = (int) request('templateID');
        $template = DB::table('admin.mailandsmstemplates')->where('id', $id)->first();
        return $template->message;
    }


    public function communication() {
        $this->data['never_use'] = DB::table('admin.nmb_schools')->count();
        if ($_POST) { 
            $this->validate(request(), [
                'message' => 'required'
            ]);

            $message = request("message");
            $prospectscriteria = request('prospectscriteria');
            $leadscriteria = request('leadscriteria');
            $firstCriteria = request('firstCriteria');
            $customer_criteria = request('customer_criteria');
            $customer_segment = request('customer_segment');
            $custom_numbers = request('custom_numbers');
            $criteria = request('less_than');
            $student_number = request('student_number');


            switch ($firstCriteria) {
                case 00:   
                    //customers First
                    return $this->sendCustomSmsToCustomers($message,$customer_criteria,$criteria,$student_number,$prospectscriteria = null, $leadscriteria = null,$customer_segment = null);
                    break;
                case 01:
                    //Prospects
                    return $this->sendCustomSmsToProspects($message, $custom_numbers);
                    break;
                case 02:
                    //Leads
                    return $this->sendCustomSmsToLeads($message, $custom_numbers);
                    break;
                case 03:
                    //All customers
                    return $this->sendCustomSmsToAll($message, $section_id, $message);
                    break;
                case 04:
                    // Not Custom selection
                    return $this->sendCustomSms($message, $section_id, $message);
                    break;
                default:
                    break;
            }
        }
        return view('market.communication.index', $this->data);
    }

    public function sendCustomSmsToCustomers($message,$customer_criteria,$criteria,$student_number,$prospectscriteria = null,$leadscriteria = null,$customer_segment = null) {
        $dates = date('Y-m-d',strtotime('first day of January'));
    
        switch ($customer_criteria) {
            case 0:   //All customers (paid)
                $customers = \DB::select("select * from admin.clients where id in (select client_id from admin.invoices where id in (select invoice_id from admin.payments where created_at::date > '" . $this->dates . "'))");
                break;
            case 1:
                //Active & Full paid customers
                  $customers = \DB::select("select a.client_id,a.name,a.username,a.remain_amount from (select i.client_id,i.reference,i.account_year_id,c.name,c.username,f.amount as total_amount,COALESCE(sum(p.amount),0) as paid_amount,f.amount - COALESCE(sum(p.amount),0) as remain_amount from admin.invoices i join admin.invoice_fees f on i.id = f.invoice_id join admin.payments p on p.invoice_id = i.id join admin.clients c on c.id = i.client_id group by i.reference,i.account_year_id,f.amount,c.name,i.client_id,c.username ) a where a.remain_amount = 0");
                break;
            case 2:
                //Active & partial paid customers
                  $customers = \DB::select("select a.client_id,a.name,a.username,a.total_amount,a.remain_amount from (select i.client_id,i.reference,i.account_year_id,c.name,c.username,f.amount as total_amount,COALESCE(sum(p.amount),0) as paid_amount,f.amount - COALESCE(sum(p.amount),0) as remain_amount from admin.invoices i join admin.invoice_fees f on i.id = f.invoice_id join admin.payments p on p.invoice_id = i.id join admin.clients c on c.id = i.client_id group by i.reference,i.account_year_id,f.amount,c.name,i.client_id,c.username ) a where a.remain_amount > 0");
                break;
            case 3:
                // Active but not paid customers (have S.I)
                  $customers = \DB::select("select a.client_id,a.name,a.username,a.total_amount,a.paid_amount from (select i.client_id,i.reference,i.account_year_id,c.name,c.username,f.amount as total_amount,COALESCE(sum(p.amount),0) as paid_amount,f.amount - COALESCE(sum(p.amount),0) as remain_amount from admin.invoices i join admin.invoice_fees f on i.id = f.invoice_id join admin.payments p on p.invoice_id = i.id join admin.clients c on c.id = i.client_id group by i.reference,i.account_year_id,f.amount,c.name,i.client_id,c.username ) a where a.paid_amount = 0 and a.client_id in (select client_id from admin.standing_orders)");
                break;
            case 4:
                // Not active & paid customers
                break;

            case 5:
                return $this->sendCustomSmsBySegment($message,$customer_segment,$criteria,$student_number);
                break;
            default:
                break;
        }
        if (isset($customers) && count($customers) > 0) { 
            foreach ($customers as $customer) {

                $replacements = array(
                    $customer->name, $customer->username
                );

            $sms = $this->getCleanSms($replacements, $message, array(
                    '/#name/i', '/#username/i', '/#schema_name/i',
                ));

                $this->send_sms($customer->phone, $sms);
            }

            return redirect()->back()->with('success', 'Message sent successfuly');
        } else {
            return redirect()->back()->with('error', 'Message Failed to be sent');
        }
    }

  

    public function sendCustomSmsToProspects($message,$custom_numbers) {
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


       $replacements = array('', '', '', '', '', '');

        $sms = $this->getCleanSms($replacements, $message);

        foreach ($numbers as $number) {
            $valid = validate_phone($number);
            if (is_array($valid)) {
                $sent_to++;
                $this->send_sms($valid[1], $sms, 0, 1);
            } else {
                $wrong++;
                $invalid_numbers .= $number . ',';
            }
        }
    }


    public function sendCustomSmsToLeads($message,$custom_numbers) {
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


       $replacements = array('', '', '', '', '', '');

        $sms = $this->getCleanSms($replacements, $message);

        foreach ($numbers as $number) {
            $valid = validate_phone($number);
            if (is_array($valid)) {
                $sent_to++;
                $this->send_sms($valid[1], $sms, 0, 1);
            } else {
                $wrong++;
                $invalid_numbers .= $number . ',';
            }
        }
    }


    public function sendCustomSmsToAll($message,$customer_criteria,$prospectscriteria = null,$leadscriteria = null,$customer_segment = null){
        $customers = DB::select("select * from admin.all_setting");
        if (isset($customers) && count($customers) > 0) {
            foreach ($customers as $customer) {
                $replacements = array(
                    $customer->name, $customer->schema_name
                );
                $sms = $this->getCleanSms($replacements, $message, array(
                    '/#name/i','/#schema_name/i','/#username/i'
                ));
                $this->send_sms($customer->phone, $sms);
            }
            return redirect()->back()->with('success', 'Message sent successfuly');
        } else {
            return redirect()->back()->with('error', 'Message Failed to be sent');
        }
    }


    public function sendCustomSms(){

    }


    public function sendCustomSmsBySegment($message,$customer_segment,$criteria,$student_number){
         switch ($customer_segment) {
            case 00: //Nursey schools only 
                $segments = DB::select("select * from admin.all_classlevel where lower(name) = 'nursery' or lower(name) = 'nursery level'");
                break;
            case 01:
                //Primary schools
                $segments = DB::select("SELECT * FROM admin.all_classlevel WHERE lower(name) = 'primary' OR lower(name) = 'primary level'");
                break;
            case 02:
                //Secondary schools
                $segments = DB::select("SELECT * FROM admin.all_classlevel WHERE lower(name) = 'a-level' OR lower(name) = 'o-level' or lower(name) = 'secondary' or lower(result_format) = 'csee' or lower(result_format) = 'acsee'");
                break;
            case 03:
                // College only
                $segments = DB::select("SELECT * FROM admin.all_classlevel WHERE lower(result_format) = 'college' or lower(name) = 'nacte'");

                break;
            case 04:
                // Schools with student (greater than or less than)
                return $this->sendSmsByStudentNumber($message,$criteria,$student_number,$customer_segment);
                break;
            default:
                break;
        }
        if (isset($segments) && count($segments) > 0) {
            foreach ($segments as $segment) {
                $customer = \collect(\DB::select("select * from admin.all_setting where schema_name ='{$segment->schema_name}'"))->first();

                $replacements = array(
                    $customer->sname, $segment->schema_name
                );

                $sms = $this->getCleanSms($replacements, $message, array(
                    '/#name/i', '/#username/i', '/#schema_name/i',
                ));

                $this->send_sms($customer->phone, $sms);
            }

            return redirect()->back()->with('success', 'Message sent successfuly');
        } else {
            return redirect()->back()->with('error', 'Message Failed to be sent');
        }
    }
     


     public function sendSmsByStudentNumber($message,$criteria,$student_number,$segment){
         $sql = $this->statusNumber($criteria,$student_number,$segment);
           dd($sql);
         $customers = DB::select("select * from admin.clients where estimated_students is not null $sql");
    
         if (isset($customers) && count($customers) > 0) {
            foreach ($customers as $customer) {
                $replacements = array(
                    $customer->name, $customer->username
                );

                $sms = $this->getCleanSms($replacements, $message, array(
                    '/#name/i', '/#username/i', '/#schema_name/i',
                ));

                $this->send_sms($customer->phone, $sms);
            }

            return redirect()->back()->with('success', 'Message sent successfuly');
        } else {
            return redirect()->back()->with('error', 'Message Failed to be sent');
        }
    }


    public function statusNumber($criteria,$number,$segment,$column = 'estimated_students') {
        $and = '';
        if ((int) $number > 0 && (int) $segment == 04 ) {
            if ((int) $criteria == 1) {
                $and = ' AND ' . $column . ' <=' . $number;
            } else if ((int) $criteria == 0) {
                $and = ' AND ' . $column . ' >=' . $number;
            } else if ((int) $criteria == 2) {
                $and = ' AND ' . $column . ' =' . $number;
            } else {
                $and = ' AND ' . $column . ' >=' . 0;
            }
        }
        return $and;
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



    public function templates(){
        $type = request()->segment(3);
        $id = request()->segment(4);
        $this->data['mailandsmstemplates'] =  DB::table('admin.mailandsmstemplates')->orderBy('created_at', 'desc')->get();
        if($type == 'delete'){
             DB::table('admin.mailandsmstemplates')->where('id',$id)->delete();
             return redirect(base_url('marketing/templates'))->with('success','Successful deleted!');
        }elseif($type == 'edit'){
             $this->data['temp'] = DB::table('admin.mailandsmstemplates')->where('id',(int) $id)->first();
             if($_POST){
                $data = request()->except('_token');
                DB::table('admin.mailandsmstemplates')->where('id',$id)->update($data);
                  return redirect(base_url('marketing/templates'))->with('success','Successful Edited!');
             }
              return view('market.communication.edittemplate',$this->data);
        }elseif($type == 'view'){
             $this->data['temp'] = DB::table('admin.mailandsmstemplates')->where('id',(int) $id)->first();
             return view('market.communication.viewtemplate',$this->data);
        }
        return view('market.communication.templates',$this->data);
    }

    public function addtemplate(){
          if ($_POST) {
                $validated = request()->validate([
                   'name' => 'required|max:255',
                   'message' => 'required',
                   ]);
                DB::table('admin.mailandsmstemplates')->insert(request()->except('_token'));
                return redirect(base_url('marketing/templates'))->with('success','Successfully!');;
            } else {
                return view('market.communication.addtemplate');
            }

    }


     

}

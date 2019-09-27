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
        $this->data['demo_requests'] = DB::table('website_demo_requests')->get();
        $this->data['join_requests'] = DB::table('website_join_shulesoft')->get();
        return view('sales.leads', $this->data);
    }

    public function prospect() {
        $this->data['demo_requests'] = DB::table('website_demo_requests')->get();
        $this->data['join_requests'] = DB::table('website_join_shulesoft')->get();
        $page = request()->segment(3);
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

    function profile() {
        return view('sales.profile');
    }

    public function school() {
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
                $sql = "select a.*, b.id as prospect_id, c.id as lead_id from admin.schools a  left join admin.prospects b on b.school_id=a.id left join admin.leads c on c.school_id=a.id where lower(a.ownership) <>'government'";
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
                  return $this->ajaxTable('error_logs', ['file', 'error_message', 'route', 'url', 'error_instance', 'created_at','schema_name']);
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

}

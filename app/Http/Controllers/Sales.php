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
        $this->data['use_shulesoft']=DB::table('admin.all_setting')->count()-5;
        $this->data['nmb_schools']=DB::table('admin.nmb_schools')->count();
        $this->data['nmb_shulesoft_schools']= \collect(DB::select("select count(distinct schema_name) as count from admin.all_bank_accounts where refer_bank_id=22"))->first()->count;
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
                $sql = "select * from admin.error_logs where deleted_at is null";
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
                return $this->ajaxTable('payments', ['a.id', 'amount','name','a.created_at'], $sql);
                break;
              case 'tasks':
                $sql = "select b.id,d.name as task_name, b.activity,b.created_at,a.name,c.firstname,b.date  from admin.clients a join admin.tasks b on a.id=b.client_id join admin.users c on c.id=b.user_id join admin.task_types d on d.id=b.task_type_id ";
                return $this->ajaxTable('tasks', ['b.activity', 'd.name', 'c.firstname', 'b.created_at','b.date'], $sql);
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

                \App\Models\Task::create($data);
                \App\Models\UsersSchool::create([
                    'user_id' => Auth::user()->id, 'school_id' => request('client_id'), 'role_id' => Auth::user()->role->id, 'status' => 1,
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
                    'ward' => request('ward'),
                    'zone' => request('zone'),
                    'type' => request('type'),
                    'region' => request('region'),
                    'district' => request('district'),
                    'ownership' => request('ownership'),
                    'nmb_zone' => request('zone')
                ];
                DB::table('admin.schools')->insert($array);
                return redirect('sales/school')->with('success',  request('name').' successfully');
        }
        return view('sales.add_school');
    }
    
    
}

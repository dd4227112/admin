<?php

namespace App\Http\Controllers;
use App\Jobs\PushSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Charts\SimpleChart;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class Sales extends Controller {

    /**
     *
     * @var Graph title 
     */
    public $graph_title = '';

    /**
     *
     * @var x axis 
     */
    public $x_axis = '';

    /**
     *
     * @var y axis 
     */
    public $y_axis = '';

    public function __construct() {
        $this->middleware('auth');
        $this->data['insight'] = $this;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        return view('sales.index', $this->data);
    }

    public function faq() {
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
                $task_id = DB::table('tasks')->insertGetId([
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


     public function schools() {   
        $id = request()->segment(3);
        $reg_id = request()->segment(4);

        if($id > 1){
            if(isset($reg_id) && (int) $reg_id > 0){
              $this->data['schools'] = \App\Models\ClientSchool::whereIn('school_id',\App\Models\School::whereIn('ward_id',\App\Models\Ward::whereIn('district_id',\App\Models\District::whereIn('region_id',[$reg_id])->get(['id']))->get(['id']))->get(['id']))->get();
            } else{
              $this->data['schools'] = \App\Models\ClientSchool::whereIn('school_id',\App\Models\School::whereIn('ward_id',\App\Models\Ward::whereIn('district_id',\App\Models\District::whereIn('region_id',\App\Models\Region::get(['id']))->get(['id']))->get(['id']))->get(['id']))->get();
            }
        }
        
        $this->data['use_shulesoft'] = DB::table('admin.all_setting')->count() - 5;
        $this->data['nmb_schools'] = DB::table('admin.nmb_schools')->count();
        $this->data['nmb_shulesoft_schools'] = \collect(DB::select("select count(distinct schema_name) as count from admin.all_bank_accounts where refer_bank_id=22"))->first()->count;
        $this->data['school_types'] = DB::select("select type, count(*) from admin.schools where ownership='Non-Government' group by type,ownership");
        $this->data['ownerships'] = DB::select('select ownership, COUNT(*) as count,SUM(COUNT(*)) over() as total_schools,(COUNT(*) * 1.0) / SUM(COUNT(*)) over() as percent FROM admin.schools group by ownership');
        return view('sales.schools', $this->data);
    }

    function objective() {
        return view('market.objective');
    }

    function schoolStatus() {
        $id = request()->segment(3);
        if ($id == 'shulesoft') {
            $this->data['title'] = "Schools Alreardy Onboarded";
            $user = Auth::user()->id;
            $this->data['branch'] = $branch = \App\Models\PartnerUser::where('user_id', $user)->first();
            if (!empty($branch)) {
                $this->data['all_schools'] = \App\Models\School::whereIn('ward_id', \App\Models\Ward::where('district_id', $branch->branch->district_id)->get(['id']))->whereNotNull('schema_name')->orderBy('schema_name', 'ASC')->get();
            } else {
                $this->data['all_schools'] = \App\Models\School::whereNotNull('schema_name')->orderBy('schema_name', 'ASC')->get();
            }
        }
        if ($id == 'bank') {
             $refer_bank_id=(new \App\Http\Controllers\Users())->getBankId();
            $user = Auth::user()->id;
            $this->data['branch'] = $branch = \App\Models\PartnerUser::where('user_id', $user)->first();
            $this->data['title'] = "Schools With Bank Payment Integration";
            if (!empty($branch)) {
                $this->data['all_schools'] = DB::select('select * from admin.schools WHERE schema_name IN (select distinct schema_name from admin.all_bank_accounts where refer_bank_id='.$refer_bank_id.') and ward_id in (select id from admin.wards where district_id = ' . $branch->branch->district_id . ')');
            } else {
                $this->data['all_schools'] = DB::select('select * from admin.schools WHERE schema_name IN (select distinct schema_name from admin.all_bank_accounts where refer_bank_id='.$refer_bank_id.')');
            }
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
        $sql = "insert into public.sms (body,users_id,type,phone_number) select '{$message}',id,'0',phone from admin.all_users WHERE schema_name::text IN ($list_schema) AND usertype !='Student' {$in_array} AND phone is not NULL";
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
      //   dd(request('type'));

        switch ($page) {
            case 'leads':
                $sql = 'select a.* from admin.leads a join admin.schools b on a.school_id=b.id join admin.users c on c.id=a.user_id join admin.prospects d on d.id=a.prospect_id join admin.tasks e on e.id=a.task_id';
                return $this->ajaxTable('schools', ['b.name'], $sql);
                break;
            case 'schools':
                if ((int) request('type') == 3) {
              //  $sql = "select * from (select a.*, (select count(*) from admin.tasks where school_id=a.id) as activities from admin.schools a where lower(a.ownership) <>'government') a where activities >0";
                $sql = "select C.*,D.username from (select A.*,B.* from (select x.* from(select s.id,s.name,s.ownership,s.type,s.zone,s.nmb_school_name,s.nmb_zone,s.branch_code,s.branch_name,s.account_number,s.schema_name,s.nmb_branch,s.students,s.created_at,s.updated_at,s.ward_id,s.status,s.registered,w.name as ward, d.name as district,r.name as region, count(t.*) as activities from admin.schools as s join admin.tasks as t on s.id=t.school_id join admin.wards as w on s.ward_id=w.id join admin.districts as d on d.id=w.district_id join admin.regions as r on r.id=d.region_id group by s.id, w.id, d.id,r.id) x ) A LEFT JOIN (select school_id,client_id from admin.client_schools) B on A.id = B.school_id) C  left  join (select id,username from admin.clients) D on C.client_id = D.id"; 
                } else if ((int) request('type') == 2) {
                    $sql = "select B.id,B.name,B.ownership,B.type,B.status,B.status,B.students,B.created_at,B.updated_at,B.nmb_branch,B.account_number,B.branch_name,B.branch_code,B.nmb_zone,B.registered,B.zone,B.schema_name,B.activities,B.ward_id,T.region,T.ward,T.district
                    from (select a.*, (select count(*) from admin.tasks where client_id in (select id from admin.clients where username in (select schema_name from admin.all_setting where school_id=a.id)))
                    as activities from admin.schools a   where lower(a.ownership) <>'government' and a.id in (select school_id from admin.all_setting)) B join (select D.name as district,W.id,W.name as ward,R.name as region from admin.districts as D join
                    admin.wards as W on D.id = W.district_id join admin.regions R on R.id = D.region_id ) T on B.ward_id = T.id";
                } else {     
                 $sql = "select a.* from (select s.id,s.registered,s.status,s.created_at,s.students,s.nmb_branch,s.schema_name,s.account_number,s.branch_name,s.branch_code,s.nmb_zone,s.nmb_school_name,s.zone,s.type,s.ownership,s.name,b.name as ward,d.name as district,r.name as region,c.client_id,e.username, (select count(*) from admin.tasks where school_id=s.id) as activities from admin.schools s join admin.wards b on s.ward_id = b.id join admin.districts as d on d.id=b.district_id join admin.regions r on r.id=d.region_id left join admin.client_schools c on c.school_id = s.id left join admin.clients e on e.id=c.client_id) a where lower(a.ownership) <>'government'";
                 }
                return $this->ajaxTable('schools', ['a.name', 'a.region', 'a.district'], $sql);
                break;
            case 'prospects':
                $sql = "select a.id, b.name, a.title||' '||a.name||' <br/> Email: '||a.email||' , phone: '||a.phone_number  as contact_name, c.name as person_in_charge,  b.district||' '||b.ward as location, e.created_at as last_activity, e.date || ' at '||e.time as action_date, e.action||' : '|| e.activity as last_message from admin.prospects a join (select s.id,s.name,w.name as ward,d.name as district,r.name as region from admin.schools s join admin.wards w on s.ward_id = w.id join admin.districts as d on d.id=w.district_id join admin.regions r on r.id=d.region_id where lower(s.ownership) <>'government') b  on a.school_id=b.id join admin.users c on c.id=a.user_id join admin.tasks e on e.id=a.task_id";
                return $this->ajaxTable('schools', ['b.name', 'contact_name', 'person_in_charge', 'location', 'last_activity', 'action_date', 'last_message'], $sql);
                break;
            case 'customers':
                //$sql = 'select * fr';
                return $this->ajaxTable('all_setting', ['sname', 'phone', 'address', 'email', 'payment_integrated', 'created_at']);
                break;
            case 'errors':
                $sql = "SELECT id,error_message,error_instance,created_at::date,schema_name,file, url  from (select * from admin.error_logs where deleted_at is null  AND error_instance NOT IN ('Symfony\Component\HttpKernel\Exception\NotFoundHttpException', 'Illuminate\Session\TokenMismatchException','Illuminate\Auth\AuthenticationException','Symfony\Component\ErrorHandler\Error\FatalError','ErrorException') order by id desc) y where deleted_at is null";
                return $this->ajaxTable('error_logs', ['file', 'error_message', 'route', 'url', 'error_instance', 'created_at::date', 'schema_name'], $sql);
                break;
            case 'errors_resolved':
                $sql = "select a.*,b.name as resolved_by from admin.error_logs a left join admin.users b on b.id=a.deleted_by where a.deleted_at is not null";
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
                $sql = "select a.id,b.name, a.amount, a.method,a.date as created_at,a.transaction_id, d.name as bank_name,'Client Payment' as payment_type from admin.payments a join admin.clients b on b.id=a.client_id left join admin.bank_accounts c on c.id=a.bank_account_id left join constant.refer_banks d on d.id=c.refer_bank_id where extract(year from a.date)=" . date('Y');
//                 "
// union all
// select a.id,a.payer_name as name, a.amount, 'cash' as method, a.date as created_at, a.transaction_id, d.name as bank_name, 'Revenue' as payment_type from admin.revenues a left join admin.bank_accounts c on c.id=a.bank_account_id left join constant.refer_banks d on d.id=c.refer_bank_id ";
                return $this->ajaxTable('payments', ['a.id', 'amount', 'name', 'a.date'], $sql);
                break;
            case 'tasks': 
                $user_id = (int) request('user_id') > 0 ? request('user_id') : Auth::user()->id;
                if(Auth::user()->role_id == '1'){
                    $sql = "select t.id,t.ticket_no,substring(t.activity from 1 for 50) as activity,t.date,t.created_at ,t.updated_at,p.school_name,p.client,u.firstname||' '||u.lastname as user_name, substring(tt.name from 1 for 20) as task_name, t.status,t.priority from admin.tasks t left join (
                    select a.task_id, substring(c.name from 1 for 20) as school_name,'Client' as client from admin.tasks_clients a join admin.clients c on c.id=a.client_id
                    UNION ALL SELECT b.task_id,  substring(s.name from 1 for 20) as school_name, 'Not Client' as client from admin.tasks_schools b join admin.schools s on s.id=b.school_id ) p on p.task_id=t.id join admin.users u on u.id=t.user_id LEFT join admin.task_types tt on tt.id=t.task_type_id where  
                    t.id in (select task_id from admin.tasks_users)";
                }
                $sql = "select t.id,t.ticket_no,substring(t.activity from 1 for 50) as activity,t.date, t.created_at,t.updated_at,p.school_name,p.client,u.firstname||' '||u.lastname as user_name, substring(tt.name from 1 for 20) as task_name, t.status,t.priority from admin.tasks t left join (
                    select a.task_id, substring(c.name from 1 for 20) as school_name,'Client' as client from admin.tasks_clients a join admin.clients c on c.id=a.client_id
                    UNION ALL SELECT b.task_id,  substring(s.name from 1 for 20) as school_name, 'Not Client' as client from admin.tasks_schools b join admin.schools s on s.id=b.school_id ) p on p.task_id=t.id join admin.users u on u.id=t.user_id LEFT join admin.task_types tt on tt.id=t.task_type_id where u.id=" . $user_id . " 
                    OR t.id in (select task_id from admin.tasks_users where user_id=" . $user_id . ")";
                return $this->ajaxTable('tasks', ['activity', 'u.firstname', 'p.school_name', 't.created_at','t.updated_at', 't.date', 'u.lastname'], $sql);
                break;
            case 'school_status':
                if ((int) request('type') == 3) {
                    $sql = "select * from (select a.*, (select count(*) from admin.tasks where school_id=a.id) as activities from admin.schools a   where lower(a.ownership) <>'government') a where activities >0";
                } else if ((int) request('type') == 2) {
                    $sql = "select a.*, (select count(*) from admin.tasks where client_id in (select id from admin.clients where username in (select schema_name from admin.all_setting where school_id=a.id))) as activities from admin.schools a   where lower(a.ownership) <>'government' and a.id in (select school_id from admin.all_setting)";
                } else {
                    $sql = "select a.*, (select count(*) from admin.tasks where school_id=a.id) as activities from admin.schools a   where lower(a.ownership) <>'government'";
                }
                return $this->ajaxTable('schools', ['a.name', 'a.region', 'a.ward', 'a.district'], $sql);
                break;

            case 'list_of_schools':
                if ((int) request('type') == 3) {
                    $sql = "SELECT *  from admin.schools a where a.schema_name NOT IN  (select schema_name from admin.all_setting) AND  lower(a.ownership) <>'government'";
                } else if ((int) request('type') == 2) {
                    $sql = "SELECT *  from admin.schools a where a.schema_name in  (select schema_name from admin.all_setting) AND  lower(a.ownership) <>'government'";
                } else {
                    $sql = "SELECT * from admin.schools a  where lower(a.ownership) <>'government'";
                }
                return $this->ajaxTable('schools', ['a.name', 'a.region', 'a.ward', 'a.district'], $sql);
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
        $id = (int) request()->segment(3);

        if ((int) $id == 0 || !is_int($id)) {  
            return false;
        }

        $this->data['school'] = \App\Models\School::findOrFail($id);
        if ($_POST) {
            if ((int) request('add_sale') == 1) {
                \App\Models\School::findOrFail(request('client_id'))->update(request()->all());
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
                $school_id = request('client_id');
                $data = array_merge(request()->all(), ['user_id' => \Auth::user()->id, 'school_id' => request('client_id')]);
                 DB::transaction(function () use($data,$school_id) {
                    $task = \App\Models\Task::create($data);
                    \App\Models\UsersSchool::create([
                        'user_id' => Auth::user()->id, 'school_id' => (int) $school_id, 'role_id' => \Auth::user()->role_id, 'status' => 1,
                    ]);
                    DB::table('tasks_schools')->insert([
                        'task_id' => $task->id,
                        'school_id' => (int) $school_id
                    ]);
                    return redirect()->back()->with('success', 'Report added successfully');
               });
            }
        }
        return view('sales.profile', $this->data);
    }

    public function updateStudent() {
        $id = request('school_id');
        \App\Models\School::findOrFail($id)->update(['students' => request('no')]);
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
            if (!empty($contact)) {
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
            return redirect('sales/schools')->with('success', request('name') . ' successfully');
        }
        return view('sales.add_school',$this->data);
    }

    public function onboard() {
        $school_id = (int) request()->segment(3);
        //Redirects Partners to Onboarding Views
        if(Auth::user()->department == 9 || Auth::user()->department == 10){
            return redirect('Partner/add/'.$school_id);
        }

        $this->data['school'] = $school  =  \App\Models\School::findOrFail($school_id);
        $username = clean(preg_replace('/[^a-z]/', null, strtolower($school->name)));

        $user_object = new \App\Http\Controllers\Users();
        $this->data['staffs'] =  $user_object->shulesoftUsers();
        if ($_POST) {
             $file = request()->file('file');
            if(filesize($file) > 2015110 ) {
                  return redirect()->back()->with('error', 'File must have less than 2MBs');
             }
             
             $this->validate(request(), 
                   ['school_name' => 'required',
                    'sales_user_id' => 'required',
                    'price' => 'required',
                    'students' => 'required|numeric',
                    'username' => 'required'
                ]);

            $code = rand(343, 32323) . time();
            $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
            if (empty($school_contact)) {
                DB::table('admin.school_contacts')->insert([
                    'name' => request('school_name'), 'email' => request('email'), 'phone' => request('phone'), 'school_id' => $school_id, 'user_id' => \Auth::user()->id, 'title' => request('title')
                ]);
                $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
            }

             $schema_name = str_replace(' ','', request('username'));
             DB::table('admin.schools')->where('id', $school_id)->update(['name'=> request('school_name'),'students' => request('students'),'schema_name' => $schema_name]);
             $check_client = DB::table('admin.clients')->where('username', $schema_name)->first();

             $client_data = [
                    'name' => empty(request('school_name')) ? $school->name : request('school_name'),
                    'address' => $school->wards->name . ' ' . $school->wards->district->name . ' ' . $school->wards->district->region->name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'phone' => !empty($school_contact->phone) ? $school_contact->phone : request('owner_phone'),
                    'email' => !empty($school_contact->email) ? $school_contact->email : request('owner_email'),
                    'estimated_students' => request('students'),
                    'status' => 1, // Unapproved application
                    'code' => $code,
                    'region_id' => $school->wards->district->region->id,
                    'email_verified' => 0,
                    'phone_verified' => 0,
                    'created_by' => \Auth::user()->id,
                    'username' => clean($schema_name),
                    'payment_option' => request('payment_option'),
                    'start_usage_date' => date('Y-m-d'),
                    'trial' => request('check_trial'),
                    'owner_email' => request('owner_email'),
                    'owner_phone' => request('owner_phone'),  
                    'price_per_student' => request('price'),
                    'note' => nl2br(request('description'))
             ];  
           
            if(!empty($check_client)) {
                $client_id = $check_client->id;
                 \DB::table('admin.clients')->where('id',$client_id)->update(Arr::except($client_data, ['username'])); 
            } else { 
                $client_id = \DB::table('admin.clients')->insertGetId($client_data); 
                // trial period
                // if(request('check_trial') == 1 && !is_null(request('trial_period')) ) {
                //       $start = date('Y-m-d', strtotime(request('implementation_date')));
                //       $period  = request('trial_period');
                //     DB::table('admin.client_trials')->insert([
                //         'client_id' => $client_id,
                //         'period' => $period,
                //         'start_date' => $start,
                //         'end_date' => date('Y-m-d', strtotime($start. " + $period days")),
                //         'status' =>  1
                //      ]); 
                // }

                //client school
                DB::table('admin.client_schools')->insert([
                    'school_id' => $school_id, 'client_id' => $client_id
                ]);
                //client projects
                DB::table('admin.client_projects')->insert([
                    'project_id' => 1, 'client_id' => $client_id //default ShuleSoft project
                ]);
                //sales person
                DB::table('admin.users_schools')->insert([
                    'school_id' => $school_id, 'client_id' => $client_id, 'user_id' =>Auth::user()->id, 'role_id' => 8, 'status' => 1
                ]);
                //post task, onboarded
                $data = ['user_id' => Auth::user()->id, 'school_id' => $school_id, 'activity' => 'Onboarding', 'task_type_id' => request('task_type_id'), 'user_id' => \Auth::user()->id];
                $task = \App\Models\Task::create($data);
                DB::table('tasks_schools')->insert([
                    'task_id' => $task->id,
                    'school_id' => $school_id
                ]);
            }
  
            if (!empty(request('file'))) {
                $file = request()->file('file');
                $company_file_id = $file ? $this->saveFile($file,TRUE) : 1;
                $contract_id = DB::table('admin.contracts')->insertGetId([
                'name' => 'Shulesoft service fee', 'company_file_id' => $company_file_id, 'start_date' => request('start_date'), 'end_date' => request('end_date'), 'contract_type_id' => request('contract_type_id'), 'user_id' => \Auth::user()->id
                ]);
                //client contracts
                DB::table('admin.client_contracts')->insert([
                    'contract_id' => $contract_id, 'client_id' => $client_id
                ]);
              }
 
                // if document is standing order,Upload standing order files
             if (!empty(request('standing_order_file')) && preg_match('/Standing Order/i', request('payment_option')) ) {
                $file = request()->file('standing_order_file');
                $company_file_id = $file ? $this->saveFile($file, TRUE) : 1;
                $total_amount = empty(request('total_amount')) ? request('occurance_amount') * request('number_of_occurrence') : request('total_amount');

                $contract_id = DB::table('admin.standing_orders')->insertGetId(array(
                    'type' => request('which_basis'),'created_by' => \Auth::user()->id, 
                    'client_id' => $client_id,'contract_type_id' => 8,
                    'is_approved' => '0','company_file_id' => $company_file_id,
                    'payment_date' => request('maturity_date'), 'occurance_amount' => remove_comma(request('occurance_amount')),
                    'contact_person' => request('contact_person'), 'branch_name' => request('branch_name'),
                    'occurrence' => request('number_of_occurrence'), 'total_amount' => remove_comma($total_amount), 
                ));
                //client contracts
                DB::table('admin.client_contracts')->insert([
                    'contract_id' => $contract_id, 'client_id' => $client_id
                ]);
              } 

            //once a school has been installed, now create an invoice for this school or create a promo code
         
                $client = \App\Models\Client::findOrFail($client_id);
                $year = \App\Models\AccountYear::where('name', date('Y'))->first();
                $reference = time(); // to be changed for selcom ID

                $invoice = \App\Models\Invoice::create(['reference' => $reference, 'client_id' => $client_id, 'date' => date('d M Y'), 'due_date' => date('d M Y', strtotime(' +30 day')), 'year' => date('Y'), 'user_id' => Auth::user()->id, 'account_year_id' => $year->id]);

                 $unit_price = remove_comma(request('price'));
                 $estimated_students = remove_comma(request('students'));
                 $amount = $unit_price * $estimated_students;
                \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $amount, 'project_id' => 1, 'item_name' => 'ShuleSoft Service Fee', 'quantity' => $estimated_students, 'unit_price' => $unit_price]);

           
                $trial_code = $client_id . time();
                $client = DB::table('admin.clients')->where('id', $client_id); 
                DB::table('admin.clients')->where('id', $client_id)->update(['code' => $trial_code]);
                $user = $client->first();

                $user = \App\Models\User::find(request('sales_user_id'));
    
                $message = 'Hello '.$user->firstname .' '. $user->lastname 
                . chr(10) .'School :' . $school->name . ' has been onboarded succesfully'
                . chr(10) .'Thank you.';
                $this->send_whatsapp_sms($user->phone, $message); 
                $this->send_sms($user->phone, $message, 1);
                
                $finance = \App\Models\User::where('designation_id',2)->where('status',1)->first();
                $sms = 'Hello '.$finance->firstname .' '. $finance->lastname 
                . chr(10) .'New school :' . $school->name . ' has been onboarded in the shulesoft system'
                . chr(10) .'You are remainded to verify the invoice document'
                . chr(10) .'Thank you.';
                $this->send_whatsapp_sms($finance->phone, $sms); 
                $this->send_sms($finance->phone, $sms, 1);

                return redirect('sales/onboaredSchools');
           }
    
        return view('sales.add_new', $this->data);
    }
 
    
     public function onboaredSchools(){
        $this->data['clients'] = \DB::select("SELECT c.id,c.name,c.email,c.phone,c.address,c.code,c.status,COUNT(a.id) as tasks,s.id as sid,s.company_file_id FROM admin.clients c JOIN admin.standing_orders s on c.id = s.client_id LEFT JOIN admin.train_items_allocations a on a.client_id = c.id   where c.status <> 3 GROUP BY s.id,c.id,c.name,c.email,c.phone,c.address,c.code,c.status HAVING count(a.id) <= 0
         ORDER BY c.created_at DESC");
        return view('sales.onboard', $this->data);
     }



     public function updateOnboardStatus(){
        $client_id = request()->segment(3);
        \App\Models\Client::where('id', (int)$client_id)->update(['status'=> 3]);

        $user = \App\Models\User::find(761);  //Head of product Mr Paul --default 
        $client = \App\Models\Client::find($client_id);  

        $message = 'Dear '.$user->firstname .' '. $user->lastname 
                . chr(10) .'School of ' . $client->name . ' has been approved by finance officer for implementation'
                . chr(10) .'Kindly proceeds with implementation plan'
                . chr(10) .'Link  https://admin.shulesoft.com/sales/implemetation/'.$client_id
                . chr(10) .'Thank you.';
         $this->send_whatsapp_sms($user->phone, $message); 
         $this->send_sms($user->phone,$message,1);

         return redirect()->back()->with('success','School Approved for onboarding');
     }





    public function scheduleActivities($client_id,$trial_code) {
        // if((int)$client_id == 0){
        //     $client_id = request()->segment(3);
        // }  
        $time = 0;
        if((int)$client_id > 0){ 
            \App\Models\Client::where('id', (int) $client_id)->update(['data_type_id'=>request('data_type_id')]);
            $sections = \App\Models\TrainItem::where('status',1)->orderBy('id', 'asc')->get();
            $start_date = date('Y-m-d H:i');

        foreach ($sections as $section) {
            $start_date = date('Y-m-d H:i', strtotime("+{$time} minutes", strtotime(request('implementation_date'))));
            //check if start_date is greater than 17 hours
            if (((int) date('H', strtotime($start_date))) >= 16 && (int) $section->time >= 30) {
                // we cannot add a task here, so switch this tomorrow
                $add_time = (int) $time + 16 * 60;
                $start_date = date('Y-m-d H:i', strtotime("+{$add_time} minutes", strtotime(request('implementation_date'))));
            }
            if (date('D', strtotime($start_date)) == 'Sat') {
                //its saturday, so add 48 hours
                $sat_add_time = (int) $time + 48 * 60;
                $start_date = date('Y-m-d H:i', strtotime("+{$sat_add_time} minutes", strtotime(request('implementation_date'))));
            }

            if (date('l', strtotime($start_date)) == 'Sunday') {
                // its sunday, so add 24 hours
                $sun_add_time = (int) $time + 24 * 60;
                $start_date = date('Y-m-d H:i', strtotime("+{$sun_add_time} minutes", strtotime(request('implementation_date'))));
            }
            //later we will check if user attend, holiday etc

            $end_date = date('Y-m-d H:i', strtotime("+{$section->time} minutes", strtotime($start_date)));
       
            $slot = \App\Models\Slot::find(request('slot_id' . $section->id));
            
            if(empty($slot)){
                $slot = \App\Models\Slot::first();
            }
            $date = date('Y-m-d', strtotime(request('slot_date' . $section->id)));

            /// who will attend the task
            $support_user_id= $this->getSupportUser($section->id);

            if(request("train_item{$section->id}") != ''){
                $data = [
                    'activity' => $section->content,
                    'date' => date('Y-m-d', strtotime($start_date)),             
                    'user_id' => $support_user_id,
                    'task_type_id' => preg_match('/data/i', $section->content) ? 3 : 4,
                    'start_date' => date('Y-m-d H:i', strtotime($start_date)),
                    'end_date' => date('Y-m-d H:i', strtotime($start_date." + {$section->time} days")),
                    'slot_id' => (int) $slot->id > 0 ? $slot->id : 5
                ]; 
                $time += $section->time;
                $task = \App\Models\Task::create($data);
            
                DB::table('tasks_users')->insert([
                    'task_id' => $task->id,
                    'user_id' => $support_user_id,
                ]);

               DB::table('tasks_clients')->insert(['task_id' => $task->id,'client_id' => (int) $client_id]);
                  \App\Models\TrainItemAllocation::create([
                    'task_id' => $task->id,
                    'client_id' => $client_id,
                    'user_id' => $support_user_id,
                    'train_item_id' => $section->id,
                    'school_person_allocated' => request("train_item{$section->id}"),
                    'max_time' => $section->time
              ]);
            }
        
            // email to shulesoft personel
            $user = \App\Models\User::where('id',$support_user_id)->first();
            $start_date = date('d-m-Y', strtotime($start_date)) == '01-01-1970' ? date('Y-m-d') : date('d-m-Y', strtotime($start_date));
            $message = 'Hello ' . $user->firstname . ' ' . $user->lastname . '<br/>'
                        . 'A task ' . $section->content .' has been allocated to you'
                        . '<ul>'
                        . '<li>From : ' . \App\Models\Client::where('id',$client_id)->first()->name . '</li>'
                        . '<li>Start date: ' . date('Y-m-d H:i:s', strtotime($start_date)) . '</li>'
                        . '<li>Deadline: ' . date('Y-m-d H:i:s', strtotime($start_date . " + {$section->time} days")) . '</li>'
                        . '</ul>';
            $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);
           
                //  message to assign messages
                $sms  = 'Hello ' .$user->firstname .' ' . $user->lastname
                . chr(10) . 'A task of : ' . $section->content . ' at ' . \App\Models\Client::where('id',$client_id)->first()->name .' has been allocated to you'
                . chr(10) . 'A task is expected to start at ' .date('d-m-Y', strtotime($start_date)).' and end '. date('d-m-Y', strtotime($start_date . " + {$section->time} days"))
                . chr(10) . 'By :'. \Auth::user()->name
                . chr(10) . 'Thank you';
             $this->send_whatsapp_sms($user->phone, $sms);
             $this->send_sms($user->phone,$sms,1);

            //email to zonal manager
             $sales = new \App\Http\Controllers\Customer();
             $zm = $sales->zonemanager($client_id);
             if(isset($zm->user_id) && !empty((int) $zm->user_id)){
                 $manager = \App\Models\User::where(['id' => $zm->user_id,'status'=>1])->first();

                if(!empty($manager)) {
                    $manager_message = 'Hello ' . $manager->firstname . '<br/>'
                    . 'A task ' . $section->content .' been scheduled to'
                    . '<li>' . \App\Models\Client::where('id',$client_id)->first()->name  . '</li>'
                    . '<li>Start date: ' . date('Y-m-d H:i:s', strtotime($start_date)) . '</li>'
                    . '<li>Deadline: ' . date('Y-m-d H:i:s', strtotime($start_date . " + {$section->time} days")) . '</li>'
                    . '</ul>';
                    $this->send_email($manager->email,'Task Allocation', $manager_message);
                 
                    $message  = 'Hello ' .$manager->firstname .' ' . $manager->lastname
                    . chr(10) . 'A task of : ' . $section->content . ' been scheduled to ' . \App\Models\Client::where('id',$client_id)->first()->name .' has been allocated to you'
                    . chr(10) . 'A task is expected to start at ' .date('d-m-Y', strtotime($start_date)).' up to '. date('d-m-Y', strtotime($start_date . " + {$section->time} days"))
                    . chr(10) . 'Thank you';
                    $this->send_whatsapp_sms($manager->phone, $message);
                    $this->send_sms($manager->phone,$message,1);
                  }
               }
            //sms to school personel
              if(request("train_item{$section->id}") != ''){
                    $phonenumber = $this->extractPhoneNumber(request("train_item{$section->id}"));
                    $phonenumber = validate_phone_number($phonenumber[0],255);
                    $sms  = 'Hello '
                    . chr(10) . 'A task of : ' . $section->content . ' has been allocated to your school'
                    . chr(10) . 'A task is expected to start at ' .date('F,d Y', strtotime($start_date)).' up to '. date('F,d Y', strtotime($start_date . " + {$section->time} days"))
                    . chr(10) . 'Thank you';
                    $this->send_whatsapp_sms($phonenumber, $sms);
                    $this->send_sms($phonenumber,$sms,1);
              }
          } 
        }
        
        $this->data['trial_code'] = $trial_code;
        $this->data['client'] = \App\Models\Client::where('id', (int) $client_id)->first();
        $this->customerSuccess($trial_code,$this->data['client']);
    }


      private function customerSuccess($code,$client) {
        $client = (object) $client;
        $this->data['trial_code'] = $code;
        $this->data['client'] = \App\Models\Client::where('id', (int)$client->id)->first();
        if (!empty($this->data['client'])) {
           return view('sales.customer_success', $this->data);
        } else {
            die('Invalid URL');
        }

    }


    public function extractPhoneNumber($text){
         $matches = array();
         preg_match_all('/[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}|[0-9]{9}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}/', $text, $matches);
         $matches = $matches[0];
         return $matches;
    }

    public function getSupportUser($section_id) {
        //  $user=DB::table('admin.user_train_items')->where('train_item_id',$section_id)->where('status',1)->first();
           $collection = DB::table('admin.user_train_items')->join('admin.users','admin.users.id','=','admin.user_train_items.user_id')->join('admin.train_items','admin.train_items.id','=','admin.user_train_items.train_item_id')
                         ->select('admin.users.id','admin.users.name','admin.train_items.content','admin.user_train_items.train_item_id')
                         ->where('admin.users.status','=','1')->where('admin.user_train_items.train_item_id','=',$section_id)->distinct()->get();
                    $ids = array();
                        foreach($collection as $value) {
                        $ids[] = $value->id;
                     }
            $users = DB::table('admin.train_items_allocations')->select('user_id', DB::raw('count(status) as complete'))->whereIn('user_id',$ids)->where('status',1)->groupBy('user_id')->get();
            if(!empty($users)){
                  $data = [];
                  foreach($users as $value){
                   $data[$value->user_id] = $value->complete;
               }
              $user_id = !empty($data) ? array_search(max($data), $data) : DB::table('admin.user_train_items')->where('train_item_id',$section_id)->where('status',1)->first()->user_id;
            } 
            return $user_id;
       }
    //algorithm is very very simple
    /**
     * 1. check that user if he has a task at that particular time
     * 2. if user has a time, return an error to adjust
     * 3. if user does have a time, then fix that initial time there
     * 4. check the specific task has been allocated how many minutes to be accomplished
     * 5. add that minutes to the time specified and fix end datetime
     * 6. if you findOrFail occupied time slot in between, add that time slot in between to extend time for end datetime
     * 7. return both, start datetime and end datetime respectively
     */
    public function taskStartTime($start_date, $timeframe, $iterate = false) {
        $end_time = date('d-m-Y H:i', strtotime("+{$timeframe} minutes", time()));
        $start_time = date('d-m-Y H:i', strtotime($start_date));
        $slot_available = \collect(DB::select("SELECT * FROM   admin.tasks WHERE  start_date::timestamp <='" . $start_time . "'::timestamp and end_date::timestamp >='" . $end_time . "'::timestamp"))->first();
        if (!empty($slot_available)) {
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


    public function implemetation(){
          $this->data['client_id'] = $client_id = request()->segment(3);
          $this->data['client'] = \App\Models\Client::where('id', (int) $client_id)->first();
          $this->data['trial_code'] = $trial_code = $client_id . time();
          if($_POST){
               $this->scheduleActivities($client_id,$trial_code); 
              // $this->customerSuccess($client_id,$this->data['trial_code']); 
           }
         return view('sales.onboarding_school', $this->data);
    }

    public function curlPrivate($fields, $url = null) {
        // Open connection
        $url = 'http://75.119.140.177:8081/api/payment';
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

    public function salesStatus() {
        $page = request()->segment(3);
        if ((int) $page == 1 || $page == 'null' || (int) $page == 0) {
            //current day
            $this->data['today'] = 1;
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
            $where = '  a.created_at::date=CURRENT_DATE';
        } else {
            $this->data['today'] = 2;
            $start_date = date('Y-m-d', strtotime(request('start')));
            $end_date = date('Y-m-d', strtotime(request('end')));
            $where = "  a.created_at::date >='" . $start_date . "' AND a.created_at::date <='" . $end_date . "'";
        }
         $user_id = \Auth::User()->id;
      //   $this->data['schools'] = DB::select("select * from admin.tasks where user_id = $user_id  and  (start_date, end_date) OVERLAPS ('$start_date'::date, '$end_date'::date)");
        $this->data['schools'] = \App\Models\Task::where('user_id', Auth::user()->id)->whereRaw("(created_at >= ? AND created_at <= ?)", [$start_date . " 00:00:00", $end_date . " 23:59:59"])->orderBy('created_at', 'desc')->get();
        $this->data['new_schools'] = \App\Models\Task::where('user_id', Auth::user()->id)->where('next_action', 'new')->whereRaw("(created_at >= ? AND created_at <= ?)", [$start_date . " 00:00:00", $end_date . " 23:59:59"])->orderBy('created_at', 'desc')->get();
        $this->data['pipelines'] = \App\Models\Task::where('user_id', Auth::user()->id)->where('next_action', 'pipeline')->whereRaw("(created_at >= ? AND created_at <= ?)", [$start_date . " 00:00:00", $end_date . " 23:59:59"])->orderBy('created_at', 'desc')->get();
        $this->data['closeds'] = \App\Models\Task::where('user_id', Auth::user()->id)->where('next_action', 'closed')->whereRaw("(created_at >= ? AND created_at <= ?)", [$start_date . " 00:00:00", $end_date . " 23:59:59"])->orderBy('created_at', 'desc')->get();
        $this->data['query'] = 'SELECT count(next_action), next_action from admin.tasks a where  a.user_id='.Auth::User()->id.' and ' . $where . ' group by next_action order by count(next_action) desc';
        $this->data['types'] = 'SELECT count(b.name), b.name as type from admin.tasks a, admin.task_types b  where a.task_type_id=b.id AND a.user_id ='.Auth::User()->id.' and ' . $where . ' group by b.name order by count(b.name) desc';
        return view('sales.sales_status.index', $this->data);
    }

    public function addLead() {
        if ($_POST) {
             $task_data = ['school_id'=>request('school_id'),'school_name'=>request('school_name'),'school_phone'=>request('school_phone'),'school_title'=>request('school_title'),
                      'students'=>request('students'),'start_date'=>date('Y-m-d', strtotime(request('start_date'))),'end_date'=>date('Y-m-d', strtotime(request('end_date'))),
                      'task_type_id'=>request('task_type_id'),'next_action'=>request('next_action'),'budget'=>request('budget'),
                      'activity'=>request('activity')];
            $data = array_merge($task_data, ['user_id' => Auth::user()->id, 'status' => 'new', 'date' => date('Y-m-d')]);

            $task = \App\Models\Task::create($data);

            DB::table('tasks_users')->insert([
                'task_id' => $task->id,
                'user_id' => Auth::user()->id
            ]);

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

            if (request('school_name') != '' && request('school_phone') != '') {
                \App\Models\SchoolContact::create([
                    'name' => request('school_name'),
                    'phone' => request('school_phone'),
                    'school_id' => (int) $school_id,
                    'user_id' => Auth::user()->id,
                    'title' => request('school_title')
                ]);
                DB::table('admin.schools')->where('id', (int) $school_id)->update(['students' => request('students')]);
            }

            return redirect('Sales/salesStatus/1')->with('success', 'success');
        }
        return view('sales.sales_status.add', $this->data);
    }

    private function createGraph($data, $firstpart, $table, $chart_type, $custom = false, $call_back_sql = false) {
        $k = [];
        $l = [];
        foreach ($data as $value) {
            array_push($k, $value->{$firstpart});
            array_push($l, (int) $value->count);
        }
        $chart = new SimpleChart;
        $chart->labels($k);
        $chart->dataset($this->x_axis == '' ? $table : $this->x_axis, $chart_type, $l);

        if ($call_back_sql != false) {
            foreach ($call_back_sql as $key => $sql) {
                $call = $this->createCallBack(DB::select($sql), $firstpart);
                $chart->labels($call[0]);
                $chart->dataset($key, $chart_type, $call[1]);
            }
        }
        $title = $this->graph_title == '' ?
                ucwords('Relationship Between ' . $table . ' and ' . str_replace('_', ' ', $firstpart)) : $this->graph_title;
        $chart->title($title);
        $this->data['chart'] = $chart;
        return $custom == true ? $this->createCustomChart($data, $chart_type, $firstpart) : view('analyse.charts.chart', $this->data);
    }

    private function createCustomChart($data, $chart_type, $base_column) {
        $insight = $this;
        return view('insight.highcharts', compact('data', 'chart_type', 'base_column', 'insight'));
    }

    public function createChartBySql($sql, $firstpart, $table, $chart_type, $custom = false, $call_back_sql = false) {
        $data = DB::select($sql);
        return $this->createGraph($data, $firstpart, $table, $chart_type, $custom, $call_back_sql);
    }

    public function schoolVisit() {
        $page = request()->segment(3);
        if ((int) $page == 1 || $page == 'null' || (int) $page == 0) {
            //current day
            $this->data['today'] = 1;
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
            $where = '  a.created_at::date=CURRENT_DATE';
        } else {
            $this->data['today'] = 2;
            $start_date = date('Y-m-d', strtotime(request('start')));
            $end_date = date('Y-m-d', strtotime(request('end')));
            $where = "  a.created_at::date >='" . $start_date . "' AND a.created_at::date <='" . $end_date . "'";
        }
        $ids = [];

        if (request('user_ids') != '') {
            foreach (request('user_ids') as $ids) {
                array_push($ids, $ids);
            }
        } else {
            array_push($ids, Auth::user()->id);
        }

        $task_ids = [];
        $id = Auth::user()->id;
        //    $tasks = \App\Models\Task::where('user_id', $id)->where('action', 'visit')->whereRaw("(created_at >= ? AND created_at <= ?)", [$start_date . " 00:00:00", $end_date . " 23:59:59"])->orderBy('created_at', 'desc')->get();
        $tasks = \App\Models\Task::where('user_id', $id)->where('action', 'visit')->orderBy('created_at', 'desc')->get();
        foreach ($tasks as $value) {
            array_push($task_ids, (int) $value->id);
        }
        if(Auth::user()->role_id==1){
            $this->data['schools'] = \App\Models\TaskClient::whereIn('task_id', \App\Models\Task::where('action', 'visit')->get(['id']))->get();
            //$this->data['new_schools'] = \App\Models\Task::whereIn('user_id', $id)->where('next_action', 'new')->whereRaw("(created_at >= ? AND created_at <= ?)", [$start_date . " 00:00:00", $end_date . " 23:59:59"])->orderBy('created_at', 'desc')->get();
    
            $this->data['query'] = 'SELECT count(a.status), a.status from admin.tasks_clients a where task_id in(select id from admin.tasks where  action=\'visit\') group by a.status order by count(a.status) desc';

            $this->data['types'] = 'SELECT count(a.updated_at::date), a.updated_at::date as "Date" from admin.tasks_clients a where task_id in(select id from admin.tasks where  action=\'visit\') and a.status is not null group by a.updated_at::date order by count(a.updated_at::date) desc';
            return view('sales.sales_status.visitation_index', $this->data);
        }else{
        $this->data['schools'] = \App\Models\TaskClient::whereIn('task_id', $task_ids)->get();
        
        //$this->data['new_schools'] = \App\Models\Task::whereIn('user_id', $id)->where('next_action', 'new')->whereRaw("(created_at >= ? AND created_at <= ?)", [$start_date . " 00:00:00", $end_date . " 23:59:59"])->orderBy('created_at', 'desc')->get();

        $this->data['query'] = 'SELECT count(a.status), a.status from admin.tasks_clients a where task_id in(select id from admin.tasks where user_id in(' . $id . ')  and action=\'visit\') group by a.status order by count(a.status) desc';
        $this->data['types'] = 'SELECT count(a.updated_at::date), a.updated_at::date as "Date" from admin.tasks_clients a where task_id in(select id from admin.tasks where user_id in(' . $id . ')   and action=\'visit\') and a.status is not null group by a.updated_at::date order by count(a.updated_at::date) desc';
        return view('sales.sales_status.visitation_index', $this->data);
    }
}

    public function addvisit() {
        $schools = DB::table('all_setting')->orderBy('created_at', 'DESC')->get();
        $all_school = [];
        foreach ($schools as $school) {
            array_push($all_school, $school->schema_name);
        }
        $this->data['schools'] = \App\Models\Client::whereIn('username', $all_school)->get();

        if ($_POST) {
            $data = array_merge(request()->except(['_token','start_date','end_date']), ['start_date' => date("Y-m-d H:i:s", strtotime(request('start_date'))), 'end_date' => date("Y-m-d H:i:s", strtotime(request('end_date'))), 'user_id' => Auth::user()->id, 'status' => 'new', 'action' => 'visit', 'date' => date('Y-m-d')]);
            $task = \App\Models\Task::create($data);
            DB::table('tasks_users')->insert([
                'task_id' => $task->id,
                'user_id' => Auth::user()->id
            ]);

            $clients = request('school_id');
            foreach ($clients as $client_id) {
                DB::table('tasks_clients')->insert([
                    'task_id' => $task->id,
                    'status' => 'new',
                    'client_id' => (int) $client_id
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
            return redirect('Sales/schoolVisit/1')->with('success', 'success');
        }

        return view('sales.sales_status.add_visit', $this->data);
    }

    public function analysis() {
        $table = DB::select("select count(*)*400*10000 as total, lower(region) as region from admin.schools where lower(ownership) <>'government' group by lower(region) order by total desc ");
        $title = array('region', 'total');
        $this->data['records'] = $this->createTable($table, $title);
        return view('sales.report', $this->data);
    }

    function createTable($data, $titles) {
        return view('layouts.table', compact('data', 'titles'));
    }

    public function viewVisit() {
        $id = request()->segment(3);

        $this->data['activity'] = $task = \App\Models\TaskClient::where('id', $id)->first();
        if ($_POST) {
            if (!empty(request('staff_id'))) {
                foreach (request('staff_id') as $staff) {
                    $user_id = explode(',', $staff);
                    $check = \App\Models\TaskStaff::where('task_id', $task->task_id)->where('user_id', $user_id[0])->where('user_table', $user_id[1])->first();
                    if (empty($check)) {
                        \App\Models\TaskStaff::create([
                            'task_id' => $task->task_id,
                            'start_time' => request('start_time'),
                            'end_time' => request('end_time'),
                            'module' => request('module'),
                            'user_id' => $user_id[0],
                            'user_table' => $user_id[1],
                        ]);
                    } else {
                        \App\Models\TaskStaff::where('task_id', $task->task_id)->where('user_id', $user_id[0])->where('user_table', $user_id[1])
                                ->update([
                                    'start_time' => request('start_time'),
                                    'end_time' => request('end_time')
                        ]);
                    }
                }
            }
        }
        $this->data['school'] = \App\Models\School::where('schema_name', $task->client->username)->first();
        $this->data['users'] = DB::SELECT('SELECT count(a."table"), a."table" from ' . $task->client->username . '.users a where status=1 and "table" !=\'setting\'  group by a."table" order by count(a."table") desc');
        return view('sales.sales_status.view_task', $this->data);
    }

    public function updateTask() {
        $id = request('id');
        $action = request('action');
        \App\Models\TaskClient::where('id', $id)->update(['status' => $action, 'updated_at' => date('Y-m-d H:i:s')]);
        echo '<small style="color: red">Success</small>';
    }

    public function updateVisit() {
        $id = request('task_id');
        \App\Models\Task::where('id', $id)->update(['status' => request('status'), 'start_date' => request('start_time'), 'end_date' => request('end_time'), 'task_type_id' => request('task_type_id'), 'updated_at' => date('Y-m-d H:i:s')]);
        return redirect()->back()->with('success', 'School record updated successfully');
    }


    public function hrReport(){
        $this->data['schools'] = [];
        $this->data['name'] = '';
        $this->data['month_num'] = null;
        if($_POST){
            $this->data['user_id'] = $user_id = request('user_id');
            $this->data['month_num'] = $month_num = request('month');
            $this->data['name'] = \App\Models\User::where('id',$user_id)->first()->name; 
            $this->data['schools'] = $schools = DB::table('users_schools')
                   ->join('schools','users_schools.school_id', '=', 'schools.id')
                   ->select('schools.id','schools.name')->where('users_schools.user_id',$user_id)->get();
        }
        return view('sales.report.index',$this->data);
    }


    public function jobcards(){
        $this->data['jobcards'] = DB::table('client_job_cards')
                               ->join('clients','clients.id', '=', 'client_job_cards.client_id')
                               ->join('users','users.id', '=', 'client_job_cards.created_by')
                               ->select('users.name','client_job_cards.*','clients.name as clientname')
                               ->whereNotNull('client_job_cards.date')->orderBy('client_job_cards.date','desc')->get();
        return view('sales.jobcards',$this->data);
    }


 



     
      

 

}

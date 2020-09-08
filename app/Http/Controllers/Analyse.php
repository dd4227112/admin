<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Charts\SimpleChart;
use Illuminate\Support\Facades\Auth;

class Analyse extends Controller {


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        $this->data['insight'] = $this;
    }

    public function logRequest() {
        $sql = "select count(*),created_at::date from admin.all_log where created_at::date <= '2018-02-03' and created_at::date>= '2018-01-03' group by created_at::date order by created_at desc";
    }

    public function index() {
        $this->data['users'] = [];

//         $this->data['active_schools']=\collect(DB::select(" select count(distinct \"schema_name\") as aggregate from admin.all_log where \"table\"  in ('user', 'teacher') and (created_at >= date_trunc('week', CURRENT_TIMESTAMP - interval '1 week') and
//       created_at < date_trunc('week', CURRENT_TIMESTAMP)
//      )"))->first()->aggregate;
        //$this->data['log_graph'] = $this->createBarGraph();
        if(Auth::user()->id == 36){
            $id = Auth::user()->id;
           // $this->data['branch'] = $branch = \App\Models\PartnerUser::where('user_id', $id)->first();
            $this->data['use_shulesoft'] = DB::table('admin.all_setting')->count() - 5;
            $this->data['nmb_schools'] = DB::table('admin.nmb_schools')->count();
            $this->data['schools'] = DB::table('admin.schools')->where('ownership','<>', 'Government')->get();
            $this->data['nmb_shulesoft_schools'] = \collect(DB::select("select count(distinct schema_name) as count from admin.all_bank_accounts where refer_bank_id=22"))->first()->count;
            return view('analyse.nmb', $this->data);
        }elseif(Auth::user()->department == 10 && Auth::user()->id != 36){
            $id = Auth::user()->id;
            $this->data['branch'] = $branch = \App\Models\PartnerUser::where('user_id', $id)->first();
            $this->data['use_shulesoft'] = \App\Models\School::whereIn('ward_id', \App\Models\Ward::where('district_id', $branch->branch->district_id)->get(['id']))->whereNotNull('schema_name')->count();
            $this->data['nmb_schools'] = DB::table('admin.partner_schools')->where('branch_id', $branch->branch_id)->count();
            $this->data['schools'] = \App\Models\School::whereIn('ward_id', \App\Models\Ward::where('district_id', $branch->branch->district_id)->get(['id']))->where('ownership','<>', 'Government')->orderBy('schema_name', 'ASC')->get();
            $this->data['nmb_shulesoft_schools'] = \collect(DB::select('select count(distinct schema_name) as count from admin.all_bank_accounts where refer_bank_id=22 and schema_name in(select schema_name from admin.schools where schema_name is not null and ward_id in (select id from admin.wards where district_id = '. $branch->branch->district_id.'))'))->first()->count;
            return view('analyse.nmb', $this->data);
        }else{
            $user = Auth::user()->id;
            $sql = "select a.id, a.end_date, substring(a.activity from 1 for 80) as activity,a.created_at::date, a.date,d.name as user ,e.name as type  from admin.tasks a join admin.tasks_clients c on a.id=c.task_id
            join admin.users d on d.id=a.user_id join admin.task_types e on a.task_type_id=e.id WHERE a.user_id = $user order by a.created_at::date desc";
            $this->data['activities'] = DB::select($sql);
        return view('analyse.index', $this->data);
        }
    }

    public function customers() {
        $this->data['days'] = request()->segment(3);
        return view('analyse.customers', $this->data);
    }

    public function software() {
        $this->data['days'] = request()->segment(3);
        return view('analyse.software', $this->data);
    }

    public function moreInsight() {
        $this->data['days'] = request()->segment(3);
        return view('analyse.insight', $this->data);
    }

    public function sales() {
        $this->data['days'] = request()->segment(3);
        $this->data['shulesoft_schools'] = \collect(DB::select("select count(*) as count from admin.all_classlevel where lower(name) NOT like '%nursery%' and schema_name not in ('public','accounts')"))->first()->count;
        $this->data['schools'] = \collect(DB::select("select count(*) as count from admin.schools where lower(ownership)<>'government'"))->first()->count;
        $this->data['nmb_schools'] = \collect(DB::select('select count(*) as count from admin.nmb_schools'))->first()->count;
          $this->data['shulesoft_nmb_schools'] = \collect(DB::select('select count(distinct "schema_name") from admin.all_bank_accounts where refer_bank_id=22'))->first()->count;
        $this->data['clients'] = \collect(DB::select('select count(*) as count from admin.clients'))->first()->count;
        return view('analyse.sales', $this->data);
    }

    public function summary() {

        $this->data['parents'] = \collect(DB::select('select count(*) as count from admin.all_parent'))->first()->count;
        $this->data['students'] = \collect(DB::select('select count(*) as count from admin.all_student'))->first()->count;
        $this->data['teachers'] = \collect(DB::select('select count(*) as count from admin.all_teacher'))->first()->count;
        $this->data['users'] = \collect(DB::select('select count(*) as count from admin.all_users'))->first()->count;
        $this->data['total_schools'] = \collect(DB::select(" select count(distinct \"table_schema\") as aggregate from INFORMATION_SCHEMA.TABLES where \"table_schema\" not in ('admin', 'beta_testing', 'api', 'app', 'constant', 'public','accounts','information_schema')"))->first()->aggregate;
        $this->data['schools_with_students'] = \collect(DB::select('select count(distinct "schema_name") as count from admin.all_student'))->first()->count;

        $this->data['active_parents'] = \collect(DB::select('select count(*) as count from admin.all_parent where status=1'))->first()->count;
        $this->data['active_students'] = \collect(DB::select('select count(*) as count from admin.all_student where status=1'))->first()->count;
        $this->data['active_teachers'] = \collect(DB::select('select count(*) as count from admin.all_teacher where status=1'))->first()->count;
        $this->data['active_users'] = \collect(DB::select('select count(*) as count from admin.all_users where status=1'))->first()->count;

        return json_call($this->data);
    }

    public function setting() {
        $this->data['association'] = \App\Model\Association::first();
        return view('analyse.setting', $this->data);
    }

    public function accounts() {
        $this->data['association'] = \App\Model\Association::first();
        return view('analyse.accounts', $this->data);
    }

    public function marketing() {
        // $this->data['association'] = \App\Model\Association::first();
        return view('analyse.marketing', $this->data);
    }

    public function search() {
        $q = strtolower(request('q'));
        $users = DB::select("select a.reference,a.id,b.name,b.username from admin.invoices a join admin.clients b on b.id=a.client_id where (lower(a.reference) like  '%" . $q . "%'  or lower(b.name) like  '%" . $q . "%' )");
        $user_list = '';
        foreach ($users as $user) {
            $user_list .= '   <a class="dummy-media-object" href="' . url('account/invoiceView/' . $user->username) . '">
                                        <img class="round" src="' . url('public/assets/images/avatar-1.png') . '" alt="' . $user->name . '" />
                                        <h3>' . $user->name . '<br/>' . $user->reference . '</h3>
                                    </a>';
        }

        $school_list = '';
        $schools = DB::select("select * from (select sname,schema_name,photo, 1 as is_schema from admin.all_setting where lower(schema_name) like '%" . $q . "%' union select name as sname, name as schema_name,'default.png' as photo, id as is_schema from admin.schools where lower(name) like '%" . $q . "%' ) b limit 6 ");

        foreach ($schools as $school) {
            $url = $school->is_schema == 1 ? url('customer/profile/' . $school->schema_name) : url('sales/profile/' . $school->is_schema);
            $school_list .= ' <a class="dummy-media-object" href="' . $url . '">
                                        <img src="' . url('public/assets/images/avatar-1.png') . '" alt="' . $school->schema_name . '" />
                                        <h3>' . $school->sname . '</h3>
                                    </a>';
        }
        $activity_list = '';
        $activities = DB::SELECT("select * from admin.tasks where lower(activity) like  '%" . $q . "%' limit 4");
        foreach ($activities as $activity) {
            $url = url('users/notification/null?#tasks' . $activity->id);
            $activity_list .= ' <a class="dummy-media-object" href="' . $url . '">
                                        <img src="' . url('public/assets/images/avatar-1.png') . '" alt="" />
                                        <h3>' . $activity->activity . '</h3>
                                    </a>';
        }
        echo json_encode([
            'people' => $user_list,
            'schools' => $school_list,
            'activities' => $activity_list
        ]);
    }

    public function index2() {
        $this->data['pg_id'] = clean_htmlentities($this->uri->segment(3));
        $this->data['page'] = clean_htmlentities($this->uri->segment(4));
        if ($this->data['pg_id'] == 1) {
            $this->getUsers('student');
        } else if ($this->data['pg_id'] == 2) {
            $this->getUsers('parent');
        } else {
            $this->getUsers();
        }
        $this->getPageCalled($this->data['pg_id']);
        return view('insight.index', $this->data);
    }



    /**
     * 
     * @param type $table
     * @return type
     */
    public function getUsers($table = 'student') {
        $this->data['user'] = \collect(DB::SELECT("with total as (
	select count(*) as total from $table where status=1 ),
	total_male as (
select count(*) as male from $table where status=1 and lower(sex)='male'),
total_female as (
select count(*) as female from $table where status=1 and lower(sex) <>'male')
SELECT * FROM total,total_male, total_female
"))->first();

        $this->data['student_by_class'] = DB::SELECT('with classes AS (select count(a.*) as total,a."classesID",b.classes from student a join classes b on a."classesID"=b."classesID"  where a.status=1 group by a."classesID",b.classes ),
class_males as (select count(a.*) as male,a."classesID",b.classes from student a join classes b on a."classesID"=b."classesID"  where a.status=1 and lower(a.sex)=\'male\' group by a."classesID",b.classes),
class_females as (select count(a.*) as female,a."classesID",b.classes from student a join classes b on a."classesID"=b."classesID"  where a.status=1 and lower(a.sex) <>\'male\' group by a."classesID",b.classes)
select a.*,b.total,c.female from class_males a join classes b on a."classesID"=b."classesID" left join class_females c on c."classesID"=a."classesID" ORDER BY "classesID"');

        $this->data['locations'] = DB::SELECT('select count(a.*),a.city_id,b.city from ' . $table . ' a left join constant.refer_cities b on b.id=a.city_id group by city_id,b.city');
        $this->data['detail_locations'] = DB::select('select count(*),location from ' . $table . ' group by location');
        return $this->data;
    }

    public function custom() {
        $class_id = request('class_id');
        $sql_ = 'select round(avg(a.average),1) as count, EXTRACT(YEAR FROM age(cast(b.dob as date))) as age from sum_exam_average_done a join student b on a.student_id=b.student_id where a."classesID"=' . $class_id . ' group by b.dob';
        echo $this->createChartBySql($sql_, 'age', 'Overall Average', 'scatter', false);
        $corr = \collect(DB::SELECT('select corr(count,age) from (' . $sql_ . ' ) x '))->first();
        echo '<p>Correlation Factor : ' . round($corr->corr, 3) . '</p>';
    }

    public function charts() {
        return view('analyse.charts.logins', $this->data);
    }

}

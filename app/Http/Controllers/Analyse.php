<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Charts\SimpleChart;

class Analyse extends Controller {
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

        return view('analyse.index', $this->data);
    }

    public function customers() {
          return view('analyse.customers', $this->data);
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
       $this->data['association'] = \App\Model\Association::first();
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
     * @param type $pg_id
     */
    public function getPageCalled($pg_id) {
        $page_id = $this->data['page_id'] = $pg_id == null ? 1 : $pg_id;
        switch ($page_id) {
            case 1:
                $pg = 'student';
                $ar_list = [
                    'overview', 'locations', 'previus_school', 'age', 'health', 'religion', 'other_reports'
                ];
                break;
            case 2:
                $pg = 'parent';
                $ar_list = [
                    'overview', 'relation', 'age', 'locations', 'career', 'health'
                ];
                break;
            case 3:

                $pg = 'teacher';
                $ar_list = [
                    'overview', 'locations', 'age', 'career', 'health', 'religion', 'salary'
                ];
                $this->getUsers('teacher');
                break;
            case 4:
                $pg = 'staff';
                $ar_list = [
                    'overview', 'locations', 'age', 'career', 'health', 'religion', 'joining_date', 'salary'
                ];

                break;
            case 5:
                $pg = 'academic';
                $ar_list = [
                    'overview', 'class_average', 'subject_average', 'student_information', 'teachers_performance', 'activity_with_performance'
                ];

                break;
            case 6:

                $pg = 'accounts';
                $ar_list = [
                    'overview', 'Installments', 'parent_information', 'student_performance', 'financial_ratios'
                ];
                break;
            default:
                $pg = 'student';
                $ar_list = [
                    'overview', 'locations', 'previus_school', 'age', 'health', 'religion', 'other_reports'
                ];
                break;
        }
        $this->data['pg'] = $pg;
        $this->data['ar_list'] = $ar_list;
    }

    /**
     * 
     * @param type $sql
     * @param type $firstpart
     * @param type $table
     * @param type $chart_type
     * @param type $custom
     * @return type
     */
    public function createChartBySql($sql, $firstpart, $table, $chart_type, $custom = false, $call_back_sql = false) {
        $data = DB::select($sql);
        return $this->createGraph($data, $firstpart, $table, $chart_type, $custom, $call_back_sql);
    }

    /**
     * 
     * @param type $table
     * @param type $base_column
     * @param type $join_table
     * @param type $join_table_array
     * @param type $chart_type
     * @param type $custom
     * @param type $as_alias
     * @return type
     */
    public function createChart($table, $base_column, $join_table = false, $join_table_array = false, $chart_type = 'bar', $custom = false, $as_alias = false) {

        $data = $join_table == false ? DB::table($table)
                        ->select(DB::raw('count(*)'), DB::raw($base_column))
                        ->groupBy(DB::raw($as_alias == FALSE ? $base_column : $as_alias))->get() :
                DB::table($table)
                        ->join($join_table, array_keys($join_table_array)[0] . '.' . array_values($join_table_array)[0], array_keys($join_table_array)[1] . '.' . array_values($join_table_array)[1])
                        ->select(DB::raw('count(*)'), DB::raw($base_column))
                        ->groupBy(DB::raw($as_alias == FALSE ? $base_column : $as_alias))->get();
        $column = preg_replace('/^([^::]*).*$/', '$1', $as_alias == FALSE ? $base_column : $as_alias);
        list($firstpart) = explode(',', $column);
        return $this->createGraph($data, $firstpart, $table, $chart_type, $custom);
    }

    /**
     * 
     * @param type $data
     * @param type $chart_type
     * @param type $base_column
     * @return type
     */
    private function createCustomChart($data, $chart_type, $base_column) {
        $insight = $this;
        return view('insight.highcharts', compact('data', 'chart_type', 'base_column', 'insight'));
    }

    /**
     * 
     * @param type $data
     * @param type $firstpart
     * @param type $table
     * @param type $chart_type
     * @param type $custom
     * @param type $call_back_sql
     * @return type
     */
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
        $this->data['chart']=$chart;
        return $custom == true ? $this->createCustomChart($data, $chart_type, $firstpart) : view('analyse.charts.chart', $this->data);
    }

    /**
     * 
     * @param type $data
     * @param type $firstpart
     * @return type
     */
    private function createCallBack($data, $firstpart) {
        $k = [];
        $l = [];
        foreach ($data as $value) {
            array_push($k, $value->{$firstpart});
            array_push($l, (int) $value->count);
        }
        return [$k, $l];
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

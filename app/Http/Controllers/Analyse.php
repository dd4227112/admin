<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Analyse extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
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

}

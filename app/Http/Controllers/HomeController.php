<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }


     public function userapi(){
         $data = DB::select("select a.firstname ||' '||a.lastname as name,a.email,a.phone,a.next_kin,a.address,b.name as role,d.name as department,case when (f.path IS NULL OR f.path = '') then 'https://admin.shulesoft.com/public/assets/images/user.png' else f.path end as photo from admin.users a join constant.refer_company_designations b on a.designation_id = b.id join admin.departments d on a.department = d.id join admin.roles r on r.id = a.role_id left join admin.company_files f on f.id = a.company_file_id where a.status = '1' and a.role_id not in (7,15)");
          echo json_encode(['staffs' => $data]);
    }


    public function schoolapi(){
       $data = DB::select("select a.sname as school_name,a.phone,a.address,a.email,a.website,a.created_at as joined_at,
                case when (a.photo is null OR a.photo = '') then 'https://demo.shulesoft.com/public/assets/images/default.png' else 'https://demo.shulesoft.com/storage/uploads/images/'||a.photo end as photo, z.estimated_students as number_of_students from admin.all_setting a join admin.client_schools c on c.school_id = a.school_id join admin.clients z on z.id = c.client_id order by school_name");
         echo json_encode(['schools' => $data]);
    }

     public function schoolInfo() {
        $data['school_info'] = [
            'semisters' => DB::select('select name,start_date,end_date from ' . request('schema') . '.semester where class_level_id=' . request('class_level_id') . ' order by end_date desc limit 4'),
            "general_timetable" => DB::select('select title as event_name, date, notice_for as participants, status as type from ' . request('schema') . '.notice  where year=' . date("Y") . ''),
            'class_timetable' => DB::select('select a.start_time, a.end_time, b.classes as class, a.room, a.day, c.subject from ' . request('schema') . '.routine a join ' . request('schema') . '.classes b using("classesID") JOIN ' . request('schema') . '.subject c using("subjectID") where b.classlevel_id= ' . request('class_level_id') . ''),
            'daily_routine' => DB::select('select day, start_time, end_time, activity,class_level_id from ' . request('schema') . '.routine_daily where class_level_id=' . request('class_level_id') . '')
        ];
        echo json_encode($data);
    }


  


}
    
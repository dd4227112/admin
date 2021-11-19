<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
use PDF;

class Attendance extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }


    public function index() {
        $this->data['id'] = $id = request()->segment(3);
        if ((int) $id > 0) {
            $this->data['user'] = \App\Models\User::where('id', $id)->first();
            return view('users.attendance.show', $this->data);
        } else {
            $this->data['users'] = (new \App\Http\Controllers\Payroll())->getUsers();
            return view('users.attendance.index', $this->data);
        }
    }


    public function add(){
        $this->data['date'] = date("Y-m-d");
        $this->data['users'] = (new \App\Http\Controllers\Payroll())->getUsers();
        return view('users.attendance.create', $this->data);
    }




    function singl_add() {
        $id = request('id');
        $day = request('day');
        $absent_reason_id = (int) request('absent_id') > 0 ? (int) request('absent_id') : null;
        $user_id = preg_replace('/[^0-9]/i', '', $id);
        if ((int) $user_id) {
            $present = request('status') == 'false' ? 0 : 1;
            $this->addSingleUser($user_id, $day, $present, $absent_reason_id);
            echo ('success');
        }
    }


    public function addSingleUser($id, $day, $present, $absent_reason_id=null) {
        $where = ['user_id' => $id, 'date' =>date("Y-m-d", strtotime($day))];
        $found = \App\Models\Uattendance::where($where);
        if (!empty($found->first())) {
            //update              
            $data = array_merge($where, ['created_by' => Auth::user()->id,
                'absent_reason_id'=>$absent_reason_id,
                'present' => $present]);
            $found->update($data);
        } else {
            \App\Models\Uattendance::create(array_merge($where, [
            'timein' => date("Y-m-d h:i:s"),
            'created_by' => Auth::user()->id,
            'absent_reason_id'=> $absent_reason_id,
            'present' => $present]));
        }
        return TRUE;
    }


    public function getAbsentMinutes(){
        $min = \App\Models\Uattendance::where('date',date('m'));
    }


    public function report(){
        $this->data['type'] = $type = request()->segment(3);
        $this->data['id'] = $id = request()->segment(4);
           $export = request()->segment(5);
              $this->data["weeks"] = $this->loadWeeK();
            if(!empty($type) && !empty($id)){
                $this->data["type"] = $type;
                $this->data["set"] = $id;
                $this->data['users'] = (new \App\Http\Controllers\Payroll())->getUsers();

             if($export == 'export'){
                $this->data["export"] = $id;
                $this->data["printthis"]  = true;
           
                $pdf = PDF::loadView('users.attendance.report', $this->data);
                $type != 'date' ? $pdf->setPaper('A4', 'landscape') : '';
                return $pdf->stream('pdf_file.pdf');
               // return $pdf->download('pdf_file.pdf');
              }
            }
            return view("users.attendance.report", $this->data);
    }


      public function loadWeek(){
        $year   = date("Y");
        $firstDayOfYear = mktime(0, 0, 0, 1, 1, $year);
        $nextMonday     = strtotime('monday', $firstDayOfYear);
        $nextSunday     = strtotime('sunday', $nextMonday);
        $this_date = date("Y-m-d", strtotime($nextSunday));
        $exam_name = '';
        while (date('Y', $nextMonday) == $year && $this_date <= date("Y-m-d") ) {
            $week = date('W', strtotime($this_date));
            $exam_name .= '<option value=' . $nextSunday.'_'.$nextMonday . '>' . date('Y-m-d', $nextMonday). ' - '. date('Y-m-d', $nextSunday). ' - Week'. $week . '</option>';
            $nextMonday = strtotime('+1 week', $nextMonday);
            $nextSunday = strtotime('+1 week', $nextSunday);
            $this_date = date("Y-m-d", $nextSunday);
        }
        return $exam_name;
    }


      public function hr_report(){
            $day = request()->segment(3);
            $this->data['day'] = $day = !isset($day) ? date('Y-m-d') : $day;
            $where = date("Y-m-d", strtotime($day));
            $this->data['attendances']  = DB::select("select s.date,s.timein,s.timeout,u.firstname || ' '|| u.lastname as name from admin.uattendances s join admin.users u on s.user_id = u.id where u.status = 1 and u.role_id not in (7,15) and s.date::date = '".$where."' ");
            return view("users.attendance.hr_report", $this->data);

      }



}



<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;

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

}



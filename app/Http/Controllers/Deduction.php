<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\Models\UserDeduction;
use DB;

class Deduction extends Controller {

    function __construct() {
      //  parent::__construct();
        $this->middleware('auth');
      
    }

    public function index() {
        $this->data['breadcrumb'] = array('title' => 'Subscription-Allowance','subtitle'=>'accounts','head'=>'payroll');

            $this->data['type'] = $id = request()->segment(3);
            if ((int) $id > 0) {
                $this->data['deductions'] = \App\Models\Deduction::where('category', $id)->get();
            } else {
                $this->data['deductions'] = [];
            }
            $this->data['subview'] = 'account.payroll.deduction.index';
            return view($this->data['subview'], $this->data);
      }

    public function monthly() {
        if (can_access('manage_payroll')) {
            $this->data['type'] = 0;
            $this->data['deductions'] = \App\Model\Deduction::where('category', '<>', 1)->get();
            $this->data['subview'] = 'deduction/index';
            $this->load->view('_layout_main', $this->data);
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }


    public function add() {
        $this->data['breadcrumb'] = array('title' => 'Add deductions','subtitle'=>'accounts','head'=>'payroll');
            $this->data['type'] = $id = request()->segment(3);
            if ($_POST) { 
                $deduction = \App\Models\Deduction::create(request()->except('_token'));
                if ((int) $deduction->percent > 0 || (int) $deduction->amount > 0) {
                    $code = strtoupper(substr(0, 2));
                    \App\Models\ReferExpense::create(['name' => $deduction->name, 'financial_category_id' => 2, 'note' => 'Deductions', 'code' => 3232, 'code' => $code . '-OPEX-' . rand(1900, 582222),
                        'predefined' => 1]);
                }

               return redirect('deduction/index/'.$id)->with('success', 'Successfully!');
            } else {
                $this->data['subview'] = 'account.payroll.deduction.add';
                return view($this->data['subview'], $this->data);
            }
     
    }




    public function edit() {
           $this->data['breadcrumb'] = array('title' => 'Edit deductions','subtitle'=>'accounts','head'=>'payroll');
            $id = request()->segment(3);
            if ((int) $id) {
                $this->data['deduction'] = \App\Models\Deduction::find($id);
                if ($this->data['deduction']) {
                    if ($_POST) {
                        $this->data['deduction']->update(request()->except('_token'));
                        if ((int) $this->data['deduction']->employer_percent > 0 || (int) $this->data['deduction']->employer_amount > 0) {
                            $scheck = \App\Models\ReferExpense::where('name', $this->data['deduction']->name)->first();
                            if (empty($scheck)) {
                                $code = strtoupper(substr(set_schema_name(), 0, 2));
                                \App\Models\ReferExpense::create(['name' => $this->data['deduction']->name, 'financial_category_id' => 2, 'note' => 'Deductions', 'code' => 3232, 'code' => $code . '-OPEX-' . rand(1900, 582222),
                                    'predefined' => 1]);
                            }
                        }
                        return redirect('deduction/index/'.$this->data['deduction']->category)->with('success', 'Successfully!');
                    } else {
                        $this->data["subview"] = "account/payroll/deduction/edit";
                       return view($this->data['subview'], $this->data);
            
                    }
                } else {
                    $this->data["subview"] = "error";
    
                }
            } else {
                $this->data["subview"] = "error";
            }
    }

    public function delete() {
        $id = request()->segment(3);
            if ((int) $id) {
                $user_deductions = UserDeduction::where('deduction_id', $id)->first();
                $salary_deductions = \App\Models\SalaryDeduction::where('deduction_id', $id)->first();
                if (!empty($user_deductions) || !empty($salary_deductions)) {
                    //you cannot delete this
                   // dd('You cant');
                    return redirect()->back()->with('error', 'You cannot delete this deduction because some users are already allocated on this deduction!');
                } else {
                    \App\Models\Deduction::destroy($id);
                    return redirect()->back()->with('success', 'Deleted successfully!');

                }
                return redirect()->back();
            } else {
                return redirect()->back();
            }
    }

    public function subscribe() {
        $this->data['breadcrumb'] = array('title' => 'Subscription-Allowance','subtitle'=>'accounts','head'=>'payroll');
        $id = request()->segment(3);
        if ((int) $id) {
            $this->data['set'] = $id;
            $this->data['type'] = 'deduction';
            $this->data['allowance'] = \App\Models\Deduction::find($id);
            $subscriptions = \App\Models\UserDeduction::where('deduction_id', $id)->get();
            $data = [];
            foreach ($subscriptions as $value) {
                $data = array_merge($data, array($value->user_id));
            }
            $this->data['users'] = (new \App\Http\Controllers\Payroll())->getUsers();
            $this->data['subscriptions'] = $data;
       
            $this->data['view'] = 'account.payroll.subscribe';
            return view($this->data['view'], $this->data);
        } 
    }

    public function monthlysubscribe() {
        $id = request()->segment(3);
        if ((int) $id) {
            $this->data['set'] = $id;
            $this->data['type'] = 'deduction';
            $this->data['udeduction'] = \App\Models\Deduction::find($id);
            $subscriptions = \App\Models\UserDeduction::where('deduction_id', $id)->get();
            $data = [];
            foreach ($subscriptions as $value) {
                $data = array_merge($data, array($value->user_id));
            }
            $this->data['users'] = (new \App\Http\Controllers\Payroll())->getUsers();
            $this->data['subscriptions'] = $data;
            $this->data['view'] = 'account.payroll.deduction.monthlysubscribe';
            return view($this->data['view'], $this->data);
        } 
    }

    function monthlyAddSubscriber() {
        $deduction = UserDeduction::where('user_id', request('user_id'))->where('type', 0)->where('deduction_id', request('deduction_id'));
        $obj=array_merge(request()->except(['_token', 'deadline']), ['deadline'=> date('Y-m-d', strtotime(request('deadline')))]);
        if (!empty($deduction->first())) {
            $deduction->update($obj);
        } else {
            UserDeduction::create($obj);
        }
        echo 'success';
    }

    function excel() {
        $this->data['users'] = \App\Model\Teacher::all();
        $this->data["subview"] = "deduction/excel";
        $this->load->view('_layout_main', $this->data);
    }

    public function uploadFileByExcel() {
        ini_set('max_execution_time', 300); //overwrite execution time, 5min
        $data = $this->uploadExcel();
        $status = $this->excelCheckKeysExists($data, array('phone', 'amount', 'deadline', 'deduction_name'));
        if ((int) $status == 1 && count($data) > 0) {
            $status = '';
            foreach ($data as $val) {
                $value = array_change_key_case($val, CASE_LOWER);

                $deduction_name = isset($value['deduction_name']) ? $value['deduction_name'] : 'null';
                $deduction = \App\Model\Deduction::where(DB::raw('lower(name)'), strtolower($deduction_name))->first();

                $phone = isset($value['phone']) ? $value['phone'] : 'null';
                $valid = validate_phone_number($phone);

                $valid_phone = is_array($valid) ? $valid[1] : 'null';
                $user = \App\Model\User::where('phone', $valid_phone)->first();
                if (empty($user)) {
                    $status .= '<p class="alert alert-danger">User with this number ' . $value['phone'] . ' does not exists</p>';
                } else if (empty($deduction)) {
                    $status .= '<p class="alert alert-danger">This deduction name ' . $value['dediction_name'] . ' does not exists. Please define it first or write it correctly</p>';
                } else {
                    $user_deduction = UserDeduction::where('user_id', $user->id)->where('table', $user->table)->where('type', 0)->where('deadline', '>', date('Y-m-d', strtotime($value['deadline'])));

                    $obj = ['user_id' => $user->id, 'table' => $user->table, 'deduction_id' => $deduction->id, 'deadline' => date('Y-m-d', strtotime($value['deadline'])), 'type' => 0, 'amount' => $value['amount']];

                    if (!empty($user_deduction->first())) {
                        $user_deduction->update($obj);
                    } else {
                        UserDeduction::create($obj);
                    }
                    $status .= '<p class="alert alert-success">Deduction for user "' . $user->name . '" '
                            . '  added successfully</p>';
                }
            }
        }
        $this->data['status'] = $status;
        $this->data["subview"] = "mark/upload_status";
        $this->load->view('_layout_main', $this->data);
    }

}

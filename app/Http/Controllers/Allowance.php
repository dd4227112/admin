<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\UserAllowance;
use App\Models\SalaryAllowance;

class Allowance extends Controller {

    /**
     * -----------------------------------------
     * 
     * ******* Address****************
     * INETS COMPANY LIMITED
     * P.O BOX 32258, DAR ES SALAAM
     * TANZANIA
     * 
     * 
     * *******Office Location *********
     * 11th block, Bima Road, Mikocheni B, Kinondoni, Dar es salaam
     * 
     * 
     * ********Contacts***************
     * Email: <info@inetstz.com>
     * Website: <www.inetstz.com>
     * Mobile: <+255 655 406 004>
     * Tel:    <+255 22 278 0228>
     * -----------------------------------------
     */
    function __construct() {
         $this->middleware('auth');
        $this->data['insight'] = $this;
        // parent::__construct();
        // $this->lang->load('email');
        // $this->lang->load('payroll');
    }

    public function index() {
           $this->data['category'] = $id = request()->segment(3);
            if ((int) $id > 0) {
                $this->data['allowances'] = \App\Models\Allowance::where('category', $id)->get();
            } else {
                $this->data['allowances'] = [];
            }
            $this->data['view'] = 'account.payroll.allowance.index';
            return view($this->data['view'], $this->data);
    }

    public function add() {
            if ($_POST) {
                // $this->validate(request(), [
                //     'name' => 'required|max:255',
                //     "is_percentage" => "required",
                //     "description" => "required"
                //         ]);
                $allowances = request()->all();
                $allowance = \App\Models\Allowance::create($allowances);
                return redirect('allowance/index/'.$allowance->category)->with('success', 'Successfully!');
            } else {
                $this->data['view'] = 'account.payroll.allowance.add';
                //$this->load->view('_layout_main', $this->data);
                return view($this->data['view'], $this->data);
            }
    }

    public function edit() {
         $id = request()->segment(3);
            if ((int) $id) {
         $this->data['allowance'] = \App\Models\Allowance::find($id);
                if ($this->data['allowance']) {
                    if ($_POST) {
                        // $this->validate(request(), [
                        //     'name' => 'required|max:255',
                        //     "is_percentage" => "required",
                        //     "description" => "required"
                        //    ]);
                      
                     $this->data['allowance']->update(request()->except('_token'));
                     return redirect('allowance/index/'.$this->data['allowance']->category)->with('success', 'Allowance Updated Successfully!');
                    } else {
                        $this->data['view'] = 'account.payroll.allowance.edit';
                        return view($this->data['view'], $this->data);
                  }
                } else {
                    $this->data["subview"] = "error";
                   // $this->load->view('_layout_main', $this->data);
                }
            } else {
                $this->data["subview"] = "error";
              //  $this->load->view('_layout_main', $this->data);
            }
      }

    public function delete() {
            $id = request()->segment(3);
            if ((int) $id) {
                $user_allowances = UserAllowance::where('allowance_id', $id)->first();
                $salary_allowance = SalaryAllowance::where('allowance_id', $id)->first();
                if (!empty($user_allowances) || !empty($salary_allowance)) {
                    return redirect()->back()->with('error', 'You cannot delete this allowance because some users are already allocated on this allowance!');
                } else {
                    \App\Models\Allowance::destroy($id);
                 //   $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                    return redirect()->back()->with('success','Deleted successfull');
                }
                return redirect()->back();
            } else {
                return redirect()->back();
          }
    }

    public function subscribe() {
        $id = request()->segment(3);
        if ((int) $id) {
            $this->data['set'] = $id;
            $this->data['type'] = 'allowance';
            $this->data['allowance'] = \App\Models\Allowance::find($id);
            $subscriptions = UserAllowance::where('allowance_id', $id)->get();
            $data = [];
            foreach ($subscriptions as $value) {
                $data = array_merge($data, array($value->user_id));
            }
            $this->data['users'] = (new \App\Http\Controllers\Payroll())->getUsers();
            $this->data['subscriptions'] = $data;
          
            $this->data['view'] = 'account/payroll/subscribe';
            return view($this->data['view'], $this->data);
        } else {
            $this->data["subview"] = "account.payroll.allowance.index";
            return view($this->data['subview'], $this->data);
        }
    }

     public function monthlysubscribe() {
        $id = request()->segment(3);
        if ((int) $id) {
            $this->data['set'] = $id;
            $this->data['type'] = 'allowance';
            $this->data['allowance'] = \App\Models\Allowance::find($id);
            $subscriptions = \App\Models\UserAllowance::where('allowance_id', $id)->get();
            $data = [];
            foreach ($subscriptions as $value) {
                $data = array_merge($data, array($value->user_id));
            }
            $this->data['users'] = (new \App\Http\Controllers\Payroll())->getUsers();
            $this->data['subscriptions'] = $data;
            $this->data["subview"] = "account.payroll.allowance.monthlysubscribe";
            return view($this->data['subview'], $this->data);
        } else {
            $this->data["subview"] = "account.payroll.allowance.index";
            return view($this->data['subview'], $this->data);
        }
    }
    
    public function monthlyAddSubscriber() {
        $allowance = UserAllowance::where('user_id', request('user_id'))->where('allowance_id', request('allowance_id'))->where('deadline', '>', request('deadline'));
        if (!empty($allowance->first())) {
            $allowance->update(request()->all());
        } else {
            UserAllowance::create(request()->all());
        }
      //  print_r(request()->all());
        echo 'success';
        return request()->ajax() == TRUE ? 'success' : redirect()->back()->with('success', 'Successfully subscribed');
    }
}

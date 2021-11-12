<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\UserAllowance;
use App\Models\SalaryAllowance;

class Allowance extends Controller {

 
    function __construct() {
         $this->middleware('auth');
        $this->data['insight'] = $this;
    }

    public function index() {
           $this->data['category'] = $id = request()->segment(3);
            if ((int) $id > 0) {
                if($id == 1){
                  $this->data['allowance_type'] = 'Fixed Allowances';
                }elseif($id == 2){
                   $this->data['allowance_type'] = 'Monthly Allowances';  
                }else{
                   $this->data['allowance_type'] = 'Allowances';  
                }
                $this->data['allowances'] = \App\Models\Allowance::where('category', $id)->get();
            } else {
                  $this->data['allowances'] = [];
            }
            $this->data['view'] = 'account.payroll.allowance.index';
            return view($this->data['view'], $this->data);
       }

    public function add() {
        $this->data['breadcrumb'] = array('title' => 'Add allowances','subtitle'=>'accounts','head'=>'payroll');

            if ($_POST) {
                // $this->validate(request(), [
                //     'name' => 'required|max:255',
                //     "is_percentage" => "required",
                //     "description" => "required"
                //         ]);
              //  $allowances = !empty(request('amount')) ? request()->all(request()->except(request('amount'))) : request()->all();
               
                if(request('amount') !== null){
                    $allowances = request()->all(request()->except(request('amount')));
                    $data = array_merge($allowances,['amount' => remove_comma(request('amount'))]);
                } else {
                    $data = request()->all();
                }

                $allowance = \App\Models\Allowance::create($data);
                return redirect('allowance/index/'.$allowance->category)->with('success', '👍Allowance successfully created!');
            } else {
               // $this->data['view'] = 'account.payroll.allowance.add';
                return view('account.payroll.allowance.add', $this->data);
            }
    }

    public function edit() {
        $this->data['breadcrumb'] = array('title' => 'Edit allowances','subtitle'=>'accounts','head'=>'payroll');
         $id = request()->segment(3);
            if ((int) $id) {
         $this->data['allowance'] = \App\Models\Allowance::find($id);
                if ($this->data['allowance']) {
                    if ($_POST) {
                      
                     $this->data['allowance']->update(request()->except('_token'));
                     return redirect('allowance/index/'.$this->data['allowance']->category)->with('success', '👍 Updated Successfully!');
                    } else {
                        $this->data['view'] = 'account.payroll.allowance.edit';
                        return view($this->data['view'], $this->data);
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
                $user_allowances = UserAllowance::where('allowance_id', $id)->first();
                $salary_allowance = SalaryAllowance::where('allowance_id', $id)->first();
                if (!empty($user_allowances) || !empty($salary_allowance)) {
                    return redirect()->back()->with('error', '🤦  You cannot delete this allowance because some users are already allocated on this allowance!');
                } else {
                    \App\Models\Allowance::destroy($id);
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
        $this->data['breadcrumb'] = array('title' => 'Subscription-Allowance','subtitle'=>'accounts','head'=>'payroll');
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
        return request()->ajax() == TRUE ? 'Successfully subscribed' : redirect()->back()->with('success', 'Successfully subscribed');
    }
}

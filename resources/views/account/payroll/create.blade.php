
@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
      <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
        <div class="page-body">

        <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="col-lg-12 col-xl-12">                                      
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs md-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home3" role="tab"> <strong>PAYROLL LIST</strong></a>
                            <div class="slide"></div>
                        </li>
                    </ul>

                            <!-- Tab panes -->
                    <div class="card-block">
                     <form class="form-horizontal" role="form" method="post">
                        <div class="table-responsive">
                            <table class="table dataTable table-sm table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th ><?= __('#') ?></th>
                                    <th><?= __('Employee name') ?></th>
                                    <th>User designation</th>
                                    <th >Bank</th>
                                    <th><?= __('Bank Account') ?></th>
                                    <th><?= __('Basic Pay') ?></th>
                                    <th><?= __('Allowance') ?></th>
                                    <th ><?= __('Gross pay') ?></th>
                                    <th ><?= __('Pension') ?></th>
                                    <th ><?= __('deduction') ?></th>
                                    <th ><?= __('Taxable Amount') ?></th>
                                    <th ><?= __('Paye') ?></th>
                                    <th ><?= __('Net Pay') ?></th>
                                    <?php
                                    if (can_access('manage_payroll')) {?>   
                                            {{-- <th ><?= __('Action') ?></th>                                                                                                                                        <!--<th class="col-sm-4"><?= __('action') ?></th>--> --}}
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $total_basic_pay = 0;
                                $sum_of_total_allowances = 0;
                                $total_gross_pay = 0;
                                $total_pension = 0;
                                $sum_of_total_deductions = 0;
                                $total_paye = 0;
                                $total_taxable_amount = 0;
                                $pension_employer_contribution = 0;
                                $total_net_pay = 0;
                                $bank_name = '';
                                $users =  \App\Models\User::where('status', 1)->whereNotIn('role_id',array(7,5,15))->get();
                                foreach ($users as $user) {
                                   // $user_info = $user->userInfo(DB::table($user->table));
                                    $basic_salary = $special == 0 ? $user->salary : 0;
                                    $total_basic_pay += $basic_salary;
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= ucwords($user->firstname. ' ' .$user->lastname) ?></td>
                                        <td><?= $user->designation->name ?></td>
                                        <td><?= $user->bank_name ?> </td>
                                        <td>
                                           <?= $user->bank_account ?>
                                        </td>
                                        <td>
                                            <?= (int) $basic_salary == 0 ? 0 : money($basic_salary) ?>
                                         </td>
                                        <td>
                                            <?php
                                            //calculate user allowances
                                            $allowances = \App\Models\UserAllowance::where('user_id', $user->id)->get();
                                            $allowance_ids = array();
                                            $total_allowance = 0;
                                            $taxable_allowances = 0;
                                            $non_taxable_allowances = 0;
                                            $no_pension_allowances = 0;
                                            if (!empty($allowances) ) {
                                                foreach ($allowances as $value) {
                                                    $all_amount = (float) $value->amount > 0 ? $value->amount : $value->allowance->amount;
                                                    $all_percent = (float) $value->percent > 0 ? $value->percent : $value->allowance->percent;

                                                    $all_end_date = date_create(date('Y-m-d', strtotime($value->deadline)));
                                                    $all_now = date_create(date('Y-m-d'));
                                                    $all_diffi = date_diff($all_now, $all_end_date);
                                                    $all_time_diff = $all_diffi->format("%R%a");
                                                    if ($value->allowance->type == 0) {
                                                        //taxable allowances
                                                        if ($value->allowance->category == 2 && (int) $all_time_diff > 0) {
                                                            $allowance_tax_amount = $value->allowance->is_percentage == 1 ? $basic_salary * $all_percent / 100 : $all_amount;
                                                            //  echo $allowance_tax_amount.'<br/>';
                                                            $taxable_allowances += $allowance_tax_amount;
                                                            array_push($allowance_ids, [$allowance_tax_amount => $value->allowance_id]);
                                                        }
                                                        if ($value->allowance->category == 1) {
                                                            $allowance_tax_amount = $value->allowance->is_percentage == 1 ? $basic_salary * $all_percent / 100 : $all_amount;
                                                            //  echo $allowance_tax_amount.'<br/>';
                                                            $taxable_allowances += $allowance_tax_amount;
                                                            array_push($allowance_ids, [$allowance_tax_amount => $value->allowance_id]);
                                                        }
                                                    }
                                                    if ($value->allowance->type == 1) {
                                                        if ($value->allowance->category == 2 && (int) $all_time_diff > 0) {
                                                            //not taxable allowances
                                                            $allowance_nontax_amount = $value->allowance->is_percentage == 1 ? $basic_salary * $all_percent / 100 : $all_amount;
                                                            // echo $allowance_nontax_amount.'<br/>';
                                                            $non_taxable_allowances += $allowance_nontax_amount;
                                                            array_push($allowance_ids, [$allowance_nontax_amount => $value->allowance_id]);
                                                        }
                                                        if ($value->allowance->category == 1) {
                                                            //not taxable allowances
                                                            $allowance_nontax_amount = $value->allowance->is_percentage == 1 ? $basic_salary * $all_percent / 100 : $all_amount;
                                                            // echo $allowance_nontax_amount.'<br/>';
                                                            $non_taxable_allowances += $allowance_nontax_amount;
                                                            array_push($allowance_ids, [$allowance_nontax_amount => $value->allowance_id]);
                                                        }
                                                    }

                                                    if ($value->allowance->pension_included == 0) {
                                                        if ($value->allowance->category == 2 && (int) $all_time_diff > 0) {
                                                            $allowance_with_no_pension = $value->allowance->is_percentage == 1 ? $basic_salary * $all_percent / 100 : $all_amount;
                                                            // echo $allowance_nontax_amount.'<br/>';
                                                            $no_pension_allowances += $allowance_with_no_pension;
                                                        }
                                                        if ($value->allowance->category == 1) {
                                                            $allowance_with_no_pension = $value->allowance->is_percentage == 1 ? $basic_salary * $all_percent / 100 : $all_amount;
                                                            // echo $allowance_nontax_amount.'<br/>';
                                                            $no_pension_allowances += $allowance_with_no_pension;
                                                        }
                                                    }
                                                    $allowance_amount = $non_taxable_allowances + $taxable_allowances;
                                                    $total_allowance = $allowance_amount;
                                                }
                                            }
                                            if ( (int) $special == 0) {
                                                $total_allowance = 0;
                                                $taxable_allowances = 0;
                                            }
                                            echo money($total_allowance);
                                            $sum_of_total_allowances += $total_allowance;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $gross_pay = $basic_salary + $total_allowance;
                                            $total_gross_pay += $gross_pay;
                                            echo money($gross_pay);
                                            ?> 
                                        </td>
                                        <td>  
                                            <?php
                                            //calculate user pension amount
                                            $pensions = \App\Models\UserPension::where('user_id', $user->id)->get();
                                            $pension_employer_contribution = 0;
                                            $pension_employee_contribution = 0;
                                            foreach ($pensions as $pension) {
                                                if ($pension->pension->status == '1') {
                                                    $pension_employee_contribution += $pension->pension->employee_percentage * ($gross_pay - $non_taxable_allowances - $no_pension_allowances) / 100;
                                                    $pension_employer_contribution += $pension->pension->employer_percentage * ($gross_pay - $non_taxable_allowances - $no_pension_allowances) / 100;
                                                    $pension_employee_contribution = $special == 0 ? $pension_employee_contribution : 0;
                                                    $pension_employer_contribution = $special == 0 ? $pension_employer_contribution : 0;
                                                    $total_pension += $pension_employee_contribution;
                                                } else {
                                                    $pension_employee_contribution += $pension->pension->employee_percentage * ($basic_salary - $non_taxable_allowances - $no_pension_allowances) / 100;
                                                    $pension_employer_contribution += $pension->pension->employer_percentage * ($basic_salary - $non_taxable_allowances - $no_pension_allowances) / 100;
                                                    $pension_employee_contribution = $special == 0 ? $pension_employee_contribution : 0;
                                                    $pension_employer_contribution = $special == 0 ? $pension_employer_contribution : 0;
                                                    $total_pension += $pension_employee_contribution;
                                                }
                                            }
                                            echo money($pension_employee_contribution);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            //calculate user deductions
                                            $deductions = \App\Models\UserDeduction::where('user_id', $user->id)->get();
                                            $deduction_ids = array();
                                            $ededuction_ids = array();
                                            $total_deductions = 0;
                                            $total_employer_deduction = 0;
                                            if (!empty($deductions)) {
                                                foreach ($deductions as $value) {
                                                    $cut_amount = (int) $value->deduction->gross_pay == 1 ? $gross_pay : $basic_salary;
                                                    $employer_deduction = (bool) $value->deduction->is_percentage == 1 ? (float) $cut_amount * $value->employer_percent / 100 : (float) $value->employer_amount;
                                                    $employee_deduction = (bool) $value->deduction->is_percentage == 1 ? (float) $cut_amount * $value->percent / 100 : (float) $value->amount;
                                                    $total_employer_deduction += $employer_deduction;
                                                    $ded_amount = (float) $value->amount > 0 ? $value->amount : $value->deduction->amount;
                                                    $ded_percent = (float) $value->percent > 0 ? $value->percent : $value->deduction->percent;
                                                    $end_date = date_create(date('Y-m-d', strtotime($value->deadline)));
                                                    $now = date_create(date('Y-m-d'));
                                                    $diffi = date_diff($now, $end_date);
                                                    $time_diff = $diffi->format("%R%a");
                                                    if ($value->type == 0 && (int) $time_diff > 0) {
                                                        $tded_amount = $employer_deduction + $ded_amount;
                                                        // $total_deductions += $tded_amount;
                                                        $total_deductions += $ded_amount;
                                                        array_push($deduction_ids, [$employee_deduction => $value->deduction_id]);
                                                        array_push($ededuction_ids, [$employer_deduction => $value->deduction_id]);
                                                    }
                                                    if ($value->type <> 0) {
                                                        $deduction_amount = (bool) $value->deduction->is_percentage == 1 ? $cut_amount * $ded_percent / 100 : $ded_amount;
                                                        $tdeduction_amount = $employer_deduction + $deduction_amount;
                                                        // $total_deductions += $tdeduction_amount;
                                                        $total_deductions += $deduction_amount;
                                                        array_push($deduction_ids, [$deduction_amount => $value->deduction_id]);
                                                        array_push($ededuction_ids, [$employer_deduction => $value->deduction_id]);
                                                    }
                                                    // if deduction is from a LOAN
                                                    if ((int) $value->deduction->loan_application_id > 0 && $create == 1) {
                                                        DB::table('loan_payments')->insert([
                                                            'loan_application_id' => $value->deduction->loan_application_id,
                                                            'amount' => $value->deduction->amount,
                                                            'payment_type_id'=>1,
                                                            'date' => date('Y-m-d', strtotime(request('payroll_date'))),
                                                            'transaction_id' => time(),
                                                            'bank_account_id'=>DB::table('bank_accounts')->first()->id,
                                                            'created_by' => Auth::user()->id,
                                                         
                                                        ]);
                                                    }
                                                }
                                            }
                                            $total_deductions = (int) $special == 0 ? $total_deductions : 0;
                                            $sum_of_total_deductions += $total_deductions;
                                            echo money($total_deductions);
                                            ?> 
                                        </td>
                                        <td>
                                            <?php
                                            //calculate user taxable amount
                                            $taxable_amount = $gross_pay - $pension_employee_contribution - $non_taxable_allowances;
                                            $total_taxable_amount += $taxable_amount;
                                            echo money($taxable_amount);
                                            ?>  
                                        </td>
                                        <td>
                                            <?php
                                            //calculate PAYEE
                                            $tax = \App\Models\Paye::where('from', '<=', round($taxable_amount, 0))->where('to', '>=', round($taxable_amount, 0))->first();
                                            if (!empty($tax) ) {
                                                $paye = ($taxable_amount - $tax->from) * $tax->tax_rate / 100 + $tax->tax_plus_amount;
                                            } else {
                                                $paye = 0;
                                            }
                                            $total_paye += $paye;
                                            echo money($paye);
                                            ?> 
                                        </td>
                                        <td>
                                            <?php
                                            //$net_pay = $gross_pay - $pension_employee_contribution - $total_deductions - $paye ; //all the same
                                            $net_pay = $basic_salary + $taxable_allowances - $pension_employee_contribution - $total_deductions - $paye + $non_taxable_allowances;
                                            $total_net_pay += $net_pay;
                                            echo money($net_pay);
                                            ?>
                                        </td>
                                        {{-- <td>
                                            <a href="<?= url('payroll/payslip/null/?id=' . $user->id . '&month=' . date('m')) ?>" class="btn btn-success btn-sm" data-placement="top" data-toggle="tooltip" data-original-title="Show Payslip"><i class="fa fa-file"></i>Preview</a> 
                                        </td>  --}}
                                    </tr>

                                    <?php
                                    if ($create == 1) {
                                        $check_data = array('user_id' => $user->id,
                                             'payment_date' => date('Y-M-d', strtotime(request('payroll_date'))));
                                        $check = \DB::table('salaries')->where($check_data)->first();
                                        if (empty($check)) {
                                            $salary_id = \DB::table('salaries')->insertGetId(array(
                                                'user_id' => $user->id,
                                                'basic_pay' => $basic_salary,
                                                'allowance' => $total_allowance,
                                                'gross_pay' => $gross_pay,
                                                'pension_fund' => $pension_employee_contribution,
                                                'deduction' => $total_deductions,
                                                'tax' => $taxable_amount,
                                                'paye' => $paye,
                                                'net_pay' => $net_pay,
                                                'payment_date' => date('Y-M-d', strtotime(request('payroll_date'))),
                                                'reference' => date('Ymd')
                                            ));

                                        // $min = \App\Models\Uattendance::where('user_id',$user->id)->whereMonth('date', '=', date('m',strtotime(request('payroll_date'))))->get();
                                        // $office_time = '08:00:00';
                                        // $all_minutes = [];
                                        // foreach($min as $key => $m){
                                        //     $time = date("H:s:i",strtotime($m->timein));
                                        //     $mnts = strtotime($time) - strtotime($office_time)/60;
                                        //     array_push($all_minutes, $mnts);
                                        // }
                                        // print_r(array_sum($all_minutes));

                                        } else {
                                            $salary_id = $check->id;
                                        }
                                        if (request('send_sms_email') == 1) {
                                            $sms_body = request('message_body');
                                            $patterns = array(
                                                '/#name/i', '/#net_payment/i', '/#salary_date/i'
                                            );
                                            $replacements = array(
                                                $user->name,  $net_pay . '/=', date('Y-M-d', strtotime(request('payroll_date')))
                                            );
                                            $sms = preg_replace($patterns, $replacements, $sms_body);
                                            \DB::table('public.sms')->insert(['body' => $sms, 'user_id' => $user->id, 'phone_number' => $user->phone]);
                                            \DB::table('public.email')->insert(['body' => $sms, 'subject' => ' Salary for ' . date('Y-M-d', strtotime(request('payroll_date'))), 'user_id' => $user->id, 'email' => $user->email]);
                                        }
                                        //add salary_allowance records. One person can have more than one allowances
                                        if (!empty($allowance_ids)) {
                                            foreach ($allowance_ids as $key1 => $allowances) {
                                                foreach ($allowances as $key => $allowance_id) {
                                                    $key=empty($key) ? 0:$key;
                                                    $check_all_data = array('salary_id' => $salary_id,
                                                        'allowance_id' => $allowance_id);
                                                    $check_all = \DB::table('salary_allowances')->where($check_all_data)->first();
                                                    if (empty($check_all)) {
                                                        \DB::table('salary_allowances')->insert(array(
                                                            'salary_id' => $salary_id,
                                                            'allowance_id' => $allowance_id,
                                                            'amount' => $key,
                                                            'created_by' => Auth::user()->id 
                                                        ));
                                                    }
                                                }
                                            }
                                        }

                                        //add salary_deduction records
                                        if (!empty($deduction_ids)) {
                                            foreach ($deduction_ids as $key1 => $deductions) {
                                                foreach ($deductions as $key => $deduction_id) {
                                                    $check_ded_data = array('salary_id' => $salary_id,
                                                        'deduction_id' => $deduction_id);
                                                    $check_ded = \DB::table('salary_deductions')->where($check_ded_data)->first();
                                                    if (empty($check_ded)) {
                                                        if(!empty($key)){
                                                            $amount_ded = $key;
                                                            }else{
                                                            $amount_ded = 0;
                                                        }
                                                        \DB::table('salary_deductions')->insert(array(
                                                            'salary_id' => $salary_id,
                                                            'deduction_id' => $deduction_id,
                                                            'amount' => $amount_ded,
                                                            'created_by' => Auth::user()->id 
                                                        ));
                                                    }
                                                }
                                            }
                                        }
                                        //add salary_deduction records
                                        $edeductions_ids = [];
                                        if (!empty($ededuction_ids)) {
                                            foreach ($ededuction_ids as $key1 => $edeductions) {
                                                foreach ($edeductions as $key => $deduction_id) {
                                                    array_push($edeductions_ids, $deduction_id);
                                                    $check_eded_data = array('salary_id' => $salary_id,
                                                        'deduction_id' => $deduction_id);
                                                    $check_eded = \DB::table('salary_deductions')->where($check_eded_data);
                                                    if (empty($check_eded->first())) {
                                                        \DB::table('salary_deductions')->insert(array(
                                                            'salary_id' => $salary_id,
                                                            'deduction_id' => $deduction_id,
                                                            'amount' => 0,
                                                            'employer_amount' => $key,
                                                            'created_by' => Auth::user()->id
                                                        ));
                                                    } else {
                                                        $check_eded->update(['employer_amount' => $key]);
                                                    }
                                                }
                                            }
                                        }

                                        //total deductions which are expense to schools
                                        $totals = \DB::select('SELECT sum(employer_amount::integer) as employer_amount, name, expense_id from (
                                      select a.employer_amount, b.name, c.id as expense_id from salary_deductions a join deductions b on a.deduction_id=b.id join refer_expense c on b.name=c.name where a.salary_id=' . $salary_id . ' and a.employer_amount is not null and a.employer_amount::integer >= 0 group by a.employer_amount,b.name,c.id ) b group by name,expense_id');
                                       
                                          $bank_account = \App\Models\BankAccount::where('id','>', 0)->first();
                                        foreach ($totals as $total) {
                                            $array = array(
                                              //  "create_date" => date("Y-m-d"),
                                                "date" => date('Y-m-d', strtotime(request('payroll_date'))),
                                                "amount" => $total->employer_amount,
                                                "note" => 'Payroll ',
                                                "ref_no" => date('Ymd'),
                                                "payment_method" => 'bank',
                                                "refer_expense_id" => $total->expense_id,
                                                "expenseyear" => date("Y"),
                                                "expense" => $total->name,
                                                "depreciation" => 0,
                                                // Payment type id is 3
                                                "payment_type_id"=>1,
                                                "bank_account_id"=>$bank_account->id,
                                                'user_id' => Auth::user()->id,
                                            
                                            );
                                            \DB::table('expenses')->insert($array);
                                        }

                                        //add salary_pension_records

                                        if (!empty($pensions) && (int) $special == 0) {
                                            foreach ($pensions as $pension) {
                                                $check_salary_data = array('salary_id' => $salary_id,
                                                    'pension_id' => $pension->pension_id);
                                                $check_salary = \DB::table('salary_pensions')->where($check_salary_data)->first();
                                                if (empty($check_salary)) {
                                                    \DB::table('salary_pensions')->insert(array(
                                                        'salary_id' => $salary_id,
                                                        'pension_id' => $pension->pension_id,
                                                        'amount' => $pension_employee_contribution,
                                                        'employer_amount' => $pension_employer_contribution,
                                                        'created_by' => Auth::user()->id
                                                    ));
                                                }
                                            }
                                        }
                                    }

                                    $i++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>

                                    <td>Total</td>
                                  <!--  <td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?= money($total_basic_pay) ?></td>
                                    <td><?= money($sum_of_total_allowances) ?></td>
                                    <td><?= money($total_gross_pay) ?></td>
                                    <td><?= money($total_pension) ?></td>
                                    <td><?= money($sum_of_total_deductions) ?></td>
                                    <td><?= money($total_taxable_amount) ?></td>
                                    <td><?= money($total_paye) ?></td>
                                    <td><?= money($total_net_pay) ?></td>

                                    <!--  <td>
                                        <a href="<?= url('payroll/summary/null/?month=' . date('M') . '&month=' . date('m')) . '&' . http_build_query(array('basic_pay' => $total_basic_pay, 'allowance' => $sum_of_total_allowances, 'gross_pay' => $total_gross_pay, 'pension' => $total_pension, 'deduction' => $sum_of_total_deductions, 'tax' => $total_taxable_amount, 'paye' => $total_paye, 'net_pay' => $total_net_pay)) ?>" class="btn btn-success btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Show Payslip"><i class="fa fa-file"></i>Summary</a>
                                    </td>-->
                                </tr>
                            </tfoot>
                        </table>
                      </div>
                     </div>
                    
                    <?php if ($create == 0) { ?>
                       
                     <div class="row">
                        <div class='form-group  col-sm-4'>
                            <label class="col-sm-12 control-label">
                                Payroll Date
                            </label>
                            <div class="col-sm-12">
                                <input type="date" class="form-control" required="" name="payroll_date" value="<?= date('Y-m-d') ?>" >
                            </div>
                        </div>
  
                
                        <div class='form-group col-sm-4'>
                            <label class="col-sm-12 control-label">
                                Notify company employees
                            </label>
                            <div class="col-sm-3">
                                <input type="checkbox" id="check_message_to_send" onclick="$('#message_to_send').toggle()" class="form-control" name="send_sms_email" value="1" >
                            </div>
                            <div class="col-sm-12">
                                <textarea style="display:none" id="message_to_send" class="form-control" name="message_body">Hello #name Salary for this #salary_date has been issued. Your Net payment amount is #net_payment.</textarea>
                            </div>
                        </div>

                        <div class='form-group  col-sm-4'>
                            <div class="col-sm-6">
                                <input type="submit" class="btn btn-success" value="Create Payroll">
                            </div>
                        </div>
                        <?php
                    } else {
                        //insert in expense table so we can track in income statement
                        //insert bank_account_id and payment type in expense
                        $bank_account = \App\Models\BankAccount::where('id','>',0 )->first();
                        $array = array(
                         //   "create_date" => date("Y-m-d"),
                            "date" => date('Y-m-d', strtotime(request('payroll_date'))),
                            "amount" => $total_gross_pay,
                            "note" => 'Payroll ',
                            "ref_no" => date('Ymd'),
                            "payment_method" => 'bank',
                            "refer_expense_id" => $refer_expense_id,
                            "expenseyear" => date("Y"),
                            "expense" => 'Payroll',
                            "depreciation" => 0,
                            //Payment type id is 3
                            "payment_type_id"=>1,
                            'bank_account_id'=>$bank_account->id,
                            'user_id' => Auth::user()->id,
                          
                        );
                        $insert_id = \DB::table('expenses')->insertGetId($array, "id");
                        //specify all expenses accomplished by 
                        ?>
                        <script type="text/javascript">window.location.href = '<?= url('payroll/index') ?>';</script>     
                    <?php } ?>
                    <?= csrf_field() ?>
                  </form>
                 </div> 
           </div>
         </div>
        </div> 
      </div>
   </div>
</div>


@endsection
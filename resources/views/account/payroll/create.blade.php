
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-feetype"></i> <?= __('panel_title') ?></h3>

        <ol class="breadcrumb">
            <li><a href="<?= url("dashboard/index") ?>"><i
                        class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
            <li><a href="<?= url("payroll/index") ?>"><?= __('menu_payroll') ?></a></li>
            <li class="active"><?= __('menu_add') ?> <?= __('menu_payroll') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <!--<p> Fields marked <span class="red">*</span> are mandatory</p>-->
        <div class="row">
            <div class="col-sm-12">
                <form class="form-horizontal" role="form" method="post">

                    <!--  <?php
                //    if (form_error($errors, 'subject'))
                //        echo "<div class='form-group has-error' >";
                //    else
                //        echo "<div class='form-group' >";
                      ?>
                        <label for="subject" class="col-sm-2 control-label">
                            Specify payment date
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="name" placeholder="<?php //__('date')   ?>" name="date" value="<?= date('d M Y') ?>" >
                        </div>
                     </div>-->
                    <div class="col-sm-12">
                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="col-sm-1"><?= __('slno') ?></th>
                                    <th class="col-sm-2"><?= __('employee_name') ?></th>
                                    <th class="col-sm-2">User Type</th>
                                    <!--<th class="col-sm-2"><?= __('employee_number') ?></th>-->
                                    <th class="col-sm-1">Bank</th>
                                    <th class="col-sm-2"><?= __('bank_account') ?></th>
                                    <th class="col-sm-2"><?= __('basic_pay') ?></th>
                                    <th class="col-sm-1"><?= __('allowance') ?></th>
                                    <th class="col-sm-1"><?= __('gross_pay') ?></th>
                                    <th class="col-sm-1"><?= __('pension') ?></th>
                                    <th class="col-sm-1"><?= __('deduction') ?></th>
                                    <th class="col-sm-1"><?= __('taxable_amount') ?></th>
                                    <th class="col-sm-1"><?= __('paye') ?></th>
                                    <th class="col-sm-1"><?= __('net_pay') ?></th>

                                    <?php
                                    if (can_access('manage_payroll')) {
                                        ?>                                                                                                                                                   <!--<th class="col-sm-4"><?= __('action') ?></th>-->
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
                                foreach ($users as $user) {
                                    $user_info = $user->userInfo(DB::table($user->table));
                                    $basic_salary = $special == 0 ? $user_info->salary : 0;
                                    $total_basic_pay += $basic_salary;
                                    //echo $user->table;exit;
                                    $bank_name = $user->userInfo(DB::table($user->table))->bank_name;
                                    $bank_account = $user->userInfo(DB::table($user->table))->bank_account_number;
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $user->name ?></td>
                                        <td><?= $user->usertype ?></td>
                                        <!--<td><?php //$user_info->id_number ?></td>-->

                                        <td><span  style=" text-decoration: none; border-bottom: dashed 1px #0088cc;" contenteditable="true" onblur="save('<?= $user->id . $user->table . 'bank_name' ?>', '<?= $user->id ?>', 'bank_name', '<?= $user->table ?>')" id="<?= $user->id . $user->table . 'bank_name' ?>"><?= $bank_name == '' ? 'null' : $bank_name ?></span>
                                            <span id="stat<?= $user->id . $user->table . 'bank_name' ?>"></span></td>
                                        <td>
                                            <span style=" text-decoration: none; border-bottom: dashed 1px #0088cc;" contenteditable="true" onblur="save('<?= $user->id . $user->table . 'bank_account_number' ?>', '<?= $user->id ?>', 'bank_account_number', '<?= $user->table ?>')" id="<?= $user->id . $user->table . 'bank_account_number' ?>"><?= $bank_account == '' ? 'null' : $bank_account ?></span>
                                            <span id="stat<?= $user->id . $user->table . 'bank_account_number' ?>"></span></td>

                                        <td><span style=" text-decoration: none; border-bottom: dashed 1px #0088cc;" contenteditable="true" onblur="save('<?= $user->id . $user->table . 'salary' ?>', '<?= $user->id ?>', 'salary', '<?= $user->table ?>')" id="<?= $user->id . $user->table . 'salary' ?>"><?= (int) $basic_salary == 0 ? 0 : ($basic_salary) ?></span>
                                            <span id="stat<?= $user->id . $user->table . 'salary' ?>"></span></td>
                                        <td>
                                            <?php
                                            //calculate user allowances
                                            $allowances = \App\Models\UserAllowance::where('user_id', $user->id)->where('table', $user->table)->get();
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
                                            if (in_array(set_schema_name(), ['public.']) && (int) $special == 0) {
                                                $total_allowance = 0;
                                                $taxable_allowances = 0;
                                            }
                                            echo ($total_allowance);
                                            $sum_of_total_allowances += $total_allowance;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $gross_pay = $basic_salary + $total_allowance;
                                            $total_gross_pay += $gross_pay;
                                            echo ($gross_pay);
                                            ?> 
                                        </td>
                                        <td>  
                                            <?php
                                            //calculate user pension amount
                                            $pensions = \App\Models\UserPension::where('user_id', $user->id)->where('table', $user->table)->get();
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
                                            echo ($pension_employee_contribution);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            //calculate user deductions
                                            $deductions = \App\Models\UserDeduction::where('user_id', $user->id)->where('table', $user->table)->get();
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
                                                            'created_by' => session('id'),
                                                            'created_by_table' => session('table')
                                                        ]);
                                                    }
                                                }
                                            }
                                            $total_deductions = (int) $special == 0 ? $total_deductions : 0;
                                            $sum_of_total_deductions += $total_deductions;
                                            echo ($total_deductions);
                                            ?> 
                                        </td>
                                        <td>
                                            <?php
                                            //calculate user taxable amount
                                            $taxable_amount = $gross_pay - $pension_employee_contribution - $non_taxable_allowances;

                                            $total_taxable_amount += $taxable_amount;
                                            echo ($taxable_amount);
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
                                            echo ($paye);
                                            ?> 
                                        </td>
                                        <td>
                                            <?php
                                            //$net_pay = $gross_pay - $pension_employee_contribution - $total_deductions - $paye ; //all the same
                                            $net_pay = $basic_salary + $taxable_allowances - $pension_employee_contribution - $total_deductions - $paye + $non_taxable_allowances;

                                            $total_net_pay += $net_pay;
                                            echo ($net_pay);
                                            ?>
                                        </td>
                                       <!-- <td>
                                            <a href="<?= url('payroll/payslip/null/?id=' . $user->id . '&table=' . $user->table . '&month=' . date('m')) ?>" class="btn btn-success btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Show Payslip"><i class="fa fa-file"></i>Preview</a> 
                                        </td> -->
                                    </tr>

                                    <?php
                                    if ($create == 1) {
                                        $check_data = array('user_id' => $user->id,
                                            'table' => $user->table, 'payment_date' => date('Y-M-d', strtotime(request('payroll_date'))));
                                        $check = \DB::table('salaries')->where($check_data)->first();
                                        if (empty($check)) {
                                            $salary_id = \DB::table('salaries')->insertGetId(array(
                                                'user_id' => $user->id,
                                                'table' => $user->table,
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
                                        } else {
                                            $salary_id = $check->id;
                                        }
                                        if (request('send_sms_email') == 1) {
                                            $sms_body = request('message_body');
                                            $patterns = array(
                                                '/#name/i', '/#net_payment/i', '/#salary_date/i'
                                            );
                                            $replacements = array(
                                                $user->name, $siteinfos->currency_symbol . '' . $net_pay . '/=', date('Y-M-d', strtotime(request('payroll_date')))
                                            );


                                            $sms = preg_replace($patterns, $replacements, $sms_body);
                                            \DB::table('sms')->insert(['body' => $sms, 'user_id' => $user->id, 'phone_number' => $user->phone, 'table' => $user->table]);
                                            \DB::table('email')->insert(['body' => $sms, 'subject' => ' Salary for ' . date('Y-M-d', strtotime(request('payroll_date'))), 'user_id' => $user->id, 'email' => $user->email, 'table' => $user->table]);
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
                                                            'created_by' => '{' . session('id') . ',' . session('table') . '}'
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
                                                            'created_by' => '{' . session('id') . ',' . session('table') . '}'
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
                                                            'created_by' => '{' . session('id') . ',' . session('table') . '}'
                                                        ));
                                                    } else {
                                                        $check_eded->update(['employer_amount' => $key]);
                                                    }
                                                }
                                            }
                                        }

                                        //total deductions which are expense to schools
                                        $totals = \DB::select('select sum(employer_amount) as employer_amount, name, expense_id from (
select a.employer_amount, b.name, c.id as expense_id from salary_deductions a join deductions b on a.deduction_id=b.id join refer_expense c on b.name=c.name where a.salary_id=' . $salary_id . ' and a.employer_amount is not null and a.employer_amount >0 group by a.employer_amount,b.name,c.id ) b group by name,expense_id');
$bank_account = \App\Model\BankAccount::where('id','>',0 )->first();
                                        foreach ($totals as $total) {
                                            $array = array(
                                                "create_date" => date("Y-m-d"),
                                                "date" => date('Y-m-d', strtotime(request('payroll_date'))),
                                                "amount" => $total->employer_amount,
                                                "note" => 'Payroll ',
                                                "ref_no" => date('Ymd'),
                                                "payment_method" => 'bank',
                                                "refer_expense_id" => $total->expense_id,
                                                "expenseyear" => date("Y"),
                                                "expense" => $total->name,
                                                "depreciation" => 0,
                                                "payment_type_id"=>3,
                                                "bank_account_id"=>$bank_account->id,
                                                'userID' => session('id'),
                                                'uname' => session('username'),
                                                'usertype' => session('usertype'),
                                                'created_by' => '{' . session('id') . ',' . session('table') . '}'
                                            );
                                            \DB::table('expense')->insert($array);
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
                                                        'created_by' => '{' . session('id') . ',' . session('table') . '}'
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
                    <div class="col-sm-12">

                    </div>
                    <?php if ($create == 0) { ?>

                        <div class='form-group center' >

                            <label for="title" class="col-sm-1 control-label">
                                Payroll Date
                            </label>
                            <div class="col-sm-6">
                                <input class="form-control calendar" required="" name="payroll_date" value="<?= old('date') ?>" >
                            </div>
                            <span class="col-sm-6 control-label">
                                <?php echo form_error($errors, 'email_sms'); ?>
                            </span>
                        </div>
                        <div class='form-group center' >

                            <label for="email_sms" class="col-sm-1 control-label">
                                Notify users By SMS & Emails
                            </label>
                            <div class="col-sm-2">
                                <input type="checkbox" id="check_message_to_send" onclick="$('#message_to_send').toggle()" class="form-control" name="send_sms_email" value="1" >
                            </div>
                            <div class="col-sm-4">
                                <textarea style="display:none" id="message_to_send" class="form-control" name="message_body">Hello #name Salary for this #salary_date has been issued. Your Net payment amount is #net_payment. For More information, login into your account</textarea>
                            </div>
                            <span class="col-sm-6 control-label">
                                <?php echo form_error($errors, 'email_sms'); ?>
                            </span>
                        </div>
                        <div class='form-group center' >

                            <label for="title" class="col-sm-1 control-label">

                            </label>
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
                            "create_date" => date("Y-m-d"),
                            "date" => date('Y-m-d', strtotime(request('payroll_date'))),
                            "amount" => $total_gross_pay,
                            "note" => 'Payroll ',
                            "ref_no" => date('Ymd'),
                            "payment_method" => 'bank',
                            "refer_expense_id" => $refer_expense_id,
                            "expenseyear" => date("Y"),
                            "expense" => 'Payroll',
                            "depreciation" => 0,
                            "payment_type_id"=>3,
                            'bank_account_id'=>$bank_account->id,
                            'userID' => session('id'),
                            'uname' => session('username'),
                            'usertype' => session('usertype'),
                            'created_by' => '{' . session('id') . ',' . session('table') . '}'
                        );
                        $insert_id = \DB::table('expense')->insertGetId($array, "expenseID");

                        //specify all expenses accomplished by 
                        ?>
                        <script type="text/javascript">window.location.href = '<?= url('payroll/index') ?>';</script>     
                    <?php } ?>
                    <?= csrf_field() ?>
                </form>
            </div> <!-- col-sm-8 -->

        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->
<script>
    function save(a, b, column, table) {
        var val = $('#' + a).text();
        if (val !== '') {
            $.ajax({
                type: 'POST',
                url: "<?= url('profile/editProfile/null') ?>",
                data: {"id": b, newvalue: val, column: column, table: table},
                dataType: "html",
                beforeSend: function (xhr) {
                    $('#stat' + a).html('<a href="#/refresh"<i class="fa fa-spinner"></i> </a>');
                },
                complete: function (xhr, status) {
                    $('#stat' + a).html('<span class="label label-success">' + status + '</span>');
                },
                success: function (data) {
                    toast(data);
                }
            });
        }
    }

</script>
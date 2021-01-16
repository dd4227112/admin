
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-subject"></i> <?= __('panel_title') ?></h3>

        <ol class="breadcrumb">
            <li><a href="<?= url("dashboard/index") ?>"><i
                        class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
            <li><a href="<?= url("payroll/index") ?>"><?= __('menu_payroll') ?></a></li>
            <li class="active"><?= __('menu_add') ?> <?= __('menu_payroll') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <span class="section"><?= $set ?> Monthly Payroll </span> 
        <!--<p> Fields marked <span class="red">*</span> are mandatory</p>-->
        <div class="row">
            <div class="col-sm-12">
                <div id="hide-table" class="table-responsive" >
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-sm-1"><?= __('slno') ?></th>
                                <th class="col-sm-2"><?= __('employee_name') ?></th>

                                <th class="col-sm-1"><?= __('basic_pay') ?></th>
                                <th class="col-sm-1">Bank</th>
                                <th class="col-sm-2"><?= __('bank_account') ?></th>

                                <th class="col-sm-1"><?= __('allowance') ?></th>
                                <th class="col-sm-1"><?= __('gross_pay') ?></th>
                                <th class="col-sm-1"><?= __('pension') ?></th>
                                <th class="col-sm-1"><?= __('deduction') ?></th>
                                <th class="col-sm-1"><?= __('taxable_amount') ?></th>
                                <th class="col-sm-1"><?= __('paye') ?></th>
                                <th class="col-sm-1"><?= __('net_pay') ?></th>
                                 <th class="col-sm-1"><?= __('date') ?></th>

                                <?php
                                if (can_access('manage_payroll')) {
                                    ?>
                                    <th class="col-sm-4"><?= __('action') ?></th>
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
                            $total_net_pay = 0;
                            foreach ($salaries as $salary) {
                                $basic_salary = $salary->basic_pay;
                                $total_basic_pay += $basic_salary;
                                $user = \App\Model\User::where('id', $salary->user_id)->where('table', $salary->table)->first();
                                if (!empty($user)) {
                                    $name = $user->name;
                                    $id = $user->id;
                                } else {
      $table=$salary->table=='student' ? 'student_id': $salary->table.'ID';
                                    $us = \DB::table($salary->table)->where($table, $salary->user_id)->first();
                                    if (empty($us)) {
                                        $name = 'Deleted User';
                                        $id = 'removed';
                                    } else {
                                        $name = $us->name;
                                        $id = $us->id_number;
                                    }
                                }
                                $user_info_bank = \App\Model\User::where('table', $salary->table)->where('id', $salary->user_id)->first();
                                if (!empty($user_info_bank)) {
                                    $bank = $user_info_bank->userInfo(DB::table($salary->table));
                                    $bank_name = $bank->bank_name;
                                    $bank_account = $bank->bank_account_number;
                                } else {
                                    $bank_name = '';
                                    $bank_account = '';
                                }
                                ?>
                                <tr>
                                    <td  data-title="<?= __('slno') ?>"><?= $i ?></td>
                                    <td  data-title="<?= __('employee_name') ?>"><?= $name ?></td>
                                    <td  data-title="<?= __('basic_pay') ?>"><?= $basic_salary ?></td>
                                    <td  data-title="<?= __('Bank') ?>"><?= $bank_name == '' ? 'null' : $bank_name ?></td>
                                    <td  data-title="<?= __('bank_account') ?>"><?= $bank_account == '' ? 'null' : $bank_account ?></td>
                                    <td  data-title="<?= __('allowance') ?>">
                                        <?php
                                        //calculate user allowances

                                        echo money($salary->allowance);
                                        $sum_of_total_allowances += $salary->allowance;
                                        ?>
                                    </td>
                                    <td  data-title="<?= __('gross_pay') ?>">
                                        <?php
                                        $gross_pay = $basic_salary + $salary->allowance;
                                        echo money($gross_pay);
                                        $total_gross_pay += $gross_pay;
                                        ?> 
                                    </td>
                                    <td  data-title="<?= __('pension') ?>">  
                                        <?php
                                        //calculate user pension amount

                                        echo money($salary->pension_fund);
                                        $total_pension += $salary->pension_fund;
                                        ?>
                                    </td>
                                    <td  data-title="<?= __('deduction') ?>">
                                        <?php
                                        //calculate user deductions

                                        echo money($salary->deduction);
                                        $sum_of_total_deductions += $salary->deduction;
                                        ?> 
                                    </td>
                                    <td  data-title="<?= __('taxable_amount') ?>"> 
                                        <?php
                                        //calculate user taxable amount
                                        $taxable_amount = $gross_pay - $salary->pension_fund;
                                        echo money($taxable_amount);
                                        $total_taxable_amount += $taxable_amount;
                                        ?>  
                                    </td>
                                    <td  data-title="<?= __('paye') ?>">
                                        <?php
                                        //calculate PAYEE

                                        echo money($salary->paye);
                                        $total_paye += $salary->paye;
                                        ?> 
                                    </td>
                                    <td  data-title="<?= __('net_pay') ?>">
                                        <?php
                                        $net_pay = $gross_pay - $salary->pension_fund - $salary->deduction - $salary->paye;
                                        echo money($net_pay);
                                        $total_net_pay += $net_pay;
                                        ?>
                                    </td>
                                    <td  data-title="<?= __('date') ?>">
                                        <?= $set ?> 
                                    </td>
                                    <td  data-title="<?= __('action') ?>">
                                        <a href="<?= url('payroll/payslip/null/?id=' . $salary->user_id . '&table=' . $salary->table . '&month=' . date('m') . '&set=' . $set) ?>" class="btn btn-success btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Show Payslip"><i class="fa fa-file"></i>Preview</a>
                                    </td>                 
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td  data-title="<?= __('total') ?>">Total</td>
                                <td  data-title=""></td>
                                <td  data-title="<?= __('basic_pay') ?>"><?= money($total_basic_pay) ?></td>
                                <td  data-title=""></td>
                                <td data-title=""></td>
                                <td data-title="<?= __('allowances') ?>"><?= money($sum_of_total_allowances) ?></td>
                                <td data-title="<?= __('gross_pay') ?>"><?= money($total_gross_pay) ?></td>
                                <td data-title="<?= __('pension') ?>"><?= money($total_pension) ?></td>
                                <td data-title="<?= __('deduction') ?>"><?= money($sum_of_total_deductions) ?></td>
                                <td data-title="<?= __('slno') ?>"><?= money($total_taxable_amount) ?></td>
                                <td data-title="<?= __('taxable_amount') ?>"><?= money($total_paye) ?></td>
                                <td data-title="<?= __('net_pay') ?>"><?= money($total_net_pay) ?></td>
                                <td></td>
                                <td data-title="<?= __('action') ?>"> <a href="<?= url('payroll/summary/null/?set=' . $set . '&month=' . date('M') . '&month=' . date('m')) . '&' . http_build_query(array('basic_pay' => $total_basic_pay, 'allowance' => $sum_of_total_allowances, 'gross_pay' => $total_gross_pay, 'pension' => $total_pension, 'deduction' => $sum_of_total_deductions, 'tax' => $total_taxable_amount, 'paye' => $total_paye, 'net_pay' => $total_net_pay)) ?>" class="btn btn-success btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Show Payslip"><i class="fa fa-file"></i>Summary</a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
              
            </div> <!-- col-sm-8 -->

        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->
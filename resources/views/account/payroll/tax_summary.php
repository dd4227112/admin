
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
        <span class="section">Tax Paye Summary of <?= $set ?> </span> 
        <!--<p> Fields marked <span class="red">*</span> are mandatory</p>-->
        <div class="row">
            <div class="col-sm-12">
                <div id="hide-table" class="table-responsive" >
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-sm-1"><?= __('slno') ?></th>
                                <th class="col-sm-2"><?= __('employee_name') ?></th>

                                <th class="col-sm-2"><?= __('gross_pay') ?></th>
                                <th class="col-sm-1"><?= __('pension') ?></th>
                                <th class="col-sm-2"><?= __('taxable_amount') ?></th>
                                <th class="col-sm-2"><?= __('paye') ?></th>

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
                                
                                ?>
                                <tr>
                                    <td  data-title="<?= __('slno') ?>"><?= $i ?></td>
                                    <td  data-title="<?= __('employee_name') ?>"><?= $name ?></td>
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
                                <td data-title="<?= __('gross_pay') ?>"><?= money($total_gross_pay) ?></td>
                                <td data-title="<?= __('pension') ?>"><?= money($total_pension) ?></td>
                                <td data-title="<?= __('slno') ?>"><?= money($total_taxable_amount) ?></td>
                                <td data-title="<?= __('taxable_amount') ?>"><?= money($total_paye) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
              
            </div> <!-- col-sm-8 -->

        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->
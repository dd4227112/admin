
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
        <span class="section">Summary Form</span> 
<!--        <p align="right"><a class="buttons-print btn btn-success" tabindex="0" aria-controls="example1" href="#"><span>Full Export</span></a></p>-->
        <div class="row">
            <div class="col-sm-12">

                <div class="col-sm-12">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">

                        <thead>

                            <tr>
                                <th  rowspan="2" class="col-sm-1"><?= __('slno') ?></th>
                                <th  rowspan="2" class="col-sm-2">Name</th>
                                <th rowspan="2" class="col-sm-1">Basic Salary</th>
                                <th rowspan="2" class="col-sm-1">Gross Salary</th>
                                <th colspan="<?= count($deductions) ?>" class="text-center">Employer Deductions</th>
                                <th rowspan="2">Total Deductions</th>
                            </tr>
                            <tr>
                                <?php
                                $total_ded[] = 0;
                                $deductions_ids=[];
                                foreach ($deductions as $deduction) {
                                    $total_ded[$deduction->id] = 0;
                                    array_push($deductions_ids, $deduction->id);
                                    ?>
                                    <th><?= $deduction->name ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $total_basic_pay = 0;
                            $total_gross_pay = 0;
                            $ded_sum [] = 0;

                            foreach ($users as $salary) {
                                $ded_sum[$salary->user->id] = 0;
                                $amount = \App\Model\SalaryDeduction::where('salary_id', $salary->id)->where('deduction_id', $deductions_ids)->sum('amount')+\App\Model\SalaryDeduction::where('salary_id', $salary->id)->where('deduction_id', $deductions_ids)->sum('employer_amount');
                                if ((float) $amount > 0) {
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= strtoupper($salary->user->name) ?></td>
                                        <td>
                                            <?php
                                            echo money($salary->basic_pay);
                                            $total_basic_pay += $salary->basic_pay;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo money($salary->gross_pay);
                                            $total_gross_pay += $salary->gross_pay;
                                            ?>
                                        </td>
                                        <?php
                                        $dedd = [];
                                        foreach ($deductions as $deduction) {
                                            $dedd[$salary->user->id][$deduction->id] = $deduction->salaryDeductions->where('salary_id', $salary->id)->sum('amount')+$deduction->salaryDeductions->where('salary_id', $salary->id)->sum('employer_amount');
                                            $ded_sum[$salary->user->id] += $dedd[$salary->user->id][$deduction->id];
                                            $total_ded[$deduction->id] += $dedd[$salary->user->id][$deduction->id];
                                            ?>
                                            <td><?= money($dedd[$salary->user->id][$deduction->id]) ?></td>
                                        <?php } ?>

                                        <td><?= money($ded_sum[$salary->user->id]) ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td></td>
                                <td><?= money($total_basic_pay) ?></td>
                                <td><?= money($total_gross_pay) ?></td>
                                <?php
                                $all_ded_sum = 0;
                                foreach ($deductions as $deduction) {
                                    $all_ded_sum += $total_ded[$deduction->id];
                                    ?>
                                    <td><?= money($total_ded[$deduction->id]) ?></td>
                                <?php } ?>
                                <td><?= money($all_ded_sum) ?></td>

                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php ?>

                <div class="col-sm-12">

                </div>


            </div> <!-- col-sm-8 -->

        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->

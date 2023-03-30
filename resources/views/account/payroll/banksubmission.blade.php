
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-subject"></i> Bank Submission Form</h3>

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
        <div class="col-sm-6 col-sm-offset-3 list-group">

            <div class="list-group-item list-group-item-warning">
                <form style="" class="form-horizontal" role="form" method="post">
                    <div class='form-group' >
                        <label for="class_level_id" class="col-sm-2 control-label">
                            Select Option*
                        </label>
                        <div class="col-sm-6 col-xs-12">
                            <select class="form-control col-sm-12" id="skip">
                                <option value="all" <?= request('skip') == 'all' ? 'selected' : '' ?>>All</option>
                                <option value="<?= $skip ?>" <?= request('skip') == '1' ? 'selected' : '' ?>>Skip Deductions, PAYE and PENSION</option>
                                <option value="bank" <?= request('skip') == 'bank' ? 'selected' : '' ?>>Sort By Bank</option>
                                <option value="deduction" <?= request('skip') == 'deduction' ? 'selected' : '' ?>>Show Deductions Only</option>
                            </select>
                        </div>
                        <span class="col-sm-4 col-xs-12 control-label">
                            <?php echo form_error($errors, 'classlevel'); ?>
                        </span>
                    </div>

                    <?= csrf_field() ?>
                </form>
            </div>


        </div>
        <script>
            skip = function () {
                $('#skip').change(function () {
                    var id = $(this).val();
                    window.location.href = '<?= url()->current() ?>?set=<?= $set ?>&month=<?= $month ?>&skip=' + id;
                });
            }
            $(document).ready(skip);
        </script>

<!--        <p> Bank Submission Form For Each Employee and Summation of Deductions to be Submitted to a respective bank</p>
        <p><input type="checkbox" value="1" onclick="window.location.href = '<?= url()->current() ?>?set=<?= $set ?>&month=<?= $month ?>&skip=<?= $skip ?>'" id="skip_deductions" <?= (int) $skip == 0 ? 'checked' : '' ?>> Skip Deductions, PAYE and PENSION</p>-->
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <div id="hide-table" class="table-responsive" >
                    <?php if (request('skip') <> 'bank') { ?>
                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="col-sm-1"><?= __('slno') ?></th>
                                    <th class="col-sm-2"><?= __('employee_name') ?></th>

                                    <th class="col-sm-1">Bank</th>
                                    <th class="col-sm-2"><?= __('bank_account') ?></th>


                                    <th class="col-sm-1"><?= __('net_pay') ?></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $total_basic_pay = 0;
                                $total_gross_pay = 0;

                                $sum_of_total_deductions = 0;
                                $total_paye = 0;
                                $total_taxable_amount = 0;
                                $total_net_pay = 0;
                                if (request('skip') <> 'deduction') {
                                    foreach ($salaries as $salary) {
                                        $basic_salary = $salary->basic_pay;
                                        $total_basic_pay += $basic_salary;
                                        $user = \App\Model\User::where('id', $salary->user_id)->where('table', $salary->table)->first();
                                        if (!empty($user)) {
                                            $name = $user->name;
                                            $id = $user->id;
                                        } else {
                                            $table = $salary->table == 'student' ? 'student_id' : $salary->table . 'ID';
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

                                            <td  data-title="<?= __('Bank') ?>"><?= $bank_name == '' ? 'null' : $bank_name ?></td>
                                            <td  data-title="<?= __('bank_account') ?>"><?= $bank_account == '' ? 'null' : $bank_account ?></td>



                                            <td  data-title="<?= __('net_pay') ?>">
                                                <?php
                                                $net_pay = $salary->basic_pay + $salary->allowance - $salary->pension_fund - $salary->deduction - $salary->paye;
                                                echo money($net_pay);
                                                $total_net_pay += $net_pay;
                                                ?>
                                            </td>

                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                                <?php
                                $total_deductions = 0;
                                $total_pensions = 0;
                                $payee = 0;
                                $x = $i;
                                if (!empty($deductions)  && (int) $skip == 1) {


                                    foreach ($deductions as $ded) {
                                        $total_deductions += $ded->sum+ $ded->employer_amount;
                                        ?>
                                        <tr>
                                            <th scope="row"><?= $x ?></th>
                                            <td><?= $ded->name ?></td>
                                            <td><?= $ded->bank_name ?> </td>
                                            <td><?= $ded->account_number ?> </td>
                                            <td><?= money($ded->sum+ $ded->employer_amount) ?></td>
                                        </tr>
                                        <?php
                                        $x++;
                                    }
                                }
                                if ((int) $skip == 1) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $x ?></th>
                                        <td>PAYE</td>
                                        <td> </td>
                                        <td> </td>
                                        <?php
                                        $payee = \App\Model\Salary::where('payment_date', $set)->sum('paye');
                                        ?>
                                        <td><?= money($payee) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= $x + 1 ?></th>
                                        <td>Pension</td>
                                        <td> </td>
                                        <td> </td>
                                        <?php
                                        $pension = \collect(DB::select('select sum(a.employer_amount) as employer_contribution, sum(a.amount) as employee_contribution from ' . set_schema_name() . 'salary_pensions a join constant.pensions b on b.id=a.pension_id  where salary_id IN (SELECT id FROM ' . set_schema_name() . 'salaries where payment_date=\'' . $set . '\')'))->first();
                                        $total_pensions = $pension->employer_contribution + $pension->employee_contribution;
                                        ?>
                                        <td><?= money($total_pensions) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td  data-title="<?= __('total') ?>">Total</td>
                                    <td  data-title=""></td>

                                    <td  data-title=""></td>
                                    <td data-title=""></td>




                                    <td data-title="<?= __('net_pay') ?>"><?= money($total_net_pay + $total_deductions + $payee + $total_pensions) ?></td>

                                </tr>
                            </tfoot>
                        </table>
                    <?php
                    } else {
                        $banks = \DB::select('select distinct bank_name from user,teacher');
                        foreach ($banks as $bank_info) {
                            echo '<h1 class="section alert"><b>' . $bank_info->bank_name . '</b></h1><br/>';
                            ?>
                            <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th class="col-sm-1"><?= __('slno') ?></th>
                                        <th class="col-sm-2"><?= __('employee_name') ?></th>

                                        <th class="col-sm-1">Bank</th>
                                        <th class="col-sm-2"><?= __('bank_account') ?></th>


                                        <th class="col-sm-1"><?= __('net_pay') ?></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $total_basic_pay = 0;
                                    $total_gross_pay = 0;

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
                                            $table = $salary->table == 'student' ? 'student_id' : $salary->table . 'ID';
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
                                        if ($bank_name ==$bank_info->bank_name) {
                                            ?>
                                            <tr>
                                                <td  data-title="<?= __('slno') ?>"><?= $i ?></td>
                                                <td  data-title="<?= __('employee_name') ?>"><?= $name ?></td>

                                                <td  data-title="<?= __('Bank') ?>"><?= $bank_name == '' ? 'null' : $bank_name ?></td>
                                                <td  data-title="<?= __('bank_account') ?>"><?= $bank_account == '' ? 'null' : $bank_account ?></td>



                                                <td  data-title="<?= __('net_pay') ?>">
                                                    <?php
                                                    $net_pay = $salary->basic_pay + $salary->allowance - $salary->pension_fund - $salary->deduction - $salary->paye;
                                                    echo money($net_pay);
                                                    $total_net_pay += $net_pay;
                                                    ?>
                                                </td>

                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                    <?php
                                    $total_deductions = 0;
                                    $total_pensions = 0;
                                    $payee = 0;
                                    $x = $i;
                            
                                        ?>
                                       

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td  data-title="<?= __('total') ?>">Total</td>
                                        <td  data-title=""></td>

                                        <td  data-title=""></td>
                                        <td data-title=""></td>




                                        <td data-title="<?= __('net_pay') ?>"><?= money($total_net_pay + $total_deductions + $payee + $total_pensions) ?></td>

                                    </tr>
                                </tfoot>
                            </table>  
                        <?php }
                        ?>

<?php } ?>
                </div>

            </div> <!-- col-sm-8 -->

        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->
<script type="text/javascript">
  
</script>
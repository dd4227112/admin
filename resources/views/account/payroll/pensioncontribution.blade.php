
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-subject"></i> <?= __('panel_title') ?></h3>

        <ol class="breadcrumb">
            <li><a href="<?= url("dashboard/index") ?>"><i
                        class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
            <li><a href="<?= url("subject/index") ?>"><?= __('menu_subject') ?></a></li>
            <li class="active"><?= __('menu_add') ?> <?= __('menu_subject') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <span class="section">Pension Contribution </span> 
<!--        <p align="right"><a class="buttons-print btn btn-success" tabindex="0" aria-controls="example1" href="#"><span>Full Export</span></a></p>-->
        <div class="row">
            <div class="col-sm-12">
                <?php ob_start(); ?>
                <div class="col-sm-12">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">

                        <thead>
                            <tr>
                                <th colspan="9">
                                    <div class="col-sm-4 invoice-col">
                                        <address>
                                            <strong>Director General</strong>
                                            <br/><strong><?= $pension->name ?></strong>
                                            <br><?= $pension->address ?>

                                        </address>
                                    </div>

                                    <div class="text-right">
                                        <b>Cheque No: #007612</b>
                                        <br>                      
                                        <br>
                                        <b>Date of Cheque:</b> 2/22/2014
                                        <br>
                                        <b>Account:</b> 968-34567
                                    </div>
                                </th>

                            </tr>
                            <tr>
                                <th  rowspan="2" class="col-sm-1"><?= __('slno') ?></th>
                                <th  rowspan="2" class="col-sm-2">Membership Number</th>
                                <th  rowspan="2" class="col-sm-2">Name</th>
                                <th rowspan="2" class="col-sm-1">Monthly Salary</th>
                                <th colspan="2">Members Contribution</th>
                                <th colspan="2">Employer Contribution</th>
                                <th rowspan="2">Total Contribution</th>
                            </tr>
                            <tr>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Rate</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;

                            $total_basic_pay = 0;
                            $employeee_amount = 0;
                            $employeer_amount = 0;
                            $total_pension_contribution = 0;
                            foreach ($pensions as $pension) {
                                $total_contribution = $pension->amount + $pension->employer_amount;
                                $total_pension_contribution += $total_contribution;
                                $user=\App\Model\UserPension::where('pension_id', $pension->pension_id)->where('user_id', $pension->salary->user->id)->where('table', $pension->salary->user->table)->first();
                                if ($pension->salary->user->status == 1 && !empty($user)) {
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?php
                                   
                                            echo $user->checknumber
                                            ?></td>
                                        <td><?= strtoupper($pension->salary->user->name) ?></td>
                                        <td>
                                            <?php
                                            echo $pension->salary->basic_pay;
                                            $total_basic_pay += $pension->salary->basic_pay;
                                            ?>
                                        </td>
                                        <td><?= $pension->pension->employee_percentage ?></td>
                                        <td>
                                            <?php
                                            echo $pension->amount;
                                            $employeee_amount += $pension->amount
                                            ?>
                                        </td>
                                        <td><?= $pension->pension->employer_percentage ?></td>
                                        <td><?php
                                            echo $pension->employer_amount;
                                            $employeer_amount += $pension->employer_amount;
                                            ?></td>
                                        <td><?= $total_contribution ?></td>
                                    </tr>
                                    <?php
                                }
                                $i++;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td></td>
                                <td></td>
                                <td><?= $total_basic_pay ?></td>
                                <td></td>
                                <td><?= $employeee_amount ?></td>
                                <td></td>
                                <td><?= $employeer_amount ?></td>

                                <td><?= $total_pension_contribution ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3">
                                    <p>Remittance</p>
                                    <div>
                                        Employer's Signature <span></span>
                                    </div>
                                </td>
                                <td></td>
                                <td colspan="3">
                                    <p>&nbsp;</p>
                                    <div>Contribution For Date: <b style="text-decoration:underline"> <?= request('set') ?> </b></div>
                                </td>

                                <td></td>

                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php
                $table = ob_get_clean();
                echo $table;
//                if (request('export_all' == 1)) {
//                    $myfile = 'pension.xls';
//                    $handle = fopen($myfile, 'wr+');
//                    $handler = fwrite($handle, $table);
//                    fclose($handle);
//                    header("Location: " . url(url('/')) . '/' . $myfile);
//                }
                ?>

                <div class="col-sm-12">

                </div>


            </div> <!-- col-sm-8 -->

        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->

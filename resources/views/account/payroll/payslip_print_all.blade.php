<?php
ini_set('max_execution_time', 360);
/**
 * Description of print_combined
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<?php
$payslip_settings = \DB::table('payslip_settings')->first();
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <title>payslip</title>
        <script type="text/javascript" src="<?php echo url('public/assets/shulesoft/jquery.js'); ?>"></script>
        <link href="<?php echo url('public/assets/css/print_all/certificate.css'); ?>" rel="stylesheet" type="text/css" async>


        <link href="<?php echo url('public/assets/bootstrap/3.3.2/bootstrap.min.css'); ?>" rel="stylesheet">


        <link rel="stylesheet" href="<?= url("public/assets/css/documenter_style.css") ?>">


        <style type="text/css">
            .page{
                border: 1px solid #ccc;
            }
            .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
                border: 0;
                border-bottom: 1px solid #ccc;
            }
            table.table.table-striped td, table.table.table-striped th, table.table {
                font-size: 12px !important;
                margin-left: 10%;
            }
            table{

            }

            @font-face {
                font-family: DejaVuSans_b;
                src: url("../../public/assets/fonts/DejaVuSans_b.woff") format("woff");
            }

            table.table.table-striped td, table.table.table-striped th, table.table {
                margin: 1px auto !important;
            }

            @media print {


                #wrappers{
                    page-break-before: always;
                }

            }

        </style>

    </head>
    <body onload="window.print()">
        <?php
        foreach ($salaries as $salary) {
            if(isset($salary->user->table)){
            ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel page" id="wrappers" style="overflow:hidden;  height: 255mm;  border: 1px solid white; margin: 10mm auto; line-break: auto; font-size: 100%; ">

                        <div class="x_content">

                            <section class="content invoice">

                                <!-- title row -->
                                <div class="row">
                                    <div class="col-xs-12 invoice-header">
                                        <h1 style="text-align:center; font-size: 29px;">
                                            PAYSLIP
                                            <br/>
                                        </h1>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div style="height:1em"></div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                <table class="table">
                                        <thead>
                                            <tr>
                                                <th  class="col-lg-4" style="max-width:30%">
                                                    <?php
                                                    $array = array(
                                                        "src" => url('storage/uploads/images/'),
                                                        'width' => '82em',
                                                        'height' => '82em',
                                                        'class' => 'img-rounded',
                                                        'style' => 'margin-left:2em'
                                                    );
                                                    $user_info = $salary->user->userInfo(\DB::table($salary->user));
                                                    ?>
                                                        {{-- <?= img($array) ?> --}}
                                                    </th>
                                                    <th style="padding-left:3em;">
                                                    <?php if ((int) $payslip_settings->show_address == 1) { ?>
                                                    <address style="margin-left:1em">

                                                        <br/>
                                                            <br>Address: <?= $user->address; ?>
                                                            <br>Phone: <?= $user->phone; ?>
                                                            <br>Email: <?= $user->email; ?>
                                                    </address>
                                                    <?php } ?>
                                                    </th>
                                                <th  class="col-lg-4" style="max-width:30%">
                                                    <b>Name: </b><?= $salary->user->name ?><br>
                                                    <b>ID No: </b> <?php
                                                    echo $user_info->id_number
                                                    ?>

                                                    <br>
                                                    <b>Payment Date:</b> <?= $salary->payment_date ?>
                                                    <br>
                                                    <b>Bank Name:</b> <?= $user_info->bank_name ?>
                                                    <br>
                                                    <b>Bank Account No:</b> <?= $user_info->bank_account_number ?></th>
                                            </tr>
                                        </thead>
                                    </table>

                                </div>
                                <!-- /.row -->
                                <br/>
                                <br/>
                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-xs-12 table">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th style="width: 59%">Description</th>
                                                    <th align='center' class="text-center">Amount (<?= $siteinfos->currency_symbol ?>)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>

                                                    <td>1</td>
                                                    <td>Basic Salary</td>
                                                    <td align='center'><?php
                                                $basic_salary = $user_info->salary;
                                                echo money($basic_salary);
                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>
                                                        <b>Allowance</b>
                                                        <div class="x_content col-lg-offset-1">
                                                            <table style=" width: 80%" class="table table-responsive description">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Total </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>


                                                                    <?php
                                                                    //calculate user allowances
                                                                    $allowances = \App\Models\SalaryAllowance::where('salary_id', $salary->id)->get();
                                                                    $total_allowance = 0;
                                                                    if (!empty($allowances)) {
                                                                        foreach ($allowances as $value) {
                                                                            $t_allowance = $value->allowance->is_percentage == 1 ? $basic_salary * $value->allowance->percent / 100 : $value->allowance->amount;
                                                                            echo '<tr>';
                                                                            $total_allowance += $t_allowance;
                                                                            echo '<td>' . $value->allowance->name . '</td>';
                                                                            echo '<td>' . money($t_allowance) . '</td>';
                                                                            echo '</tr>';
                                                                        }
                                                                    }
                                                                    ?> 
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </td>
                                                    <td align='center' style="padding-top: 3%"><?= money($total_allowance) ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">GROSS PAY</td>
                                                    <td align='center'> <?php
                                                                $gross_pay = $basic_salary + $total_allowance;
                                                                echo money($gross_pay);
                                                                    ?> </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <?php
                                                    $pension = \App\Models\SalaryPension::where('salary_id', $salary->id)->first();
                                                    ?>
                                                    <td>Pension Fund (<?= !empty($pension)? $pension->pension->name : '' ?>)</td>
                                                    <td align='center'> <?php
                                                //calculate user pension amount

                                                if (!empty($pension)) {
                                                    $pension_employee_contribution = $pension->pension->employee_percentage * $basic_salary / 100;
                                                } else {
                                                    $pension_employee_contribution = 0;
                                                }
                                                echo money($pension_employee_contribution);
                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td><b>Deductions</b>
                                                        <div class="x_content col-lg-offset-1">
                                                            <table style=" width: 80%" class="table table-responsive description">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Total </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>


                                                                    <?php
                                                                    //calculate user deductions
                                                                    $deductions = \App\Models\SalaryDeduction::where('salary_id', $salary->id)->get();
                                                                    $total_deductions = 0;
                                                                    if (!empty($deductions)) {
                                                                        foreach ($deductions as $value) {
                                                                            if ($value->deduction->percent > 0 || $value->deduction->amount > 0) {
                                                                                $t_deduction = $value->deduction->is_percentage == 1 ? $basic_salary * $value->deduction->percent / 100 : $value->deduction->amount;
                                                                                $total_deductions += $t_deduction;
                                                                                echo '<tr>';
                                                                                echo '<td>' . $value->deduction->name . '</td>';
                                                                                echo '<td>' . money($t_deduction) . '</td>';
                                                                                echo '</tr>';
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div></td>

                                                    <td align='center'  style="padding-top: 3%"><?= money($total_deductions) ?></td>
                                                </tr>
                                                <tr>

                                                    <td colspan="2">TOTAL DEDUCTIONS</td>
                                                    <td align='center'><?= money($total_deductions + $pension_employee_contribution) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-xs-6">
                                        <p class="lead">Payment status: PROCESSED</p>


                                        <table>
                                            <tr>
                                                <td>
                                                    <?php if ($payslip_settings->show_employee_signature == 1) { ?>
                                                        <p> <?php if ($payslip_settings->show_employee_digital_signature == 1) { ?>....<img src="<?= $user_info->signature ?>" width="75" height="54"/> <?php
                                            } else {
                                                echo '<br/>';
                                            }
                                                        ?>.......</p>



                                                    <?php } ?>   
                                                </td>
                                                <td>                                    <?php
                                                    if ($payslip_settings->show_employer_signature == 1) {
                                                        $setting = \App\Models\Setting::first();
                                                        ?>

                                                        <p><?php if ($payslip_settings->show_employer_digital_signature == 1) { ?>.... <img src="<?= $setting->signature ?>" width="75" height="54"> <?php
                                                } else {
                                                    echo '<br/>';
                                                }
                                                        ?>......</p>
                                                        <?php } ?></td>
                                            </tr>
                                            <tr>
                                                <?php if ($payslip_settings->show_employee_signature == 1) { ?> <td>Employee Signature </td> <?php } ?>
                                                <?php if ($payslip_settings->show_employer_signature == 1) { ?> <td> Employer Signature</td> <?php } ?>
                                            </tr>
                                        </table>

                                    </div>
                                    <!-- /.col -->
                                    <div class="col-xs-6">
                                        <p class="lead">Summary</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <?php $paye = 0;
                                                    if ($payslip_settings->show_tax_summary == 1) {
                                                        ?>
                                                        <tr>
                                                            <th style="width:50%">Taxable Amount:</th>
                                                            <td><?php
                                                                //calculate user taxable amount
                                                                $taxable_amount = $gross_pay - $pension_employee_contribution;
                                                                echo money($taxable_amount);
                                                                ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>PAYE  <?php
                                                                //calculate PAYEE
                                                                $tax = \App\Models\Paye::where('from', '<=', $taxable_amount)->where('to', '>=', $taxable_amount)->first();
                                                                if (!empty($tax)) {
                                                                    echo '(' . $tax->tax_rate . '%)';
                                                                    if (!empty($tax)) {
                                                                        $paye = ($taxable_amount - $tax->from) * $tax->tax_rate / 100 + $tax->tax_plus_amount;
                                                                    } else {
                                                                        $paye = 0;
                                                                    }
                                                                } else {
                                                                    $paye = 0;
                                                                }
                                                                ?></th>
                                                            <td><?= money($paye) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php if ($payslip_settings->show_employer_contribution == 1) { ?>
                                                        <tr>
                                                            <th>Contributions:</th>
                                                            <td><?= money($pension_employee_contribution) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <th>NET PAY:</th>
                                                        <td><?= money($gross_pay - $pension_employee_contribution - $total_deductions - $paye) ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <br/>

                            </section>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Begin inline CSS -->


            <?php
        }
        }
        ?>
    </body>
</html>
 <!--<p align="center">Page rendered in <?php // (microtime(true) - LARAVEL_START)           ?> seconds.</p> -->

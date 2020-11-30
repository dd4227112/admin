<?php
$payslip_settings = \DB::table('payslip_settings')->first();
if (empty($payslip_settings)) {
    DB::select('insert into ' . set_schema_name() . 'payslip_settings (show_employee_signature,show_employer_signature,show_employee_digital_signature,show_employer_digital_signature) values (0,0,1,1)');
}
?>
<link href="<?php echo url('public/assets/print.css'); ?>?v=4" rel="stylesheet" type="text/css">



<style type="text/css">

    .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {

    }


    @font-face {
        font-family: DejaVuSans_b;
        src: url("../../public/assets/fonts/DejaVuSans_b.woff") format("woff");
    }


    @media print {




    }

</style>
<div class="well">
    <div class="row">
        <div class="col-sm-6">

            <button class="btn-cs btn-sm-cs" onclick="javascript:printDiv('printablediv')"><span
                    class="fa fa-print"></span> <?= __('print') ?> </button>
                <?php if (can_access('manage_payroll')) { ?>
                <a href="<?= url('payroll/payslipAll/null?action=all&set=' . $set) ?>"
                   target="_blank">
                    <i class="fa fa-print"></i><?= __('print') ?> Pint All</a>
            <?php } ?>
            <span>&nbsp;</span>


        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb">
                <li><a href="<?= url("dashboard/index") ?>"><i
                            class="fa fa-laptop"></i> Accounts</a></li>
                <li><a href="#">Payroll</a></li>
                <li class="active">Payslip</li>
                <?php if (can_access('manage_payroll')) { ?>
                    <button class="btn-default btn-cs btn-sm-cs" data-toggle="modal" data-target="#report_setting_model"><span class="fa fa-gear"></span> Options</button>
                <?php } ?>
            </ol>
        </div>
    </div>

</div>
<div style="overflow: auto" class="overflow" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
    <div id="printablediv" class="page center sheet padding-10mm" >
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">

                    <div class="x_content">

                        <section class="content invoice" id="">

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
                            <!-- info row -->
                            <div class="row invoice-info">


                                <!-- /.col -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="col-lg-4" style="max-width:30%">
                                                <?php
                                                $array = array(
                                                    "src" => url('storage/uploads/images/' . $siteinfos->photo),
                                                    'width' => '82em',
                                                    'height' => '82em',
                                                    'class' => 'img-rounded',
                                                    'style' => 'margin-left:2em'
                                                );
                                                ?>
                                    <?= img($array) ?>
                                    </th>
                                    <th style="padding-left:3em;">
                                    <?php if ((int) $payslip_settings->show_address == 1) { ?>
                                                <address style="margin-left:1em;     margin-left: 1em; font-size: 90%; max-width: 80%;">
                                                <br/>
                                                        <br>Address: <?= $user_info->address; ?>
                                                        <br>Phone: <?= $user_info->phone; ?>
                                                        <br>Email: <?= $user_info->email; ?>
                                                    <?php } ?>
                                                </address>
                                            </th>
                                            <th style=" font-size: 17px; font-size: 100%; max-width: 100%;">
                                                <b>Name: </b><?= $salary->user->name ?><br>
                                                <b>ID No: </b><?php 
                                                $bank_name='-';
                                                $bank_account='-';
                                               if(isset($salary->user->table)){
                                                $user_info = $salary->user->userInfo(DB::table($salary->user->table)); 
                                               $bank_name= $user_info->bank_name;
                                               $bank_account=$user_info->bank_account_number;
                                                 echo $user_info->id_number;
                                               }
                                               
                                                        
                                                ?>

                                                <br>
                                                <b>Payment Date:</b> <?= $salary->payment_date ?>
                                                <br>
                                                <b>Bank Name:</b> <?= $bank_name ?>
                                                <br>
                                                <b>Bank Account No:</b> <?= $bank_account ?>
                                                </th>
                                        </tr>
                                    </thead>
                                </table>
                                

                            </div>
                            <!-- /.row -->
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
                                                    $basic_salary = $salary->basic_pay;
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

                                                                $allowances = \App\Model\SalaryAllowance::where('salary_id', $salary->id)->get();

                                                                $total_allowance = 0;
                                                                if (!empty($allowances)) {
                                                                    foreach ($allowances as $value) {

                                                                        echo '<tr>';
                                                                        $total_allowance += $value->amount;

                                                                        $all_name = !empty($value->allowance) ? $value->allowance->name : '';
                                                                        echo '<td>' . $all_name . '</td>';
                                                                        echo '<td>' . money($value->amount) . '</td>';
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
                                                $pension = \App\Model\SalaryPension::where('salary_id', $salary->id)->first();
                                                ?>
                                                <td>Pension Fund (<?= !empty($pension) ? $pension->pension->name : '' ?>)</td>
                                                <td align='center'> <?php
                                                    //calculate user pension amount

                                                    if (!empty($pension)) {
                                                        $pension_employee_contribution = $pension->amount;
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
                                                                $deductions = \App\Model\SalaryDeduction::where('salary_id', $salary->id)->get();

                                                                $total_deductions = 0;
                                                                if (!empty($deductions)) {
                                                                    foreach ($deductions as $value) {
                                                                        if ($value->amount > 0) {
                                                                            $total_deductions += $value->amount;
                                                                            echo '<tr>';
                                                                            echo '<td>' . $value->deduction->name . '</td>';
                                                                            echo '<td>' . money($value->amount) . '</td>';
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
                                    <p class="lead">Payment status:</p>

                                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                        PROCESSED
                                    </p>
                                </div>
                                <!-- /.col -->
                                <div class="col-xs-6">
                                    <p class="lead">Summary</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <?php if ($payslip_settings->show_tax_summary == 1) { ?>
                                                    <tr>
                                                        <th style="width:50%">Taxable Amount:</th>
                                                        <td><?php
                                                            //calculate user taxable amount
                                                            $taxable_amount = $gross_pay - $pension_employee_contribution;
                                                            echo money($taxable_amount);
                                                            ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>PAYE</th>
                                                        <td><?= money($salary->paye) ?></td>
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
                                                    <td><?= money($salary->net_pay) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <br/>
                            <div class="row">
                                <div class="responsive-table">
                                    <table class=""  style="">                         
                                        <tbody>

                                            <tr>
                                                <?php if ($payslip_settings->show_employee_signature == 1) { ?>
                                                    <td  style="width: 80%">....<?php if ($payslip_settings->show_employee_digital_signature == 1) { ?> <img src="<?= $user_info->signature ?>" width="75" height="54"/> <?php } ?>.......</td>
                                                <?php } ?>
                                                <td></td>
                                                <td ></td>
                                                <?php
                                                if ($payslip_settings->show_employer_signature == 1) {
                                                    $setting = \App\Model\Setting::first();
                                                    ?>

                                                    <td  style="width: 80%">.....<?php if ($payslip_settings->show_employer_digital_signature == 1) { ?> <img src="<?= $setting->signature ?>" width="75"
                                                                                                                                                                  height="54"> <?php } ?>........</td>
                                                    <?php } ?>
                                            </tr> 
                                            <tr>
                                                <?php if ($payslip_settings->show_employee_signature == 1) { ?>
                                                    <td style="">Employee Signature</td>
                                                <?php } ?>
                                                <td ></td>
                                                <td ></td>
                                                <?php if ($payslip_settings->show_employer_signature == 1) { ?>
                                                    <td style="text-align: right">Employer Signature</td>
                                                <?php } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>


        <!-- Begin inline CSS -->
        <style type="text/css">

            .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
                font-weight: bolder
            }
            table.table.table-striped td, table.table.table-striped th, table.table {
                font-size: 12px !important;
                margin-left: 10%;
            }

            @font-face {
                font-family: DejaVuSans_b;
                src: url("../../public/assets/fonts/DejaVuSans_b.woff") format("woff");
            }

            table.table.table-striped td, table.table.table-striped th, table.table {
                margin: 1px auto !important;
            }

            @media print {

                .table-bordered > thead > tr > th, .table-bordered > tbody > tr > td {
                    font-size: 13px;
                }

                .well {
                    display: none;
                }
                .nav_menu{display: none;}
            }


        </style>

    </div>
</div>

<!-- Modal content start here -->
<div class="modal fade" id="report_setting_model">
    <div class="modal-dialog">

        <form action="#" method="post" class="form-horizontal" role="form">
            <input type="hidden" name="id" value="<?= $payslip_settings->id ?>"/>
            <div class="modal-content">

                <div class="modal-header">
                    Payslip Settings
                </div>
                <?php
                $vars = get_object_vars($payslip_settings);
                ?>
                <div class="modal-body" > 
                    <table class="table table-hover">
                        <?php
                        foreach ($vars as $key => $variable) {

                            if (!in_array($key, array('id', 'created_at', 'updated_at'))) {
                                $name = ucfirst(str_replace('_', ' ', $key));
                                $final_name = str_replace('pos', 'position', $name);
                                $lname = str_replace('classteacher', 'class teacher ', $final_name);
                                ?>
                                <tr style="border-bottom:1px solid whitesmoke">
                                    <td style="padding-left:5px;">
                                        <h4><?= $lname ?></h4>
                                    </td>
                                    <td>
                                        <?php
                                        if (is_integer($variable) && $variable == 1) {
                                            ?>
                                            <input type="checkbox" name="<?= $key ?>" checked="checked" onchange="this.value = this.checked ? 1 : 0" value="1"/>
                                        <?php } else if ((is_integer($variable) && $variable == 0) || $variable == '') { ?>
                                            <input type="checkbox" onchange="this.value = this.checked ? 1 : 0" name="<?= $key ?>"  value="1"/>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="text" name="<?= $key ?>" value="<?= $variable ?>"/>
                                        <?php } ?>
                                    </td>

                                </tr>
                                <?php
                            }
                        }
                        ?>


                    </table>   
                </div>


                <div class="modal-footer">
                    <button type="button" style="margin-bottom:0px;" class="btn btn-default" data-dismiss="modal" onclick="javascript:closeWindow()"><?= __('close') ?></button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
                <?= csrf_field() ?>
        </form>
    </div>
</div>
</div>
<script>
    function printDiv(divID) {

        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        //document.body.innerHTML =
        //       '<html><head><title></title></head><body>' +
        //       divElements + '</body>';

        //Print Page
        window.print();
        //Restore orignal HTML
        //  document.body.innerHTML = oldPage;
    }
</script>


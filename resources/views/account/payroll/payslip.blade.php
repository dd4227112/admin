@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/';
$payslip_settings = \DB::table('admin.payslip_settings')->first();

if (empty($payslip_settings)) {
    DB::select('insert into payslip_settings (show_employee_signature,show_employer_signature,
                show_employee_digital_signature,show_employer_digital_signature,show_address,show_tax_summary,show_employer_contribution) 
               values (0,0,1,1,1,0,0)');
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
      margin: 2cm 2cm 2cm 2cm;
        }
        .invoice-header{
            margin-right:30% !important;
        }
        .invoice-title{
            float: right !important;
        }

    }
</style>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
          <div class="col-sm-12 m-10">
                <?php if (can_access('manage_payroll')) { ?>
                    <button class="btn btn-sm btn-primary" onclick="javascript:printDiv('printablediv')"> Print payslip </button>
                 <?php } ?>
         </div>

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                                                         
                          
                                                    
                        <div style="overflow: auto" class="overflow" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
                            <div id="printablediv" class="page center sheet padding-10mm" >
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                            <div class="tab-content card-block">

                                                <section class="content invoice" id="print_div">

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

                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                              <th  style="max-width:25%" class="m-10">
                                                             <?php 
                                                                $path = \collect(DB::select("select f.path from admin.users a join admin.company_files f on 
                                                                a.company_file_id = f.id where a.id = '$user->id'"))->first(); 
                                                                $local = $root . 'assets/images/user.png';
                                                                ?>
                                                                <img class="img-50 img-circle" style="margin-left:2em" height="60em" width="72em" 
                                                                src="<?= isset($path->path) && ($path->path != '')  ? $path->path : $local ?>" 
                                                                alt="User-Profile-Image"> 
                                                            </th>

                                                    
                                                             <th style="font-size: 17px; font-size: 100%; max-width: 100%;">
                                                                <b>Name:</b> <?= $salary->user->firstname. ' '.$salary->user->lastname ?>
                                                                <br>
                                                                {{-- <b>Address:</b> <?= $user->address ?? ''?>
                                                                <br> --}}
                                                                <b>Phone No:</b>  <?= $user->phone ?? '' ?>
                                                                <br>
                                                                <b>Email :</b>  <?= $user->email ?? '' ?>
                                                              </th>
                                                           

                                                              <th style="font-size: 17px; font-size: 100%; max-width: 100%;">
                                                                <b>Payment Date:</b> <?= date('d-m-Y', strtotime($salary->payment_date)) ?>
                                                                <br>
                                                                <b>Bank Name:</b> <?= $user->bank_name ?? ''?>
                                                                <br>
                                                                <b>Bank Account No:</b>  <?= $user->bank_account ?? '' ?>
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
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th style="width: 59%">Description</th>
                                                                        <th align='center' class="text-center">Amount (  currency)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>

                                                                        <td>1</td>
                                                                        <td><b>Basic Salary</b></td>
                                                                        <td align='center'><?php
                                                                            $basic_salary = $salary->basic_pay;
                                                                            echo money($basic_salary);
                                                                            ?>
                                                                       </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>
                                                                            <b>Allowance</b>
                                                                            <div class="x_content offset-lg-1">
                                                                                <table >
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
                                                                                                echo '<tr>';
                                                                                                $total_allowance += $value->amount;
                                                                                                $all_name = !empty($value->allowance->name) ? $value->allowance->name : '';
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
                                                                        $pension = \App\Models\SalaryPension::where('salary_id', $salary->id)->first();
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
                                                                                <table>
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
                                                                            </div>
                                                                          
                                                                        </td>

                                                                        <td align='center'  style="padding-top: 3%"><?= money($total_deductions) ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">TOTAL DEDUCTIONS</td>
                                                                        <td align='center'><?= money($total_deductions + $pension_employee_contribution) ?></td>
                                                                    </tr>
                                                                 </tr>


                                                                      <tr>
                                                                        <td>5</td>
                                                                        <td><b>Payment status:</b>
                                                                               <div class="x_content col-lg-offset-1">
                                                                                <table>
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Name</th>
                                                                                            <th>Total </th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>

                                                                                    
                                                                                     <?php if ($payslip_settings->show_tax_summary == 1) { ?>
                                                                                         <tr>
                                                                                            <th>Taxable Amount</th>
                                                                                            <th> <?php $taxable_amount = $gross_pay - $pension_employee_contribution;
                                                                                               echo money($taxable_amount); ?></th>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th> PAYE</th>
                                                                                            <th> <?= money($salary->paye) ?></th>
                                                                                        </tr>
                                                                                      <?php } ?>
                                                                                    

                                                                                         <?php if ($payslip_settings->show_employer_contribution == 1) { ?>
                                                                                          <tr>
                                                                                            <th>Contributions</th>
                                                                                            <th><?= money($pension_employee_contribution) ?></th>
                                                                                          </tr>
                                                                                         <?php } ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                          </td>
                                                                       </tr>
                                                                       <tr>
                                                                        <th colspan="2">NET PAYMENT</th>
                                                                        <th align='center'><?= money($salary->net_pay) ?></th>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                  
                                                
                                                    <br/>
                                                    <div class="row">
                                                        <div class="responsive-table">
                                                            <table class=""  style="">                         
                                                                <tbody>

                                                                    <tr>
                                                                        <td style="width: 80%;font-weight:800">
                                                                        <img src="<?= isset($user->signature)?$user->signature:'' ?>" width="75" height="54"/> </td>
                                                                        <td></td>
                                                                        <td ></td>
                                                                        <td ></td>
                                                                        <td ></td>
                                                                        <td ></td>
                                                                        <?php
                                                                        if ($payslip_settings->show_employer_signature == 1) {
                                                                            $setting = \App\Models\Setting::first();
                                                                            ?>
                                                                            <td  style="width: 80%;font-weight:800;">

                                                                                 <div style="padding-left:15%;">
                                                                                    <div style="z-index: 5000">
                                                                                        <img src="<?= url('public/images/company_seal.png') ?>"
                                                                                            width="100" height="100"
                                                                                            style="position:relative; margin-left: 3px; float:right;">
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                         <?php } ?>
                                                                    </tr> 
                                                                    <tr>
                                                                        <?php if ($payslip_settings->show_employee_signature == 1) { ?>
                                                                            <td style="">Employee Signature</td>
                                                                        <?php } ?>
                                                                        <td ></td>
                                                                        <td ></td>
                                                                        <td ></td>
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
                        

                        {{-- 
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
                            </div> --}}


                            
                        
                         </div>
                     </div>
                </div> 
            </div>
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
        document.body.innerHTML =
              '<html><head><title></title></head><body>' +
              divElements + '</body>';

        //Print Page
        window.print();
        //Restore orignal HTML
        //  document.body.innerHTML = oldPage;
    }

     $(document).ready(function () {
        $("#printPayslip").click(function () {

            printDiv("print_div");
        });
    });
</script>
@endsection


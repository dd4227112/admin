@extends('layouts.app')
@section('content')

<style>.count{font-size: 17px !important;}</style>
<?php
$users = 0;
if (!empty($basic_payments)) {
    foreach ($basic_payments as $payment) {
        $users += $payment->count;
    }
}
?>
<div class="row mt-4">

    <div class="col-md-2 col-sm-4 col-xs-6">
    <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Users</p>
                                                <h4 class="m-b-0"><?= $users ?></h4>
                                            </div>
                                            
                                    </div>
                                </div>
                            </div>
  
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
    <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Basic Salary</p>
                                                <h4 class="m-b-0"><?=  ' ' . money(request('basic_pay')) ?></h4>
                                            </div>
                                           
                                    </div>
                                </div>
                            </div>
       
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
    <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Allowances</p>
                                                <h4 class="m-b-0"><?=  ' ' . money(request('allowance')) ?></h4>
                                            </div>
                                            
                                    </div>
                                </div>
                            </div>
    
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
    <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Deductions</p>
                                                <h4 class="m-b-0"><?=  ' ' . money(request('deduction')) ?></h4>
                                            </div>
                                           
                                    </div>
                                </div>
                            </div>
       
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 ">
    <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Net Payment</p>
                                                <h4 class="m-b-0"><?=  ' ' . money(request('net_pay')) ?></h4>
                                            </div>
                                            
                                    </div>
                                </div>
                            </div>
      
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 ">
    <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total PAYE</p>
                                                <h4 class="m-b-0"><?=  ' ' . money(request('paye')) ?></h4>
                                            </div>
                                            
                                    </div>
                                </div>
                            </div>
        
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Bank Submission Forms </h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Summary </th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>All Staff & Deductions</td>
                            {{-- <td><a href="<?= url('payroll/bankSubmission/null/?set=' . request('set') . '&month=' . date('m')) ?>" class="btn btn-success btn-xs mrg"><i class="fa fa-file"></i> View</a></td> --}}
                        </tr>
<!--                         <tr>
                            <td>2</td>
                            <td>TAX Submission</td>
                            <td><a href="<?= url('payroll/taxSubmission/null/?set=' . request('set') . '&month=' . date('m')) ?>" class="btn btn-success btn-xs mrg"><i class="fa fa-file"></i> View</a></td>
                        </tr>-->
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title mb-3">
                <h5 >Bank Total Amount</h5>

                <div class="clearfix"></div>
            </div>
            <div class="card">
                <div class="card-block">
                    <span class="count_top"><i class="fa fa-money"></i> Amount to be Transacted From Bank Account</span>
                    <?php
                    $set = request('set');
                    $salary = \App\Models\Salary::where('payment_date', $set);
                    $pension = \collect(DB::select('select sum(a.employer_amount) as employer_contribution from salary_pensions a join constant.pensions b on b.id=a.pension_id  where salary_id IN (SELECT id FROM salaries where payment_date=\'' . $set . '\')'))->first();
                    ?>
                    <div class="" style="font-size:32px">Tsh <?= money($salary->sum('gross_pay') + $pension->employer_contribution) ?>/=</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">

  <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
      <div class="x_title">
          <h2>Tax Summary</h2>

          <div class="clearfix"></div>
      </div>
      <div class="x_content">

          <table class="table">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Total Amount </th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>1</td>
                      <td>Pay-E Summary</td>

                      <td><?=  ' ' . money(request('paye')) ?></td>
                  </tr>
                  <tr>
                      <td colspan="2"></td>
                      <td><a href="<?= url('payroll/viewTaxSummary/null/?set=' . request('set') . '&month=' . date('m')) ?>" class="btn btn-success btn-xs mrg"><i class="fa fa-file"></i> View Tax Summary</a></td>
                      </tr>
              </tbody>
          </table>

      </div>
  </div>
  </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <h2>Pension Summary </h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> Name</th>
                                <th>Employer Contribution</th>
                                <th>Employee Contribution</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_employer_contribution = 0;
                            $total_employee_contribution = 0;
                            if (!empty($pensions)) {
                                $p = 1;

                                foreach ($pensions as $pension) {
                                    $total_employer_contribution += $pension->employer_contribution;
                                    $total_employee_contribution += $pension->employee_contribution;
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $p ?></th>
                                        <td><?= $pension->name ?></td>
                                        <td><?= money($pension->employer_contribution) ?></td>
                                        <td><?= money($pension->employee_contribution) ?></td>
                                        <td> <a href="<?= url('payroll/pensionContribution/null/?id=' . $pension->pension_id . '&set=' . request('set') . '&month=' . date('m')) ?>" class="btn btn-success btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Show contribution form"><i class="fa fa-file"></i>Contribution Form</a></td>
                                    </tr>
                                    <?php
                                    $p++;
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td scope="row">TOTAL</td>
                                <td></td>
                                <td><?= money($total_employer_contribution) ?></td>
                                <td><?= money($total_employee_contribution) ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Allowance Status</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Allowance Name</th>
                            <th>Amount </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_allowances = 0;
                        if (!empty($allowances)) {
                            $x = 1;
                            foreach ($allowances as $allowance) {
                                $total_allowances += $allowance->sum;
                                ?>
                                <tr>
                                    <th scope="row"><?= $x ?></th>
                                    <td><?= $allowance->name ?></td>
                                    <td><?= money($allowance->sum) ?></td>
                                </tr>
                                <?php
                                $x++;
                            }
                        }
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="row">TOTAL</th>
                            <td></td>
                            <td><?= money($total_allowances) ?></td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>


      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="card">
              <div class="card-body">
                  <h2>Basic Payments</h2>

                  <div class="clearfix"></div>
              </div>
              <div>

                  <table class="table">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>User Type</th>
                              <th>No of Users </th>
                             <th>Amount (Tsh)</th> 
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          $total_users = 0;
                          $total_basic_payment_amount = 0;
                          if (!empty($basic_payments)) {
                              $i = 1;
                              foreach ($basic_payments as $payment) {
                                  $total_users += $payment->count;
                                  $total_basic_payment_amount += $payment->amount;
                                  ?>
                                  <tr>
                                      <th scope="row"><?= $i ?></th>
                                      <td><?php
                                        //   if ($payment->table == 'setting') {
                                        //       echo 'Main Administrator';
                                        //   } else if ($payment->table == 'user') {
                                        //       echo 'Non Teaching Staff';
                                        //   } else {
                                        //       echo ucfirst($payment->table);
                                        //   }
                                          ?>
                                      </td>
                                      <td><?= $payment->count ?></td>
                                      <td><?= money($payment->amount) ?></td>
                                  </tr>
                                  <?php
                                  $i++;
                              }
                          }
                          ?>

                      </tbody>
                      <tfoot>
                          <tr>
                              <th scope="row">TOTAL</th>
                              <td></td>
                              <td><?= $total_users ?></td>
                              <td><?= money($total_basic_payment_amount) ?></td>
                          </tr>
                      </tfoot>
                  </table>

              </div>
          </div>
      </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Deductions Status</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <tr>
                            <th>#</th>
                            <th>Deduction Name</th>
                            <th>Amount (Tsh)</th>
                            <th>Contribution Form</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_deductions = 0;
                        if (!empty($deductions)) {
                            $x = 1;

                            foreach ($deductions as $ded) {
                                $total_deductions += $ded->sum + $ded->employer_amount;
                                ?>
                                <tr>
                                    <th scope="row"><?= $x ?></th>
                                    <td><?= $ded->name ?></td>
                                    <td><?= money($ded->sum +$ded->employer_amount) ?></td>
                                    <td> <a href="<?= url('payroll/summaryForm/null/?type=deduction&set=' . request('set') . '&month=' . date('m').'&ded_id='.$ded->deduction_id) ?>" class="btn btn-success btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Show contribution form"><i class="fa fa-file"></i>View Report</a></td>
                                </tr>
                                <?php
                                $x++;
                            }
                        }
                        ?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th scope="row">TOTAL</th>
                                            <td></td>
                                            <td><?= money($total_deductions) ?></td>
                                            <td><a href="<?= url('payroll/summaryForm/null/?type=deduction&set=' . request('set') . '&month=' . date('m')) ?>" class="btn btn-success btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Show contribution form"><i class="fa fa-file"></i> Deduction Form</a></td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>



                <div class="clearfix"></div>


            </div>

            <!--<link href="<?php echo url('public/assets/print.css'); ?>" rel="stylesheet" type="text/css">

            <div class="well">
            <div class="row">
              <div class="col-sm-6">

                  <button class="btn-cs btn-sm-cs" onclick="javascript:printDiv('printablediv')"><span
                          class="fa fa-print"></span> <?= __('print') ?> </button>

                  <a href=""
                     target="_blank">
                      <i class="fa fa-print"></i><?= __('print') ?> Pint All</a>
                  <span>&nbsp;</span>


              </div>
              <div class="col-sm-6">
                  <ol class="breadcrumb">
                      <li><a href="<?= url("dashboard/index") ?>"><i
                                  class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
                      <li><a href="<?= url("exam/index") ?>"><?= __('menu_parent') ?></a></li>
                      <li class="active"><?= __('view') ?></li>
                  </ol>
              </div>
            </div>

            </div>
            <div style="overflow: auto" class="overflow" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
            <div id="printablediv" class="page center sheet padding-10mm" >

              <section class=" subpage">


                  <div id="p1" style="overflow: hidden; left: 5%;" class="">


                       Begin inline CSS
                      <style type="text/css">

                          .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
                              font-weight: bolder
                          }

                          #printablediv {
                              color: #000;
                          }

                          table.table.table-striped td, table.table.table-striped th, table.table {
                              font-size: 12px !important;
                              margin-left: 10%;
                          }

                          @page {
                              margin: 0
                          }

                          .sheet {
                              margin: 0;
                              overflow: hidden;
                              position: relative;
                              box-sizing: border-box;
                              page-break-after: always;
                          }

                          /** Padding area **/
                          .sheet.padding-10mm {
                              padding: 10mm
                          }

                          /** For screen preview **/
                          @media screen {

                              .sheet {
                                  background: white;
                                  box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                                  margin: 5mm;
                                  left:12%;
                              }
                          }
                      </style>
                       End inline CSS

                       Begin embedded font definitions
                      <style id="fonts1" type="text/css">


                          table.table.table-striped td, table.table.table-striped th, table.table {
                              border: 1px solid #000000;
                          }


                      </style>

                      <style type="text/css">
                          @font-face {
                              font-family: DejaVuSans_b;
                              src: url("../../public/assets/fonts/DejaVuSans_b.woff") format("woff");
                          }

                          table.table.table-striped td, table.table.table-striped th, table.table {
                              border: 1px solid #000000;
                              margin: 1px auto !important;
                          }

                          @media print {
                              html, body {
                                  width: 210mm;
                                  height: 297mm;
                              }

                              section.A4 {
                                  width: 210mm
                              }

                              @page {
                                  size: A4;
                                  margin: 0;

                              }

                              table {
                                  width: 100%;
                                  border-spacing: 0;
                              }

                              .subpage {
                                  padding: 1em 1em 0 1em;
                                  /* border: 3px #f00 solid; */
                                  font-size: .8em;
                              }

                              table.table.table-striped td, table.table.table-striped th, table.table {
                                  border: .1px solid #000;
                              }

                              .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                  padding: 0.2%;
                              }

                              .table-bordered > thead > tr > th, .table-bordered > tbody > tr > td {
                                  font-size: 11px;
                              }


                          }

                          h3, h4 {
                              page-break-after: avoid;

                          }

                      </style>

                       Begin page background


                                <?php
                                $array = array(
                                    "src" => url('storage/uploads/images/' ),
                                    'width' => '126em',
                                    'height' => '126em',
                                    'class' => 'img-rounded',
                                    'style' => 'margin-left:2em'
                                );
                                ?>

              
                      <hr/>
                  </div>

                  <div class="">
                      <h1 align='center' style="font-size: 1.9em; font-weight: bolder;padding-top: 0%; ">
                          PAYSLIP TITLE</h1>
                  </div>
                  <div>
                      <div class="row" style="margin: 1% 2% 1% 2%;">
                          <div class="col-sm-6" style="float:left;">
                              <h1 style="font-weight: bolder;font-size: 1.4em;"> NAME: </h1>
                              <h4 style="margin-top: 2%;"> Admission No: </h4>
                          </div>
                          <div class="col-sm-3" style="float: right;">
                              <h1 style="font-weight: bolder; font-size: 1.4em;">Address</h1>
                          </div>
                          <div style="clear:both;"></div>
                      </div>

                  </div>

                  <div class="row table" style="margin: 2%;">

                      <div class="col-lg-12">
                          <div class="row" style="margin: 2%;">

                              <div class="col-lg-12">
                                  <table  class="table table-striped table-bordered center" style="margin-bottom: -.1%;">
                                      <thead style='background-color: #b3b3b3'>
                                          <tr>
                                              <th>Description</th>
                                              <th>Amount</th>
                                          </tr>
                                      </thead>

                                      <tbody>
                                          <tr>
                                              <td>Total Basic Salary</td>
                                              <td align='center'><?= request('basic_pay') ?></td>
                                          </tr>
                                          <tr>
                                              <td>Total Allowance</td>
                                              <td align='center'><?= request('allowance') ?></td>
                                          </tr>
                                          <tr>
                                              <td>Total GROSS PAY</td>
                                              <td align='center'> <?= request('gross_pay') ?> </td>
                                          </tr>
                                      </tbody>
                                  </table>

                                  <br/>
                                  <br/>
                                  <table  class="table table-striped table-bordered center" style="margin-bottom: -.1%;">
                                      <thead style='background-color: #b3b3b3'>

                                      </thead>

                                      <tbody>
                                          <tr>
                                              <td>Total Pension (Employees)</td>
                                              <td align='center'> <?= request('pension') ?></td>
                                          </tr>
                                          <tr>
                                              <td>Total Pension (Employers Contribution)</td>
                                              <td align='center'>
                                            <?php
                                            //calculate user deductions
                                            $user_pensions = \App\Models\UserPension::all();
                                            $total_pensions = 0;
                                            if (!empty($user_pensions)) {
                                                foreach ($user_pensions as $pension) {
                                                    $user = \App\Models\User::where('id', $pension->user_id)->first();
                                                    $basic_salary = !empty($user) ? $user->salary : 0;
                                                    $total_pensions += $basic_salary * $pension->pension->employer_percentage;
                                                }
                                            }
                                            echo $total_pensions;
                                                ?></td>
                                          </tr>
                                          <tr>
                                              <td>Deductions</td>
                                              <td align='center'>
                                                  <?= request('deduction') ?></td>
                                          </tr>
                                          <tr>
                                              <td>Total Net Salary</td>
                                              <td align='center'><?= request('net_pay') ?></td>
                                          </tr>
                                      </tbody>
                                  </table>
                                  <br/>
                                  <br/>
                                  <h3>Summary</h3>
                                  <table  class="table table-striped table-bordered center" style="margin-bottom: -.1%;">
                                      <thead style='background-color: #b3b3b3'>
                                          <tr>

                                          </tr>
                                      </thead>

                                      <tbody>
                                          <tr>
                                              <td>Taxable Amount</td>
                                              <td align='center'><?= request('tax') ?> </td>
                                          </tr>
                                          <tr>
                                              <td>PAYE</td>
                                              <td align='center'><?= request('paye') ?></td>
                                          </tr>

                                          <tr>
                                              <td>SDL</td>
                                              <td align='center'><?= request('gross_pay') * 0.45 / 100 ?></td>
                              </tr>
                          </tbody>
                      </table>

                  </div>


              </div>


              </section>

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
              document.body.innerHTML = oldPage;
          }

          function trigger_message(a) {
              swal({
                  title: "Are you sure?",
                  text: "SMS will be sent to all parents in this class",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: '#DD6B55',
                  confirmButtonText: 'Yes, I am sure!',
                  cancelButtonText: "No, cancel it!",
                  closeOnConfirm: false,
                  closeOnCancel: false
              },
                      function (isConfirm) {

                          if (isConfirm) {
                              swal("Report!", "Message will be sent now!", "success");
                              window.location.href = a;

                          } else {
                              swal("Cancelled", "Message not sent :)", "error");
                              e.preventDefault();
                          }
                      });
          }
      </script>
-->

@endsection



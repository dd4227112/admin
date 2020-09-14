

@extends(!isset($balance) ? 'layouts.app' : 'layouts.nologin')

@section('content')

<title>Invoice</title>
<link rel="SHORTCUT ICON" rel="icon" href="<?= url("storage/uploads/images/favicon.png") ?>">
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<meta name="theme-color" content="#00acac">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="<?php echo url('public/assets/shulesoft/style.css'); ?>" rel="stylesheet" media="all">
<link href="<?php echo url('public/assets/shulesoft/shulesoft.css'); ?>" rel="stylesheet">
<link href="<?php echo url('public/assets/shulesoft/responsive.css'); ?>" rel="stylesheet">
<link href="<?php echo url('public/assets/shulesoft/rid.css'); ?>" rel="stylesheet">

<style>
    @media print {
        @page {
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

<style>
    .btn-bs-file{
        position:relative;
    }
    .btn-bs-file input[type="file"]{
        position: absolute;
        top: -9999999;
        filter: alpha(opacity=0);
        opacity: 0;
        width:0;
        height:0;
        outline: none;
        cursor: inherit;
    }

</style>
<div class="main-body">
    <div class="@if(!isset($balance))  page-wrapper @endif">
        <!-- Page-header start -->
        @if(!isset($balance))
        <div class="page-header">
            <div class="page-header-title">
                <h4>ShuleSoft Invoices</h4>
             
            </div>
        </div>
        @endif
        <!-- Page-header end -->
        <!-- Page-body start -->


        <style>

            #valid-msg {
                color: #00C900;
            }
            #error-msg {
                color: red;
            }
            @media print {
                #setup_notifications {
                    display: none !important;
                }
                /*                #print_div{
                padding-left:20em;
                }*/
                .table-header{
                    background-color: #aaaaaa !important;
                }

            }
        </style>
        <?php
        $bn_number = 888999;
        ?>
       
        <div class="page-body">
                  <div class="row">
                                        <div class="col-lg-6"></div>
                                        <div class="col-lg-6">
                                            
                                             <p class="text-right" align="right">
                                                @if(!isset($balance)) 
                                                <?php
                                            if (strlen($invoice->token) < 4) {
                                                ?><a href="<?= url()->current() . '/1' ?>" class="btn btn-warning btn-sm ">Create Control Number</a>
                                            <?php } ?>
                                                     <?php if ($invoice->status <> 1) { ?>  <a href="<?= url('account/payment/' . $invoice->id) ?>" class="btn btn-danger btn-sm"><i class="fa fa-money"></i> Add Payment </a>
                                                        <?php } ?>
                                                        @endif
                                                        <a href="#" id="printInvoice" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Print </a>
                                                   
                                                </p>
                                    </div>  
                                 
                                    <div class="clearfix"></div>
                                </div>
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-block tab-icon">
                            <div class="x_panel">
                                <div class="x_title">
                              
                                <div class="x_content" id="print_div">

                                    <!-- title row -->
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-8">
                                            <address id="dt-ajax-array" class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <!-- <img src="{{url('public/assets/images/inets.png')}}" height="90" alt="INETS Company Limtied, ShuleSoft School Management System" style="margin-right: 40%;"> -->
                                                            <ul>
                                                                <li style="font-size: 1rem">From</li>
                                                                <li><strong>INETS COMPANY LIMITED</strong></li>
                                                                
                                                                <li>P.o Box 33287 Dar es Salaam</li>
                                                                <li>2nd Floor,Block NO. 576</li>
                                                                <li>Mbezi Beach Bagamoyo Road</li>
                                                                <li>Mobile no: +255 655/754 406004</li>
                                                            </ul>
                                                        </td>
                                                       
                                                    </tr>
                                                <tbody>
                                            </address>
                                            <!-- /.col -->
                                        </div>
                                        <div class="col-lg-6 col-sm-4">
                                             <td>
                                                            <h1 class="pull-right invoice-title" style="font-size: rem; float: right; margin-left: 60%">Invoice</h1>
                                                        </td>
                                        </div>
                                    </div>
                                    <!-- info row -->
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                             <address>
                                                            <ul>
                                                                <li><p style="font-size: 1rem;"> To</p></li>
                                                               
                                                                    <li><strong><?=  $invoice->client->name ?></strong></li>
                                                                    
                                                                    <li>Phone: <?=  $invoice->client->phone ?></li>
                                                                    <li>Email: <?=  $invoice->client->email ?></li>
                                                            </ul>
                                                           
                                                   </address>
                                               </div>
                                                 <div class="col-lg-6 col-sm-6 ">
                                                    <table  class="table">
                                                                    <tr>
                                                                        <td>Control #</td>
                                                                        <td><?= strlen($invoice->token) <4 ?$invoice->reference:$invoice->token ?></td>
                                                                    </tr>
                                                                   
                                                                    <tr>
                                                                        <td>Due Date #</td>
                                                                        <td><?= date('d M Y', strtotime($invoice->due_date)) ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>TOTAL DUE</td>
                                                                        <td>  <?php
                                                                    $am = $invoice->invoiceFees()->sum('amount');

                                                                    $paid = $invoice->payments()->sum('amount');

                                                                    $unpaid = $am - $paid;
                                                                    ?><b class="amnt-value">Tsh <?= number_format($unpaid) ?></b></td>
                                                                    </tr>
                                                              </table> 
                                                    </div>

                                        
                                    </div>
                                    <!-- /.row -->

                                    <!-- Table row -->
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-lg-12 ">
                                             <?php
                                                    $invoice_fee = $invoice->invoiceFees()->get();
                                                    ?>
                                                    <br/>
                                                    <div class="col-xs-12 col-sm-12 col-lg-12">
                                                    <table class="table table-bordered table-colapse">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Description</th>
                                                                <th class="text-center">Quantity</th>
                                                                 <th class="text-center">Unit Price</th>
                                                                <th class="text-center">Total (Tsh)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                              foreach ($invoice_fee as $fees) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $i ?></td>
                                                                <td><?= $fees->item_name?>
                                                                     <li>Training and Support</li>
                                                                    <li>Unlimited Cloud hosting for School Information</li>
                                                                    <li>Unlimited bandwidth for users to access</li>
                                                                  
                                                                    <li>Customization of features based on school requests</li>
                                                                    <li>Free Technical support for all ShuleSoft users<br/> ( parents, teachers, students and staff)</li>
                                                                </td>
                                                                <td class="text-center"><?= $fees->quantity ?></td>
                                                                 <td class="text-center"><?= $fees->unit_price ?></td>
                                                                <td class="text-center"><?= money($fees->amount)?></td>
                                                            </tr>
                                                              <?php }?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                        </div>
                                        <!-- /.col -->
                                          <p class="well-sm "><b>Amount in words:</b> <?= number_to_words($unpaid) ?></p>
                                    </div>
                                    <!-- /.row -->

                                    <div class="row">
                                       <div class="col-lg-6 col-sm-6 col-xs-6">
                                      
<table class="table">
  
                                          
                                            <br/>

                                            <p class="lead">Payment Methods:</p>
                                            
                                            <p  >
                                                <b>Account Details :</b><br/>
                                                <b>Account Name:</b> INETS COMPANY LIMITED <br/> <b>Bank Name:</b> NMB BANK PLC <br/>  <b>Account Number:</b> 22510028669
                                                <br/>
                                                <small>Please notify us after a deposit</small>
                                            </p>
                                      <?php  if (strlen($invoice->token) > 4) { ?>
                                            <d>Or Pay Electronically here <a href="<?= url('epayment/i/' . $invoice->id) ?>" target="_blank"><?= url('epayment/i/' . ($invoice->id)) ?></a></d>
                                        <?php }?>
                                           <!-- <br/>
                                            <b>If you make a bank deposit, you will have to notify us to activate your account</b> -->
                                            <p class="text-muted well well-sm no-shadow">

                                                Thank you for your business. we're glad to serve you
                                            </p>
                                  
                            </table>
                        </div>

           <div class="col-lg-6  col-sm-6 col-xs-6">
                                            <br/>
                                            <p class="lead">Summary</p>
                                           
                                                     <table class="table ">
                                                                <tbody>
                                                                    <tr>
                                                                        <th>Sub - Total amount :</th>
                                                                        <th>Tsh <?= number_format($am) ?></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Paid Amount :</th>
                                                                        <th>Tsh <?= $paid > 0 ? number_format($paid) : 0 ?> </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Grand Total :</th>
                                                                        <th>Tsh <?= number_format($unpaid) ?></th>
                                                                    </tr>
                                                                   
                                                                </tbody>
                                                            </table>
                                           
    
</div>
                                       
                                      
                                    </div>
                                    <!-- /.row -->

                                
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="{{url('public/assets/shulesoft/jquery.PrintArea.js')}}" type="text/JavaScript"></script>

<script type="text/javascript">
                                            function printDiv(divID) {
                                                //Get the HTML of div
                                                var divElements = document.getElementById(divID).innerHTML;
                                                //Get the HTML of whole page
                                                var oldPage = document.body.innerHTML;

                                                //Reset the page's HTML with div's HTML only
                                                document.body.innerHTML =
                                                        "<html><head><title></title></head><body><div style='margin-left: 4em; margin-right:4em; margin-top:10em'>" +
                                                        divElements + "</div></body>";

                                                //Print Page
                                                window.print();

                                                //Restore orignal HTML
                                                document.body.innerHTML = oldPage;
                                            }

                                            $(document).ready(function () {
                                                $("#printInvoice").click(function () {

                                                    printDiv("print_div");
                                                });
                                            });
</script>

@endsection


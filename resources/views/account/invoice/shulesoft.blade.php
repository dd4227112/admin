@extends('layouts.app')

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
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Invoices</h4>
                <span>Show payments summary</span>

            </div>
        </div>
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
        <div class="nav_menu no-print">

            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Help</h4>
                        </div>
                        <div class="modal-body">
                            <h4>How to make payments</h4>
                            <p>We accept payments via three ways</p>
                            <ol style="margin:0 8%;">
                                <li><b>Direct Bank Transfer:</b> In this way, you can use your internet banking or issue a transfer request from your bank to our bank account. This process can take at max 6 business hours to approve your account after confirmation of your payments</li>
                                <li><b>Issuing a cheque:</b> In this way, you can write a cheque and deposit in our bank account. This process can take at maximum 3 days after the deposit.</li>
                                <li><b>Mobile Money Transfer:</b> In this way you can transfer your payments to our  Tigo-pesa Number (0655406004).  This process can take at max 2 business hours to approve your account after confirmation of your payments</li>
                            </ol>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-block tab-icon">
                            <div class="x_panel">
                                <div class="x_title">
                                    <div class="row">
                                        <div class="col-lg-6"></div>
                                        <div class="col-lg-6">
                                            <?php
                                            if (strlen($invoice->token) < 4) {
                                                ?><a href="<?= url('account/invoiceView/accounts/1') ?>" class="btn btn-warning ">Create Control Number</a>
                                            <?php } ?><span style="float: right;" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#large-Modal">Define Due Date</span></div>
                                    </div>  
                                    <h2>Invoice For &nbsp; &nbsp;  &nbsp;</h2>
                                    <p class="nav navbar-nav text-center">
                                        <select class="form-control" onchange="window.location.href = '<?= url('help/upgrade/') ?>/' + $(this).val()">
                                            <option value="1"></option>
                                            <option value="1" <?= $set == 1 ? 'selected' : '' ?>>One Year</option>
                                            <option value="6" <?= $set == 6 ? 'selected' : '' ?>>One Term</option>
                                            <option value="12" <?= $set == 12 ? 'selected' : '' ?>>One Month</option>
                                        </select>
                                    </p>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" id="print_div">

                                    <!-- title row -->
                                    <div class="row">
                                        <div class="table-responsive dt-responsive">
                                            <table id="dt-ajax-array" class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <img src="{{url('public/assets/images/inets.png')}}" height="90" alt="INETS Company Limtied, ShuleSoft School Management System" style="margin-right: 40%;">
                                                        </td>
                                                        <td>
                                                            <h1 class="pull-right invoice-title" style="font-size: rem; float: right; margin-left: 60%">Invoice</h1>
                                                        </td>
                                                    </tr>
                                                <tbody>
                                            </table>
                                            <!-- /.col -->
                                        </div>
                                    </div>
                                    <!-- info row -->
                                    <div class="row invoice-info">
                                        <div class="table-responsive dt-responsive">
                                            <table id="dt-ajax-array" class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <ul>
                                                                <li style="font-size: 1rem">From</li>
                                                                <li><strong>INETS COMPANY LIMITED</strong></li>
                                                                <li>TIN 122-866-750</li>
                                                                <li>P.o Box 33287 Dar es Salaam</li>
                                                                <li>2nd Floor,Block NO. 576</li>
                                                                <li>Mbezi Beach Bagamoyo Road</li>
                                                                <li>Mobile no: +255 655 406 004</li>
                                                                <li>Telephone: +255 22 278 0228</li>
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <ul>
                                                                <li><p style="font-size: 1rem;"> To</p></li>
                                                                <address>
                                                                    <li><strong><?= $siteinfos->sname ?></strong></li>
                                                                    <li><?= $siteinfos->address ?></li>
                                                                    <li>Phone: <?= $siteinfos->phone ?></li>
                                                                    <li>Email: <?= $siteinfos->email ?></li>
                                                            </ul>
                                                            </address>
                                                        </td>
                                                        <td>
                                                            <ul>
                                                                <li><p style="font-size: 1rem;"> Invoice Info:</p></li>
                                                                <address>
                                                                    <li><b>Invoice #<?php $invoice->token ?></b></li>
                                                                    <li><b>Date:</b> <?= isset($siteinfos->last_payment_date) ? date('d M Y', strtotime($siteinfos->last_payment_date)) : '' ?></li>
                                                                    <li><b>Due Date:</b> <?= isset($siteinfos->next_payment_date) ? date('d M Y', strtotime($siteinfos->next_payment_date)) : '' ?></li>
                                                                    </td>
                                                            </ul>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <!-- /.row -->

                                    <!-- Table row -->
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 table">
                                            <table class="table table-bordered ">
                                                <thead>
                                                    <tr style="background-color: #33b5b5; font-weight: 800" class="table-header">

                                                        <th><b>Name</b></th>
                                                        <th><b>Description</b></th>
                                                        <th><b>Students</b></th>
                                                        <th><b>Price</b></th>
                                                        <th><b>Amount</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>

                                                        <td>ShuleSoft</td>
                                                        <td >
                                                            <div style="line-height:2;">
                                                                ShuleSoft Charges for (

                                                                <?= $schema ?>shulesoft.com). Charges cover
                                                                <ul style="margin-left:4%">
                                                                    <li>Training and Support</li>
                                                                    <li>Unlimited Cloud hosting for School data</li>
                                                                    <li>Unlimited bandwidth for user access</li>
                                                                    <li>Unlimited disk space</li>
                                                                    <li>Customization of features based on school requests</li>
                                                                    <li>Free Technical support for all ShuleSoft users ( parents, teachers, students and staff)</li>
                                                                    <li>Access of all modules available in ShuleSoft <br/>(User Management, Academic Management, Library, Hostel, Routine, Account module, system reports)</li>
                                                                    <li>Free SMS and Email</li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <?php
                                                        $price = 0;

                                                        if ($set == 1 || $set == '') {
                                                            $price = $siteinfos->price_per_student;
                                                        } else if ($set == 6) {
                                                            $price = $siteinfos->price_per_student / 2;
                                                        } else if ($set == 12) {
                                                            $price = $siteinfos->price_per_student / 10;
                                                        }
                                                        ?>
                                                        <td><?= $students + (int) $siteinfos->estimated_students ?> </td>
                                                        <td><?= money($price) ?></td>
                                                        <td><?= money($price * ($students + (int) $siteinfos->estimated_students)) ?></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <div class="row">
                                        <!-- accepted payments column -->

                                        <div class="col-sm-6 invoice-col">
                                            <p class="well-sm "><b>Amount in words:</b> <?= number_to_words((float) $price * ((int) $students + (int) $siteinfos->estimated_students)) ?></p>
                                            <br/>

                                            <p class="lead  well-sm ">Payment Methods:</p>
                                            <!--                                    <a href="#" data-toggle="modal" data-target=".bs-nmb-modal-lg3">
                                            <img src="<?= url('public/assets/images/account/nmb.jpg') ?>" alt="NMB channels" width="50" height="60"></a>
                                            <a href="#mpesa" data-toggle="modal" data-target=".bs-mobile-modal-lg3">
                                            <img src="<?= url('public/assets/images/account/mpesa.jpg') ?>" alt="M-pesa" width="50" height="60"></a>
                                            <a href="#tigo" data-toggle="modal" data-target=".bs-mobile-modal-lg3">
                                            <img src="<?= url('public/assets/images/account/tigo.jpg') ?>" alt="TigoPesa" width="50" height="60"></a>
                                            <a href="#airtel" data-toggle="modal" data-target=".bs-mobile-modal-lg3">
                                            <img src="<?= url('public/assets/images/account/airtel.jpg') ?>" alt="Airtel Money" width="50" height="60"></a>-->
                                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                                <b>Account Details :</b><br/>
                                                <b>Account Name:</b> INETS COMPANY LIMITED <br/> <b>Bank Name:</b> NMB BANK PLC <br/>  <b>Account Number:</b> 22510028669
                                                <br/>
                                            </p>
                                            <d>Or Pay Electronically here <a href="<?= url('epayment/i/' . $booking->id) ?>" target="_blank"><?= url('epayment/i/' . ($booking->id)) ?></a></d>
                                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">

                                                Thank you for your business. we're glad to serve you
                                            </p>
                                        </div>
                                        <!-- /.col -->

                                        <div class="col-sm-6 invoice-col">
                                            <p class="lead">Summary</p>
                                            <div class="table-responsive summary">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th style="width:50%">Total Invoice Amount:</th>
                                                            <td><?= money($price * ($students + $siteinfos->estimated_students)) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total Paid Amount</th>
                                                            <td><?= money($siteinfos->total_paid_amount) ?></td>
                                                        </tr>

                                                        <tr>

                                                            <th>Unpaid Total Amount:</th>
                                                            <td>
                                                                <?php
                                                                $unpaid = $price * ($students + $siteinfos->estimated_students) - $siteinfos->total_paid_amount;
                                                                echo money($unpaid);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <!-- this row will not appear when printing -->
                                    <div class="row no-print">
                                        <div class="col-xs-12">

                            <!--<button class="btn btn-success pull-right" data-toggle="modal" data-target=".bs-example-modal-lg3"><i class="fa fa-credit-card"></i> Submit Payment</button>-->
                            <!--<button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>-->
                                        </div>
                                        <div class="modal fade bs-nmb-modal-lg3" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                        </button>
                                                        <h4 class="modal-title" id="myModalLabel">How to make Payments</h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <header>
                                                            <ul class="nav nav-tabs">
                                                                <li class="active">
                                                                    <a href="#stats" data-toggle="tab" aria-expanded="true">BRANCH</a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="#report" data-toggle="tab" aria-expanded="false">NMB Mobile</a>
                                                                </li>
                                                                <li class="dropdown">
                                                                    <a href="#manual" data-toggle="tab" aria-expanded="false">NMB Wakala</a>
                                                                </li>
                                                            </ul>
                                                        </header>
                                                        <div class="body tab-content">
                                                            <div id="stats" class="tab-pane clearfix active col-lg-offset-1">
                                                                <p></p>
                                                                <br/>
                                                                <h3>BRANCH Payment instructions</h3>

                                                                <p></p>
                                                                <ol>
                                                                    <li>Visit any nearby NMB BANK branch</li>
                                                                    <li>Make deposit by specifying invoice number : <b><?= $invoice ?></b> with payment amount of Tsh <b><?php // money($price * $students)    ?></b></li>
                                                                </ol>
                                                                <p></p>



                                                            </div>
                                                            <div id="report" class="tab-pane col-lg-offset-1">

                                                                <h3 class="tt" key="nmb1">How to do Payment</h3>

                                                                <p></p>
                                                                <ol>
                                                                    <li class="nmb3" key="step1">Dial *150*66# in your phone to open NMB mobile service</li>
                                                                    <li class="nmb3" key="step2">Enter your secret PIN</li>
                                                                    <li class="nmb3" key="step3">Select (5) for Bills Payment</li>
                                                                    <li class="nmb3" key="step4">Select (6) option </li>
                                                                    <li><span class="nmb3" key="step5">Enter invoice number </span>: <b><?= $invoice ?></b></li>
                                                                    <li><span  class="nmb3" key="step6">Enter amount for your payment </span> <b>Tsh <?php // money($price * $students)    ?></b></li>
                                                                </ol>

                                                                <p></p>


                                                            </div>
                                                            <div id="manual" class="tab-pane col-lg-offset-1">
                                                                <p></p>
                                                                <br/>
                                                                <h3>NMB Wakala Payment instructions</h3>
                                                                <p></p>
                                                                <ol>
                                                                    <li>Visit any nearby NMB Wakala agent</li>
                                                                    <li>Make deposit of Tsh <b><?php // money($price * $students)    ?></b> and specify invoice number : <b><?= $invoice ?></b></li>
                                                                </ol>

                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade bs-mobile-modal-lg3" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                        </button>
                                                        <h4 class="modal-title" id="myModalLabel">How to make Payments</h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class=" ">
                                                            <header>
                                                                <ul class="nav nav-tabs">
                                                                    <li class="active">
                                                                        <a href="#mpesa" data-toggle="tab" aria-expanded="true">M-Pesa Payment</a>
                                                                    </li>
                                                                    <li class="">
                                                                        <a href="#tigopesa" data-toggle="tab" aria-expanded="false">TigoPesa Payment</a>
                                                                    </li>
                                                                    <li class="">
                                                                        <a href="#airtel" data-toggle="tab" aria-expanded="false">Airtel Money Payment</a>
                                                                    </li>
                                                                </ul>
                                                            </header>
                                                            <div class="body tab-content">
                                                                <div id="mpesa" class="tab-pane clearfix active col-lg-offset-1">
                                                                    <h2>M-pesa Payment instructions</h2>

                                                                    <p></p>
                                                                    <ol>
                                                                        <li>Dial *150*00# to access your M-pesa Menu</li>
                                                                        <li>Select option 4, for payment</li>
                                                                        <li>Select option 4, to enter business number </li>
                                                                        <li>Enter Business Number <b><?= $bn_number ?></b></li>
                                                                        <li>Enter Reference Number : <b><?= $invoice ?></b></li>
                                                                        <li>Enter amount for your payment Tsh <b><?php // money($price * $students)    ?></b></li>
                                                                        <li>Enter pin to confirm </li>
                                                                    </ol>
                                                                    <p></p>
                                                                    <p>

                                                                    </p>

                                                                </div>
                                                                <div id="tigopesa" class="tab-pane col-lg-offset-1">
                                                                    <h2>Tigo-pesa Payment instructions</h2>

                                                                    <p></p>
                                                                    <ol>
                                                                        <li>Dial *150*01# to access your Tigo pesa Menu</li>
                                                                        <li>Select option 4, for payment</li>
                                                                        <li>Select option 3, to enter business number </li>
                                                                        <li>Enter Business Number <b><?= $bn_number ?></b></li>
                                                                        <li>Enter Reference Number : <b><?= $invoice ?></b></li>
                                                                        <li>Enter amount for your payment Tsh <b><?= money($price * $students) ?></b></li>
                                                                        <li>Enter pin to confirm </li>
                                                                    </ol>
                                                                    <p></p>


                                                                </div>
                                                                <div id="airtel" class="tab-pane col-lg-offset-1">
                                                                    <h2>Airtel Money Payment</h2>
                                                                    <p></p>
                                                                    <p></p>
                                                                    <ol>
                                                                        <li>Dial *150*60# to access your Airtel-Money Menu</li>
                                                                        <li>Select option 5, for payment</li>
                                                                        <li>Select option 4, to enter business number </li>
                                                                        <li>Enter Business Number <b><?= $bn_number ?></b></li>
                                                                        <li>Enter Reference Number : <b><?= $invoice ?></b></li>
                                                                        <li>Enter amount for your payment Tsh <b><?= money($price * $students) ?></b></li>
                                                                        <li>Enter pin to confirm </li>
                                                                    </ol>

                                                                    <p></p>
                                                                    <p>

                                                                    </p>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-default" id="printInvoice"><i class="fa fa-print"></i> Print</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="large-Modal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1050; display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Define Invoice Start & Date</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="#" method="post">
                <div class="modal-body">
                    <form action="#" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    Invoice Start Date
                                    <input type="date" class="form-control"  name="last_payment_date" required>
                                </div>
                                <div class="col-md-6">
                                    Invoice Due Date
                                    <input type="date" class="form-control"  name="next_payment_date" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    Amount To be Paid
                                    <input type="number" class="form-control"  name="amount" value="<?= $unpaid ?>" required>
                                </div>
                                <div class="col-md-6">
                                    Number of Students
                                    <input type="number" class="form-control"  name="student" value="<?= $students ?>" required>
                                    <input type="hidden" name="school" value="<?= $client->username ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                        </div>
                        <?= csrf_field() ?>
                    </form>
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

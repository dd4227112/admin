<?php $root = url('/') . '/public/' ?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <title>ShuleSoft Admin Panel</title>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="ShuleSoft Admin">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="ShuleSoft, Admin , Admin Panel">
    <meta name="author" content="ShuleSoft">
    <script type="text/javascript" src="<?= $root ?>bower_components/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <script type="text/javascript" src="<?= $root ?>bower_components/jquery-ui/jquery-ui.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/icon/icofont/css/icofont.css">
    <!-- flag icon framework css -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/flag-icon/flag-icon.min.css">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/style.css">
    <!--color css-->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/color/color-1.css" id="color"/>


    <script type="text/javascript" src="<?= $root ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/style.css">


    <div class="modal-content">

        <?php if (isset($paid) && (int) $paid == 1) { ?>
            <br/>
            <div class="card table-card widget-success-card">
                <div class="row-table">
                    <div class="col-sm-3 card-block-big">
                        <i class="icofont icofont-tick-mark"></i>
                    </div>
                    <div class="col-sm-9">
                        <h4>Success</h4>
                        <h6>This Invoice have been Paid Already</h6>
                    </div>
                </div>
            </div>
        <?php } else {
            ?>


            <!--<div class="modal-body">-->

            @if ($message = Session::get('warning'))
            <div class="alert alert-top alert-warning alert-dismissable margin5">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Warning:</strong> {{ $message }}
            </div>
            @endif
            <div class=" ">

                <ul class="nav nav-tabs tabs nav nav-tabs md-tabs img-tabs b-none">
                    <li class="active nav-item">
                        <a href="#stats" data-toggle="tab" aria-expanded="true" class="nav-link">M-Pesa </a>
                    </li>
                    <li class="nav-item">
                        <a href="#report" data-toggle="tab" aria-expanded="false" class="nav-link">TigoPesa</a>
                    </li>
                    <li class="nav-item">
                        <a href="#manual" data-toggle="tab" aria-expanded="false" class="nav-link">Airtel Money</a>
                    </li>
                    <li class="nav-item">
                        <a href="#halopesa" data-toggle="tab" aria-expanded="false" class="nav-link">HaloPesa</a>
                    </li>
                    <li class="nav-item">
                        <a href="#ezypesa" data-toggle="tab" aria-expanded="false" class="nav-link">EZYPESA</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tpesa" data-toggle="tab" aria-expanded="false" class="nav-link">T-Pesa</a>
                    </li>
                    <li class="nav-item">
                        <a href="#selcom_card" data-toggle="tab" aria-expanded="false" class="nav-link">SELCOM-CARD</a>
                    </li>
                    <li class="nav-item">
                        <a href="#banking" data-toggle="tab" aria-expanded="false" class="nav-link"> Mobile Banking</a>
                    </li>
                </ul>
                <script>

                </script>
                <div class="tab-content card-block">
                    <div id="stats" class="tab-pane clearfix col-lg-offset-1 active">

                        <h3>M-pesa Payment instructions</h3>

                        <ol>
                            <li>Dial *150*00# to access your M-pesa Menu</li>
                            <li>Select option 4,Lipa by M-pesa</li>
                            <li>Select option 4, to enter business number </li>
                            <li>Enter Business Number <b> 123123</b></li>
                            <li>Enter Reference Number : <b><?= isset($booking->token) ? $booking->token : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>
                            <li>Enter amount for your payment Tsh <b><?= isset($unpaid) ? number_format($unpaid) : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>
                            <li>Enter pin to confirm </li>
                            <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                        </ol>
                        <p></p>
                        <p>

                        </p>

                    </div>
                    <div id="report" class="tab-pane col-lg-offset-1">

                        <h3>Tigo-pesa Payment instructions</h3>

                        <ol>
                            <li>Dial *150*01# to access your Tigo pesa Menu</li>
                            <li>Select option 5, for Merchant payment</li>
                            <li>Select option 2, Pay Mastercard QR Merchant </li>
                            <li>Enter Reference Number : <b><?= isset($booking->token) ? $booking->token : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>
                            <li>Enter amount for your payment Tsh <b><?= isset($unpaid) ? number_format($unpaid) : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>
                            <li>Enter pin to confirm </li>
                            <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                        </ol>
                        <p></p>


                    </div>
                    <div id="manual" class="tab-pane col-lg-offset-1">

                        <h3>Airtel Money Payment</h3>

                        <ol>
                            <li>Dial *150*60# to access your Airtel-Money Menu</li>
                            <li>Select option 5, for payment</li>
                            <li>Select option 1, for Merchant payments  </li>
                            <li>Select option 1, Pay with Mastercard QR</li>
                            <li>Enter amount for your payment Tsh <b><?= isset($booking->amount) ? number_format($booking->amount - $balance) : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>
                            <li>Enter Reference Number : <b><?= isset($unpaid) ? number_format($unpaid) : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>
                            <li>Enter pin to confirm </li>
                            <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                        </ol>



                    </div>
                    <div id="halopesa" class="tab-pane col-lg-offset-1">

                        <h3>HaloPesa Payment</h3>

                        <ol>
                            <li>Dial *150*88# to access your HaloPesa Menu</li>
                            <li>Select option 5, for payment</li>
                            <li>Select option 3, Pay with Mastercard QR</li>
                            <li>Enter Reference Number : <b><?= isset($booking->token) ? $booking->token : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>
                            <li>Enter amount for your payment Tsh <b><?= isset($unpaid) ? number_format($unpaid) : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>

                            <li>Enter pin to confirm </li>
                            <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                        </ol>


                    </div>
                    <div id="ezypesa" class="tab-pane col-lg-offset-1">

                        <h3>EzyPesa Payment</h3>

                        <ol>
                            <li>Dial *150*02# to access your EzyPesa Menu</li>
                            <li>Select option 5, for payment</li>
                            <li>Select option 1, for Lipa Hapa</li>
                            <li>Select option 2, Pay with Mastercard QR</li>
                            <li>Enter Reference Number : <b><?= isset($booking->token) ? $booking->token : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>
                            <li>Enter amount for your payment Tsh <b><?= isset($unpaid) ? number_format($unpaid) : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>

                            <li>Enter pin to confirm </li>
                            <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                        </ol>



                    </div>

                    <div id="tpesa" class="tab-pane col-lg-offset-1">

                        <h3>T-Pesa Payment</h3>

                        <ol>
                            <li>Dial *150*71# to access your T-Pesa Menu</li>
                            <li>Select option 6, for payment</li>

                            <li>Select option 2, Pay with Mastercard QR</li>
                            <li>Enter Reference Number : <b><?= isset($booking->token) ? $booking->token : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>
                            <li>Enter amount for your payment Tsh <b><?= isset($unpaid) ? number_format($unpaid) : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>

                            <li>Enter pin to confirm </li>
                            <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                        </ol>

                        <p></p>
                        <p>

                        </p>

                    </div>
                    <div id="selcom_card" class="tab-pane col-lg-offset-1">

                        <h3>Selcom Card Payment</h3>

                        <ol>
                            <li>Dial *150*50# to access your Selcom Card Menu</li>
                            <li>Enter pin to confirm </li>

                            <li>Select option 2, Pay with Mastercard QR</li>
                            <li>Enter Reference Number : <b><?= isset($booking->token) ? $booking->token : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>
                            <li>Enter amount for your payment Tsh <b><?= isset($unpaid) ? number_format($unpaid) : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>

                            <li>Confirm Payments by entering 1 </li>
                            <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                        </ol>



                    </div>
                    <div id="banking" class="tab-pane col-lg-offset-1">

                        <h3>Pay with mobile banking</h3>
                        <p><img src="https://demo.shulesoft.com/public/assets/images/banks.JPG" width="550"/></p>

                        <ol>
                            <li>Dial  your bank's USSD code </li>
                            <li>Enter pin to confirm </li>

                            <li>Select Mastercard QR</li>
                            <li>Enter Reference Number : <b><?= isset($booking->token) ? $booking->token : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>
                            <li>Enter amount for your payment Tsh <b><?= isset($unpaid) ? number_format($unpaid) : '<span style="color:red;"><u> Not Defined</u></span>' ?></b></li>
                            <li>Confirm Payments by entering 1 </li>
                            <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                        </ol>



                    </div>
                </div>
            </div>

            <!--</div>-->

            <div class="modal-footer">
                <a style="float:left"> For Help Call - <b>+255754406004</b></a>


<!--                <a href="<?= url('/') ?>" class="btn btn-sm btn-danger">Cancel </a>
                <a href="<?= url('epayment/i/' . $booking->id) ?>" class="btn btn-sm btn-success" >Proceed </a>-->

            </div>


        <?php } ?>
    </div>

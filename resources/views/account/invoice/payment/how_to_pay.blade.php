<?php
$invoice_number = 'SASA11E12';
?>

<div class="box">
    <!-- /.box-header -->

    <header>
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#mobile_payments" data-toggle="tab" aria-expanded="true">NMB Mobile</a>
            </li>
            <li class="">
                <a href="#nmb_payments" data-toggle="tab" aria-expanded="false">BRANCH Payment</a>
            </li>
        </ul>
    </header>
    <div class="body tab-content">
        <div id="mobile_payments" class="tab-pane clearfix  col-lg-offset-1">
<div class=" ">
        <header>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#stats" data-toggle="tab" aria-expanded="true">M-Pesa Payment</a>
                </li>
                <li class="">
                    <a href="#report" data-toggle="tab" aria-expanded="false">TigoPesa Payment</a>
                </li>
                <li class="">
                    <a href="#manual" data-toggle="tab" aria-expanded="false">Airtel Money Payment</a>
                </li>
            </ul>
        </header>
        <div class="body tab-content">
            <div id="stats" class="tab-pane clearfix active col-lg-offset-1">
                <h2>M-pesa Payment instructions</h2>

                <p></p>
                <ol>
                    <li>Dial *150*00# to access your M-pesa Menu</li>
                    <li>Select option 4, for payment</li>
                    <li>Select option 4, to enter business number </li>
                    <li>Enter Business Number <b><?= $bn_number ?></b></li>
                    <li>Enter Reference Number : <b><?= $invoice_number ?></b></li>
                    <li>Enter amount for your payment Tsh <b></b></li>
                    <li>Enter pin to confirm </li>
                </ol>
                <p></p>
                <p>

                </p>

            </div>
            <div id="report" class="tab-pane col-lg-offset-1">
                <h2>Tigo-pesa Payment instructions</h2>

                <p></p>
                <ol>
                    <li>Dial *150*01# to access your Tigo pesa Menu</li>
                    <li>Select option 4, for payment</li>
                    <li>Select option 3, to enter business number </li>
                    <li>Enter Business Number <b></b></li>
                    <li>Enter Reference Number : <b><?= $invoice_number ?></b></li>
                    <li>Enter amount for your payment Tsh <b></b></li>
                    <li>Enter pin to confirm </li>
                </ol>
                <p></p>


            </div>
            <div id="manual" class="tab-pane col-lg-offset-1">
                <h2>Airtel Money Payment</h2>
                <p></p>
                <p></p>
                <ol>
                    <li>Dial *150*60# to access your Airtel-Money Menu</li>
                    <li>Select option 5, for payment</li>
                    <li>Select option 4, to enter business number </li>
                    <li>Enter Business Number <b></b></li>
                    <li>Enter Reference Number : <b><?= $invoice_number ?></b></li>
                    <li>Enter amount for your payment Tsh <b></b></li>
                    <li>Enter pin to confirm </li>
                </ol>

                <p></p>
                <p>

                </p>

            </div>

        </div>
    </div>
        </div>
        <div id="nmb_payments" class="tab-pane clearfix active col-lg-offset-1">
<div class="box-body">
        <div class="row">
            <div class="heading">
                <i class="nmb circle-icon circle-teal"></i>
                <h2>NMB BANK</h2>
            </div>

            <section class=" col-md-8">
                <header>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#stats" data-toggle="tab" aria-expanded="true">NMB Mobile</a>
                        </li>
                        <li class="">
                            <a href="#report" data-toggle="tab" aria-expanded="false">BRANCH Payment</a>
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
                        <h3 class="tt" key="nmb1">How to do Payment</h3>

                        <p></p>
                        <ol>
                            <li class="nmb3" key="step1">Dial *150*66# in your phone to open NMB mobile service</li>
                            <li class="nmb3" key="step2">Enter your secret PIN then OK to accept</li>
                            <li class="nmb3" key="step3">Select (5) for Bills Payment</li>
                            <li class="nmb3" key="step4">Select (6) option for </li>
                            <li><span class="nmb3" key="step5">Enter invoice number </span>: <b><?= $invoice_number ?></b></li>
                            <li><span  class="nmb3" key="step6">Enter amount for your payment </span> <b>Tsh </b></li>
                        </ol>

                        <p></p>


                    </div>
                    <div id="report" class="tab-pane col-lg-offset-1">
                        <p></p>
                        <br/>
                        <h3>BRANCH Payment instructions</h3>

                        <p></p>
                        <ol>
                            <li>Visit any nearby NMB BANK branch</li>
                            <li>Make deposit by specify invoice number : <b><?= $invoice_number ?></b> with payment amount of Tsh <b></b></li>
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
                            <li>Make deposit of Tsh <b></b> and specify invoice number : <b><?= $invoice_number ?></b></li>
                        </ol>

                    </div>

                </div>
            </section>
            <div class="col-md-4">
                <h4 class="heading" key="psm">Payment Summary</h4>

            </div>
        </div>
    </div>
        </div>
    </div>
    

    
</div>
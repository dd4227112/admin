@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>

<div class="main-body">
    <div class="page-wrapper">
   
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">

                        <div class="heading">
                            <i class="nmb circle-icon circle-teal"></i>
                            <h2>NMB BANK</h2>
                        </div>

                        <section class=" col-md-8">
                            <header>
                                <ul class="nav nav-tabs">
                                    <li class="active mr-3">
                                        <a href="#stats" data-toggle="tab" aria-expanded="true">NMB Mobile</a>
                                    </li>
                                    <li class="mr-3">
                                        <a href="#report" data-toggle="tab" aria-expanded="false">BRANCH Payment</a>
                                    </li>
                                    <li class="dropdown mr-3">
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
                     
                   

                       <div class="card tab-card">

                        <div class="col-md-4">
                            <h4 class="heading" key="psm">Payment Summary</h4>
                              <?php $invoice_fee = $invoices->invoiceFees()->get(); ?>
                            <table id="user" class="table table-bordered table-striped" style="clear: both">
                                <tbody>
                                   
                                      <?php
                                        $i = 1;foreach ($invoice_fee as $fees) {
                                        ?>
                                     <tr>
                                        <td class="column-left"><span class="s5"  key="pam">Payment Amount</span>:</td>
                                        <td class="column-right">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span  class="s5"  key="psc">Service Charge</span></td>
                                        <td>
                                            Tsh 
                                            charges
                                        </td>
                                    </tr>
                                    <tr>
                                        <?php $am = $invoices->invoiceFees()->sum('amount'); ?>
                                        <td><span class="s5"  key="ptp">Total Amount to Pay</span></td>
                                        <td> Tsh <?=  $am ?>
                                     </td>
                                    </tr>
                                    <tr>
                                        <td><span class="s5"  key="pfm">Payment For</span></td>
                                        <td>
                                        <?= $fees->item_name ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    

                        </div>
                        
                    </div>

                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>

@endsection
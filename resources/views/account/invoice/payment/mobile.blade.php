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
                            <h2> MOBILE Money Payment</h2>
                        </div>

                        <section class="col-md-8">
                            <header>
                                <ul class="nav nav-tabs">
                                    <li class="active mr-4">
                                        <a href="#stats" data-toggle="tab" aria-expanded="true">M-Pesa Payment</a>
                                    </li>
                                    <li class="mr-4">
                                        <a href="#report" data-toggle="tab" aria-expanded="false">TigoPesa Payment</a>
                                    </li>
                                    <li class="mr-4">
                                        <a href="#manual" data-toggle="tab" aria-expanded="false">Airtel Money Payment</a>
                                    </li>
                                </ul>
                            </header> 

                            <?php $am = $invoices->invoiceFees()->sum('amount'); ?>
                            <div class="body tab-content">
                                <div id="stats" class="tab-pane clearfix active col-lg-offset-1">
                                    <h2>M-pesa Payment instructions</h2>
        
                                    <p></p>
                                    <ol>
                                        <li>Dial *150*00# to access your M-pesa Menu</li>
                                        <li>Select option 4, for payment</li>
                                        <li>Select option 4, to enter business number </li>
                                        <li>Enter Business Number <b></b></li>
                                        <li>Enter Reference Number : <b><?= $invoice_number ?></b></li>
                                        <li>Enter amount for your payment Tsh <b><?= money($am) ?></b></li>
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
                                        <li>Enter amount for your payment Tsh <b><?= $am; ?></b></li>
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
                                        <li>Enter amount for your payment Tsh <b><?= $am ?></b></li>
                                        <li>Enter pin to confirm </li>
                                    </ol>
                                    <p></p>
                                  
                                </div>
                            </div>
                        </section>
                     
                       <div class="card tab-card">

                        <div class="col-md-4">
                            <h4 class="heading" key="psm">Payment Summary</h4>
                              <?php $invoice_fee = $invoices->invoiceFees()->first(); ?>
                            <table id="user" class="table table-bordered table-striped" style="clear: both">
                                <tbody>

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
                                        <td> Tsh <?=  $am ?> </td>
                                    </tr>

                                    <tr>
                                        <td><span class="s5"  key="pfm">Payment For</span></td>
                                        <td><?= $invoice_fee->item_name ?></td>
                                    </tr>
                                    
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



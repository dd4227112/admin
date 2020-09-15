@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Invoices</h4>
                <span>Show payments summary</span>

            </div>
        </div>

<div class="card">
        <div class="row">
            <div class="col-sm-3 col-lg-3 col-xs-3 col-md-6">
                <h2> Payment Dates</h2>
               
                <hr/>
                <?php
                $all_payments = $invoice->payments()->get();
                if (isset($all_payments) && count($all_payments) > 0) {


                    //echo print_r($all_payments);exit;
                    foreach ($all_payments as $payment_view) {
                        ?>
                
                <a  href="<?= url('account/receipts/' . $invoice->id . '/' . $payment_view->id) ?>">   
                              <div>

                                    Payer: 
                                    <?= $payment_view->client->name ?>
                                </div>
                                <div class="right">

                                    <span>Bank:  <?= $payment_view->bankAccount->account_name  ?></span><br/>

                                    <span>Date:  <?= date('d M Y ', strtotime($payment_view->date)) ?></span>
                                </div> 
                            
                        </a>
                <hr/>
                        <?php
                    }
                }
                ?>

            </div>
            <!-- /MAIL LIST -->

            <!-- CONTENT MAIL -->
            <div class="col-lg-9 col-xs-9 col-md-6">
                <?php
                $file = 'account.transaction.receipt';
                ?>
                @include("{$file}")
            </div>
            <!-- /CONTENT MAIL -->
        </div>

    </div>
</div>
</div>
@endsection
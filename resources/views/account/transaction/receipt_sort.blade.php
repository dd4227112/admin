@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start 
        <div class="page-header">
            <div class="page-header-title">
                <h4>Receipts</h4>
                <span>Show payments receipt</span>
            </div>
        </div>  -->

        <div class="row">
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
                <p class="text-right" align="right">
                <?php
                    $message = '';
                    $message .= 'Habari ';
                    $message .= 'Receipt kwa ajili ya malipo ya shulesoft';
                    $message .= chr(10);
                    $message .= ' https://admin.shulesoft/customer/sharereceiptwhatsapp/'.$invoice->id.'/receipt';
                    ?>

                     {{-- <a  target="_break" href="<?= url('customer/sharereceiptwhatsapp/'.$invoice->id.'/receipt') ?>" class="btn btn-sm btn-success">View</a> --}}
                   
                     <a href="whatsapp://send?text=<?=$message?>" data-action="share/whatsapp/share" title="Share via Whatsapp">
                        <img src="https://web.whatsapp.com/favicon-64x64.ico">
                    </a>

                       <?php $link = ''; $link .= 'https://admin.shulesoft/customer/ShareReceiptEmail/'.$invoice->id.'/receipt'; ?> 
                    <a href="mailto:?subject=Receipt kwa ajili ya malipo ya shulesoft &amp;body=Open this link <?= $link ?>"
                       title="Share by Email">
                          <img src="http://png-2.findicons.com/files/icons/573/must_have/48/mail.png">
                    </a>
                </p>
            </div>
            <div class="clearfix"></div>
        </div>

         <div class="card">
           <div class="row">
            <div class="col-sm-3 col-lg-3 col-xs-3 col-md-6">
                <h2> Payment Dates</h2>
                <hr/>
                <?php
                $all_payments = $invoice->payments()->get();
                if (isset($all_payments)) {
                   //  echo print_r($all_payments);exit;  
                    foreach ($all_payments as $payment_view) {?>
                 <a  href="<?= url('account/receipts/' . $invoice->id . '/' . $payment_view->id) ?>">   
                    <div> Payer: <?= $payment_view->client->name ?? '' ?> </div>
                    <div class="right">
                    <span>Bank:  <?= $payment_view->bankAccount->account_name  ?></span><br/>
                    <span>Date:  <?= date('d M Y ', strtotime($payment_view->date)) ?></span>
                    </div> 
                  </a>
                     <hr/>
                <?php } 
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
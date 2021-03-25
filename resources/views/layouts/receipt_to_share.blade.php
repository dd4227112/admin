<?php $root = url('/') . '/public/' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Receipt </title>
    <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/dashboard/horizontal-timeline/css/style.css">
</head>
   <body>

                                         <div class="card">
                                                    <h2> Payment Dates</h2>
                                                    <hr/>
                                                    <?php
                                                    $all_payments = $invoice->payments()->get();
                                                    if (isset($all_payments) && count($all_payments) > 0) {
                                                        //echo print_r($all_payments);exit;
                                                     foreach ($all_payments as $payment_view) {?>
                                                    <a  href="<?= url('account/receipts/' . $invoice->id . '/' . $payment_view->id) ?>">   
                                                               <div>
                                                                     Payer: 
                                                                    <?= isset($payment_view->client->name) ? $payment_view->client->name:'' ?>
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

                                                    <div class="card-block">

                                                        <?php
                                                        $file = 'account.transaction.receipt';
                                                        ?>
                                                        @include("{$file}")
                                                    </div>
                                                </div>
                                                <!-- Invoice card end -->
                                            
                                        

</body>

</html>

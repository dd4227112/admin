<?php $root = url('/') . '/public/' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Receipt </title>
    <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/dashboard/horizontal-timeline/css/style.css">
</head>
<body>

    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-block tab-icon">
                    <div id="print_div">

                        <!-- title row -->
                        <div class="row" style="padding-top: 0px">
                            <div class="col-lg-12 col-sm-12">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                              <!-- <img src="{{url('public/assets/images/inets.png')}}" height="90" alt="INETS Company Limtied, ShuleSoft School Management System" style="margin-right: 40%;"> -->
                                                <ul>
                                                    <li style="font-size: 1rem">From</li>
                                                    <li><strong>INETS COMPANY LIMITED</strong></li>

                                                    <li>P.o Box 32282 Dar es Salaam</li>
                                                    <li>2nd Floor,Block NO. 576</li>
                                                    <li>Mbezi Beach Bagamoyo Road</li>
                                                    <li>Mobile no: +255 655/754 406004</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul style="border-left: 1px solid #cccc; padding-left: 3em;">
                                                    <li style="font-size: 1.5rem; font-weght: bold;">To</li>
                                                    <li><strong><?= $invoice->client->name ?></strong></li>

                                                    <li>Phone: <?= $invoice->client->phone ?></li>
                                                    <li>Email: <?= $invoice->client->email ?></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <h1 class="pull-right invoice-title" style="font-size: rem; float: right; ">Invoice</h1>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="col-sm-12 col-lg-12">
                                <table  class="table">
                                    <tr>
                                        <td>Control #</td>
                                        <td><?= strlen($invoice->token) < 4 ? $invoice->reference : $invoice->token ?></td>
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

                            <?php
                            $invoice_fee = $invoice->invoiceFees()->get();
                            ?>
                            <br/>
                            <div class="col-xs-12 col-sm-12 col-lg-12">
                                <table class="table table-bordered table-colapse">
                                    <thead>
                                        <tr>
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
                                                <td><?= $fees->item_name ?>
                                        <li>Training and Support</li>
                                        <li>Unlimited Cloud hosting for School Information</li>
                                        <li>Unlimited bandwidth for users to access</li>

                                        <li>Customization of features based on school requests</li>
                                        <li>Free Technical support for all ShuleSoft users<br/> ( parents, teachers, students and staff)</li>
                                        </td>
                                        <td class="text-center"><?= $fees->quantity ?></td>
                                        <td class="text-center"><?= $fees->unit_price ?></td>
                                        <td class="text-center"><?= money($fees->amount) ?></td>
                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                                <p class="well-sm "><b>Amount in words:</b> <?= number_to_words($unpaid) ?></p>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-12 col-lg-12">

                            </div>
                            <table class="table">
                                <tr>
                                    <td>

                                        <p class="lead">Payment Methods:</p>

                                        <p  >
                                            <b>Account Details :</b><br/>
                                            <b>Account Name:</b> INETS COMPANY LIMITED <br/> <b>Bank Name:</b> NMB BANK PLC <br/>  <b>Account Number:</b> 22510028669
                                            <br/>
                                            <small>Please notify us after a deposit</small>
                                        </p>
                                        <?php if (strlen($invoice->token) > 4) { ?>
                                    <d>Or Pay Electronically here <a href="<?= url('epayment/i/' . $invoice->id) ?>" target="_blank"><?= url('epayment/i/' . ($invoice->id)) ?></a></d>
                                <?php } ?>
                                <!-- <br/>
                                <b>If you make a bank deposit, you will have to notify us to activate your account</b> -->
                                <p class="text-muted well well-sm no-shadow">
                                    Thank you for your business. we're glad to serve you
                                </p>
                                </td>
                                <td>
                                    <b>Summary</b>

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
                                </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          </div>  
       </div>
</body>
</html>
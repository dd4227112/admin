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
        <style>
            #valid-msg {
                color: #00C900;
            }
            #error-msg {
                color: red;
            }

        </style>
        <?php
        $bn_number = 888999;
        ?>

        <?php
        $message = '';
        $message .= 'Habari ';
        $message .= 'Fungua invoice ya malipo ya shulesoft';
        $message .= ' ya tarehe '.date('d M Y',strtotime($invoice->date)).'';
        $message .= chr(10);
        $message .= 'https://admin.shulesoft/customer/shareinvoicewhatsapp/'.$invoice->id.'';
        ?>
        
        <div class="page-body">
            <div class="row">
                <div class="col-lg-6"></div>
                <div class="col-lg-6">
                    <p class="text-right" align="right">
                        <a class="btn btn-secondary btn-sm" href="#" data-toggle="modal" data-target="#large-Modal"> Edit </a>
                        <a href="#" id="printInvoice" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Print </a>

                       
                        <a href="whatsapp://send?text=<?=$message?>" data-action="share/whatsapp/share" 
                            onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on whatsapp">
                            <img width="50" src="https://web.whatsapp.com/favicon-64x64.ico">
                        </a>

                        <?php $link = ''; $link .= 'https://admin.shulesoft/customer/ShareInvoiceEmail/'.$invoice->id; ?> 
                        <a href="mailto:?subject=Invoice kwa ajili ya malipo ya shulesoft &amp;body=Open this Link:<?= $link ?>"
                           title="Share by Email">
                              <img src="http://png-2.findicons.com/files/icons/573/must_have/48/mail.png">
                        </a>
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>

            
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
                                                <td colspan="2"> </td>
                                            </tr>

                                            <tr>
                                                <td>Start Date #</td>
                                                <td><?=date('d M Y', strtotime('-30 day', strtotime($invoice->due_date))) ?> </td>
                                               
                                                <td>Due Date #</td>
                                                <td><?= date('d M Y', strtotime($invoice->due_date)) ?></td>
                                            </tr>
                                            <tr>
                                                <td>TOTAL DUE</td>
                                                <td>  <?php
                                                    $am = $invoice->invoiceFees()->sum('amount');
                                                    $paid = $invoice->payments()->sum('amount');
                                                    $unpaid = $am - $paid;
                                                    ?><b class="amnt-value">Tsh <?= number_format($unpaid) ?></b>
                                                </td>
                                                <td colspan="2"> </td>
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
                                        <p class="well-sm "><b>Amount in words:</b> <?= number_to_words($unpaid) ?>    </p>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-12 col-lg-12">

                                    </div>

                                    <table class="table">
                                        <tr>
                                            <td>
                                                <?php 
                                                $a  = [];
                                                        $setting = DB::table('admin.all_setting')->where('schema_name', $invoice->client->username)->first();
                                                        if(!empty($setting)) {
                                                           $a = DB::table($invoice->client->username. '.bank_accounts')->where('refer_bank_id', 22)->first();
                                                        } 
<<<<<<< HEAD
                                                 ?>
                                                  <p>
                                                    <b>Account Details :</b><br/>
                                                    <b>Account Name:</b> INETS COMPANY LIMITED <br/> 
                                                    <b>Bank Name:</b> NMB BANK PLC <br/> 
                                                     <b>Account Number:</b> 22510028669
                                                    <br/>
                                                    <small>Please notify us after a deposit</small>
                                                  </p>
                                                 
=======
                                                 if(!empty($a)){ ?>
                                                
                                                  <?php }else { ?>
                                                    <p>
                                                        <b>Account Details :</b><br/>
                                                        <b>Account Name:</b> INETS COMPANY LIMITED <br/> 
                                                        <b>Bank Name:</b> CRDB BANK PLC <br/> 
                                                         <b>Account Number:</b> 120922510028669
                                                        <br/>
                                                        <small>Please notify us after a deposit</small>
                                                    </p>
                                                  <?php  }  ?>
>>>>>>> 26bd8e5c43ae29c6f7c96daff985be28d3d264ec

                                                <?php if (strlen($invoice->token) > 4) { ?>
                                                <p>Or Pay Electronically here <a href="<?= url('epayment/i/' . $invoice->id) ?>" target="_blank"><?= url('epayment/i/' . ($invoice->id)) ?></a></p>
                                              <?php } ?>
                                        <!-- <br/>
                                        <b>If you make a bank deposit, you will have to notify us to activate your account</b> -->
                                        <?php if($diff_in_months <= 12) { ?>
                                        <p class="text-muted well well-sm no-shadow">
                                            This is the payment for shulesoft system for <?=$diff_in_months > 1 ? number_to_words($diff_in_months).' months' : number_to_words($diff_in_months).' month'?>. <br>
                                            Thank you for your business. we're glad to serve you
                                        </p>
                                        <?php } else { ?>
                                            <p class="text-muted well well-sm no-shadow">
                                              Thank you for your business. we're glad to serve you
                                            </p>
                                        <?php } ?>
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


                                    <table class="table">
                                        <tr>
                                               
                                            <?php  {  ?>
                                                <a href="<?= url('PaymentController/index/' . $invoice->id . '/nmbbank') ?>" class="mr-4">
                                                <img src="<?= url('public/assets/images/account/nmb.jpg') ?>" alt="NMB channels" width="60" height="60"></a>
                                        
                                                <a href="<?= url('PaymentController/index/' . $invoice->id . '/mobile') ?>" class="mr-4">
                                                    <img src="<?= url('public/assets/images/account/mpesa.jpg') ?>" alt="M-pesa" width="60" height="60"></a>
                                                <a href="<?= url('PaymentController/index/' . $invoice->id . '/mobile') ?>" class="mr-4">
                                                    <img src="<?= url('public/assets/images/account/tigo.jpg') ?>" alt="TigoPesa" width="60" height="60"></a>
                                                <a href="<?= url('PaymentController/index/' . $invoice->id . '/mobile') ?>" class="mr-4">
                                                    <img src="<?= url('public/assets/images/account/airtel.jpg') ?>" alt="Airtel Money" width="60" height="60">
                                                </a>
                                                <a href="" class="mr-4">
                                                    <img src="<?= url('public/assets/images/account/paypal.png') ?>" alt="Pay Pal" width="60" height="60">
                                                </a>

                                                <a href="" class="mr-4">
                                                    <img src="<?= url('public/assets/images/account/paycard.jpg') ?>" alt="Pay Pal" width="60" height="60">
                                                </a>
                                              <?php } ?>
                                           </tr>
                                         </table>
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
                            <h4 class="modal-title">Edit This Invoice</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <?php
                        $invoice_fee = $invoice->invoiceFees()->first();
                        ?>
                        <div class="modal-body">
                      
                                <form action="<?=url('Account/editInvoice/'.$invoice_fee->invoice_id)?>" method="post">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Quantity
                                                <input type="text" class="form-control"  name="quantity" value="<?= $invoice_fee->quantity ?>">
                                            </div>
                                            <div class="col-md-6">
                                                Price
                                                <input type="text" class="form-control"  name="price" value="<?= $invoice_fee->unit_price ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" name="invoice_id" id="invoice_id" value="<?= $invoice_fee->invoice_id ?>">
                                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Edit</button>
                                    </div>
                                    <?= csrf_field() ?>
                                </form>
           
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
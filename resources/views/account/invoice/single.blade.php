@extends('layouts.app')

@section('content')
<style>
    @media print {
        a[href]:after {
            content: none !important;
        }
        #myTab {display: block !important; opacity: 1 !important;}
        table,thead,tbody,tr,td,th {border: 1px solid black !important;}
        #invoice_name{font-size: 15px !important; font-weight: bolder}
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
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Invoices</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">

                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">


                        <div class="card-block">


                            <div class="row">

                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Invoice
                                            <span class=" pull-right">
                                                <div class="tab-pane">
                                                    <div style="">
                                                        <?php if ($invoice->status <> 1) { ?>  <a href="<?= url('payment/add?id=' . $invoice->id) ?>" class="btn btn-danger btn-sm"><i class="fa fa-money"></i> Add Payment </a>
                                                        <?php } ?>
                                                        <a href="#" onmousedown="print_page()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Print </a>
                                                    </div>
                                                </div>
                                            </span>
                                        </header>
                                        <div class="">
                                            <div class="col-md-12">
                                                <div class="panel-body invoice">
                                                    <div class="invoice-header">
                                                        <div class="invoice-title col-md-3 col-xs-2">
                                                            <h1 id="invoice_name">invoice</h1>
                                                        </div>
                                                        <div class="invoice-info col-md-9 col-xs-10">

                                                            <div class="pull-right">
                                                                <div class="col-md-6 col-sm-6 pull-left">
                                                                    <p>INETS CO LTD <br>
                                                                        11th Block, Bima Road, Mikocheni B, Dar es salaam ,<br>
                                                                        P.o Box 32258, Dar es salaam</p>
                                                                </div>

                                                                <div class="col-md-6 col-sm-6 pull-right">
                                                                    <p>Tel: +255 655 406004<br>
                                                                        Email : info@inetstz.com</p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="row invoice-to">

                                                        <div class="col-md-6 col-sm-6 pull-left">
                                                            <h4>Invoice To:</h4>
                                                            <h5><?= $invoice->client->name ?></h5>
                                                            <p>  
                                                                Phone: <?= $invoice->client->phone ?><br>
                                                                Email : <?= $invoice->client->email ?>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 pull-right">
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-5 inv-label">Control #</div>
                                                                <div class="col-md-8 col-sm-6"><b style="font-size: 17px"><?= $invoice->reference ?></b></div>  
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-5 inv-label">Date #</div>
                                                                <div class="col-md-8 col-sm-7"><?= date('d M Y', strtotime($invoice->date)) ?></div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-5 inv-label">
                                                                    <b>TOTAL DUE</b>
                                                                </div>
                                                                <div class="col-md-8 col-sm-7">
                                                                    <?php
                                                                    $am = $invoice->invoiceFees()->sum('amount');

                                                                    $paid = $invoice->payments()->sum('amount');

                                                                    $unpaid = $am - $paid;
                                                                    ?>

                                                                    <b class="amnt-value">Tsh <?= number_format($unpaid) ?></b>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <?php
                                                    $invoice_fee = $invoice->invoiceFees()->get();
                                                    ?>
                                                    <br/>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
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
                                                                <td><?= $i ?></td>
                                                                <td><?= $fees->item_name?></td>
                                                                <td class="text-center"><?= $fees->quantity ?></td>
                                                                 <td class="text-center"><?= $fees->unit_price ?></td>
                                                                <td class="text-center"><?= money($fees->amount)?></td>
                                                            </tr>
                                                              <?php }?>

                                                        </tbody>
                                                    </table>

                                                    <div class="row">
                                                        <div class="col-md-8 col-xs-7 payment-method">

                                                            <p><b style="color:#0066cc">FOR BANKS</b>
                                                                <br/>
                                                                Use the INVOICE NUMBER to make payments in the Bank selected, thereafter a confirmation SMS & email will be sent to the mobile number and email.
                                                                <br/>
                                                                <b>(You are advised to print this invoice and submit it to the bank along with the appreciate amount)</b>


                                                            </p>
                                                       
                                                            <br/><p><b  style="color:#0066cc">NB;</b><br/>
                                                                in case you face any challenge, please call +255 655 406004</p>

                                                            <br>

                                                        </div>
                                                        <div class="col-md-4 col-xs-5 invoice-block pull-right">
                                                            <ul class="unstyled amounts">


                                                                <li>Sub - Total amount : <?= number_format($am) ?></li>
                                                                <li>Paid Amount : <?= $paid > 0 ? $paid : 0 ?> </li>
                                                                <li>Discount :___ </li>
                                                                <li class="grand-total">Grand Total : Tsh <?= number_format($unpaid) ?></li>
                                                            </ul>
                                                        </div>
                                                    </div>



                                                </div>

                                            </div>
                                        </div>
                                    </section>
                                </div>

                            </div>
                            <script type="text/javascript">
                                print_page = function () {
                                    $('#head_one,#tab_panel_heading').hide();
                                    $('.widget-header, .btn, .breadcrumb, .clearfix').hide();
                                    $('#myTab').removeClass('nav-tabs');
                                    $('#myTab').removeClass('bar_tabs');
                                    window.print();
                                    $('#head_one,#tab_panel_heading').show();
                                    $('.widget-header, .btn, .breadcrumb, .clearfix').show();
                                    $('#myTab').addClass('nav-tabs');
                                    $('#myTab').addClass('bar_tabs');
                                }</script>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>
@endsection

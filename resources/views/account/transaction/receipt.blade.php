@extends('layouts.app')

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
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Company Invoices</h4>
        <span>Show payments summary</span>

      </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->


    <style>

    #valid-msg {
      color: #00C900;
    }
    #error-msg {
      color: red;
    }
    @media print {
      #setup_notifications {
        display: none !important;
      }
      /*                #print_div{
      padding-left:20em;
      }*/
      .table-header{
        background-color: #aaaaaa !important;
      }

    }
    </style>
    <?php
    $bn_number = 888999;
    ?>
    <section   class="content invoice" style=" margin: 0px auto; padding-left: 10%; padding-right: 10%; page-break-inside: avoid;">
      <div class="nav_menu no-print">

        <div class="page-body">
          <div class="row">
            <div class="col-md-12 col-xl-12">
              <div class="card">
                <div class="x_content" id="print_div">

                  <!-- title row -->
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="table-responsive dt-responsive">
                        <table id="dt-ajax-array" class="table">
                          <tbody>
                            <tr>
                              <td>
                                <img src="{{url('public/assets/images/inets.png')}}" height="140" alt="INETS Company Limtied, ShuleSoft School Management System" style="margin-right: 40%;">
                              </td>
                              <td>
                                <ul>
                                  <li style="font-size: 1em;"><strong>INETS COMPANY LIMITED</strong></li>
                                  <li>TIN 122-866-750</li>
                                  <li>P.o Box 33287 Dar es Salaam  </li>
                                  <li> 2nd Floor,Block NO. 576</li>
                                  <li>Mbezi Beach Bagamoyo Road</li>
                                  <li>Mobile no: +255 655 406 004 </li>
                                  <li>Telephone: +255 22 278 0228</li>
                                </ul>
                              </td>
                              <td>
                                <h1 class="pull-right invoice-title" style="font-size: rem; float: right; margin-left: 60%"></h1>
                              </td>
                            </tr>
                            <tbody>
                            </table>
                          </div>
                          <!-- /.col -->

                          <?php
                          $i = 0;
                          if (count($revenue) > 0) {
                            ?>
                            <?php if (isset($revenue) && count($revenue) > 0) { ?>

                              <div class="table-responsive dt-responsive">
                                <table id="dt-ajax-array" class="table">
                                  <tbody>
                                    <tr>
                                      <td>
                                        &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp;<strong>RECEIPT NO:</strong><b> <?= $revenue->number ?></b>
                                      </td>
                                      <td>
                                        <strong>Date:</strong><b><?= date('d M Y ', strtotime($revenue->date)) ?> </b>
                                      </td>
                                    </tr>
                                    <tbody>
                                    </table>
                                  </div>

                                  <br/><br/>
                                  <div class="col-lg-12 col-md-12 col-sm-12">

                                    <div class="ttl-amts">
                                      Received from
                                      <span style="padding-left:100px;padding-right: 30px; font-weight:bold; text-transform:uppercase">
                                        <?= $revenue->payer_name ?> </span><hr/>
                                      </div>

                                      <div class="ttl-amts">
                                        Amount in words

                                        <span style="padding-left:85px;padding-right: 50px; font-weight:bold; text-transform:uppercase">
                                          <?php
                                          $amount = money($revenue->amount);
                                          $am = (double) str_replace(',', NULL, $amount);
                                          echo number_to_words($am);
                                          ?>   ONLY</span><hr/>
                                        </div>
                                        <div class="ttl-amts">
                                          Being Payment for
                                          <span style="padding-left:76px;padding-right: 50px; font-weight:bold; text-transform:uppercase">
                                            <?php
                                            echo $revenue->referExpense->name;
                                            ?>
                                          </span> <hr />
                                        </div>

                                        <div class="ttl-amts">
                                          By cash/cheque No
                                          <span style="padding-left:65px; font-weight:bold;padding-right: 50px; text-transform:uppercase">
                                            <?= $revenue->transaction_id . '-' . $revenue->payment_method; ?> </span> <hr/>
                                          </div>
                                          <div class="ttl-amts">

                                            <div style="padding-left:15%;">
                                              <div style="z-index: 5000">
                                                <img src="<?= url('public/images/company_seal.png') ?>"
                                                width="200" height="150"
                                                style="position:relative; margin-left: 3px; float:right;">
                                              </div>
                                            </div>
                                          </div>

                                          <div class="ttl-amts">
                                            Tshs: <b><?= money($revenue->amount) ?>/- </i></b>
                                            <span style="padding-left:75px; font-weight:bold;padding-right: 50px; text-transform:uppercase">
                                                NON.REFUNDABLE </span> <hr/>
                                            </div>
                                            
                                            <div class="ttl-amts">
                                              <br>
                                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px; text-align: center">
                                              Thank you for your business. we're glad to serve you.
                                            </p>
                                            </div>
                                          </div>


                                        </section>
                                        <button class="btn btn-default" id="printInvoice"><i class="fa fa-print"></i> Print</button>

                                        <?php
                                      } else {


                                        echo'There is an issue in this receipt';
                                      }
                                      ?>

                                      <br><br>
                                    <?php }?>
                                  </div>
                                </div>
                                <div class="col-sm-1"></div>
                                <!-- /MAIL LIST -->
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

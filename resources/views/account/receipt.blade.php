@extends('layouts.app')
@section('content')
<div class="main-body">
  <div class="page-wrapper">
    <div class="page-header">
      <div class="page-header-title">
        <h4>Charts of Accounts </h4>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Accounts</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Charts of Account</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="page-body">
      <!-- form start -->
      <div class="page-body">
        <div class="card">
          <p></p>
          <p></p>
          <div class="col-sm-12">

            &nbsp;  <h5 class="page-header">

              <a class="btn btn-success" href="#" type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#large-Modal">
                <i class="fa fa-plus"></i>
                Add New Account
              </a>
            </h5>
            <div class="table-responsive dt-responsive ">
              <div class="row">
                <div class="col-sm-6">


                  <button class="btn btn-xs btn-success" onclick="javascript:printDiv('printablediv')"><span class="fa fa-print"></span> <?= $data->lang->line('print') ?> </button>
                  <a class="btn btn-xs btn-danger" href="{{url('revenue/index/' . $revenue->refer_expense_id . "/")}}"><i class="fa fa-edit"></i> Return Back</a>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb">
                    <button class="btn-default btn-cs btn-sm-cs" data-toggle="modal" data-target="#report_setting_model"><span class="fa fa-gear"></span> Options</button>

                  </ol>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-sm-1"></div>
              <div class="col-sm-10 mail_list_column" id="payment_lists">
                <?php
                /**
                * @author Ephraim Swilla <ephraim@inetstz.com>
                */
                $school = $siteinfos;
                ?>
                <div id="printablediv">
                  <?php
                  if (count($revenue) > 0) {
                    for ($i = 0; $i < $receipt_setting->copy_to_print; $i++) {
                      ?>
                      <?php if (isset($revenue) && count($revenue) > 0) { ?>
                        <section   class="content invoice" style=" margin: 0px auto; padding-left: 10%; padding-right: 10%; page-break-inside: avoid;">
                          <div class="row text-center">
                            <?php
                            if ($i > 0) {
                              ?>
                              <p align="left" style="font-weight: bolder; font-size: 16px">COPY</p>
                            <?php } ?>
                            <div class="row pad-top-botm ">
                              <div class="col-lg-2">
                                <img src="<?= base_url('storage/uploads/images/default.jpg') ?>"  width="80px" height="80px"/>
                              </div>
                              <div class="col-lg-8" style="font-family:tahoma; font-size:15px; display:block;">

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
                                  <div class="col-lg-3 col-md-3 col-sm-3">
                                  </div>
                                </div>

                                <br/>
                                <div  class="row">
                                  <div class="col-lg-8">
                                    <h1 align="right"><strong>INVOICE NO:</strong><b> <?= $revenue->invoice_number ?></b>, &nbsp; &nbsp; <strong>RECEIPT NO:</strong><b> <?= $revenue->number ?></b></h1>
                                  </div>

                                  <div class="col-lg-4">
                                    <h4 align="right">  <strong>Date:</strong><b><?= date('d M Y ', strtotime($revenue->date)) ?> </b>
                                    </div>
                                  </div>

                                  <br/><br/>
                                  <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                      <div class="ttl-amts">
                                        Received from
                                        <span style="padding-left:50px;padding-right: 30px; font-weight:bold; text-transform:uppercase">
                                          <?= $revenue->payer_name ?></span><hr/>
                                        </div>

                                        <div class="ttl-amts">
                                          Amount in words

                                          <span style="padding-left:20px;padding-right: 50px; font-weight:bold; text-transform:uppercase">
                                            <?php
                                            $amount = money($revenue->amount);
                                            $am = (double) str_replace(',', NULL, $amount);
                                            echo number_to_words($am);
                                            ?>   ONLY</span><hr/>
                                          </div>

                                          <div class="ttl-amts">
                                            Being Payment for
                                            <span style="padding-left:80px;padding-right: 50px; font-weight:bold; text-transform:uppercase">
                                              <?php
                                              echo $revenue->referExpense->name;
                                              ?>
                                            </span> <hr />


                                          </div>

                                          <div class="ttl-amts">
                                            By cash/cheque No
                                            <span style="padding-left:80px; font-weight:bold;padding-right: 50px; text-transform:uppercase">
                                              <?= $revenue->transaction_id . '-' . $revenue->payment_method; ?> </span> <hr/>
                                            </div>

                                          </div>

                                          <div class="responsive-table">
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="responsive-table">
                                            <table class="table "  style="padding-top: 20px">
                                              <tbody>
                                                <tr>
                                                  <td style=""><?= $siteinfos->currency_symbol ?>:</td>
                                                  <td style="text-align: center;color: black"><b><?= money($revenue->amount) ?>/=</b></td>
                                                  <td style="padding-left: 20px;">NON REFUNDABLE</td>
                                                  <td colspan="4" style="width: 40%; padding-left:20px">------<?php
                                                  if ($receipt_setting->show_digital_signature) {
                                                    $column = $revenue->user_table == 'student' ? 'student_id' : $revenue->user_table . 'ID';
                                                    if ((int) $revenue->user_id > 0) {
                                                      $setting = \DB::table($revenue->user_table)->where($column, $revenue->user_id)->first();
                                                    } else {
                                                      $setting = \App\Model\Setting::first();
                                                    }
                                                    ?>
                                                    <img src="<?= $setting->signature ?>" width="75"
                                                    height="54">
                                                  <?php } ?>---------<br>With Thanks      <div style="margin-left: -100%;  margin-top: -27%;">

                                                    <div style="padding-left:5%;">

                                                      <div style="z-index: 4000">
                                                        <div style="float: right; margin-right: 4%; margin-top: 4%;"></div>
                                                        <div>

                                                          <?php
                                                          if ((int) $receipt_setting->show_school_stamp == 1) {
                                                            $path = "storage/uploads/images/stamp_" . set_schema_name() . "png";
                                                            ?>

                                                            <img src="<?= base_url($path) ?>"
                                                            width="100" height="100"
                                                            style="position:relative; margin:-17% 15% 0 0; float:right;">
                                                          <?php } ?>
                                                        </div>

                                                      </div>


                                                    </div>
                                                  </div></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div><br>-----------------------------------------------------------------------------------------------------------------
                                        <br>
                                      </section>
                                      <?php
                                    } else {


                                      echo'There is an issue in this receipt';
                                    }
                                    ?>

                                    <br><br>
                                  <?php }}?>
                                </div>
                              </div>
                              <div class="col-sm-1"></div>
                              <!-- /MAIL LIST -->
                            </div>
                          </div>
                          <script language="javascript" type="text/javascript">
                          function printDiv(divID) {
                            if (document.all) {
                              document.all.well.style.display = 'none';
                              document.all.topnav.style.display = 'none';
                              window.print();
                              document.all.well.style.visibility = 'visible';
                              document.all.topnav.style.visibility = 'visible';
                            } else {
                              document.getElementById('well').style.display = 'none';
                              document.getElementById('topnav').style.display = 'none';
                              $('.well,#topnav').hide();
                              window.print();
                              $('.well,#topnav').show();
                            }
                          }
                          </script>
                        </div>
                      </div>
                    </div>
                    <script type="text/javascript">

                    function fill_form(id) {
                      $('#code').val($('#code'+id).text());
                      $('#chart_name').val($('#name'+id).text());
                      $('#note').text($('#note'+id).text());
                      $('#expense_id').val(id);

                    }
                    $('#financial_category_id').change(function () {
                      var financial_category_id = $(this).val();

                      if (financial_category_id ==='0') {

                      } else {
                        $.ajax({
                          type: 'POST',
                          url: "<?= url('account/checkCategory') ?>",
                          data: {"financial_category_id": financial_category_id },
                          dataType: "html",
                          success: function (data) {
                            $('#account_group_id').html(data);

                          }
                        });
                      }
                    });
                  </script>
                  @endsection

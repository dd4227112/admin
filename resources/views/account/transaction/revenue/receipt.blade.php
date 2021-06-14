@extends('layouts.app')

@section('content')

<title>Receipt</title>

<?php
$receipt_setting = \DB::table('receipt_settings')->first();
$template = $receipt_setting->template;
$file = 'invoices.receipt_templates.' . $template;
?>
<div class="main-body">
    <div class="@if(!isset($balance))  page-wrapper @endif">
    <div class="page-body">
           
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-block tab-icon">
                            <div id="print_div">
                                <div class="row" style="padding-top: 0px">

                                    <div class="well col-sm-12"  id="well">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button class="btn btn-xs btn-success" onclick="javascript:printDiv('printablediv')"><span class="fa fa-print"></span> <?= ('print') ?> </button>
                                                <a class="btn btn-xs btn-danger" href="{{url('revenue/index')}}"><i class="fa fa-edit"></i> Return Back</a>
                                            </div>
                                            <div class="col-sm-6">
                                              
                                            </div> 
                                        </div>
                                    </div>


                                    <div class="row col-sm-12">
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-10 mail_list_column" id="payment_lists">
                                            <?php
                                            /**
                                             * @author Ephraim Swilla <ephraim@inetstz.com>
                                             */
                                            //$school = $siteinfos;
                                            ?>
                                            <div id="printablediv"> 
                                            <?php
                                            if (!empty($revenue)) {   
                                            //  for ($i = 0; $i < $receipt_setting->copy_to_print; $i++) {
                                                    ?>
                                                    <?php if (isset($revenue) && !empty($revenue)) { ?>
                                                        <section   class="content invoice" style=" margin: 0px auto; padding-left: 10%; padding-right: 10%; page-break-inside: avoid;">
                                                    <div class="row text-center">
                                               <?php /*
                                                if ($i > 0) {
                                                    ?>
                                                    <p align="left" style="font-weight: bolder; font-size: 16px">COPY</p>
                                                <?php } */ ?>
                                                            <div class="row pad-top-botm ">
                                                            
                                                                <div class="col-sm-12" style="font-family:tahoma; font-size:15px; display:block;">
                            
                                                                    <b  style="font-family:tahoma;font-size:20px; display:block;"><?= $revenue->payer_name ?></b><br>  
                            
                                                                    {{-- <i> &nbsp;&nbsp;<?= $invoice->client->address ?></i>,&nbsp; --}}
                                                                  
                            
                                                                    <i><b>Mob:</b><?= $revenue->payer_phone ?></i>.&nbsp;&nbsp;<br>
                            
                                                                    <i><b> Email: </b><?= $revenue->payer_email ?></i>&nbsp;<br>
                            
                                                                </div> 
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3">              
                                                            </div>
                                                        </div>
                            
                                                        <br/>
                                                        <div  class="row">
                                                            <div class="col-lg-7">
                                                                <h6 align="right"><strong>INVOICE NO:</strong><b> <?= $revenue->invoice_number ?> </b>, &nbsp; &nbsp; <strong>RECEIPT NO:</strong><b> <?= $revenue->number ?></b></h6>
                                                            </div>
                                                           
                                                            <div class="col-lg-5">
                                                                <h6 align="right">  <strong>Date:</strong><b><?= date('d M Y ', strtotime($revenue->date)) ?> </b> </h6>
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
                                                                            <td style=""><?= $revenue->bank_account_id ?>:</td>
                                                                            <td style="text-align: center;color: black"><b><?= money($revenue->amount) ?>/=</b></td>
                                                                            <td style="padding-left: 20px;">NON REFUNDABLE</td>
                                                                            <td colspan="4" style="width: 40%; padding-left:20px">------<?php
                                                                                if ($receipt_setting->show_digital_signature) {
                                                                                  //  $column = $revenue->user_table == 'student' ? 'student_id' : $revenue->user_table . 'ID';
                                                                                    // if ((int) $revenue->user_id > 0) {
                                                                                    //     $setting = \DB::table($revenue->user_table)->where($column, $revenue->user_id)->first();
                                                                                    // } else {
                                                                                       $setting = \App\Models\Setting::first();
                                                                                    }
                                                                                    ?>
                                                                                    <img src="<?= $setting->signature ?? '' ?>" width="75"
                                                                                         height="54">
                                                                                <?php } ?>---------<br>With Thanks     
                                                                                 <div style="margin-left: -100%;  margin-top: -27%;">
                            
                                                                                    <div style="padding-left:5%;">
                            
                                                                                        <div style="z-index: 4000">
                                                                                            <div style="float: right; margin-right: 4%; margin-top: 4%;"></div>
                                                                                            <div>
                            
                                                                                                <?php
                                                                                                if ((int) $receipt_setting->show_school_stamp == 1) {
                                                                                                //     $path = "storage/uploads/images/stamp_" . set_schema_name() . "png";
                                                                                                //     ?>
                            
                                                                                                     <img src=""
                                                                                                          width="100" height="100"
                                                                                                          style="position:relative; margin:-17% 15% 0 0; float:right;">
                                                                                                      <?php } 
                                                                                                     ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
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
                                        
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        <!-- /MAIL LIST -->
                                    </div>
                                 
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>  
              </div>
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
    <div class="modal fade" id="report_setting_model">
        <div class="modal-dialog">
            <form method="post" action="#" class="form-horizontal" role="form">
                <input type="hidden" name="id" value="<?= $receipt_setting->id ?>"/>
                <div class="modal-content">

                    <div class="modal-header">
                        Receipt Settings
                    </div>
                    <?php
                    $vars = get_object_vars($receipt_setting);
                    ?>
                    <div class="modal-body" > 
                        <table class="table table-hover">
                            <?php
                            foreach ($vars as $key => $variable) {
                                if (!in_array($key, array('id', 'created_at', 'updated_at', 'available_templates', 'show_class', 'show_installment', 'show_balance', 'show_stream'))) {
                                    $name = ucfirst(str_replace('_', ' ', $key));
                                    $final_name = str_replace('pos', 'position', $name);
                                    $lname = str_replace('classteacher', 'class teacher ', $final_name);
                                    ?>
                                    <tr style="border-bottom:1px solid whitesmoke">
                                        <td style="padding-left:5px;">
                                            <h4><?= $lname ?></h4>
                                        </td>
                                        <td>
                                            <?php
                                            if (is_integer($variable) && $variable == 1) {
                                                ?>
                                                <input type="checkbox" name="<?= $key ?>" checked="checked" onchange="this.value = this.checked ? 1 : 0" value="1"/>
                                            <?php } else if ((is_integer($variable) && $variable == 0) || $variable == '') { ?>
                                                <input type="checkbox" onchange="this.value = this.checked ? 1 : 0" name="<?= $key ?>"  value="1"/>
                                                <?php
                                            } else if ($key == 'template') {
                                                $physical = [];
                                                $temps = explode(',', $receipt_setting->available_templates);
                                                foreach ($temps as $temp) {
                                                    $physical[$temp] = $temp;
                                                }

                                                echo form_dropdown("template", $physical, old("template", $receipt_setting->template), "id='template' class='form-control select2'");
                                                ?>

                                            <?php } else {
                                                ?>
                                                <input type="text" name="<?= $key ?>" value="<?= $variable ?>"/>
                                            <?php } ?>
                                        </td>

                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                        </table>   
                    </div>


                    <div class="modal-footer">
                        <button type="button" style="margin-bottom:0px;" class="btn btn-default" data-dismiss="modal" onclick="javascript:closeWindow()"><?= ('close') ?></button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                    <?= csrf_field() ?>
            </form>
        </div>
    </div>
</div>
@endsection
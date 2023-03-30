@extends('layouts.app')
@section('content')
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title" id="payment_receipt_title">
                <h2>Payment Receipts</h2>

                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="row">
                    <div class="col-sm-3 mail_list_column" id="payment_lists">
                        <h2> Payment Dates</h2>
                        <br/><hr/>
                        <?php
                        
                     
                        if (isset($all_payments) && !empty($all_payments)) {
                            
                            
                            //echo print_r($all_payments);exit;
                            foreach ($all_payments as $payment_view) {
                                ?>

                                <?php if ((int)$invoice_id > 0) { ?> 

                                    <a href="<?= base_url('invoices/receipt/' . $invoice_id . '/' . $academic_year_id . '/' . $payment_view->id) ?>">   

                                    <?php } ?>


                                    <div class="mail_list  ">
                                        <div>

                                            Payer: 
                                            <?= $payment_view->student->name ?>
                                        </div>
                                        <div class="right">

                               <h3>Bank:  <?= $payment_view->bankAccount->name ?><small>

                                  <?= date("d M Y", strtotime($payment_view->date)) ?></small></h3>

                                            <span>Recorded Date:  <?= date('d M Y ', strtotime($payment_view->created_at)) ?></span>
                                        </div> 
                                    </div>
                                </a>
                                <?php
                            }
                        }
                       
                        ?>

                    </div>
                    <!-- /MAIL LIST -->

                    <!-- CONTENT MAIL -->
                    <div class="col-sm-9 mail_view">



                        <div class="inbox-body">



                            <div class="view-mail">
                                <?php
                               
                                $receipt_setting = \DB::table('receipt_settings')->first();
                                if(empty($receipt_setting)){
                                    $sql = 'INSERT INTO ' . set_schema_name() . 'receipt_settings(
                                        show_installment, created_at, updated_at, show_class, template, available_templates, show_single_fee, show_balance, copy_to_print, show_digital_signature, show_school_stamp, show_stream, show_fee_amount)
                                    select 	show_installment, created_at, updated_at, show_class, template, available_templates, show_single_fee, show_balance, copy_to_print, show_digital_signature, show_school_stamp, show_stream, show_fee_amount from canossa.receipt_settings limit 1';
                                    DB::select($sql);
                                    $receipt_setting = \DB::table('receipt_settings')->first();
                                }
                              
                                $template = $receipt_setting->template;
                                $file = 'invoices.receipt_templates.' . $template;
                              
                                if (isset($payment_info) && !empty($payment_info)) {
                               
                                    ?>
                                    @include("{$file}")
                                <?php } ?>
                            </div>


                        </div>
                        <!-- Modal content start here -->
                        <div class="modal fade" id="report_setting_model">
                            <div class="modal-dialog">
                                <form action="#" method="post" class="form-horizontal" role="form">
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
                                                    if (!in_array($key, array('id', 'created_at', 'updated_at', 'available_templates'))) {
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
                                            <button type="button" style="margin-bottom:0px;" class="btn btn-default" data-dismiss="modal" onclick="javascript:closeWindow()"><?= $data->lang->line('close') ?></button>
                                            <button type="submit" class="btn btn-success">Save</button>
                                        </div>
                                        <?= csrf_field() ?>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="share">
                        <div class="modal-dialog">
                            <form action="#" method="post" class="form-horizontal" role="form">
                                <input type="hidden" name="share" value="1">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        Share Via
                                    </div>

                                    <div class="modal-body" > 
                                        <div class="row">
                                            <div class="col-lg-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Write Email <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" id="first-name" name="email" required="required" class="form-control col-md-7 col-xs-12">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                    <div class="modal-footer">
                                        <button type="button" style="margin-bottom:0px;" class="btn btn-default" data-dismiss="modal" onclick="javascript:closeWindow()"><?= $data->lang->line('close') ?></button>
                                        <button type="submit" class="btn btn-success">Send</button>
                                    </div>
                                    <?= csrf_field() ?>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal content End here -->
            </div>
            <!-- /CONTENT MAIL -->
        </div>
    </div>
</div>
</div>
</div>
@endsection
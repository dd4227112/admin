<?php
/**
 * Description of payment_history
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
$set = NULL;
?>
@extends('layouts.app')
@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-payment"></i> <?= $data->lang->line('menu_receipt') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li class="active"><?= $data->lang->line('menu_payment_history') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">

                <?php
                $usertype = session("usertype");
                ?>

                <div class="list-group">
                    <div class="">
                        <div class="col-sm-12">
                            <form style="" class="form-horizontal" role="form" method="post"> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $data->lang->line('class_level') ?></label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <?php echo form_error($errors, 'class_level_id'); ?>
                                            <select class="select2 form-control" tabindex="-1" required="true"  name="class_level_id" id="class_level_id">           <option value="0"><?= $data->lang->line('select_class_level') ?></option>

                                                <?php
                                                foreach ($classlevels as $level) {
                                                    echo "<option value='" . $level->classlevel_id . "'>" . $level->name . "</option>";
                                                }
                                                ?>          
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $data->lang->line('select_class') ?></label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <?php echo form_error($errors, 'classesID'); ?>
                                            <select class="select2 form-control" tabindex="-1" name="classesID" id="classID">

                                            </select>
                                        </div>
                                    </div>
                                </div>                     
                                <div class="col-md-3" >
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $data->lang->line('select_academic_year') ?></label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <?php echo form_error($errors, 'academic_year'); ?>
                                            <select class="select2 form-control" tabindex="-1" name="academic_year_id" id="academic_year_id" required="true">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?= csrf_field() ?>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
                $total_payment_amount = 0;
                $amount_by_cash = 0;
                $amount_by_bank = 0;
                $amount_by_cheque = 0;
                if (isset($receipts) && !empty($receipts)) {
                  
                    $payment_info= \collect($receipts)->first();
                    
                    ?>
 <div class="col-sm-6 col-xs-12 col-sm-offset-3 list-group">
                            <div class="list-group-item">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?= $data->lang->line("menu_classes") ?></th>
                                            <th><?= $data->lang->line("menu_student") ?></th>
                                            <th><?= $data->lang->line("menu_payment") ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td><?= $payment_info->payment->student->classes->classes ?></td>
                                       
                                            <td><?= \App\Model\StudentArchive::whereIn('section_id',$sections)->count() ?></td>
                                            <td><?= count($receipts) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <div class="col-sm-12">
                       
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#all" aria-expanded="true"><?= $data->lang->line("all_students") ?></a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="all" class="tab-pane active">
                                    <div id="hide-table">
                                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-1"><?= $data->lang->line('slno') ?></th>
                                                    <th class="col-sm-1"><?= $data->lang->line('invoice_invoice') ?></th>	<th class="col-sm-1">Invoice <?= $data->lang->line('invoice_date') ?></th>

                                                    <th class="col-sm-2"><?= $data->lang->line('date') ?></th>
                                                    <th class="col-sm-2"><?= $data->lang->line('student_name') ?></th>

                                                    <th class="col-sm-1">Invoiced <?= $data->lang->line('invoice_amount') ?></th>
                                                    <th class="col-sm-1"> <?= $data->lang->line('paid_amount') ?></th>

                                                    <th class="col-sm-1">Bank <?= $data->lang->line('transaction_id') ?></th>
                                       
                                                    <th class="col-sm-1"><?= $data->lang->line('receipt_number') ?></th>

                                                
                                                    <th class="col-sm-6"><?= $data->lang->line('action') ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($receipts) ) {
                                                    $i = 1;
                                                    foreach ($receipts as $receipt) {
                                                        ?>
                                                        <tr>
                                                            <td data-title="<?= $data->lang->line('slno') ?>">
                                                                <?php echo $i; ?>
                                                            </td>
                                                            <td data-title="<?= $data->lang->line('invoice_invoice') ?>">
                                                                <?php
                                                                echo $receipt->payment->invoice->reference;
                                                                ?>
                                                            </td>
                                                            <td data-title="<?= $data->lang->line('invoice_date') ?>">
                                                                <?php
                                                                echo $receipt->payment->invoice->date;
                                                                ?>
                                                            </td>

                                                            <td data-title="<?= $data->lang->line('date') ?>">
                                                                <?php echo $receipt->payment->paymentdate; ?>
                                                            </td>
                                                            <td data-title="<?= $data->lang->line('student_name') ?>">
                                                                <?php echo $receipt->payment->student->name; ?>
                                                            </td>
                                                            <td data-title="<?= $data->lang->line('invoice_amount') ?>">

                                                                <?php
                                                                $total_amount = $receipt->payment->invoice->invoicesFeesInstallments()->sum('amount');
                                                             
                                                                echo money($total_amount);
                                                                ?>
                                                            </td>

                                                            <td data-title="<?= $data->lang->line('paid_invoice_amount') ?>">
                                                                <?php
                                                                $total_payment_amount += $receipt->payment->paymentamount;
                                                                if (strtolower($receipt->payment->paymenttype) == 'cash') {
                                                                    $amount_by_cash += $receipt->payment->paymentamount;
                                                                } else if (strtolower($receipt->payment->paymenttype) == 'bank') {
                                                                    $amount_by_bank += $receipt->payment->paymentamount;
                                                                } else if (strtolower($receipt->payment->paymenttype) == 'cheque') {
                                                                    $amount_by_cheque += $receipt->payment->paymentamount;
                                                                }
                                                                echo money($receipt->payment->paymentamount);
                                                                ?>
                                                            </td>
                                                            <td data-title="Bank <?= $data->lang->line('transaction_id') ?>">
                                                                <?php echo $receipt->code; ?>
                                                            </td>

                                                            <td data-title="<?= $data->lang->line('bank_name') ?>">
                                                                <?php echo $receipt->receiptID; ?>
                                                            </td>
                                             
                                                            <td data-title="<?= $data->lang->line('action') ?>">
                                                                <?php
                                                        
                                                                echo '<a  href="' . base_url("/invoices/receipt/".$receipt->payment->invoiceID.'/'.$receipt->payment->invoice->academic_year_id.'/'.$receipt->payment->paymentID) . ' " class="btn btn-success btn-xs"><i class="fa fa-folder"></i>View </a>'
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    ?>
                                                <div class="col-sm-12">
                                                    <div class="alert alert-info">No Payment Records</div>
                                                </div>    
                                            <?php }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>

                        </div> <!-- nav-tabs-custom -->
                    </div> <!-- col-sm-12 for tab -->

                    <?php
                }

                ?>
            </div> <!-- col-sm-12 -->
            <?php if (isset($payment) && !empty($payment)) { ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Summary</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <table class="table table-bordered">

                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Total Amount Collected</td>
                                        <td><?= $siteinfos->currency_symbol . ' ' . money($total_payment_amount) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Amount By Cheque</td>
                                        <td><?= $siteinfos->currency_symbol . ' ' . money($amount_by_cheque) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Amount By Cash</td>
                                        <td><?= $siteinfos->currency_symbol . ' ' . money($amount_by_cash) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Amount By Bank</td>
                                        <td><?= $siteinfos->currency_symbol . ' ' . money($amount_by_bank) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Amount By Other Methods (MNOs)</td>
                                        <td><?= $siteinfos->currency_symbol . ' ' . money($total_payment_amount - ($amount_by_bank + $amount_by_cash + $amount_by_cheque)) ?></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->

<script type="text/javascript">
    $('#class_level_id').change(function (event) {
        var class_level_id = $(this).val();
        if (class_level_id === '0') {
            $('#class_level_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('classes/call_classes') ?>",
                data: "class_level_id=" + class_level_id,
                dataType: "html",
                success: function (data) {

                    $('#classID').html(data);
                }
            });
        }
    });

    $('#class_level_id').change(function (event) {
        var class_level_id = $(this).val();
        if (class_level_id === '0') {
            $('#class_level_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('academicyear/call_academicyear') ?>",
                data: "class_level_id=" + class_level_id,
                dataType: "html",
                success: function (data) {

                    $('#academic_year_id').html(data);
                }
            });
        }
    });
    $('#academic_year_id').change(function () {
        var academic_year_id = $(this).val();
        var class_id = $('#classID').val();
        window.location.href = '<?= base_url('PaymentController/receipts') ?>/' + class_id + '/' + academic_year_id;
    });




</script>
@endsection
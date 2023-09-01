<?php
/**
 * Description of payment_history
 *
 *  -----------------------------------------------------
 *  Copyright: SHULESOFT LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
$set = NULL;
?>

<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-payment"></i> <?= $data->lang->line('payment_title') ?></h3>


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
                                <div class="col-md-3" >
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fee</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <?php echo form_error($errors, 'fee'); ?>
                                            <select class="select2 form-control" tabindex="-1" name="fee_id" id="fee_id" required="true">

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
                if (isset($report) && !empty($report)) {
                    ?>

                    <div class="col-sm-12">

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#all" aria-expanded="true"><?= $data->lang->line("all_students") ?></a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="all" class="tab-pane active">
                                    <div id="hide-table" class="table-responsive">
                                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-1"><?= $data->lang->line('slno') ?></th>
                                                    <th class="col-sm-1">Student Name</th>	
                                                    <th class="col-sm-1">Role</th>

                                                    <th class="col-sm-2">Class</th>
                                                    <?php
                                                    foreach ($fees as $fee) {
                                                        ?>
                                                        <th class="col-sm-2"><?= ucwords(strtolower($fee->name)) ?></th>
                                                    <?php } ?>
                                                    <th class="col-sm-2">Wallet</th>
                                                    <th class="col-sm-6"><?= $data->lang->line('action') ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($report) ) {
                                                    $i = 1;
                                                    foreach ($report as $report_fee) {
                                                        ?>
                                                        <tr>
                                                            <td data-title="<?= $data->lang->line('slno') ?>">
                                                                <?php echo $i; ?>
                                                            </td>
                                                            <td data-title="<?= $data->lang->line('name') ?>">
                                                                <?php
                                                                echo $report_fee->name;
                                                                ?>
                                                            </td>
                                                            <td data-title="<?= $data->lang->line('roll') ?>">
                                                                <?php
                                                                echo $report_fee->roll
                                                                ?>
                                                            </td>

                                                            <td data-title="<?= $report_fee->classes ?>">
                                                                <?php echo $report_fee->classes ?>
                                                            </td>
                                                            <?php
                                                            foreach ($fees as $fee) {
                                                                ?>
                                                                <td data-title="<?= $fee->name ?>">
                                                                    <?php echo isset($report_fee->{$fee->name}) ? money($report_fee->{$fee->name}) : ''; ?>
                                                                </td>
                                                            <?php } ?>

                                                            <td  data-title="<?= $data->lang->line('wallet') ?>">
                                                                <?php echo money($report_fee->wallet) ?>
                                                            </td>
                                                            <td></td>
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
        if (academic_year_id === '0') {
            $('#academic_year_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('fee_balance/get_fee') ?>",
                data: {"academic_year_id": academic_year_id, class_id: class_id, 'get_all': 1},
                dataType: "html",
                success: function (data) {
                    $('#fee_id').html(data);
                }
            });
        }
    });

    $('#fee_id').change(function () {
        var fee_id = $(this).val();
        var class_id = $('#classID').val();
        var academic_year_id = $('#academic_year_id').val();
        window.location.href = '<?= base_url('invoices/balance_by_fee') ?>/' + class_id + '/' + academic_year_id + '/' + fee_id;
    });



</script>
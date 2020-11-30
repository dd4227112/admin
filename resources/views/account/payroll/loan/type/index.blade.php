@extends('layouts.app')
@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-signal"></i> <?= __('panel_title') ?> - <?php echo __('loan_types')
?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
            <li class="active"><?= __('loan_types') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">

                <?php
                $usertype = session("usertype");
                if (can_access('manage_payroll')) {
                    ?>
                    <h5 class="page-header">
                        <a class="btn btn-success" href="<?php echo url('loan/add') ?>">
                            <i class="fa fa-plus"></i> 
                            Add New Loan Type
                        </a>
                    </h5>
                <?php } ?>


                <div class="col-sm-6 col-sm-offset-3 list-group">
                    <!--                    <div class="list-group-item list-group-item-warning">
                                            <form style="" class="form-horizontal" role="form" method="post">  
                                                <div class="form-group">              
                                                    <label for="deduction_type" class="col-sm-2 col-sm-offset-2 control-label">
                    <?= __("category") ?>
                                                    </label>
                                                    <div class="col-sm-6">
                    <?php
//                                    $array = array("0" => __("select"));
//                                    $deduction_types = [
//                                        '1' => 'Fixed Deductions',
//                                        '2' => 'Monthly Deductions'
//                                    ];
//                                    foreach ($deduction_types as $key => $value) {
//                                        $array[$key] = $value;
//                                    }
//                                    echo form_dropdown("deduction_type", $array, old("deduction_type", $type), "id='deduction_type' class='form-control'");
                    ?>
                                                    </div>
                                                </div>
                    <?= csrf_field() ?>
                                            </form>
                                        </div>-->
                </div>
                <div id="hide-table">
                    <?php if (isset($types) && count($types) > 0) { ?>
                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="col-lg-1"><?= __('slno') ?></th>
                                    <th class="col-lg-2"><?= __('name') ?></th>
                                    <th class="col-lg-2"><?= __('minimum_amount') ?></th>
                                    <th class="col-lg-1"><?= __('maximum_amount') ?></th>
                                    <th class="col-lg-1"><?= __('minimum_tenor') ?></th>
                                    <th class="col-lg-1"><?= __('maximum_tenor') ?></th>
                                    <th class="col-lg-1"><?= __('interest_rate') ?></th>
                                    <th class="col-lg-1"><?= __('credit_ratio') ?></th>
                                    <th class="col-lg-1"><?= __('created_by') ?></th>
                                    <th class="col-lg-1"><?= __('description') ?></th>
                                    <th class="col-lg-2"><?= __('action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($types as $loan_type) {
                                    ?>
                                    <tr>
                                        <td data-title="<?= __('slno') ?>">
                                            <?php echo $i; ?>
                                        </td>
                                        <td data-title="<?= __('name') ?>">
                                            <?php echo $loan_type->name; ?>
                                        </td>
                                        <td data-title="<?= __('minimum_amount') ?>">
                                            <?php echo money($loan_type->minimum_amount) ?>
                                        </td>
                                        <td data-title="<?= __('maximum_amount') ?>">
                                            <?php echo money($loan_type->maximum_amount); ?>
                                        </td>
                                        <td data-title="<?= __('minimum_tenor') ?>">
                                            <?php echo $loan_type->minimum_tenor; ?>
                                        </td>
                                        <td data-title="<?= __('maximum_tenor') ?>">
                                            <?php echo $loan_type->maximum_tenor; ?>
                                        </td>
                                        <td data-title="<?= __('interest_rate') ?>">
                                            <?php echo $loan_type->interest_rate; ?>
                                        </td>
                                        <td data-title="<?= __('credit_ratio') ?>">
                                            <?php echo $loan_type->credit_ratio; ?>
                                        </td>
                                        <td data-title="<?= __('name') ?>">
                                            <?php echo $loan_type->createdBy()->name; ?>
                                        </td>
                                          <td data-title="<?= __('description') ?>">
                                            <?php echo $loan_type->description; ?>
                                        </td>
                                        <td data-title="<?= __('action') ?>">
                                            <?php echo '<a  href="' . url("loan/type/edit/$loan_type->id") . ' " class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> ' . __('edit') . ' </a>' ?>
                                            <?php
                                            echo '<a  href="' . url("loan/type/delete/$loan_type->id") . ' " class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> ' . __('delete') . ' </a>';
                                            ?>

                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="col-lg-1"><?= __('slno') ?></th>
                                    <th class="col-lg-2"><?= __('name') ?></th>
                                    <th class="col-lg-2"><?= __('minimum_amount') ?></th>
                                    <th class="col-lg-1"><?= __('maximum_amount') ?></th>
                                    <th class="col-lg-1"><?= __('minimum_tenor') ?></th>
                                    <th class="col-lg-1"><?= __('maximum_tenor') ?></th>
                                    <th class="col-lg-1"><?= __('credit_ratio') ?></th>
                                    <th class="col-lg-1"><?= __('name') ?></th>

                                    <th class="col-lg-2"><?= __('action') ?></th>
                                </tr>
                            </thead>
                        </table>
                    <?php } ?>
                </div>


            </div> <!-- col-sm-12 -->
        </div><!-- row -->


    </div><!-- Body -->
</div><!-- /.box -->
<script type="text/javascript">
    $('#classlevel_id').change(function () {
        var classesID = $(this).val();
        if (classesID == 0) {
            $('#hide-table').hide();
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('grade/grade_list') ?>",
                data: "id=" + classesID,
                dataType: "html",
                success: function (data) {
                    window.location.href = data;
                }
            });
        }
    });

    $('#deduction_type').change(function () {
        var deduction_type = $(this).val();
        if (deduction_type === 0) {
            $('#hide-table').hide();
            $('.nav-tabs-custom').hide();
        } else {
            window.location.href = "<?= url('deduction/index') ?>/" + deduction_type;
        }
    });
</script>
@endsection
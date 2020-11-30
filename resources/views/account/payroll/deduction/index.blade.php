@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Payroll</h4>
                <span>Allowances</span>
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
                    <li class="breadcrumb-item"><a href="#!">Payroll</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">

             <div class="row">
            <div class="col-sm-12">
 <div class="card">
                <?php
                $usertype = session("usertype");
                if (can_access('manage_payroll')) {
                    ?>
                    <h5 class="page-header">
                        <a class="btn btn-success" href="<?php echo url('deduction/add/' . $type) ?>">
                            <i class="fa fa-plus"></i> 
                            Add New Deduction
                        </a>
                    </h5>
<?php } ?>


                <div class="col-sm-6 col-sm-offset-3 list-group">
                    <div class="list-group-item list-group-item-warning">
                        <form style="" class="form-horizontal" role="form" method="post">  
                            <div class="form-group">              
                                <label for="deduction_type" class="col-sm-2 col-sm-offset-2 control-label">
<?= __("category") ?>
                                </label>
                                <div class="col-sm-6">
                                    <?php
                                    $array = array("0" => __("select"));
                                    $deduction_types = [
                                        '1' => 'Fixed Deductions',
                                        '2' => 'Monthly Deductions'
                                    ];
                                    foreach ($deduction_types as $key => $value) {
                                        $array[$key] = $value;
                                    }
                                    echo form_dropdown("deduction_type", $array, old("deduction_type", $type), "id='deduction_type' class='form-control'");
                                    ?>
                                </div>
                            </div>
<?= csrf_field() ?>
                        </form>
                    </div>
                </div>
                <div id="hide-table">
<?php if (isset($deductions) && !empty($deductions)) { ?>
                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="col-lg-1"><?= __('slno') ?></th>
                                    <th class="col-lg-2"><?= __('name') ?></th>
                                    <th class="col-lg-2"><?= __('category') ?></th>
                                    <th class="col-lg-1"><?= __('amount') ?></th>
                                    <th class="col-lg-1"><?= __('members') ?><i class="fa fa-question-circle" title="This is the total number of users who are (or ware ) in this plan. It include active and in active users"></i></th>
                                    <th class="col-lg-1"><?= __('percentage') ?></th>
                                    <th class="col-lg-1"><?= __('description') ?></th>
                                      <th class="col-lg-1"><?= __('bank_account') ?></th>
                                    <th class="col-lg-1"><?= __('account_number') ?></th>
                                    <th class="col-lg-2"><?= __('action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($deductions as $deduction) {
                                    ?>
                                    <tr>
                                        <td data-title="<?= __('slno') ?>">
                                            <?php echo $i; ?>
                                        </td>
                                        <td data-title="<?= __('name') ?>">
                                            <?php echo $deduction->name; ?>
                                        </td>
                                        <td data-title="<?= __('name') ?>">
                                            <?php echo $deduction->category == 1 ? 'Fixed' : 'Monthly'; ?>
                                        </td>
                                        <td data-title="<?= __('amount') ?>">
                                            <?php echo $deduction->amount; ?>
                                        </td>
                                         <td data-title="<?= __('amount') ?>">
                                            <?php echo $deduction->userDeductions()->count(); ?>
                                        </td>
                                        <td data-title="<?= __('percentage') ?>">
                                            <?php echo $deduction->is_percentage == null ? 'NONE' : $deduction->percent; ?>
                                        </td>
                                        <td data-title="<?= __('description') ?>">
                                            <?php echo $deduction->description; ?>
                                        </td>
                                         <td data-title="<?= __('description') ?>">
                                            <?php echo $deduction->bankAccount->name; ?>
                                        </td>
                                         <td data-title="<?= __('description') ?>">
                                            <?php echo $deduction->account_number; ?>
                                        </td>
                                        <td data-title="<?= __('action') ?>">
                                            <?php echo '<a  href="' . url("deduction/edit/$deduction->id") . ' " class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> ' . __('edit') . ' </a>' ?>
                                            <?php
                                            echo (int) $deduction->predefined ==1 ? "": '<a  href="' . url("deduction/delete/$deduction->id") . ' " class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> ' . __('delete') . ' </a>';
                                            $sub = $type == 1 ? 'subscribe' : 'monthlysubscribe';
                                            ?>
                                            <a href="<?= url('deduction/' . $sub . '/' . $deduction->id) ?>" class="btn btn-primary btn-xs mrg" ><i class="fa fa-users"></i> members</a>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
<?php }else{?>
      <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="col-lg-1"><?= __('slno') ?></th>
                                    <th class="col-lg-2"><?= __('name') ?></th>
                                    <th class="col-lg-2"><?= __('category') ?></th>
                                    <th class="col-lg-1"><?= __('amount') ?></th>
                                    <th class="col-lg-1"><?= __('members') ?><i class="fa fa-question-circle" title="This is the total number of users who are (or ware ) in this plan. It include active and in active users"></i></th>
                                    <th class="col-lg-1"><?= __('percentage') ?></th>
                                    <th class="col-lg-1"><?= __('description') ?></th>
                                      <th class="col-lg-1"><?= __('bank_account') ?></th>
                                    <th class="col-lg-1"><?= __('account_number') ?></th>
                                    <th class="col-lg-2"><?= __('action') ?></th>
                                </tr>
                            </thead>
      </table>
<?php } ?>
                </div>

 </div>
            </div> <!-- col-sm-12 -->
        </div><!-- row -->


    </div><!-- Body -->
</div><!-- /.box -->
</div>
<script type="text/javascript">
    $('#deduction_type').change(function () {
        var deduction_type = $(this).val();
        if (deduction_type === 0) {
            $('#hide-table').hide();
            $('.nav-tabs-custom').hide();
        } else {
            window.location.href = "<?= url('payroll/deductionIndex') ?>/" + deduction_type;
        }
    });
</script>
@endsection
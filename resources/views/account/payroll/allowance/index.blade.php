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

                <div class="col-lg-12">
                    <div class="card">
        <?php
                $usertype = session("usertype");
                if (can_access('manage_payroll')) {
                    ?>
                    <span class="section">
                        <a class="btn btn-success" href="<?php echo url('allowance/add') ?>">
                            <i class="fa fa-plus"></i> 
                            <?= __('add_allowance') ?>
                        </a>
                    </span>
                <?php } ?>

      

                <div class="col-sm-6 col-sm-offset-3 list-group">
                    <div class="list-group-item list-group-item-warning">
                        <form style="" class="form-horizontal" role="form" method="post">  
                            <div class="form-group">              
                                <label for="category" class="col-sm-2 col-sm-offset-2 control-label">
                                    <?= __("category") ?>
                                </label>
                                <div class="col-sm-6">
                                    <?php
                                    $array = array("0" => __("select"));
                                    $deduction_types = [
                                        '1' => 'Fixed Allowances',
                                        '2' => 'Monthly Allowances'
                                    ];
                                    foreach ($deduction_types as $key => $value) {
                                        $array[$key] = $value;
                                    }
                                    echo form_dropdown("category", $array, old("category", $category), "id='category' class='form-control'");
                                    ?>
                                </div>
                            </div>
                            <?= csrf_field() ?>
                        </form>
                    </div>
                </div>

                <div id="hide-table">
                    <?php if (isset($allowances) && !empty($allowances)) { ?>
                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="col-lg-1"><?= __('slno') ?></th>
                                    <th class="col-lg-2"><?= __('name') ?></th>
                                    <th class="col-lg-1"><?= __('category') ?></th>
                                    <th class="col-lg-1"><?= __('type') ?></th>
                                    <th class="col-lg-1"><?= __('pension') ?></th>
                                    <th class="col-lg-1"><?= __('amount') ?></th>
                                    <th class="col-lg-1"><?= __('percentage') ?></th>
                                    <th class="col-lg-1"><?= __('description') ?></th>
                                    <th class="col-lg-2"><?= __('action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                //  dd($allowances);
                                foreach ($allowances as $allowance) {
                                    ?>
                                    <tr>
                                        <td data-title="<?= __('slno') ?>">
                                            <?php echo $i; ?>
                                        </td>
                                        <td data-title="<?= __('name') ?>">
                                            <?php echo $allowance->name; ?>
                                        </td>
                                        <td data-title="<?= __('name') ?>">
                                            <?php echo $allowance->category == 1 ? 'Fixed' : 'Monthly'; ?>
                                        </td>
                                        <td data-title="<?= __('type') ?>">
                                            <?php echo $allowance->type == 0 ? 'Taxable' : 'Non Taxable'; ?>
                                        </td>
                                        <td data-title="<?= __('pension') ?>">
                                            <?php echo $allowance->pension_included == 1 ? 'Included' : 'Non Included'; ?>
                                        </td>
                                        <td data-title="<?= __('amount') ?>">
                                            <?php echo $allowance->amount; ?>
                                        </td>
                                        <td data-title="<?= __('percentage') ?>">
                                            <?php echo (bool) $allowance->is_percentage == false ? 'NONE' : $allowance->percent; ?>
                                        </td>
                                        <td data-title="<?= __('description') ?>">
                                            <?php echo $allowance->description; ?>
                                        </td>
                                        <td data-title="<?= __('action') ?>">
                                            <?php echo '<a  href="' . url("allowance/edit/$allowance->id") . ' " class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> ' . __('edit') . ' </a>'; ?>
                                            <?php echo '<a  href="' . url("allowance/delete/$allowance->id") . ' " class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> ' . __('delete') . ' </a>';
                                            
                                            $sub = $category == 1 ? 'subscribe' : 'monthlysubscribe';
                                            ?>
                                            <a href="<?= url('allowance/'.$sub.'/' . $allowance->id) ?>" class="btn btn-primary btn-xs mrg" ><i class="fa fa-users"></i> members</a>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>


            </div> <!-- col-sm-12 -->
        </div><!-- row -->


    </div><!-- Body -->
</div><!-- /.box -->
    </div>
</div>
<script type="text/javascript">
    $('#category').change(function () {
        var category = $(this).val();
        if (category === 0) {
            $('#hide-table').hide();
            $('.nav-tabs-custom').hide();
        } else {
            window.location.href = "<?= url('payroll/allowanceIndex') ?>/" + category;
        }
    });
</script>
@endsection
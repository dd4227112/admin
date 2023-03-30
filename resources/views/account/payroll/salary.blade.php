
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-teacher"></i> <?= __('panel_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
            <li class="active"><?= __('menu_teacher') ?></li>
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
                    <h5 class="page-header"><a class="btn btn-success" href="<?php echo url('payroll/create') ?>"><i class="fa fa-plus"></i>
                            <?= __('add_title') ?></a>

                    </h5>

                <?php }  ?>

                <div id="hide-table" class="table-responsive">
                    <a
                        class="right"><i class="fa fa-question-circle" data-container="body"
                                     data-toggle="popover" data-placement="right" data-trigger="hover"
                                     data-content="Use the buttons below to either copy or download the information on the table below. "
                                     title="Export Buttons"></i></a>
                    
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-sm-1"><?= __('slno') ?></th>
                                <th class="col-sm-2"><?= __('payment_date') ?></th>
                            

                                <th class="col-sm-2"><?= __('basic_pay') ?></th>

                                <th class="col-sm-1"><?= __('allowance') ?></th>
                                <th class="col-sm-1"><?= __('gross_pay') ?></th>
                                <th class="col-sm-1"><?= __('pension') ?></th>
                                <th class="col-sm-1"><?= __('deduction') ?></th>
                                <th class="col-sm-1"><?= __('tax') ?></th>
                                <th class="col-sm-1"><?= __('paye') ?></th>
                                <th class="col-sm-1"><?= __('net_pay') ?></th>

                                <th class="col-sm-4"><?= __('action') ?></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($salaries) && !empty($salaries)) {
                                $i = 1;
                                foreach ($salaries as $salary) {
                                    ?>
                                    <tr>
                                        <td data-title="<?= __('slno') ?>">
                                            <?php echo $i; ?>
                                        </td>
                                        <td data-title="<?= __('payment_date') ?>">
                                            <?php
                                            echo date('d M Y', strtotime($salary->payment_date));
                                            ?>
                                        </td>
                                    
                                        <td data-title="<?= __('basic_pay') ?>">
                                            <?php echo money($salary->basic_pay); ?>
                                        </td>
                                        <td data-title="<?= __('allowance') ?>">
                                            <?php
                                            echo money($salary->allowance);
                                            ?>

                                        <td data-title="<?= __('gross_pay') ?>">
                                            <?php echo money($salary->gross_pay); ?>
                                        </td>
                                        <td data-title="<?= __('paye') ?>">
                                            <?php echo money($salary->pension); ?></td>
                                        <td data-title="<?= __('deduction') ?>">
                                            <?php echo money($salary->deduction); ?></td>
                                        <td data-title="<?= __('tax') ?>">
                                            <?php echo money($salary->tax); ?></td>
                                        <td data-title="<?= __('paye') ?>">
                                            <?php echo money($salary->paye); ?></td>
                                        <td data-title="<?= __('net_pay') ?>">
                                            <?php echo money($salary->net_pay); ?></td>
                                      
                                        <td data-title="<?= __('action') ?>">
                                        
                                            <a href="<?= url('payroll/payslip/null/?id=' . $salary->user_id . '&table=' . session('table') . '&month=' .  date('m',strtotime($salary->payment_date)) . '&set=' . $salary->payment_date) ?>" class="btn btn-success btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Show Payslip"><i class="fa fa-file"></i>Preview</a>
                                        </td>

                                    </tr>
        <?php
        $i++;
    }
}
?>
                        </tbody>
                    </table>
                </div>

            </div> <!-- col-sm-12 -->
        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->

@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Revenues</h4>
                <span>Show revenue summary</span>
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
                    <li class="breadcrumb-item"><a href="#!">Revenues</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <?php
                            //$usertype = session("usertype");
                            //if (can_access('view_revenue')) {
                            ?>
                            <h5 class="page-header">

                                <?php //if (can_access('add_revenue')) { ?>
                                <a class="btn btn-success" href="<?php echo url('account/revenueAdd') ?>">
                                    <i class="fa fa-plus"></i> 
                                    Add Revenue
                                </a>
                                <?php //} ?>

                            </h5>

                            <div class="card-block">
                                <div class="dt-responsive table-responsive">
                                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th class="col-sm-1">#</th>
                                                <th class="col-sm-2">Name</th>
                                                <th class="col-sm-1">Group</th>
                                              
                                                <th class="col-sm-2"><?= __('Total') . '(Tsh)' ?></th>
                                                <th class="col-sm-2"><?= __('note') ?></th>

                                                <?php //if (can_access('edit_revenue')) { ?>
                                                <th class="col-sm-2"><?= __('action') ?></th>
                                                    <?php //} ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            $total_amount = 0;
                                            if (count($expenses) > 0) {
                                                $i = 1;
                                                foreach ($expenses as $refer_expense) {
                                                    ?>
                                                    <tr>
                                                        <td data-title="<?= __('slno') ?>">
                                                            <?php echo $i; ?>
                                                        </td>
                                                        <td data-title="<?= __('expense') ?>">
                                                            <?php echo $refer_expense->name; ?>
                                                        </td>
                                                        <td data-title="<?= __('expense') ?>">
                                                            <?php echo $refer_expense->accountGroup->name; ?>
                                                        </td>
                                                         
                                                        <td data-title="<?= __('expense_amount') ?>">
                                                            <?php
                                                            $sum_amount = $refer_expense->expenses->sum('amount')+$refer_expense->revenues->sum('amount');
                                                            $total_amount += $sum_amount;
                                                            echo money($sum_amount)
                                                            ?>
                                                        </td>  

                                                        <?php if (can_access('add_expense')) { ?>
                                                            <td data-title="<?= __('expense_note') ?>">
                                                                <?php echo $refer_expense->note; ?>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td data-title="<?= __('expense_note') ?>">
                                                                <?php echo wordwrap($refer_expense->note,20); ?>
                                                            </td>
                                                        <?php } ?>

                                                        <?php //if (can_access('edit_revenue')) {  ?>
                                                        <td data-title="<?= __('action') ?>">

                                                            <a href="<?php echo url('account/revenue/' . $refer_expense->id) ?>">View </a></td>
                                                        <?php //}  ?>

                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">Total</td>
                                                <td ><?= money($total_amount) ?></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <?php //}  ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
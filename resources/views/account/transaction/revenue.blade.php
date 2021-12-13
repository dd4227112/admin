@extends('layouts.app')
@section('content')

    



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
                                                <th class="col-sm-2">Payer Name</th>
                                                <th class="col-sm-1">Fee Type</th>
                                                <th class="col-sm-1">Payment Date</th>
                                                <th class="col-sm-1">Added Date</th>
                                                <th class="col-sm-2"><?= __('Amount') . '(Tsh)' ?></th>
                                                <th class="col-sm-2"><?= __('note') ?></th>

                                                <th class="col-sm-2"><?= __('action') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_amount = 0;
                                            if (count($revenues) > 0) {
                                                $i = 1;
                                                foreach ($revenues as $revenue) {
                                                    ?>
                                                    <tr>
                                                        <td data-title="<?= __('slno') ?>">
                                                            <?php echo $i; ?>
                                                        </td>
                                                        <td data-title="<?= __('expense') ?>">
                                                            <?php echo $revenue->payer_name; ?>
                                                        </td>
                                                        <td data-title="<?= __('expense') ?>">
                                                            <?php echo $revenue->referExpense->name; ?>
                                                        </td>
                                                        <td data-title="<?= __('expense_date') ?>">
                                                            <?php echo date("d M Y", strtotime($revenue->date)); ?>
                                                        </td>
                                                        
                                                        <td data-title="<?= __('expense_date') ?>">
                                                            <?php 
                                                            echo date("d M Y", strtotime($revenue->created_at));
                                                            ?>
                                                        </td>      
                                                        <td data-title="<?= __('expense_amount') ?>">
                                                            <?php
                                                            $sum_amount = $revenue->amount;
                                                            $total_amount += $sum_amount;
                                                            echo money($sum_amount)
                                                            ?>
                                                        </td>  

                                                        <?php if (can_access('add_expense')) { ?>
                                                            <td data-title="<?= __('expense_note') ?>">
                                                                <?php echo $revenue->note; ?>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td data-title="<?= __('expense_note') ?>">
                                                                <?php echo wordwrap($revenue->note,20); ?>
                                                            </td>
                                                        <?php } ?>

                                                        <td data-title="<?= __('action') ?>">
                                                        <?php if (can_access('manage_finance')) { ?>

                                                            <a href="<?php echo url('account/receipts/' . $revenue->id) ?>" class="btn btn-success btn-sm"> Receipt </a>
                                                          <!--  <a href="<?php echo url('account/revenue/index/' . $revenue->id) ?>" class="btn btn-info btn-sm"> Edit </a> -->
                                                            <a href="<?php echo url('account/deleteRevenue/' . $revenue->id) ?>" class="btn btn-warning btn-sm"> Delete </a>
                                                                <?php }  ?>

                                                            </td>

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
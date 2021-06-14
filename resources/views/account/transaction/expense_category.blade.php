@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Transactions</h4>
                <span>List of company transactions by date</span>
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
                    <li class="breadcrumb-item"><a href="#!">Transactions</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-block">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa icon-expense"></i> <?php
                                    if ($id == 4) {
                                        echo 'Company Expenses';
                                    } elseif ($id == 1) {
                                        echo "Fixed Assets";
                                    } else if ($id == 2) {
                                        echo "Liabilities";
                                    } else if ($id == 3) {
                                        echo "Capital Management";
                                    } else if ($id == 5) {
                                        echo 'Current Assets';
                                    }
                                    ?></h3>

                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                     
                                        <h5 class="page-header">
                                            <?php
                                            if (isset($refer_expense_name) && !empty($refer_expense_name)) {
                                                echo ucwords($refer_expense_name);
                                            }
                                            ?>

                                        </h5>
                                        <br/>
 
                                     <div class="row">
                                        <div class="col-sm-4">
                                            <h5 class="page-header"> 
                                                
                                                <a class="btn btn-success" href="<?php echo url('account/addtransaction/' . $id . '/' . $refer_id . '') ?>">
                                                    <i class="fa fa-plus"></i> 
                                                    Add Transaction 
                                                </a>

                                            </h5>
                                        </div>

                                        <div class="col-sm-8">
                                            <form style="" class="form-horizontal" role="form" method="post"> 
                                              <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group row">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date</label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                            <input type="date"  class="form-control" value="<?= date('Y-01-01') ?>" id="from_date" name="from_date" required> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="form-group row">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">End Date</label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12"> 
                                                            <input type="date" class="form-control" value="<?= date('Y-m-d') ?>"id="to_date" name="to_date"  required>
                                                        </div>
                                                    </div>
                                                </div>                     

                                                <div class="col-md-2">
                                                  <div class="form-group row">
                                                    <div class="">
                                                         <input type="submit" class="form-control btn btn-success" value="Submit"  style="float: right;">
                                                        </div>
                                                    </div>
                                                </div> 

                                              </div>
                                                <?= csrf_field() ?>
                                            </form>
                                        </div>  
                                     </div>          


                                        <?php if ($period == 1) { ?>
                                          <div class="table-responsive dt-responsive"> 
                                                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-sm-1"><?= __('#') ?></th>

                                                            <th class="col-sm-2">Name</th>

                                                            <th class="col-sm-2"><?= __('Expense Date') ?></th>

                                                            <th class="col-sm-1"><?= __('Expense Amount') ?></th>                               

                                                            <th class="col-sm-2"><?= __('Expense Note') ?></th>

                                                            <?php if (isset($depreciation)) { ?>
                                                                <th class="col-sm-2">Asset Name</th>
                                                            <?php } else { ?>

                                                           <th class="col-sm-2"><?= __('Payment Method') ?></th>       
                                                            <?php } ?>

                                                            <th class="col-sm-2"><?= __('Reference') ?></th>
                                                            <th class="col-sm-2"><?= __('Action') ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        $total_expense = 0;
                                                        $i = 1;

                                                        if (isset($expenses) && !empty($expenses)) {
                                                            $i = 1;
                                                            foreach ($expenses as $expense) {
                                                                ?>
                                                                <tr>
                                                                    <td data-title="<?= __('slno') ?>">
                                                                        <?php echo $i; ?>
                                                                    </td>
                                                                    <td data-title="Recipient">
                                                                        <?php echo isset($expense->recipient) ? $expense->recipient : ''; ?>
                                                                    </td>

                                                                    <td data-title="<?= __('Expense Date') ?>">
                                                                        <?php echo date("d M Y", strtotime($expense->date)); ?>
                                                                    </td>

                                                                    <td data-title="<?= __('Expense Amount') ?>">
                                                                        <?php echo money($expense->amount); ?>
                                                                    </td>


                                                                    <td data-title="<?= __('Expense Note') ?>">
                                                                        <?php echo $expense->note; ?>
                                                                    </td>

                                                                    <?php if (isset($depreciation)) { ?>
                                                                        <td data-title="Asset Name">
                                                                            <?php echo $expense->name; ?>
                                                                        </td>      

                                                                    <?php } else { ?>

                                                                        <td data-title="<?= __('Payment Method') ?>">
                                                                            <?php echo  $expense->payment_method; ?>
                                                                        </td>        
                                                                    <?php } ?>

                                                                    <td data-title="<?= __('Reference') ?>">
                                                                        <?php
                                                                        if (isset($expense->transaction_id)) {
                                                                            echo $expense->transaction_id;
                                                                        } else {
                                                                            //echo $expense->ref_no;
                                                                        }
                                                                        ?>
                                                                    </td>

                                                                    <td data-title="<?= __('action') ?>">
                                                                        <?php
                                                                        if ($id != 5 && !isset($depreciation)) {
                                                                            if ((int) $expense->predefined == 0) {
                                                                                ?>
                                                                                <?php echo '<a class="btn btn-sm btn-info" href="'.url('account/expense/edit/' . $expense->id . '/' . $id).'">edit</a>'; ?>
                                                                                <?php echo '<a class="btn btn-sm btn-danger" href="'.url('account/expense/delete/' . $expense->id . '/' . $id).'">delete</a>'; ?>
                                                                                <?php echo '<a class="btn btn-sm btn-warning" href="'.url('account/expense/voucher/' . $expense->id . '/' . $id).'">Payment Voucher</a>'; ?>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                                $total_expense += $expense->amount;
                                                            }
                                                        }

                                                        if (isset($current_assets) && !empty($current_assets) && $id == 5) {

                                                            foreach ($current_assets as $current_asset) { 
                                                                ?>
                                                                <tr>
                                                                    <td data-title="<?= __('slno') ?>">
                                                                        <?php echo $i; ?>
                                                                    </td>
                                                                    <td data-title="Name">
                                                                        <?php echo isset($current_asset->recipient) ? $current_asset->recipient : ''; ?>
                                                                    </td>

                                                                    <td data-title="<?= __('expense_date') ?>">
                                                                        <?php echo date("d M Y", strtotime($current_asset->date)); ?>
                                                                    </td>

                                                                    <td data-title="<?= __('expense_amount') ?>">
                                                                        <?php echo money($current_asset->amount); ?>
                                                                    </td>


                                                                    <td data-title="<?= __('expense_note') ?>">
                                                                        <?php echo $current_asset->note; ?>
                                                                    </td>

                                                                    <td data-title="<?= __('payment_method') ?>">
                                                                        <?php echo isset($current_asset->payment_method) ? $current_asset->payment_method : ''; ?>
                                                                    </td> 
                                                                    <td data-title="<?= __('ref_no') ?>">
                                                                        <?php
                                                                        if (isset($current_asset->transaction_id)) {
                                                                            echo $current_asset->transaction_id;
                                                                        } else { 
                                                                            //echo $expense->ref_no;
                                                                        } 
                                                                        ?>
                                                                    </td> 
                             
                                                                        <td data-title="<?= __('action') ?>">
                                                                            <?php  //echo  '<a class="btn btn-sm" href="'.url('expense/delete/' . $current_asset->id . '/' . $id).'">delete</a>' ?> 
                                                                            <?php //echo '<a class="btn btn-sm" href="'.url('expense/voucher/' . $current_asset->id . '/' . $id).'">Payment Voucher</a>'; ?>
                                                                        </td>
                                                            
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                                $total_expense += $current_asset->amount;
                                                            }
                                                        }
                                                        ?> 

                                                        <?php
                                                        if (isset($fees) && !empty($fees) && $id == 5) {
                                                            foreach ($fees as $fee) {
                                                                ?>
                                                                <tr>
                                                                    <td data-title="<?= __('slno') ?>">
                                                                        <?php echo $i; ?>
                                                                    </td>
                                                                    <td data-title="Name">
                                                                        <?php echo isset($fee->name) ? $fee->name : ''; ?>
                                                                    </td>

                                                                    <td data-title="<?= __('expense_date') ?>">
                                                                        <?php echo date("d M Y"); ?>
                                                                    </td>

                                                                    <td data-title="<?= __('expense_amount') ?>">
                                                                        <?php echo money($fee->total_amount); ?>
                                                                    </td>


                                                                    <td data-title="<?= __('expense_note') ?>">
                                                                        <?php echo 'To be Collected from fees' ?>
                                                                    </td>

                                                                    <td data-title="<?= __('payment_method') ?>">
                                                                        <?php echo isset($fee->payment_method) ? $fee->payment_method : ''; ?>
                                                                    </td>
                                                                    </td> 
                                                                    <td data-title="<?= __('ref_no') ?>">
                                                                        <?php
                                                                        if (isset($expense->transaction_id)) {
                                                                            echo $expense->transaction_id;
                                                                        } else {
                                                                            //echo $expense->ref_no;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <?php if (can_access("delete_expense") || can_access('edit_expense')) { ?>
                                                                        <td data-title="<?= __('action') ?>">
                                                                        </td>
                                                                    <?php } ?>

                                                                </tr>
                                                                <?php
                                                                $i++;
                                                                $total_expense += $fee->total_amount;
                                                            }
                                                        }
                                                        ?> 

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td>Total </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><?= money($total_expense) . '/=' ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>     
                                                        </tr>
                                                    </tfoot>
                                                </table>     
                                            </div>

                                            <div class="col-sm-4 col-sm-offset-8 total-marg">
                                                <div class="well well-sm">
                                                    <table style="width:100%; margin:0px;">
                                                        <tr>
                                                            <td width="50%">
                                                                <?php
                                                                echo __('Total') . " : ";
                                                                ?>
                                                            </td>
                                                            <td style="width:50%;padding-left:10px">
                                                                <?php
                                                                echo money($total_expense) . " TK";
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        <?php } ?> 


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection
@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Our Banks</h4>
                <span>List of bank Accounts</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?=url('/')?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Banking</a>
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
                    
                    <div class="card-header">
                      
                            <?php
                            if (can_access('add_bankaccount')) {
                                ?>
<!--                                <h5 class="page-header">
                                    <a class="btn btn-success" data-original-title="Add your bank account with Number, Name, Branch, Currency etc." data-toggle="tooltip" data-placement="right" href="<?php echo url('bankaccount/add') ?>">
                                        <i class="fa fa-plus"></i> 
                                        <?= __('add_title') ?>
                                    </a>
                                </h5>-->
                            <?php } ?>
                            <div id="hide-table">
                                <table id="example1" class="table table-striped table-bordered table-hover no-footer">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-1">#</th>
                                            <th class="col-sm-1">Bank Name</th>

                                            <th class="col-sm-1">Branch</th>
                                            <th class="col-sm-2">Account Name</th>
                                            <th class="col-sm-1">Account Number</th>
                                            <th class="col-sm-1">Currency</th>
                                            <th class="col-sm-1">Balance</th>
                                            <th class="col-sm-4">Note</th>
                                            <!--<th class="col-sm-3">Action</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($bankaccounts)) {
                                            $i = 1;
                                            foreach ($bankaccounts as $account) {
                                                ?>
                                                <tr>
                                                    <td data-title="<?= __('slno') ?>">
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td data-title="<?= __('bankaccount_name') ?>">
                                                         <?php echo $account->referBank->name; ?> 
                                                    </td>
                                                    <td data-title="<?= __('bankaccount_branch') ?>">
                                                        <?php echo $account->branch ?>
                                                    </td>
                                                    <td data-title="<?= __('bankaccount_name') ?>">
                                                      <?php echo $account->account_name; ?>
                                                    </td>
                                                    <td data-title="<?= __('bankaccount_amount') ?>">
                                                        <?php echo $account->number; ?>
                                                    </td>

                                                    <td data-title="<?= __('bankaccount_currency') ?>">
                                                        <?php echo $account->referCurrency->symbol ?>
                                                    </td>
                                                    <td data-title="<?= __('opening_balance') ?>">
                                                        <?php echo $account->opening_balance ?>
                                                    </td>

                                                    <td data-title="<?= __('bankaccount_note') ?>">
                                                        <?php echo $account->note; ?>
                                                    </td>
<!--                                                    <td data-title="<?= __('action') ?>">
                                                        <?php // echo can_access('edit_bankaccount') ? btn_edit('bankaccount/edit/' . $account->id, __('edit')) : '' ?>
                                                        <?php //echo can_access('delete_bankaccount') ? btn_delete('bankaccount/delete/' . $account->id, __('delete')) : '' ?>
                                                    </td>-->
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
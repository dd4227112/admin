@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Expenses</h4>
                <span>Show expense summary</span>
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
                    <li class="breadcrumb-item"><a href="#!">Expenses</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <!-- form start -->
            <div class="page-body">
                <div class="card">
                    <h3 class="box-title"><i class="fa icon-expense"></i>
                        <?php
                        $global_id = $id;
                        $name = '';
                        if ($id == 4) {
                            echo __('panel_title');
                        } elseif ($id == 1) {
                            echo "Fixed Assets";
                            $name = 'Fixed Assets';
                        } else if ($id == 2) {
                            echo "Liabilities";
                            $name = 'Liabilities';
                        } else if ($id == 3) {
                            echo "Capital Management";
                            $name = 'Capital Management';
                        } else if ($id == 5) {
                            echo 'Current Assets';
                            $name = 'Current Assets';
                        }
                        ?>
                    </h3>
                    <div class="col-sm-12">


                        <?php
                        if (can_access('view_expense')) {
                            ?>
                            <h5 class="page-header">
                                <?php if (can_access('add_expense')) { ?>
                                    <a class="btn btn-success" href="<?php echo url('account/addTransaction/' . $id . '') ?>">
                                        <i class="fa fa-plus"></i> 
                                        <?= __('add_title') ?>
                                    </a>
                                <?php } ?>

                            </h5>




                            <div class="col-sm-12">
                                <form style="" class="form-horizontal" role="form" method="post"> 
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <?php echo form_error($errors, 'from_date'); ?>
                                                <input type="text" required="true" class="form-control calendar" id="from_date" name="from_date" value="<?= old('from_date') ?>" >
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">End Date</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <?php echo form_error($errors, 'to_date'); ?>
                                                <input type="text" required="true" class="form-control calendar" id="to_date" name="to_date" value="<?= old('to_date') ?>" >
                                            </div>
                                        </div>
                                    </div>                     


                                    <div class="col-md-2">
                                        <div class="form-group">

                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="submit" class="btn btn-success" value="Submit" >
                                            </div>
                                        </div>
                                    </div> 
                                    <?= csrf_field() ?>
                                </form>
                            </div>             



                            <div id="hide-table">
                                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-1"><?= __('slno') ?></th>
                                            <th class="col-sm-1"><?= __('code') ?></th>
                                            <th class="col-sm-2"><?= __('expense_expense') ?></th>
                                            <th class="col-sm-2"><?= __('category') ?></th>
                                            <th class="col-sm-2"><?= __('group_name') ?></th>
                                            <th class="col-sm-2"><?= __('sum') ?></th>
                                            <th class="col-sm-2">Open Balance</th>
                                            <th class="col-sm-2"><?= __('expense_note') ?></th>

                                            <?php if (can_access('edit_expense')) { ?>
                                                <th class="col-sm-2"><?= __('action') ?></th>
                                                <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_expense = 0;
                                        $i = 1;
                                        if (count($expenses) > 0) {


                                            foreach ($expenses as $expense) {
                                                ?>
                                                <tr>
                                                    <td data-title="<?= __('slno') ?>">
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td data-title="<?= __('slno') ?>">
                                                        <?php echo $expense->code; ?>
                                                    </td>
                                                    <td data-title="<?= __('expense_expense') ?>">
                                                        <?php echo $expense->name; ?>
                                                    </td>
                                                    <td data-title="<?= __('category') ?>">
                                                        <?php echo $expense->financialCategory->name; ?>
                                                    </td>   
                                                    <td data-title="<?= __('group_name') ?>">

                                                        <?php echo isset($expense->accountGroup->name) ? $expense->accountGroup->name : ''; ?>
                                                    </td>

                                                    <td data-title="<?= __('sum') ?>">
                                                        <?php
                                                        if ($id == 2 && $expense->name == 'Unearned Revenue') {

                                                            $unearned = \App\Model\AdvancePayment::sum('amount') - \App\Model\AdvancePaymentsInvoicesFeesInstallment::sum('amount');
                                                            echo money($unearned);
                                                        } else if (preg_match('/EC-1001/', $expense->code) && $id = 4 && isset($expense->predefined) && (int) $expense->predefined > 0) {
                                                            //this is employer contribution, so lets check the code
                                                            $pension = \App\Model\SalaryPension::where('pension_id', $expense->predefined)->sum('employer_amount');
                                                            echo money($pension + $expense->expenses()->sum('amount'));
                                                        } else if ($id == 5) {
                                                            $new_account = new \App\Http\Controllers\expense();
                                                            if (strtoupper($expense->name) == 'CASH') {
                                                                $total_cash_transaction = \collect(DB::SELECT('SELECT sum(coalesce(amount,0)) as total_cash from ' . set_schema_name() . ' bank_transactions WHERE  payment_type_id =1 and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . ' '))->first();
                                                                //$total_current_assets= \collect(DB::SELECT('SELECT sum(caolesce(amount,0)) as total_current from '.set_schema_name(). ' current_asset_transactions WHERE refer_expense_id='.$expense->id.'and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . ' '))->first();
                                                                $total_current_assets_cash = $new_account->getCashtransactions($from_date, $to_date, 1);
                                                                $total_amount = $total_cash_transaction->total_cash + $total_current_assets_cash->amount;
                                                            } elseif (strtoupper($expense->name) == 'ACCOUNT RECEIVABLE') {

                                                                $bank_opening_balance = \collect(DB::select('select sum(coalesce(opening_balance,0)) as opening_balance from ' . set_schema_name() . ' bank_accounts'))->first()->opening_balance;

                                                                $total_receivable = $new_account->getgeneralFeeTotal($from_date, $to_date);
                                                                $total_paid = $new_account->getTotalFeePaidTotal($from_date, $to_date);
                                                                $due_amount = \App\Model\DueAmount::all()->sum('amount');

                                                                $total_amount = $due_amount + $total_receivable - $total_paid + $bank_opening_balance;
                                                            } else {
                                                                $total_bank = \collect(DB::SELECT('SELECT sum(coalesce(amount,0)) as total_bank from ' . set_schema_name() . ' bank_transactions WHERE bank_account_id=' . $expense->predefined . ' and payment_type_id <> 1 and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . ''))->first();

                                                                $total_current_assets = \collect(DB::SELECT('SELECT sum(coalesce(amount,0)) as total_current from ' . set_schema_name() . ' current_asset_transactions WHERE refer_expense_id=' . $expense->id . '  and "date" >= ' . "'$from_date'" . ' AND "date" <= ' . "'$to_date'" . ''))->first();


                                                                $total_amount = $total_bank->total_bank + $total_current_assets->total_current;
                                                            }

                                                            echo money($total_amount);
                                                        } elseif (strtoupper($expense->name) == 'DEPRECIATION') {

                                                            $total_depreciation = \collect(DB::select('select sum(amount* a.depreciation*(\'' . $to_date . '\'::date-a.date::date)/365) as deprec,COALESCE(sum(b.open_balance::numeric * b.depreciation*(\'' . $to_date . '\'::date-a.date::date)/365),0) as open_balance from ' . set_schema_name() . 'expense a join ' . set_schema_name() . 'refer_expense b  on b.id=a.refer_expense_id where b.financial_category_id=4 AND a.date  <= \'' . $to_date . '\''))->first();

                                                            $total_amount = $total_depreciation->deprec;
                                                            //$open_balance=$total_depreciation->open_balance;


                                                            echo money($total_amount);
                                                        } else {
                                                            echo count($expense->expenses()->get()) > 0 ? money($expense->expenses()->sum('amount')) : '';
                                                        }
                                                        ?>
                                                    </td>

                                                    <td data-title="Opening Balance">
                                                        <?php
                                                        $open_bal = isset($expense->open_balance) > 0 ? $expense->open_balance : 0;
                                                        echo money($open_bal);
                                                        ?>
                                                    </td>
                                                    <td data-title="<?= __('expense_note') ?>">
                                                        <?php echo $expense->note; ?>
                                                    </td>

                                                    <?php if (can_access('view_expense')) { ?>
                                                        <td data-title="<?= __('action') ?>">

                                                            <?php
                                                            if ($id == 2 && $expense->name == 'Unearned Revenue') {
                                                                echo btn_view('invoices/wallet', __('view'));
                                                            } else {
                                                                // echo btn_view('expense/view_expense/' . $expense->id . '/'.$global_id, __('view'));

                                                                echo btn_view('expense/view_expense/' . $expense->id . '/' . $id . '/' . $expense->predefined, __('view'));
                                                            }
                                                            ?></td>

                                                    <?php } ?>

                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>


                                    </tbody>

                                </table>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.calendar').on('click', function (e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");
    });
</script>
@endsection
@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>


<!-- Page-header start -->
<div class="page-header">
    <div class="page-header-title">
        <h4>Reconciliation</h4>
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
            <li class="breadcrumb-item"><a href="#!">Reconciliation</a>
            </li>
        </ul>
    </div>
</div>

<div class="page-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block">
                    <!-- form start -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="row" style="margin-bottom: 30px">
                                    <div class="col-sm-12 col-sm-offset-3 list-group">
                                        <div class="list-group-item list-group-item-warning">
                                            <form style="" class="form-horizontal" role="form" method="post">
                                                <div class="form-group row">
                                                    <label for="bank_account_id" class="col-sm-2 col-sm-offset-2 control-label">
                                                        Bank Name
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <?php
                                                        $array = array("" => ("Select School"));
                                                        foreach ($bank_accounts as $bank) {
                                                            $array[$bank->invoice_prefix] = $bank->schema_name . ' (' . $bank->invoice_prefix . ')';
                                                        }
                                                        echo form_dropdown("invoice_prefix", $array, old("invoice_prefix"), "id='bank_account_id' required class='form-control select2'");
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="from" class="col-sm-2 col-sm-offset-2 control-label">
                                                        From Date
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input type="date" name="from_date" id="from" class='form-control'/>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="to" class="col-sm-2 col-sm-offset-2 control-label">
                                                        To Date
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input type="date" name="to_date" id="to"  class='form-control'/>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="to" class="col-sm-2 col-sm-offset-2 control-label">

                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input type="submit" class="btn btn-success btn-block" style="margin-bottom:0px" value="<?= ("View Payments") ?>" >
                                                    </div>
                                                </div>

                                                <?= csrf_field() ?>
                                            </form>
                                        </div>

                                    </div>
                                </div>



                                <div class="table-responsive dt-responsive"> 
                                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th class="col-sm-2"><?= ('ID') ?></th>
                                                <th class="col-sm-2"><?= ('Student Name') ?></th>
                                                <th class="col-sm-2"><?= ('Phone') ?></th>
                                                <th class="col-sm-2"><?= ('Reference') ?></th>
                                                <th class="col-sm-2"><?= ('Amount') ?></th>
                                                <th class="col-sm-2"><?= ('Receipt No') ?></th>
                                                <th class="col-sm-2"><?= ('Channel') ?></th>
                                                <th class="col-sm-2"><?= ('Date') ?></th>
                                                <th class="col-sm-2"><?= ('action') ?></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $total_payments = 0;
                                            $amount_reconciled = 0;
                                            $prefix = $invoice_prefix;
                                            $i = 1;
                                            if (count($payments) > 0) {

                                                foreach ($payments as $value) {
                                                    $payment = json_decode($value->content);
                                                    if (isset($payment->transactionRef)) {
                                                        $school = $is_new_version == 0 ?
                                                                DB::table('admin.all_invoice_prefix')->where('reference', $payment->reference)->first() :
                                                                DB::table('shulesoft.invoice_prefix')->where('reference', $payment->reference)->first();
                                                        if (!empty($school)) {
                                                            if (preg_match('/' . strtolower($prefix) . '/i', strtolower($payment->reference))) {
                                                                $check = $is_new_version == 0 ?
                                                                        DB::table($school->schema_name . '.payments')->where('transaction_id', $payment->transactionRef)->first() :
                                                                        DB::table('shulesoft.payments')->where('transaction_id', $payment->transactionRef)->first();

                                                                $check_ = $is_new_version == 0 ?
                                                                        DB::table($school->schema_name . '.wallets')->where('transaction_id', $payment->transactionRef)->first() :
                                                                        DB::table('shulesoft.wallets')->where('transaction_id', $payment->transactionRef)->first();
                                                            }
                                                        } else {
                                                            $check = [];
                                                            $check_ = [];
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td data-title="<?= ('slno') ?>">
                                                                <?php echo $i++; ?>
                                                            </td>
                                                            <td data-title="<?= ('bank_name') ?>">
                                                                <?php echo isset($payment->customer_name) ? $payment->customer_name : ''; ?>
                                                            </td>
                                                            <td data-title="<?= ('bank_name') ?>">
                                                                <?php echo isset($payment->payerMobile) ? $payment->payerMobile : ''; ?>
                                                            </td>
                                                            <td data-title="<?= ('bank_name') ?>">
                                                                <?php echo isset($payment->reference) ? $payment->reference : ''; ?>
                                                            </td>
                                                            <td data-title="<?= ('bank_name') ?>">
                                                                <?php
                                                                echo $payment->amount;
                                                                $total_payments += $payment->amount;
                                                                ?>
                                                            </td>
                                                            <!-- <td data-title="<?= ('bank_name') ?>">
                                                            <?php // echo $payment->paymentDesc;   ?>
                                                            </td> -->
                                                            <td data-title="<?= ('bank_account') ?>">
                                                                <?php echo isset($payment->receipt) ? $payment->receipt : ''; ?>
                                                            </td>
                                                            <td data-title="<?= ('transaction_id') ?>">
                                                                <?php echo isset($payment->channel) ? $payment->transactionChannel : ''; ?>
                                                            </td>
                                                            <td data-title="<?= ('transaction_date') ?>">
                                                                <?php echo isset($payment->timestamp) ? $payment->timestamp : ''; ?>
                                                            </td>

                                                            <?php
                                                            if (empty($check) && empty($check_)) {
                                                                ?>
                                                                <td id="payment<?= $payment->reference ?>" data-title="<?= ('action') ?>">

                                                                    <a href="#" onclick="return false" class="btn btn-primary btn-mini btn-round" onmousedown="reconcile('<?= url('Partner/pushPayment/null?data=' . urlencode(json_encode($payment))) ?>', <?= $payment->reference ?>)">Sync</a>

                                                                </td>
                                                            <?php } else { ?>
                                                                <td></td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>

                                <div>
                                    <div class="col-sm-12">
                                        <hr/>
                                        <?php
                                        if (isset($invoice_prefix) && $invoice_prefix != '') {
                                            $bank1 = DB::table('admin.all_bank_accounts_integrations')->where('invoice_prefix', $invoice_prefix)->first();
                                            if (!empty($bank1)) {
                                                $bank_accounts = DB::table($bank1->schema_name . '.bank_accounts')->where('id', $bank1->bank_account_id)->first();
                                                $setting = DB::table($bank1->schema_name . '.setting')->first();
                                                echo!empty($setting) ? '<h2>' . $setting->sname . '</h2>' : $bank1->schema_name;
                                            }
                                        }
                                        ?>
                                        <div class="">
                                            <div class="list-group-item">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th><?= ("Account Name") ?></th>
                                                            <th><?= ("Number") ?></th>
                                                            <th><?= ("dates") ?></th>
                                                            <th><?= ("Amount Collected") ?></th>
                                                            <th><?= ("transactions") ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>

                                                            <td><?php
                                                                if (isset($bank1) && !empty($bank1) && isset($bank_accounts)) {
                                                                    echo $bank_accounts->name;
                                                                }
                                                                ?></td>
                                                            <td><?php
                                                                if (isset($bank1) && !empty($bank1) && isset($bank_accounts)) {
                                                                    echo $bank_accounts->number;
                                                                }
                                                                ?></td>
                                                            <td><?= 'From: <b>' . $from_date . '</b> - to - <b>' . $to_date . '</b>' ?></td>
                                                            <td><?= money($total_payments) ?></td>
                                                            <td><?= $i ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br/>
                                    </div>

                                </div>
                            </div> 
                        </div>

                        <script type="text/javascript">
                            reconcile = function (a, b) {
                                $.ajax({
                                    url: a,
                                    method: 'GET',
                                    success: function (data) {
                                        $('#payment' + b).html(data);
                                    }
                                });
                            }
                        </script>
                        @endsection



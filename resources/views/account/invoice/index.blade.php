@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Invoices</h4>
                <span>Show payments summary</span>
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
                    <li class="breadcrumb-item"><a href="#!">Invoices</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">

                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Invoices</h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                            <br/>
                            <a href="<?= url('account/createInvoice') ?>" class="btn btn-sm btn-primary">Create New Invoice</a>
                        </div>
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group row col-lg-offset-6">
                                <label class="col-sm-4 col-form-label">Select Project</label>
                                <div class="col-sm-4">
                                    <select name="select" class="form-control" id="schema_select">
                                        <option value="0">Select</option>
                                        <?php
                                        $projects = \App\Models\Project::all();
                                        foreach ($projects as $project) {
                                            ?>
                                            <option value="<?= $project->id ?>" <?= $project_id == $project->id ? 'selected' : '' ?>><?= $project->name ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row col-lg-offset-6" <?= $project_id == 1 ? 'selected' : ' style="display:none;"' ?>  id="year_id">
                                <label class="col-sm-4 col-form-label">Select Year</label>
                                <div class="col-sm-4">
                                    <select name="select" class="form-control" id="year_select">
                                        <option value="0">Select</option>
                                        <?php
                                        $years = \App\Models\AccountYear::all();
                                        foreach ($years as $year) {
                                            ?>
                                            <option value="<?= $year->id ?>" ><?= $year->name ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <?php if ($project_id == 4) { ?>
                                    <table id="invoice_table" class="table table-striped table-bordered nowrap dataTable">
                                        <thead>
                                            <tr>
                                                 <th>#</th>
                                                <th>Client Name</th>
                                                <th>Reference #</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                                <th>SMS Provided</th>
                                                <th>Transaction ID</th>
                                                <th>Method</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_amount = 0;
                                            $total_paid = 0;
                                            $total_sms = 0;
                                            $x = 1;
                                            foreach ($invoices as $invoice) {

                                                $amount = $invoice->amount;
                                                $paid = $invoice->confirmed == 1 && $invoice->approved == 1 ? $amount : 0;
                                                $unpaid = $amount - $paid;
                                                $total_paid += $paid;
                                                $total_amount += $amount;
                                                $total_sms += $invoice->sms_provided;
                                                ?>


                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td><?= $invoice->name ?></td>
                                                    <td><?= $invoice->invoice ?></td>
                                                    <td><?= money($amount) ?></td>
                                                    <td><?= money($paid) ?></td>
                                                    <td><?= $invoice->sms_provided ?></td>
                                                    <td><?= $invoice->transaction_code ?></td>
                                                    <td><?= $invoice->method ?></td>
                                                    <td><?= date('d M Y', strtotime($invoice->time)) ?></td>
                                                    <td>
        <!--                                                        <a href="<?= url('account/invoiceView/' . $invoice->payment_id) ?>" class="btn btn-sm btn-success">View</a>
                                                        <a href="<?= url('account/invoice/edit/' . $invoice->payment_id) ?>" class="btn btn-sm btn-primary">Edit</a>-->
                                                        <!--<a href="<?= url('account/invoice/delete/' . $invoice->payment_id) ?>" class="btn btn-sm btn-danger">Delete</a></td>-->
                                                </tr>
                                            <?php $x++; } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">Total</td>
                                                <td><?= money($total_amount) ?></td>
                                                <td><?= money($total_paid) ?></td>
                                                <td><?= $total_sms ?></td>
                                                <td colspan="4"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <?php } else {
                                    ?>
                                    <table id="invoice_table" class="table table-striped table-bordered nowrap dataTable">
                                        <thead>
                                            <tr>
                                                <th>Client Name</th>
                                                <th>Reference #</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Remained Amount</th>
                                                <th>Due Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_amount = 0;
                                            $total_paid = 0;
                                            $total_unpaid = 0;
                                            $i = 1;
                                            foreach ($invoices as $invoice) {

                                                $amount = $invoice->invoiceFees()->sum('amount');
                                                $paid = $invoice->payments()->sum('amount');
                                                $unpaid = $amount - $paid;
                                                $total_paid += $paid;
                                                $total_amount += $amount;
                                                $total_unpaid += $unpaid;
                                                ?>


                                                <tr>
                                                    <td><?= $invoice->client->name ?></td>
                                                    <td><?= $invoice->reference ?></td>
                                                    <td><?= money($amount) ?></td>
                                                    <td><?= money($paid) ?></td>
                                                    <td><?= money($unpaid) ?></td>
                                                    <td><?= date('d M Y', strtotime($invoice->due_date)) ?></td>
                                                    <td>
                                                        <a href="<?= url('account/invoiceView/' . $invoice->id) ?>" class="btn btn-sm btn-success">View</a>
                                                        <a href="<?= url('account/invoice/edit/' . $invoice->id) ?>" class="btn btn-sm btn-primary">Edit</a>
                                                        <a href="<?= url('account/invoice/delete/' . $invoice->id) ?>" class="btn btn-sm btn-danger">Delete</a>
                                                        <?php if ((int) $unpaid > 0) { ?>  <a href="<?= url('account/payment/' . $invoice->id) ?>" class="btn btn-secondary btn-sm"><i class="fa fa-money"></i> Add Payment </a> <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">Total</td>
                                                <td><?= money($total_amount) ?></td>
                                                <td><?= money($total_paid) ?></td>
                                                <td><?= money($total_unpaid) ?></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>
<script type="text/javascript">
    $('#schema_select').change(function () {
        var schema = $(this).val();
        if (schema == 0 || schema == 1) {
            $('#year_id').show();
            return false;
        } else {
            window.location.href = "<?= url('account/invoice') ?>/" + schema;
        }
    });
    $('#year_select').change(function () {
        var year = $(this).val();
        var project = $('#schema_select').val();
        if (year == 0) {
            return false;
        } else {
            window.location.href = "<?= url('account/invoice') ?>/" + project + '/' + year;
        }
    });
</script>
@endsection
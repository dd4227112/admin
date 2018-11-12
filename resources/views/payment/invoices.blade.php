@extends('layouts.app')
@section('content')
<div class="white-box">
    <h5 class="box-title">Payment Requests</h5>
    <?php if (request()->segment(3) == 0) { ?>
        <a href="<?= url('api/invoices/create') ?>" class="btn btn-info">Create Testing Invoice</a>
    <?php } ?>
    @if ($message = Session::get('success'))
    <div class="alert alert-top alert-success alert-dismissable margin5">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Success:</strong> {{ $message }}
    </div>
    @endif

    @if ($message = Session::get('error'))
    <div class="alert alert-top alert-danger alert-dismissable margin5">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Error:</strong> {{ $message }}
    </div>
    @endif
    <div class="table-responsive"> 
        <table id="example23" class="display nowrap table color-table success-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Student Name</th>
                    <th>School Name</th>
                    <th>Created At</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($invoices as $key => $invoice) {
                    ?>

                    <tr>
                        <td><?= $invoice->reference ?></td>
                        <td><?= $invoice->student_name ?></td>
                        <td><?= $invoice->school_name ?></td>
                        <td><?= date('d M Y', strtotime($invoice->created_at)) ?></td>
                        <td><?= $invoice->amount ?></td>
                        <td><?php
                            if ($invoice->status == 2) {
                                echo '<b class="label label-info">Partially Paid</b>';
                            } else if ($invoice->status == 3) {
                                echo '<b class="label label-success">Fully Paid</b>';
                            } else {
                                echo '<b class="label label-warning">Not paid</b>';
                            }
                            ?></td>

                        <td><a href="<?= url('api/invoices/cancel') . '?invoice=' . $invoice->reference ?>" class="btn btn-danger">Cancel</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
@include('layouts.datatable')
@endsection


@extends('layouts.app')
@section('content')
<div class="white-box">
    <h5 class="box-title">Payment Requests</h5>
<?php
if(request()->segment(3)==0){ ?>
    <a href="<?= url('api/invoices/create') ?>" class="btn btn-info">Create Testing Invoice</a>
<?php }?>
    <div class="table-responsive"> 
        <table id="example23" class="display nowrap table color-table success-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Student Name</th>
                    <th>School Name</th>
                    <th>Created At</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($invoices as $key => $invoice) {
                    ?>
                    <tr>
                        <td><?= $invoice->invoiceNO ?></td>
                        <td><?= $invoice->student_name ?></td>
                        <td><?= $invoice->school_name ?></td>
                        <td><?=date('d M Y',strtotime($invoice->created_at)) ?></td>
                        <td><?= $invoice->amount ?></td>
                        <td><a href="<?=url('api/invoices/cancel').'?invoice='.$invoice->invoiceNO?>" class="btn btn-danger">Cancel</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
@include('layouts.datatable')
@endsection


@extends('layouts.app')
@section('content')
<div class="white-box">
    <h5 class="box-title">Payment Requests</h5>

    <div class="table-responsive"> 
        <table id="example23" class="display nowrap table color-table success-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Student Name</th>
                    <th>School Name</th>
                    <th>Created At</th>
                    <th>Amount</th>
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
                        <td><?=date('d M Y',strtotime($invoice->date)) ?></td>
                        <td><?= $invoice->amount ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
@include('layouts.datatable')
@endsection


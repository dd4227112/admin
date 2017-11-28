@extends('layouts.app')
@section('content')

<div class="white-box">
    <h5 class="box-title">Payment Requests</h5>

    <div class="table-responsive"> 
        <select id="" onchange="window.location.href = '<?= url('api/payment') ?>/' + this.value">
            <option value="">Select School</option>
            <?php foreach ($schools as $school) {
                ?>
                <option value="<?= $school->table_schema ?>"><?= $school->table_schema ?></option>
            <?php } ?>
        </select>
        <br/>
        <table id="example23" class="display nowrap table color-table success-table">
            <thead>
                <tr>
                    <th>Invoice NO</th>
                    <th>Amount</th>
                    <th>Student Name</th>
                    <th>Account Number</th>
                    <th>Payment Method</th>
                    <th>Payment Date</th>
                    <th>Bank Transaction ID</th>
                    <th>MNO transaction ID</th>
                    <th>School Receipt</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($payments as $key => $request) {
                    ?>
                    <tr>
                        <td><?= $request->invoiceNO ?></td>
                        <td><?= $request->paymentamount ?></td>
                        <td><?= $request->studentID ?></td>
                        <td><?= $request->account_number ?></td>
                        <td><?= $request->paymenttype ?></td>
                        <td><?= $request->created_at ?></td>
                        <td><?= $request->transaction_id ?></td>
                        <td><?= $request->mobile_transaction_id ?></td>
                        <td><?= $request->mobile_transaction_id ?></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>
@include('layouts.datatable')
@endsection


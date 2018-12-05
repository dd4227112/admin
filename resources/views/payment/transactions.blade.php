@extends('layouts.app')
@section('content')
<div class="white-box">
    <h5 class="box-title">Payment Requests</h5>

    <div class="table-responsive"> 
        <div class="col-sm-12 col-xs-12">
            <form action="" method="post">
                <div class="form-group col-lg-3">
                    <label for="from">School </label>
                    <select id="" class="form-control" name="school">
                        <option value="">Select School</option>
                        <?php foreach ($schools as $school) {
                            ?>
                            <option value="<?= $school->table_schema ?>"><?= $school->table_schema ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="from">From </label>
                    <input type="date" name="from" class="form-control" id="exampleInputEmail1" placeholder="From"> </div>
                <div class="form-group col-lg-3">
                    <label for="to">To</label>
                    <input type="date" name="to" class="form-control" id="exampleInputEmail1" placeholder="To"> </div>
                <div class="form-group col-lg-3"><br/>
                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Reconcile</button>
                    {{ csrf_field() }}
                </div>
            </form>
        </div>
        <br/>
        <?php if (count($setting) > 0 && count($payments) > 0) { ?>
            <table id="example23" class="display nowrap table color-table success-table table-bordered">
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
                        <th>Transaction Fee</th>
                        <th>NMB Commission</th>
                        <th>ShuleSoft Commission</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $transaction_fee = 0;
                    $nmb_comission = 0;
                    $shulesoft_comission = 0;
                    foreach ($payments as $key => $request) {
                        ?>
                        <tr>
                            <td><?= $request->reference ?></td>
                            <td><?= $request->paymentamount ?></td>
                            <td><?= $request->name ?></td>
                            <td><?= $request->account_number ?></td>
                            <td><?= $request->paymenttype ?></td>
                            <td><?= $request->created_at ?></td>
                            <td><?= $request->transaction_id ?></td>
                            <td><?= $request->mobile_transaction_id ?></td>
                            <td><?= 'No=' . $request->number . ', code=' . $request->code ?></td>
                            <td><?php
                                echo $setting->transaction_fee;
                                $transaction_fee += $setting->transaction_fee;
                                ?></td>
                            <td><?php
                                echo $c = $setting->nmb_comission * $setting->transaction_fee;
                                $nmb_comission += $c;
                                ?></td>
                            <td><?php
                                echo $sc = $setting->shulesoft_comission * $setting->transaction_fee;
                                $shulesoft_comission += $sc;
                                ?></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="9">Total</td>
                        <td><?= $transaction_fee ?></td>
                        <td><?= $nmb_comission ?></td>
                        <td><?= $shulesoft_comission ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        <?php } ?>
    </div>

</div>
@include('layouts.datatable')
@endsection

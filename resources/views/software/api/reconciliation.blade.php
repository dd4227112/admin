@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
       
        <div class="page-body">
                <div class="col-lg-12">

                           <div class="card">
                            <div class="card-block">
                             <form method="post">

                             <div class="row">
                                <div class="col-sm-12 col-xl-3 m-b-30">
                                    <h4 class="sub-title">Select School</h4>
                                    <select name="schema_name" class="select2" id="payment_schema">
                                        <option value="0">Select</option>
                                        <?php
                                        $schemas = DB::select('select distinct "schema_name" from admin.all_setting  where payment_integrated=1');
                                        foreach ($schemas as $schema) {
                                            ?>
                                            <option value="<?= $schema->schema_name ?>"><?= $schema->schema_name ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>

                                 <div class="col-sm-12 col-xl-3 m-b-30">
                                    <h4 class="sub-title">Start date</h4>
                                    <input type="date" name="start_date" class="form-control"/>
                                  </div>

                                  <div class="col-sm-12 col-xl-3 m-b-30">
                                     <h4 class="sub-title">Start date</h4>
                                     <input type="date" name="end_date" class="form-control"/>
                                  </div>

                                   <div class="col-sm-12 col-xl-3 m-b-30">
                                      <h4 class="sub-title"> &nbsp;&nbsp; </h4>
                                      <button type="submit" name="submit" class="btn btn-primary"> Submit </button>
                                   </div>
                                </div>
                                  <?= csrf_field() ?>
                                </form>
                                </div>
                            </div>
                        
                     <?php if (isset($returns) && !empty($returns)) { ?>
                        <div class="card">
                        <div class="card-block">
                           <div id="sync_status"></div>
                            <div class="table-responsive dt-responsive "> 
                                <table id="api_requests" class="table table-striped dataTable table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer Name</th>
                                            <th>Reference</th>
                                            <th>Timestamp</th>
                                            <th>Amount</th>
                                            <th>Receipt</th>
                                            <th>Channel</th>
                                            <th>Account Number</th>
                                            <th>Token</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($returns as $return) {
                                                $data = $return->transactions;
                                                if (!empty($data)) {
                                                    $trans = (object) $data;
                                                    $i = 1;
                                                    foreach ($trans as $tran) {
                                                        if (preg_match('/' . strtolower($prefix) . '/i', strtolower($tran->reference))) {
                                                            $check = DB::table(request('schema_name') . '.payments')->where('transaction_id', $tran->receipt)->first();
                                                            ?>
                                                            <tr>
                                                                <td><?= $i ?></td>
                                                                <td><?= $tran->customer_name ?></td>
                                                                <td><?= $tran->reference ?></td>
                                                                <td><?= $tran->timestamp ?></td>
                                                                <td><?= number_format($tran->amount) ?></td>
                                                                <td><?= $tran->receipt ?></td>
                                                                <td><?= $tran->channel ?></td>
                                                                <td><?= $tran->account_number ?></td>
                                                                <td><?= $tran->token ?></td>
                                                                <td>
                                                                    <?php
                                                                    if (empty($check)) {
                                                                        ?>
                                                                        <a href="#" onclick="return false" onmousedown="reconcile('<?= url('software/syncMissingPayments/null?data=' . urlencode(json_encode($tran))) ?>')">Sync</a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    }
                                                }
                                            } ?>
                                       
                                    </tbody>
                                </table>
                             </div>
                           </div>
                         </div>
                      <?php   } ?>

                    </div> 
              </div> 
           </div>
     </div>

<script type="text/javascript">
    reconcile = function (a) {
        $.ajax({
            url: a,
            method: 'get',
            success: function (data) {
                $('#sync_status').html(data).addClass('alert alert-success');
            }
        });
    }

    $(".select2").select2({
        theme: "bootstrap",
        dropdownAutoWidth: false,
        allowClear: false,
        debug: true
    });


</script>
@endsection


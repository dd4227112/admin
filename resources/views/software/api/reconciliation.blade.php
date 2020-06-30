@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Payment Api Requests</h4>
                <span>This parts show all api requests done with a bank</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Software</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">API requests</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">



                        <div class="card-block">
                            <div class="col-md-12 col-xl-12">
                                <form method="post">
                                    <div class="form-group row col-lg-offset-6">

                                        <label class="col-sm-4 col-form-label">Select School</label>
                                        <div class="col-sm-4">
                                            <select name="schema_name" class="form-control select2" id="payment_schema">
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
                                    </div>
                                    <div class="form-group row col-lg-offset-6">
                                        <label class="col-sm-4 col-form-label">Select Date</label>
                                        <div class="col-sm-4">
                                            <input type="date" name="date" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group row col-lg-offset-6">
                                        <label class="col-sm-4 col-form-label"></label>
                                        <div class="col-sm-4">
                                            <?= csrf_field() ?>
                                            <input type="submit" name="submit" class="form-control btn btn-success"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                                        <?php
                                        if (isset($returns) && count($returns) > 0) {
                                            foreach ($returns as $return) {


                                                $data = $return->transactions;
                                                if (count($data) > 0) {
                                                    $trans = (object) $data;
                                                    $i = 1;
                                                    foreach ($trans as $tran) {

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
                                                                if (count($check) == 0) {
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
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> </div>
                </div> </div>
        </div> </div>
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
    //    $(document).ready(function () {
    //        var table = $('#api_requests').DataTable({
    //            "processing": true,
    //            "serverSide": true,
    //            'serverMethod': 'post',
    //            'ajax': {
    //                'url': "<?= url('software/api/null?tag=get') ?>"
    //            },
    //            "columns": [
    //                {"data": "id"},
    //                {"data": "content"},
    //                {"data": "created_at"},
    //                {"data": ""}
    //            ],
    //            "columnDefs": [
    //                {
    //                    "targets": 3,
    //                    "data": null,
    //                    "render": function (data, type, row, meta) {
    //
    //                        return '<a href="#" id="' + row.id + '" class="label label-danger dlt_log" onmousedown="delete_log(' + row.id + ')" onclick="return false">Delete</a>';
    //
    //
    //                    }
    //
    //                }
    //            ],
    //
    //            rowCallback: function (row, data) {
    //                //$(row).addClass('selectRow');
    //                $(row).attr('id', 'log' + data.id);
    //            }
    //        });
    //        delete_log = function (a) {
    //            $.ajax({
    //                url: '<?= url('software/logsDelete') ?>/null',
    //                method: 'get',
    //                data: {id: a},
    //                success: function (data) {
    //                    if (data == '1') {
    //                        $('#log' + a).fadeOut();
    //                    }
    //                }
    //            });
    //        }
    //    }
    //    );
    //    $('#schema_select').change(function () {
    //        var schema = $(this).val();
    //        if (schema == 0) {
    //            return false;
    //        } else {
    //            window.location.href = "<?= url('software/logs') ?>/" + schema;
//        }
//    });

</script>
@endsection


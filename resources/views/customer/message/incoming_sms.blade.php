@extends('layouts.app')
@section('content')

<script type="text/javascript" src="<?= url('/public') ?>/assets/select2/select2.js"></script> 

<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>SMS received</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Incoming SMS</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-lg-6"></div>
                <div class="card table-card widget-danger-card col-lg-6">
                    <div class="card-footer">
                        <div class="task-list-table">
                            <p class="task-due"><strong>School with highest SMS logs: </strong><strong class="label label-danger"><?= isset($danger_schema) ? $danger_schema->schema_name : '' ?></strong></p>
                        </div>
                        <div class="task-board m-0">
                            <a href="#" class="btn btn-info btn-mini b-none" title="view"><i class="icofont icofont-eye-alt m-0"></i></a>

                        </div>
                        <!-- end of pull-right class -->
                    </div>
                </div>
            </div>
            <div class="row">

                <!-- Documents card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks dark-primary-border">
                        <div class="card-block">
                            <h5>All SMS Received</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-document-folder"></i>
                                </li>
                                <li class="text-right">
                                    <?= sizeof($sms_logs) ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Documents card end -->
                <!-- New clients card start -->
                <?php
                foreach ($user_groups as $group) {
                    ?>
                    <div class="col-md-6 col-xl-3">
                        <div class="card client-blocks warning-border">
                            <div class="card-block">
                                <h5><?= $group->table == '' ? 'Unknown group' : $group->table ?></h5>
                                <ul>
                                    <li>
                                        <i class="icofont icofont-ui-user-group text-warning"></i>
                                    </li>
                                    <li class="text-right text-warning">
                                        <?= $group->count ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- Open Project card end -->
                <div class="col-md-12 col-xl-12">
                    <div class="form-group row col-lg-offset-6">
                        <label class="col-sm-4 col-form-label">Select School</label>
                        <div class="col-sm-4">
                            <select name="select" class="form-control select2" id="schema_select">
                                <option value="0">Select</option>
                                <?php
                                $schemas = DB::select('select distinct "schema_name" from admin.all_reply_sms');
                                foreach ($schemas as $schema) {
                                    ?>
                                    <option value="<?= $schema->schema_name ?>"><?= $schema->schema_name ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-12">
                    <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                    <strong>( <?= sizeof($sms_logs) ?>)</strong> SMS
                                </a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item complete">
                                <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false">Read SMS</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item complete">
                                <a class="nav-link" data-toggle="tab" href="#messages3" role="tab" aria-expanded="false">Summary</a>
                                <div class="slide"></div>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">

                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="sms_log_table" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>                                                
                                                    <th>Date</th>
                                                    <th>From</th>
                                                    <th>Message</th>
                                                    <th>Group</th>
                                                    <th>School</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>                                                
                                                    <th>Date</th>
                                                    <th>From</th>
                                                    <th>Message</th>
                                                    <th>Group</th>
                                                    <th>School</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="simpletable_read_sms" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>                                                
                                                    <th>Date</th>
                                                    <th>From</th>
                                                    <th>Message</th>
                                                    <th>Group</th>
                                                    <th>School</th>
                                                </tr>
                                            </thead>

                                            <tfoot>
                                                <tr>
                                                    <th>#</th>                                                
                                                    <th>Date</th>
                                                    <th>From</th>
                                                    <th>Message</th>
                                                    <th>Group</th>
                                                    <th>School</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="messages3" role="tabpanel" aria-expanded="false">
                                <a href="#" class="btn btn-sm btn-success" id="show_summary" style="display: none">Show Summary</a>
                                <div id="custom_logs"></div>
                                <div class="email-card p-0" id="log_summary">
                                    <div class="card-block">

                                        <div class="mail-body-content">
                                            <div class="card">


                                                <div class="card-block table-border-style">
                                                    <div class="table-responsive analytic-table">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Error Instance Name</th>
                                                                    <th>Count</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sql = 'select "schema_name",count(*) from admin.all_reply_sms group by "schema_name"';
                                                                $logs = DB::select($sql);
                                                                foreach ($logs as $log) {
                                                                    ?>
                                                                    <tr>
                                                                        <td>

                                                                            <span class="table-msg"><?= $log->schema_name ?></span>
                                                                        </td>
                                                                        <td><?= $log->count ?></td>
                                                                        <td> <a href="#" onmousedown='getErrorPage("<?= $log->count ?>")' onclick="return false" class="btn btn-sm btn-warning btn-outline-warning waves-effect md-trigger">View</a></td>
                                                                    </tr>
                                                                <?php }
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#sms_log_table').DataTable({
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
                'url': "<?= url('sales/show/null?page=sms_reply_logs') ?>"
            },
            "columns": [
                {"data": "id"},
                {"data": "created_at"},
                {"data": "from"},
                {"data": "message"},
                {"data": "table"},
                {"data": "schema_name"},
                {"data": ""}
            ],
            "columnDefs": [
                {
                    "targets": 6,
                    "data": null,
                    "render": function (data, type, row, meta) {

                        return '<a href="#" id="' + row.id + '" class="label label-danger dlt_log" onmousedown="delete_log(' + row.id + ')" onclick="return false">Delete</a>';


                    }

                }
            ],

            rowCallback: function (row, data) {
                //$(row).addClass('selectRow');
                $(row).attr('id', 'log' + data.id);
            }
        });
        View_log = function (a) {

            window.location.href = "<?= url('software/Readlogs') ?>/" + a;
        },
                delete_log = function (a) {
                    $.ajax({
                        url: '<?= url('software/logsDelete') ?>/null',
                        method: 'get',
                        data: {id: a},
                        success: function (data) {
                            if (data == '1') {
                                $('#log' + a).fadeOut();
                            }
                        }
                    });
                }

    }
    );
    $('#schema_select').change(function () {
        var schema = $(this).val();
        if (schema == 0) {
            return false;
        } else {
            window.location.href = "<?= url('software/logs') ?>/" + schema;
        }
    });

    getErrorPage = function (a) {
        $.ajax({
            url: '<?= url('software/logsView') ?>/null',
            method: 'get',
            data: {type: a},
            success: function (data) {
                $('#log_summary').hide();
                $('#custom_logs').html(data).show();
                $('#show_summary').show();
                console.log(data);
            }
        });
    }
    $('#show_summary').mousedown(function () {
        $(this).hide();
        $('#log_summary').show();
        $('#custom_logs').hide();
    });

    $(document).ready(function () {
        var table = $('#simpletable_read_sms').DataTable({
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
                'url': "<?= url('sales/show/null?page=opened_sms') ?>"
            },
            "columns": [
                {"data": "id"},
                {"data": "created_at"},
                {"data": "from"},
                {"data": "message"},
                {"data": "table"},
                {"data": "schema_name"}
            ],

            rowCallback: function (row, data) {
                $(row).attr('id', 'log' + data.id);
            }
        });
    });


    $('#schema_select').select2({
        placeholder: "Select a State",
        allowClear: true
    });
</script>
@endsection

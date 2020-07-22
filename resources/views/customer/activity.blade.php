@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>SCHOOL ACTIVITIES OR TASK PERFORMED</h4>
                <span>This Part Show all added Task performed on schools</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Customer Support</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Activities</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-success btn-sm" href="<?= url('customer/activity/add') ?>"> Add New Task</a>
                            <span style="float: right">
                                <input type="date" style="width:300px;" class="form-control" placeholder="Time" id='daskdate'>
                            </span>

                        </div>

                        <div class="card-block">

                            <div class="table-responsive dt-responsive">
                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Task type</th>
                                            <th>Added By</th>
                                            <th>School</th>
                                            <th>Deadline</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Task type</th>
                                            <th>Added By</th>
                                            <th>School</th>
                                            <th>Deadline</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Page-body end -->
        </div>
    </div>
    <!-- Main-body end -->
    @endsection
    @section('footer')
    <!-- data-table js -->
    <?php $root = url('/') . '/public/' ?>

    <script type="text/javascript">
        load_tasks = function () {
            var table = $('#dt-ajax-array').DataTable({
                "processing": true,
                "serverSide": true,
                'serverMethod': 'post',
                'ajax': {
                    'url': "<?= url('sales/show/null?page=tasks') ?>"
                },
                "columns": [

                    {"data": "id"},
                    {"data": "task_name"},

                    {"data": "user_name"},
                    {"data": "school_name"},
                    {"data": "date"},
                    {"data": ""},
                    {"data": ""}
                ],
                "columnDefs": [
                    {
                        "targets": 6,
                        "data": null,
                        "render": function (data, type, row, meta) {

                            return '<a href="<?= url('customer/activity/show/') ?>/' + row.id + '" class="btn btn-mini waves-effect waves-light btn-primary"> <i class="icofont icofont-eye-alt"></i> View</a>';


                        }

                    },
                    {
                        "targets": 5,
                        "data": null,
                        "render": function (data, type, row, meta) {
                            var status;
                            var message;
                            if (row.status == 'complete') {
                                status = 'success';
                                message = 'Complete';

                            } else if (row.status == 'on progress') {
                                status = 'warning';
                                message = 'On progress';
                            } else {
                                status = 'danger';
                                message = 'New';
                            }
                            return '<div class="dropdown-secondary dropdown f-right"><button class="btn btn-' + status + ' btn-mini dropdown-toggle waves-effect waves-light" type="button" id="dropdown6' + row.id + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' + message + '</button><div class="dropdown-menu" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"><a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_status(\'on progress\',' + row.id + ')"><span class="point-marker bg-danger"></span>On progress</a> <a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_status(\'complete\',' + row.id + ')"><span class="point-marker bg-warning"></span>Complete</a><a class="dropdown-item waves-light waves-effect" href="#!" onmousedown="change_status(\'new\',' + row.id + ')"><span class="point-marker bg-warning"></span>New</a></div> <span class="f-left m-r-5 text-inverse" style="display:none">Priority : ' + row.priority + '</span></div>';


                        }

                    },
                ],

                rowCallback: function (row, data) {
                    $(row).click(function (row) {
                       // window.location.href = '<?= url('customer/activity/show/') ?>/' + row.id;
                    });
                    //$(row).attr('id', 'log' + data.id);

                }
            });
            change_status = function (a, b) {
                $.ajax({
                    url: '<?= url('customer/changeStatus') ?>/null',
                    method: 'get',
                    data: {status: a, id: b},
                    success: function (data) {

                        $('#dropdown6' + b).html(data).removeClass('btn btn-danger').addClass('btn btn-primary');

                    }
                });
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
        $(document).ready(load_tasks);

        $('#taskdate').change(function (event) {
            var taskdate = $(this).val();
            if (taskdate === '') {
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?= url('customer/activity') ?>",
                    data: {taskdate: taskdate},
                    dataType: "html",
                    success: function (data) {
                        $('#classes_id').html(data);
                    }
                });
            }
        });

    </script>
    @endsection

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
                                            <th>Task Performed</th>
                                            <th>Added By</th>
                                            <th>School</th>
                                            <th> Deadline</th>
                                            <th>Added On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if ($i == 0) {
                                            foreach ($activities as $activity) {
                                                ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $activity->taskType->name ?></td>
                                                    <td><a href="<?= url('customer/activity/show/' . $activity->id) ?>"><?= substr($activity->activity, 0, 60) ?></a></td>

                                                    <td><?= $activity->user->firstname ?></td>
                                                    <td><?= $activity->client->username ?></td>
                                                    <td><?= $activity->date ?> <?= $activity->time ?></td>

                                                    <td><?= $activity->created_at ?></td>
                                                    <td><a href="<?= url('customer/activity/show/' . $activity->id) ?>" class="btn btn-mini waves-effect waves-light btn-primary"> <i class="icofont icofont-eye-alt"></i> View</a></td>
                                                </tr>
                                            <?php }
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Task type</th>
                                            <th>Task Title</th>
                                            <th>Added By</th>
                                            <th>School</th>
                                            <th>Added On</th>
                                            <th> Deadline</th>
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
                    {"data": "activity"},
                    {"data": "user_name"},
                    {"data": "school_name"},
                    {"data": "created_at"},
                    {"data": "date"},
                    {"data": ""}
                ],
                "columnDefs": [
                    {
                        "targets": 7,
                        "data": null,
                        "render": function (data, type, row, meta) {

                            return '<a href="<?= url('customer/activity/show/') ?>/'+row.id+'" class="btn btn-mini waves-effect waves-light btn-primary"> <i class="icofont icofont-eye-alt"></i> View</a>';


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
        $(document).ready(load_tasks);

        $('#taskdate').change(function (event) {
            var taskdate = $(this).val();
            if (taskdate === '') {
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?= url('customer/activity') ?>",
                    data: {taskdate: class_levtaskdateel_id},
                    dataType: "html",
                    success: function (data) {
                        $('#classes_id').html(data);
                    }
                });
            }
        });

    </script>
    @endsection

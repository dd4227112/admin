@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/fullcalendar/dist/fullcalendar.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>/bower_components/fullcalendar/dist/fullcalendar.print.css" media='print'>
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
                            <?php
                            if (Auth::user()->role_id == 1) {
                                $users = \App\Models\User::where('status', 1)->where('role_id', '<>', 7)->get();
                                ?>
                                <span style="float: right">
                                    <select class="form-control" style="width:300px;"  id='taskdate'>
                                        <option></option>
                                        <?php foreach ($users as $user) { ?>
                                            <option value="<?= $user->id ?>" <?= (int) request('user_id') > 0 && request('user_id') == $user->id ? 'selected' : '' ?> ><?= $user->firstname . ' ' . $user->lastname ?></option>
                                        <?php } ?>
                                    </select>

                                </span>

                            <?php } ?>

                        </div>
                        <div class="col-lg-12 col-xl-12">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs  tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">All Tasks</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#Completed" role="tab">Completed</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#Progress" role="tab">On Progress</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#Pending" role="tab">Pending</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#profile1" role="tab">Calender & Schedules</a>
                                </li>

                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content tabs card-block">
                                <div class="tab-pane active" id="home1" role="tabpanel">
                                    <div class="card-block">

                                        <div class="table-responsive dt-responsive">
                                            <table id="dt-ajax-array" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>School</th>
                                                        <th>Task type</th>
                                                        <th>Activity</th>
                                                          <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>No</th>
                                                          <th>School</th>
                                                        <th>Task type</th>
                                                        <th>Activity</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Completed Tasks -->
                                <div class="tab-pane" id="Completed" role="tabpanel">
                                
                                <div class="table-responsive">
                                    <table class="table dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Task type</th>
                                                        <th>Activity</th>
                                                        <th>End Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1;

                                                $tasks = \App\Models\Task::where('user_id', $user = Auth::user()->id)->where('status', 'complete')->orderBy('created_at', 'desc')->get();
                                                if (count($tasks) > 0) {
                                                    foreach ($tasks as $act){
                                                     ?>
                                                  <tr>
                                                  <td><?=$i++?></td>
                                                  <td><?=$act->tasktype->name?></td>
                                                  <td><?=substr($act->activity, 0, 60)?></td>
                                                  <td><?=$act->end_date?></td>
                                                  <td> <a href="<?=url('customer/activity/show/'.$act->id)?>">View</a> </td>
                                                </tr>
                                                  <?php } ?>
                                                  <?php } ?>
                                                </tbody>
                                                <tfooter>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Task type</th>
                                                        <th>Activity</th>
                                                        <th>End Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfooter>
                                            </table>
                                        </div>
                                    </div>
                                <!-- Completed Tasks -->
<!-- Completed Tasks -->
<div class="tab-pane" id="Progress" role="tabpanel">
                                
                                <div class="table-responsive">
                                    <table class="table dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Task type</th>
                                                        <th>Activity</th>
                                                        <th>End Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1;

                                                $tasks = \App\Models\Task::where('user_id', $user = Auth::user()->id)->where('status', 'on progress')->orderBy('created_at', 'desc')->get();
                                                if (count($tasks) > 0) {
                                                    foreach ($tasks as $act){
                                                     ?>
                                                  <tr>
                                                  <td><?=$i++?></td>
                                                  <td><?=$act->tasktype->name?></td>
                                                  <td><?=substr($act->activity, 0, 60)?></td>
                                                  <td><?=$act->end_date?></td>
                                                  <td> <a href="<?=url('customer/activity/show/'.$act->id)?>">View</a> </td>
                                                </tr>
                                                  <?php } ?>
                                                  <?php } ?>
                                                </tbody>
                                                <tfooter>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Task type</th>
                                                        <th>Activity</th>
                                                        <th>End Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfooter>
                                            </table>
                                        </div>
                                    </div>
                                <!-- Completed Tasks -->
                                <!-- Completed Tasks -->
                                <div class="tab-pane" id="Pending" role="tabpanel">
                                
                                <div class="table-responsive">
                                    <table class="table dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Task type</th>
                                                        <th>Activity</th>
                                                        <th>End Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1;

                                                $tasks = \App\Models\Task::where('user_id', $user = Auth::user()->id)->where('status', 'new')->orderBy('created_at', 'desc')->get();
                                                if (count($tasks) > 0) {
                                                    foreach ($tasks as $act){
                                                     ?>
                                                  <tr>
                                                  <td><?=$i++?></td>
                                                  <td><?=$act->tasktype->name?></td>
                                                  <td><?=substr($act->activity, 0, 60)?></td>
                                                  <td><?=$act->end_date?></td>
                                                  <td> <a href="<?=url('customer/activity/show/'.$act->id)?>">View</a> </td>
                                                </tr>
                                                  <?php } ?>
                                                  <?php } ?>
                                                </tbody>
                                                <tfooter>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Task type</th>
                                                        <th>Activity</th>
                                                        <th>End Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfooter>
                                            </table>
                                        </div>
                                    </div>
                                <!-- Completed Tasks -->
                                <div class="tab-pane" id="profile1" role="tabpanel">
                                    <p class="m-0"><div id='calendar'></div></p>
                                </div>

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

    <!-- calender js -->
    <script type="text/javascript" src="<?= $root ?>/bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>assets/pages/full-calender/calendar.js?v=2"></script>
    <div id="ajax_data_results" style="display: none"></div>
    <script type="text/javascript">

        load_tasks = function () {
            var event;
            var table = $('#dt-ajax-array').DataTable({
                "processing": true,
                "serverSide": true,
                'serverMethod': 'post',
                'ajax': {
                    'url': "<?= url('sales/show/null?page=tasks&user_id=' . request('user_id')) ?>"
                },
                "columns": [

                    {"data": "id"},
                        {"data": "school_name"},
                    {"data": "task_name"},
                    {"data": "activity"},
                   {"data": "start_date"},
                    {"data": "end_date"},
                    {"data": ""},
                    {"data": ""}
                ],
                "columnDefs": [
                    {
                        "targets": 7,
                        "data": null,
                        "render": function (data, type, row, meta) {
                       
                            return '<a href="<?= url('customer/activity/show/') ?>/' + row.id + '" class="btn btn-mini waves-effect waves-light btn-primary"> <i class="icofont icofont-eye-alt"></i> View</a>';
                        }

                    },
                    {
                        "targets": 6,
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
                window.location.href = '<?= url('customer/activity') ?>/null?user_id=' + taskdate;
            }
        });
        "use strict";
        $(document).ready(function () {
            $('#external-events .fc-event').each(function () {

                // store data so the calendar knows to render an event upon drop
                $(this).data('event', {
                    title: $.trim($(this).text()), // use the element's text as the event title
                    stick: true // maintain when user navigates (see docs on the renderEvent method)
                });
                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });
            });
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listMonth'
                },
                defaultDate: '<?= date('Y-m-d') ?>',
                navLinks: true, // can click day/week names to navigate views
                businessHours: true, // display business hours
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                drop: function () {

                    // is the "remove after drop" checkbox checked?
                    if ($('#checkbox2').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },
                events: [
<?php
$user_id = (int) request('user_id') > 0 ? request('user_id') : Auth::user()->id;
$sql = "select t.id,t.activity,t.date, t.start_date,t.end_date, t.created_at,p.school_name,p.client,u.firstname||' '||u.lastname as user_name, substring(tt.name from 1 for 10) as task_name, t.status,t.priority from admin.tasks t left join (
select a.task_id, c.name as school_name,'Client' as client from admin.tasks_clients a join admin.clients c on c.id=a.client_id
UNION ALL
SELECT b.task_id, s.name as school_name, 'Not Client' as client from admin.tasks_schools b join admin.schools s on s.id=b.school_id ) p on p.task_id=t.id join admin.users u on u.id=t.user_id left join admin.task_types tt on tt.id=t.task_type_id where (u.id=" . $user_id . " OR t.id in (select task_id from admin.tasks_users where user_id=" . $user_id . " ) ) AND t.start_date::date=CURRENT_DATE";
$tasks = DB::select($sql);
foreach ($tasks as $task) {
    ?>
                    /**
                     * Removing Line Breaks and Newlines in PHP
                     */
                        {
                            title: '<?= $task->school_name . ': ' . preg_replace('/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/', '', preg_replace('/[ \t]+/', ' ', preg_replace('/\s*$^\s*/m', "\n", addslashes(strip_tags($task->activity))))) ?>',
                            start: '<?= date('Y-m-d H:i:s', strtotime($task->start_date)); ?>',
                            end: '<?= date('Y-m-d H:i:s', strtotime($task->end_date)); ?>',
                            constraint: 'businessHours',
                            editable: true,
                            borderColor: '#1abc9c',
                            textColor: '#000'
                        },
<?php } ?>




                ]
            });
        });

    </script>
    @endsection

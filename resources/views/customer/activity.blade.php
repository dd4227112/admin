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
                          <?php if(can_access('add_task')) { ?>
                            <a class="btn btn-success btn-sm" href="<?= url('customer/activity/add') ?>"> Add New Task</a>
                          <?php } ?>
                            <?php
                            if (Auth::user()->role_id == 1) {
                                $users = \App\Models\User::where('status', 1)->where('role_id', '<>', 7)->get();
                            ?>
                                <span style="float: right">
                                    <select class="form-control" style="width:300px;" id='taskdate'>
                                        <option></option>
                                        <?php foreach ($users as $user) { ?>
                                            <option value="<?= $user->id ?>" <?= (int) request('user_id') > 0 && request('user_id') == $user->id ? 'selected' : '' ?>><?= $user->firstname . ' ' . $user->lastname ?></option>
                                        <?php } ?>
                                    </select>
                                </span>

                            <?php } ?>

                        </div>
                        <div class="col-lg-12 col-xl-12">
                            <div class="card-block">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs  tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#newtask" role="tab">New task</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#Progress" role="tab">On Progress</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#Completed" role="tab">Completed</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#home1" role="tab">All Tasks</a>
                                    </li>
               
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#profile1" role="tab">Calender & Schedules</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content tabs">
                                        {{-- New tasks --}}

                                        <div class="tab-pane" id="home1" role="tabpanel">
                                            <div class="table-responsive  table-striped table-bordered table-hover">
                                                <table class="table dataTable">
                                                    <tr>
                                                        <th>All tasks</th>
                                                        <th>New tasks</th>
                                                        <th>Progressed tasks</th>
                                                        <th>Completed tasks</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center"><?= \App\Models\Task::where('user_id', $user = Auth::user()->id)->count();  ?></th>
                                                        <th class="text-center"><?= \App\Models\Task::where('user_id', $user = Auth::user()->id)->where('status', 'new')->count();  ?></th>
                                                        <th class="text-center"><?= \App\Models\Task::where('user_id', $user = Auth::user()->id)->where('status', 'on progress')->count(); ?></th>
                                                        <th class="text-center"><?= \App\Models\Task::where('user_id', $user = Auth::user()->id)->where('status', 'complete')->count();?></th>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="display nowrap table dataTable dt-ajax-array table-bordered">
                                                  <thead>
                                                      <tr>
                                                          <th>No.</th>
                                                          <th>Task type</th>
                                                          <th>Priority</th>
                                                          <th>School</th>
                                                          <th>Activity</th>
                                                          <th>Status</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                 </tbody>
                                              </table>
                                          </div>
                                      </div>


                                 <div class="tab-pane active" id="newtask" role="tabpanel">
                                        <div class="table-responsive  table-striped table-bordered table-hover">
                                            <table class="table dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Task type</th>
                                                        <th>Priority</th>
                                                        <th >Activity</th>
                                                        <th>End Date</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1; $date = \Carbon\Carbon::today()->subDays(2);
                                                    $tasks = \App\Models\Task::where('user_id', $user = Auth::user()->id)->where('created_at','>=',$date)->where('status', 'new')->orderBy('created_at', 'desc')->limit(100)->get();
                                                  //  dd($tasks);
                                                    if (!empty($tasks)) { 
                                                        foreach ($tasks as $act) {
                                                               if ($act->priority == '1') {
                                                                    $status = 'success';
                                                                    $message = 'High';
                                                                } else if ($act->priority == '2') {
                                                                    $status = 'warning';
                                                                    $message = 'Medium';
                                                                } else if ($act->priority == '3'){
                                                                    $status = 'info';
                                                                    $message = 'Less';
                                                                } else {
                                                                    $status = '';
                                                                    $message = '';
                                                                }
                                                            ?>

                                                               <?php if($act->status == 'complete') { 
                                                                        $stat = 'success';
                                                                        $msg = 'Complete';
                                                                    } else if ($act->status == 'on progress') {
                                                                        $stat = 'warning';
                                                                        $msg = 'On progress';
                                                                    } else {
                                                                        $stat = 'danger';
                                                                        $msg = 'New';
                                                                    }
                                                                 ?>
                                                            <tr>
                                                                <td><?= $i++ ?></td>
                                                                <?php if(can_access('view_task')) { ?>
                                                                <td><a href="<?= url('customer/activity/show/' . $act->id) ?>"> <?= $act->tasktype->name ?> </a> </td>
                                                                <?php } else { ?>
                                                                    <td> <?= $act->tasktype->name ?> </td>
                                                                <?php } ?>
                                                                <td> 
                                                                <div  class="dropdown-secondary dropdown f-right"><button class="btn btn-<?=$status ?>  btn-mini dropdown-toggle waves-effect waves-light"  type="button" id="dropdown7<?=$act->id?>"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $message ?></button><div class="dropdown-menu" aria-labelledby="dropdown7" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"><a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_priority(1,<?= $act->id?>)"><span class="point-marker bg-danger"></span>High</a> <a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_priority(2,<?= $act->id?>)"><span class="point-marker bg-warning"></span>Medium</a><a class="dropdown-item waves-light waves-effect" href="#!" onmousedown="change_priority(3,<?= $act->id?>)"><span class="point-marker bg-warning"></span>Less</a></div> </div>
                                                                </td>
                                                                <td style="width: 100px;word-break: break-all;">
                                                                    <?= substr($act->activity, 0, 30) ?>
                                                                </td>
                                                                <td><?= cdate($act->end_date) ?></td>
                                                                <td> 
                                                                    <div class="dropdown-secondary dropdown f-right"><button class="btn btn-<?=$stat?> btn-mini dropdown-toggle waves-effect waves-light"  type="button" id="dropdown6<?=$act->id?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$msg?></button><div class="dropdown-menu" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"><a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_status('on progress',<?=$act->id ?>)"><span class="point-marker bg-danger"></span>On progress</a> <a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_status('complete',<?=$act->id ?>)"><span class="point-marker bg-warning"></span>Complete</a><a class="dropdown-item waves-light waves-effect" href="#!" onmousedown="change_status('new',<?=$act->id ?>)"><span class="point-marker bg-warning"></span>New</a></div> </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                            
                                                </tbody>
                                                <tfooter>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Task type</th>
                                                        <th>Priority</th>
                                                        <th>Activity</th>
                                                        <th>End Date</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </tfooter>
                                        </table>
                                      </div>
                                    </div>

                                        {{-- New Progress --}}
                                    <div class="tab-pane" id="Progress" role="tabpanel">
                                        <div class="table-responsive  table-striped table-bordered table-hover">
                                            <table class="table dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Task type</th>
                                                        <th>Priority</th>
                                                        <th>Activity</th>
                                                        <th>End Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $tasks = \App\Models\Task::where('user_id', $user = Auth::user()->id)->where('status', 'on progress')->orderBy('created_at', 'desc')->limit(100)->get();
                                                    if (!empty($tasks)) {
                                                        foreach ($tasks as $act) {
                                                            if ($act->priority == '1') {
                                                                    $status = 'success';
                                                                    $message = 'High';
                                                                } else if ($act->priority == '2') {
                                                                    $status = 'warning';
                                                                    $message = 'Medium';
                                                                } else if ($act->priority == '3'){
                                                                    $status = 'info';
                                                                    $message = 'Less';
                                                                } else {
                                                                    $status = '';
                                                                    $message = '';
                                                                }
                                                          ?>
                                                            <tr>
                                                                <td><?= $i++ ?></td>
                                                                <?php if(can_access('view_task')) { ?>
                                                                <td><a href="<?= url('customer/activity/show/' . $act->id) ?>"> <?= $act->tasktype->name ?> </a> </td>
                                                                <?php } else { ?>
                                                                 <td> <?= $act->tasktype->name ?> </td>
                                                                <?php } ?>
                                                                <td>  
                                                                <div class="dropdown-secondary dropdown f-right text-center"><button class="btn btn-<?=$status ?>  btn-mini dropdown-toggle waves-effect waves-light"  type="button" id="dropdown7<?=$act->id?>"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $message ?></button><div class="dropdown-menu" aria-labelledby="dropdown7" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"><a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_priority(1,<?= $act->id?>)"><span class="point-marker bg-danger"></span>High</a> <a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_priority(2,<?= $act->id?>)"><span class="point-marker bg-warning"></span>Medium</a><a class="dropdown-item waves-light waves-effect" href="#!" onmousedown="change_priority(3,<?= $act->id?>)"><span class="point-marker bg-warning"></span>Less</a></div> </div>
                                                                </td>
                                                                <td><?= substr($act->activity, 0, 60) ?></td>
                                                                <td><?= cdate($act->end_date) ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tbody>
                                                <tfooter>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Task type</th>
                                                        <th>Priority</th>
                                                        <th>Activity</th>
                                                        <th>End Date</th>
                                                    </tr>
                                                </tfooter>
                                            </table>
                                        </div>
                                    </div>

                                  
                                    <!-- Completed Tasks -->
                                    <div class="tab-pane" id="Completed" role="tabpanel">
                                        <div class="table-responsive  table-striped table-bordered table-hover">
                                            <table class="table dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Task type</th>
                                                        <th>Priority</th>
                                                        <th>Activity</th>
                                                        <th>End Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $tasks = \App\Models\Task::where('user_id', $user = Auth::user()->id)->where('status', 'complete')->orderBy('created_at', 'desc')->limit(100)->get();
                                                    if (!empty($tasks)) { 
                                                        foreach ($tasks as $act) {
                                                            if ($act->priority == '1') {
                                                                    $status = 'success';
                                                                    $message = 'High';
                                                                } else if ($act->priority == '2') {
                                                                    $status = 'warning';
                                                                    $message = 'Medium';
                                                                } else if ($act->priority == '3'){
                                                                    $status = 'info';
                                                                    $message = 'Less';
                                                                } else {
                                                                    $status = '';
                                                                    $message = '';
                                                                }
                                                            ?>
                                                            <tr>
                                                                <td><?= $i++ ?></td>
                                                                <?php if(can_access('view_task')) { ?>
                                                                <td><a href="<?= url('customer/activity/show/' . $act->id) ?>"> <?= $act->tasktype->name ?> </a> </td>
                                                                <?php } else { ?>
                                                                 <td> <?= $act->tasktype->name ?> </td>
                                                                <?php } ?>
                                                                <td>  
                                                                <div class="dropdown-secondary dropdown f-right text-center"><button class="btn btn-<?=$status ?>  btn-mini dropdown-toggle waves-effect waves-light"  type="button" id="dropdown7<?=$act->id?>"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $message ?></button><div class="dropdown-menu" aria-labelledby="dropdown7" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"><a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_priority(1,<?= $act->id?>)"><span class="point-marker bg-danger"></span>High</a> <a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_priority(2,<?= $act->id?>)"><span class="point-marker bg-warning"></span>Medium</a><a class="dropdown-item waves-light waves-effect" href="#!" onmousedown="change_priority(3,<?= $act->id?>)"><span class="point-marker bg-warning"></span>Less</a></div> </div>
                                                                </td>
                                                                <td><?= substr($act->activity, 0, 60) ?></td>
                                                                <td><?= cdate($act->end_date) ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tbody>
                                                <tfooter>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Task type</th>
                                                        <th>Priority</th>
                                                        <th>Activity</th>
                                                        <th>End Date</th>
                                                    </tr>
                                                </tfooter>
                                            </table>
                                        </div>
                                    </div>

                
                                    <div class="tab-pane" id="profile1" role="tabpanel">
                                        <p class="m-0">
                                            <div id='calendar'></div>
                                        </p>
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
            load_tasks = function() {
                var event;
                var table = $('.dt-ajax-array').DataTable({
                    "processing": true,
                    "serverSide": true,
                    'serverMethod': 'post',
                    'ajax': {
                        'url': "<?= url('sales/show/null?page=tasks&user_id=' . request('user_id')) ?>"
                    },
                    "columns": [

                        {
                            "data": "id"
                        },
                        {
                            "data": ""
                        },
                        {
                            "data": ""
                        },
                        {
                            "data": "school_name"
                        },
                        {
                            "data": ""
                        },
                        {
                            "data": ""
                        }
                      
                    ],
                    "columnDefs": [{
                            "targets":1,
                            "data": null,
                            "render": function(data, type, row, meta) {
                                return '<a href="<?= url('customer/activity/show/') ?>/' + row.id + '"> ' + row.task_name + '  </a>';
                             }
                           },
                           {
                            "targets":2,
                            "data": null,
                            "render": function(data, type, row, meta) {
                                var status;
                                var message;
                                if (row.priority == '1') {
                                    status = 'success';
                                    message = 'High';
                                } else if (row.priority == '2') {
                                    status = 'warning';
                                    message = 'Medium';
                                } else if (row.priority == '3'){
                                    status = 'info';
                                    message = 'Less';
                                } else {
                                    status = '';
                                    message = '';
                                }
                                return '<div class="dropdown-secondary dropdown f-right text-center"><button class="btn btn-' + status + ' btn-mini dropdown-toggle waves-effect waves-light"  type="button" id="dropdown7' + row.id + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' + message + '</button><div class="dropdown-menu" aria-labelledby="dropdown7" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"><a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_priority(\'1\',' + row.id + ')"><span class="point-marker bg-danger"></span>High</a> <a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_priority(\'2\',' + row.id + ')"><span class="point-marker bg-warning"></span>Medium</a><a class="dropdown-item waves-light waves-effect" href="#!" onmousedown="change_priority(\'3\',' + row.id + ')"><span class="point-marker bg-warning"></span>Less</a></div> <span class="f-left m-r-5 text-inverse" style="display:none">Priority : ' + row.priority + '</span></div>';
                            }
                           },
                         {
                            "targets":4,
                            "data": null,
                            "render": function(data, type, row, meta) {
                                return '<div style="white-space:normal; "> ' + row.activity + '  </div>';
                             }
                         },
                        {
                            "targets": 5,
                            "data": null,
                            "render": function(data, type, row, meta) {
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
                                return '<div class="dropdown-secondary dropdown f-right"><button class="btn btn-' + status + ' btn-mini dropdown-toggle waves-effect waves-light"  type="button" id="dropdown6' + row.id + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' + message + '</button><div class="dropdown-menu" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"><a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_status(\'on progress\',' + row.id + ')"><span class="point-marker bg-danger"></span>On progress</a> <a class="dropdown-item waves-light waves-effect" href="#!"  onmousedown="change_status(\'complete\',' + row.id + ')"><span class="point-marker bg-warning"></span>Complete</a><a class="dropdown-item waves-light waves-effect" href="#!" onmousedown="change_status(\'new\',' + row.id + ')"><span class="point-marker bg-warning"></span>New</a></div> <span class="f-left m-r-5 text-inverse" style="display:none">Priority : ' + row.priority + '</span></div>';
                            }

                        },
                    ],
                    rowCallback: function(row, data) {
                        $(row).click(function(row) {
                            // window.location.href = '<?= url('customer/activity/show/') ?>/' + row.id;
                        });
                        //$(row).attr('id', 'log' + data.id);

                    }
                });
                change_status = function(a, b) {
                        $.ajax({
                            url: '<?= url('customer/changeStatus') ?>/null',
                            method: 'get',
                            data: {
                                status: a,
                                id: b
                            },
                            success: function(data) {
                                $('#dropdown6' + b).html(data).removeClass('btn btn-danger').addClass('btn btn-primary');
                                window.location.reload();
                            }
                        });
                    },

                 change_priority = function(x,y){
                    $.ajax({
                            url: '<?= url('customer/changepriority') ?>/null',
                            method: 'get',
                            data: {
                                priority: x,
                                id: y
                            },
                            success: function(data) {   console.log(x);
                                $('#dropdown7' + y).html(data).removeClass('btn btn-danger').addClass('btn btn-primary');
                                window.location.reload();
                            }
                        });
                    },

                    delete_log = function(a) {
                        $.ajax({
                            url: '<?= url('software/logsDelete') ?>/null',
                            method: 'get',
                            data: {
                                id: a
                            },
                            success: function(data) {
                                if (data == '1') {
                                    $('#log' + a).fadeOut();
                                }
                            }
                        });
                    }
            }
            $(document).ready(load_tasks);
            $('#taskdate').change(function(event) {
                var taskdate = $(this).val();
                if (taskdate === '') {} else {
                    window.location.href = '<?= url('customer/activity') ?>/null?user_id=' + taskdate;
                }
            });
            "use strict";
            $(document).ready(function() {
                $('#external-events .fc-event').each(function() {
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
                    drop: function() {

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
@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/';

$page = request()->segment(3);
$today = 0;

if ((int) $page == 1 || $page == 'null' || (int) $page == 0) {
    //current day
    $where = '  a.created_at::date=CURRENT_DATE';
    $today = 1;
    $year = date('Y');
} else {
    $start_date = date('Y-m-d', strtotime(request('start')));
    $end_date = date('Y-m-d', strtotime(request('end')));
    $year = date('Y', strtotime(request('start')));
    $where = "  a.created_at::date >='" . $start_date . "' AND a.created_at::date <='" . $end_date . "'";
}
?>
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-title">
            <?php
            $on = 'Today';
            ?>
            <?php
            $where_setting = (int) $today == 1 ? ' ' : " WHERE a.created_at::date <='" . $end_date . "'";
            $out_of = \collect(DB::select('select count(*) from admin.all_setting a   ' . $where_setting))->first()->count;
            $active_customers = \collect(DB::select('select count(distinct "schema_name") from admin.all_login_locations a  WHERE "table" in (\'parent\',\'user\',\'teacher\') and ' . $where))->first()->count;
            $total_activity = \collect(DB::select('select count(*) from admin.tasks a where  a.user_id in (select id from admin.users where department=1) and ' . $where . ' and a.status not in(\'Pending\',\'New\')'))->first()->count;
            ?>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Summary</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="page-body">

        <div class="page-body">
            <div class="row">
                <div class="col-lg-3 text-left">


                    <?php
                    if (Auth::user()->role_id == 1) {
                        $users = \App\Models\User::where('status', 1)->where('role_id', '<>', 7)->get();
                        ?>
                        <span >
                            <select class="form-control" id='taskdate'>
                                <option></option>
                                <?php foreach ($users as $user) { ?>
                                    <option value="<?= $user->id ?>" <?= (int) request('user_id') > 0 && request('user_id') == $user->id ? 'selected' : '' ?>><?= $user->firstname . ' ' . $user->lastname ?></option>
                                <?php } ?>
                            </select>

                        </span>

                    <?php } ?>


                </div>
                <div class="col-lg-3"></div>

                <div class="col-lg-6 text-right">
                    <select class="form-control" id="check_custom_date">
                        <option value="today" <?= $today == 1 ? 'selected' : '' ?>>Today</option>
                        <option value="custom"  <?= $today == 0 ? 'selected' : '' ?>>Custom</option>
                    </select>

                </div>
            </div>
            <div class="row" style="display: none" id="show_date">

                <div class="col-lg-4"></div>
                <div class="col-lg-8 text-right">
                    <h4 class="sub-title">Date Time Picker</h4>
                    <div class="input-daterange input-group" id="datepicker">
                        <input type="date" class="input-sm form-control calendar" name="start" id="start_date">
                        <span class="input-group-addon">to</span>
                        <input type="date" class="input-sm form-control" name="end" id="end_date">
                        <input type="submit" class="input-sm btn btn-sm btn-success" id="search_custom"/>
                    </div>
                </div>

            </div>

            <div class="row">
                <!-- Documents card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks dark-primary-border">
                        <a href="<?= url('analyse/moreInsight') ?>"><div class="card-block">


                                <h5> Active Customers</h5>
                                <ul>
                                    <li>
                                        <i class="icofont icofont-document-folder"></i>
                                    </li>
                                    <li class="text-right">
                                        <?= $active_customers ?>
                                    </li>
                                    <span class="small">Out of <?= $out_of ?></span>
                                </ul>
                            </div></a>
                    </div>
                </div>
                <!-- Documents card end -->
                <!-- New clients card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks warning-border">
                        <div class="card-block">

                            <h5>Support Activities</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-ui-user-group text-warning"></i>
                                </li>
                                <li class="text-right text-warning">
                                    <?= $total_activity ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- New clients card end -->
                <!-- New files card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks success-border">
                        <div class="card-block">
                            <?php
                            //        $total_reacherd = \collect(DB::select('select count(distinct b.client_id) from admin.tasks a, admin.tasks_clients b WHERE a.id=b.task_id and  a.user_id in (select id from admin.users where department=1) AND ' . $where))->first()->count;
                            $total_reacherd = \collect(DB::select("select (count(distinct school_id) + count(distinct client_id)) as count from admin.tasks_schools a, admin.tasks_clients b where b.task_id in (select id from admin.tasks a where a.user_id in (select id from admin.users where department=1) and " . $where . ") and a.task_id in (select id from admin.tasks a where a.user_id in (select id from admin.users where department=1) and " . $where . ")"))->first()->count;
                            ?>
                            <h5>Schools Supported</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-files text-success"></i>
                                </li>
                                <li class="text-right text-success">
                                    <?= $total_reacherd ?>
                                </li>
                                <span class="small">Out of <?= $out_of ?></span>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- New files card end -->
                <!-- Open Project card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks">
                        <div class="card-block">
                            <?php
                            $total_with_students = \collect(DB::select('select count(distinct "schema_name") as count from admin.all_student'))->first()->count;
                            ?>
                            <h5>No students Schools</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-users text-primary"></i>
                                </li>
                                <li class="text-right text-primary">
                                    <?= $out_of - $total_with_students ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Documents card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks dark-primary-border">
                        <a href="<?= url('analyse/moreInsight') ?>"><div class="card-block">

                                <?php
                                $user = request()->segment(4);
                                $where_value = (int) $user > 0 ? ' where user_id=' . $user : '';
                                $sql = 'select sum((select count(*) from admin.all_student where "schema_name"=b.username and status=1))*10000 as total_value from admin.users_schools a left join admin.clients b on b.id=a.client_id left join admin.schools c on c.id=a.school_id  ' . $where_value;
                                $value = \collect(DB::select($sql))->first()->total_value;
                                ?>
                                <h5> Lead Value</h5>
                                <ul>
                                    <li>
                                        <i class="icofont icofont-money"></i>
                                    </li>
                                    <li class="text-right" style="    font-size: 29px !important;">
                                        <?= number_format($value) ?>
                                    </li>
                                    <span class="small">Out of Tsh 200mil Per User</span>
                                </ul>
                            </div></a>
                    </div>
                </div>
                <!-- Documents card end -->
                <!-- New clients card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks warning-border">
                        <div class="card-block">

                            <h5>Customer Retention Rate</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-ui-user-group text-warning"></i>
                                </li>
                                <li class="text-right text-warning">
                                    <?= $total_activity ?>
                                </li>
                                <span class="small">Out of Tsh 98%</span>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- New clients card end -->
                <!-- New files card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks success-border">
                        <div class="card-block">
                            <?php
//                            $user = request()->segment(4);
//                                $where_value = (int) $user > 0 ? ' where user_id=' . $user : '';
//                            $active_user_per_school = \collect(DB::select('select count(distinct "schema_name") from admin.all_login_locations a  WHERE "table" in (\'parent\',\'user\',\'teacher\') and ' . $where))->first()->count;
                            ?>
                            <h5>Active Users Per schools</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-files text-success"></i>
                                </li>
                                <li class="text-right text-success">
                                    <?= $total_reacherd ?>
                                </li>
                                <span class="small">Out of 70%</span>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- New files card end -->
                <!-- Open Project card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks">
                        <div class="card-block">
                            <?php
                            $total_with_students = \collect(DB::select('select count(distinct "schema_name") as count from admin.all_student'))->first()->count;
                            ?>
                            <h5>Customer ARP  </h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-users text-primary"></i>
                                </li>
                                <li class="text-right text-primary">
                                    <?= $out_of - $total_with_students ?>
                                </li>
                                <span class="small">Out of 70%</span>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Open Project card end -->
                <!-- Morris chart start -->
                <div class="col-md-12 col-xl-8">
                    <div class="card">

                        <div class="card-block">
                            <div id="login_graph"></div>
                            <?php
                            $sql_ = "select count(distinct (user_id,\"table\")) as count, created_at::date as date from admin.all_login_locations a where " . $where . " group by created_at::date ";
                            echo $insight->createChartBySql($sql_, 'date', 'Total Users Login', 'bar', false);
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Morris chart end -->
                <!-- Todo card start -->
                <div class="col-md-12 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Tasks</h5>
                            <!--<label class="label label-success">Today</label>-->
                        </div>
                        <div class="card-block">

                            <div class="new-task">
                                <div class="table-responsive">
                                    <table class="table dataTable">
                                        <thead>
                                            <tr class="text-capitalize">

                                                <th>Activity</th>
                                                <th>Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $tasks = DB::select('select count(a.*),b.name,b.id from admin.tasks a join admin.task_types b on b.id=a.task_type_id where   a.user_id in (select id from admin.users where department=1) and ' . $where . '  group by b.name, b.id');
                                            foreach ($tasks as $task) {
                                                ?>
                                                <tr>

                                                    <td><a href="<?= url('customer/taskGroup/task/' . $task->id) ?>"><?= $task->name ?></a></td>
                                                    <td><?= $task->count ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <!-- Todo card end -->
                <!-- User chat box start -->
                <div class="col-md-12 col-xl-8">
                    <div class="card widget-chat-box">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-2">
                                    <i class="icofont icofont-navigation-menu pop-up"></i>
                                </div>
                                <div class="col-sm-8 text-center">
                                    <h5>
                                        Tasks Activities
                                    </h5>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <!--<i class="icofont icofont-ui-edit"></i>-->
                                </div>
                            </div>
                            <table id="res-config" class="table table-bordered w-100 dataTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Task Type</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $activities = DB::select("select a.id, a.activity,a.created_at,b.name as task_name,a.user_id, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.task_types b on b.id=a.task_type_id join admin.users c on c.id=a.user_id WHERE   a.user_id in (select id from admin.users where department=1) and " . $where);
                                    foreach ($activities as $activity) {
                                        ?>
                                        <tr>
                                            <td class="img-pro">
                                                <a href="<?= url('customer/taskGroup/user/' . $activity->user_id) ?>"><?= $activity->user_name ?></a>
                                            </td>
                                        <!--    <td class="pro-name"><?= $activity->activity ?>
                                            </td>-->
                                            <td> <a href="<?= url('customer/activity/show/' . $activity->id) ?>"> <?= $activity->task_name ?></a> </td>
                                            <td>
                                                <label class="text-danger">  <?= $activity->created_at ?></label>
                                            </td>

                                        </tr>
                                    <?php } ?>


                                </tbody>
                            </table>

                        </div>
                        <div class="card-block">

                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5> Tasks count per School</h5>
                            <label class="label label-success"><?= $on ?></label>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table dataTable">
                                    <thead>
                                        <tr class="text-capitalize">

                                            <th>School</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sqls = "SELECT count(a.*),b.username from admin.tasks a join admin.tasks_clients c on a.id=c.task_id join admin.clients b on b.id=c.client_id
                                            WHERE a.user_id in (select id from admin.users where department=1) and " . $where . " and a.status not in('Pending','New') group by b.username
                                            UNION ALL
                                            select count(a.*),b.name from admin.tasks a join admin.tasks_schools c on a.id=c.task_id join admin.schools b on b.id=c.school_id
                                            WHERE a.user_id in (select id from admin.users where department=1) and " . $where . " and a.status not in('Pending','New') group by b.name";
                                        $tasks = DB::select($sqls);
                                        foreach ($tasks as $task) {
                                            ?>
                                            <tr>
                                                <td><?= substr($task->username, 0, 30) ?></td>
                                                <td><?= $task->count ?></td>

                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User chat box end -->



            </div>
            <!-- Todo card start -->
            <!-- Horizontal Timeline start -->
            <div class="col-md-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Average system usability</h5>
                    </div>
                    <div class="card-block">
                        <div class="cd-horizontal-timeline loaded">

                            <!-- .timeline -->
                            <div class="events-content">
                                <div class="card">

                                    <div class="card-block">

                                        <?php
                                        $sql_2 = "select count(id) as count, controller as module from admin.all_log a   where controller not in ('background','SmsController','signin','dashboard') and " . $where . "  group by controller order by count desc limit 10 ";

                                        echo $insight->createChartBySql($sql_2, 'module', 'System Usability Per Modules', 'bar', false);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- .events-content -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Horizontal Timeline end -->

            <div class="col-md-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Activities per Module</h5>
                    </div>
                    <div class="card-block">
                        <div class="cd-horizontal-timeline loaded">

                            <!-- .timeline -->
                            <div class="events-content">
                                <div class="card">

                                    <div class="card-block">
                                        <?php
                                        $sql_2_activities = "select count(m.id) as count ,m.name as modules from admin.modules m, admin.module_tasks mt,admin.users u,admin.tasks a where m.id=mt.module_id and mt.task_id =a.id and u.id =a.user_id and u.role_id in (14,8)  and " . $where . " group by m.name";
                                        echo $insight->createChartBySql($sql_2_activities, 'modules', 'Activities', 'bar', false);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- .events-content -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Horizontal Timeline end -->

            <?php
            $support_distribution = "select count(*) as count, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.users c on c.id=a.user_id WHERE   a.user_id in (select id from admin.users where department=1) and " . $where . " and a.status not in('Pending','New') group by user_name";
            echo $insight->createChartBySql($support_distribution, 'user_name', 'Support Activity', 'bar', false);
            ?>

            <?php
            $new_schools = 'select count(*),extract(month from created_at) as month from admin.all_setting
      where extract(year from created_at)=' . date('Y') . ' group by month order by month';
            echo $insight->createChartBySql($new_schools, 'month', 'Schools Onboarded', 'bar', false);
            ?>

        </div>
    </div>
</div>
<script type="text/javascript">

    check = function () {

        $('#check_custom_date').change(function () {
            var val = $(this).val();
            if (val == 'today') {
                window.location.href = '<?= url('analyse/customers/') ?>/1';
            } else {
                $('#show_date').show();
            }
        });

        $('#taskdate').change(function (event) {
            var taskdate = $(this).val();
            if (taskdate === '') {
            } else {
                window.location.href = '<?= url('analyse/customers/user/') ?>/' + taskdate;
            }
        });

    }
    submit_search = function () {
        $('#search_custom').mousedown(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            window.location.href = '<?= url('analyse/customers/') ?>/5?start=' + start_date + '&end=' + end_date;
        });
    }

    $(document).ready(check);
    $(document).ready(submit_search);
</script>
@endsection

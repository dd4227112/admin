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
$total_activity = \collect(DB::select('select count(*) from admin.tasks a where  a.user_id in (select id from admin.users where department=3) and ' . $where))->first()->count;
    $yes_activity = \collect(DB::select('select count(*) from admin.tasks a where  a.user_id in (select id from admin.users where department=3) and action=(\'Yes\') and ' . $where))->first()->count;
    $no_activity = \collect(DB::select('select count(*) from admin.tasks a where  a.user_id in (select id from admin.users where department=3) and action=(\'No\') and ' . $where))->first()->count;

?><div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Software Department </h4>
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
                    <li class="breadcrumb-item"><a href="#!">Software Department</a>
                    </li>
                </ul>

            </div>
        </div>
        <div class="page-body">
            <div class="row">
            <div class="col-lg-4 text-left">
                   <p class="btn btn-success"> Yes - <?= $no_activity ?> out of <?= $total_activity ?> <span style="padding-left: 40px;"> No - <?= $no_activity ?>  out of <?= $total_activity ?> </span></p>

                </div>
                <div class="col-lg-4"></div>
                <div class="col-lg-4 text-right">
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


            <?php
            $on = 'Today';
            
            ?>
            <div class="page-body">

                <!-- Open Project card end -->
                <div class="row">
                    <!-- counter-card-1 start-->
                    <div class="col-md-12 col-xl-4">
                        <div class="card counter-card-1">
                            <div class="card-block-big">
                                <div>
                                    <?php
                                    $total_reacherd = \collect(DB::select('select count(*) from admin.error_logs a  WHERE ' . $where))->first()->count;
                                    ?>
                                    <h3><?= $total_reacherd ?></h3>
                                    <p>Total Errors
    <!--                                    <span class="f-right text-primary">
                                            <i class="icofont icofont-arrow-up"></i>
                                            37.89%
                                        </span>-->
                                    </p>
                                    <div class="progress ">
                                        <!--<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>-->
                                    </div>
                                </div>
                                <i class="icofont icofont-comment"></i>
                            </div>
                        </div>
                    </div>
                    <!-- counter-card-1 end-->
                    <!-- counter-card-2 start -->
                    <div class="col-md-6 col-xl-4">
                        <div class="card counter-card-2">
                            <div class="card-block-big">
                                <div>
                                    <?php
                                    $total_schools = \collect(DB::select('select count(*) from admin.error_logs a WHERE deleted_at is not null and  ' . $where))->first()->count;
                                    ?>
                                    <h3><?= $total_schools ?></h3>
                                    <p>Error Resolved
    <!--                                    <span class="f-right text-success">
                                            <i class="icofont icofont-arrow-up"></i>
                                            34.52%
                                        </span>-->
                                    </p>
                                    <div class="progress ">
                                        <!--<div class="progress-bar progress-bar-striped progress-xs progress-bar-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>-->
                                    </div>
                                </div>
                                <i class="icofont icofont-coffee-mug"></i>
                            </div>
                        </div>
                    </div>
                    <!-- counter-card-2 end -->
                    <!-- counter-card-3 start -->
                    <div class="col-md-6 col-xl-4">
                        <div class="card counter-card-3">
                            <div class="card-block-big">
                                <div>
                                    <?php
                                    $total_activity = \collect(DB::select('select count(*) from admin.tasks a where   a.user_id in (select id from admin.users where department=3) and ' . $where))->first()->count;
                                    ?>
                                    <h3><?= $total_activity ?></h3>
                                    <p>New Tasks Recorded
    <!--                                    <span class="f-right text-default">
                                            <i class="icofont icofont-arrow-down"></i>
                                            22.34%
                                        </span>-->
                                    </p>
                                    <div class="progress ">
                                        <!--<div class="progress-bar progress-bar-striped progress-xs progress-bar-default" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>-->
                                    </div>
                                </div>
                                <i class="icofont icofont-upload"></i>
                            </div>
                        </div>
                    </div>
                    <!-- counter-card-3 end -->
                    <!-- Monthly Growth Chart start-->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Monthly Issues Recorded</h5>
                            </div>
                            <div class="card-block">
                                <?php
                                $new_schools = 'select count(*),extract(month from created_at) as month from admin.error_logs a
where extract(year from a.created_at)=' . $year . '  group by month order by month';
                                echo $insight->createChartBySql($new_schools, 'month', 'Software Issues Recorded', 'line', false);
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Monthly Growth Chart end-->
                    <!-- Google Chart start-->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Technical Activities</h5>
                            </div>
                            <div class="card-block">
                                <?php
                                $sales_group = "select count(*),b.name as task_name from admin.tasks a join admin.task_types b on b.id=a.task_type_id WHERE   a.user_id in (select id from admin.users where department=3) and " . $where . " group by task_name";
                                echo $insight->createChartBySql($sales_group, 'task_name', 'Technical Activity', 'bar', false);
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Google Chart end-->
                    <!-- Recent Order table start -->
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>TECHNICAL ACTIVITIES</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <div class="dt-responsive table-responsive">
                                        <table id="res-config" class="table table-bordered w-100 dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Task</th>
                                                    <th>Task Type</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $t = '-' . $days . ' days';
                                                $at = date('Y-m-d H:i:s', strtotime($t));
                                                $i = 1;
                                                $activities = $activities = DB::select("select a.id,d.username, a.activity,a.created_at,b.name as task_name, c.firstname||' '||c.lastname as user_name from admin.tasks a  join admin.task_types b on b.id=a.task_type_id join admin.users c on c.id=a.user_id join admin.tasks_clients e on a.id=e.task_id join admin.clients d on d.id=e.client_id WHERE   a.user_id in (select id from admin.users where department=3) and " . $where);

                                                foreach ($activities as $activity) {
                                                    ?>
                                                    
                                                    <tr>
                                                        <td class="pro-name"><?= $activity->task_name ?></td>
                                                        <td class="img-pro"><?= $activity->user_name ?></td>
                                                        <td><a href="<?= url('customer/activity/show/' . $activity->id) ?>"><?= $activity->username ?></a></td>
                                                        <td> <label class="text-danger"><?= $activity->created_at ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php
                                                //
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Recent Order table end -->
                    <div class="col-sm-12 col-xl-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Technical Team Activity Ratio</h5>
                                    </div>
                                    <div class="card-block">
                                        <?php
                                        $sales_distribution = "select count(*) as count, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.users c on c.id=a.user_id WHERE   a.user_id in (select id from admin.users where department=3) and " . $where . " group by user_name";
                                        echo $insight->createChartBySql($sales_distribution, 'user_name', 'Technical Team Activity', 'bar', false);
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                   
                        <div class="col-md-12 col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Daily Tasks</h5>
                                    <label class="label label-success"><?= $on ?></label>
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
                                                    $sqls = "select count(a.*),b.name from admin.tasks a join admin.task_types b on b.id=a.task_type_id join admin.task_types c on c.id=a.task_type_id where $where  and c.department=3  group by b.name";
                                                    $tasks = DB::select($sqls);
                                                    foreach ($tasks as $task) {
                                                        ?>
                                                        <tr>

                                                            <td><?= $task->name ?></td>
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

                        <!-- .events-content -->
                        <!-- Todo card start -->
                        <div class="col-md-12 col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5> Tasks count per School</h5>
                                    <label class="label label-success"><?= $on ?></label>
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
                                                    $sqls = "select count(a.*),d.username  from admin.tasks a  join admin.task_types b on b.id=a.task_type_id join admin.users c on c.id=a.user_id join admin.tasks_clients e on a.id=e.task_id join admin.clients d on d.id=e.client_id WHERE   a.user_id in (select id from admin.users where department=3)  and  $where group by d.username";
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
                        </div>
                        <!-- Horizontal Timeline end -->


                </div>
                    <div class="row">
                      <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Task Status</h5>
                                    </div>
                                    <div class="card-block">
                                        <?php
                                        $new_schools = 'select count(*), status from admin.tasks a
where   a.user_id in (select id from admin.users where department=3) and ' . $where . ' group by status';
                                       
                                        echo $insight->createChartBySql($new_schools, 'status', 'Technical Tasks Status', 'line', false);
                                        ?>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        check = function () {
            $('#check_custom_date').change(function () {
                var val = $(this).val();
                if (val == 'today') {
                    window.location.href = '<?= url('analyse/software/') ?>/1';
                } else {
                    $('#show_date').show();
                }
            });
        }
        submit_search = function () {
            $('#search_custom').mousedown(function () {
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                window.location.href = '<?= url('analyse/software/') ?>/5?start=' + start_date + '&end=' + end_date;
            });
        }
        $(document).ready(check);
        $(document).ready(submit_search);
    </script>

    <script type="text/javascript" src="<?= $root ?>bower_components/jquery/dist/jquery.min.js"></script>

    <script src="<?= url('/public') ?>/code/highcharts.js"></script>
    <script src="<?= url('/public') ?>/code/modules/exporting.js"></script>
    <script src="<?= url('/public') ?>/code/modules/export-data.js"></script>
    <script src="<?= url('/public') ?>/code/modules/series-label.js"></script>
    <script src="<?= url('/public') ?>/code/modules/data.js"></script>


    @endsection

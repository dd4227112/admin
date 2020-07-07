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
    $where = "  a.created_at::date >='" . $start_date . "' AND a.created_at::date <='" . $end_date."'";
}
?><div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Sales Dashboard</h4>
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
                    <li class="breadcrumb-item"><a href="#!">Sales Report</a>
                    </li>
                </ul>

            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-lg-8"></div>
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


            <div class="row">
                <!-- counter-card-1 start-->
                <div class="col-md-12 col-xl-4">
                    <div class="card counter-card-1">
                        <div class="card-block-big">
                            <div>
                                <?php
                                $total_reacherd = \collect(DB::select('select count(distinct school_id) from admin.tasks a  WHERE  a.task_type_id in (select id from admin.task_types where department=2) and ' . $where))->first()->count;
                                ?>
                                <h3><?= $total_reacherd ?></h3>
                                <p>Total School Reached
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
                                $total_schools = \collect(DB::select('select count(*) from admin.all_setting a WHERE  ' . $where))->first()->count;
                                ?>
                                <h3><?= $total_schools ?></h3>
                                <p>New Schools Onboarded
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
                                $total_activity = \collect(DB::select('select count(*) from admin.tasks a where  a.task_type_id in (select id from admin.task_types where department=2) and ' . $where))->first()->count;
                                ?>
                                <h3><?= $total_activity ?></h3>
                                <p>Total Sales Activities
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
                            <h5>Monthly Success</h5>
                        </div>
                        <div class="card-block">
                            <?php
                            $new_schools = 'select count(*),extract(month from created_at) as month from admin.all_setting a
where extract(year from a.created_at)=' .$year. '  group by month order by month';
                            echo $insight->createChartBySql($new_schools, 'month', 'Onboarded Schools', 'line', false);
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Monthly Growth Chart end-->
                <!-- Google Chart start-->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Sales Distribution Activities</h5>
                        </div>
                        <div class="card-block">
                            <?php
                            $sales_group = "select count(*),b.name as task_name from admin.tasks a join admin.task_types b on b.id=a.task_type_id WHERE  a.task_type_id in (select id from admin.task_types where department=2) and ".$where." group by task_name";
                            echo $insight->createChartBySql($sales_group, 'task_name', 'Sales Group Activity', 'bar', false);
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Google Chart end-->
                <!-- Recent Order table start -->
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>SALES ACTIVITIES</h5>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <div class="dt-responsive table-responsive">
                                    <table id="res-config" class="table table-bordered w-100">
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
                                            $activities = DB::select("select a.activity,a.created_at,b.name as task_name, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.task_types b on b.id=a.task_type_id join admin.users c on c.id=a.user_id WHERE  a.task_type_id in (select id from admin.task_types where department=2) and ".$where);
                                            foreach ($activities as $activity) {
                                                ?>                    
                                                <tr>
                                                    <td class="img-pro">
                                                        <?= $activity->user_name ?>
                                                    </td>
                                                    <td class="pro-name">

                                                        <span class="text-muted f-12"><?= $activity->activity ?></span>
                                                    </td>
                                                    <td>  <?= $activity->task_name ?></td>
                                                    <td>
                                                        <label class="text-danger">  <?= $activity->created_at ?></label>
                                                    </td>

                                                </tr>
                                            <?php } ?>


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
                                    <h5>Sales Person Activity Ratio</h5>
                                </div>
                                <div class="card-block">
                                    <?php
                                    $sales_distribution = "select count(*) as count, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.users c on c.id=a.user_id WHERE  a.task_type_id in (select id from admin.task_types where department=2) and ".$where." group by user_name";
                                    echo $insight->createChartBySql($sales_distribution, 'user_name', 'Sales Activity', 'bar', false);
                                    ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <!-- User activities chart start -->
                            <div class="card analytic-user">
                                <div class="card-block-big text-center">
                                    <i class="icofont icofont-wallet"></i>
                                    <?php
                                    $student_sum = \collect(DB::select('select sum(students) from admin.schools WHERE id in (select school_id from admin.tasks a where a.task_type_id in (select id from admin.task_types where department=2) and '.$where. ')'))->first()->sum;
                                    ?>
                                    <h3>Tsh <?= number_format($student_sum * 10000) ?> /=</h3>
                                    <h4>Projected Income</h4>
                                </div>
                                <div class="card-footer p-t-25 p-b-25">
                                    <p class="m-b-0"></p>
                                </div>
                            </div>
                            <!-- User activities chart end -->
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
                            window.location.href = '<?= url('analyse/sales/') ?>/1';
                        } else {
                            $('#show_date').show();
                        }
                    });
                }
                submit_search = function () {
                    $('#search_custom').mousedown(function () {
                        var start_date = $('#start_date').val();
                        var end_date = $('#end_date').val();
                        window.location.href = '<?= url('analyse/sales/') ?>/5?start=' + start_date + '&end=' + end_date;
                    });
                }
                $(document).ready(check);
                $(document).ready(submit_search);
            </script>
<?php
/*
$sql_ = 'select avg as count, periods from (select avg(a.mark),a."subjectID",a."classesID", b."teacherID", EXTRACT(YEAR FROM age(cast(c.dob as date))) as age, c.salary,c.sex, (select count(*) from routine where "subjectID"=a."subjectID") as periods  from mark_info a join section_subject_teacher b on b."subject_id"=a."subjectID" join teacher c on c."teacherID"=b."teacherID" ' . $and_class_id . ' GROUP BY a."classesID",a."subjectID", b."teacherID",c.dob,c.salary,c.sex ORDER BY a."subjectID") p';
echo $insight->createChartBySql($sql_, 'periods', 'Overall total_days', 'scatter', false);
$corr2 = \collect(DB::SELECT('select corr(count,periods) from (' . $sql_ . ' ) x '))->first();
echo '<p>Correlation Factor : ' . round($corr2->corr, 3) . '</p>';
*/ ?>

<?php $root = url('/') . '/public/' ?>
<div class="page-wrapper">
  <?php if (can_access('manage_users')) { ?>
    <?php
    if($days == '' || $days == 1){
        $days = 1;
        $on = 'Today';
    }if($days == 7){
        $on = 'This Week';
    }if($days == 30){
        $on = 'This Month';
    }if($days == 90){
        $on = 'Three Month';
    }   if($days == 181){
        $on = 'Six Month';
    }if($days == 365){
        $on = 'This Year';
      }
    ?>
    <div class="page-body">
      <div class="row">
        <!-- Documents card start -->
        <div class="col-md-6 col-xl-3">
          <div class="card client-blocks dark-primary-border">
            <div class="card-block">
              <h5> Schools in ShuleSoft</h5>
              <ul>
                <li>
                  <i class="icofont icofont-list"></i>
                </li>
                <li class="text-right">
                  <?php echo $shulesoft_schools; ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- Documents card end -->
        <!-- New clients card start -->
        <div class="col-md-6 col-xl-3">
          <div class="card client-blocks warning-border">
            <div class="card-block">
              <h5>NMB Schools</h5>
              <ul>
                <li>
                  <i class="ti-layout text-warning"></i>
                </li>
                <li class="text-right text-warning">
                  <?php echo $nmb_schools; ?>
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
              <h5>Our Clients</h5>
              <ul>
                <li>
                  <i class="icofont icofont-users text-success"></i>
                </li>
                <li class="text-right text-success">
                  <?php echo $clients; ?>

                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- New files card end -->
        <!-- Open Project card start -->
        <div class="col-md-6 col-xl-3">
          <div class="card client-blocks">
            <div class="card-block">
              <h5>All Schools</h5>
              <ul>
                <li>
                  <i class="icofont icofont-ui-folder text-primary"></i>
                </li>
                <li class="text-right text-primary">
                  <?php echo $schools; ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- Open Project card end -->
        <!-- Morris chart start -->
        <div class="col-md-12 col-xl-8">
          <div class="card">
            <div class="card-header">
              <a href="<?= url('Analyse/sales/1') ?>" class="btn btn-primary btn-sm">Day</a>
              <a href="<?= url('Analyse/sales/7') ?>" class="btn btn-primary btn-sm">Week</a>
              <a href="<?= url('Analyse/sales/30') ?>" class="btn btn-primary btn-sm">Month</a>
              <a href="<?= url('Analyse/sales/90') ?>" class="btn btn-primary btn-sm">Quater</a>
              <a href="<?= url('Analyse/sales/181') ?>" class="btn btn-primary btn-sm">Six Month</a>
              <a href="<?= url('Analyse/sales/365') ?>" class="btn btn-primary btn-sm">Year</a>
            </div>
            <div class="card-block">
              <div id="login_graph"></div>
              <?php
              $sql_ = "select count(distinct (user_id,\"table\")) as count, created_at::date as date from admin.all_login_locations where created_at >= current_date - interval '$days days'  group by created_at::date ";
              echo $insight->createChartBySql($sql_, 'date', 'User Login per Day', 'bar', false);
              ?>
            </div>
          </div>
        </div>
        <!-- Morris chart end -->
        <!-- Todo card start -->
        <div class="col-md-12 col-xl-4">
          <div class="card">
            <div class="card-header">
              <h5>Daily Tasks</h5>
              <label class="label label-success"><?=$on?></label>
            </div>
            <div class="card-block">
              <div class="new-task">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr class="text-capitalize">

                        <th>Activity</th>
                        <th>Count</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sqls = "select count(a.*),b.name from admin.tasks a join admin.task_types b on b.id=a.task_type_id where  a.created_at > current_date - interval '$days days'  group by b.name";
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

        <!-- Horizontal Timeline start -->
        <div class="col-md-12 col-xl-8">
          <div class="card">
            <div class="card-header">
              <h5>Average system usability</h5>
            </div>
                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                  <thead>
                    <tr>
                      <th>Task type</th>
                      <th>Added By</th>
                      <th>School</th>
                      <th>Deadline</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $t = '-'.$days.' days';
                    $at = date('Y-m-d H:i:s', strtotime($t));
                    $i = 1;
                    $activities = \App\Models\Task::where('created_at', '>=', $at)->orderBy('id', 'desc')->get();
                    foreach ($activities as $activity) {
                      ?>
                      <tr>
                        <td><?= $activity->taskType->name ?></td>
                        <td><?= $activity->user->firstname ?></td>
                        <td><a href="<?= url('customer/activity/show/' . $activity->id) ?>"><?= $activity->client->username  ?></a></td>
                        <td><?= $activity->date ?> <?= $activity->time ?></td>

                      </tr>
                    <?php } ?>
                  </tbody>
                  <tfooter>
                    <tr>
                      <th>Task type</th>
                      <th>Added By</th>
                      <th>School</th>
                      <th>Deadline</th>
                    </tr>
                  </tfooter>
                </table>

              </div>
            </div>
          </div>
          <!-- .events-content -->
        <!-- Todo card start -->
        <div class="col-md-12 col-xl-4">
          <div class="card">
            <div class="card-header">
              <h5> Tasks count per School</h5>
              <label class="label label-success"><?=$on?></label>
            </div>
            <div class="card-block">
              <div class="new-task">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr class="text-capitalize">

                        <th>Activity</th>
                        <th>Count</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sqls = "select count(a.*),b.username from admin.tasks a join admin.clients b on a.client_id=b.id where  a.created_at > current_date - interval '$days days'  group by b.username";
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
    </div>
  <?php } ?>
  <?php if (can_access('manage_users')) { ?>
    <script type="text/javascript" src="<?= $root ?>bower_components/jquery/dist/jquery.min.js"></script>

    <script src="<?= url('/public') ?>/code/highcharts.js"></script>
    <script src="<?= url('/public') ?>/code/modules/exporting.js"></script>
    <script src="<?= url('/public') ?>/code/modules/export-data.js"></script>
    <script src="<?= url('/public') ?>/code/modules/series-label.js"></script>
    <script src="<?= url('/public') ?>/code/modules/data.js"></script>
    <table id="users_table" style="display:none">
      <thead>
        <tr>
          <th></th>
          <th>User Feedback</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $logs = DB::select('select count(*),extract(month from created_at) as month from constant.feedback
        where extract(year from created_at)=' . date('Y') . ' group by month order by month');
        foreach ($logs as $log) {
          $monthNum = $log->month;
          $dateObj = DateTime::createFromFormat('!m', $monthNum);
          $monthName = $dateObj->format('F'); // March
          ?>
          <tr>
            <th><?= $monthName ?></th>
            <td><?= $log->count ?></td>
          </tr>
        <?php }
        ?>
      </tbody>
    </table>
    <script type="text/javascript">
    Highcharts.chart('container', {
      data: {
        table: 'users_table'
      },
      chart: {
        type: 'column'
      },
      title: {
        text: 'User Feedback Per Month'
      },
      yAxis: {
        allowDecimals: false,
        title: {
          text: 'User Feedback'
        }
      },
      tooltip: {
        formatter: function () {
          return '<b>' + this.series.name + '</b><br/>' +
          this.point.y + ' ' + this.point.name.toLowerCase();
        }
      }
    });

    Highcharts.chart('container2', {
      data: {
        table: 'users_sales'
      },
      chart: {
        type: 'column'
      },
      title: {
        text: 'No of Sales Per Month of <?= date('Y') ?>'
      },
      yAxis: {
        allowDecimals: false,
        title: {
          text: 'No of new onboarded school'
        }
      },
      tooltip: {
        formatter: function () {
          return '<b>' + this.series.name + '</b><br/>' +
          this.point.y + ' ' + this.point.name.toLowerCase();
        }
      }
    });
    dashboard_summary = function () {
      $.ajax({
        url: '<?= url('analyse/summary/null') ?>',
        data: {},
        dataType: 'JSONP',
        success: function (data) {
          //console.log(data);
          $('#all_users').html(data.users);
          $('#all_students').html(data.students);
          $('#all_parents').html(data.parents);
          $('#all_teachers').html(data.teachers);
          $('#schools_with_shulesoft').html(data.total_schools);
          $('#schools_with_students').html(data.total_schools - data.schools_with_students);
          //
          $('#active_users').html(data.active_users);
          $('#active_students').html(data.active_students);
          $('#active_parents').html(data.active_parents);
          $('#active_teachers').html(data.active_teachers);
        }
      });
    }
    $(document).ready(dashboard_summary);


    </script>
  <?php  } ?>
  @endsection

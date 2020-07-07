<?php
/*
$sql_ = 'select avg as count, periods from (select avg(a.mark),a."subjectID",a."classesID", b."teacherID", EXTRACT(YEAR FROM age(cast(c.dob as date))) as age, c.salary,c.sex, (select count(*) from routine where "subjectID"=a."subjectID") as periods  from mark_info a join section_subject_teacher b on b."subject_id"=a."subjectID" join teacher c on c."teacherID"=b."teacherID" ' . $and_class_id . ' GROUP BY a."classesID",a."subjectID", b."teacherID",c.dob,c.salary,c.sex ORDER BY a."subjectID") p';
echo $insight->createChartBySql($sql_, 'periods', 'Overall total_days', 'scatter', false);
$corr2 = \collect(DB::SELECT('select corr(count,periods) from (' . $sql_ . ' ) x '))->first();
echo '<p>Correlation Factor : ' . round($corr2->corr, 3) . '</p>';
*/ ?>
@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="page-wrapper">
  <div class="page-header">
    <div class="page-header-title">
      <h4>Dashboard</h4>
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

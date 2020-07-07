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
              <h5> Active Customers</h5>
              <ul>
                <li>
                  <i class="icofont icofont-document-folder"></i>
                </li>
                <li class="text-right">
                  133
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
              <h5>New Logins Today</h5>
              <ul>
                <li>
                  <i class="icofont icofont-ui-user-group text-warning"></i>
                </li>
                <li class="text-right text-warning">
                  23
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
              <h5>New Files</h5>
              <ul>
                <li>
                  <i class="icofont icofont-files text-success"></i>
                </li>
                <li class="text-right text-success">
                  240
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
              <h5>Open Projects</h5>
              <ul>
                <li>
                  <i class="icofont icofont-ui-folder text-primary"></i>
                </li>
                <li class="text-right text-primary">
                  169
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
              <a href="<?= url('Analyse/customers/1') ?>" class="btn btn-primary btn-sm">Day</a>
              <a href="<?= url('Analyse/customers/7') ?>" class="btn btn-primary btn-sm">Week</a>
              <a href="<?= url('Analyse/customers/30') ?>" class="btn btn-primary btn-sm">Month</a>
              <a href="<?= url('Analyse/customers/90') ?>" class="btn btn-primary btn-sm">Quater</a>
              <a href="<?= url('Analyse/customers/181') ?>" class="btn btn-primary btn-sm">Six Month</a>
              <a href="<?= url('Analyse/customers/365') ?>" class="btn btn-primary btn-sm">Year</a>
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
        <script>
        //                    $.ajax({
        //                        url:'<?= url('analyse/charts') ?>',
        //                        method:'GET',
        //                        data:{},
        //                        success:function(data){
        //                            $('#login_graph').html(data);
        //                        }
        //                    })
        </script>
        <!-- Morris chart end -->
        <!-- Todo card start -->
        <div class="col-md-12 col-xl-4">
          <div class="card">
            <div class="card-header">
              <h5>Daily Tasks</h5>
              <label class="label label-success"><?=$on?></label>
            </div>
            <div class="card-block">
              <!--                                <div class="input-group input-group-button">
              <input type="text" class="form-control add_task_todo" placeholder="Create your task list" name="task-insert">
              <span class="input-group-addon" id="basic-addon1">
              <button id="add-btn" class="btn btn-primary">Add Task</button>
            </span>
          </div>-->
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



            <!--                                    <div class="to-do-list">
            <div class="checkbox-fade fade-in-primary">
            <label class="check-task">
            <input type="checkbox" value="">
            <span class="cr">
            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
          </span>
          <span> </span>
        </label>
      </div>
      <div class="f-right">

      <a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
    </div>
  </div>-->

  <!--                                    <div class="to-do-list">
  <div class="checkbox-fade fade-in-primary">
  <label class="check-task">
  <input type="checkbox" value="">
  <span class="cr">
  <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
</span>
<span>New Attachment has error</span>
</label>
</div>
<div class="f-right">
<a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
</div>
</div>
<div class="to-do-list">
<div class="checkbox-fade fade-in-primary">
<label class="check-task">
<input type="checkbox" value="">
<span class="cr">
<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
</span>
<span>Have to submit early</span>
</label>
</div>
<div class="f-right">
<a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
</div>
</div>
<div class="to-do-list">
<div class="checkbox-fade fade-in-primary">
<label class="check-task">
<input type="checkbox" value="">
<span class="cr">
<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
</span>
<span>10 pages has to be completed</span>
</label>
</div>
<div class="f-right">
<a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
</div>
</div>
<div class="to-do-list">
<div class="checkbox-fade fade-in-primary">
<label class="check-task">
<input type="checkbox" value="">
<span class="cr">
<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
</span>
<span>Navigation working</span>
</label>
</div>
<div class="f-right">
<a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
</div>
</div>
<div class="to-do-list">
<div class="checkbox-fade fade-in-primary">
<label class="check-task">
<input type="checkbox" value="">
<span class="cr">
<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
</span>
<span>Files submited successfully</span>
</label>
</div>
<div class="f-right">
<a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
</div>
</div>
<div class="to-do-list">
<div class="checkbox-fade fade-in-primary">
<label class="check-task">
<input type="checkbox" value="">
<span class="cr">
<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
</span>
<span>Work Complete Before Time</span>
</label>
</div>
<div class="f-right">
<a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
</div>
</div>-->
</div>
</div>
</div>
</div>
<!-- Todo card end -->
<!-- User chat box start -->

<!-- User chat box end -->
<!-- Horizontal Timeline start -->
<div class="col-md-12 col-xl-8">
  <div class="card">
    <div class="card-header">
      <h5>Average system usability</h5>
    </div>
    <div class="card-block">

        <!-- .timeline -->
        <div class="events-content">

              <?php
              $sql_2 = "select count(*) as count, controller as module from admin.all_log   where controller not in ('background','SmsController') and created_at >= current_date - interval '$days days'  group by controller order by count desc limit 8 ";
              echo $insight->createChartBySql($sql_2, 'module', 'System Usability Per Modules', 'bar', false);
              ?>
            </div>
          </div>
        </div>
        <!-- .events-content -->
      </div>
<!-- Horizontal Timeline end -->

<!-- Todo card start -->
<div class="col-md-12 col-xl-4">
  <div class="card">
    <div class="card-header">
      <h5> Tasks count per School</h5>
      <label class="label label-success"><?=$on?></label>
    </div>
    <div class="card-block">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr class="text-capitalize">

                <th>School</th>
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
</div>
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
  <table id="users_sales" style="display:none">
    <thead>
      <tr>
        <th></th>
        <th>User Feedback</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $new_schools = DB::select('select count(*),extract(month from created_at) as month from admin.all_setting
      where extract(year from created_at)=' . date('Y') . ' group by month order by month');
      foreach ($new_schools as $new_school) {
        $monthNum = $new_school->month;
        $dateObj = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March
        ?>
        <tr>
          <th><?= $monthName ?></th>
          <td><?= $new_school->count ?></td>
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
<?php } ?>
@endsection

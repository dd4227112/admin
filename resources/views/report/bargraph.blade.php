@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Exam Marking</h4>
                <span>You can upload marks from excel sheet and system will generate reports for you automatically</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Exam</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Marking</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page header end -->
        <!-- Page body start -->
        <div class="page-body">
  <form style="" class="form-horizontal" role="form" method="post">
    <br>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Type</label>
      <div class="col-sm-6">
        <?php echo form_error($errors, 'class_level_id'); ?>
        <select class="select2 form-control" tabindex="-1" required="true"  name="request_type" id="request_type">
          <option value="0">Select Task Source Here...</option>
          <option value="4">Number of new Users (students, parents, teachers)</option>
          <option value="16">Sms sent and email sent</option>
          <option value="14">Number of Reply Sms</option>
          <option value="1">Number of Login failed attempts</option>
          <option value="2">Number of Log activities (students, parents, teachers)</option>
          <option value="3">Number of errors recorded</option>
          <option value="18">Website Demo Requests</option>
          <option value="17">Number of sales calls,New schools onboarded & Schools trained today</option>
          <option value="9">Number of Files uploaded</option>
          <option value="7">Number of Forum Questions Asked</option>
          <option value="8">Number of Forum Question Answered</option>
          <option value="20">Number of Forum Questions Viewers</option>
          <option value="13">Number of Videos Uploaded</option>
          <option value="12">Number of Total Viewers</option>
          <option value="11">Number of Total Likes</option>
          <option value="10">Number of Media Comments</option>
          <option value="15">Online exams Published</option>
          <option value="5">Assignment Published</option>
          <option value="6">Assignment Submits</option>
          <option value="19">Assignment Total Viewers</option>
        </select>
      </div>

      <?= csrf_field() ?>
    </form>

  </div>

  <div class="clearfix"></div>
  <div class="col-lg-12">
      <div class="card">
          <div class="card-block">
              <div id="chartdiv"></div>
          </div>
      </div>
  </div>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <div class="card">
      <div class="card-block">
  <script type="text/javascript">
  $(function () {

    $('#container').highcharts({
      chart: {
        type: 'column'
      },
      title: {
        text: "<?= ucfirst($title) ?> "
      },
      subtitle: {
        text: 'Daily Performance Evaluation of Two Week.'
      },
      xAxis: {
        type: 'category'
      },
      yAxis: {
        title: {
          text: 'Total Count'
        }

      },
      legend: {
        enabled: false
      },
      plotOptions: {
        series: {
          borderWidth: 0,
          dataLabels: {
            enabled: true,
            format: '{point.y:.1f}%'
          }
        }
      },

      tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
      },

      series: [{
        name: 'Avarage',
        colorByPoint: true,
        data: [
          <?php
          $i = 0;
          // foreach ($days as $key => $value) {
          foreach($datas as $data){
            //$dayz = date("l", strtotime($data->created_at));
            $y= $data->ynumber == NULL ? '0' : $data->ynumber;
            if($data->ynumber !=NULL && $data->created_at <> 'Sex' ){
              ?>
              {
                name: '<?php echo '<b>'.$data->created_at.'</b>'; ?>',
                y: <?= $data->ynumber == NULL ? '0' : $data->ynumber ?>,
                drilldown: '<?= $data->created_at ?>'
              },
              <?php
              $i++;
            }
          }
          //  }
          ?>
        ]
      }]
    });
  });

  </script>
  <script src="http://localhost/shulesoft/public/assets/js/highchart.js"></script>
  <script src="http://localhost/shulesoft/public/assets/js/exporting.js"></script>
  <div id="container" style="min-width: 700px; max-width: 900px; height: 500px; margin: 0 auto"></div>
  <div class="clearfix"></div>
  <hr>
</div>
</div>
<?php if(isset($schools) && sizeof($schools) > 0){ ?>
<script type="text/javascript">
  $(function () {

    $('#container2').highcharts({
      chart: {
        type: 'column'
      },
      title: {
        text: "Schools Performance Daily Evaluations. "
      },
      subtitle: {
        text: '<?=ucfirst($title)?> Analysis.'
      },
      xAxis: {
        type: 'category'
      },
      yAxis: {
        title: {
          text: 'Total Count'
        }

      },
      legend: {
        enabled: false
      },
      plotOptions: {
        series: {
          borderWidth: 0,
          dataLabels: {
            enabled: true,
            format: '{point.y:.1f}%'
          }
        }
      },

      tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
      },

      series: [{
        name: 'Avarage',
        colorByPoint: true,
        data: [
          <?php
          $i = 0;
          // foreach ($days as $key => $value) {
          foreach($schools as $school){

            $y= $school->ynumber == NULL ? '0' : $school->ynumber;
            if($school->ynumber !=NULL && $school->schema_name <> '' ){
              ?>
              {
                name: '<?php echo '<b>'.ucfirst($school->schema_name).'</b>'; ?>',
                y: <?= $school->ynumber == NULL ? '0' : $school->ynumber ?>,
                drilldown: '<?= $school->schema_name ?>'
              },
              <?php
              $i++;
            }
          }
          //  }
          ?>
        ]
      }]
    });
  });

  </script>

  <div id="container2" style="min-width: 500px; max-width: 900px; height: 500px; margin: 0 auto"></div>
  <div class="clearfix"></div>
<?php } ?>
<hr>
<?php if(isset($weeks) && $type != 'week'){ ?>
<script type="text/javascript">
  $(function () {

    $('#container1').highcharts({
      chart: {
        type: 'column'
      },
      title: {
        text: "Weekly Performance Evaluation of Seven Weeks. "
      },
      subtitle: {
        text: '<?=ucfirst($title)?> Analysis.'
      },
      xAxis: {
        type: 'category'
      },
      yAxis: {
        title: {
          text: 'Total Count'
        }

      },
      legend: {
        enabled: false
      },
      plotOptions: {
        series: {
          borderWidth: 0,
          dataLabels: {
            enabled: true,
            format: '{point.y:.1f}%'
          }
        }
      },

      tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
      },

      series: [{
        name: 'Avarage',
        colorByPoint: true,
        data: [
          <?php
          $i = 0;
          // foreach ($days as $key => $value) {
          foreach($weeks as $week){

            $dayz = date("l", strtotime($week->week));
            $tarehe = date('Y-m-d', strtotime($week->week));
            $y= $week->ycounts == NULL ? '0' : $week->ycounts;
            if($week->ycounts !=NULL && $tarehe <> '' ){
              ?>
              {
                name: '<?php echo '<b>'.$tarehe.'<br>'.$dayz.'</b>'; ?>',
                y: <?= $week->ycounts == NULL ? '0' : $week->ycounts ?>,
                drilldown: '<?= $tarehe ?>'
              },
              <?php
              $i++;
            }
          }
          //  }
          ?>
        ]
      }]
    });
  });

  </script>

  <div id="container1" style="min-width: 500px; max-width: 900px; height: 500px; margin: 0 auto"></div>
  <div class="clearfix"></div>
<?php } ?>
</div>
  <?php

if(isset($users)){
    if(sizeof($users) > 0){
      foreach($users as $user){
        ?>

          <div class="animated  col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
              <div class="icon" style="top:45px"><i class="fa fa-users"></i>
              </div>
              <div class="count"><?php echo $user->ynumber; ?></div>

              <h3><?=ucfirst($user->table)?>s</h3>
            </div>
          </div>


  <?php } } } ?>
<br>
<hr>
  <?php
if(isset($activities)){
    if(sizeof($activities) > 0){
      foreach($activities as $activity){
        ?>

          <div class="animated  col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
              <div class="icon" style="top:45px"><i class="fa fa-tags"></i>
              </div>
              <div class="count"><?php echo $activity->ynumber; ?></div>

              <h3><?=ucfirst($activity->controller)?></h3>
            </div>
          </div>


  <?php } } } ?>
  </div>
    </div>

  <script type="text/javascript">
  $('#request_type').change(function () {
    var request_type =  $('#request_type').val();
    var date_criteria = '<?=$type?>';
    if (request_type == '' && date_criteria == '') {
      return false;
    } else {
      window.location.href = "<?= url('report/index/') ?>/" + request_type + "/" + date_criteria;
    }
  });
  </script>
</div>
@endsection

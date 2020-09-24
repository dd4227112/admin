@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>

<style>
      #blinkingg {
        animation:blinkingText 1.7s infinite;
      }
      @keyframes blinkingText {
        0%{     color: #ff0000;  padding: 0.5px; font-size: 2.5em; font-weight: bold;  }
        49%{    color: #cccc; }
        60%{    color: #ff0000; }
        49%{    color: #cccc;}
        100%{   color: transparent;    }
      }

</style>
<?php
$root = url('/') . '/public/';
$page = request()->segment(3);
$today = 0;
?>
<div class="page-wrapper">
  <div class="page-header">
    <div class="page-header-title">
      <h4>Task Reports </h4>
    </div>
    <div class="page-header-breadcrumb">
       
  </div>
</div>
<div class="page-body">
<div class="row">
<div class="col-lg-4">
          <select class="form-control" id="check_custom_date">
            <option value="" selected >Select Options Here</option>
            <option value="today">Today</option>
            <option value="custom">Custom</option>
          </select>
        </div>
        <div class="col-lg-8 text-right">
          <div  style="display: none" id="show_date">
          <form action="#" method="post" onsubmit="this.submit(); this.reset(); return false;">
            <div class="input-daterange input-group" id="datepicker">
              <input type="date" class="input-sm form-control" name="start" id="start_date">
              <span class="input-group-addon">to</span>
              <input type="date" class="input-sm form-control" name="end" id="end_date">
              <br>
              </div>
              <?php
              if (in_array(Auth::user()->role_id,  [1,8])) {
              $users = \App\Models\User::where('status', 1)->where('role_id', '<>', 7)->get();
              foreach ($users as $user) { ?>
                <input type="checkbox" class="user_ids" value="<?= $user->id ?>" name="user_ids[]" ><?= $user->firstname?> &nbsp; &nbsp;
              <?php } }?>
              <input type="submit" Value="Submit" class="input-sm btn btn-sm btn-success" id="search_custom"/>
          </div>
          <?= csrf_field() ?>
            </form>
        
          <div  style="display: none" id="today_list">
          <form action="#" method="post" onsubmit="this.submit(); this.reset(); return false;">
              <?php
              if (in_array(Auth::user()->role_id,  [1,8])) {
              $users1 = \App\Models\User::where('status', 1)->whereIn('role_id', [8,14])->get();
              foreach ($users1 as $user) { ?>
                <input type="checkbox" id="user<?= $user->id ?>" value="<?= $user->id ?>" name="user_ids[]" ><?= $user->firstname?> &nbsp; &nbsp;
              <?php } }?>
              <input type="submit" Value=" Submit " class="input-sm btn btn-sm btn-success" id="search_user"/>
              <?= csrf_field() ?>
            </form>
          </div>
        </div>
  </div>
  <div class="row">
      <div class="col-lg-12">
        <div class="card">
        <div class="card-header">
        <h5> 
        TASK SUMMARY BY 
         <?php
          if(count($task_users)>0){
            foreach($task_users as $us){
              echo '<u>'.$us->firstname . ' '. $us->lastname .' </u> &nbsp; &nbsp;';
            }
          }else{
            echo '<u>'.Auth::user()->name .'</u>';
          }
         ?>
         
         </h5> 
        </div>
          <div class="card-block">

            <div class="row">
              <?php
              $i = 1;
              $total = 0;
                foreach($tasks as $task){
              ?>
              <div class="col-sm-6 col-xl-3">
                <div class="card counter-card-<?= $i ?>">
                  <div class="card-block-big">
                    <div>
                      <h3><?= $task->count ?></h3>
                      <p><?= ucfirst($task->status)?> Task</p>
                      <div class="progress ">
                        <div class="progress-bar progress-bar-striped progress-xs progress-bar-<?= $i == 1 ? 'pink' : 'success' ?>" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <i class="icofont icofont-trophy-alt" id="blinkingg"></i>
                  </div>
                </div>
              </div>
                  <?php } ?>
              <div class="col-sm-6 col-xl-3">
                <div class="card counter-card-<?= $i ?>">
                  <div class="card-block-big">
                    <div>
                      <h3><?= count($activities) ?></h3>
                      <p> Support Activities</p>
                      <div class="progress ">
                        <div class="progress-bar progress-bar-striped progress-xs progress-bar-info" role="progressbar" style="width: 70%" aria-valuenow="<?=count($tasks)?>" aria-valuemin="0" aria-valuemax="<?=count($tasks)?>"></div>
                      </div>
                    </div>
                    <i class="icofont icofont-list" id="blinkingg"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>


<div class="row" id="schools">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5>List of Tasks & Activities Under <u><?=$staff->name?></u></h5>
       
      </div>
      <div class="card-block">
        <div class="table-responsive">
          <table class="table dataTable responsive">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th width="10%">School Name</th>
                <th width="70%">Task</th>
                <th width="10%">Status</th>
                <th width="5%">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach($all_tasks as $task){
                echo '<tr>';
                echo '<td>'.$i++.'</td>';
                echo '<td>'.$task->client->name.'</td>';
                echo '<td>'.$task->task->activity.'</td>';
                echo '<td>'.$task->task->status.'</td>';
                echo '<td>';
                if($task->client->username != ''){
                  echo '<a href="'. url('customer/profile/'.$task->client->username) .'" class="btn btn-success btn-sm"> View </a>';
                }else{
                  echo '<a href="'. url('sales/profile/'.$task->task_id) .'" class="btn btn-success btn-sm"> View</a>';

                }
                echo '</td>';
                echo '</tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>



  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5>Seven Day Perfomance Trend</h5>
      </div>
      <div class="card-block">
        <?php
        //echo $insight->createChartBySql($logs, 'schema_name', ' Schools Activities ', 'bar', false);
        ?>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5>Task Modules Statistics</h5>
      </div>
      <div class="card-block">
        <?php
       // echo $insight->createChartBySql($logs, 'schema_name', ' Schools Activities ', 'line', false);
        ?>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>


<script type="text/javascript">

check = function () {

    $('#check_custom_date').change(function () {
        var val = $(this).val();
        if (val == 'today') {
          $('#show_date').hide();
          $('#today_list').show();
        }
        if(val == 'custom') {
          $('#today_list').hide();
            $('#show_date').show();
        }
    });
}

$(document).ready(check);

</script>
@endsection

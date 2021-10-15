@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
{{-- <style>
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

</style> --}}
<?php
$page = request()->segment(3);
$today = 0;
?>
<div class="main-body">
 <div class="page-wrapper">
  <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

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
              <input type="date" class="input-sm form-control" name="start" id="start_date" style="width: 40px;">
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

          <div class="card-block">
            <div class="row">
              <div class="col-sm-6 col-xl-6">
            <?php
              if(count($task_users)>0){
                foreach($task_users as $us){
                  $name = 'TASK SUMMARY BY '.$us->firstname . ' '. $us->lastname;
                }
              }else{
                  $name =  'TASK SUMMARY BY '.\Auth::user()->name;
              }
            ?>
           <x-analyticCard :value="count($tasks)" :name="$name" icon="feather icon-trending-up text-white f-16"  color="bg-c-blue"  topicon="feather icon-activity f-50" subtitle="Activities"></x-analyticCard>
            </div>
           </div>
          </div>

          <div class="card-block">
            <div class="row">
              <?php
              $i = 1;
              $total = 0;
                foreach($tasks as $task){
              ?>
              <div class="col-sm-6 col-xl-6">
                 <x-analyticCard :value="$task->count" :name="ucfirst($task->status)" icon="feather icon-trending-up text-white f-16"  color="bg-c-pink"  topicon="feather icon-activity f-50" subtitle="No students schools"></x-analyticCard>
              </div>
              <?php } ?>
              <div class="col-sm-6 col-xl-6">
                 <x-analyticCard :value="count($activities)" name="Support Activities" icon="feather icon-trending-up text-white f-16"  color="bg-c-green"  topicon="feather icon-activity f-50" subtitle="No students schools"></x-analyticCard>
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
        <h5>  List of Tasks & Activities By 
        <?php
          if(sizeof($task_users)>0){
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
         <div class="table-responsive dt-responsive">
            <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
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

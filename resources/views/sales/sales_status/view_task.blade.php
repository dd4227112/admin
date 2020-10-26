@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>

<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/style.css">

<link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2.css">

<link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2-bootstrap.css">
<link rel="stylesheet" href="<?= $root ?>assets/select2/css/gh-pages.css">
<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4> SCHOOL TASK PERFORMED</h4>
        <!-- <span>This Part Show Task performed on a school</span> -->
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item"><a class="btn btn-info"  data-toggle="modal" data-target="#edit_task_model"> <i class="icofont icofont-edit"></i> Edit Here</a></li>
            <li class="breadcrumb-item"><a  onclick="javascript:printDiv('print_all')" class="btn btn-primary"> <i class="icofont icofont-print"></i> Print Here</a></li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->

    <!-- Page-body start -->
    <div class="page-body" id="print_all">
      <div class="row">
        <div class="col-lg-12">
          <!-- tab panel personal start -->
          <!-- personal card start -->
          <div class="card">
            <div class="card-block">
              <div class="row">
                <div class="col-lg-12 col-sm-12">
                <table class="table m-0">
                <thead style="text-align: center !important;">
                <tr>
                <th>School Profile</th>
                <th>Task Information</th>
                </tr>
                </thead>
                    <tbody>
                    <tr>
                    <td>
                  <table class="table">
                    <tbody>
                      <tr>
                        <th scope="row">Client Name</th>
                        <th>{{ $activity->client->name }}</th>
                      </tr>
                      <tr>
                        <th scope="row">Location</th>
                        <th>
                          <?php
                          if(!empty($school)){
                          echo $school->district . ' - ' .  $school->region ;
                          }else{
                              echo $activity->client->address;
                          }
                          ?>
                        </tr>
                        <tr>
                          <th> <?php echo 'Phone: '. $activity->client->phone; ?></th>
                          <th><?php
                          echo 'Email: '.$activity->client->email .'</a>';
                          ?></th>
                        </tr>
                        
                        <tr>
                          <th>Registered Users</th>
                          <th>
                            <?php
                            if (!empty($users)) {
                              $loop = 1;
                              foreach ($users as $user) {

                                echo $loop. '. '. ucfirst($user->table).'s - ' . $user->count;
                                ?>  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
                                <?php
                                if($loop == 2){
                                  echo '<br>';
                                }
                                $loop++;
                              }
                            } else {
                              echo "No Registered User";
                            }
                            ?>
                          </th>
                        </tr>
                      </tbody>
                    </table>
                    </td>
                  <td>
                    <table class="table">
                      <tbody>
                        <tr>
                          <th scope="row">Task Start</th>
                          <th> {{ $activity->task->start_date }}</th>
                        </tr>
                        <tr>
                          <th scope="row">Task End</th>
                          <th><?= $activity->task->end_date ?></th>
                        </tr>
                        <tr>
                          <th scope="row">Assigned To</th>
                          <th>
                            <?php
                            if ($activity->task->user_id != '') {
                              echo $activity->task->user->firstname . ' ' . $activity->task->user->lastname;
                            } else {
                              echo 'Not Defined ';
                            }
                            ?>
                          </tr>

                          <tr>
                            <th scope="row">Task Type</th>
                            <th> <?= $activity->task->taskType->name ?></th>
                          </tr>
                          <tr>
                            <th>Task Status</th>
                            <th><u> <?= ucfirst($activity->status) ?></u></th>

                            <td>
                            
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      </td>
                      </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-header">
                          <h5>List of Staffs Trained</h5>
                          <span class="form-datas" style="float: right">
                            <a class="btn btn-success btn-sm" href="#"  data-toggle="modal" data-target="#customer_contracts_model">  <i class="ti-plus"> </i> Add Staff</a>
                          </span>
                        </div>
                        <div class="card-body">
                          <table class="table m-0">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Staff Name</th>
                                <th>Phone</th>
                                <th>Position</th>
                                <th>Module</th>
                                <th>Start</th>
                                <th>End</th>
                              </tr>

                            </thead>
                            <tbody>
                              <?php
                              $staffs = $activity->task->taskStaff()->get();
                              if (!empty($staffs)) {
                                $i = 1;
                                foreach ($staffs as $staff) {
                                  $user = DB::table($activity->client->username. '.users')->where('id', $staff->user_id)->where('table', $staff->user_table)->first();
                                  if(!empty($user)){
                                    ?>
                                    <tr>
                                      <th>{{ $i++ }}</th>
                                      <th>{{ $user->name }}</th>
                                      <th>{{ $user->phone }}</th>
                                      <th>{{ $user->usertype }}</th>
                                      <th>{{ $staff->module }}</th>
                                      <th>{{ $staff->start_time }}</th>
                                      <th>{{ $staff->end_time }}</th>
                                    </tr>
                                  <?php } } } ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- end of row -->
                    </div>
                    <!-- end of general info -->
                  </div>
                  <!-- end of col-lg-12 -->
                </div>
                <!-- end of row -->
              </div>

              <!-- end of card-block -->
            <div class="row">
              <div class="col-lg-12">
                <div class="card">

                  <div class="card-block user-desc">
                    <div class="view-desc">
                      <h4>About This Activity </h4>
                      <p id="taskstatus" style="float: right;"> <span style="float: right;" id="added_"> </span>
                        <b>Task Excuted:</b>
                        <select id="action" class="form-control">
                          <option value='{{ $activity->task->status }}'>{{ $activity->task->status }}</option>
                          <option value='complete'>Complete</option>
                          <option value='Pending'>Pending</option>
                          <option value='on progress'>Progress</option>
                          <option value='Resolved'>Resolved</option>
                        </select>
                      </p>
                      <p> <?= $activity->task->activity ?></p>
                      <p><b>Training Modules</b> <br>
                      <?php
                              $modules = $activity->task->modules()->get();
                              if (!empty($modules)) {
                                $i =1;
                                foreach ($modules as $module) {
                                  echo $i++.'. '. $module->module->name;
                                  ?>  &nbsp;|
                                  <?php
                                }
                              } else {
                                echo "No Mudule Specified";
                              }
                              ?>
                              </p>

                    </div>

                    <div class="card-block user-desc">
                      <div class="view-desc">
                        <b>Task Comments</b>
                        <div class="user-box">
                          <?php
                          $comments = $activity->task->taskComments()->get();
                          if (!empty($comments)) {
                            foreach ($comments as $comment) {
                              ?>
                              <div class="media m-b-1" style="margin: 0px; padding: 0px">
                                <a class="media-left" href="#">
                                  <img class="media-object img-circle m-r-2" src="<?= $root ?>assets/images/avatar-1.png" alt="Image">
                                </a>
                                <div class="media-body b-b-muted social-client-description">
                                  <div class="chat-header"><?= $comment->user->firstname ?> - <span class="text-muted"><?= date('d M Y', strtotime($comment->created_at)) ?></span></div>
                                  <p class="text-muted"><?= $comment->content ?></p>
                                </div>
                              </div>

                              <?php
                            }
                          }else{
                            echo 'No Comment..';
                          }
                          ?>
                          <div class="new_comment<?= $activity->task->id ?>"></div>
                          <div class="media form-datas">
                            <a class="media-left" href="#">
                              <img class="media-object img-circle m-r-20" src="<?= $root ?>assets/images/avatar-blank.jpg" alt="Image">
                            </a>
                            <div class="media-body">
                              <form class="">
                                <div class="">
                                  <textarea rows="5" cols="5" id="task_comment<?= $activity->task->id ?>" class="form-control" placeholder="Write Something here..."></textarea>
                                  <div class="text-right m-t-20"><a href="#" class="btn btn-primary waves-effect waves-light" onclick="return false" onmousedown="$.get('<?= url('customer/taskComment/null') ?>', {content: $('#task_comment<?= $activity->task->id ?>').val(), task_id:<?= $activity->task->id ?>}, function (data) {
                                    $('.new_comment<?= $activity->task->id ?>').after(data);
                                    $('#task_comment<?= $activity->task->id ?>').val('')
                                  })">Post</a></div>
                                </div>
                              </form>
                            </div>
                          </div>
                          <!-- <table class="table">
                          <tr>
                            <td style="width: 60% !important;">
                              <img src="<?= url('public/images/ShuleSoft-TM.png') ?>" width="350" height="" style=""/>
                            </td>
                            <td style="width: 60% !important;">
                              <span>
                                INETS is a Private Company Limited by shares and registered <br/>under the Company Act 2012 with registration number 9216.<br/> INETS deals solely with Software Development. <br/>Currently focused on a School Management System ShuleSoft </span></td>
                              </tr>
                            </table> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<!-- personal card end-->

<div class="modal fade" id="customer_contracts_model" role="dialog" style="z-index: 99999;" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add School Staffs Trained</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="#" method="post">
        <div class="modal-body">
          <div class="form-group">
            <?php
            $school_staffs = DB::table($activity->client->username. '.users')->where('status', 1)->whereIn('table', ['teacher', 'user'])->get();

            if(sizeof($school_staffs)){
              ?>
              <div class="row">

                <div class="col-md-12">
                <strong> Select Staff Here(multiple).</strong>
                  <select id="action" name="staff_id[]" class="form-control" multiple required>
                    <?php
                    foreach ($school_staffs as $school_staff) {
                      ?>
                      <option value="{{$school_staff->id}},{{$school_staff->table}}"><?php echo $school_staff->name; ?> - <?php echo $school_staff->usertype; ?> </option>

                      <!-- <input type="checkbox" id="feature<?= $school_staff->id ?>" >   &nbsp; &nbsp; -->
                    <?php } ?>
                  </select>

                </div>
              </div>

            <?php   }   ?>
          </div>
          <div class="form-group">
            <div class="row">

              <div class="col-md-6">
                <strong> Start Time</strong>
                <input type="datetime-local" class="form-control" required name="start_time">
              </div>

              <div class="col-md-6">
                <strong> End Time</strong>
                <input type="datetime-local" class="form-control" required name="end_time">
              </div>

            </div>
          </div>
          <div class="form-group">
            <textarea class="form-control" rows="4" name="module" placeholder="Type Short Details Here..." required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info waves-effect waves-light ">Submit Here</button>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>

<!-- Update School Visitation Details -->


<div class="modal fade" id="edit_task_model" role="dialog" style="z-index: 99999;" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Task Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="<?=url('Sales/updateVisit')?>" method="post">
        <div class="modal-body">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
            <div class="row">

              <div class="col-md-6">
                <strong> Start Time</strong>
                <input type="datetime-local" class="form-control" required name="start_time">
              </div>

              <div class="col-md-6">
                <strong> End Time</strong>
                <input type="datetime-local" class="form-control" required name="end_time">
              </div>
            </div>
          </div>
        </div>
          
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
  <div class="row">
  <div class="col-md-12">
      <strong> Select Task Status</strong>
      <input type="hidden" name="task_id" value="<?=$activity->task_id?>"  class="form-control">

      <select type="text" name="status"  required class="form-control select2">
          <option value='{{ $activity->task->status }}'>{{ $activity->task->status }}</option>
          <option value='complete'>Complete</option>
          <option value='Pending'>Pending</option>
          <option value='on progress'>Progress</option>
          <option value='Resolved'>Resolved</option>
      </select>
    </div>
  
    </div>
    </div>
<div class="form-group">
  <div class="row">

    <div class="col-md-12">
      <strong> Task Type</strong>
      <input type="hidden" name="task_id" value="<?=$activity->task_id?>"  class="form-control">

      <select type="text" name="task_type_id"  required class="form-control select2">
        <option value="1">Select Here...</option>
        <?php
        $users = DB::table('task_types')->where('department', 1)->orderBy('id', 'DESC')->get();
        foreach ($users as $school) { ?>
          <option value="<?= $school->id ?>"><?= $school->name ?></option>
        <?php } ?>
      </select>
    </div>
  
    </div>
    </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info waves-effect waves-light ">Submit Here</button>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>


<script>
function printDiv(divID) {

  //Get the HTML of div
  var divElements = document.getElementById(divID).innerHTML;
  //Get the HTML of whole page
  var oldPage = document.body.innerHTML;

  //Reset the page's HTML with div's HTML only
  document.body.innerHTML =
  '<html><head><title></title></head><body>' +
  divElements + '</body>';
  //Print Page
  $('.form-datas').hide();
  $('#taskstatus').hide();
  $('.form-message').hide();
  window.print();
  //Restore orignal HTML
  document.body.innerHTML = oldPage;
}

$('#action').change(function () {
  var val = $(this).val();
  $.ajax({
    type: 'POST',
    url: "<?= url('Sales/updateTask') ?>",
    data: "id=" + <?= $activity->id ?> + "&action=" + val,
    dataType: "html",
    success: function (data) {
      $('#added_').html(data);
    }
  });
});
</script>
@endsection

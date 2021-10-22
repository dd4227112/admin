@extends('layouts.app')
@section('content')
<div class="main-body">
  <div class="page-wrapper">
  
         <div class="page-header">
            <div class="page-header-title">
                <h4>Create attendance</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">attendance</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Operations</a>
                    </li>
                </ul>
            </div>
        </div> 

    <div class="page-body">
      <div class="row">

        <div class="col-sm-12">
          <div class="card tab-card">
            <div class="card-block">
             

                  <div class="col-md-12 col-xl-12">
                    <div class="row">
                        <form class="col-sm-6 form-horizontal" role="form" method="post">
                            <?php
                            $date_ = date("m/d/Y", strtotime($date));
                            if (form_error($errors, 'date'))
                                echo "<div class='form-group has-error' >";
                            else
                                echo "<div class='form-group' >";
                            ?>
                            <label for="date" class="col-sm-6 col-sm-offset-2 control-label">
                                <?= ('Attendance date') ?>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control calendar" name="date" id="calender" value="<?= isset($date_) ? $date_ : '' ?>" required="">
                             </div>
                        </div>

                        <div class="form-group">
                         <div class="col-sm-offset-4 col-sm-8">
                            <input type="submit" class="btn btn-success" style="margin-bottom:0px" value="<?= ("attendance") ?>" >
                          </div>
                       </div>
                         <?= csrf_field() ?>
                       </form>
                     </div>
                    </div> 


                 
 
                    <?php if (!empty($users)) { ?>
                     <div class="card-block">
                      <div class="dt-responsive table-responsive">
                       <table id="simpletable" class="table dataTable table-striped table-bordered nowrap">
                      <thead>
                        <tr>
                          <th># </th>
                          <th>Name</th>
                          <th>Type</th>
                          <th>Phone</th>
                          <th>Email </th>
                          <th>Action </th>
                          <th class="text-center">Absent reason</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(!empty($users)){
                        $i = 1;
                        foreach($users as $user){
                          ?>
                      <tr>
                          <td><?=$i++?> </td>
                          <td><?=$user->firstname. ' '.$user->lastname ?></td>
                          <td><?=$user->role->display_name ?></td>
                          <td><?=$user->phone ?></td>
                          <td><?=$user->email ?></td>
                          <td class="text-center">
                            <?php
                            $method = '';
                            $att = $user->uattendance()->where('date', date("Y-m-d", strtotime($date)))->first();
                            if (!empty($att)  && $att->present == 1) {
                                $method = "checked";
                            }
                            $absent_id = !empty($att) == True ? $att->absent_reason_id : null;
                            echo btn_attendance($user->id, $method, 'attendance btn btn-warning',('add_title'));
                            if ((int) $absent_id > 0) {
                                echo '<script type="text/javascript">$("#"+'.$user->id.').hide()</script>';
                            }
                            ?>
                          </td>
                        
                          <td data-title="<?= ('Absent reason') ?>" class="text-center">
                            <?php
                            $array_ = array("0" => ("select reason"));
                            $absents = \DB::table('constant.absent_reasons')->get();
                            if (isset($absents) && !empty($absents)) {
                                foreach ($absents as $absent) {
                                    $array_[$absent->id] = $absent->reason;
                                }
                            }
                            echo form_dropdown("absent_id", $array_, old("absent_id", $absent_id), "id='absent_id' user_id='" . $user->id . "' class='form-control absent'");
                            ?>
                          </td>

                        </tr>
                        <?php } } ?>
                      </tbody>
                    </table>
                      </div>
                  <?php } ?>
                  </div>
              
          
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('.attendance').click(function () {
      var id = $(this).attr("id");
      var day = "<?= $date ?>";
      var status = $(this).is(':checked');
      $.ajax({
          type: 'POST',
          url: "<?= url('attendance/singl_add') ?>",
          data: {"id": id, "day": day, status: status},
          dataType: "html",
          success: function (data) {
              toast(data);
              window.location.reload();
          }
      });
  });

  $('.all_attendance').click(function () {
      var day = "<?= $date ?>";
      var status = "";

      if ($(".all_attendance").prop('checked')) {
          status = "checked";
          $('.attendance').prop("checked", true);
      } else {
          status = "unchecked";
          $('.attendance').prop("checked", false);
      }
      $.ajax({
          type: 'POST',
          url: "<?= url('attendance/all_add') ?>",
          data: {"day": day, "status": status},
          dataType: "html",
          success: function (data) {
              toast(data);
          }
      });

  });
  
function addAttendance(id, day, status, absent_id = 0) {
$.ajax({
  type: 'POST',
  url: "<?= url('attendance/singl_add') ?>",
  data: {"id": id, "day": day, status: status, absent_id: absent_id},
  dataType: "html",
  success: function (data) {
      toast(data);
      window.location.reload();
   }
  });
}

$('.absent').change(function () {
var absent_id = $(this).val();
var user_id = $(this).attr("user_id");
 console.log(absent_id)
var user_ids =   user_id;
var date = "<?= $date ?>";
if (absent_id === '0') {
  document.getElementById(user_id).checked = false;
  $('#' + user_id).show();
  addAttendance(user_ids, date, 'false');
}else {
  $('#' + user_id).hide();
  document.getElementById( user_id).checked = false;
  addAttendance(user_ids, date, 'false', absent_id);
}
});
</script>
@endsection

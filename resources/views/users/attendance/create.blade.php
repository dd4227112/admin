@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/';
function tagEdit($column, $value) {
    //  $type = null ? $type = '"text"' : $type = $type;
    if ((int) request('skip') == 1) {
        $return = $value;
    } else {
        $return = '<input required  class="form-control" type="datetime"  id="' . $column . '" value="' . $value . '" onblur="edit_records(\'' . $column . '\', this.value)"  disabled="disabled"/>';
    }
    return $return;
  }
 ?>
  
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
             
{{-- 
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
                    </div>  --}}


                 
 
                    <?php if (!empty($users)) { ?>
                     <div class="card-block">
                      <div class="table-responsive">
                       <table id="simpletable" class="table dataTable table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Choose </th>
                          <th>Name</th>
                          <th>TimeIn </th>
                          <th>TimeOut </th>
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
                          <td> 
                            <input class="form-control" type="checkbox" id="user<?= $user->id ?>"  value="<?= $user->id ?>"  onclick="pickuser('<?= $user->id ?>')" />
                          </td>
                          
                          <td><?= $user->firstname. ' '.$user->lastname ?></td>
                          <td class="text-center">
                          
                            <input type="datetime" class="form-control timein" name="timein" id="timein<?= $user->id ?>" style="width: 135px;" value="<?= empty($user->uattendance->where('date',$date)->first()) ? date('Y-m-d 07:47:00') : $user->uattendance->where('date',$date)->first()->timein ?>" disabled="disabled"/>
                          </td>
                           
                           <td class="text-center">
                             <input type="datetime" class="form-control timeout" name="timeout"  id="timeout<?= $user->id ?>" style="width: 135px;" value="<?= empty($user->uattendance->where('date',$date)->first()) ? date('Y-m-d 17:15:00') : $user->uattendance->where('date',$date)->first()->timeout ?>" disabled="disabled"/>
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
                            echo form_dropdown("absent_id", $array_, old("absent_id", $absent->id), "id='absent_id' user_id='" . $user->id . "' class='form-control absent' style='width:120px;height:18px;'");
                            ?>
                          </td>

                        </tr>
                        <?php } }  ?>
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
    pickuser = function (id) {
         var user_id = id;
         if ( $("#user" + user_id).is(":checked")) {
                $("#timein" + user_id).removeAttr("disabled");
                $("#timeout" + user_id).removeAttr("disabled");
                $("#timein"+user_id).focus();
                $("#timeout"+user_id).focus();
            }else {
                $("#timein" + user_id).attr("disabled", "disabled");
                $("#timeout" + user_id).attr("disabled", "disabled");
            }
        };



     edit_records = function (tag, val) {
        $.get('<?= url('users/updateAttendances/null') ?>', {schema: 'admin', table: 'uattendances', val: val, tag: tag, user_id: '1'}, function (data) {
            $('#status_' + tag + schema).html('<label class="badge badge-success">'+data+'</label>');
            toastr.success(data);
        });
    };


  $('.attendance').click(function () {
      var id = $(this).attr("id");
      var day = "<?= $date ?>";
      var status = $(this).is(':checked');
      $.ajax({
          type: 'POST',
           headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "<?= url('attendance/singl_add') ?>",
          data: {"id": id, "day": day, status: status},
          dataType: "html",
          success: function (data) {
             toastr.success(data);
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
           headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "<?= url('attendance/all_add') ?>",
          data: {"day": day, "status": status},
          dataType: "html",
          success: function (data) {
              toastr.success(data);

          }
      });

  });
  
function addAttendance(id, day, status, absent_id = 0) {
$.ajax({
  type: 'POST',
   url: "<?= url('attendance/singl_add') ?>",
   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  data: {"id": id, "day": day, status: status, absent_id: absent_id},
  dataType: "html",
  success: function (data) {
    if (data =='Invalid date format!') {
      toastr.error(data);
    }else{
      toastr.success(data);
      //window.location.reload();
    }
   }
  });
}

$('.absent').change(function () {
var absent_id = $(this).val();
var user_id = $(this).attr("user_id");
var user_ids = user_id;
var date =  $('#timein' + user_id).val();
if (absent_id === '0') {
  document.getElementById(user_id).checked = false;
  $('#' + user_id).show();
  addAttendance(user_ids, date, 'false');
}else {
  $('#' + user_id).hide();
 // document.getElementById(user_id).checked = false;
  addAttendance(user_ids, date, 'false', absent_id);
  }
});


$('.timein').click(function () {
var timein = $(this).val();
var user_id = $(this).attr("id");
  addAttendance(user_id, timein, 'true');
});

$('.timeout').click(function () {
var timeout = $(this).val();
var user_id = $(this).attr("id");
  addAttendance(user_id, timeout, 'true');
});

</script>
@endsection

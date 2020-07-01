@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4><?= $school->sname ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!"><?= $school->sname ?> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!"><?=$schema?></a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                  <div class="row">
  <div class="card-block">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Create Task/Activity</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form action="#" method="post">
            <div class="modal-body">
              <span>
                Create a task for this school with implementation deadline</span>

                <div class="form-group">
                  <textarea class="form-control" placeholder="Create Task" rows="5" name="activity"></textarea>
                </div>
                <div class="form-group">
                  <div class="row">

                    <div class="col-md-6">
                      Task Type
                      <select name="task_type_id"  class="form-control">
                        <?php
                        $types = DB::table('task_types')->whereNull('department')->get();
                        foreach ($types as $type) {
                          ?>
                          <option value="<?= $type->id ?>"><?= $type->name ?></option>
                        <?php } ?>

                      </select>
                    </div>
                    <div class="col-md-6">
                      Person Allocated to do
                      <select name="to_user_id" class="form-control">
                        <?php
                        $staffs = DB::table('users')->where('status', 1)->get();
                        foreach ($staffs as $staff) {
                          ?>
                          <option value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                        <?php } ?>

                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">

                    <div class="col-md-6">
                      Deadline Date
                      <input type="date" class="form-control" placeholder="Deadline" name="date">
                    </div>
                    <div class="col-md-6">
                      Deadline Time
                      <input type="time" class="form-control" placeholder="Time" name="time">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <?php
                    $modules = DB::table('modules')->get();
                    foreach ($modules as $module) {
                      ?>
                      <div class="col-md-3">
                        Task on <?=$module->name?>
                        <br>
                        <?php
                        $subs = DB::table('sub_modules')->where('module_id', $module->id)->orderBy('id', 'ASC')->get();
                        foreach ($subs as $sub) { ?>
                          <input type="checkbox" id="feature<?= $sub->id ?>" value="{{$sub->id}}" name="taskmodule[]" >  <?php echo $sub->name; ?>
                          <br>
                        <?php } ?>

                      </div>
                    <?php } ?>

                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
              </div>
              <input type="hidden" value="<?= $client_id ?>" name="client_id"/>
              <?= csrf_field() ?>
            </form>
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
<script type="text/javascript">

<script>
send_comment = function (id) {
  var featur_id = $('#feature' + id).val();
  var module_id = $('#module' + id).val();
  $.ajax({
    type: 'POST',
    url: '<?=url('Customer/addTask')?>',
    data: {module_id: module_id,module_id: module_id, _token: '{{ csrf_token() }}'},
    dataType: "html",
    success: function (data) {
      
      //   window.location.href = '';
    }
  });
}
</script>
@endsection
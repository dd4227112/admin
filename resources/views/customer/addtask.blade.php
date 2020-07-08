@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.9/select2-bootstrap.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>

<div class="main-body">
    <div class="page-wrapper">
       
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
                  <textarea class="form-control" placeholder="Create Task" rows="4" name="activity"></textarea>
                </div>
                <div class="form-group">
                <strong>  Select School or Client</strong> 

                <select name="client_id"  class="form-control select2" required>
                <option value=''> Select Client Here...</option>
                        <?php
                        foreach ($clients as $client) {
                          ?>
                          <option value='<?php echo $client->id; ?>'><?= $client->name ?>  (<?= $client->username ?>)</option>
                        <?php } ?>
                        </select>
                </div>
                <div class="form-group">

                    <strong> Task Type</strong> 
                      <select name="task_type_id" required class="form-control select2">
                      <option value=''> Select Here...</option>
                        <?php
                        $types = DB::table('task_types')->get();
                        foreach ($types as $type) {
                          ?>
                          <option value="<?= $type->id ?>"> <?= $type->name ?></option>
                        <?php } ?>

                      </select>
                    </div>
                    
                <div class="form-group">
                  <div class="row">

                    <div class="col-md-6">
                    <strong> Person Allocated to do</strong> 
                      <select name="to_user_id" class="form-control select2" required>
                        <?php
                        $staffs = DB::table('users')->where('status', 1)->get();
                        foreach ($staffs as $staff) {
                          ?>
                          <option value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                        <?php } ?>

                      </select>
                    </div>
                    
                    <div class="col-md-6">
                    <strong> Task Executed Successfully</strong> 
                    <select name="action" class="form-control" required>
                    <option value=''> Select Task Status Here...</option>
                    <option value='Yes'> Yes </option>
                    <option value='No'> No </option>
                    </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">

                    <div class="col-md-6">
                    <strong> Deadline Date</strong> 
                      <input type="date" class="form-control" placeholder="Deadline" name="date">
                    </div>
                    <div class="col-md-6">
                    <strong> Deadline Time</strong> 
                      <input type="time" class="form-control" placeholder="Time" name="time">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                        <strong>  Pick Modules where task will be Performed</strong> 
                          <hr>
                    <?php
                    $modules = DB::table('modules')->get();
                    foreach ($modules as $module) {
                      ?>
                      <input type="checkbox" id="feature<?= $module->id ?>" value="{{$module->id}}" name="module_id[]" >  <?php echo $module->name; ?>  &nbsp; &nbsp;

                    <?php } ?>
                      <?php
                      /*
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
                  </div>
                  */ ?>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
              </div>
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

$(".select2").select2({
		theme: "bootstrap",
		dropdownAutoWidth: false,
		allowClear: false,
        debug: true
	});
</script>
@endsection

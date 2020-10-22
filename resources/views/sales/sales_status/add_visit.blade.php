@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>

<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4 class="box-title">Sales Leads Definition </h4>
        <span> This Part helps you keep track of your deal progress</span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="<?= url('/') ?>/Sales/salesStatus/1">Sales Leads</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Create</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div id="outer" class="container">
          <div id="wrapper" class="layout" style="background-color: #fff; margin-bottom: 40px;">
            <div id="editorForm">

              <form method="post" action="#" enctype='multipart/form-data'>
                {{ csrf_field() }}
                <div class="card-block">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                    <hr>
                      <strong>Select  School:</strong>
                      <select name="school_id[]" multiple class="form-control select2">
                      <?php 
                          foreach($schools as $school){
                       ?>
                            <option value="<?= $school->id ?>"> <?= substr($school->name, 0, 20) ?> (<u><?= $school->username ?></u>)</option>
                        <?php
                            }
                           ?>
                      </select>
                    </div>
                  </div>


                  <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">
                      <div class="row">

                        <div class="col-md-6">
                          <strong> Start Date</strong>
                          <input type="datetime-local" class="form-control" placeholder="Deadline" name="start_date">
                        </div>
                        <div class="col-md-6">
                          <strong> End Date </strong>
                          <input type="datetime-local" class="form-control" placeholder="Time" name="end_date">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <div class="row">

                        <div class="col-md-6">
                          <strong> Task Type</strong>

                          <select type="text" name="task_type_id"  style="text-transform:uppercase" required class="form-control select2">
                            <option value="1">Select Here...</option>
                            <?php
                            $users = DB::table('task_types')->where('department', 1)->get();
                            foreach ($users as $school) { ?>
                              <option value="<?= $school->id ?>"><?= $school->name ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <strong> Select Pipeline stage</strong>
                          <select name="next_action" class="form-control">
                            <option value="new">New</option>
                            <option value="pipeline">Pipeline</option>
                            <option value="closed">Closed</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <strong> Add More Details Here...</strong>

                      <textarea name="activity" rows="5" id="content_part" placeholder="Write More details Here .." class="form-control"> </textarea>
                    </div>
                  </div>
                  <div class="form-group" id="modules">
                    <strong>  Pick Modules where task will be Performed</strong> 
                    <hr>
                    <?php
                    $modules = DB::table('modules')->get();
                    foreach ($modules as $module) {
                        ?>
                        <input type="checkbox" id="feature<?= $module->id ?>" value="{{$module->id}}" name="module_id[]" >  <?php echo $module->name; ?>  &nbsp; &nbsp;

                    <?php } ?>

                    </div>

              <hr>
              <div id="savebtnWrapper" class="form-group">
                <button type="submit" class="btn btn-primary">
                  &emsp;Submit&emsp;
                </button>
              </div>
            </div>

          </form>

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

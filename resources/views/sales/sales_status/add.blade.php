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

              @if (count($errors) > 0)
              <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              <form method="post" action="#" enctype='multipart/form-data'>
                {{ csrf_field() }}
                <div class="card-block">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                    <hr>
                      <strong>Select Multiple Schools:</strong>
                      <select type="text" multiple="" name="school_id[]"  style="text-transform:uppercase" required class="form-control select2">
                      <option value="1">Select Here...</option>
                        <?php
                        foreach ($schools as $school) { 
                          if($school->schema_name !=''){ ?>
                            <option value="<?= $school->id ?>"><?= $school->name . ' (Client) - '. substr($school->region, 0, 3)  ?></option>
                        <?php  }else{ ?>
                            <option value="<?= $school->id ?>"><?= $school->name . ' (' . substr($school->type, 0,3) .') - '. substr($school->region, 0, 3)  ?></option>
                        <?php
                          }
                          ?>

                        <?php } ?>
                      </select>

                    </div>
                  </div>

                 <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <strong>Key Person Name:</strong>
                          <input type="text" class="form-control" placeholder="Enter Person name here..." autofocus="1" name="school_name" required>
                        </div>

                        <div class="col-md-3">
                          <strong>Contact Details:</strong>
                          <input type="text" class="form-control" placeholder="Type Phone Number or Emails..." name="school_phone" required>
                        </div>
                        
                        <div class="col-md-3">
                          Title
                          <select name="school_title" class="form-control">

                            <option value="director">Director/Owner</option>
                            <option value="manager">School Manager</option>
                            <option value="head teacher">Head Teacher</option>
                            <option value="Second Master/Mistress">Second Master/Mistress</option>
                            <option value="academic master">Academic Master</option>
                            <option value="teacher">Normal Teacher</option>
                            <option value="Accountant">Accountant</option>
                            <option value="Other Staff">Other Non Teaching Staff</option>


                          </select>
                        </div>
                        <div class="col-md-3">
                          <strong>Number of Students:</strong>
                          <input type="number" class="form-control" placeholder="Enter number of students..." name="students" required>
                        </div>
                      </div>
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
                            $users = DB::table('task_types')->where('department', 2)->get();
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
$('#region').change(function () {
  var val = $(this).val();
  $.ajax({
    method: 'get',
    url: '<?= url('Users/getBranch/null') ?>',
    data: {region: val},
    dataType: 'html',
    success: function (data) {
      $('#branch_id').html(data);
    }
  });
});

</script>
@endsection

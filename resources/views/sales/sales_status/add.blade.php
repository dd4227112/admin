@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<div class="main-body">
  <div class="page-wrapper">

   <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
     
     <div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
              <form method="post" action="#" enctype='multipart/form-data'>
                {{ csrf_field() }}
                <div class="card-block">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                    <hr>
                      <strong>Select  School:</strong>
                      <input type="text" class="form-control" id="get_schools" name="school_id" value="<?= old('school_id') ?>" >
                    </div>
                  </div>

                 <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <strong>Key Person Name:</strong>
                          <input type="text" class="form-control" placeholder="Enter Person name here..." autofocus="1" name="school_name">
                        </div>

                        <div class="col-md-3">
                          <strong>Contact Details:</strong>
                          <input type="text" class="form-control" placeholder="Type Phone Number or Emails..." name="school_phone">
                        </div>
                        
                        <div class="col-md-3">
                          <strong> Title:</strong>
                          <select name="school_title" class="form-control select2">
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
                          <input type="number" class="form-control" placeholder="Enter number of students..." name="students" >
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

                        <div class="col-md-4">
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
                        <div class="col-md-4">
                          <strong> Select Pipeline stage</strong>
                          <select name="next_action" class="form-control">
                            <option value="new">New</option>
                            <option value="pipeline">Pipeline</option>
                            <option value="closed">Closed</option>
                          </select>
                        </div>
                           <div class="col-md-4">
                          <strong> Budget(any) -Tsh</strong>
                          <input type="number" name="budget" class="form-control" />
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
 
get_schools = function () {
    $("#get_schools").select2({
        minimumInputLength: 2,
       // tags: [],
        ajax: {
           headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
            url: '<?= url('customer/getschools/null') ?>',
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term,
                    token: $('meta[name="csrf-token"]').attr('content')
                };
            },
            results: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        };
                    })
                };
            }
        }
    });
}

$(document).ready(get_schools);
</script>
@endsection

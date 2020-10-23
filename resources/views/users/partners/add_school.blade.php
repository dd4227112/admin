@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>
  
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4 class="box-title">Add Partner School </h4>
        <span>Register school Information here</span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="<?= url('/') ?>/Users/minutes">Company Minute</a>
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

              @if (sizeof($errors) > 0)
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
                    <strong>Select School:</strong>
                    <input type="text" class="form-control" id="get_schools" name="school_id" value="<?= old('school_id') ?>" >

                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">
                  <div class="row">
                  <div class="col-md-6">
                  <strong>Account Name:</strong>
                    <input type="text" class="form-control" placeholder="Enter Partner name here..." autofocus="1" name="account_name" required>
                    </div>
                      <div class="col-md-6">
                    <strong>Account Number:</strong>
                    <input type="email" class="form-control" placeholder="Type Account Number Here..." name="account_number" required>
                  </div>
                  </div>
                  </div>
                  </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                  <div class="row">
                  <div class="col-md-6">
                    <strong>Select Region Branch:</strong>
                    <select name=''  id="region" class="form-control select2" required>
                     
                     <option value="">Select Region Here... </option>
                     @foreach($regions as $value)

                     <option value="{{$value->id}}">{{ucfirst($value->name)}} </option>

                     @endforeach
                   </select>
                    </div>
                      <div class="col-md-6">
                    <strong>Select Branches:</strong>
                    <select name='branch_id'  id="branch_id" class="form-control select2" required>
                     <option value="">Select Branch Here... </option>
                    
                   </select>
                  </div>
                    </div>
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

<script>

$(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
});
</script>
   <script type="text/javascript">   
   
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
            url: '<?= url('student/getschools/null') ?>',
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

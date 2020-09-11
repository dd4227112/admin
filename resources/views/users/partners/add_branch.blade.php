@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>
  
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/style.css">

        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2.css">

        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2-bootstrap.css">
        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/gh-pages.css">    
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4 class="box-title">Add Partner Branch </h4>
        <span>Register all users who are supposed to be in the system</span>
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
                    <strong>Branch Name:</strong>
                    <input type="text" class="form-control" placeholder="Enter Partner name here..." autofocus="1" name="name" required>

                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <div class="row">

                      <div class="col-md-6">
                    <strong>Branch Email:</strong>
                    <input type="email" class="form-control" placeholder="Type Email Here..." name="email" required>
                  </div>
                <div class="col-md-6">
                <strong>Phone Number:</strong>
                <input type="text" class="form-control" placeholder="Enter Phone number..." name="phone_number" required>
                    </div>
                    </div>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <div class="row">
                    
                      <div class="col-md-6">
                        <strong>Select Region</strong>
                        <select name='country_id'  id="region" class="form-control select2" required>
                     
                     <option value="">Select Country </option>
                     @foreach($regions as $value)

                     <option value="{{$value->id}}">{{ucfirst($value->name)}} </option>

                     @endforeach
                   </select>                      </div>
                      <div class="col-md-6">
                        <strong>Select District</strong>
                        <select type="text" name="district" id="district" style="text-transform:uppercase" required class="form-control select2">
                          <option value="">Select Here...</option>

                          </select>
                        </div>
                    </div>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <textarea name="note" rows="4" id="content_part" placeholder="Write More details Here .." class="form-control"> </textarea>
                  </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <strong>About Company Partnership:</strong>
                          <hr>
                </div>
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
<script src="<?= url('public/assets/tinymce/tinymce.min.js') ?>"></script>
   <script type="text/javascript">   
   
$('#region').change(function () {
            var val = $(this).val();
            $.ajax({
                method: 'get',
                url: '<?= url('Marketing/getDistrict/null') ?>',
                data: {region: val},
                dataType: 'html',
                success: function (data) {
                    $('#district').html(data);
                }
            });
        });
                wywig = function () {
                    tinymce.init({
                        selector: 'textarea#content_part',
                        height: 200,
                        plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table contextmenu paste code'
                        ],
                        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                        content_css: [
                            '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                            '//localhost/shule/public/assets/tinymce/codepan.css' 
                        ]
                    });
                }
                wywig();
</script>
@endsection

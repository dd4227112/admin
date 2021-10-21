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
           
              {{-- @if (sizeof($errors) > 0)
              <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif --}}
                
           
            <div class="card-block">
             <form method="post" action="#" enctype='multipart/form-data'>
              {{ csrf_field() }}
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <strong>Company Name:</strong>
                    <input type="text" class="form-control" placeholder="Enter Partner name here..." autofocus="1" name="name" required>

                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <div class="row">

                      <div class="col-md-6">
                    <strong>Company Email:</strong>
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
                        <strong>Select Country</strong>
                        <select name='country_id' class="form-control select2" required>
                     
                     <option value="">Select Country </option>
                     @foreach($countries as $value)

                     <option value="{{$value->id}}">{{$value->country}} </option>

                     @endforeach
                   </select>                      </div>
                      <div class="col-md-6">
                        <strong>Website or Link</strong>
                        <input type="text" class="form-control" placeholder=" Paste Here..." name="webstite">
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

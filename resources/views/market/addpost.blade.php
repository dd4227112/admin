@extends('layouts.app')

@section('content')

  

   <div class="page-header">
      <div class="page-header-title">
          <h4> <?= 'Social Media Posts' ?></h4>
      </div>
      <div class="page-header-breadcrumb">
          <ul class="breadcrumb-title">
              <li class="breadcrumb-item">
              <a href="<?= url('/') ?>">
                  <i class="feather icon-home"></i>
              </a>
              </li>
              <li class="breadcrumb-item"><a href="#!">social media</a>
              </li>
              <li class="breadcrumb-item"><a href="#!">marketing</a>
              </li>
          </ul>
      </div>
  </div> 

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
                    <strong>Post Title:</strong>
                    <input type="text" class="form-control"  name="title" required>

                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <div class="row">

                      <div class="col-md-6">
                    <strong>Posted Type:</strong>
                    <select name='type' class="form-control" required>
                    <option value="">Select Posted Type</option>
                    <option>image</option>
                    <option>text</option>
                    <option>video</option>
                    <option>sms & emails</option>
                    </select>                   
                  </div>
                <div class="col-md-6">

                    <strong>Post Category:</strong>
                    <select name='category' class="form-control" required>
                      <option value="">Select Post Category... </option>
                      <option>Convice</option>
                      <option>Entertainment</option>
                      <option>Education</option>
                      <option>Insipiration</option>
                      <option>Social activities</option>
                      <option>Social events</option>
                      
                    </select>
                    </div>
                    </div>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                  <strong>  Select Socialmedia Account for this Post </strong> 
                          <hr>
                    <?php
                    foreach ($socialmedia as $media) {
                      ?>
                      <input type="checkbox" id="feature<?= $media->id ?>" value="{{$media->id}}" name="socialmedia_id[]" >  <?php echo $media->name; ?>  &nbsp; &nbsp;

                    <?php } ?>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                  <strong>Posted Date:</strong>
                    <input type="date" class="form-control" placeholder="Date" name="date" required>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <strong>Meeting Description:</strong>
                    <textarea name="note" rows="4" id="content_part" placeholder="Write More details Here .." class="form-control"> </textarea>
                  </div>
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

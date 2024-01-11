@extends('layouts.app')

@section('content')

    
      
        <div class="page-header">
            <div class="page-header-title">
                <h4><?=' Add event' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">events</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 

        <div class="page-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-block">
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
                            <form method="post" action="" enctype='multipart/form-data'>
                                {{ csrf_field() }}
                                <div class="card-block">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Workshop Title:</strong>
                                            <input type="text" class="form-control"  name="title" required>

                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <strong>Workshop Date:</strong>
                                                    <input type="date" class="form-control" placeholder="Date" name="event_date" required>
                                                </div>
                                                <div class="col-md-6">

                                                    <strong>Department:</strong>
                                                    <select name='department_id' class="form-control select2" required>
                                                        <?php
                                                        $roles = DB::table('departments')->get();
                                                        ?>
                                                        <option value="">Select Minute Department </option>
                                                        @foreach($roles as $value)

                                                        <option value="{{$value->id}}">{{$value->name}} </option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <strong>Start Time</strong>
                                                    <input type="time" class="form-control" placeholder="Deadline" name="start_time" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>End Time</strong>
                                                    <input type="time" class="form-control" placeholder="Time" name="end_time" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <strong>Attach Workshop Poster/Image:</strong>
                                                    <input type="file"   accept=".png,.jpeg,.jpg"  class="form-control"  name="image" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Attach Event/Press Document:</strong>
                                                    <input type="file"   accept=".pdf"  class="form-control"  name="attached">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Workshop Meeting Link:</strong>
                                            <input type="text" class="form-control"  name="meeting_link" required>

                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>More Details About this Workshop:</strong>
                                            <textarea name="note" required rows="4" id="content_part" placeholder="Write More details Here .." class="form-control"> </textarea>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <select class="form-control" name="category" required>
                                                        <option value="">Select Category</option>
                                                        <option value="event">Event</option>
                                                        <option value="press">Press</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-primary">
                                                        &emsp;Submit&emsp;
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
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

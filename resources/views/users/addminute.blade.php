@extends('layouts.app')

@section('content')
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4 class="box-title">Company Minute </h4>
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
                    <strong>Meeting Title:</strong>
                    <input type="text" class="form-control"  name="title" required>

                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <div class="row">

                      <div class="col-md-6">
                    <strong>Meeting Date:</strong>
                    <input type="date" class="form-control" placeholder="Date" name="date" required>
                  </div>
                <div class="col-md-6">

                    <strong>Department:</strong>
                    <select name='department_id' class="form-control" required>
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
                    <strong>Attach Document:</strong>
                    <input type="file" class="form-control"  name="attached">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <strong>Meeting Description:</strong>
                    <textarea name="note" rows="4" placeholder="Write More details Here .." class="form-control"> </textarea>
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
@endsection

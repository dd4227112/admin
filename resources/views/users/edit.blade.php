@extends('layouts.app')
@section('content')

    <?php $root =url('/').'/public/' ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Users </h4>
                <span>Exams are defined only once for quick reference</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Exams</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Listing</a>
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
                <div id="dpEditor" class="flex">

                    <form id="dpForm" enctype="multipart/form-data" role="form" method="POST"
                          action="{{ url('save-dp') }}" class="layout vertical center">
                        {{ csrf_field() }}

                        <div id="dp">
                            <?php
                            $dp = "images/uploads/user_dps/";
                            $dp = isset($user->dp) ? $user->dp : 'default.png';

                            ?>

                            <div id="loadingDp" class="layout center-center">
                                <img src="{{$root.'images/loading.gif'}}" alt="">
                            </div>

                            <img src='{{$root."images/$user->dp"}}' width="140" height="140" id="curDp" alt="">
                        </div>
                    </form>

                    <br>
                    <div id="dpSavedAlert" class="alert alert-success alert-dismissible collapse" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        Picture saved.
                    </div>

                </div>
                <div id="editorForm">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <h2>Edit User</h2>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ url('users.index') }}"> Back</a>
                            </div>
                        </div>
                    </div>
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
                    {!! Form::model($user, ['method' => 'PATCH','url' => ['users.update', $user->id]]) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>First Name:</strong>
                                {!! Form::text('firstname', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Last Name:</strong>
                                {!! Form::text('lastname', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Phone:</strong>
                                {!! Form::text('phone', null, array('placeholder' => 'Phone Number','class' => 'form-control phoneNumber','type'=>'tel','id'=>'phone')) !!}
                                <span id="valid-msg" class="hide">✓ Valid</span>
                                <span id="error-msg" class="hide">Invalid</span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Email:</strong>
                                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group{{ $errors->has('town') ? ' has-error' : '' }}">
                                <strong>Town:</strong>
                                <input id="town" placeholder="Town" type="text" class="form-control" name="town"
                                       value="{{$user->town}}" required>

                                @if ($errors->has('town'))
                                    <span class="help-block">
		                                <strong>{{ $errors->first('town') }}</strong>
		                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Map Location:</strong>
                                <input id="location" readonly placeholder="location" type="text" class="form-control" name="location" value="" required>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Role:</strong>
                                <br/>
                                @foreach($role as $value)
                                    <label>{{ Form::checkbox('role[]', $value->id, in_array($value->id, $userRoles) ? true : false, array('class' => 'name')) }}
                                        {{ $value->display_name }}</label>
                                    <br/>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>
    <script src="http://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyBgc2zYiUzXGjZ277annFVhIXkrpXdOoXw"></script>
    <script src="{{$root.'/js/jquery.geocomplete.min.js'}}"></script>
    <script>

        $("#town").geocomplete()
                .bind("geocode:result", function(event, result){
                    var loc = result.geometry.location;
                    $("#location").val(loc.lng() + ", " + loc.lat());
                })
                .bind("geocode:error", function(event, status){
                    console.log("ERROR: " + status);
                })
                .bind("geocode:multiple", function(event, results){
                    console.log("Multiple: " + results.length + " results found");
                });
    </script>
<script  src="<?= url('public') ?>/intlTelInput/js/intlTelInput.js"></script>
<script  src="<?= url('public') ?>/js/customTelInput.js"></script>
  <script>
            $(document).ready(function () {
                $(".phoneNumber").intlTelInput();
            });
            $('.phoneNumber').blur(function () {
                if ($('.phoneNumber').intlTelInput('isValidNumber')) {
                    $("#phone").val($(".phoneNumber").intlTelInput("getNumber"));

                } else {
                    $("#phone").val('');


                }
            });
        </script>
@endsection
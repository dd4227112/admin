@extends('layouts.app')
@section('content')

<?php $root = url('/') . '/public/' ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Users </h4>
                <span></span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Users</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Edit</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-header">
                            <!--<h5>Basic Form Inputs</h5>-->
                            <span>Specify information correctly as specified. Area marked with * are mandatory</span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                        </div>
                        <div id="wrapper" class="layout row card-block" style="background-color: #fff; padding: 40px;">

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
                                {!! Form::model($user, ['method' => 'PATCH','class'=>'form-horizontal','url' => ['users/edit', $user->id]]) !!}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row ">
                                            <strong>First Name:</strong>
                                            {!! Form::text('firstname', null, array('placeholder' => 'Name','class' => 'form-control ')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <strong>Last Name:</strong>
                                            {!! Form::text('lastname', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <strong>Phone:</strong>
                                            {!! Form::text('phone', null, array('placeholder' => 'Phone Number','class' => 'form-control phoneNumber','type'=>'tel','id'=>'phone')) !!}
                                            <span id="valid-msg" class="hide">✓ Valid</span>
                                            <span id="error-msg" class="hide">Invalid</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <strong>Email:</strong>
                                            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row{{ $errors->has('town') ? ' has-error' : '' }}">
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
                                        <div class="form-group row">
                                            <strong>Map Location:</strong>
                                            <input id="location" readonly placeholder="location" type="text" class="form-control" name="location" value="" required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <strong>Role:</strong>
                                            <br/>
                                            <select name='role_id' class="form-control row">
                                                <?php
                                                $roles = DB::table('roles')->get();
                                                ?>
                                                @foreach($roles as $value)

                                                <option value="{{$value->id}}">{{$value->display_name}} </option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <strong>Gender:</strong>
                                            <br/>
                                            <select name='sex' class="form-control row">
                                                <option value="male">Male </option>
                                                <option value="female">Female </option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <strong>Marital Status:</strong>
                                            <br/>
                                            <select name='marital' class="form-control row">
                                                <option value="single">Single </option>
                                                <option value="married">Married </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <strong>Basic Salary:</strong>
                                            <input id="location" placeholder="basic salary" type="text" class="form-control" name="salary" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <strong>Skills:</strong>

                                            <textarea name="skills" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <strong>About:</strong>

                                            <textarea name="about" class="form-control"></textarea>
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
</div>

<script src="http://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyBgc2zYiUzXGjZ277annFVhIXkrpXdOoXw"></script>
<script src="{{$root.'/js/jquery.geocomplete.min.js'}}"></script>
<script>

$("#town").geocomplete()
        .bind("geocode:result", function (event, result) {
            var loc = result.geometry.location;
            $("#location").val(loc.lng() + ", " + loc.lat());
        })
        .bind("geocode:error", function (event, status) {
            console.log("ERROR: " + status);
        })
        .bind("geocode:multiple", function (event, results) {
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
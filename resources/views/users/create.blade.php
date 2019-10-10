@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Users </h4>
                <span>Register all users who are supposed to be in the system</span>
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
                {!! Form::open(array('url' => 'users/store','method'=>'POST')) !!}
                <div class="card-block">
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
                            <span id="error-msg" class="hide">Invalid number</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            {!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control ','type'=>'email','id'=>'email')) !!}

                        </div>
                    </div>
                       <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group{{ $errors->has('town') ? ' has-error' : '' }}">
                                <strong>Town:</strong>
                                <input id="town" placeholder="Town" type="text" class="form-control" name="town"
                                       value="" required>

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
                                <select name='role_id' class="form-control">
                                <?php
                                $roles=DB::table('roles')->get();
                                ?>
                                @foreach($roles as $value)
                                
                                <option value="{{$value->id}}">{{$value->display_name}} </option>
                              
                                @endforeach
                                </select>
                            </div>
                        </div>
                    <div id="savebtnWrapper" class="form-group">
                        <button type="submit" class="btn btn-primary">
                            &emsp;Submit&emsp;
                        </button>
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
@endsection

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

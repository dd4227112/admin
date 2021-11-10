@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">

            <div class="page-header">
            <div class="page-header-title">
                <h4>Change password</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">user credentials</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">profile</a>
                    </li>
                </ul>
            </div>
        </div> 

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                  <div id="outer" class="card">
                    <div id="wrapper" class="card-body" style="background-color: #fff; margin-bottom: 40px;">
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
                            {!! Form::open(array('url' => 'users/storePassword','method'=>'POST')) !!}
                            <div class="card-block">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Old Password:</strong>
                                        <input placeholder="Old Password" class="form-control" name="password" type="password">
                                    </div>
                                </div>
                   <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>New Password:</strong>
                                        <input placeholder="New Password" class="form-control" name="new" type="password">
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Re-type Password:</strong>
                                         <input placeholder="Retype Password" class="form-control" name="retype" type="password">
                                    </div>
                                </div>
                             
                                <div id="savebtnWrapper" class="form-group">
                                    <button type="submit" class="btn btn-primary btn-mini btn-round">
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
</div>
@endsection



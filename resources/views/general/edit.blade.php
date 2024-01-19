@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

    
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Phone calls </h4>
                <span></span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Phone calls</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Edit</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">

                        <form action="{{ url('Phone_call/edit') }}" method="POST">
                            @csrf
                                    <div class="card-block">
                                        <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>First Name:</strong>
                                                <input type="text" name="full_name" placeholder="Name" class="form-control" value="{{ old('full_name') }}" />
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Phone:</strong>
                                                <input type="tel" name="phone_number" placeholder="Phone Number" class="form-control phoneNumber" id="phone" value="{{ old('phone_number') }}" />
                                                <span id="valid-msg" class="hide">✓ Valid</span>
                                                <span id="error-msg" class="hide">Invalid number</span>
                                            </div>
                                         </div>
                                        </div>

                                        <div class="row">
                                         <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Email:</strong>
                                                <input type="email" name="email" placeholder="Email" class="form-control" id="email" value="{{ old('email') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group{{ $errors->has('town') ? ' has-error' : '' }}">
                                                <strong>Location:</strong>
                                                <input id="town" placeholder="Location" type="text" class="form-control"
                                                    name="location" value="" required>

                                                @if ($errors->has('town'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('town') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                         </div>
                                        </div>


                                        <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Call type:</strong>
                                                <br />
                                                <select name='call_type' class="form-control">
                                                    <option value="0">Incoming</option>
                                                    <option value="1">Outgoing</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Time:</strong>
                                                <br />
                                                <div class="input-group clockpicker">
                                                    <input type="text" class="form-control" value="09:30"
                                                        name='call_time'> <span class="input-group-addon"> <span
                                                            class="glyphicon glyphicon-time"></span> </span>
                                                </div>
                                            </div>
                                         </div>
                                        </div>

                                        <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Call Duration:</strong>
                                                <br />
                                                <input id="call_duration" placeholder="Call Duration" type="number"
                                                    class="form-control" name="call_duration" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Next Followup Date:</strong>
                                                <br />

                                                <input type="date" class="form-control " placeholder=""
                                                    name="followup_date"> </div>
                                         </div>
                                        </div>

                                        <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Next Followup Time:</strong>
                                                <br />
                                                <div class="input-group clockpicker">
                                                    <input type="text" class="form-control" value="09:30"
                                                        name='next_followup'> <span class="input-group-addon"> <span
                                                            class="glyphicon glyphicon-time"></span> </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Call Details:</strong>
                                                <textarea id="call_detail" placeholder="call details here" type="text"
                                                    class="form-control" name="call_detail" required></textarea>
                                            </div>
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


@endsection
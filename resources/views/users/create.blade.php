@extends('layouts.app')

@section('content')

    
       
         <div class="page-header">
            <div class="page-header-title">
                <h4> Create user</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">users</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 

        <div class="page-body">
            <div class="row">
                <div class="card">
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
                            {!! Form::open(array('url' => 'users/store','method'=>'POST')) !!}
                            <div class="card-block">
                                <div class="row">  
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>First Name:</strong>
                                        {!! Form::text('firstname', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                    </div>
                                   </div>
                                   <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Last Name:</strong>
                                        {!! Form::text('lastname', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
                                    </div>
                                  </div>

                                  <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Phone:</strong>
                                        {!! Form::text('phone', null, array('placeholder' => 'Phone Number','class' => 'form-control phoneNumber','type'=>'tel','id'=>'phone')) !!}
                                        <span id="valid-msg" class="hide">✓ Valid</span>
                                        <span id="error-msg" class="hide">Invalid number</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Personal Email:</strong>
                                        {!! Form::email('personal_email', null, array('placeholder' => 'Personal Email','class' => 'form-control ','type'=>'email','id'=>'personal_email')) !!}
                                    </div>
                                </div>
                                </div>

                              

                              <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Company Email:</strong>
                                        {!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control ','type'=>'email','id'=>'email')) !!}
                                        <span class="hinge">Please login into hosting account and create an email ID for this person</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
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

                                 <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Map Location:</strong>
                                        <input id="location" readonly placeholder="location" type="text" class="form-control" name="location" value="" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Role:</strong>
                                        <br/>
                                        <select name='role_id' class="form-control">
                                            <?php
                                            $roles = DB::table('roles')->get();
                                            ?>
                                            @foreach($roles as $value)
                                              <option value="{{$value->id}}">{{$value->display_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                </div> 

                    

                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Gender:</strong>
                                        <br/>
                                        <select name='sex' class="form-control">
                                            <option value="male">Male </option>
                                            <option value="female">Female </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Marital Status:</strong>
                                        <br/>
                                        <select name='marital' class="form-control">
                                            <option value="single">Single </option>
                                            <option value="married">Married </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>National ID:</strong>
                                        <input id="location" placeholder="Put user national ID" type="text" class="form-control" name="national_id" value="">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Date of Birth:*</strong>
                                        <input id="location" placeholder="Date of Birth" type="date" class="form-control" name="date_of_birth" value="" required>
                                    </div>
                                </div>
                             </div>

                        

                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Employment Category*:</strong>  <br/>
                                        <select name='employment_category' class="form-control">
                                            <option value="permant">Permanent </option>
                                            <option value="temporarily">Temporarily</option>
                                            <option value="consultant">Consultant</option>
                                            <option value="intern">Intern</option>
                                            <option value="practical training">Practical Training</option>
                                            <option value="consultant">Consultant</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Basic Salary:</strong>
                                        <input id="location" placeholder="basic salary" type="text" class="form-control" name="salary" value="" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Joining Date:*</strong>
                                        <input id="location" placeholder="Date of Joining" type="date" class="form-control" name="joining_date" value="" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Contract End date:*</strong>
                                        <input id="location" placeholder="Contract End date" type="date" class="form-control" name="contract_end_date" value="" required>
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                 <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Have Valid Passport:</strong>
                                        <br/>
                                        <select name='valid_passport' class="form-control">
                                            <option value="YES">YES </option>
                                            <option value="NO">NO </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Skills:</strong>
                                        <textarea name="skills" class="form-control"></textarea>
                                    </div>
                                </div>
                           
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Account number:</strong>
                                        <input  placeholder="Account number" type="text" class="form-control" name="bank_account"  required>
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>Bank name:</strong>
                                        <input  placeholder="Bank name" type="text" class="form-control" name="bank_name" value="" required>
                                    </div>
                                </div>
                             </div>

                             <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <strong>About:</strong>
                                        <textarea name="about" class="form-control"></textarea>
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <strong>Next Kin Information:</strong>
                                        <textarea name="next_kin" class="form-control" placeholder="Name , Relation, Phone, Email "></textarea>
                                    </div>
                                </div>
                             </div>

                             <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <strong>T-shirt Size:</strong>
                                        <input id="location" placeholder="T-shirt size" type="text" class="form-control" name="tshirt_size" value="" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <strong>Have Driving License:</strong>
                                        <br/>
                                        <select name='driving_license' class="form-control">
                                            <option value="YES">YES </option>
                                            <option value="NO">NO </option>
                                        </select>
                                    </div>
                                </div>
                              </div>

                             <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <strong>Scanned Academic Certificates:</strong>
                                        <input id="location" placeholder="Academic Certificates" type="text" class="form-control" name="academic_certificates" value="" required>
                                        <span class="hinge">Please Scan all academic certificates, place them into one document, upload them in company Google drive account, and paste a shared link here</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <strong>Scanned Medical Report:</strong>
                                        <input id="location" placeholder="Academic Certificates" type="text" class="form-control" name="medical_report" value="" required>
                                        <span class="hinge">Please Scan health check report from registered hospital, place them into one document, upload them in company Google drive account, and paste a shared link here</span>
                                    </div>
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

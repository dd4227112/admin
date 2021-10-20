@extends('layouts.app')
@section('content')

<?php $root = url('/') . '/public/' ?>
<div class="main-body">
    <div class="page-wrapper">
        <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

        <!-- Page-header end -->
    <?php    if (can_access('manage_users') || Auth::user()->id == $id) { ?>
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-header">
                            <span>Specify information correctly as specified. Area marked with * are mandatory</span>
                        </div>


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
                                {!! Form::model($user, ['method' => 'PATCH','class'=>'form-horizontal', 'enctype' => 'multipart/form-data', 'url' => ['users/edit', $user->id]]) !!}
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>First Name:</strong>
                                            {!! Form::text('firstname', null, array('placeholder' => 'Name','class' => 'form-control ')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Last Name:</strong>
                                            {!! Form::text('lastname', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Phone:</strong>
                                            {!! Form::text('phone', null, array('placeholder' => 'Phone Number','class' => 'form-control phoneNumber','type'=>'tel','id'=>'phone')) !!}
                                            <span id="valid-msg" class="hide">✓ Valid</span>
                                            <span id="error-msg" class="hide">Invalid</span>
                                        </div>
                                      </div>
                                    </div>


                                  <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Personal Email:</strong>
                                            {!! Form::email('personal_email', null, array('placeholder' => 'Personal Email','class' => 'form-control ','type'=>'email','id'=>'personal_email')) !!}

                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Company Email:</strong>
                                            {!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control ','type'=>'email','id'=>'email')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group {{ $errors->has('town') ? ' has-error' : '' }}">
                                            <strong>Town:</strong>
                                            <input id="town" placeholder="Town" type="text" class="form-control" name="town"
                                                   value="{{$user->town}}" >

                                            @if ($errors->has('town'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('town') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                      </div>
                                    </div>

                                  <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group ">
                                            <strong>Map Location:</strong>
                                            <input id="location" readonly placeholder="location" type="text" class="form-control" name="location" value="<?=ucfirst($user->location)?>">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Role:</strong>
                                            <br/>
                                            <select name='role_id' class="form-control">
                                                <?php
                                                $roles = DB::table('roles')->get();
                                                ?>
                                                @foreach($roles as $value)
                                                 <option value="{{ $value->id }}" {{ $value->id == $user->role_id ? 'selected' : '' }}>{{ $value->display_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Gender:</strong>
                                            <br/>
                                            <select name='sex' class="form-control">
                                                <option value="male">Male </option>
                                                <option value="female">Female </option>
                                            </select>
                                        </div>
                                      </div>
                                    </div>

                                  <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Marital Status:</strong>
                                            <br/>
                                            <select name='marital' class="form-control">
                                                <option value="single">Single </option>
                                                <option value="married">Married </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>National ID:</strong>
                                            <input id="location" placeholder="National ID" type="text" class="form-control" name="national_id" value="<?=ucfirst($user->national_id)?>" >
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Date of Birth:*</strong>
                                            <input id="location" placeholder="basic salary" type="date" class="form-control" name="date_of_birth" value="<?=ucfirst($user->date_of_birth)?>" required>
                                        </div>
                                    </div>
                                   </div>

                                  <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Employment Category*:</strong>  <br/>
                                            <select name='employment_category' class="form-control">
                                            <option value="<?=$user->employment_category?>"><?=ucfirst($user->employment_category)?> </option>
                                                <option value="permant">Permanent </option>
                                                <option value="temporarily">Temporarily</option>
                                                <option value="contract">Contract</option>
                                                <option value="intern">Intern</option>
                                                <option value="practical training">Practical Training</option>
                                                <option value="consultant">Consultant</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Basic Salary:</strong>
                                            <input id="location" placeholder="basic salary" type="text" class="form-control  transaction_amount" name="salary" value="<?=$user->salary?>">
                                        </div>
                                    </div>

                                    <?php if(can_access('edit_user_info')) { ?>
                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <div class="form-group">
                                                <strong>Joining Date:*</strong>
                                                <input id="location" placeholder="Date of Joining" type="date" class="form-control" name="joining_date" value="<?=$user->joining_date?>" >
                                            </div>
                                        </div>
                                    </div>

                                  <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Contract End date:*</strong>
                                            <input id="location" placeholder="Contract End date" type="date" class="form-control" name="contract_end_date" value="<?=$user->contract_end_date?>" >
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Scanned Academic Certificates:</strong>
                                            <input id="certificate" placeholder="Academic Certificates" type="text" class="form-control" name="academic_certificates" value="<?=$user->academic_certificates?>" >
                                            <span class="hinge">Please Scan all academic certificates, place them into one document, upload them in company Google drive account, and paste a shared link here</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Scanned Medical Report:</strong>
                                            <input id="location" placeholder="Academic Certificates" type="text" class="form-control" name="medical_report" value="<?=$user->medical_report?>" >
                                            <span class="hinge">Please Scan health check report from registered hospital, place them into one document, upload them in company Google drive account, and paste a shared link here</span>
                                        </div>
                                     </div>
                                    </div>

                                  <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Scanned Employment contract:</strong>
                                            <input id="location" placeholder="Employment contract" type="text" class="form-control" name="employment_contract" value="<?=$user->employment_contract?>" >
                                            <span class="hinge">Please Scan employment contract upload them in company Google drive account, and paste a shared link here</span>
                                        </div>
                                    </div>
                                  <?php } ?>


                                     <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Employment CV:</strong>
                                            <input id="location" placeholder="Employment contract" type="text" class="form-control" name="cv" value="<?=$user->cv?>" >
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>T-shirt Size:</strong>
                                            <input id="location" placeholder="T-shirt size" type="text" class="form-control" name="tshirt_size" value="<?=$user->tshirt_size?>">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Have Driving License:</strong>
                                            <br/>
                                            <?php  echo form_dropdown("driving_license", array('YES' => 'YES', "NO" => 'NO'), old("valid_passport", $user->driving_license), "id='valid_passport' class='form-control'"); ?>

                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Have Valid Passport:</strong>
                                            <br/>
                                            <?php  echo form_dropdown("valid_passport", array('YES' => 'YES', "NO" => 'NO'), old("valid_passport", $user->valid_passport), "id='valid_passport' class='form-control'"); ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Skills:</strong>
                                            <textarea name="skills" class="form-control">{{$user->skills}}</textarea>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group ">
                                            <strong>About:</strong>
                                            <textarea name="about"  class="form-control">{{$user->about}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group ">
                                            <strong>Bank name:</strong>
                                            <textarea name="bank_name"  class="form-control">{{$user->bank_name}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group ">
                                            <strong>Bank account:</strong>
                                            <textarea name="bank_account"  class="form-control">{{$user->bank_account}}</textarea>
                                        </div>
                                    </div>
                                  </div>

                                <?php if(can_access('edit_user_info')) { ?>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Next Kin Information:</strong>
                                             <input name="next_kin" class="form-control" value="<?=$user->next_kin ?>">
                                        </div>
                                    </div>
                                 </div>
                                  <?php }  ?>
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                                        <button type="submit" class="btn btn-primary btn-mini btn-round">Update User</button>
                                    </div>
                                
                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>
                </div>
                 <?php } ?>
            </div>
        </div>
    </div>
</div>

@endsection
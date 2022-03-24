@extends('layouts.app')
@section('content')

         <div class="page-header">
            <div class="page-header-title">
                <h4> Create phone call</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">phone call</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 
        
        <div class="page-body">
            <div class="row">
                <div class="col-md-12 col-xl-12">
                <div class="card">
                    <!-- Row start -->
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs md-tabs " role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"><i
                                    class="icofont icofont-phone"> </i> Add Phone Call</a>
                            <div class="slide"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#uploads" role="tab"><i
                                    class="icofont icofont-files "></i> Upload Phone Calls</a>
                            <div class="slide"></div>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content card-block">
                        <div class="tab-pane active" id="home7" role="tabpanel">
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
                                    {!! Form::open(array('url' => 'Phone_call/store','method'=>'POST')) !!}
                                    <div class="card-block">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>First Name:</strong>
                                                {!! Form::text('full_name', null, array('placeholder' => 'Name','class'
                                                => 'form-control')) !!}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Phone:</strong>
                                                {!! Form::text('phone_number', null, array('placeholder' => 'Phone
                                                Number','class' => 'form-control
                                                phoneNumber','type'=>'tel','id'=>'phone')) !!}
                                                <span id="valid-msg" class="hide">✓ Valid</span>
                                                <span id="error-msg" class="hide">Invalid number</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Email:</strong>
                                                {!! Form::email('email', null, array('placeholder' => 'Email','class' =>
                                                'form-control ','type'=>'email','id'=>'email')) !!}

                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
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
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Call type:</strong>
                                                <br />
                                                <select name='call_type' class="form-control">
                                                    <option value="0">Incoming</option>
                                                    <option value="1">Outgoing</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
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


                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Call Duration:</strong>
                                                <br />
                                                <input id="call_duration" placeholder="Call Duration" type="number"
                                                    class="form-control" name="call_duration" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Next Followup Date:</strong>
                                                <br />

                                                <input type="date" class="form-control " placeholder=""
                                                    name="followup_date"> </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
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

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Call Details:</strong>
                                                <textarea id="call_detail" placeholder="call details here" type="text"
                                                    class="form-control" name="call_detail" required></textarea>
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
                    <!-- </div>
                </div>
            </div> -->
            <div class="tab-pane" id="uploads" role="tabpanel">
                <div class="card-header">
                    <h5>Add New Members</h5>
                    <span>Import Calls  from a CSV file. In Excel, add an required column of  New call, and save the file in a CSV format. Click A CSV file, then drag and drop your .csv file, or click choose file to browse files on your computer. Then click <b>Submit. <br>  <br></b>
                    <a href="<?=url('public/sample_files/upload_sample_phone_call.csv')?>" class="right"> <u><b>#Download Sample</b></u> </a>
                    </span>
                </div>
                <form id="add-form" action="{{ url('Phone_call/CallsUpload') }}" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label>Attach File Name</label>
                    <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                        <i class="fas fa-file"></i>
                        </div>
                    </div>
                    <input type="file" class="form-control" placeholder="Enter group name..." name="call_file" required>
                    </div>
                </div>
                <!-- </div> -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
                </form>
              </div>

                </div>
    </div>
</div>
</div>
</div>
@endsection

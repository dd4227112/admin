@extends('layouts.app')

@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Phone calls</h4>
                <span>List Phone calls records</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Phone Records</a>
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
                <div class="col-lg-12">
                    <div id="wrapper" class="card">
                        <div id="editorForm">
                            <div class="row">
                                <div class="card-header">
                                    <div class="pull-left">
                                        <h2>Phone Calls Management</h2>
                                    </div>
                                    <div class="pull-right">
                                       
                                            <a class="btn btn-success" href="<?= url('Phone_call/create') ?>">  New Phone Call</a>
                                      
                                    </div>
                                </div>
                            </div>
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif
                            <div class="card-block">

                                <div class="table-responsive dt-responsive ">
                                    <table class="table table-bordered dataTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Full Name</th>
                                                <th>Phone Number</th>
                                                 <th>Email</th>
                                                 <th>Call Type</th>
                                                 <th>Time</th>
                                                  <th>Next Follow up</th>
                                                   <th>Call Duration</th>
                                                    <th>Call Details</th>
                                                <th width="280px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($phone_calls as $key => $call)
                                            <tr>
                                    <td><?= $i ?></td>
                                                <td>{{ $call->full_name }} </td>
                                                <td>{{ $call->phone_number }} </td>
                                                <td>{{ $call->email }}</td>
                                                <td><?php if($call->call_type==0){
                                                    echo 'Outgoing';    
                                                } else{
                                                    echo 'Incoming';  
                                                }?></td>
                                                
                                                <td>{{ $call->created_at}}<br> {{ $call->call_time}}</td>
                                                <td>{{ $call->followup_date }}<br> {{ $call->next_followup }}</td>
                                                <td>{{ $call->call_duration }}</td> 
                                                <td>{{ $call->call_detail }}</td> 
                                                <td>
                                                    <a class="btn btn-primary btn-sm" href="{{ url('Phone_call/edit/'.$call->id) }}">Edit</a> 

                                                 
                                                    <a class="btn btn-danger btn-sm" href="{{ url('Phone_call/destroy/'.$call->id) }}">Delete</a>
                                                 
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Exams </h4>
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
                <div class="col-lg-12">
                    <div id="wrapper" class="card">
                        <div id="editorForm">
                            <div class="row">
                                <div class="card-header">
                                    <div class="pull-left">
                                        <h2>User Management</h2>
                                    </div>
                                    <div class="pull-right">
                                       
                                            <a class="btn btn-success" href="<?= url('users/create') ?>"> Create New User</a>
                                      
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
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                 <th>Email</th>
                                                <th width="280px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($users as $key => $user)
                                            <tr>
                                    <td><?= $i ?></td>
                                                <td><img src="{{$root.'images/'.$user->dp }}" class="img-circle" style="position: relative;
                                                         width: 30px;
                                                         height: 30px;
                                                         border-radius: 50%;
                                                         overflow: hidden;"></td>
                                                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <a class="btn btn-info btn-sm" href="{{ url('users/show/'.$user->id) }}">Show</a>
                                                  
                                                        <a class="btn btn-primary btn-sm" href="{{ url('users/edit/'.$user->id) }}">Edit</a>

                                                 
                                                        <a class="btn btn-danger btn-sm" href="{{ url('users/destroy/'.$user->id) }}">Delete</a>
                                                 
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
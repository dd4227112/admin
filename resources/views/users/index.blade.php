@extends('layouts.app')

@section('content') 
<?php $root = url('/') . '/public/' ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Company Staff Members </h4>
                <span>This Part show all Active Company Staff Members</span>
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
        <?php if (can_access('manage_users')) { ?>
            <div class="page-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="wrapper" class="card">
                            <div id="editorForm">
                            <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a class="btn btn-success" href="<?= url('users/create') ?>"> Create New User</a>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button class="btn btn-primary" data-toggle="modal"  role="button" data-target="#status-Modal"> Upload Users  <i class="ti-user"></i></button>                     
                                    </div>
                                    @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @endif
                                    <hr>
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
                                                        <th>Joining Date</th>
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
                                                         <td>{{ date('d M Y',strtotime($user->created_at)) }}</td>
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
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="status-Modal">
<div class="modal-dialog modal-lg" role="document">
<form id="add-form" action="{{ url('users/userUpload') }}" method="POST" enctype="multipart/form-data">
<?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add New Members</h5>
            <a href="<?=url('public/sample_files/users.csv')?>"> <u><b>Download Sample</b></u> </a>
        </div>
      <div class="modal-body">
      <p>Import users from a CSV file. In Excel, add an required column of  New Users, and save the file in a CSV format. Click A CSV file, then drag and drop your .csv file, or click choose file to browse files on your computer. Then click <b>Submit. <br>  <br> #Remember to Remove First Row.</b></p>
          <div class="form-group">
            <label>Attach File Name</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-file"></i>
                </div>
              </div>
              <input type="file" class="form-control" placeholder="Enter group name..." name="user_file" required>
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
    @endsection
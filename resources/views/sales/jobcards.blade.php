@extends('layouts.app')

@section('content') 
<?php $root = url('/') . '/public/' ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">School Job cards</h4>
                <span>This Part show all Active Company Staff Members</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Job cards</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Schools</a>
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
                            <br>
                                <div class="row">
                                    
                                   
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
                                                        <th>School name</th>
                                                        <th>Date</th>
                                                        <th>Created by</th>
                                                        <th width="280px">Action</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php
                                                    $x = 1;
                                                    if(count($jobcards) > 0) {
                                                    foreach ($jobcards as $jobcard) { ?>
                                                    <tr>
                                                        <td><?= $x ?></td>
                                                        <td><?=$jobcard->clientname?></td>
                                                        <td><?=$jobcard->date?></td>
                                                        <td><?=$jobcard->name?></td>
                                                        <td>
                                                            <a  target="_break" href="<?= url('customer/viewFile/'.$jobcard->date.'/jobcard') ?>" class="btn btn-sm btn-success">View job card</a>
                                                        </td>
                                                    </tr>
                                                    <?php $x++; } } ?>
                                                  
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


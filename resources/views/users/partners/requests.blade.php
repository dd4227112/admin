@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Shulesoft Partners List</h4>
        <span>The Part holds all list of partners and their branches.</span>

      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Company partners</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">partners</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h5>Schools Onboarding Status
              </h5>
              <span style="float: right">
                <a class="btn btn-success btn-sm" href="<?= url('Partner/add') ?>">  <i class="ti-plus"> </i> Add School</a>
              </span>
            </div>
            <div class="card-block">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs  tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">All Requests</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#Completed" role="tab"> <i class="ti-pencil"> </i> New Requests</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#Progress" role="tab"> <i class="ti-check"> </i> Verified</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#Pending" role="tab"> <i class="ti-danger"> </i> Pending</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#profile1" role="tab"> <i class="ti-menu"> </i> Reports</a>
                </li>

              </ul>
              <!-- Tab panes -->
              <div class="tab-content tabs">
                <div class="tab-pane active" id="home1" role="tabpanel">

                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>School</th>
                          <th>System Status</th>
                          <th>Bank Interation</th>
                          <th>Bank Approval</th>
                          <th>Shulesoft Approval</th>
                          <th>Added Date</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>

                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endsection

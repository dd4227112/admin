@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start 
    <div class="page-header">
      <div class="page-header-title">
        <h4>Shulesoft Partners School Lists</h4>
        <span>The Part holds all list of schools and their branches.</span>

      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Company schools</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">schools</a>
          </li>
        </ul>
      </div>
    </div>
    Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <!-- Ajax data source (Arrays) table start -->
          <div class="card tab-card">
          <div class="card-header">
           <h3> <?=isset($branch) ? 'List of Schools At '. $branch->name.' Branch' : 'Shulesoft Partners School Lists'; ?> 

          <span style="float:right">
          <?php
                isset($branch) ? $id = $branch->partner_id : $id = $set;
          ?>
          <a class="btn btn-info btn-sm" href="<?= url('Partner/addSchool/'.$id) ?>"> Add New School</a>
          </span>
          </h3>
           </div>
            <div class="card-block">
          
              <div class="steamline">
                <div class="card-block">

                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                          <th>Id </th>
                          <th>School Name</th>
                          <th>Account Name</th>
                          <th>Account Number</th>
                          <th>Branches</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(!empty($schools)){
                        
                        $i = 1;
                        foreach($schools as $school){
                          
                          ?>
                      <tr>
                          <td><?=$i++?> </td>
                          <td><a href="{{ url('sales/profile/'.$school->school_id) }}"><?=$school->school_id !='' ? substr($school->school->name, 0, 60) .' - ' .$school->school->type : 'Undefined' ?></a></td>
                          <td><?=$school->account_name?></td>
                          <td><?=$school->account_number?></td>
                          <td><b><?=$school->branch->name?></b></td>

                          <td>
                          <a class="btn btn-success btn-sm" href="{{ url('sales/profile/'. $school->school_id) }}"> View School</a>
                          <!-- <a class="btn btn-warning btn-sm" href="{{ url('users/deleteschool/'.$school->id) }}">Delete</a> -->
                          </td>
                        </tr>
                        <?php } } ?>
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
</div>
@endsection
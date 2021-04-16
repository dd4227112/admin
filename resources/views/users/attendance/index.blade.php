@extends('layouts.app')
@section('content')

<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Attendance</h4>
        <span>The Part holds all list of users on their attendance.</span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Company Employee</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Attendance</a>
          </li>
        </ul>
      </div>
    </div>
   
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="card tab-card">
            <div class="card-block">

              <div class="m-6">
                <a href="<?= url('attendance/add') ?>" class="btn btn-sm btn-primary">Add attendance</a>
               </div>
    
              <div class="steamline">
                <div class="card-block">

                  <div class="table-responsive table-sm table-striped table-bordered table-hover">
                    <table id="dt-ajax-array" class="table dataTable">
                      <thead>
                        <tr>
                          <th># </th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Role </th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(!empty($users)){
                        $i = 1;
                        foreach($users as $user){
                          ?>
                      <tr>
                          <td><?=$i++?> </td>
                          <td><?=$user->name ?></td>
                          <td><?=$user->email ?></td>
                          <td><?=$user->phone ?></td>
                          <td><?=$user->role->display_name ?></td>
                          <td class="text-center">
                          <a class="btn btn-info btn-sm" href="{{ url('attendance/index/'.$user->id) }}">View </a>
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

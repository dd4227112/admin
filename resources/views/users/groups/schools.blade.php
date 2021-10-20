@extends('layouts.app')
@section('content')
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <?php 
    $breadcrumb = array('title' => $group->name,'subtitle'=>'operations','head'=>'school list'); ?>
    <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
   
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
              <div class="card-block">
                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>School name</th>
                          <th>Email</th>
                          <th>No of students</th>
                          <th>code</th>
                          <th>Phone</th>
                         
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(sizeof($schools) > 0){
                        $i = 1;
                        foreach($schools as $group){ ?>
                      <tr>
                          <td><?=$i++?> </td>
                          <td><?=$group->name?></td>
                          <td><?=$group->email?></td>
                          <td><?=$group->estimated_students?></td>
                          <td><?=$group->code?></td>
                          <td><?=$group->phone?></td>
                         
                        </tr>
                        <?php }  ?>
                    <?php }  ?>
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
@endsection

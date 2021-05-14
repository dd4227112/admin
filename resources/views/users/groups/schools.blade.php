@extends('layouts.app')
@section('content')
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>User group List</h4>
        <span>The Part holds all written record of user groups.</span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">User groups</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">groups</a>
          </li>
        </ul>
      </div>
    </div>
 
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="card tab-card">
            <div class="card-block">
              <div class="steamline">
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
  </div>
</div>
@endsection
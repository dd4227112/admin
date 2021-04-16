@extends('layouts.app')
@section('content')
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>KPI List</h4>
        <span>The Part holds all written record of kps.</span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Company Minutes</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">KPI</a>
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

                <div class="m-10">
                    <a href="<?= url('users/kpi') ?>" class="btn btn-sm btn-primary">Create New KPI</a>
                </div>

                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                          <th>Id </th>
                          <th>Title</th>
                          <th>Date</th>
                          <th>Value</th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(sizeof($kpis) > 0){
                        $i = 1;
                        foreach($kpis as $kpi){
                          ?>
                      <tr>
                          <td><?=$i++?> </td>
                          <td><?=$kpi->name?></td>
                          <td><?=$kpi->created_at ?></td>
                          <td><?=$kpi->value?></td>
                          <td>
                          <a class="btn btn-info btn-sm" href="{{ url('users/kpi/'.$kpi->id . '/edit') }}">Edit</a>
                          <a class="btn btn-warning btn-sm" href="{{ url('users/kpi/'.$kpi->id .'/assign') }}">Assign</a>
                          <a class="btn btn-warning btn-sm" href="{{ url('users/kpi/'.$kpi->id .'/show') }}">Show</a>
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

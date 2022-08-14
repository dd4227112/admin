@extends('layouts.app')
@section('content')

     <div class="page-header">
            <div class="page-header-title">
              <h4><?='Implement school tasks' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">new school</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Tasks</a>
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
                            <th>School Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Code</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(sizeof($schoolstasks) > 0){
                        $i = 1;
                        foreach($schoolstasks as $value){ ?>
                              <tr>
                              <td><?= $i ?></td>
                              <td><?= $value->name ?? '' ?></td>
                              <td><?= $value->email ?? '' ?></td>
                              <td><?= $value->phone ?? '' ?></td>
                              <td><?= $value->code ?? '' ?></td>
                              
                            
                            
                              <td class="text-center">
                                  <a href="<?= url('sales/implemetation/'.$value->id) ?>" class="btn btn-info btn-mini btn-round">Implement tasks</a>                     
                              </td>
                          </tr>
                        <?php $i++; } } ?>
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
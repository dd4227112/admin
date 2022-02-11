@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

     <div class="page-header">
            <div class="page-header-title">
              <h4><?='Onboard new school' ?></h4>
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
                    <li class="breadcrumb-item"><a href="#!">sales</a>
                    </li>
                </ul>
            </div>
        </div> 

         
        <div class="page-body">
            <div class="row">
              <div class="col-lg-12">
                    <div class="card">
                          <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Estimated students</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php
                                        $i = 1;
                                        if(isset($clients)) {
                                          foreach ($clients as $value) { ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $value->name ?></td>
                                                <td><?= $value->email ?></td>
                                                <td><?= $value->phone ?></td>
                                                <td><?= $value->estimated_students ?></td>
                                                <td class="text-center">
                                                  <?php if((int) $value->status == 3) { ?>
                                                    <a href="<?= url('sales/implemetation/'.$value->id) ?>" class="btn btn-info btn-sm btn-round">Implement tasks</a>
                                                  <?php } else { ?>
                                                      <?php if(can_access('approve_implementaion')) { ?>
                                                         <a href="<?= url('sales/updateOnboardStatus/'. $value->id) ?>" class="btn btn-success btn-sm btn-round">Approve</a>
                                                       <?php } ?>
                                                      
                                                 <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $i++;
                                          }
                                        }
                                        ?>
                                     </tbody>
                                </table>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
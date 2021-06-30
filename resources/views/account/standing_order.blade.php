@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>STANDING ORDERS </h4>
                <span>This Part Show all standing orders</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Customer Support</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Activities</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                </div>
            </div>
         </div>

            <div class="card tab-card">
                <ul class="nav nav-tabs md-tabs" role="tablist">
                    <li class="nav-item complete">
                        <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                            <strong> Standing orders</strong>
                        </a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item complete">
                        <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false">Summary</a>
                        <div class="slide"></div>
                    </li>
                  
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                        <div class="card-block">
                           <div class="dt-responsive table-responsive">
                   
                            <table id="" class="table table-striped table-bordered nowrap dataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>School </th>
                                        <th>Contact </th>
                                        <th>Type</th>
                                        <th>Occurance amount</th>
                                        <th>Total amount</th>
                                        <th>Maturity date</th>
                                        <th colspan="2" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                

                                    <?php if(count($standingorders) > 0) { ?>
                                        @foreach ($standingorders as $key => $standing)
                                        <tr>
                                        <td><?=$key+1?></td>
                                        <td><?= isset($standing->client) ? $standing->client->name: ''?></td>

                                        <td><?= isset($standing->schoolcontact) ? $standing->schoolcontact->name: ''?></td>
                                       
                                        <td><?=$standing->type?></td>
                                        <td><?=money($standing->occurance_amount)?></td>
                                        <td><?=money($standing->total_amount)?></td>
                                        <td><?=isset($standing->payment_date) ? date('d M Y', strtotime($standing->payment_date)) : ''?></td>
                                        <td>
                                          
                                        {{-- <div class="dropdown-secondary dropdown f-right"> --}}
                                        {{-- <button class="btn btn-success btn-mini dropdown-toggle waves-effect waves-light" type="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button> --}}
                                        {{-- <div class="dropdown-menu" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"> --}}
                                         <a  target="_break" href="<?= url('customer/viewContract/'.$standing->id) ?>" class="waves-light waves-effect btn btn-primary btn-sm">View</a>
 
                                     <?php if(isset($standing->payment_date)) {  ?>  
                                         <?php if(isset($standing->client)) {  ?>
                                            <?php if((int) $standing->is_approved == 1) { ?>
                                                  <button type="button" class="btn btn-dark btn-sm">Approved</button>
                                            <?php } else { ?>
                                              <a href="<?= url('account/approvestandingorder/'.$standing->id) ?>" class="waves-light waves-effect btn btn-warning btn-sm">Approve</a>
                                            <?php } ?>
                                            <?php if((int) $standing->is_approved != 1) { ?>
                                             <a href="<?= url('account/rejectstandingorder/'.$standing->id) ?>" class="waves-light waves-effect btn btn-danger btn-sm">Reject</a> 
                                             <?php } ?>

                                         <?php } ?>
                                        <?php } ?>

                                       </td>

                                  </tr>
                                  @endforeach
                                 <?php } ?>
                                </tbody>
                            
                            </table>
                      
                            </div>
                        </div>
                    </div>


               


                    <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                        <div class="card-block">
                                <div class="card-header">
                                   <div class="table-responsive dt-responsive">
                                      
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> 
                </div>


    @endsection
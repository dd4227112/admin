@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/fullcalendar/dist/fullcalendar.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>/bower_components/fullcalendar/dist/fullcalendar.print.css"
    media='print'>
<!-- Sidebar inner chat end-->
<!-- Main-body start -->
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

                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card">
                        <div class="card-header">
                            <?php if(can_access('add_si')){?>
                                <span style="float: right">
                                  <a class="btn btn-primary btn-sm" 
                                   href="{{ url('Customer/uploadstandingorder') }}"> Add Standing order </a>
                                </span>
                                <?php }?>
                          </div>

                           <div class="col-lg-12 col-xl-12">
                               <div class="">
                                   <div class="card-headeri">
                                        <div class="table-responsive dt-responsive">
                                            <table class="table table-responsive table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>School</th>
                                                        <th>Branch</th>
                                                      
                                                        <th>Type</th>
                                                        <th>Occurance amount</th>
                                                        <th>Total amount</th>
                                                        <th>Maturity date</th>
                                                        <th colspan="2" class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <?php $i = 1; if( count($standingorders) > 0) { ?>
                                                    @foreach ($standingorders as $key => $standing)
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?=$standing->client->name?></td>
                                                        <td><?=$standing->branch->name?></td>
                                               
                                                        <td><?=$standing->type?></td>
                                                        <td><?=money($standing->occurance_amount)?></td>
                                                        <td><?=money($standing->amount)?></td>
                                                        <td><?= date('d M Y', strtotime($standing->payment_date)) ?></td>
                                                       @if(can_access('manage_finance'))
                                                        <td>
                                                          <a  target="_break" href="<?= url('customer/viewContract/'.$standing->id.'/standing') ?>" class="btn btn-sm btn-success">View</a>
                                                          @if($standing->is_approved == 0)
                                                          <a  href="<?= url('account/approveStandingOrder/'.$standing->id) ?>" class="btn btn-sm btn-info"> Approve </a>
                                                          <a  href="<?= url('account/rejectStandingOrder/'.$standing->id) ?>" class="btn btn-sm btn-danger"> Reject </a>
                                                       
                                                          @else
                                                          <a  href="<?= url('account/confirmSI/'.$standing->id) ?>" class="badge badge-primary">Confirm</a>
                                                          @endif 
                                                        </td>
                                                     @endif
                                                    </tr>
                                                    <?php $i++; ?>
                                                    @endforeach
                                                    <?php } ?>
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
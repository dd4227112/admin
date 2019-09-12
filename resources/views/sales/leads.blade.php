@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Sales Materials</h4>
                <span>Use this part to get all important resources to support you in sales</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Sales</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Materials</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">

                            <div class="col-lg-12 col-xl-12">
                                <div class="sub-title">ShuleSoft Important Materials</div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs md-tabs b-none" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#home5" role="tab">Join Requests</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#profile5" role="tab">Demo Requests </a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#messages5" role="tab">Contact Us Requests</a>
                                        <div class="slide"></div>
                                    </li>
                                    <!--      <li class="nav-item">
                                              <a class="nav-link" data-toggle="tab" href="#settings5" role="tab">FAQ</a>
                                              <div class="slide"></div>
                                          </li>-->
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabs-left-content card-block">
                                    <div class="tab-pane active" id="home5" role="tabpanel">
                                        <div class="row">


                                            <div class="card-block" style="max-width: 68%">

                                                <div class="table-responsive">
                                                    <table id="dt-ajax-array" class="table table-striped dataTable table-bordered nowrap ">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>School Name</th>
                                                                <th>Address</th>
                                                                <th>Message</th>
                                                                <th>Contact Name</th>
                                                                <th>Contact Phone</th>
                                                                <th>Contact Email</th>
                                                                <th>Date Submitted</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;

                                                            if (count($join_requests) > 0) {
                                                                foreach ($join_requests as $join) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td><?= $join->school_name ?></td>
                                                                        <td><?= $join->school_address ?></td>
                                                                        <td><?= $join->message ?></td>
                                                                        <td><?= $join->contact_name ?></td>
                                                                        <td><?= $join->contact_phone ?></td>
                                                                        <td><?= $join->contact_email ?></td>
                                                                        <td><?= date('d M Y', strtotime($join->created_at)) ?></td>
                                                                        <td>

                                                                            <a class="btn btn-info btn-sm" href="<?php echo url('sales/website/onboard/' . $join->id) ?>">On Board</a>

                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="profile5" role="tabpanel">
                                        <div class="row">

                                            <div class="card-block" style="max-width: 58%">

                                                <div class="table-responsive">
                                                    <table id="dt-ajax-array" class="table table-striped dataTable table-bordered ">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>School Name</th>
                                                                <th>Address</th>
                                                                <th>Message</th>
                                                                <th>Contact Name</th>
                                                                <th>Contact Phone</th>
                                                                <th>Contact Email</th>
                                                                <th>Date Submitted</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $d = 1;

                                                            if (count($demo_requests) > 0) {
                                                                foreach ($demo_requests as $demo) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $d ?></td>
                                                                        <td><?= $demo->school_name ?></td>
                                                                        <td><?= $demo->school_location ?></td>
                                                                        <td><?= $demo->message ?></td>
                                                                        <td><?= $demo->contact_name ?></td>
                                                                        <td><?= $demo->contact_phone ?></td>
                                                                        <td><?= $demo->contact_email ?></td>
                                                                        <td><?= date('d M Y', strtotime($demo->created_at)) ?></td>
                                                                        <td>

                                                                            <a class="btn btn-info btn-sm" href="<?php echo url('sales/website/onboard/' . $demo->id) ?>">On Board</a>

                                                                    </tr>
                                                                    <?php
                                                                    $d++;
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="tab-pane" id="messages5" role="tabpanel">
                                        <div class="card-block" style="max-width: 40%">

                                            <div class="table-responsive">
                                                <table id="dt-ajax-array" class="table table-striped dataTable table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Phone</th>
                                                            <th>Email</th>
                                                            <th  class="col-lg-2">Message</th>
                                                            <th>Date Submitted</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="settings5" role="tabpanel">
                                        <p class="m-0">4.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
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
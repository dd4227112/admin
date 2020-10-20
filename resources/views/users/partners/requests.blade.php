@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Shulesoft Schools Onboarding</h4>
        <span>The Part holds all list of partner schools onboarded.</span>

      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Schools Onboarding</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">index</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h5>Schools Onboarding Status
              </h5>
              <span style="float: right">
                <a class="btn btn-success btn-sm" href="<?= url('Partner/add') ?>">  <i class="ti-plus"> </i> Add School</a>
              </span>
            </div>
            <div class="card-block">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs  tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">All Requests</a>
                </li>
                <!-- <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Completed" role="tab"> <i class="ti-pencil"> </i> New Requests</a>
              </li>

              <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#Progress" role="tab"> <i class="ti-check"> </i> Verified</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#invoices" role="tab"> <i class="ti-list"> </i> Invoices</a>
            </li>
            <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#profile1" role="tab"> <i class="ti-menu"> </i> Reports</a>
          </li> -->

        </ul>
        <!-- Tab panes -->
        <div class="tab-content tabs">
          <div class="tab-pane active" id="home1" role="tabpanel">

            <div class="table-responsive dt-responsive">
              <table id="dt-ajax-array" class="table table-striped table-bordered nowrap">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>School Name</th>
                    <th>System Status</th>
                    <th>Bank Integration</th>
                    <th>Bank Status</th>
                    <th>Shulesoft Status</th>
                    <th>Added Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(!empty($requests)){
                    $i=1;
                    foreach($requests as $request){
                      echo '<tr>
                      <td>'.$i++.'</td>
                      <td>'.substr($request->client->name, 0, 30).'</td>
                      <td>'.$request->schema_name.'</td>';
                      ?>
                      <td><?=$request->banks->integration_request_id >0 ? 'Integrated' : 'Not Integrated' ?></td>
                      <td><?=$request->bank_approved==1 ? 'Approved' : 'Not Approved' ?></td>
                      <td><?=$request->shulesoft_approved==1 ? 'Approved' : 'Not Approved' ?></td>
                      <td><?=timeAgo($request->created_at)?></td>
                      <td>
                      <a class="btn btn-info btn-sm" href="<?= url('Partner/view/'.$request->id)?>">View</a>
                      <a href="https://<?=$request->client->username?>.shulesoft.com/database/<?php echo $request->client->username; ?>" target="_blank" class="btn btn-success btn-sm"> Install System</a>
                      </td>
                      </tr>
                      <?php
                    }

                  }
                  ?>
                </tbody>

              </table>
            </div>
          </div>
          <div class="tab-pane" id="invoices" role="tabpanel">
            <div class="table-responsive dt-responsive">
              <table id="dt-ajax-array" class="table table-striped table-bordered nowrap">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>School Name</th>
                    <th>Students</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Added Date</th>
                    <th>Due Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(!empty($invoices)){
                    $i=1;
                    foreach($invoices as $invoice){
                      $contract = \App\Models\ClientContract::where('client_id', $invoice->client_id)->first();
                      ?>
                      <tr>
                        <td><?=$i++?></td>
                        <td><?=$invoice->client->name?></td>
                        <td><?=$invoice->client->estimated_students?></td>
                        <td><?=number_format(12000*$invoice->client->estimated_students)?></td>
                        <td><?=$invoice->status == 0 ? 'Unpaid' : 'Paid' ?></td>
                        <td><?=date('d M Y', strtotime($invoice->client->created_at))?></td>
                        <td><?=date('d M Y', strtotime($contract->contract->start_date))?></td>
                        <td>
                          <a href="<?=url('account/invoiceView/'.$invoice->id)?>" class="btn btn-info btn-sm"> View Invoice</a>
                          <!-- <a href="https://<?=$invoice->client->username?>.shulesoft.com/database/<?=$invoice->client->username?>" target="_blank" class="btn btn-success btn-sm"> Install System</a> -->
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
      @endsection

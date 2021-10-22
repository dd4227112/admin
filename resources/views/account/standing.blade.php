@extends('layouts.app')
@section('content')

<div class="main-body">
  <div class="page-wrapper">

    <div class="page-header">
            <div class="page-header-title">
                <h4>Standing order</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">payroll</a>
                    </li>
                </ul>
            </div>
        </div>
   
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <!-- Ajax data source (Arrays) table start -->
          <div class="card tab-card">
            <div class="card-block">
        
              <div class="steamline">
                <div class="card-block">
                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                            <th>No.</th>
                            <th>School </th>
                            <th>Contact </th>
                            <th>Type</th>
                            <th>Occurance amount</th>
                            <th>Total amount</th>
                            <th>Maturity date</th>
                            <th class="text-center">view</th>
                            <th class="text-center">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(sizeof($standingorders) > 0){
                        $i = 1;
                        foreach($standingorders as $value){ ?>
                       <tr>
                        <td><?=$i ?></td>
                        <td><?= isset($value->client->name) ? $value->client->name : ''?></td>
                        <td><?= isset($value->contact_person) ? $value->contact_person : ''?></td>
                        <td><?=$value->type?></td>
                        <td><?=money($value->occurance_amount)?></td>
                        <td><?=money($value->total_amount)?></td>
                        <td><?=isset($value->payment_date) ? date('d M Y', strtotime($value->payment_date)) : ''?></td>
                        <td class="text-center">
                          <a  target="_break" href="<?= url('customer/viewContract/' . $value->id .'/standing') ?>" class="btn btn-primary btn-mini btn-round">View</a> 
                        </td>

                        <td>
                           <?php $approve_url="account/approvestandingorder/$value->id";$reject_url="account/rejectstandingorder/$value->id";
                           if(isset($value->payment_date)) {  ?>  
                            <?php if(isset($value->client)) {  ?>
                                <?php if((int) $value->is_approved == 1) { ?>
                                    <label class="badge badge-inverse-success">Approved</label>
                                <?php } else { ?>
                                  <a href="<?= url($approve_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Approve standing order">Approve  </a>

                                <?php } ?>
                                <?php if((int) $value->is_approved != 1) { ?>
                                    <a href="<?= url($reject_url) ?>" class="btn btn-warning btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Reject standing order">reject  </a>

                                <?php } ?>

                            <?php } ?>
                           <?php } ?>
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
  </div>
</div>
@endsection

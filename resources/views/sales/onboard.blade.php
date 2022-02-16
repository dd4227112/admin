@extends('layouts.app')
@section('content')

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

                            <th>Standing Order</th>
                            <th>Payment</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(sizeof($clients) > 0){
                        $i = 1;
                        foreach($clients as $value){ ?>
                              <tr>
                              <td><?= $i ?></td>
                              <td><?= $value->name ?></td>
                              <td><?= $value->email ?></td>
                              <td><?= $value->phone ?></td>
                              <td><?= $value->code ?></td>
                              
                              <td class="text-center">
                                 <?php echo  $value->sid == null ? '<label class="badge badge-inverse-warning">Not Defined</label>' : '<a  target="_break" href="customer/viewContract/' . $value->sid .'/standing" class="btn btn-primary btn-mini btn-round">View</a>'  ?>
                              </td>
                              <td>
                                <?php echo  $value->client_id == null ? '<label class="badge badge-inverse-danger">Not paid</label>' : '<label class="badge badge-inverse-info">' .money($value->paid). '<label/>'  ?>
                              </td>
                              <td class="text-center">
                                <?php if((int) $value->status == 3) { ?>
                                  <a href="<?= url('sales/implemetation/'.$value->id) ?>" class="btn btn-info btn-mini btn-round">Implement tasks</a>
                                <?php } else { ?>
                                    <?php if(can_access('approve_implementaion')) { ?>
                                      <a href="<?= url('sales/updateOnboardStatus/'. $value->id) ?>" class="btn btn-success btn-mini btn-round">Approve</a>

                                      {{-- <a href="<?= url('account/invoice') ?>" class="btn btn-primary btn-mini btn-round">view invoice</a> --}}
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


@endsection

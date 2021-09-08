@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'?>
<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>                             

<div class="main-body">
  <div class="page-wrapper">
    <div class="page-header">
      <div class="page-header-title">
        <h4>Standing orders</h4>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="index-2.html">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Dashboard</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Error Logs</a>
          </li>
        </ul>
      </div>
    </div> 

    <div class="page-body">
      <div class="row">
        <div class="col-md-12 col-xl-12">
          <div class="card" style="">
            <div class="card-block tab-icon">
              <!-- Row start -->
              <div class="row">
                <div class="col-lg-12 col-xl-12">
                  <ul class="nav nav-tabs md-tabs " role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#requirements" role="tab"><i class="icofont icofont-ui-user "></i>Standing orders</a>
                      <div class="slide"></div>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div class="tab-pane active" id="requirements" role="tabpanel">
                      <div class="card-block">
                          <div class="table-responsive dt-responsive">
                            <table id="" class="table table-sm table-bordered nowrap dataTable">
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
                                    <?php $i= 1; if(count($standingorders) > 0) 
                                        foreach ($standingorders as $standing) { ?>
                                        <tr>
                                        <td><?=$i ?></td>
                                        <td><?= isset($standing->client) ? $standing->client->name: ''?></td>

                                        <td><?= isset($standing->schoolcontact) ? $standing->schoolcontact->name: ''?></td>
                                       
                                        <td><?=$standing->type?></td>
                                        <td><?=money($standing->occurance_amount)?></td>
                                        <td><?=money($standing->total_amount)?></td>
                                        <td><?=isset($standing->payment_date) ? date('d M Y', strtotime($standing->payment_date)) : ''?></td>

                                        <td>
                                        {{-- <a  target="_break" href="<?= url('storage/uploads/files/'.$standing->file) ?>" class="waves-light waves-effect btn btn-primary btn-sm">View</a> --}}
                              
                                       <a  target="_break" href="<?= url('customer/viewContract/' . $standing->id .'/standing') ?>" class="waves-light waves-effect btn btn-primary btn-sm">View</a> 

 
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
                                  
                                   <?php $i++; } ?>
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
  </div>


</div>
</div>
</div>


<script type="text/javascript">

  $(".select2").select2({
      theme: "bootstrap",
      dropdownAutoWidth: false,
      allowClear: false,
      debug: true
  }); 

</script>

@endsection

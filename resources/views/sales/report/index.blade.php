@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>


<div class="page-wrapper">
  <div class="page-header">
    <div class="page-header-title">
      <h4>Task Performance </h4>
    </div>
    <div class="page-header-breadcrumb">
  </div>
</div>

<div class="page-body">
  <div class="row">
      <div class="col-md-12 col-xl-12">
          <div class="card" style="height: 65em"> 
              <div class="card-block tab-icon">
                  <!-- Row start -->
                
                     
                          <h5> ZONES PERFOMANCES FOR MAY  </h5>                                       
                          <ul class="nav nav-tabs md-tabs " role="tablist">
                              <li class="nav-item">
                                  <a class="nav-link active" data-toggle="tab" href="#profile7" role="tab"><i class="icofont icofont-ui-user "></i>Fill Perfomance</a>
                                  <div class="slide"></div>
                              </li>
                              {{-- <li class="nav-item">
                                  <a class="nav-link" data-toggle="tab" href="#home7" role="tab"><i class="icofont icofont-home"></i>Sent Invoice</a>
                                  <div class="slide"></div>
                              </li> --}}
                          </ul>
                        
                          <div class="tab-content card-block">
                           
                              <div class="tab-pane active" id="profile7" role="tabpanel">
                                 

                                      <div class="table-responsive dt-responsive">
                                          <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                              <thead>
                                                <tr>
                                                  <th width="10%">#</th>
                                                  <th width="10%">Zone Name</th>
                                                  <th width="5%"> Zone Manager</th>
                                                  <th width="5%"> Number of regions</th>
                                                  <th width="5%"> Number of Schools</th>
                                                  <th width="5%">Action</th>
                                           
                                                </tr>
                                              </thead>
                                              <tbody> 
                                              <?php $zones = DB::select('select A.name as zone,C.name as zonemanager from constant.refer_zones as A join admin.zone_managers as B on A.id = B.zone_id
                                              join admin.users as C on B.user_id = C.id'); ?>
                                              
                                              <?php $i=1;foreach($zones as $zone) { ?>
                                                <tr>
                                                  <td width="1%"><?=$i?></td>
                                                  <td width="10%"><?= strtoupper($zone->zone)?></td>
                                                  <td width="5%">
                                                    <?= strtoupper($zone->zonemanager)?>
                                                  </td>
                                                  <td width="5%">
                                                
                                                  </td>
                                                  <td width="5%">
                                                    
                                                  </td>
                                                
                                                  <td width="5%">
                                                    <a href="" class="btn btn-sm btn-success">View</a>
                                                  </td>
                                                </tr>
                                              <?php $i++;} ?>
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

@endsection

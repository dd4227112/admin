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
                  <div class="row">
                      <div class="col-lg-12 col-xl-12">
                     
                          <h5> APRIL CUSTOMER SUPPORT PERFOMANCE REVIEW </h5>                                       
                          <ul class="nav nav-tabs md-tabs " role="tablist">

                              <li class="nav-item">
                                  <a class="nav-link active" data-toggle="tab" href="#profile7" role="tab"><i class="icofont icofont-ui-user "></i>Fill Perfomane</a>
                                  <div class="slide"></div>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link" data-toggle="tab" href="#home7" role="tab"><i class="icofont icofont-home"></i></a>
                                  <div class="slide"></div>
                              </li>
                            
                          </ul>
                        
                          <div class="tab-content card-block">
                           
                              <div class="tab-pane active" id="profile7" role="tabpanel">
                                  <div class="card-block">

                                      <div class="table-responsive dt-responsive">
                                          <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                              <thead>
                                                <tr>
                                                  <th width="10%">#</th>
                                                  <th width="10%">School Name</th>
                                                  <th width="5%">Number of students</th>
                                                  <th width="5%">Ward</th>
                                                  <th width="5%">District</th>
                                                  <th width="5%">Region</th>
                                                  <th width="5%">Action</th>
                                             
                                                </tr>
                                              </thead>
                                              <tbody> 
                                                <?php $i = 1;  foreach($schools as $key => $school) { ?>
                                                <tr>
                                                  <th width="10%"><?=$i?></th>
                                                  <th width="10%"><?=$school->name?></th>
                                                  <th width="5%">
                                                    <?=$school->students?>
                                                  </th>
                                                  <th width="5%">
                                                    <?= $school->wards->name ?>
                                                  </th>
                                                  <td width="5%">
                                                    <?= $school->wards->district->name ?>
                                                  </td>
                                                  <td width="5%"> 
                                                    <?= $school->wards->district->region->name ?>
                                                  </td>
                                                  <th width="5%">
                                                    <a href="<?= url('Sales/addperfomance/' . $school->id) ?>" class="btn btn-sm btn-success">View</a>
                                                  </th>
                                                </tr>
                                                <?php $i++;}  ?>
                                              </tbody>
                                          
                                          </table>
                                      </div>
                                  </div>
                  
                              </div>
                                                             
                          </div>
                      </div> 
                  </div>
                  <!-- Row end -->
              </div>

          </div>
      </div>
  </div>
</div>

</div>

@endsection

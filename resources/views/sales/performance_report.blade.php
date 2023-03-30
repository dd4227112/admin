@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/';
 $alldata= array('logins','allteachers','allstaffs','allstudents','allparents','allusers','allschools_sms');
?>
<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>


  <div class="page-header">
    <div class="page-header-title">
      <h4>General reports </h4>
    </div>
    <div class="page-header-breadcrumb">
  </div>
</div>

<div class="page-body">
  <div class="row">
      <div class="col-md-12 col-xl-12">
          <div class="card" style="height: 35em"> 
              <div class="card-block tab-icon">
              
                    <div class="col-sm-12">
                        <br>
                            <form class="form-horizontal" role="form" method="post" action="<?= url('allData') ?>"> 
                                  <div class="form-group row">
                                    <div class="col-sm-4">
                                      <label>Select Data </label>
                                      <select name="select" class="form-control select2" id="data_select">
                                        <option value="0">Select</option>
                                        <?php
                                       foreach ($alldata as $value) {
                                            ?>
                                            <option value="<?= $value?>"><?= $value ?></option>
                                        <?php  }
                                        ?>
                                    </select>
                                    </div>
                                   </div>
                                <?= csrf_field() ?>
                            </form>
                       </div>            
                        
                                                                
                          {{-- <ul class="nav nav-tabs md-tabs " role="tablist">
                              <li class="nav-item">
                                  <a class="nav-link active" data-toggle="tab" href="#profile7" role="tab"><i class="icofont icofont-ui-user "></i></a>
                                  <div class="slide"></div>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link" data-toggle="tab" href="#home7" role="tab"><i class="icofont icofont-home"></i></a>
                                  <div class="slide"></div>
                              </li>
                          </ul> --}}
                        
                          <div class="tab-content card-block">
                            <?php if(isset($type) && $type == 'logins') { ?>
                              <div class="tab-pane active" id="profile7" role="tabpanel">
                                 <h4 class="text-center"> All School Logins </h4>
                                  <div class="card-block">
                                      <div class="table-responsive dt-responsive">
                                          <table class="table table-xl table-striped table-bordered  dataTable">
                                              <thead>
                                                <tr>
                                                   <th width="10%">Today</th>
                                                   <th width="10%">This week</th>
                                                   <th width="10%">This month</th>
                                                   <th width="10%">This year</th>
                                                </tr>
                                              </thead>
                                              <tbody> 
                                                <tr>
                                                     <th width="10%"><?= $today->total?></th>
                                                     <th width="10%"><?= $week->total?></th>
                                                     <th width="10%"><?= $month->total?></th>
                                                     <th width="10%"><?= $year->total?></th>
                                                </tr>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                            <?php } elseif(isset($type)  && $type == 'allteachers') { ?>
                                <h4 class="text-center"> All Teachers </h4>
                                  <div class="card-block">
                                      <div class="table-responsive dt-responsive">
                                          <table class="table table-xl table-striped table-bordered  dataTable">
                                              <thead>
                                                <tr>
                                                   <th width="10%">All Teachers</th>
                                                   
                                                </tr>
                                              </thead>
                                              <tbody> 
                                                <tr>
                                                     <th width="10%"><?= $teachers->total ?></th>
                                                </tr>
                                              </tbody>
                                          
                                          </table>
                                      </div>
                                  </div>
                            <?php } elseif(isset($type)  && $type == 'allstaffs') { ?>
                                 <h4 class="text-center"> All Staffs </h4>
                                  <div class="card-block">
                                      <div class="table-responsive dt-responsive">
                                          <table class="table table-xl table-striped table-bordered  dataTable">
                                              <thead>
                                                <tr>
                                                   <th width="10%">All Staffs</th>
                                                   
                                                </tr>
                                              </thead>
                                              <tbody> 
                                                <tr>
                                                     <th width="10%"><?= $allstaffs->total ?></th>
                                                </tr>
                                              </tbody>
                                          
                                          </table>
                                      </div>
                                  </div>
                              <?php }  elseif(isset($type)  && $type == 'allparents') { ?>
                                  <h4 class="text-center"> All Parents </h4>
                                  <div class="card-block">
                                      <div class="table-responsive dt-responsive">
                                          <table class="table table-xl table-striped table-bordered  dataTable">
                                              <thead>
                                                <tr>
                                                   <th width="10%">All Parents</th>
                                                   
                                                </tr>
                                              </thead>
                                              <tbody> 
                                                <tr>
                                                     <th width="10%"><?= $allparents->total ?></th>
                                                </tr>
                                              </tbody>
                                          
                                          </table>
                                      </div>
                                  </div>
                                   <?php } elseif(isset($type)  && $type == 'allstudents') { ?>
                                       <h4 class="text-center"> All Students </h4>
                                  <div class="card-block">
                                      <div class="table-responsive dt-responsive">
                                          <table class="table table-xl table-striped table-bordered  dataTable">
                                              <thead>
                                                <tr>
                                                   <th width="10%">All Students</th>
                                                   <th width="10%">All Male</th>
                                                   <th width="10%">All Female</th>
                                                   
                                                </tr>
                                              </thead>
                                              <tbody> 
                                                <tr>
                                                     <th width="10%"><?= $allstudents->total ?></th>
                                                     <th width="10%"><?= $mstudents->total?></th>
                                                     <th width="10%"><?= $fstudents->total?></th>
                                                </tr>
                                              </tbody>
                                          
                                          </table>
                                      </div>
                                  </div>

                                  <div class="col-md-12">
                                    <h5 class="text-center">Pie chart</h5>
                                    <div class="col-xl-12" style="margin-top: 30px;">
                                      <div class="card">
                                        <div class="card-body">
                                          <div class="chart-container">
                                            <div class="chart has-fixed-height" id="pie_basic"></div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>	
                                  </div>
                               
                               
                                <?php } elseif(isset($type)  && $type == 'allschools_sms') { ?>
                                       <h4 class="text-center"> Schools sms</h4>
                                  <div class="card-block">
                                      <div class="table-responsive dt-responsive">
                                          <table class="table table-xl table-striped table-bordered  dataTable">
                                              <thead>
                                                <tr>
                                                   <th width="10%">Today</th>
                                                   <th width="10%">This Week</th>
                                                   <th width="10%">This Month</th>
                                                   <th width="10%">This Year</th>
                                                </tr>
                                              </thead>
                                              <tbody> 
                                                <tr>
                                                  <th width="10%"><?=$today_sms->total?></th>
                                                  <th width="10%"><?=$week_sms->total?></th>
                                                  <th width="10%"><?=$month_sms->total?></th>
                                                  <th width="10%"><?=$year_sms->total?></th>
                                                </tr>
                                              </tbody>
                                          
                                          </table>
                                      </div>
                                  </div>
                                <?php } elseif(isset($type)  && $type == 'allusers') {  ?>

                                 <h4 class="text-center"> All System Users </h4>
                                  <div class="card-block">
                                      <div class="table-responsive dt-responsive">
                                          <table class="table table-xl table-striped table-bordered  dataTable">
                                              <thead>
                                                <tr>
                                                   <th width="10%">All Students</th>
                                                   <th width="10%">All Parents</th>
                                                   <th width="10%">All staffs</th>
                                                   <th width="10%">All Teachers</th>
                                                   <th width="10%">Total</th>
                                                </tr>
                                              </thead>
                                              <tbody> 
                                                <tr>
                                                  <th width="10%"><?php $a = $allstudents->total; echo number_format($a); ?></th>
                                                  <th width="10%"><?php $b = $allparents->total; echo number_format($b); ?></th>
                                                  <th width="10%"><?php $c = $allstaffs->total; echo number_format($c); ?></th>
                                                  <th width="10%"><?php $d = $teachers->total; echo number_format($d); ?></th> 
                                                  <th width="10%"><?= number_format($a+$b+$c+$d) ?></th> 
                                                </tr>
                                              </tbody>
                                          
                                          </table>
                                      </div>
                                  </div>
                                <?php } ?>


                               {{-- <div class="tab-pane" id="home7" role="tabpanel">
                                  <div class="card-block">
                                      <div class="table-responsive dt-responsive">
                                          <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                              <thead>
                                                <tr>
                                                  <th width="10%">#</th>
                                                 
                                                </tr>
                                              </thead>
                                              <tbody> 
                                            
                                                <tr>
                                                  <th width="10%"></th>
                                                </tr>
                                         
                                              </tbody>
                                          
                                          </table>
                                      </div>
                                  </div>
                              </div> --}}
                                                             
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

<script type="text/javascript">
$(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
});


  $('#data_select').change(function () {
      var value = $(this).val();
      if (value == 0) {
          return false;
      } else {
          window.location.href = "<?= url('sales/allData') ?>/" + value;
      }
  });



  </script>

@endsection

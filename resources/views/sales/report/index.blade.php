@extends('layouts.app')
@section('content')
<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>
<?php  use Carbon\Carbon;
  function check_module($school_id,$month,$user_id,$module_name){
    return \App\Models\PerfomanceMeasures::whereMonth('date', $month)->where(['school_id'=>$school_id,'module'=>$module_name,'user_id'=>$user_id])->first(); 
   // return  DB::table('perfomance_measures')->whereMonth('date', $month)->where('user_id',$user_id)->where('school_id',$school_id)->where('module',$module_name)->get(['module']);
  }
 $root = url('/') . '/public/';  
 $yes =  '<span style="font-size:1rem;"class="label label-info">YES</span>';
 $no =   '<span style="font-size:1rem;"class="label label-danger">NO</span>';
?>



    <div class="page-header">
        <div class="page-header-title">
            <h4>Monthly Perfomances</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">zones</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Perfomances</a>
                </li>
            </ul>
        </div>
    </div>
 
    <div class="page-body">
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="card" > 
                    <div class="card-block tab-icon">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <?php if(isset($name) && isset($month_num)) { ?>
                                <h5> Schools perfomance for  <?=$name?> &nbsp;in <?= date("F", mktime(0, 0, 0, $month_num, 10)) ?> </h5>  
                                <?php } ?>                                     
                                <ul class="nav nav-tabs md-tabs " role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#profile7" role="tab"><i class="icofont icofont-ui-user "></i> Perfomance</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#home7" role="tab"><i class="icofont icofont-home"></i>Zones</a>
                                        <div class="slide"></div>
                                    </li>
                                </ul>
                              
                                     <div class="tab-content card-block">
                                       <div class="tab-pane active" id="profile7" role="tabpanel">
                                          <form action="<?= url('Sales/hrReport') ?>" method="post">
      
                                            <div class="form-group">
                                                <div class="row">
                                                  <div class="col-md-4">
                                                      <strong> School Associate</strong> 
                                                      <select name="user_id" class="form-control select2" required>
                                                          <option> </option>
                                                          <?php
                                                          $user_ids = \App\Models\UsersSchool::get(['user_id']);
                                                          $staffs = DB::table('users')->where('status', 1)->whereIn('id', $user_ids)->where('role_id', '<>', 7)->get();
                                                          foreach ($staffs as $staff) { ?>
                                                              <option value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                                                          <?php } ?>
                                                      </select>
                                                  </div>
  
                                                <div class="col-md-4">
                                                  <strong> Choose month</strong> 
                                                  <select  name="month" class="form-control select2" required>
                                                    <option> </option>
                                                      <?php
                                                      $months = DB::table('constant.months')->get();
                                                      foreach ($months as $month) { ?>
                                                          <option value="<?= $month->id ?>"><?= $month->month_name?></option>
                                                      <?php } ?>
                                                    </select>
                                                </div>
  
                                                <div class="col-md-4">
                                                  <strong> &nbsp;</strong> 
                                                  <div class="mt-6">
                                                     <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                                  </div>
                                                 </div>
                                               </div>
                                              </div>
                                           <?= csrf_field() ?>
                                        </form>


                                        <div class="card-bloc">
                                            <div class="table-responsive dt-responsive">
                                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                      <tr>
                                                        <th width="5%"> School</th>
                                                        <th width="5%"> Exam Published</th>
                                                        <th width="5%"> Payroll</th>
                                                        <th width="5%"> Attendance </th>
                                                        <th width="5%"> Parent login</th>
                                                        <th width="5%"> Fee Collection</th>
                                                        <th width="5%"> Inventory </th>
                                                        <th width="5%"> Library </th>
                                                        <th width="5%"> Staff login</th>
                                                        <th width="5%"> Expenses</th>
                                                        <th width="5%"> Transport</th>
                                                        <th width="5%"> Character</th>
                                                        <th width="5%"> Electronic payment</th>
                                                        <th width="5%"> SMS </th>
                                                        <th width="5%"> Total </th>
                                                      </tr>
                                                    </thead>
                                                    <tbody> 
                                                     <?php $i=1;$total=0;foreach($schools as $school) { ?>
                                                      <tr>
                                                        <td width="10%"><?=$school->name?></td>
                                                        <th width="5%"><?= !empty(check_module($school->id,$month_num,$user_id,'Exam Published')) ?$yes: $no ?></th>
                                                        <th width="5%"> <?= !empty(check_module($school->id,$month_num,$user_id,'Payroll')) ?$yes: $no ?></th>
                                                        <th width="5%"> <?= !empty(check_module($school->id,$month_num,$user_id,'Attendance')) ?$yes: $no ?> </th>
                                                        <th width="5%"> <?= !empty(check_module($school->id,$month_num,$user_id,'Parent Login')) ?$yes: $no ?></th>
                                                        <th width="5%"> <?= !empty(check_module($school->id,$month_num,$user_id,'Fee Collection')) ?$yes: $no ?></th>
                                                        <th width="5%"> <?= !empty(check_module($school->id,$month_num,$user_id,'Inventory')) ?$yes: $no ?> </th>
                                                        <th width="5%"> <?= !empty(check_module($school->id,$month_num,$user_id,'Library')) ?$yes: $no ?> </th>
                                                        <th width="5%"> <?= !empty(check_module($school->id,$month_num,$user_id,'Staff Login')) ?$yes: $no ?></th>
                                                        <th width="5%"> <?= !empty(check_module($school->id,$month_num,$user_id,'Expenses')) ?$yes: $no ?></th>
                                                        <th width="5%"> <?= !empty(check_module($school->id,$month_num,$user_id,'Transport')) ?$yes: $no ?></th>
                                                        <th width="5%"> <?= !empty(check_module($school->id,$month_num,$user_id,'Character')) ?$yes: $no ?></th>
                                                        <th width="5%"> <?= !empty(check_module($school->id,$month_num,$user_id,'Electronic payment')) ?$yes: $no ?></th>
                                                        <th width="5%"> <?= !empty(check_module($school->id,$month_num,$user_id,'SMS')) ?$yes: $no ?> </th>
                                                        <th width="5%"> 
                                                          <?php $sum = \DB::table('monthly_bonus')->whereMonth('date', Carbon::now()->month)->where(['school_id'=>$school->id,'user_id'=>Auth::user()->id])->sum('bonus_amount'); echo money($sum);$total+=$sum; ?>
                                                        </th>
                                                      </tr>
                                                    <?php $i++;} ?>
                                                    </tbody>
                                                    <tfoot>
                                                      <th colspan="14" class="text-right"> SUM</th>
                                                      <th> <?= money($total) ?></th>
                                                    </tfoot>
                                               </table>
                                                 
                                          </div>
                                       </div>

                                    </div>

                                    <div class="tab-pane" id="home7" role="tabpanel">
                                         <div class="card-header">
                                            <h5>Zones belong to shulesoft</h5>
                                         </div>
                                         <div class="card-bloc">
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




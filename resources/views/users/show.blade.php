@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<?php
$arr = [];
foreach ($user_permission as $permis) {
    array_push($arr, $permis->id);
}

function tagEdit($value, $column, $user_id, $absent_id, $type = null) {
      $type = null ? $type = '"text"' : $type = $type;
    if ((int) request('skip') == 1) {
        $return = $value;
    } else {
        $return = '<input required class="text-muted" type="'. $type. '" date="' . $value . '" id="' . $column .$value. '" value="' . date('Y-m-d',strtotime($value)) . '" 
        onblur="edit_records(\'' . $user_id . '\', this.value, \'' .$absent_id . '\')"/>
        <br/>';
    }
    return $return;
  }

?>
<div class="main-body">
    <div class="page-wrapper">
   
          <div class="page-header">
            <div class="page-header-title">
                <h4> <?= $user->name ?? '' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">user</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">profile</a>
                    </li>
                </ul>
            </div>
        </div> 

        <div class="page-body">
            <!--profile cover start-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="row"> 

                       <div class="col-md-6 col-xl-4">
                           <div class="card">
                            <div class="card-block">
                                <img class="img-circle" src="<?= $user->company_file_id !='' ? $user->companyFile->path : $root . 'assets/images/user.png' ?>" alt="round-img" width="40" height="40">
                                <h6 class="text-left mt-2">{{ $user->firstname }} {{ $user->lastname }}</h6> 
                                <p class="text-left text-muted"><?= $user->designation->abbreviation ? $user->designation->name.'  ' . '('.$user->designation->abbreviation.')' : '' ?></p>
                            </div>
                            </div>
                         </div>

                            <?php
                            if (Auth::user()->role_id != 7) { ?>
                            <div class="col-md-6 col-xl-4">
                                <?php $pay = isset($user->salary) ? $user->salary : 1 ?>
                                  <a href="<?= url('payroll/payroll_summary/'.$user->id) ?>">
                                  <div class="card">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h4 class="text-c-green f-w-700">{{ $user->id == \Auth::user()->id  ? number_format($pay) : 0 }} </h4>
                                                <h6 class="text-muted m-b-0">Basic Salary</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <i class="feather icon-user f-30"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-c-blue">
                                        <div class="row align-items-center">
                                            <div class="col-9">
                                                <p class="text-white m-b-0">Monthly basic salary</p>
                                            </div>
                                            <div class="col-3 text-right">
                                                <i class="feather icon-trending-up text-white f-16"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                </a>
                            </div>
                            
                            <div class="col-md-6 col-xl-4">
                                 <?php $month_bonus = 0 ?>
                               
                                    <div class="card">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h4 class="text-c-green f-w-700">{{ number_format($month_bonus)}} </h4>
                                                <h6 class="text-muted m-b-0">This Month Bonus</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <i class="feather icon-user f-30"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-c-green">
                                        <div class="row align-items-center">
                                            <div class="col-9">
                                                <p class="text-white m-b-0">Based on performance</p>
                                            </div>
                                            <div class="col-3 text-right">
                                                <i class="feather icon-trending-up text-white f-16"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>
                            <div class="col-md-6 col-xl-4">
                
                                  <?php $nmb_schools = \DB::table('admin.nmb_schools')->count(); ?>
                                   <div class="card">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h4 class="text-c-green f-w-700">{{ number_format($nmb_schools)}} </h4>
                                                <h6 class="text-muted m-b-0">NMB Schools</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <i class="feather icon-user f-30"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-c-yellow">
                                        <div class="row align-items-center">
                                            <div class="col-9">
                                                <p class="text-white m-b-0">Total Schools with NMB</p>
                                            </div>
                                            <div class="col-3 text-right">
                                                <i class="feather icon-trending-up text-white f-16"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                 <?php $b = \collect(\DB::select('select count(distinct branch) as count from admin.nmb_schools'))->first(); ?>
                            
                                   <div class="card">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h4 class="text-c-green f-w-700">{{ number_format($b->count)}} </h4>
                                                <h6 class="text-muted m-b-0">Branches</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <i class="feather icon-user f-30"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-c-pink">
                                        <div class="row align-items-center">
                                            <div class="col-9">
                                                <p class="text-white m-b-0">Branches with Schools</p>
                                            </div>
                                            <div class="col-3 text-right">
                                                <i class="feather icon-trending-up text-white f-16"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>


            <!--profile cover end-->
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <!-- Nav tabs -->
                
                    <ul class="nav nav-tabs md-tabs tabs-left b-none" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home5" role="tab" aria-expanded="true">Personal Info</a>
                            <div class="slide"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile5" role="tab" aria-expanded="false">Reports</a>
                            <div class="slide"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#messages5" role="tab" aria-expanded="false">Activities</a>
                            <div class="slide"></div>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#attendance" role="tab" aria-expanded="false">Attendance</a>
                            <div class="slide"></div>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#leave" role="tab" aria-expanded="false">Leave/Absent</a>
                            <div class="slide"></div>
                        </li>

                  
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#legal" role="tab" aria-expanded="false">legal/contract</a>
                            <div class="slide"></div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#learning" role="tab" aria-expanded="false">Courses</a>
                            <div class="slide"></div>
                        </li>
                 
                        <?php if (Auth::user()->id == 2) { ?>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#settings5" role="tab">Permissions</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#school_allocations" role="tab" aria-expanded="false">Schools Allocation</a>
                                <div class="slide"></div>
                            </li>
                        <?php } ?>
                    </ul>
                

                    <!-- Tab panes -->
                    <div class="tab-content tabs-left-content card-block" style="width:100%; padding-top: 0; padding-right: 0;">
                        <div class="tab-pane active" id="home5" role="tabpanel" aria-expanded="true">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">About </h5>
                                </div>
                                <div class="card-block">
                                    <div class="view-info">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="general-info">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-xl-6">
                                                            <table class="table m-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">Full Name</th>
                                                                        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Gender</th>
                                                                        <td>{{ $user->sex }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Birth Date</th>
                                                                        <td>{{ date('d-m-Y', strtotime($user->date_of_birth)) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Marital Status</th>
                                                                        <td>{{ $user->marital }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Location</th>
                                                                        <td> {{ $user->town }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th scope="row">Bank name</th>
                                                                        <td> {{ $user->bank_name }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th scope="row">Academic Certificates</th>
                                                                        <td> <?php if($user->academic_certificates == '') { ?>
                                                                          <label class="btn btn-warning btn-mini btn-round"> No Certificates</label>
                                                                      <?php } else { ?> 
                                                                        <a target='_break' href="<?=  $user->academic_certificates ?>" class="btn btn-default btn-mini btn-round"> View Certificate</a>
                                                                      <?php } ?>
                                                                       </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th scope="row">Employment Contract</th>
                                                                        <td> <?php if($user->employment_contract == '') { ?>
                                                                         <label class="btn btn-warning btn-mini btn-round"> No Contract</label>
                                                                      <?php } else { ?> 
                                                                        <a target='_break' href="<?=  $user->employment_contract ?>" class="btn btn-default btn-mini btn-round"> View Contract</a>
                                                                      <?php } ?>
                                                                       </td>

                                                                    </tr>
                                                                     <tr>
                                                                         <td> 
                                                                          <a class="btn btn-primary btn-mini btn-round" data-toggle="modal" data-target="#exampleModalLonguu">
                                                                            Update image 
                                                                          </a>
                                                                        </td>
                                                                         <td>
                                                                         <?php  $reset_url = "users/resetPassword/$user->id"; ?>
                                                                    <a href="<?= url($reset_url) ?>" class="btn btn-warning btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Reset your password">Reset Password  </a>
                                                                         </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- end of table col-lg-6 -->
                                                        <div class="col-lg-12 col-xl-6">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">Email</th>
                                                                        <td style="font-size: 10px;">{{ $user->email }}, <br> {{ $user->personal_email }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Mobile Number</th>
                                                                        <td>{{ $user->phone }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">National ID</th>
                                                                        <td>{{ $user->national_id }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Role</th>
                                                                        <td>{{ $user->role->name ?? '' }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th scope="row"> Designation</th>
                                                                        <td style="font-size:10px;"><?= $user->designation->abbreviation ? $user->designation->name.'  ' . '('.$user->designation->abbreviation.')' : '' ?></td> 
                                                                    </tr>

                                                                    <tr>
                                                                        <th scope="row">Employment Category</th>
                                                                        <td> <?php echo ucfirst($user->employment_category); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Bank Account</th>
                                                                        <td> <?php echo ($user->bank_account); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Medical Report</th>
                                                                        <td> <?php if($user->medical_report == ''){ ?>
                                                                            <label class="btn btn-warning btn-mini btn-round"> No report</label>
                                                                             <?php } else { ?>
                                                                            <a target='_break' href="<?= $user->medical_report?>" class="btn btn-default btn-mini btn-round"> View Report</a>
                                                                             <?php } ?>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                       <?php if(can_access('update_designation')) { ?>
                                                                        <td> 
                                                                          <a class="btn btn-primary btn-mini btn-round text-light" data-toggle="modal" data-target="#exampleModalLong">
                                                                            Update designation 
                                                                          </a>
                                                                        </td>
                                                                      <?php } ?>
                                                     
                                                                       <?php if(can_access('remove_user')) { ?>
                                                                        <td> 
                                                                          <a class="btn btn-danger btn-mini btn-round text-light" data-toggle="modal" data-target="#exampleModaldelete">
                                                                            DELETE USER
                                                                          </a>
                                                                        </td>
                                                                      <?php } ?>
                                                                    </tr>
                                                                    
                                                              

                                                                <div class="modal fade" id="exampleModalLonguu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                                 <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Update profile</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form class="form-horizontal form-material" method="post" action="<?= url('users/changePhoto/' . $user->id) ?>" enctype="multipart/form-data">
                                                                        <div class="form-group ">
                                                                            <label for="cname" class="control-label col-lg-3">Image</label>
                                                                            <div class="col-lg-12">
                                                                               <input type="file" name="photo" accept=".png,.jpg,.jpeg,.gif" class="form-control form-control-line" required>
                                                                            </div>
                                                                        </div>
                                                                      
                                                                      <div class="modal-footer">
                                                                        <input type="hidden" value="<?=$user->id?>" name="user_id">
                                                                        <button type="button" class="btn btn-default btn-mini btn-round" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary btn-mini btn-round">Save</button>
                                                                      </div>
                                                                      <?= csrf_field() ?>
                                                                    </form>
                                                                    </div>
                                                                 </div>
                                                                </div>
                                                             </div>
                                                              
                                                              
                                                             <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                                 <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Update Designation</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                       <form method="post" action="<?= url('users/updateDesignation') ?>"> 
                                                                        <div class="form-group">
                                                                            <label  class="control-label col-lg-6">Choose company designation</label>
                                                                            <div class="col-lg-12">
                                                                                <select name="designation_id"  class="form-control">
                                                                                    <option>choose </option>
                                                                                    <?php
                                                                                    $designations = \App\Models\ReferDesignation::all();
                                                                                    foreach ($designations as $designation) {
                                                                                        ?>
                                                                                        <option value="<?= $designation->id ?>"><?= $designation->name ?></option>
                                                                                    <?php }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group ">
                                                                            <label for="cname" class="control-label col-lg-3">Name</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" disabled value="<?=$user->name?>" name="" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                      
                                                                      <div class="modal-footer">
                                                                        <input type="hidden" value="<?=$user->id?>" name="user_id">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                                      </div>
                                                                      <?= csrf_field() ?>
                                                                    </form>
                                                                    </div>
                                                                 </div>
                                                                </div>
                                                             </div>


                                                            <div class="modal fade" id="exampleModaldelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                                 <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Remove user</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                       <form method="post" action="<?= url('users/destroy') ?>"> 
                                                                        <div class="form-group">
                                                                            <label  class="control-label col-lg-6">Provide reason</label>
                                                                            <div class="col-lg-12">
                                                                                <select name="reason_id"  class="form-control">
                                                                                    <option>choose </option>
                                                                                    <?php
                                                                                    $reasons = DB::table('admin.leave_reasons')->get();
                                                                                    foreach ($reasons as $reason) {
                                                                                        ?>
                                                                                        <option value="<?= $reason->id ?>"><?= $reason->reason_name ?></option>
                                                                                    <?php }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

        
                                                                      <div class="modal-footer">
                                                                        <input type="hidden" value="<?=$user->id?>" name="user_id">
                                                                        <button type="button" class="btn btn-default btn-mini btn-round" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary btn-mini btn-round">Submit</button>
                                                                      </div>
                                                                      <?= csrf_field() ?>
                                                                    </form>
                                                                    </div>
                                                                 </div>
                                                                </div>
                                                             </div>
                      


                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- end of table col-lg-6 -->
                                                    </div>
                                                    <!-- end of row -->
                                                </div>
                                                <!-- end of general info -->
                                            </div>
                                            <!-- end of col-lg-12 -->
                                        </div>
                                        <!-- end of row -->
                                    </div>
                                    <!-- end of view-info -->
                                    <div class="edit-info" style="display: none;">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="general-info">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"><i class="icofont icofont-user"></i></span>
                                                                                <input type="text" class="form-control" placeholder="Full Name">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-radio">
                                                                                <div class="group-add-on">
                                                                                    <div class="radio radiofill radio-inline">
                                                                                        <label>
                                                                                            <input type="radio" name="radio" checked=""><i class="helper"></i> Male
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="radio radiofill radio-inline">
                                                                                        <label>
                                                                                            <input type="radio" name="radio"><i class="helper"></i> Female
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <input id="dropper-default" class="form-control" type="text" placeholder="Select Your Birth Date">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <select id="hello-single" class="form-control">
                                                                                <option value="">---- Marital Status ----</option>
                                                                                <option value="married">Married</option>
                                                                                <option value="unmarried">Unmarried</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"><i class="icofont icofont-location-pin"></i></span>
                                                                                <input type="text" class="form-control" placeholder="Address">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- end of table col-lg-6 -->
                                                        <div class="col-lg-6">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"><i class="icofont icofont-mobile-phone"></i></span>
                                                                                <input type="text" class="form-control" placeholder="Mobile Number">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"><i class="icofont icofont-social-twitter"></i></span>
                                                                                <input type="text" class="form-control" placeholder="Twitter Id">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon" id="basic-addon1">@</span>
                                                                                <input type="text" class="form-control" placeholder="Twitter Id">
                                                                            </div>
                                                                        </td>
                                                                    </tr> -->
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"><i class="icofont icofont-social-skype"></i></span>
                                                                                <input type="email" class="form-control" placeholder="Skype Id">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"><i class="icofont icofont-earth"></i></span>
                                                                                <input type="text" class="form-control" placeholder="website">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- end of table col-lg-6 -->
                                                    </div>
                                                    <!-- end of row -->
                                                    <div class="text-center">
                                                        <a href="#!" class="btn btn-primary waves-effect waves-light m-r-20">Save</a>
                                                        <a href="#!" id="edit-cancel" class="btn btn-default waves-effect">Cancel</a>
                                                    </div>
                                                </div>
                                                <!-- end of edit info -->
                                            </div>
                                            <!-- end of col-lg-12 -->
                                        </div>
                                        <!-- end of row -->
                                    </div>
                                    <!-- end of edit-info -->
                                    
                                
                                </div>
                                <!-- end of card-block -->
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Description About Me</h5>
                                            <?php $url_edit = "users/edit/$user->id"; ?>
                        
                                        <a href="<?= url($url_edit) ?>" class="btn btn-info btn-mini  btn-round float-right" data-placement="top"  data-toggle="tooltip" data-original-title="Edit user data">Edit  </a>
                                         

                                        </div>
                                        <div class="card-block user-desc">
                                            <div class="view-desc">
                                                <p><?= $user->about ?></p>
                                                <hr />
                                                <b>Skills: <?php echo $user->skills; ?></b>
                                            </div>
                                            <div class="edit-desc" style="display: none;">
                                                <div class="col-md-12">
                                                    <textarea id="description" style="visibility: hidden;">&lt;p&gt;But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?" "On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able To Do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pain.&lt;/p&gt;
                                                    </textarea>
                                                </div>
                                                <div class="text-center">
                                                    <a href="#!" class="btn btn-primary waves-effect waves-light m-r-20 m-t-20">Save</a>
                                                    <a href="#!" id="edit-cancel-btn" class="btn btn-default waves-effect m-t-20">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Job Application Details</h5>

                                        </div>
                                        <div class="card-block user-desc">
                                            <?php
                                            $except = array('id', 'updated_at');
                                            $applicant = (int) $user->applicant_id > 0 ? DB::table('applicants')->where('id', $user->applicant_id)->first() : [];
                                            if ($applicant) {
                                                $vars = get_object_vars($applicant);

                                                ?>
                                                <div class="view-desc">
                                                    <table class="table">
                                                        <?php
                                                        foreach ($vars as $key => $value) {
                                                            if (!in_array($key, $except)) {
                                                                ?> 
                                                                <tr>
                                                                    <td><?= ucwords(str_replace('_', ' ', $key)) ?></td>
                                                                    <td>
                                                                        <?php
                                                                        $content = $applicant->{$key};
                                                                        if (preg_match('/https/', $content)) {
                                                                            echo '<a href="' . $content . '" target="_blank">' . $content . '</a>';
                                                                        } else if (preg_match('/-/', $content)) {
                                                                            $pieces = explode('-', $content);
                                                                            foreach ($pieces as $piece) {
                                                                                echo $piece . '<br/>';
                                                                            }
                                                                        } else {
                                                                            echo $content;
                                                                        }
                                                                        ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </table>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">User QR CODE</h5>
                                </div>
                                <div class="card-block">
                                    <form>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <?php $qr_code =  "QrCode/generate_qr_code/$user->email"; ?>
                                                <a href="<?= url($qr_code) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Generate qr code">qr code  </a>
                                                 

                                            </div>
                                            <?php if ($user->qr_code != '') { ?>
                                                <div class="col-sm-2">
                                                    <a href="<?= $root ?><?= $user->qr_code ?>" class="btn btn-success">Download</a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </form>
                                    <div>
                                        <?php if ($user->qr_code != '') { ?>
                                            <img src="<?= $root ?><?= $user->qr_code ?>" alt="">
                                            <bt>

                                            <?php } ?>
                                    </div>
                                </div>

                                <br />
                                <div class="card-block">

                                    <div id="report_section">

                                    </div>
                                </div>
                            </div>
                            <!-- personal card end--> 
                        </div>

                        <div class="tab-pane" id="profile5" role="tabpanel" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Custom Reports</h5>
                                        </div>
                                        <div class="card-block">
                                      
                                        <div class="table-responsive dt-responsive">
                                        <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                            <thead>
                                            <tr>
                                                <th>Id </th>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Value</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                          
                                            </tbody>

                                        </table>
                                        </div>

                                        </div>
                                        <br />
                                        <div class="card-block">
                                            <div id="report_section"></div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="tab-pane" id="messages5" role="tabpanel" aria-expanded="false">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Activities</h5>
                                </div>
                                <div class="card-block">

                                </div>
                            </div>   </div>
                        <div class="tab-pane" id="attendance" role="tabpanel" aria-expanded="false">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-header-text">Attendance</h5>
                                    </div>
                                    <div class="col-lg-12">
                                        <br/>
                                        <?php
                                        if ($user->id == Auth::user()->id) {?>
                                            <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#large-Modal"><i class="fa fa-plus"></i>Add Attendance</button>
                                        <?php } ?>
                                        
                                        <div class="table-responsive dt-responsive">
                                        <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Arrival Time</th>
                                                        <th>Late Comer Reaons</th>
                                                        <th>Departue Time</th>
                                                        <th>Early Departue Reason</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <?php  if(sizeof($attendances) > 0) {  ?>
                                                    <?php foreach ($attendances as $attendance) { ?>
                                                        <tr>
                                                            <td><?= date('d M Y', strtotime($attendance->created_at)) ?></td>
                                                            <td><?= $attendance->status == 1 ? 'Present' : 'Absent' ?></td>
                                                            <td><?= date('Y', strtotime($attendance->timein)) > 1970 ? date('h:i', strtotime($attendance->timein)) : '' ?></td>
                                                            <td><?= $attendance->late_comment ?></td>
                                                            <td><?= date('Y', strtotime($attendance->timeout)) > 1970 ? date('h:i', strtotime($attendance->timeout)) : '' ?></td>
                                                            <td><?= $attendance->early_leave_comment ?></td>
                                                            <td>
                                                                {{-- <a href="<?= url('users/leave') ?>">Leave the Office</a> --}}
                                                                <?php
                                                                if (date('H', strtotime(timeZones(date('Y-m-d H:i:s')))) > 17 && date('Y', strtotime($attendance->timeout)) > 1970) {
                                                                    ?>
                                                                    <a href="<?= url('users/leave') ?>">Leave the Office</a>

                                                                <?php } else if (date('H', strtotime(timeZones(date('Y-m-d H:i:s')))) < 17 && date('Y', strtotime($attendance->timeout)) > 1970) { ?>
                                                                    <a  href="#" class="text-danger waves-e" data-toggle="modal" data-target="#early-large-Modal">Early Leave</a>
                                                                    <?php
                                                                }
                                                                ?>

                                                            </td>
                                                        </tr>
                                                      <?php } ?>
                                                     <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div></div>   </div>

                             <div class="tab-pane" id="leave" role="tabpanel" aria-expanded="false">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-header-text">Leave/Absent</h5>
                                        <button type="button" class="btn btn-primary btn-mini btn-round float-right" data-toggle="modal" data-target="#leave-large-Modal">Add Leave</button>
                                    </div>

                                        <div class="card-block">
                                           
                                           <div class="table-responsive dt-responsive">
                                           <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Absent Type</th>
                                                        <th>Note</th> 
                                                        <th>Leave Attachment</th>
                                                        <th>Approved By</th>
                                                        <th>End date</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                 
                                                      <?php if(count ($absents) > 0) 
                                                             foreach($absents as $absent) { ?>
                                                        <tr>
                                                            <td><?= date('d M Y', strtotime($absent->date)) ?></td>
                                                            <td><?= $absent->absentReason->name ?></td>
                                                            <td><?= warp($absent->note,20) ?></td>
                                                            <td class="text-center">
                                                                <a type="button" class="btn btn-primary btn-mini btn-round" target="_blank" href="<?= url('customer/viewContract/' . $absent->id .'/absent') ?>">View</a>
                                                            </td>
                                                            <td><?= $absent->approvedBy->name ?></td>
                                                            <td>
                                                                {{-- <?= isset($absent->end_date) ? date('d M Y', strtotime($absent->end_date)) : '' ?> --}}

                                                                <?php if(can_access('edit_leave_dates'))  { ?>
                                                                      <?= tagEdit($absent->end_date, 'end_date', $user->id,$absent->id); ?>
                                                                 <?php } else { ?>
                                                                      <?= date('d-m-Y', strtotime($absent->end_date)) ?>
                                                                 <?php } ?>
                                                            </td>
                                                            <td>
                                                                <div class="dropdown-secondary dropdown f-right">
                                                                    <button class="btn btn-success btn-mini dropdown-toggle waves-effect waves-light" type="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                     {{-- <a class="dropdown-item waves-light waves-effect" href="<?= url('users/askleave/'.$absent->id.'/edit') ?>"><span class="point-marker"></span>Edit</a> --}}

                                                                      <?php if ($absent->status == null) { ?>
                                                                         <?php if(can_access('approve_leave')) { ?>
                                                                         <?php $app_url = "users/askleave/$absent->id/approve"; $rej_url = "users/askleave/$absent->id/reject"; ?>
                                                                          
                                                                          <a href="<?= url($app_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Approve">Approve  </a>
                                                                          <a href="<?= url($rej_url) ?>" class="btn btn-warning btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Reject">Reject  </a>

                                                                        <?php } ?>
                                                                     <?php } else if($absent->status == 'Approved') { ?>
                                                                        <a  class="badge badge-info badge-sm"> <?=$absent->status?> </a>
                                                                     <?php } else { ?>
                                                                        <a  class="badge badge-danger badge-sm"> <?=$absent->status?> </a>
                                                                     <?php } ?>
                                                                   </div>
                                                                </div>

                                                            </td>
                                                        </tr>
                                                      <?php } ?>
                                                  
                                                </tbody>
                                            </table>
                                        </div>
                                      </div>
                                    </div>
                             </div>

                             <div class="tab-pane" id="legal" role="tabpanel" aria-expanded="false">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Legal/contract</h5>
                                            <button type="button" class="btn btn-primary btn-mini btn-round float-right" data-toggle="modal" data-target="#legal-large-Modal">Add Legal/Contract</button>

                                        </div>
                                        <div class="col-lg-12">
                                            <div class="card-block">
                                              
                                              <div class="table-responsive dt-responsive">
                                                 <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Start date</th>
                                                            <th>End date</th>
                                                            <th>Description</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php  if(count($documents) > 0) 
                                                        foreach ($documents as $document) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $document->name ?></td>
                                                                <td><?= date('d-m-Y', strtotime($document->start_date)) ?></td>
                                                                <td> {{ date('d-m-Y', strtotime($document->end_date)) ?? '' }}</td>
                                                                <td><?= $document->description?></td>
                                                                <td>
                                                                    <a type="button" class="btn btn-primary btn-mini btn-round" target="_blank" href="<?= url('customer/viewcontract/' . $document->id . '/legal') ?>">View</a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                           </div>
                                        </div>
                                    </div>
                                   </div>  
                                 </div>


                                 <div class="tab-pane" id="learning" role="tabpanel" aria-expanded="false">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-header-text">Courses</h5>
                                                <button type="button" class="btn btn-primary btn-mini btn-round float-right" data-toggle="modal" data-target="#learning-large-Modal">Learning</button>
                                            </div>
                                            <div class="col-lg-12">
        
                                                <div class="card-block">
                                                   
                                               <div class="table-responsive dt-responsive">
                                                  <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Course Name</th>
                                                                <th>Start date</th>
                                                                <th>End date</th>
                                                                <th>Source</th>
                                                                <th>View</th>
                                                               
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                         <?php  if(count($learnings) > 0) { ?>
                                                             <?php $i=1; foreach ($learnings as $learning) {
                                                                ?>
                                                                <tr>
                                                                    <td><?= $i?></td>
                                                                    <td><?= $learning->course_name ?></td>
                                                                    <td><?= date('d-m-Y', strtotime($learning->from_date)) ?></td>
                                                                    <td><?= date('d-m-Y', strtotime($learning->to_date)) ?></td>
                                                                    <td> {{ $learning->source ?? '' }}</td>
                                                                    <td>
                                                                        <?php $v_url = "users/learning/$learning->id"; ?>
                                                                          <a href="<?= url($v_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="View">View  </a>
                                                                    </td>
                                                                </tr>
                                                              <?php $i++;} ?>
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


            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="large-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <form class="cmxform form-horizontal " id="commentForm" method="post" action="#">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Attendance</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-3">Time In</label>
                        <div class="col-lg-12">
                            <input class="form-control" id="cname" name="timein" disabled value="<?= date('H:i', strtotime(timeZones(date('Y-m-d H:i:s')))) ?>"  type="time">
                        </div>
                    </div>

                    <?php
                    if (date('H', strtotime(timeZones(date('Y-m-d H:i:s')))) > 8) {
                        ?>
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-3"> Late Coming Reasons</label>
                            <div class="col-lg-12">
                                <textarea class=" form-control" id="abbrname" name="late_comment" type="text" required=""></textarea>
                            </div>
                        </div>
                    <?php } ?> 
                </div>
                <div class="modal-footer">
                    <?= csrf_field() ?>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="early-large-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <form class="cmxform form-horizontal " id="commentForm" method="post" action="#">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Early Leave </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-3">Current Time</label>
                        <div class="col-lg-12">
                            <input class="form-control" id="cname" name="timein" disabled="" value="<?= date('H:i', strtotime(timeZones(date('Y-m-d H:i:s')))) ?>"  type="time">
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-3">Early Leave Reasons</label>
                        <div class="col-lg-12">
                            <textarea class=" form-control" id="abbrname" name="early_leave_comment" type="text" required=""></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= csrf_field() ?>
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>


<div class="modal fade" id="leave-large-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <form class="cmxform form-horizontal " id="commentForms" action="<?= url('users/absent') ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Absent Registration  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="cname" class="control-label col-lg-3">Absent Reason</label>
                        <div class="col-lg-12">
                            <select name="absent_reason_id" class=" select2 category_id">
                                <?php
                                $ctypes = DB::table('admin.absent_reasons')->get();
                                if (!empty($ctypes)) {
                                    foreach ($ctypes as $ctype) {
                                        ?>
                                        <option value="<?= $ctype->id ?>"><?= $ctype->name ?></option>
                                        <?php
                                      }
                                   }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                       <div class="col-sm-4">
                         <label class="control-label">Start </label>
                          <div class="col-lg-12">
                            <input class="form-control"  name="date"   value="<?= date('Y-m-d') ?>"  type="date" 
                              required>
                          </div>
                       </div>
                      
                       <div class="col-sm-4">
                        <label class="control-label"> End</label>
                        <div class="col-lg-12">
                            <input class="form-control" name="end_date"  type="date">
                        </div>
                       </div>

                       {{-- <div class="col-sm-6">
                        <label class="control-label"> Start and End date</label>
                          <div class="col-lg-12">
                             <input type="text" class="form-control" name="datetimes" />
                          </div>
                        </div> --}}
                    </div>

                    <div class="form-group">
                        <label for="cname" class="control-label col-lg-3">Description</label>
                        <div class="col-lg-12">
                            <textarea class=" form-control"  name="note" type="text"></textarea>
                        </div>
                    </div>

              
                    <div class="form-group row">
                        <div class="col-sm-6"  id="dates">
                            <label class="control-label">Sick Leave document</label>
                             <div class="col-lg-12">
                                <a href="https://drive.google.com/file/d/1YhpG4g9OSsylI6aM6SJZw7zZVa7iZYTc/view" target="_blank" class="badge badge-warning badge-sm"> Download </a> 
                             </div>
                          </div>

                          <div class="col-sm-6">
                            <label class="control-label">Upload Document</label>
                             <div class="col-lg-12">
                                <input type="file" class="form-control" accept=".pdf" name="file">
                             </div>
                          </div>
                     </div>

                </div>
                <div class="modal-footer">
                    <?= csrf_field() ?>
                    <input type="hidden" value="<?= $user->id ?>" name="user_id"/>
                    <button type="button" class="btn btn-default btn-mini btn-round" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-mini btn-round">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>





<div class="modal fade" id="legal-large-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <form class="cmxform form-horizontal " id="commentForms" action="<?= url('users/legalcontract') ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Legal/Contract  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cname" class="control-label col-lg-3">Contract/Legal name</label>
                        <div class="col-lg-12">
                            <input class="form-control"  name="contract_legal"   type="text">
                        </div>
                    </div>

                    <div class="form-group row">
                       <div class="col-sm-6">
                         <label class="control-label">Start date</label>
                          <div class="col-lg-12">
                            <input class="form-control"  name="start_date"   type="date">
                          </div>
                       </div>
                      
                       <div class="col-sm-6">
                        <label class="control-label">End date</label>
                        <div class="col-lg-12">
                            <input class="form-control" name="end_date"   type="date">
                        </div>
                       </div>
                    </div>

                    <div class="form-group">
                        <label for="cname" class="control-label col-lg-3">Description</label>
                        <div class="col-lg-12">
                            <textarea class=" form-control"  name="description" type="text" required=""></textarea>
                        </div>
                    </div>

              
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="control-label">Upload Document</label>
                             <div class="col-lg-12">
                                <input type="file" class="form-control" accept=".pdf" name="file">
                             </div>
                          </div>
                     </div>
                </div>

                <div class="modal-footer">
                    <?= csrf_field() ?>
                    <input type="hidden" value="<?= $user->id ?>" name="user_id"/>
                    <button type="button" class="btn btn-default btn-mini btn-round" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary  btn-mini btn-round">Save </button>
                </div>
            </div>
        </div>
    </form>
</div>




<div class="modal fade" id="learning-large-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <form class="cmxform form-horizontal " id="commentForms" action="<?= url('users/learning') ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Course </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                     <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="control-label col-lg-3">Course</label>
                             <div class="col-lg-12">
                               <input class="form-control"  name="course_name"   type="text">
                             </div>
                          </div>
                         
                          <div class="col-sm-6">
                           <label class="control-label">Source</label>
                             <div class="col-lg-12">
                               <input class="form-control"  name="source"   type="text">
                             </div>
                          </div>
                      </div>


                     <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="control-label col-lg-3">Url link</label>
                             <div class="col-lg-12">
                               <input class="form-control"  name="link"   type="url">
                             </div>
                          </div>
                         
                          <div class="col-sm-6">
                           <label class="control-label">Has certificate</label>
                             <div class="col-lg-12">
                                YES: <input type="radio" name="has_certificate" value="1" /> &nbsp;&nbsp;&nbsp;
                                No: <input type="radio" name="has_certificate" value="0"/>
                           </div>
                          </div>
                      </div>


                    <div class="form-group row">
                       <div class="col-sm-6">
                         <label class="control-label">Start date</label>
                          <div class="col-lg-12">
                            <input class="form-control"  name="from_date"   type="date">
                          </div>
                       </div>
                      
                       <div class="col-sm-6">
                        <label class="control-label">End date</label>
                        <div class="col-lg-12">
                            <input class="form-control" name="to_date"   type="date">
                        </div>
                       </div>
                    </div>

                    <div class="form-group">
                        <label for="Description" class="control-label col-lg-3">Description</label>
                        <div class="col-lg-12">
                            <textarea class=" form-control"  name="description" type="text" required=""></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <?= csrf_field() ?>
                    <input type="hidden" value="<?= $user->id ?>" name="user_id"/>
                    <button type="button" class="btn btn-default btn-mini btn-round" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-mini btn-round">Save </button>
                </div>
            </div>
        </div>
    </form>
</div>



<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
                        
$(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
  });


  edit_records = function (tag, val, absent_id) {
        $.get('<?= url('users/editLeaveDates/null') ?>', {absent_id: absent_id, val: val, tag: tag}, function (data) {
            $('#status_' + tag + val).html('<label class="badge badge-success">'+data+'</label>');
            toastr.success(data);
        });
    };



$(function() {
  $('input[name="datetimes"]').daterangepicker({
    timePicker: true,
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      format: 'Y/m/d hh:mm:ss'
    }
  });
});


    permission = function () {
        $('.permission').click(function () {
            var id = $(this).val();
            var role_id = '<?= $user->role_id ?>';
            if (parseInt(id)) {
                if (!this.checked) {
                    // It is not checked, show your div...
                    var url_obj = "<?= url('Users/removePermission') ?>";
                } else {
                    var url_obj = "<?= url('Users/addPermission') ?>";
                }
                $.ajax({
                    type: 'POST',
                    url: url_obj,
                    data: {
                        "id": id,
                        role_id: role_id
                    },
                    dataType: "html",
                    success: function (data) {
                        toast(data);
                    }
                });
            }
        });
    }
    $(document).ready(permission);
    search_report = function () {
        $('#search_report').mousedown(function () {
            var from = $('#from').val();
            var to = $('#to').val();
            $.ajax({
                type: 'POST',
                url: "<?= url('users/report') ?>",
                data: {
                    "from": from,
                    to: to,
                    user_id: <?= $user->id ?>
                },
                dataType: "html",
                success: function (data) {
                    $('#report_section').html(data);
                }
            });
        })
    };
    search_district = function () {
        $('#search_regions').change(function () {
            var region_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: "<?= url('background/searchDistrict') ?>",
                data: {
                    "region_id": region_id,
                    user_id: <?= $user->id ?>
                },
                dataType: "html",
                success: function (data) {
                    $('#search_district').html(data);
                }
            });
        })
    };

    search_wards = function () {
        $('#search_district').change(function () {
            var district_id = $(this).val();

            $.ajax({
                type: 'POST',
                url: "<?= url('background/searchWard') ?>",
                data: {
                    "district_id": district_id,
                    user_id: <?= $user->id ?>
                },
                dataType: "html",
                success: function (data) {
                    $('#search_ward').html(data);
                }
            });
        })
    };
    $(document).ready(search_wards);
    $(document).ready(search_district);
    $(document).ready(search_report);
</script>
     
     <div class="modal fade" id="status-Modal">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add-form" action="{{ url('users/userUpload') }}" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Members</h5>
                    <a href="<?= url('public/sample_files/users.csv') ?>"> <u><b>Download Sample</b></u> </a>
                </div>
                <div class="modal-body">
                    <p>Import users from a CSV file. In Excel, add all required column of  New Users, and save the file in a CSV format. Click A CSV file, then drag and drop your .csv file, or click choose file to browse files on your computer. Then click <b>Submit. <br>  <br> #Remember to Remove First Row.</b></p>
                    <div class="form-group">
                        <label>Attach File Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-file"></i>
                                </div>
                            </div>
                            <input type="file" class="form-control" placeholder="Enter group name..." name="user_file" required>
                        </div>
                    </div>
                    <!-- </div> -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                    </form>
           </div>
     </div>

    </div>
    @endsection
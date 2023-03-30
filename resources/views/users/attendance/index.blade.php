@extends('layouts.app')
@section('content')
        <div class="page-header">
            <div class="page-header-title">
                <h4>Employees Attendances</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Attendance</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Operations</a>
                    </li>
                </ul>
            </div>
        </div> 
   
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
           <div class="card">
            <div class="card-block">
               
              <div class="row">
                 <div class="col-sm-12">
                  <div class="card-header float-left">
                    <a href="<?= url('attendance/add') ?>" class="btn btn-sm btn-primary btn-round">Create</a>
                </div> 
                <div class="card-header float-right">
                    <a href="<?= url('attendance/report') ?>" class="btn btn-sm btn-primary btn-round">View Report</a>
                </div> 

                <?php if(can_access('attendance_hr_report')) { ?>
                 <div class="card-header float-right">
                    <a href="<?= url('attendance/hr_report') ?>" class="btn btn-sm btn-primary btn-round">HR Report</a>
                </div> 
                <?php } ?>

               </div>  
              </div>  
    
                  <div class="">
                    <table id="dt-ajax-array" class="table dataTable table-mini table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th># </th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Role </th>
                          <th>SID </th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php  $i = 1; if(!empty($users)){
                        foreach($users as $user){ ?>
                      <tr>
                          <td><?=$i++?> </td>
                          <td><?=$user->firstname. ' ' .$user->lastname ?></td>
                          <td><?=$user->phone ?></td>
                          <td><?=$user->email ?></td>
                          <td><?=$user->role->display_name ?></td>
                          <td><?=$user->sid ?></td>
                          <td class="text-center">
                            <a class="btn btn-primary btn-mini btn-round" href="{{ url('attendance/index/'.$user->id) }}">View </a>
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
    </div>
  </div>
</div>


@endsection

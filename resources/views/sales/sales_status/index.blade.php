@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>



       
      <div class="page-header">
            <div class="page-header-title">
                <h4><?=' Sales status' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">status</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 

      <div class="card">
            <div class="row">
                <div class="col-sm-12 col-lg-3 m-b-20">
                    <h6>Pick date </h6>
                    <input type="text" name="dates" id="rangeDate" class="form-control">
                </div>
                
                <div class="col-sm-12 col-lg-3 m-b-20">
                    <h6> &nbsp; </h6>
                    <select class="form-control" name="choose" id="choose" >
                    <option value="All"> All</option>
                    <option value="Mine"> Mine</option>
                    </select>
                </div>
                <div class="col-sm-12 col-lg-3 m-b-20">
                    <h6> &nbsp; </h6>
                    <input type="submit" id="search_custom" class="input-sm btn btn-mini btn-primary btn-round">
                </div>
            </div>
                        
                
                <div class="col-lg-12 col-xl-12">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs  tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">All Schools</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#New" role="tab"> <i class="ti-plus"> </i> New</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#Pipeline" role="tab">  <i class="ti-bell"> </i>Pipeline </a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#Closed" role="tab">  <i class="ti-check"> </i> Closed </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#profile1" role="tab">  <i class="ti-layout-cta-right"> </i> Reports</a>
                                </li>
                                <li class="nav-item" style="float:right;">
                                    <a class="nav-link" href="<?=url('Sales/addLead')?>" role="tab"><b>  <i class="ti-pencil"> </i> Add New </b></a>
                                </li>

                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content tabs card-block">
                                <div class="tab-pane active" id="home1" role="tabpanel">
                                    <div class="card-block">

                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Schools</th>
                                                        <th>Region</th>
                                                        <th>End Date</th>
                                                        <th>TaskType</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1; 
                                                if (sizeof($schools) > 0) { 
                                                    foreach ($schools as $school){
                                                        $check = \App\Models\TaskSchool::where('task_id', $school->id)->first();
                                                          // dd($check);
                                                        if(!empty($check)){
                                                            ?>
                                                  <tr>
                                                  <td><?=$i++?></td>
                                                  <td><?=$check->school->name?></td>
                                                  <td><?=$check->school->region?></td>
                                                  <td><?=$school->end_date?></td>
                                                  <td><?= isset($school->type) ? $school->type : '' ?></td>
                                                  <td><?=$school->next_action?></td>
                                                  <td> 
                                                  <?php
                                                   if($check->school->schema_name != ''){
                                                    echo '<a href="'. url('customer/profile/'.$check->school->schema_name) .'" class="btn btn-success btn-sm"> View Client </a>';
                                                }else{
                                                    echo '<a href="'. url('sales/profile/'.$check->school_id) .'" class="btn btn-info btn-sm"> View Profile</a>';
    
                                                }
                                                  ?>
                                                  </td>
                                                </tr>
                                                  <?php } else{
                                                       $check_task = \App\Models\TaskClient::where('task_id', $school->id)->first();
                                                       if(!empty($check_task)){
                                                 ?>
                                                    <tr>
                                                  <td><?=$i++?></td>
                                                  <td><?=$check_task->client->name?></td>
                                                  <td><?=$check_task->client->phone?></td>
                                                  <td><?=$school->end_date?></td>
                                                  <td><?=isset($school->type) ? $school->type : ''?></td>
                                                  <td><?=$school->next_action?></td>
                                                  <td> 
                                                  <?php
                                                   if($check_task->client->username != ''){
                                                    echo '<a href="'. url('customer/profile/'.$check_task->client->username) .'" class="btn btn-success btn-sm"> View Client </a>';
                                                }else{
                                                    echo '<a href="'. url('sales/profile/'.$school->id) .'" class="btn btn-info btn-sm"> View Profile</a>';
                                                }
                                                  ?>
                                                  </td>
                                                </tr>
                                                  <?php
                                                        } 
                                                    }
                                                    }
                                                }
                                                  ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Schools </th>
                                                        <th>Region</th>
                                                        <th>End Date</th>
                                                        <th>Status</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Completed Tasks -->
                                <div class="tab-pane" id="Closed" role="tabpanel">
                                
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Schools </th>
                                                        <th>Region</th>
                                                        <th>End Date</th>
                                                        <th>TaskType</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1;
                                                if (sizeof($closeds) > 0) {
                                                    foreach ($closeds as $school){
                                                        $check_task = \App\Models\TaskClient::where('task_id', $school->id)->first();
                                                        if(!empty($check_task)){
                                                     ?>
                                                  <tr>
                                                  <td><?=$i++?></td>
                                                  <td><?=$check_task->client->name?></td>
                                                  <td><?=$check_task->client->phone?></td>
                                                  <td><?=$school->end_date?></td>
                                                  <td><?=$school->tasktype->name?></td>
                                                  <td><?=$school->next_action?></td>
                                                  <td> 
                                                  <?php
                                                   if($check_task->client->username != ''){
                                                    echo '<a href="'. url('customer/profile/'.$check_task->client->username) .'" class="btn btn-success btn-sm"> View Client </a>';
                                                }else{
                                                    echo '<a href="'. url('sales/profile/'.$school->id) .'" class="btn btn-info btn-sm"> View Profile</a>';
    
                                                }
                                                  ?>
                                                  </td>
                                                </tr>
                                                  <?php } else{ 
                                                    $check = \App\Models\TaskSchool::where('task_id', $school->id)->first();
                                                    if(!empty($check)){
                                                    ?>
                                                      <tr>
                                                      <td><?=$i++?></td>
                                                      <td><?=$check->school->name?></td>
                                                      <td><?=$check->school->phone?></td>
                                                      <td><?=$school->end_date?></td>
                                                      <td><?=$school->tasktype->name?></td>
                                                      <td><?=$school->next_action?></td>
                                                      <td> 
                                                      <?php
                                                       if($check->school->schema_name != ''){
                                                        echo '<a href="'. url('customer/profile/'.$check->school->schema_name) .'" class="btn btn-success btn-sm"> View Client </a>';
                                                    }else{
                                                        echo '<a href="'. url('sales/profile/'.$school->id) .'" class="btn btn-info btn-sm"> View Profile</a>';
        
                                                    }
                                                      ?>
                                                      </td>
                                                    </tr>

                                                  <?php  } } ?>
                                                  <?php }} ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Schools </th>
                                                        <th>Region</th>
                                                        <th>End Date</th>
                                                        <th>Status</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                        <!-- Completed Tasks -->
                                <!-- Completed Tasks -->
                                <div class="tab-pane" id="Pipeline" role="tabpanel">
                                
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Schools </th>
                                                        <th>Region</th>
                                                        <th>End Date</th>
                                                        <th>TaskType</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1;
                                                if (sizeof($pipelines) > 0) {
                                                    foreach ($pipelines as $school){
                                                        $check_task = \App\Models\TaskClient::where('task_id', $school->id)->first();
                                                        if(!empty($check_task)){
                                                     ?>
                                                  <tr>
                                                  <td><?=$i++?></td>
                                                  <td><?=$check_task->client->name?></td>
                                                  <td><?=$check_task->client->phone?></td>
                                                  <td><?=$school->end_date?></td>
                                                  <td><?=$school->tasktype->name?></td>
                                                  <td><?=$school->next_action?></td>
                                                  <td> 
                                                  <?php
                                                   if($check_task->client->username != ''){
                                                    echo '<a href="'. url('customer/profile/'.$check_task->client->username) .'" class="btn btn-success btn-sm"> View Client </a>';
                                                }else{
                                                    echo '<a href="'. url('sales/profile/'.$school->id) .'" class="btn btn-info btn-sm"> View Profile</a>';
    
                                                }
                                                  ?>
                                                  </td>
                                                </tr>
                                                  <?php } else{ 
                                                    $check = \App\Models\TaskSchool::where('task_id', $school->id)->first();
                                                    if(!empty($check)){
                                                    ?>
                                                      <tr>
                                                      <td><?=$i++?></td>
                                                      <td><?=$check->school->name?></td>
                                                      <td><?=$check->school->phone?></td>
                                                      <td><?=$school->end_date?></td>
                                                      <td><?=$school->tasktype->name?></td>
                                                      <td><?=$school->next_action?></td>
                                                      <td> 
                                                      <?php
                                                       if($check->school->schema_name != ''){
                                                        echo '<a href="'. url('customer/profile/'.$check->school->schema_name) .'" class="btn btn-success btn-sm"> View Client </a>';
                                                    }else{
                                                        echo '<a href="'. url('sales/profile/'.$school->id) .'" class="btn btn-info btn-sm"> View Profile</a>';
        
                                                    }
                                                      ?>
                                                      </td>
                                                    </tr>

                                                  <?php  } } ?>
                                                  <?php }} ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Schools </th>
                                                        <th>Region</th>
                                                        <th>End Date</th>
                                                        <th>Status</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                <!-- Completed Tasks -->
                                <!-- Completed Tasks -->
                                <div class="tab-pane" id="New" role="tabpanel">
                                
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Schools </th>
                                                        <th>Region</th>
                                                        <th>End Date</th>
                                                        <th>TaskType</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1;
                                                if (sizeof($new_schools) > 0) {
                                                    foreach ($new_schools as $school){
                                                        $check_task = \App\Models\TaskClient::where('task_id', $school->id)->first();
                                                        if(!empty($check_task)){
                                                     ?>
                                                  <tr>
                                                  <td><?=$i++?></td>
                                                  <td><?=$check_task->client->name?></td>
                                                  <td><?=$check_task->client->phone?></td>
                                                  <td><?=$school->end_date?></td>
                                                  <td><?=$school->tasktype->name?></td>
                                                  <td><?=$school->next_action?></td>
                                                  <td> 
                                                  <?php
                                                   if($check_task->client->username != ''){
                                                    echo '<a href="'. url('customer/profile/'.$check_task->client->username) .'" class="btn btn-success btn-sm"> View Client </a>';
                                                }else{
                                                    echo '<a href="'. url('sales/profile/'.$school->id) .'" class="btn btn-info btn-sm"> View Profile</a>';
    
                                                }
                                                  ?>
                                                  </td>
                                                </tr>
                                                  <?php } else{ 
                                                    $check = \App\Models\TaskSchool::where('task_id', $school->id)->first();
                                                    if(!empty($check)){
                                                    ?>
                                                      <tr>
                                                      <td><?=$i++?></td>
                                                      <td><?=$check->school->name?></td>
                                                      <td><?=$check->school->phone?></td>
                                                      <td><?=$school->end_date?></td>
                                                      <td><?=$school->tasktype->name?></td>
                                                      <td><?=$school->next_action?></td>
                                                      <td> 
                                                      <?php
                                                       if($check->school->schema_name != ''){
                                                        echo '<a href="'. url('customer/profile/'.$check->school->schema_name) .'" class="btn btn-success btn-sm"> View Client </a>';
                                                    }else{
                                                        echo '<a href="'. url('sales/profile/'.$school->id) .'" class="btn btn-info btn-sm"> View Profile</a>';
        
                                                    }
                                                      ?>
                                                      </td>
                                                    </tr>

                                                  <?php  } } ?>
                                                  <?php }} ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Schools </th>
                                                        <th>Region</th>
                                                        <th>End Date</th>
                                                        <th>Status</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                <!-- Completed Tasks -->
                                <div class="tab-pane" id="profile1" role="tabpanel">
                                   <div id='calendar'>
                                   <?php
                         
                            echo $insight->createChartBySql($query, 'next_action', 'Leads Activity', 'bar', false);
                            ?>
                                   </div>
                                   <hr><br>
                                   <div id='calendar'>
                                   <?php
                         
                            echo $insight->createChartBySql($types, 'type', 'Sales Activities', 'bar', false);
                            ?>
                                   </div>
                                </div>

                            </div>
                        </div>

                    </div>

       </div>
    </div>
    <!-- Main-body end -->

     
<script type="text/javascript">

submit_search = function () {
    $('#search_custom').mousedown(function () {
        var alldates = $('#rangeDate').val();
            alldates = alldates.trim();
            alldates = alldates.split("-");
            start_date = formatDate(alldates[0]);
            end_date = formatDate(alldates[1]);
            choose =$('#choose').val();
        window.location.href = '<?= url('sales/salesStatus/') ?>/'+choose + '/5?start=' + start_date + '&end=' + end_date ;
    });
}

   formatDate = function (date) {
            date = new Date(date);
            var day = ('0' + date.getDate()).slice(-2);
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var year = date.getFullYear();
            return year + '-' + month + '-' + day;
    }

$(document).ready(submit_search);
$(document).ready(formatDate);

$('input[name="dates"]').daterangepicker();
</script>
 @endsection

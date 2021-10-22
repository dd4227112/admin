@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="main-body">
<div class="page-wrapper">
      <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

    <div class="page-body">
    <div class="card">
    <div class="card-header">
    <h5>List Of Schools To Visit</h5>
    </div>
    <div class="card-body">
            <div class="row">
            
                        <div class="col-lg-12 col-xl-12">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs  tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">All School List</a>
                                </li>
                                
                                <!-- <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#Closed" role="tab"> <i class="ti-plus"> </i> New</a>
                                </li>
                                -->
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#profile1" role="tab">  <i class="ti-layout-cta-right"> </i> Reports / Trend</a>
                                </li>
                                <li class="nav-item" style="float:right;">
                                    <a class="nav-link" href="<?=url('Sales/addVisit')?>" role="tab"><b>  <i class="ti-pencil"> </i> Add New </b></a>
                                </li>

                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content tabs">
                                <div class="tab-pane active" id="home1" role="tabpanel">
                                    <div class="card-block">

                                        <div class="table-responsive">
                                            <table class="table dataTable table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Schools</th>
                                                        <th>Region</th>
                                                        <th>TaskType</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1;
                                                if (sizeof($schools) > 0) {
                                                    foreach ($schools as $school){
                                                        $check = \App\Models\School::where('schema_name', $school->client->username)->first();

                                                ?>
                                                  <tr>
                                                  <td><?=$i++?></td>
                                                  <td><?=$school->client->name?></td>
                                                  <td><?=!empty($check) ? $check->region : "Not Defined" ?></td>
                                                  <td><?=$school->task->tasktype->name?></td>
                                                  <td><?=$school->task->start_date?></td>
                                                  <td><?=$school->task->end_date?></td>
                                                  <td><?=$school->task->next_action?></td>
                                                  <td> 
                                                  <?php
                                                    echo '<a href="'. url('customer/profile/'.$school->client->username) .'" class="label label-success btn-sm"> View Client </a> ';
                                                    echo ' <a href="'. url('Sales/viewVisit/'.$school->id) .'" class="label label-info btn-sm"> View Task </a>';
                                               
                                                  ?>
                                                  </td>
                                                </tr>
                                                  <?php 
                                                    }
                                                }
                                                  ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Schools </th>
                                                        <th>Region</th>
                                                        <th>Task Type</th>                                                        
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Completed Tasks -->
                                
                               
                                <div class="tab-pane" id="profile1" role="tabpanel">
                                   <div id='calendar'>
                                   <?php
                                        echo $insight->createChartBySql($query, 'status', 'Visitation Activity', 'bar', false);
                                    ?>
                                   </div>
                                   <hr><br>
                                   <div id='calendar'>
                                   <?php
                                        echo $insight->createChartBySql($types, 'Date', 'Visitation Activities', 'line', false);
                                        ?>
                                   </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- Page-body end -->
        </div>
    </div>
    <!-- Main-body end -->
    @endsection
    @section('footer')
    <!-- data-table js -->
    
<script type="text/javascript">

check = function () {

    $('#check_custom_date').change(function () {
        var val = $(this).val();
        if (val == 'today') {
            window.location.href = '<?= url('Sales/schoolVisit/') ?>/1';
        } else {
            $('#show_date').show();
        }
    });
}
submit_search = function () {
    $('#search_custom').mousedown(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        window.location.href = '<?= url('Sales/schoolVisit/') ?>/5?start=' + start_date + '&end=' + end_date;
    });
}
$(document).ready(check);
$(document).ready(submit_search);
</script>
    @endsection

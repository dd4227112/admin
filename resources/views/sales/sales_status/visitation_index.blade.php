@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-title">
            <h4>Dashboard</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Summary</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-body">
            <div class="row">
                <div class="col-sm-12">

                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card">
                        <div class="card-header">
                        <div class="row">
                <div class="col-lg-4">
                    <select class="form-control" id="check_custom_date">
                        <option value="today" <?= $today == 1 ? 'selected' : '' ?>>Today</option>
                        <option value="custom"  <?= $today == 0 ? 'selected' : '' ?>>Custom</option>
                    </select>
                </div>
                <div class="col-lg-8 text-right">
                    <div  style="display: none" id="show_date">
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="date" class="input-sm form-control" name="start" id="start_date">
                            <span class="input-group-addon">to</span>
                            <input type="date" class="input-sm form-control" name="end" id="end_date">
                            <input type="submit" Value="Submit" class="input-sm btn btn-sm btn-success" id="search_custom"/>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
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
                                                        $check = \App\Models\School::where('schema_name', $school->client->username)->first();

                                                ?>
                                                  <tr>
                                                  <td><?=$i++?></td>
                                                  <td><?=$school->client->name?></td>
                                                  <td><?=!empty($check) ? $check->region : "Not Defined" ?></td>
                                                  <td><?=$school->task->end_date?></td>
                                                  <td><?=$school->task->tasktype->name?></td>
                                                  <td><?=$school->task->next_action?></td>
                                                  <td> 
                                                  <?php
                                                    echo '<a href="'. url('customer/profile/'.$school->client->username) .'" class="btn btn-success btn-sm"> View Client </a>';
                                               
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
            window.location.href = '<?= url('Sales/salesStatus/') ?>/1';
        } else {
            $('#show_date').show();
        }
    });
}
submit_search = function () {
    $('#search_custom').mousedown(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        window.location.href = '<?= url('Sales/salesStatus/') ?>/5?start=' + start_date + '&end=' + end_date;
    });
}
$(document).ready(check);
$(document).ready(submit_search);
</script>
    @endsection

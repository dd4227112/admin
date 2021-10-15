@extends('layouts.app')
@section('content')

<div class="main-body">
  <div class="page-wrapper">
    <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <!-- Ajax data source (Arrays) table start -->
          <div class="card">
            <div class="card-block">
               <div class="card-block">
                <a class="btn btn-success btn-sm" href="<?= url('users/addMinute') ?>"> Add New Minute</a>
              </div>

              
                <div class="card-block">
                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                          <th>Id </th>
                          <th>Title</th>
                          <th>Date</th>
                          <th>Start Time</th>
                          <th>End Time</th>
                          <th>Department</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(sizeof($minutes) > 0){
                        $i = 1;
                        foreach($minutes as $minute){
                          ?>
                      <tr>
                          <td><?=$i++?> </td>
                          <td><a href="{{ url('users/showMinute/'.$minute->id) }}"><?=substr($minute->title, 0, 60)?></a></td>
                          <td><?=$minute->date?></td>
                          <td><?=$minute->start_time?></td>
                          <td><?=$minute->end_time?></td>
                          <td><?=$minute->department->name?></td>

                          <td>
                          <a class="btn btn-info btn-sm" href="{{ url('users/showMinute/'.$minute->id) }}">Show</a>
                          <a class="btn btn-warning btn-sm" href="{{ url('users/deleteMinute/'.$minute->id) }}">Delete</a>
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
</div>
@endsection

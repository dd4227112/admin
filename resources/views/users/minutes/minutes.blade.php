@extends('layouts.app')
@section('content')

    <div class="page-header">
            <div class="page-header-title">
                <h4><?='Minutes' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">meeting</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Operations</a>
                    </li>
                </ul>
            </div>
        </div> 

    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <!-- Ajax data source (Arrays) table start -->
          <div class="card">
            <div class="card-block">
               <div class="card-block">
                  <a href="<?= url("users/addminute") ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title=" Add New Minute">  Add Minute </a>

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

                          <td class="text-center">
                              <?php $show_url ="users/showMinute/$minute->id"; $delete_url ="users/deleteMinute/$minute->id";?>            
                                   <a href="<?= url($show_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Show Minute">  view </a>
                                   <a href="<?= url($delete_url) ?>" class="btn btn-danger btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Delete Minute">  delete</a>
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

@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->

  

      <div class="page-header">
        <div class="page-header-title">
            <h4><?=' Add event' ?></h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">new events</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">operations</a>
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
                <span>
                  <?php if(can_access('add_event')) { ?>
                  <a class="btn btn-primary btn-sm btn-round" href="<?= url('Marketing/addEvent') ?>"> Add New Event </a>
                  <?php } ?>
              </span>
           </div>

            
                <div class="card-block">
                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                          <th>Id </th>
                          <th>Title</th>
                          <th>Date</th>
                          <th>Start</th>
                          <th>End</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(sizeof($events) > 0){ 
                        $i = 1;
                        foreach($events as $event){
                          ?>
                         <tr>
                          <td><?=$i++?> </td>
                          <td><a href="{{ url('Marketing/events/'.$event->id) }}"><?=substr($event->title, 0, 60)?></a></td>
                          <td><?=date('d-m-Y', strtotime($event->event_date))?></td>
                          <td><?=$event->start_time?></td>
                          <td><?=$event->end_time?></td>

                          <td>
                          <a class="btn btn-info btn-mini btn-round" href="{{ url('Marketing/events/'.$event->id.'/1') }}">Show</a>
                          <a class="btn btn-danger btn-mini btn-round" href="{{ url('Marketing/DeleteMedia/'.$event->id) }}">Delete</a>
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

@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>


<div class="page-body">

  <div class="row">
      <div class="col-md-12 col-xl-12">
          <div class="card"> 
              <div class="card-block">
                {{-- <button type="button" class="btn btn-info btn-outline-info waves-effect md-trigger" data-modal="modal-12">Just Me</button> --}}
              
                <form class="form-horizontal" role="form" method="post"> 
                     <div class="form-group row">
                       <div class="col-sm-5">
                         <label>Start date </label>
                          <input type="date" name="start_date" class="form-control" id="start_date" value="<?= date('Y-01-01')?>">
                       </div>

                       <div class="col-sm-5">
                         <label>End date</label>
                          <input type="date" name="end_date" class="form-control" id="end_date" value="<?= date('Y-m-d')?>">
                       </div>

                        <div style="padding-top: 30px;">
                           <button type="submit" class="btn btn-sm btn-info">Submit</button>
                       </div>
                      </div>
                   <?= csrf_field() ?>
                  </form>
              <hr>                              
                <ul class="nav nav-tabs md-tabs " role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#profile7" role="tab"> <h6 class="text-center text-subtitle">Phone calls </h6></a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#home7" role="tab"> <h6 class="text-center text-subtitle"> Project Profile </h6></a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#missedCall" role="tab"> <h6 class="text-center text-subtitle">Project Statistics </h6></a>
                        <div class="slide"></div>
                    </li>
                </ul> 
                        
                   <div class="tab-content">
                    
                      <div class="tab-pane active" id="profile7" role="tabpanel">
               
                               
                             <div class="card-block">
                                     <div class="dt-responsive table-responsive">
                                        <table id="list_of_calls" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Action</th>
                                                <th>Story Type</th>
                                                <th>Story Name</th>
                                                <th>Current State</th>
                                                {{-- <th>Call Duration</th> --}}
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @if(!empty($stories))
                                          <?php
                                
                                            $all_stories = json_decode($stories);
                                            foreach ($all_stories as $key => $value) {
                                            //  dd($value);
                                            ?>
                                             <tr>
                                                <th>{{ $value->id }} </th>
                                                <th>
                                                  <button type="button" class="btn btn-info btn-sm" data-target=".bd-example-modal-sm" id="myBtn" onmousedown="send_comment(<?= $value->id ?>)"> Tasks </button>
                                                </th>
                                                <th>{{ $value->story_type  }}</th>
                                                <th>{{ $value->name  }}</th>
                                                {{-- <th>{{ isset($value->description) ? $value->description : ''  }}</th> --}}
                                                <th>{{ $value->current_state  }}</th>
                                                <th> <a href="{{ $value->url  }}" target="_blank" rel="noopener noreferrer">View Story</a> </th>
                                            </tr>
                                          <?php  } ?>
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                              </div>
                             </div>
                        
                            <div class="tab-pane" id="home7" role="tabpanel">               
                                <div class="row"> 
                                   <div class="col-sm-12">
                                    @if(!empty($projectdata))
                                      <?php
                                        $project = json_decode($projectdata);
                                  
                                        $columns = array('id','name', 'kind', 'week_start_day',  'start_date', 'created_at', 'start_time', 'updated_at');
                                    
                                      ?>
                                  
                                          <div class="card"> 
                                            <div class="card-header">
                                                <h3>{{ $project[0]->name }} </h3>
                                            </div>
                                              <div class="card-block">
                                                <div class="row">
                                                  <div class="col-md-12 col-xl-12">
                                                    <table class="table">
                                                      <thead>
                                                        @foreach ($columns as $value) 
                                                        <tr>
                                                          <th><?= ucwords(str_replace('_', ' ', $value)) ?> </th>
                                                          <th>{{ $project[0]->{$value} }} </th>
                                                        </tr>
                                                        @endforeach
                                                      </thead>
                                                    </table>
                                                  </div>
                                              </div>
                                            </div>
                                        
                                      @endif
                                   </div> 
                                
                               </div>    
                            </div> 
                    
              </div>

          </div>
      </div>
  </div>

  </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div id="districts">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>

</div>

<script>
    $(document).ready(function(){
        send_comment = function (id) {
          $('#districts').hide();
          $.ajax({
            method: 'get',
            url: '<?= url('General/roadTask/null') ?>',
            data: {story_id: id},
            dataType: 'html',
            success: function (data) {
              $('#districts').show();
              $('#districts').html(data);
            }
          });
        $("#myModal").modal();
      }
    });

</script>


@endsection

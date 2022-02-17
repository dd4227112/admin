@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<?php
    $pr = [
        ""=>"None",
        "p0"=>"Critical",
        "p1"=>"High",
        "p2"=>"Medium",
        "p3"=>"Low",
    ];
?>
<!-- Page body start -->
<div class="page-body">
    <!-- Task board design block start-->
    <div class="row">
        <div class="col-sm-12">
            <h4>Task Board</h4>
            <!-- Left column start -->
            <div class="pull-xl-3 filter-bar">
                <!-- Nav Filter tab start -->
                <nav class="navbar navbar-light bg-faded m-b-30 p-10">
                    <ul class="nav navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#!">Filter: <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#!" id="bydate" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-clock-time"></i> By
                                Date</a>
                            <div class="dropdown-menu" aria-labelledby="bydate">
                                <a class="dropdown-item" href="#!">Show all</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="date/{{ date('Y-m-d') }}">Today</a>
                                <a class="dropdown-item" href="date/2">Yesterday</a>
                                <a class="dropdown-item" href="date/7">This week</a>
                                <a class="dropdown-item" href="date/30">This month</a>
                                <a class="dropdown-item" href="date/{{ date('Y') }}">This year</a>
                            </div>
                        </li>
                        <!-- end of by date dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#!" id="bystatus" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i
                                    class="icofont icofont-chart-histogram-alt"></i> By Status</a>
                            <div class="dropdown-menu" aria-labelledby="bystatus">
                                <a class="dropdown-item" href="#!">Show all</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#!" value="unstarted">Unstarted</a>
                                      <a class="dropdown-item" href="#!" value="started">Started</a>
                                      <a class="dropdown-item" href="#!" value="finished">Finished</a>
                                      <a class="dropdown-item" href="#!" value="delivered">Delivered</a>
                                      <a class="dropdown-item" href="#!" value="rejected">Rejected</a>
                                      <a class="dropdown-item" href="#!" value="accepted">Accepted</a>
                                      <a class="dropdown-item" href="#!" value="unscheduled">Unscheduled</a>
                                      <a class="dropdown-item" href="#!" value="planned">Planned</a>
                            </div>
                        </li>
                        <!-- end of by status dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#!" id="bypriority" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-sub-listing"></i>
                                By Priority</a>
                            <div class="dropdown-menu" aria-labelledby="bypriority">
                                <a class="dropdown-item" href="#!">Show all</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#!" value="null">None</a>
                                <a class="dropdown-item" href="#!" value="P0">Critical</a>
                                <a class="dropdown-item" href="#!" value="P1">High</a>
                                <a class="dropdown-item" href="#!" value="P2">Medium</a>
                                <a class="dropdown-item" href="#!" value="P3">Low</a>
                            </div>
                        </li>
                    </ul>
                    <div class="nav-item nav-grid">
                        <span class="m-r-15">View all tasks here: </span>
                        
                    </div>
                    <!-- end of by priority dropdown -->

                </nav>
            </div>
        </div>
        @if(!empty($stories))
        <?php
    
                $all_stories = json_decode($stories);
                foreach ($all_stories as $key => $value) {
                //  dd($value);
                ?>
        <div class="col-sm-6">
            <div class="card card-border-default">
                <div class="card-header">
                    <a href="#" class="card-title"> <strong>#{{ $value->id }}</strong> - {{ $value->name }} </a>
                    <span class="label label-default f-right"> {{ timeAgo($value->created_at) }} </span>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="task-detail">{{ isset($value->description) ? $value->description : ''  }}
                            
                            <span class="btn btn-default btn-mini"><i class="icofont icofont-clock"></i> Last Updated 
                                : {{ timeAgo($value->updated_at) }}</span></p>
                        </div>
                        <!-- end of col-sm-8 -->
                    </div>
                    <!-- end of row -->
                </div>
                <div class="card-footer">
                    <div class="task-list-table">

                        <a href="#!" class="btn btn-info btn-mini"><i class="icofont icofont-tags"></i><b>
                                {{ $value->story_type  }}</b> </a>
                                
                            <button class="btn btn-warning btn-mini" data-target=".bd-example-modal-sm" id="myBtn"
                            onmousedown="send_comment(<?= $value->id ?>)"> <strong> <i class="icofont icofont-comment"></i> View Tasks </strong></button>
                        
                    </div>
                    <div class="task-board">
                        <div class="dropdown-secondary dropdown">
                            <button class="btn btn-danger btn-mini">{{ $pr[$value->story_priority]  }} - Priority</button>

                            <!-- end of dropdown menu -->
                        </div>
                        <div class="dropdown-secondary dropdown">
                            <button class="btn btn-success btn-mini">{{ $value->current_state  }}</button>
                        </div>
                        <!-- end of dropdown-secondary -->
                        <div class="dropdown-secondary dropdown">
                        </div>
                        <!-- end of seconadary -->
                    </div>
                    <!-- end of pull-right class -->
                </div>
                <!-- end of card-footer -->
            </div>
        </div>
        <?php } ?>
        @endif
    </div>
    <!-- Task board design block end -->
</div>
<!-- Left column end -->
</div>
</div>
<!-- Page body end -->
</div>
</div>
<!-- Main-body end -->
<!-- Modal -->
<div class="modal fade centered bd-example-modal-lg" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div id="districts">

            </div>
            <div id="pleasewait" class="text-center">
                <img src="{{ url('public/images/loading-buffering.gif') }}" alt="">
            </div>
            <div class="modal-footer">
                <button type="button"class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

</div>

<script>
    $(document).ready(function(){

        send_comment = function (id) {
            $('#districts').hide();
            $('.modal-footer').hide();
            $('#pleasewait').show();
          $.ajax({
            method: 'get',
            url: '<?= url('General/roadTask/null') ?>',
            data: {story_id: id},
            dataType: 'html',
            success: function (data) {
              $('#pleasewait').hide();
              $('#districts').show();
              $('.modal-footer').show();
              $('#districts').html(data);
            }
          });
        $("#myModal").modal();
      }

      send_storycomment = function (id) {
        var storycomment = $('#storycomment').val();
        if(storycomment !== ''){
          $.ajax({
            method: 'get',
            url: '<?= url('General/postComment/null') ?>',
            data: {story_id: id, text: storycomment},
            dataType: 'html',
            success: function (data) {
              $('#sentcomment').show();
              $('#showcomment').hide();
            }
          });
      }
      }
    });

</script>


@endsection

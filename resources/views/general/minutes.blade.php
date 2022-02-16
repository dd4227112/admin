@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>


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
                        <span class="m-r-15">View Mode: </span>
                        <button type="button" class="btn btn-sm btn-primary waves-effect waves-light m-r-10"
                            data-toggle="tooltip" data-placement="top" title="list view">
                            <i class="icofont icofont-listine-dots"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-primary waves-effect waves-light"
                            data-toggle="tooltip" data-placement="top" title="grid view">
                            <i class="icofont icofont-table"></i>
                        </button>
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
                            <p class="task-detail">{{ isset($value->description) ? $value->description : ''  }}</p>
                        </div>
                        <!-- end of col-sm-8 -->
                    </div>
                    <!-- end of row -->
                </div>
                <div class="card-footer">
                    <div class="task-list-table">

                        <a href="#!" class="btn btn-info btn-mini"><i class="icofont icofont-tags"></i><b>
                                {{ $value->story_type  }}</b> </a>
                        <a href="#!" class="btn btn-default btn-mini"><i class="icofont icofont-clock"></i> Last Update
                            : {{ timeAgo($value->updated_at) }}</a>
                    </div>
                    <div class="task-board">
                        <div class="dropdown-secondary dropdown">
                            <button class="btn btn-danger btn-mini">{{ $value->story_priority  }}</button>

                            <!-- end of dropdown menu -->
                        </div>
                        <div class="dropdown-secondary dropdown">
                            <button class="btn btn-success btn-mini">{{ $value->current_state  }}</button>
                        </div>
                        <!-- end of dropdown-secondary -->
                        <div class="dropdown-secondary dropdown">
                            <button class="btn btn-warning btn-mini" data-target=".bd-example-modal-sm" id="myBtn"
                                onmousedown="send_comment(<?= $value->id ?>)"> View Tasks </button>
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
    $(document).ready(function () {
        send_comment = function (id) {
            $('#districts').hide();
            $.ajax({
                method: 'get',
                url: '<?= url('
                General / roadTask / null ') ?>',
                data: {
                    story_id: id
                },
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

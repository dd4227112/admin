@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>

<div class="page-wrapper">
  <div class="page-header">
    <div class="page-header-title">
      <h4>Phone calls</h4>
    </div>
    <div class="page-header-breadcrumb">
  </div>
</div>

<div class="page-body">
  <div class="row">
      <div class="col-md-12 col-xl-12">
          <div class="card" > 
              <div class="card-block tab-icon">                               
                <ul class="nav nav-tabs md-tabs " role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#profile7" role="tab"> <h6 class="text-center">Phone calls </h6></a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#home7" role="tab"> <h6 class="text-center">Incoming calls </h6></a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#missedCall" role="tab"> <h6 class="text-center">Missed calls </h6></a>
                        <div class="slide"></div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#OutgoingCall" role="tab"> <h6 class="text-center">Outgoing calls </h6></a>
                        <div class="slide"></div>
                    </li>
                </ul> 
                        
                   <div class="tab-content card-block">
                    
                      <div class="tab-pane active" id="profile7" role="tabpanel">
                          <div class="col-sm-12">
                             <form class="form-horizontal" role="form" method="post"> 
                                  <div class="form-group row">
                                    <div class="col-sm-3">
                                      <label>Start date </label>
                                       <input type="date" name="start_date" class="form-control" id="start_date" value="<?= date('Y-01-01')?>">
                                    </div>

                                    <div class="col-sm-3">
                                      <label>End date</label>
                                       <input type="date" name="end_date" class="form-control" id="end_date" value="<?= date('Y-m-d')?>">
                                    </div>

                                     <div style="padding-top: 30px;">
                                        <button type="submit" class="btn btn-sm btn-info">Submit</button>
                                    </div>
                                   </div>
                                <?= csrf_field() ?>
                               </form>
                            </div> 
                               
                             <div class="card-block">
                                <div class="table-responsive dt-responsive ">
                                    <table class="table table-bordered dataTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Full Name</th>
                                                <th>Phone Number</th>
                                                <th>Email</th>
                                                <th>Call Type</th>
                                                <th>Time</th>
                                                <th>Next Follow up</th>
                                                <th>Call Duration</th>
                                                <th>Call Details</th>
                                                <th width="280px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($phone_calls as $key => $call)
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td>{{ $call->full_name }} </td>
                                                <td>{{ $call->phone_number }} </td>
                                                <td>{{ $call->email }}</td>
                                                <td><?php if($call->call_type==0){
                                                    echo 'Outgoing';    
                                                } else{
                                                    echo 'Incoming';  
                                                }?></td>
                                                
                                                <td>{{ $call->created_at}}<br> {{ $call->call_time}}</td>
                                                <td>{{ $call->followup_date }}<br> {{ $call->next_followup }}</td>
                                                <td>{{ $call->call_duration }}</td> 
                                                <td>{{ $call->call_detail }}</td> 
                                                <td>
                                                  <a class="btn btn-primary btn-sm" href="{{ url('Phone_call/edit/'.$call->id) }}">Edit</a> 
                                                  <a class="btn btn-danger btn-sm" href="{{ url('Phone_call/destroy/'.$call->id) }}">Delete</a>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                              </div>
                             </div>
                        
                         
                            <div class="tab-pane" id="home7" role="tabpanel">               
                               <div class="col-sm-12">
                                <div class="row"> 
                                   <div class="col-sm-6">
                                          <script src="https://code.highcharts.com/highcharts.js"></script>
                                        <script src="https://code.highcharts.com/modules/data.js"></script>
                                        <script type="text/javascript">
                                                    $(function () {
                                                        $('#container').highcharts({
                                                            data: {
                                                                table: 'datatables'
                                                            },
                                                            series: [{
                                                                    name: '',
                                                                    colorByPoint: true}
                                                            ],
                                                            chart: {
                                                                type: 'column'
                                                            },
                                                            title: {
                                                                text: "Incoming calls" 
                                                            },
                                                            yAxis: {
                                                                allowDecimals: false,
                                                                title: {
                                                                    text: 'Calls'
                                                                }
                                                            },
                                                            legend: {
                                                                enabled: false
                                                            },
                                                            plotOptions: {
                                                                series: {
                                                                    borderWidth: 0,
                                                                    dataLabels: {
                                                                        enabled: true,
                                                                        format: ''
                                                                    }
                                                                }
                                                            },
                                                            tooltip: {
                                                                formatter: function () {
                                                                    return '<b>' + this.series.name + '</b><br/>' +
                                                                            this.point.y + ' ' + this.point.name.toUpperCase();
                                                                }
                                                            }
                                                        });
                                                    });
                                                </script>
                                        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                   </div> 
                                
                                    <div class="col-sm-6">
                                        <div class="car">
                                          <div class="card-heade">
                                                  <table id="datatables" style="margin:5px;font-size:10px;" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Month</th>
                                                            <th>All Incoming calls</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                      
                                                        for ($m = 1; $m <= (int) date('m'); $m++) {
                                                            $dateObj = DateTime::createFromFormat('!m', $m);
                                                            $monthName = $dateObj->format('F');
                                                            $incomings = \App\Models\PhoneCall::where(DB::raw('EXTRACT(MONTH FROM created_at) '), $m)->where('call_type', 'Incoming')->count();
                                                         
                                                            ?>
                                                            <tr>
                                                                <th><?= $monthName ?></th>
                                                                <td><?= $incomings ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                         </div>
                                      </div> 
                                   </div>
                               </div>    
                            </div> 

                            <div class="tab-pane" id="missedCall" role="tabpanel">               
                               <div class="col-sm-12">
                                  <div class="row"> 
                                   <div class="col-sm-6">
                                      <script src="https://code.highcharts.com/highcharts.js"></script>
                                        <script src="https://code.highcharts.com/modules/data.js"></script>
                                           <script type="text/javascript">
                                                    $(function () {
                                                        $('#missed').highcharts({
                                                            data: {
                                                                table: 'datatables_missed'
                                                            },
                                                            series: [{
                                                                    name: '',
                                                                    colorByPoint: true}
                                                            ],
                                                            chart: {
                                                                type: 'column'
                                                            },
                                                            title: {
                                                                text: "Missed calls" 
                                                            },
                                                            yAxis: {
                                                                allowDecimals: false,
                                                                title: {
                                                                    text: 'Calls'
                                                                }
                                                            },
                                                            legend: {
                                                                enabled: false
                                                            },
                                                            plotOptions: {
                                                                series: {
                                                                    borderWidth: 0,
                                                                    dataLabels: {
                                                                        enabled: true,
                                                                        format: ''
                                                                    }
                                                                }
                                                            },
                                                            tooltip: {
                                                                formatter: function () {
                                                                    return '<b>' + this.series.name + '</b><br/>' +
                                                                            this.point.y + ' ' + this.point.name.toUpperCase();
                                                                }
                                                            }
                                                        });
                                                    });
                                                </script>
                                        <div id="missed" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                   </div> 
                                
                                    <div class="col-sm-6">
                                        <div class="cardi">
                                          <div class="card-headeri">
                                                  <table id="datatables_missed" style="margin:5px;font-size:10px;" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Month</th>
                                                            <th>All missed calls</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        for ($m = 1; $m <= (int) date('m'); $m++) {
                                                            $dateObj = DateTime::createFromFormat('!m', $m);
                                                            $monthName = $dateObj->format('F');
                                                            $missed_calls = \App\Models\PhoneCall::where(DB::raw('EXTRACT(MONTH FROM created_at) '), $m)->where('call_type', 'Missed')->count();
                                                         
                                                            ?>
                                                            <tr>
                                                                <th><?= $monthName ?></th>
                                                                <td><?= $missed_calls ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                         </div>
                                      </div> 
                                   </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="OutgoingCall" role="tabpanel">               
                               <div class="col-sm-12">
                                  <div class="row"> 
                                   <div class="col-sm-6">
                                      <script src="https://code.highcharts.com/highcharts.js"></script>
                                        <script src="https://code.highcharts.com/modules/data.js"></script>
                                           <script type="text/javascript">
                                                    $(function () {
                                                        $('#outgoings').highcharts({
                                                            data: {
                                                                table: 'datatabless'
                                                            },
                                                            series: [{
                                                                    name: '',
                                                                    colorByPoint: true}
                                                            ],
                                                            chart: {
                                                                type: 'column'
                                                            },
                                                            title: {
                                                                text: "Outgoing calls" 
                                                            },
                                                            yAxis: {
                                                                allowDecimals: false,
                                                                title: {
                                                                    text: 'Calls'
                                                                }
                                                            },
                                                            legend: {
                                                                enabled: false
                                                            },
                                                            plotOptions: {
                                                                series: {
                                                                    borderWidth: 0,
                                                                    dataLabels: {
                                                                        enabled: true,
                                                                        format: ''
                                                                    }
                                                                }
                                                            },
                                                            tooltip: {
                                                                formatter: function () {
                                                                    return '<b>' + this.series.name + '</b><br/>' +
                                                                            this.point.y + ' ' + this.point.name.toUpperCase();
                                                                }
                                                            }
                                                        });
                                                    });
                                                </script>
                                        <div id="outgoings" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                   </div> 
                                
                                    <div class="col-sm-6">
                                        <div class="cardi">
                                          <div class="card-headeri">
                                                  <table id="datatabless" style="margin:5px;font-size:10px;" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Month</th>
                                                            <th>All Outgoing calls</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        for ($m = 1; $m <= (int) date('m'); $m++) {
                                                            $dateObj = DateTime::createFromFormat('!m', $m);
                                                            $monthName = $dateObj->format('F');
                                                            $Outgoing_calls = \App\Models\PhoneCall::where(DB::raw('EXTRACT(MONTH FROM created_at) '), $m)->where('call_type', 'Outgoing')->count();
                                                            ?>
                                                            <tr>
                                                                <th><?= $monthName ?></th>
                                                                <td><?= $Outgoing_calls ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
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
                  <!-- Row end -->
              </div>

          </div>
      </div>
  </div>
</div>
</div>

@endsection

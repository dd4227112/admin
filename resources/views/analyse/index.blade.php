@extends('layouts.app')
@section('content')

<?php $root = url('/') . '/public/';  ?>



  <div>
    <div class="page-header">
        <div class="page-header-title">
            <h4>Home</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                 <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">summary</a>
                </li>
            </ul>
        </div>
    </div> 
  </div>

    <div class="page-body">
        <?php if (can_access('manage_users')) { ?>

           <div class="row">
                  <div class="col-xl-3 col-md-6">
                             <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Users</p>
                                                <h4 class="m-b-0">{{ number_format($summary['users']) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-users f-30"></i>
                                   
                                            </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                
                    <div class="col-xl-3 col-md-6">
                         <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Parents</p>
                                                <h4 class="m-b-0">{{ number_format($summary['parents']) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-users f-30 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Students</p>
                                                <h4 class="m-b-0">{{ number_format($summary['students']) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-users f-30 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                   <div class="col-xl-3 col-md-6">
                        <div class="card shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Teachers</p>
                                                <h4 class="m-b-0">{{ number_format($summary['teachers']) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-users f-30 text-c-red" style="color:#19b99a"></i>
                                            </div>
                                    </div>
                                </div>
                         </div>
                   </div>

                    <div class="col-xl-3 col-md-6">
                         <div class="card shadow bg-primary">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Active Users</p>
                                                <h4 class="m-b-0">{{ number_format($summary['active_users']) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-users f-30 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                         </div>
                    </div>

                   

                      <div class="col-xl-3 col-md-6">
                         <div class="card shadow bg-primary">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Active Parents</p>
                                                <h4 class="m-b-0">{{ number_format($summary['active_parents']) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-users f-30 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                         </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                         <div class="card shadow bg-primary">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Active Students</p>
                                                <h4 class="m-b-0">{{ number_format($summary['active_students']) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-users f-30 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                         </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                            <div class="card shadow bg-primary">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Active teachers</p>
                                                <h4 class="m-b-0">{{ number_format($summary['active_teachers']) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-users f-30 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-12">
                        <div class="card">
                            <div class="card-block">
                                <div id="containa" style="height:300px"></div>
                            </div>
                        </div>
                     </div>
                    </div>
        
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card  mb-2">
                                <div class="card-body">
                                    <figure class="highcharts-figure">
                                        <div id="onboardPie" style="height: 300px; width:350px;"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card  mb-2">
                                <div class="card-body">
                                    <figure class="highcharts-figure">
                                        <div id="onboardBar" style="height: 300px; width:350px;"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                       
              <?php } ?>

                   <div class="card">
                    <div class="card-header">
                        <h5>My User Activities</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table dataTable table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Task type</th>
                                        <th>School</th>
                                        <th>Activity</th>
                                        <th>Added On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (!empty($activities)) {
                                        foreach ($activities as $act) {
                                            ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $act->type ?></td>
                                                <td><?= $act->school ?></td>
                                                <td><?= warp($act->activity,80) ?> </td>
                                                <td><?= date('d-m-Y',strtotime($act->end_date)) ?></td>
                                                <td> <a href="<?= url('customer/activity/show/' . $act->id) ?>">View</a> </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                  </div>

        </div>
    </div>

<script>
Highcharts.chart('containa', {
      chart: {
        type: 'column'
    },
    title: {
        text: 'Schools onboarding Trend'
    },

    subtitle: {
        text: 'Based on new schools every month.'
    },

    yAxis: {
        title: {
            text: 'Schools'
        }
    },

    xAxis: {
         title: {
            text: 'Months'
        },
        categories: [
            <?php foreach($new_schools as $class){  ?> '<?=date("M", strtotime($class->month))?>',
            <?php } ?>
        ]
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    series: [{
        name: 'Schools',
        colorByPoint: true,
        data: [<?php foreach($new_schools as $teacher){ echo $teacher->schools.','; }?>]
    }],
    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }
});



Highcharts.chart('onboardPie', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Onboarded schools distribution'
    },
    subtitle: {
        text: 'Total Schools - <?=count($new_schools)?>'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:.1f}</b>'
    },
    accessibility: {
        point: {
          //  valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:.1f}'
            }
        }
    },
    series: [{
        name: 'Schools',
        colorByPoint: true,
        data: [
            <?php foreach($new_schools as $value){  ?> {
                name: '<?=date("M", strtotime($value->month))?>',
                y: <?=$value->schools ?>
            },
            <?php } ?>
        ]
    }]
});


Highcharts.chart('onboardBar', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Schools Vs Months'
    },
    subtitle: {
        text: 'Overall schools onboarded'
    },
    xAxis: {
        type: 'Months',
       
        categories: [
        <?php foreach($new_schools as $value){  ?> '<?=date("M", strtotime($value->month))?>',
        <?php } ?>
      ]
    },
    yAxis: {
        title: {
            text: 'Schools'
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Months',
        colorByPoint: true,
        data: [
            <?php foreach($new_schools as $value){ ?> {
                name: '<?=date("M", strtotime($value->month))?>',
                y: <?=$value->schools?>,
                drilldown: <?=$value->schools ?>
            },
            <?php } ?>
        ]
    }]
});
</script>

@endsection

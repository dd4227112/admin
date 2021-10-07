@extends('layouts.app')
@section('content')

<?php $root = url('/') . '/public/';  ?>

<div class="page-wrapper">
  <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
    <div class="page-body">
        <div class="row">
            <?php if (can_access('manage_users')) { ?>
                    
                  <div class="col-xl-3 col-md-6">
                        <x-smallCard title="Users"
                                :value="$summary['users']"
                                icon="feather icon-users f-50 text-c-red"
                                cardcolor="bg-c-yellow text-white"
                                >
                        </x-smallCard>
                    </div>

                
                    <div class="col-xl-3 col-md-6">
                        <x-smallCard title="Parents"
                                     :value="$summary['parents']"
                                     icon="feather icon-users f-50 text-c-red"
                                     cardcolor="bg-c-green text-white"
                                     >
                        </x-smallCard>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <x-smallCard title="Students"
                                    :value="$summary['students']"
                                    icon="feather icon-users f-50 text-c-red"
                                    cardcolor="bg-c-blue text-white"
                                    >
                        </x-smallCard>
                    </div>

                   <div class="col-xl-3 col-md-6">
                        <x-smallCard title="Teachers"
                                    :value="$summary['teachers']"
                                    icon="feather icon-users f-50 text-c-blue"
                                    cardcolor="bg-c-blue text-white"
                                    >
                        </x-smallCard>
                   </div>

                    <div class="col-xl-3 col-md-6">
                          <x-smallCard title="Active Users" :value="$summary['active_users']" icon="feather icon-users f-50 text-c-blue" cardcolor="bg-c-yellow text-white">
                         </x-smallCard>
                    </div>

                    <div class="col-xl-3 col-md-6">
                         <x-smallCard title="Active Parents" :value="$summary['active_parents']" icon="feather icon-users f-50 text-c-blue" cardcolor="bg-c-green text-white">
                        </x-smallCard>
                     </div>

                    <div class="col-xl-3 col-md-6">
                        <x-smallCard title="Active Students" :value="$summary['active_students']" icon="feather icon-users f-50 text-c-blue" cardcolor="bg-c-pink text-white">
                        </x-smallCard>
                    </div>

                    <div class="col-xl-3 col-md-6">
                            <x-smallCard title="Active teachers" :value="$summary['active_teachers']" icon="feather icon-users f-50 text-c-blue" cardcolor="bg-c-blue text-white">
                            </x-smallCard>
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
                            <div class="card shadow mb-2">
                                <div class="card-body">
                                    <figure class="highcharts-figure">
                                        <div id="onboardPie" style="height: 300px; width:350px;"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card shadow mb-2">
                                <div class="card-body">
                                    <figure class="highcharts-figure">
                                        <div id="onboardBar" style="height: 300px; width:350px;"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                       
              <?php } ?>

              <div class="row">
                  <div class="col-sm-12">
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

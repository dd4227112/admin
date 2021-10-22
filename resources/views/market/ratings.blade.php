@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/'; ?>
<div class="main-body">
    <div class="page-wrapper">
        <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
          <div class="page-body">

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <x-analyticCard :value="$nps->nps" name="NPS"  icon="feather icon-trending-up text-white f-16" color="bg-c-yellow" topicon="feather icon-bar-chart f-40" subtitle="trending"></x-analyticCard>
                </div>

                <div class="col-xl-3 col-md-6">
                    <x-analyticCard :value="$commentators" name="Total Rators" icon="feather icon-users text-white f-16"  color="bg-c-green"  topicon="feather icon-users f-40" subtitle="system users"></x-analyticCard>
                </div>

                <div class="col-xl-3 col-md-6">
                    <x-analyticCard :value="$comments" name="Comments" icon="feather icon-message-circle text-white f-16"  color="bg-c-blue"  topicon="feather icon-message-square f-40" subtitle="user comments"></x-analyticCard>
                </div>
            </div>
  
            <div class="row">
                <div class="col-lg-12">
                <div class="card">
                    <div class="card-block">
                        <div id="containa" style="height:380px;" ></div>
                    </div>
                </div> 
                </div>
            </div>

              <div class="row">
                <div class="col-lg-12">
                <div class="card">
                    <div class="card-block">
                        <div id="container" style="height:380px;width:850px;" ></div>
                    </div>
                </div> 
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <figure class="highcharts-figure">
                                <div id="onboardPie" style="height: 300;width:850px;"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>

            
                 <div class="card">
                       <div class="card-header">
                            <h5>System User ratings and comments</h5>
                        </div>
                    <div class="card-block">
                        <div class="table-responsive analytic-table">
                            <table id="res-config" class="table table-bordered w-100 dataTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Usertype</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>School</th>
                                    <th>Date</th>
                                    <th>Module</th>
                                    <th>Comment</th>
                                    <th>Rate</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; if(count($ratings) > 0)
                                            foreach ($ratings as $rating) { ?>
                                          <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $rating->usertype?></td>
                                            <td>
                                             <?= isset(fullName($rating->schema_name,$rating->user_table,$rating->user_id)->name)?fullName($rating->schema_name,$rating->user_table,$rating->user_id)->name:'' ?>
                                            </td>
                                            <td>
                                            <?= isset(fullName($rating->schema_name,$rating->user_table,$rating->user_id)->phone)?fullName($rating->schema_name,$rating->user_table,$rating->user_id)->phone:'' ?>
                                            </td>
                                            <td><?= $rating->schema_name?></td>
                                            <td><?= date('d-m-Y', strtotime($rating->created_at)) ?></td>
                                            <td><?= isset($rating->modules->name) ? $rating->modules->name : '' ?></td>
                                            <td class="text-left"><?= warp($rating->comment,20) ?></td>
                                            <td class="text-left"><?= $rating->rate?></td>
                                          </tr>
                                     <?php $i++; } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Usertype</th>
                                    <th>School</th>
                                    <th>Date</th>
                                    <th>Module</th>
                                    <th>Comment</th>
                                    <th>Rate</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>

<script type="text/javascript">
Highcharts.chart('onboardPie', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45
    }
  },
  title: {
    text: 'Average module ratings'
  },
  subtitle: {
    text: 'Average ratings for each module'
  },
  plotOptions: {
    pie: {
      innerSize: 100,
      depth: 25
    }
  },
  series: [{
    name: 'Average ratings',
     data: [
            <?php foreach($avg as $value){  ?> {
                name: '<?=$value->module?>',
                y: <?=$value->count ?>
            },
            <?php } ?>
        ]
  }]
});


Highcharts.chart('container', {
 chart: {
    type: 'column',
  },
  title: {
    text: 'Average module ratings'
  },
  subtitle: {
    text: 'Average ratings for each module'
  },
xAxis: { 
    title: {
            text: 'Modules'
        },
categories: [
    <?php foreach($avg as $value){  ?> '<?= $value->module ?>',
    <?php } ?>
]
},
  series: [{
    name: 'Average ratings',
    colorByPoint: true,
    data: [<?php foreach($avg as $valuet){ echo $valuet->count.','; }?>]
  }]
});


Highcharts.chart('containa', {
    title: {
        text: 'Daily ratings'
    },

    subtitle: {
        text: 'Based on users daily ratings.'
    },

    yAxis: {
        title: {
            text: 'Users (Rators)'
        }
    },

    xAxis: {
         title: {
            text: 'Dates'
        },
        categories: [
            <?php foreach($rators as $value){  ?> '<?=date("d-m-Y", strtotime($value->created_at))?>',
            <?php } ?>
        ]
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    series: [{
        name: 'Rators',
        data: [<?php foreach($rators as $valuet){ echo $valuet->count.','; }?>]
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

</script>


@endsection
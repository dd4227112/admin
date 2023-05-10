@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<?php $chart_files = base_url('public/theme/default/clearbar');
$performance = 60;
$start =date('Y-m-d', strtotime($from_date));
$end =date('Y-m-d', strtotime($to_date)); ?>


<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Users</a></li>
                    <li class="breadcrumb-item"><a href="<?=base_url(request()->segment(1).'/staffs')?>"><?=request()->segment(1)?></a></li>
                    <li class="breadcrumb-item active"><?= request()->segment(2) ?></li>
                </ol>
            </div>
            <h4 class="page-title"><?= $user->name ?> Dashboard</h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>
<div class="row">
                <form class="my-4 form-horizontal" role="form" method="POST">
                    @csrf
                    <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label for="start-date">From</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control mb-2" id="from_date" name="from_date" value="<?=$start?>"  placeholder="Start Date">
                    </div>
                    <div class="col-auto">
                        <label for="end-date">To</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control mb-2"  id="to_date" name="to_date" value="<?=$end?>" placeholder="End Date">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-success mb-2">View Report</button>
                    </div>
                    </div>
                </form>

            </div>

<!-- end page title end breadcrumb -->
<div class="row">
    <?php

    function fileExtension($file) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if (in_array($ext, ['xls', 'csv', 'xlsx'])) {
            return 'file-excel';
        } else if ($ext == 'pdf') {
            return 'file-pdf';
        } else if ($ext == 'doc') {
            return 'file-document';
        } else if($ext=='ppt'){
            return 'file-powerpoint';
        } else {
            return 'file-outline';
        }
    }
   
    $derived_targets = $user->staffTargets()->where('is_derived', 1)->whereBetween('created_at', [$from_date, $to_date])->get();
    foreach ($derived_targets as $targ) {
        // $cur_value = \collect(DB::select($targ->is_derived_sql))->first();
        $cur_value = DB::connection($targ->connection)->select($targ->is_derived_sql);

        $performance = !empty($cur_value) && (int) $cur_value['0']->current_value > 0 ? round($cur_value['0']->current_value * 100 / $targ->value) : 0;
        ?>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 align-self-center">
                            <!-- <div class="icon-info">
                                <i data-feather="activity" class="align-self-center icon-md icon-dual-primary"></i>
                            </div>  -->
                        </div>
                        <div class="col-8 align-self-center text-right">
                            <div class="ml-2">
                                <p class="text-dark mb-1 font-weight-semibold font-13"><?= $targ->kpi ?></p>
                                <h3 class="mt-0 mb-1 font-weight-semibold"><?= $performance ?>%</h3>  
                                <p style="font-size: 20px;"><span class="badge badge-primary">Target: <?= number_format(round($targ->value)) ?></span><br/>
    
                                        <span class="badge badge-success mt-1 shadow-none">Reached: <?= !empty($cur_value) ? number_format(round($cur_value['0']->current_value)) : 0 ?></span></p>
                            </div>
                        </div>                    
                    </div>
                    <div class="progress mt-2" style="height:3px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width:<?= $performance ?>%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
       
<?php } ?>
</div><!--end row-->

<div class="row">
    <div class="col-lg-8">                                                        
        <div class="card">
            <div class="card-body">  
                <h4 class="header-title mt-0">Staff Monthly Performance</h4>                                 
                <div class="">
                    <div id="liveVisits" class="apex-charts"></div>
                </div>  
            </div><!--end card-body-->                                                           
        </div><!--end card-->                                
    </div><!--end col-->
    <div class="col-xl-4">                            
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title">Overall Staff Performance</h4>


                <div class="m-0">
                    <div id="apex_radialbar3" class="apex-charts"></div>
                </div> 
                <div class="bg-light p-3 d-flex justify-content-between">
                    <div>
                        <h3 class="mb-1 font-weight-semibold"><?= $user->staffTargets()->whereBetween('created_at', [$from_date, $to_date])->count() ?></h3>
                        <p class="text-muted mb-0">Targets Allocated</p>
                    </div>
                    <div class="img-group align-self-center">
                        <span class="user-avatar user-avatar-group" href="#">
                            Reports Submitted
                        </span>

                        <a href="<?=base_url('users/show/'.$user->id)?>" class="avatar-box thumb-xs align-self-center">
                            <span class="avatar-title bg-soft-info rounded-circle font-13 font-weight-normal">
                                <?=$user->staffReports()->whereBetween('created_at', [$from_date, $to_date])->count()?></span>
                        </a>    
                    </div>
                </div>                                    
            </div><!--end card-body-->
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->


<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 mb-3"><?= $user->name ?> KPI Report</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>KPI</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Target</th>  
                                <th>Is Derived</th>                                                    
                                <th>Reached</th>
                                <th>Performance</th>
                            </tr><!--end tr-->
                        </thead>

                        <tbody>

                            <?php
                            $r = 1;
                            $avg_performance = 0;
                            foreach ($user->staffTargets()->whereBetween('created_at', [$from_date, $to_date])->get() as $target) {
                                if ((int) $target->is_derived == 1) {
                                    // $cur_value = \collect(DB::select($target->is_derived_sql))->first();
                                    $cur_value = DB::connection($target->connection)->select($target->is_derived_sql);

                                    $performance =  $cur_value['0']->current_value;
                                } else {
                                    $performance = $target->staffTargetsReports()->sum('current_value');
                                }
                                ?>
                                <tr>
                                    <td><?= $r ?></td>
                                    <td><?= $target->kpi ?></td>
                                    <td><?= $target->start_date ?></td>
                                    <td><?= $target->end_date ?></td>
                                    <td><?= $target->value ?></td>
                                    <td><?= $target->is_derived == 1 ? 'Yes' : 'No' ?></td>
                                    <td><?= $performance ?></td>
                                    <td><?= (float) $target->value > 0 ? round($performance * 100 / $target->value) : 0 ?>%</td>

                                </tr><!--end tr-->   
                                <?php
                                $avg_performance += (float) $target->value > 0 ? round($performance * 100 / $target->value) : 0;
                                $r++;
                            }
                            $avg = (int) $r == 1 ? 0 : round($avg_performance / ($r - 1))
                            ?>
                        </tbody>
                    </table>                    
                </div>  
            </div><!--end card-body-->
        </div><!--end card-->
    </div><!--end col-->
    <div class="col-lg-4">
        <div class="card">                                       
            <div class="card-body"> 
                <h4 class="header-title mt-0 mb-3">Activity</h4>
                <div class="slimscroll crm-dash-activity">
                    <div class="activity">
                        <?php
                        $comments = $user->staffReports()->whereBetween('created_at', [$from_date, $to_date])->get();
                        foreach ($comments as $comment) {
                            ?>
                            <div class="activity-info">
                                <div class="icon-info-activity">
                                    <i class="las la-check-circle bg-soft-<?= $comment->status == 1 ? 'success' : 'primary' ?>"></i>
                                </div>
                                <div class="activity-info-text">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 w-75"><?= $comment->status == 1 ? 'Task finished' : 'Task Onprogress' ?></h6>
                                        <span class="text-muted d-block"><?= timeAgo($comment->created_at) ?></span>
                                    </div>
                                    <p class="text-muted mt-3"><?= $comment->comment ?> </p>

                                    <div class="media">
                                        <i class="mdi mdi-<?= fileExtension($comment->attach) ?>" style="font-size: 60px; color: green;"></i>
                                        <div class="media-body align-self-center">                                                          
                                            <h4 class="mt-0 mb-1 title-text text-dark"><?= $comment->attach_file_name ?></h4>
                                            <a href="<?= $comment->attach ?>"><span class="px-2 py-1 bg-soft-success d-inline-block">Download File</span></a>
                                            <a href="<?= $comment->attach ?>" class="bg-soft-purple px-2 py-1"><i class="dripicons-download"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div> 
<?php } ?>

                    </div><!--end activity-->
                </div><!--end crm-dash-activity-->
            </div>  <!--end card-body-->                                     
        </div><!--end card--> 
    </div><!--end col-->  
</div><!--end row-->


<script src="<?= $chart_files ?>/plugins/chartjs/chart.min.js"></script>
<script src="<?= $chart_files ?>/assets/pages/jquery.chartjs.init.js?v=91"></script>
<script src="<?= $chart_files ?>/plugins/apexcharts/apexcharts.min.js"></script> 


<script type="text/javascript">

    var options = {
        chart: {
            height: 270,
            type: 'radialBar',
        },
        plotOptions: {
            radialBar: {
                startAngle: -135,
                endAngle: 135,
                hollow: {
                    margin: 0,
                    size: "55%",
                },
                track: {
                    background: '#b9c1d4',
                    opacity: 0.3,
                    strokeWidth: '90%',
                },
                dataLabels: {
                    name: {
                        fontSize: '15px',
                        color: '#8997bd',
                        offsetY: 95,
                        fontFamily: 'Roboto, sans-serif',
                    },
                    value: {
                        offsetY: 50,
                        fontSize: '22px',
                        color: '#8997bd',
                        formatter: function (val) {
                            return val + "%";
                        }
                    }
                }
            }
        },
        fill: {
            gradient: {
                enabled: true,
                shade: 'dark',
                shadeIntensity: 0.15,
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 65, 91]
            },
        },
        stroke: {
            dashArray: 4,
        },
        colors: ["<?php
if ((int) $avg >= 80) {
    echo '#2ddab5';
} else if ((int) $avg < 80 && (int) $avg > 40) {
    echo '#fda354';
} else {
    echo '#ef4d56';
}
?>"],
        series: [<?= $avg ?>],
        labels: ['<?= $user->name?> Performance'],
        responsive: [{
                breakpoint: 380,
                options: {
                    chart: {
                        height: 280
                    }
                }
            }]
    }

    var chart = new ApexCharts(
            document.querySelector("#apex_radialbar3"),
            options
            );

    chart.render();

//monthly performance
    var options = {
        chart: {
            height: 380,
            type: 'line',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            },
        },
        colors: ['#f6d365', '#0acf97'],
        dataLabels: {
            enabled: true,
        },
        stroke: {
            width: [3, 3],
            curve: 'smooth'
        },
        series: [

            {
                name: "<?= date('Y') ?>",
                data:
                        [
<?php
for ($m = 1; $m <= 12; $m++) {
    $start_date = date('Y') . '-' . $m . '-01';
    $date = new DateTime('last day of ' . date('Y') . '-' . $m);
    $end_date = $date->format('Y-m-d');
    $sql = 'select count(distinct staff_report_id) as total_reports from shulesoft.staff_targets_reports a where a.staff_report_id in (select id from shulesoft.staff_report where user_id=' . $user->id . ' and date between \'' . $start_date . '\' and \'' . $end_date . '\')';

    $month_reports = \collect(DB::select($sql))->first();

    $monthavg = !empty($month_reports) ? $month_reports->total_reports : 0;
    echo $monthavg . ',';
}
?>
                        ]
            },
        ],
        title: {
            text: 'Monthly Reports Submitted',
            align: 'left',
            style: {
                fontSize: "14px",
                color: '#8997bd',
                fontWeight: '500',
                marginBottom: '10px'
            }
        },
        grid: {
            row: {
                colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.2
            },
            borderColor: '#f1f3fa'
        },
        markers: {
            style: 'inverted',
            size: 6
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            axisBorder: {
                show: true,
                color: '#bec7e0',
            },
            axisTicks: {
                show: true,
                color: '#bec7e0',
            },
            title: {
                text: 'Month'
            }
        },
        yaxis: {
            title: {
                text: 'Averages'
            },
            min: 0,
            max: 100
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -25,
            offsetX: 5
        },
        responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        toolbar: {
                            show: false
                        }
                    },
                    legend: {
                        show: false
                    },
                }
            }]
    }

    var chart = new ApexCharts(document.querySelector("#liveVisits"), options);
    chart.render();
</script>
@endsection
@section('footer')
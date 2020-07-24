@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/';
$page = request()->segment(3);
$today = 0;

if ((int) $page == 1 || $page == 'null' || (int) $page == 0) {
    //current day
    $where = '  a.created_at::date=CURRENT_DATE';
    $today = 1;
    $year = date('Y');
} else {
    $start_date = date('Y-m-d', strtotime(request('start')));
    $end_date = date('Y-m-d', strtotime(request('end')));
    $year = date('Y', strtotime(request('start')));
    $where = "  a.created_at::date >='" . $start_date . "' AND a.created_at::date <='" . $end_date . "'";
}
?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Analytic Dashboard</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dasboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Analytic Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8"></div>
            <div class="col-lg-4 text-right">
                <select class="form-control" id="check_custom_date">
                    <option value="today" <?= $today == 1 ? 'selected' : '' ?>>Today</option>
                    <option value="custom"  <?= $today == 0 ? 'selected' : '' ?>>Custom</option>
                </select>

            </div>
        </div>
        <div class="row" style="display: none" id="show_date">

            <div class="col-lg-4"></div>
            <div class="col-lg-8 text-right">
                <h4 class="sub-title">Date Time Picker</h4>
                <div class="input-daterange input-group" id="datepicker">
                    <input type="date" class="input-sm form-control calendar" name="start" id="start_date">
                    <span class="input-group-addon">to</span>
                    <input type="date" class="input-sm form-control" name="end" id="end_date">
                    <input type="submit" class="input-sm btn btn-sm btn-success" id="search_custom"/>
                </div>
            </div>

        </div>
        <br/>
        <div class="page-body">
            <div class="row">

                <!-- Facebook card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card social-widget-card">
                        <div class="card-block-big bg-facebook">
<?php
$unique_visitors = \collect(DB::select('select count(*) from (select distinct platform,user_agent from admin.website_logs a where ' . $where . '  ) x '))->first()->count;
?>
                            <h3><?= $unique_visitors ?></h3>
                            <span class="m-t-10">Website Visits</span>
                            <i class="icofont icofont-ui-user-group"></i>
                        </div>
                    </div>
                </div>
                <!-- Facebook card end -->
                <!-- Twitter card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card social-widget-card">
                        <div class="card-block-big bg-twitter">
<?php
$total_sms_sent = \collect(DB::select('select count(*) from public.sms a where department_id=8 and ' . $where))->first()->count;
?>
                            <h3><?= $total_sms_sent ?></h3>
                            <span class="m-t-10">SMS Sent</span>
                            <i class="icofont icofont-email"></i>
                        </div>
                    </div>
                </div>
                <!-- Twitter card end -->
                <!-- Linked in card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card social-widget-card">
                        <div class="card-block-big bg-linkein">
<?php
$email_total_reacherd = \collect(DB::select('select count(*) from public.email a where department_id=8 and ' . $where))->first()->count;
?>
                            <h3><?= $email_total_reacherd ?></h3>
                            <span class="m-t-10">Email Sent</span>
                            <i class="icofont icofont-email"></i>
                        </div>
                    </div>
                </div>
                <!-- Linked in card end -->


                <!-- Google-plus card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card social-widget-card">
                        <div class="card-block-big bg-google-plus">
                            <h3>1</h3>
                            <span class="m-t-10">Upcoming Events</span>
                            <i class="icofont icofont-code-alt"></i>
                        </div>
                    </div>
                </div>
                <!-- Google-plus card end -->
                <div class="col-md-12 col-xl-4">
                    <div class="card counter-card-1">
                        <div class="card-block-big">
                            <div>
<?php
$total_reacherd = \collect(DB::select("select (count(distinct school_id) + count(distinct client_id)) as count from admin.tasks_schools a, admin.tasks_clients b where b.task_id in (select id from admin.tasks a where task_type_id in (select id from task_types where department=2) and " . $where . ") and a.task_id in (select id from admin.tasks a where task_type_id in (select id from task_types where department=2) and " . $where . ")"))->first()->count;
?>
                                <h3><?= $total_reacherd ?></h3>
                                <p>Total School Reached
<!--                                    <span class="f-right text-primary">
                                        <i class="icofont icofont-arrow-up"></i>
                                        37.89%
                                    </span>-->
                                </p>
                                <div class="progress ">
                                    <!--<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>-->
                                </div>
                            </div>
                            <i class="icofont icofont-comment"></i>
                        </div>
                    </div>
                </div>
                <!-- counter-card-1 end-->
                <!-- counter-card-2 start -->
                <div class="col-md-6 col-xl-4">
                    <div class="card counter-card-2">
                        <div class="card-block-big">
                            <div>
<?php
$total_schools = \collect(DB::select('select count(*) from admin.all_setting a WHERE  ' . $where))->first()->count;
?>
                                <h3><?= $total_schools ?></h3>
                                <p>Total Contacts Reached
<!--                                    <span class="f-right text-success">
                                        <i class="icofont icofont-arrow-up"></i>
                                        34.52%
                                    </span>-->
                                </p>
                                <div class="progress ">
                                    <!--<div class="progress-bar progress-bar-striped progress-xs progress-bar-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>-->
                                </div>
                            </div>
                            <i class="icofont icofont-coffee-mug"></i>
                        </div>
                    </div>
                </div>
                <!-- counter-card-2 end -->
                <!-- counter-card-3 start -->
                <div class="col-md-6 col-xl-4">
                    <div class="card counter-card-3">
                        <div class="card-block-big">
                            <div>
<?php
$total_activity = \collect(DB::select('select count(*) from admin.tasks a where  a.task_type_id in (select id from admin.task_types where department=2) and ' . $where))->first()->count;
?>
                                <h3><?= $total_activity ?></h3>
                                <p>Total Marketing Activities
<!--                                    <span class="f-right text-default">
                                        <i class="icofont icofont-arrow-down"></i>
                                        22.34%
                                    </span>-->
                                </p>
                                <div class="progress ">
                                    <!--<div class="progress-bar progress-bar-striped progress-xs progress-bar-default" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>-->
                                </div>
                            </div>
                            <i class="icofont icofont-upload"></i>
                        </div>
                    </div>
                </div>

                <!-- NVD3 chart start -->
                <div class="col-md-6 col-xl-7">
                    <div class="card">
                        <div class="card-header">
                            <h5>Website Visitor</h5>
                            <span>shows number of total visitors</span>
                        </div>
                        <div class="card-block">
                            <div id="linechart" class="nvd-chart">

                                <?php
                                $sql_ = "select count(*),created_at::date from (select distinct platform,user_agent,created_at::date from admin.website_logs a where " . $where . "  ) x  group by created_at::date ";

                                echo $insight->createChartBySql($sql_, 'created_at', 'Total Users Login', 'bar', false);
                                ?>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-xl-5">

                    <div class="card ">

                        <div class="section section-info">
                            <span class="info-time">Today 2:25 PM</span>
                            <h3 class="info-title">Website Visitors by Location</h3>

                            <div class="info-aapl">
                                <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

                                <script type="text/javascript">
//                                    $(function () {
//                                        $('#container2').highcharts({
//                                            chart: {
//                                                plotBackgroundColor: null,
//                                                plotBorderWidth: null,
//                                                plotShadow: false,
//                                                type: 'pie'
//                                            },
//                                            title: {
//                                                text: 'Browser market shares January, 2015 to May, 2015'
//                                            },
//                                            tooltip: {
//                                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
//                                            },
//                                            plotOptions: {
//                                                pie: {
//                                                    allowPointSelect: true,
//                                                    cursor: 'pointer',
//                                                    dataLabels: {
//                                                        enabled: true,
//                                                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
//                                                        style: {
//                                                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
//                                                        }
//                                                    }
//                                                }
//                                            },
//                                            series: [{
//                                                    name: 'Brands',
//                                                    colorByPoint: true,
//                                                    data: [{
//                                                            name: 'Microsoft Internet Explorer',
//                                                            y: 56.33
//                                                        }, {
//                                                            name: 'Chrome',
//                                                            y: 24.03,
//                                                            sliced: true,
//                                                            selected: true
//                                                        }, {
//                                                            name: 'Firefox',
//                                                            y: 10.38
//                                                        }, {
//                                                            name: 'Safari',
//                                                            y: 4.77
//                                                        }, {
//                                                            name: 'Opera',
//                                                            y: 0.91
//                                                        }, {
//                                                            name: 'Proprietary or Undetectable',
//                                                            y: 0.2
//                                                        }]
//                                                }]
//                                        });
//                                    });
                                </script>

                                <script src="https://code.highcharts.com/highcharts.js"></script>
                                <script src="https://code.highcharts.com/modules/exporting.js"></script>

                                <div id="container2" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>



                            </div>

                        </div>


                    </div>
                </div>
                <!-- Table end -->


                <div class="col-md-12 col-xl-12">
                    <div class="page-header-title">
                        <h4>ShuleSoft Statistics</h4>
                    </div>
                    <br/>
                </div>
                <div class="col-md-12 col-xl-4">
                    <div class="card counter-card-1">
                        <div class="card-block-big">
                            <div>
                                <h3>4000</h3>
                                <p>SMS sent
                                    <span class="f-right text-primary">
                                        <i class="icofont icofont-arrow-up"></i>
                                        37.89%
                                    </span></p>
                                <div class="progress ">
                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <i class="icofont icofont-comment"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card counter-card-2">
                        <div class="card-block-big">
                            <div>
                                <h3>2500</h3>
                                <p>Email Sent
                                    <span class="f-right text-success">
                                        <i class="icofont icofont-arrow-up"></i>
                                        34.52%
                                    </span>
                                </p>
                                <div class="progress ">
                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <i class="icofont icofont-coffee-mug"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card counter-card-3">
                        <div class="card-block-big">
                            <div>
                                <h3>24</h3>
                                <p>Schools with No Activities
                                    <span class="f-right text-default">
                                        <i class="icofont icofont-arrow-down"></i>
                                        22.34%
                                    </span></p>
                                <div class="progress ">
                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-default" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <i class="icofont icofont-upload"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-8">
                    <div class="card">

                        <div class="card-block">
                            <div id="login_graph"></div>
                            <?php
                            $sql_ = "select count(distinct (user_id,\"table\")) as count, created_at::date as date from admin.all_login_locations a where " . $where . " group by created_at::date ";
                            echo $insight->createChartBySql($sql_, 'date', 'Total Users Login', 'bar', false);
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Morris chart end -->
                <!-- Todo card start -->
                <div class="col-md-12 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Module Usage</h5>
                            <!--<label class="label label-success">Today</label>-->
                        </div>
                        <div class="card-block">

                            <div class="new-task">
                                <div class="table-responsive">
                                    <script type="text/javascript">
//                                    $(function () {
//                                        $('#container3').highcharts({
//                                            chart: {
//                                                plotBackgroundColor: null,
//                                                plotBorderWidth: null,
//                                                plotShadow: false,
//                                                type: 'pie'
//                                            },
//                                            title: {
//                                                text: 'Browser market shares January, 2015 to May, 2015'
//                                            },
//                                            tooltip: {
//                                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
//                                            },
//                                            plotOptions: {
//                                                pie: {
//                                                    allowPointSelect: true,
//                                                    cursor: 'pointer',
//                                                    dataLabels: {
//                                                        enabled: true,
//                                                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
//                                                        style: {
//                                                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
//                                                        }
//                                                    }
//                                                }
//                                            },
//                                            series: [{
//                                                    name: 'Brands',
//                                                    colorByPoint: true,
//                                                    data: [{
//                                                            name: 'Microsoft Internet Explorer',
//                                                            y: 56.33
//                                                        }, {
//                                                            name: 'Chrome',
//                                                            y: 24.03,
//                                                            sliced: true,
//                                                            selected: true
//                                                        }, {
//                                                            name: 'Firefox',
//                                                            y: 10.38
//                                                        }, {
//                                                            name: 'Safari',
//                                                            y: 4.77
//                                                        }, {
//                                                            name: 'Opera',
//                                                            y: 0.91
//                                                        }, {
//                                                            name: 'Proprietary or Undetectable',
//                                                            y: 0.2
//                                                        }]
//                                                }]
//                                        });
//                                    });
                                    </script>


                                    <div id="container3" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Todo card end -->
                <!-- Social user card end -->
                <!-- Live-chart start -->
                <div class="col-xl-5 dashbored-live-left col-lg-6">
                    <div class="card widget">
                        <div class="section section-graph">
                            <div class="graph-info">
                                Task Types Done
                            </div>
                            <div id="graph"></div>
                        </div>
                        <div class="section section-info">



                        </div>
                    </div>
                    <div class="section"></div>
                </div>
                <!-- Live-chart end -->
                <!-- Last activity start -->
                <div class="col-xl-7">
                    <div class="card">
                        <div class="card-header">
                            <h5>Marketing Activities</h5>
                            <div class="f-right">
                                <label class="label label-success">Today</label>
                                <label class="label label-danger">Month</label>
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            <div class="table-responsive analytic-table">
                                <table id="res-config" class="table table-bordered w-100 dataTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Task Type</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $activities = DB::select("select a.activity,a.created_at,b.name as task_name, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.task_types b on b.id=a.task_type_id join admin.users c on c.id=a.user_id WHERE  a.task_type_id in (select id from admin.task_types where department=4) and " . $where);
                                        foreach ($activities as $activity) {
                                            ?>                    
                                            <tr>
                                                <td class="img-pro">
    <?= $activity->user_name ?>
                                                </td>
                                            <!--    <td class="pro-name"><?= $activity->activity ?>
                                                </td>-->
                                                <td>  <?= $activity->task_name ?></td> 
                                                <td>
                                                    <label class="text-danger">  <?= $activity->created_at ?></label>
                                                </td>

                                            </tr>
<?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Last activity end -->


            </div>
        </div>
    </div>
</div>
@endsection
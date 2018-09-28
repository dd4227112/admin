@extends('layouts.app')
@section('content')

@role('marketing','admin')
<?php
$user = array();
$total_users = 0;
foreach ($users as $key => $value) {
    # code...
    $user[$value->usertype] = $value->count;
    $total_users += $value->count;
}
?>


<div class="row">
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="white-box">
            <h3 class="box-title">Total Accounts</h3>
            <ul class="list-inline m-t-30 p-t-10 two-part">
                <li><i class="icon-people text-info"></i></li>
                <li class="text-right"><span class="counter"><?= $total_users ?></span></li>
            </ul>

        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="white-box">
            <h3 class="box-title">Total Parents</h3>
            <ul class="list-inline m-t-30 p-t-10 two-part">
                <li><i class="icon-people text-info"></i></li>
                <li class="text-right"><span class="counter"><?= $user['Parent'] ?></span></li>
            </ul>
            <div class="pull-right"><?= round($user['Parent'] * 100 / $total_users, 2) ?>% <i class="fa fa-level-up text-success"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="white-box">
            <h3 class="box-title">Total Students</h3>
            <ul class="list-inline m-t-30 p-t-10 two-part">
                <li><i class="icon-people text-info"></i></li>
                <li class="text-right"><span class="counter"><?= $user['Student'] ?></span></li>
            </ul>
            <div class="pull-right"><?= round($user['Student'] * 100 / $total_users, 2) ?>% <i class="fa fa-level-up text-success"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="white-box">
            <h3 class="box-title">Total Teachers</h3>
            <ul class="list-inline m-t-30 p-t-10 two-part">
                <li><i class="icon-people text-info"></i></li>
                <li class="text-right"><span class="counter"><?= $user['Teacher'] ?></span></li>
            </ul>
            <div class="pull-right"><?= round($user['Teacher'] * 100 / $total_users, 2) ?>% <i class="fa fa-level-up text-success"></i></div>
        </div>

    </div>
</div>




<div class="row">
    <div class="col-lg-4 col-md-12">
        <div class="white-box">
            <h3 class="box-title">Other Users</h3>
         
        </div>
    </div>
    <div class="col-md-12 col-lg-8">
        <div class="white-box bg-extralight m-b-0">
            <div class="city-weather-widget">
                <h3>Log Requests</h3>
                <div class="row">


                    <?php
                    $sql = "select distinct user_id from all_log where created_at::date='" . date('Y-m-d') . "' and user_id is not null";
                    $log_request = count(\DB::select($sql));
                    $all_log_request = count(\DB::select("select distinct user_id from all_log where user_id is not null"));
                    ?>
                    <script type="text/javascript">
                        $(function () {
                            $('#container').highcharts({
                                chart: {
                                    plotBackgroundColor: null,
                                    plotBorderWidth: null,
                                    plotShadow: false,
                                    type: 'pie'
                                },
                                title: {
                                    text: 'Total users login Today <?= date('d M Y') ?>'
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                            style: {
                                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                            }
                                        }
                                    }
                                },
                                series: [{
                                        name: 'Users',
                                        colorByPoint: true,
                                        data: [{
                                                name: 'Total Users Login',
                                                y: <?= $log_request ?>
                                            }, {
                                                name: 'Total Users',
                                                y: <?= count($users) ?>,
                                                sliced: true,
                                                selected: true
                                            }]
                                    }]
                            });
                        });
                            $(function () {
                            $('#container2').highcharts({
                                chart: {
                                    plotBackgroundColor: null,
                                    plotBorderWidth: null,
                                    plotShadow: false,
                                    type: 'pie'
                                },
                                title: {
                                    text: 'Total users login ratio'
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                            style: {
                                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                            }
                                        }
                                    }
                                },
                                series: [{
                                        name: 'Users',
                                        colorByPoint: true,
                                        data: [{
                                                name: 'Total Users Login',
                                                y: <?= $all_log_request ?>
                                            }, {
                                                name: 'Total Users',
                                                y: <?= count($users) ?>,
                                                sliced: true,
                                                selected: true
                                            }]
                                    }]
                            });
                        });
                    </script>
                    </head>
                    <body>
                        <script src="<?= url('public/js/highcharts.js') ?>"></script>
                        <script src="<?= url('public/js/exporting.js') ?>"></script>

                        <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
      <div id="container2" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

                </div>
            </div>
        </div>

    </div>
</div>
@endrole

@role('Bank')
<div class="row">

    <div class="col-md-12 col-lg-8">
        <div class="white-box">
            <div class="row">
                <div class="col-sm-8">
                    <h2 class="m-b-0 font-medium">Search Invoice</h2>
                    <h5 class="text-muted m-t-0">Payment Reference Number</h5></div>
                <div class="col-sm-12">
                    <form action="<?=url('searchInvoice')?>" method="post"/>
                    <div class="form-group">
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="invoice" placeholder="Seach"> 
                        </div>
                        <div class="col-md-4">
                            <?= csrf_field() ?>
                            <input type="submit" class="btn btn-small btn-success" value="search"/>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="white-box">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="m-b-0 font-medium">Tsh 356,000,000</h2>
                    <h5 class="text-muted m-t-0">Total Posted Today</h5></div>

            </div>
        </div>
    </div>

</div>
@endrole
@endsection

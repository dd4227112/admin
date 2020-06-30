@extends('layouts.app')
@section('content')

<script type="text/javascript" src="<?= url('/public') ?>/assets/select2/select2.js"></script> 

<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>e-Payment Summary</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">e-Payments </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-lg-6"></div>
                <div class="card table-card widget-danger-card col-lg-6">
                    <div class="card-footer">
                        <div class="task-list-table">
                            <p class="task-due"><strong>School with highest e-payments: </strong><strong class="label label-danger"><?= count($danger_schema) == 1 ? $danger_schema->schema_name : '' ?></strong></p>
                        </div>
                        <div class="task-board m-0">
                            <a href="#" class="btn btn-info btn-mini b-none" title="view"><i class="icofont icofont-eye-alt m-0"></i></a>

                        </div>
                        <!-- end of pull-right class -->
                    </div>
                </div>
            </div>
            <div class="row">

                <!-- Documents card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks dark-primary-border">
                        <div class="card-block">
                            <h5>School Connected with NMB</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-document-folder"></i>
                                </li>
                                <li class="text-right">
                                    <?= $schools_connected ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Documents card end -->
                <!-- New clients card start -->

                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks warning-border">
                        <div class="card-block">
                            <h5>Schools with Other Banks</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-ui-user-group text-warning"></i>
                                </li>
                                <li class="text-right text-warning">
                                    <?= DB::table('admin.all_setting')->count() - $schools_connected ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


                <!-- Open Project card end -->
                <div class="col-md-12 col-xl-12">
                    <div class="form-group row col-lg-offset-6">
                        <label class="col-sm-4 col-form-label">Select School</label>
                        <div class="col-sm-4">
                            <select name="select" class="form-control select2" id="schema_select">
                                <option value="0">Select</option>
                                <?php
                                $schemas = DB::select('select distinct "schema_name" from admin.all_payments where token is not null');
                                foreach ($schemas as $schema) {
                                    ?>
                                    <option value="<?= $schema->schema_name ?>"><?= $schema->schema_name ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-12">
                    <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                    <strong>( <?= count($epayment_logs) ?>)</strong> Payments Logs Summary
                                </a>
                                <div class="slide"></div>
                            </li>

                            <li class="nav-item complete">
                                <a class="nav-link" data-toggle="tab" href="#messages3" role="tab" aria-expanded="false">Summary</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item complete">
                                <a class="nav-link" data-toggle="tab" href="#messages4" role="tab" aria-expanded="false">All schools connected</a>
                                <div class="slide"></div>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">

                                <div class="card-block">

                                    <script src="https://code.highcharts.com/highcharts.js"></script>
                                    <script src="https://code.highcharts.com/modules/data.js"></script>
                                    <script type="text/javascript">
                                        graph_disc = function () {
                                            Highcharts.chart('container', {
                                                chart: {
                                                    type: 'column'
                                                },
                                                title: {
                                                    text: "e-Payments done per year <?= date('Y') ?>"
                                                },
                                                subtitle: {
                                                    text: ''
                                                },
                                                xAxis: {
                                                    type: 'category'
                                                },
                                                yAxis: {
                                                    title: {
                                                        text: 'No of Payments'
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
                                                            format: '{point.y:.1f}'
                                                        }
                                                    }
                                                },
                                                tooltip: {
                                                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
                                                },
                                                series: [{
                                                        name: 'Avarage',
                                                        colorByPoint: true,
                                                        data: [
<?php
$where = strlen(request()->segment(3)) > 3 ? ' and "schema_name"=\'' . request()->segment(3) . '\'' : '';
$epayments = \DB::select('select count(*),extract(month from created_at) as month from admin.all_payments where token is not null and extract(year from created_at)=' . date('Y') . $where . ' group by extract(month from created_at) order by extract(month from created_at) asc');
foreach ($epayments as $epayment) {
    $monthNum = $epayment->month;
    $dateObj = \DateTime::createFromFormat('!m', $monthNum);
    $monthName = $dateObj->format('F');
    ?>
                                                                {
                                                                    name: '<?= ucwords($monthName) ?>',
                                                                    y: <?php
    echo $epayment->count;
    ?>,
                                                                    drilldown: ''
                                                                },
    <?php
}
?>
                                                        ]
                                                    }]
                                            });
                                        }
                                        $(document).ready(graph_disc);
                                    </script>


                                    <div id="container" style="min-width: 70%;  height: 480px; margin: 0 auto"></div>
                                </div>


                            </div>

                            <div class="tab-pane" id="messages3" role="tabpanel" aria-expanded="false">
                                <a href="#" class="btn btn-sm btn-success" id="show_summary" style="display: none">Show Summary</a>
                                <div id="custom_logs"></div>
                                <div class="email-card p-0" id="log_summary">
                                    <div class="card-block">

                                        <div class="mail-body-content">
                                            <div class="card">


                                                <div class="card-block table-border-style">
                                                    <div class="table-responsive analytic-table">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>School Name</th>
                                                                    <th>E-payment Requests</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sql = 'select "schema_name",count(*) from admin.all_payments where token is not null group by "schema_name"';
                                                                $logs = DB::select($sql);
                                                                foreach ($logs as $log) {
                                                                    ?>
                                                                    <tr>
                                                                        <td>

                                                                            <span class="table-msg"><?= $log->schema_name ?></span>
                                                                        </td>
                                                                        <td><?= $log->count ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                <?php }
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


                            <div class="tab-pane" id="messages4" role="tabpanel" aria-expanded="false">
                                <a href="#" class="btn btn-sm btn-success" id="show_summary" style="display: none">Show Summary</a>
                                <div id="custom_logs"></div>
                                <div class="email-card p-0" id="log_summary">
                                    <div class="card-block">

                                        <div class="mail-body-content">
                                            <div class="card">


                                                <div class="card-block table-border-style">
                                                    <div class="table-responsive analytic-table">
                                                        
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>School Name</th>
                                                                    <th>Location</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sql2 = 'select * from admin.all_setting where payment_integrated=1';
                                                                $schools = DB::select($sql2);
                                                                foreach ($schools as $school) {
                                                                    ?>
                                                                    <tr>
                                                                        <td>

                                                                            <span class="table-msg"><?= $school->schema_name ?></span>
                                                                        </td>
                                                                        <td><?= $school->address ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                <?php }
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
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#schema_select').change(function () {
        var schema = $(this).val();
        if (schema == 0) {
            return false;
        } else {
            window.location.href = "<?= url('customer/epayments') ?>/" + schema;
        }
    });

    getErrorPage = function (a) {
        $.ajax({
            url: '<?= url('software/logsView') ?>/null',
            method: 'get',
            data: {type: a},
            success: function (data) {
                $('#log_summary').hide();
                $('#custom_logs').html(data).show();
                $('#show_summary').show();
                console.log(data);
            }
        });
    }
    $('#show_summary').mousedown(function () {
        $(this).hide();
        $('#log_summary').show();
        $('#custom_logs').hide();
    });


    $('#schema_select').select2({
        placeholder: "Select a State",
        allowClear: true
    });
</script>
@endsection

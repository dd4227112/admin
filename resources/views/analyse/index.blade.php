@extends('layouts.app')
@section('content')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<?php $root = url('/') . '/public/';  ?>

<div class="page-wrapper">
  
    <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

    <div class="page-body">
        <div class="row">
            <?php if (can_access('manage_users')) { ?>
                <div class="col-xl-3 col-md-6">
                        <div class="card bg-c-yellow text-white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Users</p>
                                            <h4 class="m-b-0" id=""> <?= number_format($summary['users'])?></h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-users f-50 text-c-yellow"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-green text-white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Parents</p>
                                            <h4 class="m-b-0" id=""><?= number_format($summary['parents']) ?></h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-users f-50 text-c-green"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-blue text-white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Students</p>
                                            <h4 class="m-b-0" id=""><?= number_format($summary['students']) ?></h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-users f-50 text-c-pink"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-blue text-white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Teachers</p>
                                            <h4 class="m-b-0" id=""> <?= number_format($summary['teachers']) ?></h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-users f-50 text-c-blue"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-c-yellow text-white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Active Users</p>
                                            <h4 class="m-b-0" id=""> <?= number_format($summary['active_users']) ?> </h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-users f-50 text-c-yellow"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-green text-white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Active Parents</p>
                                            <h4 class="m-b-0" id=""> <?= number_format($summary['active_parents']) ?> </h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-users f-50 text-c-green"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-pink text-white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Active Students</p>
                                            <h4 class="m-b-0"><?= number_format($summary['active_students']) ?> </h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-users f-50 text-c-pink"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-blue text-white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Active teachers</p>
                                            <h4 class="m-b-0" id=""> <?= number_format($summary['active_teachers']) ?></h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-users f-50 text-c-blue"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                <div class="col-lg-12">
                    <div class="card">
                        <figure class="highcharts-figure">
                            <div id="container" style="height: 300px;"></div>
                        </figure>
                    </div>
                </div>
            <?php } ?>

            <div class="col-lg-12">
                <div class="card card-border-primary">
                    <div class="card-header">
                        <h5>My User Activities</h5>

                    </div>
                    <div class="card-block">

                        <div class="table-responsive">
                            <table class="table dataTable">
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
</div>
{{-- 
<table id="users_table" style="display:none">
    <thead>
        <tr>
            <th></th>
            <th>User Feedback</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $logs = DB::select('select count(*),extract(month from created_at) as month from constant.feedback where extract(year from created_at)=' . date('Y') . ' group by month order by month');
        foreach ($logs as $log) {
            $monthNum = $log->month;
            $dateObj = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F'); // March
            ?>
            <tr>
                <th><?= $monthName ?></th>
                <td><?= $log->count ?></td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>
<table id="users_sales" style="display:none">
    <thead>
        <tr>
            <th></th>
            <th>User Feedback</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $new_schools = DB::select('select count(*),extract(month from created_at) as month from admin.all_setting where extract(year from created_at)=' . date('Y') . ' group by month order by month');
        foreach ($new_schools as $new_school) {
            $monthNum = $new_school->month;
            $dateObj = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F'); // March
            ?>
            <tr>
                <th><?= $monthName ?></th>
                <td><?= $new_school->count ?></td>
            </tr>
        <?php }
        ?>
    </tbody>
</table> --}}

<script>
Highcharts.chart('container', {

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
</script>

@endsection

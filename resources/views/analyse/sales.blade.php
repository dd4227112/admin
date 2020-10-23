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
$sqls1 = "select count(a.*),b.username from admin.tasks a join admin.tasks_clients c on a.id=c.task_id join admin.clients b on b.id=c.client_id
                                                WHERE a.user_id in (select id from admin.users where department=2) and $where group by b.username
                                                UNION ALL
                                                select count(a.*),b.name from admin.tasks a join admin.tasks_schools c on a.id=c.task_id join admin.schools b on b.id=c.school_id
                                                WHERE a.user_id in (select id from admin.users where department=2) and $where group by b.name";
$taskss = DB::select($sqls1);

$total_activity = \collect(DB::select('select sizeof(*) from admin.tasks a where  a.user_id in (select id from admin.users where department=2) and ' . $where))->first()->count;?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Sales Dashboard</h4>
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
                    <li class="breadcrumb-item"><a href="#!">Sales Report</a>
                    </li>
                </ul>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4"></div>
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


        <?php
        $on = 'Today';
        if ($days == '' || $days == 1) {
            $days = 1;
            $on = 'Today';
        }if ($days == 7) {
            $on = 'This Week';
        }if ($days == 30) {
            $on = 'This Month';
        }if ($days == 90) {
            $on = 'Three Month';
        } if ($days == 181) {
            $on = 'Six Month';
        }if ($days == 365) {
            $on = 'This Year';
        }
        ?>

        <div class="page-body">
            <div class="row">
                <!-- Documents card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks dark-primary-border">
                        <div class="card-block">
                            <h5> Schools in ShuleSoft</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-list"></i>
                                </li>
                                <li class="text-right">
                                    <?php echo $shulesoft_schools; ?>
                                </li>
                                <span class="small"><?= round($shulesoft_schools * 100 / $schools, 1) ?>% Coverage</span>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Documents card end -->
                <!-- New clients card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks warning-border">
                        <div class="card-block">
                            <h5>NMB Schools</h5>
                            <ul>
                                <li>
                                    <i class="ti-layout text-warning"></i>
                                </li>
                                <li class="text-right text-warning">
                                    <?php echo $nmb_schools; ?>
                                </li>
                                <span class="small"><?= $shulesoft_nmb_schools . ' in ShuleSoft (' . round($shulesoft_nmb_schools * 100 / ((int) $nmb_schools == 0 ? 1 : $nmb_schools), 1) ?>%)</span>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- New clients card end -->
                <!-- New files card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks success-border">
                        <div class="card-block">
                            <h5>Our Clients</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-users text-success"></i>
                                </li>
                                <li class="text-right text-success">
                                    <?php echo $clients; ?>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- New files card end -->
                <!-- Open Project card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks">
                        <div class="card-block">
                            <h5>All Schools</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-ui-folder text-primary"></i>
                                </li>
                                <li class="text-right text-primary">
                                    <?php echo $schools; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Open Project card end -->
            </div>
            <div class="row">
                <!-- counter-card-1 start-->
                <div class="col-md-12 col-xl-4">
                    <div class="card counter-card-1">
                        <div class="card-block-big">
                            <div>
                                <?php
                               // $total_reacherd = \collect(DB::select("select (count(distinct school_id) + count(distinct client_id)) as count from admin.tasks_schools a, admin.tasks_clients b where b.task_id in (select id from admin.tasks a where a.user_id in (select id from admin.users where department=2) and " . $where . ") and a.task_id in (select id from admin.tasks a where a.user_id in (select id from admin.users where department=2) and " . $where . ")"))->first()->count;
                                ?>
                                <h3><?php echo sizeof($taskss); ?></h3>
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
                        </div>
                        <i class="icofont icofont-comment"></i>
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
                                <p>New Schools Onboarded
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

                <div class="col-md-6 col-xl-4">
                    <div class="card counter-card-3">
                        <div class="card-block-big">
                            <div>

                                <h3><?= $total_activity ?></h3>
                                <p>Total Sales Activities
<!--                                    <span class="f-right text-default">
                                        <i class="icofont icofont-arrow-down"></i>
                                        22.34%
                                    </span>-->
                                </p>
                                <div class="progress ">
                                    <!--<div class="progress-bar progress-bar-striped progress-xs progress-bar-default" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>-->
                                </div>
                            </div>
                        </div>
                        <i class="icofont icofont-upload"></i>
                    </div>
                </div>
            </div>
            <!-- counter-card-3 end -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                        <h5>Monthly On Boarded Schools</h5>
                        </div>
                        <div class="card-block">
                        <div class="table-responsive dt-responsive">
                                            <table id="dt-ajax-array" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Client</th>
                                                        <th>Address</th>
                                                        <th>Added Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1;
                                            $schoolz = DB::select('select * from admin.all_setting a WHERE  ' . $where);
                                        if(sizeof($schoolz)){
                                            foreach($schoolz as $school){ 
                                                ?>
                                                <tr>
                                                <td><?=$i++?></td>
                                                <td><?=ucfirst($school->sname)?></td>
                                                <td><?=ucfirst($school->address)?></td>
                                                <td><?=$school->created_at?></td>
                                                <td>
                                                <?php
                                                echo '<a href="'. url('customer/profile/'.$school->schema_name) .'">View</a>';
                                                ?>
                                                </td>
                                                </tr>

                                      <?php
                                            }
                                        }
                                        ?>
                            </tbody>
                                </table>
                        </div>
                    </div>
                </div>
                <!-- Monthly Growth Chart end-->
            <!-- Monthly Growth Chart start-->
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Monthly Success</h5>
                        </div>
                        <div class="card-block">
                            <?php
                            $new_schools = 'select count(*),extract(month from created_at) as month from admin.all_setting a
where extract(year from a.created_at)=' . $year . '  group by month order by month';
                            echo $insight->createChartBySql($new_schools, 'month', 'Onboarded Schools', 'line', false);
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Monthly Growth Chart end-->
                <!-- Google Chart start-->
                <div class="col-xl-6">
                <div class="card">
                                        <div class="card-header">
                                            <h5>Website Join Requests</h5>
                                        </div>
                                        <div class="card-block">
                                            <?php
                                            $new_schools = 'select count(*),extract(month from created_at) as month from admin.website_join_shulesoft a
                                                where extract(year from a.created_at)=' . $year . '  group by month order by month';
                                            echo $insight->createChartBySql($new_schools, 'month', 'Website Requests', 'line', false);
                                            ?>
                                        </div>
                                    </div>
                </div>
            </div>
            <!-- Recent Order table start -->


            <!-- Recent Order table end -->
            <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Sales Person Activity Ratio</h5>
                            </div>
                            <div class="card-block">
                                <?php
                                $sales_distribution = "select count(*) as count, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.users c on c.id=a.user_id WHERE   a.user_id in (select id from admin.users where department=2) and " . $where . " group by user_name";
                                echo $insight->createChartBySql($sales_distribution, 'user_name', 'Sales Activity', 'bar', false);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Sales Distribution Activities</h5>
                        </div>
                        <div class="card-block">
                            <?php
                            $sales_group = "select count(*),b.name as task_name from admin.tasks a join admin.task_types b on b.id=a.task_type_id WHERE  a.task_type_id in (select id from admin.task_types where department=2) and " . $where . " group by task_name";
                            echo $insight->createChartBySql($sales_group, 'task_name', 'Sales Group Activity', 'bar', false);
                            ?>
                        </div>
                    </div>
                </div>
                        
                                           
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
             
                    <!-- .events-content -->
                    <!-- Todo card start -->
                    <div class="row">

                    <!-- Horizontal Timeline end -->
                    <div class="col-lg-8 col-sm-12">
                        <div class="card widget-chat-box">
                            <div class="card-header">
                                        <h5>
                                            Tasks Activities
                                        </h5>
                                </div>
                                <div class="card-block">
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
                                        $activities = DB::select("select a.id, a.activity,a.created_at,b.name as task_name,a.user_id, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.task_types b on b.id=a.task_type_id join admin.users c on c.id=a.user_id WHERE   a.user_id in (select id from admin.users where department=2) and " . $where);
                                        foreach ($activities as $activity) {
                                            ?>
                                            <tr>
                                                <td class="img-pro">
                                                <a href="<?=url('customer/taskGroup/user/'.$activity->user_id)?>"><?= $activity->user_name ?></a>
                                                </td>
                                            <!--    <td class="pro-name"><?= $activity->activity ?>
                                                </td>-->
                                                <td> <a href="<?= url('customer/activity/show/'.$activity->id) ?>"> <?= $activity->task_name ?></a> </td>
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
                    <div class="col-lg-4 col-sm-12">
                        <!-- User activities chart start -->
                        <div class="card analytic-user">
                            <div class="card-block-big text-center">
                                <i class="icofont icofont-wallet"></i>
                                <?php
                                $student_sum = \collect(DB::select('select sum(students) from admin.schools WHERE id in (select school_id from admin.tasks a where  a.user_id in (select id from admin.users where department=2) and ' . $where . ')'))->first()->sum;
                                ?>
                                <h3>Tsh <?= number_format($student_sum * 10000) ?> /=</h3>
                                <h4>Projected Income</h4>
                            </div>
                            <div class="card-footer p-t-25 p-b-25">
                                <p class="m-b-0"></p>
                            </div>
                        </div>
                    </div>
                    <!-- User activities chart end -->
                </div>

          
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= $root ?>bower_components/jquery/dist/jquery.min.js"></script>

<script src="<?= url('/public') ?>/code/highcharts.js"></script>
<script src="<?= url('/public') ?>/code/modules/exporting.js"></script>
<script src="<?= url('/public') ?>/code/modules/export-data.js"></script>
<script src="<?= url('/public') ?>/code/modules/series-label.js"></script>
<script src="<?= url('/public') ?>/code/modules/data.js"></script>

<script>
    check = function () {
        $('#check_custom_date').change(function () {
            var val = $(this).val();
            if (val == 'today') {
                window.location.href = '<?= url('analyse/sales/') ?>/1';
            } else {
                $('#show_date').show();
            }
        });
    }
    submit_search = function () {
        $('#search_custom').mousedown(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            window.location.href = '<?= url('analyse/sales/') ?>/5?start=' + start_date + '&end=' + end_date;
        });
    }
    $(document).ready(check);
    $(document).ready(submit_search);
</script>
@endsection

@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-title">
            <h4>Dashboard</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Summary</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-body">
        <div class="row">
              <?php if (can_access('manage_users')) { ?>

                <div class="col-md-12 col-xl-4">
                    <!-- table card start -->
                    <div class="card table-card">
                        <div class="">
                            <div class="row-table">
                                <div class="col-sm-6 card-block-big br">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <i class="icofont icofont-eye-alt text-success"></i>
                                        </div>
                                        <div class="col-sm-8 text-center">
                                            <h5 id="all_users"></h5>
                                            <span>Users</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 card-block-big">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <i class="icofont icofont-ui-music text-danger"></i>
                                        </div>
                                        <div class="col-sm-8 text-center">
                                            <h5 id="all_parents"></h5>
                                            <span>Parents</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="row-table">
                                <div class="col-sm-6 card-block-big br">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <i class="icofont icofont-files text-info"></i>
                                        </div>
                                        <div class="col-sm-8 text-center">
                                            <h5 id="all_students"></h5>
                                            <span>Students</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 card-block-big">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <i class="icofont icofont-envelope-open text-warning"></i>
                                        </div>
                                        <div class="col-sm-8 text-center">
                                            <h5 id="all_teachers"></h5>
                                            <span>Teachers</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- table card end -->
                </div>
                <div class="col-md-12 col-xl-4">
                    <!-- table card start -->
                    <div class="card table-card">
                        <div class="">
                            <div class="row-table">
                                <div class="col-sm-6 card-block-big br">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div id="barchart" style="height:40px;width:40px;"></div>
                                        </div>
                                        <div class="col-sm-8 text-center">
                                            <h5 id="active_users"></h5>
                                            <span>(A) Users</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 card-block-big">
                                    <div class="row ">
                                        <div class="col-sm-4">
                                            <i class="icofont icofont-network text-primary"></i>
                                        </div>
                                        <div class="col-sm-8 text-center">
                                            <h5 id="active_parents"></h5>
                                            <span>(A)Parents</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="row-table">
                                <div class="col-sm-6 card-block-big br">
                                    <div class="row ">
                                        <div class="col-sm-4">
                                            <div id="barchart2" style="height:40px;width:40px;"></div>
                                        </div>
                                        <div class="col-sm-8 text-center">
                                            <h5 id="active_students"></h5>
                                            <span>(A)Students</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 card-block-big">
                                    <div class="row ">
                                        <div class="col-sm-4">
                                            <i class="icofont icofont-network-tower text-primary"></i>
                                        </div>
                                        <div class="col-sm-8 text-center">
                                            <h5 id="active_teachers"></h5>
                                            <span>(A)Teachers</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- table card end -->
                </div>
                <div class="col-md-12 col-xl-4">
                    <!-- widget primary card start -->
                    <div class="card table-card widget-primary-card">
                        <div class="">
                            <div class="row-table">
                                <div class="col-sm-3 card-block-big">
                                    <i class="icofont icofont-star"></i>
                                </div>
                                <div class="col-sm-9">
                                    <h4  id="schools_with_shulesoft"></h4>
                                    <h6>Schools in ShuleSoft</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- widget primary card end -->
                    <!-- widget-success-card start -->
                    <div class="card table-card widget-success-card">
                        <div class="">
                            <div class="row-table">
                                <div class="col-sm-3 card-block-big">
                                    <i class="icofont icofont-trophy-alt"></i>
                                </div>
                                <div class="col-sm-9">
                                    <h4 id="schools_with_students"></h4>
                                    <h6>Schools without Students</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- widget-success-card end -->
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-primary btn-sm">Week</button>
                            <button class="btn btn-primary btn-sm">Month</button>
                            <button class="btn btn-primary btn-sm">Year</button>
                        </div>
                        <div class="card-block">
                            <div id="container2"></div>
                        </div>
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
                                                        <th>Deadline</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <?php
                                                  $user = Auth::user()->id;
                                                  $sql = "(select a.id, a.activity,a.created_at::date, a.date,b.name as client,d.name as user ,e.name as type  from admin.tasks a join admin.tasks_clients c on a.id=c.task_id join admin.clients b on b.id=c.client_id
                                                  join admin.users d on d.id=a.user_id join admin.task_types e on a.task_type_id=e.id WHERE a.user_id = $user order by a.created_at::date desc)
                                                  UNION ALL
                                                  (select a.id, a.activity,a.created_at::date, a.date,b.name as client,d.name as user ,e.name as type  from admin.tasks a join admin.tasks_schools c on a.id=c.task_id join admin.schools b on b.id=c.school_id
                                                 join admin.users d on d.id=a.user_id join admin.task_types e on a.task_type_id=e.id WHERE a.user_id = $user order by a.created_at::date desc)";
                                                $activities = DB::select($sql);
                                                 $i = 1;
                                                  foreach ($activities as $act):
                                                     ?>
                                                  <tr>
                                                  <td><?=$i++?></td>
                                                  <td><?=$act->type?></td>
                                                  <td><?=$act->client?></td>
                                                  <td><?=$act->date?></td>
                                                  <td> <a href="<?=url('customer/activity/show/'.$act->id)?>">View</a> </td>
                                                </tr>
                                              <?php endforeach; ?>
                                                </tbody>

                                            </table>
                                        </div>
                                      </div>
                                    </div>
                  </div>

              <?php    if (can_access('manage_users')) { ?>

                <div class="col-lg-6">
                    <div class="row">

                        <div class="col-lg-12">
                            <!-- Invoice list card start -->
                            <div class="card card-border-primary">
                                <div class="card-header">
                                    <h5>Other Users Activities</h5>

                                </div>
                                <div class="card-block">
                                    <div class="row">
                                           <?php
                                                $sales_distribution = "select count(*) as count, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.users c on c.id=a.user_id WHERE  a.task_type_id in (select id from admin.task_types where department >4)  group by user_name";
                                                echo $insight->createChartBySql($sales_distribution, 'user_name', 'User Activity', 'bar', false);
                                                ?>
                                    </div>
                                </div>

                                <!-- end of card-footer -->
                            </div>
                            <!-- Invoice list card end -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">

                        <div class="card-block">
                            <div id="container"></div>
                        </div>
                    </div>
                </div>
              <?php } ?>

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
    <table id="users_table" style="display:none">
        <thead>
            <tr>
                <th></th>
                <th>User Feedback</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $logs = DB::select('select count(*),extract(month from created_at) as month from constant.feedback
where extract(year from created_at)=' . date('Y') . ' group by month order by month');
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
            $new_schools = DB::select('select count(*),extract(month from created_at) as month from admin.all_setting
where extract(year from created_at)=' . date('Y') . ' group by month order by month');
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
    </table>


    <script type="text/javascript">
        Highcharts.chart('container', {
            data: {
                table: 'users_table'
            },
            chart: {
                type: 'column'
            },
            title: {
                text: 'User Feedback Per Month'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'User Feedback'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            this.point.y + ' ' + this.point.name.toLowerCase();
                }
            }
        });

        Highcharts.chart('container2', {
            data: {
                table: 'users_sales'
            },
            chart: {
                type: 'column'
            },
            title: {
                text: 'No of Sales Per Month of <?= date('Y') ?>'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'No of new onboarded school'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            this.point.y + ' ' + this.point.name.toLowerCase();
                }
            }
        });
        dashboard_summary = function () {
            $.ajax({
                url: '<?= url('analyse/summary/null') ?>',
                data: {},
                dataType: 'JSONP',
                success: function (data) {
                    //console.log(data);
                    $('#all_users').html(data.users);
                    $('#all_students').html(data.students);
                    $('#all_parents').html(data.parents);
                    $('#all_teachers').html(data.teachers);
                    $('#schools_with_shulesoft').html(data.total_schools);
                    $('#schools_with_students').html(data.total_schools - data.schools_with_students);
                    //
                    $('#active_users').html(data.active_users);
                    $('#active_students').html(data.active_students);
                    $('#active_parents').html(data.active_parents);
                    $('#active_teachers').html(data.active_teachers);
                }
            });
        }
        $(document).ready(dashboard_summary);


    </script>

@endsection

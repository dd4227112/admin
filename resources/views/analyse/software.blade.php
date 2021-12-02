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
$total_activity = \collect(DB::select('select count(*) from admin.tasks a where  a.user_id in (select id from admin.users where department=3) and ' . $where))->first()->count;
    $yes_activity = \collect(DB::select('select count(*) from admin.tasks a where  a.user_id in (select id from admin.users where department=3) and action=(\'Yes\') and ' . $where))->first()->count;
    $no_activity = \collect(DB::select('select count(*) from admin.tasks a where  a.user_id in (select id from admin.users where department=3) and action=(\'No\') and ' . $where))->first()->count;
?>

<div class="main-body">
    <div class="page-wrapper">
           <div class="page-header">
            <div class="page-header-title">
                <h4><?= isset($start_date) && isset($end_date) ? 'Software Dashboard from '. date('d/m/Y', strtotime($start_date)) . ' to '. date('d/m/Y', strtotime($end_date)) : ' Software Dashboard' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">summary</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">software</a>
                    </li>
                </ul>
            </div>
        </div> 

           <div class="row">
             <div class="col-sm-12 col-lg-3 m-b-20">
                <h6>Pick date </h6>
                <input type="text" name="dates" id="rangeDate" class="form-control">
            </div>
            <div class="col-sm-12 col-lg-3 m-b-20">
                <h6> &nbsp; </h6>
                <input type="submit" id="search_custom" class="input-sm btn btn-sm btn-primary">
            </div>
        </div>

        <?php $on = 'Today'; ?>

                <div class="row">
                    <div class="col-md-12 col-xl-4">
                        <?php 
                        $total_errors = \collect(DB::select('select count(*) from admin.error_logs a WHERE  a.deleted_at is null and  a.route is not null and  ' . $where))->first()->count;
                        ?>
                        <div class="card bg-c-pink text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Errors</p>
                                                <h4 class="m-b-0">{{ number_format($total_errors) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-layers f-40 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                          </div>
                    </div>
                   

                    <div class="col-md-6 col-xl-4">
                         <?php
                        $resolved = \collect(DB::select('select count(*) from admin.error_logs a WHERE  a.deleted_at is not null and  a.route is not null and  ' . $where))->first()->count;
                         ?>
                        <div class="card bg-c-yellow text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="m-b-5">Error Resolved</p>
                                        <h4 class="m-b-0">{{ number_format($resolved) }}</h4>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="feather icon-check-circle f-40 text-c-red"></i>
                                    </div>
                                </div>
                            </div>
                         </div>

                    </div>
                   

                    <div class="col-md-6 col-xl-4">
                      <?php $total_activity = \collect(DB::select('select count(*) from admin.tasks a where   a.user_id in (select id from admin.users where department=3) and ' . $where))->first()->count;
                            ?>
                        <div class="card bg-c-green text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">New Tasks Recorded</p>
                                                <h4 class="m-b-0">{{ number_format($total_activity) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-book f-40 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-block">
                                <figure class="highcharts-figure">
                                   <div id="Errors" style="height: 300px; width:350px;"></div>
                                </figure> 
                            </div>
                        </div>
                    </div>
                 
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Technical Tasks Activities</h5>
                            </div>
                            <div class="card-block">
                                <?php
                                $sales_group = "select count(*),b.name as task_name from admin.tasks a join admin.task_types b on b.id=a.task_type_id WHERE   a.user_id in (select id from admin.users where department=3) and " . $where . " group by task_name";
                                echo $insight->createChartBySql($sales_group, 'task_name', 'Technical Activity', 'bar', false);
                                ?>
                            </div>
                        </div>
                    </div>
                  </div>
                   
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>TECHNICAL ACTIVITIES</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <div class="dt-responsive table-responsive">
                                        <table id="res-config" class="table table-bordered w-100 dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Task</th>
                                                    <th>Task Type</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $t = '-' . $days . ' days';
                                                $at = date('Y-m-d H:i:s', strtotime($t));
                                                $i = 1;
                                                $activities = $activities = DB::select("select a.id,d.username, a.activity,a.created_at,b.name as task_name, c.firstname||' '||c.lastname as user_name from admin.tasks a  join admin.task_types b on b.id=a.task_type_id join admin.users c on c.id=a.user_id join admin.tasks_clients e on a.id=e.task_id join admin.clients d on d.id=e.client_id WHERE   a.user_id in (select id from admin.users where department=3) and " . $where);
                                                foreach ($activities as $activity) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $activity->task_name ?></td>
                                                        <td><?= $activity->user_name ?></td>
                                                        <td><a href="<?= url('customer/activity/show/' . $activity->id) ?>"><?= $activity->username ?></a></td>
                                                        <td> <label class="text-danger"><?= $activity->created_at ?></td>
                                                    </tr>
                                                <?php $i++;} ?>
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                  <div class="col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Technical Team Activity Ratio</h5>
                        </div>
                        <div class="card-block">
                            <?php
                            $sales_distribution = "select count(*) as count, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.users c on c.id=a.user_id WHERE   a.user_id in (select id from admin.users where department=3) and " . $where . " group by user_name";
                            echo $insight->createChartBySql($sales_distribution, 'user_name', 'Technical Team Activity', 'bar', false);
                            ?>

                        </div>
                    </div>
                  </div>
                        <div class="col-md-12 col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Daily Tasks</h5>
                                    <label class="label label-success"><?= $on ?></label>
                                </div>
                                <div class="card-block">
                                    <div class="new-task">
                                        <div class="table-responsive">
                                            <table class="table dataTable">
                                                <thead>
                                                    <tr class="text-capitalize">
                                                        <th>#</th>
                                                        <th>Activity</th>
                                                        <th>Count</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    $sqls = "select count(a.*),b.name,b.id from admin.tasks a join admin.task_types b on b.id=a.task_type_id join admin.task_types c on c.id=a.task_type_id where $where  and c.department=3  group by b.name,b.id";
                                                    $tasks = DB::select($sqls);
                                                    foreach ($tasks as $task) {
                                                        ?>
                                                        <tr>
                                                        <td><?= $i ?></td>
                                                        <td><a href="<?=url('customer/taskGroup/task/'.$task->id)?>"><?= $task->name ?></a></td>
                                                        <td><?= $task->count ?></td>
                                                        </tr>
                                                    <?php $i++; } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        
             <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Task Status</h5>
                            </div>
                            <div class="card-block">
                                <?php
                                $new_schools = 'select count(*), status from admin.tasks a where   a.user_id in (select id from admin.users where department=3) and ' . $where . ' group by status';
                                echo $insight->createChartBySql($new_schools, 'status', 'Technical Tasks Status', 'line', false);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <script>
    <?php 
    $sql_code = 'SELECT count(*) as count,extract(month from created_at) as month from admin.error_logs a where extract(year from a.created_at) = extract(year from current_date)  AND a.route is not null  group by month order by month';
    $errors = \DB::select($sql_code);

    ?>
 
Highcharts.chart('Errors', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Issues recorded'
    },
    subtitle: {
        text: 'Issues recorded per month'
    },
    xAxis: {
        type: 'Months',
       
        categories: [
        <?php foreach($errors as $value){  ?> '<?= $value->month ?>',
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
        name: 'Issues recorded',
        colorByPoint: true,
        data: [
            <?php foreach($errors as $value){ ?> {
                name: '<?=date("M", strtotime($value->month))?>',
                y: <?=$value->count?>,
                drilldown: <?=$value->count ?>
            },
            <?php } ?>
        ]
    }]
});


submit_search = function () {
    $('#search_custom').mousedown(function () {
        var alldates = $('#rangeDate').val();
            alldates = alldates.trim();
            alldates = alldates.split("-");
            start_date = formatDate(alldates[0]);
            end_date = formatDate(alldates[1]);
        window.location.href = '<?= url('analyse/software/') ?>/5?start=' + start_date + '&end=' + end_date;
    });
}

   formatDate = function (date) {
            date = new Date(date);
            var day = ('0' + date.getDate()).slice(-2);
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var year = date.getFullYear();
            return year + '-' + month + '-' + day;
    }

$(document).ready(submit_search);
$(document).ready(formatDate);

$('input[name="dates"]').daterangepicker();

</script>

@endsection

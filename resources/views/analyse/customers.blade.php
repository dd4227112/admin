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
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-title">
            <?php
            $on = 'Today';
            ?>
            <?php
            $where_setting = (int) $today == 1 ? ' ' : " WHERE a.created_at::date <='" . $end_date . "'";
            $out_of = \collect(DB::select('select count(*) from admin.all_setting a   ' . $where_setting))->first()->count;
            $active_customers = \collect(DB::select('select count(distinct "schema_name") from admin.all_login_locations a  WHERE "table" in (\'parent\',\'user\',\'teacher\') and ' . $where))->first()->count;
            $total_activity = \collect(DB::select('select count(*) from admin.tasks a where  a.user_id in (select id from admin.users where department=1) and ' . $where . ' and a.status not in(\'Pending\',\'New\')'))->first()->count;
            ?>
        </div>
     


         <div class="page-header">
            <div class="page-header-title">
                <h4><?= isset($start_date) && isset($end_date) ? 'Customer Dashboard from '. date('d/m/Y', strtotime($start_date)) . ' to '. date('d/m/Y', strtotime($end_date)) : ' Customer Dashboard' ?></h4>
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
                    <li class="breadcrumb-item"><a href="#!">customer</a>
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
                <input type="submit" id="search_custom" class="input-sm btn btn-sm btn-success">
            </div>
          </div>

            {{-- <div class="row">
                <div class="col-lg-6 text-left">
                    <?php
                    if (Auth::user()->role_id == 1) {
                        $users = \App\Models\User::where('status', 1)->where('role_id', '<>', 7)->get(); ?>
                        <span >
                            <select class="form-control" id='taskdate'>
                                <option></option>
                                <?php foreach ($users as $user) { ?>
                                    <option value="<?= $user->id ?>" <?= (int) request('user_id') > 0 && request('user_id') == $user->id ? 'selected' : '' ?>><?= $user->firstname . ' ' . $user->lastname ?></option>
                                <?php } ?>
                            </select>
                        </span>
                    <?php } ?>
                </div>

                 <div class="col-lg-6 text-left">
                    <input type="text" name="daterange" class="form-control">
                 </div>
            </div> --}}
            <br>
       

            <div class="row">
                <div class="col-md-6 col-xl-3">
                      <?php  $percent = 'Out of '.$out_of; ?>
                
                    <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-green f-w-700">{{ number_format($active_customers)}} </h4>
                                        <h6 class="text-muted m-b-0">Customers</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-users f-30"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-c-green">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">{{$percent}}</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="feather icon-trending-up text-white f-16"></i>
                                    </div>
                                </div>

                            </div>
                        </div>

                </div>
                 

                <div class="col-md-6 col-xl-3">    
                    <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-green f-w-700">{{ number_format($total_activity)}} </h4>
                                        <h6 class="text-muted m-b-0">Activities</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-activity f-30"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-c-pink">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">support activities</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="feather icon-trending-up text-white f-16"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
               

                <div class="col-md-6 col-xl-3">
                      <?php $percent = 'Out of '.$out_of; 
                                   $total_reacherd = \collect(DB::select("select (count(distinct school_id) + count(distinct client_id)) as count from admin.tasks_schools a, admin.tasks_clients b where b.task_id in (select id from admin.tasks a where a.user_id in (select id from admin.users where department=1) and " . $where . ")
                             and a.task_id in (select id from admin.tasks a where a.user_id in (select id from admin.users where department=1) and " . $where . ")"))->first()->count;
                      ?> 
                          <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-green f-w-700">{{ number_format($total_reacherd)}} </h4>
                                        <h6 class="text-muted m-b-0">Client reached</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-activity f-30"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-c-blue">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">{{$percent}}</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="feather icon-trending-up text-white f-16"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
             
                <div class="col-md-6 col-xl-3">
                      <?php $total_with_students = \collect(DB::select('select count(distinct "schema_name") as count from admin.all_student'))->first()->count;
                      $total_students = $out_of - $total_with_students ?>
                   

                        <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-green f-w-700">{{ number_format($total_students)}} </h4>
                                        <h6 class="text-muted m-b-0">No students </h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-activity f-30"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-c-yellow">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">No students schools</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="feather icon-trending-up text-white f-16"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>

                <!-- Documents card start -->
                <div class="col-md-6 col-xl-3">
                    <?php
                    $user = request()->segment(4);
                    $where_value = (int) $user > 0 ? ' where user_id=' . $user : '';
                    $sql = 'select sum((select count(*) from admin.all_student where "schema_name"=b.username and status=1))*10000 as total_value from admin.users_schools a left join admin.clients b on b.id=a.client_id left join admin.schools c on c.id=a.school_id  ' . $where_value;
                    $value = \collect(DB::select($sql))->first()->total_value;  
                    ?>
                     <div class="card bg-c-green text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Lead Value</p>
                                                <h4 class="m-b-0">{{ number_format($value) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-file f-40 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                </div>

            
                <div class="col-md-6 col-xl-3">
                     <div class="card bg-c-pink text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Customer Retention Rate</p>
                                                <h4 class="m-b-0">{{ number_format($total_activity) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-trending-up f-40 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                </div>
           


                <div class="col-md-6 col-xl-3">
                     <div class="card bg-c-blue text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Active Users Per schools</p>
                                                <h4 class="m-b-0">{{ number_format($total_reacherd) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-trending-up f-40 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                </div>
    
              
                <div class="col-md-6 col-xl-3">
                       <?php
                            $total_with_students = \collect(DB::select('select count(distinct "schema_name") as count from admin.all_student'))->first()->count;
                            $total = $out_of - $total_with_students;
                        ?>
                     <div class="card bg-c-yellow text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Customer ARP</p>
                                                <h4 class="m-b-0">{{ number_format($total) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-trending-up f-40 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                </div>
              

                <div class="col-md-12 col-xl-6">
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

                
                <div class="col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Tasks</h5>
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
                                            <?php $z = 1;
                                            $tasks = DB::select('select count(a.*),b.name,b.id from admin.tasks a join admin.task_types b on b.id=a.task_type_id where   a.user_id in (select id from admin.users where department=1) and ' . $where . '  group by b.name, b.id');
                                            foreach ($tasks as $task) {
                                                ?>
                                                <tr>
                                                    <td><?= $z ?>
                                                    <td><a href="<?= url('customer/taskGroup/task/' . $task->id) ?>"><?= $task->name ?></a></td>
                                                    <td><?= $task->count ?></td>
                                                </tr>
                                            <?php $z++; } ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
             

                <div class="row">
                  <div class="col-sm-6">
                   <div class="card">
                    <div class="card-header">
                        <h5>My User Activities</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table dataTable table-striped table-bordered nowrap">
                                <thead>
                                   <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Task Type</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    <?php  $h = 1;
                                    $activities = DB::select("select a.id, a.activity,a.created_at,b.name as task_name,a.user_id, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.task_types b on b.id=a.task_type_id join admin.users c on c.id=a.user_id WHERE   a.user_id in (select id from admin.users where department=1) and " . $where);
                                    foreach ($activities as $activity) {
                                        ?>
                                        <tr>
                                            <td><?= $h ?></td>
                                            <td>
                                                <a href="<?= url('customer/taskGroup/user/' . $activity->user_id) ?>"><?= $activity->user_name ?></a>
                                            </td>
                                            <td> <a href="<?= url('customer/activity/show/' . $activity->id) ?>"> <?= $activity->task_name ?></a> </td>
                                            <td>
                                                <label class="text-danger">  <?= $activity->created_at ?></label>
                                            </td>
                                        </tr>
                                    <?php $h++; } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                  </div>
                </div>



                       <div class="col-sm-6">
                   <div class="card">
                    <div class="card-header">
                        <h5>My User Activities</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table dataTable table-striped table-bordered nowrap">
                                <thead>
                                   <tr class="text-capitalize">
                                        <th>#</th>
                                        <th>School</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                        <?php $i=1;
                                        $sqls = "SELECT count(a.*),b.username from admin.tasks a join admin.tasks_clients c on a.id=c.task_id join admin.clients b on b.id=c.client_id
                                            WHERE a.user_id in (select id from admin.users where department=1) and " . $where . " and a.status not in('Pending','New') group by b.username
                                            UNION ALL
                                            select count(a.*),b.name from admin.tasks a join admin.tasks_schools c on a.id=c.task_id join admin.schools b on b.id=c.school_id
                                            WHERE a.user_id in (select id from admin.users where department=1) and " . $where . " and a.status not in('Pending','New') group by b.name";
                                        $tasks = DB::select($sqls);
                                        foreach ($tasks as $task) {
                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= substr($task->username, 0, 30) ?></td>
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
            <div class="col-md-12 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Average system usability</h5>
                    </div>
                    <div class="card-block">
                        <div class="cd-horizontal-timeline loaded">

                            <!-- .timeline -->
                            <div class="events-content">
                                <div class="card">

                                    <div class="card-block">

                                        <?php
                                        $sql_2 = "select count(id) as count, controller as module from admin.all_log a   where controller not in ('background','SmsController','signin','dashboard') and " . $where . "  group by controller order by count desc limit 10 ";

                                        echo $insight->createChartBySql($sql_2, 'module', 'System Usability Per Modules', 'bar', false);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- .events-content -->
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="col-md-12 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Activities per Module</h5>
                    </div>
                    <div class="card-block">
                        <div class="cd-horizontal-timeline loaded">

                            <!-- .timeline -->
                            <div class="events-content">
                                <div class="card">

                                    <div class="card-block">
                                        <?php
                                        $sql_2_activities = "select count(m.id) as count ,m.name as modules from admin.modules m, admin.module_tasks mt,admin.users u,admin.tasks a where m.id=mt.module_id and mt.task_id =a.id and u.id =a.user_id and u.role_id in (14,8)  and " . $where . " group by m.name";
                                        echo $insight->createChartBySql($sql_2_activities, 'modules', 'Activities', 'bar', false);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        </div>
    </div>
</div>
<script type="text/javascript">

   <?php
    $sql = "select count(*) as count, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.users c on c.id=a.user_id WHERE   a.user_id in (select id from admin.users where department=1) and " . $where . " and a.status not in('Pending','New') group by user_name";
    $sql2 = 'select count(*) as count,extract(month from created_at) as month from admin.all_setting where extract(year from created_at)=' . date('Y') . ' group by month order by month';
    $support_distribution = \DB::select($sql);
    $dataw = \DB::select($sql2);
    ?>

       
   Highcharts.chart('onboardBar', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Support activities'
    },
    subtitle: {
        text: 'Relationship between support activity and username'
    },
    xAxis: {
        type: 'Months',
       
        categories: [
        <?php foreach($support_distribution as $value){  ?> '<?= $value->user_name ?>',
        <?php } ?>
      ]
    },
    yAxis: {
        title: {
            text: 'Activities'
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Activities',
        colorByPoint: true,
        data: [
            <?php foreach($support_distribution as $value){ ?> {
                name: '<?= $value->user_name ?>',
                y: <?=$value->count?>,
                drilldown: <?=$value->count ?>
            },
            <?php } ?>
        ]
    }]
});
   
   Highcharts.chart('onboardPie', {
    chart: {
        type: 'column'
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
        <?php foreach($dataw as $value){  ?> '<?= $value->month?>',
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
        name: 'Schools',
        colorByPoint: true,
        data: [
            <?php foreach($dataw as $value){ ?> {
                name: '<?=date("M", strtotime($value->month))?>',
                y: <?=$value->count?>,
                drilldown: <?=$value->count ?>
            },
            <?php } ?>
        ]
    }]
});

    check = function () {
         $('#taskdate').change(function (event) {
            var taskdate = $(this).val();
            if (taskdate === '') {
            } else {
                window.location.href = '<?= url('analyse/customers/user/') ?>/' + taskdate;
            }
        });
    }


   submit_search = function () {
        $('#search_custom').mousedown(function () {
            var alldates = $('#rangeDate').val();
            alldates = alldates.trim();
            alldates = alldates.split("-");
            start_date = formatDate(alldates[0]);
            end_date = formatDate(alldates[1]);
            window.location.href = '<?= url('analyse/customers/') ?>/5?start=' + start_date + '&end=' + end_date;
        });
    }
    $(document).ready(submit_search);
    $('input[name="dates"]').daterangepicker();

    $(document).ready(check);
    $(document).ready(submit_search);


        formatDate = function (date) {
            date = new Date(date);
            var day = ('0' + date.getDate()).slice(-2);
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var year = date.getFullYear();
            return year + '-' + month + '-' + day;
        }

</script>
@endsection

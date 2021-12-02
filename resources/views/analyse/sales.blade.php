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
$total_activity = \collect(DB::select('select count(*) from admin.tasks a where  a.user_id in (select id from admin.users where department=2) and ' . $where))->first()->count;
$allschools = DB::select('select * from admin.all_setting a WHERE  ' . $where . ' order by created_at desc');
?>
<div class="main-body">
    <div class="page-wrapper">

     <div class="page-header">
        <div class="page-header-title">
             <h4><?= isset($start_date) && isset($end_date) ? 'Sales Dashboard from '. date('d/m/Y', strtotime($start_date)) . ' to '. date('d/m/Y', strtotime($end_date)) : ' Sales Dashboard' ?></h4>
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
                <li class="breadcrumb-item"><a href="#!">sales</a>
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
                <div class="col-md-6 col-xl-3">
                  <?php $percent = round($shulesoft_schools * 100 / $schools, 1). '% Coverage ' ?>
                
                    <div class="card">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-c-green f-w-700">{{ number_format($shulesoft_schools)}} </h4>
                                    <h6 class="text-muted m-b-0">Schools</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-map-pin f-30"></i>
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
                     <?php  
                    $percent =  $shulesoft_nmb_schools . ' in ShuleSoft (' . round($shulesoft_nmb_schools * 100 / ((int) $nmb_schools == 0 ? 1 : $nmb_schools), 1) .'%' ?>
                 
                     <div class="card">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-c-green f-w-700">{{ number_format($nmb_schools)}} </h4>
                                    <h6 class="text-muted m-b-0">NMB Schools</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-home f-30"></i>
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
                     <div class="card">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-c-green f-w-700">{{ number_format($clients)}} </h4>
                                    <h6 class="text-muted m-b-0">Our clients</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-users f-30"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-c-yellow">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">clients</p>
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
                                    <h4 class="text-c-green f-w-700">{{ number_format($schools)}} </h4>
                                    <h6 class="text-muted m-b-0">All Schools</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-users f-30"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-c-green">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">Registered schools</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 col-xl-4">
                     <div class="card">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total School Reached</p>
                                                <h4 class="m-b-0">{{ number_format(count($taskss)) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-book f-50" style="color: #19b99a;"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                </div>


                <div class="col-md-6 col-xl-4">
                    <?php  $total_schools = \collect(DB::select('select count(*) from admin.all_setting a WHERE  ' . $where))->first()->count;  ?>
                     <div class="card">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">New schools onboarded</p>
                                                <h4 class="m-b-0">{{ number_format($total_schools) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-user-plus f-50" style="color: #ADD8E6;"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                </div>
            
                <div class="col-md-6 col-xl-4">
                     <div class="card">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Sales Activities</p>
                                                <h4 class="m-b-0">{{ number_format($total_activity) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-activity f-50" style="color: gray;"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                </div>
            </div>
        
             <div class="row">
                  <div class="col-sm-12">
                   <div class="card">
                    <div class="card-header">
                        <h5>My User Activities</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table dataTable">
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
                                             if(count($allschools)){
                                              foreach($allschools as $school){ 
                                                ?>
                                                <tr>
                                                <td><?=$i?></td>
                                                <td><?=ucfirst($school->sname)?></td>
                                                <td><?=ucfirst($school->address)?></td>
                                                <td><?= date('F,d Y', strtotime($school->created_at))?></td>
                                                <td>
                                                 <a class="btn btn-info btn-min btn-round" href="<?= url('customer/profile/' . $school->schema_name) ?>">View</a>
                                                </td>
                                                </tr>
                                            <?php
                                            $i++; }
                                          }
                                        ?>
                                    </tbody>
                              </table>
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
                                 <div id="new_school" style="height: 300px; width:350px;"></div>
                             </figure> 
                        </div>
                    </div>
                </div>
  
                <div class="col-xl-6">
                 <div class="card">
                    <div class="card-block">
                      <figure class="highcharts-figure">
                           <div id="Requests" style="height: 300px; width:350px;"></div>
                       </figure> 
                    </div>
                  </div>
                </div>
            </div>
     
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




                 <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <div class="card">
                            <div class="card-block">
                              <div class="table-responsive analytic-table">
                                <table id="res-config" class="table table-bordered w-100 dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Task Type</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $t= 1; $activities = DB::select("select a.id, a.activity,a.created_at,b.name as task_name,a.user_id, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.task_types b on b.id=a.task_type_id join admin.users c on c.id=a.user_id WHERE   a.user_id in (select id from admin.users where department=2) and " . $where);
                                        foreach ($activities as $activity) {
                                            ?>
                                            <tr>
                                                <td> <?= $t ?> </td>
                                                <td> <a href="<?=url('customer/taskGroup/user/'.$activity->user_id)?>"><?= $activity->user_name ?></a></td>
                                                <td> <a href="<?= url('customer/activity/show/'.$activity->id) ?>"> <?= $activity->task_name ?></a> </td>
                                                <td><label class="text-info">  <?= date('d/m/Y',strtotime($activity->created_at)) ?></label> </td>
                                            </tr>
                                        <?php $t++; } ?>
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
<script>
    
Highcharts.chart('new_school', {
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
        <?php foreach($new_schools as $value){  ?> '<?=date("M", strtotime($value->month))?>',
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
            <?php foreach($new_schools as $value){ ?> {
                name: '<?=date("M", strtotime($value->month))?>',
                y: <?=$value->count?>,
                drilldown: <?=$value->count ?>
            },
            <?php } ?>
        ]
    }]
});

Highcharts.chart('Requests', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Website requests'
    },
    subtitle: {
        text: 'Website Join Requests'
    },
    xAxis: {
        type: 'Months',
       
        categories: [
        <?php foreach($requests as $value){  ?> '<?= $value->month ?>',
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
            <?php foreach($requests as $value){ ?> {
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
            window.location.href = '<?= url('analyse/sales/') ?>/5?start=' + start_date + '&end=' + end_date;
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

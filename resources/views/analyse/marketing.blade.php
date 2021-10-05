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

        {{-- <div class="page-header">
            <div class="page-header-title">
                <h4><?= isset($start_date) && isset($end_date) ? 'Analytic Dashboard from '. date('d/m/Y', strtotime($start_date)) . ' to '. date('d/m/', strtotime($end_date)) : ' Analytic Dashboard' ?></h4>
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
        </div> --}}

        <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
       
        <div class="row">
             <div class="col-sm-12 col-xl-4 m-b-30">
                <h6>Pick date </h6>
                <input type="text" name="dates" class="form-control">
            </div>
        </div>
        {{-- <div class="row">
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
         </div> --}}

        <div class="page-body">
            <div class="row">
                 <div class="col-xl-3 col-md-6">
                    <?php $unique_visitors = \collect(DB::select('select count(*) from (select distinct platform,user_agent from admin.website_logs a where ' . $where . '  ) x '))->first()->count; ?>
                     <x-smallCard title="Website Visits"
                                :value="$unique_visitors"
                                icon="feather icon-users f-50 text-c-light"
                                cardcolor="bg-c-green text-white"
                                >
                     </x-smallCard>
                  </div>

                  <div class="col-xl-3 col-md-6">
                    <?php $total_sms_sent = \collect(DB::select('select count(*) from public.sms a where ' . $where))->first()->count; ?>
                     <x-smallCard title="SMS sent"
                                :value="$total_sms_sent"
                                icon="feather icon-message-square f-50 text-c-light"
                                cardcolor="bg-c-green text-white"
                                >
                     </x-smallCard>
                  </div>

                
                  <div class="col-xl-3 col-md-6">
                      <?php  $email_total_reacherd = \collect(DB::select('select count(*) from public.email a where ' . $where))->first()->count; ?>
                     <x-smallCard title="Email sent"
                                :value="$email_total_reacherd"
                                icon="feather icon-mail f-50 text-c-light"
                                cardcolor="bg-c-blue text-white"
                                >
                     </x-smallCard>
                  </div>
                <!-- Linked in card end -->

                 <div class="col-xl-3 col-md-6">
                      <?php  $email_total_reacherd = \collect(DB::select('select count(*) from admin.events  a where ' . $where))->first()->count; ?>
                       <x-smallCard title="Events"
                                :value="$email_total_reacherd"
                                icon="feather icon-clipboard f-50 text-c-light"
                                cardcolor="bg-c-yellow text-white"
                                >
                      </x-smallCard>
                  </div>
                </div>

             
                <!-- Google-plus card end -->
            <div class="row">
                <div class="col-md-12 col-xl-4">
                     <?php
                       $total_reacherd = \collect(DB::select("select (count(distinct school_id) + count(distinct client_id)) as count from admin.tasks_schools a, admin.tasks_clients b where b.task_id in (select id from admin.tasks a where task_type_id in (select id from task_types where department=2) and " . $where . ") and a.task_id in (select id from admin.tasks a where task_type_id in (select id from task_types where department=2) and " . $where . ")"))->first()->count;
                     ?>
                     <x-analyticCard :value="$total_reacherd" name="Total School Reached"  icon="feather icon-trending-up text-white f-16" color="bg-c-yellow" topicon="feather icon-bar-chart f-40" subtitle="new schools"></x-analyticCard>
                </div>

              
                <div class="col-md-12 col-xl-4">
                    <?php $total_schools = \collect(DB::select('select count(*) from admin.all_setting a WHERE  ' . $where))->first()->count; ?>
                    <x-analyticCard :value="$total_schools" name="Total Contacts Reached"  icon="feather icon-trending-up text-white f-16" color="bg-c-green" topicon="feather icon-file f-40" subtitle="reached schools"></x-analyticCard>
                </div>
               
                <div class="col-md-12 col-xl-4">
                    <?php $total_activity = \collect(DB::select('select count(*) from admin.tasks a where  a.task_type_id in (select id from admin.task_types where department=2) and ' . $where))->first()->count; ?>
                    <x-analyticCard :value="$total_activity" name="Marketing Activities"  icon="feather icon-activity text-white f-16" color="bg-c-blue" topicon="feather icon-activity f-40" subtitle="activities"></x-analyticCard>
                </div>
             </div>

    
            <div class="row">
                <div class="col-lg-12">
                <div class="card">
                    <div class="card-block">
                        <div id="websitevisitors" style="height:300px;" ></div>
                    </div>
                </div> 
                </div>
            </div>


            <div class="row">
                <div class="col-lg-6">
                <div class="card">
                    <div class="card-block">
                        <div id="loginlocations" style="height:330px;" ></div>
                    </div>
                 </div> 
                </div>

                <div class="col-lg-6">
                <div class="card">
                    <div class="card-block">
                        <div id="moduleusage" style="height:330px;" ></div>
                    </div>
                 </div> 
                </div>
            </div>

               
       

      <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Marketing Activities</h5>
           </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table dataTable table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Task Type</th>
                                <th>Activity</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $j = 1;
                            $activities = DB::select("select a.activity,a.created_at,b.name as task_name, c.firstname||' '||c.lastname as user_name from admin.tasks a join admin.task_types b on b.id=a.task_type_id join admin.users c on c.id=a.user_id
                                  WHERE  a.task_type_id in (select id from admin.task_types where department=4) and " . $where . " order by a.created_at desc");
                            foreach ($activities as $activity) {
                                ?>                    
                                <tr>
                                    <td><?= $j ?> </td>
                                    <td><?= $activity->user_name ?> </td>
                                    <td><?= warp($activity->activity,40) ?> </td>
                                    <td><?= $activity->task_name ?></td> 
                                    <td>
                                        <label class="text-info">  <?= $activity->created_at ?></label>
                                    </td>
                                 </tr>
                              <?php $j++; } ?>
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

<script type="text/javascript">

$('input[name="dates"]').daterangepicker();

<?php 
 $sql1 = "select count(*),created_at::date from (select distinct platform,user_agent,created_at::date from admin.website_logs a where " . $where . "  ) x  group by created_at::date ";
 $sql_ = "select count(distinct (user_id,\"table\")) as count, created_at::date as date from admin.all_login_locations a where " . $where . " group by created_at::date ";
 $sql2 = "select count(id) as count, controller as date from admin.all_log a   where controller not in ('background','SmsController','signin','dashboard') and ".$where."  group by controller order by count desc limit 10 ";

 $visitors = \DB::select($sql1);
 $logins = \DB::select($sql_);
 $modules = \DB::select($sql2);
 ?>
Highcharts.chart('websitevisitors', {
    title: {
        text: 'Daily website visitors'
    },

    subtitle: {
        text: 'Based on number of people visits the website'
    },

    yAxis: {
        title: {
            text: 'Visitors'
        }
    },

    xAxis: {
         title: {
            text: 'Dates'
        },
        categories: [
            <?php foreach($visitors as $value){  ?> '<?=date("d-m-Y", strtotime($value->created_at))?>',
            <?php } ?>
        ]
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    series: [{
        name: 'Visitors',
        data: [<?php foreach($visitors as $valuet){ echo $valuet->count.','; }?>]
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

Highcharts.chart('loginlocations', {
 chart: {
    type: 'column',
  },
  title: {
    text: 'Daily user logins'
  },
  subtitle: {
    text: 'Relationship between user logins and dates'
  },
    yAxis: {
        title: {
            text: 'Users'
        }
    },

  xAxis: { 
    title: {
            text: 'Dates'
    },
    categories: [
        <?php foreach($logins as $value){  ?> '<?= date("d-m-Y", strtotime($value->date)) ?>',
        <?php } ?>
     ]
    },
    series: [{
        name: 'User logins',
        colorByPoint: true,
        data: [<?php foreach($logins as $valuet){ echo $valuet->count.','; }?>]
    }]
 });


 
Highcharts.chart('moduleusage', {
 chart: {
    type: 'bar',
  },
  title: {
    text: 'Module Usage'
  },
  subtitle: {
    text: 'Relationship between module usage and dates'
  },
    yAxis: {
        title: {
            text: 'Modules'
        }
    },

  xAxis: { 
    title: {
            text: 'Dates'
    },
    categories: [
        <?php foreach($modules as $value){  ?> '<?= $value->date ?>',
        <?php } ?>
     ]
    },
    series: [{
        name: 'Module usage',
        colorByPoint: true,
        data: [<?php foreach($modules as $value){ echo $value->count.','; }?>]
    }]
 });


  check = function () {
        $('#check_custom_date').change(function () {
            var val = $(this).val();
            if (val == 'today') {
                window.location.href = '<?= url('analyse/marketing/') ?>/1';
            } else {
                $('#show_date').show();
            }
        });
    }
    submit_search = function () {
        $('#search_custom').mousedown(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            window.location.href = '<?= url('analyse/marketing/') ?>/5?start=' + start_date + '&end=' + end_date;
        });
    }
    $(document).ready(check);
    $(document).ready(submit_search);
</script>

@endsection
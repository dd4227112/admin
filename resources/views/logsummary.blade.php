@extends('layouts.app')
@section('content')

<div class="row">
    <div class="white-box">
        <div class="col-lg-12">
            <form action="" method="get">
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Schema</label>
                    <select class="form-control" name="schema">

                        <option value="">All</option>
                        <?php foreach ($schemas as $ss) {
                            ?>
                            <option value="<?= $ss->table_schema ?>"><?= $ss->table_schema ?></option>
                        <?php } ?>
                    </select> </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="date" class="form-control" name="start_date"  value="<?= request('start_date') ?>" id="exampleInputEmail1" placeholder="Enter email"> </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputPassword1">End Date</label>
                    <input type="date" class="form-control" name="end_date" value="<?= request('end_date') ?>" id="exampleInputPassword1" placeholder="Password"> </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputPassword1">User Type</label>
                    <select class="form-control" name="usertype">
                        <option value="">All</option>
                        <?php foreach ($users as $user_info) {
                            ?>
                            <option value="<?= $user_info->usertype ?>"><?= $user_info->usertype ?></option>
                        <?php } ?>
                    </select> </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputPassword1"></label><br/>
                    <button type="submit" class="btn btn-inverse waves-effect waves-light">Analyse</button>
                </div>
            </form>
        </div>
        <h5>Total Request made by Date</h5>
        <script type="text/javascript">
            $(function () {
            $('#container').highcharts({
            data: {
            table: 'datatable'
            },
                    series: [{
                    name: '',
                            colorByPoint: true}
                    ],
                    chart: {
                    type: 'column'
                    },
                    title: {
                    text: 'Log Requests'
                    },
                    yAxis: {
                    allowDecimals: false,
                            title: {
                            text: 'Requests'
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
                                    format: ''
                            }
                    }
                    },
                    tooltip: {
                    formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            this.point.y + ' ' + this.point.name.toUpperCase();
                    }
                    }
            });
            $('#container2').highcharts({
            data: {
            table: 'datatable2'
            },
                    series: [{
                    name: '',
                            colorByPoint: true}
                    ],
                    chart: {
                    type: 'column'
                    },
                    title: {
                    text: 'Number of Users Login'
                    },
                    yAxis: {
                    allowDecimals: false,
                            title: {
                            text: 'Users'
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
                                    format: ''
                            }
                    }
                    },
                    tooltip: {
                    formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            this.point.y + ' ' + this.point.name.toUpperCase();
                    }
                    }
            });
            });
        </script>

        <script src="<?= url('public/js/highcharts.js') ?>"></script>
        <script src="<?= url('public/js/exporting.js') ?>"></script>
        <script src="<?= url('public/js/data.js') ?>"></script>

        <?php
        $from_date = date('Y-m-d', strtotime($start)) == '1970-01-01' ? date('Y-m-d', time() - 60 * 60 * 24 * 30) : date('Y-m-d', strtotime($start));
        $end_date = date('Y-m-d', strtotime($end)) == '1970-01-01' ? date('Y-m-d') : date('Y-m-d', strtotime($end));
        $where_schema = $schema == '' ? '' : ' AND "schema_name"::text=\'' . $schema . "' ";
        $where_user = $user == '' ? '' : ' AND lower("user")=\'' . strtolower($user) . "' ";
        $sql = "select count(*),created_at::date from admin.all_log where created_at::date <= '" . $end_date . "' and created_at::date>= '" . $from_date . "' " . $where_schema . $where_user . " group by created_at::date order by created_at desc";

        $sql_distinct = "select count(distinct user_id),created_at::date from admin.all_log where created_at::date <= '" . $end_date . "' and created_at::date>= '" . $from_date . "' " . $where_schema . $where_user . " group by created_at::date order by created_at desc";



       
        //distinct schema
        $distinct_schema = \DB::select('select distinct "schema_name"::text from admin.all_log');

        $schema_users = \DB::select("select \"schema_name\"::text, count(distinct user_id), created_at::date  from admin.all_log where created_at::date <= '" . $end_date . "' and created_at::date>= '" . $from_date . " ' " . $where_schema . $where_user . "  and \"user\" !='0' group by \"schema_name\"::text,created_at::date order by created_at desc");
        $schema_data = [];
        foreach ($distinct_schema as $ssm) {
            $schema_data[$ssm->schema_name] = [];
            foreach ($schema_users as $schema_user) {
                array_push($schema_data[$ssm->schema_name], $schema_user);
            }
        }
        
         ///distinct users
        $distinct_users = \DB::select('select distinct "user" from admin.all_log  where "user" is not null and "user" !=\'0\'');
        
         $distinct_schema_users = \DB::select("select \"user\"::text, count(distinct user_id), created_at::date  from admin.all_log where created_at::date <= '" . $end_date . "' and created_at::date>= '" . $from_date . " ' " . $where_schema . $where_user . "  and \"user\" !='0' group by \"user\"::text,created_at::date order by created_at desc");
        $schema_user_data = [];
        foreach ($distinct_users as $distinct_user) {
            $schema_user_data[$distinct_user->user] = [];
            foreach ($distinct_schema_users as $distinct_schema_user) {
                $data_in=$distinct_schema_user->user==$distinct_user->user ? $distinct_schema_user: []; 
                if(count($data_in)>0){
                array_push($schema_user_data[$distinct_user->user], $distinct_schema_user);
                }
            }
        }
        //dd($schema_user_data);
        ?>
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        <div class="table-responsive"> 
            <table id="datatable" style="display:none" >
                <thead>
                    <tr>
                        <th>Count</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;

                    $logs = \DB::select($sql);
                    foreach ($logs as $value) {
                        ?>
                        <tr>
                            <td><?= $value->created_at ?></td>
                            <td><?= $value->count ?></td>

                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>


        <hr/><br/>
        <div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        <div class="table-responsive"> 
            <table id="datatable2" style="display:none" >
                <thead>
                    <tr>
                        <th>Count</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;

                    $user_logs = \DB::select($sql_distinct);
                    $dates = '';
                    foreach ($user_logs as $log) {
                        $dates .= "'" . $log->created_at . "',";
                        ?>
                        <tr>
                            <td><?= $log->created_at ?></td>
                            <td><?= $log->count ?></td>

                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script type="text/javascript">
            $(function () {
            $('#container_schema').highcharts({
            chart: {
            type: 'line'
            },
                    title: {
                    text: 'User Distribution by School'
                    },
                    subtitle: {
                    text: 'Source: shulesoft.com'
                    },
                    xAxis: {
                    categories: [<?php
                    foreach ($user_logs as $log) {
                        echo "'" . $log->created_at . "',";
                    }
                    ?>
                    ]
                    },
                    yAxis: {
                    title: {
                    text: 'Schools'
                    }
                    },
                    plotOptions: {
                    line: {
                    dataLabels: {
                    enabled: true
                    },
                            enableMouseTracking: false
                    }
                    },
                    series: [
<?php
foreach ($schemas as $ss) {
    ?>
                        {
                        name: '<?= $ss->table_schema ?>',
                                data: [
    <?php
    if (isset($schema_data[$ss->table_schema])) {
        $data = $schema_data[$ss->table_schema];
        foreach ($user_logs as $log) {
            foreach ($data as $value) {
                if ($log->created_at == $value->created_at) {
                    echo $value->count . ',';
                }
            }
        }
    } else {
        
    }
    ?>
                                ]
                        },
<?php } ?>
                    ]
            });
            });
            $(function () {
            $('#container_users').highcharts({
            title: {
            text: 'User Distribution by Users',
                    x: - 20 //center
            },
                    subtitle: {
                    text: 'Source: shulesoft.com',
                            x: - 20
                    },
                    xAxis: {
                    categories: [<?php
foreach ($user_logs as $log) {
    echo "'" . $log->created_at . "',";
}
?>]
                    },
                    yAxis: {
                    title: {
                    text: 'Total Users'
                    },
                            plotLines: [{
                            value: 0,
                                    width: 1,
                                    color: '#808080'
                            }]
                    },
                    tooltip: {
                    valueSuffix: '°C'
                    },
                    legend: {
                    layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle',
                            borderWidth: 0
                    },
                    series: [
<?php
foreach ($distinct_users as $distinct_user) {
    ?>
                        {
                        name: '<?= $distinct_user->user ?>',
                                data: [
    <?php
    if (isset($schema_user_data[$distinct_user->user])) {
        $data = $schema_user_data[$distinct_user->user];
        $log_value='';
        foreach ($user_logs as $log) {
            $log_in[$log->created_at]=[];
            foreach ($data as $value) {
                if ($log->created_at == $value->created_at && $value->user=$distinct_user->user) {
                   array_push($log_in[$log->created_at],  $value->count );
                }
            }
           
        }
        foreach ($user_logs as $log) {
            echo isset($log_in[$log->created_at][0])? $log_in[$log->created_at][0].',' :'0,';  
        }
    } else {
        
    }
    ?>]
                        },
<?php } ?>]
            });
            });
        </script>



    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div id="container_schema"></div>

        </div>
        <div class="col-lg-12 col-sm-12">
            <div id="container_users"></div>

        </div>
    </div>
</div>
@include('layouts.datatable')
@endsection

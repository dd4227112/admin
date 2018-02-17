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
                        <?php  foreach ($schemas as $ss) { 
    
                            ?>
                        <option value="<?=$ss->table_schema?>"><?=$ss->table_schema?></option>
                       <?php }?>
                    </select> </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="date" class="form-control" name="start_date"  value="<?= request('start_date')?>" id="exampleInputEmail1" placeholder="Enter email"> </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputPassword1">End Date</label>
                    <input type="date" class="form-control" name="end_date" value="<?= request('end_date')?>" id="exampleInputPassword1" placeholder="Password"> </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputPassword1">User Type</label>
                    <select class="form-control" name="usertype">
                        <option value="">All</option>
                        <?php  foreach ($users as $user_info) { 
    
                            ?>
                        <option value="<?=$user_info->usertype?>"><?=$user_info->usertype?></option>
                       <?php }?>
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
                            text: 'Average'
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
                    $sql="select count(*),created_at::date from admin.all_log where created_at::date <= '" . $end_date . "' and created_at::date>= '" . $from_date . "' " . $where_schema . $where_user . " group by created_at::date order by created_at desc";
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
    </div>
</div>
@include('layouts.datatable')
@endsection

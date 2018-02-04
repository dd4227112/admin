@extends('layouts.app')
@section('content')

<div class="row">
    <div class="white-box">
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
                    $from_date = date('Y-m-d', strtotime($start)) == '1970-01-01' ? date('Y-m-d', time() - 60 * 60 * 24 * 30) : date('Y-m-d', strtotime($start));
                    $end_date = date('Y-m-d', strtotime($end)) == '1970-01-01' ? date('Y-m-d') : date('Y-m-d', strtotime($end));
                    $logs = \DB::select("select count(*),created_at::date from admin.all_log where created_at::date <= '" . $end_date . "' and created_at::date>= '" . $from_date . "' group by created_at::date order by created_at desc");
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

<script type="text/javascript">
    graph_disc = function() {
    Highcharts.chart('container', {
    chart: { type: 'column' },
            title: {
            text: "System usage by Month"
            },
            subtitle: {
            text: ''
            },
            xAxis: {
            type: 'category'
            },
            yAxis: {
            title: {
            text: 'Log Requests'
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
                            format: '{point.y:.1f}'
                    }
            }
            },
            tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },
            series: [{
            name: 'Log Requests',
                    colorByPoint: true,
                    data: [
<?php
$logs = DB::select('select count(*), extract(month from created_at) as month from ' . $schema . '.log where user_id is not null and extract(year from created_at)=' . date('Y') . '  group by extract(month from created_at) order by extract(month from created_at) asc');
if (!empty($logs)) {
    foreach ($logs as $log) {
        $dateObj = DateTime::createFromFormat('!m', $log->month);
        $month = $dateObj->format('F');
        ?> { name: '<?= ucwords($month) ?>',
                                            y: <?php
        echo $log->count;
        ?>,
                                            drilldown: ''
                                    },
        <?php
    }
}
?>
                    ]
            }]
    });
    Highcharts.chart('container_log', {
    chart: {
    type: 'column'
    },
            title: {
            text: "Number of System User Login by Day."
            },
            subtitle: {
            text: ''
            },
            xAxis: {
            type: 'category'
            },
            yAxis: {
            title: {
            text: 'Number of Logins'
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
                            format: '{point.y:.1f}'
                    }
            }
            },
            tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
            },
            series: [{
            name: 'Number of Logins',
                    colorByPoint: true,
                    data: [
<?php
$setting = "'setting'";
$logins = DB::select('select count(user_id), created_at::date as month from ' . $schema . '.login_locations where user_id is not null AND  "table" != ' . $setting . ' and extract(year from created_at) = ' . date('Y') . '  group by created_at::date order by created_at::date desc limit 10');
if (!empty($logins)) {
    foreach ($logins as $log) {
        ?> {
                                    name: '<?= $log->month . "<br><b>" . date("l", strtotime($log->month)) . "</b>" ?>',
                                            y: <?php echo $log->count; ?>,
                                            drilldown: ''
                                    },
        <?php
    }
}
?>
                    ]
            }]
    });
    }
    $(document).ready(graph_disc);
</script>

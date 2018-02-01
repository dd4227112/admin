<?php
$types = array();
foreach ($results as $result) {
    array_push($types, $result->dataname);
}
$data_types = array_unique($types);
?>
<script src="<?=url('public/js/highcharts.js')?>"></script>
<script src="<?=url('public/js/exporting.js')?>"></script>
<script type="text/javascript">
    $(function () {
    $('#container').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Average Number of Users Login Daily'
            },
            subtitle: {
            text: 'Source: shulesoft '
            },
            xAxis: {
            categories: [
                <?php
                 //arsort($results);
                foreach ($results as $result) {
                    echo '"'.date('D',strtotime($result->timeline)).'-('.date('d M',strtotime($result->timeline)).')",';
        
    }?>
            ],
                    crosshair: true
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Total User Logins'
                    }
            },
            tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} users</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
            },
            plotOptions: {
            column: {
            pointPadding: 0.2,
                    borderWidth: 0
            }
            },
            series: [
<?php foreach ($data_types as $type) {
    ?>
                {
                name:"<?= $type ?>",
                        data:
                [
    <?php
    foreach ($results as $result) {
        echo $type == $result->dataname ? $result->count.',' : '';
    }
    ?>]

                },
<?php } ?>]
    });
    });
</script>


<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


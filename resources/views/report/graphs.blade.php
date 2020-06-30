<?php
/*
$types = array();
foreach ($results as $result) {
    array_push($types, $result->dataname);
}
$data_types = array_unique($types);
*/
?>
@extends('layouts.app')
@section('content')
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4 class="box-title">Database</h4>
        <span></span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Database</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Create Script</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">

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
                 foreach($datas as $data){
                        echo  $data->ynumber;
                 }
                        ?>
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

                <?php
                foreach($datas as $data){
    ?>
                {
                name:"<?= $data->created_at ?>",
                        data:
                [<?php echo $data->ynumber; ?>]

                },
<?php } ?>]
    });
    });
</script>


<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

</div>
    </div>
    <div class="row">
    <div class="col-md-12 col-lg-8 col-sm-12 col-xs-12">
        <div class="white-box">
            <h3 class="box-title">Weekly Requests</h3>
            <div id="ct-visits" style="height: 405px;">
                <div class="chartist-tooltip" style="top: 257px; left: 230px;"></div>
                <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
                <style type="text/css">
                    ${demo.css}
                </style>
                <script type="text/javascript">
                    $(function () {
                        $('#container').highcharts({
                            data: {
                                table: 'datatable'
                            },
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Log requests in weekly interval'
                            },
                            yAxis: {
                                allowDecimals: false,
                                title: {
                                    text: 'Requests'
                                }
                            },
                            tooltip: {
                                formatter: function () {
                                    return '<b>' + this.series.name + '</b><br/>' +
                                            this.point.y + ' ' + this.point.name.toLowerCase();
                                }
                            }
                        });
                    });
                </script>
                <script src="https://code.highcharts.com/highcharts.js"></script>
                <script src="https://code.highcharts.com/modules/data.js"></script>
                <script src="https://code.highcharts.com/modules/exporting.js"></script>

                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  </div>

  @endsection

@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Revenue vs Expense Report</h4>
                <span>Show list of all expenses and revenues </span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Reports</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
         <div class="col-sm-12 tile-stats flipInY">
            <form style="" class="form-horizontal list-group-item list-group-item-warning" role="form" method="post"> 
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= __('start_date') ?></label>
                        <div class=" col-xs-12">
                            <input type="text" required="true" class="form-control calendar" id="from_date" name="from_date" value="" autocomplete="off">
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= __('end_date') ?></label>
                        <div class="col-xs-12">
                            <input type="text" required="true" class="form-control calendar" id="to_date" name="to_date" value="">
                        </div>
                    </div>
                </div>                     


                <div class="col-md-3">
                    <div class='form-group' >
                        <label for="class_level_id" class="control-label col-md-3 col-sm-3 col-xs-12">
                            <?= __('type') ?>
                        </label>
                        <div class="col-xs-12">
                            <?php
                            $array = array("0" => __("type"));
                            $array['1'] = 'Expenses';
                            $array['2'] = 'Payments';
                            $array['3'] = 'Revenue';

                            echo form_dropdown("report_type", $array, old("report_type"), "id='class_level_id' class='form-control'");
                            ?>
                        </div>
                        <span class="col-sm-4 col-xs-12 control-label">
                            <?php echo form_error($errors, 'classlevel'); ?>
                        </span>
                    </div> 
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="class_level_id" class="control-label col-md-3 col-sm-3 col-xs-12">
                            <br/>
                        </label>
                        <div class="col-xs-12">
                            <br/> <?= csrf_field() ?>
                            <input type="submit" class="btn btn-success" value="Submit">
                        </div>
                    </div>
                </div> 


            </form>

        </div> 
       
        <div class="row">
            <div class="col-md-12 col-xl-3">
                    <div class="card counter-card-1">
                        <div class="card-block-big">
                            <div>
                    <h3><?= $no_invoice ?></h3>
                    <p><?= __('No Invoice') ?></p>
                </div>
            </div>
             </div>
            </div>
            <div class="col-md-12 col-xl-3">
                    <div class="card counter-card-1">
                        <div class="card-block-big">
                            <div>
                    <h3><?= $no_payments ?></h3>
                    <p><?= __('No Payments') ?> <p>
                 </div>
            </div>
             </div>
            </div>
           <div class="col-md-12 col-xl-3">
                    <div class="card counter-card-1">
                        <div class="card-block-big">
                            <div>
                    <h3><?= $payments_received ?></h3>
                   <p><?= __('Payments Received') ?> <p>
                </div>
            </div>
             </div>
            </div>
            <div class="col-md-12 col-xl-3">
                    <div class="card counter-card-1">
                        <div class="card-block-big">
                            <div>
                    <h3><?= $revenue_received ?></h3>
                    <p><?= __('Revenue Received') ?> <p>
                </div>
            </div>
             </div>
            </div>
        </div>

        <div class="row">
           <div class="col-sm-12 card">
             
                        <div class="col-md-9 col-sm-9 col-xs-12">

                            <ul class="stats-overview">
                                <li>
                                    <span class="name"><?= __('today_collect') ?></span>
                                    <span class="value text-success"> <?=  number_format($today_amount->sum) ?> </span>
                                </li>
                                <li>
                                    <span class="name"><?= __('week_collect') ?></span>
                                    <span class="value text-success"><?=   number_format($weekly_amount->sum) ?> </span>
                                </li>
                                <li class="hidden-phone">
                                    <span class="name"> <?= __('month_collect') ?> </span>
                                    <span class="value text-success"> <?=  number_format($monthly_amount->sum) ?></span>
                                </li>


                            </ul>
                            <br>

                            <div id="mainb">

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
                                                text: 'Expense and Revenue Per Month '
                                            },
                                            yAxis: {
                                                allowDecimals: false,
                                                title: {
                                                    text: 'Amounts (Tsh)'
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
                                                formatter: function () {
                                                    return '<b>' + this.series.name + '</b><br/>' +
                                                            this.point.y + ' ' + this.point.name.toLowerCase();
                                                }
                                            }
                                        });
                                    });
                                </script>
                                <script src="<?= url('public/assets/js/highchart.js') ?>"></script>
                                <script src="<?= url('public/assets/js/exporting.js') ?>"></script>
                                <script src="<?= url('public/assets/js/data.js') ?>"></script>

                                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                                <table id="datatable" style="display: none">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th><?= __('expense') ?></th>
                                            <th><?= __('revenue') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($revenue as $value) { ?>
                                            <tr>
                                                <th><?= date('M', strtotime($value->date)) ?></th>
                                                <td><?= $value->expense ?></td>
                                                <td><?= $value->revenue ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                            <div class="row">
                                <script type="text/javascript">
                                    $(function () {
                                        $('#container2').highcharts({
                                            chart: {
                                                plotBackgroundColor: null,
                                                plotBorderWidth: null,
                                                plotShadow: false,
                                                type: 'pie'
                                            },
                                            title: {
                                                text: 'Browser market shares January, 2015 to May, 2015'
                                            },
                                            tooltip: {
                                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                            },
                                            plotOptions: {
                                                pie: {
                                                    allowPointSelect: true,
                                                    cursor: 'pointer',
                                                    dataLabels: {
                                                        enabled: true,
                                                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                                        style: {
                                                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                        }
                                                    }
                                                }
                                            },
                                            series: [{
                                                    name: 'Brands',
                                                    colorByPoint: true,
                                                    data: [{
                                                            name: 'Microsoft Internet Explorer',
                                                            y: 56.33
                                                        }, {
                                                            name: 'Chrome',
                                                            y: 24.03,
                                                            sliced: true,
                                                            selected: true
                                                        }, {
                                                            name: 'Firefox',
                                                            y: 10.38
                                                        }, {
                                                            name: 'Safari',
                                                            y: 4.77
                                                        }, {
                                                            name: 'Opera',
                                                            y: 0.91
                                                        }, {
                                                            name: 'Proprietary or Undetectable',
                                                            y: 0.2
                                                        }]
                                                }]
                                        });
                                    });
                                </script>
                                <!--<div id="container2" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>-->

                            </div>

                        </div>

                        <!-- start project-detail sidebar -->
                        <div class="col-md-3 col-sm-3 col-xs-12">

                            <section class="panel">
                                <div class="alert alert-default">
                                    <div class="x_title">
                                        <h2><?= __('project_collect') ?></h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-body">
                                        <h3 class="green"><i class="fa fa-paint-brush"></i><?= __('revenue') ?></h3>
                                        <div class="project_detail">
                                            <p class="title"><?= __('expected_amount') ?></p>
                                            <p><?=   number_format($expected_amount->sum) ?>/=</p>
                                            <p class="title">Collected Revenue</p>
                                            <p><?=   number_format($collected_amount->sum) ?>/=</p>
                                        </div>

                                    </div>
                                </div>
                                <div class="alert alert-link">
                                    <div class="x_title">
                                        <h2><?= __('expense_project') ?></h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-body">
                                        <h3 class="green"><i class="fa fa-paint-brush"></i><?= __('expense') ?></h3>
                                        <div class="project_detail">
                                            <p class="title"><?= __('expected_amount') ?></p>
                                            <p><?=   number_format($expected_expense->sum) ?>/=</p>
                                            <p class="title">Amount Spent </p>
                                            <p><?=   number_format($expense->sum) ?>/=</p>
                                        </div>

                                    </div>
                                </div>
                            </section>

                        </div>
                        <!-- end project-detail sidebar -->

             
            </div>
        </div>
    </div>
     </div>
</div>

@endsection
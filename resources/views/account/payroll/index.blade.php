@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Payroll</h4>
                <span>Salaries</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Payroll</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">

                        <?php
                        // $usertype = session("usertype");
                        ?>
                        <div class="m-10">
                           <h5 class="page-header">
                            <a class="btn btn-success" href="<?php echo url('payroll/create') ?>"><i class="fa fa-plus"></i>
                                Add Payroll</a>&nbsp; 
                          </h5>
                        </div>

                        <div class="col-lg-12 col-xl-12">                                      
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home3" role="tab">Payroll List</a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#profile3" role="tab">Summary</a>
                                    <div class="slide"></div>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content card-block">
                                <div class="tab-pane active" id="home3" role="tabpanel">
                                  <div id="hide-table">
                                            <a
                                                class="right"><i class="fa fa-question-circle" data-container="body"
                                                             data-toggle="popover" data-placement="right" data-trigger="hover"
                                                             data-content="Use the buttons below to either copy or download the information on the table below. "
                                                             title="Export Buttons"></i></a>

                                         <div class="table-responsive table-sm table-striped table-bordered table-hover">          
                                            <table id="example1" class="table dataTable">
                                                <thead>
                                                    <tr>
                                                        <th class="col-sm-1"><?= __('#') ?></th>
                                                        <th class="col-sm-2"><?= __('payment_date') ?></th>
                                                        <th class="col-sm-2"><?= __('total_users') ?></th>
                                                        <th class="col-sm-2"><?= __('basic_pay') ?></th>
                                                        <th class="col-sm-1"><?= __('allowance') ?></th>
                                                        <th class="col-sm-1"><?= __('gross_pay') ?></th>
                                                        <th class="col-sm-1"><?= __('pension') ?></th>
                                                        <th class="col-sm-1"><?= __('deduction') ?></th>
                                                        <th class="col-sm-1"><?= __('tax') ?></th>
                                                        <th class="col-sm-1"><?= __('paye') ?></th>
                                                        <th class="col-sm-1"><?= __('net_pay') ?></th>

                                                        <?php
                                                        if (can_access('manage_payroll')) {
                                                            ?>
                                                            <th class="col-sm-4"><?= __('action') ?></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($salaries) && !empty($salaries)) {
                                                        $i = 1;
                                                        foreach ($salaries as $salary) {
                                                            ?>
                                                            <tr>
                                                                <td data-title="<?= __('slno') ?>">
                                                                    <?php echo $i; ?>
                                                                </td>
                                                                <td data-title="<?= __('payment_date') ?>">
                                                                    <?php
                                                                    echo date('d M Y', strtotime($salary->payment_date));
                                                                    ?>
                                                                </td>
                                                                <td data-title="<?= __('total_users') ?>">
                                                                    <?php echo $salary->total_users; ?>
                                                                </td>
                                                                <td data-title="<?= __('basic_pay') ?>">
                                                                    <?php echo money($salary->basic_pay); ?>
                                                                </td>
                                                                <td data-title="<?= __('allowance') ?>">
                                                                    <?php
                                                                    echo money($salary->allowance);
                                                                    ?>

                                                                <td data-title="<?= __('gross_pay') ?>">
                                                                    <?php echo money($salary->gross_pay); ?>
                                                                </td>
                                                                <td data-title="<?= __('paye') ?>">
                                                                    <?php echo money($salary->pension); ?></td>
                                                                <td data-title="<?= __('deduction') ?>">
                                                                    <?php echo money($salary->deduction); ?></td>
                                                                <td data-title="<?= __('tax') ?>">
                                                                    <?php echo money($salary->tax); ?></td>
                                                                <td data-title="<?= __('paye') ?>">
                                                                    <?php echo money($salary->paye); ?></td>
                                                                <td data-title="<?= __('net_pay') ?>">
                                                                    <?php echo money($salary->net_pay); ?></td>
                                                                    <?php
                                                                if (can_access('manage_payroll')) {
                                                                    ?>
                                                                    <td data-title="<?= __('action') ?>">
                                                                        <?php
                                                                        echo '<a  href="' . url("payroll/show/$salary->payment_date") . '  " class="btn btn-success btn-sm"><i class="fa fa-folder-o"></i> View </a>';

                                                                        echo '<a href="' . url("payroll/delete/$salary->reference") . '  " class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete </a>';
                                                                        ?>
                                                                    </td>
                                                                <?php } ?>

                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                         </div>
                                        </div>
                                </div>
                                <div class="tab-pane" id="profile3" role="tabpanel">
                                  <div class="row">


                                            <script type="text/javascript">
                                                $(function () {
                                                    $('#container').highcharts({
                                                        title: {
                                                            text: 'Payrol Summary'
                                                        },
                                                        xAxis: {
                                                            categories: [<?php
                                                    foreach ($salaries as $salary) {
                                                        echo '"' . date('M Y', strtotime($salary->payment_date)) . '",';
                                                    }
                                                    ?>]
                                                        },
                                                        labels: {
                                                            items: [{
                                                                    html: 'Payroll Summary for Basic and net payments',
                                                                    style: {
                                                                        left: '50px',
                                                                        top: '18px',
                                                                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                                                                    }
                                                                }]
                                                        },
                                                        series: [
                                                            {
                                                                type: 'column',
                                                                name: 'Basic Payments',
                                                                data: [
                                                                        <?php
                                                                        foreach ($salaries as $salary) {
                                                                            echo $salary->basic_pay . ',';
                                                                        }
                                                                        ?>
                                                                ]
                                                            }, {
                                                                type: 'column',
                                                                name: 'Net Payments',
                                                                data: [
                                                                    <?php
                                                                    foreach ($salaries as $salary) {
                                                                        echo $salary->net_pay . ',';
                                                                    }
                                                                    ?>
                                                                ]
                                                            }, {
                                                                type: 'spline',
                                                                name: 'Total Users',
                                                                data: [<?php
                                                                        foreach ($salaries as $salary) {
                                                                            echo $salary->total_users . ',';
                                                                        }
                                                                        ?>],
                                                                marker: {
                                                                    lineWidth: 2,
                                                                    lineColor: Highcharts.getOptions().colors[3],
                                                                    fillColor: 'white'
                                                                }
                                                            },
                                                                    //                {
                                                                    //            type: 'pie',
                                                                    //            name: 'Total consumption',
                                                                    //            data: [{
                                                                    //                name: 'Jane',
                                                                    //                y: 13,
                                                                    //                color: Highcharts.getOptions().colors[0] // Jane's color
                                                                    //            }, {
                                                                    //                name: 'John',
                                                                    //                y: 23,
                                                                    //                color: Highcharts.getOptions().colors[1] // John's color
                                                                    //            }, {
                                                                    //                name: 'Joe',
                                                                    //                y: 19,
                                                                    //                color: Highcharts.getOptions().colors[2] // Joe's color
                                                                    //            }],
                                                                    //            center: [100, 80],
                                                                    //            size: 100,
                                                                    //            showInLegend: false,
                                                                    //            dataLabels: {
                                                                    //                enabled: false
                                                                    //            }
                                                                    //        }
                                                        ]
                                                    });
                                                });


                                            </script>
                                            <script src="https://code.highcharts.com/highcharts.js"></script>
                                            <script src="https://code.highcharts.com/modules/exporting.js"></script>
                                            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                  </div>
                                </div>
                            </div>
                         </div>
                     </div>
                </div> 
            </div>
        </div>
</div>
@endsection
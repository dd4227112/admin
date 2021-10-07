@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
       
      <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">

            
                        <div class="card-header">
                              <a class="btn btn-success" href="<?php echo url('payroll/create') ?>">
                                Add Payroll
                            </a>
                        </div>

                        <div class="col-lg-12 col-xl-12">                                      
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
                                <div class="tab-pane active" id="home3" role="tabpanel">
                                     <div class="card-block">
                                     
                                      <div class="table-responsive">
                                          <table class="table dataTable table-sm table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th><?= __('#') ?></th>
                                                        <th><?= __('Payment date') ?></th>
                                                        <th><?= __('Total users') ?></th>
                                                        <th><?= __('Basic pay') ?></th>
                                                        <th><?= __('Allowance') ?></th>
                                                        <th><?= __('Gross pay') ?></th>
                                                        <th><?= __('Pension') ?></th>
                                                        <th><?= __('Deduction') ?></th>
                                                        <th><?= __('Tax') ?></th>
                                                        <th><?= __('Paye') ?></th>
                                                        <th><?= __('Net pay') ?></th>

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
                                                                <td>
                                                                    <?php echo $i; ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    echo date('d M Y', strtotime($salary->payment_date));
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $salary->total_users; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo money($salary->basic_pay); ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    echo money($salary->allowance);
                                                                    ?>

                                                                <td>
                                                                    <?php echo money($salary->gross_pay); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo money($salary->pension); ?></td>
                                                                <td>
                                                                    <?php echo money($salary->deduction); ?></td>
                                                                <td>
                                                                    <?php echo money($salary->tax); ?></td>
                                                                <td>
                                                                    <?php echo money($salary->paye); ?></td>
                                                                <td>
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
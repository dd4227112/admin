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
                            <div class="card-block">
                                <!-- Row start -->
                                <div class="row m-b-30">
                                    <div class="col-lg-12 col-xl-12">

                                        <ul class="nav nav-tabs md-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"><strong>Payroll List</strong></a>
                                                <div class="slide"></div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#profile7" role="tab"><strong>Summary</strong></a>
                                                <div class="slide"></div>
                                            </li>
                                        </ul>
                                        
                                        <div class="tab-content card-block">

                                          {{-- <div class="tab-pane active" id="home7" role="tabpanel">
                                            <div class="dt-responsive table-responsive">
                                              <table id="simpletable" class="table table-striped table-bordered nowrap dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Payment date</th>
                                                        <th>Total users</th>
                                                        <th>Basic pay</th>
                                                        <th>Allowance</th>
                                                        <th>Gross pay</th>
                                                        <th>Pension</th>
                                                        <th>Deduction</th>
                                                        <th>Tax</th>
                                                        <th>Paye</th>
                                                        <th>Net pay</th>
                                                        <?php if (can_access('manage_payroll')) {?>
                                                        <th>Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    if (isset($salaries) && !empty($salaries)) {
                                                        foreach ($salaries as $salary) { ?>
                                                        <tr>
                                                        <td> <?php echo $i; ?> </td>
                                                        <td> <?php echo date('d M Y', strtotime($salary->payment_date)); ?></td>
                                                        <td> <?php echo $salary->total_users; ?></td>
                                                        <td> <?php echo money($salary->basic_pay); ?></td>
                                                        <td> <?php echo money($salary->allowance); ?> </td>
                                                        <td> <?php echo money($salary->gross_pay); ?>  </td>
                                                        <td> <?php echo money($salary->pension); ?> </td>
                                                        <td> <?php echo money($salary->deduction); ?> </td>
                                                        <td> <?php echo money($salary->tax); ?></td> 
                                                        <td> <?php echo money($salary->paye); ?></td>
                                                        <td> <?php echo money($salary->net_pay); ?></td>
                                                        <?php if (can_access('manage_payroll')) { ?>
                                                        <td> <?php
                                                            echo '<a href="' . url("payroll/show/$salary->payment_date") . '  " class="btn btn-success btn-mini btn-round mr-2"> View </a>';
                                                            echo '<a href="' . url("payroll/delete/$salary->reference") . '  " class="btn btn-danger btn-mini btn-round"> Delete </a>';
                                                            ?>
                                                        </td>
                                                        <?php } ?>
                                                        </tr>
                                                      <?php $i++; } } ?>
                                                     </tbody>
                                                  </table>
                                                 </div>
                                             </div> --}}

                                               <div class="tab-pane" id="profile7" role="tabpanel">
                                                    <div class="card-body">
                                                        <figure class="highcharts-figure">
                                                            <div id="onboardPie" style="height: 300px; width:800px;"></div>
                                                        </figure>
                                                    </div>
                                              </div> 

                                        </div>
                                    </div>

                                </div>
                            </div>
                                            

            
                         </div>
                     </div>
                </div> 
            </div>
        </div>
   </div>


<script type="text/javascript">
   Highcharts.chart('onboardPie', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Payrol Summary'
    },
    subtitle: {
        text: 'Payroll Summary for Net payments'
    },
    xAxis: {
        type: 'Months',
       
        categories: [
        <?php foreach($salaries as $value){  ?> "<?= date('F Y', strtotime($value->payment_date)) ?>",
        <?php } ?>
      ]
    },
    yAxis: {
        title: {
            text: 'Payments'
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Months',
        colorByPoint: true,
        data: [
            <?php foreach($salaries as $value){ ?> {
                name: "<?= date('F Y', strtotime($value->payment_date)) ?>",
                y: <?=$value->net_pay?>,
                drilldown: <?=$value->net_pay ?>
            },
            <?php } ?>
        ]
    }]
});

 

</script>
@endsection
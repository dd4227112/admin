@extends('layouts.app')

@section('content')

    
      
         <div class="page-header">
            <div class="page-header-title">
                <h4><?='Reports' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">payments</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">accounts</a>
                    </li>
                </ul>
            </div>
        </div> 

         <div class="page-body">
            <!-- form start -->
                  <div class="card">
                     <div class="card-block">
                           <!-- <div class="col-sm-12">
                               <form class="form-horizontal" role="form" method="post"> 
                                    <div class="form-group row">
                                        <div class="col-md-4 col-sm-12">
                                            <input type="date" class="form-control" id="from_date" name="from_date" value="<?= old('from_date',$from) ?>" >
                                        </div>
                                  
                                        <div class="col-md-4 col-sm-12">
                                            <input type="date" class="form-control" id="to_date" name="to_date" value="<?= old('to_date',$to) ?>" >
                                        </div>
                                    
                                        <div class="col-md-2 col-sm-2 col-xs-6">
                                            <input type="submit" class="btn btn-success" value="Submit"  style="float: right;">
                                        </div>
                                    </div>
                                   <?= csrf_field() ?>
                                 </form>
                               </div>   -->
                                  
                  
                                <div class="dt-responsive table-responsive">
                                    <table id="invoice_table" class="table table-striped table-bordered nowrap dataTable">
                                    <div class="col-sm-12">
                               <form class="form-horizontal" role="form" method="post"> 
                                    <div class="form-group row">
                                        <div class="col-md-4 col-sm-12">
                                            <input type="date" class="form-control" id="from_date" name="from_date" value="<?= old('from_date',$from) ?>" >
                                        </div>
                                  
                                        <div class="col-md-4 col-sm-12">
                                            <input type="date" class="form-control" id="to_date" name="to_date" value="<?= old('to_date',$to) ?>" >
                                        </div>
                                    
                                        <div class="col-md-2 col-sm-2 col-xs-6">
                                            <input type="submit" class="btn btn-success" value="Submit"  style="float: right;">
                                        </div>
                                    </div>
                                   <?= csrf_field() ?>
                                 </form>
                               </div>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Client Name</th>
                                                <th>Reference #</th>
                                                <th>Paid date</th>
                                                <th>Amount</th>
                                                <th>Due Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_amount = 0;
                                            $total_paid = 0;
                                            $total_unpaid = 0;
                                            $i = 1;
                                            foreach ($invoices as $invoice) {

                                                ?>


                                                <tr>
                                                    <td><?= $i?></td>
                                                    <td><?= $invoice->name ?></td>
                                                    <td><?= $invoice->reference ?></td>
                                                    <td><?= date('d M Y', strtotime($invoice->created_at)) ?></td>
                                                    <td><?= money($invoice->amount) ?></td>
                                                    <td><?= date('d M Y', strtotime($invoice->due_date)) ?></td>
                                                    <td>
                                                        <a class="btn btn-success btn-mini btn-round" href="<?= url('account/receiptView/' . $invoice->id . '/'. $invoice->p_id) ?>"  > <span class="point-marker bg-danger"></span>View</a>
                                                   </td>
                                               </tr>
                                         <?php $i++; } ?>
                                        </tbody>
                                        <tfoot>
                                            {{-- <tr>
                                                <td colspan="2">Total</td>
                                                <td><?= money($total_amount) ?></td>
                                                <td><?= money($total_paid) ?></td>
                                                <td><?= money($total_unpaid) ?></td>
                                                <td colspan="2"></td>
                                            </tr> --}}
                                        </tfoot>
                                    </table>
                               </div>
                            </div>
                         </div>


                        <div class="row">
                          <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block">
                                    <div id="contain" style="height:350px;width:900px;" ></div>
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
Highcharts.chart('contain', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Payments'
    },
    subtitle: {
        text: 'Payments received every month'
    },
    xAxis: {
        type: 'Months',
       
        categories: [
        <?php foreach($invoice_reports as $value){  ?> "<?php $dateObj = DateTime::createFromFormat('!m', $value->month); $monthName = $dateObj->format('F'); echo $monthName ?>",
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
        name: 'Amount',
        colorByPoint: true,
        data: [
            <?php foreach($invoice_reports as $value){ ?> {
                name:"<?php $dateObj = DateTime::createFromFormat('!m', $value->month); $monthName = $dateObj->format('F'); echo $monthName ?>",
                y: <?=$value->sum?>,
                drilldown: <?=$value->sum ?>
            },
            <?php } ?>
        ]
    }]
});

    $('.calendar').on('click', function (e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");
    });
</script>
@endsection
@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/';
$root = url('/') . '/public/';
$page = request()->segment(3);
$today = 0;

if ((int) $page == 1 || $page == 'null' || (int) $page == 0) {
    //current day
    $where = '  a.created_at::date=CURRENT_DATE';
    $today = 1;
    $year = date('Y');
} else {
    $start_date = date('Y-m-d', strtotime(request('start')));
    $end_date = date('Y-m-d', strtotime(request('end')));
    $year = date('Y', strtotime(request('start')));
    $where = "  a.created_at::date >='" . $start_date . "' AND a.created_at::date <='" . $end_date . "'";
}
 ?>
<div class="page-wrapper">

         <div class="page-header">
        <div class="page-header-title">
             <h4><?= isset($start_date) && isset($end_date) ? 'Accounts Dashboard from '. date('d/m/Y', strtotime($start_date)) . ' to '. date('d/m/Y', strtotime($end_date)) : ' Accounts Dashboard' ?></h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                 <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">summary</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">accounts</a>
                </li>
            </ul>
        </div>
      </div> 

            
          <div class="row">
             <div class="col-sm-12 col-lg-3 m-b-20">
                <h6>Pick date </h6>
                <input type="text" name="dates" id="rangeDate" class="form-control">
            </div>
            <div class="col-sm-12 col-lg-3 m-b-20">
                <h6> &nbsp; </h6>
                <input type="submit" id="search_custom" class="input-sm btn btn-sm btn-success">
            </div>
        </div>

     <?php if (can_access('manage_users')) { ?>
      <div class="page-body">
          <div class="row">
    
                <!-- Documents card start -->
                <div class="col-md-6 col-xl-3">
                    <?php
                        $total_school=\collect(DB::select('select count(*) from admin.all_setting a WHERE  ' . $where))->first()->count;
                        $invoices_sent = \collect(DB::select('select count(*) from admin.invoices_sent a WHERE  ' . $where))->first()->count;
                        $issued = round($invoices_sent * 100 / ((int)$total_school==0 ? 1:$total_school), 1);
                    ?>
                       <div class="card">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-c-green f-w-700">{{ number_format($issued)}} </h4>
                                    <h6 class="text-muted m-b-0">Invoice Issued</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-file f-30"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-c-green">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">Invoice Issued</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

             
                <div class="col-md-6 col-xl-3">
                    <?php
                    $account_year=DB::table('admin.account_years')->where('name',date('Y'))->first();
                    $total_invoice = DB::table('admin.invoices')->where('account_year_id', $account_year->id)->count();
                    $invoice_paid =count(DB::select('select count(distinct invoice_id) from admin.invoice_fees where invoice_id in (select id from admin.invoices where account_year_id='.$account_year->id.')'));
                    $percent = ' percentage (' . round($invoice_paid * 100 / ((int) $total_invoice  == 0 ? 1 : 4), 1) .')';
                    ?>
                      <div class="card">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-c-green f-w-700">{{ number_format($invoice_paid)}} </h4>
                                    <h6 class="text-muted m-b-0">Invoice paid</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-file f-30"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-c-blue">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">{{$percent}}</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

             
                <div class="col-md-6 col-xl-3">
                  <?php $all_setting = \collect(DB::select('select count(*) from admin.all_setting  '))->first()->count; ?>
                  
                    <div class="card">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-c-green f-w-700">{{ number_format($all_setting)}} </h4>
                                    <h6 class="text-muted m-b-0">Our Clients</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-file f-30"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-c-yellow">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">School clients</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

              
                 <div class="col-md-6 col-xl-3">
                  <?php $paid_clients = \collect(DB::select("select COALESCE(count(distinct client_id),0) as clients from admin.invoices where id in (select invoice_id from  admin.payments where extract(year from created_at::date) = extract(year from current_date))"))->first(); ?>
                       <div class="card">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-c-green f-w-700">{{ number_format($paid_clients->clients)}} </h4>
                                    <h6 class="text-muted m-b-0">Paid Clients</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-file f-30"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-c-yellow">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">School clients</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
          
           <?php 
             if(in_array(Auth::user()->id, [2,3,7,770])){ 
            ?>
            <div class="row">
                <div class="col-md-12 col-xl-4">
                    <?php
                    $total_revenue = DB::table('revenues')->whereYear('created_at', date('Y'))->sum('amount');
                    $total_payments = DB::table('payments')->whereYear('created_at', date('Y'))->sum('amount');
                    $total_sms_payments=0;
                    $total = $total_revenue + $total_payments+$total_sms_payments;
                    ?>
                       <div class="card bg-c-green text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Revenue Collected This Year</p>
                                                <h4 class="m-b-0">{{ number_format($total) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-book f-50 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                </div>
              

                <div class="col-md-6 col-xl-4">
                    <?php
                    $day = date('Y-m-d');
                    $trans_revenue = \collect(DB::select('select count(*)*152.54 as total from admin.all_payments where extract(year from created_at)=' . date('Y') . '  and token is not null '))->first();
                    ?>
                      <div class="card bg-c-blue text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Yearly total Transaction Fee</p>
                                                <h4 class="m-b-0">{{ number_format($trans_revenue->total) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-book f-50 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                </div>
              

                <div class="col-md-6 col-xl-4">
                    <?php
                    $total_expense = DB::table('expenses')->whereYear('created_at', date('Y'))->sum('amount');
                    ?>
                     <div class="card bg-c-yellow text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Total Expenses This Year</p>
                                                <h4 class="m-b-0">{{ number_format($total_expense) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-book f-50 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                </div>
    
               </div>
            <?php } ?>

            <div class="row">
              <div class="col-lg-12">     
                <div class="card">
                    <div class="card-block">
                      <div class="cd-horizontal-timeline loaded">
                        <div class="events-content">
                            <div class="card">
                                     <div class="card-block">  
                                          <figure class="highcharts-figure">
                                             <div id="onboardBar" style="height: 400px; width:850px;"></div>
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
    <?php } ?>

</div>

<script>

    
Highcharts.chart('onboardBar', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Schools Vs Months'
    },
    subtitle: {
        text: 'Overall schools onboarded'
    },
    xAxis: {
        type: 'Values',
       
        categories: [
        <?php foreach($pay_collection as $value){  ?> '<?= $value->month ?>',
        <?php } ?>
      ]
    },
    yAxis: {
        title: {
            text: 'Collections'
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Values',
        colorByPoint: true,
        data: [
            <?php foreach($pay_collection as $value){ ?> {
                name: '<?= $value->month ?>',
                y: <?=$value->count?>,
                drilldown: <?=$value->count ?>
            },
            <?php } ?>
        ]
    }]
});

   submit_search = function () {
        $('#search_custom').mousedown(function () {
            var alldates = $('#rangeDate').val();
            alldates = alldates.trim();
            alldates = alldates.split("-");
            start_date = formatDate(alldates[0]);
            end_date = formatDate(alldates[1]);
            window.location.href = '<?= url('analyse/accounts/') ?>/5?start=' + start_date + '&end=' + end_date;
        });
    }
    $(document).ready(submit_search);
    $('input[name="dates"]').daterangepicker();

    $(document).ready(submit_search);

        formatDate = function (date) {
            date = new Date(date);
            var day = ('0' + date.getDate()).slice(-2);
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var year = date.getFullYear();
            return year + '-' + month + '-' + day;
        }

</script>
@endsection


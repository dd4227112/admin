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
        <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

         <div class="row">
             <div class="col-sm-12 col-xl-4 m-b-30">
                <h6>Pick date </h6>
                <input type="text" name="daterange" class="form-control">
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
                    <x-analyticCard :value="$issued" name="Invoice Issued" icon="feather icon-trending-up text-white f-16"  color="bg-c-green"  topicon="feather icon-file f-30" subtitle="Invoice Issued"></x-analyticCard>
                </div>

             
                <div class="col-md-6 col-xl-3">
                    <?php
                    $account_year=DB::table('admin.account_years')->where('name',date('Y'))->first();
                    $total_invoice = DB::table('admin.invoices')->where('account_year_id', $account_year->id)->count();
                    $invoice_paid =count(DB::select('select count(distinct invoice_id) from admin.invoice_fees where invoice_id in (select id from admin.invoices where account_year_id='.$account_year->id.')'));
                    $percent = ' percentage (' . round($invoice_paid * 100 / ((int) $total_invoice  == 0 ? 1 : 4), 1) .')';
                    ?>
                    <x-analyticCard :value="$invoice_paid" name="Invoice paid" icon="feather icon-trending-up text-white f-16"  color="bg-c-blue"  topicon="feather icon-file f-30" :subtitle="$percent"></x-analyticCard>
                </div>

             
                <div class="col-md-6 col-xl-3">
                  <?php $all_setting = \collect(DB::select('select count(*) from admin.all_setting  '))->first()->count; ?>
                    <x-analyticCard :value="$all_setting" name="Our Clients" icon="feather icon-trending-up text-white f-16"  color="bg-c-yellow"  topicon="feather icon-users f-30" subtitle="School clients"></x-analyticCard>
                </div>

              
                 <div class="col-md-6 col-xl-3">
                  <?php $paid_clients = \collect(DB::select("select COALESCE(count(distinct client_id),0) as clients from admin.invoices where id in (select invoice_id from  admin.payments where extract(year from created_at::date) = extract(year from current_date))"))->first(); ?>
                    <x-analyticCard :value="$paid_clients->clients" name="Paid clients" icon="feather icon-trending-up text-white f-16"  color="bg-c-yellow"  topicon="feather icon-book f-30" subtitle="School clients"></x-analyticCard>
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
                     <x-smallCard title="Revenue Collected This Year"
                                :value="$total"
                                icon="feather icon-book f-50 text-c-red"
                                cardcolor="bg-c-green text-white"
                                >
                     </x-smallCard>
                </div>
              

                <div class="col-md-6 col-xl-4">
                    <?php
                    $day = date('Y-m-d');
                    $trans_revenue = \collect(DB::select('select count(*)*152.54 as total from admin.all_payments where extract(year from created_at)=' . date('Y') . '  and token is not null '))->first();
                    ?>
                      <x-smallCard title="Yearly total Transaction Fee"
                                :value="$trans_revenue->total"
                                icon="feather icon-book f-50 text-c-red"
                                cardcolor="bg-c-blue text-white"
                                >
                     </x-smallCard>
                </div>
              

                <div class="col-md-6 col-xl-4">
                    <?php
                    $total_expense = DB::table('expenses')->whereYear('created_at', date('Y'))->sum('amount');
                    ?>
                     <x-smallCard title="Total Expenses This Year"
                                :value="$total_expense"
                                icon="feather icon-book f-50 text-c-red"
                                cardcolor="bg-c-yellow text-white"
                                >
                     </x-smallCard>
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
                                             <div id="onboardBar" style="height: 200px; width:850px;"></div>
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

    check = function () {
        $('#check_custom_date').change(function () {
            var val = $(this).val();
            if (val == 'today') {
                window.location.href = '<?= url('analyse/accounts/') ?>/1';
            } else {
                $('#show_date').show();
            }
        });
    }
    submit_search = function () {
        $('#search_custom').mousedown(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            window.location.href = '<?= url('analyse/accounts/') ?>/5?start=' + start_date + '&end=' + end_date;
        });
    }
    $(document).ready(check);
    $(document).ready(submit_search);
</script>
@endsection


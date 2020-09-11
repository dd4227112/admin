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
            <h4>Accounts Dashboard</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Summary</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Accounts Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
    <?php if (can_access('manage_users')) { ?>
        <div class="page-body">
                <div class="row">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4 text-right">
                <select class="form-control" id="check_custom_date">
                    <option value="today" <?= $today == 1 ? 'selected' : '' ?>>Today</option>
                    <option value="custom"  <?= $today == 0 ? 'selected' : '' ?>>Custom</option>
                </select>

            </div>
        </div>
        <div class="row" style="display: none" id="show_date">

            <div class="col-lg-4"></div>
            <div class="col-lg-8 text-right">
                <h4 class="sub-title">Date Time Picker</h4>
                <div class="input-daterange input-group" id="datepicker">
                    <input type="date" class="input-sm form-control calendar" name="start" id="start_date">
                    <span class="input-group-addon">to</span>
                    <input type="date" class="input-sm form-control" name="end" id="end_date">
                    <input type="submit" class="input-sm btn btn-sm btn-success" id="search_custom"/>
                </div>
            </div>

        </div>
             <div class="row">
                <!-- Documents card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks dark-primary-border">
                        <div class="card-block">
                            <h5> Invoice Issued</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-list"></i>
                                </li>
                                <li class="text-right">
                                     <?php
                                     $total_school=\collect(DB::select('select count(*) from admin.all_setting a WHERE  ' . $where))->first()->count;

                                $invoices_sent = \collect(DB::select('select count(*) from admin.invoices_sent a WHERE  ' . $where))->first()->count;
                                ?>
                                    <?php echo $invoices_sent; ?>
                                </li>
                                <span class="small"><?= round($invoices_sent * 100 / ((int)$total_school==0 ? 1:$total_school), 1) ?>% issued</span>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Documents card end -->
                <!-- New clients card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks warning-border">
                        <div class="card-block">
                            <h5>Total Invoice Paid</h5>
                            <ul>
                                <li>
                                    <i class="ti-layout text-warning"></i>
                                </li>
                                <li class="text-right text-warning">
                                         <?php
                                $all_setting = \collect(DB::select('select count(*) from admin.all_setting  '))->first()->count;
                                ?>
                                    <?php echo $all_setting; ?>
                                </li>
                                <span class="small"><?= ' percentage (' . round(43 * 100 / ((int) 434 == 0 ? 1 : 4), 1) ?>%)</span>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- New clients card end -->
                <!-- New files card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks success-border">
                        <div class="card-block">
                            <h5>Our Clients</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-users text-success"></i>
                                </li>
                                <li class="text-right text-success">
                                     <?php
                                $all_setting = \collect(DB::select('select count(*) from admin.all_setting  '))->first()->count;
                                ?>
                                    <?php echo $all_setting; ?>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- New files card end -->
                <!-- Open Project card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks">
                        <div class="card-block">
                            <h5>Clients Pay</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-ui-folder text-primary"></i>
                                </li>
                                <li class="text-right text-primary">
                                    <?php echo 43; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Open Project card end -->
            </div>
            <?php 
if(in_array(Auth::user()->id, [2,3,7])){ 
            ?>
            <div class="row">
                <!-- counter-card-1 start-->
                <div class="col-md-12 col-xl-4">
                    <div class="card counter-card-1">
                        <div class="card-block-big">
                            <div>
                                <?php
                                $total_revenue = DB::table('revenues')->whereYear('created_at', date('Y'))->sum('amount');
                                $total_payments = DB::table('payments')->whereYear('created_at', date('Y'))->sum('amount');
                                                 $total_sms_payments = DB::connection('karibusms')->table('payment')->whereYear('time', date('Y'))->sum('amount');
                                ?>
                                <h3>Tsh <?= number_format($total_revenue + $total_payments+$total_sms_payments) ?></h3>
                                <p>Revenue Collected This Year
                                    <span class="f-right text-primary">
                                        <i class="icofont icofont-arrow-up"></i>
                                        37.89%
                                    </span></p>
                                <div class="progress ">
                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <i class="icofont icofont-comment"></i>
                        </div>
                    </div>
                </div>
                <!-- counter-card-1 end-->
                <!-- counter-card-2 start -->
                <div class="col-md-6 col-xl-4">
                    <div class="card counter-card-2">
                        <div class="card-block-big">
                            <div>
                                <?php
                                $day = date('Y-m-d');
                                $trans_revenue = \collect(DB::select('select count(*)*152.54 as total from admin.all_payments where extract(year from created_at)=' . date('Y') . '  and token is not null '))->first();
                                ?>
                                <h3>Tsh <?= number_format($trans_revenue->total) ?></h3>
                                <p>Yearly total Transaction Fee 
                                    <span class="f-right text-success">
                                        <i class="icofont icofont-arrow-up"></i>
                                        34.52%
                                    </span>
                                </p>
                                <div class="progress ">
                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <i class="icofont icofont-coffee-mug"></i>
                        </div>
                    </div>
                </div>
                <!-- counter-card-2 end -->
                <!-- counter-card-3 start -->
                <div class="col-md-6 col-xl-4">
                    <div class="card counter-card-3">
                        <div class="card-block-big">
                            <div>
                                <?php
                                $total_expense = DB::table('expense')->whereYear('created_at', date('Y'))->sum('amount');
                                ?>
                                <h3>Tsh <?= number_format($total_expense) ?></h3>

                                <p>Total Expenses This Year
                                    <span class="f-right text-default">
                                        <i class="icofont icofont-arrow-down"></i>
                                        22.34%
                                    </span></p>
                                <div class="progress ">
                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-default" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <i class="icofont icofont-upload"></i>
                        </div>
                    </div>
                </div>
                <!-- counter-card-3 end -->
                <!-- Monthly Growth Chart start-->
    
            </div>
<?php } ?>
                <div class="row">
                    <div class="col-xl-6">
                          
                <div class="card">
                    <div class="card-header">
                        <h5>Average Collection Per Month </h5>
                    </div>
                    <div class="card-block">
                        <div class="cd-horizontal-timeline loaded">

                            <!-- .timeline -->
                            <div class="events-content">
                                <div class="card">

                                    <div class="card-block">

                                        <?php
                                        

                                 $sql_2 = "select sum(count) as count, month from (

                                 select sum(amount) as count, extract(month from created_at) as month from admin.payments a   where extract(year from created_at)=".date('Y')." group by month
                                 UNION ALL
                                 select sum(amount) as count, extract(month from created_at) as month from admin.revenues a   where extract(year from created_at)=".date('Y')." group by month


                             ) a group by month order by month asc ";

                               echo $insight->createChartBySql($sql_2, 'month', 'Payments Collection Per Month', 'line', false);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- .events-content -->
                        </div>
                    </div>
                </div>
            
                    </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Budget Distribution</h5>
                        </div>
                        <div class="card-block">
                      <!--       <?php
                            //$rations = DB::select('select a.name, sum(b.amount) from admin.budget_ratios a join admin.payments_budget_ratios b on a.id=b.budget_ratio_id  group by a.name');
                           // $widget=['primary','success','inverse'];
                           // foreach ($rations as $ratio) {
                                ?>
                            <div class="card bg-<?php // $widget[rand(0, 2)]?> large-widget-card">
                                    <div class="card-block-big">
                                        <h4>Tsh <?php // number_format($ratio->sum)?></h4>
                                        <h6><?php //$ratio->name?></h6>
                                        <i class="icofont icofont-star"></i>
                                    </div>
                                </div>
                            <?php // } ?>
                          -->

                        </div>
                    </div>
                </div>
</div>
        </div>
    <?php } ?>

</div>
<?php if (can_access('manage_users')) { ?>

<?php } ?>
@endsection


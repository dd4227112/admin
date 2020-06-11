@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
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
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Revenue Vs Expense</h5>
                        </div>
                        <div class="card-block">
                            <div id="chart4" class="c3" style="max-height: 320px; position: relative;">
                                
                               <div class="c3-tooltip-container" style="position: absolute; pointer-events: none; display: none; top: 17.7031px; left: 96.5px;">
                                </div>
                                    
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Monthly Growth Chart end-->
                <!-- Google Chart start-->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Budget Distribution</h5>
                        </div>
                        <div class="card-block">
                            <?php
                            $rations = DB::select('select a.name, sum(b.amount) from admin.budget_ratios a join admin.payments_budget_ratios b on a.id=b.budget_ratio_id  group by a.name');
                            $widget=['primary','success','inverse'];
                            foreach ($rations as $ratio) {
                                ?>
                            <div class="card bg-<?= $widget[rand(0, 2)]?> large-widget-card">
                                    <div class="card-block-big">
                                        <h4>Tsh <?= number_format($ratio->sum)?></h4>
                                        <h6><?=$ratio->name?></h6>
                                        <i class="icofont icofont-star"></i>
                                    </div>
                                </div>
                            <?php } ?>
                         

                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php } ?>
</div>
<?php if (can_access('manage_users')) { ?>
    <script type="text/javascript">
        dashboard_summary = function () {
            $.ajax({
                url: '<?= url('analyse/summary/null') ?>',
                data: {},
                dataType: 'JSONP',
                success: function (data) {
                    console.log(data);
                    $('#all_users').html(data.users);
                    $('#all_students').html(data.students);
                    $('#all_parents').html(data.parents);
                    $('#all_teachers').html(data.teachers);
                    $('#schools_with_shulesoft').html(data.total_schools);
                    $('#schools_with_students').html(data.total_schools - data.schools_with_students);
                    //
                    $('#active_users').html(data.active_users);
                    $('#active_students').html(data.active_students);
                    $('#active_parents').html(data.active_parents);
                    $('#active_teachers').html(data.active_teachers);
                }
            });
        }
        $(document).ready(dashboard_summary);
    </script>
<?php } ?>
@endsection


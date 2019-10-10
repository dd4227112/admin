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
                                $total_revenue = DB::table('revenues')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('amount');
                                ?>
                                <h3>Tsh <?= $total_revenue ?></h3>
                                <p>Revenue Collocted This Month
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
                                $trans_revenue = \collect(DB::select('select count(*)*152.54 as total from admin.all_payments where created_at::date=\'' . $day . '\' and token is not null '))->first();
                                ?>
                                <h3>Tsh <?= $trans_revenue->total ?></h3>
                                <p>Today total Transaction Fee 
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
                                $total_expense = DB::table('expense')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('amount');
                                ?>
                                <h3>Tsh <?= $total_expense ?></h3>

                                <p>Total Expenses This Month
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
                            <h5>Monthly Growth</h5>
                        </div>
                        <div class="card-block">
                            <div id="chart4" class="c3" style="max-height: 320px; position: relative;"><svg width="470.703125" height="320" style="overflow: hidden;"><defs><clipPath id="c3-1570736271028-clip"><rect width="428.703125" height="266"></rect></clipPath><clipPath id="c3-1570736271028-clip-xaxis"><rect x="-41" y="-20" width="500.703125" height="70"></rect></clipPath><clipPath id="c3-1570736271028-clip-yaxis"><rect x="-39" y="-4" width="60" height="290"></rect></clipPath><clipPath id="c3-1570736271028-clip-grid"><rect width="428.703125" height="266"></rect></clipPath><clipPath id="c3-1570736271028-clip-subchart"><rect width="428.703125"></rect></clipPath></defs><g transform="translate(40.5,4.5)"><text class="c3-text c3-empty" text-anchor="middle" dominant-baseline="middle" x="214.3515625" y="133" style="opacity: 0;"></text><rect class="c3-zoom-rect" width="428.703125" height="266" style="opacity: 0;"></rect><g clip-path="url(http://localhost/shulesoft/public/admin3/flatable.phoenixcoded.net/default/dashboard-ecommerce.html#c3-1570736271028-clip)" class="c3-regions" style="visibility: visible;"></g><g clip-path="url(http://localhost/shulesoft/public/admin3/flatable.phoenixcoded.net/default/dashboard-ecommerce.html#c3-1570736271028-clip-grid)" class="c3-grid" style="visibility: visible;"><g class="c3-xgrid-focus"><line class="c3-xgrid-focus" x1="-10" x2="-10" y1="0" y2="266" style="visibility: hidden;"></line></g></g><g clip-path="url(http://localhost/shulesoft/public/admin3/flatable.phoenixcoded.net/default/dashboard-ecommerce.html#c3-1570736271028-clip)" class="c3-chart"><g class="c3-event-rects c3-event-rects-single" style="fill-opacity: 0;"><rect class=" c3-event-rect c3-event-rect-0" x="0.2747395833333357" y="0" width="71.45052083333333" height="266"></rect><rect class=" c3-event-rect c3-event-rect-1" x="72.27473958333334" y="0" width="71.45052083333333" height="266"></rect><rect class=" c3-event-rect c3-event-rect-2" x="143.27473958333334" y="0" width="71.45052083333333" height="266"></rect><rect class=" c3-event-rect c3-event-rect-3" x="215.27473958333334" y="0" width="71.45052083333333" height="266"></rect><rect class=" c3-event-rect c3-event-rect-4" x="286.2747395833333" y="0" width="71.45052083333333" height="266"></rect><rect class=" c3-event-rect c3-event-rect-5" x="357.2747395833333" y="0" width="71.45052083333333" height="266"></rect></g><g class="c3-chart-bars"><g class="c3-chart-bar c3-target c3-target-data1" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data1 c3-bars c3-bars-data1" style="cursor: pointer;"><path class="c3-shape c3-shape-0 c3-bar c3-bar-0" style="stroke: rgb(0, 194, 146); fill: rgb(0, 194, 146); opacity: 1;" d="M 14.564843750000001,266 L14.564843750000001,247.9318181818182 L36,247.9318181818182 L36,266 z"></path><path class="c3-shape c3-shape-1 c3-bar c3-bar-1" style="stroke: rgb(0, 194, 146); fill: rgb(0, 194, 146); opacity: 1;" d="M 86.56484375,266 L86.56484375,253.95454545454544 L108,253.95454545454544 L108,266 z"></path><path class="c3-shape c3-shape-2 c3-bar c3-bar-2" style="stroke: rgb(0, 194, 146); fill: rgb(0, 194, 146); opacity: 1;" d="M 157.56484375,266 L157.56484375,235.88636363636365 L179,235.88636363636365 L179,266 z"></path><path class="c3-shape c3-shape-3 c3-bar c3-bar-3" style="stroke: rgb(0, 194, 146); fill: rgb(0, 194, 146); opacity: 1;" d="M 229.56484375,266 L229.56484375,241.9090909090909 L251,241.9090909090909 L251,266 z"></path><path class="c3-shape c3-shape-4 c3-bar c3-bar-4" style="stroke: rgb(0, 194, 146); fill: rgb(0, 194, 146); opacity: 1;" d="M 300.56484375,266 L300.56484375,229.86363636363635 L322,229.86363636363635 L322,266 z"></path><path class="c3-shape c3-shape-5 c3-bar c3-bar-5" style="stroke: rgb(0, 194, 146); fill: rgb(0, 194, 146); opacity: 1;" d="M 371.56484375,266 L371.56484375,235.88636363636365 L393,235.88636363636365 L393,266 z"></path></g></g><g class="c3-chart-bar c3-target c3-target-data2" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data2 c3-bars c3-bars-data2" style="cursor: pointer;"><path class="c3-shape c3-shape-0 c3-bar c3-bar-0" style="stroke: rgb(76, 86, 103); fill: rgb(76, 86, 103); opacity: 1;" d="M 14.564843750000001,247.9318181818182 L14.564843750000001,127.47727272727275 L36,127.47727272727275 L36,247.9318181818182 z"></path><path class="c3-shape c3-shape-1 c3-bar c3-bar-1" style="stroke: rgb(76, 86, 103); fill: rgb(76, 86, 103); opacity: 1;" d="M 86.56484375,253.95454545454544 L86.56484375,175.65909090909088 L108,175.65909090909088 L108,253.95454545454544 z"></path><path class="c3-shape c3-shape-2 c3-bar c3-bar-2" style="stroke: rgb(76, 86, 103); fill: rgb(76, 86, 103); opacity: 1;" d="M 157.56484375,235.88636363636365 L157.56484375,181.68181818181822 L179,181.68181818181822 L179,235.88636363636365 z"></path><path class="c3-shape c3-shape-3 c3-bar c3-bar-3" style="stroke: rgb(76, 86, 103); fill: rgb(76, 86, 103); opacity: 1;" d="M 229.56484375,241.9090909090909 L229.56484375,97.36363636363637 L251,97.36363636363637 L251,241.9090909090909 z"></path><path class="c3-shape c3-shape-4 c3-bar c3-bar-4" style="stroke: rgb(76, 86, 103); fill: rgb(76, 86, 103); opacity: 1;" d="M 300.56484375,229.86363636363635 L300.56484375,151.56818181818178 L322,151.56818181818178 L322,229.86363636363635 z"></path><path class="c3-shape c3-shape-5 c3-bar c3-bar-5" style="stroke: rgb(76, 86, 103); fill: rgb(76, 86, 103); opacity: 1;" d="M 371.56484375,235.88636363636365 L371.56484375,103.38636363636365 L393,103.38636363636365 L393,235.88636363636365 z"></path></g></g><g class="c3-chart-bar c3-target c3-target-data3" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data3 c3-bars c3-bars-data3" style="cursor: pointer;"></g></g><g class="c3-chart-bar c3-target c3-target-data4" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data4 c3-bars c3-bars-data4" style="cursor: pointer;"></g></g><g class="c3-chart-bar c3-target c3-target-data5" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data5 c3-bars c3-bars-data5" style="cursor: pointer;"><path class="c3-shape c3-shape-0 c3-bar c3-bar-0" style="stroke: rgb(163, 174, 189); fill: rgb(163, 174, 189); opacity: 1;" d="M 36,266 L36,187.70454545454544 L57.43515625,187.70454545454544 L57.43515625,266 z"></path><path class="c3-shape c3-shape-1 c3-bar c3-bar-1" style="stroke: rgb(163, 174, 189); fill: rgb(163, 174, 189); opacity: 1;" d="M 108,266 L108,193.72727272727275 L129.43515625,193.72727272727275 L129.43515625,266 z"></path><path class="c3-shape c3-shape-2 c3-bar c3-bar-2" style="stroke: rgb(163, 174, 189); fill: rgb(163, 174, 189); opacity: 1;" d="M 179,266 L179,175.65909090909093 L200.43515625,175.65909090909093 L200.43515625,266 z"></path><path class="c3-shape c3-shape-3 c3-bar c3-bar-3" style="stroke: rgb(163, 174, 189); fill: rgb(163, 174, 189); opacity: 1;" d="M 251,266 L251,181.6818181818182 L272.43515625,181.6818181818182 L272.43515625,266 z"></path><path class="c3-shape c3-shape-4 c3-bar c3-bar-4" style="stroke: rgb(163, 174, 189); fill: rgb(163, 174, 189); opacity: 1;" d="M 322,266 L322,169.63636363636365 L343.43515625,169.63636363636365 L343.43515625,266 z"></path><path class="c3-shape c3-shape-5 c3-bar c3-bar-5" style="stroke: rgb(163, 174, 189); fill: rgb(163, 174, 189); opacity: 1;" d="M 393,266 L393,175.65909090909093 L414.43515625,175.65909090909093 L414.43515625,266 z"></path></g></g><g class="c3-chart-bar c3-target c3-target-data6" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data6 c3-bars c3-bars-data6" style="cursor: pointer;"></g></g></g><g class="c3-chart-lines"><g class="c3-chart-line c3-target c3-target-data1" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data1 c3-lines c3-lines-data1"></g><g class=" c3-shapes c3-shapes-data1 c3-areas c3-areas-data1"></g><g class=" c3-selected-circles c3-selected-circles-data1"></g><g class=" c3-shapes c3-shapes-data1 c3-circles c3-circles-data1" style="cursor: pointer;"></g></g><g class="c3-chart-line c3-target c3-target-data2" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data2 c3-lines c3-lines-data2"></g><g class=" c3-shapes c3-shapes-data2 c3-areas c3-areas-data2"></g><g class=" c3-selected-circles c3-selected-circles-data2"></g><g class=" c3-shapes c3-shapes-data2 c3-circles c3-circles-data2" style="cursor: pointer;"></g></g><g class="c3-chart-line c3-target c3-target-data3" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data3 c3-lines c3-lines-data3"><path class=" c3-shape c3-shape c3-line c3-line-data3" style="stroke: rgb(3, 169, 243); opacity: 1;" d="M36,85.31818181818184Q93.7,137.11363636363637,108,145.54545454545456C129.45,158.19318181818184,157.55,187.70454545454547,179,169.63636363636365S229.55,33.22159090909093,251,25.0909090909091S300.7,101.8806818181818,322,115.43181818181816Q336.2,124.46590909090907,393,115.43181818181816"></path></g><g class=" c3-shapes c3-shapes-data3 c3-areas c3-areas-data3"><path class=" c3-shape c3-shape c3-area c3-area-data3" style="fill: rgb(3, 169, 243); opacity: 0.2;" d="M 36 85.31818181818184"></path></g><g class=" c3-selected-circles c3-selected-circles-data3"></g><g class=" c3-shapes c3-shapes-data3 c3-circles c3-circles-data3" style="cursor: pointer;"><circle class="c3-shape c3-shape-0 c3-circle c3-circle-0" r="2.5" style="fill: rgb(3, 169, 243); opacity: 1;" cx="36" cy="85.31818181818184"></circle><circle class=" c3-shape c3-shape-1 c3-circle c3-circle-1" r="2.5" style="fill: rgb(3, 169, 243); opacity: 1;" cx="108" cy="145.54545454545456"></circle><circle class=" c3-shape c3-shape-2 c3-circle c3-circle-2" r="2.5" style="fill: rgb(3, 169, 243); opacity: 1;" cx="179" cy="169.63636363636365"></circle><circle class=" c3-shape c3-shape-3 c3-circle c3-circle-3" r="2.5" style="fill: rgb(3, 169, 243); opacity: 1;" cx="251" cy="25.0909090909091"></circle><circle class=" c3-shape c3-shape-4 c3-circle c3-circle-4" r="2.5" style="fill: rgb(3, 169, 243); opacity: 1;" cx="322" cy="115.43181818181816"></circle><circle class=" c3-shape c3-shape-5 c3-circle c3-circle-5" r="2.5" style="fill: rgb(3, 169, 243); opacity: 1;" cx="393" cy="115.43181818181816"></circle></g></g><g class="c3-chart-line c3-target c3-target-data4" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data4 c3-lines c3-lines-data4"><path class=" c3-shape c3-shape c3-line c3-line-data4" style="stroke: rgb(171, 140, 228); opacity: 1;" d="M36,145.54545454545456L108,187.70454545454544L179,211.79545454545456L251,121.45454545454547L322,187.70454545454544L393,133.5"></path></g><g class=" c3-shapes c3-shapes-data4 c3-areas c3-areas-data4"><path class=" c3-shape c3-shape c3-area c3-area-data4" style="fill: rgb(171, 140, 228); opacity: 0.2;" d="M 36 145.54545454545456"></path></g><g class=" c3-selected-circles c3-selected-circles-data4"></g><g class=" c3-shapes c3-shapes-data4 c3-circles c3-circles-data4" style="cursor: pointer;"><circle class="c3-shape c3-shape-0 c3-circle c3-circle-0" r="2.5" style="fill: rgb(171, 140, 228); opacity: 1;" cx="36" cy="145.54545454545456"></circle><circle class=" c3-shape c3-shape-1 c3-circle c3-circle-1" r="2.5" style="fill: rgb(171, 140, 228); opacity: 1;" cx="108" cy="187.70454545454544"></circle><circle class=" c3-shape c3-shape-2 c3-circle c3-circle-2" r="2.5" style="fill: rgb(171, 140, 228); opacity: 1;" cx="179" cy="211.79545454545456"></circle><circle class=" c3-shape c3-shape-3 c3-circle c3-circle-3" r="2.5" style="fill: rgb(171, 140, 228); opacity: 1;" cx="251" cy="121.45454545454547"></circle><circle class=" c3-shape c3-shape-4 c3-circle c3-circle-4" r="2.5" style="fill: rgb(171, 140, 228); opacity: 1;" cx="322" cy="187.70454545454544"></circle><circle class=" c3-shape c3-shape-5 c3-circle c3-circle-5" r="2.5" style="fill: rgb(171, 140, 228); opacity: 1;" cx="393" cy="133.5"></circle></g></g><g class="c3-chart-line c3-target c3-target-data5" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data5 c3-lines c3-lines-data5"></g><g class=" c3-shapes c3-shapes-data5 c3-areas c3-areas-data5"></g><g class=" c3-selected-circles c3-selected-circles-data5"></g><g class=" c3-shapes c3-shapes-data5 c3-circles c3-circles-data5" style="cursor: pointer;"></g></g><g class="c3-chart-line c3-target c3-target-data6" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data6 c3-lines c3-lines-data6"><path class=" c3-shape c3-shape c3-line c3-line-data6" style="stroke: rgb(254, 193, 7); opacity: 1;" d="M36,211.79545454545456L108,223.8409090909091L179,253.95454545454544L251,235.88636363636365L322,229.86363636363635L393,193.72727272727275"></path></g><g class=" c3-shapes c3-shapes-data6 c3-areas c3-areas-data6"><path class=" c3-shape c3-shape c3-area c3-area-data6" style="fill: rgb(254, 193, 7); opacity: 0.2;" d="M36,211.79545454545456L108,223.8409090909091L179,253.95454545454544L251,235.88636363636365L322,229.86363636363635L393,193.72727272727275L393,266L322,266L251,266L179,266L108,266L36,266Z"></path></g><g class=" c3-selected-circles c3-selected-circles-data6"></g><g class=" c3-shapes c3-shapes-data6 c3-circles c3-circles-data6" style="cursor: pointer;"><circle class="c3-shape c3-shape-0 c3-circle c3-circle-0" r="2.5" style="fill: rgb(254, 193, 7); opacity: 1;" cx="36" cy="211.79545454545456"></circle><circle class=" c3-shape c3-shape-1 c3-circle c3-circle-1" r="2.5" style="fill: rgb(254, 193, 7); opacity: 1;" cx="108" cy="223.8409090909091"></circle><circle class=" c3-shape c3-shape-2 c3-circle c3-circle-2" r="2.5" style="fill: rgb(254, 193, 7); opacity: 1;" cx="179" cy="253.95454545454544"></circle><circle class=" c3-shape c3-shape-3 c3-circle c3-circle-3" r="2.5" style="fill: rgb(254, 193, 7); opacity: 1;" cx="251" cy="235.88636363636365"></circle><circle class=" c3-shape c3-shape-4 c3-circle c3-circle-4" r="2.5" style="fill: rgb(254, 193, 7); opacity: 1;" cx="322" cy="229.86363636363635"></circle><circle class=" c3-shape c3-shape-5 c3-circle c3-circle-5" r="2.5" style="fill: rgb(254, 193, 7); opacity: 1;" cx="393" cy="193.72727272727275"></circle></g></g></g><g class="c3-chart-arcs" transform="translate(214.3515625,128)"><text class="c3-chart-arcs-title" style="text-anchor: middle; opacity: 0;"></text></g><g class="c3-chart-texts"><g class="c3-chart-text c3-target c3-target-data1" style="opacity: 1; pointer-events: none;"><g class=" c3-texts c3-texts-data1"></g></g><g class="c3-chart-text c3-target c3-target-data2" style="opacity: 1; pointer-events: none;"><g class=" c3-texts c3-texts-data2"></g></g><g class="c3-chart-text c3-target c3-target-data3" style="opacity: 1; pointer-events: none;"><g class=" c3-texts c3-texts-data3"></g></g><g class="c3-chart-text c3-target c3-target-data4" style="opacity: 1; pointer-events: none;"><g class=" c3-texts c3-texts-data4"></g></g><g class="c3-chart-text c3-target c3-target-data5" style="opacity: 1; pointer-events: none;"><g class=" c3-texts c3-texts-data5"></g></g><g class="c3-chart-text c3-target c3-target-data6" style="opacity: 1; pointer-events: none;"><g class=" c3-texts c3-texts-data6"></g></g></g></g><g clip-path="url(http://localhost/shulesoft/public/admin3/flatable.phoenixcoded.net/default/dashboard-ecommerce.html#c3-1570736271028-clip-grid)" class="c3-grid c3-grid-lines"><g class="c3-xgrid-lines"></g><g class="c3-ygrid-lines"></g></g><g class="c3-axis c3-axis-x" clip-path="url(http://localhost/shulesoft/public/admin3/flatable.phoenixcoded.net/default/dashboard-ecommerce.html#c3-1570736271028-clip-xaxis)" transform="translate(0,266)" style="visibility: visible; opacity: 1;"><text class="c3-axis-x-label" transform="" style="text-anchor: end;" x="428.703125" dx="-0.5em" dy="-0.5em"></text><g class="tick" transform="translate(36, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">0</tspan></text></g><g class="tick" transform="translate(108, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">1</tspan></text></g><g class="tick" transform="translate(179, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">2</tspan></text></g><g class="tick" transform="translate(251, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">3</tspan></text></g><g class="tick" transform="translate(322, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">4</tspan></text></g><g class="tick" transform="translate(393, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">5</tspan></text></g><path class="domain" d="M0,6V0H428.703125V6"></path></g><g class="c3-axis c3-axis-y" clip-path="url(http://localhost/shulesoft/public/admin3/flatable.phoenixcoded.net/default/dashboard-ecommerce.html#c3-1570736271028-clip-yaxis)" transform="translate(0,0)" style="visibility: visible; opacity: 1;"><text class="c3-axis-y-label" transform="rotate(-90)" style="text-anchor: end;" x="0" dx="-0.5em" dy="1.2em"></text><g class="tick" transform="translate(0,266)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">0</tspan></text></g><g class="tick" transform="translate(0,236)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">50</tspan></text></g><g class="tick" transform="translate(0,206)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">100</tspan></text></g><g class="tick" transform="translate(0,176)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">150</tspan></text></g><g class="tick" transform="translate(0,146)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">200</tspan></text></g><g class="tick" transform="translate(0,116)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">250</tspan></text></g><g class="tick" transform="translate(0,86)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">300</tspan></text></g><g class="tick" transform="translate(0,56)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">350</tspan></text></g><g class="tick" transform="translate(0,26)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">400</tspan></text></g><path class="domain" d="M-6,1H0V266H-6"></path></g><g class="c3-axis c3-axis-y2" transform="translate(428.703125,0)" style="visibility: hidden; opacity: 1;"><text class="c3-axis-y2-label" transform="rotate(-90)" style="text-anchor: end;" x="0" dx="-0.5em" dy="-0.5em"></text><g class="tick" transform="translate(0,266)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0</tspan></text></g><g class="tick" transform="translate(0,240)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.1</tspan></text></g><g class="tick" transform="translate(0,213)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.2</tspan></text></g><g class="tick" transform="translate(0,187)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.3</tspan></text></g><g class="tick" transform="translate(0,160)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.4</tspan></text></g><g class="tick" transform="translate(0,134)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.5</tspan></text></g><g class="tick" transform="translate(0,107)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.6</tspan></text></g><g class="tick" transform="translate(0,81)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.7</tspan></text></g><g class="tick" transform="translate(0,54)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.8</tspan></text></g><g class="tick" transform="translate(0,28)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.9</tspan></text></g><g class="tick" transform="translate(0,1)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">1</tspan></text></g><path class="domain" d="M6,1H0V266H6"></path></g></g><g transform="translate(20.5,320.5)" style="visibility: hidden;"><g clip-path="url(http://localhost/shulesoft/public/admin3/flatable.phoenixcoded.net/default/dashboard-ecommerce.html#c3-1570736271028-clip-subchart)" class="c3-chart"><g class="c3-chart-bars"></g><g class="c3-chart-lines"></g></g><g clip-path="url(http://localhost/shulesoft/public/admin3/flatable.phoenixcoded.net/default/dashboard-ecommerce.html#c3-1570736271028-clip)" class="c3-brush" style="pointer-events: all; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><rect class="background" x="0" width="448.703125" style="visibility: hidden; cursor: crosshair;"></rect><rect class="extent" x="0" width="0" style="cursor: move;"></rect><g class="resize e" transform="translate(0,0)" style="cursor: ew-resize; display: none;"><rect x="-3" width="6" height="6" style="visibility: hidden;"></rect></g><g class="resize w" transform="translate(0,0)" style="cursor: ew-resize; display: none;"><rect x="-3" width="6" height="6" style="visibility: hidden;"></rect></g></g><g class="c3-axis-x" transform="translate(0,0)" clip-path="url(http://localhost/shulesoft/public/admin3/flatable.phoenixcoded.net/default/dashboard-ecommerce.html#c3-1570736271028-clip-xaxis)" style="visibility: hidden; opacity: 1;"><g class="tick" transform="translate(36, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">0</tspan></text></g><g class="tick" transform="translate(108, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">1</tspan></text></g><g class="tick" transform="translate(179, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">2</tspan></text></g><g class="tick" transform="translate(251, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">3</tspan></text></g><g class="tick" transform="translate(322, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">4</tspan></text></g><g class="tick" transform="translate(393, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">5</tspan></text></g><path class="domain" d="M0,6V0H428.703125V6"></path></g></g><g transform="translate(0,300)"><g class="c3-legend-item c3-legend-item-data1" style="visibility: visible; cursor: pointer;"><text x="88.4375" y="9" style="pointer-events: none;">data1</text><rect class="c3-legend-item-event" x="74.4375" y="-5" width="55.03125" height="18" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" x1="72.4375" y1="4" x2="82.4375" y2="4" stroke-width="10" style="stroke: rgb(0, 194, 146); pointer-events: none;"></line></g><g class="c3-legend-item c3-legend-item-data2" style="visibility: visible; cursor: pointer;"><text x="143.46875" y="9" style="pointer-events: none;">data6</text><rect class="c3-legend-item-event" x="129.46875" y="-5" width="55.359375" height="18" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" x1="127.46875" y1="4" x2="137.46875" y2="4" stroke-width="10" style="stroke: rgb(254, 193, 7); pointer-events: none;"></line></g><g class="c3-legend-item c3-legend-item-data3" style="visibility: visible; cursor: pointer;"><text x="198.828125" y="9" style="pointer-events: none;">data5</text><rect class="c3-legend-item-event" x="184.828125" y="-5" width="55.359375" height="18" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" x1="182.828125" y1="4" x2="192.828125" y2="4" stroke-width="10" style="stroke: rgb(163, 174, 189); pointer-events: none;"></line></g><g class="c3-legend-item c3-legend-item-data4" style="visibility: visible; cursor: pointer;"><text x="254.1875" y="9" style="pointer-events: none;">data2</text><rect class="c3-legend-item-event" x="240.1875" y="-5" width="55.359375" height="18" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" x1="238.1875" y1="4" x2="248.1875" y2="4" stroke-width="10" style="stroke: rgb(76, 86, 103); pointer-events: none;"></line></g><g class="c3-legend-item c3-legend-item-data5" style="visibility: visible; cursor: pointer;"><text x="309.546875" y="9" style="pointer-events: none;">data4</text><rect class="c3-legend-item-event" x="295.546875" y="-5" width="55.359375" height="18" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" x1="293.546875" y1="4" x2="303.546875" y2="4" stroke-width="10" style="stroke: rgb(171, 140, 228); pointer-events: none;"></line></g><g class="c3-legend-item c3-legend-item-data6" style="visibility: visible; cursor: pointer;"><text x="364.90625" y="9" style="pointer-events: none;">data3</text><rect class="c3-legend-item-event" x="350.90625" y="-5" width="45.359375" height="18" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" x1="348.90625" y1="4" x2="358.90625" y2="4" stroke-width="10" style="stroke: rgb(3, 169, 243); pointer-events: none;"></line></g></g><text class="c3-title" x="235.3515625" y="0"></text></svg><div class="c3-tooltip-container" style="position: absolute; pointer-events: none; display: none; top: 17.7031px; left: 96.5px;"><table class="c3-tooltip"><tbody><tr><th colspan="2">0</th></tr><tr class="c3-tooltip-name--data3"><td class="name"><span style="background-color:#03A9F3"></span>data3</td><td class="value">300</td></tr><tr class="c3-tooltip-name--data4"><td class="name"><span style="background-color:#AB8CE4"></span>data4</td><td class="value">200</td></tr><tr class="c3-tooltip-name--data2"><td class="name"><span style="background-color:#4C5667"></span>data2</td><td class="value">200</td></tr><tr class="c3-tooltip-name--data5"><td class="name"><span style="background-color:#a3aebd"></span>data5</td><td class="value">130</td></tr><tr class="c3-tooltip-name--data6"><td class="name"><span style="background-color:#FEC107"></span>data6</td><td class="value">90</td></tr><tr class="c3-tooltip-name--data1"><td class="name"><span style="background-color:#00C292"></span>data1</td><td class="value">30</td></tr></tbody></table></div></div>
                        </div>
                    </div>
                </div>
                <!-- Monthly Growth Chart end-->
                <!-- Google Chart start-->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Daily Increment</h5>
                        </div>
                        <div class="card-block">
                            <div id="chart_Donut" style="width: 100%; height: 320px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Google Chart end-->
                <!-- Recent Order table start -->
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>RECENT ORDERS</h5>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <div class="dt-responsive table-responsive">
                                    <table id="res-config" class="table table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Amount</th>
                                                <th>Stock</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="img-pro">
                                                    <img src="assets/images/e-commerce/product-list/pro-l1.png" class="img-fluid d-inline-block" alt="tbl">
                                                </td>
                                                <td class="pro-name">
                                                    <h6>Frock Designs</h6>
                                                    <span class="text-muted f-12">Lorem ipsum dolor sit consec te imperdiet iaculis ipsum..</span>
                                                </td>
                                                <td>$456</td>
                                                <td>
                                                    <label class="text-danger">Out Of Stock</label>
                                                </td>
                                                <td class="action-icon">
                                                    <a href="#" class="m-r-15 text-muted f-18"><i class="icofont icofont-ui-edit"></i></a>
                                                    <a href="#" class="text-muted f-18"><i class="icofont icofont-delete-alt"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="img-pro">
                                                    <img src="assets/images/e-commerce/product-list/pro-l6.png" class="img-fluid d-inline-block" alt="tbl">
                                                </td>
                                                <td class="pro-name">
                                                    <h6> Style Tops </h6>
                                                    <span class="text-muted f-12">Interchargebla lens Digital Camera with APS-C-X Trans CMOS Sens</span>
                                                </td>
                                                <td>$689</td>
                                                <td>
                                                    <label class="text-success">In Stock</label>
                                                </td>
                                                <td class="action-icon">
                                                    <a href="#" class="m-r-15 text-muted f-18"><i class="icofont icofont-ui-edit"></i></a>
                                                    <a href="#" class="text-muted f-18"><i class="icofont icofont-delete-alt"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="img-pro">
                                                    <img src="assets/images/e-commerce/product-list/pro-l1.png" class="img-fluid d-inline-block" alt="tbl">
                                                </td>
                                                <td class="pro-name">
                                                    <h6>Frock Designs</h6>
                                                    <span class="text-muted f-12">Lorem ipsum dolor sit consec te imperdiet iaculis ipsum..</span>
                                                </td>
                                                <td>$456</td>
                                                <td>
                                                    <label class="text-danger">Out Of Stock</label>
                                                </td>
                                                <td class="action-icon">
                                                    <a href="#" class="m-r-15 text-muted f-18"><i class="icofont icofont-ui-edit"></i></a>
                                                    <a href="#" class="text-muted f-18"><i class="icofont icofont-delete-alt"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="img-pro">
                                                    <img src="assets/images/e-commerce/product-list/pro-l2.png" class="img-fluid d-inline-block" alt="tbl">
                                                </td>
                                                <td class="pro-name">
                                                    <h6> Kurta Women </h6>
                                                    <span class="text-muted f-12">Lorem ipsum dolor sit consec te imperdiet iaculis ipsum..</span>
                                                </td>
                                                <td>$755</td>
                                                <td>
                                                    <label class="text-warning">Low Stock</label>
                                                </td>
                                                <td class="action-icon">
                                                    <a href="#" class="m-r-15 text-muted f-18"><i class="icofont icofont-ui-edit"></i></a>
                                                    <a href="#" class="text-muted f-18"><i class="icofont icofont-delete-alt"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="img-pro">
                                                    <img src="assets/images/e-commerce/product-list/pro-l3.png" class="img-fluid d-inline-block" alt="tbl">
                                                </td>
                                                <td class="pro-name">
                                                    <h6> T Shirts For Women </h6>
                                                    <span class="text-muted f-12">Lorem ipsum dolor sit consec te imperdiet iaculis ipsum..</span>
                                                </td>
                                                <td>$989</td>
                                                <td>
                                                    <label class="text-success">In Stock</label>
                                                </td>
                                                <td class="action-icon">
                                                    <a href="#" class="m-r-15 text-muted f-18"><i class="icofont icofont-ui-edit"></i></a>
                                                    <a href="#" class="text-muted f-18"><i class="icofont icofont-delete-alt"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="img-pro">
                                                    <img src="assets/images/e-commerce/product-list/pro-l4.png" class="img-fluid d-inline-block" alt="tbl">
                                                </td>
                                                <td class="pro-name">
                                                    <h6> Black Frock For Women </h6>
                                                    <span class="text-muted f-12">Interchargebla lens Digital Camera with APS-C-X Trans CMOS Sens</span>
                                                </td>
                                                <td>$1150</td>
                                                <td>
                                                    <label class="text-success">In Stock</label>
                                                </td>
                                                <td class="action-icon">
                                                    <a href="#" class="m-r-15 text-muted f-18"><i class="icofont icofont-ui-edit"></i></a>
                                                    <a href="#" class="text-muted f-18"><i class="icofont icofont-delete-alt"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="img-pro">
                                                    <img src="assets/images/e-commerce/product-list/pro-l5.png" class="img-fluid d-inline-block" alt="tbl">
                                                </td>
                                                <td class="pro-name">
                                                    <h6> T Shirts For Women </h6>
                                                    <span class="text-muted f-12">Lorem ipsum dolor sit consec te imperdiet iaculis ipsum..</span>
                                                </td>
                                                <td>$2006</td>
                                                <td>
                                                    <label class="text-danger">Out Of Stock</label>
                                                </td>
                                                <td class="action-icon">
                                                    <a href="#" class="m-r-15 text-muted f-18"><i class="icofont icofont-ui-edit"></i></a>
                                                    <a href="#" class="text-muted f-18"><i class="icofont icofont-delete-alt"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recent Order table end -->
                <div class="col-sm-12 col-xl-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Daily Visitors</h5>
                                </div>
                                <div class="card-block">
                                    <div id="pie-chart" style="height:300px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <!-- User activities chart start -->
                            <div class="card analytic-user">
                                <div class="card-block-big text-center">
                                    <i class="icofont icofont-wallet"></i>
                                    <h1>$ 324587</h1>
                                    <h4>All Income</h4>
                                </div>
                                <div class="card-footer p-t-25 p-b-25">
                                    <p class="m-b-0">This is standard panel footer</p>
                                </div>
                            </div>
                            <!-- User activities chart end -->
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


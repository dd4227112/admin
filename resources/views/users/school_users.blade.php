@extends('layouts.app')
@section('content')

<div class="row">
  <?php
$user=array();
$total_users=0;
foreach ($users as $key => $value) {
	# code...
	$user[$value->usertype]=$value->count;
	$total_users +=$value->count;
}
?>


                  <div class="row">
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box">
                                    <h3 class="box-title">Total Accounts</h3>
                                    <ul class="list-inline m-t-30 p-t-10 two-part">
                                        <li><i class="icon-people text-info"></i></li>
                                        <li class="text-right"><span class="counter"><?=$total_users?></span></li>
                                    </ul>

                                </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                      <div class="white-box">
                                    <h3 class="box-title">Total Parents</h3>
                                    <ul class="list-inline m-t-30 p-t-10 two-part">
                                        <li><i class="icon-people text-info"></i></li>
                                        <li class="text-right"><span class="counter"><?=$user['Parent']?></span></li>
                                    </ul>
                                    <div class="pull-right"><?=round($user['Parent']*100/$total_users ,2)?>% <i class="fa fa-level-up text-success"></i></div>
                                </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                      <div class="white-box">
                                    <h3 class="box-title">Total Students</h3>
                                    <ul class="list-inline m-t-30 p-t-10 two-part">
                                        <li><i class="icon-people text-info"></i></li>
                                        <li class="text-right"><span class="counter"><?=$user['Student']?></span></li>
                                    </ul>
                                    <div class="pull-right"><?=round($user['Student']*100/$total_users ,2)?>% <i class="fa fa-level-up text-success"></i></div>
                                </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box">
                                    <h3 class="box-title">Total Teachers</h3>
                                    <ul class="list-inline m-t-30 p-t-10 two-part">
                                        <li><i class="icon-people text-info"></i></li>
                                        <li class="text-right"><span class="counter"><?=$user['Teacher']?></span></li>
                                    </ul>
                                    <div class="pull-right"><?=round($user['Teacher']*100/$total_users ,2)?>% <i class="fa fa-level-up text-success"></i></div>
                                </div>
           
                    </div>
                </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <h3 class="box-title">Schools</h3>
            <!--<div id="basicgrid"></div>-->
            <select id="school_region">
                <option value="">Select school name</option>
                
            </select>
            <select id="school_region">
                <option value="">Select user types</option>
                
            </select>
            <table id="example23" class="display nowrap table color-table success-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>School Name</th>
                        <th>Region</th>
                        <th>District</th>
                        <th>Ward</th>
                        <th>Type</th>
                        <th>Ownership</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if (isset($users_q)  && count($users_q) > 0) {
                        foreach ($schools as $key => $value) {
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $value->name ?></td>
                                <td><?= $value->region ?></td>
                                <td><?= $value->district ?></td>
                                <td><?= $value->ward ?></td>
                                <td><?= $value->type ?></td>
                                <td><?= $value->ownership ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
        </div>
    </div>
</div>
@include('layouts.datatable')
@endsection

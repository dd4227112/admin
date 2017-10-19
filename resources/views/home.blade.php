@extends('layouts.app')
@section('content')

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




                <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Other Users</h3>
                        <ul class="country-state  p-t-20">
                        <?php
			foreach ($users as $key => $value) {
				if(in_array($value->usertype,array('Parent','Student','Teacher'))) continue;
				$percent=round($value->count*100/$total_users ,2);
		?>
                            <li>
                                <h2><?=$value->count?></h2> <small>{{$value->usertype}}</small>
                                <div class="pull-right"><?=$percent?>% <i class="fa fa-level-up text-success"></i></div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:48%;"> <span class="sr-only"><?=$percent?>% By number</span></div>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8">
                    <div class="white-box bg-extralight m-b-0">
                        <div class="city-weather-widget">
                            <h3>Log Requests</h3>
                             <div class="row">
                   <?=$log_graph?>
                </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="row">
                            <ul class="list-unstyled city-weather-days">
                                <li class="col-xs-4 col-sm-2"><span>Tue</span><i class="wi wi-day-sunny"></i><span>32<sup>°F</sup></span></li>
                                <li class="col-xs-4 col-sm-2"><span>Wed</span><i class="wi wi-day-cloudy"></i><span>34<sup>°F</sup></span></li>
                                <li class="col-xs-4 col-sm-2"><span>Thu</span><i class="wi wi-day-hail"></i><span>35<sup>°F</sup></span></li>
                                <li class="col-xs-4 col-sm-2 active"><span>Fri</span><i class="wi wi-day-sprinkle"></i><span>34<sup>°F</sup></span></li>
                                <li class="col-xs-4 col-sm-2"><span>Sat</span><i class="wi wi-day-snow"></i><span>30<sup>°F</sup></span></li>
                                <li class="col-xs-4 col-sm-2"><span>Sun</span><i class="wi wi-day-sunny"></i><span>26<sup>°F</sup></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
   
@endsection

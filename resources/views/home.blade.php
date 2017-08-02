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
                            <h1>Kufri, Himachal Pradesh</h1>
                            <h4>Friday, 19 Jan 2017</h4>
                            <div class="row p-t-30">
                                <div class="col-sm-6">
                                    <ul class="side-icon-text">
                                        <li><span class="di vm"><i class="wi wi-day-hail text-info"></i></span><span class="di vm"><h1 class="m-b-0 text-info">23<sup>o</sup></h1><h5 class="m-t-0">Mostly Sunny</h5></span></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-icons pull-right">
                                        <li><i class="wi wi-day-sunny m-r-5"></i>Humidity 38%</li>
                                        <li><i class=" wi wi-day-windy m-r-5"></i>Wind 38%</li>
                                    </ul>
                                </div>
                                <div class="col-md-12">
                                    <div id="ct-city-wth" style="height:220px"><div class="chartist-tooltip"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-line" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><path d="M20,185L20,68.333C34.548,82.917,78.19,165.556,107.286,155.833C136.381,146.111,165.476,19.722,194.571,10C223.667,0.278,252.762,87.778,281.857,97.5C310.952,107.222,340.048,63.472,369.143,68.333C398.238,73.194,427.333,126.667,456.429,126.667C485.524,126.667,514.619,73.194,543.714,68.333C572.81,63.472,616.452,92.639,631,97.5L631,185Z" class="ct-area"></path><path d="M20,68.333C34.548,82.917,78.19,165.556,107.286,155.833C136.381,146.111,165.476,19.722,194.571,10C223.667,0.278,252.762,87.778,281.857,97.5C310.952,107.222,340.048,63.472,369.143,68.333C398.238,73.194,427.333,126.667,456.429,126.667C485.524,126.667,514.619,73.194,543.714,68.333C572.81,63.472,616.452,92.639,631,97.5" class="ct-line"></path><line x1="20" y1="68.33333333333333" x2="20.01" y2="68.33333333333333" class="ct-point" value="5"></line><line x1="107.28571428571429" y1="155.83333333333334" x2="107.2957142857143" y2="155.83333333333334" class="ct-point" value="2"></line><line x1="194.57142857142858" y1="10" x2="194.58142857142857" y2="10" class="ct-point" value="7"></line><line x1="281.8571428571429" y1="97.5" x2="281.8671428571429" y2="97.5" class="ct-point" value="4"></line><line x1="369.14285714285717" y1="68.33333333333333" x2="369.15285714285716" y2="68.33333333333333" class="ct-point" value="5"></line><line x1="456.42857142857144" y1="126.66666666666666" x2="456.43857142857144" y2="126.66666666666666" class="ct-point" value="3"></line><line x1="543.7142857142858" y1="68.33333333333333" x2="543.7242857142858" y2="68.33333333333333" class="ct-point" value="5"></line><line x1="631" y1="97.5" x2="631.01" y2="97.5" class="ct-point" value="4"></line></g></g><g class="ct-labels"><foreignObject style="overflow: visible;" x="20" y="190" width="87.28571428571429" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 87px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">12AM</span></foreignObject><foreignObject style="overflow: visible;" x="107.28571428571429" y="190" width="87.28571428571429" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 87px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">2AM</span></foreignObject><foreignObject style="overflow: visible;" x="194.57142857142858" y="190" width="87.2857142857143" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 87px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">6AM</span></foreignObject><foreignObject style="overflow: visible;" x="281.8571428571429" y="190" width="87.28571428571428" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 87px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">9AM</span></foreignObject><foreignObject style="overflow: visible;" x="369.14285714285717" y="190" width="87.28571428571428" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 87px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">12AM</span></foreignObject><foreignObject style="overflow: visible;" x="456.42857142857144" y="190" width="87.28571428571433" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 87px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">3PM</span></foreignObject><foreignObject style="overflow: visible;" x="543.7142857142858" y="190" width="87.28571428571422" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 87px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">6PM</span></foreignObject><foreignObject style="overflow: visible;" x="631" y="190" width="30" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 30px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">9PM</span></foreignObject></g></svg></div>
                                </div>
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

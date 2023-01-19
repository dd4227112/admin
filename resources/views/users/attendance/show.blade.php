@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

       <div class="page-header">
            <div class="page-header-title">
                <h4><?= $user->name()."'s Attendances "?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Attendance</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Operations</a>
                    </li>
                </ul>
            </div>
        </div> 

    <div class="page-body">
      <div class="">
        <div class="row">
            <div class="col-sm-4">
          
              <div class="card counter-card-1">
                <div class="card-block-big">
                    <div class="media-left">
                        <div href="#" class="profile-image">
                         
                          <img class="user-img img-circle" src="<?= $user->company_file_id !='' ? $user->companyFile->path : $root . 'assets/images/user.png' ?>" alt="User-Profile-Image" height="90">

                          <div class="center">
                             <h6>Full name: <?= $user->name() ?? '' ?></h6> 
                             <h6>Phone number: <?= $user->phone ?? '' ?></h6> 
                             <h6>Email: <?= $user->email ?? '' ?></h6>
                             <h6>Designation: <?= $user->designation->name ?? '' ?></h6>
                             <h6>Gender: <?= $user->sex ?? '' ?></h6>
                             <h6>Address: <?= $user->address ?? '' ?></h6>
                          </div>

                        </div>
                    </div>
                </div>
              </div>
            </div>

              <div class="col-sm-8">
                 <div class="card">
                    <div class="col-md-12">
                        <script src="https://code.highcharts.com/highcharts.js"></script>
                          <script src="https://code.highcharts.com/modules/data.js"></script>
                           <script type="text/javascript">
                                    $(function () {
                                        $('#container').highcharts({
                                            data: {
                                                table: 'datatables'
                                            },
                                            series: [{
                                                    name: '',
                                                    colorByPoint: true}
                                            ],
                                            chart: {
                                                type: 'column'
                                            },
                                            title: {
                                                text: "<?=$user->name?> Attendance Report" 
                                            },
                                            yAxis: {
                                                allowDecimals: false,
                                                title: {
                                                    text: 'Days'
                                                }
                                            },
                                            legend: {
                                                enabled: false
                                            },
                                            plotOptions: {
                                                series: {
                                                    borderWidth: 0,
                                                    dataLabels: {
                                                        enabled: true,
                                                        format: ''
                                                    }
                                                }
                                            },
                                            tooltip: {
                                                formatter: function () {
                                                    return '<b>' + this.series.name + '</b><br/>' +
                                                            this.point.y + ' ' + this.point.name.toUpperCase();
                                                }
                                            }
                                        });
                                    });
                                </script>
                         <div id="container" style="height: 350px; margin: 0 auto"></div>
                   </div>
               </div>
             </div>
        </div>

            <div class="card">
              <div class="card-block">
                      <table id="datatables" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Working days</th>
                                <th>Days Attended</th>
                                <th>Permissions</th>
                                <th>Absents</th>
                                <th>Late coming</th>
                                <th>Early leave</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $the_timein = "08:00:00";
                                $the_timeout = "17:00:00";
                            for ($m = 1; $m <= (int) date('m'); $m++) {
                                $dateObj = DateTime::createFromFormat('!m', $m);
                                $monthName = $dateObj->format('F');
                                $att = $user->uattendance()->where(DB::raw('EXTRACT(MONTH FROM date) '), $m)->where('present', 1)->count();
                                $permissions = $user->uattendance()->where(DB::raw('EXTRACT(MONTH FROM date) '), $m)->whereNotNull('absent_reason_id')->count();
                                $absents = $user->uattendance()->where(DB::raw('EXTRACT(MONTH FROM date) '), $m)->whereNull('absent_reason_id')->where('present',0)->count();
                                $late_comming = $user->uattendance()->where(DB::raw('EXTRACT(MONTH FROM date) '), $m)->where(DB::raw('CAST(timein::timestamp as time) '), '>', $the_timein)->where('present',1)->count();
                                $early_leave = $user->uattendance()->where(DB::raw('EXTRACT(MONTH FROM date) '), $m)->where(DB::raw('CAST(timeout::timestamp as time) '), '<', $the_timeout)->where('present',1)->count();

                                ?>
                                <tr>
                                    <th><?= $monthName ?></th>
                                    <th><?= workingDays(date('Y'),date('m')) ?></th>
                                    <td><?= $att ?></td>
                                    <td><?= $permissions ?></td>
                                    <td><?= $absents ?></td>
                                    <td class="text-center"><?= $late_comming > 0 ? '<label class="badge badge-warning">' .$late_comming .'</label>' : 0 ?></td>
                                    <td class="text-center"><?= $early_leave > 0 ? '<label class="badge badge-warning">' .$early_leave .'</label>' : 0 ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                       
                    </table>
                   
                   </div>
                </div>

                <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-title mt-4 mr-2 px-4">
                                <h5 style="font-weight: 800"> Attendance information</h5> 
                                <p style="font-weight:700"> Present   <label class="badge badge-info">P</label>, Present late  <label class="badge badge-warning">P</label>, Present early leave  <label class="badge badge-danger">P</label>,
                                 weekends <label class="badge badge-default">S</label>, Sick  <label class="badge badge-danger">S</label>, Permission  <label class="badge badge-info">PM</label> </p>
                                </div>
                           
                                <div class="card-body">
                                    <div class="table-responsive attendance-table">
                                    <?php
                              for ($m = 1; $m <= (int) date('m'); $m++) {
                                  $dateObj = DateTime::createFromFormat('!m', $m);
                                  $monthName = $dateObj->format('F');
                                  ?>
                                  <h6 class="text-left"><?= $monthName ?></h6>
                                        <table class="table table-bordered mb-0 table-centered">
                                        <thead>
                                              <tr>
                                                  <?php 
                                                  for ($i = 1; $i <= date('t', strtotime($monthName)); $i++) {
                                                      echo "<td style='font-size='2px;''>" . ($i) . "</td>";
                                                  }
                                                  ?>
                                              </tr>
                                          </thead>
                                          <tbody>
      
                                              <tr>
                                                  <?php  $the_timein = "08:00:00";$the_timeout = "17:00:00";
                                                  for ($i = 1; $i <= date('t', strtotime($monthName)); $i++) { 
                                                      $att = $user->uattendance()->where('date', date('Y-m-d', strtotime(date('Y') . '-' . $m . '-' . $i)))->first();
                                                      if((date('D', strtotime(date('Y') . '-' . $m . '-' . $i)) == 'Sat') || (date('D', strtotime(date('Y') . '-' . $m . '-' . $i)) == 'Sun')){
                                                          $att = '<label class="badge badge-default">S</label>';
                                                      } elseif(!empty($att->absent_reason_id)) {
                                                        $reason = \DB::table('constant.absent_reasons')->where('id', $att->absent_reason_id)->first();
                                                        if (!empty($reason)) {
                                                          //   $att = $reason->reason;
                                                             if(preg_match('/Sick/', $reason->reason)){
                                                                  $att = '<label class="badge badge-danger">S</label>';
                                                             }elseif(preg_match('/Permission/', $reason->reason)){
                                                                  $att = '<label class="badge badge-info">PM</label>';
                                                             }elseif(preg_match('/other reasons/', $reason->reason)) {
                                                                  $att = '<label class="badge badge-info">O</label>';
                                                             }
                                                        }else{
                                                            $att = '<strong>ABS</strong>';
                                                        }
                                                    } elseif (!empty($att) && $att->present == 1) {
                                                          if(date("H:i:s",strtotime($att->timein)) > $the_timein){
                                                             $att = '<label class="badge badge-warning">P</label>';
                                                          }elseif(!empty($att->timeout) && date("H:i:s",strtotime($att->timeout)) < $the_timeout){
                                                             $att = '<label class="badge badge-danger">P</label>';
                                                          }else{
                                                             $att = '<label class="badge badge-info">P</label>';
                                                          }
                                                      }else{
                                                         $att = '';
                                                      }
                                                      echo "<td>" . $att . "</td>";
                                                  }
                                                  ?> 
                                              </tr>
                                          </tbody>
                                        </table><!--end /table-->
                                        <?php } ?>
                                    </div><!--end /tableresponsive-->
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->

              
             
          </div>
        </div>
    </div>
  
      
      <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;
            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                    "<html><head><title></title></head><body>" +
                    divElements + "</body>";
            //Print Page
            window.print();
            //Restore orignal HTML
            document.body.innerHTML = oldPage;
        }
        function closeWindow() {
            location.reload();
        }

      
</script>
@endsection

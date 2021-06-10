@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<?php
if (!empty($user)) {
    $usertype = Auth::user()->name;
 } ?>
        

<div class="main-body">
  <div class="page-wrapper">
    <div class="page-header">
      <div class="page-header-title">
        <h4>Attendance</h4>
        <span>attendance.</span>
      </div>
      <div class="page-header-breadcrumb">
      

        <div class="col-sm-12">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Company Employee</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Attendance</a>
          </li>
        </ul>
        </div>
      </div>
    </div>

    <div class="page-body">
      <div class="row">
        <div class="col-sm-12 row">
            <div class="col-sm-4">
          
              <div class="card counter-card-1">
                <div class="card-block-big">
                    <div class="media-left">
                        <a href="#" class="profile-image">
                            <img class="user-img img-circle" src="" alt="User-Profile-Image" height="110">
                        </a>
                    </div>
                    
                </div>
              </div>
            </div>

          <div class="col-sm-8">
            <div class="card">
              <div class="col-md-12">
                <h4> Attendance Report</h4>
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

                <script src="<?= url('public/assets/js/highchart.js') ?>"></script>
                <script src="<?= url('public/assets/js/exporting.js') ?>"></script>
                <script src="<?= url('public/assets/js/data.js') ?>"></script>
                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            </div>
          </div>
         </div>
        </div>

         <div class="col-sm-12">
            <div class="card">

              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">User Information</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Summary</a>
                    </li>
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div role="card-body" class="tab-pane fade active" id="tab_content1" aria-labelledby="home-tab">
                    
                        <table id="datatables" style="" class="table">
                          <tr>
                              <td>
                                Name
                              </td>
                              <td>
                                <?= $user->name ?>
                              </td>
                          </tr>
                          <tr>
                            <td>
                              Gender
                            </td>
                            <td>
                              <?= $user->sex ?>
                            </td>
                        </tr>
                        <tr>
                          <td>
                            Address
                          </td>
                          <td>
                            <?= $user->address ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Email
                          </td>
                          <td>
                            <?= $user->email ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Phone
                          </td>
                          <td>
                            <?= $user->phone ?>
                          </td>
                       </tr>
                      </table>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                      <table id="datatables" style="" class="table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Days Attended</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sum_att = 0;
                            for ($m = 1; $m <= (int) date('m'); $m++) {
                                $dateObj = DateTime::createFromFormat('!m', $m);
                                $monthName = $dateObj->format('F');
                                $att = $user->uattendance()->where(DB::raw('EXTRACT(MONTH FROM date) '), $m)->where('present', 1)->count();
                                $sum_att += $att;
                                ?>
                                <tr>
                                    <th><?= $monthName ?></th>
                                    <td><?= $att ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- end user projects -->
                      <table  style="" class="table">
                        <tr>
                            <td>Total Days Attended</td>
                            <td><?= $sum_att ?></td>
                        </tr>
                     </table>
                     </div>
                    </div>
                   </div>
                </div>
              </div>


                <div class="col-sm-12">
                    <div class="card">
                      <h5 class="text-center"><?= ("Attendance information") ?></h5>
                      <div class="rowr">
                          <div class="col-sm-12">
                              <?php
                              for ($m = 1; $m <= (int) date('m'); $m++) {
                                  $dateObj = DateTime::createFromFormat('!m', $m);
                                  $monthName = $dateObj->format('F');
                                  ?>
                                  <h6 class="text-left"><?= $monthName ?></h6>
                                  <div id="hide-table  table-sm table-striped">
                                      <table class="table">
                                          <thead>
                                              <tr>
                                                  <?php
                                                  for ($i = 1; $i <= 31; $i++) {
                                                      echo "<th style='font-size='5px;''>" . ($i) . "</th>";
                                                  }
                                                  ?>
                                              </tr>
                                          </thead>
                                          <tbody>
      
                                              <tr>
                                                  <?php
                                                  for ($i = 1; $i <= 31; $i++) { 
                                                      $att = $user->uattendance()->where('date', date('Y-m-d', strtotime(date('Y') . '-' . $m . '-' . $i)))->first();
                                                      
                                                      if (!empty($att) && $att->present == 1) {
                                                          $att = "P";
                                                      } elseif(!empty($att->absent_reason_id)) {
                                                          $reason = \DB::table('constant.absent_reasons')->where('id', $att->absent_reason_id)->first();
                                                          if (!empty($reason)) {
                                                              $att = $reason->reason;
                                                          }else{
                                                              $att = 'ABS';
                                                          }
                                                      }else {
                                                          $att = '';
                                                      }
                                                      echo "<td>" . $att . "</td>";
                                                  }
                                                  ?> 
                                              </tr>
                                          </tbody>
      
                                      </table>
                                  </div>
                              <?php } ?>
                          </div>
                        </div>
                  </div>
            
            </div>
          </div>


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

        function check_email(email) {
            var status = false;
            var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
            if (email.search(emailRegEx) == -1) {
                $("#to_error").html('');
                $("#to_error").html("<?= ('mail_valid') ?>").css("text-align", "left").css("color", 'red');
            } else {
                status = true;
            }
            return status;
        }
</script>
@endsection

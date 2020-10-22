@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
  <div class="row">
  <div class="col-sm-6">
      <a  onclick="javascript:printDiv('print_all')" class="btn btn-primary">Print Here</a>
  </div>
  <div class="col-sm-6">
      <a href="<?=url('Partner/InvoicePrefix/')?>" style="float: right;" class="btn btn-success">Validate This Application</a>
  </div>
  </div>

    <!-- Page-body start -->
    <div class="page-body" id="print_all">
      <div class="row">
        <div class="col-lg-12">
          <!-- tab panel personal start -->
            <!-- personal card start -->
            <div class="card">
              <div class="card-header text-center" style="background-color:#8CDDCD; !important">
                <h5  style="border-bottom: 5px solid #8CDDCD; color: #ffffff">
                  INETS COMPANY LIMITED</span>
                </h5>
              </div>
              <div class="card-block">
                <div class="view-info">
                  <div class="col-lg-12">
                    <div class="general-info">
                      <div class="row">

                        <div class="col-sm-6">
                          <h3>School Profile</h3>
                          <table class="table m-0">

                            <tbody>
                              <tr>
                                <th scope="row">School Name</th>
                                <th>
                                  <?php
                                  echo '<a href="#">'. $request->client->name .'</a>';
                                  ?>
                                </th>
                              </tr>
                              <tr>
                                <th scope="row">Location</th>
                                <th>
                                  <?php
                                  if ($request->user_id != '') {
                                    echo $client->school->district. ' - '. $client->school->region;
                                  }
                                  ?>
                                </tr>
                                <tr>
                                  <th> Registration No. </th>
                                  <th>
                                    <?php
                                    echo $client->school->ownership;
                                    ?>
                                  </th>
                                </tr>
                                <tr>
                                  <th scope="row">Number of Students</th>
                                  <th> <?= $request->client->estimated_students ?></th>
                                </tr>
                                <tr>
                                  <th>School Levels</th>
                                  <td>
                                    <?php
                                    $levels = DB::table('admin.school_levels')->where('client_id', $request->client_id)->get();
                                    foreach($levels as $level){
                                      echo '<b>'.$level->name.'</b>,   &nbsp; &nbsp;';
                                    }
                                    ?>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div class="col-sm-6">
                            <h3>Key Person Contacts</h3>

                            <table class="table m-0">
                              <tbody>
                                <tr>
                                  <th scope="row">Full Name</th>
                                  <th> <?=$school->name ?> </th>
                                </tr>
                                <tr>
                                  <th scope="row">Position</th>
                                  <th>
                                    <?php
                                    echo $school->title;
                                    ?>
                                  </tr>
                                  <tr>
                                    <th> Phone </th>
                                    <th>
                                      <?php
                                      echo $school->phone;
                                      ?>
                                    </th>
                                  </tr>
                                  <tr>
                                    <th scope="row">Email</th>
                                    <th> <?= $school->email ?></th>
                                  </tr>
                                  <tr>
                                    <th>Modules</th>
                                    <td>
                                      <?php
                                      echo "No Module Specified";
                                      ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        <!-- end of row -->
                      </div>
                      <!-- end of general info -->
                    </div>
                    <!-- end of col-lg-12 -->
                  </div>
                  <!-- end of row -->
                </div>

                <!-- end of card-block -->
              </div>
            </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <h5>Bank Account Details</h5>
                    </div>
                      <?php
                          $bank = \App\Models\IntegrationBankAccount::where('integration_request_id', $request->id)->first();
                          if(empty($bank)){
                            $bank = DB::table($request->client->username.'.bank_accounts_integrations')->where('refer_bank_id', 8)->first();
                           $refer_bank = $bank->name;
                          }else{
                            $refer_bank = $bank->referBank->name;

                          }
                      ?>
                    <div class="card-block user-desc">
                      <div class="view-desc">

                        <div class="row">
                          <div class="col-sm-6">
                            <h3>Account</h3>

                            <table class="table m-0">
                              <tbody>
                                <tr>
                                  <th scope="row">Bank Name</th>
                                  <th><?=$refer_bank?></th>
                                </tr>
                                <tr>
                                  <th scope="row">Account Name</th>
                                  <th>
                                    <?php
                                    if ($request->user_id != '') {
                                      echo $bank->name;
                                    }
                                    ?>
                                  </tr>
                                  <tr>
                                    <th> Account Number </th>
                                    <th><?php echo $bank->number; ?> </th>
                                  </tr>

                                  <tr>
                                    <th>Currency</th>
                                    <th> <?= $bank->branch ?></th>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="col-sm-6">
                              <h3> Application Docs Attachments</h3>
                              <table class="table m-0">
                                <tbody>
                                  <tr>
                                    <th scope="row">Bank Term of Services </th>
                                    <th> <a href="http://" target="_blank" class="btn btn-info btn-sm" rel="noopener noreferrer"> <i class="ti-cloud"></i> View Doc</a> </th>
                                  </tr>
                                  <tr>
                                      <th scope="row">Shulesoft Agreement Form</th>
                                      <th> <a href="http://" target="_blank" class="btn btn-info btn-sm" rel="noopener noreferrer"> <i class="ti-cloud"></i> View Doc</a> </th>
                                  </tr>
                                  <tr>
                                    <th scope="row">Bank Application Form</th>
                                    <th> <a href="http://" target="_blank" class="btn btn-info btn-sm" rel="noopener noreferrer"> <i class="ti-cloud"></i> View Doc</a> </th>
                                     
                                    </tr>
                                    <!-- <tr>
                                      <th scope="row">Implemetantion Start</th>
                                      <th> <?php // $client->contract->start_date ?></th>
                                    </tr> -->

                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-sm-6">

                                <div class="table-responsive">

                                  <table class="table">

                                    <thead>
                                      <tr  style="border-bottom: 5px solid #8CDDCD;">
                                        <th colspan="2" style="background:#8CDDCD;text-align: center;
                                        font-size: 18px;
                                        color: white;"><?=$bank->referBank->name?></th>
                                      </tr>
                                      <tr>
                                        <td>
                                          <p>On behalf of <b> <?=$bank->referBank->name?></b> Limited, the aforementioned services headed by</p>
                                        </td>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>Name:</td>
                                      </tr>
                                      <tr>
                                        <td>Designation:</td>
                                      </tr>
                                      <!-- <tr>
                                      <td>Department:</td>
                                    </tr> -->
                                    <tr>
                                      <td>Signature</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div class="col-sm-6">
                              <div class="table-responsive">
                                <table class="table">

                                  <thead>
                                    <tr  style="border-bottom: 5px solid #8CDDCD;">
                                      <th colspan="2" style="background:#8CDDCD;text-align: center;
                                      font-size: 18px;
                                      color: white;">INETS COMPANY LIMITED</th>
                                    </tr>
                                    <tr>
                                      <th>
                                        <p>On behalf of <b>INETS Company Limited</b>, the aforementioned services headed by</p>
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Name:   &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; <?=$bank->requests->user->name?></td>
                                    </tr>
                                    <tr>
                                      <td>Designation:   &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; <?=$bank->requests->user->name?></td>
                                    </tr>
                                    <!-- <tr>
                                    <td>Department:</td>
                                  </tr> -->
                                  <tr>
                                    <td>Signature   &nbsp; &nbsp;  &nbsp; &nbsp;</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>

                          </div>
                        </div>
                        <table class="table">
                          <tr>
                            <td style="width: 60% !important;">
                              <img src="<?= url('public/images/ShuleSoft-TM.png') ?>" width="350" height="" style=""/>
                            </td>
                            <td style="width: 60% !important;">
                              <span>
                                INETS is a Private Company Limited by shares and registered <br/>under the Company Act 2012 with registration number 9216.<br/> INETS deals solely with Software Development. <br/>Currently focused on a School Management System ShuleSoft </span></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- personal card end-->

          <script>
              function printDiv(divID) {

              //Get the HTML of div
              var divElements = document.getElementById(divID).innerHTML;
              //Get the HTML of whole page
              var oldPage = document.body.innerHTML;

              //Reset the page's HTML with div's HTML only
              document.body.innerHTML =
                      '<html><head><title></title></head><body>' +
                      divElements + '</body>';
              //Print Page
              window.print();
              //Restore orignal HTML
              document.body.innerHTML = oldPage;
              }
    </script>
          <script>
          $('#action').change(function () {
            var val = $(this).val();
            $.ajax({
              type: 'POST',
              url: "<?= url('Customer/updateTask') ?>",
              data: "id=" + <?= $request->id ?> + "&action=" + val,
              dataType: "html",
              success: function (data) {
                $('#added_').html(data);
              }
            });
          });
          </script>
          @endsection

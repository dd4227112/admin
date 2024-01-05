@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="https://admin.shulesoft.com/public/assets/css/style.css">
<link rel="stylesheet" type="text/css" href="https://admin.shulesoft.com/public/assets/css/bars.css">

<link rel="stylesheet" href="https://admin.shulesoft.com/public/assets/select2/css/select2.css">

<link rel="stylesheet" href="https://admin.shulesoft.com/public/assets/select2/css/select2-bootstrap.css">
<link rel="stylesheet" href="https://admin.shulesoft.com/public/assets/select2/css/gh-pages.css">

  

    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">

            <div class="card-block">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-12 text-center">
                    <div class="card px-0 pt-2 pb-0 mt-2 mb-3">
                      <h2 id="heading">Onboard New School</h2>
                      <p>Fill all form field to go to next step</p>
                      <form id="msform" method="POST" action="">
                        <!-- progressbar -->
                        <ul id="progressbar">
                          <li class="active" id="account"><strong>About School</strong></li>
                          <li id="personal"><strong>School Contact</strong></li>
                          <li id="payment"><strong>Application Attachments</strong></li>
                          <li id="confirm"><strong>Bank Intagration</strong></li>
                        </ul>
                        <div class="progress">
                          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                        </div> <br> <!-- fieldsets -->
                        <fieldset>
                          <div class="form-card">

                            <div class="form-group row">
                              <div class="col-md-6">
                                Select Ownership
                                <input type="text" class="form-control" placeholder="school Name here.." name="school_name" required="">
                              </div>
                              <div class="col-md-6">
                                Estimated Students
                                <input type="text" class="form-control" placeholder="Number of student here.." name="students" required="">
                              </div>
                            </div>

                            <div class="form-group row">
                              <div class="col-md-6">
                                <strong> Select Ownership</strong>
                                <select name="ownership" class="form-control" required>
                                  <option value="Non-Government">Non-Government</option>
                                  <option value="Government">Government</option>
                                </select>
                              </div>
                              <div class="col-md-6">
                                <strong> Select School Type</strong>
                                <select type="text" name="type" class="form-control" required>
                                  <option value="primary"> Primary School</option>
                                  <option value="secondary"> Secondary School</option>
                                  <option value="college"> College</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <div class="col-md-6">
                                Select Region
                                <select type="text" name="region" id="region" style="text-transform:uppercase" required class="form-control select2">
                                  <option value="">Select here...</option>
                                  <?php
                                  $regions = \App\Models\Region::where('country_id', 1)->get();
                                  foreach($regions as $region){
                                    echo  '<option value="'.$region->id.'">'.$region->name.'</option>';
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="col-md-6">
                                <strong>Enter District</strong>
                                <select type="text" name="district" id="district" style="text-transform:uppercase" required class="form-control select2">
                                  <option value="">Select Here...</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <div class="col-sm-6">
                                Implementation Start Date
                                <input type="datetime-local" class="form-control"  name="implementation_date" required="">
                              </div>
                              <div class="col-sm-6">
                                Data Format Available
                                <select name="data_type_id" class="form-control">
                                  <option value="1">Excel With Parent Phone Numbers</option>
                                  <option value="2">Physical Files Format</option>
                                  <option value="3">Softcopy but without parents phone numbers</option>

                                </select>
                              </div>
                            </div>
                          </div>
                          <input type="button" name="next" class="next action-button" value="Next" />
                        </fieldset>
                        <fieldset>
                          <div class="form-card">
                            <div class="row">
                              <div class="col-6">
                                <!-- <h2 class="fs-title">Key Personal Contacts:</h2> -->
                              </div>
                              <div class="col-6">
                                <h2 class="steps">Key Personal Contacts:</h2>
                              </div>
                            </div>


                            <div class="form-group row">
                              <div class="col-sm-6">
                                Fullname
                                <input type="text" name="name" class="form-control" required/>
                              </div>
                              <div class="col-sm-6">
                                Phone Number
                                <input type="text" name="phone" class="form-control" required/>
                              </div>
                            </div>

                            <div class="form-group row">
                              <div class="col-sm-6">
                                Email Address
                                <input type="text" name="email" class="form-control" required/>
                              </div>
                              <div class="col-sm-6">
                                Title
                                <select name="title" class="form-control select2" required>
                                  <option value="director">Director/Owner</option>
                                  <option value="manager">School Manager</option>
                                  <option value="head teacher">Head Teacher</option>
                                  <option value="Second Master/Mistress">Second Master/Mistress</option>
                                  <option value="academic master">Academic Master</option>
                                  <option value="teacher">Normal Teacher</option>
                                  <option value="Accountant">Accountant</option>
                                  <option value="Other Staff">Other Non Teaching Staff</option>
                                </select>
                              </div>
                            </div>
                            <hr>

                            <div class="form-group row">
                              <div class="col-sm-6">
                                ShuleaSoft Agreement Form
                                <input type="file"   accept=".pdf" name="name" class="form-control"/>
                              </div>
                              <div class="col-sm-6">
                                Bank Application Form
                                <input type="file"   accept=".pdf" name="phone" class="form-control"/>
                              </div>
                            </div>

                          </div> <input type="button" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                        </fieldset>
                        <fieldset>
                          <div class="form-card">
                            <div class="row">
                              <div class="col-7">
                                <h2 class="fs-title">Upload All Required Documents:</h2>
                              </div>
                              <div class="col-5">
                                <h2 class="steps">Step 3 - 4</h2>
                              </div>
                            </div>

                            <div class="form-group row">
                              <div class="col-sm-6">
                                ShuleaSoft Agreement Form
                                <input type="file"   accept=".pdf" name="name" class="form-control"/>
                              </div>
                              <div class="col-sm-6">
                                Bank Application Form
                                <input type="file"  accept=".pdf" name="phone" class="form-control"/>
                              </div>
                            </div>

                            <div class="form-group row">
                              <div class="col-sm-6">
                                Implementation Start Date
                                <input type="datetime-local" class="form-control" value="" name="implementation_date" required="">
                              </div>
                              <div class="col-sm-6">
                                Data Format Available
                                <select name="data_type_id" class="form-control">
                                  <option value="1">Excel With Parent Phone Numbers</option>
                                  <option value="2">Physical Files Format</option>
                                  <option value="3">Softcopy but without parents phone numbers</option>

                                </select>
                              </div>
                            </div>


                          </div> <input type="button" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                        </fieldset>
                        <fieldset>
                          <div class="form-card">
                            <div class="row">
                              <div class="col-7">
                                <h2 class="fs-title">Finish:</h2>
                              </div>
                              <div class="col-5">
                                <h2 class="steps">Step 4 - 4</h2>
                              </div>
                            </div>

                            <div class="form-group row">
                              <div class="col-sm-12">
                                Account Name
                                <input type="text" name="name" class="form-control"/>
                              </div>

                            </div>

                            <div class="form-group row">
                              <div class="col-sm-6">
                                Bank Account Number
                                <input type="text" class="form-control"  name="implementation_date" required="">
                              </div>
                              <div class="col-sm-6">
                                Invoice Prefix
                                <input type="text" name="phone" class="form-control"/>
                              </div>
                            </div>


                            <div class="form-group row">
                              <div class="col-sm-6">
                                Live username
                                <input type="text" class="form-control"  name="implementation_date" required="">
                              </div>
                              <div class="col-sm-6">
                                Live Password
                                <input type="text" class="form-control"  name="implementation_date" required="">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label">Joining Status</label>
                              <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                  <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="payment_status" id="gender-1" value="1" required=""> All Information Verified
                                  </label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="payment_status" id="gender-2" value="2" required=""> School Still on-progress
                                  </label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="payment_status" id="gender-3" value="2" required=""> School Under ShuleSoft Follow-up
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                          <input type="submit" name="next" class="btn btn-primary"  value="Submit" /> 
                        </fieldset>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <script type="text/javascript">
          $(document).ready(function(){

            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;
            var current = 1;
            var steps = $("fieldset").length;

            setProgressBar(current);

            $(".next").click(function(){

              current_fs = $(this).parent();
              next_fs = $(this).parent().next();

              //Add Class Active
              $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

              //show the next fieldset
              next_fs.show();
              //hide the current fieldset with style
              current_fs.animate({opacity: 0}, {
                step: function(now) {
                  // for making fielset appear animation
                  opacity = 1 - now;

                  current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                  });
                  next_fs.css({'opacity': opacity});
                },
                duration: 500
              });
              setProgressBar(++current);
            });

            $(".previous").click(function(){

              current_fs = $(this).parent();
              previous_fs = $(this).parent().prev();

              //Remove class active
              $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

              //show the previous fieldset
              previous_fs.show();

              //hide the current fieldset with style
              current_fs.animate({opacity: 0}, {
                step: function(now) {
                  // for making fielset appear animation
                  opacity = 1 - now;

                  current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                  });
                  previous_fs.css({'opacity': opacity});
                },
                duration: 500
              });
              setProgressBar(--current);
            });

            function setProgressBar(curStep){
              var percent = parseFloat(100 / steps) * curStep;
              percent = percent.toFixed();
              $(".progress-bar")
              .css("width",percent+"%")
            }

            $(".submit").click(function(){
              return false;
            })

          });
          notify = function (title, message, type) {
            new PNotify({
              title: title,
              text: message,
              type: type,
              hide: 'false',
              icon: 'icofont icofont-info-circle'
            });
          }



          $('#region').change(function () {
            var val = $(this).val();
            $.ajax({
              method: 'get',
              url: '<?= url('Marketing/getDistrict/null') ?>',
              data: {region: val},
              dataType: 'html',
              success: function (data) {
                $('#district').html(data);
              }
            });
          });
        
          </script>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

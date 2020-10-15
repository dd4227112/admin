@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/style.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/bars.css">

<link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2.css">

<link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2-bootstrap.css">
<link rel="stylesheet" href="<?= $root ?>assets/select2/css/gh-pages.css">
<style type="text/css">
#regiration_form fieldset:not(:first-of-type) {
  display: none;
}
</style>
<div class="main-body">
  <div class="page-wrapper">

    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">
        <div>
        <embed src="https://shulesoft.s3.amazonaws.com/shulesoft/62fTi6VB1tFBnnWadfaYzItF4eDpBozxmhVVK4sv.pdf" type="application/pdf" width="100%" height="600px" /></embed>

        </div>
          <div class="card">
            <div class="card-block">
              <div class="px-0 pb-0 mt-1 mb-3">
                <div class="text-center">
                  <h2 id="heading">Onboard New School</h2>
                  <p>Fill all form field to go to next step</p>
                </div>
                <div id="msform">
                  <!-- progressbar -->
                  <ul id="progressbar">
                    <li class="active" id="account"><strong>About School</strong></li>
                    <li class="active" id="personal"><strong>School Contact</strong></li>
                    <li class="active" id="payment"><strong>Application Attachments</strong></li>
                    <li class="active" id="confirm"><strong>Bank Intagration</strong></li>
                  </ul>
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <hr>
                </div>
                <!-- <div class="alert alert-success hide"></div> -->
                <form id="regiration_form" novalidate>
                  <fieldset>
                    <div class="form-group row">
                      <div class="col-md-6">
                        School Name
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
                    <input type="button" name="password" class="next btn btn-info" value="Next" />
                  </fieldset>
                  <fieldset>
                  <h4>Step 2. Key Personal Contact</h4>

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
                        ShuleSoft Agreement Form
                        <input type="file" name="name" class="form-control"/>
                      </div>
                      <div class="col-sm-6">
                        Bank Application Form
                        <input type="file" name="phone" class="form-control"/>
                      </div>
                    </div>

                    <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
                    <input type="button" name="next" class="next btn btn-info" value="Next" />
                  </fieldset>

                  <fieldset>
                    <h4> Step 3: Attach Required Documents</h4>

                    <div class="form-group row">
                      <div class="col-sm-6">
                        ShuleaSoft Agreement Form
                        <input type="file" name="name" class="form-control"/>
                      </div>
                      <div class="col-sm-6">
                        Bank Application Form
                        <input type="file" name="phone" class="form-control"/>
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


                    <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
                    <input type="button" name="next" class="next btn btn-info" value="Next" />
                  </fieldset>

                  <fieldset>
                    <h4>Step 4: Bank Integrations</h4>

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

                    <div class="form-group">
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
                    <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
                    <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
                  </fieldset>
                </form>

                <script type="text/javascript">

                $(document).ready(function(){
                  var current = 1,current_step,next_step,steps;
                  steps = $("fieldset").length;
                  $(".next").click(function(){
                    current_step = $(this).parent();
                    next_step = $(this).parent().next();
                    next_step.show();
                    current_step.hide();
                    setProgressBar(++current);
                  });
                  $(".previous").click(function(){
                    current_step = $(this).parent();
                    next_step = $(this).parent().prev();
                    next_step.show();
                    current_step.hide();
                    setProgressBar(--current);
                  });
                  setProgressBar(current);
                  // Change progress bar action
                  function setProgressBar(curStep){
                    var percent = parseFloat(100 / steps) * curStep;
                    percent = percent.toFixed();
                    $(".progress-bar")
                    .css("width",percent+"%")
                    .html(percent+"%");
                  }
                });



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

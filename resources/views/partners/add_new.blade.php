@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<head>
<script type="text/javascript" src="http://thecodeplayer.com/uploads/js/jquery-1.9.1.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js"></script>

<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/bars.css">

<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/style.css">

<link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2.css">

<link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2-bootstrap.css">
<link rel="stylesheet" href="<?= $root ?>assets/select2/css/gh-pages.css">

<style type="text/css">
#regiration_form fieldset:not(:first-of-type) {
  display: none;
}
</style>
</head>
<div class="main-body">
  <div class="page-wrapper">

    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-block">
              <div class="px-0 pb-0 mt-1 mb-3">
                <div class="text-center">
                  <h2 id="heading">Onboard New School</h2>
                  <p>Please Fill all form field to go next step</p>

                </div>
                <div id="msform">
                  <!-- progressbar -->
                  <ul id="progressbar">
                    <li class="active" id="account"><strong>About School</strong></li>
                    <li class="active" id="personal"><strong>School Contact</strong></li>
                    <li class="active" id="payment"><strong>Application Attachments</strong></li>
                    <li class="active" id="confirm"><strong>Bank Integration</strong></li>
                  </ul>
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <hr>
                </div>
                <!-- <div class="alert alert-success hide"></div> -->
                <form id="regiration_form" action="" method='POST' enctype='multipart/form-data'>
                  <fieldset>
                    <div class="form-group row">
                      <div class="col-sm-6">
                        School Name
                        <input type="text" class="form-control" placeholder="School Name here.." name="school_name" value="<?=$school->name ?? '' ?>" required>
                        </div>
                        <div class="col-sm-6">
                        Registration No:
                        <input type="text" class="form-control"  name="registration_number" value="<?=$school->registration_number ?? '' ?>" required="">
                      </div>
                      
                    </div>

                    <div class="form-group row">
                      
                      <div class="col-sm-6">
                          Number of Students
                          <input type="text" class="form-control" placeholder="Enter here..." name="students" value="<?=$school->students ?? '' ?>" required="">
                      </div>
                      <div class="col-sm-6">
                        Implementation Start Date
                        <input type="date" class="form-control"  name="implementation_date" required="">
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
                      <div class="col-md-6">
                        Select Ward
                        <select type="text" name="ward" id="ward" style="text-transform:uppercase" required class="form-control select2">
                         
                        </select>
                      </div>
                      <div class="col-sm-6">
                        P.O Box Address
                        <input type="text" class="form-control"  name="address" required="">

                      </div>
                    </div>

                    
                    
                    <input type="button" name="password" class="next btn btn-info" value="Next" />
                  </fieldset>
                  <fieldset>
                    <h4>Step 2. Key Personal Contact</h4>

                    <div class="form-group row">
                      <div class="col-sm-6">
                        Fullname
                        <input type="text" name="fullname" class="form-control" value="<?=$contact->name ?? '' ?>" required/>
                      </div>
                      <div class="col-sm-6">
                      Title
                        <select name="title" class="form-control select2" required>
                        <option value="<?=$contact->title ?? '' ?>"><?=$contact->title ?? '' ?></option>
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

                    <div class="form-group row">
                      <div class="col-sm-6">
                        Email Address
                        <input type="text" name="email" value="<?=$contact->email ?? '' ?>" class="form-control" required/>
                      </div>
                      <div class="col-sm-6">
                      Phone Number
                        <input type="text" name="phone" value="<?=$contact->phone ?? '' ?>" class="form-control" required/>
                      </div>
                    </div>

                    <div class="form-group row">
                    <div class="col-sm-6">
                        <strong>Select School Levels</strong>
                        <br>
                        <input type="checkbox" name="classlevel[]" value="A-level">&nbsp; &nbsp; &nbsp; A-level (Advanced Secondary Level - ACSEE exams)
                        <br>
                        <input type="checkbox" name="classlevel[]" value="O-level">&nbsp; &nbsp; &nbsp; O-level (Ordinary Secondary Level - CSEE exams)
                       
                      </div>
                    <div class="col-sm-6">
                        <br>
                        <input type="checkbox"  name="classlevel[]" value="Primary">&nbsp; &nbsp; &nbsp; Primary (Primary Education Level - PSLE exams)
                        <br>
                        <input type="checkbox"  name="classlevel[]" value="Nursery">&nbsp; &nbsp; &nbsp; Nursery (Pre-Primary)- (Pre-primary Education Level)
                        </div>
                    </div>

                    <div class="form-group">
                    <div class="row" style="border: 0.5px dashed;">
                      <div class="col-sm-4">Account Name  <b style="font-size: 1.4em; float:right"> https://</b> </div>
                      <div class="col-sm-6">
                        <input  class="form-control " id="school_username" name="username" type="text" autofocus="" placeholder="Enter school keyname here.."  required="" onkeyup="validateForm()">
                      </div>
                      <div class="col-sm-2">
                        <b style="font-size: 1.4em;">.shulesoft.com</b>
                      </div>
                      <small id="username_message_reply"></small>
                    </div>
                </div>
                    
                    <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
                    <input type="button" name="next" class="next btn btn-info" value="Next" />
                  </fieldset>

                  <fieldset>
                    <!-- <h4> Step 3: School Application Attachments </h4> -->

                    <div class="form-group row">
                      <div class="col-sm-6">
                        ShuleSoft Application Form
                        <input type="file" name="attachments[]" class="form-control" required/>
                      </div>
                      <div class="col-sm-6">
                        Bank Application Form
                        <input type="file" name="attachments[]" class="form-control" required/>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <div class="col-sm-6">
                        ShuleSoft Contract Document
                        <input type="file" name="attachments[]" class="form-control"/>
                      </div>
                      <div class="col-sm-6">
                      Standing Order Form
                        <input type="file" name="attachments[]" class="form-control"/>
                        </div>
                      </div>

                      <div class="form-group row">
                      <div class="col-sm-6">
                        Shulesoft Terms of Services
                        <input type="file" name="attachments[]" class="form-control" required/>
                      </div>
                      <div class="col-sm-6">
                      CRDB Terms and Conditions 
                        <input type="file" name="attachments[]" class="form-control"/>
                      </div>
                    </div>
                    
                    
                    <hr>

                    <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
                    <input type="button" name="next" class="next btn btn-info" value="Next" />
                  </fieldset>

                  <fieldset>
                    <h4>Step 4: Bank Integrations </h4>

                    <div class="form-group row">
                      <div class="col-sm-12">
                        Account Name
                        <input type="text" name="account_name" class="form-control"/>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-6">
                        Bank Account Number
                        <input type="text" class="form-control"  name="account_number" required="">
                      </div>

                      <div class="col-sm-6">
                        Branch Name
                        <input type="text" name="branch_name" class="form-control"/>
                      </div>
                    </div>


                    <div class="form-group row">
                      <div class="col-sm-6">
                        Currency
                        <select name="refer_currency_id" class="form-control select2">
                          <?php $curs = DB::table('constant.refer_currencies')->get();
                          foreach($curs  as $cur){
                            ?>
                            <option value="<?=$cur->id?>"><?=$cur->currency?> (<?=$cur->symbol?>)</option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-sm-6">
                        Opening Balance
                        <input type="text" class="form-control"  name="opening_balance" required="">
                      </div>
                    </div>

                    <div class="form-group row">
                    <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                    <label class="form-check-label"> 
                    <input class="form-check-input" type="radio" name="payment_status" id="gender-1" value="1" required=""> I Agree All Information Filled Here is True and Verified
                  </label>
                  </div>
                  </div>
                  </div>
                  <hr>
                <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
                <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
              </fieldset>
                        
            {{ csrf_field() }}

          </form>

<script type="text/javascript">

$(".select2").select2({
  theme: "bootstrap",
  dropdownAutoWidth: false,
  allowClear: false,
  debug: true
});

$(document).ready(function(){
  var current = 1,current_step,next_step,steps;
  steps = $("fieldset").length;
  $(".next").click(function(){
    
    $('#regiration_form').validate();
    if (!$('#regiration_form').valid()) {
        return false;
    }
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

function validateForm() {
  var regex = new RegExp("^[a-z]+$");
  var x = $('#school_username').val();
  if (x == null || x == "") {
    $('#username_message_reply').html("Name must not be blank").addClass('alert alert-danger');
    return false;
  } else if (!regex.test(x)) {
    $('#username_message_reply').html("Name contains invalid characters (Only letters with no spaces !)").addClass('alert alert-danger');
    return false;
  } else {
    $('#username_message_reply').html('').removeClass('alert alert-danger');
    ;
    return true;
  }
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
$('#district').change(function () {
    var val = $(this).val();
    $.ajax({
        method: 'get',
        url: '<?= url('Marketing/getWard/null') ?>',
        data: {district: val},
        dataType: 'html',
        success: function (data) {
            $('#ward').html(data);
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
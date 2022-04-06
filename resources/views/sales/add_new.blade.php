@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

  <div class="page-header">
      <div class="page-header-title">
        <h4><?='Onboard new school' ?></h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">new school</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">sales</a>
                </li>
            </ul>
        </div>
    </div> 
    
          <div class="card">
            <div class="card-block">
                <div class="text-center m-t-10 m-b-20">
                  <h4 id="heading">Onboard New School</h4>
                </div>
             
                <form action="<?= url('sales/onboard/' . $school->id) ?>" method="POST" enctype="multipart/form-data">
                  <fieldset>
                    <div class="form-group row">
                      <div class="col-sm-4">
                         School Name
                         <input type="text" class="form-control" placeholder="School Name here.." name="school_name" value="<?=$school->name ?? '' ?>" required>
                      </div>

                      <div class="col-sm-4">
                          Account Name
                          <div class="row">
                              <div id="col-sm-2">  
                                  <b style="font-size: 1.2em;"> https://</b>
                               </div>
                              <div id="col-sm-7">
                                  <input style="max-width: 15em; resize: none" class="form-control" id="school_username" name="username" type="text" placeholder="school name" value="<?= clean(strtolower($school->name)) ?>" maxlength="15" onkeyup="validateForm()"> 
                              </div>
                              <div id="col-sm-3">
                                  <b style="font-size: 1.2em;">.shulesoft.com</b>
                              </div>
                          </div>
                          <small style="max-width: 13em;" id="username_message_reply"></small>
                       </div>

                        <div class="col-sm-4">
                           Sales Person
                        <select name="sales_user_id" class="select2">
                          <?php foreach ($staffs as $staff) { ?>
                            <option user_id="<?= $staff->id ?>" school_id="" value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                          <?php } ?>
                       </select>
                      </div>
                      
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-6">
                           Owner Phone
                        <input type="text" class="form-control" placeholder="School Owner phone number" name="owner_phone" required>
                      </div>
                      <div class="col-sm-6">
                          Owner Email
                           <input type="text" class="form-control" placeholder="School Owner email" name="owner_email" required>
                      </div>
                    </div>

              
                     <div class="form-group row">
                       <div class="col-sm-6">
                           Agreement Type
                            <select name="contract_type_id" class="form-control" >
                               <option value="">select</option>
                             <?php $ctypes = DB::table('admin.contracts_types')->whereNotIn('id',[4,5,6,7,8])->get();
                                 foreach ($ctypes as $ctype) {?>
                                  <option value="<?= $ctype->id ?>"><?= $ctype->name ?></option>
                              <?php } ?>
                          </select>
                      </div>

                      <div class="col-md-6">
                           Upload Agreement Form
                            <input type="file" class="form-control" accept=".pdf" name="file" required="">
                       </div>
                     </div>

                    <div class="form-group row">
                      <div class="col-md-6">
                          Price Per Student
                        <input type="text" class="form-control transaction_amount" value="10000" name="price" required="">
                      </div>

                      <div class="col-md-6">
                         Estimated Students
                          <input type="number" class="form-control" value="<?= $school->students ?>" name="students" required="">
                       </div>
                     </div>
                      
                    <div class="form-group row" id="paymentption">
                      <div class="col-md-6">
                          Payment Option
                          <select name="payment_option" class="form-control" id="_payment_option">
                            <option value="">select</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Standing Order">Standing Order</option>
                            <option value="Bank Transfer">Bank Transfer </option>
                            <option value="Bank Deposit">Bank Deposit</option>
                        </select>
                      </div>

                        <div class="col-sm-6">
                           Final Sales Method
                            <select name="task_type_id"  class="form-control" required>
                                <?php
                                $types = DB::table('task_types')->where('department', 2)->get();
                                foreach ($types as $type) {
                                    ?>
                                    <option value="<?= $type->id ?>"><?= $type->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>



               <div class="m-t-20"  id="standing_order_form"  style="display: none;">
                 <h6><strong>Add standing Order informations</strong></h6>
                <div class="form-group row">
                    <div class="col-sm-4">
                            Branch name 
                        <input type="text" placeholder="Bank branch name"  class="form-control"  name="branch_name">
                    </div>
                    <div class="col-sm-4">
                            Contact person
                        <input type="text" placeholder="Contact person"  class="form-control"  name="contact_person">
                    </div>
                        <div class="col-sm-4">
                            Number of Occurance
                        <input type="number" placeholder="must be number eg 2, 3, 12 etc"  class="form-control" id="box1" name="number_of_occurrence">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4">
                           Payment Basis
                            <select name="which_basis"  class="form-control">
                                <option value=""></option>
                                <option value="Annually">Annually</option>
                                <option value="Semiannually">Semi Annually</option>
                                <option value="Quarterly">Quarterly</option>
                                <option value="Monthly">Monthly</option>
                            </select>
                    </div>
                    <div class="col-sm-4">
                            Amount for Every Occurrence 
                            <input type="text"  class="form-control transaction_amount"  name="occurance_amount" id="box2">
                    </div>
                        <div class="col-sm-4">
                           Total Amount
                            <input type="text" class="form-control" name="total_amount" >
                    </div>
                </div>

                    <div class="form-group row">
                    <div class="col-sm-4">
                           Maturity Date
                            <input type="date"class="form-control" name="maturity_date">
                    </div>
                    <div class="col-sm-4">
                            Standing order file
                            <input type="file" class="form-control" name="standing_order_file">
                    </div>
                        <div class="col-sm-4">
                           Refer bank
                            <select name="refer_bank_id"  class="form-control">
                            <?php
                            $banks = DB::table('constant.refer_banks')->get();
                            if (!empty($banks)) {
                                foreach ($banks as $bank) {
                                    ?>
                            <option
                                value="<?= $bank->id ?>">
                                    <?= $bank->name ?>
                            </option>
                            <?php
                            }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

              <div class="form-group row">
                <div class="col-sm-12"> 
                   Areas much interested
                    <textarea rows="4" cols="5" name="description" class="form-control" placeholder="Clarify if this client has any special needs or areas much interested to start ?"></textarea>
                </div>
            </div>

             <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary btn-round btn-sm">Submit</button>
                </div>
            </div>
                    
                        
            {{ csrf_field() }}

          </form>

<script type="text/javascript">

$('#_payment_option').change(function () {
      var val = $(this).val();
      if (val != 'Standing Order') {
          $('#standing_order_form').hide();
      } else {
          $('#standing_order_form').show();
      }
  });


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
  }
  else if (!regex.test(x)) {
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

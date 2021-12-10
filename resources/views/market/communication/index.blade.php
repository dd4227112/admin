@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/';
?>


    

           <div class="page-header">
            <div class="page-header-title">
                <h4><?=' Compose message' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">communication</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">messages</a>
                    </li>
                </ul>
            </div>
        </div> 


        <div class="page-body">
                <div class="col-sm-12">
                  <div class="card">
                    <div class="card-block">
                       <div class="row">
   
                         <form class="form-horizontal" method="POST" action="<?= base_url('marketing/communication') ?>">
                            <div class="card-block">
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="form-field-select-0">
                                        Channels:
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <select multiple="" id="sms_keys_id" class="select2"  name ="sms_channels[]" required>
                                        <option value="quick-sms">Quick SMS</option>
                                        <option value="whatsapp">WhatsApp</option>
                                        <option value="telegram">Telegram</option>
                                        <option value="phone-sms">Phone SMS</option>
                                        <option value="email">Email</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="form-field-select-0">
                                       Send SMS to
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <select style="30px;" id="form-field-select-0" class="select2" name="firstCriteria"
                                        onchange="setFirstCriteria(this.value);">
                                        <option value="{{old('criteria')}}">Select</option>
                                        <option value="00">Customers</option>
                                        <option value="01">Prospects</option>
                                        <option value="02">Leads</option>
                                        <option value="03">All</option>
                                        <option value="04">Custom selection</option>
                                    </select>
                                </div>
                                <div class="has-error">
                                    <?php if (form_error($errors, 'criteria')): ?>
                                    <?php echo form_error($errors, 'criteria'); ?>
                                    <?php endif ?>
                                </div>
                            </div>

                          
                        
                            <div class="form-group row" id="parents_selection" style="display: none;">
                                 <div class="col-sm-4">
                                    <label>
                                        Select Customer:
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <select id="form-field-select-3" class="select2" name="customer_criteria"
                                        onchange="setCriteria(this.value);">
                                        <option value="{{old('criteria')}}">Select</option>
                                        <option value="0">All Customers (Paid) </option>
                                        <option value="1">Active & Full paid customers</option>
                                        <option value="2">Active & partial paid customers</option>
                                        <option value="3">Active but not paid customers (have S.I)</option>
                                        <option value="4">Not active & paid customers</option>
                                        <option value="5">By customer segment</option>
                                    </select>
                                </div>
                                <div class="has-error">
                                    <?php if (form_error($errors, 'criteria')) { ?>
                                    <?php echo form_error($errors, 'criteria'); ?>
                                    <?php } ?>
                                </div>
                            </div>

                             <div class="form-group row" id="by_customer_segment" style="display: none;">
                                 <div class="col-sm-4">
                                    <label  for="form-field-select-4">
                                        Customer Segment
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <select id="form-field-select-3" class="select2" name="customer_segment"
                                        onchange="BycustomerSegment(this.value);">
                                        <option value="{{old('criteria')}}">Select</option>
                                        <option value="00">Nursey schools only  </option>
                                        <option value="01">Primary schools</option>
                                        <option value="02">Secondary schools </option>
                                        <option value="03">College only</option>
                                        <option value="04">Schools with student (greater than or less than)</option>
                                    </select>
                                </div>
                                <div class="has-error">
                                    <?php if (form_error($errors, 'criteria')) { ?>
                                    <?php echo form_error($errors, 'criteria'); ?>
                                    <?php } ?>
                                </div>
                            </div>



                            <div class="form-group row" id="prospect_selection" style="display: none;">
                                <div class="col-sm-4">
                                    <label for="form-field-select-4">
                                       Prospects
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <select id="form-field-select-4" class="select2" name="prospectscriteria"
                                         onchange="setProspectsCriteria(this.value);">
                                        <option value="{{old('criteria')}}">Select</option>
                                        <option value="001">All Prospects </option>
                                        <option value="002">Based on segment</option>
                                    </select>
                                </div>
                                <div class="has-error">
                                    <?php if (form_error($errors, 'criteria')): ?>
                                    <?php echo form_error($errors, 'criteria'); ?>
                                    <?php endif ?>
                                </div>
                            </div>


                           <div class="form-group row" id="leads_selection" style="display: none;">
                                <div class="col-sm-4">
                                    <label for="form-field-select-4">
                                       Leads
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <select id="form-field-select-4" class="select2" name="leadscriteria"
                                        onchange="setLeadsCriteria(this.value);">
                                        <option value="{{old('criteria')}}">Select</option>
                                        <option value="001">All Leads </option>
                                        <option value="002">Based on segment</option>
                                    </select>
                                </div>
                                <div class="has-error">
                                    <?php if (form_error($errors, 'criteria')): ?>
                                    <?php echo form_error($errors, 'criteria'); ?>
                                    <?php endif ?>
                                </div>
                            </div>     
                            
                            
                         <div class="form-group row" id="custom_number_selection" style="display: none;">
                            <div class="col-sm-4">
                                <label for="form-field-select-3">
                                    Phone numbers
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" id="tags_1" data-role="tagsinput" class="tags form-control"  name ="custom_numbers" placeholder="separate by comma or space"  />
                            </div>
                            <div class="has-error">
                                <?php if (form_error($errors, 'custom_numbers')): ?>
                                    <?php echo form_error($errors, 'custom_numbers'); ?>
                                <?php endif ?>
                            </div>
                           </div>



                         
                        <div class="row" id="number_of_student" style="display: none;">
                           <div class="form-group col-sm-12 row" >
                                <label class="col-sm-3">
                                   Criteria
                                </label>
                                <label class="col-sm-3">
                                    Less Than   <input type="radio" id="optionsRadios1" name="less_than" value="1" >
                                </label>
                                <label class="col-sm-3">
                                    Greater than  
                                    <input type="radio" id="optionsRadios2" name="less_than"  value="0" > 
                                </label>
                                <label class="col-sm-3">
                                    Equals to 
                                    <input type="radio" id="optionsRadios3" name="less_than"  value="2" > 
                                </label>
                            </div>

                            <div class="form-group col-sm-12 row">
                                <div class="col-sm-5">
                                    <label for="amount" class="control-label">
                                        Specify students number
                                    </label>
                                </div>
                                <div  class="col-sm-7">
                                    <input type="number" name="student_number" placeholder="Enter student number Here" id= "student_number" class="form-control"/>
                                </div>
                            </div> 
                         </div> 

                      
                 
                        <div class='form-group row'>
                            <div class="col-sm-4">
                                <label for="sms_template">
                                    <?= __("Template") ?>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <?php

                                 $array = array(
                                     'select' => 'Select Template',
                                 );

                                 $templates = DB::table('admin.mailandsmstemplates')->where('status', '1')->get();
                                foreach ($templates as $etemplate) {
                                    strtolower($etemplate->type) == 'sms' ? $array[$etemplate->id] = $etemplate->name : '';
                                }
                                echo form_dropdown("template", $array, old("email_template"), "id='sms_template' data-type='content_area' class='form-controli select2'");
                                ?>

                            </div>
                            <span class="col-sm-1 control-label">
                                <?php echo form_error($errors, 'sms_template'); ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control" name="message"
                                    onmousedown="get_estimated_delivery_time()" rows="6" id="content_area"
                                    placeholder="<?= __('message') ?>"><?= old('sms_message') ?></textarea>
                            </div>
                            <div class="col-sm-12">
                                <span><?= __('chars/SMS count') ?> <b id="word_counts">0</b>/<b
                                        id="sms_count">1</b></span>
                                <div><?= __('write') ?> <code style="color: green;"><?= __('#name') ?></code>,
                                    <?= __('it_will') ?>; <code style="color: green;"><?= __('#username') ?></code>,
                                    <?= __('it_will_username') ?> #schema_name =School Short Name</div>


                                <div id="account_tags" style="display: none">
                                    <code style="color: green;">#name</code> =Admin Name, <code
                                        style="color: green;">#schema_name </code>= Admin Short School Name, <code
                                        style="color: green;">#username </code>=Admin username
                                </div>
                            </div>
                            <div class="has-error">
                                <?php if (form_error($errors, 'message')): ?>
                                <?php echo form_error($errors, 'message'); ?>
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="pull-left col-sm-4">
                            <p>Estimated Delivery Time: <span id="get_estimated_delivery_time"></span> <i
                                    class="fa fa-question-circle" data-container="body" data-toggle="popover"
                                    data-placement="right" data-trigger="hover"
                                    title="This depends on number of parents to receive sms and existing pending SMS and whether sent by Quick SMS or phone"></i>
                            </p>
                        </div>
                        <div class="pull-right col-sm-2">
                           <button type="submit" class="btn btn-primary btn-mini btn-round"> Submit </button>
                        </div>
                        <?= csrf_field() ?>
                      </div>
                    </form>
                    </div>
                   </div>
                    <div class="col-sm-2"></div>
                </div>
                <!--</div>-->
            </div>
 

            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true"style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" onmousedown="message_left_count()" class="close"
                                data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Quick SMS</h4>
                        </div>
                        <div class="modal-body">
                            <p>These are Quick and Fasts SMS that can be delivered in less than 5min</p>
                            <h3>Only at Tsh 20/= per SMS</h3>
                            <p></p>
                            <div id="buy_sms_content">
                                <form class="form-horizontal form-label-left" onsubmit="return false">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Enters
                                            Number of SMS to buy <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="number_of_sms" name="sms" required="required"
                                                class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"><span
                                                class="required"></span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="submit" class="btn btn-success" id="buy_sms_btn">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                onmousedown="message_left_count()">Close</button>
                            <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>

     $(".select2").select2({
      theme: "bootstrap",
      dropdownAutoWidth: false,
      allowClear: false,
      debug: true
  }); 


get_estimated_delivery_time = function() {
    // var type = $('#sms_keys_id').val();
    // $.ajax({
    //     type: 'GET',
    //     url: "<?= url('background/getEstimatedDeliveryTime/null') ?>?type=" + type,
    //     data: {
    //         sms_type: type
    //     },
    //     dataType: "html",
    //     success: function(data) {
    //         $('#get_estimated_delivery_time').html(data);
    //     }
    // });
}
message_left_count = function() {
    $.ajax({
        type: 'POST',
        url: "<?= url('background/getBulkSmsRemains') ?>",
        data: {
            type: 'sms'
        },
        dataType: "html",
        success: function(data) {
            $('#message_left_count').html(data);
        }
    });
}
buy_sms = function() {
    $('#buy_sms_btn').mousedown(function() {
        var number_of_sms = $('#number_of_sms').val();
        $.ajax({
            type: 'POST',
            url: "<?= url('background/createReference') ?>",
            data: {
                number_of_sms: number_of_sms,
                type: 'sms'
            },
            dataType: "html",
            success: function(data) {
                $('#buy_sms_content').html(data);
            }
        });
    });
}
$(document).ready(buy_sms);

  $('#sms_template').change(function () {
            var templateID = $(this).val();
            $.ajax({
                type: 'POST',
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                url: "<?= base_url('marketing/getTemplateContent') ?>",
                data: "templateID=" + templateID,
                dataType: "html",
                success: function (data) {
                    $('#content_area').html(data);
                }
            });

        })



function setFirstCriteria(value) {
    switch (value) {
        case '00':
            $('#parents_selection').show();
            $('#by_customer_segment,#leads_selection,#prospect_selection,#custom_number_selection,#teachersPhones,#number_of_student').hide();
            break;
        case '01':
            $('#by_customer_segment,#leads_selection,#category6,#category8,#account_tags,#parents_selection,#number_of_student').hide();
            $('#prospect_selection').show();
            break;
        case '02':
            $('#load_types,#by_customer_segment,#category6,#category8,#account_tags,#parents_selection,#prospect_selection,#number_of_student').hide();
            $('#leads_selection').show();
            break;
        case '03':
            $('#leads_selection,#by_customer_segment,#custom_number_selection,#category8,#account_tags,#parents_selection,#prospect_selection,#number_of_student').hide();
            break;
        case '04':
            $('#leads_selection,#by_customer_segment,#category6,#category8,#account_tags,#parents_selection,#prospect_selection,#number_of_student').hide();
            break;
        default:
            break;
    }
}



function setCriteria(value1) {
    switch (value1) {
        case '':
            $('#by_customer_segment,#load_payment_status,#category6,#category8,#account_tags,#number_of_student').hide();
            break;
        case '0':
            $('#by_customer_segment,#category6,#category8,#load_hostel,#number_of_student').hide();
         
            break;
        case '1':
            $('#load_fees,#load_payment_status,#load_types,#category6,#category7,#category8,#load_hostel').hide();
            $('#by_customer_segment,#account_tags,#load_payment_amount').hide();
            break;
        case '2':
            $('#load_payment_status,#load_types,#by_customer_segment').hide();
            $('#load_payment_status,#account_tags,#load_payment_amount,#load_hostel,#number_of_student').hide();
            break;
        case '3':
            $('#by_customer_segment,#load_hostel,#load_fees,#load_payment_status,#number_of_student').hide();
            break;
        case '4':
            $('#by_customer_segment,#load_hostel,#load_fees,#load_payment_status,#number_of_student').hide();
            break;
        case '5':
            $('#category').hide();
            $('#load_payment_status,#load_fees,#account_tags,#load_payment_amount,#load_hostel,#number_of_student').hide();
            $('#by_customer_segment').show();
            break;
        default:
            break;
    }
}



function setcustomerCriteria(value) {
    switch (value) {
        case 0:
            $('#by_customer_segment,#leads_selection,#prospect_selection').hide();
            break;
        case 1:
            $('#by_customer_segment,#leads_selection,#category6,#category8,#account_tags').hide();
            $('#prospect_selection').show();
            break;
        case 2:
            $('#load_types,#by_customer_segment,#category6,#category8,#account_tags,#prospect_selection').hide();
            $('#leads_selection').show();
            break;
        case 3:
            $('#leads_selection,#by_customer_segment,#category6,#category8,#account_tags,#prospect_selection').hide();
            break;
        case 4:
            $('#number_of_student').show();
            $('#leads_selection,#by_customer_segment,#category6,#category8,#account_tags,#prospect_selection').hide();
            break;
        default:
            break;
    }
}



function setProspectsCriteria(value){
      switch (value) {
        case '001':
            $('#custom_number_selection').show();
            $('#parents_selection,#leads_selection,#by_customer_segment,#parents_selection,#number_of_student').hide();
            break;
        case '002':
            $('#by_customer_segment,#leads_selection,#by_customer_segment,#account_tags,#parents_selection,#number_of_student').hide();
            $('#custom_number_selection').show();
            break;
        default:
            break;
    }
}

function setLeadsCriteria(value){
      switch (value) {
        case '001':
            $('#custom_number_selection').show();
            $('#parents_selection,#by_customer_segment,#parents_selection,#prospect_selection,#number_of_student').hide();
            break;
        case '002':
            $('#by_customer_segment,#by_customer_segment,#account_tags,#parents_selection,#prospect_selection,#number_of_student').hide();
            $('#custom_number_selection').show();
            break;
        default:
            break;
    }
}


function BycustomerSegment(value){
    switch (value) {
    case '01':
        $('#number_of_student,#prospect_selection,#custom_number_selection').hide();
        break;
     case '02':
        $('#number_of_student,#prospect_selection,#custom_number_selection').hide();
        break;
     case '03':
        $('#number_of_student,#prospect_selection,#custom_number_selection').hide();
        break;
    case '04':
      //   $(#account_tags,#prospect_selection').hide();
         $('#number_of_student').show();
      
        break;
    default:
        break;
}
}

word_count = function() {
    $('#content_area').keyup(function() {
        var words = $('#content_area').val().length;
        $('#word_counts').html(words);
        $('#sms_count').html(Math.ceil(words / 160));
        if (words > 160) {
            $('#word_counts').style.color = 'black';
        }
    });
};
$(document).ready(word_count);

//add comma at every 3 digit on amount
$('#amount').change(function(event) {
    var num = $this.val().replace(/(\s)/g, '');
    $this.val(num.replace(/(\d)(?=(\d{3})+(?!\d))/g, ","));
});
</script>
@endsection
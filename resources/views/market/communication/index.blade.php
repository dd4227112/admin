<?php
$email = session('email');
$usertype = session('usertype');
?>
<!-- <div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-mailandsms"></i> <?= $data->lang->line('panel_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li class="active"><?= $data->lang->line('panel_title') ?></li>
        </ol>
    </div><!-- /.box-header--
    <div class="box-body"> -->
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-11">
        <?php
        $schema = str_replace('.', null, set_schema_name());
        $client = DB::connection('karibusms')->table('client')->where('keyname', $schema)->first();

        if (count($client) == 0) {
            $message_left = (new \App\Http\Controllers\Background())->createSmsSetting();
        } else {
            $quick_sms = DB::connection('karibusms')->table('sms_status')->where('client_id', count($client) == 0 ? $client_id : $client->client_id)->first();
            $message_left = count($quick_sms) == 1 ? $quick_sms->message_left : 0;
        }
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>

                    <th><b>Quick SMS</b> <br/>
                        <span class="badge bg-green" data-toggle="modal" data-target=".bs-example-modal-lg"><span id="message_left_count"><?= $message_left ?> </span> Quick SMS Remains (Click here to buy)</span>
                    </th>
                    <th>
                        <b>Normal Phone SMS </b><br/>
                        <span>Sent via the phone:</span>
                    </th>

                </tr>
            </thead>
        </table>

        <p><a href="#" data-toggle="modal" data-target="#karibu_diff_instructions"> Click here to know the difference</a> </p>
        <div class="modal fade" id="karibu_diff_instructions">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                class="sr-only"><?= $data->lang->line('close') ?></span></button>
                        <h4 class="modal-title">Difference between Quick SMS and normal phone SMS</h4>
                    </div>
                    <div class="modal-body" id="modal_content">

                        <table class="table table-bordered">
                            <thead>
                                <tr>

                                    <th><b>Quick SMS</b> </th>
                                    <th><b>Normal Phone SMS</b></th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <td>High rate of sending SMS, Basically speed of 200–500 SMS per second</td>
                                    <td>Low rate of sending SMS (increase by linking more phones)  Basically 1 SMS per second</td>

                                </tr>
                                <tr>

                                    <td>SMS are sent via dedicated gateways available in Telecom companies</td>
                                    <td>SMS are sent from mobile phone connected with ShuleSoft</td>

                                </tr>
                                <tr>

                                    <td>SMS received appear with a sender name as a sender</td>
                                    <td>SMS received appear with school phone number as a sender</td>

                                </tr>
                                <tr>

                                    <td>SMS can be sent to all countries</td>
                                    <td>SMS can only be sent in one country eg Tanzania only</td>

                                </tr>
                                <tr>

                                    <td>Receiver cannot reply back to SMS sent</td>
                                    <td>Receiver can reply back to SMS sent</td>

                                </tr>

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
        <hr>
        <form class="form-horizontal" method="POST" action="{{ url('mailandsms/sendSmsToParentsAndTeachers') }}" enctype="multipart/form-data">
            <div class="form-group">
                <div class="form-group">
                    <div class="col-sm-2">
                        <label for="form-field-select-0">
                            {{trans('mailandsms_lang.from')}}  <a><i class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right" data-trigger="hover"  title="You can change this is SMS settings in main system settings by linking other phone or use internet message"></i></a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <select id="sms_keys_id" class="form-control"  name ="sms_keys_id" >

                            <option value="quick" <?= (int) $message_left > 0 ? 'selected' : '' ?>>Quick SMS</option>

                            <?php
                            $sms_keys = DB::table('sms_keys')->get();
                            foreach ($sms_keys as $key) {
                                ?>
                                <option value="<?= $key->id ?>" <?= (int) $message_left == 0 ? 'selected' : '' ?>><?= $key->phone_number ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="has-error">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-2">
                        <label for="form-field-select-0">
                            {{trans('mailandsms_lang.send_to')}}
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <select id="form-field-select-0" class="form-control"  name ="firstCriteria" onchange="setFirstCriteria(this.value);">
                            <option value="{{old('firstCriteria')}}">&nbsp;</option>
                            <option value="00"><?= trans('mailandsms_lang.mailandsms_parents') ?></option>
                            <option value="01"><?= trans('mailandsms_lang.mailandsms_teachers') ?></option>
                            <option value="02"><?= trans('mailandsms_lang.mailandsms_numbers') ?></option>
                        </select>
                    </div>
                    <div class="has-error">
                        <?php if (form_error($errors, 'criteria')): ?>
                            <?php echo form_error($errors, 'criteria'); ?>
                        <?php endif ?>
                    </div>
                </div>

                <div class="form-group" id="custom_number_selection" hidden>
                    <div class="col-sm-2">
                        <label for="form-field-select-3">
                            <?= $data->lang->line('write_Phone_numbers') ?>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="tags_1" data-role="tagsinput" class="tags form-control"  name ="custom_numbers" placeholder="separate by comma or space"  />
                    </div>
                    <div class="has-error">
                        <?php if (form_error($errors, 'custom_numbers')): ?>
                            <?php echo form_error($errors, 'custom_numbers'); ?>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group" id="parents_selection" hidden>
                    <div class="col-sm-2">
                        <label for="form-field-select-3">
                            <?= $data->lang->line('select_criteria') ?>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <select id="form-field-select-3" class="form-control"  name ="criteria" onchange="setCriteria(this.value);">
                            <option value="0"><?= $data->lang->line('all_parents') ?></option>
                            <option value="1"><?= $data->lang->line('based_on_class') ?></option>
                            <option value="2"><?= $data->lang->line('based_on_feetype') ?></option>
                            <option value="3"><?= $data->lang->line('based_on_accounts') ?></option>
                            <option value="5"><?= $data->lang->line('based_on_transport_routes') ?></option>
                            <option value="6"><?= $data->lang->line('based_on_hostel') ?></option>
                            <option value="4"><?= $data->lang->line('custom_selection') ?></option>
                        </select>
                    </DIV>
                    <div class="has-error">
                        <?php if (form_error($errors, 'criteria')): ?>
                            <?php echo form_error($errors, 'criteria'); ?>
                        <?php endif ?>
                    </div>
                </div>


                <div class="form-group" id="teachers_selection" hidden>
                    <div class="col-sm-2">
                        <label for="form-field-select-4">
                            <?= $data->lang->line('teacher_type') ?>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <select id="form-field-select-4" class="form-control"  name ="teachersCriteria" onchange="setTeachersCriteria(this.value);">
                            <option value="{{old('criteria')}}">Select</option>
                            <option value="001"><?= trans('mailandsms_lang.all_teachers') ?></option>
                            <option value="002"><?= trans('mailandsms_lang.based_on_class') ?></option>
                            <option value="003"><?= trans('mailandsms_lang.custom_selection') ?></option>
                        </select>
                    </div>
                    <div class="has-error">
                        <?php if (form_error($errors, 'criteria')): ?>
                            <?php echo form_error($errors, 'criteria'); ?>
                        <?php endif ?>
                    </div>
                </div>
                <div class="select2-wrapper" id="load_fees" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label>
                                Select Fee
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <?php
                            $c_array = array("0" => 'Select Fees');
                            if (!empty($fees)) {
                                foreach ($fees as $fee) {
                                    $c_array[$fee->id] = $fee->name;
                                }
                            }
                            echo form_dropdown("fee_id", $c_array, old("fee_id"), "id='fee_id' class='form-control'");
                            ?>

                        </div>
                    </div></div>

                <div class="select2-wrapper" id="load_classes" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label>
                                Select Class here
                        </div>
                        <div class="col-sm-9">
                            <?php
                            $c_array = array("0" => 'Select Class');
                            if (!empty($classes)) {
                                foreach ($classes as $class) {
                                    $c_array[$class->classesID] = $class->classes;
                                }
                            }
                            echo form_dropdown("class_id", $c_array, old("class_id"), "id='classesID' class='form-control'");
                            ?>
                        </div>
                    </div>
                </div>

                <div id="load_section" class="form-group" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label>
                                Select Section here
                        </div>
                        <div class="col-sm-9">
                            <?php
                            $array = array("0" => 'Select sections');
                            if (!empty($sections)) {
                                foreach ($sections as $section) {
                                    $array[$section->sectionID] = $section->section;
                                }
                            }
                            echo form_dropdown("section_id", $array, old("section_id"), "id='sectionID' class='form-control'");
                            ?>
                        </div>
                    </div>
                </div>
                <div id="load_student_types" class="form-group" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="sectionID" class="col-sm-2 col-sm-offset-2 control-label">
                                Select Option
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <?php
                            $array = array("0" => 'Select option');
                            if (!empty($student_types)) {

                                foreach ($student_types as $types) {
                                    $array[$types->column_name] = ucwords(str_replace('_', ' ', str_replace('_id', null, $types->column_name)));
                                }
                            }
                            echo form_dropdown("student_type", $array, old("student_type"), "id='student_type' class='form-control select2 col-sm-12'");
                            ?>
                        </div>
                    </div>
                </div>

                <div id="load_types"></div>
                <div id="load_payment_status" class="form-group" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="payment_status" class="control-label">
                                Payment Status
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <?php
                            $array = array("0" => 'Select option');
                            if (!empty($payment_status)) {

                                foreach ($payment_status as $key => $types) {
                                    $array[$key] = $types;
                                }
                            }
                            echo form_dropdown("payment_status", $array, old("payment_status"), "id='payment_status' class='form-control select2 col-sm-12'");
                            ?>
                        </div>
                    </div>
                </div>
                <div id="load_payment_amount" class="form-group" style="display: none">

                    <div class="form-group" class="col-sm-12">
                        <label class="col-sm-3">
                            Select Amount Criteria
                        </label>
                        <label class="col-sm-3">
                            Less Than   <input type="radio" id="optionsRadios1" name="less_than" value="1" >
                        </label>
                        <label class="col-sm-3">
                            Greater than  
                            <input type="radio" id="optionsRadios1" name="less_than"  value="0" > 
                        </label>
                        <label class="col-sm-3">
                            Equals to 
                            <input type="radio" id="optionsRadios1" name="less_than"  value="2" > 
                        </label>
                    </div>

                    <div class="col-sm-2">
                        <label for="amount" class="control-label">
                            Specify Amount :
                        </label>
                    </div>
                    <div  class="col-sm-9">
                        <input type="number" name="amount" placeholder="Enter Amount Here" id= "amount" class="form-control"/>
                    </div>
                </div>
                <div id="load_transport" class="form-group" style="display: none">
                    <div  class="col-sm-2">
                        <label for="load_transport" class="control-label">
                            Select Route
                        </label>
                    </div>
                    <div  class="col-sm-9">
                        <?php
                        $array = array("0" => 'Select option');

                        $transport = \App\Model\TransportRoute::all();

                        if (count($transport)) {

                            foreach ($transport as $route) {
                                $array[$route->id] = $route->name;
                            }
                        }
                        echo form_dropdown("transport_id[]", $array, old("transport_id"), "id='transport_id' class='form-control select2 col-sm-12' multiple");
                        ?>
                    </div>
                </div>

                <div id="load_hostel" class="form-group" style="display: none">
                    <div  class="col-sm-2">
                        <label for="load_transport" class="control-label">
                            Select Hostel
                        </label>
                    </div>
                    <div  class="col-sm-9">
                        <?php
                        $array_hostel = array("0" => 'Select option');

                        $hostels = \App\Model\Hostel::all();

                        if (count($hostels)) {

                            foreach ($hostels as $hostel) {
                                $array_hostel[$hostel->id] = $hostel->name;
                            }
                        }
                        echo form_dropdown("hostel_id[]", $array_hostel, old("hostel_id"), "id='hostel_id' class='form-control select2  col-sm-12' multiple");
                        ?>
                    </div>
                </div>
            </div>
            <div id="category6" class="form-group" style="display: none">

                <div  class="col-sm-2">
                    <label for="load_transport" class="control-label">
                        Select Based On
                    </label>
                </div>
                <div  class="col-sm-9">
                    <select id="form-field-select-2" class="form-control" onchange="setCriteria(this.value);">
                        <option value="0">Select an Option</option>
                        <option value="9"><?= $data->lang->line('based_on_names') ?></option>
                        <option value="10"><?= $data->lang->line('based_on_phone_number') ?></option>
                    </select>
                </div>
            </div>

            <div id="category7" class="form-group" style="display: none">
                <div  class="col-sm-2">
                    <label for="load_transport" class="control-label">
                        Select Parent Name
                    </label>
                </div>
                <div  class="col-sm-9">
                    <?php
                    $array = array("0" => 'Select option');
                    if (count($parents) > 0) {

                        foreach ($parents as $key => $parent) {
                            $array[$parent->parentID] = $parent->name;
                        }
                    }
                    echo form_dropdown("parents[]", $array, old("parents"), "id='parents_name' class='form-control select2_multiple col-sm-12' multiple='multiple'");
                    ?>
                </div>
            </div>
            <div id="category8" class="form-group" style="display: none">

                <div  class="col-sm-2">
                    <label for="load_transport" class="control-label">
                        Select Parent Phone
                    </label>
                </div>
                <div  class="col-sm-9">
                    <?php
                    $array = array("0" => 'Select option');
                    if (count($parents) > 0) {

                        foreach ($parents as $key => $parent) {
                            $array[$parent->parentID] = $parent->phone;
                        }
                    }
                    echo form_dropdown("parents[]", $array, old("parents"), "id='parents_phone' class='form-control select2_multiple col-sm-12' multiple='multiple'");
                    ?>
                </div>
            </div>

            <div id="teachersCat" class="form-group" style="display: none">

                <div  class="col-sm-2">
                    <label for="load_transport" class="control-label">
                        Select Teacher Based
                    </label>
                </div>
                <div  class="col-sm-9">
                    <select id="form-field-select-5" class="form-control" onchange="setTeachersCriteria(this.value);">
                        <option value="">Select an Option</option>
                        <option value="09"><?= $data->lang->line('based_on_teachers_names') ?></option>
                        <option value="010"><?= $data->lang->line('based_on_teachers_phone_number') ?></option>
                    </select>
                </div>
            </div>
            <div id="teachersNames" class="form-group" style="display: none">
                <div  class="col-sm-2">
                    <label for="load_transport" class="control-label">
                        Select Teacher Name
                    </label>
                </div>
                <div  class="col-sm-9">
                    <?php
                    $array = array("0" => 'Select option');
                    if (count($teachers) > 0) {

                        foreach ($teachers as $key => $teacher) {
                            $array[$teacher->teacherID] = $teacher->name;
                        }
                    }
                    echo form_dropdown("teachers[]", $array, old("teachers"), "id='teachers_name' class='form-control select2_multiple col-sm-12' multiple='multiple'");
                    ?>
                </div>
            </div>
            <div id="teachersPhones" class="form-group" style="display: none">
                <div  class="col-sm-2">
                    <label for="load_transport" class="control-label">
                        Select Teacher Phone
                    </label>
                </div>
                <div  class="col-sm-9">
                    <?php
                    $array = array("0" => 'Select option');
                    if (count($teachers) > 0) {

                        foreach ($teachers as $key => $teacher) {
                            $array[$teacher->teacherID] = $teacher->phone;
                        }
                    }
                    echo form_dropdown("teachers[]", $array, old("teachers"), "id='teachers_phone' class='form-control select2_multiple col-sm-12' multiple='multiple'");
                    ?>
                </div>
            </div>
            <div class='form-group' >
                <div class="col-sm-2">
                    <label for="sms_template" class="col-sm-3">
                        <?= $data->lang->line("mailandsms_template") ?>
                    </label>
                </div>
                <div class="col-sm-9">

                    <?php
                    $array = array(
                        'select' => $data->lang->line('mailandsms_select_template'),
                    );

                    foreach ($templates as $etemplate) {
                        strtolower($etemplate->type) == 'sms' ? $array[$etemplate->id] = $etemplate->name : '';
                    }
                    echo form_dropdown("template", $array, old("email_template"), "id='sms_template' data-type='content_area' class='form-control'");
                    ?>

                </div>
                <span class="col-sm-1 control-label">
                    <?php echo form_error($errors, 'sms_template'); ?>
                </span>
            </div>

            <div class="form-group">

                <div class="col-sm-11">
                    <textarea class="form-control" name="message" onmousedown="get_estimated_delivery_time()"  rows="10" id="content_area" placeholder="<?= $data->lang->line('message') ?>"><?= old('sms_message') ?></textarea>
                </div>
                <div class="col-sm-12">
                    <span><?= $data->lang->line('chars/SMS count') ?> <b id="word_counts">0</b>/<b id="sms_count">1</b></span>
                    <div><?= $data->lang->line('write') ?> <code style="color: green;"><?= $data->lang->line('#name') ?></code>, <?= $data->lang->line('it_will') ?>; <code style="color: green;"><?= $data->lang->line('#username') ?></code>, <?= $data->lang->line('it_will_username') ?> </div>


                    <div id="account_tags" style="display: none">
                        <code style="color: green;">#name</code> =Parent Name, <code style="color: green;">#student_name </code>= Student Name, <code style="color: green;">#username </code>=parent username, <code style="color: green;">#balance </code>= requested amount a student needs to pay, <code style="color: green;">#invoice </code>=invoice number
                    </div>
                </div>
                <div class="has-error">
                    <?php if (form_error($errors, 'message')): ?>
                        <?php echo form_error($errors, 'message'); ?>
                    <?php endif ?>
                </div>
            </div>
            <div class="pull-left col-sm-4">
                <p>Estimated Delivery Time: <span id="get_estimated_delivery_time"></span> <i class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right" data-trigger="hover"  title="This depends on number of parents to receive sms and existing pending SMS and whether sent by Quick SMS or phone"></i></p>
            </div>
            <div class="pull-right col-sm-2">                    
                <button type="submit" class="btn btn-primary btn-block "><i class="fa fa-envelope-o"></i> <?= $data->lang->line('send') ?></button>
            </div> 
            <?= csrf_field() ?>
        </form>
        <!--</div><!-- /.box-body -->
        <div class="col-sm-2"></div>
    </div>
    <!--</div>-->
</div>
    <!--<script  src="<?php echo base_url('public/assets/jquery.tagsinput/bootstrap-tagsinput.min.js'); ?>"></script>-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button"  onmousedown="message_left_count()" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Enters Number of SMS to buy <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" id="number_of_sms" name="sms" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"><span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="submit" class="btn btn-success" id="buy_sms_btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onmousedown="message_left_count()">Close</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>

        </div>
    </div>
</div>
<script>
//    $('#tags_1').tagsinput({
//  tagClass: 'big',confirmKeys: [13, 32, 44]
//});
    get_estimated_delivery_time = function () {
        var type = $('#sms_keys_id').val();
        $.ajax({
            type: 'GET',
            url: "<?= base_url('background/getEstimatedDeliveryTime/null') ?>?type=" + type,
            data: {sms_type: type},
            dataType: "html",
            success: function (data) {
                $('#get_estimated_delivery_time').html(data);
            }
        });
    }
    message_left_count = function () {
        $.ajax({
            type: 'POST',
            url: "<?= base_url('background/getBulkSmsRemains') ?>",
            data: {type: 'sms'},
            dataType: "html",
            success: function (data) {
                $('#message_left_count').html(data);
            }
        });
    }
    buy_sms = function () {
        $('#buy_sms_btn').mousedown(function () {
            var number_of_sms = $('#number_of_sms').val();
            $.ajax({
                type: 'POST',
                url: "<?= base_url('background/createReference') ?>",
                data: {number_of_sms: number_of_sms, type: 'sms'},
                dataType: "html",
                success: function (data) {
                    $('#buy_sms_content').html(data);
                }
            });
        });
    }
    $(document).ready(buy_sms);
    $('#classesID').change(function (event) {
        var classesID = $(this).val();
        if (classesID === '0') {
            $('#load_section').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('student/sectioncall') ?>",
                data: "id=" + classesID,
                dataType: "html",
                success: function (data) {
                    $('#sectionID').html(data);
                }
            });
        }
    });

    $('#student_type').change(function (event) {
        var types = $(this).val();
        if (types === '0') {
            $('#load_types').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('mailandsms/loadtypes') ?>",
                data: "type=" + types,
                dataType: "html",
                success: function (data) {
                    $('#load_types').html(data);
                }
            });
        }
    });

    function setFirstCriteria(value) {

        switch (value) {

            case '00':
                $('#parents_selection').show();
                $('#load_classes,#load_section,#load_student_types,#load_payment_status,#load_types,#teachers_selection,#teachersCat,#teachersPhones').hide();
                break;
            case '01':
                $('#load_classes,#load_section,#load_types,#load_student_types,#load_payment_status,#category6,#category8,#account_tags,#parents_selection').hide();
                $('#teachers_selection').show();
                break;
            case '02':
                $('#load_classes,#load_section,#load_types,#load_student_types,#load_payment_status,#category6,#category8,#account_tags,#parents_selection,#teachers_selection').hide();
                $('#custom_number_selection').show();
                break;

            default:

                //document.getElementById('category').style.display = "block";
                break;
        }
    }

    function setTeachersCriteria(value) {

        switch (value) {
            case '001':

                break;
            case '002':
                $('#load_classes,#load_section').show();
                break;

            case '003':
                $('#teachersCat').show();
                $('#load_classes,#load_section').hide();
                break;

            case '09':
                $('#teachersPhones').hide();
                $('#teachersNames').show();
                break;
            case '010':
                $('#teachersPhones').show();
                $('#teachersNames').hide();
                break;

            default:

                //document.getElementById('category').style.display = "block";
                break;
        }
    }

    function setCriteria(value1) {
        switch (value1) {

            case '':
                $('#load_classes,#load_section,#load_student_types,#load_payment_status,#category6,#category8,#account_tags').hide();

                break;
            case '0':
                $('#load_classes,#load_section,#category6,#category8,#load_hostel').hide();
                //var items = ["", "Male", "Female", "All"];
                //push_options(items);
                break;
            case '1':
                $('#load_fees,#load_payment_status,#load_types,#category6,#category7,#category8,#load_hostel,#load_transport').hide();
                $('#load_payment_status,#account_tags,#load_payment_amount').hide();
                $('#load_classes,#load_section').show();
                break;
            case '2':
                $('#load_payment_status,#load_classes,#load_section,#category6,#category8').hide();

                $('#load_payment_status,#load_types,#load_section').hide();
                $('#load_payment_status,#account_tags,#load_payment_amount,#load_transport,#load_hostel').hide();
                $('#load_fees,#load_classes').show();
                break;
            case '3':
                $('#load_fees,#load_classes,#load_section,#load_fees,#load_types,#category6,#category8,#load_transport,#load_hostel').hide();
                $('#load_payment_status,#account_tags,#load_payment_amount').show();
                break;
            case '4':
                $('#load_classes,#load_section,#load_hostel,#load_fees,#load_payment_status,#load_types,#load_transport').hide();
                $('#category').hide();
                $('#category1').hide();
                $('#category3').hide();
                $('#category2').hide();
                $('#category4').hide();
                $('#category5').hide();
                $('#category6').show();
                $('#category7').hide();
                break;

            case '5':
                $('#category').hide();
                $('#category1').hide();
                $('#category2').hide();
                $('#category3').show();
                $('#category4').hide();
                $('#load_transport').show();
                $('#category6').hide();
                $('#category7').hide();
                $('#load_classes,#load_section,#load_student_types,#load_payment_status,#load_types').hide();
                $('#load_payment_status,#load_fees,#account_tags,#load_payment_amount,#load_hostel').hide();
                $('#category8').hide();
                break;

            case '6':
                $('#category').hide();
                $('#category1').hide();
                $('#category2').hide();
                $('#category3').show();
                $('#category4').hide();
                $('#load_hostel').show();
                $('#category6').hide();
                $('#category7').hide();
                $('#load_classes,#load_section,#load_student_types,#load_payment_status,#load_types').hide();
                $('#load_payment_status,#account_tags,#load_payment_amount,#load_transport').hide();
                $('#category8').hide();
                break;
            case '7':
                $('#category,#load_transport,#load_hostel').hide();
                $('#category1').hide();
                $('#category2').hide();
                $('#category3').hide();
                $('#category4').show();
                $('#category5').hide();
                $('#category6').hide();
                $('#category7').hide();
                $('#category8').hide();
                break;

            case '8':
                $('#category,#load_transport,#load_hostel').hide();
                $('#category1').hide();
                $('#category2').show();
                $('#category3').hide();
                $('#category4').hide();
                $('#category5').hide();
                $('#category6').hide();
                $('#category7').hide();
                $('#category8').hide();
                // var items = ["", "Healthy", "Eye problem", ""];
                // push_options(items);
                break;
            case '9':
                $('#category,#load_transport,#load_hostel').hide();
                $('#category1').hide();
                $('#category2').hide();
                $('#category3').hide();
                $('#category4').hide();
                $('#category5').hide();
                $('#category7').show();
                $('#category8').hide();

                break;
            case '10':
                $('#category,#load_transport,#load_hostel').hide();
                $('#category1').hide();
                $('#category2').hide();
                $('#category3').hide();
                $('#category4').hide();
                $('#category5').hide();
                $('#category8').show();
                $('#category7').hide();



                break;

            default:

                //document.getElementById('category').style.display = "block";
                break;
        }
    }
    word_count = function () {
        $('#content_area').keyup(function () {
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
    $('#amount').change(function (event) {
        var num = $this.val().replace(/(\s)/g, '');
        $this.val(num.replace(/(\d)(?=(\d{3})+(?!\d))/g, ","));
    });

</script>

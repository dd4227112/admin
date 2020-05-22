@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-title">
            <h4>Dashboard</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Pages</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Inputs Validation start -->
            <div class="card">
                <div class="card-header">
                    <h5>Basic Inputs Validation</h5>
                    <span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-refresh"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <form id="main" method="post" action="http://flatable.phoenixcoded.net/" novalidate="">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Simple Input</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Text Input Validation">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row has-success">
                            <label class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password input">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Repeat Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="repeat-password" name="repeat-password" placeholder="Repeat Password">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row has-success">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter valid e-mail address">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">Radio Buttons</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="gender" id="gender-1" value="option1"> Male
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="gender" id="gender-2" value="option2"> Female
                                    </label>
                                </div>
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Basic Inputs Validation end -->
            <!-- Tooltip Validation card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Tooltip Validation</h5>
                    <span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-refresh"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <form id="second" action="http://flatable.phoenixcoded.net/" method="post" novalidate="">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Enter Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="usernameP" name="Username" placeholder="Enter Username">
                                <span class="messages popover-valid"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Enter Email-id</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="EmailP" name="Email" placeholder="Enter email id">
                                <span class="messages popover-valid"></span>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Tooltip Validation card end -->
            <!-- Number Validation card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Number Validation</h5>
                    <span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-refresh"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <form id="number_form" action="http://flatable.phoenixcoded.net/" method="post" novalidate="">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Integers Only</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="integer" id="integer" placeholder="Integers Only">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Numbers Only</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="numeric" id="numeric" placeholder="Numbers Only">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Greater number</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Number" id="greater" placeholder="Number Greter than 50">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Less number</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Numbers" id="less" placeholder="Number Less than 50">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Number Validation card end -->
            <!-- Form components Validation card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form components Validation</h5>
                    <span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-refresh"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <form id="checkdrop" action="http://flatable.phoenixcoded.net/" method="post" novalidate="">
                        <div class="form-group row">
                            <label class="col-sm-2">Radio Buttons</label>
                            <div class="col-sm-10">
                                <div class="form-radio">
                                    <div class="radio radiofill radio-primary radio-inline">
                                        <label>
                                            <input type="radio" name="member" value="free" data-bv-field="member">
                                            <i class="helper"></i>Select here
                                        </label>
                                    </div>
                                    <div class="radio radiofill radio-primary radio-inline">
                                        <label>
                                            <input type="radio" name="member" value="personal" data-bv-field="member">
                                            <i class="helper"></i>Another select
                                        </label>
                                    </div>
                                </div>
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Select Checkbox</label>
                            <div class="col-sm-10">
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input type="checkbox" id="checkbox" name="Language" value="HTML">
                                        <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                        </span>
                                        <span>HTML</span>
                                    </label>
                                </div>
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input type="checkbox" id="checkbox2" name="Language" value="CSS">
                                        <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                        </span>
                                        <span>CSS</span>
                                    </label>
                                </div>
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Form components Validation card end -->
        </div>
    </div>
</div>
</div>
<script type="text/javascript">

    $('#level').change(function (event) {

        var class_level_id = $(this).val();
        if (class_level_id === '0') {
            $('#level_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('academicyear/call_next_year') ?>",
                data: "class_level_id=" + class_level_id,
                dataType: "html",
                success: function (data) {

                    $('#academic_id').html(data);
                }
            });
        }
    });
    custom_to_id = function () {
        $('#custom_to_id').change(function () {
            var id = $(this).val();
            if (id == 3) {
                $('#custom_to_amount_id').show();
            } else {
                $('#custom_to_amount_id').hide();
            }
        });
    },
            $(document).ready(custom_to_id);
    document.getElementById("uploadBtn").onchange = function () {
        document.getElementById("uploadFile").value = this.value;
    };
    set_system_deadline = function () {
        var form = $('#set_pay_id').serialize();
        $.ajax({
            type: 'POST',
            url: "<?= url('setting/system_deadline') ?>",
            data: {formdata: form},
            dataType: "html",
            success: function (data) {

                swal('success', data, 'success');
                //window.location.reload();

            }
        });
    };


    add_year = function () {
        var form = $('#academic_year').serialize();
        $.ajax({
            type: 'POST',
            url: "<?= url('setting/academic_year') ?>",
            data: {formdata: form},
            dataType: "html",
            success: function (data) {

                swal('success', data, 'success');

            }
        });
    };




    transfer_account_setting = function () {
        var form = $('#accounting_id').serialize();
        $.ajax({
            type: 'POST',
            url: "<?= url('setting/account_setting') ?>",
            data: {formaccountdata: form},
            dataType: "html",
            success: function (data) {
                console.log(data);
                if (data == '1') {
                    // window.location.reload();
                    swal('success', data, 'success');
                } else {
                    swal('warning', data, 'warning');
                }
            }
        });
    }
    var type = window.location.hash.substr(1);
    $('.tab-pane').removeClass('active');
    $('#' + type).addClass('active');
    $('.tabs-left li a').mousedown(function () {
        var id = $(this).attr('href');
        window.location.hash = id;
    });
    replaceEmptyMark = function (empty_mark) {
        var form = $('#report_setting').serialize();
        $.ajax({
            type: 'POST',
            url: "<?= url('setting/replace_empty_mark') ?>",
            data: {'empty_mark': empty_mark},
            dataType: "html",
            success: function (data) {

                $('#replace_mark').html(JSON.parse(data).empty_mark);
            }
        });
    }
</script>
@endsection
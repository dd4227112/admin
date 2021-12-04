<?php $root = url('/') . '/public/' ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>ShuleSoft Events</title>
  
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="">
        <meta name="keywords" content=", Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
        <meta name="author" content="">
        <!-- Favicon icon -->

        <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

        <!-- Required Jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" />

        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- themify-icons line icon -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/icon/themify-icons/themify-icons.css">
        <!-- ico font -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/icon/icofont/css/icofont.css">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/style.css?v=2">
        <link rel="stylesheet" href="https://intl-tel-input.com/node_modules/intl-tel-input/examples/css/prism.css">
        <link rel="stylesheet" href="https://intl-tel-input.com/node_modules/intl-tel-input/build/css/intlTelInput.css?1613236686837">
        <link rel="stylesheet" href="https://intl-tel-input.com/node_modules/intl-tel-input/examples/css/prism.css">
        <link rel="stylesheet" href="https://intl-tel-input.com/node_modules/intl-tel-input/examples/css/isValidNumber.css?1613236686837">

        <script src="https://intl-tel-input.com/node_modules/intl-tel-input/examples/js/prism.js"></script>
        <script src="https://intl-tel-input.com/node_modules/intl-tel-input/build/js/intlTelInput.js?1613236686837"></script>
        <style>
            .select2-container--default .select2-selection--single {
                height: 46px !important;
                padding: 10px 16px;
                font-size: 18px;
                line-height: 1.33;
                border-radius: 6px;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow b {
                top: 85% !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 26px !important;
            }
            .select2-container--default .select2-selection--single {
                border: 1px solid #CCC !important;
                box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
                transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
            }
        </style>
    </head>
    <body class="fix-menu" style="overflow-y:auto; height: auto;">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header ">
                                    <h1 class="text-center" style="color: black; font-weight: bold;">
                                        <img src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="logo.png" width="80" height="80">
                                    </h1>
                                    <h4 class="text-center"><b>{{ $event->title }}</b></h4>

                                </div>
                                <form class="form-group" id="loginform" method="POST" action="<?= url('/addregister') ?>" >
                                    <div class="modal-body">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <div class="col-sm-12 col-xs-12">
                                                Your Fullname
                                                <input type="text" name="name" class="form-control" placeholder="Enter your full name here..."  value="{{ old('email') }}" autofocus required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Whatsapp Phone number
                                                        <input id="phone" class="form-control" type="tel" name = "phone"   id="login-email"  placeholder="" value="" required>
                                                        <span id="valid-msg" class="hide">✓ Valid</span>
                                                        <span id="error-msg" class="hide"></span>
                                                        <input type="hidden" value="" name="country_code" id="country_code"/>
                                                        <input type="hidden" value="" name="country_name" id="country_name"/>
                                                        <input type="hidden" value="" name="country_abbr" id="country_abbr"/>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12 col-xs-12">
                                                Your Position
                                                <input type="text" name="position" class="form-control" placeholder="Enter your position here eg. Teacher" value="{{ old('position') }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12 col-xs-12">
                                                Your School / Organization
                                                <input type="text" name="school_id" class="form-control" placeholder="Enter your School name here.." value="{{ old('school_id') }}" required>
                                                <!--
                                                                        <select name="school_id" class="form-control select2-container step2-select" data-placeholder="Select Gender" required>
                                                                          <option value="1">Search Your School Here....</option>
                                                <?php
                                                $schools = DB::table('schools')->where('ownership', 'Non-Government')->get();
                                                foreach ($schools as $school) {
                                                    ?>
                                                                                                <option value="<?= $school->id ?>"><?php // $school->name. ' (<b> '.$school->type. ' </b>) - '. $school->wards->district->region->name      ?></option>
                                                <?php } ?>
                                          
                                                                        </select> -->
                                            </div>
                                        </div>



                                        <div class="form-group ">
                                            <div class="col-sm-12 col-xs-12">
                                                How did you hear about this event?
                                                <select name="source" id="source" class="form-control" required>
                                                    <option value="whatsapp">Whatsapp</option>
                                                    <option value="Phone Call">Phone Call</option>
                                                    <option value="NMB Bank">NMB Bank</option>
                                                    <option value="message">Message(sms)</option>
                                                    <option value="friend">Friend (Referral from other schools)</option>
                                                    <option value="radio">Radio</option>
                                                    <option value="internet search">Internet Search</option>
                                                    <option value="linkedin">LinkedIn</option>
                                                    <option value="facebook">Facebook</option>
                                                    <option value="instagram">Instagram</option>
                                                    <option value="others">Others</option>
                                                </select>
                                                <input type="hidden" name="event_id" value="<?= $event->id ?>">

                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="checkbox-fade fade-in-primary">
                                                    <label>
                                                        <input type="checkbox" name="status" value="1">
                                                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                        <span class="text-inverse">Do you Want to Receive Update of this Workshop*</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Submit Here</button>
                                    </div>
                                    <?= csrf_field() ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Authentication card end -->
        </div>
        <!-- end of col-sm-12 -->
        <script>

validate_phone = function () {
    var input = document.querySelector("#phone"),
            errorMsg = document.querySelector("#error-msg"),
            validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
    var iti = window.intlTelInput(input, {
        utilsScript: "https://intl-tel-input.com/node_modules/intl-tel-input/build/js/utils.js?1613236686837",
        preferredCountries: ['tz'],
    });

    var reset = function () {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };

// on blur: validate
    input.addEventListener('blur', function () {
        reset();
        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                validMsg.classList.remove("hide");
            } else {
                input.classList.add("error");
                var errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
            }
            var countryData = iti.getSelectedCountryData();
            // console.log(countryData);
            $("#country_code").val(countryData.dialCode);
            $("#country_name").val(countryData.name);
            $("#country_abbr").val(countryData.iso2);
        }
    });

// on keyup / change flag: reset
    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);
}
$(document).ready(validate_phone);
        </script>

    </body>
</html>

<?php $root = url('/') . '/' ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>ShuleSoft Admin Panel</title>
        <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
          <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="Phoenixcoded">
        <meta name="keywords" content=", Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
        <meta name="author" content="Phoenixcoded">
        <!-- Favicon icon -->

        <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
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

    </head>

    <body class="fix-menu">
        <section class="login p-fixed d-flex text-center bg-primary common-img-bg">
            <!-- Container-fluid starts -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Authentication card start -->
                        <div class="login-card card-block auth-body">
                            @include('layouts.notifications')

                            <?php if (preg_match('/reset/i', url()->current())) { ?>

                                <form class="md-float-material" role="form" method="POST" action="{{ route('password.email') }}">
                                    {{ csrf_field() }}
                                    <div class="auth-box">
                                    <div class="row m-b-20">
                                            <div class="col-md-12">
                                            <div class="text-center">
                                        <img src="<?= $root ?>images/shulesoft_logo.png" alt="logo.png" width="70px">
                                    </div>
                                                <small style="color:black; text-align: center">ShuleSoft Administration Panel</small>
                                                <h3 style ="font-size:18px;margin-bottom:0px;" class="text-left txt-primary">Reset Password</h3>
                                            </div>
                                        </div>
                                        <p class="text-inverse b-b-default text-right">Back to <a href="<?= url('/') ?>">Login.</a></p>
                                        @if (session('status'))
                                        <div class="row m-b-20">
                                            <div class="col-md-12">
                                                <div class="alert alert-success">
                                                   <strong> {{ session('status') }}</strong>
                                                </div>

                                                </div>
                                         </div>
                                         @endif
                                         @if ($errors->has('email'))
                                         <div class="row m-b-20">
                                            <div class="col-md-12">
                                                <div class="alert alert-danger">
                                                <strong>{{ $errors->first('email') }}</strong>
                                                </div>
                                            </div>
                                            </div>
                                        @endif
   
                                        <div class="input-group">
                                            <input type="email" name="email" class="form-control" placeholder="Your Email Address"  value="{{ old('email') }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Reset and send me a new Password</button>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <p class="text-inverse text-left m-b-0">Credentials are only provided by Administrator</p>
                                                <p class="text-inverse text-left"></p>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            <?php } else { ?>  
                                <form class="md-float-material" id="loginform" method="POST" action="{{ route('login') }}" >
                                    {{ csrf_field() }}

                                    <div class="auth-box">
                                        <div class="row m-b-20">
                                            <div class="col-md-12">
                                            <div class="text-center">
                                        <img src="<?= $root ?>images/shulesoft_logo.png" alt="logo.png" width="70px">
                                    </div>
                                                <small style="color:black; text-align: center">ShuleSoft Administration Panel</small>
                                                <h3 style ="font-size:18px;" class="text-left txt-primary">Sign In</h3>
                                            </div>
                                        </div>
                                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong class="alert alert-danger">{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong class="alert alert-danger">{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                        <hr/>
                                        <div class="input-group ">
                                            <input type="email" name="email" class="form-control" placeholder="Your Email Address" value="{{ old('email') }}">
                                            <span class="md-line"></span>

                                        </div>
                                        <div class="input-group ">
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                            <span class="md-line"></span>

                                        </div>


                                        <div class="row m-t-25 text-left">
                                            <div class="col-sm-7 col-xs-12">
                                                <div class="checkbox-fade fade-in-primary">
                                                    <label>
                                                        <input type="checkbox" value="">
                                                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                        <span class="text-inverse">Remember me</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-5 col-xs-12 forgot-phone text-right">
                                                <a href="{{ route('password.request') }}"  class="text-right f-w-600 text-inverse"> Forgot Your Password?</a>
                                            </div>
                                        </div>
                                        <div class="row m-t-30">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign in</button>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <p class="text-inverse text-left m-b-0">Credentials are only provided by Administrator</p>
                                                <p class="text-inverse text-left"></p>
                                            </div>
                                            <div class="col-md-2">
                                                <!-- <img src="<?= $root ?>images/shulesoft_logo.png" alt="small-logo.png" width="30" height="30"> -->
                                            </div>
                                        </div>

                                    </div>
                                </form>
                                <!-- end of form -->
                            <?php } ?>

                        </div>
                        <!-- Authentication card end -->
                    </div>
                    <!-- end of col-sm-12 -->
                </div>
                <!-- end of row -->
            </div>
            <!-- end of container-fluid -->
        </section>
        <!-- Warning Section Starts -->
        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
        <div class="ie-warning">
        <h1>Warning!!</h1>
        <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
        <div class="iew-container">
        <ul class="iew-download">
        <li>
        <a href="http://www.google.com/chrome/">
        <img src="assets/images/browser/chrome.png" alt="Chrome">
        <div>Chrome</div>
        </a>
        </li>
        <li>
        <a href="https://www.mozilla.org/en-US/firefox/new/">
        <img src="assets/images/browser/firefox.png" alt="Firefox">
        <div>Firefox</div>
        </a>
        </li>
        <li>
        <a href="http://www.opera.com">
        <img src="assets/images/browser/opera.png" alt="Opera">
        <div>Opera</div>
        </a>
        </li>
        <li>
        <a href="https://www.apple.com/safari/">
        <img src="assets/images/browser/safari.png" alt="Safari">
        <div>Safari</div>
        </a>
        </li>
        <li>
        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
        <img src="assets/images/browser/ie.png" alt="">
        <div>IE (9 & above)</div>
        </a>
        </li>
        </ul>
        </div>
        <p>Sorry for the inconvenience!</p>
        </div>
        <![endif]-->
        <!-- Warning Section Ends -->
        <!-- Required Jquery -->
        <script type="text/javascript" src="<?= $root ?>bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/tether/dist/js/tether.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- jquery slimscroll js -->
        <script type="text/javascript" src="<?= $root ?>bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>
        <!-- modernizr js -->
        <script type="text/javascript" src="<?= $root ?>bower_components/modernizr/modernizr.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/modernizr/feature-detects/css-scrollbars.js"></script>
        <!-- i18next.min.js -->
        <script type="text/javascript" src="<?= $root ?>bower_components/i18next/i18next.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/jquery-i18next/jquery-i18next.min.js"></script>
        <!-- Custom js -->
        <script type="text/javascript" src="<?= $root ?>assets/js/script.js"></script>
    </body>
</html>


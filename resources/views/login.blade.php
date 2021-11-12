<?php $root = url('/') . '/public/' ?>
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

        <style>
            .brand-wrapper {
  padding-top: 7px;
  padding-bottom: 8px; }
  .brand-wrapper .logo {
    height: 25px; }

.login-section-wrapper {
  display: -webkit-box;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
          flex-direction: column;
  padding: 68px 100px;
  background-color: #fff; }
  @media (max-width: 991px) {
    .login-section-wrapper {
      padding-left: 50px;
      padding-right: 50px; } }
  @media (max-width: 575px) {
    .login-section-wrapper {
      padding-top: 20px;
      padding-bottom: 20px;
      min-height: 100vh; } }

.login-wrapper {
  width: 300px;
  max-width: 100%;
  padding-top: 24px;
  padding-bottom: 24px; }
  @media (max-width: 575px) {
    .login-wrapper {
      width: 100%; } }
  .login-wrapper label {
    font-size: 14px;
    font-weight: bold;
    color: #b0adad; }
  .login-wrapper .form-control {
    border: none;
    border-bottom: 1px solid #e7e7e7;
    border-radius: 0;
    padding: 9px 5px;
    min-height: 40px;
    font-size: 18px;
    font-weight: normal; }
    .login-wrapper .form-control::-webkit-input-placeholder {
      color: #b0adad; }
    .login-wrapper .form-control::-moz-placeholder {
      color: #b0adad; }
    .login-wrapper .form-control:-ms-input-placeholder {
      color: #b0adad; }
    .login-wrapper .form-control::-ms-input-placeholder {
      color: #b0adad; }
    .login-wrapper .form-control::placeholder {
      color: #b0adad; }
  .login-wrapper .login-btn {
    padding: 13px 20px;
    background-color: #fdbb28;
    border-radius: 0;
    font-size: 20px;
    font-weight: bold;
    color: #fff;
    margin-bottom: 14px; }
    .login-wrapper .login-btn:hover {
      border: 1px solid #fdbb28;
      background-color: #fff;
      color: #fdbb28; }
  .login-wrapper a.forgot-password-link {
    color: #080808;
    font-size: 14px;
    text-decoration: underline;
    display: inline-block;
    margin-bottom: 54px; }
    @media (max-width: 575px) {
      .login-wrapper a.forgot-password-link {
        margin-bottom: 16px; } }
  .login-wrapper-footer-text {
    font-size: 16px;
    color: #000;
    margin-bottom: 0; }

.login-title {
  font-size: 30px;
  color: #000;
  font-weight: bold;
  margin-bottom: 25px; }

.login-img {
  width: 100%;
  height: 100vh;
  -o-object-fit: cover;
     object-fit: cover;
  -o-object-position: left;
     object-position: left; }
        </style>
    </head>

    <body class="fix-menu">
        <main>
    <div class="container-fluid">
      <div class="row">

      <div class="col-sm-6 px-0 d-none d-sm-block ">
          <img src="assets/images/login.jpg" alt="login image" class="login-img">
        </div>

        <div class="col-sm-6 login-section-wrapper">
          <div class="brand-wrapper">
          <img src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="logo.png" width="70" height="70">
          </div>
          <div class="login-wrapper my-auto">
          <div class="row m-b-20">
                                            <div class="col-md-12">
                                                <small style="color:black; text-align: center">ShuleSoft Administration Panel</small>
                                                <h3 class="text-left txt-primary login-title">Sign In</h3>
                                            </div>
                                        </div>
            @include('layouts.notifications')
            
<?php if (preg_match('/reset/i', url()->current())) { ?>
    
            <form class="md-float-material" role="form" method="POST" action="{{ route('password.email') }}">
                                    {{ csrf_field() }}

                                  
                                    <div class="auth-box">
                                        <div class="row m-b-20">
                                            <div class="col-md-12">
                                                <h3 class="text-center">Reset Your Password </h3>

                                            </div>
                                        </div>
                                        <p class="text-inverse b-b-default text-right">Back to <a href="<?= url('/') ?>">Login.</a></p>
   
                                        <div class="input-group">
                                            <input type="email" name="email" class="form-control" placeholder="Your Email Address"  value="{{ old('email') }}">
                                          
                                            @if ($errors->has('email'))
                                            <br/> <br/>
                                            <span class="help-block" style="color: red;">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
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
                                            <div class="col-md-2">
                                                <img src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="small-logo.png" width="30" height="30">
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            <?php } else { ?>  
                                <form class="" id="loginform" method="POST" action="{{ route('login') }}" >
                                    {{ csrf_field() }}

                                    
                                    <div class="">
                                        
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
                                        <div class="form-group ">
                                        <label for="email">Email</label>
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
                                                <img src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="small-logo.png" width="30" height="30">
                                            </div>
                                        </div>

                                    </div>
                                </form>
                                <!-- end of form -->
                            <?php } ?>
            <a href="#!" class="forgot-password-link">Forgot password?</a>
            <p class="login-wrapper-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>
          </div>
        </div>
        
      </div>
    </div>
  </main>
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


<!DOCTYPE html>
<?php $root = url('/') . '/' ?>
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
    <style>
        label{ color: black}
    </style>
    <?php $root = url('/') . '/' ?>
    <body class="fix-menu">
        <section class="login p-fixed d-flex text-center bg-primary common-img-bg">
            <!-- Container-fluid starts -->
            <div class="container-fluid" >
                <div class="row">
                <div class="col-sm-4"></div>
                    <div class="col-sm-4" style="background-color:white;border-radius:10px;">
                        <!-- Authentication card start -->
                        <div class="login-card card-block auth-body">
                            <div class="container">
                             <div class="card-body" >
                             <div class="row">
                                            <div class="col-md-11">
                                            <div class="text-center">
                                        <img src="<?= $root ?>/images/shulesoft_logo.png" alt="logo.png" width="70px">
                                    </div>
                                                <small style="color:black; text-align: center">ShuleSoft Administration Panel</small>
                                                <h3 style ="font-size:18px;margin-bottom:0px;" class="text-left txt-primary">Setup New Password</h3>
                                                <hr/>
                                            </div>
                                             <hr/>
                                        </div>
                                       
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">                            
                            <div class="col-md-10">
                                <input id="email" style="border-radius:5px;" placeholder="Enter your email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-10">
                                <input id="password" style="border-radius:5px;" placeholder="New Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback text-danger" role="alert" >
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-10">
                                <input id="password-confirm"style="border-radius:5px;" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-12">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                                
                            </div>
                            
                        </div>
                
                    </form>
                    
                    <div class="row">
                                            <div class="col-md-10">
                                            <hr/>
                                                <p class="text-inverse text-left m-b-0">Credentials are only provided by Administrator</p>
                                                <p class="text-inverse text-left"></p>
                                            </div>
                                            <div class="col-md-2">
                                                <!-- <img src="<?= $root ?>images/shulesoft_logo.png" alt="small-logo.png" width="30" height="30"> -->
                                            </div>
                                        </div>
                </div>
                         
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
            </div>
        </section>
    </body>



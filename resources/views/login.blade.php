<!DOCTYPE html>  
<html lang="en">
    <head>
        <?php $root = url('/') . '/public/' ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= $root ?>images/ShuleSoft-TM.png">
        <title>ShuleSoft Admin Panel</title>
        <!-- Bootstrap Core CSS -->
        <link href="<?= $root ?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- animation CSS -->
        <link href="<?= $root ?>css/animate.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?= $root ?>css/style.css" rel="stylesheet">
        <!-- color CSS -->
        <link href="<?= $root ?>css/colors/default.css" id="theme"  rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <!-- Preloader -->
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <section id="wrapper" class="new-login-register">
            <div class="lg-info-panel">
                <div class="inner-panel">

                    <div class="lg-content">
                        <h2>ShuleSoft Admin Panel</h2>
                        <p class="text-muted">Important area to generate and manage statistics, growth, analysis, and provide customer support. This system is for ShuleSoft staff, Marketing agencies, Partners, Investors and Shareholders</p>

                    </div>
                </div>
            </div>
            <div class="new-login-box">
                <a href="javascript:void(0)">
                    <img src="<?= $root ?>images/ShuleSoft-TM.png" width="50%" height="50%"></a>
                <div class="white-box">
                    <h3 class="box-title m-b-0">Sign In to Admin</h3>
                    <small>Enter your details below</small>
                    @include('layouts.notifications')
                    <form class="form-horizontal new-lg-form" id="loginform" method="POST" action="{{ route('login') }}" >
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} m-t-20">
                            <div class="col-xs-12">
                                <label>Email Address</label>
                                <input class="form-control" type="text" required=""  name="email" value="{{ old('email') }}" >
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label>Password</label>
                                <input class="form-control" type="password" required="" placeholder="Password" name="password">

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox checkbox-info pull-left p-t-0">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup"> Remember me </label>
                                </div>
                                <a href="{{ route('password.request') }}" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">Log In</button>
                            </div>
                        </div>

                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                <p>Don't have an account? <a href="#" class="text-primary m-l-5" alt="default" data-toggle="modal" data-target="#myModal"><b>Contact Your Administrator</b></a></p>
                            </div>

                        </div>
                    </form>
                    <form class="form-horizontal" id="recoverform" action="https://wrappixel.com/ampleadmin/ampleadmin-html/ampleadmin-minimal/index.html">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>Recover Password</h3>
                                <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>            


        </section>
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">System Administrator</h4> </div>
                    <div class="modal-body">
                        <h4>To be able to login, your administrator needs to create an account for you</h4>
                        <p>If you don't know your administrator, please call +255655406004 or +255 22278 0228. <br/>Thanks.</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- jQuery -->
        <script src="<?= $root ?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="<?= $root ?>bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- Menu Plugin JavaScript -->
        <script src="<?= $root ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

        <!--slimscroll JavaScript -->
        <script src="<?= $root ?>js/jquery.slimscroll.js"></script>
        <!--Wave Effects -->
        <script src="<?= $root ?>js/waves.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="<?= $root ?>js/custom.min.js"></script>
        <!--Style Switcher -->
        <script src="<?= $root ?>plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    </body>
</html>

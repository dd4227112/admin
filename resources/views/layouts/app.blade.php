<!DOCTYPE html>
<?php $root = url('/') . '/public/' ?>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <title>{{ config('app.name', 'ShuleSoft') }}</title>

        <script src="<?= $root ?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <link href="<?= $root ?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Menu CSS -->
        <link href="<?= $root ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <!-- toast CSS -->
        <link href="<?= $root ?>plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
        <!-- morris CSS -->
        <link href="<?= $root ?>plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
        <!-- chartist CSS -->
        <link href="<?= $root ?>plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
        <link href="<?= $root ?>plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
        <!-- Calendar CSS -->
        <link href="<?= $root ?>plugins/bower_components/calendar/dist/fullcalendar.css" rel="stylesheet" />
        <!-- animation CSS -->
        <link href="<?= $root ?>css/animate.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?= $root ?>css/style.css" rel="stylesheet">
        <!-- color CSS -->
        <link href="<?= $root ?>css/colors/default.css" id="theme" rel="stylesheet">
        <link href="<?= $root ?>plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $root ?>plugins/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
        <script src="<?= $root ?>plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?= $root ?>plugins/bower_components/jsgrid/dist/jsgrid.min.css" />
        <link type="text/css" rel="stylesheet" href="<?= $root ?>plugins/bower_components/jsgrid/dist/jsgrid-theme.min.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var root_url = "<?= url('/'); ?>";
        </script>
        <style>
            #valid-msg {
                color: #00C900;
            }
            #error-msg {
                color: red;
            }
        </style>
    </head>
    <body class="fix-header">
        @if (!Auth::guest())  
        <div class="preloader" style="display: none;">
            <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle> 
            </svg>
        </div>
        <div id="wrapper">

            <nav class="navbar navbar-default navbar-static-top m-b-0">
                <div class="navbar-header">
                    <div class="top-left-part">
                        <!-- Logo -->
                        <a class="logo" href="{{url('home')}}">
                            <!-- Logo icon image, you can use font-icon also --><b>
                                <!--This is dark logo icon--><img src="<?= $root ?>images/ShuleSoft-TM.png" alt="home" class="dark-logo"><!--This is light logo icon-->
                            </b>
                            <!-- Logo text image you can use text also --><span class="hidden-xs">
                                <!--This is dark logo text--><!--This is light logo text--><img src="<?= $root ?>images/ShuleSoft-TM.png" height="40" alt="home" class="light-logo">
                            </span> </a>
                    </div>
                    <!-- /Logo -->
                    <!-- Search input and Toggle icon -->

                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="javascript:void(0)" class="open-close waves-effect waves-light" onmousedown="$('body').toggleClass('show-sidebar hide-sidebar')"><i class="ti-menu"></i></a></li>
                        <?php
                        $feedbacks = \App\Model\Feedback::where('opened', 1)->get();
                        ?>
                        <?php if (can_access('manage_messages')) { ?>     
                            <li class="dropdown">
                                <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i class="mdi mdi-gmail"></i>&nbsp;&nbsp;&nbsp;&nbsp;<b class="badge badge-danger"><?= count($feedbacks) ?></b>
                                    <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                                </a>
                                <ul class="dropdown-menu mailbox animated bounceInDown">
                                    <li>
                                        <div class="drop-title">You have <?= count($feedbacks) ?> new messages</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <?php
                                            $f = 1;
                                            foreach ($feedbacks as $feedback) {
                                                if ($f == 5)
                                                    break;
                                                //  $user=\DB::table($feedback->schema.$feedback->table)->where($feedback->table.'ID',$feedback->user_id)->first();
                                                ?>
                                                <a href="#">
                                                    <div class="user-img"> <img src="<?= url('storage/uploads/images/' . Auth::user()->photo) ?>" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                                    <div class="mail-contnet">
                                                        <h5><?php //count($user)==1 ? $user->name: ''  ?></h5>
                                                        <span class="mail-desc"><?= $feedback->feedback ?></span>
                                                        <span class="time"><?= timeAgo($feedback->created_at) ?></span> </div>
                                                </a>
                                                <?php $f++;
                                            }
                                            ?>

                                        </div>
                                    </li>
                                    <li>
                                        <a class="text-center" href="{{url('message/feedback')}}"> <strong>See all feedbacks</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                                <!--/.dropdown-messages--> 
                            </li>
<?php } ?>
                        <!-- .Task dropdown -->
                        <!--                                              <li class="dropdown">
                                                                            <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i class="mdi mdi-check-circle"></i>
                                                                                <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                                                                            </a>
                                                                            <ul class="dropdown-menu dropdown-tasks animated slideInUp">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <div>
                                                                                            <p> <strong>Task 1</strong> <span class="pull-right text-muted">40% Complete</span> </p>
                                                                                            <div class="progress progress-striped active">
                                                                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="divider"></li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <div>
                                                                                            <p> <strong>Task 2</strong> <span class="pull-right text-muted">20% Complete</span> </p>
                                                                                            <div class="progress progress-striped active">
                                                                                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%"> <span class="sr-only">20% Complete</span> </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="divider"></li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <div>
                                                                                            <p> <strong>Task 3</strong> <span class="pull-right text-muted">60% Complete</span> </p>
                                                                                            <div class="progress progress-striped active">
                                                                                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"> <span class="sr-only">60% Complete (warning)</span> </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="divider"></li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <div>
                                                                                            <p> <strong>Task 4</strong> <span class="pull-right text-muted">80% Complete</span> </p>
                                                                                            <div class="progress progress-striped active">
                                                                                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"> <span class="sr-only">80% Complete (danger)</span> </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="divider"></li>
                                                                                <li>
                                                                                    <a class="text-center" href="#"> <strong>See All Tasks</strong> <i class="fa fa-angle-right"></i> </a>
                                                                                </li>
                                                                            </ul>
                                                                        </li>-->
                        <!-- .Megamenu -->
<!--                       <li class="mega-dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><span class="hidden-xs">Mega</span> <i class="icon-options-vertical"></i></a>
                            <ul class="dropdown-menu mega-dropdown-menu animated bounceInDown">
                                <li class="col-sm-3">
                                    <ul>
                                        <li class="dropdown-header">Forms Elements</li>
                                        <li><a href="form-basic.html">Basic Forms</a></li>
                                        <li><a href="form-layout.html">Form Layout</a></li>
                                        <li><a href="form-advanced.html">Form Addons</a></li>
                                        <li><a href="form-material-elements.html">Form Material</a></li>
                                        <li><a href="form-float-input.html">Form Float Input</a></li>
                                        <li><a href="form-upload.html">File Upload</a></li>
                                        <li><a href="form-mask.html">Form Mask</a></li>
                                        <li><a href="form-img-cropper.html">Image Cropping</a></li>
                                        <li><a href="form-validation.html">Form Validation</a></li>
                                    </ul>
                                </li>
                                <li class="col-sm-3">
                                    <ul>
                                        <li class="dropdown-header">Advance Forms</li>
                                        <li><a href="form-dropzone.html">File Dropzone</a></li>
                                        <li><a href="form-pickers.html">Form-pickers</a></li>
                                        <li><a href="form-wizard.html">Form-wizards</a></li>
                                        <li><a href="form-typehead.html">Typehead</a></li>
                                        <li><a href="form-xeditable.html">X-editable</a></li>
                                        <li><a href="form-summernote.html">Summernote</a></li>
                                        <li><a href="form-bootstrap-wysihtml5.html">Bootstrap wysihtml5</a></li>
                                        <li><a href="form-tinymce-wysihtml5.html">Tinymce wysihtml5</a></li>
                                    </ul>
                                </li>
                                <li class="col-sm-3">
                                    <ul>
                                        <li class="dropdown-header">Table Example</li>
                                        <li><a href="basic-table.html">Basic Tables</a></li>
                                        <li><a href="table-layouts.html">Table Layouts</a></li>
                                        <li><a href="data-table.html">Data Table</a></li>
                                        <li><a href="bootstrap-tables.html">Bootstrap Tables</a></li>
                                        <li><a href="responsive-tables.html">Responsive Tables</a></li>
                                        <li><a href="editable-tables.html">Editable Tables</a></li>
                                        <li><a href="foo-tables.html">FooTables</a></li>
                                        <li><a href="jsgrid.html">JsGrid Tables</a></li>
                                    </ul>
                                </li>
                                <li class="col-sm-3">
                                    <ul>
                                        <li class="dropdown-header">Charts</li>
                                        <li> <a href="flot.html">Flot Charts</a> </li>
                                        <li><a href="morris-chart.html">Morris Chart</a></li>
                                        <li><a href="chart-js.html">Chart-js</a></li>
                                        <li><a href="peity-chart.html">Peity Charts</a></li>
                                        <li><a href="knob-chart.html">Knob Charts</a></li>
                                        <li><a href="sparkline-chart.html">Sparkline charts</a></li>
                                        <li><a href="extra-charts.html">Extra Charts</a></li>
                                    </ul>
                                </li>

                            </ul>
                        </li>-->
                        <!-- /.Megamenu -->
                    </ul>

<?php if (Auth::check() == 1) { ?>
                        <ul class="nav navbar-top-links navbar-right pull-right">
                            <li>
    <?php if (can_access('view_users')) { ?>
                                    <form role="search" action="<?= url('/search') ?>?q="  method="GET" class="app-search hidden-sm hidden-xs m-r-10">
                                        <input type="text" name="q" placeholder="Search name or phone" id="search_box" class="form-control"> <a href="#"><i class="fa fa-search"></i></a> </form>
    <?php } ?>

                            <li class="dropdown" id="search_results">
                                <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> 
                                    <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                                </a>
                                <ul class="dropdown-menu mailbox animated bounceInDown">
                                    <li>
                                        <div class="drop-title">You have <span id="search_counts"></span> results</div>
                                    </li>
                                    <li>
                                        <div class="message-center" id="search_content">


                                        </div>
                                    </li>
                                    <li>
                                        <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                                <!-- /.dropdown-messages -->
                            </li>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="<?= url('storage/uploads/images/' . Auth::user()->photo) ?>" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">  {{ Auth::user()->name() }}</b><span class="caret"></span> </a>
                                <ul class="dropdown-menu dropdown-user animated flipInY">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="<?= $root ?>plugins/images/users/varun.jpg" alt="user"></div>
                                            <div class="u-text">
                                                <h4>  {{ Auth::user()->name() }}</h4>
                                                <p class="text-muted">  {{ Auth::user()->email }}</p>
                                                <a href="{{url('users/'.Auth::user()->id)}}" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                        </div>
                                    </li>
                                    <!--                                    <li role="separator" class="divider"></                                                                    li>
                                            <li><a href="#"><i class="ti                                                                    -user"></i> My Profile</a></li>
                                            <li><a href="#"><i class="ti-w                                                                    allet"></i> My Balance</a></li>
                                            <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                                            <li role="separator" class="divider"></li>
            <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>-->
                                    <li role="separator" class="divider"></li>                                                                                                                       
                                    <li><a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout</a></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </ul>
                                <!-- /.dropdown-user -->
                            </li>

                            <!-- /.dropdown -->
                        </ul>
<?php } ?>
                </div>
                <!-- /.navbar-header -->
                <!-- /.navbar-top-links -->
                <!-- /.navbar-static-side -->
            </nav>
            @endif
            @if (!Auth::guest())        
            @include('layouts.nav')
            @endif

            @if (!Auth::guest())
            <div id="page-wrapper" style="min-height: 163px;">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title">{{isset($page) ? ucfirst($page):'Home'}}</h4> </div>
                        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
<!--                            <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>-->


                        </div>
                        <!-- /.col-lg-12 -->
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                    </div>
                    @yield('content')
                </div>
            </div>  
            @endif

            @guest
            @yield('content')
            @endif
        </div>

        <!-- Scripts -->

        <script type="text/javascript">
            var BASE_URL = '{{url('')}}';
            call_page = function (pg) {
                $.ajax({
                    url: '{{ url("/") }}/' + pg,
                    data: '',
                    type: 'POST',
                    success: function (data) {
                        $('.contents').html(data);
                    }
                });
            }

            downloadMaterial = function (type) {
                $.ajax({
                    url: '{{ url("downloadMaterial") }}/' + type,
                    data: '',
                    type: 'GET',
                    success: function (data) {
                        console.log(data);
                    }
                });
            }
        </script>
        @role('admin') 
        <script type="text/javascript">
            search_box = function () {
                $('#search_box').keyup(function () {
                    var val = $(this).val();
                    if (val != '') {
                        $.ajax({
                            url: '{{ url("search") }}',
                            data: {q: val},
                            type: 'POST',
                            dataType: 'JSON',
                            success: function (data) {
                                $('#search_content').html(data.result);
                                $('#search_counts').html(data.total);
                                $('#search_results').addClass('open');
                            }
                        });
                    }
                });

            }
            $(document).ready(search_box);
        </script>
        @endrole


        <!-- Bootstrap Core JavaScript -->
        <script src="<?= $root ?>bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- Menu Plugin JavaScript -->
        <script src="<?= $root ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
        <!--slimscroll JavaScript -->
        <script src="<?= $root ?>js/jquery.slimscroll.js"></script>
        <!--Wave Effects -->
        <script src="<?= $root ?>js/waves.js"></script>
        <!-- Copy to clipboard-->
        <script src="<?= $root ?>js/clipboard.min.js"></script>

        <!-- Sparkline chart JavaScript -->
        <script src="<?= $root ?>plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?= $root ?>js/custom.min.js"></script>


        <script src="<?= $root ?>plugins/bower_components/jsgrid/db.js?v=4"></script>
        <script type="text/javascript" src="<?= $root ?>plugins/bower_components/jsgrid/dist/jsgrid.min.js"></script>
        <script src="<?= $root ?>js/jsgrid-init.js?v=2"></script>



        <script src="<?= $root ?>plugins/bower_components/toast-master/js/jquery.toast.js"></script>
        <!--Style Switcher -->
        <script src="<?= $root ?>plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
        <script src="<?= $root ?>js/custom.min.js"></script>

        <!--Wave Effects -->
        <script type="text/javascript">
           // var scrollToVal = $('.sidebar').scrollTop() + $('#el').position();
        //    $('.sidebar').slimScroll({scrollTo:  '100em'});
         // $('#side-menu').slimScroll();
        </script>

        @yield('footer')



    </body>
</html>
<!--<p align="center">End of ClickDesk  This page took <?php echo (microtime(true) - LARAVEL_START) ?> seconds to render</p>-->
<?php $root = url('/') . '/public/' ?>


<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <title>ShuleSoft Admin Panel</title>
     
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

        <meta name="description" content="ShuleSoft Admin">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="keywords" content="ShuleSoft, Admin , Admin Panel">
        <meta name="author" content="ShuleSoft">
        <!-- Favicon icon -->
        <link rel="icon" href="<?= $root ?>assets/images/favicon.ico" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- themify icon -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/icon/themify-icons/themify-icons.css">
        <!-- ico font -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/icon/icofont/css/icofont.css">
        <!-- flag icon framework css -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/flag-icon/flag-icon.min.css">
        <!-- Menu-Search css -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/menu-search/css/component.css">
        <!-- Horizontal-Timeline css -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/dashboard/horizontal-timeline/css/style.css">
        <!-- amchart css -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/dashboard/amchart/css/amchart.css">
        <!-- flag icon framework css -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/flag-icon/flag-icon.min.css">
        <!-- Data Table Css -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/data-table/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">


        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/style.css">

        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2.css">

        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2-bootstrap.css">
        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/gh-pages.css">       

        <link href="<?= url('public') ?>/bower_components/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">

        <script type="text/javascript" src="<?= $root ?>bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/jquery-ui/jquery-ui.min.js"></script>


        <script type="text/javascript">
            ajax_setup = function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    async: true,
                    cache: false,
                    beforeSend: function (xhr) {
                        // jQuery('.theme-loader').show();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // jQuery('.theme-loader').hide();
                    },
                    complete: function (xhr, status) {
                        // jQuery('.theme-loader').hide();
                    }
                });
            }
            $(document).ready(ajax_setup);
            function toast(message) {
                new PNotify({
                    title: 'Feedback',
                    text: message,
                    type: 'success',
                    hide: 'false',
                    icon: 'icofont icofont-info-circle'
                });
            }
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

        <body class="<?= strlen(request('token')) > 5 ? 'menu-collapsed menu-static' : 'fix-menu' ?>">
            <!-- Pre-loader start -->
            <div class="theme-loader">
                <div class="ball-scale">
                    <div></div>
                </div>
            </div>
        <!-- Pre-loader end -->
        <!-- Menu header start -->
        <nav class="navbar header-navbar">
            <div class="navbar-wrapper">
                <div class="navbar-logo">
                    <a class="mobile-menu" id="mobile-collapse" href="#!">
                        <i class="ti-menu"></i>
                    </a>
                    <a class="mobile-search morphsearch-search" href="#">
                        <i class="ti-search"></i>
                    </a>
                    <?php
                    $width = strlen(request('token')) > 5 ? '80' : '50';
                    ?>
                    <a href="<?= url('/') ?>">
                        <img class="img-fluid" src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="ShuleSoft" height="<?= $width ?>" width="<?= $width ?>" />
                    </a>
                    <a class="mobile-options">
                        <i class="ti-more"></i>
                    </a>
                </div>

                <div class="navbar-container container-fluid">
                    <div>
                         <ul class="nav-left">
                            <li>
                                <a id="collapse-menu" href="#">
                                    <i class="ti-menu"></i>
                                </a>
                            </li>
                            <?php
                            if (strlen(request('token')) < 4) {
                                ?>
                                <li>

                                    <a class="main-search morphsearch-search" href="#">
                                        <!-- themify icon -->
                                        <i class="ti-search"></i>
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="ti-fullscreen"></i>
                                </a>
                            </li>
                            <!--                            <li class="mega-menu-top">
                                                                                                                        <a href="#">
                                                                                                                            Mega
                                                                                                                            <i class="ti-angle-down"></i>
                                                                                                                        </a>
                                                            <ul class="show-notification row">
                                                                <li class="col-sm-3">
                                                                    <h6 class="mega-menu-title">Popular Links</h6>
                                                                    <ul class="mega-menu-links">
                                                                        <li><a href="form-elements-component.html">Form Elements</a></li>
                                                                        <li><a href="button.html">Buttons</a></li>
                                                                        <li><a href="map-google.html">Maps</a></li>
                                                                        <li><a href="user-card.html">Contact Cards</a></li>
                                                                        <li><a href="user-profile.html">User Information</a></li>
                                                                        <li><a href="auth-lock-screen.html">Lock Screen</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li class="col-sm-3">
                                                                    <h6 class="mega-menu-title">Mailbox</h6>
                                                                    <ul class="mega-mailbox">
                                                                        <li>
                                                                            <a href="#" class="media">
                                                                                <div class="media-left">
                                                                                    <i class="ti-folder"></i>
                                                                                </div>
                                                                                <div class="media-body">
                                                                                    <h5>Data Backup</h5>
                                                                                    <small class="text-muted">Store your data</small>
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" class="media">
                                                                                <div class="media-left">
                                                                                    <i class="ti-headphone-alt"></i>
                                                                                </div>
                                                                                <div class="media-body">
                                                                                    <h5>Support</h5>
                                                                                    <small class="text-muted">24-hour support</small>
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" class="media">
                                                                                <div class="media-left">
                                                                                    <i class="ti-dropbox"></i>
                                                                                </div>
                                                                                <div class="media-body">
                                                                                    <h5>Drop-box</h5>
                                                                                    <small class="text-muted">Store large amount of data in one-box only
                                                                                    </small>
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" class="media">
                                                                                <div class="media-left">
                                                                                    <i class="ti-location-pin"></i>
                                                                                </div>
                                                                                <div class="media-body">
                                                                                    <h5>Location</h5>
                                                                                    <small class="text-muted">Find Your Location with ease of use</small>
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li class="col-sm-3">
                                                                    <h6 class="mega-menu-title">Gallery</h6>
                                                                    <div class="row m-b-20">
                                                                        <div class="col-sm-4"><img class="img-fluid img-thumbnail" src="<?= $root ?>assets/images/mega-menu/01.jpg" alt="Gallery-1">
                                                                        </div>
                                                                        <div class="col-sm-4"><img class="img-fluid img-thumbnail" src="<?= $root ?>assets/images/mega-menu/02.jpg" alt="Gallery-2">
                                                                        </div>
                                                                        <div class="col-sm-4"><img class="img-fluid img-thumbnail" src="<?= $root ?>assets/images/mega-menu/03.jpg" alt="Gallery-3">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row m-b-20">
                                                                        <div class="col-sm-4"><img class="img-fluid img-thumbnail" src="<?= $root ?>assets/images/mega-menu/04.jpg" alt="Gallery-4">
                                                                        </div>
                                                                        <div class="col-sm-4"><img class="img-fluid img-thumbnail" src="<?= $root ?>assets/images/mega-menu/05.jpg" alt="Gallery-5">
                                                                        </div>
                                                                        <div class="col-sm-4"><img class="img-fluid img-thumbnail" src="<?= $root ?>assets/images/mega-menu/06.jpg" alt="Gallery-6">
                                                                        </div>
                                                                    </div>
                                                                    <button class="btn btn-primary btn-sm btn-block">Browse Gallery</button>
                                                                </li>
                                                                <li class="col-sm-3">
                                                                    <h6 class="mega-menu-title">Contact Us</h6>
                                                                    <div class="mega-menu-contact">
                                                                        <div class="form-group row">
                                                                            <label for="example-text-input" class="col-3 col-form-label">Name</label>
                                                                            <div class="col-9">
                                                                                <input class="form-control" type="text" placeholder="Artisanal kale" id="example-text-input">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="example-search-input" class="col-3 col-form-label">Email</label>
                                                                            <div class="col-9">
                                                                                <input class="form-control" type="email" placeholder="Enter your E-mail Id" id="example-search-input">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="example-search-input" class="col-3 col-form-label">Contact</label>
                                                                            <div class="col-9">
                                                                                <input class="form-control" type="number" placeholder="+91-9898989898" id="example-search-input">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="exampleTextarea" class="col-3 col-form-label">Message</label>
                                                                            <div class="col-9">
                                                                                <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </li>-->
                                                    </ul>
                                                    <?php
                                                    if (strlen(request('token')) < 4) {
                                                        ?>
                                                     <ul class="nav-right">
                                                    <li class="header-notification lng-dropdown">
                                                        <a href="#" id="dropdown-active-item">
                                                            <i class="flag-icon flag-icon-gb m-r-5"></i> English
                                                        </a>
                                                        <ul class="show-notification">
                                                            <li>
                                                                <a href="#" data-lng="en">
                                                                    <i class="flag-icon  flag-icon-es m-r-5"></i> English
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" data-lng="es">
                                                                    <i class="flag-icon flag-icon-tz m-r-5"></i> Swahili
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                    if (true) {
                                                        $tasks = \App\Models\Task::where('to_user_id', Auth::user()->id)->where('date', '>=', date('Y-m-d'))->get();
                                                        ?>
                                                        <li class="header-notification">
                                                            <a href="#!">
                                                                <i class="ti-bell"></i>
                                                                <span class="badge"><?= sizeof($tasks) ?></span>
                                                            </a>
                                                            <ul class="show-notification">
                                                                <li>
                                                                    <h6>Notifications</h6>
                                                                    <label class="label label-danger">New</label>
                                                                </li>
                                                                <?php
                                                                foreach ($tasks as $task) {
                                                                    ?>
                                                                    <li onMouseOver="this.style.backgroundColor = '#cccccc'">
                                                                        <a href="<?= url('customer/activity/show/' . $task->id) ?>" >
                                                                            <div class="media">
                                                                                <img class="d-flex align-self-center" src="<?= $root ?>assets/images/user.png" alt="Image">
                                                                                <div class="media-body">
                                                                                    <h5 class="notification-user">Client: <?= $task->client->name ?></h5>
                                                                                    <p class="notification-msg"><?= $task->activity ?></p>
                                                                                    <span class="notification-time"><?= date('d M Y', strtotime($task->date)) ?></span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                                <li>
                    
                                                                    <a href="<?= url('users/notification') ?>"><label class="label label-warning">View All</label></a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                             <!--      <li class="header-notification">
                                                        <a href="#!" class="displayChatbox">
                                                        <i class="ti-comments"></i>
                                                        <span class="badge"><?php
                                    $users = \App\Models\User::where('status', 1)->where('department', '<>', 10)->get();
                                    echo sizeof($users);
                                    ?></span>
                                        </a>
                                    </li>-->
                                <?php } ?>

                                <li class="user-profile header-notification">
                                    <a href="#!">
                                        <img src="<?= $root ?>assets/images/user.png" alt="User-Profile-Image">
                                        <span>{{ Auth::user()->name() }}</span>
                                        <i class="ti-angle-down"></i>
                                    </a>

                                    <ul class="show-notification profile-notification">
                                        <li>
                                            <a href="<?= url('users/show/' . Auth::user()->id) ?>">
                                                <i class="ti-user"></i> Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= url('users/password/') ?>">
                                                <i class="ti-settings"></i> Change Password
                                            </a>
                                        </li>
                                        <?php if (false) { ?>
                                            <li>
                                                <a href="#!">
                                                    <i class="ti-settings"></i> Settings
                                                </a>
                                            </li>

                                            <li>
                                                <a href="email-inbox.html">
                                                    <i class="ti-email"></i> My Messages
                                                </a>
                                            </li>
                                            <li>
                                                <a href="auth-lock-screen.html">
                                                    <i class="ti-lock"></i> Lock Screen
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <li><a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                           document.getElementById('logout-form').submit();"><i class="ti-layout-sidebar-left"></i> Logout</a></li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>

                                    </ul>

                                </li>
                            </ul>
                            <!-- search -->
                        <?php } ?>


                        <script>
                            search_inputs = function () {
                                $('#search_inputs').keyup(function () {
                                    var val = $(this).val();
//                                    if(val.lenght >1){
                                    $.ajax({
                                        type: "post",
                                        url: "<?= url('analyse/search') ?>",
                                        data: "q=" + val,
                                        dataType: 'JSON',
                                        success: function (data) {
                                            console.log(data);
                                            $('#search_people').html(data.people);
                                            $('#search_schools').html(data.schools);
                                            $('#search_activities').html(data.activities);
                                        }
                                    });
//                                    }else{
//                                     $('#search_people').html('');
//                                     $('#search_schools').html('');
//                                     $('#search_activities').html('');
//                                    }
                                })
                            }
                            $(document).ready(search_inputs);
                        </script>
                        <div id="morphsearch" class="morphsearch">
                            <form class="morphsearch-form">
                                <input class="morphsearch-input" id="search_inputs" type="search" placeholder="Search..." />
                                <button class="morphsearch-submit" type="submit">Search</button>
                            </form>
                            <div class="morphsearch-content">
                                <div class="dummy-column">
                                    <h2>Invoices</h2>
                                    <span id="search_people"></span>


                                </div>
                                <div class="dummy-column" style="overflow-y: scroll;">
                                    <h2>Schools</h2>
                                    <span id="search_schools"></span>


                                </div>
                                <div class="dummy-column">
                                    <h2>Activity</h2>
                                    <span id="search_activities"></span>

                                </div>
                            </div>
                            <!-- /morphsearch-content -->
                            <span class="morphsearch-close"><i class="icofont icofont-search-alt-1"></i></span>
                        </div>
                        <!-- search end -->
                    </div>
                </div>
            </div>
        </nav>
        <!-- Menu header end -->


       <?php
        if (strlen(request('token')) < 3) {
            ?>
            <!-- Menu aside start -->
            <div class="main-menu">
                <div class="main-menu-header">
                    <img class="img-40" src="<?= $root ?>assets/images/user.png" alt="User-Profile-Image">
                    <div class="user-details">
                        <span>{{ Auth::user()->name() }}</span>
                        <span id="more-details"> <?php // Auth::user()->role->display_name              ?></span>
                    </div>
                </div>
                <div class="main-menu-content">
                    <ul class="main-navigation">

                        <hr style="background:white"/>

                        <li class="nav-item">
                            <?php if (Auth::user()->role_id <> 7) { ?>
                                <a href="#!">
                                    <i class="ti-home"></i>
                                    <span data-i18n="nav.dash.main">Dashboard</span>
                                </a>
                            <?php } else { ?>
                                <a href="<?= url('/') ?>">
                                    <span data-i18n="nav.dash.main">Dashboard</span>
                                </a> 
                            <?php }
                            ?>
                            <ul class="tree-1 has-class">

                                <?php if (can_access('manage_users')) { ?>
                                    <li>
                                        <a href="<?= url('analyse/index') ?>" data-i18n="nav.dash.default"> Home </a></li>

                                <?php } if ((can_access('manage_users') || Auth::user()->department == 2) && Auth::user()->role_id <> 3) { ?>

                                    <li><a href="<?= url('analyse/marketing') ?>" data-i18n="nav.dash.ecommerce"> Marketing </a></li>
                                <?php } if (can_access('manage_users') || Auth::user()->department == 2) { ?>
                                    <li><a href="<?= url('analyse/sales') ?>" data-i18n="nav.dash.ecommerce"> Sales</a></li>
                                <?php } if (can_access('manage_users') || Auth::user()->department == 4) { ?>
                                    <li><a href="<?= url('analyse/accounts') ?>" data-i18n="nav.dash.crm">Accounts</a></li>
                                <?php } if (can_access('manage_users') || Auth::user()->department == 1) { ?>
                                    <li><a href="<?= url('analyse/customers') ?>" data-i18n="nav.dash.analytics">Customers</a>
                                        <label class="label label-info menu-caption">NEW</label>
                                    </li>
                                <?php } if (can_access('manage_users') || Auth::user()->department == 3) { ?>
                                    <li><a href="<?= url('analyse/software') ?>" data-i18n="nav.dash.project">Software Dev</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php if (can_access('manage_customers')) { ?>
                            <li class="nav-title" data-i18n="nav.category.navigation">
                                <i class="ti-line-dashed"></i>
                                <span>Operations</span>
                            </li>

                            <li class="nav-item">
                                <a href="#!">
                                    <i class="ti-layout"></i>
                                    <span data-i18n="nav.page_layout.main">Customer Service</span>
                                </a>
                                <ul class="tree-1">
                                    <li><a href="<?= url('general/show/whatsapp_integrations') ?>" data-i18n="nav.page_layout.bottom-menu">WhatsApp Integration</a></li>
                                    <li><a href="<?= url('customer/setup') ?>" data-i18n="nav.page_layout.bottom-menu">System Setup</a></li>
                                    <li>
                                        <a href="<?= url('Phone_call/index') ?>" data-i18n="nav.navigate.navbar"> Phone Calls</a>
                                    </li>

                                    <li class="nav-sub-item"><a href="#" data-i18n="nav.page_layout.vertical.main"><i
                                                class="icon-arrow-right"></i>Training</a>
                                        <ul class="tree-2">

                                            <li><a href="<?= url('customer/guide') ?>" data-i18n="nav.page_layout.vertical.header-fixed">User Guide</a></li>
                                            <li><a href="<?= url('customer/faq') ?>" data-i18n="nav.page_layout.vertical.compact"> FAQ </a>
                                            </li>
                                            <li><a href="<?= url('customer/report') ?>" data-i18n="nav.page_layout.vertical.static-layout">Report </a></li>
                                            <li><a href="<?= url('customer/sequence') ?>" data-i18n="nav.page_layout.vertical.static-layout">Sequence </a></li>
                                        </ul>
                                    </li>

                                    <li class="nav-sub-item"><a href="#" data-i18n="nav.page_layout.vertical.main"><i
                                                class="icon-arrow-right"></i>Usage Analysis</a>
                                        <ul class="tree-2">
                                            <li><a href="<?= url('customer/modules') ?>" data-i18n="nav.page_layout.vertical.static-layout"> Modules </a></li>
                                            <li><a href="<?= url('customer/logs') ?>" data-i18n="nav.page_layout.vertical.header-fixed">
                                                    User Logs</a></li>
                                            <li><a href="<?= url('customer/karibu') ?>" data-i18n="nav.page_layout.vertical.compact"> karibuSMS </a>
                                            </li>
                                            <li><a href="<?= url('customer/epayments') ?>" data-i18n="nav.page_layout.vertical.compact"> e-payments </a>
                                            </li>

                                        </ul>
                                    </li>

                                    <li class="nav-sub-item"><a href="#" data-i18n="nav.page_layout.horizontal.main"> Communications</a>
                                        <ul class="tree-2">
                                            <li><a href="<?= url('customer/calls') ?>"  data-i18n="nav.page_layout.horizontal.static-layout"> Call Logs</a></li>
                                            <li><a href="<?= url('customer/emailsms') ?>" data-i18n="nav.page_layout.horizontal.static-layout"> SMS & Email Logs</a></li>
                                            <li><a href="<?= url('customer/feedbacks/null') ?>"  data-i18n="nav.page_layout.horizontal.fixed-layout">Customer Feedbacks </a></li>
                                            <li><a href="<?= url('customer/update') ?>" data-i18n="nav.page_layout.horizontal.static-with-icon">ShuleSoft Updates </a></li>

                                        </ul>
                                    </li>
                                    <li><a href="<?= url('customer/requirements') ?>" data-i18n="nav.page_layout.bottom-menu">Customer Requirements</a></li>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if (Auth::user()->role_id == 12) { ?>

                            <li class="nav-item">
                                <a href="<?= url('customer/activity') ?>">
                                    <i class="ti-gift "></i>
                                    <span data-i18n="nav.extra-components.main">Tasks Management</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= url('account/transaction/4') ?>"><i class="fa icon-expense"></i> 
                                    <span data-i18n="nav.extra-components.main">Record Expense</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php // if (can_access('manage_sales') || Auth::user()->role_id == 14) { ?>
                        <li class="nav-item">
                            <a href="#!">
                                <i class="ti-layout-cta-right"></i>
                                <span data-i18n="nav.navigate.main">Sales</span>
                            </a>
                            <ul class="tree-1">
                                <li>
                                    <a href="<?= url('sales/index') ?>" data-i18n="nav.navigate.navbar">Sales Materials</a>
                                </li>

                                <?php
                                if (!preg_match('/crdb/i', Auth::user()->email)) {
                                    ?>
<!--                                    <li>
                                        <a href="<?= url('sales/school') ?>" data-i18n="nav.navigate.navbar">Schools</a>
                                    </li>-->
                                    <?php
                                    if (Auth::user()->role_id <> 3) {
                                        ?>
                                        <li>
                                            <a href="<?= url('sales/school') ?>" data-i18n="nav.navigate.navbar">List of Schools</a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                                <li>
                                    <a href="<?= url('sales/salesStatus') ?>" data-i18n="nav.navigate.navbar">Sales Status</a>
                                </li>

                                <!--                                    <li>
                                                                        <a href="<?= url('sales/analysis') ?>" data-i18n="nav.navigate.navbar">Sales Analysis</a>
                                                                    </li>-->
                            </ul>
                        </li>
                        <?php // } ?>

                        <?php if (Auth::user()->role_id != 7 && Auth::user()->role_id <> 3) { ?>

                            <li class="nav-item">
                                <a href="<?= url('customer/activity') ?>">
                                    <i class="ti-gift "></i>
                                    <span data-i18n="nav.extra-components.main">Tasks Management</span>
                                </a>
                            </li>

                        <?php } if (Auth::user()->role_id == 14) { ?>
                            <li class="nav-item">
                                <a href="<?= url('customer/modules') ?>">
                                    <i class="ti-bell"></i>
                                    <span data-i18n="nav.extra-components.main"> Customer Modules</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="<?= url('sales/school') ?>">
                                    <i class="ti-list "></i>
                                    <span data-i18n="nav.extra-components.main"> List of Schools</span>
                                </a>
                            </li> -->
                            <li><a href="<?= url('customer/requirements') ?>" data-i18n="nav.page_layout.bottom-menu">Customer Requirements</a></li>
                        <?php } ?>

                        <?php if (can_access('manage_marketing') || Auth::user()->id == 33) { ?>
                            <li class="nav-item">
                                <a href="#!">
                                    <i class="ti-bell "></i>
                                    <span data-i18n="nav.extra-components.main">Marketing</span>
                                </a>
                                <ul class="tree-1">
                                    <li><a href="<?= url('Marketing/socialMedia') ?>" data-i18n="nav.extra-components.session-timeout">Social Media</a></li>
                                    <li><a href="<?= url('Marketing/school') ?>" data-i18n="nav.navigate.navbar">Schools Status</a></li>
                                    <li><a href="<?= url('Marketing/Events') ?>" data-i18n="nav.extra-components.session-idle-timeout">Events</a></li>
                                    <li><a href="<?= url('Marketing/moduleUsage') ?>" data-i18n="nav.extra-components.session-idle-timeout">Module Usage</a></li>
                                    <li><a href="<?= url('Marketing/systemUser') ?>" data-i18n="nav.extra-components.session-idle-timeout">System Users</a></li>
                                    <li><a href="<?= url('Marketing/Communication') ?>" data-i18n="nav.extra-components.session-idle-timeout">Communication</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (can_access('manage_software')) { ?>
                            <li class="nav-item">
                                <a href="#!">
                                    <i class="ti-layout-grid2-alt"></i>
                                    <span data-i18n="nav.basic-components.main">Software Development</span>
                                </a>
                                <ul class="tree-1">
                                    <li><a href="<?= url('software/template') ?>" data-i18n="nav.basic-components.alert">Templates & Policies</a></li>
                                    <li class="nav-sub-item"><a href="#" data-i18n="nav.menu-levels.menu-level-22.main">Database</a>
                                        <ul class="tree-2" style="display: none;">
                                            <li><a href="<?= url('software/compareTable') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Tables</a></li>
                                            <li><a href="<?= url('software/compareColumn') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Columns</a></li>
                                            <li><a href="<?= url('software/constrains') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Constrains</a></li>
                                            <li><a href="<?= url('software/backup') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Backup</a></li>
                                            <li><a href="<?= url('software/analysis') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Reports</a></li>
                                            <li><a href="<?= url('software/upgrade') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Create Script</a></li>

                                        </ul>
                                    </li>

                                    <li class="nav-sub-item"><a href="#" data-i18n="nav.menu-levels.menu-level-22.main">Payment Integration</a>
                                        <ul class="tree-2" style="display: none;">
                                            <li><a href="<?= url('software/banksetup') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Bank Setup</a></li>


                                            <li><a href="<?= url('software/invoice/live') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Live Invoices</a></li>
                                            <li><a href="<?= url('software/invoice/uat') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Testing Invoices</a></li>
                                            <li><a href="<?= url('software/api') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">API Requests</a></li>

                                            <li><a href="<?= url('software/reconciliation') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Reconciliation</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="<?= url('software/server') ?>" data-i18n="nav.basic-components.button">Server Administration</a></li>
                                    <li><a href="<?= url('software/logs') ?>" data-i18n="nav.basic-components.box-shadow">Error Logs</a></li>
                                   

                                </ul>
                            </li>
                        <?php } ?>


                        <?php if (can_access('manage_users')) { ?>
                            <li class="nav-item">
                                <a href="#!">
                                    <i class="ti-gift "></i>
                                    <span data-i18n="nav.extra-components.main">User permissions</span>
                                </a>
                                <ul class="tree-1">
                                    <li><a href="<?= url('Role/userPermission') ?>"
                                     data-i18n="nav.extra-components.session-timeout">User permission</a></li>
                                </ul>
                            </li>
                            <?php } ?>


                            <?php if (can_access('manage_users')) { ?>
                                <li class="nav-item">
                                    <a href="#!">
                                        <i class="ti-gift "></i>
                                        <span data-i18n="nav.extra-components.main">Human Resources</span>
                                    </a>
                                    <ul class="tree-1">
                                        <li><a href="<?= url('users/index') ?>"
                                                data-i18n="nav.extra-components.session-timeout">Users</a></li>
                                        <li><a href="<?= url('users/kpi_list') ?>"
                                            data-i18n="nav.extra-components.session-timeout">KPI</a></li>
                                        <li><a href="<?= url('users/minutes') ?>" data-i18n="nav.extra-components.offline">Meeting
                                                Minutes</a></li>
                                        <li><a href="<?= url('attendance/index') ?>"
                                                data-i18n="nav.extra-components.session-timeout">Attendance</a></li>
                                        <li><a href="<?= url('Partner/partners') ?>"
                                                data-i18n="nav.extra-components.session-idle-timeout">Partners</a></li>
                                        <li><a href="<?= url('users/applicant') ?>"
                                                data-i18n="nav.extra-components.session-idle-timeout">Applicants</a>
                                        </li>
                                        <li><a href="<?= url('users/template') ?>" data-i18n="nav.extra-components.offline">Forms &
                                                Templates</a></li>
                                    </ul>
                                </li>
                                <?php } ?>

                                <?php  if (can_access('manage_users') && !in_array(Auth::user()->department, [9, 10]) || in_array(Auth::user()->role_id, array(14, 8, 2, 3, 9, 20))) {
                                    ?>
                                   <li class="nav-item">
                                               <a href="#!">
                                                   <i class="ti-layers "></i>
                                                   <span data-i18n="nav.extra-components.main">My Schools</span>
                                               </a>
                                               <ul class="tree-1">
                                                   <li><a href="<?= url('Analyse/myschools') ?>" data-i18n="nav.extra-components.session-timeout"> List of Schools</a></li>
                                                   <li><a href="<?= url('Analyse/myreport') ?>" data-i18n="nav.extra-components.offline">Task Report</a></li>
                                                   <li><a href="<?= url('sales/schoolVisit/1') ?>" data-i18n="nav.extra-components.session-timeout">School Visitation</a></li>
                                                   <!-- <li><a href="<?= url('software/banksetup') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Bank Setup</a></li> -->
                                               </ul>
                                           </li>
                                           <?php } ?>

                                <?php if (in_array(Auth::user()->role_id, array(14, 8, 9, 2,3))) { ?>
                                    <li class="nav-item"><a href="<?= url('users/minutes') ?>" data-i18n="nav.extra-components.offline"> <i class="ti-book "> </i> Meeting Minutes</a></li>
                                <?php } ?>




                                
                        <?php if ((int) Auth::user()->role_id == 7) { ?>
                            <li class="nav-item">
                                <a href="#!">
                                    <i class="ti-layers "></i>
                                    <span data-i18n="nav.extra-components.main">Operations</span>
                                </a>
                                <ul class="tree-1">
                                    <li><a href="<?= url('Partner/index') ?>" data-i18n="nav.extra-components.session-timeout">Onboard Requests</a></li>
                                    <!--<li><a href="<?= url('Partner/add') ?>" data-i18n="nav.extra-components.offline">Onboard New School</a></li>-->
                                    <!--<li><a href="#" data-i18n="nav.extra-components.session-timeout">Reports</a></li>-->
                                </ul>
                            </li>
                        <?php } if (can_access('manage_users') || in_array(Auth::user()->role_id, array(14, 8))) { ?>
                            <li class="nav-item">
                                <a href="#!">
                                    <i class="ti-layers "></i>
                                    <span data-i18n="nav.extra-components.main">Partner Operations</span>
                                </a>
                                <ul class="tree-1">
                                    <li><a href="<?= url('Partner/index') ?>" data-i18n="nav.extra-components.session-timeout"> Onboard Requests</a></li>
                                    <!--<li><a href="<?= url('Partner/add') ?>" data-i18n="nav.extra-components.offline">Onboard New School</a></li>-->
                                    <li><a href="#" data-i18n="nav.extra-components.session-timeout">Reports</a></li>
                                </ul>
                            </li>
                            <?php
                        }
                        if (Auth::user()->department == 9 || Auth::user()->department == 10) {
                            ?>
                            <li class="nav-item"><a href="<?= url('Partner/index') ?>" > <i class="ti-layers "> </i> Onboarded Schools</a></li>
                            <?php
                        }
                        // if (can_access('manage_schools')) {

                        if (false) {
                            $has_class = preg_match('/exam/', url()->current()) ? 'has-class open' : '';
                            ?>
                            <li class="nav-item <?= $has_class ?>">
                                <a href="#!">
                                    <i class="ti-crown"></i>
                                    <span data-i18n="nav.advance-components.main">Schools</span>
                                </a>
                                <ul class="tree-1 ">
                                    <!--<li><a href="<?= url('exam/dashboard') ?>" data-i18n="nav.advance-components.draggable">Dashboard</a></li>-->

                                    <li class="nav-sub-item"><a href="#" data-i18n="nav.page_layout.horizontal.main"> Exams</a>
                                        <ul class="tree-2 <?= $has_class ?>">
                                            <a href="<?= url('exam/listing') ?>"><i class="fa icon-account"></i> Listing</a>
                                            <a href="<?= url('exam/allocate') ?>"><i class="fa icon-account"></i> Definition</a>
                                            <!--<a href="<?= url('exam/schedule') ?>"><i class="fa icon-expense"></i> Schedule</a>-->
                                            <a href="<?= url('exam/grade') ?>"><i class="fa icon-account"></i> Grades</a>

                                            <a href="<?= url('exam/subject') ?>"><i class="fa icon-account"></i> Subjects</a>

                                            <li class="nav-sub-item-3">
                                                <a href="#" data-i18n="nav.menu-levels.menu-level-22.menu-level-32.main">&nbsp; Reports</a>
                                                <ul class="tree-3">
                                                    <li><a href="<?= url('exam/report/single') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-32.menu-level-41">Single</a> </li>
                                                    <!--<li><a href="<?= url('exam/report/accumulative') ?>" data-i18n="nav.menu-levels.menu-level-22.menu-level-32.menu-level-41">Combined</a> </li>-->

                                                </ul>
                                            </li>
                                            <li><a href="<?= url('exam/marking') ?>" data-i18n="nav.advance-components.draggable">Marking</a></li>

                                        </ul>
                                    </li>
                                  <!--  <li class="nav-sub-item"><a href="<?= url('report/index') ?>"> System Reports</a></li> -->

                                </ul>
                            </li>
                        <?php } ?>

                        


                        <?php if (can_access('manage_finance')) { ?>
                            <li class="nav-item">
                                <a href="#!">
                                    <i class="ti-crown"></i>
                                    <span data-i18n="nav.advance-components.main">Accounts & Finance</span>
                                </a>
                                <ul class="tree-1">
                                    <!-- <li><a href="<?= url('account/projection') ?>" data-i18n="nav.advance-components.draggable">Projections</a></li> -->
                                    <li><a href="<?= url('account/invoice') ?>" data-i18n="nav.advance-components.grid-stack">Invoice</a></li>
                                    <li class="nav-sub-item"><a href="#" data-i18n="nav.page_layout.horizontal.main"> Transactions</a>
                                        <ul class="tree-2">
                                            <a href="<?= url('account/revenue') ?>"><i class="fa icon-account"></i> Revenue</a>
                                            <a href="<?= url('account/transaction/4') ?>"><i class="fa icon-expense"></i> Expense</a>
                                            <a href="<?= url('account/transaction/1') ?>"><i class="fa icon-account"></i> Fixed assets</a>
                                            <a href="<?= url('account/transaction/5') ?>"><i class="fa icon-account"></i> Current assets</a>
                                            <a href="<?= url('account/transaction/2') ?>"><i class="fa icon-account"></i> liabilities</a>
                                            <a href="<?= url('account/transaction/3') ?>"><i class="fa icon-account"></i> capital</a>
                                            <a href="<?= url('account/reconciliation') ?>"><i class="fa icon-account"></i> Reconciliation</a>
                                        </ul>
                                    </li>
                        <li><a href="<?= url('Account/budget') ?>"
                            data-i18n="nav.advance-components.grid-stack">
                              Budget 
                        </a>
                       </li>

                
                        <li class="nav-sub-item">
                            <a href="#" data-i18n="nav.page_layout.horizontal.main">
                                Payroll
                                <span class="fa fa-chevron-down"></span></a>
                            <ul class="tree-2">
                                <a href="<?= url('payroll/taxes') ?>"><i
                                        class="fa fa-clipboard"></i><span>TAX</span></a>
                                <a href="<?= url('payroll/pension') ?>"><i class="fa fa-clipboard"></i><span>Pension
                                        Fund</span></a>
                                <a href="<?= url('allowance/index') ?>"><i
                                        class="fa fa-clipboard"></i><span>Allowances</span></a>
                                <a href="<?= url('deduction/index') ?>"><i
                                        class="fa fa-clipboard"></i><span>Deductions</span></a>
                                <li class="nav-sub-item-3">
                                    <a>
                                        Loans
                                        <span class="fa fa-chevron-down"></span></a>
                                    <ul class="tree-3">

                                        <a href="<?= url('loan/type') ?>"><i class="fa fa-clipboard"></i><span
                                                style="color: white; line-height: 25px;"> Loan Types</span></a>

                                        <a href="<?= url('loan/index') ?>"><i class="fa fa-clipboard"></i><span
                                                style="color: white; line-height: 25px;"> Borrowers </span></a>
                                        </ul>
                                    </li>
               
                                    <li><a href="<?= url('account/report') ?>" data-i18n="nav.advance-components.light-box">Reports</a></li>
                                    <li class="nav-sub-item"><a href="#" data-i18n="nav.page_layout.horizontal.main"> Settings</a>
                                        <ul class="tree-2">
                                            <a href="<?= url('account/client') ?>"><i class="fa icon-account"></i>  Clients</a>
                                            <a href="<?= url('account/bank') ?>"><i class="fa icon-account"></i> Banking</a>
                                            <a href="<?= url('account/groups') ?>"><i class="fa icon-account"></i> Account Groups</a>
                                            <a href="<?= url('account/chart') ?>"><i class="fa icon-account"></i> Charts of Accounts</a>
                                            <a href="<?= url('account/project') ?>"><i class="fa icon-account"></i> Company Projects</a>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>


                        <?php if (can_access('manage_expenses')) { ?>
                             {{-- <li class="nav-item single-item has-class">
                                    <a href="<?= url('account/transaction/4') ?>">
                                        <i class="ti-view-grid"></i>
                                        <span data-i18n="nav.widget.main"> Expenses</span>
                                        <label class="label label-danger menu-caption">+</label>
                                            </a>
                                        </li> --}}
                            <?php } ?>



                    <?php } ?>
                    <?php /* if (preg_match('/localhost/', url()->current()) && can_access('manage_software')) { ?>
                      <li class="nav-item">
                      <a href="#">
                      <i class="ti-menu"></i>
                      <span data-i18n="nav.basic-components.main"> Customer Requirement </span>
                      </a>
                      <ul class="tree-1 ">
                      <li><a href="<?=url('software/requirements')?>" data-i18n="nav.extra-components.session-timeout">Requirement</a></li>
                      <li><a href="<?= url('software/todo') ?>" data-i18n="nav.extra-components.session-timeout">Todo List</a></li>
                      <li><a href="<?= url('software/statistics') ?>" data-i18n="nav.extra-components.session-timeout">Reports</a></li>
                      </ul>
                      </li>
                      <?php } */ ?>
                </ul>
            </div>
        </div>
        <!-- Menu aside end -->
        <!-- Sidebar chat start -->
        <div id="sidebar" class="users p-chat-user showChat">
            <div class="had-container">
                <div class="card card_main p-fixed users-main">
                    <div class="user-box">
                        <div class="card-block">
                            <div class="right-icon-control">
                                <input type="text" class="form-control  search-text" placeholder="Search Friend" id="search-friends">
                                <div class="form-icon">
                                    <i class="icofont icofont-search"></i>
                                </div>
                            </div>
                        </div>
                        <div class="main-friend-list">
                            <?php
                            foreach ($users as $user) {
                                ?>
                                <div class="media userlist-box" onclick="get_user(<?= $user->id ?>)" data-id="1" data-status="online" data-username="<?= $user->firstname . ' ' . $user->lastname ?>" data-toggle="tooltip" data-placement="left" title="<?= $user->firstname . ' ' . $user->lastname ?>">
                                    <input id="to_user_id<?= $user->id ?>" value="<?= $user->id ?>" type="hidden">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-circle" src="<?= $root ?>assets/images/avatar-1.png" alt="<?= $user->firstname . ' ' . $user->lastname ?>">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header"><?= $user->firstname . ' ' . $user->lastname ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!--                                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe" data-toggle="tooltip" data-placement="left" title="Lary Doe">
                                                                <a class="media-left" href="#!">
                                                                    <img class="media-object img-circle" src="<?= $root ?>assets/images/task/task-u1.jpg" alt="Image">
                                                                    <div class="live-status bg-success"></div>
                                                                </a>
                                                                <div class="media-body">
                                                                    <div class="f-13 chat-header">Lary Doe</div>
                                                                </div>
                                                            </div>-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar inner chat start-->
        <div class="showChat_inner">
            <div id="usermessage"  style="overflow-y: auto; height: 100%;">

            </div>
        </div>
        <!-- Sidebar inner chat end-->
        <!-- Main-body start-->
        <div class="main-body">
            @include('layouts.notifications')
            @yield('content')
        </div>
        <!-- Main-body end-->
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
                        <img src="<?= $root ?>assets/images/browser/chrome.png" alt="Chrome">
                        <div>Chrome</div>
                    </a>
                </li>
                <li>
                    <a href="https://www.mozilla.org/en-US/firefox/new/">
                        <img src="<?= $root ?>assets/images/browser/firefox.png" alt="Firefox">
                        <div>Firefox</div>
                    </a>
                </li>
                <li>
                    <a href="http://www.opera.com">
                        <img src="<?= $root ?>assets/images/browser/opera.png" alt="Opera">
                        <div>Opera</div>
                    </a>
                </li>
                <li>
                    <a href="https://www.apple.com/safari/">
                        <img src="<?= $root ?>assets/images/browser/safari.png" alt="Safari">
                        <div>Safari</div>
                    </a>
                </li>
                <li>
                    <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                        <img src="<?= $root ?>assets/images/browser/ie.png" alt="">
                        <div>IE (9 & above)</div>
                    </a>
                </li>
            </ul>
        </div>
        <p>Sorry for the inconvenience!</p>
    </div>
    <![endif]-->
        <!-- Warning Section Ends -->

        <script src="<?= $root ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/tether/dist/js/tether.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- jquery slimscroll js -->
        <script type="text/javascript" src="<?= $root ?>bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>
        <!-- modernizr js -->
        <script type="text/javascript" src="<?= $root ?>bower_components/modernizr/modernizr.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/modernizr/feature-detects/css-scrollbars.js"></script>
        <!-- classie js -->
        <script type="text/javascript" src="<?= $root ?>bower_components/classie/classie.js"></script>
        <!-- Rickshow Chart js -->
        <script src="<?= $root ?>bower_components/d3/d3.js"></script>
        <!-- Morris Chart js -->
        <script src="<?= $root ?>bower_components/raphael/raphael.min.js"></script>
        <script src="<?= $root ?>bower_components/morris.js/morris.js"></script>
        <!-- Horizontal-Timeline js -->
        <script type="text/javascript" src="<?= $root ?>assets/pages/dashboard/horizontal-timeline/js/main.js"></script>
        <!-- amchart js -->
        <script type="text/javascript" src="<?= $root ?>assets/pages/dashboard/amchart/js/amcharts.js"></script>
        <script type="text/javascript" src="<?= $root ?>assets/pages/dashboard/amchart/js/serial.js"></script>
        <script type="text/javascript" src="<?= $root ?>assets/pages/dashboard/amchart/js/light.js"></script>
        <script type="text/javascript" src="<?= $root ?>assets/pages/dashboard/amchart/js/custom-amchart.js"></script>



        <!-- i18next.min.js -->
        <script type="text/javascript" src="<?= $root ?>bower_components/i18next/i18next.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>bower_components/jquery-i18next/jquery-i18next.min.js"></script>

        <!-- Custom js -->
        <script src="<?= url('public') ?>/bower_components/clockpicker/dist/jquery-clockpicker.min.js"></script>  
        <script type="text/javascript" src="<?= $root ?>assets/pages/dashboard/custom-dashboard.js?v=3"></script>
        <script type="text/javascript" src="<?= $root ?>assets/js/script.js?v=3"></script>

        <script src="<?= $root ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?= $root ?>bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?= $root ?>assets/pages/data-table/js/jszip.min.js"></script>
        <script src="<?= $root ?>assets/pages/data-table/js/pdfmake.min.js"></script>
        <script src="<?= $root ?>assets/pages/data-table/js/vfs_fonts.js"></script>
        <script src="<?= $root ?>bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="<?= $root ?>bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="<?= $root ?>bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?= $root ?>bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= $root ?>bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        @yield('footer')

    </body>
    <?php
    if (request('type_id') != 'subject' && !preg_match('/emailsms/', url()->current()) && !preg_match('/sales/', url()->current()) && !preg_match('/logs/', url()->current()) && !preg_match('/activity/', url()->current()) && !preg_match('/payment_history/i', url()->current()) && !preg_match('/api/', url()->current())) {
        ?>
        <script type="text/javascript">
                                    send_message = function (id) {
                                        var to_user_id = $('#to_user_id' + id).val();
                                        var body = $('#body').val();
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?= url('Users/storeChat/null') ?>',
                                            data: {to_user_id: to_user_id, body: body},
                                            dataType: "html",
                                            success: function (data) {
                                                $('input[type="text"],textarea').val('');
                                                $('#usermessage').html(data);
                                            }
                                        });
                                    }

                                    get_user = function (id) {
                                        var to_user_id = $('#to_user_id' + id).val();
                                        $.ajax({
                                            type: 'get',
                                            url: '<?= url('Users/getUser/null') ?>',
                                            data: {to_user_id: to_user_id},
                                            dataType: "html",
                                            success: function (data) {
                                                $('#usermessage').html(data);
                                            }
                                        });
                                    }

                                    $(document).ready(function () {
                                        $('.dataTable').DataTable({
                                            dom: 'Bfrtip',
                                            responsive: false,
                                            paging: true,
                                            info: false,
                                            "pageLength": 10,
                                            buttons: [
                                                {
                                                    text: 'PDF',
                                                    extend: 'pdfHtml5',
                                                    message: '',
                                                    orientation: 'landscape',
                                                    exportOptions: {
                                                        columns: ':visible'
                                                    },
                                                    customize: function (doc) {
                                                        doc.pageMargins = [10, 10, 10, 10];
                                                        doc.defaultStyle.fontSize = 7;
                                                        doc.styles.tableHeader.fontSize = 7;
                                                        doc.styles.title.fontSize = 9;
                                                        // Remove spaces around page title
                                                        doc.content[0].text = doc.content[0].text.trim();
                                                        // Create a footer
                                                        doc['footer'] = (function (page, pages) {
                                                            return {
                                                                columns: [
                                                                    'www.shulesoft.com',
                                                                    {
                                                                        // This is the right column
                                                                        alignment: 'right',
                                                                        text: ['page ', {text: page.toString()}, ' of ', {text: pages.toString()}]
                                                                    }
                                                                ],
                                                                margin: [10, 0]
                                                            }
                                                        });
                                                        // Styling the table: create style object
                                                        var objLayout = {};
                                                        // Horizontal line thickness
                                                        objLayout['hLineWidth'] = function (i) {
                                                            return .5;
                                                        };
                                                        // Vertikal line thickness
                                                        objLayout['vLineWidth'] = function (i) {
                                                            return .5;
                                                        };
                                                        // Horizontal line color
                                                        objLayout['hLineColor'] = function (i) {
                                                            return '#aaa';
                                                        };
                                                        // Vertical line color
                                                        objLayout['vLineColor'] = function (i) {
                                                            return '#aaa';
                                                        };
                                                        // Left padding of the cell
                                                        objLayout['paddingLeft'] = function (i) {
                                                            return 4;
                                                        };
                                                        // Right padding of the cell
                                                        objLayout['paddingRight'] = function (i) {
                                                            return 4;
                                                        };
                                                        // Inject the object in the document
                                                        doc.content[1].layout = objLayout;
                                                    }
                                                },

                                                {extend: 'excelHtml5', footer: true},
                                                {extend: 'csvHtml5', customize: function (csv) {
                                                        return "ShuleSoft" + csv + "ShuleSoft";
                                                    }},
                                                {extend: 'print', footer: true}

                                            ]
                                        });
                                    });



                                    $('form').each(function (i, form) {
                                        var $form = $(form);

                                        if (!$form.find('input[name="_token"]').length) {
                                            $('form').prepend('<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').prop('content') + '"/>');
                                        }
                                    });

                                    $('.clockpicker').clockpicker({
                                        donetext: 'Done'
                                    }).find('input').change(function () {
                                        console.log(this.value);
                                    });
        </script>
    <?php } ?>
</html>
<?php
///echo url()->current();
if (preg_match('/localhost/', url()->current())) {
    ?>
    <p align="center">This page took <?php echo (microtime(true) - LARAVEL_START) ?> seconds to render</p>
<?php } ?>

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            


<?php $root = url('/') . '/public/';
$value = \App\Models\UsersSchool::where('user_id',Auth::user()->id)->get();
//isset($value) ? dd($value) : 'vaaaaaaaa' 
?>
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
        <meta name="keywords" content="ShuleSoft, Admin, Admin Panel">
        <meta name="author" content="ShuleSoft">
        <!-- Favicon icon -->
        <link rel="icon" href="<?= $root ?>assets/images/favicon.ico" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/bower_components/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/assets/icon/feather/css/feather.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/assets/css/jquery.mCustomScrollbar.css">

        <!-- Data Table Css -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/assets/pages/data-table/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
   
        <!-- select 2 -->
        <link rel="stylesheet" href="<?= $root ?>/files/bower_components/select2/css/select2.min.css">

        {{-- date picker --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
       
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/series-label.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script src="https://code.highcharts.com/highcharts-3d.js"></script>
            
     </head>
    <body>
      <!-- Pre-loader start -->

       <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>    
          
     {{-- <div class="theme-loader itext-center">
        <div class="ball-scale justify-content-center">
            <div class='contain'>
                <img width="200" height="200" src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="ShuleSoft">
            </div>
        </div>
    </div>    --}}

    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header" style="background-color: #2C3E50;">
                <div class="navbar-wrapper">
                    <div class="navbar-logo" style="background-color: #2C3E50;">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="index-1.htm">
                            <img width="50" height="50" src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="ShuleSoft">
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="feather icon-x text-light"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn"><i class="feather icon-search text-light"></i></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="feather icon-maximize full-screen text-light"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="feather icon-bell text-light"></i>
                                        <span class="badge bg-c-pink">5</span>
                                    </div>
                                    <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <h6>Notifications</h6>
                                            <label class="label label-danger">New</label>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <img class="d-flex align-self-center img-radius" src="..\files\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h5 class="notification-user">John Doe</h5>
                                                    <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                    <span class="notification-time">30 minutes ago</span>
                                                </div>
                                            </div>
                                        </li>
                                    
                                    </ul>
                                </div>
                            </li>
                          
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <?php $id = Auth::user()->id;
                                        $path = \collect(DB::select("select f.path from admin.users a join admin.company_files f on a.company_file_id = f.id where a.id = '$id'"))->first(); 
                                        $local = $root . 'assets/images/user.png';
                                        ?>
                                        <img class="img-40" src="<?= isset($path->path) && ($path->path != '')  ? $path->path : $local ?>" alt="User-Profile-Image"> 
                                        <span class="text-light"><?= \Auth::user()->name ?></span>
                                        <i class="feather icon-chevron-down text-light"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="#!">
                                                <i class="feather icon-settings"></i> Settings
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= url('users/show/' . Auth::user()->id) ?>">
                                                <i class="feather icon-user"></i> Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a href="email-inbox.htm">
                                                <i class="feather icon-mail"></i> My Messages
                                            </a>
                                        </li>
                                     
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();"><i class="feather icon-log-out"></i> Logout</a>
                                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                   {{ csrf_field() }}
                                              </form>
                                        </li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar" >
                        <div class="pcoded-inner-navbar main-menu" style="background-color: #2C3E50;">
                            <div class="pcoded-navigatio-lavel">menu</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                  <?php if (can_access('view_home_dashboard')) { ?>
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">DASHBOARD</span>
                                    </a>
                                   <?php } ?>
                                    <ul class="pcoded-submenu">
                                        <?php if (can_access('view_home_dashboard')) { ?>
                                        <li class="active">
                                            <a href="<?= url('analyse/index') ?>">
                                                <span class="pcoded-mtext">Home</span>
                                            </a>
                                        </li>
                                        <?php } if ((can_access('view_marketing_dashboard') || Auth::user()->department == 2) && Auth::user()->role_id <> 3) { ?>
                                        <li class="">
                                            <a href="<?= url('analyse/marketing') ?>">
                                                <span class="pcoded-mtext">Marketing</span>
                                            </a>
                                        </li>
                                         <?php } if (can_access('view_sales_dashboard') || Auth::user()->department == 2) { ?>
                                        <li class=" ">
                                            <a  href="<?= url('analyse/sales') ?>">
                                                <span class="pcoded-mtext">Sales</span>
                                            </a>
                                        </li>
                                        <?php } if (can_access('view_accounts_dashboard') || Auth::user()->department == 4) { ?>
                                         <li class=" ">
                                            <a href="<?= url('analyse/accounts') ?>">
                                                <span class="pcoded-mtext">Accounts</span>
                                            </a>
                                        </li>
                                         <?php } if (can_access('view_customer_dashboard') || Auth::user()->department == 1) { ?>
                                        <li class=" ">
                                            <a href="<?= url('analyse/customers') ?>">
                                                <span class="pcoded-mtext">Customers</span>
                                            </a>
                                        </li>
                                         <?php } if (!can_access('view_engineering_dashboard'))  { ?>
                                          <li class=" ">
                                            <a href="<?= url('analyse/software') ?>">
                                                <span class="pcoded-mtext">Engineering</span>
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>

                            
                              <?php if (can_access('manage_marketing')) { ?>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                                        <span class="pcoded-mtext">MARKETING</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext text-bold">Sales</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('sales/index') ?>">
                                                       <span class="pcoded-mtext">Sales materials</span>
                                                    </a>
                                                 </li>
                                             
                                                <?php if (can_access('onboard_school')) { ?>
                                                 <li class="">
                                                    <a href="<?= url('sales/school') ?>">
                                                        <span class="pcoded-mtext">List of Schools</span>
                                                    </a>
                                                  </li>
                                                <?php } ?>

                                                <li class="">
                                                    <a href="<?= url('sales/salesStatus') ?>">
                                                       <span class="pcoded-mtext">Sales Status</span>
                                                    </a>
                                                 </li>
                                            </ul>
                                        </li>

                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Usage and analysis</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class=" ">
                                                    <a href="<?= url('marketing/moduleusage') ?>">
                                                        <span class="pcoded-mtext">Usage analysis</span>
                                                    </a>
                                                </li>
                                             
                                                <li class=" ">
                                                    <a href="<?= url('customer/modules') ?>">
                                                        <span class="pcoded-mtext">Modules</span>
                                                    </a>
                                                </li>

                                                 <li class=" ">
                                                    <a href="<?= url('customer/logs') ?>">
                                                        <span class="pcoded-mtext">Task logs</span>
                                                    </a>
                                                </li>

                                                <li class=" ">
                                                    <a href="<?= url('customer/karibu') ?>">
                                                        <span class="pcoded-mtext">karibuSMS</span>
                                                    </a>
                                                </li>

                                                <li class=" ">
                                                    <a href="<?= url('customer/epayments') ?>">
                                                        <span class="pcoded-mtext">e-payments</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                       <?php if (can_access('manage_communications')) { ?>
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Communications</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('marketing/communication') ?>">
                                                        <span class="pcoded-mtext">Communication</span>
                                                    </a>
                                                </li>
                                             
                                                <li class="">
                                                    <a href="<?= url('customer/calls') ?>">
                                                        <span class="pcoded-mtext">Call logs</span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('customer/emailsms') ?>">
                                                        <span class="pcoded-mtext">SMS & Email logs</span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('customer/feedbacks/null') ?>">
                                                        <span class="pcoded-mtext">Customer feedbacks</span>
                                                    </a>
                                                </li>

                                                  <li class="">
                                                    <a href="<?= url('customer/update') ?>">
                                                        <span class="pcoded-mtext">Updates</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                     <?php } ?>

                                        <li class=" ">
                                            <a href="<?= url('marketing/socialmedia') ?>">
                                                <span class="pcoded-mtext">Digital marketing</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="<?= url('analyse/ratings') ?>">
                                                <span class="pcoded-mtext">Ratings</span>
                                            </a>
                                        </li>

                                          <li class="">
                                            <a href="#">
                                                <span class="pcoded-mtext">Parental experience</span>
                                            </a>
                                        </li>

                                        <li class="">
                                           <a href="<?= url('sales/salesstatus') ?>">
                                                <span class="pcoded-mtext">Sales status</span>
                                           </a>
                                        </li>

                                        <li class="">
                                           <a href="<?= url('customer/requirements') ?>">
                                                <span class="pcoded-mtext">Customer Requirements</span>
                                           </a>
                                        </li>

                                       <li class="">
                                           <a href="<?= url('marketing/events') ?>">
                                                <span class="pcoded-mtext">Events and seminars</span>
                                           </a>
                                        </li>
                                      
                                    </ul>
                                </li>
                                <?php }  ?>

                                <li class="">
                                    <a href="navbar-light.htm">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">OPERATIONS</span>
                                    </a>
                                </li>

                                  <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                                        <span class="pcoded-mtext">ENGINEERING</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" ">
                                            <a href="widget-statistic.htm">
                                                <span class="pcoded-mtext">Statistic</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="widget-data.htm">
                                                <span class="pcoded-mtext">Data</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="widget-chart.htm">
                                                <span class="pcoded-mtext">Chart Widget</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                 
                              <?php if (can_access('manage_finance')) { ?>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-book"></i></span>
                                        <span class="pcoded-mtext">ACCOUNTING</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" ">
                                            <a href="<?= url('account/invoice') ?>">
                                                <span class="pcoded-mtext">Invoice</span>
                                            </a>
                                        </li>
                                          
                                          <li class=" ">
                                            <a href="<?= url('account/standingOrders') ?>">
                                                <span class="pcoded-mtext">Standing order</span>
                                            </a>
                                        </li>

                                        
                                       <?php if (!can_access('manage_transactions')) { ?>
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Transactions</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('revenue/index') ?>">
                                                        <span class="pcoded-mtext">Revenue</span>
                                                    </a>
                                                </li>
                                             
                                                <li class="">
                                                    <a href="<?= url('expense/index/4') ?>">
                                                        <span class="pcoded-mtext">  Expense</span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('account/transaction/1') ?>">
                                                        <span class="pcoded-mtext">  Fixed assets</span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('account/transaction/5') ?>">
                                                        <span class="pcoded-mtext"> Current assets</span>
                                                    </a>
                                                </li>

                                                  <li class="">
                                                    <a href="<?= url('account/transaction/2') ?>">
                                                        <span class="pcoded-mtext">Liabilities</span>
                                                    </a>
                                                </li>

                                                    <li class="">
                                                    <a href="<?= url('account/transaction/3') ?>">
                                                        <span class="pcoded-mtext"> Capital</span>
                                                    </a>
                                                </li>

                                                  <li class="">
                                                    <a href="<?= url('account/reconciliation') ?>">
                                                        <span class="pcoded-mtext">Reconciliation</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                     <?php } ?>

                                              
                                       <?php if (can_access('manage_payroll')) { ?>
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Payroll</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('payroll/taxes') ?>">
                                                        <span class="pcoded-mtext">TAX</span>
                                                    </a>
                                                </li>
                                             
                                                <li class="">
                                                    <a href="<?= url('payroll/pension') ?>">
                                                        <span class="pcoded-mtext">  Pension Fund </span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('allowance/index') ?>">
                                                        <span class="pcoded-mtext">  Allowances </span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('deduction/index') ?>">
                                                        <span class="pcoded-mtext"> Deductions </span>
                                                    </a>
                                                </li>

                                                  <li class="">
                                                    <a href="<?= url('Payroll/index') ?>">
                                                        <span class="pcoded-mtext">Salaries</span>
                                                    </a>
                                                </li>

                                             <li class=" pcoded-hasmenu">
                                               <a href="javascript:void(0)">
                                                 <span class="pcoded-mtext text-bold">Loans</span>
                                               </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('sales/index') ?>">
                                                       <span class="pcoded-mtext">Sales materials</span>
                                                    </a>
                                                 </li>
                                             
                                                <?php if (can_access('onboard_school')) { ?>
                                                 <li class="">
                                                    <a href="<?= url('sales/school') ?>">
                                                        <span class="pcoded-mtext">List of Schools</span>
                                                    </a>
                                                  </li>
                                                <?php } ?>

                                                <li class="">
                                                    <a href="<?= url('sales/salesStatus') ?>">
                                                       <span class="pcoded-mtext">Sales Status</span>
                                                    </a>
                                                 </li>
                                            </ul>
                                        </li>

                                               

                                            </ul>
                                        </li>
                                     <?php } ?>

                                      
                                    </ul>
                                </li>
                               <?php } ?>

                            </ul>
                        </div>
                    </nav>

                      <div class="pcoded-content">
                        <div class="pcoded-inner-content">

                          <div class="main-body">
                              {{-- @include('layouts.notifications') --}}
                              @yield('content')
                          </div>

                        </div>
                      </div>

                    </div>
                </div>
            </div>
             
        </div>   

    <script type="text/javascript" src="<?= $root ?>/files/bower_components/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>/files/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>/files/bower_components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>/files/bower_components/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>/files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="<?= $root ?>/files/bower_components/modernizr/js/modernizr.js"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="<?= $root ?>/files/bower_components/chart.js/js/Chart.js"></script>
    <script src="<?= $root ?>/files/assets/pages/widget/amchart/amcharts.js"></script>
    <script src="<?= $root ?>/files/assets/pages/widget/amchart/serial.js"></script>
    <script src="<?= $root ?>/files/assets/pages/widget/amchart/light.js"></script>
    <script src="<?= $root ?>/files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>/files/assets/js/SmoothScroll.js"></script>
    <script src="<?= $root ?>/files/assets/js/pcoded.min.js"></script>
    <script src="<?= $root ?>/files/assets/js/vartical-layout.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>/files/assets/pages/dashboard/custom-dashboard.js"></script>
    <script type="text/javascript" src="<?= $root ?>/files/assets/js/script.min.js"></script>

     {{-- Datatables --}}
   
    <script src="<?= $root ?>/files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= $root ?>/files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= $root ?>/files/assets/pages/data-table/js/jszip.min.js"></script>
    <script src="<?= $root ?>/files/assets/pages/data-table/js/pdfmake.min.js"></script>
    <script src="<?= $root ?>/files/assets/pages/data-table/js/vfs_fonts.js"></script>
    <script src="<?= $root ?>/files/assets/pages/thousandth/thousands.js"></script>
    <script src="<?= $root ?>/files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= $root ?>/files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= $root ?>/files/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= $root ?>/files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= $root ?>/files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <script type="text/javascript" src="<?= $root ?>/files/bower_components/select2/js/select2.full.min.js'); ?>"></script>


    

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

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            


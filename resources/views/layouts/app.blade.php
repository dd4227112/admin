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
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="keywords" content="ShuleSoft, Admin, Admin Panel">
        <meta name="author" content="ShuleSoft">
        <!-- Favicon icon -->
        <link rel="icon" href="<?= $root ?>assets/images/favicon.ico" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <!-- Required Fremwork -->

        {{-- <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/bootstrap/dist/css/bootstrap.min.css">   --}}
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/bower_components/bootstrap/css/bootstrap.min.css">  

        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/menu-search/css/component.css">


        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/assets/icon/feather/css/feather.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/assets/icon/icofont/css/icofont.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/assets/css/jquery.mCustomScrollbar.css">


        {{-- databables --}}
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/data-table/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
 

        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2.css">
        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/gh-pages.css"> 

        <link href="<?= url('public') ?>/bower_components/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">

        <script type="text/javascript" src="<?= $root ?>/files/bower_components/jquery/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?= $root ?>/files/bower_components/jquery-ui/js/jquery-ui.min.js"></script>  

        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
       
        {{-- highcharts --}}
         <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/series-label.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script src="https://code.highcharts.com/highcharts-3d.js"></script>

         {{-- select 2 --}}
        <script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script> 

       <link rel="stylesheet" href="<?= $root ?>/files/bower_components/select2/css/select2.min.css">
        <!-- Multi Select css -->
       <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css">
       <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/bower_components/multiselect/css/multi-select.css">

        {{--  alert --}}
       <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
       <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> 
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

      {{-- <style>
          .image {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 240px;
                height: 240px;
                margin:-60px 0 0 -60px;
                -webkit-animation:spin 20s linear infinite;
                -moz-animation:spin 10s linear infinite;
                animation:spin 10s linear infinite;
            }
            @-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
            @-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
            @keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }
      </style>
          
       <div class="theme-loader itext-center">
        <div class="ball-scale justify-content-center">
            <div class='contain'>
                <img class="image" width="400" height="400" src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="ShuleSoft">
            </div>
        </div>
    </div>     --}}


    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

          

        @include('components.header')
                    @include('components.menu')
                      <div class="pcoded-content">
                        <div class="pcoded-inner-content">

                          <div class="main-body">
                       
                        <div class="page-wrapper">
                              @yield('content')
                          </div>
                          </div>
                        </div>
                      </div>

                    </div>
                </div>
            </div>
        </div>  
        @include('components.footer')
          
 
            
            
            
            
            


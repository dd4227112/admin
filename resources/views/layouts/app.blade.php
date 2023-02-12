<?php $root =  'http://admin.shulesoft.co/public/';
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
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/bower_components/bootstrap/css/bootstrap.min.css?v=3">  

        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/menu-search/css/component.css?v=4">


        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/assets/icon/feather/css/feather.css?v=4">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/assets/icon/icofont/css/icofont.css?v=4">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/assets/css/style.css?v=4">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/assets/css/jquery.mCustomScrollbar.css?v=4">


        {{-- databables --}}
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css?v=4">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/data-table/css/buttons.dataTables.min.css?v=4">
        <link rel="stylesheet" type="text/css" href="<?= $root ?>/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css?v=4">
 

        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2.css?v=4">
        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/gh-pages.css?v=4"> 

        <link href="<?= url('public') ?>/bower_components/clockpicker/dist/jquery-clockpicker.min.css?v=4" rel="stylesheet">

        <script type="text/javascript" src="<?= $root ?>/files/bower_components/jquery/js/jquery.min.js?v=4"></script>
        <script type="text/javascript" src="<?= $root ?>/files/bower_components/jquery-ui/js/jquery-ui.min.js?v=4"></script>  

        <link rel="stylesheet" type="text/css" href="https://cdn.js?v=4delivr.net/npm/daterangepicker/daterangepicker.css?v=4" />
        <script type="text/javascript" src="https://cdn.js?v=4delivr.net/momentjs/latest/moment.min.js?v=4"></script>
        <script type="text/javascript" src="https://cdn.js?v=4delivr.net/npm/daterangepicker/daterangepicker.min.js?v=4"></script>
       
        {{-- highcharts --}}
         <script src="https://code.highcharts.com/highcharts.js?v=4"></script>
        <script src="https://code.highcharts.com/modules/series-label.js?v=4"></script>
        <script src="https://code.highcharts.com/modules/exporting.js?v=4"></script>
        <script src="https://code.highcharts.com/modules/export-data.js?v=4"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js?v=4"></script>
        <script src="https://code.highcharts.com/highcharts-3d.js?v=4"></script>

         {{-- select 2 --}}
        <script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js?v=4'); ?>"></script> 

       <link rel="stylesheet" href="<?= $root ?>/files/bower_components/select2/css/select2.min.css?v=4">
        <!-- Multi Select css -->
       <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css?v=4">
       <link rel="stylesheet" type="text/css" href="<?= $root ?>/files/bower_components/multiselect/css/multi-select.css?v=4">

        {{--  alert --}}
       <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js?v=4/latest/toastr.min.css?v=4">
       <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js?v=4/latest/js/toastr.min.js?v=4"></script> 
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
          
 
            
            
            
            
            


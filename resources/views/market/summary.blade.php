<?php $root = url('/') . '/public/' ?>


<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

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


    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="white-box m-b-0 bg-success">
                <h3 class="text-white box-title" align="center" style="padding-top: 2em">Conglatulations for registering!!! We glad to have you.'); </h3>
                <div id="sparkline2dash" class="text-center">
                    <canvas width="215" height="70" style="display: inline-block; width: 215px; height: 70px; vertical-align: top;"></canvas>
                </div>
            </div>
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <!--<img src="{{url('public/files/sustain.jpeg')}}"/>-->
<div class="text-muted m-t-20"><br/><br/></div>
                            <h2>
                                <a href="{{url('public/files/sustain.jpeg')}}" download target="_blank" class="btn btn-primary" ><i class="fa fa-download"></i>Download Presentation</a>
                                 <a href="https://shulesoft.com" class="btn btn-success" ><i class="fa fa-link"></i>Close</a>
    </h2>
                    </div>
                        <div data-label="60%" class="css-bar css-bar-60 css-bar-lg m-b-0  css-bar-info pull-right"></div>
                    </div>  
                     <div class="col-lg-3"></div>
                </div>
            </div>
        </div>
    </div>


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

</body>
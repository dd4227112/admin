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
                               
                                <li class="user-profile header-notification">
                                    <a href="#!">
                                        <img src="<?= $root ?>assets/images/user.png" alt="User-Profile-Image">
                                        <span>{{ $user->name() }}</span>
                                      
                                    </a>

                                 

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
                        <span>{{ $user->name() }}</span>
                        <span id="more-details"> <?php // $user->role->display_name            ?></span>
                    </div>
                </div>
                <div class="main-menu-content">
                    <ul class="main-navigation"></ul>
                </div>
            </div>
            <!-- Menu aside end -->
            <!-- Sidebar chat start -->
          
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
        <?php }} ?>
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
    </head>
    <div class="row">
        <p><?= ucfirst($schema)?> Daily Report</p>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Users</h3>
                <div class="text-right"> <span class="text-muted">Total Users</span>
                    <h1><sup><i class="ti-arrow-up text-success"></i></sup> <?= $users ?></h1> </div> <span class="text-success">20%</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only"><?= $added_users ?> Added Today</span> </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Students</h3>
                <div class="text-right"> <span class="text-muted">Total Students</span>
                    <h1><sup><i class="ti-arrow-up text-success"></i></sup><?= $birthday ?></h1> </div> <span class="text-success">20%</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only">20% Complete</span> </div>
                </div>
            </div>
        </div>


        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Revenue</h3>
                <div class="text-right"> <span class="text-muted">Today Revenue</span>
                    <h1><sup><i class="ti-arrow-up text-info"></i></sup><?= $revenue->sum == null ? 0 : $revenue->sum ?></h1> </div> <span class="text-info">60%</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:60%;"> <span class="sr-only">20% Complete</span> </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Expense</h3>
                <div class="text-right"> <span class="text-muted">Today Expense</span>
                    <h1><sup><i class="ti-arrow-up text-inverse"></i></sup><?= $expense->sum == null ? 0 : $expense->sum ?></h1> </div> <span class="text-inverse">80%</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span class="sr-only">230% Complete</span> </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">ShuleSoft</h3>
                <div class="text-right"> <span class="text-muted">Todays total requests</span>
                    <h1><sup><i class="ti-arrow-up text-success"></i></sup><?= $logs ?></h1> </div> <span class="text-success">20%</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only"><?= $log_parents ?></i> From parents</span> </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Birthdays</h3>
                <div class="text-right"> <span class="text-muted">Todays Birthdays</span>
                    <h1><sup><i class="ti-arrow-up text-success"></i></sup><?= $birthday ?></h1> </div> <span class="text-success">20%</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only">20% Complete</span> </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="white-box">
                <h3 class="box-title"><small class="pull-right m-t-10 text-success"><i class="fa fa-sort-asc"></i> 18% High then last month</small> SMS & EMAILS</h3>
                <div class="stats-row">
                    <div class="stat-item">
                        <h6>Total SMS sent</h6> <b><?= $total_sms ?></b></div>
                    <div class="stat-item">
                        <h6>SMS sent Today</h6> <b><?= $sms ?></b></div>
                    <div class="stat-item">
                        <h6>Emails Sent Today</h6> <b><?= $email ?></b></div>
                </div>

            </div>

        </div>
    </div>
    <div class="comment-body">
        <div class="mail-contnet">
            <h5>By ShuleSoft</h5><span class="time">Sent: <?= date('d M Y h:m') ?></span>
            <br><span class="mail-desc">For more information, please login into your account.</span> ShuleSoft is a cloud based School management software that help schools to organize their information, generate different reports and statistics to help decision makers </div>
    </div>

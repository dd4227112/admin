@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="<?= url('/public/') ?>/assets/pages/timeline/style.css">
<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Notifications For your Tasks and Activities</h4>
                <span>Please note issues not attended and work to resolve them</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">User</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Notifications</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Timeline</h5>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                                <i class="icofont icofont-close-circled"></i>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="main-timeline">
                                <div class="cd-timeline cd-container">
                                    <?php
                                    foreach ($tasks as $task) {
                                        ?>
                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-icon bg-primary">
                                                <i class="icofont icofont-ui-file"></i>
                                            </div>
                                            <!-- cd-timeline-img -->
                                            <div class="cd-timeline-content card_main">
                                                <img src="assets/images/timeline/img1.jpg" class="img-fluid width-100" alt="">
                                                <div class="card-block">
                                                    <h6>Client: <?= $task->client->name ?></h6>
                                                    <div class="timeline-details">
                                                        <a href="#"> <i class="icofont icofont-ui-calendar"></i><span><?= date('d M Y', strtotime($task->created_at)) ?></span> </a>
                                                        <a href="#">
                                                            <i class="icofont icofont-ui-user"></i><span><?= $task->user->name ?><</span>
                                                        </a>
                                                        <p class="m-t-20"><?= $task->activity ?>.</p>
                                                    </div>
                                                </div>
                                                <span class="cd-date"><?=isset($task->date) ? date('d M Y', strtotime($task->date)):'' ?></span>
                                                <span class="cd-details"> <?= $task->taskType->name ?></span>
                                            </div>
                                            <!-- cd-timeline-content -->
                                        </div>
                                    <?php } ?>
                                   
                                </div>
                                <!-- cd-timeline -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
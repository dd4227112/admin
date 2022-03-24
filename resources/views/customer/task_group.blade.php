@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>ShuleSoft Feedbacks</h4>
                <span>This shows teachers, users and parents feedbacks</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Customer </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Feedbacks</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-border-primary">
                                    <div class="card-header">
                                        <h5>My User Activities</h5>
                                    </div>
                                        <div class="card-block">
                                        <?php
                                                $i = 1;
                                                if(sizeof($activities)){
                                                    foreach ($activities as $act){
                                                    ?>
                                        <div class="media chat-messages">
                                        <a class="media-left photo-table" href="#!">
                                        <img class="media-object img-circle m-t-5" src="<?= $root?>assets/images/avatar-1.png" alt="Image">
                                        </a>
                                        <div class="media-body chat-menu-content">
                                            <div class="">
                                                <p class="chat-cont"><?=$act->activity ?><br>
                                                <b>Task</b> - <?=$act->tasktype->name?>   &nbsp; &nbsp; &nbsp; &nbsp;
                                                <b>User</b> - <?=$act->user->name?>   &nbsp; &nbsp; &nbsp; &nbsp;
                                                <b>Time</b> - <?=timeAgo($act->created_at)?>   &nbsp; &nbsp; &nbsp; &nbsp;
                                                <b>Status</b> - <?=ucfirst($act->status)?>   &nbsp; &nbsp; &nbsp; &nbsp;
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <?php } ?>
                                    </div>

                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


    @endsection

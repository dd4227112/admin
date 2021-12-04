@extends('layouts.app')
@section('content')

<?php $root = url('/') . '/public/' ?>


    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-header-title">
            <h4>School </h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Sales</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">School Profile</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">

    <div class="row">
        <div class="col-lg-12">
            <!-- Default card start -->
            <div class="card">                            
                <div class="card-block">
                   <div class="col-md-6 col-xl-4">
                        <div class="card group-widget">
                           
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12">
                        <div class="col-sm-12">
                                <div class="card borderless-card">
                                    <div class="card-block-big bg-primary quick-note-card">
                                         <div class="card-block-big bg-info text-center">
                                <h1><?=$trial_code?></h1>
                                <h6 class="m-t-10">Trial Code</h6>
                            </div>
                                        <h6> </h6>
                                        <h2>Click the  Install button to proceed With ShuleSoft Installation</h2>
                                        <div class="text-right">
                                            <a class="btn btn-primary btn-outline-primary" href="<?= url('https://' . $client->username . '.shulesoft.com')?>" target="_blank">Install</a>
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
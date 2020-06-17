
@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/';
?>
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-title">
            <h4>Human Resources </h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Users</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Applicants</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="page-body">
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="card" style="height: 65em"> 
                    <div class="card-block tab-icon">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <!-- <h6 class="sub-title">Tab With Icon</h6> -->
                                <div class="sub-title">Budget & Projections</div>                                        
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs md-tabs " role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"><i class="icofont icofont-home"></i>Google Sheet Applicants</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#profile7" role="tab"><i class="icofont icofont-ui-user "></i>Actuals</a>
                                        <div class="slide"></div>
                                    </li>

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content card-block">
                                    <div class="tab-pane active" id="home7" role="tabpanel">
                                        <div class="card-header">
                                            <h5>List of Applicants</h5>
                                            <span>This part shows list of all applicants interested to work with us </span>

                                        </div>
                                        <div class="card-block"  style="height: 35em">
                                    <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vTTsUoeCF2H7hAVSceAnhtkBwD8MUukEk_uN5GsV4vimu6KUxTWMpBVlNA3Cld8uKRTN8Xu-rn_k6oj/pubhtml?widget=true&amp;headers=false" height='100%' width="100%"></iframe>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="profile7" role="tabpanel">
                                        <div class="card-block">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row end -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


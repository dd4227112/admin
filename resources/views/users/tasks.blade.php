
@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/';
?>
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-title">
            <h4>Tasks Management </h4>
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
                <li class="breadcrumb-item"><a href="#!">Tasks</a>
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
                                <div class="sub-title">Tasks Management</div>                                        
                                
                                <div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://projects.inetstz.com/" allowfullscreen></iframe>
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


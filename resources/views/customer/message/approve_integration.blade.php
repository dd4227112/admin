@extends('layouts.app')
@section('content')
<?php
?>
<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Customers</h4>
                <span>Whatsapp integration requests</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Customer</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Whatsapp</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card rd">

                        <div class="tab-content">
                            <div class="card-block">
                                <div class="steamline">


                                    <div class="card-block">

                                  
                                            <form id="second" action="<?= url('customer/approveIntegration') ?>" method="post" novalidate="">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">API url</label>
                                                    <div class="col-sm-10">
                                                        <input type="url" class="form-control" id="usernameP" name="url" placeholder="Enter url">
                                                        <span class="messages popover-valid"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">API Token</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="EmailP" name="token" placeholder="Enter token">
                                                        <span class="messages popover-valid"></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-2"></label>
                                                    <div class="col-sm-10">
                                                        <input name="id" value="<?= $request->id ?>" type="hidden">
                                                        <input name="phone" value="<?= $request->phone_number ?>" type="hidden">
                                                        <input name="schema_name" value="<?= $request->schema_name ?>" type="hidden">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                                                    </div>
                                                </div>
                                            </form>   
                                    
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>



                </div>
            </div>
            <!-- Page-body end -->
        </div>
    </div>

    @endsection
    @section('footer')
    @endsection
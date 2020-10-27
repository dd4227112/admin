@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Sales Materials</h4>
                <span>Use this part to get all important informed decision</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Sales</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Analysis</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">

                            <div class="col-lg-12 col-xl-12">
                                <div class="sub-title">ShuleSoft Important Materials</div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs md-tabs tabs-left b-none" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#home5" role="tab">Manuals</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#profile5" role="tab">Legals</a>
                                        <div class="slide"></div>
                                    </li>
<!--                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#messages5" role="tab">Scripts</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#settings5" role="tab">FAQ</a>
                                        <div class="slide"></div>
                                    </li>-->
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabs-left-content card-block">
                                    <div class="tab-pane active" id="home5" role="tabpanel">
                                        <div class="row">
                                           

                                           
                                            <?=$records?>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="profile5" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-4 col-xl-3 col-sm-6">
                                                <div class="badge-box">
                                                    <div class="sub-title">ShuleSoft Agreement Form

                                                    </div>

                                                    <p>
                                                        Also called, Acceptance Form, provide this to customer interested to start using ShuleSoft
                                                    </p>
                                                    <a href="https://drive.google.com/file/d/16tgURq3lyVOmAc-Tp0Bc4aaWUG69v8Rw/view?usp=sharing"  target="_blank" class="badge badge-warning">Download (V 1.0)</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-xl-3 col-sm-6">
                                                <div class="badge-box">
                                                    <div class="sub-title">ShuleSoft Grace Period Form

                                                    </div>

                                                    <p>
                                                        provide this to customer interested to start using ShuleSoft but needs a grace or trial period
                                                    </p>
                                                      <a href="https://drive.google.com/file/d/1eby-E3YzjffrvCqapTBL6820WhrDnq10/view?usp=sharing"  target="_blank" class="badge badge-warning">Download (V 1.0)</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-xl-3 col-sm-6">
                                                <div class="badge-box">
                                                    <div class="sub-title">Introduction Letter

                                                    </div>

                                                    <p>
                                                        provide this to customer interested to start using ShuleSoft but needs a grace or trial period
                                                    </p>
                                                      <a href="{{url('downloadMaterial/introduction_letter')}}"  target="_blank" class="badge badge-warning">Download (V 1.0)</a>
                                                </div>
                                            </div>
                                        
                                           
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="messages5" role="tabpanel">
                                        <p class="m-0">3. This is Photoshop's version of Lorem IpThis is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean mas Cum sociis natoque penatibus et magnis dis.....</p>
                                    </div>
                                    <div class="tab-pane" id="settings5" role="tabpanel">
                                        <p class="m-0">4.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
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
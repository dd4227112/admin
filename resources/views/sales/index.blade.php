@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">

     <div class="page-header">
            <div class="page-header-title">
                <h4><?=' Sales Materials' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">materials</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">marketing</a>
                    </li>
                </ul>
            </div>
        </div> 
     

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

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabs-left-content card-block">
                                    <div class="tab-pane active" id="home5" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-4 col-xl-3 col-sm-12">
                                                <div class="badge-box">
                                                    <div class="sub-title">
                                                        Sales Manual

                                                    </div>

                                                    <p>
                                                        This provides a guide on how to do sales effectively and win customers
                                                    </p>
                                                    <a href="https://drive.google.com/file/d/1xu1mWmRIt96Na8EkFcr3rW8Xw3dOy500/view?usp=sharing" target="_blank" class="badge badge-success">Download (V 2.2)</a>
                                                </div>
                                            </div>


                                            <div class="col-lg-4 col-xl-3 col-sm-6">
                                                <div class="badge-box">
                                                    <div class="sub-title">ShuleSoft Proposal

                                                    </div>

                                                    <p>
                                                        If you have a presentation like an event, you can use this to be in a flow easily.
                                                    </p>
                                                   <a href="https://drive.google.com/file/d/19_46LuHyXOikevG5nDIDcsrbIgRRKQSx/view?usp=sharing" target="_blank" class="badge badge-warning">Download (V 1.0)</a> 
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-xl-3 col-sm-6">
                                                <div class="badge-box">
                                                    <div class="sub-title">ShuleSoft Presentation

                                                    </div>

                                                    <p>
                                                        This provides a guide on how to do sales effectively and win customers
                                                    </p>
                                                <a href="https://drive.google.com/file/d/1zj2n1mAuaxtoAvRnLu97KAQP_Mvy4Fdc/view?usp=sharing" target="_blank" class="badge badge-warning">Download (V 1.0)</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-xl-3 col-sm-6">
                                                <div class="badge-box">
                                                    <div class="sub-title">ShuleSoft Product Profile

                                                    </div>

                                                    <p>
                                                        Use this as an alternative to demonstration, showing customers how system is
                                                    </p>
                                                    <a href="https://drive.google.com/file/d/1lZ2cYxKHrQd7Jc5Q_8sc1U8PuOS8_EaG/view?usp=sharing" target="_blank" class="badge badge-warning">Download (V 1.0)</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-xl-3 col-sm-6">
                                                <div class="badge-box">
                                                    <div class="sub-title">ShuleSoft Brochure

                                                    </div>

                                                    <p>
                                               Customers who needs a formal introduction letter, download this letter and change school name with a school name you submit. This letter is already signed and sealed.
                                                    </p>
                                                    <a href="https://drive.google.com/file/d/16FrZl_mkC5t92n66ZieI0I1L2Ol0zmV1/view?usp=sharing" target="_blank" class="badge badge-warning">Download (V 1.0)</a>
                                                </div>
                                            </div>

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
                                            <?php if(!preg_match('/crdb/', Auth::user()->email)){ ?>
                                            <div class="col-lg-4 col-xl-3 col-sm-6">
                                                <div class="badge-box">
                                                    <div class="sub-title">ShuleSoft NMB Application Form

                                                    </div>

                                                    <p>
                                                       For school that needs an application with NMB BANK or sales done with NMB Bank partnership
                                                    </p>
                                                      <a href="https://drive.google.com/file/d/1DlSsOI_UFehOFmcd1U7Bbzr4Og5-6fa1/view?usp=sharing"  target="_blank" class="badge badge-warning">Download (V 2.0)</a>
                                                </div>
                                            </div>
                                            <?php }
                                                 if(!preg_match('/nmb/', Auth::user()->email)){ 
                                                     ?>
                                            <div class="col-lg-4 col-xl-3 col-sm-6">
                                                <div class="badge-box">
                                                    <div class="sub-title">ShuleSoft CRBD Application Form

                                                    </div>

                                                    <p>
                                                       For school that needs an application with CRDB BANK or sales done with CRDB Bank partnership
                                                    </p>
                                                      <a href="https://shulesoft.s3.amazonaws.com/company/contracts/JTQL0yIbK0E6rKZcnXfmVJzTTT1YvRSb3vsqgoEF.pdf"  target="_blank" class="badge badge-warning">Download (V 2.0)</a>
                                                </div>
                                            </div>
                                                 <?php } ?>
                                            <div class="col-lg-4 col-xl-3 col-sm-6">
                                                <div class="badge-box">
                                                    <div class="sub-title">Introduction Letter

                                                    </div>

                                                    <p>
                                                        provide this to customer interested to start using ShuleSoft but needs a grace or trial period
                                                    </p>
                                                      <a href="https://drive.google.com/file/d/1oRHWY6nt9h5ddQZ7Jjv9VK6XHXdsB0tT/view?usp=sharing"  target="_blank" class="badge badge-warning">Download (V 1.0)</a>
                                                </div>
                                            </div>
                                        <div class="col-lg-4 col-xl-3 col-sm-6">
                                                <div class="badge-box">
                                                    <div class="sub-title">Standing Order Instruction Form

                                                    </div>

                                                    <p>
                                                        Any customer must submit a standing order form together with an agreement form for system to be offered
                                                    </p>
                                                      <a href="https://drive.google.com/file/d/1FKvv0xIzaT7Os_5EwCmteXuPsNXbN6wM/view?usp=sharing"  target="_blank" class="badge badge-warning">Download (V 1.0)</a>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="messages5" role="tabpanel">
                                        <!--<p class="m-0">3. This is Photoshop's version of Lorem IpThis is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean mas Cum sociis natoque penatibus et magnis dis.....</p>-->
                                    </div>
                                    <div class="tab-pane" id="settings5" role="tabpanel">
                                        <!--<p class="m-0">4.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>-->
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
@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">WhatsApp</h4>
                <span></span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">WhatsApp</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Link Whatsapp Business</a>
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

  <!--<iframe src="https://app.chat-api.com/instance/210904" width='100%' height=''/>-->
                        <iframe src="https://app.chat-api.com/instance/210904" height="600" id="myiFrame" onload="changefocus()"></iframe>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function changefocus() {
        alert('is loaded');
        $('#main').hide();
    }
</script>
@endsection

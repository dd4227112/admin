@extends('layouts.app')
@section('content')

<!-- .row -->
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">Introduction</h3> 
            This part allows you to download all necessary and important materials that you may need when you talk to your customers. You are recommended to print these materials when necessary </div>
    </div>
</div>
<!-- /.row -->


<!-- .row -->
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <!-- Tabstyle start -->
            <h3 class="box-title m-b-0">BRANDS</h3>
            <hr>
            <section>
                <div class="sttabs tabs-style-bar">
                    <nav>
                        <ul>
                            <li class="tab-current"><a href="#section-bar-1" class="sticon ti-home"><span>IDENTITY CARD </span></a></li>
                            <li class=""><a href="#section-bar-2" class="sticon ti-trash"><span>BUSINESS CARDS</span></a></li>
                            <li><a href="#section-bar-3" class="sticon ti-stats-up"><span>APPROVED LETTER</span></a></li>
                            <li><a href="#section-bar-4" class="sticon ti-upload"><span>T-SHIRT</span></a></li>
                            <li><a href="#section-bar-5" class="sticon ti-settings"><span>AWARDS</span></a></li>
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="section-bar-1" class="content-current">
                            <h3>Your ID from ShuleSoft</h3>
                            <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                        </section>
                        <section id="section-bar-2" class="">
                            <h2>BUSINESS CARD</h2></section>
                        <section id="section-bar-3">
                            <h2>APPROVED LETTER from ShuleSoft</h2></section>
                        <section id="section-bar-4">
                            <h2>Request your ShuleSoft T-shirt</h2></section>
                        <section id="section-bar-5">
                            <h2>Company Awards and Recognitions</h2></section>
                    </div>
                    <!-- /content -->
                </div>
                <!-- /tabs -->
            </section>
            <!-- Tabstyle start -->
            <hr>
          
 
        </div>
    </div>
</div>

@endsection
@section('footer')
<?php $root = url('/') . '/public/' ?>
<script src="<?= $root ?>js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?= $root ?>js/cbpFWTabs.js"></script>
<script type="text/javascript">
    (function () {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });
    })();
</script>
@endsection
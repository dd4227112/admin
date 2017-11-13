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
    <div class="col-lg-4 col-sm-4">
        <div class="panel panel-info">
            <div class="panel-heading"> Grace Period Form
                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
            </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <p>When any school needs a grace period, they MUST fill this form accordingly. You also need to sign this form in your area. All forms have to be submitted to email address sales@shulesoft.com  </p>
                    <a class="btn btn-info m-t-10" style="color:white !important;">Download Form</a>   
                </div>

                <div class="panel-footer"> Last Update: <?= date('d M Y') ?></div>
            </div>
        </div>
    </div>
    <!-- /.col-lg-4 -->
    <div class="col-lg-4 col-sm-4">
        <div class="panel panel-success">
            <div class="panel-heading"> Contract of Service
                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
            </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <p>A contract of service, is a final part for school. You need to read this carefully and understand about this contract. In case you don't understand any place, please do not hesitate to call +255655406004. In case customer ask you something you don't understand, please forward that enquiry to head office</p>
                    <a class="btn btn-success m-t-10" style="color:white !important;">Download</a>   
                </div>
                <div class="panel-footer"> Last Update: <?= date('d M Y') ?></div>
            </div>
        </div>
    </div>
</div>
@endsection
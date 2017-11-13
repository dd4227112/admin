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
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Customer Acquisation Form</div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <p>Use this when you present ShuleSoft in an event where you can find most of your customers. For example Owners meeting,etc.</p>
                    <a class="btn btn-custom m-t-10 collapseble">Download</a>

                </div>
                <div class="panel-footer"> Last Update: <?= date('d M Y') ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">ShuleSoft Fliers

            </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <p>Fliers are very useful especially when someone needs to remain with something to present to other people, otherwise its not important.</p> 
                    <a class="btn btn-info m-t-10">Download</a> </div>
                <div class="panel-footer"> Last Update: <?= date('d M Y') ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <h3>ShuleSoft Proposal</h3>
                    <p>Some customers needs a formal proposal to present to their management. Download this proposal and remember to change school name with a school name you submit a proposal</p><a class="btn btn-success m-t-10">Download</a> </div>
                <div class="panel-footer"> Last Update: <?= date('d M Y') ?></div>
            </div>
        </div>
    </div>
</div>


<!-- .row -->
<div class="row">
    <div class="col-lg-4 col-sm-4">
        <div class="panel panel-info">
            <div class="panel-heading"> Company Profile
                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
            </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <p>When a school needs a company profile, it means, it needs assurance of our services and our validity. This company profile includes company legal and registration certificates </p>
                    <a class="btn btn-info m-t-10" style="color:white !important;">Download</a>   
                </div>

                <div class="panel-footer"> Last Update: <?= date('d M Y') ?></div>
            </div>
        </div>
    </div>
    <!-- /.col-lg-4 -->
    <div class="col-lg-4 col-sm-4">
        <div class="panel panel-success">
            <div class="panel-heading"> Introduction Letter
                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
            </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <p>Customers who needs a formal introduction letter, download this letter and change school name with a school name you submit. This letter is already signed and sealed.</p>
                    <a class="btn btn-success m-t-10" style="color:white !important;">Download</a>   
                </div>
                <div class="panel-footer"> Last Update: <?= date('d M Y') ?></div>
            </div>
        </div>
    </div>
</div>
@endsection
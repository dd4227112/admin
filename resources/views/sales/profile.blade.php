@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="white-box m-b-0 bg-info">
                            <h3 class="text-white box-title">Sales Presentation <span class="pull-right"><i class="fa fa-caret-down"></i> 160</span></h3>
                            <div id="sparkline2dash" class="text-center"><canvas width="215" height="70" style="display: inline-block; width: 215px; height: 70px; vertical-align: top;"></canvas></div>
                        </div>
                        <div class="white-box">
                            <div class="row">
                                <div class="p-l-20 p-r-20">
                                    <div class="pull-left">
                                        <div class="text-muted m-t-20">Download Sample Presentations</div>
                                        <h2><a href="{{url('downloadMaterial/presentation')}}" class="btn btn-primary" ><i class="fa fa-download"></i>Download</a></h2> </div>
                                    <div data-label="60%" class="css-bar css-bar-60 css-bar-lg m-b-0  css-bar-info pull-right"></div>
                                </div>    
                            </div>
                        </div>
                    </div>
</div>
@endsection
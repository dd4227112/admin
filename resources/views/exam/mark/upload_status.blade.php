@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Upload Marks by Excel</h4>
                <span>Please use the correct excel format to upload marks</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Exam</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Mark Upload by Excel</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page header end -->
        <!-- Page body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <span class="pull-left"> @if(url()->previous()!=url()->current())
                        <a class="btn btn-sm btn-info" href="{{url()->previous()}}"><i class="fa fa-arrow-circle-left"> @lang('application_lang.go_back')</i></a>
                        @endif
                    </span>
                    <div class="col-sm-6 col-sm-offset-3 list-group">
                        <div class="list-group-item list-group-item-warning">
                            <?= $status ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
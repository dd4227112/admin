@extends('layouts.app')
@section('content')

    <div class="page-header">
        <div class="page-header-title">
            <h4>Onboarding school </h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Sales</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">School Profile</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="page-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">                            
                <div class="card-block">
                   <div class="col-md-6 col-xl-4">
                        <div class="card group-widget">
                           
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12">
                        <div class="col-sm-12">
                                <div class="card borderless-card">
                                    <div class="card-block-big bg-primary quick-note-card">
                                         <div class="card-block-big bg-info text-center">
                                          <h1><?= $client->name?></h1>
                                         <h6 class="m-t-10"><?=$trial_code. ' Trial Code' ?></h6>
                                      </div>
                                        <div class="text-right m-t-10">
                                             <a class="btn btn-info btn-sm" 
                                             href="<?= url('http://' . $client->username . '.shulesoft.africa')?>" target="_blank"> install </a>
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
</div>
@endsection
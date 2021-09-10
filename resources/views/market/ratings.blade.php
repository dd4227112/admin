@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/'; ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dasboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Analytic Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
       
     

        <br/>
        <div class="page-body">
            <div class="row">

                <!-- Facebook card start -->
                <div class="col-md-6 col-xl-12">
                    <div class="card social-widget-card">
                

                <!-- NVD3 chart start -->
                <div class="col-md-6 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>School average ratings</h5>
                        </div>
                        <div class="card-block">
                            <div id="linechart" class="nvd-chart">

                                <?php
                                $sql_ = "select a.module_id,b.name as module,round(avg(a.rate::integer),1) as count from admin.rating a join admin.modules b on a.module_id = b.id group by a.module_id,b.name";
                                echo $insight->createChartBySql($sql_, 'module', 'Average ratings', 'bar', false);
                                ?>

                            </div>
                        </div>
                    </div>
                </div>


               

                <!-- Morris chart end -->
                <!-- Todo card start -->
                <div class="col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Module ratings</h5>
                    
                        </div>
                        <div class="card-block">
                                <?php
                                 $sql1 = "select a.module_id,b.name as module,round(avg(a.rate::integer),1) as count from admin.rating a join admin.modules b on a.module_id = b.id group by a.module_id,b.name";
                                 echo $insight->createChartBySql($sql1 , 'module', 'Module average Rating', 'pie', false);
                            ?>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
               

            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= $root ?>bower_components/jquery/dist/jquery.min.js"></script>


@endsection
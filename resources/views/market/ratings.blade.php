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
                        <div class="card-header row">
                            <h5>School  daily total ratings </h5>  <h5 class="pull-right"> NPS : <?= isset($nps->nps) ? round($nps->nps,2) : '' ?></h5>
                        </div>
                        <div class="card-block">
                            <div id="linechart" class="nvd-chart">
                             <?php
                                $sql_ = "select TO_CHAR(a.created_at::date,'dd-mm-yyyy') as created_at, count(a.rate::integer) as count from admin.rating a join admin.modules b on a.module_id = b.id group by a.created_at::date";
                                echo $insight->createChartBySql($sql_, 'created_at', 'Total ratings', 'line', false);
                              ?>
                            </div>
                        </div>
                    </div>
                </div>


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


                 <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>System User ratings and comments</h5>
                          
                        </div>
                        <div class="card-block table-border-style">
                            <div class="table-responsive analytic-table">
                                <table id="res-config" class="table table-bordered w-100 dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usertype</th>
                                            <th>Phone Number</th>
                                            <th>School</th>
                                            <th>Date</th>
                                            <th>Module</th>
                                            <th>Comment</th>
                                            <th>Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; if(count($ratings) > 0)
                                            foreach ($ratings as $rating) { ?>
                                          <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $rating->usertype?></td>
                                            <td><?= $rating->phone?></td>
                                            <td><?= $rating->schema_name?></td>
                                            <td><?= date('d-m-Y', strtotime($rating->created_at)) ?></td>
                                            <td><?= isset($rating->modules->name) ? $rating->modules->name : '' ?></td>
                                            <td class="text-left"><?= warp($rating->comment) ?></td>
                                            <td class="text-left"><?= $rating->rate?></td>
                                          </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="<?= $root ?>bower_components/jquery/dist/jquery.min.js"></script>


@endsection
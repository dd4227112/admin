@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Distributions</h4>
                <span>Show revenue </span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Collections</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <!-- form start -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                
                                     {{-- <div class="row m-10">
                                        <div class="col-sm-8">
                                            <form style="" class="form-horizontal" role="form" method="post"> 
                                              <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Year</label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                            <input type="date"  class="form-control calendar" id="year" name="year" required> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                  <div class="form-group row">
                                                    <div class="">
                                                         <input type="submit" class="form-control btn btn-success" value="Submit"  style="float: right;">
                                                        </div>
                                                    </div>
                                                </div> 

                                              </div>
                                                <?= csrf_field() ?>
                                            </form>
                                        </div>  
                                     </div>      --}}
                                     
                                     
                                     <div class="table-responsive dt-responsive"> 
                                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-1">No</th>
                                                    <th class="col-sm-2"><?= ('Name') ?></th>
                                                    <th class="col-sm-2"><?= ('Amount') ?></th>
       
                                                    @foreach($months as $month)
                                                    <th class="col-sm-2"><?= $month->month_name ?></th>
                                                    @endforeach
                                              
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total = 0;
                                                $avg_total = 0;
                                                $montharray = [];
                                                $a = 0;
                                                if (!empty($payments)) {
                                                    $i = 1;foreach ($payments as $revenue) { ?>
                                                   <tr>
                                                    <td> <?= $i; ?></td>
                                                    <td class="text-left">
                                                        <?= $revenue->client->name; ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <?php $total += $revenue->amount;
                                                        echo money($revenue->amount); ?>
                                                    </td>
                                                    @foreach($months as $month)
                                                    <td class="col-sm-2">
                                                        <?php $average = $revenue->amount/12;
                                                        if($month->id >= date("n", strtotime($revenue->date))) {
                                                            $avg = $average;
                                                            echo money($avg); 
                                                          
                                                         } else {
                                                            $avg = 0;
                                                            echo money($avg); 
                                                         }
                                                        
                                                         ?>
                                                    </td>
                                                    @endforeach
                                                </tr>
                                                <?php
                                                $i++;
                                               }
                                              }
                                            ?>
                                            </tbody> 
                                           
                                            <?php  $avg_total += $avg;
                                            if (!empty($payments)) { ?>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <td>Total</td>
                                                        <td><?= money($total) ?></td>
                                                        
                                                        @foreach($months as $month)
                                                           <td></td>
                                                        @endforeach
                                                    </tr>
                                                </tfoot>
                                            <?php } ?>
                                        </table>
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



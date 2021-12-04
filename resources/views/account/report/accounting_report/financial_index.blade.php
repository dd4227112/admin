@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>


    
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h3 class="box-title"><i class="fa icon-invoice"></i>
                    <?php
        
                    if($type==2) {
                        echo 'Balance Sheet';
                        }elseif($type==1){
                        echo 'Income Statement';
                        } elseif($type==4){
                        echo 'Trial Balance';
                        }
                        else{
                            echo 'Cash Flow Statement';
                        }?>
                </h3>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">  <?php

                        if($type==2) {
                            echo 'Balance Sheet';
                            }elseif($type==1){
                            echo 'Income Statement';
                            } elseif($type==4){
                            echo 'Trial Balance';
                            }
                            else{
                                echo 'Cash Flow Statement';
                            }?></a>
                    </li>
                   
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                      

                        <div class="col-md-12 col-xl-12">
                            <?php
                            $x="1";
                           if($x=='1') {?>
                        
                                <form class="form-horizontal" role="form" method="post">
                                    <?php
                                    if($type==2 || $type==4){
            
                                    } else {
                                    if(form_error($errors,'from_date'))
                                        echo "<div class='form-group has-error' >";
                                    else
                                        echo "<div class='form-group'>";
                                    ?>
                                    <label for="from_date" class="col-sm-2 control-label">
                                        From
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="date" required class="form-control calendar" id="from_date" name="from_date" value="<?= date('Y-01-01')?>" >
                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors,'from_date'); ?>
                                    </span>
                                       </div>
                                       <?php }?>
                                       <?php
                                       if(form_error($errors,'to_date'))
                                           echo "<div class='form-group has-error'>";
                                       else
                                           echo "<div class='form-group' >";
                                       ?>
                                       <label for="to_date" class="col-sm-2 control-label">
                                           To
                                       </label>
                                         <div class="col-sm-6">
                                           <input type="date" required class="form-control calendar" id="to_date" name="to_date" value="<?= date('Y-m-d')?>" >
                                         </div>
                                       <span class="col-sm-4 control-label">
                                            <?php echo form_error($errors,'to_date'); ?>
                                        </span>
                                   </div>
                        
                                   <div class="form-group">
                                       <div class="col-sm-offset-2 col-sm-4">
                                           <input type="submit" class="btn btn-primary btn-block" value="View Statement" >
                                       </div>
                                   </div>
                        
                                   <?= csrf_field() ?>
                                </form>
                            <?php } else {?>
                            This part is undergoing modifications , be patient to wait
                            <?php  } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>
@endsection



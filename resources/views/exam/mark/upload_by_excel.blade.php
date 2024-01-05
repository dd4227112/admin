@extends('layouts.app')
@section('content')

    
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
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-header">
                            <!--<h5>Basic Form Inputs</h5>-->
                            <span>Please use the correct excel template. <a href="<?=url('storage/app/sample.xls')?>">Click here to view sample</a>. Ensure subject names in excel tally with what defined in the system</span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <p id="notes" class="notes"></p>
                        </div>
                        <div class="card-block">
                            <!--<h4 class="sub-title">Basic Inputs</h4>-->
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Upload Excel File</label>
                                    <div class="col-sm-10">
                                        <input type="file"   accept=".xls,.xlsx,.csv" name="file" class="form-control calendar" placeholder=""/>
                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'name'); ?>
                                    </span>
                                </div>
                               
                               
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-4">
                                        <input type="submit" class="btn btn-block btn-success" value="<?= __("Submit") ?>" >
                                    </div>
                                </div>

                                <?= csrf_field() ?>
                            </form>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body end -->
    </div>
</div>
@endsection
@extends('layouts.app')
@section('content')

    
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Edit Subject</h4>
                <span></span>
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
                    <li class="breadcrumb-item"><a href="#!">Subject</a>
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
                          <p> <?= __('Fields marked') ?>  <span class="red">*</span> <?= __(' are mandatory') ?> </p>
                        
                        <div class="card-header">
                              <div class="row">
                                    <div class="col-sm-8">
                                        <form class="form-horizontal" role="form" method="post">
                                           
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Subject name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="grade"   placeholder="<?= __('eg English') ?>" name="name" value="<?= old('name',$subject->name) ?>" >
                                                </div>
                                                <span class="col-sm-4 control-label">
                                                    <?php echo form_error($errors, 'name'); ?>
                                                </span>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">class level</label>
                                                <div class="col-sm-10">
                                                    <?php
                                                    $array = array();
                                                    foreach ($classes as $class) {
                                                        $array[$class->id] = $class->name;
                                                    }
                                                    echo form_dropdown("class_id", $array, old("class_id",$subject->class_id), "id='class_id' class='form-control'");
                                                    ?>
                                                </div>
                                                <span class="col-sm-4 control-label">
                                                    <?php echo form_error($errors, 'class_id'); ?>
                                                </span>
                                            </div>



                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"></label>
                                                <div class="col-sm-offset-2 col-sm-6 col-xs-12">
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
                <script type="text/javascript">
                    $('.gradeinfo').keyup(function () {
                        var val = $(this).val();
                        if (val > 100) {
                            swal('Warning', 'mark cannot exceed 100');
                            $(this).val('').css('border', '1px solid red');
                        } else if (val < 0) {
                            swal('Warning', 'mark cannot be below 0');
                            $(this).val('').css('border', '1px solid red');
                        }
                    });
                </script>
                @endsection
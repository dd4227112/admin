@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Define New Exam</h4>
                <span>Exams are only defined once</span>
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
                    <li class="breadcrumb-item"><a href="#!">Definition</a>
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
                            <span class="section"> <p> <?= __('Fields marked') ?>  <span class="red">*</span> <?= __(' are mandatory') ?> </p>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <form class="form-horizontal" role="form" method="post">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Association</label>
                                                <div class="col-sm-10">
                                                    <?php
                                                    $array_ass = array();
                                                    foreach ($associations as $association) {
                                                        $array_ass[$association->id] = $association->name;
                                                    }
                                                    echo form_dropdown("association_id", $array_ass, old("association_id"), "id='association_id' class='form-control'");
                                                    ?>
                                                </div>
                                                <span class="col-sm-4 control-label">
                                                    <?php echo form_error($errors, 'name'); ?>
                                                </span>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Grade name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="grade"   placeholder="<?= __('grade name eg A') ?>" name="grade" value="<?= old('grade',$grade->grade) ?>" >
                                                </div>
                                                <span class="col-sm-4 control-label">
                                                    <?php echo form_error($errors, 'grade'); ?>
                                                </span>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">class level</label>
                                                <div class="col-sm-10">
                                                    <?php
                                                    $array = array();
                                                    foreach ($levels as $classlevel) {
                                                        $array[$classlevel->id] = $classlevel->name;
                                                    }
                                                    echo form_dropdown("classlevel_id", $array, old("classlevel_id",$grade->classlevel_id), "id='classlevel_id' class='form-control'");
                                                    ?>
                                                </div>
                                                <span class="col-sm-4 control-label">
                                                    <?php echo form_error($errors, 'classlevel'); ?>
                                                </span>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Grade Point</label>
                                                <div class="col-sm-10">
                                                    <input placeholder="<?= __("point") ?>" type="number" class="form-control" id="point" name="point" value="<?= old('point',$grade->point) ?>" >
                                                </div>
                                                <span class="col-sm-4 control-label">
                                                    <?php echo form_error($errors, 'point'); ?>
                                                </span>
                                            </div>

                                            
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Grade From</label>
                                                <div class="col-sm-10">
                                                     <input type="text" placeholder="<?= __("minimum") ?>" class="form-control gradeinfo" id="gradefrom" name="gradefrom" value="<?= old('gradefrom',$grade->gradefrom) ?>" >
                                                </div>
                                                <span class="col-sm-4 control-label">
                                                    <?php echo form_error($errors, 'gradefrom'); ?>
                                                </span>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Grade up to</label>
                                                <div class="col-sm-10">
                                                    <input type="text" placeholder="<?= __("max") ?>" class="form-control gradeinfo" id="gradeupto" name="gradeupto" value="<?= old('gradeupto',$grade->gradeupto) ?>" >
                                                </div>
                                                <span class="col-sm-4 control-label">
                                                    <?php echo form_error($errors, 'gradeupto'); ?>
                                                </span>
                                            </div>

                                           <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Note</label>
                                                <div class="col-sm-10">
                                                <textarea style="resize:none;" placeholder="<?= __("eg. excellent") ?>" class="form-control" id="note" name="note"><?= old('note',$grade->note) ?></textarea>
                                                </div>
                                                <span class="col-sm-4 control-label">
                                                    <?php echo form_error($errors, 'note'); ?>
                                                    <a><i class="fa fa-question-circle" data-container="body"
                                                      data-toggle="popover" data-placement="top" data-trigger="hover"
                                                      data-content="<?= __("remarks") ?>"
                                                      title="<?= __("grade_remarks") ?>"></i></a>
                                                </span>
                                            </div>



                                            <div class="form-group">
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
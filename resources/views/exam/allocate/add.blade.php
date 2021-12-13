@extends('layouts.app')
@section('content')

    
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
                            <!--<h5>Basic Form Inputs</h5>-->
                            <span>Specify information correctly as specified. Area marked with * are mandatory</span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                        </div>
                        <div class="card-block">
                            <!--<h4 class="sub-title">Basic Inputs</h4>-->

                            <form class="form-horizontal" role="form" method="post">

                                <div class="form-group row">
                                    <label for="global_exam_definition_id" class="col-sm-2 control-label">
                                        Exam Name<span class="red">*</span>
                                    </label>
                                    <div class="col-sm-6 col-xs-12">
                                        <?php
                                        $array_ass = array();
                                        foreach ($exams as $exam) {
                                            $array_ass[$exam->id] = $exam->name;
                                        }
                                        echo form_dropdown("global_exam_definition_id", $array_ass, old("global_exam_definition_id"), "id='global_exam_definition_id' class='form-control'");
                                        ?>
                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'global_exam_definition_id'); ?>
                                    </span>
                                </div>

                                <div class="form-group row">
                                    <label for="class_id" class="col-sm-2 control-label">
                                        <?= __('Classes') ?><span class="red">*</span>
                                    </label>
                                    <div class="col-sm-6 col-xs-12">
                                        <?php
                                        $array = array("0" => __("select level"));
                                        if (isset($classes)) {
                                            foreach ($classes as $class) {
                                                $array[$class->id] = $class->name;
                                            }
                                        }
                                        echo form_dropdown("class_id", $array, old("class_id"), "id='class_id' class='form-control'");
                                        ?>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="date" class="col-sm-2 control-label">
                                        <?= __("Exam Date") ?><span class="red">*</span>
                                    </label>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="date" id="datepicker" name="date" class="form-control calendar" placeholder="dd/mm/yyyy"/>

                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'date'); ?>
                                    </span>
                                </div>


                               

                                <div class="form-group row">
                                    <label for="note" class="col-sm-2 control-label">
                                        <?= __("Note") ?>
                                    </label>
                                    <div class="col-sm-6 col-xs-12">
                                        <textarea style="resize:none;" class="form-control" id="note" name="note"><?= old('note') ?></textarea>
                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'note'); ?>
                                    </span>
                                </div>
                                <div class="form-group row">
                                    <label for="note" class="col-sm-2 control-label"></label>
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
    </div>
</div>

        @endsection
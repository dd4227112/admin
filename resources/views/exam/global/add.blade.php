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
                        <div class="col-sm-2">
                            <p id="notes" class="notes"></p>
                        </div>
                        <div class="card-block">
                            <!--<h4 class="sub-title">Basic Inputs</h4>-->
                            <form action="" method="post">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Exam Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="exam" name="name" class="form-control calendar" placeholder=""/>
                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'name'); ?>
                                    </span>
                                </div>
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
                                        <?php echo form_error($errors, 'association_id'); ?>
                                    </span>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">School Level</label>
                                    <div class="col-sm-10">
                                        <?php
                                        $array = array("0" => __("select level"));
                                        if (isset($levels)) {
                                            foreach ($levels as $level) {
                                                $array[$level->id] = $level->name;
                                            }
                                        }
                                        echo form_dropdown("school_level_id", $array, old("school_level_id"), "id='school_level_id' class='form-control'");
                                        ?> </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Note</label>
                                    <div class="col-sm-10">
                                        <textarea rows="5" cols="5" id="note" name="note" class="form-control" placeholder="Write exam note"><?= old('note') ?></textarea>
                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'note'); ?>
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
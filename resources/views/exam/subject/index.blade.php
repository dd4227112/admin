@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Exams Schedule</h4>
                <span>Exams schedule defined each time to create easiness of reference</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Exams</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Schedule</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <h5 class="card-header">
                            <a class="btn btn-success" href="<?php echo url('exam/addSubject') ?>">
                                <i class="fa fa-plus"></i> 
                                <?= __('add grade') ?>
                            </a>
                        </h5>
                        <?php // } ?>

                        <div class="col-sm-6 col-xs-12 col-lg-offset-3">
                            <div class="list-group-item">
                                <form style="" class="form-horizontal" role="form" method="post">  
                                    <div class="form-group">              
                                        <label for="class_id" class="col-sm-2 col-lg-offset-2 control-label">
                                            <?= __("class") ?>
                                        </label>
                                        <div class="col-sm-6 col-xs-12">
                                            <?php
                                            $array = array("0" => __("class_id"));
                                            foreach ($classes as $class) {
                                                $array[$class->id] = $class->name;
                                            }
                                            echo form_dropdown("class_id_id", $array, old("class_id", request('id')), "id='class_id' class='form-control'");
                                            ?>
                                        </div>
                                        <a
                                            class="right"><i class="fa fa-question-circle" data-container="body"
                                                         data-toggle="popover" data-placement="right" data-trigger="hover"
                                                         data-content="<?= __("select_level") ?>"
                                                         title="<?= __("select_class_id") ?>"></i></a>
                                    </div>
                                    <?= csrf_field() ?>
                                </form>
                            </div>
                        </div>

                        <div class="card-block">

                            <div class="table-responsive dt-responsive ">
                                <table id="dt-ajax-array" class="table table-striped dataTable table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th class="col-lg-1"><?= __('#') ?></th>
                                            <th class="col-lg-2"><?= __('Subject name') ?></th>
                                            <th class="col-lg-4"><?= __('action') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($subjects as $subject) {
                                            ?>
                                            <tr>
                                                <td data-title="<?= __('slno') ?>">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td data-title="<?= __('grade_name') ?>">
                                                    <?php echo $subject->name; ?>
                                                </td>
                                                
                                                

                                                <td data-title="<?= __('action') ?>">
                                                    <?php echo '<a  href="' . url("/exam/editSubject/$subject->id") . ' " class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> ' . __('edit') . ' </a>' ?>
                                                    <?php echo '<a  href="' . url("exam/deleteSubject/$subject->id") . ' " class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> ' . __('delete') . ' </a>' ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div> <!-- col-sm-12 -->
    </div><!-- row -->
</div><!-- Body -->
</div><!-- /.box -->
<script type="text/javascript">
    $('#class_id').change(function () {
        var level_id = $(this).val();
        if (level_id == 0) {
            $('#hide-table').hide();
        } else {
            var url = "<?= url('exam/subject') ?>/null";
            window.location.href = url + '?id=' + level_id;

        }
    });
</script>
@endsection

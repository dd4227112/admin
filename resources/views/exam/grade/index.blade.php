@extends('layouts.app')
@section('content')
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <?php
                  ///  if (can_access('add_grade')) {
                        ?>
                        <h5 class="page-header">
                            <a class="btn btn-success" href="<?php echo url('exam/grade/add') ?>">
                                <i class="fa fa-plus"></i> 
                                <?= __('add grade') ?>
                            </a>
                        </h5>
                    <?php // } ?>

                    <div class="col-sm-6 col-xs-12 col-sm-offset-3 list-group">
                        <div class="list-group-item list-group-item-warning">
                            <form style="" class="form-horizontal" role="form" method="post">  
                                <div class="form-group">              
                                    <label for="classlevel_id" class="col-sm-2 col-sm-offset-2 control-label">
                                        <?= __("classlevel") ?>
                                    </label>
                                    <div class="col-sm-6 col-xs-12">
                                        <?php
                                        $array = array("0" => __("classlevel"));
                                        foreach ($levels as $classlevel) {
                                            $array[$classlevel->id] = $classlevel->name;
                                        }
                                        echo form_dropdown("classlevel_id", $array, old("classlevel_id", request('id')), "id='classlevel_id' class='form-control'");
                                        ?>
                                    </div>
                                    <a
                                        class="right"><i class="fa fa-question-circle" data-container="body"
                                                     data-toggle="popover" data-placement="right" data-trigger="hover"
                                                     data-content="<?= __("select_level") ?>"
                                                     title="<?= __("select_classlevel") ?>"></i></a>
                                </div>
                                <?= csrf_field() ?>
                            </form>
                        </div>
                    </div>

                    <div id="hide-table">
                        <?php if (isset($grades) && count($grades) > 0) { ?>
                            <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th class="col-lg-1"><?= __('#') ?></th>
                                        <th class="col-lg-2"><?= __('Grade name') ?></th>
                                        <th class="col-lg-1"><?= __('Point') ?></th>
                                        <th class="col-lg-1"><?= __('From') ?></th>
                                        <th class="col-lg-1"><?= __('To') ?></th>
                                        <th class="col-lg-1"><?= __('Note') ?></th>
                                        <th class="col-lg-2"><?= __('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($grades as $grade) {
                                        ?>
                                        <tr>
                                            <td data-title="<?= __('slno') ?>">
                                                <?php echo $i; ?>
                                            </td>
                                            <td data-title="<?= __('grade_name') ?>">
                                                <?php echo $grade->grade; ?>
                                            </td>
                                            <td data-title="<?= __('grade_point') ?>">
                                                <?php echo $grade->point; ?>
                                            </td>
                                            <td data-title="<?= __('grade_gradefrom') ?>">
                                                <?php echo $grade->gradefrom; ?>
                                            </td>
                                            <td data-title="<?= __('grade_gradeupto') ?>">
                                                <?php echo $grade->gradeupto; ?>
                                            </td>
                                            <td data-title="<?= __('grade_note') ?>">
                                                <?php echo $grade->note; ?>
                                            </td>

                                            <td data-title="<?= __('action') ?>">
                                                <?php echo '<a  href="' . url("/exam/grade/edit/$grade->id") . ' " class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> ' . __('edit') . ' </a>' ?>
                                                <?php echo '<a  href="' . url("exam/grade/delete/$grade->id") . ' " class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> ' . __('delete') . ' </a>' ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>

                </div>
            </div> <!-- col-sm-12 -->
        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->
<script type="text/javascript">
    $('#classlevel_id').change(function () {
        var level_id = $(this).val();
        if (level_id == 0) {
            $('#hide-table').hide();
        } else {
            var url = "<?= url('exam/grade') ?>";
            window.location.href = url + '?id=' + level_id;

        }
    });
</script>
@include('layouts.datatable')
@endsection

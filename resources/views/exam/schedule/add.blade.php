@extends('layouts.app')
@section('content')
<div class="box">
    <div class="box-body">
        <div class="white-box">
            <span class="section"> <p> <?= __('Fields marked') ?>  <span class="red">*</span> <?= __(' are mandatory') ?> </p>
                <div class="row">
                    <div class="col-sm-8">
                        <form class="form-horizontal" role="form" method="post">
                            
                            <?php
                            if (form_error($errors, 'global_exam_definition_id'))
                                echo "<div class='form-group has-error' >";
                            else
                                echo "<div class='form-group' >";
                            ?>
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

                    <?php
                    if (form_error($errors, 'class_id'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
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


                <?php
                if (form_error($errors, 'date'))
                    echo "<div class='form-group has-error' >";
                else
                    echo "<div class='form-group' >";
                ?>
                <label for="date" class="col-sm-2 control-label">
                    <?= __("Exam Date") ?><span class="red">*</span>
                </label>
                <div class="col-sm-6 col-xs-12">
                    <input type="text" id="datepicker" name="date" class="form-control calendar" placeholder="dd/mm/yyyy"/>

                </div>
                <span class="col-sm-4 control-label">
                    <?php echo form_error($errors, 'date'); ?>
                </span>
        </div>



<?php
if (form_error($errors, 'show_division'))
    echo "<div class='form-group has-error' id='show_division' style='display:none' >";
else
    echo "<div class='form-group' id='show_division' style='display:none'>";
?>
<label for="show_division" class="col-sm-2 control-label">
    <?= __("show_division") ?> 
</label>
<div class="col-sm-6 col-xs-12">
    <?= __("YES") ?>
    <input type="radio" id="is_counted" name="show_division" value="1">
    &nbsp;&nbsp; <?= __("NO") ?> 
    <input type="radio" id="is_counted" name="show_division" value="0">
</div>
<span class="col-sm-4 control-label">
    <?php echo form_error($errors, 'show_division'); ?>
</span>
</div>

<?php
if (form_error($errors, 'note'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
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
@include('layouts.datatable')
@endsection
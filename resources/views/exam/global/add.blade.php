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
                if (form_error($errors, 'date'))
                    echo "<div class='form-group has-error' >";
                else
                    echo "<div class='form-group' >";
                ?>
                <label for="date" class="col-sm-2 control-label">
                    <?= __("Exam Name") ?><span class="red">*</span>
                </label>
                <div class="col-sm-6 col-xs-12">
                    <input type="text" id="exam" name="exam" class="form-control calendar" placeholder=""/>

                </div>
                <span class="col-sm-4 control-label">
                    <?php echo form_error($errors, 'date'); ?>
                </span>
        </div>
                            <?php
                            if (form_error($errors, 'association_id'))
                                echo "<div class='form-group has-error' >";
                            else
                                echo "<div class='form-group' >";
                            ?>
                            <label for="association_id" class="col-sm-2 control-label">
                                Association<span class="red">*</span>
                            </label>
                            <div class="col-sm-6 col-xs-12">
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

                    <?php
                    if (form_error($errors, 'class_level'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                    <label for="class_level_id" class="col-sm-2 control-label">
                        <?= __('School Level') ?><span class="red">*</span>
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <?php
                        $array = array("0" => __("select level"));
                        if (isset($levels)) {
                            foreach ($levels as $level) {
                                $array[$level->id] = $level->name;
                            }
                        }
                        echo form_dropdown("class_level_id", $array, old("class_level_id"), "id='class_level_id' class='form-control'");
                        ?>
                    </div>
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
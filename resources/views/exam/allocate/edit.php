<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-pencil"></i> <?= $data->lang->line('panel_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i
                        class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li><a href="<?= base_url("exam/index") ?>"><?= $data->lang->line('menu_exam') ?></a></li>
            <li class="active"><?= $data->lang->line('menu_edit') ?> <?= $data->lang->line('menu_exam') ?></li>
        </ol>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <span class="section"><?= $data->lang->line('exam_info') ?> </span> <p> <?= $data->lang->line('fields') ?> <span class="red">*</span> <?= $data->lang->line('mandatory') ?></p>
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">

		    <?php
		    if (form_error($errors,'exam'))
			echo "<div class='form-group has-error' >";
		    else
			echo "<div class='form-group' >";
		    ?>
                    <label for="exam" class="col-sm-2 control-label">
			<?= $data->lang->line("exam_name") ?><span class="red">*</span>
                    </label>

                    <div class="col-sm-6">
                        <input type="hidden" name='refer_exam_id' value="<??>"/>
                        <input type="text" class="form-control" id="exam" name="exam"
                               value="<?=$exam->exam?>" disabled="disabled"/>

                    </div>
                    

		    <span class="col-sm-4 control-label">
			<?php echo form_error($errors,'exam'); ?>
		    </span>
            </div>

	    <?php
	    if (form_error($errors,'date'))
		echo "<div class='form-group has-error' >";
	    else
		echo "<div class='form-group' >";
	    ?>
            <label for="date" class="col-sm-2 control-label">
		<?= $data->lang->line("exam_date") ?><span class="red">*</span>
            </label>

            <div class="col-sm-6">
                <input type="text" class="form-control calendar" id="datepicker" name="date" value="<?= $exam->date?>"/>
            </div>
	    <span class="col-sm-4 control-label">
		<?php echo form_error($errors,'date'); ?>
	    </span>
        </div>

<?php
	if (form_error($errors,'class_level'))
	    echo "<div class='form-group has-error' >";
	else
	    echo "<div class='form-group' >";
	?>
	<label for="sectionID" class="col-sm-2 control-label">
	    <?= $data->lang->line('class_level') ?><span class="red">*</span>
	</label>
	<div class="col-sm-6">
	    <?php
	    $array = array("0" => $data->lang->line("mark_select_level"));
	    if (!empty($class_level)) {
		foreach ($class_level as $level) {
		    $array[$level->classlevel_id] = $level->name;
		}
	    }
            $result_format=\App\Model\Classlevel::find($exam->classlevel_id)->result_format;
	    echo form_dropdown("class_level_id", $array, old("class_level_id",$exam->classlevel_id), "id='class_level_id' class='form-control' disabled");
	    ?>
	</div>
    </div>

    <?php
    if (form_error($errors,'academic_year'))
	echo "<div class='form-group has-error' >";
    else
	echo "<div class='form-group' >";
    ?>
    <label for="sectionID" class="col-sm-2 control-label">
	<?= $data->lang->line('academic_year') ?><span class="red">*</span>
    </label>
    <div class="col-sm-6">
	<?php
	$array = array("0" => $data->lang->line("exam_select_year"));
	if (!empty($academic_years)) {
	    foreach ($academic_years as $academic) {
		$array[$academic->id] = $academic->name;
	    }
	}
	echo form_dropdown("academic_year_id", $array, old("academic_year_id",$exam->academic_year_id), "id='academic_year_id' class='form-control'");
	?>
    </div>
</div>


   <?php
    if (form_error($errors,'semester'))
	echo "<div class='form-group has-error' >";
    else
	echo "<div class='form-group' >";
    ?>
    <label for="sectionID" class="col-sm-2 control-label">
	<?= $data->lang->line('semester') ?><span class="red">*</span>
    </label>
    <div class="col-sm-6">
	<?php
	$array = array("0" => $data->lang->line("exam_select_semester"));
	if (!empty($semesters)) {
	    foreach ($semesters as $semester) {
		$array[$semester->id] = $semester->name;
	    }
	}
	echo form_dropdown("semester_id", $array, old("semester_id",$exam->semester_id), "id='semester_id' class='form-control'");
	?>
    </div>
</div>

	<?php
	if (form_error($errors,'classes'))
	    echo "<div class='form-group has-error' >";
	else
	    echo "<div class='form-group' >";
	?>
        <label for="classesID" class="col-sm-2 control-label">
	    <?= $data->lang->line("exam_class") ?><span class="red">*</span>
        </label>
        <div class="col-sm-6">
	    <?php
	    if (!empty($classes)) {
		echo "<input type=\"checkbox\" id='checkboxs'  onclick='check_all()'>", $data->lang->line("exam_all"), "</option>";
		$arr = [];
		foreach ($exam_classes as $exam_class) {
		    array_push($arr, $exam_class->class_id);
		}
		foreach ($classes as $class) {
		    $checked = in_array($class->classesID, $arr) ? 'checked' : '';
		    echo "&nbsp;&nbsp; <input type=\"checkbox\" class='check'  name=\"classes[]\"  " . $checked . "  value=\"$class->classesID\">", $class->classes, "";
		}
	    }
	    ?>
        </div>
	<span class="col-sm-4 control-label">
	    <?php echo form_error($errors,'classes'); ?>
	</span>
    </div>


 <?php
    if (form_error($errors,'abbreviation'))
	echo "<div class='form-group has-error' >";
    else
	echo "<div class='form-group' >";
    ?>
    <label for="note" class="col-sm-2 control-label">
	<?= $data->lang->line("abbreviation") ?><span class="red">*</span>
    </label>
    <div class="col-sm-6">
	<input type="text" class="form-control" id="abbreviation" name="abbreviation" value="<?= old('abbreviation',$exam->abbreviation) ?>" maxlength="3" placeholder="<?= $data->lang->line("abbreviation_placeholder") ?>"/>
    </div>
    <span class="col-sm-4 control-label">
	<?php echo form_error($errors,'abbreviation'); ?>
    </span>
</div>
    <?php
  
    $show=(strtoupper($result_format)=='CSEE' || strtoupper($result_format)=='ACSEE') ? "" :"id='show_division' style='display:none'";
    if (form_error($errors,'show_division'))
        echo "<div class='form-group has-error' ".$show." >";
    else
        echo "<div class='form-group' ".$show.">";
    ?>
    <label for="is_counted" class="col-sm-2 control-label">
         <?= $data->lang->line("show_division") ?> 
    </label>
    <div class="col-sm-6">
        <?= $data->lang->line("YES") ?> 
        <input type="radio" id="is_counted" name="show_division" value="1" <?=$exam->show_division==1 ? 'checked':''?>>
        &nbsp;&nbsp; <?= $data->lang->line("NO") ?> 
        <input type="radio" id="is_counted" name="show_division" value="0" <?=$exam->show_division==0 ? 'checked':''?>>
    </div>
    <span class="col-sm-4 control-label">
	<?php echo form_error($errors,'show_division'); ?>
    </span>
</div>

   <?php
    if (form_error($errors,'special_grades'))
	echo "<div class='form-group has-error' >";
    else
	echo "<div class='form-group' >";
    ?>
    <label for="sectionID" class="col-sm-2 control-label">
	<?= $data->lang->line('special_grade_names') ?><span class="red">*</span>
    </label>
    <div class="col-sm-6">
	<?php
	$array = array("" => $data->lang->line("select_special_grades"));
	if (count($special_grade_names)) {
	    foreach ($special_grade_names as $special_grade) {
		$array[$special_grade->id] = $special_grade->name;
	    }
	}
	echo form_dropdown("special_grade_name_id", $array, old("special_grade_name_id",$exam->special_grade_name_id), "id='special_grade_name_id' class='form-control'");
	?>
    </div>
   <span class="col-sm-4 control-label">
	<?php echo form_error($errors,'special_grades'); ?>
    </span>
</div>

    <?php
    if (form_error($errors,'note'))
	echo "<div class='form-group has-error' >";
    else
	echo "<div class='form-group' >";
    ?>
    <label for="note" class="col-sm-2 control-label">
	<?= $data->lang->line("exam_note") ?>
    </label>

    <div class="col-sm-6">
        <textarea style="resize:none;" class="form-control" id="note"
                  name="note"><?= old('note', $exam->note) ?></textarea>
    </div>
    <span class="col-sm-4 control-label">
	<?php echo form_error($errors,'note'); ?>
    </span>
</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-8">
        <input type="submit" class="btn btn-success" value="<?= $data->lang->line("update_exam") ?>">
    </div>
</div>

<?= csrf_field() ?>
</form>
</div>
</div>
</div>
</div>

<script type="text/javascript">
    function check_all() {
	$('.check').prop('checked', true);
    }

     $('#class_level_id').change(function (event) {
	var class_level_id = $(this).val();
	if (class_level_id === '0') {
	    $('#academic_year_id').val(0);
	    $('#classes_id').hide();
	} else {
	    $.ajax({
		type: 'POST',
		url: "<?= base_url('exam/get_academic_years_bylevel') ?>",
		data: "class_level_id=" + class_level_id,
		dataType: "html",
		success: function (data) {
		    $('#academic_year_id').html(data);
		}
	    });
	    $('#classes_id').show();
	    $('.checkbox_tag, .checkbox_name').hide();
	    $('.class'+class_level_id).show();
	}
    });
    
     $('#academic_year_id').change(function (event) {
	var academic_year_id = $(this).val();
	if (academic_year_id === '0') {
	    $('#semester_id').val(0);
	} else {
	    $.ajax({
		type: 'POST',
		url: "<?= base_url('semester/get_semester') ?>",
		data: "academic_year_id=" + academic_year_id,
		dataType: "html",
		success: function (data) {
		    $('#semester_id').html(data);
		}
	    });
	}
    });
</script>

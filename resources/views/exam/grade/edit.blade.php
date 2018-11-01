@extends('layouts.app')
@section('content')
<div class="box">
    <div class="box-body">
        <div class="white-box">
         <p> <?=__('Fields marked')?> <span class="red">*</span>  <?=__(' are_mandatory')?></p>
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">
 <?php
		    if (form_error($errors,'association_id'))
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
			<?php echo form_error($errors,'association_id'); ?>
		    </span>
	    </div>
                    <?php 
                        if(form_error($errors,'grade')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="grade" class="col-sm-2 control-label">
                            <?=__("Grade Name")?><span class="red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="<?=__('Grade Name')?>" class="form-control" id="grade" name="grade" value="<?=old('grade', $grade->grade)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors,'grade'); ?>
                        </span>
                    </div>

	    <?php
		    if (form_error($errors,'classlevel'))
			echo "<div class='form-group has-error' >";
		    else
			echo "<div class='form-group' >";
		    ?>
		    <label for="classlevel" class="col-sm-2 control-label">
			<?= __("class level") ?><span class="red">*</span>
		    </label>
		    <div class="col-sm-6">
			<?php
			$array = array();
			foreach ($levels as $classlevel) {
			    $array[$classlevel->id] = $classlevel->name;
			}
			echo form_dropdown("classlevel_id", $array, old("classlevel_id",$grade->classlevel_id), "id='classlevel_id' class='form-control'");
			?>
		    </div>
		    <span class="col-sm-4 control-label">
			<?php echo form_error($errors,'classlevel'); ?>
		    </span>
	    </div>
                    <?php 
                        if(form_error($errors,'point')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="point" class="col-sm-2 control-label">
                            <?=__("Grade Point")?><span class="red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input placeholder="<?=__("weight")?>" type="number" class="form-control" id="point" name="point" value="<?=old('point', $grade->point)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors,'point'); ?>
                        </span>
                    </div>

                    <?php 
                        if(form_error($errors,'gradefrom')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="gradefrom" class="col-sm-2 control-label">
                            <?=__("Grade from")?><span class="red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input placeholder="<?=__("minimum")?>" type="text" class="form-control gradeinfo" id="gradefrom" name="gradefrom" value="<?=old('gradefrom', $grade->gradefrom)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors,'gradefrom'); ?>
                        </span>
                    </div>

                    <?php 
                        if(form_error($errors,'gradeupto')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="gradeupto" class="col-sm-2 control-label">
                            <?=__("Grade upto")?><span class="red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input placeholder="<?=__("max")?>" type="text" class="form-control gradeinfo" id="gradeupto" name="gradeupto" value="<?=old('gradeupto', $grade->gradeupto)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors,'gradeupto'); ?>
                        </span>
                    </div>

                    <?php 
                        if(form_error($errors,'note')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="note" class="col-sm-2 control-label">
                            <?=__("notes")?><span class="red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <textarea placeholder="<?=__("excellent")?>" style="resize:none;" class="form-control" id="note" name="note"><?=old('note', $grade->note)?></textarea>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors,'note'); ?>
                        </span>
<a><i class="fa fa-question-circle" data-container="body"
      data-toggle="popover" data-placement="top" data-trigger="hover"
      data-content="<?=__("remarks")?>"
      title="<?=__("grade_remarks")?>"></i></a>
                    </div>

                    
             
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=__("update")?>" >
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
     $('.gradeinfo').keyup(function(){
  var val=$(this).val();
  if(val >100){
swal('Warning','mark cannot exceed 100');
$(this).val('').css('border','1px solid red');
  }else if(val <0){
swal('Warning','mark cannot be below 0');
$(this).val('').css('border','1px solid red');
  }
     });
</script>
@include('layouts.datatable')
@endsection
@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">

        <div class="page-header">
            <div class="page-header-title">
                <h4>Pension</h4>
                <span>Edit Pension Fund</span>
            </div>
     
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!"><?= __('allowance_title') ?></a>
                    </li>
                </ul>
            </div>
        </div>
  

       <div class="page-body">
         <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <header class="panel-heading">
                       Edit basic information correctly
                    </header>
                     <div class="card-body">
                        <div id="error_area"></div>
                        <div class="form">

                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    <?php 
                        if(form_error($errors,'name')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="name" class="col-sm-2 control-label">
                            <?=__("name")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="name" name="name" value="<?=old('name',$pension->name)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors,'name'); ?>
                        </span>
                    </div>

                    <?php 
                        if(form_error($errors,'employer_percentage')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="telephone_number" class="col-sm-2 control-label">
                            <?=__("employer_percentage")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="telephone" name="employer_percentage" value="<?=old('employer_percentage',$pension->employer_percentage)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors,'employer_percentage'); ?>
                        </span>
                    </div>

                    <?php 
                        if(form_error($errors,'employee_percentage')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="seats" class="col-sm-2 control-label">
                            <?=__("employee_percentage")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="phone_number" name="employee_percentage" value="<?=old('employee_percentage',$pension->employee_percentage)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors,'employee_percentage'); ?>
                        </span>
                    </div>
    
                    <?php
                    if (can_access('manage_payroll')) {
                        if (form_error($errors, 'status'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                        ?>
                        <label for="salary" class="col-sm-2 control-label">
                        Select  <?= __("status") ?>
                        </label>
                        <div class="col-sm-6">
                    <?php  echo form_dropdown("status", array(1 => 'Based On Gross Salary', 0 => 'Based On Basic Salary'), old("status", $pension->status), "id='status' class='form-control'"); ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors, 'status'); ?>
                        </span>
                        </div>

                    <?php } ?>
                    <?php 
                        if(form_error($errors,'address')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                          ?>
                        <label for="country" class="col-sm-2 control-label">
                            <?=__("address")?>
                        </label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="country" name="address"><?=old('address',$pension->address)?></textarea>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors,'address'); ?>
                        </span>
                    </div>
		    
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=__("Submit")?>" >
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
</div>

<script type="text/javascript">
document.getElementById("uploadBtn").onchange = function() {
    document.getElementById("uploadFile").value = this.value;
};

$(document).ready(function(){
    $('#show_password').click(function(){
        $('#password').attr('type',$(this).is(':checked')? 'text' : 'password');
    });

});
</script>
@endsection


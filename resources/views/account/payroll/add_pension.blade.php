
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-feetype"></i> <?= __('panel_title') ?> - Add Pension Fund</h3>


        <ol class="breadcrumb">
            <li><a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
            <li><a href="<?= url("bankaccount/index") ?>"><?= __('panel_title') ?></a></li>
            <li class="active">Add Pension Fund</li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <span class="section">Add Pension Fund</span>
        <div class="row">
            <div class="col-sm-8">

                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

                    <?php 
                        if(form_error($errors,'name')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="name" class="col-sm-2 control-label">
                            <?=__("pension_name")?><span class="red"> *</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="name" name="name" placeholder="<?= __('enter_pension') ?>" value="<?=old('name')?>"  required>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors,'name'); ?>
                        </span>
                    </div>

                    <?php
                        if (form_error($errors, 'refer_pension_id'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                        ?>
                        <label for="select class level" class="col-sm-2 control-label"><?= __('select_pension') ?> <span class="red">*</span></label>
                        <div class="col-sm-6">
                            <select class="select2 form-control" required="true"  name="refer_pension_id" id="refer_pension_id">
                                <option value="0"><?= __('select_pension') ?></option>

                                <?php
                                $pensions = DB::SELECT('SELECT * FROM constant.pensions');
                                foreach ($pensions as $pension) { ?>
                                    <option value="{{ $pension->id}}">{{ $pension->name}}</option>

                             <?php   } ?>       
                            </select>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors, 'refer_pension_id'); ?>
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
                            <input type="text" class="form-control" id="telephone" name="employer_percentage" value="<?=old('employer_percentage')?>" >
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
                            <input type="text" class="form-control" id="phone_number" name="employee_percentage" value="<?=old('employee_percentage')?>" >
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
    Select <?= __("status") ?>
    </label>
    <div class="col-sm-6">
  <?php  echo form_dropdown("status", array(1 => 'Based On Gross Salary', 0 => 'Based On Basic Salary'), old("status"), "id='payroll_status' class='form-control'"); ?>
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
                            <textarea class="form-control" id="country" name="address" ><?=old('address')?></textarea>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors,'address'); ?>
                        </span>
                    </div>

		    
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-6">
                            <input type="submit" class="btn btn-success btn-block" value="<?=__("save")?>" >
                        </div>
                    </div>

                <?= csrf_field() ?>
</form>
      
            </div> <!-- col-sm-8 -->
            
        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->

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



<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-feetype"></i> <?= __('panel_title') ?>-<?= __('allowance_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
            <li><a href="<?= url("grade/index") ?>"><?= __('allowance_title') ?></a></li>
            <li class="active"><?= __('menu_add') ?> <?= __('allowance_title') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <div class="box-body">
        <span class="section"><?= __('menu_add') . ' ' . __('allowance_title') ?>  </span> <p> <?= __('fields_marked') ?>  <span class="red">*</span> <?= __('are_mandatory') ?> </p>
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">

                    <?php
                    if (form_error($errors, 'name'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                    <label for="grade" class="col-sm-2 control-label">
                        <?= __("name") ?><span class="red">*</span>
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="name"   placeholder="<?= __('name') ?>" name="name" value="<?= old('name') ?>" required>
                    </div>
                    <span class="col-sm-4 control-label">
                        <?php echo form_error($errors, 'name'); ?>
                    </span>
            </div>
            <div class="form-group">              
                <label for="category" class="col-sm-2  control-label">
                    <?= __("category") ?>
                </label>
                <div class="col-sm-6">
                    <?php
                    $array = array("0" => __("select"));
                    $deduction_types = [
                        '1' => 'Fixed Allowances',
                        '2' => 'Monthly Allowances'
                    ];
                    foreach ($deduction_types as $key => $value) {
                        $array[$key] = $value;
                    }
                    echo form_dropdown("category", $array, old("category"), "id='category' class='form-control'");
                    ?>
                </div>
            </div>
            <?php
            if (form_error($errors, 'type'))
                echo "<div class='form-group has-error' >";
            else
                echo "<div class='form-group' >";
            ?>
            <label for="grade" class="col-sm-2 control-label">
                Allowance Type<span class="red">*</span>
            </label>
            <div class="col-sm-6">
                <select class="form-control" required="true"  name="type" id="allowance_type">     
                    <option value="">Select</option>         
                    <option value="0">Taxable</option>        
                    <option value="1">Non-Taxable</option>    
                </select>
            </div>
            <span class="col-sm-4 control-label">
                <?php echo form_error($errors, 'type'); ?>
            </span>
        </div>
        <?php
        if (form_error($errors, 'pension_included'))
            echo "<div class='form-group has-error' >";
        else
            echo "<div class='form-group' >";
        ?>
        <label for="grade" class="col-sm-2 control-label">
            Allowance Pension Status<span class="red">*</span>
        </label>
        <div class="col-sm-6">
            <select class="form-control" required="true" hidden=""  name="pension_included" id="pension_included">     
                <option value="1">Included</option>        
                <option value="0">Not-Included</option>        

            </select>
            <div class="alert alert-info" style="display: none">Its not required according to Tanzania Tax Regulations</div>
        </div>
        <span class="col-sm-4 control-label">
            <?php echo form_error($errors, 'pension_included'); ?>
        </span>
    </div>
    <?php
    if (form_error($errors, 'is_percentage'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
    <label for="is_penalty" class="col-sm-2 control-label">
        Charge <?= __("type") ?>
    </label>
    <div class="col-sm-6">
        <?= __("percentage") ?>
        <input type="radio" class="allowance_type" name="is_percentage" value="1">
        &nbsp;&nbsp; <?= __("fixed_amount") ?> 
        <input type="radio" class="allowance_type" name="is_percentage" value="0">
    </div>
    <span class="col-sm-4 control-label">
        <?php echo form_error($errors, 'is_percentage'); ?>
    </span>
</div>
<div id="amount_check" style="display: none">
    <?php
    if (form_error($errors, 'amount'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
    <label for="amount" class="col-sm-2 control-label">
        <?= __("fixed_amount") ?>
    </label>
    <div class="col-sm-6">
        <input placeholder="<?= __("amount") ?>" type="number" class="form-control" id="amount" name="amount" value="<?= old('amount') ?>" >
      
    </div>
    <span class="col-sm-4 control-label">
        <?php echo form_error($errors, 'point'); ?>
    </span>
</div>
</div>

<div id="percentage_check" style="display: none">
    <?php
    if (form_error($errors, 'percent'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
    <label for="amount" class="col-sm-2 control-label">
        <?= __("percent") ?>
    </label>
    <div class="col-sm-6">
        <input placeholder="<?= __("percentage") ?>" type="number" class="form-control" id="percent" name="percent" value="<?= old('percent') ?>" >
      
    </div>
    <span class="col-sm-4 control-label">
        <?php echo form_error($errors, 'percent'); ?>
    </span>
</div>
</div>

<?php
if (form_error($errors, 'description'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="note" class="col-sm-2 control-label">
    <?= __("description") ?><span class="red">*</span>
</label>
<div class="col-sm-6">
    <textarea style="resize:none;" placeholder="<?= __("description") ?>" class="form-control" id="note" name="description" required><?= old('description') ?></textarea>
</div>
<span class="col-sm-4 control-label">
    <?php echo form_error($errors, 'note'); ?>
</span>

</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
        <input type="submit" class="btn btn-success btn-block" value="Save" >
    </div>
</div>
<?= csrf_field() ?>
</form>
</div>    
</div>
</div>
</div>
<script type="text/javascript">
    $('.allowance_type').change(function () {
        var val = $(this).val();
        if (val === '1') {
            $('#percentage_check').show();
            $('#amount_check').hide();
            $('#amount').val('');
        }
        if (val === '0') {
            $('#percentage_check').hide();
            $('#amount_check').show();
            $('#ercentage').val('');
        }
    });
    $('#allowance_type').change(function () {
        var val = $(this).val();
        var text = $(this).text();
        $('#pension_included').val(val);
        $('#pension_included').html(text);
    });
</script>
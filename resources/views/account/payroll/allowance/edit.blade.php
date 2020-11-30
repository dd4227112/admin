
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-signal"></i> <?= __('panel_title') ?>-<?= __('allowance_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
            <li><a href="<?= url("grade/index") ?>"><?= __('allowance_title') ?></a></li>
            <li class="active"><?= __('menu_edit') ?> <?= __('allowance_title') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <div class="box-body">
        <span class="section"><?= __('menu_edit') . ' ' . __('allowance_title') ?>  </span> <p> <?= __('fields_marked') ?>  <span class="red">*</span> <?= __('are_mandatory') ?> </p>
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
                        <input type="text" class="form-control" id="name"   placeholder="<?= __('name') ?>" name="name" value="<?= old('name', $allowance->name) ?>" >
                    </div>
                    <span class="col-sm-4 control-label">
                        <?php echo form_error($errors, 'name'); ?>
                    </span>
            </div>
            <div class="form-group">              
                <label for="category" class="col-sm-2 control-label">
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
                    echo form_dropdown("category", $array, old("category", $allowance->category), "id='category' class='form-control'");
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
                <?php
                $array = [0 => 'Taxable', 1 => 'Non Taxable'];

                echo form_dropdown("type", $array, old("type", $allowance->type), "id='type' class='form-control select2'");
                ?>
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
            <?php
            $pension_included_array = [0 => 'Not-Included', 1 => 'Included'];

            echo form_dropdown("pension_included", $pension_included_array, old("pension_included", $allowance->pension_included), "id='pension_included' class='form-control select2'");
            ?>
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
        <input type="radio" class="allowance_type" name="is_percentage" <?=$allowance->is_percentage==1 ?'checked="checked"':''?> value="1">
        &nbsp;&nbsp; <?= __("fixed_amount") ?> 
        <input type="radio" class="allowance_type" name="is_percentage"  <?=$allowance->is_percentage==0 ?'checked="checked"':''?> value="0">
    </div>
    <span class="col-sm-4 control-label">
        <?php echo form_error($errors, 'is_percentage'); ?>
    </span>
</div>
<div id="amount_check"  <?=$allowance->is_percentage==0 ?'':'style="display: none"'?> >
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
        <input placeholder="<?= __("amount") ?>" type="number" class="form-control" id="amount" name="amount" value="<?= old('amount', $allowance->amount) ?>" >
    </div>
    <span class="col-sm-4 control-label">
        <?php echo form_error($errors, 'amount'); ?>
    </span>
</div>
</div>

<div id="percentage_check" <?=$allowance->is_percentage==1 ?'':'style="display: none"'?>>
    <?php
    if (form_error($errors, 'percent'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
    <label for="amount" class="col-sm-2 control-label">
        <?= __("percentage") ?>
    </label>
    <div class="col-sm-6">
        <input placeholder="<?= __("percentage") ?>" type="number" class="form-control" id="percentage" name="percent" value="<?= old('percent', $allowance->percent) ?>" >
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
    <textarea style="resize:none;" placeholder="<?= __("description") ?>" class="form-control" id="note" name="description"><?= old('description', $allowance->description) ?></textarea>
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
</script>
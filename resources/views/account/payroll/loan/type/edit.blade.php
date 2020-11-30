
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-signal"></i> <?= __('panel_title') ?>-<?= __('loan_type') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
            <li><a href="<?= url("loan/type") ?>"><?= __('loan_type') ?></a></li>
            <li class="active"><?= __('menu_add') ?> <?= __('loan_type') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <div class="box-body">
        <span class="section"><?= __('menu_add') . ' ' . __('loan_type') ?>  </span> <p> <?= __('fields_marked') ?>  <span class="red">*</span> <?= __('are_mandatory') ?> </p>
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
                        <input type="text" class="form-control" id="name"   placeholder="<?= __('name') ?>" name="name" value="<?= old('name', $type->name) ?>" required>
                    </div>
                    <span class="col-sm-4 control-label">
                        <?php echo form_error($errors, 'name'); ?>
                    </span>
            </div>


            <?php
            if (form_error($errors, 'minimum_amount'))
                echo "<div class='form-group has-error' >";
            else
                echo "<div class='form-group' >";
            ?>
            <label for="is_penalty" class="col-sm-2 control-label">
                <?= __("minimum_amount") ?>
            </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="minimum_amount"   placeholder="<?= __('minimum_amount') ?>" name="minimum_amount" value="<?= old('minimum_amount', $type->minimum_amount) ?>" required>
            </div>
            <span class="col-sm-4 control-label">
                <?php echo form_error($errors, 'minimum_amount'); ?>
            </span>
        </div>

        <div id="amount_check">
            <?php
            if (form_error($errors, 'maximum_amount'))
                echo "<div class='form-group has-error' >";
            else
                echo "<div class='form-group' >";
            ?>
            <label for="amount" class="col-sm-2 control-label">
                <?= __("maximum_amount") ?>
            </label>
            <div class="col-sm-6">
                <input placeholder="<?= __("maximum_amount") ?>" type="text" class="form-control" id="maximum_amount" name="maximum_amount" value="<?= old('maximum_amount', $type->maximum_amount) ?>" >

            </div>
            <span class="col-sm-4 control-label">
                <?php echo form_error($errors, 'maximum_amount'); ?>
            </span>
        </div>
        <div id="percentage_check">
            <?php
            if (form_error($errors, 'minimum_tenor'))
                echo "<div class='form-group has-error' >";
            else
                echo "<div class='form-group' >";
            ?>
            <label for="minimum_tenor" class="col-sm-2 control-label">
                <?= __("minimum_tenor") ?>
            </label>
            <div class="col-sm-6">
                <input placeholder="<?= __("minimum_tenor") ?>" type="number" class="form-control" id="minimum_tenor" name="minimum_tenor" value="<?= old('minimum_tenor', $type->minimum_tenor) ?>" >

            </div>
            <span class="col-sm-4 control-label">
                <?php echo form_error($errors, 'minimum_tenor'); ?>
            </span>
        </div>
        <?php
        if (form_error($errors, 'maximum_tenor'))
            echo "<div class='form-group has-error' >";
        else
            echo "<div class='form-group' >";
        ?>
        <label for="employer_amount" class="col-sm-2 control-label">
            <?= __("maximum_tenor") ?>
        </label>
        <div class="col-sm-6">
            <input placeholder="<?= __("maximum_tenor") ?>" type="number" class="form-control" id="maximum_tenor" name="maximum_tenor" value="<?= old('maximum_tenor', $type->maximum_tenor) ?>" >

        </div>
        <span class="col-sm-4 control-label">
            <?php echo form_error($errors, 'maximum_tenor'); ?>
        </span>
    </div>

</div>


<?php
if (form_error($errors, 'interest_rate'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="interest_rate" class="col-sm-2 control-label">
    <?= __("interest_rate") ?>
</label>
<div class="col-sm-6">
    <input placeholder="<?= __("interest_rate") ?>" type="number" class="form-control" id="interest_rate" name="interest_rate" value="<?= old('interest_rate', $type->interest_rate) ?>" min="0" max="100" >

</div>
<span class="col-sm-4 control-label">
    <?php echo form_error($errors, 'interest_rate'); ?>
</span>
</div>

</div>

<?php
if (form_error($errors, 'credit_ratio'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="interest_rate" class="col-sm-2 control-label">
    <?= __("credit_ratio") ?>
</label>
<div class="col-sm-6">
    <input placeholder="<?= __("credit_ratio") ?>" type="number" class="form-control" id="credit_ratio" name="credit_ratio" value="<?= old('credit_ratio', $type->credit_ratio) ?>"  min="0" max="100"  >

</div>
<span class="col-sm-4 control-label">
    <?php echo form_error($errors, 'interest_rate'); ?>
</span>
</div>



<?php
if (form_error($errors, 'description'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="description" class="col-sm-2 control-label">
    <?= __("description") ?><span class="red">*</span>
</label>
<div class="col-sm-6">
    <textarea style="resize:none;" placeholder="<?= __("description") ?>" class="form-control" id="note" name="description" required><?= old('description', $type->description) ?></textarea>
</div>
<span class="col-sm-4 control-label">
    <?php echo form_error($errors, 'description'); ?>
</span>
<a><i class="fa fa-question-circle" data-container="body"
      data-toggle="popover" data-placement="top" data-trigger="hover"
      data-content="<?= __("summary") ?>"
      title="<?= __("summary") ?>"></i></a>
</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-4">
        <input type="submit" class="btn btn-primary btn-block" value="Save" >
    </div>
</div>
<?= csrf_field() ?>
</form>
</div>    
</div>
</div>
</div>
<script type="text/javascript">

</script>
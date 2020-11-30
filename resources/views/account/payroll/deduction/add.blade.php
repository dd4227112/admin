
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-feetype"></i> <?= __('panel_title') ?>-<?= __('deduction') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
            <li><a href="<?= url("deduction/index") ?>"><?= __('deduction') ?></a></li>
            <li class="active"><?= __('menu_add') ?> <?= __('deduction') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <div class="box-body">
        <span class="section"><?= __('menu_add') . ' ' . __('deduction') ?>  </span> <p> <?= __('fields_marked') ?>  <span class="red">*</span> <?= __('are_mandatory') ?> </p>
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
                <label for="deduction_type" class="col-sm-2 control-label">
                    <?= __("category") ?>
                </label>
                <div class="col-sm-6">
                    <?php
                    $array = array("0" => __("select"));
                    $deduction_types = [
                        '1' => 'Fixed Deductions',
                        '2' => 'Monthly Deductions'
                    ];
                    foreach ($deduction_types as $key => $value) {
                        $array[$key] = $value;
                    }
                    echo form_dropdown("category", $array, old("category"), "id='category' class='form-control'");
                    ?>
                </div>
            </div>

            <?php
            if (form_error($errors, 'is_percentage'))
                echo "<div class='form-group has-error' >";
            else
                echo "<div class='form-group' >";
            ?>
            <label for="is_penalty" class="col-sm-2 control-label">
                <?= __("type") ?>
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
                <?= __("employee_amount") ?>
            </label>
            <div class="col-sm-6">
                <input placeholder="<?= __("employee_amount") ?>" type="number" class="form-control" id="amount" name="amount" value="<?= old('amount') ?>" >
                <i class="fa fa-question-circle" data-container="body"
                   data-toggle="popover" data-placement="top" data-trigger="hover"
                   data-content="<?= __("Default Amount") ?>"
                   title="<?= __("Default Amount") ?>"></i>
            </div>
            <span class="col-sm-4 control-label">
                <?php echo form_error($errors, 'point'); ?>
            </span>
        </div>
                  <?php
            if (form_error($errors, 'employer_amount'))
                echo "<div class='form-group has-error' >";
            else
                echo "<div class='form-group' >";
            ?>
            <label for="employer_amount" class="col-sm-2 control-label">
                 <?= __("employer_amount") ?>
            </label>
            <div class="col-sm-6">
                <input placeholder="<?= __("employer_amount") ?>" type="number" class="form-control" id="employer_amount" name="employer_amount" value="<?= old('employer_amount') ?>" >
                <i class="fa fa-question-circle" data-container="body"
                   data-toggle="popover" data-placement="top" data-trigger="hover"
                   data-content="<?= __("Default Amount") ?>"
                   title="<?= __("Default Amount") ?>"></i>
            </div>
            <span class="col-sm-4 control-label">
                <?php echo form_error($errors, 'point'); ?>
            </span>
        </div>
   
    </div>

    <div id="percentage_check" style="display: none">
        <?php
        if (form_error($errors, 'percentage'))
            echo "<div class='form-group has-error' >";
        else
            echo "<div class='form-group' >";
        ?>
        <label for="amount" class="col-sm-2 control-label">
            <?= __("employee_percent") ?>
        </label>
        <div class="col-sm-6">
            <input placeholder="<?= __("employee_percent") ?>" type="number" class="form-control" id="percentage" name="percent" value="<?= old('percentage') ?>" >
          
        </div>
        <span class="col-sm-4 control-label">
            <?php echo form_error($errors, 'point'); ?>
        </span>
    </div>
  <?php
        if (form_error($errors, 'employer_percent'))
            echo "<div class='form-group has-error' >";
        else
            echo "<div class='form-group' >";
        ?>
        <label for="employer_percentage" class="col-sm-2 control-label">
            <?= __("employer_percent") ?>
        </label>
        <div class="col-sm-6">
            <input placeholder="<?= __("employer_percent") ?>" type="number" class="form-control" id="employer_percent" name="employer_percent" value="<?= old('employer_percent') ?>" >
           
        </div>
        <span class="col-sm-4 control-label">
            <?php echo form_error($errors, 'employer_percent'); ?>
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

<h2>Optional Fields</h2>
 <div class="form-group">              
                <label for="gross_pay_id" class="col-sm-2 control-label">
                   Deduct From
                </label>
                <div class="col-sm-6">
                    <?php
                    $darray = array("0" => __("select"));
                    $darray[0]='Basic Pay';
                    $darray[1]='Gross Pay';
                    echo form_dropdown("gross_pay", $darray, old("gross_pay",0), "id='gross_pay_id' class='form-control'");
                    ?>
                </div>
            </div>
            <div class="form-group">              
                <label for="bank_account_id" class="col-sm-2 control-label">
                    <?= __("bank_account") ?>
                </label>
                <div class="col-sm-6">
                    <?php
                    $array = array("0" => __("select"));
                    $banks = \App\Model\BankAccount::all();
                    foreach ($banks as $bank) {
                        $array[$bank->id] = $bank->name;
                    }
                    echo form_dropdown("bank_account_id", $array, old("bank_account_id"), "id='bank_account_id' class='form-control'");
                    ?>
                </div>
            </div>
      <?php
                    if (form_error($errors, 'account_number'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                    <label for="grade" class="col-sm-2 control-label">
                        <?= __("account_number") ?><span class="red"></span>
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="account_number"   placeholder="<?= __('account_number') ?>" name="account_number" value="<?= old('account_number') ?>" >
                        
                    </div>
                    <span class="col-sm-4 control-label">
                        <?php echo form_error($errors, 'account_number'); ?>
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
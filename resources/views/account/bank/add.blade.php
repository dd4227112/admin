
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-signal"></i> <?= $data->lang->line('panel_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li><a href="<?= base_url("bankaccount/index") ?>"><?= $data->lang->line('panel_title') ?></a></li>
            <li class="active"><?= $data->lang->line('add_title') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            
            <div class="col-sm-8">
                @if(url()->previous()!=url()->current())
                <a class="btn btn-sm btn-info" href="{{url()->previous()}}"><i class="fa fa-arrow-circle-left"> @lang('application_lang.go_back')</i></a>
                @endif
                <div class="info col-lg-offset-2"><i class="fa fa-plus"></i>This will automatically add this in charts of accounts and create/use a group named Banks</div>
                <br/>
                <form class="form-horizontal" role="form" method="post">

                    <?php
                    if (form_error($errors, 'refer_bank_id'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                    <label for="feetype" class="col-sm-2 control-label">
                        <?= $data->lang->line("bankaccount_name") ?><span class="red">*</span>
                    </label>
                    <div class="col-sm-6">

                        <?php
                        $array = array('0' => trans('bankaccount_lang.select_bank'));
                        $banks = \App\Model\ReferBank::all();
                        foreach ($banks as $bank) {
                            $array[$bank->id] = $bank->name;
                        }

                        echo form_dropdown("refer_bank_id", $array, old("refer_bank_id"), "id='refer_bank_id' class='form-control select2' ");
                        ?>
                        <span id="select_section_status"></span>
                    </div>
                    <span class="col-sm-4 control-label">
                        <?php echo form_error($errors, 'refer_bank_id'); ?>
                    </span>
            </div>

            <?php
            if (form_error($errors, 'branch'))
                echo "<div class='form-group has-error' >";
            else
                echo "<div class='form-group' >";
            ?>
            <label for="feetype" class="col-sm-2 control-label">
                <?= $data->lang->line("bankaccount_branch") ?><span class="red">*</span>
            </label>
            <div class="col-sm-6">
                <input type="text" placeholder="<?= $data->lang->line('branch') ?>" class="form-control" id="bankaccount_branch" name="branch" value="<?= old('branch') ?>" >
            </div>
            <span class="col-sm-4 control-label">
                <?php echo form_error($errors, 'branch'); ?>
            </span>
        </div>


        <?php
        if (form_error($errors, 'name'))
            echo "<div class='form-group has-error' >";
        else
            echo "<div class='form-group' >";
        ?>
        <label for="feetype" class="col-sm-2 control-label">
            <?= $data->lang->line("bankaccount_account_name") ?><span class="red">*</span>
        </label>
        <div class="col-sm-6">
            <input required type="text" class="form-control" placeholder="<?= $data->lang->line('name') ?>" id="account_name" name="name" value="<?= old('name',$siteinfos->sname) ?>" >
        </div>
        <span class="col-sm-4 control-label">
            <?php echo form_error($errors, 'name'); ?>
        </span>
    </div>

    <?php
    if (form_error($errors, 'number'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
    <label for="feetype" class="col-sm-2 control-label">
        <?= $data->lang->line("bankaccount_account") ?><span class="red">*</span>
    </label>
    <div class="col-sm-6">
        <input required type="text" class="form-control require" placeholder="<?= $data->lang->line("account_number") ?>" id="bankaccount_account" name="number" value="<?= old('number') ?>" >
    </div>
    <span class="col-sm-4 control-label">
        <?php echo form_error($errors, 'number'); ?>
    </span>
</div>

<?php
if (form_error($errors, 'refer_currency_id'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="feetpeAccount" class="col-sm-2 control-label">
    <?= $data->lang->line("bankaccount_currency") ?><span class="red">*</span>
</label>
<div class="col-sm-6">

    <?php
    $currencies = \App\Model\ReferCurrency::all();
    $array_ = array('0' => $data->lang->line("bankaccount_select_currency"));

    foreach ($currencies as $currency) {
        $array_[$currency->id] = $currency->currency.' ('.$currency->symbol.')';
    }
    echo form_dropdown("refer_currency_id", $array_, old("refer_currency_id"), "id='bankaccount_currency' class='form-control select2'");
    ?>
</div>
<span class="col-sm-4 control-label">
    <?php echo form_error($errors, 'refer_currency_id'); ?>
</span>
</div>   

<?php
if (form_error($errors, 'opening_balance'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="amount" class="col-sm-2 control-label">
    <?= $data->lang->line("opening_balance") ?><span class="red">*</span>
</label>
<div class="col-sm-6">
    <input type="text" class="form-control" placeholder="" id="opening_balance" name="opening_balance" value="<?= old('opening_balance') ?>" >
</div>
<span class="col-sm-4 control-label">
    <?php echo form_error($errors, 'opening_balance'); ?>
</span>
</div>

<?php
if (form_error($errors, 'note'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="note" class="col-sm-2 control-label">
    <?= $data->lang->line("bankaccount_note") ?>
</label>
<div class="col-sm-6">
    <textarea class="form-control" style="resize:none;" id="note" name="note"><?= old('note') ?></textarea>
</div>
<span class="col-sm-4 control-label">
    <?php echo form_error($errors, 'note'); ?>
</span>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-4">
        <input type="submit" class="btn btn-primary btn-block" value="<?= $data->lang->line("save") ?>" >
    </div>
</div>

<?= csrf_field() ?>
</form>

</div>
</div>
</div>
</div>

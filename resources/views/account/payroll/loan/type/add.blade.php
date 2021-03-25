@extends('layouts.app')
@section('content')


<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Loan</h4>
                <span>Add loan type</span>
            </div>

            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= url("loan/type") ?>"><?= __('loan_type') ?></a>
                    </li>
                </ul>
            </div>

        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <header class="panel-heading">
                           Fill all basic information correctly
                        </header>
                        <div class="card-body">
                            <div id="error_area"></div>
                            <div class="form">
                                     
                                <form class="form-horizontal" role="form" method="post" action="<?= url('loan/add') ?>">

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
                
                
                            <?php
                            if (form_error($errors, 'minimum_amount'))
                                echo "<div class='form-group has-error' >";
                            else
                                echo "<div class='form-group' >";
                            ?>
                            <label for="is_penalty" class="col-sm-2 control-label">
                                <?= __("minimum_amount") ?><span class="red">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="minimum_amount"   placeholder="<?= __('minimum_amount') ?>" name="minimum_amount" value="<?= old('minimum_amount') ?>" required>
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
                                <?= __("maximum_amount") ?><span class="red">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input placeholder="<?= __("maximum_amount") ?>" type="text" class="form-control" id="maximum_amount" name="maximum_amount" value="<?= old('maximum_amount') ?>" >
                
                            </div>
                            <span class="col-sm-4 control-label">
                                <?php echo form_error($errors, 'maximum_amount'); ?>
                            </span>
                        </div>
                        <?php
                        if (form_error($errors, 'maximum_tenor'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                        ?>
                        <label for="employer_amount" class="col-sm-2 control-label">
                            <?= __("maximum_tenor") ?><span class="red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input placeholder="<?= __("maximum_tenor") ?>" type="number" class="form-control" id="maximum_tenor" name="maximum_tenor" value="<?= old('maximum_tenor') ?>" >
                
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors, 'maximum_tenor'); ?>
                        </span>
                    </div>
                
                </div>
                
                <div id="percentage_check">
                    <?php
                    if (form_error($errors, 'minimum_tenor'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                    <label for="minimum_tenor" class="col-sm-2 control-label">
                        <?= __("minimum_tenor") ?><span class="red">*</span>
                    </label>
                    <div class="col-sm-6">
                        <input placeholder="<?= __("minimum_tenor") ?>" type="number" class="form-control" id="minimum_tenor" name="minimum_tenor" value="<?= old('minimum_tenor') ?>" >
                
                    </div>
                    <span class="col-sm-4 control-label">
                        <?php echo form_error($errors, 'minimum_tenor'); ?>
                    </span>
                </div>
                <?php
                if (form_error($errors, 'interest_rate'))
                    echo "<div class='form-group has-error' >";
                else
                    echo "<div class='form-group' >";
                ?>
                <label for="interest_rate" class="col-sm-2 control-label">
                    <?= __("interest_rate") ?><span class="red">*</span>
                </label>
                <div class="col-sm-6">
                    <input placeholder="<?= __("interest_rate") ?>" type="number" class="form-control" id="interest_rate" name="interest_rate" value="<?= old('interest_rate') ?>"  min="0" max="100"  >
                
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
                    <?= __("credit_ratio") ?><span class="red">*</span>
                </label>
                <div class="col-sm-6">
                    <input placeholder="<?= __("credit_ratio") ?>" type="number" class="form-control" id="credit_ratio" name="credit_ratio" value="<?= old('credit_ratio') ?>"  min="0" max="100"  >
                <i class="fa fa-question-circle" data-container="body"
                              data-toggle="popover" data-placement="top" data-trigger="hover"
                              data-content="How much percentage of net salary must remains with this person after loan amount has been deducted"
                              title="<?= __("summary") ?>"></i>
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
                <label for="note" class="col-sm-2 control-label">
                    <?= __("description") ?><span class="red">*</span>
                </label>
                <div class="col-sm-6">
                    <textarea style="resize:none;" placeholder="<?= __("description") ?>" class="form-control" id="note" name="description" required><?= old('description') ?></textarea>
                </div>
                <span class="col-sm-4 control-label">
                    <?php echo form_error($errors, 'note'); ?>
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
            </div>
        </div>
    </div>
</div>

@endsection

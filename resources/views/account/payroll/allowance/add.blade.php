@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
    
         <div class="page-header">
            <div class="page-header-title">
                <h4><?= 'Add allowance' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">payroll</a>
                    </li>
                </ul>
            </div>
        </div>
    
        <div class="page-body">
            <div class="row">

                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-header">
                           Fill all basic information correctly
                        </div>
                        <div class="card-body">
                        
                            <div class="form">
                              <form class="form-horizontal" method="post" action="<?= url('allowance/add') ?>">

                                    <div class="form-group"> 
                                      <label for="grade" class="col-sm-2 control-label">
                                           <span class="red">Name *</span>
                                        </label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="name"   placeholder="Name" name="name"  required>
                                        </div> 
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
                                Allowance Pension Status <span class="red">*</span>
                            </label>
                            <div class="col-sm-6">
                                <select class="form-control" required="true"   name="pension_included" id="pension_included">     
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
                            &nbsp;&nbsp; <?= __("Fixed amount") ?> 
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
                            <?= __("Fixed amount") ?>
                        </label>
                        <div class="col-sm-6">
                            <input placeholder="<?= __("amount") ?>" type="text" class="form-control transaction_amount" id="amount" name="amount" value="<?= old('amount') ?>" >
                          
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
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    // $('.transaction_amount').attr("pattern", '^(\\d+|\\d{1,3}(,\\d{3})*)(\\.\\d{2})?$');
    //     $('.transaction_amount').on("keyup", function() {
    //         var currentValue = $(this).val();
    //         currentValue = currentValue.replace(/,/g, '');
    //         $(this).val(currentValue.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    //     });

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
    // $('#allowance_type').change(function () {
    //     var val = $(this).val();
    //     var text = $(this).text();
    //     $('#pension_included').val(val);
    //     $('#pension_included').html(text);
    // });
</script>

@endsection
@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Revenue</h4>
                <span>Edit revenue</span>
            </div>
     
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('Home') ?></a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!"><?= __('revenue') ?></a>
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
                           Edit
                        </header>
                        <div class="card-body">
                            <div id="error_area"></div>
                            <div class="form">

                            <form class="form-horizontal" role="form" method="post">
                                <?php
                                if (form_error($errors, 'user_in_shulesoft'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                                ?>
                                <?php
                              if(isset($revenue->user_id) && $revenue->user_id > 0 ){ ?>
                                  
                           <?php 
                            if (form_error($errors, 'user_id'))
                                echo "<div class='form-group has-error' >";
                            else
                                echo "<div class='form-group' >";
                            ?>

                           
                            <label for="payment method" class="col-sm-2 control-label">
                                Payer Name <span class="red">*</span>
                            </label>
                            <div class="col-sm-8 col-xs-12">
                                <?php
                                
                                $uarray = array('0' => ("select name"));
                                $users = \App\Models\User::where('role_id','<>',7)->where('status','<>','0')->get();
                                if (!empty($users)) {
                                    foreach ($users as $user) {
                                        $uarray[$user->id] = $user->name;
                                    }
                                }
                                echo form_dropdown("user_id", $uarray, old("user_id",$user->id), "id='user_id' class='form-control select2'");
                                
                                ?>
                            </div>

                            <span class="col-sm-4 control-label">
                                <?php echo form_error($errors, 'user_id'); ?>
                            </span>              
                                  
                                  
                             <?php }else { ?>
                                 
                       <?php
                        if (form_error($errors, 'payer_name'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                        ?>
                        <label for="amount" class="col-sm-2 control-label">
                            <?= ("Payer name") ?><span class="red">*</span>
                        </label>
                        <div class="col-sm-8 col-xs-12">

                            <input type="text" class="form-control" id="amount" name="payer_name" value="<?= old('payer_name',$revenue->payer_name) ?>"  placeholder="  e.g Juma Ali" onblur="this.value = this.value.toUpperCase()">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors, 'payer_name'); ?>
                        </span>               
                         <?php } ?>   
                     </div>
                          
                  
                    <?php
                    if (form_error($errors, 'payer_phone'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                    <label for="amount" class="col-sm-2 control-label">
                        <?= ("Payer phone") ?><span class="red">*</span>
                    </label>
                    <div class="col-sm-8 col-xs-12">

                        <input class="form-control phoneNumber" id="payer_phone" name="payer_phone"  value="<?= old('payer_phone',$revenue->payer_phone) ?>" type="tel"  placeholder="e.g 655406004">
                        <span id="valid-msg" class="hide">✓ Valid</span>
                        <span id="error-msg" class="hide">Invalid</span>
                        <input type="hidden" id="phone" name="payer_phone" value="<?=old('payer_phone', $revenue->payer_phone)?>" >
                    </div>
                    <span class="col-sm-4 control-label">
                        <?php echo form_error($errors, 'payer_phone'); ?>
                    </span>
                </div>
                <?php
                if (form_error($errors, 'Payer email'))
                    echo "<div class='form-group has-error' >";
                else
                    echo "<div class='form-group' >";
                ?>
                <label for="amount" class="col-sm-2 control-label">
                    <?= ("Payer email") ?>
                </label>
                <div class="col-sm-8 col-xs-12">

                    <input type="text" class="form-control" id="payer_email" name="payer_email" value="<?= old('payer_email',$revenue->payer_email) ?>"  onblur="this.value = this.value.toLowerCase()" placeholder="option">
                </div>
                <span class="col-sm-4 control-label">
                    <?php echo form_error($errors, 'payer_email'); ?>
                </span>
            </div>
        </div>
        <?php
        if (form_error($errors, 'refer_expense_id'))
            echo "<div class='form-group has-error' >";
        else
            echo "<div class='form-group' >";
        ?>
        <label for="expense" class="col-sm-2 control-label">
            <?= ("Revenue Type") ?><span class="red">*</span>
        </label>
        <div class="col-sm-8 col-xs-12">
            <?php
            $array = array('0' => ("select_expense"));
            if (!empty($category)) {
                foreach ($category as $categ) {
                    $array[$categ->id] = $categ->name;
                }
            }
            echo form_dropdown("refer_expense_id", $array, old("refer_expense_id",$revenue->refer_expense_id), "id='refer_expense_id' class='form-control'");
            ?>
            <?php if (!empty($category)) { ?>
            <?php } ?>
        </div>
        {{-- <span class="col-sm-2 small"><a href="<?= url("expense/financial_category") ?>">Create New</a></span> --}}
        <span class="col-sm-4 control-label">
            <?php echo form_error($errors, 'refer_expense_id'); ?>
        </span>
    </div>

    <?php
    if (form_error($errors, 'amount'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
    <label for="amount" class="col-sm-2 control-label">
        <?= ("amount") ?><span class="red">*</span>
    </label>
    <div class="col-sm-8 col-xs-12">

        <input type="number" class="form-control" id="amount" name="amount" value="<?= old('amount',$revenue->amount) ?>" required="true">
    </div>
    <span class="col-sm-4 control-label">
        <?php echo form_error($errors, 'amount'); ?>
    </span>
</div>

<?php
if (form_error($errors, 'payment_method'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="payment method" class="col-sm-2 control-label">
    Payment method <span class="red">*</span>
</label>
<div class="col-sm-8 col-xs-12">
   
 <select name="payment_type_id" id="payment_method_status" class="form-control" required="">
           <option value="<?=$revenue->payment_type_id ?>"><?=isset($revenue->paymentType->name) ?></option>
            <?php
            
            if (!empty($payment_types) ) {

                foreach ($payment_types as $payment_type) {
                    ?>

                    <option value="<?= $payment_type->id ?>"><?= $payment_type->name ?></option>

                    <?php
                }
            }
            ?>
                    </select>
</div>
<span class="col-sm-4 control-label">
    <?php echo form_error($errors, 'payment_method'); ?>
</span>
</div>
<div id="refer_no" style="display: none">
    <?php
    if (form_error($errors, 'bank_name'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
    <label for="bank" class="col-sm-2 control-label">Bank Name</label>
    <div class="col-sm-8 col-xs-12">
        <select class="select2_multiple form-control" name="bank_account_id" id="bank_name">               <option value=""></option>
            <?php
            if (!empty($banks)) {
                foreach ($banks as $bank) {
                    ?>
                    <option value="<?= $bank->id ?>"><?= $bank->referBank->name . ' (' . $bank->number . ')' ?></option>
                <?php
                }
             }
            ?>    
        </select>
    </div>
    <span class="col-sm-4 control-label">
<?php echo form_error($errors, 'bank_name'); ?>
    </span>
</div>


<?php
if (form_error($errors, 'transaction_id'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="amount" class="col-sm-2 control-label">
<?= ("ref_no") ?>
</label>
<div class="col-sm-8 col-xs-12">
    <input type="text" placeholder="Enter ref number/cheque number" class="form-control" id="ref_no" name="transaction_id" value="<?= old('transaction_id',  $revenue->transaction_id) ?>">
</div>
<span class="col-sm-4 control-label">
    <span id="ref_no_status"></span>
<?php echo form_error($errors, 'transaction_id'); ?>
</span>
</div>
</div>
<?php
if (form_error($errors, 'date'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="date" class="col-sm-2 control-label">
<?= ("date") ?> <span class="red">*</span>
</label>
<div class="col-sm-8 col-xs-12">
    <div class="icon-addon addon-lg">
    <input type="date" class="form-control calendar" id="date" name="date" value="<?= old('date',$revenue->date) ?>" required="true" >
<span class="fa fa-calendar"></span>
        </div>
</div>
<span class="col-sm-4 control-label">
<?php echo form_error($errors, 'date'); ?>
</span>
</div>

<?php
if (form_error($errors, 'note'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="note" class="col-sm-2 control-label">
<?= ("note") ?>
</label>
<div class="col-sm-8 col-xs-12">
    <textarea style="resize:none;" class="form-control" id="note" name="note"><?= old('note',$revenue->note) ?></textarea>
</div>
<span class="col-sm-4 control-label">
<?php echo form_error($errors, 'note'); ?>
</span>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-8">
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

    payment_method_status = function () {
      $('#payment_method_status').change(function () {
        var val = $(this).val();
        if (val !== 'cash') {
          $('#refer_no').show();
        } else {
          $('#refer_no').hide();
        }
      });
      $('#user_in_shulesoft').change(function () {
        var val = $(this).val();
        if (val === '1') {
          $('#user_in_shulesoft_tag').show();
          $('#user_not_in_shulesoft_tag').hide();
        } else if (val === '2') {
          $('#user_in_shulesoft_tag').hide();
          $('#user_not_in_shulesoft_tag').show();
        } else {
          $('#user_in_shulesoft_tag').hide();
          $('#user_not_in_shulesoft_tag').hide();
        }
      });
    };
</script>
@endsection
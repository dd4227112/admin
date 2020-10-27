@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Transactions</h4>
                <span>Record transactions based on dates</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Transactions</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-header">

                            <h3 class="box-title"><i class="fa icon-expense"></i>  <?php
                                if ($id == 4) {
                                    echo 'Company Expenses';
                                } elseif ($id == 1) {
                                    echo "Fixed Assets";
                                } else if ($id == 2) {
                                    echo "Liabilities";
                                } else if ($id == 3) {
                                    echo "Capital Management";
                                } else if ($id == 5) {
                                    echo 'Current Assets';
                                }
                                ?></h3>     

                            <span>Specify information correctly as specified. Area marked with * are mandatory</span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                        </div>

                        <div class="card-block">
                            <form class="form-horizontal" role="form" method="post">

                                <?php if ($check_id == 4 || $check_id == 1 || $check_id == 5) { ?>

                                    <div class='form-group row' >
                                        <label for="payment method" class="col-sm-2 control-label">
                                            User From<span class="red">*</span>
                                        </label>
                                        <div class="col-sm-6">
                                            <select name="user_in_shulesoft" id="user_in_shulesoft" class="form-control">
                                                <option value="0" selected="true">Select User type</option>
                                                <option value="1">User in ShuleSoft</option>
                                                <option value="2">User Not in ShuleSoft</option>
                                            </select>
                                        </div>
                                        <span class="col-sm-4 control-label">
                                            <?php echo form_error($errors, 'user_in_shulesoft'); ?>
                                        </span>
                                    </div>
                                    <div  style="display: none" id="user_in_shulesoft_tag" <?php request('user_in_shulesoft') == 1 ? '' : 'style="display: none;"' ?>>        
                                        <div class='form-group row' >
                                            <label for="payment method" class="col-sm-2 control-label">
                                                Recipient <span class="red">*</span>
                                            </label>
                                            <div class="col-sm-6">
                                                <?php
                                                $uarray = array('0' => "select User");
                                                $users = \App\Models\User::where('status', 1)->where('role_id', '<>', 7)->get();
                                                if (count($users)) {


                                                    foreach ($users as $user) {
                                                        $uarray[$user->name()] = $user->name();
                                                    }
                                                }
                                                echo form_dropdown("recipient", $uarray, old("recipient"), "id='recipient' class='form-control select2'");
                                                ?>
                                            </div>

                                            <span class="col-sm-4 control-label">
                                                <?php echo form_error($errors, 'user_id'); ?>
                                            </span>
                                        </div>   
                                    </div>
                                    <div  style="display: none" id="user_not_in_shulesoft_tag"  <?php request('user_in_shulesoft') == 2 ? '' : 'style="display: none;"' ?>>
                                        <div class='form-group row' >
                                            <label for="amount" class="col-sm-2 control-label">
                                                Recipient<span class="red">*</span>
                                            </label>
                                            <div class="col-sm-6">

                                                <input type="text" class="form-control" id="amount" name="recipient" value="<?= old('recipient', $expense->recipient) ?>"  placeholder="  e.g Juma Ali" onblur="this.value = this.value.toUpperCase()">
                                            </div>
                                            <span class="col-sm-4 control-label">
                                                <?php echo form_error($errors, 'payer_name'); ?>
                                            </span>
                                        </div>	    
                                    </div>	    
                                <?php } ?>



                                <div class='form-group row' >
                                    <label for="expense" class="col-sm-2 control-label">
                                        <?= __("expense") ?>
                                    </label>
                                    <div class="col-sm-6">
                                        <?php
                                        
                                        $array = array('0' => "select expense");
                                        if (!empty($category)) {
                                            foreach ($category as $categ) {
                                                $array[$categ->id] = $categ->name;
                                            }
                                        }
                                        echo form_dropdown("expense", $array, old("expense", $expense->refer_expense_id), "id='refer_expense_id' class='form-control select2' name='expense'");
                                        ?>
                                        <?php if (empty($category)) { ?>
                                            <span class="red">Please click  <a href="<?= url("expense/financial_category/$check_id") ?>" class="btn btn-primary" role="button">add category</a> to add category</span>
                                        <?php } ?>
                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'expense'); ?>
                                    </span>
                                </div>
                                <?php if ($check_id == 2 || $check_id == 5) { ?>

                                    <div class='form-group row' >
                                        <label for="amount" class="col-sm-2 control-label">
                                        </label>
                                        <div class="col-sm-6">


                                            <input type="radio" value="0"   class="form-group row"  name="type"/>
                                            <label  >
                                                Pay</label>

                                            <input type="radio" value="1"   class="form-group row"  name="type"/>        <label >
                                                Receive</label>
                                        </div>
                                        <span class="col-sm-4 control-label">
                                            <?php echo form_error($errors, 'type'); ?>
                                        </span>
                                    </div>

                                <?php } ?>



                                <div class='form-group row' >
                                    <label for="amount" class="col-sm-2 control-label">
                                        <?= __("expense amount") ?>
                                    </label>
                                    <div class="col-sm-6">

                                        <input type="text" class="form-control" id="amount" name="amount" value="<?= old('amount', $expense->amount) ?>" required="true">
                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'amount'); ?>
                                    </span>
                                </div>


                                <div class='form-group row' >
                                    <label for="payment method" class="col-sm-2 control-label">
                                        Payment method <span class="red">*</span>
                                    </label>
                                    <div class="col-sm-6">


                                        <?php
                                        $array_ = array('0' => "select method");
                                        if (!empty($payment_types)) {
                                            foreach ($payment_types as $payment_type) {
                                                $array_[$payment_type->id] = $payment_type->name;
                                            }
                                        }
                                        echo form_dropdown("payment_type_id", $array_, old("payment_type_id", $expense->payment_type_id), "id='payment_type_id' class='form-control select2' name='payment_type_id'");
                                        ?>

                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'payment_method'); ?>
                                    </span>
                                </div>


                                <div class='form-group row' >
                                    <label for="amount" class="col-sm-2 control-label">
                                        <?= __("reference no") ?>
                                    </label>
                                    <div class="col-sm-6">

                                        <input type="text" placeholder="Enter ref number/cheque number" class="form-control" id="ref_no" name="transaction_id" value="<?= $expense->transaction_id ?>">
                                    </div>
                                    <span class="col-sm-4 control-label">

                                        <?php echo form_error($errors, 'transaction_id'); ?>
                                    </span>
                                </div>

                                <div id="refer_no" style="display: none">
                                    <div class='form-group row' >
                                        <label for="bank" class="col-sm-2 control-label">Bank Name</label>
                                        <div class="col-sm-6">


                                            <?php
                                            $arrayb_ = array('0' => "select expense");
                                            if (!empty($banks)) {
                                                foreach ($banks as $bank) {
                                                    $arrayb_[$bank->id] = $bank->referBank->name . ' (' . $bank->number . ')';
                                                }
                                            }
                                            echo form_dropdown("bank_account_id", $arrayb_, old("bank_account_id", $expense->bank_account_id), "id='bank_account_id' class='form-control select2' name='bank_account_id'");
                                            ?>

                                        </div>
                                        <span class="col-sm-4 control-label">
<?php echo form_error($errors, 'bank_name'); ?>
                                        </span>
                                    </div>

                                </div>
                                <div class='form-group row' >
                                    <label for="date" class="col-sm-2 control-label">
<?= __("Date") ?>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control calendar" id="date" name="date" value="<?= old('date', $expense->date) ?>" required="true" >

                                    </div>
                                    <span class="col-sm-4 control-label">
<?php echo form_error($errors, 'date'); ?>
                                    </span>
                                </div>

<?php if ($check_id == 1) { ?>

                                    <div class='form-group row' >
                                        <label for="depreciation" class="col-sm-2 control-label">
                                            Depreciation*
                                        </label>
                                        <div class="col-sm-6">

                                            <select name="depreciation" id="status" class="form-control">
                                                <option value=" ">Select Depreciation</option>
                                                <option value="0.125">Class three -12.5%</option>
                                                <option value="0.25">Class two -25%</option>
                                                <option value="0.375">Class One - 37.5%</option>
                                                <option value="0">Custom Depreciation</option>
                                            </select>
                                            <span> <a href="#" id="custom_id">  &nbsp;&nbsp;</a> </span>
                                            <input type="text" placeholder="Enter depreciation eg 0.13" hidden="true" class="form-control " id="dep" name="dep" value="" style="display: none;">

                                        </div>
                                        <span class="col-sm-4 control-label">
    <?php echo form_error($errors, 'depreciation'); ?>
                                        </span>

                                    </div>


<?php }
?>



                                <div class='form-group row' >
                                    <label for="note" class="col-sm-2 control-label">
<?= __("Note") ?>
                                    </label>
                                    <div class="col-sm-6">
                                        <textarea style="min-height: 100px" placeholder="Make sure you write a well understandable descriptions here,this will help make your accounts clear" class="form-control" id="note" name="note"><?= old('note', $expense->note) ?></textarea>
                                    </div>
                                    <span class="col-sm-4 control-label">
<?php echo form_error($errors, 'note'); ?>
                                    </span>
                                </div>

                                <div class="form-group row">
                                    <label for="submit" class="col-sm-2 control-label">

                                    </label>
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


<script>
    payment_method_status = function () {
        $('#payment_method_status').change(function () {
            var val = $(this).val();
            if (val !== 'cash') {
                $('#refer_no').show();
            } else {
                $('#refer_no').hide();
            }
        });


        $('#status').click(function () {
            var depreciation = $('#status').val();
            if (depreciation == '0') {
                $('#dep').show();
            } else {
                $('#dep').hide();
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
    $(document).ready(payment_method_status)
</script>

@endsection



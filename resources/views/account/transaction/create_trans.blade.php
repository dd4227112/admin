@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Invoices</h4>
                <span>Show payments summary</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?=url('/')?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Invoices</a>
                    </li>
                </ul>
            </div>
        </div>
    <div class="page-body">
        <h3 class="box-title"><i class="fa icon-expense"></i>  <?php
            if ($id == 4) {
                echo __('panel_title');
            } elseif ($id == 1) {
                echo "Fixed Assets";
            } else if ($id == 2) {
                echo "Liabilities";
            } else if ($id == 3) {
                echo "Capital Management";
            }else if($id==5){
                echo 'Current Assets';
            }
            ?></h3>     

    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="page-body">
        <div class="card">
          <a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Add  <?php
            if ($id == 4) {
                echo __('panel_title');
            } elseif ($id == 1) {
                echo "Fixed Assets";
            } else if ($id == 2) {
                echo "Liabilities";
            } else if ($id == 3) {
                echo "Capital Management";
            }else if($id==5){
                echo 'Current Assets';
            }
            ?></a>
                    
            <div class="col-sm-8">
                            <form class="form-horizontal" role="form" method="post">
				
				<?php if($check_id==4 || $check_id==1 || $check_id==5){ ?>
				    
			        <div class='form-group' >
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
                           <div class='form-group' >
                            <label for="payment method" class="col-sm-2 control-label">
                                Recipient <span class="red">*</span>
                            </label>
                            <div class="col-sm-6">
                                <?php
                                $uarray = array('0' => __("select_expense"));
                                $users = \App\Models\User::all();
                                if (count($users)) {
                                 
                                    
                                    foreach ($users as $user) {
                                        $uarray[$user->id] = $user->name;
                                    }
                                                                       
                                }
                                echo form_dropdown("user_id", $uarray, old("user_id"), "id='user_id' class='form-control select2'");
                                ?>
                            </div>

                            <span class="col-sm-4 control-label">
                                <?php echo form_error($errors, 'user_id'); ?>
                            </span>
                        </div>   
                    </div>
                    <div  style="display: none" id="user_not_in_shulesoft_tag"  <?php request('user_in_shulesoft') == 2 ? '' : 'style="display: none;"' ?>>
                       <div class='form-group' >
                        <label for="amount" class="col-sm-2 control-label">
                           Recipient<span class="red">*</span>
                        </label>
                        <div class="col-sm-6">

                            <input type="text" class="form-control" id="amount" name="payer_name" value="<?= old('payer_name') ?>"  placeholder="  e.g Juma Ali" onblur="this.value = this.value.toUpperCase()">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors, 'payer_name'); ?>
                        </span>
                    </div>	    
		</div>	    
				<?php }?>
				
				
				
			<div class='form-group' >
                                <label for="expense" class="col-sm-2 control-label">
                                    <?= __("expense") ?>
                                </label>
                                <div class="col-sm-6">
                                    <?php
                                    $array = array('0' => __("select_expense"));
                                    if (count($category)>0) {
                                        foreach ($category as $categ) {
                                            $array[$categ->id] = $categ->name;
                                        }
                                    }
                                    echo form_dropdown("expense", $array, old("expense", $sub_id), "id='refer_expense_id' class='form-control select2' name='expense'");
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

                          <div class='form-group' >
                            <label for="amount" class="col-sm-2 control-label">
                            </label>
                            <div class="col-sm-6">


                                <input type="radio" value="0"   class="form-group"  name="type"/>
                                <label  >
                                    Pay</label>

                                <input type="radio" value="1"   class="form-group"  name="type"/>        <label >
                                    Receive</label>
                            </div>
                            <span class="col-sm-4 control-label">
                                <?php echo form_error($errors, 'type'); ?>
                            </span>
                        </div>

                    <?php } ?>



                  <div class='form-group' >
                    <label for="amount" class="col-sm-2 control-label">
                        <?= __("expense_amount") ?>
                    </label>
                    <div class="col-sm-6">

                        <input type="text" class="form-control" id="amount" name="amount" value="<?= old('amount') ?>" required="true">
                    </div>
                    <span class="col-sm-4 control-label">
                        <?php echo form_error($errors, 'amount'); ?>
                    </span>
                </div>


               <div class='form-group' >
                <label for="payment method" class="col-sm-2 control-label">
                    Payment method <span class="red">*</span>
                </label>
                <div class="col-sm-6">

                    <select name="payment_type_id" id="payment_method_status" class="form-control" required="">
                         <option value="">Select Payment type</option>
            <?php
            
            if (count($payment_types) > 0) {

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


                                <div class='form-group' >
            <label for="amount" class="col-sm-2 control-label">
                <?= __("ref_no") ?>
            </label>
            <div class="col-sm-6">

                <input type="text" placeholder="Enter ref number/cheque number" class="form-control" id="ref_no" name="transaction_id" value="<?= $transaction_id ?>">
            </div>
            <span class="col-sm-4 control-label">

                <?php echo form_error($errors, 'transaction_id'); ?>
            </span>
        </div>

        <div id="refer_no" style="display: none">
            <div class='form-group' >
            <label for="bank" class="col-sm-2 control-label">Bank Name</label>
            <div class="col-sm-6">
                <select class="select2_multiple form-control" name="bank_account_id" id="bank_name">               <option value=""></option>

                    <?php
                    if (count($banks) > 0) {

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

    </div>
   <div class='form-group' >
    <label for="date" class="col-sm-2 control-label">
        <?= __("expense_date") ?>
    </label>
    <div class="col-sm-6">
        <input type="text" class="form-control calendar" id="date" name="date" value="<?= old('date') ?>" required="true" >

    </div>
    <span class="col-sm-4 control-label">
        <?php echo form_error($errors, 'date'); ?>
    </span>
</div>

<?php if ($check_id == 1) { ?>

   <div class='form-group' >
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



<div class='form-group' >
<label for="note" class="col-sm-2 control-label">
    <?= __("expense_note") ?>
</label>
<div class="col-sm-6">
    <textarea style="min-height: 100px" placeholder="Make sure you write a well understandable descriptions here,this will help make your accounts clear" class="form-control" id="note" name="note"><?= old('note') ?></textarea>
</div>
<span class="col-sm-4 control-label">
    <?php echo form_error($errors, 'note'); ?>
</span>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-4">
        <input type="submit" class="btn btn-primary btn-block" value="Save" >
    </div>
</div>

<?= csrf_field() ?>
</form>
</div>

        <p><?= __("download") ?> <a href="<?= url('storage/uploads/sample/sample_expense_upload.xlsx') ?>"><?= __("sample_installment_file") ?></a></p><br/>
        <form id="demo-form2" action="<?= url('expense/uploadByFile') ?>" class="form-horizontal" method="POST" enctype="multipart/form-data">

            <div class="form-group">

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="file" name="file"  type="file" required="required" accept=".xls,.xlsx,.csv,.odt">
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class=" ol-sm-offset-2 col-md-4 col-sm-4 col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                </div>
            </div>

            <?= csrf_field() ?>
        </form>
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



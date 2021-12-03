@extends('layouts.app')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.9/select2-bootstrap.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>


    
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h3 class="box-title"><i class="fa icon-expense"></i>  
                 <?php
                    if ($id == 4) {
                        echo ('Expenses');
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
            </div>
    

            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url("dashboard/index") ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>
                        <?php
                            if ($id == 4) {
                                echo ('Expenses');
                            } elseif ($id == 1) {
                                echo "Fixed Assets";
                            } else if ($id == 2) {
                                echo "Liabilities";
                            } else if ($id == 3) {
                                echo "Capital Management";
                            }else if($id==5){
                                echo 'Current Assets';
                            }
                            ?>
                       </a>
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

                            <span>Specify information correctly as specified. Area marked with * are mandatory</span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                        </div>
                        <div class="card tab-card">
                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                <li class="nav-item complete">
                                    <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                        <strong>Create Single Transaction</strong> 
                                    </a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item complete">
                                    <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false">Import Expenses From an Excel</a>
                                    <div class="slide"></div>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                    <div class="card-block">

                                        <header class="panel-heading">
                                            
                                            <?php
                                            if ($id == 4) {
                                                echo "Add transactions";
                                            } elseif ($id == 1) {
                                                echo "Fixed Assets";
                                            } else if ($id == 2) {
                                                echo "Liabilities";
                                            } else if ($id == 3) {
                                                echo "Capital Management";
                                            }else if($id==5){
                                                echo 'Current Assets';
                                            } ?>
                                        </header>
                                        <div class="card-block">

                                            <form class="form-horizontal" role="form" method="post">
                                                <?php if($check_id==4 || $check_id==1 || $check_id==5){ ?>
                                                    
                                                      <?php
                                                                if (form_error($errors, 'user_in_shulesoft'))
                                                                    echo "<div class='form-group has-error' >";
                                                                else
                                                                    echo "<div class='form-group' >";
                                                                ?>
                                                                <label for="payment method" class="col-sm-2 control-label">
                                                                <?=('User from')?><span class="red">*</span>
                                                                </label>
                                                                <div class="col-sm-6">
                                                                    <select name="user_in_shulesoft" id="user_in_shulesoft" class="form-control select2">
                                                                        <option value="0" selected="true"> <?=('usertype')?></option>
                                                                        <option value="1"> <?=('User in Shulesoft')?></option>
                                                                        <option value="2"> <?=('User not in Shulesoft')?></option>
                                                                    </select>
                                                                </div>
                                                                <span class="col-sm-4 control-label">
                                                                    <?php echo form_error($errors, 'user_in_shulesoft'); ?>
                                                                </span>
                                                        </div>
                                                        <div  style="display: none" id="user_in_shulesoft_tag" <?php request('user_in_shulesoft') == 1 ? '' : 'style="display: none;"' ?>>        
                                                            <?php
                                                            if (form_error($errors, 'user_id'))
                                                                echo "<div class='form-group has-error' >";
                                                            else
                                                                echo "<div class='form-group' >";
                                                            ?>
                                                            <label for="payment method" class="col-sm-2 control-label">
                                                                Recipient <span class="red">*</span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <?php
                                                                $uarray = array('0' => "select User");
                                                                $users = \App\Models\User::where('status', 1)->where('role_id', '<>', 7)->get();
                                                                if (count($users)) {
                                                                    foreach ($users as $user) {
                                                                        $uarray[$user->id] = $user->name();
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
                                                        <?php
                                                        if (form_error($errors, 'payer_name'))
                                                            echo "<div class='form-group has-error' >";
                                                        else
                                                            echo "<div class='form-group' >";
                                                        ?>
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
                                                
                                                     <?php
                                                                if (form_error($errors, 'expense'))
                                                                    echo "<div class='form-group has-error' >";
                                                                else
                                                                    echo "<div class='form-group' >";
                                                                ?>
                                                                <label for="expense" class="col-sm-2 control-label">
                                                                    <?= ("Select Category") ?>
                                                                </label>
                                                                <div class="col-sm-6">
                                                                    <?php
                                                                    $array = array('0' => ("select Name"));
                                                                    if (!empty($category)) {
                                                                        foreach ($category as $categ) {
                                                                            $array[$categ->id] = $categ->name;
                                                                        }
                                                                    }
                                                                    echo form_dropdown("expense", $array, old("expense", $sub_id), "id='refer_expense_id' class='form-control select2' name='expense'");
                                                                    ?>
                                                                  
                                                                </div>
                                                                <span class="col-sm-4 control-label">
                                                                    <?php echo form_error($errors, 'expense'); ?>
                                                                </span>
                                                        </div>
                                                        <?php if ($check_id == 2 || $check_id == 5) { ?>
                                
                                                            <?php
                                                            if (form_error($errors, 'type'))
                                                                echo "<div class='form-group has-error' >";
                                                            else
                                                                echo "<div class='form-group' >";
                                                            ?>
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
                                
                                
                                
                                                    <?php
                                                    if (form_error($errors, 'amount'))
                                                        echo "<div class='form-group has-error' >";
                                                    else
                                                        echo "<div class='form-group' >";
                                                    ?>
                                                    <label for="amount" class="col-sm-2 control-label">
                                                        <?= ("Amount") ?>
                                                    </label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control transaction_amount"
                                                        id="amount" name="amount" value="<?= old('amount') ?>" required="true">
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
                                                <?= ("Payment method") ?> <span class="red">*</span>
                                                </label>
                                                <div class="col-sm-6">
                                
                                                    <select name="payment_type_id" id="payment_method_status" class="form-control select2" required="">
                                                         <option value="">Select Payment type</option>
                                            <?php
                                            
                                               if (!empty($payment_types) ) {
                                                foreach ($payment_types as $payment_type) {?>
                                                    <option value="<?= $payment_type->id ?>"><?= $payment_type->name ?></option>
                                                    <?php
                                                 }
                                                 }?>
                                                 </select>
                                                </div>
                                                <span class="col-sm-4 control-label">
                                                    <?php echo form_error($errors, 'payment_method'); ?>
                                                </span>
                                            </div>
                                
                                
                                            <?php
                                            if (form_error($errors, 'transaction_id'))
                                                echo "<div class='form-group has-error' >";
                                            else
                                                echo "<div class='form-group' >";
                                            ?>
                                            <label for="amount" class="col-sm-2 control-label">
                                                <?= ("Reference No.") ?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Enter ref number/cheque number" class="form-control" id="ref_no" name="transaction_id" value="<?= $transaction_id ?>">
                                            </div>
                                            <span class="col-sm-4 control-label">
                                                <?php echo form_error($errors, 'transaction_id'); ?>
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
                                            <div class="col-sm-6">
                                                <select class="select2_multiple form-control" name="bank_account_id" id="bank_name">
                                                     <option value=""></option>
                                                    <?php
                                                    if (!empty($banks) ) {
                                                        foreach ($banks as $bank) { ?>
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
                                    <?php
                                    if (form_error($errors, 'date'))
                                        echo "<div class='form-group has-error' >";
                                    else
                                        echo "<div class='form-group' >";
                                    ?>
                                    <label for="date" class="col-sm-2 control-label">
                                        <?= ("Date") ?>
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="icon-addon addon-lg">
                                        <input type="date" class="form-control calendar" id="date" name="date" value="<?= date('Y-m-d') ?>" required="true" >
                                       <span class="fa fa-calendar"></span>
                                    </div>
                                                </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'date'); ?>
                                    </span>
                                </div>
                                
                                <?php if ($check_id == 1) { ?>
                                    <?php
                                    if (form_error($errors, 'depreciation'))
                                        echo "<div class='form-group has-error' >";
                                    else
                                        echo "<div class='form-group' >";
                                    ?>
                                    <label for="depreciation" class="col-sm-2 control-label">
                                        Depreciation*
                                    </label>
                                    <div class="col-sm-6">
                                        <select name="depreciation" class="form-control status">
                                            <option value=" ">Select Depreciation</option>
                                            <option value="0.125">Class three -12.5%</option>
                                            <option value="0.25">Class two -25%</option>
                                            <option value="0.375">Class One - 37.5%</option>
                                            <option value="0">Custom Depreciation</option>
                                        </select>
                                        <span> <a href="#" id="custom_id">  &nbsp;&nbsp;</a> </span>
                                        <input type="text" placeholder="Enter depreciation eg 0.13" hidden="true" 
                                        class="form-control dept"  name="dep"  style="display: none;">
                                    </div>
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'depreciation'); ?>
                                    </span>
                                    </div>
                                <?php } ?>
                                
                                <?php
                                if (form_error($errors, 'note'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                                ?>
                                <label for="note" class="col-sm-2 control-label">
                                    <?= ("Description") ?>
                                </label>
                                <div class="col-sm-6">
                                    <textarea style="min-height: 100px" placeholder="Make sure you write a well understandable descriptions here,this will help make your accounts clear" 
                                    class="form-control" id="note" name="note" required><?= old('note') ?></textarea>
                                </div>
                                <span class="col-sm-4 control-label">
                                    <?php echo form_error($errors, 'note'); ?>
                                </span>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-6">
                                        <input type="submit" class="btn btn-success btn-block" value="<?= ("save") ?>" >
                                    </div>
                                </div>
                                
                                <?= csrf_field() ?>
                                </form>

                                           
                                  </div>
                                </div>
                            </div>
                                <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                                    <div class="card-block">

                                        <div class="table-responsive dt-responsive">
                                            <div class="card-header">
                                                <div class="panel-body">
                                                    <div class="alert alert-info">
                                                        Use the exactly ShuleSoft template as provided : Excel should contains these keys at the top :'amount', 'transaction_id', 'account_number', 'categort', 'payment_method', 'expense_name', 'date','user_in_shulesoft','payer_name'
                                                        <br>   <a href="<?= url('public/sample_files/shulesoft_account.csv') ?>" style="float: right; font-weight: bold;"><i class="fa fa-download"></i> Download Sample</a></p>
                                                        <br>
                                                    </div>
                                                    <!--<p>Sample Excel Format. </p>-->
                                                    <br/>
                                                    <div class=" form">
                                   
                                                        <form id="demo-form2" action="<?= url('expense/uploadExpenses') ?>" class="form-horizontal" method="POST"
                                                              enctype="multipart/form-data">

                                                            <div class="form-group">

                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <input id="file" name="expense_file" type="file" required="required" accept=".xls,.xlsx,.csv,.odt">
                                                                </div>
                                                            </div>
                                                            <div class="ln_solid"></div>
                                                            <div class="form-group">
                                                                <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-2">
                                                                    <button type="submit" id="add_revenue" class="btn btn-primary btn-block"><?= __("submit") ?></button>
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


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
          //Format number to thousands
   
    payment_method_status = function () {
        $('#payment_method_status').change(function () {
            var val = $(this).val();
            if (val !== 'cash') {
                $('#refer_no').show();
            } else {
                $('#refer_no').hide();
            }
        });


    
        $('.status').change(function () {
        var val = $('.status').val();
         if (val === '0') {
          
            $('.dept').show();
        } else {
            $('.dept').hide();
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

    $(".select2").select2({
		theme: "bootstrap",
		dropdownAutoWidth: false,
		allowClear: false,
        debug: true
	});

    $('.transaction_amount').attr("pattern", '^(\\d+|\\d{1,3}(,\\d{3})*)(\\.\\d{2})?$');
    $('.transaction_amount').on("keyup", function() {
        var currentValue = $(this).val();
        currentValue = currentValue.replace(/,/g, '');
        $(this).val(currentValue.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    });

</script>

@endsection



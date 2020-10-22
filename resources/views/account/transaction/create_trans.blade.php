@extends('layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.9/select2-bootstrap.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>

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
                                            Add Expense

                                        </header>
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
                                                                if (sizeof($users)) {


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
                                                        <div class='form-group row' >
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
                                                        echo form_dropdown("expense", $array, old("expense", $sub_id), "id='refer_expense_id' style='border: 1px solid red' class='form-control select2' name='expense'");
                                                        ?>
                                                        <?php if (empty($category)) { ?>
                                                            <span class="red">Please click  <a href="<?= url("expense/financial_category/$check_id") ?>" class="btn btn-primary" role="button">add category</a> to add category</span>
                                                        <?php } ?>
                                                    </div>
                                                    <span class="col-sm-4 control-label">
                                                        <?php echo form_error($errors, 'expense'); ?>
                                                    </span>
                                                </div>
                                                <div class='form-group row' >
                                                    <label for="expense" class="col-sm-2 control-label">
                                                        <?= __("Department") ?><span class="red">*</span>
                                                    </label>
                                                    <div class="col-sm-6">

                                                        <select name='expense_subcategories_id' class="form-control">
                                                            <?php
                                                            $expense_subcategories = DB::table('expense_subcategories')->get();
                                                            ?>
                                                            @foreach($expense_subcategories as $value)

                                                            <option value="{{$value->id}}">{{$value->name}} </option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                            
                                                    <span class="col-sm-4 control-label">
                                                        <?php echo form_error($errors, 'expense_subcategories_id'); ?>
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

                                                        <input type="text" class="form-control" id="amount" name="amount" value="<?= old('amount') ?>" required="true">
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

                                                        <select name="payment_type_id" id="payment_method_status" class="form-control" required="">
                                                            <option value="">Select Payment type</option>
                                                            <?php
                                                            if (!empty($payment_types)) {

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


                                                <div class='form-group row' >
                                                    <label for="amount" class="col-sm-2 control-label">
                                                        <?= __("reference no") ?>
                                                    </label>
                                                    <div class="col-sm-6">

                                                        <input type="text" placeholder="Enter ref number/cheque number" class="form-control" id="ref_no" name="transaction_id" value="<?= $transaction_id ?>">
                                                    </div>
                                                    <span class="col-sm-4 control-label">

                                                        <?php echo form_error($errors, 'transaction_id'); ?>
                                                    </span>
                                                </div>

                                                <div id="refer_no" style="display: none">
                                                    <div class='form-group row' >
                                                        <label for="bank" class="col-sm-2 control-label">Bank Name</label>
                                                        <div class="col-sm-6">
                                                            <select class="select2_multiple form-control" name="bank_account_id" id="bank_name">               <option value=""></option>

                                                                <?php
                                                                if (!empty($banks) ) {

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
                                                <div class='form-group row' >
                                                    <label for="date" class="col-sm-2 control-label">
                                                        <?= __("Date") ?>
                                                    </label>
                                                    <div class="col-sm-6">
                                                        <input type="date" class="form-control calendar" id="date" name="date" value="<?= old('date') ?>" required="true" >

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
                                                        <textarea style="min-height: 100px" placeholder="Make sure you write a well understandable descriptions here,this will help make your accounts clear" class="form-control" id="note" name="note"><?= old('note') ?></textarea>
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
                                <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                                    <div class="card-block">

                                        <div class="table-responsive dt-responsive">
                                            <div class="card-header">
                                                <div class="panel-body">
                                                    <div class="alert alert-info">Use the exactly ShuleSoft template as provided : Excel should contains these keys at the top :'amount', 'transaction_id', 'account_number', 'payment_method', 'expense_name', 'date','user_in_shulesoft','payer_name'</div>
                                                    <!--<p>Sample Excel Format. </p>-->
                                                    <!--<img src="<?= url('public/images/sample_excel.jpg') ?>"/>-->
                                                    <br/>
                                                    <div class=" form">
                                                        <!--                                                    <br/>
                                                                                                            <p><?= __("file") ?> 
                                                                                                                <a href="<?= url('storage/uploads/sample/sample_students_upload.xlsx') ?>"><i class="fa fa-2x fa-cloud-download"></i></a></p>-->
                                                        <form id="demo-form2" action="<?= url('account/uploadExpense') ?>" class="form-horizontal" method="POST"
                                                              enctype="multipart/form-data">

                                                            <div class="form-group">

                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <input id="file" name="file" type="file" required="required" accept=".xls,.xlsx,.csv,.odt">
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

    $(".select2").select2({
		theme: "bootstrap",
		dropdownAutoWidth: false,
		allowClear: false,
        debug: true
	});
</script>

@endsection



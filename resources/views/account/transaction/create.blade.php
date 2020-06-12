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
                        <a href="<?= url('/') ?>">
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
            <div class="row">


                <div class="col-sm-12">




                    <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                    <strong>Create Single Invoice</strong> 
                                </a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item complete">
                                <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false">Create Invoice From Excel</a>
                                <div class="slide"></div>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                <div class="card-block">

                                    <header class="panel-heading">
                                        Create Reference number For Single User

                                    </header>
                                    <div class="panel-body">
                                        <div id="error_area"></div>
                                        <div class=" form">
                                            <form class="form-horizontal" role="form" method="post">
                                                <div class='form-group' >
                                                    <label for="payment method" class="col-sm-2 control-label">
                                                        Revenue From<span class="red">*</span>
                                                    </label>
                                                    <div class="col-sm-6">
                                                        <select name="user_in_shulesoft" id="user_in_shulesoft" class="form-control">
                                                            <option value=""></option>
                                                            <option value="1">User in ShuleSoft</option>
                                                            <option value="2">User Not in ShuleSoft</option>
                                                        </select>
                                                    </div>
                                                    <span class="col-sm-4 control-label">
                                                        <?php echo form_error($errors, 'user_in_shulesoft'); ?>
                                                    </span>
                                                </div>
                                                <div id="user_in_shulesoft_tag" <?php request('user_in_shulesoft') == 1 ? '' : 'style="display: none;"' ?>>        
                                                    <div class='form-group' >
                                                        <label for="payment method" class="col-sm-2 control-label">
                                                            Payer Name <span class="red">*</span>
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <?php
                                                            $uarray = array('0' => __("select expense"));
                                                            $users = \App\Models\User::all();
                                                            if (count($users)) {
                                                                foreach ($users as $user) {
                                                                    $uarray[$user->id] = $user->firstname.' '.$user->lastname;
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
                                                <div id="user_not_in_shulesoft_tag"  <?php request('user_in_shulesoft') == 2 ? '' : 'style="display: none;"' ?>>
                                                    <div class='form-group' >
                                                        <label for="name" class="col-sm-2 control-label">
                                                            <?= __("Payer Name") ?><span class="red">*</span>
                                                        </label>
                                                        <div class="col-sm-6">

                                                            <input type="text" class="form-control" id="amount" name="payer_name" value="<?= old('payer_name') ?>"  placeholder="  e.g Juma Ali" onblur="this.value = this.value.toUpperCase()">
                                                        </div>
                                                        <span class="col-sm-4 control-label">
                                                            <?php echo form_error($errors, 'payer_name'); ?>
                                                        </span>
                                                    </div>
                                                    <div class='form-group' >
                                                        <label for="phone" class="col-sm-2 control-label">
                                                            <?= __("Payer Phone") ?><span class="red">*</span>
                                                        </label>
                                                        <div class="col-sm-6">

                                                            <input class="form-control phoneNumber" id="payer_phone" name="payer_phone"  value="<?= old('payer_phone') ?>" type="tel"  placeholder="e.g 655406004">
                                                           
                                                        </div>
                                                        <span class="col-sm-4 control-label">
                                                            <?php echo form_error($errors, 'payer_phone'); ?>
                                                        </span>
                                                    </div>
                                                    <div class='form-group' >
                                                        <label for="amount" class="col-sm-2 control-label">
                                                            <?= __("Payer Email") ?>
                                                        </label>
                                                        <div class="col-sm-6">

                                                            <input type="text" class="form-control" id="payer_email" name="payer_email" value="<?= old('payer_email') ?>"  onblur="this.value = this.value.toLowerCase()" placeholder="option">
                                                        </div>
                                                        <span class="col-sm-4 control-label">
                                                            <?php echo form_error($errors, 'payer_email'); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class='form-group' >
                                                    <label for="expense" class="col-sm-2 control-label">
                                                        <?= __("Fee Type") ?><span class="red">*</span>
                                                    </label>
                                                    <div class="col-sm-6">
                                                        <?php
                                                        $array = array('0' => __("select expense"));
                                                        if (!empty($category)) {
                                                            foreach ($category as $categ) {
                                                                $array[$categ->id] = $categ->name;
                                                            }
                                                        }
                                                        echo form_dropdown("refer_expense_id", $array, old("refer_expense_id"), "id='refer_expense_id' class='form-control'");
                                                        ?>
                                                        <?php if (count($category) > 0) { ?>

                                                        <?php } ?>
                                                    </div>
                                                    <span class="col-sm-2 small"><a href="<?= url("expense/financial_category") ?>">Create New</a></span>
                                                    <span class="col-sm-4 control-label">
                                                        <?php echo form_error($errors, 'refer_expense_id'); ?>
                                                    </span>
                                                </div>

                                                <div class='form-group' >
                                                    <label for="amount" class="col-sm-2 control-label">
                                                        <?= __("Amount") ?><span class="red">*</span>
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


                                                    <div class='form-group' >
                                                        <label for="amount" class="col-sm-2 control-label">
                                                            <?= __("Ref No") ?>
                                                        </label>
                                                        <div class="col-sm-6">

                                                            <input type="text" placeholder="Enter ref number/cheque number" class="form-control" id="ref_no" name="transaction_id" value="<?= old('transaction_id', time()) ?>">
                                                        </div>
                                                        <span class="col-sm-4 control-label">
                                                            <!--<span id="ref_no_status"></span>-->
                                                            <?php echo form_error($errors, 'transaction_id'); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class='form-group' >
                                                    <label for="date" class="col-sm-2 control-label">
                                                        <?= __("Date") ?> <span class="red">*</span>
                                                    </label>
                                                    <div class="col-sm-6">
                                                        <input type="date" class="form-control calendar" id="date" name="date" value="<?= old('date') ?>" required="true" >

                                                    </div>
                                                    <span class="col-sm-4 control-label">
                                                        <?php echo form_error($errors, 'date'); ?>
                                                    </span>
                                                </div>

                                                <div class='form-group' >
                                                    <label for="note" class="col-sm-2 control-label">
                                                        <?= __("note") ?>
                                                    </label>
                                                    <div class="col-sm-6">
                                                        <textarea style="resize:none;" class="form-control" id="note" name="note"><?= old('note') ?></textarea>
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

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                                <div class="card-block">

                                    <div class="table-responsive dt-responsive">
                                        <div class="card-header">
                                            <div class="panel-body">
                                                <div class="alert alert-info">Use the exactly ShuleSoft template as provided </div>
                                                <!--<p>Sample Excel Format. </p>-->
                                                <!--<img src="<?= url('public/images/sample_excel.jpg') ?>"/>-->
                                                <br/>
                                                <div class=" form">
<!--                                                    <br/>
                                                    <p><?= __("file") ?> 
                                                        <a href="<?= url('storage/uploads/sample/sample_students_upload.xlsx') ?>"><i class="fa fa-2x fa-cloud-download"></i></a></p>-->
                                                    <form id="demo-form2" action="<?= url('account/uploadRevenue') ?>" class="form-horizontal" method="POST"
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
    $('#ref_no').blur(function () {
        var trans = $(this).val();
        if (trans === '0' || trans == '') {
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('revenue/check_transaction_id') ?>",
                data: {trans_id: trans},
                dataType: "html",
                beforeSend: function (xhr) {
                    $('#ref_no_status').html('<a href="#/refresh"><i class="fa fa-spinner"></i> </a>');
                },
                complete: function (xhr, status) {
                    $('#ref_no_status').html('<span class="label label-success">' + status + '</span>');
                },
                success: function (data) {
                    $('#ref_no_status').html(data);
                }
            });
        }
    });

    $(document).ready(payment_method_status)
</script>
@endsection



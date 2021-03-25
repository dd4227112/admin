@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>

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
                    <!-- Zero config.table start -->
                    <div class="card">
                 
        <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                    <strong>Single Invoice Payment</strong> 
                                </a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item complete">
                                <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false">Upload  Invoice Payments From Excel</a>
                                <div class="slide"></div>
                            </li>
                        </ul>
                        <div class="tab-content">
                             <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                 <br/>
                                 <br/>
                        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                            <div class='form-group row'>
                                <label for="amount" class="col-sm-2 control-label">
                                    Due Amount
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" disabled class="form-control" id="amount_topay" name="amount_topay" value="<?= old('amount', number_format($invoice->invoiceFees()->sum('amount')-$invoice->payments()->sum('amount'))) ?>" required="true" >
                                </div>
                                <span class="col-sm-4 control-label">
                                    <?php echo form_error($errors, 'amount_topay'); ?>
                                </span>
                            </div>
                            <div class='form-group row' >
                                <label for="amount" class="col-sm-2 control-label">
                                   Paid Amount
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Enter Received amount here" class="form-control" id="amount" name="amount" value="" required="true">
                                </div>
                                <span class="col-sm-4 control-label">

                                    <?php echo form_error($errors, 'amount'); ?>
                                </span>
                            </div>

<!--     This part is added to assist in reporting, it needs to be removed in the future to enable proper arrangement of data and avoid duplicates-->
                            <div class='form-group row' >
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
                                        <?php if (!empty($category)) { ?>

                                        <?php } ?>
                                    </div>
                                    <!--<span class="col-sm-2 small"><a href="<?= url("expense/financial_category") ?>">Create New</a></span>-->
                                    <span class="col-sm-4 control-label">
                                        <?php echo form_error($errors, 'refer_expense_id'); ?>
                                    </span>
                                </div>

                               <div class='form-group row' >
                                  <label for="payment_method" class="col-sm-2 control-label">
                                   Payment Method
                                  </label>
                                <div class="col-sm-6">
                                    <select class="form-control" required="true" name="payment_type" id="payment_type">
                                        <option value=" ">Select Payment type</option>
                                        <?php
                                        if (!empty($payment_types)) {
                                            foreach ($payment_types as $payment_type) {
                                              ?>
                                                <option value="<?= $payment_type->id ?>"><?= $payment_type->name ?></option>
                                             <?php
                                            }
                                        }
                                    ?></select>
                            </div>
                            <span class="col-sm-4 control-label">
                                 <?php echo form_error($errors, 'payment_method'); ?>
                            </span>
                         </div>


                            <div id="cheque_number_div" style="display: none;">
                               <div class='form-group row' >
                                <label for="amount" class="col-sm-2 control-label">
                                   Cheque Number
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Available in a cheque" id="cheque_number" name="cheque_number" value="<?= old('cheque_number') ?>" >
                                </div>
                                <span class="col-sm-4 control-label">
                                    <?php echo form_error($errors, 'cheque_number'); ?>
                             </span>
                        </div>
                     </div>

                    <div id="date">
                       <div class='form-group row' >
                        <label for="amount" class="col-sm-2 control-label">
                            Date
                        </label>
                        <div class="col-sm-6">
                            <input class="form-control calendar" required type="date" placeholder="Date that payment was done" name="date" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors, 'date'); ?>
                        </span>
                    </div>
                </div>

                <div id="bank_deposit_div" >
                    <div id="bank"  style="display: none;">
                      <div class='form-group row' >
                        <label for="bank" class="col-sm-2 control-label"> Bank Name</label>
                        <div class="col-sm-6">
                            <select class="form-control" required="true" name="bank_account_id" id="bank_name">
                                <option value=" ">Select Bank</option>
                                <?php
                                if (!empty($banks)) {
                                    foreach ($banks as $bank) {
                                     ?>
                                        <option value="<?= $bank->id ?>"><?= $bank->name . ' (' . $bank->number . ')' ?></option>
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

                <div id="bank_transaction_id"  style="display: none;">
                  <div class='form-group row' >
                    <label for="amount" class="col-sm-2 control-label">
                       Transaction ID
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="transaction_id"  placeholder="From Bank/Mobile Paying Slip or message" name="transaction_id" value="<?= old('transaction_id',time()) ?>" >
                    </div>
                    <span class="col-sm-4 control-label">
                        <?php echo form_error($errors, 'transaction_id'); ?>
                    </span>
                </div>
            </div>

            <div id="bankslip" style="display: none;">
               <div class='form-group row' >
                <label for="amount" class="col-sm-2 control-label">
                   Bank Slip Title
                </label>
                <div class="col-sm-6">
                    <input class="form-control" type="file" accept=".png,.jpg,.jpeg,.gif,.pdf" class="upload" name="image" >

                </div>
                <span class="col-sm-4 control-label">
                    <span class="info">Accepted files: .png,.jpg,.jpeg,.gif,.pdf </span>
                    <?php echo form_error($errors, 'bankslip'); ?>
                </span>
            </div>
        </div>

    </div>
    <div class="form-group row">
        <div class="col-sm-6"></div>
        <div class="col-sm-4">
            <input type="hidden" value="" name="number" id="number">
            <?php
            $enabled = ' ';
            ?>
            <input  <?= $enabled ?> type="submit" class="btn btn-success" value="<?= __("add_payment") ?>" >
                  </div>
              </div>
                       <?= csrf_field() ?>
                     </form>


                             </div>
                            <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                                <div class="card-block">

                                    <div class="table-responsive dt-responsive">
                                        <div class="card-header">
                                            <div class="panel-body">
                                                <div class="alert alert-info">If customer already exists in the system, just write customer email address, and if that customer has got an invoice arlready, then write invoice number correctly </div>
                                                <p>Sample Excel Format. </p>
                                                <img src="<?= url('storage/uploads/images/payments.JPG') ?>" width="80%"/>
                                                <br/>
                                                <div class=" form">
                                                    <br/>
                                                    <form class="cmxform form-horizontal " id="commentForm2" method="post" action="<?= url('account/uploadPayments') ?>" enctype="multipart/form-data">
                                                    

                                                        <div class="form-group ">
                                                            <label for="cname" class="control-label col-lg-3">Choose Excel File (required)</label>
                                                            <div class="col-lg-6">
                                                                <input class=" form-control" id="fname" name="file" type="file" required="">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <div class="col-lg-offset-3 col-lg-6">
                                                                <?= csrf_field() ?>
                                                                <button class="btn btn-primary" type="submit">Upload Payments</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                       </div>
<!-- start: PAGE HEADER -->
</div>
</div>

</div>

</div>
</div>
</div>

<script type="text/javascript">
    $('#classesID').change(function (event) {
        var classesID = $(this).val();
        if (classesID === '0') {
            $('#student_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('invoices/call_all_student') ?>",
                data: "id=" + classesID,
                dataType: "html",
                success: function (data) {
                    $('#student_id').html(data);
                }
            });
        }
    });

    $('#payment_type').change(function () {
        //var name = $(this).text();
        var name = $("#payment_type option:selected").val();
        //cash =1, mobile=2, bank=3, cheque=4
        if (name == 4) {
            /*swal({
             title: "Cheque",
             text: 'Enter cheque number:',
             type: 'input',
             showCancelButton: true,
             closeOnConfirm: false,
             animation: "slide-from-top"
             },
             function (inputValue) {
             if (inputValue === false)
             return false;
             
             if (inputValue === "") {
             swal.showInputError("You need to write cheque number!");
             return false;
             }
             $('#number').val(inputValue);
             swal("Nice!", 'You wrote: ' + inputValue, "success");
             
             }); */

            $('#cheque_number_div').toggle();
            $('#bank').toggle();
            $('#bank_transaction_id').hide();
            $('#bankslip').hide();

        } else if (name == '3') {
            $('#cheque_number_div').hide();
            $('#bank').toggle();
            $('#bank_transaction_id').show();
            $('#bankslip').toggle();
        } else if (name == '2') {
            $('#cheque_number_div').hide();
            $('#bank_transaction_id').show();
            $('#bank').toggle();
            $('#bankslip').hide();
        } else if (name == '1') {
            $('#cheque_number_div').hide();
            $('#bank').hide();
            $('#bankslip').hide();
        }
    });
    $('#feetype').keyup(function () {
        var feetype = $(this).val();
        $.ajax({
            type: 'POST',
            url: "<?= url('invoices/feetypecall') ?>",
            data: "feetype=" + feetype,
            dataType: "html",
            success: function (data) {
                if (data != "") {
                    var width = $("#feetype").width();
                    $(".book").css('width', width + 25 + "px").show();
                    $(".result").html(data);

                    $('.result li').click(function () {
                        var result_value = $(this).text();
                        $('#feetype').val(result_value);
                        $('.result').html(' ');
                        $('.book').hide();
                    });
                } else {
                    $(".book").hide();
                }

            }
        });
    });


    $('#invoice_id').change(function (event) {
        var invoice_id = $(this).val();
        if (invoice_id === '0') {
            $('#invoice_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('invoices/payment_student_list') ?>",
                data: {"invoice_id": invoice_id, academic_year_id: academic_year_id},
                dataType: "html",
                success: function (data) {
                    window.location.href = data;
                }
            });
        }
    });

</script>
@endsection
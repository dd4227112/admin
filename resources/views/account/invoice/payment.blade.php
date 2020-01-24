<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-invoice"></i> <?= $data->lang->line('panel_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li><a href="<?= base_url("invoices/index") ?>"><?= $data->lang->line('menu_invoice') ?></a></li>
            <li class="active"><?= $data->lang->line('add_payment') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <a href="<?= base_url('invoices/index/' . $invoice->student->classes->classesID . '/' . $academic_year_id) ?>" class="btn btn-info btn-xs"><i class="fa fa-backward"></i>Go to Class Invoices</a>
                <?php
                $usertype = session("usertype");
                if (can_access("edit_invoice")) {

                    /**
                     * ----------------------------------------------------------------
                     * In case a student bring cash, accountant or admin can manually
                     * add that amount to a student account. This is not much a good
                     * process just beacause it is associated with much security issues
                     * -----------------------------------------------------------------
                     *
                     */
                    ?>



                    <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">


                        <?php
                        if (form_error($errors, 'student'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                        ?>
                        <label for="payment_method" class="col-sm-2 control-label">
                            <?= $data->lang->line("invoice_student") ?>
                        </label>
                        <div class="col-sm-6">
                         
 <?= isset($invoice_info->student_name) ? $invoice_info->student_name : '' ?>
                            <input type="text" class="form-control" id="invoice_id" name="invoice_id" value="<?= old('invoice_id') ?>"  value="<?= isset($invoice_info->student_name) ? $invoice_info->student_name : '' ?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error($errors, 'student'); ?>
                        </span>
                </div>
            
            
              
            
            


                <?php
              
                if (form_error($errors, 'fee'))
                    echo "<div class='form-group has-error' >";
                else
                    echo "<div class='form-group' >";
                ?>
                <label for="payment_method" class="col-sm-2 control-label">
                    <?= $data->lang->line("fee_name") ?>
                </label>
                <div class="col-sm-6">


                    <select class="select2_single form-control" tabindex="-1" required="true"  name="fee" id="fee_id">        <option value="0">Follow Fee Priority</option>


                        <?php
                       
                        $fees = $invoice->invoicesFeesInstallments()->get();

                        $fee_list = [];
                        foreach ($fees as $fee) {

                            $fee_name = $fee->feesInstallment()->first();
if(isset($fee_name->fee->id)){
array_push($fee_list, array('id' => $fee_name->fee->id, 'name' => $fee_name->fee->name));

}
                        }
                        
                        $input = array_map("unserialize", array_unique(array_map("serialize", $fee_list)));
                        foreach ($input as $value) {
                            echo "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <span class="col-sm-4 control-label">
                    <?php 
                 
                    echo form_error($errors, 'fee'); ?>
                </span>
            </div>


            <?php
          
            $total_amount_due=0;
            if(count($amount_due)>0){
              $total_amount_due=$amount_due->total_due_amount ;
            }
            
           if(count($invoice_info)>0) { 
           $bal=$invoice_info->amount-$invoice_info->paid_amount + $total_amount_due;
           }else{
           $bal=$total_amount_due;    
           }
            if ($bal == 0) {
                $bal = 'This student has  fully paid';
            }
            
            if (form_error($errors, 'amount_topay'))
                echo "<div class='form-group has-error' >";
            else
                echo "<div class='form-group' >";
            ?>
            <label for="amount" class="col-sm-2 control-label">
                <?= $data->lang->line("due_amount") ?>
            </label>
            <div class="col-sm-6">
                <input type="text" disabled class="form-control" id="amount_topay" name="amount_topay" value="<?= old('amount', $bal) ?>" required="true" >
            </div>
            <span class="col-sm-4 control-label">
                <?php echo form_error($errors, 'amount_topay'); ?>
            </span>
        </div>
        <?php
        if (form_error($errors, 'amount'))
            echo "<div class='form-group has-error' >";
        else
            echo "<div class='form-group' >";
        ?>
        <label for="amount" class="col-sm-2 control-label">
            <?= $data->lang->line("pay_amount") ?>
        </label>
        <div class="col-sm-6">
            <input type="text" placeholder="Enter Received amount here" class="form-control" id="amount" name="amount" value="" required="true">
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
    <label for="payment_method" class="col-sm-2 control-label">
        <?= $data->lang->line("invoice_paymentmethod") ?>
    </label>

    <div class="col-sm-6">
        <select class="form-control" required="true" name="payment_type" id="payment_type">
            <option value=" ">Select Payment type</option>
            <?php
            
            if (count($payment_types) > 0) {

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
        <?php
        if (form_error($errors, 'cheque_number'))
            echo "<div class='form-group has-error' >";
        else
            echo "<div class='form-group' >";
        ?>
        <label for="amount" class="col-sm-2 control-label">
            <?= $data->lang->line("invoice_cheque_number") ?>
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
        <?php
        if (form_error($errors, 'date'))
            echo "<div class='form-group has-error' >";
        else
            echo "<div class='form-group' >";
        ?>
        <label for="amount" class="col-sm-2 control-label">
            <?= $data->lang->line("date") ?>
        </label>
        <div class="col-sm-6">
            <input class="form-control calendar" required type="text" placeholder="Date that payment was done" name="date" >
        </div>
        <span class="col-sm-4 control-label">
            <?php echo form_error($errors, 'date'); ?>
        </span>
    </div>
    </div>

    <div id="bank_deposit_div" >
        <div id="bank"  style="display: none;">
            <?php
            if (form_error($errors, 'bank_name'))
                echo "<div class='form-group has-error' >";
            else
                echo "<div class='form-group' >";
            ?>
            <label for="bank" class="col-sm-2 control-label"> <?= $data->lang->line("bank_name") ?></label>
            <div class="col-sm-6">
                <select class="form-control" required="true" name="bank_name" id="bank_name">
                    <option value=" ">Select Bank</option>
                    <?php
                    if (count($banks) > 0) {

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
        </div></div>


    <div id="bank_transaction_id"  style="display: none;">
        <?php
        if (form_error($errors, 'transaction_id'))
            echo "<div class='form-group has-error' >";
        else
            echo "<div class='form-group' >";
        ?>
        <label for="amount" class="col-sm-2 control-label">
            <?= $data->lang->line("transaction_id") ?>
        </label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="transaction_id"  placeholder="From Bank/Mobile Paying Slip or message" name="transaction_id" value="<?= old('transaction_id') ?>" >
        </div>
        <span class="col-sm-4 control-label">
            <?php echo form_error($errors, 'transaction_id'); ?>
        </span>
    </div>
    </div>

    <div id="bankslip" style="display: none;">
        <?php
        if (form_error($errors, 'bankslip'))
            echo "<div class='form-group has-error' >";
        else
            echo "<div class='form-group' >";
        ?>
        <label for="amount" class="col-sm-2 control-label">
            <?= $data->lang->line("bankslip_title") ?>
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
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-8">
            <input type="hidden" value="" name="number" id="number">
            <?php
            $enabled = ' ';
            if ($bal == 0) {
                $bal = 'This installment is Fully Paid';
                // $enabled = 'disabled';
            }
            ?>
            <input  <?= $enabled ?> type="submit" class="btn btn-success" value="<?= $data->lang->line("add_payment") ?>" >
        </div>
    </div>


    <?= csrf_field() ?>
    </form>
    <?php
} elseif ($usertype == "Student" || $usertype == "Parent") {
    /**
     * -------------------------------------------------------------
     * This is the recommended procedure of our system. To allow
     * electronic payment to be done and amount to be deposited
     * to school bank account
     * -------------------------------------------------------------
     */
    ?>
    <!-- start: PAGE HEADER -->
    </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <!-- start: STYLE SELECTOR BOX -->

            <div class="page-header">
                <h1 class="v2"><span class="trl" key="l7">Payment </span>
                    <small class="trl" key="z2">Choose Payment method you Prefer</small></h1>
            </div>
            <!-- end: PAGE TITLE & BREADCRUMB -->
        </div>
    </div>
    <!-- end: PAGE HEADER -->
    <!-- start: PAGE CONTENT -->
    <div class="col-lg-12">
        <div class="col-lg-12" >
            <div class="col-sm-4"> <!--to be changed into col-sm-4 when we add other payment systems-->
                <div class="core-box">
                    <div class="heading">
                        <?= img(base_url('storage/uploads/images/crdb.png')) ?>
                        <h2>CRDB BANK </h2>
                    </div>
                    <div>
                        <p class="op" key="op1">You can use either CRDB SIM BANKING, DIRECT BANK DEPOSIT or FAHARI HUDUMA Payment Method.</p>
                    </div>
                    <a class="notranslate view-more btn btn-success btn-xs" href="<?= base_url("invoices/method/crdb?iid=" . $invoice_id) ?>" >
                        <span class="trl" key="fw1" >Continue</span> <i class="clip-arrow-right-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-4">
                <!--    	    <div class="core-box">
                                <div class="heading">
                <?= img(base_url('storage/uploads/images/nmb.png')) ?>
                                    <h2>NMB BANK </h2>
                                </div>
                                <div>
                                    <p class="op" key="op2">You can use either NMB MOBILE BANKING, DIRECT BANK BRANCH DEPOSIT or NMB WAKALA Payment Method.</p>
                                </div>
                                <a class="notranslate view-more btn btn-success btn-xs" href="<?= base_url("invoices/method/nmb?iid=" . $invoice_id) ?>">
                                    <span class="trl" key="fw1"> Continue</span> <i class="clip-arrow-right-2"></i>
                                </a>
                            </div>-->
                <div class="core-box">
                    <div class="heading">
                        <?= img(base_url('storage/uploads/images/online.png')) ?>
                        <h2>BANK CARDS</h2>
                    </div>
                    <div class="">
                        •Visa
                        •	MasterCard
                        •	Discover
                        •	American Express
                        •	Diners
                        •	JCB
                        •	PIN debit cards with the Visa or MasterCard logo
                        •	Debit cards with the Visa or MasterCard logo
                        •	PayPal
                    </div>
                    <a class="view-more btn btn-success btn-xs" href="<?= base_url("invoices/method/card?iid=" . $invoice_id) ?>">
                        Continue <i class="clip-arrow-right-2"></i>
                    </a>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="core-box">
                    <div class="heading">
                        <?= img(base_url('storage/uploads/images/mobile.png')) ?>
                        <h2>MOBILE Money</h2>
                    </div>
                    <div class="">
                        If you are using mobile payment solution, you can make payment via M-PESA or Tigo-Pesa Payment system.
                    </div>
                    <a class="view-more btn btn-success btn-xs" href="<?= base_url("invoices/method/mobile?iid=" . $invoice_id) ?>">
                        Continue <i class="clip-arrow-right-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <br/>
            <!--    	<div class="core-box">
                        <div class="heading">
            <?= img(base_url('storage/uploads/images/online.png')) ?>
                            <h2>BANK CARDS</h2>
                        </div>
                        <div class="">
                            •Visa
                            •	MasterCard
                            •	Discover
                            •	American Express
                            •	Diners
                            •	JCB
                            •	PIN debit cards with the Visa or MasterCard logo
                            •	Debit cards with the Visa or MasterCard logo
                            •	PayPal
                        </div>
                        <a class="view-more btn btn-success btn-xs" href="<?= base_url("invoices/method/card?iid=" . $invoice_id) ?>">
                            Continue <i class="clip-arrow-right-2"></i>
                        </a>
                    </div>-->
        </div>

    </div>
<?php }






 else {
    
    
     echo 'Ask Admin to give you access to edit einvoice first';
     
    
}?>
</div>

<div class="col-md-4 col-sm-4 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>    <?= $data->lang->line("guidance") ?></h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <p>  <?= $data->lang->line("guidance_details") ?></p>
        </div>
    </div><?php
    if (count($payment) > 0) {
        echo btn_add_pdf('invoices/receipt/' . $invoice->id . '/' . $academic_year_id, 'Receipt');
    }
    ?>
</div>
</div>
</div>
</div>

<script type="text/javascript">
    var academic_year_id =<?= $academic_year_id ?>;
    $('#classesID').change(function (event) {
        var classesID = $(this).val();
        if (classesID === '0') {
            $('#student_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('invoices/call_all_student') ?>",
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
            url: "<?= base_url('invoices/feetypecall') ?>",
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
                url: "<?= base_url('invoices/payment_student_list') ?>",
                data: {"invoice_id": invoice_id, academic_year_id: academic_year_id},
                dataType: "html",
                success: function (data) {
                    window.location.href = data;
                }
            });
        }
    });

</script>
<?php
/**
 * @author Ephraim Swilla <ephraim@inetstz.com>
 */
$school = $siteinfos;
$usertype = session('usertype');
?>

    <!-- CUSTOM STYLE  -->

<link rel="stylesheet" href="<?= url('public/') ?>/assets/custom-style-receipt.css">
    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' media="all" rel='stylesheet' type='text/css' />

<div class="container" style="padding-left: 1em">

    <div class="row pad-top-botm">
        <div class="col-lg-6 col-md-6 col-sm-6 ">
            <img src="<?= base_url('storage/uploads/images/' . $school->photo) ?>" class="img-responsive img-circle" style="width: 100px; height: 100px" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">

            <strong> <?php if (empty($payment->invoice->invoice_title)) { ?> {{$school->sname}} <?php } else { ?> {{$payment->invoice->invoice_title}} <?php } ?></strong>
            <br />
            <i>Address :</i> {{$school->box}},{{$school->address}},
            <br />
            <i>Phone :</i> {{$school->phone}} | <i>Email :</i>   {{$school->email }}
            <br/>
            <i>Website :</i> {{strtolower($school->website)}}



        </div>

    </div>

    <div  class="row text-center contact-info">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <hr />
        </div>
    </div>
    <?php if(!empty($payment)){?>
    <div  class="row pad-top-botm client-info">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h4>  <strong>Received From</strong></h4>
            <strong>  {{$payment->student->name}}</strong>
            <br />
            <b>Class :</b> {{$payment->student->classes->classes}}
            <br />
            <b></b>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">

            <h4>  <strong>Payment Details </strong></h4>
            <b>Sum of shillings: {{number_to_words($payment->paymentamount)}}  Shillings Only </b>
            <br />
            Payment Date :  {{date('d M Y ', strtotime($payment->paymentdate))}}
            <br/>
            Invoice #: <strong>{{$payment->invoice->reference}}</strong> | Receipt #: <strong>{{$payment->receipt->receiptID }}</strong>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>

                    <tr>
                        <th>S. No.</th>
                        <th>Fee</th>
                    </tr>
                    </thead>
                    <tbody>


                        <?php

                        $fees = isset($receipt_fee[$payment->paymentID]) ? $receipt_fee[$payment->paymentID] :array();
                        $i = 0;
                        $fee_name = '';
                        foreach ($fees as $fee_info) {



                         ?>

                    <tr>


                        <td>{{$i+1}}</td>
                        <td>{{$fee_info['name']}}</td>
                    </tr>
<?php
$i = $i + 1;
}
?>

                    </tbody>
                </table>
            </div>
            <hr />
            <div class="ttl-amts">
                <h5 class="pull-left"><div class="ttl-amts">
                        By cash/cheque No:
                        <span style="padding-left:80px; font-weight:bold;padding-right: 50px; text-transform:uppercase">
                            @if($payment->transactionID !='')
                        <?= $payment->paymenttype . ' - ' . $payment->transactionID . '  ' . '-' . $payment->bank_name;?>
                            @else
                                <?= $payment->paymenttype?>
                            @endif
                        </span>
                    </div></h5>
                <h5>  <strong>Total Amount :  {{toCurrency($payment->paymentamount)}} </strong></h5>
            </div>

            <hr />

        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <strong class="pull-left"> NON REFUNDABLE</strong>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <?php
            $path = "storage/uploads/images/stamp_" . set_schema_name() . "png";
            ?>
            @if(set_schema_name()=='makongo.')
                <img src="<?= base_url($path) ?>"
                     width="100" height="100"
                     style="position:relative; margin:-6% 15% 0 0; float:right;">
            @endif
            <strong class="pull-left"> With thanks:______________________</strong>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <strong> </strong>
            <ol style="padding-left: 2em">


            </ol>
        </div>


    </div>
    <div class="row pad-top-botm">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <hr />
            <a href="javascript:void(0)" class="btn btn-primary btn-sm" onmousedown="printPage()" >Print Invoice</a>
            &nbsp;&nbsp;&nbsp

        </div>
    </div>
</div>

<?php   }else{


    echo'There is an issue in this receipt';
} ?>

<form class="form-horizontal" role="form" action="<?= base_url('student/send_mail'); ?>" method="post">
    <div class="modal fade" id="mail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><?= $data->lang->line('mail') ?></h4>
                </div>
                <div class="modal-body">

                    <?php
                    if (form_error($errors, 'to'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                    <label for="to" class="col-sm-2 control-label">
                        <?= $data->lang->line("to") ?>
                    </label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" id="to" name="to" value="<?= old('to') ?>" >
                    </div>
                    <span class="col-sm-4 control-label" id="to_error">
                    </span>
                </div>

                <?php
                if (form_error($errors, 'subject'))
                    echo "<div class='form-group has-error' >";
                else
                    echo "<div class='form-group' >";
                ?>
                <label for="subject" class="col-sm-2 control-label">
                    <?= $data->lang->line("subject") ?>
                </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="subject" name="subject" value="<?= old('subject') ?>" >
                </div>
                <span class="col-sm-4 control-label" id="subject_error">
                </span>

            </div>

            <?php
            if (form_error($errors, 'message'))
                echo "<div class='form-group has-error' >";
            else
                echo "<div class='form-group' >";
            ?>
            <label for="message" class="col-sm-2 control-label">
                <?= $data->lang->line("message") ?>
            </label>
            <div class="col-sm-6">
                <textarea class="form-control" id="message" style="resize: vertical;" name="message" value="<?= old('message') ?>" ></textarea>
            </div>
        </div>


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?= $data->lang->line('close') ?></button>
        <input type="button" id="send_pdf" class="btn btn-success" value="<?= $data->lang->line("send") ?>" />
    </div>
    </div>
    </div>
    </div>
</form>

<script language="JavaScript">
    function printPage() {
        if (document.all) {
            document.all.well.style.visibility = 'hidden';

            document.all.topnav.style.visibility = 'hidden';
            $('.mail_list_column').hide();
            window.print();
            document.all.well.style.visibility = 'visible';
            document.all.topnav.style.visibility = 'visible';
            $('.mail_list_column').show();
        } else {
//            $('.mail_list_column').hide();
          $('#menu_toggle').hide();
//            $('.invoice').style.border = 'none';
            //document.getElementById('payment_receipt_title').style.display = 'none';
            //document.getElementById('topnav').style.display = 'none';
            document.getElementById('payment_lists').style.display = 'none';
            window.print();
            $('.mail_list_column').show();
            $('.well').show();
            $('#topnav,#payment_receipt_title').show();
        }
    }
</script>

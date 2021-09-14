
<?php
$bn_number = 888999;
?>
<section   class="content invoice" style="page-break-inside: avoid;">
    <div class="nav_menu no-print">

        <div class="x_content" id="print_div">

            <!-- title row -->
            <div class="col-sm-12">
                <div class="row">
                    <div class="table-responsive dt-responsive">
                        <table id="dt-ajax-array" class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="{{url('public/assets/images/inets.png')}}" height="100" alt="INETS Company Limtied, ShuleSoft School Management System">
                                    </td>
                                    <td>
                                        <ul>
                                            <li style="font-size: 1em;"><strong>INETS COMPANY LIMITED</strong></li>
                                            <li>TIN 122-866-750</li>
                                            <li>P.o Box 32258 Dar es Salaam  </li>
                                            <li> 2nd Floor,Block NO. 576</li>
                                            <li>Mbezi Beach Bagamoyo Road</li>
                                            <li>Mobile no: +255 655 406 004 </li>
                                            <li>Telephone: +255 22 278 0228</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <h1 class="pull-right invoice-title" style="font-size: rem; float: right; margin-left: 60%"></h1>
                                    </td>
                                </tr>
                            <tbody>
                        </table>
                    </div>
                    <!-- /.col -->

                    <?php
                    $i = 0;
                    if ((int) request()->segment(4) > 0) {
                        $revenue = $invoice->payments()->where('id', request()->segment(4))->first();
                    } else {
                        $revenue = $invoice->payments()->first();
                    }
                    ?>
                    <?php if (isset($revenue) && !empty($revenue)) { ?>

                        <div class="table-responsive dt-responsive">
                            <table id="dt-ajax-array" class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp;<strong>RECEIPT NO:</strong><b> <?= $revenue->id ?></b>
                                        </td>
                                        <td>
                                            <strong>Date:</strong><b><?= date('d M Y ', strtotime($revenue->date)) ?> </b>
                                        </td>
                                    </tr>
                                <tbody>
                            </table>
                        </div>

                        <br/><br/>
                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <div class="ttl-amts">
                                Received from
                                <span style="padding-left:100px;padding-right: 30px; font-weight:bold; text-transform:uppercase">
                                    <?= isset($revenue->client->name) ?$revenue->client->name:''  ?></span><hr/>
                            </div>

                            <div class="ttl-amts">
                                Amount in words

                                <span style="padding-left:85px;padding-right: 50px; font-weight:bold; text-transform:uppercase">
                                    <?php
                                    $amount = money($revenue->amount);
                                    $am = (double) str_replace(',', NULL, $amount);
                                    echo number_to_words($am);
                                    ?>   ONLY</span><hr/>
                            </div>
                            <div class="ttl-amts">
                                Being Payment for
                                <span style="padding-left:76px;padding-right: 50px; font-weight:bold; text-transform:uppercase">
                                    <?php
                                    echo !empty($revenue->invoiceFees()->first()) ? $revenue->invoiceFees()->first()->item_name : 'Service Fee';
                                    ?>
                                </span> <hr />
                            </div>

                            <div class="ttl-amts">
                                By cash/cheque No
                                <span style="padding-left:65px; font-weight:bold;padding-right: 50px; text-transform:uppercase">
                                    <?= $revenue->transaction_id . '-' . $revenue->method; ?> </span> <hr/>
                            </div>
                            <div class="ttl-amts">

                                <div style="padding-left:15%;">
                                    <div style="z-index: 5000">
                                        <img src="<?= url('public/images/company_seal.png') ?>"
                                             width="200" height="150"
                                             style="position:relative; margin-left: 3px; float:right;">
                                    </div>
                                </div>
                            </div>

                            <div class="ttl-amts">
                                Tshs: <b><?= money($revenue->amount) ?>/- </i></b>
                                <span style="padding-left:75px; font-weight:bold;padding-right: 50px; text-transform:uppercase">
                                    NON.REFUNDABLE </span> <hr/>
                            </div>

                            <div class="ttl-amts">
                                <br>
                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px; text-align: center">
                                    Thank you for your business. we're glad to serve you.
                                </p>
                            </div>
                        </div>

                        <?php
                    } else {
                        echo'There is an issue in this receipt';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

</section>
<button class="btn btn-default" id="printInvoice"><i class="fa fa-print"></i> Print</button>



<br><br>


<!-- /MAIL LIST -->

<script src="{{url('public/assets/shulesoft/jquery.PrintArea.js')}}" type="text/JavaScript"></script>

<script type="text/javascript">
function printDiv(divID) {
//Get the HTML of div
    var divElements = document.getElementById(divID).innerHTML;
//Get the HTML of whole page
    var oldPage = document.body.innerHTML;

//Reset the page's HTML with div's HTML only
    document.body.innerHTML =
            "<html><head><title></title></head><body><div style='margin-left: 4em; margin-right:4em; margin-top:10em'>" +
            divElements + "</div></body>";

//Print Page
    window.print();

//Restore orignal HTML
    document.body.innerHTML = oldPage;
}

$(document).ready(function () {
    $("#printInvoice").click(function () {

        printDiv("print_div");
    });
});
</script>


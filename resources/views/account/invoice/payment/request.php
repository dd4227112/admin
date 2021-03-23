<!--
comment because someone can come back also when comes from payment for change
i will fix it later to detect the request comes from which page
-->
<!--    <button data-style="expand-left" onmousedown="loadAjax('payment', 'payment_list')" class="btn btn-default">
        <span class="ladda-label"> Return Back </span>


        <i class="fa fa-arrow-circle-left"></i>
        <span class="ladda-spinner"></span>
        <span class="ladda-spinner"></span></button>-->
<!-- start: PAGE HEADER -->
<div class="row" style="background: #ffffff;">
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
<div class="row" style="background: #ffffff;">
    <div class="col-sm-12">
        <!--	<div class="col-sm-4"> to be changed into col-sm-4 when we add other payment systems
                    <div class="core-box">
                        <div class="heading">
                            <i class="crdb circle-icon circle-green"></i>
                            <h2>CRDB BANK </h2>
                        </div>
                        <div>
                            <p class="op" key="op1">You can use either CRDB SIM BANKING, DIRECT BANK DEPOSIT or FAHARI HUDUMA Payment Method.</p>
                        </div>
                        <a class="notranslate view-more" href="javascript:void(0)" onmousedown="loadAjax('payment', 'index', 'Payment', '#master', {pg: 'crdb_load_payment', invoice: '<?= $invoice_number ?>'});" >
                            <span class="trl" key="fw1" >Continue</span> <i class="clip-arrow-right-2"></i>
                        </a>
                    </div>
                </div>-->
        <div class="col-sm-6">
            <div class="core-box">
                <div class="heading">
                    <i class="nmb circle-icon circle-teal"></i>
                    <h2>NMB BANK </h2>
                </div>
                <div class="content">
                    You can use either NMB MOBILE BANKING, DIRECT BANK BRANCH DEPOSIT or NMB WAKALA Payment Method.
                </div>
                <a class="view-more" href="javascript:void(0)" onmousedown="loadAjax('payment', 'nmbbank', 'Payment', '#master', {pg: 'nmb_load_payment', invoice: '<?= $invoice_number ?>'});">
                    <span class="trl" key="fw1"> Continue</span> <i class="clip-arrow-right-2"></i>
                </a>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="core-box">
                <div class="heading">
                    <i class="circle-icon circle-teal mobile"></i>
                    <h2>MOBILE Money</h2>
                </div>
                <div class="content">
                    If you are using mobile payment solution, you can make payment via M-PESA , Tigo-Pesa and Airtel Money Payment system.
                </div>
                <a class="view-more" href="#" onmousedown="loadAjax('payment', 'mobile', 'Payment', '#master', {pg: 'mobile', invoice: '<?= $invoice_number ?>'});">
                    Continue <i class="clip-arrow-right-2"></i>
                </a>
            </div>
        </div>
<!--        <div class="col-sm-4">
            <div class="core-box">
                <div class="heading">
                    <i class="circle-icon circle-teal online"></i>
                    <h2>BANK CARDS</h2>
                </div>
                <div class="content">
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
                <a class="view-more" href="#" onmousedown="loadAjax('payment', 'checkout', 'BANK Payment', '#master', {pg: 'mobile', invoice: '<?= $invoice_number ?>'});">
                    Continue <i class="clip-arrow-right-2"></i>
                </a>
            </div>
        </div>-->
    </div>
</div>

<div class="row">

    <div class="col-sm-4"></div>


    <div class="col-sm-4"></div>
</div>
<script type="text/javascript">
    function loadAjax(pg,method,content,return_div){
        window.location.href='<?=url(str_replace('@', '/', createRoute())).'/'.$invoice_id?>/'+method;
    }
</script>
<?php ?>
<div class="box">
    <!-- /.box-header -->
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-invoice"></i> <?= $data->lang->line('panel_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li><a href="<?= base_url("invoice/index") ?>"><?= $data->lang->line('menu_invoice') ?></a></li>
            <li class="active"><?= $data->lang->line('add_payment') ?></li>
        </ol>
    </div>
    
    
    <div class="box-body">
        <div class="row">
	    <div class="heading">
		<i class="crdb circle-icon circle-green"></i>
		<h3>CRDB BANK</h3>
	    </div>
	    <section class="col-md-8">
		<header>
		    <ul class="nav nav-tabs">
			<li class="active">
			    <a href="#stats" data-toggle="tab" aria-expanded="true">SIM Banking</a>
			</li>
			<li class="">
			    <a href="#report" data-toggle="tab" aria-expanded="false" class="dsd" key="brpy">BRANCH Payment</a>
			</li>
			<li class="">
			    <a href="#manual" data-toggle="tab" aria-expanded="false">FAHARI Huduma</a>
			</li>
			<!--	    <li class="dropdown">
					<a href="#internet" data-toggle="tab" aria-expanded="false">Internet Banking</a>
				    </li>-->
		    </ul>
		</header>
		<div class="tab-content">
		    <div id="stats" class="tab-pane clearfix active">
			<h3 class="smbpymt" key="CRDB70">SIM BANKING Payment instructions</h3>
			<p></p>
			<ol>
			    <li class="sb1" key="CRDB71">Dial  <b>*150*03#</b> to access your <b>CRDB SIM BANKING</b> Menu</li>
			    <li class="sd" key="CRDB72">Enter your SIM BANKING password</li>
			    <li class="s1" key="CRDB73">Select option 4, to pay for invoice</li>
			    <li class="s1" key="CRDB74">Select option 6, for <?= $TITLE ?></li>
			    <li><span class="s3" key="CRDB75">Enter invoice  number </span>: <?= $invoice_number ?></li>
			    <li class="s" key="CRDB76">Confirm invoice number by pressing 1</li>
			    <li class="ds" key="CRDB77">Select account number which money will be debited and your payment will be done successfully</li>
			</ol>

			<p></p>


		    </div>
		    <div id="report" class="tab-pane clearfix">
			<h3 class="s4" key="CRDB1">BRANCH Payment instructions</h3>

			<p></p>
			<ol>
			    <li class="s4"  key="CRDB2">Visit any nearby CRDB BANK branch</li>
			    <li><span class="s4"  key="CRDB3">Make deposit by specify invoice number </span>: <b><?= $invoice_number ?></b> <span class="s4"  key="CRDB5">with payment amount of </span><b>Tsh <?= money($amount) ?></b></li>
			</ol>
			<div class="badge-warning" style="color: #FFF;"  key="CRDB_WARNING">
			    NB: Please make sure you specify INVOICE number to BANK agent and you make payment by using that invoice. Failure to do so, your application will be rejected by the system and you will fail to complete your registration. Please ask CRDB agent if is aware of <?= $TITLE ?> payments</div>

			<p></p>
		    </div>
		    <div id="manual" class="tab-pane">
			<h3 class="s4" key="CRDB7">FAHARI HUDUMA Payment instructions</h3>
			<p></p>
			<ol>
			    <li class="s4" key="CRDB8">Visit any nearby CRDB FAHARI HUDUMA agent</li>
			    <li><span class="s4" key="CRDB9">Deposit </span><b> Tsh <?= money($amount) ?></b> <span class="s4" key="CRDB10"> and specify invoice number </span>:<b> <?= $invoice_number ?></b></li>
			</ol>
			<div class="badge-warning" style="color: #FFF;"  key="CRDB_WARNING">
			    NB: Please make sure you specify INVOICE number to BANK agent and you make payment by using that invoice. Failure to do so, your application will be rejected by the system and you will fail to complete your registration. Please ask CRDB agent if is aware of <?= $TITLE ?> payments</div>

			<p></p>

		    </div>


		    <!--<div id="internet" class="tab-pane">
				<h3 class="s4">FAHARI HUDUMA Payment instructions</h3>
				<p></p>
				<ol>
				    <li class="s4">Visit any nearby CRDB FAHARI HUDUMA agent</li>
				    <li><span class="s4">Make deposit of </span> Tsh <?= money($amount) ?> <span class="s4">d specify invoice number </span>: <?= $invoice_number ?></li>
				</ol>
				<p class="s4">After Successful payment,  you will receive SMS from <?= $TITLE ?>. Enter that receipt number here to confirm payment.</p>
				<p></p>
				<p>
				<ul>
				    <input type="text" value="" id="confirm_payment" class="form-control input-transparent"  placeholder="Enter <?= $TITLE ?> Receipt Number" /><a href="#" data-toggle="modal" data-target="#payment_example" class="s4">See Example</a>
				    <span id="confirm_payment_status"></span>
				</ul>
				</p>
				<div class="pull-left">
				    <button class="oneterm btn btn-primary btn-squared" onclick="validate_payment('<?= $invoice_number ?>')" key="py3">Confirm Payment</button>
				</div>
			    </div>-->
		</div>
	    </section>

	    <div class="col-md-4">
		<h4 class="heading"  key="psm">Payment Summary</h4>
		<table id="user" class="table table-bordered table-striped" style="clear: both">
		    <tbody>
			<tr>
			    <td class="column-left"><span class="s5"  key="pam">Payment Amount</span>:</td>
			    <td class="column-right">

				Tsh <?= money($amount); ?> 
			    </td>
			</tr>
			<tr>
			    <td><span  class="s5"  key="psc">Service Charge</span></td>
			    <td>
				0
			    </td>
			</tr>
			<tr>
			    <td><span class="s5"  key="ptp">Total Amount to Pay</span></td>
			    <td> Tsh <?= money($amount) ?> </td>
			</tr>
		    </tbody>
		</table>
	    </div>
	</div>
    </div>
</div> 
<script>
    validate_payment = function (invoice) {
	/*var method = $('.pay').attr('id'); */
	var value = $('#confirm_payment').val();
	if (value === '') {
	    $('#confirm_payment_status').html('<div class="alert alert-danger"><i class="fa fa-times-circle"></i> Field is empty: Enter a valid receipt code first</div>');
	    return 0;
	}
	$('#confirm_payment_status').html(LOADER);
	/*NProgress.start();*/
	$.getJSON(url + 'PaymentController/confirm_payment', {code: value, invoice: invoice}, function (data) {
	    if (data.status === 0) {
		$('#confirm_payment_status').html(data.message);
	    } else {
		var type = window.location.hash.substr(1);
		if (type.split("/")[1] == "complete") {
		    window.location = url + "#bn_application/index";
		} else if (type.split("/")[1] == "index") {
		    //window.location.reload();
		    $('#confirm_payment_status').html(data.message);
		    //window.location = url + "#bn_application/index";
		} else {
		    $('#confirm_payment_status').html(data.message);
		}
		//window.location = url + "#bn_application/index";
		/* NProgress.done();*/
	    }
	});
    };
</script>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

﻿
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

	<title><?php //echo $panel_title;  ?></title>
	<link href="<?//= site_url('assets/invoice/bootstrap.css')?>" rel="stylesheet" />
	<!-- GOOGLE FONTS -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css' />

    </head>
    <style type="text/css">

	/* =============================================================
	   GENERAL STYLES
	 ============================================================ */
	body {
	    font-family: 'Open Sans', sans-serif;
	    font-size:12px;
	    line-height:30px;

	}
	.pad-top-botm {
	    padding-bottom:40px;

	}
	/* =============================================================
	   PAGE STYLES
	 ============================================================ */



	.ttl-amts hr {
	    margin-left: 70px;
	    margin-bottom: 0px;
	    border-top: solid 1px;
	    border-bottom:  none;
	}

	.client-info {
	    font-size:16px;
	}

	.ttl-amts {
	    text-align:left;
	}
	SPAN {

	    font-style:italic;
	    padding:0px 50px 0px 50px;

	}
	.ttl-amts {

	    font-size: 12px;
	}
	i{
            font-size: 10px;
	}

    </style>
    <body style="width: 80%; margin: 0px auto; padding-left: 10%; padding-right: 10%;" >
	<?php foreach ($receipt as $value) { ?>
	<div class="container" style="">

    	    <div class="row   ">
    		<div class="col-md-12"


    		     <div class="col-lg-12 col-md-12 col-sm-12">
    			<table>

    			    <tr ><td>
    <?php
    if ($siteinfos->photo) {
	$array = array(
	    "src" => base_url('storage/uploads/images/' . $siteinfos->photo),
	    'width' => '100px',
	    'height' => '100px'
	);
	echo img($array);
    }
    ?>
    				</td><td style="width: 90%" align="center">   <?php if (empty($receipt->invoice_title)) { ?>
					    <b style="font-family:tahoma;font-size:20px; display:block;"><?= $siteinfos->sname ?></b>
					<?php } else { ?>
					    <b style="font-family:tahoma;font-size:20px; display:block;"><?= $receipt->invoice_title ?></b>  
					<?php } ?>

    				    <i> &nbsp;&nbsp;<?= $siteinfos->address ?></i>,&nbsp;
    				    <i><?= $siteinfos->box ?></i>,&nbsp;

    				    <i><b>Mob:</b><?= $siteinfos->phone ?></i>.&nbsp;&nbsp;

    				    <i><b> Email: </b><?= $siteinfos->email ?></i>&nbsp;

    				    <i> <b>Website:</b><?= strtolower($siteinfos->sname) ?></td></tr> 

    						</table>


    						</div>
    						</div>
    						</div>

    						<div  class="row ">
    						    <div class="col-lg-12 col-md-12 col-sm-12">
    							<div class="col-lg-3 col-md-3 col-sm-3">
    							    <strong>RECEIPT NO:</strong><b> <?= $value->receiptID ?></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span >    <strong >Date:</strong><b><?= date('d M Y', strtotime($value->paymentdate));
				    ?></span>    
    							</div> 
    						    </div>
    						</div>

    						<div class="row">
    						    <div class="col-lg-12 col-md-12 col-sm-12">
    							<div class="ttl-amts">
    							    Received from 
    							    <span style="padding-left:50px;padding-right: 30px; font-weight:bold; text-transform:uppercase">
    <?= $value->name ?></span><hr/>
    							</div>

    							<div class="ttl-amts">
    							    Sum of shillings(words)

    							    <span style="padding-left:20px;padding-right: 50px; font-weight:bold; text-transform:uppercase">
    <?= number_to_words($value->paymentamount) ?>  SHILLINGS ONLY</span><hr/>
    							</div>

    							<div class="ttl-amts">
    							    Being Payment for</span> 
    							    <span style="padding-left:80px;padding-right: 50px; font-weight:bold; text-transform:uppercase">
    <?php
    $fees = $this->payment_m->get_paid_fee_name($value->paymentID);
    $i = 0;
    foreach ($fees as $fee) {
	$i = $i + 1;
	echo $i . '.  ' . ' ' . $fee->name . '   ' . '  ';
    }
    ?>		
    							    </span> <hr />


    							</div>

    							<div class="ttl-amts">
    							    By cash/cheque No
    							    <span style="padding-left:80px; font-weight:bold;padding-right: 50px; text-transform:uppercase">
								    <?= $value->paymenttype . ' - ' . $value->transactionID ?> </span> <hr/>			    
    							</div>

    						    </div>
    						</div>     
    						<div class="row">
    						    <div class="responsive-table">
    							<table class="table "  style="padding-top: 20px">                         
    							    <tbody>
    								<tr>
    								    <td style="">Tsh:</td>
    								    <td style="text-align: center;color: black"><b>=<?= $value->paymentamount ?>/=</b></td>
    								    <td style="padding-left: 20px;" colspan="3">NON REFUNDABLE</td>
    								    <td colspan="2" style="width: 20%; padding-left:300px">-------------------<br>With Thanks</td>
    								</tr>                               
    							    </tbody>
    							</table>
    						    </div>
    						</div>
    						</div> <br><br><hr style="border: none; border-bottom: dotted 1px grey"/>
    							<br>

<?php } ?>

							    </body>
							    </html>
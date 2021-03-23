

<?php
/**
 * @author Ephraim Swilla <ephraim@inetstz.com>
 */
$school = $siteinfos;
$usertype = session('usertype');

?>
<div class="well" name="well" id="well">
    <div class="row">
	<div class="col-sm-6">
	    <button class="btn-cs btn-sm-cs" onclick="printPage()"><span class="fa fa-print"></span> <?= $data->lang->line('print') ?> </button>
	  

	    <!--<button class="btn-cs btn-sm-cs" data-toggle="modal" data-target="#mail"><span class="fa fa-envelope-o"></span> <?= $data->lang->line('mail') ?></button>-->                
	</div>
	<div class="col-sm-6">
	    <ol class="breadcrumb">
		<li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
		<li><a href="<?= base_url("invoices/index") ?>">Invoices</a></li>
		<li class="active">Receipt</li>
	    </ol>
	</div>
    </div>

</div>


<div id="printablediv" style="margin-top: -30px;">  
<section class="content invoice"style=" margin: 0px auto; padding-left: 10%; padding-right: 10%; page-break-inside: avoid;" >
    	<div class="row text-center">

    	    <div class="row pad-top-botm ">
    		<div class="col-lg-2">
    	    <img src="<?= base_url('storage/uploads/images/' . $school->photo) ?>"  width="80px" height="80px"/>
    		</div>
    		<div class="col-lg-8" style="font-family:tahoma; font-size:15px; display:block;">
			<?php if (empty($value->invoice_title)) { ?>
			    <b  style="font-family:tahoma;font-size:20px; display:block;"><?= $school->sname ?></b><br>  
			<?php } else { ?>
			    <b  style="font-family:tahoma;font-size:20px; display:block;"><?= $value->invoice_title ?></b><br>  
			<?php } ?>

    		    <i> &nbsp;&nbsp;<?= $school->address ?></i>,&nbsp;
    		    <i><?= $school->box ?></i>,&nbsp;

    		    <i><b>Mob:</b><?= $school->phone ?></i>.&nbsp;&nbsp;

    		    <i><b> Email: </b><?= $school->email ?></i>&nbsp;

    		    <i> <b>Website:</b> <?= strtolower($school->website) ?><br><b></i>

    		</div> 
    	    </div>
    	    <div class="col-lg-3 col-md-3 col-sm-3">              
    	    </div>
    	</div>
	    <br/>           
    	<div  class="row">
    	    <div class="col-lg-8">
		<h1 align="right"><strong>INVOICE NO:</strong><b> <?php
                if($is_reference==1) {
                echo $payments[0]->reference;
                        
                } ?></b>, &nbsp; &nbsp; <strong>RECEIPT NO:</strong><b> <?=$receipt_no ?></b></h1>
    	    </div>
    	    <div class="col-lg-4">
    		<h4 align="right">  <strong>Date:</strong><b><?= date('d M Y ', strtotime($payments[0]->date)) ?> </b>
    	    </div>
    	</div>
           
	    <br/><br/>
    	<div class="row">
    	     <div class="col-lg-12 col-md-12 col-sm-12">
    							<div class="ttl-amts">
    							    Received from 
    							    <span style="padding-left:50px;padding-right: 30px; font-weight:bold; text-transform:uppercase">
                                                                <?php
                                                                //$pay=\collect($payments)->first();
                                                                ?>
    <?= $payment_info->student->name ?></span><hr/>
    
    
    							</div>

    							<div class="ttl-amts">
    							    Sum of shillings(words)

    						<span style="padding-left:20px;padding-right: 50px; font-weight:bold; text-transform:uppercase">
    <?= number_to_words($payment_info->amount) ?>  SHILLINGS ONLY</span><hr/>
    							</div>

    							<div class="ttl-amts">
    							    Being Payment for 
    							    <span style="padding-left:80px;padding-right: 50px; font-weight:bold; text-transform:uppercase">
    <?php
    
  
    $i = 0;
   if(!empty($payments)){
    foreach ($payments as $payment) { 

				    	
	$i = $i + 1;
	echo $i . '.  ' . ' ' . $payment->name . '   ' . '  ';
	}
}
    
    ?>		 </span> <hr />


   							</div>

    							<div class="ttl-amts">
    							    By cash/cheque No
    							    <span style="padding-left:80px; font-weight:bold;padding-right: 50px; text-transform:uppercase">
								    <?= isset($payment_info->payment_type_id) ? $payment_info->paymentType->name : 'Not Defined' . ' - ' . isset($payment_info->transaction_id).'  '.'-'.isset($payment_info->bankAccount->bank_name);?> </span> <hr/>			    
    							</div>
    						    </div>
<?php exit;?>
    	    <div class="responsive-table">
    	    </div>
    	</div>
            <div class="row">
    						    <div class="responsive-table">
    							<table class="table "  style="padding-top: 20px">                         
    							    <tbody>
    								<tr>
    								    <td style="">Tsh:</td>
    								    <td style="text-align: center;color: black"><b>=<?= $value->amount_entered ?>/=</b></td>
    								    <td style="padding-left: 20px;">NON REFUNDABLE</td>
    								    <td colspan="4" style="width: 40%; padding-left:20px">-------------------------------<br>With Thanks</td>
    								</tr>                               
    							    </tbody>
    							</table>
    						    </div>
    						</div><br>-----------------------------------------------------------------------------------------------------------------
    							<br>
        </section>
   
    <br><br>
</div>

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
		    if (form_error($errors,'to'))
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
		if (form_error($errors,'subject'))
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
	    if (form_error($errors,'message'))
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
if(document.all) {
document.all.well.style.display = 'none';
document.all.topnav.style.display = 'none';
window.print();
document.all.well.style.visibility = 'visible';
document.all.topnav.style.visibility = 'visible';
} else {
document.getElementById('well').style.display = 'none';
document.getElementById('topnav').style.display = 'none';
window.print();
document.getElementById('well').style.visibility = 'visible';
document.getElementById('topnav').style.visibility = 'visible';
}
}
</script> 



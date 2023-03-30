<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
/**
 * @author Ephraim Swilla <ephraim@inetstz.com>
 */
$school = $this->session->CI->data['siteinfos'];
$usertype = session['usertype'];

?>
    
   <link href="<?//=  base_url('assets/invoice/bootstrap.css')?>" rel="stylesheet" />
	  <!-- CUSTOM STYLE  -->
<!--    <link href="<?//=  base_url('assets/invoice/custom-style.css')?>" rel="stylesheet" />-->
    <!-- GOOGLE FONTS -->

    <style type="text/css">
        
     ﻿

/* =============================================================
   GENERAL STYLES
 ============================================================ */

.pad-top-botm {
    padding-bottom:40px;
    padding-top:60px;
}
/* =============================================================
   PAGE STYLES
 ============================================================ */

.contact-info span {
    font-size:14px;
    padding:0px 50px 0px 50px;
}


.client-info {
    font-size:15px;
}
.ttl-amts hr {
    margin-left: 70px;
margin-bottom: 0px;
border-top: solid 1px;
border-bottom:  none;
}

.ttl-amts {
    text-align:left;
    padding-left:50px;
    padding-right:50px;
    font-size: 16px;
}  
            div {
                color: red
            }
         
              .ttl-amts span{
                color: black
            }
                hr{
                color: red
            }
        
        
    </style>
 <div class="row pad-top-botm">
         <div class="col-lg-12 col-md-12 col-sm-12">
          
             <?php
            
	echo btn_add_pdf('invoices/receipt_print_preview/'.$receipt->paymentID, $data->lang->line('pdf_preview'))
			?>
             &nbsp;&nbsp;&nbsp;
<!--              <a href="#" class="btn btn-success btn-lg" >Download In Pdf</a>-->

             </div>
         </div>


    <div id="printablediv" style=" ">
          <section class="content invoice"style="width: 80%; margin: 0px auto;" >
            <div class="row text-center" style="color: red">
           <div class="row pad-top-botm ">
          <div class="col-lg-2 col-md-2 col-sm-2 ">
              <img src="<?= base_url('storage/uploads/images/' . $school->photo)?>"  width="100px" height="100px"/> 
         </div>
               <div class="col-lg-9 col-md-9 col-sm-9">
            <?php
                 if(empty($receipt->invoice_title)){?>
                                         <b  style="font-family:tahoma;font-size:20px; display:block;"><?=$school->sname ?></b>  
                                    <?php  }  else {?>
                                        <b  style="font-family:tahoma; font-size:20px; display:block;"><?= $receipt->invoice_title ?></b>  
                                   <?php   }?>
            
                                      <i> &nbsp;&nbsp;<?= $school->address ?></i>,&nbsp;
                                        <i><?= $school->box ?></i>,&nbsp;

                                        <i><b>Mob:</b><?= $school->phone ?></i>.&nbsp;&nbsp;

                                        <i><b> Email: </b><?= $school->email?></i>&nbsp;

                                        <i> <b>Website:</b> www.<?= strtolower($school->sname)?>.shulesoft.com<br></i><b style="font-family:tahoma; font-size:18px; display:block;"><?= strtoupper($receipt->optional_name) ?></b>
              
         </div>
     </div>
     <div  class="row pad-top-botm client-info">
         <div class="col-lg-6 col-md-6 col-sm-6">
             <strong>RECEIPT NO:</strong><b style="color: black"> <?= $receipt_info->receiptID ?></b>
     
         </div>
         <div class="col-lg-3 col-md-3 col-sm-3"> 
             
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3">
               <h4>  <strong>Date:</strong><b style="color: black">&nbsp<?=date('d M Y ',  strtotime($receipt->paymentdate)) ?> 
          </div>
     </div>
     <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="ttl-amts">
                     
                          Received from 
                          <span style="padding-left:80px; font-weight:bold; text-transform:uppercase">
						<?= $receipt->name ?></span> <hr/>
                      </div>
                    
              <div class="ttl-amts">
               
                Sum Amount(words)

                      <span style="padding-left:80px; font-weight:bold; text-transform:uppercase">
		<?= number_to_words($receipt->paymentamount) ?>  SHILLINGS ONLY</span><hr/>
              </div>
             
              <div class="ttl-amts">
          

                     Being Payment for   
                      <span style="padding-left:80px; font-weight:bold; text-transform:uppercase">
                          <?php
                          $fees=$this->payment_m->get_paid_fee_name($receipt->paymentID);
                          $i=0;
                          foreach ($fees as $fee) {
                              $i=$i+1;
                              echo $i.'.&nbsp;'.$fee->name.'&nbsp;&nbsp';
                              
                          }
                          
                          
                          ?>
                          
			</span> <hr />

					    
             </div>
            
               <div class="ttl-amts">
             
                By cash/cheque No
		<span style="padding-left:80px; font-weight:bold;text-transform:uppercase">
						<?= $receipt->paymenttype . ' - ' . $receipt->transactionID ?> </span> <hr />			    
             </div>
           
         </div>
              
           <div class="responsive-table">
               <table class="table " style="color: red" >
                          
                            <tbody>
                                <tr>
                                    <td style="padding-left: 50px">Tsh:</td>
                                    <td style="text-align: center;color: black"><?= $receipt->paymentamount?>/=</td>
                                    <td style="padding-left: 20px">NON REFUNDABLE</td>
                                    <td colspan="2">-------------------<br>With Thanks</td>
                                </tr>
                                
                            </tbody>
                        </table>
               </div>
         </div>
     </div>
<!--      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <strong> Important: </strong>
             <ol>
                  <li>
                    This is an electronic generated invoice so doesn't require any signature.

                 </li>
                 <li>
                     Please read all terms and polices on  www.yourdomaon.com for returns, replacement and other issues.

                 </li>
             </ol>
             </div>
         </div>-->
     
</section>

 </div>
     
<script type="text/javascript">
     function printDiv(divID) {
		//Get the HTML of div
		var divElements = document.getElementById(divID).innerHTML;
		//Get the HTML of whole page
		var oldPage = document.body.innerHTML;

		//Reset the page's HTML with div's HTML only
		document.body.innerHTML =
			"<html><head><title></title></head><body>" +
			divElements + "</body>";

		//Print Page
		window.print();

		//Restore orignal HTML
		document.body.innerHTML = oldPage;
	    }
	    function closeWindow() {
		location.reload();
	    }
</script>
     


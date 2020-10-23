@extends('layouts.app')
@section('content')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Payment Voucher</h4>
                <span>Print and let the person sign it</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Expenses</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Voucher</a>
                    </li>
                </ul>
            </div>
        
        </div>
        <div class="page-body">
            <p align="right"><button class="btn btn-xs btn-danger" onclick="javascript:printDiv('printablediv')">
                    <span class="fa fa-print"></span> <?= __('print') ?> </button> </p>
    <div class="card" >
        <div class="row">
            <div class="col-sm-1 col-lg-1"></div>
            <div class="col-sm-10 mail_list_column" id="payment_lists">
                <?php
                /**
                 * @author Ephraim Swilla <ephraim@inetstz.com>
                 */
              
                ?>
                <div id="printablediv">

                    <?php if (isset($voucher) && !empty($voucher)) { ?>
                        <section   class="content invoice" style=" margin: 0px auto; padding-left: 10%; padding-right: 10%; page-break-inside: avoid;">
                    
                            <div class="">
                                <table class=" table-striped center" style="margin: 1px 2px 1px 0px;">
                                    <thead>
                                    <tr>
                                        <th class="col-md-2" style="padding-bottom:0px">
                                                <img src="{{url('public/assets/images/inets.png')}}" height="140" alt="INETS Company Limtied, ShuleSoft School Management System" style="margin-right: 40%;">
                                                    
                                        </th>
                                        <th class="col-md-8 text-center " style="margin: 1% 0 0 16%; padding-top: 2%; ">

                                            <h3 style="font-weight: bolder !important;">INETS COMPANY LTD</h3>
                                            <h6><?= 'P.O. BOX 32282,Dar es salaam '?></h6>
                                            <h6><b><?= __('Cell') ?>:</b> +255 655/754 406004</h6>
                                           <h6> <b><?= __('Email') ?>:</b> info@inetstz.com</h6>
                                            <h6><b><?= __('Website') ?>:</b> www.inetstz.com</h6>
                                        </th>
                                        <th class="col-md-2" style="padding-bottom:0px"></th>

                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <hr/>


			   <div class="row text-center">
				 <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                      
                                        <h2 align="centre" style="">
                        <?= strtoupper(isset($voucher->payment_method)? $voucher->payment_method:'' ).'  '?> PAYMENT VOUCHER</h2>
                                  
                                    </tr>
                                    </table></div>
                            </div>
                            <div  class="row">

                                   <div class="table-responsive">
                                       <table class="table" style="width: 100%">
					 <thead>
                         <tr>
                             <th>Voucher No:<b><?=date('Y', strtotime($voucher->date))?>/<?=$voucher->voucher_no?></b></th> <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> <th>Date:<b><?= $voucher->date; ?></b></th>
                        </tr>
					 </thead>
				    </table>

                         </div>
                        </div>

                <?php
                if (isset($productexpenses) && sizeof($productexpenses) > 0) { ?>
                 <div class="row text-center">
			 <div class="col-lg-12 table">
			     <p>1.Pay the under mentioned Amount to</p>
                                   <table class="table table-bordered">

                                            <tbody>

                                            <tr>
                                            <th>No.</th>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Sub-amount</th>
                                            </tr>
                                                <?php
                                                 $i=1;
                                                 $sum = 0;
                                                  foreach($productexpenses as $cart){
                                                    $sum +=$cart->amount;
                                                    ?>
                                            <tr>
                                            <th><?=$i++?></th>
                                            <th><?=$cart->productQuantity->name?></th>
                                            <th><?php echo $cart->quantity .' - '. $cart->productQuantity->metric->abbreviation;?></th>
                                            <th><?=money($cart->amount)?></th>
                                            </tr>
                                            <?php } ?>

                                            <tr>
                                            <th colspan="3">Payment Details for - <?php echo  $cart->productQuantity->referExpense->name;?> <span style="float: right">Total Amount</span></th>
                                            <th><?=money($sum)?>/=</th>
                                            </tr>

                                            <tr style="text-transform: uppercase ; text-align:center;">
                                            <td colspan="4">Amount In Words:<?= number_to_words($sum) ?> only.</td>
                                          </tr>
                                          <thead>
                                              <tr>
                                                  <th colspan="4">Name of the Recipient/Vendor - <b> <?=$cart->vendor->name?></b> (<?=$cart->vendor->phone_number?>) <br>Address: -  </th>
                                                </tr>
                                            </thead>
                                            <tr>
                                            <th>Note:</th>
                                            <th colspan="3"><?=$cart->expenses->note?></th>
                                            </tr>
                                            </tbody>
                                            </table>
                                          </div>
                                        </div>
                                <?php    } else{?>
                                    <div class="row text-center">
			 <div class="col-lg-12 table">
			     <p style="float: left;" >1.Pay the under mentioned Amount to</p>
                                   <table class="table table-bordered">
					 <thead>
					 <tr>
					     <th colspan="4">Name of the Recipient:<b><?=$voucher->recipient?></b><br>
                         Address:</th>
                        </tr>
					 </thead>
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th style="width: 59%">Payment Details for <b><?= strtoupper(isset($voucher->refer_expense_id)? $voucher->ReferExpense->name:'' ).'  '?></b></th>

                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td><?=$voucher->note?></td>
                                                <td><?= money($voucher->amount)?></td>
                                            </tr>
                                            <tr>
                                            <td colspan="3"><center>Amount In Words:- <?php echo strtoupper(number_to_words($voucher->amount)).' ONLY'; ?></center></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                                <?php } ?>
                            <div class="row">

			       <p>2.Prepared By: </p>
                   <table class="table table-bordered">
					 <thead>
					 <tr>
					     <th>Name:&nbsp;<b><?=$voucher->payer_name?></b><br>
					    </th>
					    <th>Signature:-------------------------------------</th>
                        </tr>
					 </thead>
				    </table>
                    </div>

			
                    <div class="row">

                          <p>3. I Approve that the above mentioned amount is correct and I authorise payment</p>
                                            <table class="table" border="0" cellspacing="0" cellpadding="0">
                              <thead>
                              <tr>
                                  <th>Name of Officer
                                 </th>
                                 <th>Designation</th>
                                 <th>Signature</th>
                                  <th>Date</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>-----------------------------</td>
                                  <td>--------------------------</td>
                                  <td>-------------------------</td>
                                  <td>---------/---------/--------------</td>
                                  </tr>
                              </tbody>
                             </table>
                            </div>
			    <div class="row">

			     <p>4. Received the amount stated above</p>
                                   <table class="table" border="0" cellspacing="0" cellpadding="0">
					 <thead>
					 <tr>

					    <th>---------------------------</th>
					     <th >-----------------------------</th>


                                            </tr>
					 </thead>
					 <tbody>
					     <tr>
						 <td>Signature</td>
						 <td>Date</td>
					     </tr>
					 </tbody>
				    </table>


                            </div>
           
                        </section>
                        <?php
                    } else {


                        echo'There is an issue in this receipt';
                    }
                    ?>

                    <br><br>
                </div>
            </div>
            <div class="col-sm-1 col-lg-1"></div>
            <!-- /MAIL LIST -->
        </div>
    </div>
        </div>
    </div>
</div>
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
    @endsection

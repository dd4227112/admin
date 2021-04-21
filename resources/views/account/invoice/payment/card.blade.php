@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>

<div class="main-body">
    <div class="page-wrapper">

     <?php
	 $am = $invoices->invoiceFees()->sum('amount'); 
    define('EXCHANGE_RATE', 2300); //this is just approximation
    $amountUSD = round($am / EXCHANGE_RATE, 2);
    $account_sandbox = '901314453';
    $account_live = '102514285';
    $mode = 'sandbox';
//$mode = 'sandbox';
    $PUBLISHABLE_KEY = $mode == 'sandbox' ?
	    '66A6A908-4E69-4F8D-AF2C-2DCEAB6D2FC1' :
	    '3FE7F7D8-2A0E-4042-A0EC-39A714BFDEC9';
    $account_number = $mode == 'sandbox' ? $account_sandbox : $account_live;
    $url=$mode=='sandbox' ? 
	    'https://sandbox.2checkout.com/checkout/purchase':'https://www.2checkout.com/checkout/purchase';
    ?>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
						<div class="row">
							<div class="col-md-6">
								<div style="margin: 20px">
									<h4>&nbsp; Pay with Debit Card,  Credit Card or PayPal Account</h4>
								</div>
								
								<br/>
						
								<br/>
								<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<form action='<?= $url ?>' method='post'>
									<input type='hidden' name='sid' value='<?= $account_number ?>' />
									<input name="return_url" type="hidden" value="https://demo.shulesoft.com/payment_result">
									<input type='hidden' name='mode' value='2CO' />
									<input type='hidden' name='li_0_type' value='product' />
									<input type='hidden' name='currency' value='USD' />
									<input type='hidden' name='li_0_name'  />
									<input type='hidden' name='li_0_price' value='<?= $amountUSD ?>' />
									<input type='hidden' name='card_holder_name' value='<?= $user->name ?>' />
									<input type='hidden' name='street_address' value='<?= $user->address ?>' />
									<input type='hidden' name='city' value='<?= $user->address ?>' />
									<input type='hidden' name='state' value='TZ' />
									<input type='hidden' name='zip' value='43228' />
									<input type='hidden' name='country' value='TANZANIA -UNITED REPUBLIC' />
									<input type='hidden' name='email' value='<?= $user->email ?>' />
									<input type='hidden' name='phone' value='<?= $user->phone ?>' />
									<input name="paypal_direct" type="hidden" value="Y">
									<input name='submit' class="btn btn-warning" type='submit'  value='Add Payment Now' />
								<?= csrf_field() ?>
					           </form>
								</div>

									<div class='form-group' >
										<label for="cardno" class="col-sm-4 control-label" style="text-align: right;" >
										Credit Card Number:
										</label>
										<div class="col-sm-6">
										 <input id="ccNo"  type="text" maxlength="20" autocomplete="off" value="" autofocus class="form-control"/>
										</div>
									</div>
						
									
									<div class='form-group' >
										<label for="cvs" class="col-sm-4 control-label" style="text-align: right;">
										CVC:
										</label>
										<div class="col-sm-6">
										 <input id="cvv" type="text" maxlength="4" class="form-control" autocomplete="off" value=""/>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" style="text-align: right;">Expiry Date: </label>
										<div class="col-sm-6" style="padding-bottom:12px;">
										<select id="expMonth" class="form-control">
										<option value="01">Jan</option>
										<option value="02">Feb</option>
										<option value="03">Mar</option>
										<option value="04">Apr</option>
										<option value="05">May</option>
										<option value="06">Jun</option>
										<option value="07">Jul</option>
										<option value="08">Aug</option>
										<option value="09">Sep</option>
										<option value="10">Oct</option>
										<option value="11">Nov</option>
										<option value="12">Dec</option>
										</select>

										<select id="expYear" class="form-control">
										<option value="13">2013</option>
										<option value="14">2014</option>
										<option value="15">2015</option>
										<option value="16">2016</option>
										<option value="17">2017</option>
										<option value="18">2018</option>
										<option value="19">2019</option>
										<option value="20">2020</option>
										<option value="21">2021</option>
										<option value="22">2022</option>
										</select>
										</div>
									</div>
									<label class="col-md-4"></label>
									 <div style="margin: 20px"> 
										<button id="process-payment-btn" class="btn btn-primary"  type="button">Process Payment</button>
									 </div>
									 
									<?= csrf_field() ?>
				             	</form>
								<div id="span_loader"></div>
							</div>

							<div class="col-md-6">
								<h4 class="heading">Payment Summary</h4>
								<?php $invoice_fee = $invoices->invoiceFees()->first(); ?>
								<table id="user" class="table table-bordered table-striped" style="clear: both">
								<tbody>
									<tr>
									<td class="column-left">Payment Amount:</td>
									<td class="column-right">
					
										<?= $amountUSD ?> USD approx
									</td>
									</tr>
									<tr>
									<td>Service Charge</td>
									<td>
										<?= $service_charge = 0.05 * $amountUSD + 0.47; ?> approx
									</td>
									</tr>
									<tr>
									<td>Total Amount to Pay</td>
									<td><?= $amountUSD + $service_charge ?> approx</td>
									</tr>
									<tr>
									<td>Payment For</td>
									<td> <?= $invoice_fee->item_name ?> </td>
									</tr>
								</tbody>
								</table>
							</div>
						  </div>

                   
                     
                
                    </div>

                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>

@endsection





<script src="https://www.2checkout.com/static/checkout/javascript/direct.min.js"></script>
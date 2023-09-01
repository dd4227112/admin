
<?php $root = url('/') . '/public/';?>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <div class="@if(!isset($balance))  page-wrapper @endif">
        <style>
            #valid-msg {
                color: #00C900;
            }
            #error-msg {
                color: red;
            }

        </style>
        <?php
        $bn_number = 888999;
        ?>

            <div class="row">
                <div class="col-md-12 col-xl-12">
                            <div id="print_div">
                                <div style="margin: 0 auto; margin-bottom: 0.5cm; padding: 10mm;">
                                      <div class="row" style="margin-top: 0px ">
                                    <div class="col-lg-12 col-sm-12">
                                        <div style="border-bottom: 1px solid #dadada; margin-bottom:10px;">
                                            <img src="<?= $root ?>/images/Inetslogo.png"  width="180" height="80"/>
                                        </div>
                                        
                                        <table  style="padding: 8px;text-align: left;">
                                            <tbody>
                                                <tr style="text-align: left;">
                                                    <td>
                                                        <li style="font-size: 1.5rem;list-style: none; text-align:left;">From</li>
                                                        <li style="font-size: 0.9rem;list-style: none; text-align:left;"><strong>SHULESOFT LIMITED</strong></li>
                                                        <li style="font-size: 0.9rem;list-style: none; text-align:left;">P.o Box 32282 Dar es Salaam</li>
                                                        <li style="font-size: 0.9rem;list-style: none; text-align:left;">Shamo Park House</li>
                                                        <li style="font-size: 0.9rem;list-style: none; text-align:left;">3rd Floor, Bagamoyo Road</li>
                                                        <li style="font-size: 0.9rem;list-style: none; text-align:left;">Mobile no: +255 655/754 406004</li>
                                                    </td>
                                                    <td>
                                                        <ul  style="border-left: 1px solid #cccc; padding-left: 3em; margin-left:20px;list-style: none;">
                                                            <li style="font-size: 1.5rem; font-weght: bold;">To</li>
                                                            <li style="font-size: 0.9rem;"><strong><?= $invoice->client->name ?></strong></li>
                                                            <li style="font-size: 0.9rem;">Phone: <?= $invoice->client->phone ?></li>
                                                            <li style="font-size: 0.9rem;">Email: <?= $invoice->client->email ?></li>
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <h1 class="pull-right invoice-title" style="font-size: rem; float: right; margin-left:20px;"><?= $invoice_name ?? '' ?></h1>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="col-sm-12 col-lg-12">
                                        <table   style="border-collapse: collapse; width: 100%;  padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">
                                            <tr>
                                                
                                                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">Invoice #</td>
                                                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">
                                              <?= strlen($invoice->token) < 4 ? $invoice->reference : $invoice->token ?></td>
                                                <td colspan="2" style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;"> </td>
                                            </tr>

                                            <tr>
                                                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">Start Date #</td>
                                                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;"><?=date('d M Y', strtotime('-30 day', strtotime($invoice->due_date))) ?> </td>
                                               
                                                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">Due Date #</td>
                                                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;"><?= date('d M Y', strtotime($invoice->due_date)) ?></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px;text-align: left;background-color: rgb(211, 208, 208);">TOTAL DUE</td>
                                                <td style="padding: 8px;text-align: left;background-color: rgb(211, 208, 208);">  <?php
                                                    $am = $invoice->invoiceFees()->sum('amount');
                                                    $paid = $invoice->payments()->sum('amount');
                                                    $unpaid = $am - $paid;
                                                    ?><b class="amnt-value">Tsh <?= number_format($unpaid) ?></b>
                                                </td>
                                                <td colspan="2" style="padding: 8px;text-align: left;background-color: rgb(211, 208, 208);"> </td>
                                            </tr>
                                        </table>
                                    </div>

                                    
                                    <?php
                                    $invoice_fee = $invoice->invoiceFees()->get();
                                    ?>
                                    <br/>
                                    <div class="col-xs-12 col-sm-12 col-lg-12">
                                        <table style="border-collapse: collapse; width: 100%;border: 1px solid #ddd; padding: 8px;" >
                                            <thead>
                                                <tr>
                                                    <th style="border: 1px solid #ddd; padding:8px">#</th>
                                                    <th style="border: 1px solid #ddd;padding:8px">Description</th>
                                                    <th style="border: 1px solid #ddd;padding:8px">Quantity</th>
                                                    <th style="border: 1px solid #ddd;padding:8px">Unit Price</th>
                                                    <th style="border: 1px solid #ddd;padding:8px">Total (Tsh)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($invoice_fee as $fees) {
                                                    ?>
                                                    <tr>
                                                    <td style="border: 1px solid #ddd;padding:8px"><?= $i ?> </td>
                                                    <td style="border: 1px solid #ddd;padding:8px;font-size:12px;"> <strong><?= $fees->item_name ?? '' ?></strong> <br>
                                                        <?= warp($fees->note,90) ?? ''?>

                                                    </td>
                                                    <td class="text-right"style="border: 1px solid #ddd;padding:8px"><?= money($fees->quantity) ?></td>
                                                    <td class="text-right"style="border: 1px solid #ddd;padding:8px"><?= money($fees->unit_price) ?></td>
                                                    <td class="text-right"style="border: 1px solid #ddd;padding:8px"><?= money($fees->amount) ?></td>
                                                </tr>
                                            <?php $i++;} ?>

                                            </tbody>
                                        </table>
                                        <p class="well-sm "><b>Amount in words:</b> <?= number_to_words($unpaid) ?>    </p>
                                    </div>
                                    <!-- /.col -->
                                    
                                    <div class="col-sm-12 col-lg-12 col-xs-12"> 
                                     <table>
                                        <tr>
                                            <td style="margin-right: 20px;">
                                                <?php 
                                                $a  = [];
                                                        $setting = DB::table('admin.all_setting')->where('schema_name', $invoice->client->username)->first();
                                                        if(!empty($setting)) {
                                                           $a = DB::table($invoice->client->username. '.bank_accounts')->where('refer_bank_id', 22)->first();
                                                        }
                                                 if(!empty($a)){ ?>
                                                   <p>
                                                    <b  style="font-size: 0.8rem;">Account Details :</b><br/>
                                                    <b  style="font-size: 0.8rem;">Account Name:</b> SHULESOFT LIMITED <br/> 
                                                    <b  style="font-size: 0.8rem;">Bank Name:</b> NMB BANK PLC <br/> 
                                                     <b  style="font-size: 0.8rem;">Account Number:</b> 22510077805
                                                    <br/>
                                                    <small>Please notify us after a deposit</small>
                                                  </p>
                                                  <?php }else { ?>
                                                    <p>
                                                        <b  style="font-size: 0.8rem;">Account Details :</b><br/>
                                                        <b  style="font-size: 0.8rem;">Account Name:</b> SHULESOFT LIMITED <br/> 
                                                        <b  style="font-size: 0.8rem;">Bank Name:</b> NMB BANK PLC <br/> 
                                                        <b  style="font-size: 0.8rem;">Account Number:</b> 22510077805
                                                        <br/>
                                                        <small>Please notify us after a deposit</small>
                                                    </p>
                                                  <?php  }  ?>


                                                <?php if (strlen($invoice->token) > 4) { ?>
                                                <p>Or Pay Electronically here <a href="<?= url('epayment/i/' . $invoice->id) ?>" target="_blank"><?= url('epayment/i/' . ($invoice->id)) ?></a></p>
                                              <?php } ?>
                                        <!-- <br/>
                                        <b>If you make a bank deposit, you will have to notify us to activate your account</b> -->
                                        <?php if(isset($diff_in_months)) { ?>
                                       
                                            <p class="text-muted well well-sm no-shadow" style="background-color: #f2f2f2; padding:20px;">
                                                We're always delighted to serve your school
                                            </p>
                                        <?php } ?>
                                        </td>
                                        <td>
                                            <b>Summary</b>
                                            <table style="border-collapse: collapse;
 width: 100%;font-size: 14px;
 padding: 4px;
 text-align: left;
 border-bottom: 1px solid #ddd;">
 
                                                <tbody>
                                                    <tr>
                                                        <td style="padding: 4px;
 text-align: left;
 border-bottom: 1px solid #ddd;">Sub - Total amount :</td>
                                                        <td style="padding:8px;
 text-align: left;
 border-bottom: 1px solid #ddd;">Tsh <?= number_format($am) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px;
 text-align: left;
 border-bottom: 1px solid #ddd;">Paid Amount :</td>
                                                        <td style="padding: 4px;
 text-align: left;
 border-bottom: 1px solid #ddd;">Tsh <?= $paid > 0 ? number_format($paid) : 0 ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px;
 text-align: left;
 border-bottom: 1px solid #ddd;">Grand Total :</td>
                                                        <th>Tsh <?= number_format($unpaid) ?></th>
                                                        
                                                    </tr>
<th style="margin-left: 1px; z-index:1">
                                                            <img src="<?= $root ?>/images/company_seal.png"  width="200" height="130"/>
                                                       </th>
                                                </tbody>
                                            </table>
                                        </td>
                                      </tr>
                                    </table>
                                    </div>
                                    
                                </div>
</div>
                                <!-- title row -->
                               
                            </div>

                            
                        </div>
                    </div>
                  

 




 


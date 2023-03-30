<?php 
$usertype = session("usertype");
if (can_access('view_income_statement')) {
    $status=1;
    ?>
<div class="box">
    <div class="box-header">

    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
                
            <form class="form-horizontal" role="form" method="post">
                      <div class='form-group row'>
                       <div class="col-sm-4">
                           <input type="text" required class="form-control calendar" id="from_date" name="from_date" value="<?=old('from_date')?>" >

                       </div>
                       <div class="col-sm-4">
                   <input type="text" required class="form-control calendar" id="to_date" name="to_date" value="<?=old('to_date')?>" >

               </div>
              

               <div class="col-sm-2">
                   <input type="submit" class="btn btn-primary btn-block" value="View Statement" >
               </div>
           </div>
           <?= csrf_field() ?>
           </form>

            </div>
            <div class="row">
            <div class="col-sm-12">
               
                <div id="printablediv" style="margin-top: -20%">

                    <section class=" invoice">
                        <h2 class="page-header">
                            <?php
                        $array = array(
                            "src" => base_url('storage/uploads/images/' . $siteinfos->photo),
                            'width' => '50px',
                            'height' => '50px',
                            'class' => 'img-circle'
                        );
                        echo img($array);
                        ?>
                        </h2>
                </div><!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info" style="margin-left: 3%">
                <div class="col-sm-4 invoice-col">

                    <address>
                        <strong><?= $siteinfos->sname ?></strong><br>
                        <?= ucfirst($siteinfos->address) ?><br>
                        <?= $data->lang->line("phone") . " : " . $siteinfos->phone ?><br>
                        <?= $data->lang->line("email") . " : " . $siteinfos->email ?><br>
                    </address>


                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">


                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>FEE COLLECTIONS</b><br>
                    From: <?php echo date("d M Y", strtotime($from_date)) . '<br/>' ?>To: &nbsp
                    <?php echo date("d M Y", strtotime($to_date)) . '<br/>' ?>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- Table row -->

            <div class="row" style="margin: 2%">
                <div id="hide-table">


                    <h1 style="font-size: 24px; text-align: center;">
                        <strong><?= strtoupper($siteinfos->sname) ?></strong> - <b>DISCOUNT VS DUE FEES REPORT</b></h1>
                    <hr>
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th class="col-sm-1"> ID</th>
                                <th class="col-sm-4">FEE NAME</th>
                                <th class="col-sm-4"></th>
                                <th class="col-sm-4">AMOUNT(<?=$siteinfos->currency_symbol?>)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            echo '<tr  class="info"><td></td><td>Discount Fees</td><td> </td><td></td></tr>';
        
                            foreach ($discount_fees as $discount_fee) {
                    
                             ?>                             
                            <tr>
                            <td data-title="<?= $discount_fee->id ?>">
                                   <?php echo $discount_fee->id ?>
                                 </td>
                                 <td data-title="<?= $discount_fee->fee_name ?>">
                                   <?php echo $discount_fee->fee_name ?>
                                 </td>
                                <td data-title="<?= $data->lang->line('slno') ?>">			
                                 </td>				   
                                 <td data-title="amount">
                                    <?php echo money($discount_fee->total_discounts); ?>
                                  </td>
                             </tr>
                        <?php } ?>                   
                           
                        <tr><td></td><td></td><td></td></tr>
                        <?php
                            echo '<tr  class="info"></td><td><td>Due Fees</td><td> </td><td></td></tr>';
        
                            foreach ($due_fees as $due_fee) {
                    
                             ?>                            
                            <tr>
                                <td data-title="<?= $due_fee->fee_id ?>">
                                    <?php echo $due_fee->fee_id ?>
                                  </td>
                                <td data-title="<?= $due_fee->fee_name ?>">
                                   <?php echo $due_fee->fee_name ?>
                                 </td>
                                <td data-title="<?= $data->lang->line('slno') ?>">			
                                 </td>				   
                                 <td data-title="amount">
                                    <?php echo money($due_fee->due_amount); ?>
                                  </td>
                             </tr>
                        <?php } ?>  

                </div>

            </div><!-- /.row -->

            </div><!-- /.row -->

            </div><!-- /.row -->

            </div><!-- /.row -->

            <div class="col-sm-6">
                <button id= "prints" class="btn-cs btn-sm-cs" onclick="javascript:printDiv('printablediv')"><span
                        class="fa fa-print"></span> <?= $data->lang->line('print') ?> </button>

                </section><!-- /.content -->
            </div>

            <!-- email end here -->

            <script language="javascript" type="text/javascript">
                function printDiv() {
                    if (document.all) {
                        document.all.well.style.visibility = 'hidden';

                        document.all.topnav.style.visibility = 'hidden';
                        $('.mail_list_column').hide();
                        window.print();
                        document.all.well.style.visibility = 'visible';
                        document.all.topnav.style.visibility = 'visible';
                        $('.mail_list_column').show();
                    } else {
                        $('.well').hide();
                        document.getElementById('topnav').style.display = 'none';
                        $('.dt-buttons').hide();
                        $('#example1_filter').hide();
                        $('#prints').hide();
                        $('#example1_info').hide();
                        $('.form-horizontal').hide();
                        $('#example1_paginate').hide();
                        window.print();
                        $('.mail_list_column').show();
                        $('.well').show();
                        $('#topnav,#payment_receipt_title').show();
                    }
                }

                function closeWindow() {
                    location.reload();
                }
            </script>
            <?php } ?>
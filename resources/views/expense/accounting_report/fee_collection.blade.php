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
                    <b>Cash Basis Report</b><br>
                    From: <?php echo date("d M Y", strtotime($from_date)) . '<br/>' ?>To: &nbsp
                    <?php echo date("d M Y", strtotime($to_date)) . '<br/>' ?>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- Table row -->

            <div class="row" style="margin: 2%">
                <div id="hide-table">


                    <h1 style="font-size: 24px; text-align: center;">
                        <strong><?= strtoupper($siteinfos->sname) ?></strong> - <b>CASH BASIS REPORT</b></h1>
                    <hr>
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th class="col-sm-1"> No</th>
                                <th class="col-sm-4">ACCOUNT</th>
                                <th class="col-sm-4">AMOUNT(<?=$siteinfos->currency_symbol?>)</th>
                            </tr>


                        </thead>
                        <tbody>
        
                        <tr>
                        <th class="info" colspan="3"> <b> Fee Collections</b> </th>
                    </tr>
                            <?php
                                if(isset($fees) && count($fees) > 0){

                            $sum_revenue = 0;
                            $i = 1;
                            foreach ($fees as $fee) {
                                $total_fee = $fee->total;
                                $sum_revenue = $sum_revenue + $total_fee;
                                ?>
                            <tr>
                                <td data-title="<?= $data->lang->line('slno') ?>"> {{ $i++ }} </td>
                                <td data-title="<?= $fee->name ?>">
                                    <?php echo ucfirst($fee->name) ?>
                                </td>

                                <td data-title="Total">
                                    <?php
                                        if (!empty($total_fee)) {
                                            echo money($total_fee);
                                        } else {
                                            echo 0;
                                        }
                                        ?>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td></td>
                                <th> <b> Total Fee Collection</b> </th>
                                <th> <b> <?php echo money($sum_revenue) ?></b> </th>
                              </tr>
                            <?php } ?>
                            
                    <tr>
                        <th class="info" colspan="3"> <b> Revenue Collections</b> </th>
                    </tr>
                   
                    <?php
                if(isset($revenues) && count($revenues) > 0){

                    $allsum_revenue = 0;
                    $i = 1;
                    foreach ($revenues as $revenue) {
                        $total_fee = $revenue->sum;
                        $allsum_revenue = $allsum_revenue + $total_fee;
                        ?>
                    <tr>
                        <td data-title="<?= $data->lang->line('slno') ?>"> {{ $i++ }} </td>
                        <td data-title="<?= $revenue->name ?>">
                            <?php echo ucfirst($revenue->name) ?>
                        </td>
                        <td data-title="<?= $revenue->name ?>">
                            <?php echo money($revenue->sum) ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td></td>
                        <th> <b> Total Revenues</b> </th>
                        <th> <b> <?php echo money($allsum_revenue) ?></b> </th>
                    </tr>
                <?php } ?>


                   <tr>
                        <th class="info" colspan="3"> <b> School Expenses</b> </th>
                    </tr>
                   
                    <?php
                if(isset($expenses) && count($expenses) > 0){

                    $all_expenses = 0;
                    $i = 1;
                    foreach ($expenses as $expense) {
                        $total_fee = $expense->sum;
                        $all_expenses = $all_expenses + $total_fee;
                        ?>
                    <tr>
                        <td data-title="<?= $data->lang->line('slno') ?>"> {{ $i++ }} </td>
                        <td data-title="<?= $expense->name ?>">
                            <?php echo ucfirst($expense->name) ?>
                        </td>
                        <td data-title="<?= $expense->name ?>">
                            <?php echo money($expense->sum) ?>
                        </td>
                    </tr>
                  
                    <?php } ?>
                    <tr>
                        <td></td>
                        <th> <b> Total Expenses</b> </th>
                        <th> <b> <?php echo money($all_expenses) ?></b> </th>
                    </tr>
                <?php }else {?>

                            <div class="alert alert-info" role="alert">
                                There is no Fee Payments 
                            </div>

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
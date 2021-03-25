<?php 
$usertype = session("usertype");
if (can_access('view_income_statement')) {
    $status=1;
    ?>
    <div class="well">
        <div class="row">

            <div class="col-sm-6" style="elevation: above; z-index: 10;">
                <button class="btn-cs btn-sm-cs"  onclick="javascript:printDiv('printablediv')"><span class="fa fa-print"></span> <?= $data->lang->line('print') ?> </button>
              

            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
                    <li><a href="<?= base_url("expense/financial_index/1") ?>">Reports</a></li>
                    <li class="active">Income Statement</li>
                </ol>
            </div>
        </div>
    </div>

    <div id="printablediv" style="margin-top: -20%">

        <section class=" invoice" >
            <!-- title row -->
            <div class="row">
                <div class="col-xs-1"></div>
                <div class="col-xs-11">
                    <h2 class="page-header">
                        <?php
                        $array = array(
                            "src" => base_url('storage/uploads/images/' . $siteinfos->photo),
                            'width' => '25px',
                            'height' => '25px',
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
                    <b>INCOME STATEMENT</b><br>
                    Period:<?php echo date("d M Y", strtotime($from_date)) . '<br/>' ?>to &nbsp <?php echo date("d M Y", strtotime($to_date)) . '<br/>' ?>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- Table row -->
            <br />
            <div class="row" style="margin: 2%">
                <div id="hide-table">
                    
                    
                    <?php if($status==1){?>
                        
                    <table  class="table table-bordered " >
                        <thead>
                            <tr>
                                <th class="col-sm-4">ACCOUNT</th>
                                <th class="col-sm-4">  </th>
                                <th class="col-sm-4">AMOUNT(<?=$siteinfos->currency_symbol?>)</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            echo '<tr  class="info"><td><b>Revenue</b></td><td> </td><td></td></tr>';
                            $sum_revenue = 0;
                            foreach ($fees as $fee) {
                                $total_fee = isset($fee_total[$fee->id][0]['total']) ? $fee_total[$fee->id][0]['total'] : NULL;
                                $sum_revenue = $sum_revenue + $total_fee;
                                ?>
                                <tr>

                                    <td data-title="<?= $fee->name ?>">
                                        <?php echo ucfirst($fee->name) ?>
                                    </td>
                                    <td data-title="<?= $data->lang->line('slno') ?>">			
                                    </td>				   
                                    <td data-title="Total" >
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
<?php


                            if(!empty($express_revenues)){
    $express_revenue_total=0;

    foreach ($express_revenues_grouped as $express_revenue ) {  
        $express_revenue_total=$express_revenue_total+$express_revenue->total;
                            ?>
                            <tr>

                                <td data-title="<?= $express_revenue->name ?>">
                                    <?php echo ucfirst($express_revenue->name) ?>
                                </td>
                                <td data-title="<?= $data->lang->line('slno') ?>">
                                </td>
                                <td data-title="Total" >
                                    <?php

                                        echo money($express_revenue->total);

                                    ?>
                                </td>
                            </tr>

    <?php
    }
                     $sum_revenue=$sum_revenue + $express_revenue_total;
                            }   ?>

                            <tr><td>Total Revenue</td> <td></td><td><?= money($sum_revenue) ?></td></tr>


                            <?php
                            echo '<tr  class="info"><td>Operational Expense</td><td> </td><td></td></tr>';
                            $sum_operational = 0;
                            foreach ($expense_operational_grouped as $value) {
                                $opex = isset($unique_opex_grouped[$value->account_group_id][0]['total']) ? $unique_opex_grouped[$value->account_group_id][0]['total'] : null;
                                $sum_operational = $sum_operational + $opex;
                                ?>                            
                                <tr>
                                    <td data-title="<?= $value->name ?>">
                                        <?php echo $value->name ?>
                                    </td>
                                    <td data-title="<?= $data->lang->line('slno') ?>">			
                                    </td>				   
                                    <td data-title="amount">
                                        <?php echo money($opex); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr><td>Total Operational Expense</td> <td></td><td><?= money($sum_operational) ?></td></tr>

                        <tbody> 
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Operating Income</b></td>
                                <td></td>
                                <td>&nbsp<?= money($sum_revenue - $sum_operational); ?></td>
                            </tr>
                        </tbody>                                          
                        <?php
                        $sum_depreciation = 0;
                        foreach ($expense_fixedasset_grouped as $fixed_asset) {

                            $dep = isset($depreciation_grouped[$fixed_asset->account_group_id][0]['deprec']) ? $depreciation_grouped[$fixed_asset->account_group_id][0]['deprec'] : 0;
                            
                            $deprec_open_balance=isset($depreciation_grouped[$fixed_asset->account_group_id][0]['deprec_open_balance']) ? $depreciation_grouped[$fixed_asset->account_group_id][0]['deprec_open_balance']:0;

                            $sum_depreciation = $sum_depreciation + $dep + $deprec_open_balance;
                           
                        }
                        ?>
                        
                        <?php
                          echo '<tr  class="info"><td> General & administrative Expenses</td><td> </td><td></td></tr>';
                          $sum_general = 0;
                      
                          foreach ($expense_general_grouped as $value) {
                            $ga_total = $value->sum;

                            $sum_general = $sum_general + $ga_total;
                            ?>                            
                            <tr>
                                <td data-title="<?= $value->name ?>">
                                    <?php echo $value->name ?>
                                </td>
                                <td data-title="<?= $data->lang->line('slno') ?>">			
                                </td>				   
                                <td data-title="<?= $ga_total ?>">
                                    <?php echo money($ga_total); ?>
                                </td>
                            </tr>
                           <?php } 
                        
                        ?>
			    
                        <tr><td>Depreciation</td><td> </td><td><?= money($sum_depreciation) ?></td></tr> 
                        <tr><td>Total General & administrative Expenses</td> <td></td><td><?= money($sum_general + $sum_depreciation) ?></td></tr>
                        <tr><td></td><td> </td><td></td></tr>  
                       
                        <tr><td><b>Profit/(Loss)</b></td><td></td><td><?= money($sum_revenue - ($sum_general + $sum_operational + $sum_depreciation)); ?></td></tr>

                        </tbody>
                    </table>
                   
                        
                    <?php } else {?>
                      
                  <div class="alert alert-info" role="alert">
  This Part is Going through upgrades for now,Kindly be patient
</div>    
                    
                   <?php } ?>
                    
                </div>




            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>


    <!-- email modal starts here -->
    <form class="form-horizontal" role="form" action="<?= base_url('teacher/send_mail'); ?>" method="post">
        <div class="modal fade" id="mail">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><?= $data->lang->line('mail') ?></h4>
                    </div>
                    <div class="modal-body">

                        <?php
                        if (form_error($errors, 'to'))
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
                    if (form_error($errors, 'subject'))
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
                if (form_error($errors, 'message'))
                    echo "<div class='form-group has-error' >";
                else
                    echo "<div class='form-group' >";
                ?>
                <label for="message" class="col-sm-2 control-label">
                    <?= $data->lang->line("message") ?>
                </label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="message" name="message" style="resize: vertical;" value="<?= old('message') ?>" ></textarea>
                </div>
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?= $data->lang->line('close') ?></button>
            <!--<input type="button" id="send_pdf" class="btn btn-success" value="<?= $data->lang->line("send") ?>" />-->
        </div>
    </div>
    </div>
    </div>
    <?= csrf_field() ?>
    </form>
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
                $('#example1_info').hide();
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
    <?php
}else {
    echo 'You have no permission to view this page';
}
?>

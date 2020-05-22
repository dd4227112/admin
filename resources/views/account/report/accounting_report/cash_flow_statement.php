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
                    <li class="active">CASH FLOW STATEMENT</li>
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
                    <b> CASH FLOW STATEMENT </b><br>
                    Period:<?php echo date("d M Y", strtotime($from_date)) . '<br/>' ?>to &nbsp <?php echo date("d M Y", strtotime($to_date)) . '<br/>' ?>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- Table row -->
            <br />
            <div class="row" style="margin: 2%">
                <div id="hide-table">
                    
             <?php if($status==1){?>
                 
           
                    
                    <table  class="table" >
                        <thead>
                        <tr>
                            <th class="col-sm-4">ACCOUNT</th>
                            <th class="col-sm-4">  </th>
                            <th class="col-sm-4">AMOUNT(<?=$siteinfos->currency_symbol?>)</th>
                        </tr>


                        </thead>
                        <tbody>

                        <?php
                        echo '<tr  class="info"><td><b>Operating Activities</b></td><td> </td><td></td></tr>';



                            ?>

                            <tr>

                                <td data-title="Net Income">
                                   Net Income
                                </td>
                                <td data-title="<?= $data->lang->line('slno') ?>">
                                </td>
                                <td data-title="Total" >
                                    <?php
                                   
 $income=($fee_total + $total_express_revenues)- ($total_expense_operational + $total_expense_fixedasset + $total_expense_general);
                                    echo accounting_money($income);
                                    ?>
                                </td>
                            </tr>


                                <tr>

                            <td data-title="depreciation">
                                Depreciation
                            </td>
                            <td data-title="<?= $data->lang->line('slno') ?>">
                            </td>
                            <td data-title="Total" >
                                <?php
                                echo accounting_money($total_expense_fixedasset);

                                ?>
                            </td>
                        </tr>
                        <tr>

                            <td data-title="depreciation">
                              Account Receivable
                            </td>
                            <td data-title="<?= $data->lang->line('slno') ?>">
                            </td>
                            <td data-title="Total">
                                <?php
$receivable=$fee_total-$paid_fee_total;
echo accounting_money($receivable);

         ?>
                            </td>
                        </tr>

                        <!--<tr><td>Account Payable</td> <td></td><td><?/*= money($liability_total);*/?></td></tr>-->

                        <tr><td><b> Cash <?php

     $a= $income+$total_expense_fixedasset-$receivable ;

                                    if(($a)>0) {
					
                            echo 'In';
			    			    
                                    } 
				    
				    else {					
					echo 'Out';
				    
				    } 
				    ?>
                                    Flow from Operating activities</b></td> <td></td><td><?php
                                echo accounting_money($a); ?></td></tr>
                          <?php
                        echo '<tr  class="info"><td><b>Investing Activities</b></td><td> </td><td></td></tr>';
                        $sum_fixedasset = 0;
                        $i = 0;
                        //print_r($expense_fixedasset);exit;
                        foreach ($expense_fixedasset_grouped as $fixed_asset) {
                            $fa_total = isset($depreciation_grouped[$fixed_asset->account_group_id][0]['total']) ? $depreciation_grouped[$fixed_asset->account_group_id][0]['total'] : null;


                            $sum_fixedasset = $sum_fixedasset + $fa_total;
                            ?>
                            <tr>
                                <td data-title="<?= $fixed_asset->name ?>">
                                    <?php echo 'Acquire '.ucfirst($fixed_asset->name) ?>
                                </td>
                                <td data-title="<?= $data->lang->line('slno') ?>">
                                </td>
                                <td data-title="Total" >
                                    <?php echo'('.money(round($fa_total, 2)).')' ?>
                                </td>
                            </tr>
                        <?php } ?>

                        <tr><td><b>Cash  <?php
                                  $b= $sum_fixedasset;
                                    $b_sum= $sum_fixedasset*-1;
                                    if(($b_sum)>0){
                                        echo 'In';
                                    } else {
                                        echo 'Out';
                                    } ?>
                                    Flow from Investing activities</b></td> <td></td><td><?php
                                if($b_sum<0){
                                    echo '('.money($b_sum*-1).')' ;
                                    $b=$b_sum;
                                }else {
                                    echo money($b_sum);
                                } ?></td></tr>




                        <?php
                        echo '<tr  class="info"><td><b>Financing Activities</b></td><td> </td><td></td></tr>';


                        $sum_liabilities=0;
                        foreach ($expense_liabilities_grouped as $liability) {
                            $li_total = isset($unique_opex_grouped[$liability->account_group_id][0]['total']) ? $unique_opex_grouped[$liability->account_group_id][0]['total'] : null;

                            $sum_liabilities=$sum_liabilities+$li_total;
                            ?>
                            <tr>
                                <td data-title="<?= $liability->name ?>">
                                    <?php echo $liability->name ?>
                                </td>
                                <td data-title="<?= $data->lang->line('slno') ?>">
                                </td>
                                <td data-title="<?= $li_total ?>">&nbsp;
                                    <?php echo money($li_total); ?>
                                </td>
                            </tr>
                        <?php }
				
			
                        $sum_equity=0;
                        foreach ($expense_equity_grouped as $value1) {
			
                            $capital_total = isset($unique_opex_grouped[$value1->account_group_id][0]['total']) ? $unique_opex_grouped[$value1->account_group_id][0]['total'] : null;
                            $sum_equity=$sum_equity+$capital_total;
                            ?>
                            <tr>
                                <td data-title="<?= $value1->name ?>">
                                    <?php echo $value1->name ?>
                                </td>
                                <td data-title="<?= $data->lang->line('slno') ?>">
                                </td>
                                <td data-title="<?= $value1->name ?>">&nbsp;
                                    <?php echo accounting_money($capital_total); ?>
                                </td>
                            </tr>
                        <?php }  ?>

                        <tr ><td><b>Cash  <?php

                                $c=$sum_liabilities+$sum_equity;


                                    if(($sum_liabilities)>0){
                                        echo 'In';
                                    }else{ echo 'Out';} ?>
                                    Flow from Financing activities</b></td> <td></td><td><?php
                                echo accounting_money($c); ?></td></tr>
                        <tr><td></td><td></td><td></td><td></td></tr>

                        <tr class="warning"><td><b>Cash  <?php

                                    $d=$a+$b+$c;


                                    if(($d)>0){
                                        echo 'Increase';
                                    } else { echo 'Decrease';} ?>
                                    of Cash and Cash equivalent</b></td> <td></td><td><?php
                                echo accounting_money($d); ?></td></tr><tr><td></td><td></td><td></td><td></td></tr>
                        <tr class="danger"><td><i><b>Balance at   <?php echo date("d M Y", strtotime($from_date)); ?>
                                   </b></i></td> <td></td><td><?php
                                echo accounting_money($balance_at); ?></td></tr><tr><td></td><td></td><td></td><td></td></tr>

                        <tr class="success"><td><i><b>Cash and Cash equivalent at  <?php echo date("d M Y", strtotime($to_date)); ?>
                                       </b></i></td> <td></td><td><?php
                                echo accounting_money($balance_at+$d);
                               ?></td></tr>


                        </tbody>
                    </table>       
                 
            <?php } else{?>
       
        <div class="alert alert-info" role="alert">
  This Part is Going through upgrades for now, kindly be patient
</div>           
                 
           <?php  }?>       
                    
                   

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

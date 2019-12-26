
<?php 
$usertype = session("usertype");
if (can_access('view_balance_sheet')) {
    ?>
    <?php if (can_access('view_balance_sheet')) { ?>
        <div class="well">
            <div class="row">

                <div class="col-sm-6">
                    <button class="btn-cs btn-sm-cs" onclick="javascript:printDiv('printablediv')"><span class="fa fa-print"></span> <?= $data->lang->line('print') ?> </button>

                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
                        <li><a href="<?= base_url("expense/financial_index/2") ?>">Reports</a></li>
                        <li class="active">Balance Sheet</li>
                    </ol>
                </div>
            </div>
        </div>
    <?php } ?>
    <div id="printablediv">



        <section class="content invoice" >
            <!-- title row -->
            <div class="row">
                <div class="col-xs-1"></div>
                <div class="col-xs-11">
                    <h2 class="page-header">
                        <?php

                        if ($siteinfos->photo) {
                            $array = array(
                                "src" => base_url('storage/uploads/images/' . $siteinfos->photo),
                                'width' => '25px',
                                'height' => '25px',
                                'class' => 'img-circle'
                            );
                            echo img($array);
                        }
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
                    <b>Trial Balance</b><br>
                    As at:<?php echo date("d M Y", strtotime($to_date)) . '<br/>'; ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- Table row -->
            <br />
            <div class="row" style="margin-left: 3%">
                <div class="col-xs-12" id="hide-table">                    
                    <table class=" table">
                        <thead>                            
                            <tr>
                                <th class="col-lg-4"></th>
                                <th class="col-lg-4">  </th>
                                <th class="col-lg-4"></th>
                            </tr>       


                        </thead>
                        
                    </table>

  <!--Table-->
  <table class="table  table-bordered">

    <!--Table head-->
    <thead>
      <tr>
        
        <th class="th-sm">Account Name</th>
        <th class="th-sm">Debit</th>
        <th class="th-sm">Credit</th>
      </tr>
    </thead>
    <!--Table head-->

    <!--Table body-->
    <tbody>
        
         <?php
                            
                   
                            $sum_liability = 0;
                            $sum_receivable = 0;
                            $sum_paid = 0;
                            $sum_equity = 0;
			 

                            
                            ?>
        
<!--        FIXED ASSETS-->
        <?php
     $sum_fixedasset = 0;
                            $i = 0;
                            $total_depreciation = 0;
                            $total_no_depreciation = 0;
                            $sum_depreciation=0;
                           
                            foreach ($expense_fixedasset_grouped as $fixed_asset) {
                               
                                $fa_total = isset($net_depreciation_grouped[$fixed_asset->account_group_id][0]['total']) ? $net_depreciation_grouped[$fixed_asset->account_group_id][0]['total'] + $net_depreciation_grouped[$fixed_asset->account_group_id][0]['open_balance'] : 0;

			
                                $no_depreciation = isset($unique_opex_grouped[$fixed_asset->account_group_id][0]['total']) ? $unique_opex_grouped[$fixed_asset->account_group_id][0]['total'] : 0;


                                $depreciation_total = isset($depreciation_grouped[$fixed_asset->account_group_id][0]['deprec']) ? $depreciation_grouped[$fixed_asset->account_group_id][0]['deprec'] : 0;

 $open_balance= isset($net_depreciation_grouped[$fixed_asset->account_group_id][0]['open_balance']) ? $net_depreciation_grouped[$fixed_asset->account_group_id][0]['open_balance']:0;
 
 $deprec_open_balance=isset($net_depreciation_grouped[$fixed_asset->account_group_id][0]['deprec_open_balance']) ? $net_depreciation_grouped[$fixed_asset->account_group_id][0]['deprec_open_balance']:0;
 
 
                                $sum_fixedasset = $sum_fixedasset + $fa_total;
                                $sum_no_depreciation =  $no_depreciation + $open_balance;
                                $total_no_depreciation=$total_no_depreciation + $sum_no_depreciation;
                                
                                $sum_depreciation = $sum_depreciation+$depreciation_total + $deprec_open_balance;
                                $total_depreciation=$sum_depreciation + $total_depreciation;
                                ?>                            
                                <tr>
                                    <td data-title="<?= $fixed_asset->name ?>">
                                <?php echo ucfirst($fixed_asset->name) ?>
                                    </td>
                                    				   
                                    <td data-title="Total" >
        <?= accounting_money(round($sum_no_depreciation , 2))?>
                                    </td>
                                    <td data-title="<?= $data->lang->line('slno') ?>">			
                                    </td>
                                </tr>
                                    <?php } ?>
                            <?php
                            if($sum_depreciation>0) {
                                ?>
                               <tr><td>Accumulated Depreciation</td><td></td> <td><?= accounting_money(-$total_depreciation) ?></td></tr>     
                                
                            <?php } ?>    
                                
<!--                            
        
<!--        CURRENT ASSETS-->

         <?php
    $curr_total=0;
    
    
                            foreach ($current_asset as $curr_asset) {                           
                                $total = $curr_asset->open_balance;
                                

                                 if(strtoupper($curr_asset->name)== 'CASH') {
                                     
                             $total=$total + $cash;
                             
                              $curr_total=$curr_total+$total;
                              
                             } elseif (strtoupper($curr_asset->name)== 'ACCOUNT RECEIVABLE') {
                              
                                  $total=$total + $total_receivable ;
                                 $curr_total=$curr_total+$total;
                             
                         } 
                    elseif (strtoupper($curr_asset->name)== 'BANKS') {
                   
                    $curr_total= $curr_total + $bank;
                             
                         }     
                         
                         else {
                                 
                        $curr_total=$curr_total + $total;
                        
                             }
                             
                             ?>                            
                                <tr>
                                    <td data-title="<?= $curr_asset->name ?>">
        <?php echo $curr_asset->name ?>
                                    </td>
                                   				   
                                    <td data-title="Total">&nbsp;
                                <?php
                             if (strtoupper($curr_asset->name)== 'BANKS') {
                                 
                              echo accounting_money($bank);    
                                 
                             } else {
                                 
                              echo accounting_money($total);      
                             }  
                                
                              
                                ?>
                                    </td> <td data-title="<?= $data->lang->line('slno') ?>">			
                                    </td>
                                </tr>
                            <?php } ?> 
    

                            <?php
                          
                       $asset_total = $curr_total; ?>

                                
                                
  <!--     REVENUE                           -->
    <?php
                                
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


                            if(count($express_revenues_grouped)>0){
    $total_express_revenue=0;
    foreach ($express_revenues_grouped as $express_revenue ) {  
        $total_express_revenue=$total_express_revenue + $express_revenue->total;
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
   
                     $sum_revenue=$sum_revenue + $total_express_revenue;
                            }   ?>


                 
                                
                                     
                                
                                
                                
                                
                                
                                
<!--          LIABILITIES                      -->

     <?php
                          
                             $sum_liabilities=0; 
                            foreach ($expense_liabilities_grouped as $liability) {
                                $li_total = isset($unique_opex_grouped[$liability->account_group_id][0]['total']) ? $unique_opex_grouped[$liability->account_group_id][0]['total']+ $liability->open_balance : 0;

                                $sum_liabilities=$sum_liabilities+$li_total;
                                ?>                            
                                <tr>
                                    
                                    <td data-title="<?= $liability->name ?>">
        <?php echo $liability->name ?>
                                    </td>
                                   
                              <td data-title="<?= $data->lang->line('slno') ?>">			
                                    </td>       
                                   
                                   <td data-title="<?= $li_total ?>">&nbsp;
                                <?php if(strtoupper($liability->name)=='UNEARNED REVENUE'){
                                 echo accounting_money($li_total + $unearned);   
                                } else {
                                    
                                  echo accounting_money($li_total);   
                                }
                                ?>
                                    </td>
                                    
                                     
                                   
                                </tr>
                            <?php } ?>
                                
                                <?php
                              if($unearned>0) {
                             $sum_liabilities=$sum_liabilities + $unearned;     
                                  ?>                                            
                                  
                             <?php } ?>
<!--                                             -->
                            
  
<!--  EXPENSES                              -->
<?php

 $sum_depreciation = 0;
                        foreach ($expense_fixedasset_grouped as $fixed_asset) {

                            $dep = isset($depreciation_grouped[$fixed_asset->account_group_id][0]['deprec']) ? $depreciation_grouped[$fixed_asset->account_group_id][0]['deprec'] : 0;
                            
                            $deprec_open_balance=isset($depreciation_grouped[$fixed_asset->account_group_id][0]['deprec_open_balance']) ? $depreciation_grouped[$fixed_asset->account_group_id][0]['deprec_open_balance']:0;

                            $sum_depreciation = $sum_depreciation + $dep + $deprec_open_balance;
                           
                        }
                        ?>                               
                <tr><td>Total Operational Expense</td> <td><?= money($total_opex) ?></td><td></td></tr>                               
          <tr><td>Total General & administrative Expenses</td> <td><?= money($total_general_admin + $sum_depreciation) ?></td><td></td></tr>                             
                                
                                
                                
                                
                                
   <?php
                           
                            $retained=0;
                            foreach ($expense_equity_grouped as $value1) {
                                $capital_total = isset($unique_opex_grouped[$value1->account_group_id][0]['total']) ? $unique_opex_grouped[$value1->account_group_id][0]['total']+$value1->open_balance : null;
                                $sum_equity=$sum_equity + $capital_total;
                                ?>                            
                                <tr>
                                    <td data-title="<?= $value1->name ?>">
                                <?php echo $value1->name ?>
                                    </td>
                                   <td data-title="<?= $data->lang->line('slno') ?>">                                      
                                    </td>				   
                                    <td data-title="<?= $value1->name ?>">&nbsp;
                                
                            <?php 
                                
                            if(strtoupper($value1->name)=='RETAINED EARNINGS') {
                               
                                 $retained = $retained + $express_revenue_total->total + $sum_receivable + $sum_paid - ($g_expenses->total);
                                    echo accounting_money($retained + $capital_total);
                                } else {
                                    
                                echo accounting_money($capital_total); 
                                
                                }    
                                
                               ?>
                                    </td> 
                                </tr>
                            <?php } ?>
                 
                                                         
                         
                                
                                
      <tr class="table-info">
       
        <td class="table-info">Total</td>
        <td class="table-info"><?= accounting_money($total_no_depreciation + $asset_total+$total_opex+ $total_general_admin + $sum_depreciation-$total_depreciation) ?></td>
        <td class="table-info"><?= accounting_money($total_depreciation+$sum_revenue+$sum_liabilities+$sum_equity+$retained) ?></td>
      </tr>
    </tbody>
    <!--Table body-->
  </table>
  <!--Table-->
                </div>
                   
                
</div>

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
        function printDiv(divID) {
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
<?php }
?>

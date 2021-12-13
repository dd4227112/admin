@extends('layouts.app')
@section('content')

    
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4><?= $type ?> </h4>
  
            </div>
             <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Reports</a>
                    </li>
                </ul>
            </div> 
        </div>
        <div class="page-body">
            <div class="col-sm-12 tile-stats flipInY">
                <form style="" class="form-horizontal list-group-item list-group-item-warning" role="form" method="post"> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12"><?= __('Start date') ?></label>
                            <div class="col-xs-12">
                                <input type="date" required="true" class="form-control calendar" id="from_date" name="from_date" value="" autocomplete="off">
                            </div>
                        </div>
                    </div>
    
    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12"><?= __('End date') ?></label>
                            <div class="col-xs-12">
                                <input type="date" required="true" class="form-control calendar" id="to_date" name="to_date" value="">
                            </div>
                        </div>
                    </div>                     
    
    
                    <div class="col-md-3">
                        <div class='form-group' >
                            <label for="class_level_id" class="control-label col-md-5 col-sm-5 col-xs-12">
                                <?= __('Type') ?>
                            </label>
                            <div class="col-xs-12">
                                <?php
                                $array = array("0" => __("type"));
                                $array['1'] = 'Expenses';
                                $array['2'] = 'Payments';
                                $array['3'] = 'Revenue';
    
                                echo form_dropdown("report_type", $array, old("report_type"), "id='class_level_id' class='form-control'");
                                ?>
                            </div>
                            <span class="col-sm-4 col-xs-12 control-label">
                                <?php echo form_error($errors, 'classlevel'); ?>
                            </span>
                        </div> 
                    </div>
    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="class_level_id" class="control-label col-md-3 col-sm-3 col-xs-12">
                                <br/>
                            </label>
                            <div class="col-xs-12">
                                <br/> <?= csrf_field() ?>
                                <input type="submit" class="btn btn-success" value="Submit">
                            </div>
                        </div>
                    </div> 
                </form>
            </div> 

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
            
                        <div class="x_content">
                            <div class="col-sm-6 col-xs-12 col-sm-offset-3 list-group">
                                <div class="list-group-item">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><?= ("start_date") ?></th>
                                                <th><?= ("end_date") ?></th>
                                                <th><?= ("type") ?></th>
            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
            
                                                <td><?= $from ?></td>
                                                <td><?= $to ?></td>
                                                <td><?= $type ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="nav-tabs-custom">
            
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#all" aria-expanded="true"><?= ($type) ?></a></li>
            
                                        <li class="">
                                            <a data-toggle="tab" href="#summary" ><?= ("Summary") ?> </a></li>       
                                    </ul>
            
                                    <div class="tab-content">
                                        <div id="hide-table"  class="card-block">
                                            <div class="table-responsive table-sm table-striped table-bordered table-hover">
                                                <table id="example1" class="table dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th><?= ('slno') ?></th>
                                                            <th><?= ('name') ?></th>
                                                            <th><?= ('category') ?></th>
                                                            <th><?= ('date') ?></th>
                                                            <th><?= ('payment_method') ?></th>
                                                            <?php if($type == 'Expense'){ ?>
                                                                <th>Voucher No</th>
                                                         <?php   }else{ ?>
                                                            <th>Receipt No</th>
                                                        <?php } ?>
                                                            <th><?= ('amount') ?></th>
                                                            <th><?= ('bank') ?></th>
                                                            <th><?= ('transaction_id') ?></th>
                                                            <th><?= ('recorded_by') ?></th>         
                                                            <th><?= ('date_recorded') ?></th>
                                                            <th class=""><?= ('action') ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total_amount = 0;
                                                        $full_paid = 0;
                                                        $all_ids = '';
                                                        if (isset($transactions) && !empty($transactions)) {
                                                            $i = 1;
                                                            foreach ($transactions as $transaction) {
                                                                ?>
                                                                <tr>
                                                                    <td data-title="<?= ('slno') ?>">
                                                                        <?php echo $i; ?>
                                                                    </td>
                                                                    <td data-title="<?= ('invoice_student') ?>">
                                                                        <?php
                                                                        if ($report_type == 1) {
                                                                            echo $transaction->expense;
                                                                        } else if ($report_type == 2) {
                                                                            echo $transaction->invoice->title;
                                                                        } else if ($report_type == 3) {
                                                                            echo '';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td data-title="<?= ('invoice_roll') ?>">
                                                                        <?php echo $report_type == 2 ? 'Invoice Payments' : $transaction->referExpense->name ?>
                                                                    </td>
            
                                                                    <td data-title="<?= ('invoice_number') ?>">
                                                                        <?php echo date('d M Y', strtotime($report_type == 3 ? $transaction->date : $transaction->date)); ?>
                                                                    </td>

                                                                    <td data-title="<?= ('invoice_amount') ?>">
                                                                        <?php
                                                                        echo $report_type == 2 ? $transaction->paymentType->name :
                                                                                $transaction->payment_method;
                                                                        ?>
                                                                    </td>

                                                                    <td data-title="<?= ('invoice_amount') ?>">
                                                                        <?php 
                                                                        echo $transaction->voucher_no;
                                                                        ?>
                                                                    </td>
      
                                   

                                                                    <td data-title="<?= ('paid_invoice_amount') ?>">
                                                                        <?php
                                                                        $am = $transaction->amount;
                                                                        $total_amount += $am;
                                                                        echo money($am);
                                                                        ?>
                                                                    </td>
                                                                    <td data-title="<?= ('unpaid_amount') ?>">
                                                                        <?php
                                                                          echo 'bank';
                                                                        ?>
                                                                    </td>

                                                                    <td data-title="<?= ('invoice_status') ?>">
                                                                        <?php
                                                                        echo $transaction->transaction_id;
                                                                        ?>
                                                                    </td>
            
            
                                                                    <td data-title="<?= ('action') ?>">
                                                                        <?php
                                                                        if ($report_type <> 2) {
                                                                            $user = DB::table('users')->where('id', $transaction->user_id)->first();
                                                                            echo   $transaction->payer_name;
                                                                        }
                                                                        ?>
                                                                    </td>

                                                                    <td><?php
                                                                        echo date('d M Y h:m', strtotime($transaction->created_at));
                                                                        ?>
                                                                    </td>

                                                                    <?php if($type == 'Expense'){ ?>
                                                                    <td>
                                                                        <?php echo '<a class="btn btn-sm btn-info" href="'.url('account/expense/voucher/' . $transaction->id .'/'. 'Payment Voucher').'">Voucher</a>'; ?>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($type == 'Revenues'){ 
                                                                        echo '<td><a href="' . url('account/expense/voucher/' . $transaction->id . '/') . '" class="btn btn-primary btn-sm">Receipt</a></td>';
                                                                        
                                                                         } ?>
                                                                         <?php if($type == 'Payments'){ 
                                                                            if($transaction->id){
                                                                        echo '<td><a href="' . url('invoices/current_receipt/'.$transaction->id) . '" class="btn btn-info btn-sm">Receipt</a></td>';
                                                                        }else{
                                                                           echo '<td>-</td>';
                                                                        }
                                                                } ?>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6">Total</td>
                                                            <td><?= money($total_amount) ?></td>
                                                            <td colspan="5"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
            
                                            </div>
                                        </div>
                                        <div id="summary" class="tab-pane">
            
                                            <?=('Summary')?>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th> <?=('total_amount')?></th>
            
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= money($total_amount) ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                            
            
            
            
                                            <div class="row">
                                             
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div class="x_panel">
                                                                <div class="x_title">
                                                                    <h2><?=('tra_month')?></h2>
            
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                               
                                                                    <?php
                                                                    //$insight = new \App\Http\Controllers\Insight();
                                                                    //$sql_ = 'select sum(amount) as count, to_char(date,\'Mon\')  as month from '.strtolower($type).' where date between \''.$from.'\' and \''.$to.'\' group by to_char(date,\'Mon\') order by EXTRACT(MONTH FROM to_date(to_char(date,\'Mon\'), \'Mon\'))';
                                                                   // echo  $insight->createChartBySql($sql_, 'month', 'Overall Transactions', 'line', false);
                                                                    ?>
            
                                                            </div>
                                                        </div>
            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>

<script>

    $(".mark").blur(function (event) {
        var new_id = $(this).text();
         var payment_id = $(this).attr('payment_id');
         var student_id = $(this).attr('student_id');
             $.ajax({
                 type: 'POST',
                 url: "<?= url('fee_detail/edit_receipt') ?>",
                 data: {
                     "payment_id": payment_id,
                     "student_id": student_id,
                     "new_id": new_id
                 },
                 dataType: "html ",
                 beforeSend: function (xhr) {
                     //jQuery('#loader-content').show();
                     $('#' + payment_id + student_id).html('<a href="#/refresh"><i class="fa fa-spinner"></i> </a>');
                 },
                 complete: function (xhr, status) {
                     //jQuery('#loader-content').fadeOut('slow');
                         $('#' + payment_id + student_id).html('<span class="label label-success">' + status + '</span>');
                 },
 
                 success: function (data) {
                     toast(data);
                 }
             });
     });
 </script>
@endsection
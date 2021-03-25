@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Revenues</h4>
                <span>Show revenue summary</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Revenues</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <!-- form start -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                
                                     <div class="row" style="margin-bottom: 30px">
                                        <div class="col-sm-10 col-sm-offset-3 list-group">
                                            <div class="list-group-item list-group-item-warning">
                                                <form style="" class="form-horizontal" role="form" method="post">
                                                    <div class="form-group">
                                                        <label for="bank_account_id" class="col-sm-4 col-sm-offset-2 control-label">
                                                            Bank Name
                                                        </label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            $array = array("" => ("bank_account"));
                                                            $array["0"] = 'All';
                                                            foreach ($banks as $bank) {
                                                                $array[$bank->id] = $bank->referBank->name . ' (' . $bank->number . ')';
                                                            }
                                                            echo form_dropdown("bank_account_id", $array, old("bank_account_id"), "id='bank_account_id' class='form-control'");
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="from" class="col-sm-2 col-sm-offset-2 control-label">
                                                            From
                                                        </label>
                                                        <div class="col-sm-10">
                                                            <input type="date" name="from" id="from" class='form-control'/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="to" class="col-sm-2 col-sm-offset-2 control-label">
                                                            To
                                                        </label>
                                                        <div class="col-sm-10">
                                                            <input type="date" name="to" id="to"  class='form-control'/>
                                                        </div>
                                                    </div>
                                                    <div class='form-group' >
                                                        <label for="method" class="col-sm-6 col-sm-offset-2 control-label">
                                                            Payment Method  <span class="red">*</span>
                                                        </label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            echo form_dropdown("method", array('' => '', 'All' => ('All'), 'received' => ('received'), 'expense' => 'Expense'), old("sex"), "id='sex' class='form-control'");
                                                            ?>
                                                        </div>
                                                        <span class="col-sm-6 col-xs-12 control-label">
                                                            <?php echo form_error($errors, 'sex'); ?>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-4 col-sm-6 col-xs-12">
                                                            <input type="submit" class="btn btn-success btn-block" style="margin-bottom:0px" value="<?= ("view") ?>" >
                                                        </div>
                                                    </div>
                                                    <?= csrf_field() ?>
                                                </form>
                                            </div>
                                            <div class="">
                                                <div class="list-group-item">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th><?= ("bank_name") ?></th>
                                                                <th><?= ("dates") ?></th>
                                                                <th><?= ("payment_method") ?></th>
                                                                <th><?= ("transactions") ?></th>
                        
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                        
                                                                <td><?php
                                                                    if (isset($bank_id)) {
                                                                        if ((int) $bank_id == 0) {
                                                                            echo 'All';
                                                                        } else {
                                                                            echo $bank_info->referBank->name . '(' . $bank_info->number . ')';
                                                                        }
                                                                    }
                                                                    ?></td>
                        
                                                                <td><?= 'From: <b>' . request('from') . '</b> - to - <b>' . request('to') . '</b>' ?></td>
                                                                <td><?= request('method') ?></td>
                                                                <td><?= count($payments) ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                           
                                     
                                     
                                     <div class="table-responsive dt-responsive"> 
                                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-2"><?= ('slno') ?></th>
                                                    <th class="col-sm-2"><?= ('bank_name') ?></th>
                                                    <th class="col-sm-2"><?= ('bank_account') ?></th>
                                                    <th class="col-sm-2"><?= ('transaction_id') ?></th>
                                                    <th class="col-sm-2"><?= ('transaction_date') ?></th>
                                                    <th class="col-sm-2"><?= ('invoice_amount') ?></th>
                                                    <th class="col-sm-2"><?= ('note') ?></th>
                                                    <th class="col-sm-2"><?= ('type') ?></th>
                                                    <th class="col-sm-2"><?= ('status') ?></th>
                                                    <th class="col-sm-2"><?= ('action') ?></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            <?php
                                            $total_payments = 0;
                                            $amount_reconciled = 0;
                                            $bank_amount = [];
                                            $bank_amount_reconciled = [];
                                            $bank_amount_not_reconciled = [];
                                            foreach ($banks as $bank) {
                                                $bank_amount[$bank->id] = 0;
                                                $bank_amount_reconciled[$bank->id] = 0;
                                                $bank_amount_not_reconciled[$bank->id] = 0;
                                            }
                                          
                                            if (count($payments)>0) {
                                                $i = 1; 
                                                foreach ($payments as $payment) {
                                                    ?>
                                                    <tr>
                                                        <td data-title="<?= ('slno') ?>">
                                                       <?php echo $i; ?>
                                                        </td>
                                                        <td data-title="<?= ('bank_name') ?>">
                                                        <?php echo $payment->bank_name; ?>
                                                        </td>
                                                        <td data-title="<?= ('bank_account') ?>">
                                                          <?php echo $payment->account_number; ?>
                                                        </td>
                                                        <td data-title="<?= ('transaction_id') ?>">
                                                         <?php echo $payment->transaction_id; ?>
                                                        </td>
                                                        <td data-title="<?= ('transaction_date') ?>">
                                                          <?php echo $payment->date; ?>
                                                        </td>
                                                        <td data-title="<?= ('invoice_amount') ?>">
                                                      <?php echo money($payment->amount); ?>
                                                        </td>
                                                        <td data-title="<?= ('note') ?>">
                                                        <?php     
                                                        $total_payments += $payment->amount;
                                                        isset($bank_amount[$payment->bank_account_id]) ? $bank_amount[$payment->bank_account_id] += $payment->amount:'';
                                                        echo $payment->payer_name;
                                                        ?>
                                                        </td>
                                                        <td data-title="<?= ('type') ?>">
                                                       <?php echo $payment->is_payment == 1 ? '<b class="label label-success">Invoiced</b>' : '<b class="label label-info">Direct Revenue</b>'; ?>
                                                        </td>
                                                        <td data-title="<?= ('status') ?>">
                                                        <?php

                                                        if ($payment->reconciled == 1) {
                                                            echo '<b class="label label-success">Reconciled</b>';
                                                            $amount_reconciled += $payment->amount;
                                                            isset($bank_amount_reconciled[$payment->bank_account_id]) ? $bank_amount_reconciled[$payment->bank_account_id]+= $payment->amount :'';
                                                        }
                                                        ?>
                                                        </td>
                                                        <td data-title="<?= ('action') ?>">

                                                           <?php if ($payment->reconciled <> 1) { ?>
                                                                <input type="checkbox" class="reconcile btn btn-success" id="<?php echo $payment->id; ?>" data-table="<?= isset($payment->is_expense) && $payment->is_expense ==1 ? 'total_expenses' :$table ?>" data-type='<?= $payment->is_payment ?>' data-placement="top" data-toggle="tooltip" data-original-title="Reconcile">
                                                            <?php } else { ?>
                                                                <a href="#" onclick="return false" onmousedown="unreconcile('<?= $payment->id ?>', '<?= $payment->is_payment ?>')" class="btn btn-sm btn-danger">un reconcile</a>                                   
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            } ?>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td colspan="5">Total</td>
                                                <td><?= money($total_payments) ?></td>
                                                <td colspan="4"></td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                       </div>

                                      <div>
                                       <div class="float-left">
                                          <br/><br/>
                                            <h3>Summary</h3>
                                           <br/>
                                       </div>
                                       <?php if (count($payments)>0) { ?>
                                     <div id="hide-table">
                                       <div class="table-responsive dt-responsive"> 
                                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-2"><?= ('slno') ?></th>
                                                    <th class="col-sm-2"><?= ('total_amount') ?></th>
                                                    <th class="col-sm-2"><?= ('amount_reconciled') ?></th>
                                                    <th class="col-sm-2"><?= ('amount_not_reconciled') ?></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td><?= money($total_payments) ?></td>
                                                    <td><?= money($amount_reconciled) ?></td>
                                                    <td><?= money($total_payments - $amount_reconciled) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                       </div>
                                     </div>

                                       <div class="float-left">
                                        <br/><br/>
                                           <h3>Bank Summary</h3>
                                          <br/>
                                       </div>

                                    <div id="hide-table">
                                       <div class="table-responsive dt-responsive"> 
                                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-2"><?= ('slno') ?></th>
                                                    <th class="col-sm-2"><?= ('bank_name') ?></th>
                                                    <th class="col-sm-2"><?= ('account_name') ?></th>
                                                    <th class="col-sm-2"><?= ('account_number') ?></th>
                                                    <th class="col-sm-2"><?= ('total_amount') ?></th>
                                                    <th class="col-sm-2"><?= ('amount_reconciled') ?></th>
                                                    <th class="col-sm-2"><?= ('amount_not_reconciled') ?></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <?php
                                            
                                                $b = 1;
                                                foreach ($banks as $bank) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $b ?></td>
                                                        <td><?= $bank->referBank->name ?></td>
                                                        <td><?= $bank->name ?></td>
                                                        <td><?= $bank->number ?></td>
                                                        <td><?php
                                                        $b_amount = isset($bank_amount[$bank->id]) ? $bank_amount[$bank->id] : 0;
                                                        echo money($b_amount); ?></td>
                                                            <td><?php
                                                                $b_rec = isset($bank_amount_reconciled[$bank->id]) ? $bank_amount_reconciled[$bank->id] : 0;
                                                                echo money($b_rec) ?></td>
                                                                    <td><?= money($b_amount - $b_rec) ?></td> 
                                                                </tr>
                                                                <?php
                                                                $b++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                 </table>
                                                </div>
                                            </div>
                                          <?php } ?>
                 
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

<script type="text/javascript">
    function unreconcile(a, b) {
        $.ajax({
            type: 'POST',
            url: "<?= url('account/unreconcile') ?>",
            data: {"id": a, type: b},
            dataType: "html",
            success: function (data) {
                toast(data);
            }
        });
    }
    $('.reconcile').click(function () {
        var id = $(this).attr("id");
        var type = $(this).attr('data-type');
        var table = $(this).attr('data-table');
        if (parseInt(id)) {
            $.ajax({
                type: 'POST',
                url: "<?= url('account/reconcile') ?>",
                data: {"id": id, type: type, table: table},
                dataType: "html",
                success: function (data) {
                    toast(data);
                }
            });
        }
    });
</script>
@endsection



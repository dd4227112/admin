@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>

    
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Reconciliation</h4>
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
                    <li class="breadcrumb-item"><a href="#!">Reconciliation</a>
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
                                        <div class="col-sm-12 col-sm-offset-3 list-group">
                                            <div class="list-group-item list-group-item-warning">
                                                <form style="" class="form-horizontal" role="form" method="post">
                                                    <div class="form-group row">
                                                        <label for="bank_account_id" class="col-sm-2 col-sm-offset-2 control-label">
                                                            Bank Name
                                                        </label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            $array = array("" => ("bank_account"));
                                                            $array["0"] = 'All';
                                                             foreach ($bank_accounts as $bank) {
                                                                $array[$bank->invoice_prefix] = $bank->schema_name . ' (' . $bank->invoice_prefix . ')';
                                                             }
                                                            echo form_dropdown("invoice_prefix", $array, old("invoice_prefix"), "id='bank_account_id' class='form-control'");
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="from" class="col-sm-2 col-sm-offset-2 control-label">
                                                            From Date
                                                        </label>
                                                        <div class="col-sm-10">
                                                            <input type="date" name="from_date" id="from" class='form-control'/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="to" class="col-sm-2 col-sm-offset-2 control-label">
                                                            To Date
                                                        </label>
                                                        <div class="col-sm-10">
                                                            <input type="date" name="to_date" id="to"  class='form-control'/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="to" class="col-sm-2 col-sm-offset-2 control-label">
                                                            
                                                        </label>
                                                        <div class="col-sm-10">
                                                        <input type="submit" class="btn btn-success btn-block" style="margin-bottom:0px" value="<?= ("View Payments") ?>" >
                                                        </div>
                                                    </div>
                                                    
                                                    <?= csrf_field() ?>
                                                </form>
                                            </div>
                                        
                                        </div>
                                     </div>
                           
                                     
                                     
                                     <div class="table-responsive dt-responsive"> 
                                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-2"><?= ('ID') ?></th>
                                                    <th class="col-sm-2"><?= ('Student Name') ?></th>
                                                    <th class="col-sm-2"><?= ('Phone') ?></th>
                                                    <th class="col-sm-2"><?= ('Reference') ?></th>
                                                    <th class="col-sm-2"><?= ('Amount') ?></th>
                                                    <th class="col-sm-2"><?= ('Receipt No') ?></th>
                                                    <th class="col-sm-2"><?= ('Channel') ?></th>
                                                    <th class="col-sm-2"><?= ('Date') ?></th>
                                                    <th class="col-sm-2"><?= ('action') ?></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            <?php
                                            $total_payments = 0;
                                            $amount_reconciled = 0;
                                            $prefix = $invoice_prefix;
                                            $i = 1; 
                                            if (count($payments)>0) {
                                                foreach ($payments as $value) {
                                                    $payment = json_decode($value->content);
                                                    if(isset($payment->transactionRef)){
                                                        $school = DB::table('admin.all_invoice_prefix')->where('reference', $payment->paymentReference)->first();
                                                        if(!empty($school)){
                                                            if (preg_match('/' . strtolower($prefix) . '/i', strtolower($payment->paymentReference))) {
                                                                $check = DB::table($school->schema_name.'payments')->where('transaction_id', $payment->transactionRef)->first();
                                                            }
                                                        }else{
                                                            $check = [];
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td data-title="<?= ('slno') ?>">
                                                       <?php echo $i; ?>
                                                        </td>
                                                        <td data-title="<?= ('bank_name') ?>">
                                                        <?php echo $payment->payerName; ?>
                                                        </td>
                                                        <td data-title="<?= ('bank_name') ?>">
                                                        <?php echo $payment->payerMobile; ?>
                                                        </td>
                                                        <td data-title="<?= ('bank_name') ?>">
                                                        <?php echo $payment->paymentReference; ?>
                                                        </td>
                                                        <td data-title="<?= ('bank_name') ?>">
                                                        <?php echo $payment->amount; $total_payments += $payment->amount; ?>
                                                        </td>
                                                        <!-- <td data-title="<?= ('bank_name') ?>">
                                                        <?php // echo $payment->paymentDesc; ?>
                                                        </td> -->
                                                        <td data-title="<?= ('bank_account') ?>">
                                                          <?php echo $payment->transactionRef; ?>
                                                        </td>
                                                        <td data-title="<?= ('transaction_id') ?>">
                                                         <?php echo $payment->transactionChannel; ?>
                                                        </td>
                                                        <td data-title="<?= ('transaction_date') ?>">
                                                          <?php echo $payment->transactionDate; ?>
                                                        </td>
                                                        
                                                
                                                        <td data-title="<?= ('action') ?>">
                                                        <?php
                                                        if (empty($check)) {
                                                            ?>
                                                            <a href="#" onclick="return false" class="btn btn-primary btn-mini btn-round" onmousedown="reconcile('<?= url('software/syncMissingPayments/null?data=' . urlencode(json_encode($payment))) ?>')">Sync</a>
                                                        <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            } ?>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                            <td colspan="1">Total</td>
                                            <td colspan="1">{{ $i }}</td>
                                            <td colspan="2"> Amount Collected</td>
                                                <td><?= money($total_payments) ?></td>
                                                <td colspan="4"></td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                       </div>

                                      <div>
                                       <div class="col-sm-12">
                                          <br/><br/>
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
                                                                    
                                                                    ?></td>
                        
                                                                <td><?= 'From: <b>' . $from_date . '</b> - to - <b>' . $to_date . '</b>' ?></td>
                                                                <td><?= request('invoice_prefix') ?></td>
                                                                <td><?= count($payments) ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                           <br/>
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



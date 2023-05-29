@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<div class="page-header">
    <div class="page-header-title">
        <h4><?= 'Invoice Summary' ?></h4>
    </div>
    <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#!">Dashboard Settings</a>
            </li>
            <li class="breadcrumb-item"><a href="#!">setting</a>
            </li>
        </ul>
    </div>
</div> 
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">


                    <div class="card-block">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered dataTable">
                                <thead>
                                    <tr>
                                        <th class="col-sm-1">#</th>
                                        <th class="col-sm-2">School Name</th>
                                        <th class="col-sm-2">invoiced amount</th>
                                        <th class="col-sm-2">Paid amount</th>
                                        <th class="col-sm-2">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_expense = 0;
                                    if (!empty($invoices_sents)) {
                                        $i = 1;
                                        foreach ($invoices_sents as $sent) {
                                            ?>
                                            <tr>
                                                <td data-title="<?= __('slno') ?>">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td data-title="<?= __('holiday_name') ?>">
                                                    <p><?php echo $sent->username ?></p>
                                                </td>
                                                <td data-title="<?= __('holiday_name') ?>">
                                                    <input type="text" value="<?php echo $sent->amount ?>" name="amount" amount_id="<?php echo $sent->username ?>" class="amount"/>

                                                </td>
                                                <td data-title="<?= __('holiday_name') ?>">
                                                    <input type="text" value="<?php echo $sent->paid_amount ?>" name="paid_amount" paid_amount_id="<?php echo $sent->username ?>" class="paid_amount"/>

                                                </td>
                                                <td data-title="<?= __('balance') ?>">
                                                    <?php echo $sent->amount - $sent->paid_amount ?>

                                                </td>

                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    amount = function () {
        $('.amount').blur(function () {
            var username = $(this).attr('amount_id');
            var amount = $(this).val();
            $.ajax({
                method: 'post',
                url: '<?= url('account/updateInvoiceSettings') ?>',
                data: {amount: amount, username: username},
                dataType: "html",
                success: function (data) {
                    alert(data);
                }
            })
        })
    }
    paid_amount = function () {
        $('.paid_amount').blur(function () {
            var username = $(this).attr('paid_amount_id');
            var paid_amount = $(this).val();
            $.ajax({
                method: 'post',
                url: '<?= url('account/updateInvoiceSettingsPaid') ?>',
                data: {paid_amount: paid_amount, username: username},
                dataType: "html",
                success: function (data) {
                    alert(data);
                }
            })
        })
    }
    $(document).ready(amount);
    $(document).ready(paid_amount);
</script>
@endsection
@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>ShuleSoft Invoices</h4>
                <span>Show payments summary</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Invoices</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">

                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Invoices</h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                            <br/>
                            <a href="<?= url('account/projection') ?>" class="btn btn-sm btn-primary">Create New Invoice</a>
                        </div>
                        <div class="col-md-12 col-xl-12">
                           
                            <div class="form-group row col-lg-offset-6">
                                <label class="col-sm-4 col-form-label">Select Project</label>
                                <div class="col-sm-4">
                                    <select name="select" class="form-control" id="schema_select">
                                        <option value="0">Select</option>
                                        <?php
                                       // $projects = \App\Models\Project::all();
                                      //  foreach ($projects as $project) {
                                            ?>
                                            <option value="1" selected>ShuleSoft</option>
                                        <?php // }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row col-lg-offset-6"  selected id="year_id">
                                <label class="col-sm-4 col-form-label">Select Year</label>
                                <div class="col-sm-4">
                                    <select name="select" class="form-control" id="year_select">
                                        <option value="0">Select</option>
                                        <?php
                                        $years = \App\Models\AccountYear::all();
                                        foreach ($years as $year) {
                                            ?>
                                            <option value="<?= $year->id ?>" ><?= $year->name ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                  <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                    <strong>Invoice List</strong>
                                </a>
                                <div class="slide"></div>
                            </li>
                           <li class="nav-item complete">
                                <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false">Summary</a>
                                <div class="slide"></div>
                            </li> 

                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                <div class="card-block">

                                   
                                   <div class="dt-responsive table-responsive">
                                <?php if ($project_id == 4) { ?>
                                    <table id="invoice_table" class="table table-striped table-bordered nowrap dataTable">
                                        <thead>
                                            <tr>
                                                 <th>#</th>
                                                <th>Client Name</th>
                                                <th>Reference #</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                                <th>SMS Provided</th>
                                                <th>Transaction ID</th>
                                                <th>Method</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_amount = 0;
                                            $total_paid = 0;
                                            $total_sms = 0;
                                            $x = 1;
                                            foreach ($invoices as $invoice) {

                                                $amount = $invoice->amount;
                                                $paid = $invoice->confirmed == 1 && $invoice->approved == 1 ? $amount : 0;
                                                $unpaid = $amount - $paid;
                                                $total_paid += $paid;
                                                $total_amount += $amount;
                                                $total_sms += $invoice->sms_provided;
                                                ?>


                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td><?= $invoice->name ?></td>
                                                    <td><?= $invoice->invoice ?></td>
                                                    <td><?= money($amount) ?></td>
                                                    <td><?= money($paid) ?></td>
                                                    <td><?= $invoice->sms_provided ?></td>
                                                    <td><?= $invoice->transaction_code ?></td>
                                                    <td><?= $invoice->method ?></td>
                                                    <td><?= date('d M Y', strtotime($invoice->time)) ?></td>
                                                    <td>
        <!--                                                        <a href="<?= url('account/invoiceView/' . $invoice->payment_id) ?>" class="btn btn-sm btn-success">View</a>
                                                        <a href="<?= url('account/invoice/edit/' . $invoice->payment_id) ?>" class="btn btn-sm btn-primary">Edit</a>-->
                                                        <!--<a href="<?= url('account/invoice/delete/' . $invoice->payment_id) ?>" class="btn btn-sm btn-danger">Delete</a>-->
                                                        </td>
                                                </tr>
                                            <?php $x++; } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">Total</td>
                                                <td><?= money($total_amount) ?></td>
                                                <td><?= money($total_paid) ?></td>
                                                <td><?= $total_sms ?></td>
                                                <td colspan="4"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <?php } else {
                                    ?>
                                    <table id="invoice_table" class="table table-striped table-bordered nowrap dataTable">
                                        <thead>
                                            <tr>
                                                <th>Client Name</th>
                                                <th>Reference #</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Remained Amount</th>
                                                <th>Due Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_amount = 0;
                                            $total_paid = 0;
                                            $total_unpaid = 0;
                                            $i = 1;
                                            foreach ($invoices as $invoice) {

                                                $amount = $invoice->invoiceFees()->sum('amount');
                                                $paid = $invoice->payments()->sum('amount');
                                                $unpaid = $amount - $paid;
                                                $total_paid += $paid;
                                                $total_amount += $amount;
                                                $total_unpaid += $unpaid;
                                                ?>


                                                <tr>
                                                    <td><?= $invoice->client->username ?></td>
                                                    <td><?= $invoice->reference ?></td>
                                                    <td><?= money($amount) ?></td>
                                                    <td><?= money($paid) ?></td>
                                                    <td><?= money($unpaid) ?></td>
                                                    <td><?= date('d M Y', strtotime($invoice->due_date)) ?></td>
                                                    <td>


<div class="dropdown-secondary dropdown f-right"><button class="btn btn-success btn-mini dropdown-toggle waves-effect waves-light" type="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button><div class="dropdown-menu" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"><a class="dropdown-item waves-light waves-effect" href="<?= url('account/invoiceView/' . $invoice->id) ?>"  ><span class="point-marker bg-danger"></span>View</a> <a class="dropdown-item waves-light waves-effect" href="<?= url('account/invoice/edit/' . $invoice->id) ?>"><span class="point-marker bg-warning"></span>Edit</a><a class="dropdown-item waves-light waves-effect" href="<?= url('account/invoice/delete/' . $invoice->id) ?>"><span class="point-marker bg-warning"></span>Delete</a>
<?php if ((int) $unpaid > 0) { ?>
    <hr/>
    <a class="dropdown-item waves-light waves-effect" href="<?= url('account/payment/' . $invoice->id) ?>"><span class="point-marker bg-warning"></span>Add Payments</a>
    <?php }  ?>
    <?php if((int) $unpaid >0){ ?>
        <a class="dropdown-item waves-light waves-effect" href="#" data-toggle="modal" data-target="#large-Modal" onclick="$('#invoice_id').val('<?=$invoice->id?>')"><span class="point-marker bg-warning"></span>Send Invoice</a>
         <?php }  ?>
          <?php if((int) $paid >0){ ?>
<a class="dropdown-item waves-light waves-effect" href="<?= url('account/receipts/' . $invoice->id) ?>" target="_blank"><span class="point-marker bg-warning"></span>Receipt</a>
                                                       <?php }
                                                        ?>
    </div></div>

                                                       
                                                     
                                                    
                                                    </td>
                                                </tr>
                                            <?php $i++; } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">Total</td>
                                                <td><?= money($total_amount) ?></td>
                                                <td><?= money($total_paid) ?></td>
                                                <td><?= money($total_unpaid) ?></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <?php } ?>
                            </div>
                                </div>
                            </div>


                            <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                                <div class="card-block">

                                    <div class="table-responsive dt-responsive">
                                        <div class="card-header">
                                            <div class="panel-body">
                                                <?php if(isset($invoices) && !empty($invoices)){?>
                                                <table class="table table-responsive table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Total Clients</th>
                                                            <th>Total Invoices Created</th>
                                                            <th>Invoices Not Created</th>
                                                            <th>Total  Amount</th>
                                                            <th>Total Collected </th>
                                                            <th>Total Not Collected</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $total_clients=\DB::table('admin.clients')->count();?>
                                                        <tr>
                                                            <td class="text-center"><?=$total_clients?></td>
                                                            <td class="text-center"><?=$i?></td>
                                                            <td class="text-center"><?=$total_clients-$i?></td>
                                                            <td class="text-center">Tsh <?= money($total_amount) ?></td>
                                                            <td class="text-center">
                                                                Tsh <?= money($total_paid) ?>
                                                                <br/>
                                                                Equivalent to <?=(int) $total_amount>0 ? round($total_paid*100/$total_amount):$total_amount?>% collected
                                                            </td>
                                                            <td class="text-center">Tsh <?= money($total_unpaid) ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            <?php }?>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="card-block">

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>
<div class="modal fade" id="large-Modal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1050; display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send This Invoice</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                    <form action="<?=url('account/sendInvoice')?>" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    Email Address
                                    <input type="email" class="form-control"  name="email" required>
                                </div>
                                <div class="col-md-6">
                                    Phone Number
                                    <input type="text" class="form-control"  name="phone_number" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                           <div class="col-md-12">
                                    Message
 <textarea name="message" required="" class="form-control" >Hello #name,
Thank you for choosing ShuleSoft in your school. We really appreciate working with your school.
To help us continue offering this service to your school, kindly find our invoice for Tsh #amount. You can also pay electronically via masterpass with reference number #invoice
Thank you</textarea> 
                                </div>
                            </div>
                        </div>
                        

                        <div class="modal-footer">
                            <input type="hidden" name="invoice_id" id="invoice_id" value="">
                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light ">Send Invoice</button>
                        </div>
                        <?= csrf_field() ?>
                    </form>
                </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#schema_select').change(function () {
        var schema = $(this).val();
        if (schema == 0 || schema == 1) {
            $('#year_id').show();
            return false;
        } else {
            window.location.href = "<?= url('account/invoice') ?>/" + schema;
        }
    });
    $('#year_select').change(function () {
        var year = $(this).val();
        var project = $('#schema_select').val();
        if (year == 0) {
            return false;
        } else {
            window.location.href = "<?= url('account/invoice') ?>/" + project + '/' + year;
        }
    });
</script>
@endsection
@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<div class="main-body">
    <div class="page-wrapper">
    <div class="page-header">
            <div class="page-header-title">
                <h4>Invoices</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">invoice</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="card">
                        <div class="card-block">
                            <div class="col-sm-12 col-xl-4 m-b-30">
                           
                                       <?php if(can_access('creating_invoice')) { ?>
                                           <a href="<?= url("account/projection") ?>" class="btn btn-primary" data-placement="top"  data-toggle="tooltip" data-original-title="">Create new invoice  </a>
                                      <?php } ?>
                                </div>
                            <div class="row d-flex justify-content-center">

                                <div class="col-sm-10 col-xl-4 m-b-30">
                                    <h4 class="sub-title">Select project</h4>
                                    <select name="select" class="form-control form-control-primary"  id="schema_project">
                                       <option value="0">Select</option>
                                        <?php
                                       $projects = \App\Models\InvoiceType::whereNotIn('id',[4])->get();
                                       foreach ($projects as $project) {
                                            ?>
                                            <option value="<?= $project->id ?>" selected><?= $project->name ?></option>
                                        <?php  }
                                        ?>
                                     </select>
                                </div>
                                <div class="col-sm-12 col-xl-4 m-b-30">
                                    <h4 class="sub-title">Select year</h4>
                                    <select name="select" class="form-control form-control-primary js-example-basic-singl"  id="year_select">
                                       <option value="0">Select year</option>
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
                        </div>

                                                <!-- Material tab card start -->
                                                <div class="card">
                                                   
                                                    <div class="card-block">
                                                        <!-- Row start -->
                                                        <div class="row m-b-30">
                                                            <div class="col-lg-12 col-xl-12">
                                                                
                                                                <!-- Nav tabs -->
                                                                <ul class="nav nav-tabs md-tabs" role="tablist">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true"><strong>INVOICE LIST</strong></a>
                                                                        <div class="slide"></div>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" data-toggle="tab" href="#profile2" role="tab" aria-expanded="false"><strong>PRO FORMA INVOICE</strong></a>
                                                                        <div class="slide"></div>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" data-toggle="tab" href="#messages3" role="tab" aria-expanded="false"><strong>VIEW REPORT</strong></a>
                                                                        <div class="slide"></div>
                                                                    </li>
                                                                   
                                                                </ul>
                                                                <!-- Tab panes -->
                                                                <div class="tab-content card-block">
                                                                    <div class="tab-pane active" id="home3" role="tabpanel">
                                                                    <div class="table-responsive">
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
        <!--                                            <a href="<?= url('account/invoiceView/' . $invoice->payment_id) ?>" class="btn btn-sm btn-success">View</a>
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
                                                <th>#</th>
                                                <th>Client Name</th>
                                                <th>Reference #</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Remained Amount</th>
                                                <th>Previous Amount</th>
                                                <th>Advance Amount</th>
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
                                                    <td><?= $i ?></td>
                                                    <td><?= warp(strtoupper($invoice->client->name),15) ?></td>
                                                    <td><?= $invoice->reference ?></td>
                                                    <td><?= money($amount) ?></td>
                                                    <td><?= money($paid) ?></td>
                                                    <td><?= money($unpaid) ?></td>
                                                    <td>
                                                    <?php 
                                                    $previous_amount = \collect(DB::SELECT("select  sum(coalesce(balance,0))  as last_balance from admin.client_invoice_balances where extract(year from created_at) < '$accountyear->name' and client_id = '$invoice->client_id' "))->first();
                                                        echo money($previous_amount->last_balance)
                                                    ?>
                                                    </td>
                                                    <td>
                                                    <?php 
                                                    $adva_amount = \collect(DB::SELECT("select sum(coalesce(amount,0)) as amount from admin.advance_payments where payment_id in (select id from admin.payments where invoice_id = '$invoice->id' )"))->first();
                                                    echo money($adva_amount->amount)
                                                    ?>
                                                    </td>
                                                    <td><?= date('d M Y', strtotime($invoice->due_date)) ?></td>
                                                    <td>

                                                        <div class="dropdown-secondary dropdown f-right">
                                                        <button class="btn btn-success btn-mini dropdown-toggle waves-effect waves-light" type="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                         <a class="dropdown-item waves-light waves-effect" href="<?= url('account/invoiceView/' . $invoice->id) ?>"  > <span class="point-marker bg-danger"></span>View</a>
                                                         <a class="dropdown-item waves-light waves-effect" href="<?= url('account/invoice/edit/' . $invoice->id) ?>"><span class="point-marker bg-warning"></span>Edit</a>
                                                         <?php if(can_access('delete_invoice')) {  ?>
                                                         <a class="dropdown-item waves-light waves-effect" href="<?= url('account/invoice/delete/' . $invoice->id) ?>"><span class="point-marker bg-warning"></span>Delete</a>
                                                         <?php } ?> 
                                                        <?php if ((int) $unpaid > 0) { ?>
                                                            <hr/>
                                                            <a class="dropdown-item waves-light waves-effect" href="<?= url('account/payment/' . $invoice->id) ?>"><span class="point-marker bg-warning"></span>Add Payments</a>
                                                            <?php }  ?>
                                                            <?php if((int) $unpaid >0){ ?>
                                                                <a class="dropdown-item waves-light waves-effect" href="#" data-toggle="modal" data-target="#large-Modal" onclick="$('#invoice_id').val('<?=$invoice->id?>')"><span class="point-marker bg-warning"></span>Send Invoice</a>
                                                                <?php }  ?>
                                                                <?php if((int) $paid >0){ ?>
                                                                    <a class="dropdown-item waves-light waves-effect" href="<?= url('account/receipts/' . $invoice->id) ?>" target="_blank"><span class="point-marker bg-warning"></span>Receipt</a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                        
                                                      </td>
                                                  </tr>
                                   
                                    <?php $i++; } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">Total</td>
                                                <td><?= isset($total_amount) ? money($total_amount) : '' ?></td>
                                                <td><?= isset($total_paid) ? money($total_paid) : '' ?></td>
                                                <td><?= isset($total_unpaid) ? money($total_unpaid) : '' ?></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <?php } ?>
                               </div>
                                                                    </div>
                                                                    <div class="tab-pane" id="profile2" role="tabpanel">
                                                                    <div class="dt-responsive table-responsive">
                                    <table id="invoice_table" class="table table-striped table-bordered nowrap dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>School Name</th>
                                                <th>Reference #</th>
                                                <th>Amount</th>
                                                <th>Due Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php 
                                              $f = 1; $total_amount = 0;
                                             $temp_clients = \App\Models\TempClients::latest()->get();
                                            foreach ($temp_clients as $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $f ?></td>
                                                    <td><?= isset($value->school->name) ? warp(strtoupper($value->school->name),15) : '' ?></td>
                                                    <td><?= $value->reference ?></td>
                                                    <td><?php $total_amount+= $value->amount; echo money($value->amount) ?></td>
                                                    <td><?= date('d M Y', strtotime($value->due_date)) ?></td>
                                                    <td>
                                                     
                                                     <div class="dropdown-secondary dropdown f-right">
                                                        <button class="btn btn-success btn-mini dropdown-toggle waves-effect waves-light" type="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                         <a class="dropdown-item waves-light waves-effect" href="<?= url('account/proinvoiceView/' . $value->id) ?>"  > <span class="point-marker bg-danger"></span>View</a>
                                                         {{-- <a class="dropdown-item waves-light waves-effect" href="<?= url('account/proinvoiceView/edit/' . $value->id) ?>"><span class="point-marker bg-warning"></span>Edit</a> --}}
                                                        </div>
                                                    </div>
                                                  
                                                  </td>
                                              </tr>
                                   
                                         <?php $f++; } ?>
                                        </tbody>
                                         <tfoot>
                                            <tr>
                                                <td colspan="3"><strong> Total Amount</strong></td>
                                                <td><strong><?= isset($total_amount) ? money($total_amount) : '' ?></strong></td>
                                                <td colspan="1"></td>
                                            </tr>
                                        </tfoot> 
                                       </table>
                                            
                                    </div> 
                                                                    </div>
                                                                    <div class="tab-pane" id="messages3" role="tabpanel">
                                                                    <div class="dt-responsive table-responsive">
                                <div class="col-sm-12">
                               <form class="form-horizontal" role="form" method="post"> 
                                    <div class="form-group row">
                                        <div class="col-md-4 col-sm-12">
                                            <input type="date" class="form-control" id="from_date" name="from_date" value="<?= old('from_date',$from) ?>" >
                                        </div>
                                  
                                        <div class="col-md-4 col-sm-12">
                                            <input type="date" class="form-control" id="to_date" name="to_date" value="<?= old('to_date',$to) ?>" >
                                        </div>
                                    
                                        <div class="col-md-2 col-sm-2 col-xs-6">
                                            <input type="submit" class="btn btn-success" value="Submit"  style="float: right;">
                                        </div>
                                    </div>
                                   <?= csrf_field() ?>
                                 </form>
                               </div>
                                    <table id="invoice_table" class="table table-striped table-bordered nowrap dataTable">
                                   
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Client Name</th>
                                                <th>Reference #</th>
                                                <th>Paid date</th>
                                                <th>Amount</th>
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

                                                ?>


                                                <tr>
                                                    <td><?= $i?></td>
                                                    <td><?= $invoice->name ?></td>
                                                    <td><?= $invoice->reference ?></td>
                                                    <td><?= date('d M Y', strtotime($invoice->created_at)) ?></td>
                                                    <td><?= money($invoice->amount) ?></td>
                                                    <td><?= date('d M Y', strtotime($invoice->due_date)) ?></td>
                                                    <td>
                                                        <a class="btn btn-success btn-mini btn-round" href="<?= url('account/receiptView/' . $invoice->id . '/'. $invoice->p_id) ?>"  > <span class="point-marker bg-danger"></span>View</a>
                                                   </td>
                                               </tr>
                                         <?php $i++; } ?>
                                        </tbody>
                                        <tfoot>
                                            {{-- <tr>
                                                <td colspan="2">Total</td>
                                                <td><?= money($total_amount) ?></td>
                                                <td><?= money($total_paid) ?></td>
                                                <td><?= money($total_unpaid) ?></td>
                                                <td colspan="2"></td>
                                            </tr> --}}
                                        </tfoot>
                                    </table>
                               </div> 
                               
                                </div>
                                <div class="tab-pane" id="profile3" role="tabpanel">
                                <div class="dt-responsive table-responsive">
                                     <?php if(isset($invoices) && !empty($invoices)){ ?>
                                        <table id="invoice_table" class="table table-striped table-bordered nowrap dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Total Clients</th>
                                                        <th>Total Invoices Created</th>
                                                        <th>Invoices Not Created</th> 
                                                        <th>Total  Amount</th>
                                                        <th>Total Collected </th>
                                                        <th>Total Not Collected</th>
                                                        <th>Total Invoice sent</th>
                                                    </tr>
                                                  </thead>
                                                    <tbody>
                                                        <?php $i=0; $clients=\DB::table('admin.all_setting')->count();
                                                              $total_invoice_sent = isset($accountyear->name) ? \DB::table('admin.invoices_sent')->whereYear('date','=',$accountyear->name)->count() : DB::table('admin.invoices_sent')->count();
                                                              $total_clients = \DB::table('admin.clients')->count();
                                                            $i=0; 
                                                              ?>
                                                        <tr>
                                                            <td class="text-center"><?=$total_clients?></td>
                                                            <td class="text-center"><?=$i - 1?></td>
                                                            <td class="text-center"><?=$total_clients - ($i - 1)?></td>
                                                            
                                                            <td class="text-center">Tsh <?= money($total_amount) ?></td>
                                                            <td class="text-center">
                                                                Tsh <?= money($total_paid) ?>
                                                                <br/>
                                                                Equivalent to <?=(int) $total_amount>0 ? round($total_paid*100/$total_amount):$total_amount?>% collected
                                                            </td>
                                                            <td class="text-center">Tsh <?= money($total_unpaid) ?></td>
                                                            <td class="text-center"> <?= $total_invoice_sent ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                              <?php }?>
                                            </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                                        <!-- Row end -->
                                                       
                                                    </div>
                                                </div>
                                                <!-- Material tab card end -->
                                            </div>
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
                                    Thank you
                                    </textarea> 
                                </div>
                            </div>
                        </div>
                        

                        <div class="modal-footer">
                            <input type="hidden" name="invoice_id" id="invoice_id" value="">
                            <input type="hidden" name="client_email" id="client_email" value="">
                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light ">Send Invoice</button>
                        </div>
                        <?= csrf_field() ?>
                    </form>
                </div>
        </div>
    </div>
</div>

</div>
</div>
<script type="text/javascript">



    $('.calendar').on('click', function (e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");
    });




    $('#schema_project').change(function () {
        var schema = $(this).val();
        if (schema > 0) {
            $('#year_id').show();
            return false;
        } else {
          //  window.location.href = "<?= url('account/invoice') ?>/" + schema;
        }
    });
    $('#year_select').change(function () {
        var year = $(this).val();
        var project = $('#schema_project').val();
        if (year == 0) {
            return false;
        } else {
            window.location.href = "<?= url('account/invoice') ?>/" + project + '/' + year;
        }
    });
</script>

@endsection
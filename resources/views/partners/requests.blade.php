
@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->

<?php
$objects = [
    "1" => 'Bulk SMS Integration Requests',
    "2" => 'WhatsApp Integration Requests',
    "3" => 'VFD Integration Requests',
    "4" => 'CRDB BANK Integration Requests',
    "5" => 'Email Integration Requests'];
?>
<!-- Page-header start -->
<div class="page-header">
    <div class="page-header-title">
        <h4> Partners</h4>
    </div>
    <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#!">request</a>
            </li>
            <li class="breadcrumb-item"><a href="#!">operations</a>
            </li>
        </ul>
    </div>
</div> 
<!-- Page-header end -->
<!-- Page-body start -->
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <?php
                if ((int) request()->segment(3) > 0) {
                    ?>
                    <p align="left">
                        <br/>
                        &nbsp; &nbsp; &nbsp;
                        <a class="btn btn-primary btn-mini btn-round" href="<?= url('partner/addPartnerService/' . request()->segment(3)) ?>">  Onboard New School for <?= $objects[request()->segment(3)] ?></a>
                        <?php if (request()->segment(3) == 1) {?> 
                        
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        <a class="btn btn-success btn-mini btn-round addPayment" data-toggle="modal" data-target="#addPayment" href="#">  Add addons Payment</a>
                        <?php } ?>

                    </p>
                <?php } ?>
                <div class="row addPaymentrow" style="margin-left: 100px; margin-right: 100px;">
        <div class="col-sm-12">
            <h4> Add Addons Payment (Bulk SMS Intergration)</h4>
        <form  action="<?= url('Partner/addAddonsPayment') ?>" method="post" class="form-horizontal group_form " role="form">
                    <div class="row">                      
                        <div class="col-sm-12">
                        <div class="form-group">
                        <label for="client_id">Select School:</label>
                            <select name='school_id' id="client_id" class="form select2" required>

                            @foreach($clients as $client)

                            <option value="{{$client->id}}">{{ucfirst($client->name)}} </option>

                            @endforeach
                            </select>
                        </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label> Amount</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" placeholder="Payed amount" name="amount" required>
                                    <input  type="hidden" name="addon_id" value="<?=request()->segment(3)?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label> Payment Method</label>
                                <div class="input-group">
                                    <select type="text" class="form-control" name="method" required>
                                        <option selected>....</option>
                                        <option value="Bank Deposit">Bank Deposit</option>
                                        <option value="Electronic Payment">Electronic Payment</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Other">Others</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label> Note</label>
                                <div class="input-group">
                                    <textarea rows="4" class="form-control" placeholder="add payment notes (optional)" name="note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-warning closeAddPayment" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    
                </form>

        </div>
    </div>

                <div class="card-header">
                    <h5>Schools Onboarding Status </h5>

                    <div class='form-group row col-lg-8'>
                        <label for="parent_type" class="col-sm-2 control-label">
                            Select Type <span class="red">*</span>
                        </label>
                        <div class="col-sm-10">

                            <select name="type_id" id="integration_type" onchange="window.location.href = '<?= url('Partner/index') ?>/' + this.value" class="form-control">
                                <?php
                                foreach ($objects as $key => $value) {
                                    $selected = request()->segment(3) == $key ? 'selected' : '';
                                    echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <span class="offset-2">
                            <?php echo form_error($errors, 'parent_type'); ?>
                        </span>
                    </div>
                </div>
                <div class="card-block">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">All Requests</a>
                        </li>
                        <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#Completed" role="tab"> <i class="ti-pencil"> </i> New Requests</a>
                      </li>
        
                      <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#Progress" role="tab"> <i class="ti-check"> </i> Verified</a>
                    </li> -->
                        <?php
                        if ($refer_bank_id == 8) {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#invoices" role="tab"> <i class="ti-list"> </i> Invoices</a>
                            </li>
                        <?php } ?>
                        <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile1" role="tab"> <i class="ti-menu"> </i> Reports</a>
                      </li> -->

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="" id="home1" role="tabpanel">

                            <div class="table-responsive dt-responsive">
                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">

                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>School Name</th>
                                            <th>Username</th>
                                            <th><?= $type_id == 3 ? 'TIN' : 'Account' ?> Number</th>
                                            <th><?= $type_id == 3 ? 'TRA' : 'Bank' ?> Status</th>
                                            <th>Shulesoft Status</th>
                                            <th>Added Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $bank_number = '';
                                        if (!empty($requests) && count($requests) > 0) {
                                            $i = 1;
                                            $bank = null;
                                            foreach ($requests as $request) {
                                                if ($type_id == 1) {
                                                    $check_school = DB::table('all_setting')->where('schema_name', $request->client->username)->first();
                                                    if (!empty($check_school)) {
                                                        $bank = DB::table($request->client->username . '.bank_accounts')->where('id', $request->bank_account_id)->first();
                                                    } else {
                                                        $bank = DB::table('shulesoft.bank_accounts')->where('id', $request->bank_account_id)->where('schema_name', $request->client->username)->first();
                                                    }
                                                    if (!empty($bank)) {
                                                        $bank_number = $bank->number;
                                                    }
                                                    $number = !empty($bank) ? $bank_number : '<b class="label label-danger">Invalid</b>';
                                                }
                                                if ($type_id == 3) {
                                                    $set = DB::table('shulesoft.setting')->where('schema_name', $request->client->username)->first();
                                                    $number = $set->tin;
                                                }

                                                echo '<tr>
                                                        <td>' . $i++ . '</td>
                                                        <td>' . substr($request->client->name, 0, 30) . '</td>
                                                        <td>' . $request->schema_name . '</td>';
                                                ?>
                                            <td><?= $number ?></td>
                                            <td><?=
                                                $request->bank_approved == 1 ? '<b class="label label-success">Approved</b>' :
                                                        '<b class="label label-default">Not Approved</b>'
                                                ?></td>
                                            <td><?= $request->shulesoft_approved == 1 ? '<b class="label label-success" title="' . $request->approval->name . '"> Approved </b>' : '<b class="label label-warning"> Not Approved </b>' ?></td>
                                            <td><?= timeAgo($request->created_at) ?></td>
                                            <td>
                                                <a class="btn btn-info btn-sm" href="<?= url('Partner/view/' . $request->id) ?>">View</a>
                                                <!--<a href="https://<?= $request->client->username ?>.shulesoft.com/database/<?php echo $request->client->username; ?>" target="_blank" class="btn btn-success btn-sm"> Install System</a>-->
                                            </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="invoices" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>School Name</th>
                                            <th>Reference</th>
                                            <th>Students</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Added Date</th>
                                            <!-- <th>Due Date</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($invoices) && (int) request()->segment(3) == 1) {
                                            $i = 1;
                                            foreach ($invoices as $invoice) {
                                                ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= $invoice->client->name ?></td>
                                                    <td><?= $invoice->reference ?></td>
                                                    <td><?= $invoice->client->estimated_students ?></td>
                                                    <td><?= $invoice->invoiceFees()->sum('amount') ?></td>
                                                    <td><?= $invoice->status == 0 ? 'Unpaid' : 'Paid' ?></td>
                                                    <td><?php echo date('d M Y', strtotime($invoice->client->created_at)); ?></td>
                                                    <td>
                                                        <a href="<?= url('Partner/invoiceView/' . $invoice->id) ?>" class="btn btn-info btn-sm"> View Invoice</a>
                                                        <?php
                                                        $check_payment = $invoice->payments->count();
                                                        if ($check_payment > 0) {
                                                            ?>
                                                            <a href="https://<?= $request->client->username ?>.shulesoft.com/database/<?php echo $request->client->username; ?>" target="_blank" class="btn btn-success btn-sm"> Install System</a>
                                                        <?php } else { ?>
                                                            <a href="#"  data-toggle="modal" data-target="#customer_payment_model_<?= $invoice->id ?>_this" class="btn btn-success btn-sm"> Payments</a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <div class="modal fade" id="customer_payment_model_<?= $invoice->id ?>_this" role="dialog" style="z-index: 99999;" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header text-center">
                                                            <h4 class="modal-title"> Payment Verification for <?= $invoice->client->name ?><br> Procced with system Installation</h4>
                                                            <span id="modeltitle"></span>
                                                        </div>
                                                        <form action="<?= url('Partner/VerifyPayment') ?>" class="form-card" method="post"  enctype='multipart/form-data'>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <strong> Enter Payment Controll number</strong>
                                                                        <input type="hidden" name="integration_request_id" value="<?= $request->id ?>"  class="form-control">
                                                                        <input type="text" readonly name="amount" value="<?= $invoice->amount ?>"  class="form-control">
                                                                        <input type="hidden" name="user_id" value="<?= Auth::user()->id ?>"  class="form-control">
                                                                        <input type="text" name="reference" value=""  class="form-control">

                                                                    </div>
                                                                </div>
                                                                <?php if (preg_match('/shulesoft/', Auth::user()->email)) { ?>
                                                                    <div class="form-group">
                                                                        <div class="col-md-12">
                                                                            <strong> Attach Standing Order</strong>
                                                                            <input type="file"  name="file" class="form-control" accept="image/*,application/pdf">

                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
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
</div>

<script>
$(document).ready(function() {
    $(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
  }); 

    $('.addPaymentrow').hide();

    $('.addPayment').on('click', function(){
        $('.addPaymentrow').toggle('10000');
    });
    $('.closeAddPayment').on('click', function(){
        $('.addPaymentrow').hide('10000');
    });
    
});
get_schools = function () {
  $("#get_schools").select2({
    minimumInputLength: 2,
    // tags: [],
    ajax: {
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '<?= url('customer/getCLientschools/null') ?>',
      dataType: 'json',
      type: "GET",
      quietMillis: 50,
      data: function (term) {
        return {
          term: term,
          token: $('meta[name="csrf-token"]').attr('content')
        };
      },
      results: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              text: item.name,
              id: item.id
            };
          })
        };
      }
    }
  });
}

$(document).ready(get_schools);

</script>
 @endsection


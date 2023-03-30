@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>


    
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Standing orders</h4>
                <span>Edit Standing orders</span>
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
                    <li class="breadcrumb-item"><a href="#!">Standing order</a>
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
                    <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                    <strong>Edit Standing order</strong> 
                                </a>
                                <div class="slide"></div>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                <div class="card-block">

                                    <header class="panel-heading">
                                        Edit Standing order details
                                    </header>
                                    <div class="panel-body">
                                        <div id="error_area"></div>
                                        <div class="form">

                                            <form class="cmxform form-horizontal" method="post" action="<?= url('account/editStandingOrder/'.$id) ?>">
                                                 <div class="form-group ">
                                                    <label for="type" class="control-label col-lg-3">School contact</label>
                                                    <div class="col-lg-6">
                                                        <select name="school_contact_id"  class="form-control select2"  >
                                                            <?php                            
                                                                $contact_staffs = DB::table('school_contacts')->get();
                                                                if (count($contact_staffs) > 0) {
                                                                    foreach ($contact_staffs as $contact_staff) { ?>
                                                                <option
                                                                    value="<?= $contact_staff->id ?>">
                                                                    <?= $contact_staff->name ?>
                                                                </option>
                                                                <?php 
                                                                    }
                                                                   } 
                                                                 ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Basis</label>
                                                    <div class="col-lg-6">
                                                        <select name="which_basis"  class="form-control select2" required>
                                                            <option value=""></option>
                                                            <option value="Annually">Annually</option>
                                                            <option value="Semiannually">Semi Annually</option>
                                                            <option value="Quarterly">Quarterly</option>
                                                            <option value="Monthly">Monthly</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                 <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Number of occurrence</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" value="<?=$order->number_of_occurrence?>" name="occurrence"  
                                                        class="form-control"/>
                                                    </div>
                                                    <?php echo form_error($errors, 'number_of_occurrence'); ?>
                                                    <div class="col-lg-6"> <span id="date_error"></span></div>
                                                </div> 

                                                <div class="form-group ">
                                                  <label for="number" class="control-label col-lg-3">Occurance amount</label>
                                                    <div class="col-lg-6">
                                                     <input type="text" class="form-control transaction_amount" name="occurance_amount" 
                                                        value="<?=$order->occurance_amount ?>">
                                                    </div>
                                                </div>

                                                  <div class="form-group">
                                                    <label for="number" class="control-label col-lg-3">Total Amount</label>
                                                    <div class="col-lg-6">
                                                        <input type="text"
                                                        class="form-control transaction_amount"
                                                        name="total_amount"
                                                        value="<?=$order->total_amount ?>">
                                                    </div>
                                                    <?php echo form_error($errors, 'total_amount'); ?>
                                                    <div class="col-lg-6"> <span id="date_error"></span></div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Maturity date</label>
                                                    <div class="col-lg-6">
                                                     <input type="date"
                                                        class="form-control"
                                                        name="maturity_date" value="<?=$order->payment_date ?>">
                                                    </div>
                                                    <?php echo form_error($errors, 'maturity_date'); ?>
                                                    <div class="col-lg-6"> <span id="date_error"></span></div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Refer bank</label>
                                                    <div class="col-lg-6">
                                                     
                                                        <select name="refer_bank_id"  required
                                                            class="form-control select2">
                                                            <?php
                                                            $banks = DB::table('constant.refer_banks')->get();
                                                            if(!empty($banks)) {
                                                                foreach ($banks as $bank) {
                                                                    ?>
                                                            <option
                                                                value="<?= $bank->id ?>">
                                                                <?= $bank->name ?>
                                                            </option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Branch name</label>
                                                    <div class="col-lg-6">
                                                        <select name="branch_id" class="form-control select2" required>
                                                            <?php $branches = \App\Models\PartnerBranch::orderBy('id','asc')->get();
                                                            if (count($branches) > 0) {
                                                                foreach ($branches as $branch) {
                                                                ?>
                                                            <option
                                                                value="<?= $branch->id ?>">
                                                                <?= $branch->name ?>
                                                            </option>
                                                            <?php 
                                                                 } 
                                                               } 
                                                              ?>
                                                        </select>
                                                    </div>
                                                </div>
       
                                                <?php  if (!isset($order->client_id)) {  ?>
                                                <div class="form-group">
                                                    <label for="number" class="control-label col-lg-3">School Client</label>
                                                    <div class="col-lg-6">
                                                        <select name="client_id" class="form-control select2" required>
                                                            <?php $clients = \App\Models\Client::orderBy('id','asc')->get();
                                                            if (!empty($clients)) {
                                                                foreach ($clients as $client) {
                                                                    ?>
                                                            <option
                                                                value="<?= $client->id ?>">
                                                                <?= $client->name ?>
                                                            </option>
                                                            <?php 
                                                                } 
                                                               } 
                                                              ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php } else { ?>
                                                    <input type="hidden" value="<?= $order->client_id ?>"
                                                    name="client_id" />
                                                <?php } ?>


                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                        <button class="btn btn-primary" type="submit" >Update Standing order</button>
                                                    </div>
                                                </div>
                                               
                                                <?= csrf_field() ?>
                                            </form>
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

<script type="text/javascript">
    $(".select2").select2({
        theme: "bootstrap",
        dropdownAutoWidth: false,
        allowClear: false,
        debug: true
    });

$('.transaction_amount').attr("pattern", '^(\\d+|\\d{1,3}(,\\d{3})*)(\\.\\d{2})?$');
$('.transaction_amount').on("keyup", function() {
    var currentValue = $(this).val();
    currentValue = currentValue.replace(/,/g, '');
    $(this).val(currentValue.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
});
    
</script>

@endsection



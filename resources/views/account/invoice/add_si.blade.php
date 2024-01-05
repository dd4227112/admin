@extends('layouts.app')
@section('content')
<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>


  
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4 class="box-title">Standing order </h4>
        <span>Add standing order</span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="<?= url('/') ?>">Standing order</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Add</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div id="outer" class="container">
          <div id="wrapper" class="layout" style="background-color: #fff; margin-bottom: 40px;">
            <div id="editorForm">

              @if (sizeof($errors) > 0)
              <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              <form action="{{ url('Customer/createSI') }}" method="post"  enctype="multipart/form-data">
                <div class="modal-body">
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                              <strong> Branch name </strong>
                                <select name="branch_id" class="form-control select2" required>
                                    <?php
                                    $branches = \App\Models\PartnerBranch::orderBy('id','asc')->get();
                                    if (!empty($branches)) {
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
                            <div class="col-md-6">
                                <strong> Contact person </strong>
                                <select name="school_contact_id"  class="form-control select2"  >
                                    <?php
                            
                                    $contact_staffs = DB::table('school_contacts')->get();
                                    if (count($contact_staffs)) {
                                        foreach ($contact_staffs as $contact_staff) {?>
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
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <strong> Number of occurrence </strong>
                                <input type="number"
                                    class="form-control"
                                    name="number_of_occurrence"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <strong> Basis </strong>
                                <select name="which_basis"  class="form-control select2" required>
                                    <option value=""></option>
                                    <option value="Annually">Annually</option>
                                    <option value="Semiannually">Semi Annually</option>
                                    <option value="Quarterly">Quarterly</option>
                                    <option value="Monthly">Monthly</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <strong> Total amount</strong>
                                <input type="text"
                                    class="form-control"
                                    name="total_amount"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <strong> Amount for Every Occurrence </strong>
                                <input type="text"
                                    class="form-control"
                                    name="occurance_amount"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <strong> Maturity Date</strong>
                                <input type="date"
                                    class="form-control"
                                    name="maturity_date" required>
                            </div>
                            <div class="col-md-6">
                                <strong> Standing order  </strong>
                                <input type="file"
                                    class="form-control"
                                    accept=".pdf"
                                    name="standing_order_file"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <strong> Refer bank</strong>
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
                            <div class="col-md-6">
                                <strong> Contract type </strong>
                                <select name="contract_type_id"  required
                                    class="form-control select2">
                                    <?php
                                    $contracts = DB::table('contracts_types')->get();
                                    if (!empty($contracts)) {
                                        foreach ($contracts as $contract) {
                                            ?>
                                    <option
                                        value="<?= $contract->id ?>">
                                        <?= $contract->name ?>
                                    </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                  
                <div class="form-group">
                   <div class="row">
                    <div class="col-md-6">
                        <strong> Client </strong>
                        <select name="client_id"  required
                            class="form-control select2">
                            <?php
                            $clients = DB::table('clients')->get();
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

                      <div class="col-md-6">
                        <strong> Note</strong>
                        <input type="text"
                            class="form-control"
                            name="note"
                            required>
                       </div>

                     </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-primary waves-effect waves-light ">Save
                            changes</button>
                    </div>
                
                  </div>
                </div>

                    
                    
        </div>

               
                    {{-- <input type="hidden" value="<?= $client_id ?>"
                    name="client_id" /> --}}
    
                <?= csrf_field() ?>
            </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

$(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
});
</script>

@endsection

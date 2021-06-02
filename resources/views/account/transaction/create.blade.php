@extends('layouts.app')

@section('content')
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Company revenue</h4>
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
          <li class="breadcrumb-item"><a href="#!">revenue</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="card tab-card">
            <ul class="nav nav-tabs md-tabs" role="tablist">
              <li class="nav-item complete">
                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                  <strong>Create Single Transaction</strong>
                </a>
                <div class="slide"></div>
              </li>
              {{-- <li class="nav-item complete">
                <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false">Import Revenue From an Excel</a>
                <div class="slide"></div>
              </li> --}}
            </ul>
            <div class="tab-content">

              <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                <div class="card-block">

                  <header class="panel-heading">
                    Add Revenue

                  </header>
                  <div class="panel-body">
                    <div id="error_area"></div>
                    <div class=" form">
                      <div class="col-sm-2"></div>
                      <div class=" col-sm-10">

                        <form class="form-horizontal" role="form" method="post">
                          <div class=" col-lg-10 col-sm-6">
                          <div class='form-group' >
                            <strong>Revenue From<span class="red">*</span></strong>
                              <select name="user_in_shulesoft" id="user_in_shulesoft" class="form-control">
                                <option value=""></option>
                                <option value="1">User in ShuleSoft</option>
                                <option value="2">User Not in ShuleSoft</option>
                              </select>
                            </div>
                          </div>
                          <div id="user_in_shulesoft_tag" <?php request('user_in_shulesoft') == 1 ? '' : 'style="display: none;"' ?>>
                            <div class=" col-lg-10 col-sm-6">
                            <div class='form-group' >
                              <strong>
                                Payer Name <span class="red">*</span>
                                  <?php
                                  $uarray = array('0' => __("select expense"));
                                  $users = \App\Models\User::where('status', 1)->where('role_id', '<>', 7)->get();
                                  if (!empty($users)) {
                                    foreach ($users as $user) {
                                      $uarray[$user->id] = $user->firstname.' '.$user->lastname;
                                    }
                                  }
                                  echo form_dropdown("user_id", $uarray, old("user_id"), "id='user_id' class='form-control select2'");
                                  ?>
                                </div>

                              </div>
                            </div>

                            <div id="user_not_in_shulesoft_tag"  <?php request('user_in_shulesoft') == 2 ? '' : 'style="display: none;"' ?>>
                              <div class=" col-lg-10 col-sm-6">
                              <div class='form-group' >
                                <strong>
                                  <?= __("Payer Name") ?><span class="red">*</span>
                                </strong>
                                  <input type="text" class="form-control" id="amount" name="payer_name" value="<?= old('payer_name') ?>"  placeholder="  e.g Juma Ali" onblur="this.value = this.value.toUpperCase()">
                                </div>

                              </div>
                              <div class=" col-lg-10 col-sm-6">
                              <div class='form-group' >
                                <strong>
                                  <?= __("Payer Phone") ?><span class="red">*</span>
                                </strong>
                                  <input class="form-control phoneNumber" id="payer_phone" name="payer_phone"  value="<?= old('payer_phone') ?>" type="tel"  placeholder="e.g 655406004">
                                </div>
                              </div>
                              <div class=" col-lg-10 col-sm-6">
                              <div class='form-group' >
                                <strong>
                                  <?= __("Payer Email") ?>
                                </strong>
                                  <input type="text" class="form-control" id="payer_email" name="payer_email" value="<?= old('payer_email') ?>"  onblur="this.value = this.value.toLowerCase()" placeholder="option">
                                </div>
                              </div>
                            </div>
                            <div class=" col-lg-10 col-sm-6">
                              
                            <div class='form-group' >
                              <strong><?= __("Revenue Type") ?><span class="red">*</span></strong>
                                <?php
                                $array = array('0' => __("select name"));
                                if (!empty($category)) {
                                  foreach ($category as $categ) {
                                    $array[$categ->id] = $categ->name;
                                  }
                                }
                                echo form_dropdown("refer_expense_id", $array, old("refer_expense_id"), "id='refer_expense_id' class='form-control'");
                                ?>
                                <?php if (!empty($category)) { ?>

                                <?php } ?>
                                {{-- <span class="col-sm-2 small"><a href="<?= url("expense/financial_category") ?>">Create New</a></span> --}}
                              </div>
                             
                            </div>


                            <div class=" col-lg-10 col-sm-12">
                            <div class='form-group'>
                              <strong>
                              <label for="amount" class="col-sm-2 control-label">
                                <?= __("Amount") ?><span class="red">*</span>
                              </strong>
                                <input type="text" class="form-control transaction_amount" id="amount" name="amount" value="<?= old('amount') ?>" required="true">
                              </div>
                            </div>

                            <div class=" col-lg-10 col-sm-12">
                            <div class='form-group' >
                              <strong>
                                Payment method <span class="red">*</span>
                              </strong>
                                <select name="payment_type_id" id="payment_method_status" class="form-control" required="">
                                  <option value="">Select Payment type</option>
                                  <?php
                                  if (!empty($payment_types)) {
                                    foreach ($payment_types as $payment_type) {
                                      ?>
                                      <option value="<?= $payment_type->id ?>"><?= $payment_type->name ?></option>
                                      <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div id="refer_no" style="display: none">
                              <div class=" col-lg-10 col-sm-12">
                              <div class='form-group' >
                                <strong>Bank Name</strong>
                                <div class=" col-lg-10 col-sm-12">
                                  <select class="select2_multiple form-control" name="bank_account_id" id="bank_name">
                                    <option value=""></option>
                                    <?php
                                    if (!empty($banks) ) {
                                      foreach ($banks as $bank) {
                                        ?>
                                        <option value="<?= $bank->id ?>"><?= $bank->referBank->name . ' (' . $bank->number . ')' ?></option>
                                        <?php
                                      }
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                            <div class=" col-lg-10 col-sm-12">
                              <div class='form-group' >
                                <strong>
                                  <?= __("Reference No.") ?>
                                </strong>
                                  <input type="text" placeholder="Enter ref number/cheque number" class="form-control" id="ref_no" name="transaction_id" value="<?= old('transaction_id', time()) ?>">
                                </div>
                              </div>

                          <div class=" col-lg-10 col-sm-12">
                            <div class='form-group' >
                              <strong>
                                <?= __("Date") ?> <span class="red">*</span>
                              </strong>
                                <input type="date" class="form-control calendar" id="date" name="date" value="<?= date('Y-m-d') ?>">

                              </div>

                            </div>

                            <div class=" col-lg-10 col-sm-12">
                            <div class='form-group' >
                              <strong>
                                <?= __("Descriptions") ?>
                              </strong>
                                <textarea style="resize:none;" class="form-control" id="note" name="note"><?= old('note') ?></textarea>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-sm-offset-2 col-sm-4">
                                <input type="submit" class="btn btn-primary btn-block" value="Save" >
                              </div>
                            </div>

                            <?= csrf_field() ?>
                          </form>

                        </div>
                      </div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                    <div class="card-block">

                      <div class="table-responsive dt-responsive">
                        <div class="card-header">
                          <div class="panel-body">
                            <div class="alert alert-info">Use the exactly ShuleSoft template as provided : Excel should contains these keys at the top :'amount', 'transaction_id', 'account_number', 'payment_method', 'revenue_name', 'date'</div>
                            <!--<p>Sample Excel Format. </p>-->
                            <!--<img src="<?= url('public/images/sample_excel.jpg') ?>"/>-->
                            <br/>
                            <div class=" form">
                              <br/>
                              {{-- <p>
                                <?= __("file") ?>
                               <a href="<?= url('storage/uploads/sample/sample_students_upload.xlsx') ?>"><i class="fa fa-2x fa-cloud-download"></i></a></p> --}}

                              <form id="demo-form2" action="<?= url('revenue/uploadRevenue') ?>" class="form-horizontal" method="POST"
                                enctype="multipart/form-data">

                                <div class="form-group">

                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="file" name="file" type="file" required="required" accept=".xls,.xlsx,.csv,.odt">
                                  </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                  <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-2">
                                    <button type="submit" id="add_revenue" class="btn btn-primary btn-block"><?= __("submit") ?></button>
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
      </div>

    </div>

    <script>

        //Format number to thousands
    $('.transaction_amount').attr("pattern", '^(\\d+|\\d{1,3}(,\\d{3})*)(\\.\\d{2})?$');
    $('.transaction_amount').on("keyup", function() {
        var currentValue = $(this).val();
        currentValue = currentValue.replace(/,/g, '');
        $(this).val(currentValue.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    });

    payment_method_status = function () {
      $('#payment_method_status').change(function () {
        var val = $(this).val();
        if (val !== 'cash') {
          $('#refer_no').show();
        } else {
          $('#refer_no').hide();
        }
      });
      $('#user_in_shulesoft').change(function () {
        var val = $(this).val();
        if (val === '1') {
          $('#user_in_shulesoft_tag').show();
          $('#user_not_in_shulesoft_tag').hide();
        } else if (val === '2') {
          $('#user_in_shulesoft_tag').hide();
          $('#user_not_in_shulesoft_tag').show();
        } else {
          $('#user_in_shulesoft_tag').hide();
          $('#user_not_in_shulesoft_tag').hide();
        }
      });
    };
    $('#ref_no').blur(function () {
      var trans = $(this).val();
      if (trans === '0' || trans == '') {
      } else {
        $.ajax({
          type: 'POST',
          url: "<?= url('revenue/check_transaction_id') ?>",
          data: {trans_id: trans},
          dataType: "html",
          beforeSend: function (xhr) {
            $('#ref_no_status').html('<a href="#/refresh"><i class="fa fa-spinner"></i> </a>');
          },
          complete: function (xhr, status) {
            $('#ref_no_status').html('<span class="label label-success">' + status + '</span>');
          },
          success: function (data) {
            $('#ref_no_status').html(data);
          }
        });
      }
    });

    $(document).ready(payment_method_status)
  </script>
  @endsection

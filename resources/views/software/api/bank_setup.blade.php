@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/';

function account_no($schema,$bank_id){
   $bank =  \collect(\DB::select("select a.number from ".$schema.".bank_accounts a join admin.all_bank_accounts_integrations b on a.id = b.bank_account_id
      where b.schema_name ='{$schema}' and b.bank_account_id = '{$bank_id}' "))->first(); 
       return $bank->number;
 }

 function account_name($schema,$bank_id){
   $bank =  \collect(\DB::select("select a.name from ".$schema.".bank_accounts a join admin.all_bank_accounts_integrations b on a.id = b.bank_account_id
      where b.schema_name ='{$schema}' and b.bank_account_id = '{$bank_id}' "))->first(); 
       return $bank->name;
 }
?>                         

<div class="main-body">
  <div class="page-wrapper">

     <div class="page-header">
            <div class="page-header-title">
                <h4><?='Bank setup' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Bank setup</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Engineering</a>
                    </li>
                </ul>
            </div>
        </div> 
    
    <div class="page-body">
      <div class="row">
        <div class="col-md-12 col-xl-12">
          <div class="card" style="">
            <div class="card-block tab-icon">
              <!-- Row start -->
              <div class="row">
                <div class="col-lg-12 col-xl-12">
                
                  <ul class="nav nav-tabs md-tabs " role="tablist">
                  
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#requirements" role="tab"><i class="icofont icofont-ui-user "></i>School intergrated</a>
                      <div class="slide"></div>
                    </li>

                    <?php if(can_access('update_integration')) { ?>
                     <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#addnew" role="tab"><i class="icofont icofont-list "></i>Add new integration</a>
                      <div class="slide"></div>
                    </li>
                   <?php } ?>

                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div class="tab-pane active" id="requirements" role="tabpanel">
                      <div class="card-block">
                          <div class="table-responsive dt-responsive">
                            <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>School Name</th>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th>Invoice Prefix</th>
                                <th>Live username</th>
                                <th>Live password </th>
                            </tr>

                            </thead>
                            <tbody>
                                <?php  if(isset($integrations) && count($integrations) > 0) { ?>
                                  <?php $i = 1; foreach($integrations as $value)   { ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $value->schema_name ?></td>
                                    <td><?= isset(account_name($value->schema_name,$value->bank_account_id)) ? account_name($value->schema_name,$value->bank_account_id) : '' ?></td>
                                    <td><?= isset(account_no($value->schema_name,$value->bank_account_id)) ? account_no($value->schema_name,$value->bank_account_id) : '' ?></td>
                                    <td><?= $value->invoice_prefix ?></td>
                                    <td><?= $value->api_username ?></td>
                                    <td><?= $value->api_password ?></td>
                                </tr>
                                 <?php $i++; } ?>
                                <?php  } ?>
                           </tbody>
                          <tfoot>
                             <tr>
                                <th>#</th>
                                <th>School Name</th>
                                <th>Bank Name</th>
                                <th>Account Number</th>
                                <th>Invoice Prefix</th>
                                <th>Live username</th>
                                <th>Live password </th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane" id="addnew" role="tabpanel">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Update Integration</h4>
                        <span>This Part Allow you to update bank Integration</span>
                      </div>
                      <div class="modal-body">
                      <form autocomplete="off" action="<?= url('software/UpdateInt') ?>" method="post">

                          <div class="form-group">
                            <div class="row">

                              <div class="col-md-6">
                                <strong>  Select School</strong>
                                 <select name="schema" class="form-controlk select2" required id="check_account">
                                  <?php
                                  foreach ($settings as $setting) {
                                    ?>
                                    <option value="<?= $setting->schema_name ?>"><?= $setting->sname ?></option>
                                  <?php } ?>
                                </select>
                              </div>

                              <div class="col-md-6">
                                <strong>Account number</strong>
                                  <select name="bank_id" id="account_id" class="form-controlk select2" required>

                                  </select>
                              </div>

                            </div>
                          </div>

                        <div class="form-group">
                            <div class="row">

                              <div class="col-md-4">
                                <strong>  Invoice Prefix</strong>
                                  <input type="text" name="invoice_prefix" value="<?= $details->invoice_prefix ?? '' ?>" style="text-transform:uppercase" class="form-control" required>
                              </div>

                              <div class="col-md-4">
                                <strong>Live username</strong>
                                <input type="text" name="api_username" value="<?= $details->api_username ?? '' ?>" style="text-transform:uppercase" class="form-control" required>
                              </div>

                               <div class="col-md-4">
                                <strong>Live password</strong>
                                <input type="text" name="api_password" value="<?= $details->api_password ?? '' ?>" style="text-transform:uppercase" class="form-control" required>
                              </div>

                            </div>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary btn-round btn-sm ">Submit Here</button>
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


<script type="text/javascript">

  $(".select2").select2({
      theme: "bootstrap",
      dropdownAutoWidth: false,
      allowClear: false,
      debug: true
  }); 

$('#check_account').change(function (event) {
        var schema = $(this).val();
            $.ajax({ 
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '<?= url('software/loadaccounts') ?>',
                data: {schema: schema},
                dataType: "html", 
                cache: false,
                success: function (data) { 
                   $('#account_id').html(data);
                }
            });
      });



    //   $('#account_id').change(function(event) {
    //     var schema_name = $('#check_account').val();
    //     var account_id = $(this).val();
    //         $.ajax({
    //             type: 'POST',
    //             url: "<?= url('software/loadcredentials') ?>",
    //             data: "_token=" + "{{ csrf_token() }}" + "&account_id=" + account_id + "&schema_name=" + schema_name,
    //             dataType: "html",
    //             success: function(data) {
    //                // $('#academic_year_id').html(data);
    //             }
    //         });
    // });

</script>

@endsection

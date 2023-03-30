@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>


  
    <div class="page-header">
      <div class="page-header-title">
        <h4>Customer Analysis</h4>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="index-2.html">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Dashboard</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Update bank integration</a>
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
                  <!-- <h6 class="sub-title">Tab With Icon</h6> -->
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs md-tabs " role="tablist">

                     <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#addnew" role="tab"><i class="icofont icofont-list "></i>Edit integration</a>
                      <div class="slide"></div>
                    </li>
                 

                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content card-block">
                  

                  <div class="tab-pane active" id="addnew" role="tabpanel">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Update Integration</h4>
                        <span>This Part Allow you to update bank Integration</span>
                      </div>
                      <div class="modal-body">
                      <form  method="post">

                          <div class="form-group">
                            <div class="row">

                              <div class="col-md-6">
                                <strong><h4> <?=  $school->name ?? '' ?> </strong>
                                  
                              </div>

                              <div class="col-md-6">
                                <strong> <h4> <?= 'Account number : '.$check->number ?></strong>
                              </div>

                            </div>
                          </div>

                        <div class="form-group">
                            <div class="row">

                              <div class="col-md-4">
                                <strong>  Invoice Prefix</strong>
                                  <input type="text" name="invoice_prefix" value="<?= $check->invoice_prefix ?? '' ?>" style="text-transform:uppercase" class="form-control" required>
                              </div>

                              <div class="col-md-4">
                                <strong>Live username</strong>
                                <input type="text" name="api_username" value="<?= $check->api_username ?? '' ?>" style="text-transform:uppercase" class="form-control" required>
                              </div>

                               <div class="col-md-4">
                                <strong>Live password</strong>
                                <input type="text" name="api_password" value="<?= $check->api_password ?? '' ?>" style="text-transform:uppercase" class="form-control" required>
                              </div>

                            </div>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary waves-effect waves-light ">Update Here</button>
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
                // method: 'get',
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

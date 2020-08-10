@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.9/select2-bootstrap.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>

<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->

    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="row">
            <div class="card-block">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add New School</h4>
                  <span>This Part Allow you to add a School does'nt exist on admin panel</span>
                </div>
                <form action="#" method="post">
                  <div class="modal-body">


                    <div class="form-group">
                      <strong>  Select School or Client</strong>

                      <input name="name"  class="form-control" placeholder="Enter School  Name.." autofocus required>

                    </div>
                    <div class="form-group">
                      <div class="row">

                        <div class="col-md-6">
                          <strong> Select Region</strong>
                          <select type="text" name="region" id="region" style="text-transform:uppercase" required class="form-control select2">
                            <option value="">Select here...</option>
                           <?php
                            $regions = \App\Models\Region::where('country_id', 1)->get();
                            foreach($regions as $region){
                            echo  '<option value="'.$region->id.'">'.$region->name.'</option>';
                            }
                          ?>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <strong>Enter District</strong>
                          <select type="text" name="district" id="district" style="text-transform:uppercase" required class="form-control select2">
                          <option value="">Select Here...</option>

                          </select>

                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">

                        <div class="col-md-6">
                          <strong> Enter Ward</strong>
                          <select type="text" name="ward" id="ward" style="text-transform:uppercase" required class="form-control select2">
                          </select>
                        </div>
                        <div class="col-md-6">
                          <strong> Select School Zone</strong>
                          <select name="zone" class="form-control select2" required>
                            <option value="Central Zone">Central Zone</option>
                            <option value="Eastern Zone">Eastern Zone</option>
                            <option value="Northern  Zone">Northern  Zone</option>
                            <option value="Southern  Zone">Southern  Zone</option>
                            <option value=" Zanzibar Zone">Zanzibar  Zone</option>
                            <option value="Coastal  Zone">Coastal  Zone</option>
                            <option value="Western  Zone">Western  Zone</option>
                            <option value="Southern Highlands  Zone"> Southern Highlands Zone</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <strong> Select Ownership</strong>
                          <select name="ownership" class="form-control" required>
                            <option value="Non-Government">Non-Government</option>
                            <option value="Government">Government</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <strong> Select School Type</strong>
                          <select type="text" name="type" class="form-control" required>
                            <option value="primary"> Primary School</option>
                            <option value="secondary"> Secondary School</option>
                            <option value="college"> College</option>
                          </select>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
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
<script type="text/javascript">

$(".select2").select2({
  theme: "bootstrap",
  dropdownAutoWidth: false,
  allowClear: false,
  debug: true
});

$('#region').change(function () {
            var val = $(this).val();
            $.ajax({
                method: 'get',
                url: '<?= url('Marketing/getDistrict/null') ?>',
                data: {region: val},
                dataType: 'html',
                success: function (data) {
                    $('#district').html(data);
                }
            });
        });
$('#district').change(function () {
            var val = $(this).val();
            $.ajax({
                method: 'get',
                url: '<?= url('Marketing/getWard/null') ?>',
                data: {district: val},
                dataType: 'html',
                success: function (data) {
                    $('#ward').html(data);
                }
            });
        });
</script>
@endsection

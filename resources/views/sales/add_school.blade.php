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

                      <input name="name"  class="form-control" placeholder="Enter School  Name.." required>

                    </div>
                    <div class="form-group">
                      <div class="row">

                        <div class="col-md-6">
                          <strong> Select Region</strong>
                          <select type="text" name="region" style="text-transform:uppercase" required class="form-control select2">
                            <option value="Arusha">Arusha</option>
                            <option value="Dar es Salaam">Dar es Salaam</option>
                            <option value="Dodoma">Dodoma</option>
                            <option value="Geita">Geita</option>
                            <option value="Iringa">Iringa</option>
                            <option value="Kagera">Kagera</option>
                            <option value="Katavi">Kagera</option>
                            <option value="Kigoma">Kigoma</option>
                            <option value="Kilimanjaro">Kilimanjaro</option>
                            <option value="Lindi">Lindi</option>
                            <option value="Manyara">Manyara</option>
                            <option value="Mara">Mara</option>
                            <option value="Mbeya">Mbeya</option>
                            <option value="Morogoro">Morogoro</option>
                            <option value="Mtwara">Mtwara</option>
                            <option value="Mwanza">Mwanza</option>
                            <option value="Njombe">Njombe</option>
                            <option value="Pemba North">Pemba North</option>
                            <option value="Pemba South">Pemba South</option>
                            <option value="Pwani">Pwani</option>
                            <option value="Rukwa">Rukwa</option>
                            <option value="Ruvuma">Ruvuma</option>
                            <option value="Shinyanga">Shinyanga</option>
                            <option value="Simiyu">Simiyu</option>
                            <option value="Singida">Singida</option>
                            <option value="Tabora">Tabora</option>
                            <option value="Tanga">Tanga</option>
                            <option value="Zanzibar North">Zanzibar North</option>
                            <option value="Zanzibar South and Central">Zanzibar South and Central</option>
                            <option value="Zanzibar West">Zanzibar West</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <strong>Enter District</strong>
                          <input type="text" name="district" class="form-control" style="text-transform:uppercase" required>

                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">

                        <div class="col-md-6">
                          <strong> Enter Ward</strong>
                          <input type="text" name="ward" style="text-transform:uppercase" class="form-control" required>
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
</script>
@endsection

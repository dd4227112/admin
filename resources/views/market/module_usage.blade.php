@extends('layouts.app')
@section('content')
<div class="main-body">
  <div class="page-wrapper">
      <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
    
    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">
              <div class="row">
                <?php
                $i = 1;
                $total = 0;
                ?>
                <div class="col-lg-3 col-xl-3 col-sm-12">
                    <x-analyticCard :value="$use_shulesoft" name="Schools in ShuleSoft" icon="feather icon-trending-up text-white f-16"  color="bg-c-blue"  topicon="feather icon-users f-30" subtitle="Use  the system"></x-analyticCard>
                </div>

                <div class="col-lg-3 col-xl-3 col-sm-12">
                    <x-analyticCard :value="$active_school" name="Active Schools" icon="feather icon-trending-up text-white f-16"  color="bg-c-green"  topicon="feather icon-users f-30" subtitle="These are active schools"></x-analyticCard>
                </div>

                <div class="col-lg-3 col-xl-3 col-sm-12">
                 <?php $notactive_school = $use_shulesoft - $active_school ?>
                    <x-analyticCard :value="$notactive_school" name="Not Active" icon="feather icon-trending-up text-white f-16"  color="bg-c-yellow"  topicon="feather icon-users f-30" subtitle="Use system occassionaly"></x-analyticCard>
                </div> 

                <div class="col-lg-3 col-xl-3 col-sm-12">
                    <x-analyticCard :value="sizeof($zero_student)" name="Inactive School" icon="feather icon-trending-up text-white f-16"  color="bg-c-pink"  topicon="feather icon-users f-30" subtitle="Stoped to use ShuleSoft"></x-analyticCard>
                </div>
              </div>

           
        </div>
      </div>
  
      <div class="card">
        <div class="card-block">
          <div class="row">
            
              <?php if(can_access('add_school')) { ?>
                <div class="col-lg-3">   <a href="<?= url('sales/addSchool') ?>"  class="btn btn-success">add New School</a></div>
              <?php } ?>
            
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="white-box">
                  <hr>
                  <div class="row">
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-4 row">
                    </div>
                    <div class="col-lg-4"></div>
                  </div>
                  <div class="table-responsive">
                    <table id="list_of_schools"  class="table dataTable table-striped table-bordered nowrap">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>School Name</th>
                          <th>Region</th>
                          <th>District</th>
                          <th>Ward</th>
                          <th>Type</th>
                          <!--<th>Use NMB</th>-->
                          <th>Students</th>
                          <th>Activities</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

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
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
  var table = $('#list_of_schools').DataTable({
    "processing": true,
    "serverSide": true,
    'serverMethod': 'post',
    'ajax': {
      'url': "<?= url('sales/show/null?page=schools&type=' . request()->segment(3)) ?>"
    },
    "columns": [
      {"data": "id"},
      {"data": "name"},
      {"data": "region"},
      {"data": "district"},
      {"data": "ward"},
      {"data": "type"},
      {"data": "students"},
      {"data": "activities"},
      {"data": ""}
    ],
    "columnDefs": [
      {
        "targets": 8,
        "data": null,
        "render": function (data, type, row, meta) {
          if (row.schema_name != null) {
            return '<a href="<?= url('customer/profile') ?>/' + row.schema_name + '" class="label label-warning">Already Customer</a>';
          } else {
            return '<a href="<?= url('sales/') ?>/profile/' + row.id + '" class="label label-primary">View</a>';
          }

        }

      }
    ]
  });


}
);
school_selector = function () {
  $('#school_selector').change(function () {
    var val = $(this).val();
    window.location.href = '<?= url('sales/school') ?>/' + val;
  })
}
$(document).ready(school_selector);
</script>

@endsection

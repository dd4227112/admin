@extends('layouts.app')
@section('content')

  

    <div class="page-header">
            <div class="page-header-title">
                <h4><?=' Usage' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">communication</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">marketing</a>
                    </li>
                </ul>
            </div>
        </div> 
     
    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">
              <div class="row">
                <?php
                $i = 1;
                $total = 0;
                ?>
                <div class="col-lg-3 col-xl-3 col-sm-12">
                      <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-green f-w-700">{{ number_format($use_shulesoft)}} </h4>
                                        <h6 class="text-muted m-b-0"> Schools in ShuleSoft</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-users f-30"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-c-blue">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">Use the system</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="feather icon-trending-up text-white f-16"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>

                <div class="col-lg-3 col-xl-3 col-sm-12">
                
                    <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-green f-w-700">{{ number_format($active_school)}} </h4>
                                        <h6 class="text-muted m-b-0"> Active Schools</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-users f-30"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-c-blue">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">These are active schools</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="feather icon-trending-up text-white f-16"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>

                <div class="col-lg-3 col-xl-3 col-sm-12">
                 <?php $notactive_school = $use_shulesoft - $active_school ?>
                 
                    <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-green f-w-700">{{ number_format($notactive_school)}} </h4>
                                        <h6 class="text-muted m-b-0"> Not Active</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-users f-30"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-c-blue">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">Use system occassionaly</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="feather icon-trending-up text-white f-16"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div> 

                <div class="col-lg-3 col-xl-3 col-sm-12">
            
                    <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-green f-w-700">{{ number_format(sizeof($zero_student))}} </h4>
                                        <h6 class="text-muted m-b-0"> Inactive School</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-users f-30"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-c-blue">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">Stoped to use ShuleSoft</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="feather icon-trending-up text-white f-16"></i>
                                    </div>
                                </div>

                            </div>
                      </div>
                </div>
              </div>

           
        </div>
      </div>
  
      <div class="card">
        <div class="card-block">
          <div class="row">
            
              <?php if(can_access('add_school')) { ?>
                <div class="col-lg-3">   <a href="<?= url('sales/addSchool') ?>"  class="btn btn-primary btn-sm btn-round">add New School</a></div>
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
       'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
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
            return '<a href="<?= url('customer/profile') ?>/' + row.schema_name + '" class="badge badge-warning">Already Customer</a>';
          } else {
            return '<a href="<?= url('sales/') ?>/profile/' + row.id + '" class="badge badge-primary">View</a>';
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

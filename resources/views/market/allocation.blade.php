@extends('layouts.app')
@section('content')
<?php 
  if(Auth::user()->role_id == 17){
    $zone_id = \App\Models\ZoneManager::where('user_id',Auth::user()->id)->first()->zone_id;
    
  }
?>

<div class="main-body">
    <div class="page-wrapper">
        
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Schools</h4>
                <span>List of private schools in Tanzania</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Sales</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Report</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">

                            <div class="row">
                                <?php
                                $i = 1;
                                $total = 0;
                                foreach ($school_types as $type) {
                                    ?>
                                    <div class="col-lg-3 col-xl-3 col-sm-12">
                                        <div class="card counter-card-<?= $i ?>">
                                            <div class="card-block-big">
                                                <div>
                                                    <h3><?= $type->count ?></h3>
                                                    <p><?= $type->type ?></p>
                                                    <div class="progress ">
                                                        <div class="progress-bar progress-bar-striped progress-xs progress-bar-<?= $i == 1 ? 'pink' : 'success' ?>" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <i class="icofont icofont-comment"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $total += $type->count;
                                    $i++;
                                }
                                ?>
                                <div class="col-lg-3 col-xl-3 col-sm-12">
                                    <div class="card counter-card-<?= $i ?>">
                                        <div class="card-block-big">
                                            <div>
                                                <h3><?= $total ?></h3>
                                                <p>Total</p>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small><?= $nmb_schools ?> Use NMB, <?= $use_shulesoft ?> use ShuleSoft, <?= $nmb_shulesoft_schools ?> use NMB & ShuleSoft</small>
                                            </div>
                                            <i class="icofont icofont-comment"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                           <?php if(can_access('add_school')) { ?>
                             <div class="col-lg-3">
                                 <a href="<?= url('sales/addSchool') ?>" data-i18n="nav.navigate.navbar" class="btn btn-success">add New School</a>
                             </div>
                           <?php } ?>
                        
                            <div class="col-lg-6">
                                <?php
                                if (can_access('manage_customers')) {
                                    ?>
                                    <p align="center">
                                        <?php
                                        ?>
                                        <a href="<?= url('sales/prospect/demo') ?>"> <button class="btn btn-success btn-skew"> Demo Requests <span class="badge badge-danger"><?php //echo $demo     ?></span></button></a>
                                        <a href="<?= url('sales/prospect/join') ?>"> <button class="btn btn-info btn-skew">Join Requests <span class="badge badge-danger"><?php // echo $join      ?></span></button></a>
                                    </p>
                                <?php } ?>
                                <select class="form-control" id="school_selector">
                                    <option value="1" <?php // selected(1)  ?>>All Schools</option>
                                    <option value="2" <?php // selected(2)  ?>>Use ShuleSoft Only</option>
                                    <option value="3"<?php // selected(3)  ?>>Sales On Progress</option>
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="white-box">
                                    <h3 class="box-title">List of all Schools</h3>
                                    
                                        <div class="card-block">
                                             <div class="table-responsive">
                                             <table id="list_of_schools" class="display nowrap table-borderd table dataTable">
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
//                {"data": "nmb_branch"}, 
                {"data": "students"},
                {"data": "activities"},
                {"data": ""}
            ],
            "columnDefs": [
                {
                    "targets": 8,
                    "data": null,
                    "render": function (data, type, row, meta) {
                        if (row.client_id != null) {
                            return '<a href="<?= url('customer/profile') ?>/' + row.username + '" class="label label-warning"> Already Customer  </a>';
                        } else {
                            return '<a href="<?= url('sales/') ?>/profile/' + row.id + '" class="label label-primary">Onboard School</a>';
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
            console.log(val)
            window.location.href = '<?= url('sales/school') ?>/' + val;
        })
    }
    $(document).ready(school_selector);
</script>

@endsection

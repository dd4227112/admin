@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
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
                    <li class="breadcrumb-item"><a href="#!">Schools</a>
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
                                foreach ($school_types as $type) {
                                    ?>
                                    <div class="col-md-12 col-xl-4">
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
                                    $i++;
                                }
                                ?>

                                <div class="col-md-6 col-xl-4">
                                    <div class="card counter-card-3">
                                        <div class="card-block-big">
                                            <div>
                                                <h3>0</h3>
                                                <p>Nursery</p>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-default" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <i class="icofont icofont-upload"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="white-box">
                                    <h3 class="box-title">List of Schools</h3>
                                    <div class="row">
                                        <div class="col-lg-4"></div>
                                        <div class="col-lg-4">

                                        </div>
                                        <div class="col-lg-4"></div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="list_of_schools"  class="display nowrap table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>School Name</th>
                                                    <th>Region</th>
                                                    <th>District</th>
                                                    <th>Ward</th>
                                                    <th>Type</th>
                                                    <th>Ownership</th>
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
                'url': "<?= url('sales/show/null?page=schools') ?>"
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "region"},
                {"data": "district"},
                {"data": "ward"},
                {"data": "type"},
                {"data": "ownership"},
                {"data": ""}
            ],
            "columnDefs": [
                {
                    "targets": 7,
                    "data": null,
                    "render": function (data, type, row, meta) {
                        if (row.prospect_id == null) {
                            return '<a href="<?= url('sales/prospect/add/') ?>/' + row.id + '" class="label label-warning">Prospect </a>';
                        }else{
                            return '<a href="<?= url('customer/profile/') ?>/school/' + row.id + '" class="label label-primary">View</a>';
                        }

                    }

                }
            ]
        });


    }
    );

</script>

@endsection

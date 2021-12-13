@extends('layouts.app')
@section('content')


    

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
                                        <div class="col-lg-3 col-xl-3 col-sm-6">
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
                                        <div class="col-lg-3 col-xl-3 col-sm-6">
                                    <div class="card counter-card-<?= $i ?>">
                                        <div class="card-block-big">
                                            <div>
                                                <h3><?= $use_shulesoft ?></h3>
                                                <p>use ShuleSoft</p>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <i class="icofont icofont-gift"></i>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                           
                        <div class="row">
                        <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <select class="form-control" id="school_selector">
                                <option value="1" <?php // selected(1) ?>>Select Here..</option>
                                <option value="1" <?php // selected(1) ?>>All Schools</option>
                                    <option value="2" <?php // selected(2) ?>>Already Use ShuleSoft</option>
                                    <option value="3" <?php // selected(2) ?>>Don't Use ShuleSoft</option>
                                </select>
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="white-box">
                                    <div class="row">
                                        <div class="col-lg-4">
                                         
                                        </div>
                                        <div class="col-lg-4 row">
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
                'url': "<?= url('sales/show/null?page=list_of_schools&type=' . request()->segment(3)) ?>"
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "region"},
                {"data": "district"},
                {"data": "ward"},
                {"data": "type"},
                {"data": ""}
            ],
            "columnDefs": [
                {
                    "targets": 6,
                    "data": null,
                    "render": function (data, type, row, meta) {
                        if (row.schema_name != null) {
                            return '<a href="<?= url('customer/profile') ?>/' + row.schema_name + '" class="label label-warning">Already Customer</a>';
                        } else {
                            return '<a href="<?= url('sales/') ?>/profile/' + row.id + '" class="label label-primary">View</a> <a href="<?= url('Partner/') ?>/add/' + row.id + '" class="label label-info">Onboard</a>';
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
            window.location.href = '<?= url('Partner/school') ?>/' + val;
        })
    }
    $(document).ready(school_selector);
</script>

@endsection

@extends('layouts.app')
@section('content')

    
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">ShuleSoft Customers</h4>
                <span>These are active customers using ShuleSoft</span>
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
                    <li class="breadcrumb-item"><a href="#!">Customers</a>
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
                              
                                <div class="col-md-12 col-xl-4">
                                    <div class="card counter-card-1">
                                        <div class="card-block-big">
                                            <div>
                                                <h3><?= $customers ?></h3>
                                                <p>Total Customers</p>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <i class="icofont icofont-comment"></i>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-12 col-xl-4">
                                    <div class="card counter-card-1">
                                        <div class="card-block-big">
                                            <div>
                                                <h3><?= $active_customers ?></h3>
                                                <p>Active Customers</p>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <i class="icofont icofont-comment"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-4">
                                    <div class="card counter-card-3">
                                        <div class="card-block-big">
                                            <div>
                                                <h3>0</h3>
                                                <p>Over Due Tasks</p>
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
                        <div class="card-block">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="white-box">
                                        <h3 class="box-title">Customers Report</h3>
                                        <div class="row">
                                            <div class="col-lg-4"></div>
                                            <div class="col-lg-4">

                                            </div>
                                            <div class="col-lg-4"></div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="list_of_leads"  class="display nowrap table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th>Email</th>
                                                        <th>Location</th>
                                                        <th>Payment Automated</th>
                                                        <th>Date Joined</th>
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
        var table = $('#list_of_leads').DataTable({
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
                'url': "<?= url('sales/show/null?page=customers') ?>"
            },
            "columns": [
                {"data": "number"},
                {"data": "sname"},
                {"data": "phone"},
                {"data": "email"},
                {"data": "address"},
                {"data": "payment_integrated"},
                {"data": "created_at"},
                {"data": ""}
            ],
            "columnDefs": [
                {
                    "targets": 7,
                    "data": null,
                    "render": function (data, type, row, meta) {

                       // return '<a href="#" class="label label-warning">Prospect </a>';
                       return '';

                    }

                }
            ]
        });

    }
    );
</script>
@endsection
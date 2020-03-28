@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Sales Prospect Reports</h4>
                <span>This shows list of prospects that needs to be attended to be converted into Leads</span>
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
                    <li class="breadcrumb-item"><a href="#!">Prospects</a>
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
                                        <a href="<?= url('sales/prospect/demo') ?>">
                                            <div class="card-block-big">
                                                <div>
                                                    <h3><?= count($demo_requests) ?></h3>
                                                    <p>Demo Requests</p>
                                                    <div class="progress ">
                                                        <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <i class="icofont icofont-comment"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-4">
                                    <div class="card counter-card-1">
                                        <a href="<?= url('sales/prospect/join') ?>">
                                            <div class="card-block-big">
                                                <div>
                                                    <h3><?= count($join_requests) ?></h3>
                                                    <p>Join Requests</p>
                                                    <div class="progress ">
                                                        <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <i class="icofont icofont-comment"></i>
                                            </div>
                                        </a>
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
                                    <?php
                                    if ($page == 'demo') {
                                        ?>
                                        <div class="white-box">
                                            <h3 class="box-title">Demo Requests Report</h3>
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
                                                            <th>School Name</th>
                                                            <th>Location</th>
                                                            <th>Contact Name</th>
                                                            <th>Contact Phone</th>
                                                            <th>Contact Email</th>
                                                            <th>Message Left</th>
                                                            <th>Time</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($demo_requests as $request) {
                                                            
                                                            $link=request()->segment(4)=='demo';
                                                            ?>
                                                            <tr>
                                                                <td><?= $i ?></td>
                                                                <td><?= $request->school_name ?></td>
                                                                <td><?= $request->school_location ?></td>
                                                                <td><?= $request->contact_name ?></td>
                                                                <td><?= $request->contact_phone ?></td>
                                                                <td><?= $request->contact_email ?></td>
                                                                <td><?= $request->message ?></td>
                                                                <td><?= date('d M Y h:i:s', strtotime($request->created_at)) ?></td>
                                                                <td>
                                                                    <a href="<?= url('sales/request/attend/' .request()->segment(5).'/'. $request->id) ?>" class="btn btn-success btn-sm">Attended Already</a>
                                                                    <a href="<?= url('sales/request/delete/' .request()->segment(5).'/'. $request->id) ?>" class="btn btn-danger btn-sm">Delete</a>
                                                                </td>
                                                            </tr>
                                                            <?php $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <script type="text/javascript">
                                                    $(document).ready(function () {
                                                        $('.table').DataTable();
                                                    });
                                                </script>
                                            </div>
                                        </div> 
                                    <?php } else if ($page == 'join') {
                                        ?>
                                        <div class="white-box">
                                            <h3 class="box-title">Prospects Report</h3>
                                            <div class="row">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-4">

                                                </div>
                                                <div class="col-lg-4"></div>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="list_of_leads"  class="display nowrap table dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>School Name</th>
                                                            <th>Location</th>
                                                            <th>Contact Name</th>
                                                            <th>Contact Phone</th>
                                                            <th>Contact Email</th>
                                                            <th>Message Left</th>
                                                            <th>Time</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($join_requests as $request) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $i ?></td>
                                                                <td><?= $request->school_name ?></td>
                                                                <td><?= $request->school_address ?></td>
                                                                <td><?= $request->contact_name ?></td>
                                                                <td><?= $request->contact_phone ?></td>
                                                                <td><?= $request->contact_email ?></td>
                                                                <td><?= $request->message ?></td>
                                                                <td><?= date('d M Y h:i:s', strtotime($request->created_at)) ?></td>
                                                                <td>            <a href="<?= url('sales/request/join/demo/' . $request->id) ?>" class="btn btn-success btn-sm">Attended Already</a>
                                                                    <a href="<?= url('sales/request/delete/join/' . $request->id) ?>" class="btn btn-danger btn-sm">Delete</a></td>
                                                            </tr>
                                                            <?php $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                $('.dataTable').DataTable();
                                            });
                                        </script>
<?php } else {
    ?>
                                        <div class="white-box">
                                            <h3 class="box-title">Prospects Report</h3>
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
                                                            <th>School Name</th>
                                                            <th>Contact Name</th>
                                                            <th>Location</th>
                                                            <th>Person in Charge</th>
                                                            <th>Last Contacted</th>
                                                            <th>Next Action Date</th>
                                                            <th>Message</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                var table = $('#list_of_leads').DataTable({
                                                    "processing": true,
                                                    "serverSide": true,
                                                    'serverMethod': 'post',
                                                    'ajax': {
                                                        'url': "<?= url('sales/show/null?page=prospects') ?>"
                                                    },
                                                    "columns": [
                                                        {"data": "id"},
                                                        {"data": "name"},
                                                        {"data": "contact_name"},
                                                        {"data": "location"},
                                                        {"data": "person_in_charge"},
                                                        {"data": "last_activity"},
                                                        {"data": "action_date"},
                                                        {"data": "last_message"},
                                                        {"data": ""}
                                                    ],
                                                    "columnDefs": [
                                                        {
                                                            "targets": 8,
                                                            "data": null,
                                                            "render": function (data, type, row, meta) {

                                                                return '<a href="<?= url('sales/prospect/delete/') ?>/' + row.id + '" class="label label-danger">Delete </a>';


                                                            }

                                                        }
                                                    ]
                                                });

                                            }
                                            );
                                        </script>
<?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
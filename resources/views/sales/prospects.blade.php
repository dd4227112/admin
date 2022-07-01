@extends('layouts.app')
@section('content')

    
      
        <div class="page-header">
            <div class="page-header-title">
                <h4><?='Demo requests' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">new school</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">marketing</a>
                    </li>
                </ul>
            </div>
        </div> 


        
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">

                          
                        </div>


                    
                            <div class="row">
                                <div class="col-lg-12">
                                 <div class="card">
                                    <?php
                                    if ($page == 'demo') {
                                        ?>
                                             <div class="card-header">
                                                <h5>Demo Requests Report</h5>
                                            </div>
                                         
                                              <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table dataTable table-striped table-bordered nowrap">
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
                                                                    <a href="<?= url('sales/request/attend/demo/' . $request->id) ?>" class="btn btn-success btn-mini btn-round">Attended Already</a>
                                                                    <a href="<?= url('sales/request/delete/demo/' . $request->id) ?>" class="btn btn-danger btn-mini btn-round">Delete</a>
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
                                    
                                           <div class="card-header">
                                                <h5>Prosperity Report</h5>
                                            </div>
                                              <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table dataTable table-striped table-bordered nowrap"> 
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
                                                                <td><?= warp($request->message,5) ?></td>
                                                                <td><?= date('d M Y h:i:s', strtotime($request->created_at)) ?></td>
                                                                <td>            <a href="<?= url('sales/request/attend/join/' . $request->id) ?>" class="btn btn-success btn-sm">Attended Already</a>
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
                                          <div class="card-header">
                                                <h5>Prosperity Report</h5>
                                            </div>
                                              <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table dataTable table-striped table-bordered nowrap">
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
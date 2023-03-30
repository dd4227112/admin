@extends('layouts.app')
@section('content')
<?php
?>
<!-- Sidebar inner chat end-->
<!-- Main-body start -->

    
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Customers</h4>
                <span>Whatsapp integration requests</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Customer</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Whatsapp</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card rd">

                        <div class="tab-content">
                            <div class="card-block">
                                <div class="steamline">


                                    <div class="card-block">

                                        <div class="table-responsive dt-responsive">


                                            <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>School</th>
                                                        <th>Payment status</th>
                                                        <th>Phone Number</th>
                                                        <th>Approved</th>
                                                        <!--<th>Created By</th>-->
                                                        <th>Request Date </th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($whatsapp_requests as $request) {
                                                        $i++;
                                                        ?> 

                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <th><?= ucfirst($request->schema_name) ?></th>
                                                            <th><?= (int) $request->is_paid == 1 ? '<b class="badge badge-success">Paid</b>' : '<b class="badge badge-danger">Pending</b>' ?></th>
                                                            <th><?= $request->phone_number ?></th>
                                                            <th><?=
                                                                (int) $request->approved == 1 ? '<b class="badge badge-success">Approved</b>' :
                                                                        '<b class="badge badge-warning">Not Yet</b>'
                                                                ?></th>
                                                            <!--<th><?= $request->created_by ?></th>-->
                                                            <th><?= date('d M Y H:i', strtotime($request->created_at)) ?> </th>

                                                            <td>
                                                               <?php if((int) $request->approved <>1 ){ ?> 
                                                                <a class="btn btn-success btn-sm"  href="{{ url('customer/approveIntegration/'.$request->id)}}">Approve</a>
                                                               <?php }?>
                                                                <a class="btn btn-warning btn-sm" href="{{ url('customer/approveIntegration/delete/'.$request->id) }}">Delete</a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
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
            <!-- Page-body end -->
        </div>
    </div>

    @endsection
    @section('footer')
    @endsection
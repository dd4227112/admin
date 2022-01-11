@extends('layouts.app')
@section('content')



    
        <div class="page-header">
            <div class="page-header-title">
                <h4>System Errors</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Error Logs</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">

            <div class="row">
       
                <div class="col-md-12 col-xl-12">
                    <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab"
                                    aria-expanded="true">
                                    <strong>( <?= isset($logs ) ? count($logs) : '' ?>)</strong> Errors
                                </a>
                                <div class="slide"></div>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">

                                <?php if(isset($logs) && !empty($logs)) { ?>

                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="dt-ajax-array"
                                            class="table table-striped table-bordered nowrap dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Client Name</th>
                                                    <th>Error Message</th>
                                                    <th>File</th>
                                                    <th>url</th>
                                                    <!-- <th>Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; foreach($logs as $error) { ?>
                                                <tr>
                                                    <td><a href="#" class="label label-danger dlt_log" onmousedown="delete_log(<?= $error->id ?>)" onclick="return false">Delete</a> </td>
                                                    <td><?= date('d-m-Y', strtotime($error->created_at)) ?></td>
                                                    <td><?= $error->schema_name ?></td>
                                                    <td style="white-space: nowrap;"><?= ($error->error_message) ?></td>
                                                    <td><?= warp($error->url,20) ?></td>
                                                </tr>
                                                <?php $i++; } ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <?php } else { ?>
                                <div class="card-block">
                                    <div class="table-responsive dt-responsive">
                                        <table id="error_log_table"
                                            class="table table-striped table-bordered nowrap dataTable">
                                            <thead>
                                                <tr>

                                                    <th></th>
                                                    <th>Date</th>
                                                    <th>Client Name</th>
                                                    <th>Error Message</th>
                                                    <th>File</th>
                                                    <th>url</th>
                                                    <!-- <th>Created By</th> -->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>



                                        </table>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                      
                        </div>
                    </div>
                </div>
            </div>


            <script type="text/javascript">
            $(document).ready(function() {

                delete_log = function(a) {
                    $.ajax({
                        url: '<?= url('software/logsDelete') ?>/null',
                        method: 'get',
                        data: {
                            id: a
                        },
                        success: function(data) {
                            if (data == '1') {
                                //$('#log' + a).fadeOut();
                                window.location.reload();
                            }
                        }
                    });
                }
            });
            </script>
            @endsection
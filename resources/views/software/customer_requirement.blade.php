
@extends('layouts.app')
@section('content')

<script type="text/javascript" src="<?=url('/public') ?>/assets/select2/select2.js"></script> 


    
        <div class="page-header">
            <div class="page-header-title">
                <h4>Customer service Reported issues</h4>
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
                    <li class="breadcrumb-item"><a href="#!">Customer service requirement</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-lg-6"></div>
                <div class="card table-card widget-danger-card col-lg-6">
                    <div class="card-footer">
                        <div class="task-list-table">
                            <p class="task-due"><strong>Person with highest requirements : </strong><strong class="label label-danger"><?= !empty($danger_schema) ? $danger_schema->schema_name : '' ?></strong></p>
                        </div>
                        <div class="task-board m-0">
                            <a href="#" class="btn btn-info btn-mini b-none" title="view"><i class="icofont icofont-eye-alt m-0"></i></a>

                        </div>
                        <!-- end of pull-right class -->
                    </div>
                </div>
            </div>
            <div class="row">

                <!-- Documents card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks dark-primary-border">
                        <div class="card-block">
                            <h5>All Errors</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-document-folder"></i>
                                </li>
                                <li class="text-right">
                                   
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Documents card end -->
                <!-- New clients card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks warning-border">
                        <div class="card-block">
                            <h5>issues/Bugs</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-ui-user-group text-warning"></i>
                                </li>
                                <li class="text-right text-warning">

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- New clients card end -->
                <!-- New files card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks danger-border">
                        <div class="card-block">
                            <h5>Requirements </h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-files text-danger"></i>
                                </li>
                                <li class="text-right text-danger">

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- New files card end -->
                <!-- Open Project card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks">
                        <div class="card-block">
                            <h5>Resolved Bugs</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-ui-folder text-primary"></i>
                                </li>
                                <li class="text-right text-primary">

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

             

                <div class="col-md-12 col-xl-12">
                    <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                    <strong>( <?= sizeof($error_logs) ?>)</strong> Bugs
                                </a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item complete">
                                <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false">Resolved</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item complete">
                                <a class="nav-link" data-toggle="tab" href="#messages3" role="tab" aria-expanded="false">Summary</a>
                                <div class="slide"></div>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">

                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="error_log_table" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>                                                
                                                    <th>Activity</th>
                                                    <th>School Name</th>
                                                    <th>Assigned To</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

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
        var table = $('#error_log_table').DataTable({
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
                'url': "<?= url('sales/show/null?page=requirements') ?>"
            },
            "columns": [
                {"data": "id"},               
                {"data": "activity"},
                {"data": "name"},               
                {"data": "firstname"},               
                {"data": "created_at"},
                {"data": ""}
            ],
            "columnDefs": [
                {
                    "targets": 5,
                    "data": null,
                    "render": function (data, type, row, meta) {
                        
                                           //return '<a href="#" id="' + row.id + '" class="label label-danger dlt_log" onmousedown="delete_log(' + row.id + ')" onclick="return false">Delete</a>'+ '<a href="#" id="' + row.id + '" class="label label-info dlt_log" onmousedown="View_log(' + row.id + ')" onclick="return false">View</a>';


                    }

                }
            ],
                    
            rowCallback: function (row, data) {
                //$(row).addClass('selectRow');
                $(row).attr('id', 'log' + data.id);
            }
        });
        View_log = function (a) {
       
            window.location.href = "<?= url('software/ReadReq') ?>/" + a;
        },
  
    delete_log = function (a) {
            $.ajax({
                url: '<?= url('software/ReqDelete') ?>/null',
                method: 'get',
                data: {id: a},
                success: function (data) {
                    if (data == '1') {
                        $('#log' + a).fadeOut();
                    }
                }
            });
        }
        
    }
    );
    $('#schema_select').change(function () {
        var schema = $(this).val();
        if (schema == 0) {
            return false;
        } else {
            window.location.href = "<?= url('software/logs') ?>/" + schema;
        }
    });

    getErrorPage = function (a) {
        $.ajax({
            url: '<?= url('software/logsView') ?>/null',
            method: 'get',
            data: {type: a},
            success: function (data) {
                $('#log_summary').hide();
                $('#custom_logs').html(data).show();
                $('#show_summary').show();
                console.log(data);
            }
        });
    }
    $('#show_summary').mousedown(function () {
        $(this).hide();
        $('#log_summary').show();
        $('#custom_logs').hide();
    });
    
    
    
    $('#schema_select').select2({
  placeholder: "Select a State",
    allowClear: true
});

</script>
@endsection

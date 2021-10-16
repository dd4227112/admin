@extends('layouts.app')
@section('content')

<div class="main-body">
 <div class="page-wrapper">
     <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
        <div class="page-body">
          <div class="col-lg-12">
            
             <div class="row">
                   <p style="font-size:18px;"> <strong class="pl-10">School with highest Error Logs</strong>  <label class="badge badge-inverse-danger"> <?= !empty($danger_schema)? $danger_schema->schema_name : '' ?> </label> </p>
                </div>
            </div>


            <div class="row">
                <!-- Documents card start -->
                <div class="col-md-6 col-xl-4">
                      <x-smallCard title="All errors"
                                :value="$error_log_count"
                                icon="feather icon-layers f-50 text-c-red"
                                cardcolor="bg-c-yellow text-white"
                                >
                     </x-smallCard>
                </div>
               
                <div class="col-md-6 col-xl-4">
                      <x-smallCard title="Fatal errors"
                                :value="$error_log_count"
                                icon="feather icon-book f-50 text-c-red"
                                cardcolor="bg-c-pink text-white"
                                >
                     </x-smallCard>
                </div>

                <div class="col-md-6 col-xl-4">
                     <x-smallCard title="Resolved errors"
                                :value="$error_log_resolved"
                                icon="feather icon-check-circle f-50 text-c-red"
                                cardcolor="bg-c-green text-white"
                                >
                     </x-smallCard>
                </div>

                <!-- Open Project card end -->
              
                <div class="col-md-12 col-xl-12">
                    <div class="form-group row col-lg-offset-6">
                        <label class="col-sm-4 col-form-label"><?= isset($schema_name) ? $schema_name. ' errors': 'Select School' ?></label>
                        <div class="col-sm-4">
                            <select name="select" class=" select2" id="schema_select">
                                <option value="0">Select</option>
                                <?php
                                $schemas = DB::select('select distinct "schema_name" from admin.error_logs');
                                foreach ($schemas as $schema) {
                                    ?>
                                    <option value="<?php echo $schema->schema_name ?>"><?php echo $schema->schema_name ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 col-xl-12">
                    <div class="card tab-card">

                        


                        {{-- <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                    <strong>( <?= isset($error_log_count ) ? ($error_log_count) : '' ?>)</strong> Errors
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
                        </ul> --}}

                      {{--  <div class="tab-content">
                          <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                              <?php if(isset($schema_errors) && !empty($schema_errors)) { ?>

                                  <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable"> 
                                            <thead>
                                                <tr>
                                                    <th>#</th>                                                
                                                    <th>Date</th>
                                                    <th>Client Name</th>
                                                    <th>Error Message</th>
                                                    <th>File</th>
                                                    <th>url</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php $i = 1; foreach($schema_errors as $error) { ?>
                                                <tr>
                                                    <td><?= $i ?></td>                                                
                                                    <td><?= date('d-m-Y', strtotime($error->created_at)) ?></td>
                                                    <td><?= $error->schema_name ?></td>
                                                    <td><?= warp($error->error_message,100) ?></td>
                                                    <td><?= warp($error->file,20) ?></td> 
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
                                       <table id="error_log_table" class="table table-striped table-bordered nowrap dataTable">
                                            <thead>
                                                <tr>
                                                                                                 
                                                    <th></th>
                                                    <th>Date</th>
                                                    <th>Client Name</th>
                                                    <th>Error Message</th>
                                                    <th>File</th>
                                                    <th>url</th>
                                                    <th>Action</th> 
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                             <?php } ?>
                            </div> --}}

                            {{-- <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="simpletable_resolved_errors" class="table table-striped table-bordered nowrap dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Client Name</th>
                                                    <th>Error Message</th>
                                                    <th>File</th>
                                                    <th>url</th>
                                                    <th>Created By</th>
                                                    <th>Resolved Date</th>
                                                    <th>Resolved By</th>
                                                </tr>
                                            </thead>

                                            <tfoot>
                                                <tr>
                                                    <th>Client Name</th>
                                                    <th>Error Message</th>
                                                    <th>File</th>
                                                    <th>url</th>
                                                    <th>Created By</th>
                                                    <th>Resolved Date</th>
                                                    <th>Resolved By</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div> --}}


                            {{-- <div class="tab-pane" id="messages3" role="tabpanel" aria-expanded="false">
                                <a href="#" class="btn btn-sm btn-success" id="show_summary" style="display: none">Show Summary</a>
                                <div id="custom_logs"></div>
                                <div class="email-card p-0" id="log_summary">
                                    <div class="card-block">

                                        <div class="mail-body-content">
                                            <div class="card">
                                                <div class="card-block table-border-style">
                                                    <div class="table-responsive analytic-table">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Error Instance Name</th>
                                                                    <th>Count</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sql = 'select error_instance,count(*) from admin.error_logs group by error_instance';
                                                                $logs = DB::select($sql);
                                                                foreach ($logs as $log) {
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <span class="table-msg"><?= $log->error_instance ?></span>
                                                                        </td>
                                                                        <td><?= $log->count ?></td>
                                                                        <td> <a href="#" onmousedown='getErrorPage("<?= $log->count ?>")' onclick="return false" class="btn btn-sm btn-warning btn-outline-warning waves-effect md-trigger">View</a></td>
                                                                    </tr>
                                                                <?php }
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div> --}}

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
                 'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "<?= url('sales/show/null?page=errors') ?>"
            },
            "columns": [
                {"data": "id"},
                {"data": "created_at"},
                {"data": "schema_name"},
                {"data": "error_message"},
                {"data": "file"},
                {"data": "url"},
              //  {"data": "created_by"},
             //   {"data": ""}
            ],
            "columnDefs": [
                {
                    "targets": 6,
                    "data": null,
                    "render": function (data, type, row, meta) {
                         return '<a href="#" id="' + row.id + '" class="label label-danger dlt_log" onmousedown="delete_log(' + row.id + ')" onclick="return false">Delete</a>' + '<a href="#" id="' + row.id + '" class="label label-info dlt_log" onmousedown="View_log(' + row.id + ')" onclick="return false">View</a>';
                    }
                }
            ],

            rowCallback: function (row, data) {
                //$(row).addClass('selectRow');
                $(row).attr('id', 'log' + data.id);
            }
        });


          View_log = function (a) {
            window.location.href = "<?= url('software/Readlogs') ?>/" + a;
            },

        delete_log = function (a) {
            $.ajax({
                url: '<?= url('software/logsDelete') ?>/null',
                method: 'get',
                data: {id: a},
                success: function (data) {
                    if (data == '1') {
                        //$('#log' + a).fadeOut();
                        window.location.reload();
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

    $(document).ready(function () {
        var table = $('#simpletable_resolved_errors').DataTable({
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "<?= url('sales/show/null?page=errors_resolved') ?>"
            },
            "columns": [
                {"data": "schema_name"},
                {"data": "error_message"},
                {"data": "file"},
                {"data": "url"},
              //  {"data": "created_by"},
                {"data": "deleted_at"},
                {"data": "resolved_by"}
            ],

            rowCallback: function (row, data) {
                $(row).attr('id', 'log' + data.id);
            }
        });
    });


    $('#schema_select').select2({
        placeholder: "Select a State",
        allowClear: true
    });
</script>
@endsection

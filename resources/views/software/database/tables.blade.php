@extends('layouts.app')
@section('content')
<?php

use \App\Http\Controllers\Software as SCHEMA;

$database = new SCHEMA();
$master_tables = $database->loadTables(SCHEMA::$master_schema);
$columns = $database->loadTableColumnsBulks();
$d = $database->loadSchema();
?>

    
        
         <div class="page-header">
            <div class="page-header-title">
                <h4><?='Contrains' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">contrains</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Engineering</a>
                    </li>
                </ul>
            </div>
        </div> 
        
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="text-center">
                                <h3 class="box-title m-b-0">Constrains Relations</h3>
                                <p class="text-muted m-b-30 font-13"> Choose constrain to compare</p>
                            </div> 
                            <div class="text-center"> 
                            <div class="form-group">
                                <select class="form-control" id="check_key">
                                    <option>Select Type</option>
                                    <option value="FOREIGN KEY">FOREIGN KEY</option>
                                    <option value="PRIMARY KEY">PRIMARY KEY</option>
                                    <option value="CHECK">CHECK</option>
                                    <option value="UNIQUE">UNIQUE</option>
                                </select>
                             </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 panel_error"  style="display: none;">
                                <!-- Animation card start -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Error Message</h5>
                                        <div class="card-header-right">
                                            <i class="icofont icofont-rounded-down"></i>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="error_message"> </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Animation card end -->
                            </div>
                        </div>

                        <div class="card-block">
                        <div class="table-responsive">
                            <table class="table dataTable table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Table</th>
                                        <th>Public count</th>
                                        <?php
                                        foreach ($d as $schema) {
                                            
                                        ?>
                                        <th><?=$schema->table_schema?></th>
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($master_tables as $table) {
                                        ?>
                                        <tr>
                                            <td>{{$table}}</td>
                                            <td></td>
                                            <td>
                                              
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
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
</div>
<script type="text/javascript">
    $('#check_key').change(function () {
        var val = $(this).val();
        window.location.href = "<?= url('software/constrains') ?>/" + val;
    })

    sync_relation = function () {
        $(".sync_relation").mousedown(function (event) {
            var slave = $(this).attr('data-slave');
            var table = $(this).attr('data-table');
            var constrain = $(this).attr('data-constrain');
            var relation_type = $(this).attr('data-relation');
            $(this).hide();
            $.ajax({
                 type: 'POST',
                 headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: "<?= url('software/syncConstrain/null') ?>",
                data: {
                    "constrain": constrain,
                    "table": table,
                    "slave": slave,
                    relation_type: relation_type
                },
                dataType: "html ",
                beforeSend: function (xhr) {
                    $('#' + table + slave + constrain).html('<a href="#/refresh"><i class="feather icon-refresh-ccw"></i> </a>');
                },
                complete: function (xhr, status) {
                    $('#' + table + slave + constrain).html('<label class="badge badge-success">' + status + '</label>');
                    if (xhr.status == 500) {
                        $('.panel_error').show();
                       // $('.error_message').html(xhr.responseText);
                         toastr.error('Error: Sync failed check error logs')
                    }
                },

                success: function (data) {
                    $(this).hide();
                    toastr.success('Sync success')
                    window.location.reload(); 
                }
            });


        });
    }
    $(document).ready(sync_relation);

</script>
@endsection

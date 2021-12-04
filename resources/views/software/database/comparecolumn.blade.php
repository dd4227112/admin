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
                <h4><?='Compare column' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">table columns</a>
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
                        <div class="table-responsive">
                            <table class="table dataTable table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Schema Name</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($d as $schema) {
                                        ?>
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$schema->table_schema}}</td>
                                            <td>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Table</th>
                                                            <th>Missing Column</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $schema = $schema->table_schema;
                                                        foreach ($master_tables as $table) {

                                                            $master_columns = $columns[SCHEMA::$master_schema][$table];
                                                            $slave_columns = isset($columns[$schema][$table]) ? $columns[$schema][$table] : array();
                                                            $missing_columns = array_diff($master_columns, $slave_columns);
                                                            if (!empty($missing_columns)) {
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        {{$table}}
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <table class="table">
                                                                            <?php foreach ($missing_columns as $column) { ?>
                                                                                <tr>
                                                                                    <td>{{$column}}</td>
                                                                                    <td><a href="#" onclick="return false" data-table='{{$table}}' data-slave='{{$schema}}' data-column='{{$column}}' class="sync_column btn btn-mini btn-round btn-primary">Sync </a>
                                                                                        <span id="{{$table.$schema.$column}}"></span>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
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
    sync_column = function () {
        $(".sync_column").mousedown(function (event) {
            var slave = $(this).attr('data-slave');
            var table = $(this).attr('data-table');
            var column = $(this).attr('data-column');
            $(this).hide();
            $.ajax({
                type: 'GET',
                url: "<?= url('software/syncColumn/null') ?>",
                data: {
                    "column": column,
                    "table": table,
                    "slave": slave
                },
                dataType: "html ",
                beforeSend: function (xhr) {
                    $('#' + table + slave + column).html('<a href="#/refresh"> <i class="feather icon-refresh-ccw"></i></a>');
                },
                complete: function (xhr, status) {
                    $('#' + table + slave + column).html('<label class="badge badge-success">' + status + '</label>');
                        if(xhr.status == 500) {
                         toastr.error('Error: Comparison failed check error logs')
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
    $(document).ready(sync_column);

</script>
@endsection

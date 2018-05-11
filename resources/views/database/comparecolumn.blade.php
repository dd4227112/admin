@extends('layouts.app')
@section('content')
<?php

use \App\Http\Controllers\DatabaseController as SCHEMA;

$database = new SCHEMA();
?>
<div class="white-box">
    <div class="table-responsive">
        <table class="table">
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
                foreach ($data as $schema) {
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
                                    $master_tables = $database->loadTables(SCHEMA::$master_schema);
                                    //load all column in this main table
                                    $schema = $schema->table_schema;
                                    foreach ($master_tables as $table) {
                                        # code...
                                        $master_columns = $database->loadTableColumns(SCHEMA::$master_schema, $table);
                                        $slave_columns = $database->loadTableColumns($schema, $table);
                                        //missing columns
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
                                                                <td><a href="#" onclick="return false" data-table='{{$table}}' data-slave='{{$schema}}' data-column='{{$column}}' class="sync_column">Sync </a>
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
<script type="text/javascript">
    sync_column = function () {
        $(".sync_column").mousedown(function (event) {
            var slave = $(this).attr('data-slave');
            var table = $(this).attr('data-table');
            var column = $(this).attr('data-column');
             $(this).hide();
            $.ajax({
                type: 'GET',
                url: "<?= url('database/syncColumn') ?>",
                data: {
                    "column": column,
                    "table": table,
                    "slave": slave
                },
                dataType: "html ",
                beforeSend: function (xhr) {
                    $('#' + table + slave + column).html('<a href="#/refresh"><i class="fa fa-spin fa-refresh"></i> </a>');
                },
                complete: function (xhr, status) {
                    $('#' + table + slave + column).html('<span class="label label-success label-rouded">' + status + '</span>');
                },

                success: function (data) {
                    $(this).hide();
                }
            });


        });
    }
    $(document).ready(sync_column);

</script>
@endsection

@extends('layouts.app')
@section('content')
<?php

use \App\Http\Controllers\DatabaseController as SCHEMA;

$database = new SCHEMA();
$master_tables = $database->loadTables(SCHEMA::$master_schema);
$columns = $database->loadTableColumnsBulks();
$d = $database->loadSchema();
?>
<div class="white-box">
    <div class="white-box">
        <center>
            <h3 class="box-title m-b-0">Constrains Relations</h3>
            <p class="text-muted m-b-30 font-13"> Choose constrain to compare</p>
        </center>    
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
    <div class="row">
        <div class="panel panel-default panel_error" style="display: none;">
            <div class="panel-heading">Error Message
                <div class="panel-action"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a></div>
            </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body error_message"> </div>
            </div>
        </div>
    </div>
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
                                        <th>Constrains Column</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $schema = $schema->table_schema;
                                    foreach ($master_tables as $table) {

                                        $master_columns = isset($constrains[SCHEMA::$master_schema][$table]) ? $constrains[SCHEMA::$master_schema][$table] : array();
                                        $slave_columns = isset($constrains[$schema][$table]) ? $constrains[$schema][$table] : array();
                                        $missing_constrains = array_diff($master_columns, $slave_columns);
                                        if (!empty($missing_constrains)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    {{$table}}
                                                </td>
                                                <td colspan="2">
                                                    <table class="table">
                                                        <?php foreach ($missing_constrains as $constrain) { ?>
                                                            <tr>
                                                                <td>{{$constrain}}</td>
                                                                <td><a href="#" onclick="return false" data-table='{{$table}}' data-slave='{{$schema}}' data-constrain='{{$constrain}}' data-relation="{{$sub}}" class="sync_relation">Sync </a>
                                                                    <span id="{{$table.$schema.$constrain}}"></span>
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
    $('#check_key').change(function () {
        var val = $(this).val();
        window.location.href = "<?= url('database/constrains') ?>/" + val;
    })

    sync_relation = function () {
        $(".sync_relation").mousedown(function (event) {
            var slave = $(this).attr('data-slave');
            var table = $(this).attr('data-table');
            var constrain = $(this).attr('data-constrain');
            var relation_type = $(this).attr('data-relation');
            $(this).hide();
            $.ajax({
                type: 'GET',
                url: "<?= url('database/syncConstrain') ?>",
                data: {
                    "constrain": constrain,
                    "table": table,
                    "slave": slave,
                    relation_type: relation_type
                },
                dataType: "html ",
                beforeSend: function (xhr) {
                    $('#' + table + slave + constrain).html('<a href="#/refresh"><i class="fa fa-spin fa-refresh"></i> </a>');
                },
                complete: function (xhr, status) {
                    $('#' + table + slave + constrain).html('<span class="label label-success label-rouded">' + status + '</span>');
                    if (xhr.status == 500) {
                        $('.panel_error').show();
                        $('.error_message').html(xhr.responseText);
                    }
                    console.log(xhr);
                },

                success: function (data) {
                    $(this).hide();
                }
            });


        });
    }
    $(document).ready(sync_relation);

</script>
@endsection

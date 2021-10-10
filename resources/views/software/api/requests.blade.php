@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
    
        <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">

                            <div class="table-responsive dt-responsive "> 
                                <table id="api_requests" class="table table-striped dataTable table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Request Payload</th>
                                            <th>Created At</th>
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

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#api_requests').DataTable({
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
                'url': "<?= url('software/api/null?tag=get') ?>"
            },
            "columns": [
                {"data": "id"},
                {"data": "content"},
                {"data": "created_at"},
                {"data": ""}
            ],
            "columnDefs": [
                {
                    "targets": 3,
                    "data": null,
                    "render": function (data, type, row, meta) {

                        return '<a href="#" id="' + row.id + '" class="label label-danger dlt_log" onmousedown="delete_log(' + row.id + ')" onclick="return false">Delete</a>';


                    }

                }
            ],

            rowCallback: function (row, data) {
                //$(row).addClass('selectRow');
                $(row).attr('id', 'log' + data.id);
            }
        });
        delete_log = function (a) {
            $.ajax({
                url: '<?= url('software/logsDelete') ?>/null',
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

</script>
@endsection


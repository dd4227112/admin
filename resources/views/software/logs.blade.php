@extends('layouts.app')
@section('content')

<div class="main-body">
 <div class="page-wrapper">

        <div class="page-header">
        <div class="page-header-title">
            <h4><?='SMS Status' ?></h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">loans</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">payroll</a>
                </li>
            </ul>
        </div>
    </div> 


        <div class="page-body">
            <div class="card">
                <div class="card-header" style="margin-bottom: -20px;">
                    <h6 ><strong><?= isset($school->name) ? $school->name. ' errors' :  'Errors' ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= $errors->count() >= 10 ? '<label class="badge badge-inverse-danger">' . $errors->count() . '</label>' : '<label class="badge badge-inverse-info">'  .$errors->count().  '</label>'?>
                        <a onmousedown="delete_log('<?= $id ?>')" onclick="return false" href="" class="float-right btn btn-mini btn-round btn-danger">delete</a>
                    </h6> 
                </div>
                <div class="card-block">
                        <p style="font-weight: 500;margin-bottom:-15px;">Error  Message</p> <br>
                        <p style="font-weight: 600"> <?= $tag->error_message ?></p>

                        <p style="font-weight: 500;margin-bottom:-15px;">Error Instance</p> <br>
                        <p style="font-weight: 600"> <?= $tag->error_instance ?></p>
                </div>


               <div class="card-block">
                <div class="table-responsive">
		          <?php if(isset($errors) && !empty($errors)) { ?>
                    <table class="table dataTable table-sm table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Route</th>
                                <th>Url</th>
                                <th>Schema</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($errors as $value) { ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                     <td>
                                        <?php echo $value->file; ?>
                                    </td>
                                    <td>
                                        <?php echo $value->route; ?>
                                    </td>
                                    <td>
                                        <?php echo $value->url; ?>
                                    </td>
                                    <td>
                                        <?php echo $value->schema_name; ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y H:i:s', strtotime($value->created_at)); ?>
                                    </td>
                                </tr>
                            <?php $i++; } ?>
                         </tbody>
                      </table>
                    </div>
		            <?php } ?>
                </div>


                </div>
         </div>


<script type="text/javascript">

    $(document).ready(function() {
       $('#example').DataTable();
    });

   
    $(document).ready(function() {
      delete_log = function (a) {
        $.ajax({
            url: '<?= url('software/logsDelete') ?>/null',
            method: 'get',
            data: {id: a},
            success: function (data) {
                if (data == '1') {
                    window.location.href='<?= url('software/logs') ?>';
                    toastr.success('Error deleted successfully!');
                } else{
                    toastr.error('No Error deleted!');
                }
            }
        });
     }
});


    
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

    // $(document).ready(function () {
    //     var table = $('#simpletable_resolved_errors').DataTable({
    //         "processing": true,
    //         "serverSide": true,
    //         'serverMethod': 'post',
    //         'ajax': {
    //             'headers': {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             'url': "<?= url('sales/show/null?page=errors_resolved') ?>"
    //         },
    //         "columns": [
    //             {"data": "schema_name"},
    //             {"data": "error_message"},
    //             {"data": "file"},
    //             {"data": "url"},
    //           //  {"data": "created_by"},
    //             {"data": "deleted_at"},
    //             {"data": "resolved_by"}
    //         ],

    //         rowCallback: function (row, data) {
    //             $(row).attr('id', 'log' + data.id);
    //         }
    //     });
    // });


    $('#schema_select').select2({
        placeholder: "Select a State",
        allowClear: true
    });
</script>
@endsection

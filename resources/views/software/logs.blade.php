@extends('layouts.app')
@section('content')
<?php 
//    function getUser($schema,$id){
//       return \DB::table('admin.all_users')->select('name','usertype')->where(['schema_name'=>$schema,'id'=>$id])->first();
// }
?>
<div class="main-body">
 <div class="page-wrapper">
     <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
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

<<<<<<< HEAD
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
                                    <?= $all_error_logs->total ?>
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
                            <h5>Distinct Errors</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-ui-user-group text-warning"></i>
                                </li>
                                <li class="text-right text-warning">
                                    <?= $error_log_count->total ?>
                                </li>
                            </ul>
                        </div>
=======
                        <p style="font-weight: 500;margin-bottom:-15px;">Error  Instance</p> <br>
                        <p style="font-weight: 600"> <?= $tag->error_instance ?></p>
                </div>
          </div>
         
        <div class="card"> 
            <div class="card-block">
                <div class="table-responsive">
                    <table id="example"  class="table dataTable table-sm table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Files</th>
                                <th>Urls</th>
                                <th>Schema name</th>
                                <th>Created by</th>
                                <th>Created date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($errors as $error) { ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= warp($error->file,15)?></td>
                                    <td><?= warp($error->url,10)?></td>
                                    <td><?= $error->schema_name?></td>
                                    <td><?= !is_null($error->created_by) ? $error->created_by : '' ?></td>
                                    <td><?= date('d-m-Y H:i:s',strtotime($error->created_at))?></td>
                                </tr>
                            <?php $i++;} ?>
                         </tbody>
                      </table>
>>>>>>> admin2.0
                    </div>
                   </div>
                </div>
<<<<<<< HEAD
                <!-- New clients card end -->
                <!-- New files card start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks danger-border">
                        <div class="card-block">
                            <h5>Fatal Errors </h5>
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
                            <h5>Resolved Errors</h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-ui-folder text-primary"></i>
                                </li>
                                <li class="text-right text-primary">
                                     <?= $resolved_log_count->total ?> 
                                       
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Open Project card end -->
                <div class="col-md-12 col-xl-12">
                    <div class="form-group row col-lg-offset-6">
                        <label class="col-sm-4 col-form-label"><?= isset($schema_name) ? $schema_name. ' errors': 'Select School' ?></label>
                        <div class="col-sm-4">
                            <select name="select" class="form-control select2" id="schema_select">
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
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                    <strong>( <?= isset($all_error_logs->total) ? ($all_error_logs->total) : '' ?>)</strong> Errors
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
                                                    <!-- <th>Action</th> -->
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
                                                    <!-- <th>Created By</th> -->
                                                    <th>Action</th> 
                                                </tr>
                                            </thead>

                                         

                                        </table>
                                    </div>
                                </div>
                             <?php } ?>

=======

                
>>>>>>> admin2.0

                   

             

        

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

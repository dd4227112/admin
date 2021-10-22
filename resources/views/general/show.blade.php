@extends('layouts.app')
@section('content')


<div class="main-body">
    <div class="page-wrapper">

        <div class="page-header">
            <div class="page-header-title">
                <h4><?='Whatsapp Integration' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">integration</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 
       
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card rd">

                        <div class="tab-content">
                            <div class="card-block">
                                <h2>
                                    <a href="#model"  onclick="$('#edit_hidden').val('')" class="btn btn-primary btn-mini btn-round" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-responsive">Add New</a></h2>
                                    <div class="card-block">
                                        <div class="table-responsive dt-responsive">
                                            <?php
                                            if (!empty($headers)) { ?>
                                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th><input type="checkbox" name="all" id="toggle_all"> </th>
                                                            <?php
                                                            $vars = get_object_vars($headers);
                                                            $except = array('id', 'updated_at');
                                                            ?>

                                                            <?php
                                                            foreach ($vars as $key => $value) {
                                                                if (!in_array($key, $except)) {
                                                                    ?>
                                                                    <th><?= $key ?></th>

                                                                    <?php
                                                                }
                                                            }
                                                            ?>

                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($contents as $content) {
                                                            $i++;
                                                            ?> 

                                                            <tr>
                                                                <td><?= $i ?></td>
                                                                <?php
                                                                foreach ($vars as $key => $value) {
                                                                    if (!in_array($key, $except)) {

                                                                        //special conditions
                                                                        if ($key == 'user_id') {
                                                                            $user = DB::table('users')->where('id', $content->{$key})->first();
                                                                            echo '<td>' . $user->firstname . ' ' . $user->lastname . '</td>';
                                                                        } else {
                                                                            ?> 
                                                                            <td><?= $content->{$key} ?></td>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                <td>
                                                                    <a class="btn btn-info btn-sm" onclick="edits(<?= $content->id ?>)" href="#model" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-responsive" tag="{{$content->id}}">Edit</a>
                                                                    {{-- <a class="btn btn-warning btn-sm" href="{{ url('general/delete/'.$content->id) }}">Delete</a> --}}
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>


                        </div>
                    </div>



                </div>
            </div>
            <!-- Page-body end -->
        </div>
    </div>
    <!-- Main-body end -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel"></h4> </div>
                <form action="#" method="post">
                    <div class="modal-body">
                        <span>
                            Create a task with implementation deadline</span>
                        <br>
                        <?php
                        if (!empty($headers)) {
                            ?>
                            <?php
                            foreach ($vars as $key => $value) {

                                if ($key == 'id') {
                                    ?>
                                    <input type="hidden" class="form-control" id="edit_input" name="id" value="" >
                                    <?php
                                }
                                if (in_array($key, ['id', 'created_at', 'updated_at'])) {
                                    continue;
                                }
                                ?>
                                <div class="form-group" id="client_id">
                                    <strong>  <?= $key ?></strong> 
                                    <input type="text" class="form-control" id="<?= $key ?>" name="<?= $key ?>" value="<?= old($key) ?>" >

                                </div>

                                <?php
                            }
                        }
                        ?>

                    </div>
                    <input type="hidden" name="edit" value="" id="edit_hidden"/>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                    </div>
                    <?= csrf_field() ?>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @endsection
    @section('footer')
    <!-- data-table js -->
    <?php $root = url('/') . '/public/' ?>

    <script type="text/javascript">
        function edits(a) {
            $('#edit_hidden').val('1');
            $('#edit_input').val(a);
        }
        allocate = function () {
            $('.allocate').change(function () {
                var user_id = $('option:selected', this).attr('user_id');
                var school_id = $('option:selected', this).attr('school_id');
                var role_id = $('option:selected', this).attr('role_id');
                var schema = $('option:selected', this).attr('schema');
                var val = $(this).val();
                $.ajax({
                    type: 'post',
                    url: '<?= url('customer/allocate') ?>',
                    data: {
                        user_id: user_id,
                        school_id: school_id,
                        role_id: role_id,
                        schema: schema,
                        val: val
                    },
                    dataType: 'html',
                    success: function (data) {
                        /// alert('success',data);
                        $('#status_result_' + role_id + '_' + schema).html('<b class="label label-success">success</b>');

                    }
                });
            });
        }
        $('#school_id').keyup(function () {
            var val = $(this).val();
            $.ajax({
                url: '<?= url('customer/search/null') ?>',
                data: {
                    val: val,
                    type: 'school',
                    schema: ''
                },
                dataType: 'html',
                success: function (data) {

                    $('#search_result').html(data);
                }
            });
        });


        get_statistic = function () {
            // var data = getData();
            // console.log(data);
            //        $(".get_data").each(function (index) {
            //            var tag = $(this).attr('tag');
            //            var schema = $(this).attr('schema');
            //            //$(schema + tag).html(1);
            //
            //
            //        });
        }

        function getData() {
            $.ajax({
                type: 'get',
                url: '<?= url('customer/getData/null/') ?>',
                data: {
                    tag: 'users'
                },
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (i, info) {
                        $(".get_data").each(function (index) {
                            var tag = $(this).attr('tag');
                            var schema = $(this).attr('schema');

                            if (tag == info.table && schema == info.schema_name) {
                                $('#' + schema + tag).html(info.count);
                            }


                        });

                    });
                    return data;
                },
                error: function () {
                    return 2;
                }

            });
        }
        search_checked = function () {



            $('.check').click(function () {
                var value = $(this).val();
                var status = $(this).is(':checked');
                //uncheck "select all", if one of the listed checkbox item is unchecked
                if (false == $(this).prop("checked")) { //if this item is unchecked
                    $("#toggle_all").prop('checked', false); //change "select all" checked status to false
                    $('#delete_all_invoices').hide();

                }
                //check "select all" if all checkbox items are checked

                if ($('.check:checked').length == $('.check').length) {
                    $("#toggle_all").prop('checked', true);
                    $('#notify_schools').hide();
                    $('#notify_schools').show();

                } else if ($('.check:checked').length != null) {
                    $('#notify_schools').show();
                }

                if (status === true) {
                    //var text = $('#row' + value).html();
                    $('#search_checked_table').show();

                    var ex = $('#schools_mapped').val();
                    console.log(ex);
                    var param = ex.split(",");
                    param.push(value);
                    $('#schools_mapped').val(param.join(","));
                    console.log(param);

                } else {

                    var ex = $('.link').attr('tags');
                    var url = '<?= url('invoices/delete_class_invoice/?ids=') ?>';
                    var param = ex.split(",");
                    param = jQuery.grep(param, function (val) {
                        return val != value;
                    });
                    var arr = param;

                    var result = arr.filter(function (elem) {
                        return elem != value;
                    });
                    console.log(result);
                    $('#schools_mapped').val(result.join(","));
                    $('#delete_all_invoices').attr('tags', result.join(","));
                    $('#delete_all_invoices').attr('href', url + result.join(","));
                    $('#delete_selected_invoices').attr('tags', result.join(","));
                    $('#delete_selected_invoices').attr('href', url + result.join(","));

                    $('#s_table' + value).remove();
                }
            });
        }
        $(document).ready(get_statistic);
        $(document).ready(allocate);
        $(document).ready(search_checked);
    </script>
    @endsection
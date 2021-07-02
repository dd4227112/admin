@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Schools SMS Status</h4>
                <span>All schools SMS status</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Customer Support</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Modules Usage</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
          
                    <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#home3" role="tab" aria-expanded="false">
                                    SMS Status
                                </a>
                                <div class="slide"></div>
                            </li>
                            
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                <div class="card-block">
                                    <div class="steamline">
                                        <div class="card-block">

                                            <div class="table-responsive dt-responsive">
                                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th># </th>
                                                            <th>School Name</th>
                                                            <th>Status </th>
                                                            <th>Api Key</th>
                                                            <th>Contacts</th>
                                                            <th>last Active</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; $cont = [];
                                                         $contacts = DB::table('admin.all_users')->where('usertype','Admin')->where('status','1')->get();
                                                         foreach ($contacts as $contact) {
                                                              $cont[$contact->schema_name] = $contact->phone;
                                                         }
                                                         if(count($sms_status) > 0)  
                                                          foreach ($sms_status as $status) { 
                                                    
                                                            ?>
                                                            <tr>
                                                               <td>
                                                                 <?= $i ?>
                                                                </td>
                                                                <td>
                                                                   <?= $status->schema_name ? warp(school_full_name($status->schema_name)) : '' ?></td>
                                                                 <td> 
                                                                    <?= $status->last_active == '' ? '<b class="label label-warning">Not Installed</b>' : '<b class="label label-info">Installed</b>' ?>
                                                                  </td>
                                                                  <td><?= $status->api_key ?></td>
                                                                 <td>
                                                                 <?php
                                                                    if(isset($cont[$status->schema_name])) {
                                                                        echo $cont[$status->schema_name] .'<br/>';
                                                                    } else {
                                                                        echo '<b class="label label-info">Not Specified</b>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                  <td><?= isset($status->last_active) ? \Carbon\Carbon::parse($status->last_active)->diffForHumans() : '' ?></td>
                                                            </tr>
                                                            <?php $i++; } ?>
                                                        
                                                       
                                                    </tbody>
                                               
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                                <div class="email-card p-0">
                                    <div class="card-block">
                                        <h6>
                                            <b>User Allocation Summary</b>
                                        </h6>
                                        <div class="mail-body-content">
                                            <table class="table">

                                           
                                            
                                               
                                            </table>
                                        </div>
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
    @endsection
    @section('footer')
    <!-- data-table js -->
    <?php $root = url('/') . '/public/' ?>

    <script type="text/javascript">
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
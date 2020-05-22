@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Add Call Summary</h4>
                <span>This assist the team to know what are the most challenge and find solution for them</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Customer</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Calls</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">

                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                    <strong>Create Single Call Summary</strong> 
                                </a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item complete">
                                <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false">Upload Call Summary From Excel</a>
                                <div class="slide"></div>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                <div class="card-block">


                                    <div class="panel-body">
                                        <div id="error_area"></div>
                                        <div class=" form">
                                            <form class="cmxform form-horizontal " id="commentForm" method="post" action="<?= url('customer/addCall') ?>">

                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Call Source (Required)</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control select2_single select2" id="client_id"  name="source">
                                                            <option value="Parent">Parent</option>
                                                            <option value="Student">Student</option>
                                                            <option value="Teacher">Teacher</option>
                                                            <option value="User">Staff</option>
                                                            <option value="Admin">Admin</option>
                                                            <option value="Partner">Partner</option>
                                                            <option value="Lead">Lead (wants a solution)</option>
                                                            <option value="Other">Other (non from above)</option>
                                                        </select>

                                                    </div>
                                                    <?php echo form_error($errors, 'client_id'); ?>
                                                    <div class="col-lg-6"> <span id="client_id_error"></span></div>
                                                </div>
                                                   <div class="form-group ">
                                                    <label for="type" class="control-label col-lg-3">Call Type (Required)</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control select2_single select2" id="client_id"  name="type">
                                                            <option value="Incoming">Incoming</option>
                                                            <option value="Outgoing">Outgoing</option>
                                                        </select>

                                                    </div>
                                                    <?php echo form_error($errors, 'client_id'); ?>
                                                    <div class="col-lg-6"> <span id="client_id_error"></span></div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="name" class="control-label col-lg-3">Source Name</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" name="name" id="date" class="form-control"/>

                                                    </div>
                                                    <?php echo form_error($errors, 'name'); ?>
                                                    <div class="col-lg-6"> <span id="date_error"></span></div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="phone" class="control-label col-lg-3">Phone</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" name="phone" id="date" class="form-control"/>

                                                    </div>
                                                    <?php echo form_error($errors, 'phone'); ?>
                                                    <div class="col-lg-6"> <span id="date_error"></span></div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Date (Required)</label>
                                                    <div class="col-lg-6">
                                                        <input type="date" name="date" id="date" class="form-control"/>

                                                    </div>
                                                    <?php echo form_error($errors, 'date'); ?>
                                                    <div class="col-lg-6"> <span id="date_error"></span></div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">School(Required)</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control select2_single select2" id="client_id"  name="schema_name">
                                                            <?php
                                                             $sql2 = 'select * from admin.all_setting ';
                                                                $schools = DB::select($sql2);
                                                                foreach ($schools as $school) {
                                                            ?>
                                                            <option value="<?=$school->schema_name?>"><?=$school->schema_name?></option>
                                                                <?php } ?>
                                                            <option value="other">Others (not from school)</option>
                                                       
                                                        </select>

                                                    </div>
                                                    <?php echo form_error($errors, 'client_id'); ?>
                                                    <div class="col-lg-6"> <span id="client_id_error"></span></div>
                                                </div>
<div class="form-group ">
                                                    <label for="about" class="control-label col-lg-3">Call About (Write short why user call/called)</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" name="about" id="date" class="form-control"/>

                                                    </div>
                                                    <?php echo form_error($errors, 'about'); ?>
                                                    <div class="col-lg-6"> <span id="date_error"></span></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                        <?= csrf_field() ?>
                                                        <button class="btn btn-primary" type="submit" id="noexcel">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                                <div class="card-block">

                                    <div class="table-responsive dt-responsive">
                                        <div class="card-header">
                                            <div class="panel-body">
                                                <div class="alert alert-info">Kindly export call logs from Call History Software available in mobile phone and upload it here</div>
                                                <!--<p>Sample Excel Format. </p>-->
                                                <!--<img src="<?= url('public/images/sample_excel.jpg') ?>"/>-->
                                                <br/>
                                                <div class=" form">
                                                    <br/>
                                                    <form class="cmxform form-horizontal " id="commentForm" method="post" action="<?= url('customer/addCall') ?>" enctype="multipart/form-data">


                                                        <div class="form-group ">
                                                            <label for="cname" class="control-label col-lg-3">Choose Excel File (required)</label>
                                                            <div class="col-lg-6">
                                                                <input class=" form-control" id="cname" name="file" type="file" required="" accept=".xls,.xlsx,.csv">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <div class="col-lg-offset-3 col-lg-6">
                                                                <?= csrf_field() ?>
                                                                <button class="btn btn-primary" type="submit">Upload Call Logs</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalEmployer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal " id="commentForm" method="post" action="<?= url('user') ?>">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add New Entity</h4>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        <div class=" form">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3">Name (required)</label>
                                <div class="col-lg-6">
                                    <input class=" form-control" id="cname" name="name" minlength="2" type="text" required="">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3">Abbreviation</label>
                                <div class="col-lg-6">
                                    <input class=" form-control" id="cname" name="abbreviation"  type="text" required="">
                                </div>
                            </div>
                            <div class="form-group " style="display: none;">
                                <label for="cemail" class="control-label col-lg-3">E-Mail (required)</label>
                                <div class="col-lg-6">
                                    <input class="form-control " id="cemail" type="email" name="email" required="" value="<?= time() . 'jkdjs@engineers.co.tz' ?>">
                                </div>
                            </div>
                            <!--                                            <div class="form-group ">
                                                                            <label for="curl" class="control-label col-lg-3">Phone (required)</label>
                                                                            <div class="col-lg-6">
                                                                                <input class="form-control " id="curl" type="text" name="phone">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <label for="ccomment" class="control-label col-lg-3">Location(required)</label>
                                                                            <div class="col-lg-6">
                                                                                <textarea class="form-control " id="ccomment" name="location" required=""></textarea>
                                                                            </div>
                                                                        </div>-->

                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <?= csrf_field() ?>
                    <input type="hidden" name="user" value="employer"/>
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button class="btn btn-success" type="submit">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    single_no_excel_submit = function () {

        $('#noexcel').mousedown(function () {
            var client_id = $('#client_id').val();
            var project_id = $('#project_id').val();
            var date = $('#date').val();
            var force_new = $('#force_new').is(':checked');

            var ary = [];

            if (parseInt(project_id) < 1 || project_id == null) {
                $('#project_id_error').html('<div class="alert alert-danger">Please Select Project Name First</div>');
                return false;
            }
            if (parseInt(client_id) < 1 || client_id == null) {
                $('#client_id_error').html('<div class="alert alert-danger">Please Select Client Name First</div>');
                return false;
            }
            if (date == null || date == '') {
                $('#date_error').html('<div class="alert alert-danger">Please Select Date First</div>');
                return false;
            }

            $('#user_area tr').each(function (a, b) {
                var name = $('.name', b).text();
                var quantity = $('.quantity', b).text();
                var unit_price = $('.unit_price', b).text();
                var project = $('.project', b).text();
                if (quantity == '' || name == '' || unit_price == '' || project == '') {
                    $('#table_error_area').html('<br/><div class="alert alert-danger">Please fill all table inputs well </div>');
                    return false;
                }

                ary.push({name: name, quantity: quantity, unit_price: unit_price, project: project});

            });
            //alert(JSON.stringify(ary));
            $.ajax({
                type: 'get',
                url: "<?= url('account/createInvoice') ?>/null",
                data: {date: date, client_id: client_id, noexcel: 1, users: ary, project_id: project_id, force_new: force_new},
                dataType: "html",
                success: function (data) {
                    if (data == '1') {
                        window.location.href = "<?= url('account/invoice') ?>";
                    } else {
                        $('#table_error_area').html(data);
                    }
                }
            });
        });
    }
    checkClient = function () {
        $('#project_id').change(function () {
            var project_id = $(this).val();
            $.ajax({
                type: 'get',
                url: "<?= url('account/getClient') ?>/null",
                data: {project_id: project_id},
                dataType: "html",
                success: function (data) {
                    console.log(data);
                    $('#client_id').html(data);
//                    if (data === 'success') {
//$('#home7').html('<div clas="alert alert-success">Recorded successfully. To add new record, please refresh </div>');
//
//                    }

                }
            });
        });

    }
    $(document).ready(checkClient);
    $(document).ready(single_no_excel_submit);
</script>
@endsection



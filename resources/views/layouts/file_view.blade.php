@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>File View</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Company</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">File</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
   <div class="page-body">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Default card start -->
                        <div class="card">                            
                            <div class="card-block">
                            
                                
                                        <iframe src="https://docs.google.com/gview?url=<?= $path ?>&embedded=true" style="width:100%; height:450px;" frameborder="0" class="col-lg-12 col-md-8" title="File View"></iframe>
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



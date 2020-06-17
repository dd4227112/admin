@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>ShuleSoft User Guide</h4>
                <span>This specify instructions on how to use ShuleSoft system</span>
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
                    <li class="breadcrumb-item"><a href="#!">ShuleSoft Guide</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Guide</h5>
                            <span>You can view and edit user manual contents</span>
                           
                            <div class="row">
                                <div class="col-md-12">
                                    <p align='left'>
                                        <a class="btn btn-success" href="<?= url('customer/guide/null?pg=add') ?>">Add New Guide</a></p>
                                    <br/>
                                </div>
                            </div>
                        </div>

                        <div class="card-block">

                            <div class="table-responsive dt-responsive">

                                <table id="example23" class="display nowrap table dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Access Title</th>
                                            <th>Module Name</th>
                                            
                                            <th>Created By</th>  
                                            <th>Last Updated</th>
                                            <th>Page Views</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (count($guides) > 0) {
                                            foreach ($guides as $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= isset($value->permission->display_name) ? $value->permission->display_name : '' ?></td>
                                                    <td><?= isset($value->permission->permissionGroup->name) ? $value->permission->permissionGroup->name : '' ?></td>
                                                   
                                                    <td><?= $value->createdBy->firstname . ' ' . $value->createdBy->lastname ?></td>
                                                    <td><?= $value->updated_at ?></td>
                                                    <td><?=$value->guidePageVisit()->count()?></td>
                                                    <td>
                                                        <a href="#"  data-toggle="modal" data-target="#exampleModal<?= $i ?>" data-whatever="@mdo" class="btn btn-success btn-sm">View</a>
                                                        <div class="modal fade bs-example-modal-lg" id="exampleModal<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="display: none;">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span></button>
                                                                        <h4 class="modal-title" id="exampleModalLabel1">How to <?= $value->permission->display_name ?></h4> </div>
                                                                    <div class="modal-body">
                                                                        <?= $value->content ?>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php echo '<a  href="' . url("/customer/guide/edit/$value->id") . ' " class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> ' . __('edit') . ' </a>' ?>
                                                        <?php echo '<a  href="' . url("customer/guide/delete/$value->id") . ' " class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> ' . __('delete') . ' </a>' ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
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
    content_for = function () {
        $('#permission_group').change(function () {
            var group_id = $(this).val();
            if (group_id === '0') {
                $('#content_for').val(0);
            } else {
                $.ajax({
                    type: 'get',
                    url: "<?= url('support/getPermission') ?>",
                    data: "group_id=" + group_id,
                    dataType: "html",
                    success: function (data) {
                        $('#content_for').html(data);
                    }
                });
            }
        });
    }
    $(document).ready(content_for);
</script>
@endsection
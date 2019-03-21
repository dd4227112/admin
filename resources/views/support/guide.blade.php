@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <p align='left'>
            <a class="btn btn-success" href="<?= url('support/guide?pg=add') ?>">Add New Guide</a></p>
        <br/>
    </div>
</div>

<div class="modal-content">
    <table id="example23" class="display nowrap table color-table success-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Access Title</th>
                <th>Module Name</th>
                <th>Content </th>
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
                        <td><?= $value->permission->display_name ?></td>
                        <td><?= $value->permission->permissionGroup->name ?></td>
                        <td><a href="#"  data-toggle="modal" data-target="#exampleModal<?= $i ?>" data-whatever="@mdo">View</a>
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


                        </td>
                        <td><?= $value->createdBy->firstname . ' ' . $value->createdBy->lastname ?></td>
                        <td><?= $value->updated_at ?></td>
                        <td></td>
                        <td>
                            <?php echo '<a  href="' . url("/support/guide/edit/$value->id") . ' " class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> ' . __('edit') . ' </a>' ?>
                            <?php echo '<a  href="' . url("support/guide/delete/$value->id") . ' " class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> ' . __('delete') . ' </a>' ?>
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


@section('footer')
@include('layouts.datatable')
@endsection
<script type="text/javascript">
    content_for = function () {
        $('#permission_group').change(function () {
            var group_id = $(this).val();
            if (group_id === '0') {
                $('#content_for').val(0);
            } else {
                $.ajax({
                    type: 'POST',
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
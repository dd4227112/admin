@extends('layouts.app')
@section('content')

<?php $root = url('/') . '/public/' ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Permissions</a></li>
                    <li class="breadcrumb-item active">Manage Permissions</li>
                </ol>
            </div>
            <h4 class="page-title">Manage Permission</h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>

<div class="row">
    <div class="col-md-6">
        <?php 
        if(!empty($Permissiongroup)){?>
            <button class="btn btn-primary btn-sm add-permission" role="button"> Add Permissions</i></button>
        <br/>
        <?php }?>
     </div>
    <div class="col-md-3">
        <label for="guide_type">Permission Group</label>
        <select class="form-control select2" id="permission_group">
            <option  value=""></option>
            <option  value="Add">Add New Permission Group</option>
            <?php 
            if(!empty($Permissiongroup)) {
            foreach($Permissionsgroups as $Permissionsgroup) {
            ?>
            <option  value="<?=$Permissionsgroup->id?>" <?=$Permissionsgroup->id==$Permissiongroup->id ? 'selected' : ''?>><?=$Permissionsgroup->name?></option>

            <?php  }
            } else{
            foreach($Permissionsgroups as $Permissionsgroup) {
            ?>
            <option  value="<?=$Permissionsgroup->id?>"><?=$Permissionsgroup->name?></option>
            <?php  }
            }?>
        </select>
        <br/>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div id="hide-table">
                    <table id="example1" class="table dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Display Name</th>
                                <th>Description</th>  
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($permissions)) {
                                $i = 1;
                                foreach ($permissions as $permission) {
                                    ?>
                                   <tr>
                                            <td><?= $i ?></td>
                                            <td><?=$permission->name ?></td>
                                            <td><?=$permission->display_name ?></td>
                                            <td><?=$permission->description ?></td>
                                            <td>
                                                <a  id="<?=$permission->id ?>" class ="btn btn-sm btn-primary edit_permission" href="">Edit</a>
                                                <a class="btn btn-sm btn-danger" href="">Delete</a>
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


<!-- Add permission modal -->
<div class="modal fade" id="addpermission">
    <div class="modal-dialog">
        <form  action="<?=base_url('Role/add_permission')?>" method="post" class="form-horizontal group_form " role="form">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Permission</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label> Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Permission name" name="name" required>
                                    <input type="hidden" name="permission_group_id" value="<?=$Permissionsgroup->id?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label> Display Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Display name"
                                        name="display_name" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label> Description </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Permission description"
                                        name="description" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Edit permission modal -->
<div class="modal fade" id="editpermission">
    <div class="modal-dialog">
        <form  action="<?=base_url('Role/add_permission')?>" method="post" class="form-horizontal group_form " role="form">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Permission</h5>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label> Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Permission name" name="name" required>
                                        <input type="hidden" name ="permission_group_id" value=" <?=$Permissionsgroup->id?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label> Display Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Display name"
                                        name="display_name" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label> Description </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Permission description"
                                        name="description" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>
    </div>
</div>


<script>
        $(document).ready(function(){
            $('.edit_permission').on('click', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $('#editpermission').modal('show');
        });
        $('.add-permission').on('click', function(){
            $('#addpermission').modal('show');
            
        });

        $('#permission_group').on('change', function () {
            var val = $(this).val();
            if(val == 'Add'){
                // $('#addPermissionGroup').modal('show');
            window.location.href = '<?= url('role/add_permission') ?>';
            }else{
        window.location.href = '<?= url('role/getPermisssions/null?permission=') ?>' + val;

            }
        }); 

    });

</script>
@endsection
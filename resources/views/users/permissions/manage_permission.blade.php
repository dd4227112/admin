@extends('layouts.app')
@section('content')

<?php $root = url('/') . '/public/' ?>

    
     
    <div class="page-header">
        <div class="page-header-title">
            <h4> Manage Permission</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Permissions</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Manage Permissions</a>
                </li>
            </ul>
        </div>
    </div> 
    <div class="page-body">

    <div class="row">
        <div class="col-sm-12">
            <!-- Ajax data source (Arrays) table start -->
                    <div class="row">
                        <div class="col-md-6">
                        <?php 
                                if(!empty($Permissiongroup)){?>
                                <p align='left'>
                                <button class="btn btn-primary btn-sm add-permission" role="button"> Add Permissions</i></button>
                                </p>
                            <br/>
                            <?php }?>
                        </div>

                        <div class="col-md-3">
                                <p align='left'>
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
                                </p>
                            <br/>
                        </div>
                    </div>

                <div class="card-block">
                        <div class="table-responsive">
                            <table id="dt-ajax-array" class="table table-striped table-bordered dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Display Name</th>
                                    <th>Description</th>  
                                    <th>Action</th>
                                </tr>
                            </thead>
                                
                                <?php
                                $i = 1;
                                        foreach ($permissions as $permission) {
                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?=$permission->name ?></td>
                                            <td><?=$permission->display_name ?></td>
                                            <td><?=$permission->description ?></td>
                                            <td>
                                                <a  class ="btn btn-sm btn-primary" href="">Edit</a>
                                                <a class="btn btn-sm btn-danger" href="">Delete</a>
                                            </td>
                                        <?php
                                        $i++;
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
    <div class="modal-dialog modal-lg">
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

<script type="text/javascript">
        $(document).ready(function(){
        $('.add-permission').on('click', function(){
            $('#addpermission').modal('show');
            
        });

    });
    $(document).ready(function(){
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
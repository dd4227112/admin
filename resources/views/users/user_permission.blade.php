@extends('layouts.app')
@section('content')
<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>
<?php $root = url('/') . '/public/' ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">User permissions </h4>
                <span>This part will assign permissions to user</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!"></a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!"></a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
     <?php if (can_access('manage_users')) { ?>

        <div class="page-body">

            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-header-text">Permission group</h5>
                            <h5 class="card-header-text">

                                <?php
                                $user_roles = \App\Models\Role::get();
                               ?>
                                <span style="float: right">
                                    <select class="form-control" style="width:200px;" id='permission'>
                                        <option></option>
                                        <?php foreach ($user_roles as $u_role) { ?>
                                        <option value="<?= $u_role->id ?>" <?= (int) request('id') > 0 && request('id') == $u_role->id ? 'selected' : '' ?> ><?= $u_role->name  ?></option>
                                        <?php } ?>
                                    </select>
                                </span>

                            </h5>

                        </div>
                        <div class="card-block accordion-block">
                            <div id="accordion" role="tablist" aria-multiselectable="true">

                                @foreach ($Permissionsgroup as $key => $group)
                                <div class="accordion-panel">
                                    <div class="accordion-heading" role="tab" id="headingTwo">
                                        <h3 class="card-title accordion-title">
                                            <a class="accordion-msg" data-toggle="collapse" data-parent="#accordion"
                                                href="#collapseTwo_{{ $group->id }}" aria-expanded="false"
                                                aria-controls="collapseTwo">
                                                {{$group->name }}
                                            </a>
                                        </h3>
                                    </div>

                                    <div id="collapseTwo_{{ $group->id }}" class="panel-collapse collapse"
                                        role="tabpanel" aria-labelledby="headingTwo">
                                        @foreach($group->permissions()->get() as $sub)
                                        <?php
                                       $check = \App\Models\PermissionRole::where('role_id', $set)->where('permission_id', $sub->id)->first();
                                            !empty($check) ? $checked = 'checked' : $checked = '';
                                        ?>
                                        <label class="container">
                                            <input type="checkbox" {{ $checked }} value="{{ $sub->id }}"
                                                id="permission_{{ $sub->id }}" onclick="submit_role(this)">
                                            <span class="checkmark"></span>
                                            {{ $sub->display_name }}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-header-text">Roles</h5>
                            <h5 class="card-header-text">
                                <?php if(can_access('add_role')){?>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" role="button"
                                    data-target="#status-Modal"> Add role <i class="ti-user"></i></button>
                                <?php }?>
                            </h5>
                        </div>
                        <div class="card-block accordion-block">


                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                </tr>
                                <?php $i=0; ?>
                                @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->display_name }}</td>
                                </tr>
                                @endforeach
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<div class="modal fade" id="status-Modal">
    <div class="modal-dialog modal-lg" role="document">
        <form id="add-form" action="{{ url('Role/storeRoles') }}" method="POST">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new role</h5>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label> Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Role name" name="name"
                                        required>
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
                                    <input type="text" class="form-control" placeholder="Role description"
                                        name="description" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
        </form>
    </div>
</div>


<script type="text/javascript">
  $(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
  });
  
  
$('#permission').change(function(event) {
    var id = $(this).val();
    if (id === '') {} else {
        window.location.href = '<?= url('Role/userPermission') ?>/' + id;
    }
});

function submit_role(permission) {
    var perm_id = permission.value;
    var role = '<?=$set?>';
    if(!permission.checked){
        var url_obj = "<?= url('Role/removePermission') ?>";
    } else {
        var url_obj = "<?= url('Role/storePermission') ?>";
    }
    $.ajax({
        url: url_obj,
        method: 'post',
        data: {
            perm_id: perm_id,
            role_id: role
        },
        success: function(data) {
           // alert(data);
        }
    });
}

</script>


</div>
@endsection
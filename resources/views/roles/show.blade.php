@extends('layouts.app')

@section('content')
@include('users.style')
<div id="newUser">
    <div id="outer" class="container">
        <div id="wrapper" class="layout" style="background-color: #fff; margin-bottom: 40px;">
            <div id="editorForm">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Create New Role</h2>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $role->display_name }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Description:</strong>
                            {{ $role->description }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permissions:</strong>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap" width="150">Class</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($rolePermissions)) {
                                        $obj = [];
                                        foreach ($rolePermissions as $v) {
                                            array_push($obj, $v->permission_id);
                                        }
                                    }
                                    $permissions = \App\Model\Permission::all();
                                    foreach ($permissions as $permission) {
                                        $checked = in_array($permission->id, $obj) ? 'checked' : '';
                                        echo '<tr>
                                                <td class="text-nowrap"> 
                                                <div class="checkbox checkbox-success">
                                            <input value="'.$permission->id.'" id="checkbox2" class="permission" type="checkbox" ' . $checked . '>
                                            <label for="checkbox2"> ' . $permission->display_name . ' </label>
                                        </div></td>
                                                <td>' . $permission->description . '</td>
                                            </tr>';
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
<script>
    $('.permission').click(function () {
	    var id = $(this).val();
	    var role_id = '<?= $id ?>';
	    if (parseInt(id)) {
		if (!this.checked) {
		    var url_obj = "<?= url('roles/removePermission') ?>";
		} else {
		    var url_obj = "<?= url('roles/addPermission') ?>";
		}
		$.ajax({
		    type: 'GET',
		    url: url_obj,
		    data: {"id": id, role_id: role_id},
		    dataType: "html",
		    success: function (data) {
			

		    }
		});
	    }
	});

</script>
@endsection
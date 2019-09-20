@extends('layouts.app')
@section('content')


<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Exams </h4>
                <span>Exams are defined only once for quick reference</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Exams</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Listing</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <?php
                $arr = [];
                foreach ($user_permission as $permis) {
                    array_push($arr, $permis->id);
                }
                ?>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card tab-card">
                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#home3" role="tab" aria-expanded="false">
                                        Basic User Information
                                    </a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item complete">
                                    <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false">User Permissions</a>
                                    <div class="slide"></div>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                    <div class="card-block">

                                        <div class="steamline">


                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-nowrap" width="150"></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-nowrap"> First Name</td>
                                                        <td> <div class="edit" contenteditable="true" id='firstname'> {{ $user->firstname }}</div></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-nowrap"> Last Name</td>
                                                        <td>  {{ $user->lastname }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-nowrap">Email</td>
                                                        <td>  {{ $user->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-nowrap"> Gender</td>
                                                        <td>  {{ $user->gender }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-nowrap"> skills</td>
                                                        <td>  {{ $user->skills }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-nowrap">Town</td>
                                                        <td>  {{ $user->town }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-nowrap"> Roles</td>
                                                        <td>  
                                                            <label class="label label-success">{{ $user->role->display_name }}</label>
                                                           </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>       <div class="tab-pane" id="settings">
                                                                <form class="form-horizontal form-material" method="post" action="<?= url('user/changePhoto/' . $user->id) ?>" enctype="multipart/form-data">

                                                                    <div class="form-group">
                                                                        <label class="col-md-12">Photo</label>
                                                                        <div class="col-md-12">
                                                                            <input type="file" name="photo" accept=".png,.jpg,.jpeg,.gif" class="form-control form-control-line">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="col-sm-12">
                                                                            <?= csrf_field() ?>
                                                                            <button class="btn btn-success">Update Profile</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-nowrap"></td>
                                                        <td>                      <a href="<?=url('users/resetPassword/'.$user->id)?>" class="btn btn-warning btn-sm">Reset Password</a></td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                                    <div class="email-card p-0">
                                        <div class="card-block">
                                            <h6>
                                                <b>Permissions</b>
                                            </h6>
                                            <div class="mail-body-content">
                                                <table class="table table-responsive">
                                                    <tbody>

                                                        <?php
                                                        $permissions = \App\Models\Permission::all();
                                                        foreach ($permissions as $permission) {
                                                            ?>
                                                            <?php
                                                            $checked = in_array($permission->id, $arr) ? 'checked' : '';
                                                            ?>
                                                            <tr class="read">
                                                                <td>
                                                                    <div class="check-star">
                                                                        <div class="checkbox-fade fade-in-primary checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="permission" value="<?= $permission->id ?>" <?= $checked ?>>
                                                                                <span class="cr"><i class="cr-icon icofont icofont-verification-check txt-primary"></i></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td><a href="#!" class="email-name"><?= $permission->display_name ?></a></td>
                                                                <td><?= $permission->description ?></td>
                                                            </tr>
                                                            <?php 
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
            </div>


        </div>
    </div>
</div>
<script type="text/javascript">
    permission = function () {
        $('.permission').click(function () {
            var id = $(this).val();
            var role_id = '<?= $user->role_id ?>';
            if (parseInt(id)) {
                if (!this.checked) {
                    // It is not checked, show your div...
                    var url_obj = "<?= url('Users/removePermission') ?>";
                } else {
                    var url_obj = "<?= url('Users/addPermission') ?>";
                }
                $.ajax({
                    type: 'POST',
                    url: url_obj,
                    data: {"id": id, role_id: role_id},
                    dataType: "html",
                    success: function (data) {
                        toast(data);
                    }
                });
            }
        });
    }
    $(document).ready(permission);
</script>
@endsection
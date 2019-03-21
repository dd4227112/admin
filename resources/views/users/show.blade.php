@extends('layouts.app')

@section('content')
@include('users.style')

<div class="container-fluid">
    @role('admin')
    <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
    </div>
    @endrole
    <!-- /.row -->
    <!-- .row -->
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="white-box">
                <div class="user-bg"> <img width="100%" alt="user" src="<?=url('storage/uploads/images/'.$user->photo)?>">
                    <div class="overlay-box">
                        <div class="user-content">
                            <a href="javascript:void(0)"><img src="<?=url('storage/uploads/images/'.$user->photo)?>" class="thumb-lg img-circle" alt="img"></a>
                            <h4 class="text-white">{{ $user->firstname.' '.$user->lastname }}</h4>
                            <h5 class="text-white">{{ $user->email }}</h5> </div>
                    </div>
                </div>
                <div class="user-btm-box">
                    <div class="col-md-4 col-sm-4 text-center">
                        <p class="text-purple"><i class="ti-facebook"></i></p>
                        <h1>258</h1> </div>
                    <div class="col-md-4 col-sm-4 text-center">
                        <p class="text-blue"><i class="ti-twitter"></i></p>
                        <h1>125</h1> </div>
                    <div class="col-md-4 col-sm-4 text-center">
                        <p class="text-danger"><i class="ti-dribbble"></i></p>
                        <h1>556</h1> </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="white-box">
                <ul class="nav nav-tabs tabs customtab">
                    <li class="active tab">
                        <a href="#home" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">User Information</span> </a>
                    </li>

                    <li class="tab">
                        <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Settings</span> </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="home">
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
                                        <td>  {{ $user->firstname }}</td>
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
                                        <td>  @if(!empty($userRoles))
                                            @foreach($userRoles as $v)
                                            <label class="label label-success">{{ $v->display_name }}</label>
                                            @endforeach
                                            @endif</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="settings">
                        <form class="form-horizontal form-material" method="post" action="<?=url('user/changePhoto/'.$user->id)?>" enctype="multipart/form-data">
                           
                            <div class="form-group">
                                <label class="col-md-12">Photo</label>
                                <div class="col-md-12">
                                    <input type="file" name="photo" accept=".png,.jpg,.jpeg,.gif" class="form-control form-control-line">
                                </div>
                            </div>
                       
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?= csrf_field()?>
                                    <button class="btn btn-success">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
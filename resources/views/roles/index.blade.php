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
                                <h2>User Roles</h2>
                            </div>
                            <div class="pull-right">
                                <?php if(can_access('add_role')){?>
                                <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-lg-12">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ $role->description }}</td>
                                <td>
                                    <a class="btn btn-info" href="">Show</a>
                                   <?php if(can_access('edit_role')){?>
                                    <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                   <?php } ?>
                                    <?php if(can_access('delete_role')){?>
                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                     <?php } ?>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $roles->render() !!}
                </div>
              </div>

            </div>
        </div>
            </div>
            </div>
@endsection
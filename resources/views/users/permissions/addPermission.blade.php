@extends('layouts.app')
@section('content')

<?php $root = url('/') . '/public/' ?>

    
     
    <div class="page-header">
        <div class="page-header-title">
            <h4> Add Permission Group</h4>
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
                <li class="breadcrumb-item"><a href="#!">Add Permission Group</a>
                </li>
            </ul>
        </div>
    </div> 
    <div class="page-body">
        <form  action="<?=base_url('Role/storePermissionGroup')?>" method="post" class="form-horizontal group_form " role="form">

    <div class="row">
 
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label> Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Permission  group name" name="name"
                                        required>
                                </div>
                            </div>
                        </div>
    </div>
    <div class="row">
                         <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label> Description </label>
                                <div class="input-group">
                                    <textarea type="text" cols="5" rows="5" class="form-control" placeholder="Permission group description"
                                        name="description" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a button  href="<?=base_url('role/manage_permission')?>" class="btn  btn-warning" >Cancel</a>
                    </div>

            </div>
@endsection
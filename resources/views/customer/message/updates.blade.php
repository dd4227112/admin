@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
       <div class="page-header">
            <div class="page-header-title">
                <h4> <?= 'Updates' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">system updates</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">marketing</a>
                    </li>
                </ul>
            </div>
        </div> 
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                       <?php if(can_access('create_updates')) {?>
                        <div class="card-block">
                            <div class="card-header">
                                <a href="<?= url('customer/createUpdate') ?>" class="btn btn-primary btn-mini btn-round">  Create Updates</a>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading">ShuleSoft Updates</div>
                                <div class="card-block">

                                    <div class="table-responsive dt-responsive">
                                        <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">      <thead>
                                                <tr>
                                                    <th width="70" class="text-center">#</th>
                                                    <th>Type</th>
                                                    <th width="300" class="col-sm-3">Message</th>
                                                    <th width="200">Update For</th>
                                                    <th>Released Date</th>
                                                    <th>Created Date</th>
                                                    <th>Version</th>
                                                    <th width="300">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                $updates = \DB::table('admin.updates')->get();
                                                foreach ($updates as $update) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td><?= $update->update_type ?></td>
                                                        <td width="300" ><?= $update->message ?></td>
                                                        <td><?= $update->for ?></td>
                                                        <td><?= $update->created_at ?></td>
                                                        <td><?= $update->created_at ?></td>
                                                        <td><?= $update->version ?></td>

                                                        <td>
                                                            <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5"><i class="ti-key"></i></button>
                                                            <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5"><i class="ti-trash"></i></button>
                                                            <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5"><i class="ti-pencil-alt"></i></button>
                                                            <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-20"><i class="ti-upload"></i></button>
                                                        </td>
                                                    </tr>
                                                    <?php $i++;
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

@endsection

@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<link rel="stylesheet" href="<?= $root ?>plugins/bower_components/html5-editor/bootstrap-wysihtml5.css" />
<div class="white-box">
    <code id="mycode">
        <a href="<?=url('message/createUpdate')?>" class="btn btn-success"> <i class="fa fa-check"></i> Create Updates</a>
    </code>  
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">ShuleSoft Updates</div>
                <div class="table-responsive">
                    <table class="table table-hover manage-u-table">
                        <thead>
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
                            $i=1;
                            $updates = \DB::table('admin.updates')->get();
                            foreach ($updates as $update) {
                                ?>
                                <tr>
                                    <td class="text-center"><?=$i?></td>
                                    <td><?=$update->update_type?></td>
                                    <td width="300" ><?=$update->message?></td>
                                    <td><?=$update->for?></td>
                                     <td><?=$update->created_at?></td>
                                    <td><?=$update->created_at?></td>
 <td><?=$update->version?></td>

                                    <td>
                                        <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5"><i class="ti-key"></i></button>
                                        <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5"><i class="ti-trash"></i></button>
                                        <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5"><i class="ti-pencil-alt"></i></button>
                                        <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-20"><i class="ti-upload"></i></button>
                                    </td>
                                </tr>
                                <?php }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= $root ?>js/clipboard.min.js"></script>

@endsection

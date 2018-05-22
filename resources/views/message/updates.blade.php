@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
  <link rel="stylesheet" href="<?= $root ?>plugins/bower_components/html5-editor/bootstrap-wysihtml5.css" />
<div class="white-box">
    <code id="mycode"></code>  
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
                                        <th>Message</th>
                                        <th>Update For</th>
                                        <th>Created Date</th>
                                        <th width="300">Version</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $updates;
                                    ?>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>Daniel Kristeen
                                            <br><span class="text-muted">Texas, Unitedd states</span></td>
                                        <td>Visual Designer
                                            <br><span class="text-muted">Past : teacher</span></td>
                                        <td>daniel@website.com
                                            <br><span class="text-muted">999 - 444 - 555</span></td>
                                        <td>15 Mar 1988
                                            <br><span class="text-muted">10: 55 AM</span></td>
                     
                                        <td>
                                            <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5"><i class="ti-key"></i></button>
                                            <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5"><i class="ti-trash"></i></button>
                                            <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5"><i class="ti-pencil-alt"></i></button>
                                            <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-20"><i class="ti-upload"></i></button>
                                        </td>
                                    </tr>
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
</div>
<script>
$(document).ready(function () {
$('.textarea_editor').wysihtml5();
});
</script>
<script src="<?= $root ?>js/clipboard.min.js"></script>

@endsection

@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<link href="<?= $root ?>plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

<div class="row">
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <h3 class="box-title">Schools Contacts</h3>
            <!--<div id="basicgrid"></div>-->
            <div class="table-responsive"> 
                <table id="example23" class="table display nowrap table color-table success-table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>School Name</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Email </th>
                            <th>Website</th>
                            <th>created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;

                        if (isset($settings) && count($settings) > 0) {
        
                            foreach ($settings as $school) {
                         
                                ?>
                                <tr>
                                     <td><?= $i ?></td>
                                    <td><?= $school->sname ?></td>
                                    <td><?= $school->phone ?></td>
                                    <td><?= $school->address ?></td>
                                    <td><?= $school->email ?></td>
                                    <td><a href="<?= $school->website ?>" target="_blank"><?= $school->website ?></a></td>
                                    <td><?= $school->created_at ?></td>
                                    <td><a href="https://<?= $school->schema_name.'.shulesoft.com' ?>" target="_blank">open</a></td>
         
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                 
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Sweet-Alert  -->
<script src="<?= $root ?>plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="<?= $root ?>plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
@include('layouts.datatable')
@endsection


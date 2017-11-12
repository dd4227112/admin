@extends('layouts.app')
@section('content')

<div class="white-box">
    <h5 class="box-title">Pending Email</h5>

    <div class="table-responsive"> 
        <?php if ($type == 'sms') { ?>
            <table id="example23" class="display nowrap table color-table success-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Body</th>
                        <th>phone number</th>
                        <th>Site Name</th>
                        <th>Site Domain</th>
                        <th>Schema</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($messages as $key => $message) {
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $message->body ?></td>
                            <td><?= $message->phone_number ?></td>
                            <td><?= $message->sitename ?></td>
                            <td><?= $message->sitedomain ?></td>
                            <td><?= $message->schema_name ?></td>
                        </tr>
                        <?php $i++;
                    }
                    ?>
                </tbody>
            </table>
<?php } else { ?>
            <table id="example23" class="display nowrap table color-table success-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Body</th>
                        <th>Email</th>
                        <th>Site Name</th>
                        <th>Site Domain</th>
                        <th>Schema</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($messages as $message) {
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $message->subject ?></td>
                            <td><p><?=$message->body ?></p></td>
                            <td><?= $message->email ?></td>
                            <td><?= $message->sitename ?></td>
                            <td><?= $message->sitedomain ?></td>
                            <td><?= $message->schema_name ?></td>
                             <td><a href="<?=url('message/destroy/email/'. $message->email_id.'/'.$message->schema_name); ?>" class="btn btn-danger">
                                Delete</a></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
<?php } ?>

    </div>
</div>
@include('layouts.datatable')
@endsection

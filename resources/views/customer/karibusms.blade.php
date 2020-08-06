@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>karibuSMS Status</h4>

            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Customer Support</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">karibuSMS</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>karibuSMS</h5>
                            <span>You can manage school phones</span>

                            <div class="row">
                                <div class="col-md-12">

                                </div>
                            </div>
                        </div>

                        <div class="card-block">

                            <div class="table-responsive dt-responsive">

                                <table id="example23" class="display nowrap table dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                          
                                            <th>School</th>
                                            <th>Account Logins</th>
                                            <th>Phone Used</th>
                                            <th>Last Reported Online</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (count($clients) > 0) {
                                            foreach ($clients as $client) {
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                 
                                                    <td><?= isset($client->keyname) ? $client->keyname : '' ?></td>

                                                    <td>
                                                        phone:  <?= $client->phone_number ?> <br/>
                                                        Email: <?= $client->email ?>

                                                    </td>

                                                    <td>
                                                        <?php
                                                        $reset_button = 0;
                                                        if ($client->gcm_id == $shulesoft->gcm_id) {
                                                            echo '<b><label class="label label-info">ShuleSoft Phone</label></b>';
                                                        } else {
                                                            $reset_button = 1;
                                                            echo '<b><label class="label label-success">' . $client->keyname . ' Phone</label></b>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $client->last_reported_online ?></td>
                                                    <td>
                                                        <?php
                                                        if($reset_button==1){
                                                        ?>
                                                        <a href="<?= url('customer/karibu/' . $client->client_id) ?>" class="btn btn-success btn-xs">Reset to ShuleSoft Phone</a>
                                                        <?php } ?>

                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
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

<script type="text/javascript">
    content_for = function () {
        $('#permission_group').change(function () {
            var group_id = $(this).val();
            if (group_id === '0') {
                $('#content_for').val(0);
            } else {
                $.ajax({
                    type: 'get',
                    url: "<?= url('support/getPermission') ?>",
                    data: "group_id=" + group_id,
                    dataType: "html",
                    success: function (data) {
                        $('#content_for').html(data);
                    }
                });
            }
        });
    }
    $(document).ready(content_for);
</script>
@endsection
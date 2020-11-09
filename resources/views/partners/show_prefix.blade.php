@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Shulesoft API Integration</h4>
                <span>Map these parameters to ensure fully integration between ShuleSoft and the bank</span>

            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Company partners</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">partners</a>
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
                    <div class="card tab-card">

                        <div class="steamline">
                            <div class="card-block">
                                <?php if ($partner->bank_approved == 1) { ?>
                                    <div class="col-sm-12">
                                        <div class="card borderless-card">
                                            <div class="card-block-big bg-primary quick-note-card">
                                                <div class="card-block-big bg-info text-center">
                                                    <h1>Success</h1>

                                                </div>
                                                <h6> </h6>
                                                <h2 class="text-center">This school can now access electronic payments</h2>
                                                <div class="text-right">
                                                    <!--<a class="btn btn-primary btn-outline-primary" href="<?= url('https://' . $partner->client->username . '.shulesoft.com') ?>" target="_blank">Install</a>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } else {
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table color-table success-table">

                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td>Bank Name</td>
                                                    <td><?= $bank->name ?></td>

                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Account Number</td>
                                                    <td><?= $bank->number ?></td>

                                                </tr>
                                                <?php if ($partner->refer_bank_id == 22) { // This is NMB integration  ?>
                                                    <tr>
                                                        <td></td>
                                                        <td>Live Integration Username (From SARIS)</td>
                                                        <td><input type="text" class="form-control col-lg-8 col-sm-8" id="username" placeholder="" name="username" required></td>

                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>Live Integration Password (From SARIS)</td>
                                                        <td><input type="text" class="form-control col-lg-8 col-sm-8" id="password" placeholder="" name="password" required></td>

                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td></td>
                                                    <td>Invoice Prefix</td>
                                                    <td><h1 style="font-size: 25px"><b><?= $integration->invoice_prefix ?></b></h1></td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><span id="error_message"></span><a href="#" class="btn btn-success btn-sm confirm">Confirm Integration</a></td>

                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".confirm").click(function () {
        if (confirm("On clicking ok, Email and SMS will be sent to notify a\n\
 customer that mapping integration is complete and ready. Is this account already mapped on banking side ?, click ok if already mapped or cancel if not yet mapped")) {

            var bank_id =<?= $partner->refer_bank_id ?>;
            if (bank_id == '22') {
     
                var username = $('#username').val();
                var password = $('#password').val();
                if (username.length < 4 || password.length < 4) {
                    $('#error_message').html('<p class="alert alert-danger">Please Write First Username and Password for this bank account</p>');
                } else {
                    $.ajax({
                        type: 'get',
                        url: "<?= url('Partner/onboardSchool') ?>/<?= $partner->id ?>",
                                                data: {refer_bank_id: 22, client_id: '<?= $partner->client_id ?>', username: username, password: password},
                                                dataType: "html",
                                                success: function (data) {
                                                    window.location.reload();
                                                }
                                            });
                                        }
                                    } else {
                                       $(this).attr("href", "<?= url('Partner/onboardSchool/' . $partner->id) ?>");
                                    }
                                } else {
                                    return false;
                                }
                            });
</script>
@endsection


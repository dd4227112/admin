@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<link href="<?= $root ?>plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

<div class="row">
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <select class="form-control" id="check_key">
                <option></option>
                <?php
                if (isset($settings) && count($settings) > 0) {

                    foreach ($settings as $school) {
                        ?>
                        <option value="{{$school->schema_name}}">{{$school->sname}}</option>
                        <?php
                    }
                }
                ?>
            </select>
            <h3 class="box-title">Schools Contacts</h3>
            <!--<div id="basicgrid"></div>-->
            <div class="table-responsive"> 
                <table id="example23" class="table display nowrap table color-table success-table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bank Name</th>
                            <th>Account Number</th>
                            <th>Invoice Prefix</th>
                            <th>Live username</th>
                            <th>Live password </th>
                            <th>Testing username</th>
                            <th>Testing Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;

                        if (isset($banks) && count($banks) > 0) {
                            foreach ($banks as $bank) {
                               
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $bank->name ?></td>
                                    <td><?= $bank->number ?></td>
                                    <td>
                                        <input class="text-muted" type="text" schema='<?= $bank->invoice_prefix ?>' id="invoice_prefix" value="<?= $bank->invoice_prefix ?>" onblur="edit_bank_accounts('invoice_prefix', this.value, '<?= $schema ?>',<?= $bank->id ?>)"/>
                                    </td>
                                    <td><input class="text-muted" type="text" schema='<?= $bank->api_username ?>' id="api_username" value="<?= $bank->api_username ?>" onblur="edit_bank_accounts('api_username', this.value, '<?= $schema ?>',<?= $bank->id ?>)"/></td>
                                    <td><input class="text-muted" type="text" schema='<?= $bank->api_password ?>' id="api_password" value="<?= $bank->api_password ?>" onblur="edit_bank_accounts('api_password', this.value, '<?= $schema ?>',<?= $bank->id ?>)"/></td>
                                    <td><input class="text-muted" type="text" schema='<?= $bank->testing_api_username ?>' id="testing_api_username" value="<?= $bank->testing_api_username ?>" onblur="edit_bank_accounts('testing_api_username', this.value, '<?= $schema ?>',<?= $bank->id ?>)"/><a href="<?= $bank->testing_api_username ?>" target="_blank"></a></td>
                                    <td><input class="text-muted" type="text" schema='<?= $bank->testing_api_password ?>' id="testing_api_password" value="<?= $bank->testing_api_password ?>" onblur="edit_bank_accounts('testing_api_password', this.value, '<?= $schema ?>',<?= $bank->id ?>)"/></td>
                                    <td></td>

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
<script type="text/javascript">
    $('#check_key').change(function () {
        var val = $(this).val();
        window.location.href = "<?= url('management/banks') ?>/" + val;
    })

    edit_bank_accounts = function (tag, val, schema,bank_id) {
        if (val !== '') {
            $.get('<?= url('profile/update') ?>', {schema: schema, table: 'bank', val: val, tag: tag, bank_id: bank_id}, function (data) {
                swal('success', data);
            });
        }
    };
</script>
<!-- Sweet-Alert  -->
<script src="<?= $root ?>plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="<?= $root ?>plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
@include('layouts.datatable')
@endsection


@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<link href="<?= $root ?>plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>
  
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/style.css">

        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2.css">

        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2-bootstrap.css">
        <link rel="stylesheet" href="<?= $root ?>assets/select2/css/gh-pages.css">   
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Payment Api Requests</h4>
                <span>This parts show all api requests done with a bank</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Software</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">API requests</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-block">
                            <div class="col-lg-12">
                                <div class="white-box">
                                <form>
                                <div class="form-group">
                                    <select class="form-control select2" id="check_key">
                                        <option></option>
                                        <?php
                                        if (isset($settings) && sizeof($settings) > 0) {

                                            foreach ($settings as $school) {
                                                ?>
                                                <option value="{{$school->schema_name}}">{{$school->sname}}</option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                </form>

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
                                                    <!-- <th>Testing username</th>
                                                    <th>Testing Password</th> -->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;

                                                if(isset($banks) && sizeof($banks) > 0) {
                                                    foreach ($banks as $bank) {
                                                         if (can_access('manage_users')) { 
                                                             $text = '';
                                                         }else{
                                                            $text = 'readonly';
                                                         }
                                                        ?>
                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <td><?= $bank->name ?></td>
                                                            <td><?= $bank->number ?></td>
                                                            <td>
                                                                <input class="text-muted" type="text" <?=$text?> schema='<?= $bank->invoice_prefix ?>' id="invoice_prefix" value="<?= $bank->invoice_prefix ?>" onblur="edit_bank_accounts('invoice_prefix', this.value, '<?= $schema ?>',<?= $bank->id ?>)"/>
                                                            </td>
                                                            <td><input class="text-muted" type="text" <?=$text?> schema='<?= $bank->api_username ?>' id="api_username" value="<?= $bank->api_username ?>" onblur="edit_bank_accounts('api_username', this.value, '<?= $schema ?>',<?= $bank->id ?>)"/></td>
                                                            <td><input class="text-muted" type="text" <?=$text?> schema='<?= $bank->api_password ?>' id="api_password" value="<?= $bank->api_password ?>" onblur="edit_bank_accounts('api_password', this.value, '<?= $schema ?>',<?= $bank->id ?>)"/></td>
                                                            <!-- <td><input class="text-muted" type="text" <?=$text?> schema='<?= $bank->sandbox_api_username ?>' id="sandbox_api_username" value="<?= $bank->sandbox_api_username ?>" onblur="edit_bank_accounts('sandbox_api_username', this.value, '<?= $schema ?>',<?= $bank->id ?>)"/><a href="<?= $bank->sandbox_api_username ?>" target="_blank"></a></td>
                                                            <td><input class="text-muted" type="text" <?=$text?> schema='<?= $bank->sandbox_api_password ?>' id="sandbox_api_password" value="<?= $bank->sandbox_api_password ?>" onblur="edit_bank_accounts('sandbox_api_password', this.value, '<?= $schema ?>',<?= $bank->id ?>)"/> -->
                                                             
                                                            </td>
                                                            <td>   <input type='button' value="Save"/></td>

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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#check_key').change(function () {
        var val = $(this).val();
        window.location.href = "<?= url('software/banksetup') ?>/" + val;
    })

    edit_bank_accounts = function (tag, val, schema, bank_id) {
        if (val !== '') {
            $.get('<?= url('software/updateProfile/null') ?>', {schema: schema, table: 'bank', val: val, tag: tag, bank_id: bank_id}, function (data) {
                swal('success', data);
            });
        }
    };
    $(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
});
</script>
<!-- Sweet-Alert  -->
<script src="<?= $root ?>plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="<?= $root ?>plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
@endsection


@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<link href="<?= $root ?>plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

<div class="row">
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <h3 class="box-title">Schools</h3>
            <!--<div id="basicgrid"></div>-->
 <div class="table-responsive"> 
            <table id="example23" class="table display nowrap table color-table success-table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>School Name</th>
                        <th>Students</th>
                        <th>Cost</th>
                        <th>Transaction Fee</th>
                        <th>NMB Comission</th>
                        <th>ShuleSoft Comission</th>
                        <th>Amount </th>
                        <th>Parents</th>
                        <th>Teachers</th>
                        <th>Non Teaching</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;

                    if (isset($users) && count($users) > 0) {
                        $students = 0;
                        $parents = 0;
                        $teachers = 0;
                        $staff = 0;
                        $total = 0;
                        $total_price = 0;
                        foreach ($users as $key => $value) {
                            $setting = \DB::table($value->schema_name . '.setting')->first();
                            $price =$setting->price_per_student;
                            $students += $value->student;
                            $parents += $value->parent;
                            $teachers += $value->teacher;
                            $staff += $value->user;
                            $total += $value->student + $value->parent + $value->teacher + $value->user;
                            $price_per_school = $price * $value->student;
                            $total_price += $price_per_school;
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $value->schema_name ?></td>
                                <td><?= $value->student ?></td>
                                <td> <input class="text-muted" type="text" schema='<?=$value->schema_name?>' id="price_per_student" value="<?= $price ?>" onblur="edit_records('price_per_student',this.value,'<?=$value->schema_name?>')"/></td>
                                           <td> <input class="text-muted" type="text" schema='<?=$value->schema_name?>' id="price_per_student" value="<?= $setting->transaction_fee ?>" onblur="edit_records('transaction_fee',this.value,'<?=$value->schema_name?>')"/></td>
                                                      <td> <input class="text-muted" type="text" schema='<?=$value->schema_name?>' id="price_per_student" value="<?= $setting->nmb_comission ?>" onblur="edit_records('nmb_comission',this.value,'<?=$value->schema_name?>')"/></td>
                                                                 <td> <input class="text-muted" type="text" schema='<?=$value->schema_name?>' id="price_per_student" value="<?= $setting->shulesoft_comission ?>" onblur="edit_records('shulesoft_comission',this.value,'<?=$value->schema_name?>')"/></td>
                                <td><?= number_format($price_per_school) ?></td>
                                <td><?= $value->parent ?></td>
                                <td><?= $value->teacher ?></td>
                                <td><?= $value->user ?></td>
                                <td><?= $value->student + $value->parent + $value->teacher + $value->user ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                             <td><?= $students ?></td>
                            <td colspan="3"></td>
                           
                             <td></td>
                            <td><?= number_format($total_price) ?></td>
                            <td><?= $parents ?></td>
                            <td><?= $teachers ?></td>
                            <td><?= $staff ?></td>
                            <td><?= $total ?></td>
                        </tr>
                    </tfoot>
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
<script type="text/javascript">
     edit_records = function (tag,val,schema) {
                $.get('<?= url('profile/update') ?>', {schema:schema, table: 'setting', val: val,tag:tag,user_id: '1'}, function (data) {
                    swal('success',data);
                });
    };
</script>
@include('layouts.datatable')
@endsection

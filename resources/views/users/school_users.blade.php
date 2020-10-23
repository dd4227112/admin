@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<link href="<?= $root ?>plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

<div class="row">
</div>
<div class="row">

    <div class="col-lg-12">
        <section>
            <div class="sttabs tabs-style-bar">
                <nav>
                    <ul>
                        <li class="tab-current"><a href="#section-bar-1" class="sticon ti-home"><span>Schools</span></a></li>
                        <li class=""><a href="#section-bar-2" class="sticon ti-trash"><span>Paid Schools</span></a></li>
                        <li><a href="#section-bar-3" class="sticon ti-settings"><span>Partially Paid</span></a></li>
                        <li><a href="#section-bar-4" class="sticon ti-upload"><span>No Records</span></a></li>
                        <li><a href="#section-bar-5" class="sticon ti-stats-up"><span> Analytics</span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-bar-1" class="content-current">
                        <div class="white-box">
                            <div class="table-responsive"> 
                                <table id="example23" class="table display nowrap table color-table success-table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School Name</th>
                                            <th>Students</th>
                                            <th>Cost</th>
                                            <th>Institution Code</th>
                                            <th>Payment Integrated</th>
                                            <th>charges to parents</th>
                                            <th>Transaction Fee</th>
                                            <th>API username </th>
                                            <th>API password </th>
                                            <th>Amount </th>
                                            <th>Parents</th>
                                            <th>Teachers</th>
                                            <th>Non Teaching</th>
                                            <th>Total</th>
                                            <th>Payment Status</th>
                                            <th>Payment Deadline Date</th>
                                            <th>Paid Amount</th>
                                            <th>Estimated students</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;

                                        if (isset($users) && sizeof($users) > 0) {
                                            $students = 0;
                                            $parents = 0;
                                            $teachers = 0;
                                            $staff = 0;
                                            $total = 0;
                                            $total_price = 0;
                                            $paid_schools = [];
                                            $no_students = [];
                                            foreach ($users as $key => $value) {
                                                $setting = \DB::table($value->schema_name . '.setting')->first();

                                                if ($setting->payment_status == 1) {
                                                    array_push($paid_schools, ['school' => $setting, 'data' => $value]);
                                                }
                                                if ((int) $value->student < 10) {
                                                    array_push($no_students, ['school' => $setting, 'data' => $value]);
                                                }
                                                $price = $setting->price_per_student;
                                                $students += $value->student;
                                                $parents += $value->parent;
                                                $teachers += $value->teacher;
                                                $staff += $value->user;
                                                $total += $value->student + $value->parent + $value->teacher + $value->user;
                                                $price_per_school = $price * $value->student;
                                                $total_price += $price_per_school;
                                                $background = '';
                                                if (isset($setting->payment_status) && $setting->payment_status == 0) {
                                                    if (strtotime($setting->payment_deadline_date) > time()) {
                                                        //this client exceed deadline
                                                        $background = 'background:#fb9678';
                                                    } else {
                                                        $background = 'background:#ffbb44';
                                                    }
                                                }
                                                ?>
                                                <tr style="<?= $background ?>">
                                                    <td><?= $i ?></td>
                                                    <td><?= $value->schema_name ?></td>
                                                    <td><?= $value->student ?></td>
                                                    <td> <input class="text-muted" type="text" schema='<?= $value->schema_name ?>' id="price_per_student" value="<?= $price ?>" onblur="edit_records('price_per_student', this.value, '<?= $value->schema_name ?>')"/></td>

                                                    <td> <input class="text-muted" type="text" schema='<?= $setting->institution_code ?>' id="institution_code" <?= (int) $setting->payment_integrated == 1 ? 'disabled' : '' ?> value="<?= $setting->institution_code ?>" onblur="edit_records('institution_code', this.value, '<?= $value->schema_name ?>')"/></td>
                                                    <td> <input class="text-muted" type="text" schema='<?= $setting->payment_integrated ?>' id="payment_integrated" value="<?= $setting->payment_integrated ?>" onblur="edit_records('payment_integrated', this.value, '<?= $value->schema_name ?>')"/></td>
                                                    <td> <input class="text-muted" type="text" schema='<?= $setting->transaction_charges_to_parents ?>' id="transaction_charges_to_parents" value="<?= $setting->transaction_charges_to_parents ?>" onblur="edit_records('transaction_charges_to_parents', this.value, '<?= $value->schema_name ?>')"/></td>
                                                    <td> <input class="text-muted" type="text" schema='<?= $setting->transaction_fee ?>' id="transaction_fee" <?= (int) $setting->payment_integrated == 1 ? 'disabled' : '' ?> value="<?= $setting->transaction_fee ?>" onblur="edit_records('transaction_fee', this.value, '<?= $value->schema_name ?>')"/></td>
                                                    <td> <input class="text-muted" type="text" schema='<?= $setting->api_username ?>' id="api_username" <?= (int) $setting->payment_integrated == 1 ? 'disabled' : '' ?> value="<?= $setting->api_username ?>" onblur="edit_records('api_username', this.value, '<?= $value->schema_name ?>')"/></td>
                                                    <td> <input class="text-muted" type="text" schema='<?= $setting->api_password ?>' id="api_password" <?= (int) $setting->payment_integrated == 1 ? 'disabled' : '' ?> value="<?= $setting->api_password ?>" onblur="edit_records('api_password', this.value, '<?= $value->schema_name ?>')"/></td>
                                                    <td><?= number_format($price_per_school) ?></td>
                                                    <td><?= $value->parent ?></td>
                                                    <td><?= $value->teacher ?></td>
                                                    <td><?= $value->user ?></td>
                                                    <td><?= $value->student + $value->parent + $value->teacher + $value->user ?></td>
                                                    <td><input class="text-muted" type="text" schema='<?= $value->schema_name ?>' id="payment_status" value="<?= isset($setting->payment_status) ? $setting->payment_status : '' ?>" onblur="edit_records('payment_status', this.value, '<?= $value->schema_name ?>')"/></td>
                                                    <td><input class="text-muted" type="text" schema='<?= $value->schema_name ?>' id="payment_deadline_date" value="<?= isset($setting->payment_deadline_date) ? $setting->payment_deadline_date : '' ?>" onblur="edit_records('payment_deadline_date', this.value, '<?= $value->schema_name ?>')"/></td>
                                                                         <td><input class="text-muted" type="text" schema='<?= $value->schema_name ?>' id="total_paid_amount" value="<?= isset($setting->total_paid_amount) ? $setting->total_paid_amount : '' ?>" onblur="edit_records('total_paid_amount', this.value, '<?= $value->schema_name ?>')"/></td>
                                                                         
                                                    <td><input class="text-muted" type="text" schema='<?= $value->schema_name ?>' id="estimated_students" value="<?= isset($setting->estimated_students) ? $setting->estimated_students : '' ?>" onblur="edit_records('estimated_students', this.value, '<?= $value->schema_name ?>')"/></td>
                                                    <td><?php if (isset($setting->payment_status) && $setting->payment_status == 0) { ?><a href="<?= url('invoice/' . $value->schema_name) ?>" class="btn btn-sm btn-primary"><i class="fa fa-download"></i>Invoice</a> <?php } ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td><?= $students ?></td>
                                                <td colspan="6"></td>

                                                <td></td>
                                                <td><?= number_format($total_price) ?></td>
                                                <td><?= $parents ?></td>
                                                <td><?= $teachers ?></td>
                                                <td><?= $staff ?></td>
                                                <td><?= $total ?></td>
                                                <td colspan="5"></td>
                                            </tr>
                                        </tfoot>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                    <section id="section-bar-2" class="">
                        <h2>Paid Schools</h2>
                        <div class="table-responsive"> 
                            <table id="example23" class="table display nowrap table color-table success-table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>School Name</th>
                                        <th>Address</th>
                                        <th>Students</th>
                                        <th>Costs</th>
                                        <th>Payment Integrated</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                    $p = 1;
                                    foreach ($paid_schools as $school) {
                                        $price = $school['school']->price_per_student;
                                        $price_per_school = $price * $school['data']->student;
                                        ?>
                                        <tr>
                                            <td><?= $p ?></td>
                                            <td><?= $school['school']->sname ?></td>
                                            <td><?= $school['school']->address ?></td>
                                            <td><?= $school['data']->student ?></td>
                                            <td><?= number_format($price_per_school) ?></td>
                                            <td> <?= (int) $setting->payment_integrated == 1 ? 'Yes' : 'No' ?> </td>
                                        </tr>
                                        <?php
                                        $p++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <section id="section-bar-3">
                        <h2>No Records</h2>

                    </section>
                    <section id="section-bar-4">
                        <h2>No Complete Data Records</h2>         
                        <div class="table-responsive"> 
                            <table id="example23" class="table display nowrap table color-table success-table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>School Name</th>
                                        <th>Address</th>
                                        <th>Students</th>
                                        <th>Costs</th>
                                        <th>Payment Integrated</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                    $x = 1;
                                    foreach ($no_students as $school) {
                                        $price = $school['school']->price_per_student;
                                        $price_per_school = $price * $school['data']->student;
                                        ?>
                                        <tr>
                                            <td><?= $x ?></td>
                                            <td><?= $school['school']->sname ?></td>
                                            <td><?= $school['school']->address ?></td>
                                            <td><?= $school['data']->student ?></td>
                                            <td><?= number_format($price_per_school) ?></td>
                                            <td> <?= (int) $setting->payment_integrated == 1 ? 'Yes' : 'No' ?> </td>
                                        </tr>
                                        <?php
                                        $x++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <section id="section-bar-5">
                        <h2>Tabbing 5</h2></section>
                </div>
                <!-- /content -->
            </div>
            <!-- /tabs -->
        </section>

    </div>
</div>
<!-- Sweet-Alert  -->
<?php $root = url('/') . '/public/' ?>
<script src="<?= $root ?>js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?= $root ?>js/cbpFWTabs.js"></script>
<script type="text/javascript">
                                                        (function () {
                                                            [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                                                                new CBPFWTabs(el);
                                                            });
                                                        })();
</script>
<script src="<?= $root ?>plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="<?= $root ?>plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
<script type="text/javascript">
                                                        edit_records = function (tag, val, schema) {
                                                            $.get('<?= url('profile/update') ?>', {schema: schema, table: 'setting', val: val, tag: tag, user_id: '1'}, function (data) {
                                                                swal('success', data);
                                                            });
                                                        };
</script>
@include('layouts.datatable')
@endsection

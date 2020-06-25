@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/';

function tagEdit($schema_name, $column, $value) {
    if ((int) request('skip') == 1) {
        $return = $value;
    } else {
        $return = '<input class="text-muted" type="text" schema="' . $schema_name . '" id="' . $column . '" value="' . $value . '" onblur="edit_records(\'' . $column . '\', this.value, \'' . $schema_name . '\')"/><span id="status_' . $column . $schema_name . '"></span>';
    }
    return $return;
}
?>
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-title">
            <h4>Projections </h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Pages</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
    <?php
    $schemas = DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES WHERE table_schema NOT IN ('admin','beta_testing','accounts','public','pg_catalog','constant','api','information_schema')");
    ?>
    <div class="page-body">
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="card" style="height: 65em"> 
                    <div class="card-block tab-icon">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <!-- <h6 class="sub-title">Tab With Icon</h6> -->
                                <div class="sub-title">Budget & Projections</div>                                        
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs md-tabs " role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"><i class="icofont icofont-home"></i>Google Sheet</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#profile7" role="tab"><i class="icofont icofont-ui-user "></i>Actuals</a>
                                        <div class="slide"></div>
                                    </li>

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content card-block">
                                    <div class="tab-pane active" id="home7" role="tabpanel">
                                        <div class="card-header">
                                            <h5>Revenue Projections</h5>
                                            <span>This part shows list of customers and expected amount to be collected per each customer. These information are loaded from Google Sheet </span>

                                        </div>
                                        <div class="card-block"  style="height: 35em">
                                            <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vTUgl5FL_1xQswE7AahA4eoZ3jlDD4_wzSZxo4xo4iDot83kAG17NsqmYF522vvQ6hPSC1hVs5Pum6Z/pubhtml?widget=true&amp;headers=false" height='100%' width="100%"></iframe>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="profile7" role="tabpanel">
                                        <div class="card-block">
                                            <input type="checkbox" id="skip_field" onmousedown="skip_field()"/>
                                            <div class="table-responsive dt-responsive">
                                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>School Name</th>

                                                            <th>Students</th>
                                                            <th>Price</th>
                                                            <th>Paid Amount</th>

                                                            <th>Remained Amount</th>
                                                            <th>Payment Status</th>
                                                            <th>Payment Deadline</th>
                                                            <th>Estimated Students</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total_students = 0;
                                                        $total_price = 0;
                                                        foreach ($schemas as $schema) {
                                                            $setting = DB::table($schema->table_schema . '.setting')->first();
                                                            if (count($setting) == 0) {
                                                                continue;
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td><?= $schema->table_schema ?></td>

                                                                <td>   <?php
                                                                    $students = DB::table($schema->table_schema . '.student')->where('status', 1)->count();
                                                                    $total_students += $students;
                                                                    echo $students;
                                                                    ?>
                                                                </td>
                                                                <td>

                                                                    <?php
                                                                    $price = count($setting) == 1 ? $setting->price_per_student : 0;
                                                                    $total_price += $price * $students;
                                                                    echo tagEdit($schema->table_schema, 'price_per_student', $price);
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?= tagEdit($schema->table_schema, 'total_paid_amount', $setting->total_paid_amount) ?>
                                                                </td>

                                                                <td>  

                                                                </td>


                                                                <td> 
                                                                    <?= tagEdit($schema->table_schema, 'payment_status', $setting->payment_status) ?>
                                                                </td>
                                                                <td> 
                                                                    <?= tagEdit($schema->table_schema, 'payment_deadline_date', $setting->payment_deadline_date) ?> 
                                                                </td>

                                                                <td>
                                                                    <?= tagEdit($schema->table_schema, 'estimated_students', $setting->estimated_students) ?>
                                                                </td>


                                                                <td >                    <a href="<?= url('account/invoiceView/' . $schema->table_schema) ?>" class="btn btn-sm btn-success">View</a></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Total</th>
                                                            <th><?= $total_students ?></th>
                                                            <th><?= $total_price ?></th>
                                                            <th>Terms</th>

                                                            <th>Sections</th>

                                                            <th>School Stamp</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row end -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    edit_records = function (tag, val, schema) {
        $.get('<?= url('customer/updateProfile/null') ?>', {schema: schema, table: 'setting', val: val, tag: tag, user_id: '1'}, function (data) {
            $('#status_' + tag + schema).html(data);
        });
    };

    $('input[type="checkbox"]').click(function () {
        if ($(this).prop("checked") == true) {
            window.location.href = '<?= url('/account/projection') ?>/null?skip=1';
        } else if ($(this).prop("checked") == false) {
            window.location.href = '<?= url('/account/projection') ?>/null?skip=0';
        }
    })
</script>
@endsection


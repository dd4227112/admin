@extends('layouts.app')
@section('content')
<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>
<?php
$root = url('/') . '/public/';

function tagEdit($schema_name, $column, $value, $type = null) {
      $type = null ? $type = '"text"' : $type = $type;
    if ((int) request('skip') == 1) {
        $return = $value;
    } else {
        $return = '<input required class="text-muted" type="'. $type. '" schema="' . $schema_name . '" id="' . $column .$schema_name. '" value="' . $value . '" onblur="edit_records(\'' . $column . '\', this.value, \'' . $schema_name . '\')"/><br/><span id="status_' . $column . $schema_name . '"></span>';
    }
    return $return;
}
?>
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-title">
            <h4>Invoice Management </h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Accounts</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Invoices</a>
                </li>
            </ul>
        </div>
    </div>
 
    <div class="page-body">
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="card" style="height: 65em"> 
                    <div class="card-block tab-icon">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <!-- <h6 class="sub-title">Tab With Icon</h6> -->
                                <div class="sub-title">Manage Invoices</div>                                        
                                <ul class="nav nav-tabs md-tabs " role="tablist">

                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#profile7" role="tab"><i class="icofont icofont-ui-user "></i>Create Invoice</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#home7" role="tab"><i class="icofont icofont-home"></i>Sent Invoice</a>
                                        <div class="slide"></div>
                                    </li>
                                     <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#reports" role="tab"><i class="icofont icofont-list "></i>Reports</a>
                                        <div class="slide"></div>
                                    </li>

                                </ul>
                              
                                <div class="tab-content card-block">
                                    {{-- <div class="tab-pane " id="home7" role="tabpanel">
                                        <div class="card-header">
                                            <h5>Revenue Projections</h5>
                                            <span>This part shows list of customers and expected amount to be collected per each customer. These information are loaded from Google Sheet </span>

                                        </div>
                                        <div class="card-block"  style="height: 35em">
                                            <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vTUgl5FL_1xQswE7AahA4eoZ3jlDD4_wzSZxo4xo4iDot83kAG17NsqmYF522vvQ6hPSC1hVs5Pum6Z/pubhtml?widget=true&amp;headers=false" height='100%' width="100%"></iframe>
                                        </div>
                                    </div> --}}
                                    <div class="tab-pane active" id="profile7" role="tabpanel">
                                        <div class="card-block">
                                            <input type="checkbox" <?=(int) request('skip')==1 ?'checked':''?> id="skip_field" onmousedown="skip_field()"/> Hide Inputs Fields
                                            <div class="table-responsive dt-responsive">
                                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>School Name</th>
                                                            <th>Date Registered</th>
                                                            <th>Students</th>
                                                            <th>Price</th>
                                                            <th>Payment Deadline</th>
                                                            <th>Estimated Students</th>
                                                            <th>Start usage date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total_students = 0;
                                                        $total_price = 0;
                                                        $schemas=\DB::select("select * from admin.clients where id not in (select client_id from admin.invoices where account_year_id=(select id from admin.account_years where name='".date('Y')."'))" );
                                                        //dd($schemas);
                                                        foreach ($schemas as $schema) {
                                                            ?>
                                                            <tr>
                                                                <td><?= school_full_name($schema->username) ?></td>
                                                                <td><?= date('d M Y',strtotime($schema->created_at))  ?></td>
                                                                <td> 
                                                                    <?php 
                                                                    $setting = DB::table('admin.all_setting')->where('schema_name', $schema->username)->first();
                                                                     if(!empty($setting)) {
                                                                        $students = DB::table($schema->username. '.student')->where('status', 1)->count();
                                                                     } else {
                                                                        $students=$schema->estimated_students;
                                                                     }
                                                                    $total_students += $students;
                                                                    echo $students;
                                                                    ?>
                                                                </td>

                                                                <td>
                                                                 <?php
                                                                    // $price = count($schema) == 1 ? $schema->price_per_student : 0;
                                                                    $price =$schema->price_per_student;
                                                                    $total_price += $price * $students;
                                                                    echo tagEdit($schema->username, 'price_per_student', $price);
                                                                    ?>
                                                                </td>

                                                           
                                                                <td> 
                                                                    <?php
                                                                    $end_date =$schema->invoice_end_date;
                                                                    echo tagEdit($schema->username, 'invoice_end_date', $end_date, 'date');
                                                                    ?>
                                                                </td> 

                                                                <td>
                                                                    <?= tagEdit($schema->username, 'estimated_students', isset($schema->estimated_students) ? $schema->estimated_students:'') ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $usage_date =$schema->start_usage_date;
                                                                    echo tagEdit($schema->username, 'start_usage_date', $usage_date, 'date');
                                                                    ?>
                                                                </td>
                                                                <td><a href="<?= url('account/createShuleSoftInvoice/' . $schema->id) ?>" class="btn btn-sm btn-success">Create Invoice</a></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="2">Total</th>
                                                            <th><?= $total_students ?></th>
                                                            <th><?= money($total_price) ?></th>
                                                            <th colspan="1"></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="home7" role="tabpanel">
                                    <div class="card-header">
                                            <h5>Current Sent School Invoices</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive dt-responsive">
                                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>School Name</th>
                                                            <th>Students</th>
                                                            <th>Paid Amount</th>
                                                            <th>Added By</th>
                                                            <th>Issued Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total_students = 0;
                                                        $total_price = 0;
                                                        $schools = App\Models\InvoiceSent::orderBy('id', 'DESC')->get();
                                                        if(count($schools)){ 
                                                        foreach ($schools as $school) {?>
                                                            <tr>
                                                                <td><?= school_full_name($school->schema_name) ?></td>
                                                                <td><?php echo $school->student; $total_students += $school->student; ?></td>
                                                                <td><?php echo $school->amount; $total_price += $school->amount;?> </td>
                                                                <td><?php echo $school->user->name;?> </td>
                                                                <td><?= $school->date ?></td>
                                                                <td ><a href="<?= url('account/invoiceView/' . $school->schema_name) ?>" class="btn btn-sm btn-success">View</a></td>
                                                            </tr>
                                                        <?php } 
                                                        }?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Total</th>
                                                            <th><?= $total_students ?></th>
                                                            <th><?= $total_price ?></th>
                                                            <th>User</th>
                                                            <th>Date</th>
                                                            <th>Action</th>

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


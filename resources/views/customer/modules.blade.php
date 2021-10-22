@extends('layouts.app')
@section('content')
<?php
// /**
//  * select distinct &quot;schema_name&quot; from admin.all_student where extract (year from
//   created_at)=&#39;2019&#39; order by &quot;schema_name&quot; -to get the schools that have recorded
//   students this year.
//   ● select distinct &quot;schema_name&quot; from admin.all_marks where extract (year from
//   created_at)=&#39;2019&#39; -to get the schools that have recorded marks in the system.
//   ● select distinct &quot;schema_name&quot; from admin.all_invoices where extract (year from
//   created_at)=&#39;2019&#39; -to get the schools that have created invoices in the system.
//   ● select distinct &quot;schema_name&quot; from admin.all_bank_accounts_integrations where
//   extract (year from created_at)=&#39;2019&#39; -to get the schools that have been integrated
//   with NMB.
//   ● select distinct &quot;schema_name&quot; from admin.all_payments where extract (year from
//   created_at)=&#39;2019&#39; -to get the schools that have recorded payments.
//   ● select distinct &quot;schema_name&quot; from admin.all_payments where extract (year from
//   created_at)=&#39;2019&#39; and &quot;token&quot; is not null -to get the schools that have recorded
//   payments electronically.
//   ● select distinct &quot;schema_name&quot; from admin.all_expense where extract (year from
//   created_at)=&#39;2019&#39; -to
//  */
$marks = DB::select('select distinct "schema_name", max(created_at) as created_at from admin.all_mark group by schema_name');
$mark_status = [];
foreach ($marks as $mark) {
    $mark_status[$mark->schema_name] = $mark->created_at;
}


$exam_reports = DB::select('select distinct "schema_name", max(created_at) as created_at from admin.all_exam_report  group by schema_name');
$exam_report_status = [];
foreach ($exam_reports as $report) {
    $exam_report_status[$report->schema_name] = $report->created_at;
}


$invoices = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_invoices  group by schema_name');
$invoice_status = [];
$invoice_status_count = [];
foreach ($invoices as $invoice) {
    $invoice_status[$invoice->schema_name] = $invoice->created_at;
    $invoice_status_count[$invoice->schema_name] = $invoice->count;
}

$expenses = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_expense  group by schema_name');
$expense_status = [];
$expense_status_count = [];
foreach ($expenses as $expense) {
    $expense_status[$expense->schema_name] = $expense->created_at;
    $expense_status_count[$expense->schema_name] = $expense->count;
}

$payments = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_payments  group by schema_name');
$payment_status = [];
$payment_count = [];
foreach ($payments as $payment) {
    $payment_status[$payment->schema_name] = $payment->created_at;
    $payment_count[$payment->schema_name] = $payment->count;
}

$school_allocations = DB::select('select c.schema_name,c.source, c.sname,b.firstname, b.lastname from admin.user_clients a join admin.users b on b.id=a.user_id join admin.clients z on z.id=a.client_id join admin.all_setting c on c."schema_name"=z."username" where a.status=1 and c.schema_name is not null');
$allocation = [];
$users_allocation = [];

foreach ($school_allocations as $school_allocation) {
    $allocation[$school_allocation->schema_name] = $school_allocation->firstname . ' ' . $school_allocation->lastname;
}

function getActiveStatus($schema_name) {
    global $mark_status;
    global $payment_status;
    if (isset($mark_status[$schema_name])) {
        $now = date('Y-m-d'); // or your date as well
        $your_date = date('Y-m-d', strtotime($mark_status[$schema_name]));
        $date1 = new \DateTime($now);
        $date2 = new \DateTime($your_date);
        $days = $date2->diff($date1)->format("%a");
        return 1;
    } else if (isset($payment_status[$schema_name])) {
        $now = date('Y-m-d'); // or your date as well
        $your_date = date('Y-m-d', strtotime($payment_status[$schema_name]));
        $date1 = new \DateTime($now);
        $date2 = new \DateTime($your_date);
        $days = $date2->diff($date1)->format("%a");
        return 1;
    } else {
        return 0;
    }
}

$staffs = DB::table('users')->where('status', 1)->get();

$sources = [];
$schools_data = DB::table('admin.all_setting')->get();
foreach ($schools_data as $value) {
    $sources[$value->schema_name] = $value->source;
}

$invoice_issued = [];
$invoices_current = DB::select('select * from admin.invoices_sent');
foreach ($invoices_current as $invoice_info) {
    $invoice_issued[$invoice_info->schema_name] = 'Due: ' . date('d M Y', strtotime('30 days', strtotime($invoice_info->date)));
} 

function select($value, $schema, $sources) {
    return isset($sources[$schema]) && strtolower($sources[$schema]) == strtolower($value) ? 'Selected' : '';
}
?>
<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">

      <div class="page-header">
        <div class="page-header-title">
            <h4>Modules</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Customer modules</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Operations</a>
                </li>
            </ul>
        </div>
    </div> 
      
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#home3" role="tab" aria-expanded="false">
                                    Modules
                                </a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item complete">
                                <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false">Summary Allocation</a>
                                <div class="slide"></div>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                <div class="card-block">

                                    <span>This part shows which modules are actively used by school and which areas we need to focus to help schools.</span>
                                

                                        <p align='right'> <button type="button" id="notify_schools" style="display:none" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#large-Modal">Send Message</button></p>
                                        <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1050; display: none;">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Send Notification</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <form action="#" method="post">
                                                        <div class="modal-body">
                                                            <span>
                                                                Send notification to selected schools</span>

                                                            <div class="form-group">
                                                                <textarea class="form-control" placeholder="Compose message" name="message"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <p> Send As -
                                                                        <input type="checkbox" placeholder="Deadline" name="sms">SMS
                                                                        <input type="checkbox" placeholder="Deadline" name="email">Email </p>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light ">Send</button>
                                                            <input type="hidden" id='schools_mapped' name="schools" value="" />
                                                        </div>

                                                        <?= csrf_field() ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">

                                            <div class="table-responsive dt-responsive">
                                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th><input type="checkbox" name="all" id="toggle_all"> </th>
                                                            <th>School Name</th>
                                                            <th>Invoice </th>
                                                            <td>Support Personnel</td>
                                                            <?php
                                                            if (in_array(Auth::user()->id, [2, 7, 20])) {
                                                                ?>
                                                                <td>Sales Source</td>
                                                                <td> Support Person</td>
                                                                <td>Sales Person</td>

                                                            <?php } ?>
                                                            <td>Students</td>
                                                            <th>Marks Entered</th>
                                                            <th>Exams Published</th>
                                                            <th>Invoice Created</th>
                                                            <th>Expense Recorded</th>
                                                            <th>Payments Recorded</th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no_students = 0;
                                                        $no_marks = 0;
                                                        $no_exams_published = 0;
                                                        $no_invoice = 0;
                                                        $no_expense = 0;
                                                        $no_payment = 0;
                                                        $a = 0;
                                                        if(count($schools) > 0)
                                                        foreach ($schools as $school) { 
                                                            $students = DB::table($school->schema_name . '.student')->where('status', 1)->count();
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox" class="check" name="select[]" value="<?= $school->schema_name ?>">
                                                                </td>
                                                                <td><?= $school->schema_name ?></td>
                                                                <td><?php
                                                                    if (isset($invoice_issued[$school->schema_name])) {
                                                                        echo '<label class="label label-primary">'.$invoice_issued[$school->schema_name].'</label>';
                                                                    } else {
                                                                        echo '<label class="badge badge-danger">No</label>';
                                                                    }
                                                                    ?></td>

                                                                  <td>
                                                                      <?php
                                                                    if (isset($allocation[$school->schema_name])) {
                                                                        echo $allocation[$school->schema_name];
                                                                    } else {
                                                                        echo '<label class="badge badge-inverse-warning">No Person Allocated</label>';
                                                                    }
                                                                    ?>
                                                                    </td>
                                                                    <?php
                                                                if (in_array(Auth::user()->id, [2, 7, 20])) {
                                                                    ?>
                                                                    <td>
                                                                        <?php
                                                                        if ($a == 0) {
                                                                            $schema = $school->schema_name;
                                                                            ?>

                                                                            <select name="source_id" class="allocate">
                                                                                <option></option>
                                                                                <option role_id="5" schema="<?= $school->schema_name ?>" value="Event" <?= select("Event", $schema, $sources) ?>>Event</option>
                                                                                <option role_id="5" schema="<?= $school->schema_name ?>" value="Direct Sales" <?= select("Direct Sales", $schema, $sources) ?>>Direct Sales (Visit)</option>
                                                                                <option role_id="5" schema="<?= $school->schema_name ?>" value="Cold Call" <?= select("Cold Call", $schema, $sources) ?>>Cold Call</option>
                                                                                <option role_id="5" schema="<?= $school->schema_name ?>" value="Call Received" <?= select("Call Received", $schema, $sources) ?>>Call Received</option>
                                                                                <option role_id="5" schema="<?= $school->schema_name ?>" value="Partnership(NMB)" <?= select("Partnership(NMB)", $schema, $sources) ?>>Partnership (NMB Bank)</option>
                                                                                <option role_id="5" schema="<?= $school->schema_name ?>" value="Partnership(Other)" <?= select("Partnership(Other)", $schema, $sources) ?>>Partnership (Others)</option>

                                                                                <option role_id="5" schema="<?= $school->schema_name ?>" value="Referral" <?= select("Referral", $schema, $sources) ?>>Referral</option>
                                                                                <option role_id="5" schema="<?= $school->schema_name ?>" value="Website" <?= select("Website", $schema, $sources) ?>>Website</option>
                                                                                <option role_id="5" schema="<?= $school->schema_name ?>" value="SMS" <?= select("SMS", $schema, $sources) ?>>SMS</option>
                                                                                <option role_id="5" schema="<?= $school->schema_name ?>" value="Social Media" <?= select("Social Media", $schema, $sources) ?>>Social Media</option>
                                                                            </select>
                                                                            <span id="status_result_5_<?= $school->schema_name ?>"></span>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if ($a == 0) {
                                                                            ?>
                                                                            <select name="support_id" class="allocate">
                                                                                <option></option>
                                                                                <?php
                                                                                foreach ($staffs as $staff) {
                                                                                    ?>
                                                                                    <option user_id="<?= $staff->id ?>" role_id="8" schema="<?= $school->schema_name ?>" school_id="" value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <span id="status_result_8_<?= $school->schema_name ?>"></span>

                                                                        <?php } ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php
                                                                        if ($a == 0) {
                                                                            ?>
                                                                            <select name="sales_id" class="allocate">
                                                                                <option></option>
                                                                                <?php
                                                                                foreach ($staffs as $staff) {
                                                                                    ?>
                                                                                    <option user_id="<?= $staff->id ?>" role_id="3" schema="<?= $school->schema_name ?>" school_id="" value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                                                                                <?php } ?>

                                                                            </select>
                                                                            <span id="status_result_3_<?= $school->schema_name ?>"></span>
                                                                        <?php } ?>
                                                                    </td>
                                                                <?php } ?>

                                                                <td><?php
                                                                if ($students == 0) {
                                                                    echo '<label class="badge badge-warning"> 0</label>';
                                                                    $no_students++;
                                                                } else {
                                                                    echo '<label class="badge badge-info">' . $students .'</label>';
                                                                }
                                                                ?></td>
                                                                <td> 
                                                                    
                                                                <?php 
                                                                if (isset($mark_status[$school->schema_name])) {
                                                                    echo '<label class="label label-primary">' . date('d M Y', strtotime($mark_status[$school->schema_name])) . '</label>';
                                                                } else {
                                                                    $no_marks++;
                                                                    echo '<label class="badge badge-inverse-warning">Not Defined</label>';
                                                                }
                                                                ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    //classlevel

                                                                    if (isset($exam_report_status[$school->schema_name])) {
                                                                        echo '<label class="label label-primary">' . date('d M Y', strtotime($exam_report_status[$school->schema_name])) . '</label>';
                                                                    } else {
                                                                        $no_exams_published++;
                                                                        echo '<label class="badge badge-inverse-warning">Not Defined</label>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    //classlevel
                                                                    if (isset($invoice_status[$school->schema_name])) {

                                                                        echo '<label class="label label-primary">' . $invoice_status_count[$school->schema_name] . ' out of ' . $students . '</label><br/>
                                                                        <label  class="label label-primary">Last created: ' . date('d M Y', strtotime($invoice_status[$school->schema_name])) . '</label>';
                                                                    } else {
                                                                        $no_invoice++;
                                                                        echo '<label class="badge badge-inverse-warning">No Invoice Created</label>';
                                                                    }
                                                                    ?>
                                                                </td>

                                                                <td> <?php
                                                                //classlevel
                                                                if (isset($expense_status[$school->schema_name])) {

                                                                    echo '<label class="label label-primary">' . $expense_status_count[$school->schema_name] . ' trans</label><br/>
                                                                    <label  class="label label-primary">Last created: ' . date('d M Y', strtotime($expense_status[$school->schema_name])) . '</label>';
                                                                } else {
                                                                    $no_expense++;
                                                                    echo '<label class="badge badge-inverse-warning">No Expense Recorded</label>';
                                                                }
                                                                    ?></td>
                                                                <td> <?php
                                                                //classlevel
                                                                if (isset($payment_status[$school->schema_name])) {

                                                                    echo '<label class="label label-primary">' . $payment_count[$school->schema_name] . ' trans</label><br/>
                                                                    <label  class="label label-primary">Last created: ' . date('d M Y', strtotime($payment_status[$school->schema_name])) . '</label>';
                                                                } else {
                                                                    $no_payment++;
                                                                    echo '<label class="badge badge-inverse-warning">No Payment Recorded</label>';
                                                                }
                                                                    ?></td>
                                                                <td>
                                                                    <?php $view_url = "customer/profile/$school->schema_name"; ?>
                                                                     <a href="<?= url($view_url) ?>" class="btn btn-info btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="School profile"> view </a>

                                                                </td>

                                                            </tr>
                                                         <?php } ?> 
                                                       
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>School Name</th>
                                                            <th colspan="3"></th>
                                                            <th><?= $no_students ?></th>
                                                            <th><?= $no_marks ?></th>
                                                            <th><?= $no_exams_published ?></th>
                                                            <th><?= $no_invoice ?></th>
                                                            <th><?= $no_expense ?></th>
                                                            <th><?= $no_payment ?></th>

                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>
                            <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                                    <div class="card-block">
                                        <h6>
                                            <b>User Allocation Summary</b>
                                        </h6>
                                         <div class="table-responsive">
                                              <table class="table dataTable table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>No of Schools</th>
                                                        <th style="width:50px;">School Allocated</th>
                                                        <th>Active Schools</th>
                                                        <th>Non Active Schools</th>
                                                        <th>Tasks Allocated</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $users = \App\Models\User::whereIn('role_id', [14,8])->where('status','=','1')->get();
                                                    foreach ($users as $user) {
                                                        $schools = $user->usersSchools()->where('role_id', 8);
                                                        ?>
                                                        <tr>
                                                            <td><?= $user->firstname . ' ' . $user->lastname ?></td>
                                                            <td><?= $schools->count() ?></td>
                                                            <td style="width:50px;">
                                                                <?php
                                                                $active = 0;
                                                                $not_active = 0;
                                                                foreach ($schools->get() as $school) {
                                                                    echo $school->school->schema_name. ',';
                                                                    $active = getActiveStatus($school->school->schema_name) == 1 ? $active + 1 : $active;
                                                                    $not_active = getActiveStatus($school->school->schema_name) == 0 ? $not_active + 1 : $not_active;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?= $active ?></td>
                                                            <td><?= $not_active ?></td>
                                                            <td><?= $user->tasks()->count() ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>No of Schools</th>
                                                        <th>School Allocated</th>
                                                        <th>Active Schools</th>
                                                        <th>Non Active Schools</th>
                                                        <th>Tasks Allocated</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                               </div>
                        </div>
                    </div>



                </div>
            </div>
            <!-- Page-body end -->
        </div>
    </div>
    <!-- Main-body end -->
    @endsection
    @section('footer')
    <!-- data-table js -->
    <?php $root = url('/') . '/public/' ?>

    <script type="text/javascript">
        allocate = function () {
            $('.allocate').change(function () {
                var user_id = $('option:selected', this).attr('user_id');
                var school_id = $('option:selected', this).attr('school_id');
                var role_id = $('option:selected', this).attr('role_id');
                var schema = $('option:selected', this).attr('schema');
                var val = $(this).val();
                $.ajax({
                    type: 'post',
                    url: '<?= url('customer/allocate') ?>',
                    data: {
                        user_id: user_id,
                        school_id: school_id,
                        role_id: role_id,
                        schema: schema,
                        val: val
                    },
                    dataType: 'html',
                    success: function (data) {
                        /// alert('success',data);
                        $('#status_result_' + role_id + '_' + schema).html('<label class="label label-success">success</label>');

                    }
                });
            });
        }
        $('#school_id').keyup(function () {
            var val = $(this).val();
            $.ajax({
                url: '<?= url('customer/search/null') ?>',
                data: {
                    val: val,
                    type: 'school',
                    schema: ''
                },
                dataType: 'html',
                success: function (data) {

                    $('#search_result').html(data);
                }
            });
        });


        get_statistic = function () {
            // var data = getData();
            // console.log(data);
            //        $(".get_data").each(function (index) {
            //            var tag = $(this).attr('tag');
            //            var schema = $(this).attr('schema');
            //            //$(schema + tag).html(1);
            //
            //
            //        });
        }

        function getData() {
            $.ajax({
                type: 'get',
                url: '<?= url('customer/getData/null/') ?>',
                data: {
                    tag: 'users'
                },
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (i, info) {
                        $(".get_data").each(function (index) {
                            var tag = $(this).attr('tag');
                            var schema = $(this).attr('schema');

                            if (tag == info.table && schema == info.schema_name) {
                                $('#' + schema + tag).html(info.count);
                            }


                        });

                    });
                    return data;
                },
                error: function () {
                    return 2;
                }

            });
        }
        search_checked = function () {



            $('.check').click(function () {
                var value = $(this).val();
                var status = $(this).is(':checked');
                //uncheck "select all", if one of the listed checkbox item is unchecked
                if (false == $(this).prop("checked")) { //if this item is unchecked
                    $("#toggle_all").prop('checked', false); //change "select all" checked status to false
                    $('#delete_all_invoices').hide();

                }
                //check "select all" if all checkbox items are checked

                if ($('.check:checked').length == $('.check').length) {
                    $("#toggle_all").prop('checked', true);
                    $('#notify_schools').hide();
                    $('#notify_schools').show();

                } else if ($('.check:checked').length != null) {
                    $('#notify_schools').show();
                }

                if (status === true) {
                    //var text = $('#row' + value).html();
                    $('#search_checked_table').show();

                    var ex = $('#schools_mapped').val();
                    console.log(ex);
                    var param = ex.split(",");
                    param.push(value);
                    $('#schools_mapped').val(param.join(","));
                    console.log(param);

                } else {

                    var ex = $('.link').attr('tags');
                    var url = '<?= url('invoices/delete_class_invoice/?ids=') ?>';
                    var param = ex.split(",");
                    param = jQuery.grep(param, function (val) {
                        return val != value;
                    });
                    var arr = param;

                    var result = arr.filter(function (elem) {
                        return elem != value;
                    });
                    console.log(result);
                    $('#schools_mapped').val(result.join(","));
                    $('#delete_all_invoices').attr('tags', result.join(","));
                    $('#delete_all_invoices').attr('href', url + result.join(","));
                    $('#delete_selected_invoices').attr('tags', result.join(","));
                    $('#delete_selected_invoices').attr('href', url + result.join(","));

                    $('#s_table' + value).remove();
                }
            });
        }
        $(document).ready(get_statistic);
        $(document).ready(allocate);
        $(document).ready(search_checked);
    </script>
    @endsection
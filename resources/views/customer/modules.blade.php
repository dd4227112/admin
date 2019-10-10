@extends('layouts.app')
@section('content')
<?php
/**
 * select distinct &quot;schema_name&quot; from admin.all_student where extract (year from
  created_at)=&#39;2019&#39; order by &quot;schema_name&quot; -to get the schools that have recorded
  students this year.
  ● select distinct &quot;schema_name&quot; from admin.all_marks where extract (year from
  created_at)=&#39;2019&#39; -to get the schools that have recorded marks in the system.
  ● select distinct &quot;schema_name&quot; from admin.all_invoices where extract (year from
  created_at)=&#39;2019&#39; -to get the schools that have created invoices in the system.
  ● select distinct &quot;schema_name&quot; from admin.all_bank_accounts_integrations where
  extract (year from created_at)=&#39;2019&#39; -to get the schools that have been integrated
  with NMB.
  ● select distinct &quot;schema_name&quot; from admin.all_payments where extract (year from
  created_at)=&#39;2019&#39; -to get the schools that have recorded payments.
  ● select distinct &quot;schema_name&quot; from admin.all_payments where extract (year from
  created_at)=&#39;2019&#39; and &quot;token&quot; is not null -to get the schools that have recorded
  payments electronically.
  ● select distinct &quot;schema_name&quot; from admin.all_expense where extract (year from
  created_at)=&#39;2019&#39; -to
 */
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
$invoice_status_count=[];
foreach ($invoices as $invoice) {
    $invoice_status[$invoice->schema_name] = $invoice->created_at;
    $invoice_status_count[$invoice->schema_name] = $invoice->count;
}

$expenses = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_expense  group by schema_name');
$expense_status = [];
$expense_status_count=[];
foreach ($expenses as $expense) {
    $expense_status[$expense->schema_name] = $expense->created_at;
    $expense_status_count[$expense->schema_name] = $expense->count;
}

$payments = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_payments  group by schema_name');
$payment_status = [];
$payment_count=[];
foreach ($payments as $payment) {
    $payment_status[$payment->schema_name] = $payment->created_at;
    $payment_count[$payment->schema_name] = $payment->count;
}

$school_allocations=DB::select('select c.schema_name, c.name,b.firstname, b.lastname from admin.users_schools a join admin.users b on b.id=a.user_id join admin.schools c on c.id=a.school_id where a.role_id=8 and a.status=1 and c.schema_name is not null');
$allocation = [];
foreach ($school_allocations as $school_allocation) {
    $allocation[$school_allocation->schema_name] = $school_allocation->firstname.' '.$school_allocation->lastname;
}
?>
<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Schools Modules Usage</h4>
                <span>The goal is to ensure all modules are effectively used by all schools</span>
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
                    <li class="breadcrumb-item"><a href="#!">Modules Usage</a>
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
                            <h5>Modules</h5>
                            <span>This part shows which modules are actively used by school and which areas we need to focus to help schools.</span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                                <i class="icofont icofont-close-circled"></i>
                            </div>

                        </div>

                        <div class="card-block">

                            <div class="table-responsive dt-responsive">
                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                    <thead>
                                        <tr>
                                            <th>School Name</th>
                                            <td>Support Personnel</td>
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
                                        foreach ($schools as $school) {
                                            $students = DB::table($school->schema_name . '.student')->count();
                                         
                                            ?>
                                            <tr>
                                                <td><?=$school->schema_name?></td>
                                                <td><?php
                                                if(isset($allocation[$school->schema_name])){
                                                    echo $allocation[$school->schema_name];
                                                }else{
                                                    echo '<b class="label label-warning">No Person Allocated</b>';
                                                }
                                                ?></td>
                                               
                                                <td><?php
                                                    if ($students == 0) {
                                                        echo 0;
                                                        $no_students++;
                                                    } else {
                                                        echo $students;
                                                    }
                                                    ?></td>
                                                <td>   <?php
                                                    //classlevel

                                                    if (isset($mark_status[$school->schema_name])) {

                                                        echo '<b class="label label-success">' . date('d M Y', strtotime($mark_status[$school->schema_name])) . '</b>';
                                                    } else {
                                                        $no_marks++;
                                                        echo '<b class="label label-warning">Not Defined</b>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    //classlevel

                                                    if (isset($exam_report_status[$school->schema_name])) {
                                                        echo '<b class="label label-success">' . date('d M Y', strtotime($exam_report_status[$school->schema_name])) . '</b>';
                                                    } else {
                                                        $no_exams_published++;
                                                        echo '<b class="label label-warning">Not Defined</b>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    //classlevel
                                                    if (isset($invoice_status[$school->schema_name])) {

                                                        echo '<b class="label label-success">' . $invoice_status_count[$school->schema_name] . ' out of ' . $students . '</b><br/><b  class="label label-success">Last created: '.date('d M Y',strtotime($invoice_status[$school->schema_name])).'</b>';
                                                    } else {
                                                        $no_invoice++;
                                                        echo '<b class="label label-warning">No Invoice Created</b>';
                                                    }
                                                    ?>
                                                </td>





                                                <td >      <?php
                                                    //classlevel
                                                    if (isset($expense_status[$school->schema_name])) {

                                                        echo '<b class="label label-success">' . $expense_status_count[$school->schema_name] . ' trans</b><br/><b  class="label label-success">Last created: '.date('d M Y',strtotime($expense_status[$school->schema_name])).'</b>';
                                                    } else {
                                                        $no_expense++;
                                                        echo '<b class="label label-warning">No Expense Recorded</b>';
                                                    }
                                                    ?></td>
                                                <td >      <?php
                                                    //classlevel
                                                    if (isset($payment_status[$school->schema_name])) {

                                                        echo '<b class="label label-success">' . $payment_count[$school->schema_name] . ' trans</b><br/><b  class="label label-success">Last created: '.date('d M Y',strtotime($payment_status[$school->schema_name])).'</b>';
                                                    } else {
                                                        $no_payment++;
                                                        echo '<b class="label label-warning">No Payment Recorded</b>';
                                                    }
                                                    ?></td>
                                                <td><a href="<?= url('customer/profile/' . $school->schema_name) ?>" class="btn btn-mini waves-effect waves-light btn-primary"><i class="icofont icofont-eye-alt"></i> View</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>School Name</th>
                                            <th></th>
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
                data: {tag: 'users'},
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (i, info)
                    {
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
        $(document).ready(get_statistic);
    </script>
    @endsection

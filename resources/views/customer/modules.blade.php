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
                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>School Name</th>
                                            <td>Students</td>
                                            <th>Marks Entered</th>
                                            <th>Exams Published</th>
                                            <th>Invoice Created</th>
                                            <th>Expense Recorded</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($schools as $school) {
                                               $students= DB::table($school->schema_name . '.student')->count();
                                            ?>
                                            <tr>
                                                <td><?= $school->schema_name ?></td>
<td><?= $students ?></td>
                                                <td>   <?php
                                                    //classlevel
                                                    $mark = DB::table($school->schema_name . '.mark')->select('created_at')->orderBy('created_at', 'desc')->first();
                                                    if (count($mark) == 1) {
                                                        echo '<b class="label label-success">' . date('d M Y',strtotime($mark->created_at)) . '</b>';
                                                    } else {
                                                        echo '<b class="label label-warning">Not Defined</b>';
                                                    }
                                                    ?>
                                                </td>
                                                 <td>
                                                    <?php
                                                    //classlevel
                                                    $exam_report = DB::table($school->schema_name . '.exam_report')->select('created_at')->orderBy('created_at', 'desc')->first();
                                                    if (count($exam_report) == 1) {
                                                        echo '<b class="label label-success">' .date('d M Y',strtotime($exam_report->created_at)) . '</b>';
                                                    } else {
                                                        echo '<b class="label label-warning">Not Defined</b>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    //classlevel
                                                    $invoices = DB::table($school->schema_name . '.invoices')->count();
                                                    if ($invoices > 0) {
                                                     
                                                        echo '<b class="label label-success">' . $invoices . ' out of '.$students.'</b>';
                                                    } else {
                                                        echo '<b class="label label-warning">Not Invoice Created</b>';
                                                    }
                                                    ?>
                                                </td>
                                               
                                              



                                                <td >      <?php
                                                    //classlevel
                                                    $expense = DB::table($school->schema_name . '.expense')->count();
                                                    if ($expense > 0) {
                                                       
                                                        echo '<b class="label label-success">' . $expense . ' trans</b>';
                                                    } else {
                                                        echo '<b class="label label-warning">Not Expense Recorded</b>';
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
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>

                                        
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
        $(document).ready(function () {
            $('#dt-ajax-array').DataTable();
            //        $('#dt-ajax-users').DataTable({
            //            "ajax": '<?= url('customer/getData/data/?tag=users') ?>'
            //        });
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

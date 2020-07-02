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
//DB::statement("select admin.join_all('classlevel','classlevel_id,name,level_numeric,school_level_id')");
//$levels = DB::select('select distinct "schema_name" from admin.all_classlevel by schema_name');
//$classlevel_status = [];
//foreach ($levels as $level) {
//    $classlevel_status[$level->schema_name] = $level->schema_name;
//}
?>
<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Schools Setup</h4>
                <span>Once school is registered in the system, all mandatory parts must be specified</span>
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
                    <li class="breadcrumb-item"><a href="#!">Basic Setup</a>
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
                            <h5>School Basic Information</h5>
                            <span>This part shows areas to be defined in specific school. Your task is to ensure all parameters are defined effectively on each school</span>
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

                                            <th>Class Levels</th>
                                            <th>Academic Years</th>
                                            <th>Terms</th>

                                            <th>Sections</th>

                                            <th>School Stamp</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($schools as $school) {
                                            ?>
                                            <tr>
                                                <td><?= $school->schema_name ?></td>

                                                <td>   <?php
                                                    //classlevel
                                                    $levels = DB::table($school->schema_name . '.classlevel')->get();
                                                    if (count($levels) == 0) {
                                                        echo '<b class="label label-warning">Not Defined</b>';
                                                    }
                                                    ?>
                                                    
                                                </td>
                                                <td>
                                                    <?php
                                                    //academic year
                                                    if (count($levels) > 0) {
                                                        foreach ($levels as $level) {

                                                            $academic_year = DB::table($school->schema_name . '.academic_year')->where('class_level_id', $level->classlevel_id)->where('start_date', '<', date('Y-m-d'))->where('end_date', '>', date('Y-m-d'))->first();
                                                            if (count($academic_year) == 0) {
                                                                echo '<b class="label label-warning">Not Defined for ' . $level->name . ' (' . date('Y') . ')</b>';
                                                            }
                                                        }
                                                    } else {
                                                        echo '<b class="label label-warning">Not Defined</b>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    //academic year
                                                    if (count($levels) > 0) {
                                                        foreach ($levels as $level) {

                                                            $academic_year = DB::table($school->schema_name . '.academic_year')->where('class_level_id', $level->classlevel_id)->where('start_date', '<', date('Y-m-d'))->where('end_date', '>', date('Y-m-d'))->first();
                                                            if (count($academic_year) == 0) {
                                                                echo '<b class="label label-warning">No Terms Defined for ' . $level->name . ' (' . date('Y') . ')</b>';
                                                            } else {
                                                                //check terms for this defined year
                                                                $terms = DB::table($school->schema_name . '.semester')->where('academic_year_id', $academic_year->id)->where('start_date', '<', date('Y-m-d'))->where('end_date', '>', date('Y-m-d'))->count();

                                                                echo $terms == 0 ? '<b class="label label-warning">No Terms Defined for ' . $level->name . ' (' . date('Y') . ')</b>' : '';
                                                            }
                                                        }
                                                    } else {
                                                        echo '<b class="label label-warning">Not Defined</b>';
                                                    }
                                                    ?>  

                                                </td>

                                                <td class="get_data" schema='<?= $school->schema_name ?>' tag='section'><span id="<?= $school->schema_name ?>section"></span></td>



                                                <td ><?php
                                                    //stamp
                                                    if (count($levels) > 0) {
                                                        foreach ($levels as $level) {
                                                            if (strlen($level->stamp) < 3) {
                                                                echo '<b class="label label-warning">No Stamp for ' . $level->name . '</b>';
                                                            }
                                                        }
                                                    }
                                                    ?></td>
                                                <td><a href="<?= url('customer/profile/' . $school->schema_name) ?>" class="btn btn-mini waves-effect waves-light btn-primary"><i class="icofont icofont-eye-alt"></i> View</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>School Name</th>
                                            <th>Class Levels</th>
                                            <th>Academic Years</th>
                                            <th>Terms</th>

                                            <th>Sections</th>

                                            <th>School Stamp</th>
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

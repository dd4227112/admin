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
$train = \App\Models\TrainItemAllocation::get();
$school_allocations = DB::select('select a.schema_name,c.source, c.sname,b.firstname, b.lastname from admin.users_schools a join admin.users b on b.id=a.user_id join admin.all_setting c on c."schema_name"::text=a."schema_name"::text where a.role_id=8 and a.status=1 and c.schema_name is not null');
$allocation = [];
$users_allocation = [];

foreach ($school_allocations as $school_allocation) {
    $allocation[$school_allocation->schema_name] = $school_allocation->firstname . ' ' . $school_allocation->lastname;
}

$t_allocations = [];
$trains = DB::select('select * from admin.train_items_allocations a join admin.clients b on b.id=a.client_id join admin.tasks c on c.id=a.task_id join admin.train_items d on d.id=a.train_item_id');
foreach ($trains as $train) {

    $t_allocations[$train->username][$train->id] = $train->status;
}

$root = url('/') . '/public/';
$page = request()->segment(3);
$today = 0;


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
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4 text-right">
                <select class="form-control" id="check_custom_date">
                    <option value="today" >Today</option>
                    <option value="custom" >Custom</option>
                </select>

            </div>
        </div>
        <div class="row" style="display: none" id="show_date">

            <div class="col-lg-4"></div>
            <div class="col-lg-8 text-right">
                <h4 class="sub-title">Date Time Picker</h4>
                <div class="input-daterange input-group" id="datepicker">
                    <input type="date" class="input-sm form-control calendar" name="start" id="start_date">
                    <span class="input-group-addon">to</span>
                    <input type="date" class="input-sm form-control" name="end" id="end_date">
                    <input type="submit" class="input-sm btn btn-sm btn-success" id="search_custom"/>
                </div>
            </div>

        </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>School Basic Information</h5>
                            <span>This part shows areas to be defined in specific school. Your task is to ensure all parameters are defined effectively on each school</span>
                            <b>Please Observe</b>
                            <p class="alert alert-info">If you allocate status to Any School, that task will be assigned to your account, not to someone else</p>

                        </div>

                        <div class="card-block">

                            <div class="table-responsive dt-responsive">
                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                    <thead>
                                        <tr>
                                            <th>School Name</th>

                                            <th>Person Allocated</th>
                                            <?php
                                            $x = 1;
                                            $trainings = \App\Models\TrainItem::orderBy('id', 'asc')->get();
                                            foreach ($trainings as $training) {
                                                ?>

                                                <th><?= $training->content ?></th>
                                            <?php } ?>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $complete = '';
                                        $pending = '';
                                        $new = '';
                                        foreach ($schools as $school) {
                                            ?>
                                            <tr>
                                                <td><?= $school->schema_name ?></td>
                                                <td><?php
                                                    if (isset($allocation[$school->schema_name])) {
                                                        echo $allocation[$school->schema_name];
                                                        //$a = 1;
                                                        $a = 0;
                                                    } else {
                                                        $a = 0;
                                                        echo '<b class="label label-warning">No Person Allocated</b>';
                                                    }
                                                    ?></td>
                                                <?php
                                                foreach ($trainings as $training) {
                                                    $status = isset($t_allocations[$school->schema_name][$training->id]) ? $t_allocations[$school->schema_name][$training->id] : '';
                                                    ?>
                                                    <td>
                                                        <select name="<?= $training->id ?>" class="training" data-id="<?= $training->id ?>" data-school-id="<?= $school->schema_name ?>">
                                                            <option value="">Select status</option>
                                                            <option value="complete" <?= strtolower($status) == 'complete' ? 'selected' : '' ?> >Complete</option>
                                                            <option value="pending"  <?= strtolower($status) == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                            <option value="new"  <?= strtolower($status) == 'new' ? 'selected' : '' ?>>Not Yet</option>
                                                        </select>
                                                        <span id="train_status<?= $training->id . '_client' . $school->schema_name ?>"></span>
                                                    </td>

                                                <?php } ?>

                                                <td><a href="<?= url('customer/profile/' . $school->schema_name) ?>" class="btn btn-mini waves-effect waves-light btn-primary"><i class="icofont icofont-eye-alt"></i> View</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block table-border-style">
                                <div class="card-header">
                                    <h5>Task Summary</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tasks</th>
                                                <th>New</th>
                                                <th>Complete</th>
                                                <th>Pending</th>   
                                                <th>Not Allocated</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $x = 1;
                                            $total_schools = \DB::table('admin.all_setting')->count();
                                            foreach ($trainings as $training) {
                                                $counts_complete = $training->trainItemAllocation()->whereIn('task_id', \App\Models\Task::where('status', 'Complete')->get(['id']))->count();
                                                $counts_pending = $training->trainItemAllocation()->whereIn('task_id', \App\Models\Task::where('status', 'Pending')->get(['id']))->count();
                                                $counts_new = $training->trainItemAllocation()->whereIn('task_id', \App\Models\Task::where('status', 'New')->get(['id']))->count();
                                                ?>
                                                <tr>
                                                    <th scope="row"><?= $x ?></th>
                                                    <td><?= $training->content ?></td>
                                                    <td><?= $counts_new ?></td>
                                                    <td><?= $counts_complete ?></td>
                                                    <td><?= $counts_pending ?></td>
                                                    <td><?= $total_schools - ($counts_complete + $counts_new + $counts_pending) ?></td>

                                                </tr>
                                                <?php
                                                $x++;
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>



                        <div class="card">
                            <div class="card-block table-border-style">
                                <div class="card-header">
                                    <h5>Person Task Summary</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Person</th>
                                                <th>New</th>
                                                <th>Complete</th>
                                                <th>Pending</th>   

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $u = 1;
                                            $users_tasks = \App\Models\User::where('status', 1)->where('department','<>',10)->get();
                                            foreach ($users_tasks as $user) {
                                                ?>
                                                <tr>
                                                    <th scope="row"><?= $u ?></th>
                                                    <td><?= $user->firstname ?></td>
                                                    <td><?php
                                                    if ((int) $page == 1 || $page == 'null' || (int) $page == 0) {
   
   echo  $user->tasks()->where('status', 'New')->whereDate('created_at','<=', date('Y-m-d'))->count();
} else {
    $start_date = date('Y-m-d', strtotime(request('start')));
    $end_date = date('Y-m-d', strtotime(request('end')));
  echo  $user->tasks()->where('status', 'New')->whereDate('created_at','<=',$end_date)->whereDate('created_at','>=',$start_date)->count();
}


                                                     ?></td>
                                                    <td><?php 
 if ((int) $page == 1 || $page == 'null' || (int) $page == 0) {
   
   echo  $user->tasks()->where('status', 'Complete')->whereDate('created_at','<=', date('Y-m-d'))->count();
} else {
    $start_date = date('Y-m-d', strtotime(request('start')));
    $end_date = date('Y-m-d', strtotime(request('end')));
  echo  $user->tasks()->where('status', 'Complete')->whereDate('created_at','<=',$end_date)->whereDate('created_at','>=',$start_date)->count();
}

                                                  
                                                     ?></td>
                                                    <td><?php 

 if ((int) $page == 1 || $page == 'null' || (int) $page == 0) {
   
   echo  $user->tasks()->where('status', 'Pending')->whereDate('created_at','<=', date('Y-m-d'))->count();
} else {
    $start_date = date('Y-m-d', strtotime(request('start')));
    $end_date = date('Y-m-d', strtotime(request('end')));
  echo  $user->tasks()->where('status', 'Pending')->whereDate('created_at','<=',$end_date)->whereDate('created_at','>=',$start_date)->count();
}
                          ?>                       </td>

                                                </tr>
                                                <?php
                                                $u++;
                                            }
                                            ?>

                                        </tbody>
                                    </table>
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

        get_statistic = function () {
            $('.training').change(function () {
                var id = $(this).val();
                var training_id = $(this).attr('data-id');
                var school = $(this).attr('data-school-id');
                $.ajax({
                    type: 'get',
                    url: '<?= url('customer/config/null/') ?>',
                    data: {id: id, school_id: school, training_id: $(this).attr('data-id')},
                    success: function (data) {
                        console.log(data);
                        $('#train_status' + training_id + '_client' + school).html(data).addClass('label label-success');
                    },
                    error: function () {
                        return 2;
                    }

                });
            });
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


    check = function () {
        $('#check_custom_date').change(function () {
            var val = $(this).val();
            if (val == 'today') {
                window.location.href = '<?= url('customer/setup/') ?>/1';
            } else {
                $('#show_date').show();
            }
        });
    }
    submit_search = function () {
        $('#search_custom').mousedown(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            window.location.href = '<?= url('customer/setup/') ?>/5?start=' + start_date + '&end=' + end_date;
        });
    }
    $(document).ready(check);
    $(document).ready(submit_search);
</script>
    @endsection

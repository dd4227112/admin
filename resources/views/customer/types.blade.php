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

function getStatus($user, $status = 'New') {
    $page = request()->segment(3);
    if ((int) $page == 1 || $page == 'null' || (int) $page == 0) {

        $result = $user->tasks()->where('status', $status)->whereDate('updated_at', '<=', date('Y-m-d'))->count();
    } else {
        $start_date = date('Y-m-d', strtotime(request('start')));
        $end_date = date('Y-m-d', strtotime(request('end')));
        $result = $user->tasks()->where('status', $status)->whereDate('updated_at', '<=', $end_date)->whereDate('updated_at', '>=', $start_date)->count();
    }
    return $result;
}
?>
<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">

       
        <div class="page-header">
            <div class="page-header-title">
                <h4> Setup</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">setup</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 
      
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            
                            <span>This part shows areas to be defined in specific school. Your task is to ensure all parameters are defined effectively on each school</span>
                            <b>Please Observe</b>
                            <p class="alert alert-info">If you allocate status to Any School, that task will be assigned to your account, not to someone else</p>

                        </div>

                        <div class="card-block">

                            <div class="table-responsive dt-responsive">
                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School Name</th>
                                            <th>Person Allocated</th>
                                            <?php
                                            $x = 1;
                                            ?>

                                            <th>Gender</th>
                                            <th>Category</th>
                                            <th>Religion</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $x = 1;
                                        $complete = '';
                                        $pending = '';
                                        $new = '';
                                        foreach ($schools as $school) {
                                            ?>
                                            <tr>
                                                <td><?= $x ?></td>
                                                <td><?= $school->schema_name.' - '.$school->name ?></td>
                                                <td><?php
                                                    if (isset($allocation[$school->schema_name])) {
                                                        echo $allocation[$school->schema_name];
                                                        //$a = 1;
                                                        $a = 0;
                                                    } else {
                                                        $a = 0;
                                                        echo '<label class="badge badge-inverse-warning">No Person Allocated</label>';
                                                    }
                                                    ?></td>
                                            
                            <td>
                                <select name="<?= $school->classlevel_id ?>" data-tag="gender" class="training" data-id="<?= $school->classlevel_id ?>" data-school-id="<?= $school->schema_name ?>">
                                    <option value="">Select status</option>
                                    <option value="1" <?= isset($school->gender) && (int)$school->gender == 1 ? 'selected' : '' ?> >Boys</option>
                                    <option value="2"  <?= isset($school->gender) && (int)$school->gender == 2 ? 'selected' : '' ?>>Girls</option>
                                    <option value="3"  <?= isset($school->gender) && (int)$school->gender == 3 ? 'selected' : '' ?>>Mixture</option>
                                </select>
                                <span id="gender<?= $school->classlevel_id . '_client' . $school->schema_name ?>"></span>
                            </td>
                                                
                                                 <td>
                                                    <select name="<?= $school->classlevel_id ?>" data-tag="category" class="training" data-id="<?= $school->classlevel_id ?>" data-school-id="<?= $school->schema_name ?>">
                                                        <option value="">Select status</option>
                                                        <option value="1" <?= (int)$school->category == 1 ? 'selected' : '' ?> >Day Only</option>
                                                        <option value="2"  <?=(int)$school->category == 2 ? 'selected' : '' ?>>Boarding Only</option>
                                                        <option value="3"  <?= (int)$school->category == 3? 'selected' : '' ?>>Mixture (Hostel)</option>
                                                    </select>
                                                    <span id="category<?= $school->classlevel_id . '_client' . $school->schema_name ?>"></span>
                                                </td>
                                                
                                                
                                                 <td>
                                                    <select name="<?= $school->classlevel_id ?>" data-tag="religion" class="training" data-id="<?= $school->classlevel_id ?>" data-school-id="<?= $school->schema_name ?>">
                                                        <option value="">Select status</option>
                                                        <option value="1" <?= (int)$school->religion == 1 ? 'selected' : '' ?> >Christian School</option>
                                                        <option value="2"  <?=(int)$school->religion == 2 ? 'selected' : '' ?>>Islamic School</option>
                                                        <option value="3"  <?= (int)$school->religion == 3? 'selected' : '' ?>>No Religion</option>
                                                    </select>
                                                    <span id="religion<?= $school->classlevel_id . '_client' . $school->schema_name ?>"></span>
                                                </td>



                                                <td><a href="<?= url('customer/profile/' . $school->schema_name) ?>" class="btn btn-mini btn-round btn-primary"> View</a></td>
                                            </tr>
                                        <?php $x++; } ?>
                                    </tbody>

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
            $('.training').change(function () {
                var id = $(this).val();
                var classlevel_id = $(this).attr('data-id');
                var schema_name = $(this).attr('data-school-id');
                var tag=$(this).attr('data-tag');
                $.ajax({
                    type: 'get',
                    url: '<?= url('customer/typeConfig/null/') ?>',
                    data: {value_id: id, schema_name: schema_name, classlevel_id: classlevel_id,tag:tag},
                    success: function (data) {
                        console.log(data);
                        $('#' +tag+ classlevel_id + '_client' + schema_name).html(data).addClass('label label-success');
                    },
                    error: function () {
                        return 2;
                    }

                });
            });
        }
        $(document).ready(get_statistic);



    </script>
    @endsection

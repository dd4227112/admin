@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ;
$start =date('Y-m-d', strtotime($from_date));
$end =date('Y-m-d', strtotime($to_date)); ?>
    <div class="page-header">
        <div class="page-header-title">
            <h4>Staff Reports</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Users</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Staff Reports</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-body">

             <div class="row">
                <form class="my-4 form-horizontal" role="form" method="POST">
                    @csrf
                    <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label for="start-date">From</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control mb-2" id="from_date" name="from_date" value="<?=$start?>"  placeholder="Start Date">
                    </div>
                    <div class="col-auto">
                        <label for="end-date">To</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control mb-2"  id="to_date" name="to_date" value="<?=$end?>" placeholder="End Date">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-success mb-2">View Report</button>
                    </div>
                    </div>
                </form>

            </div>

            <div class="row">
            <?php if (!empty($users)) { ?>
                    <div class="col-sm-12">
                        <br>
                        <div id="hide-table">
                            <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>s/no</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Usertype</th>
                                        <th>Total KPI</th>
                                        <th>Reports Submitted</th>
                                        <th>Avarage Performance</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($users) > 0) {
                                        $i = 1;
                                        foreach ($users as $user) {
                                            ?>
                                            <tr>
                                                <td data-title="slno">
                                                    <?php echo $i; ?>
                                                </td>

                                                <td data-title="student_photo">
                                                    <?php // profilePic($user->photo); ?>
                                                </td>
                                                <td data-title="student_name">
                                                    <?= $user->name; ?>
                                                </td>
                                                <td data-title="student_name">
                                                    <?= $user->usertype; ?>
                                                </td>
                                                <td data-title="student_sex">
                                                    <?php
                                                    echo $user->staffTargets()->whereBetween('created_at', [$from_date, $to_date])->count();
                                                    ?>
                                                </td>

                                                <td data-title="student_sex">
                                                    <?php
                                                    echo $user->staffReports()->whereBetween('created_at', [$from_date, $to_date])->count();
                                                    ?>
                                                </td>
                                                <td data-title="student_sex">
                                                    <?php
                                                    $r = 1;
                                                    $avg_performance = 0;
                                                    foreach ($user->staffTargets()->whereBetween('created_at', [$from_date, $to_date])->get() as $target) {
                                                        if ((int) $target->is_derived == 1) {
                                                            $cur_value = \collect(DB::select($target->is_derived_sql))->first();
                                                           $performance =  $cur_value->current_value;
                                                        } else {
                                                            $performance = $target->staffTargetsReports()->sum('current_value');
                                                        }
                                                      
                                                        $avg_performance += (float) $target->value > 0 ? round($performance * 100 / $target->value) : 0;
                                                        $r++;
                                                    }
                                                    $avg = (int) $r == 1 ? 0 : round($avg_performance / ($r - 1));
                                                    echo $avg . '%';
                                                    ?>
                                                </td>

                                                <td data-title="action">


                                                          <?php  if (Auth::user()->role_id == 1) 
                                                                 { ?>  <a  href="<?=url('report/setreport/' . $user->id)?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"> </i> Set Report </a> 
                                                                 <?php } ?>

                                                            <a  href="<?=url('report/dashboard/' . $user->id)?>" class="btn btn-success btn-sm"><i class="fa fa-folder"> </i>View </a>

                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--<h2>Summary</h2>-->

                        </div>
                    </div>
                <?php } ?>
               
            </div>
            <!-- Page-body end -->
        </div>
    </div>
    <!-- Main-body end -->
<!-- Modal content start here -->
<div class="modal fade" id="set_key_performance">
    <div class="modal-dialog">
        <form action="performances" method="post" class="form-horizontal group_form" role="form">

            <div class="modal-content">

                <div class="modal-header">
                    Set Key Performances for all staffs
                </div>

                <div class="modal-body">

                    <div class="form-group row" id="name">

                        <div class="col-sm-12">
                        <label for="name" class="control-label required">Name</label>
                            <input type="text" name="name" id="name" class="form-control ">  
                        </div>
                    </div>
                    <div class="form-group row"  id="custom_query">
                        <div class="col-sm-12">
                        <label for="custom_query" class="control-label required"> Custom Query</label>
                            <input type="text" name="custom_query" id="custom_query" class="form-control ">

                        </div>
                    </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" >close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
                <input type="hidden" name="user_sid" value="<?= $user->sid ?>">
                <?= csrf_field() ?>
            </div>
        </form>
    </div>
</div>

    
    @endsection
    @section('footer')
    <!-- data-table js -->
    
<script type="text/javascript">

// check = function () {

//     $('#check_custom_date').change(function () {
//         var val = $(this).val();
//         if (val == 'today') {
//             window.location.href = '<?= url('Sales/salesStatus/') ?>/1';
//         } else {
//             $('#show_date').show();
//         }
//     });
// }
// submit_search = function () {
//     $('#search_custom').mousedown(function () {
//         var start_date = $('#start_date').val();
//         var end_date = $('#end_date').val();
//         window.location.href = '<?= url('users/hrrequest/') ?>/5?start=' + start_date + '&end=' + end_date;
//     });
// }
// $(document).ready(check);
// $(document).ready(submit_search);
</script>


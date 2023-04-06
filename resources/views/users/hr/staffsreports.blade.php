@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
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
    <!-- <form style="" class="my-4 form-horizontal" role="form" method="post">  
                    <div class="row">
                        <div class="col-sm-5 mx-auto">
                            <div class="input-group row"> 
                                <div class="col-sm-4">
                                    <input type="date" required class=" calendar" id="from_date" name="from_date" value="<?= $from_date ?>"  >
                                </div>
                                <div class="col-sm-4">
                                    <input type="date" required class=" calendar" id="to_date" name="to_date" value="<?= $to_date?>" >
                                </div>
                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary btn-block" value="view_report" >
                                </div>
                            </div>
                            <?= csrf_field() ?>
                        </div>
                    </div>
                </form> -->
                <div class="container">
                <form class="my-4 form-horizontal" role="form" method="POST">
                    @csrf
                    <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label for="start-date">From</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control mb-2" id="from_date" name="from_date" value="<?=$from_date?>"  placeholder="Start Date">
                    </div>
                    <div class="col-auto">
                        <label for="end-date">To</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control mb-2"  id="to_date" name="to_date" value="<?=$to_date?>" placeholder="End Date">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-primary mb-2">View Report</button>
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
                                        <th>slno</th>
                                        <th>photo</th>
                                        <th>name</th>
                                        <th>usertype</th>
                                        <th>total_kpi</th>
                                        <th>reports_submitted</th>
                                        <th>avarage_performance</th>
                                        <th>action</th>
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
                                                    echo $user->staffTargets()->count();
                                                    ?>
                                                </td>

                                                <td data-title="student_sex">
                                                    <?php
                                                    echo $user->staffReports()->count();
                                                    ?>
                                                </td>
                                                <td data-title="student_sex">
                                                    <?php
                                                    $r = 1;
                                                    $avg_performance = 0;
                                                    foreach ($user->staffTargets()->get() as $target) {
                                                        if ((int) $target->is_derived == 1) {
                                                            $cur_value = \collect(DB::select($target->is_derived_sql))->first();
                                                           $performance =  $cur_value->current_value;
                                                        } else {
                                                            $performance = $target->staffTargetsReports()->max('current_value');
                                                        }
                                                      
                                                        $avg_performance += (float) $target->value > 0 ? round($performance * 100 / $target->value) : 0;
                                                        $r++;
                                                    }
                                                    $avg = (int) $r == 1 ? 0 : round($avg_performance / ($r - 1));
                                                    echo $avg . '%';
                                                    ?>
                                                </td>

                                                <td data-title="action">


                                                            <a  href="<?=url('report/setreport/' . $user->uuid)?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"> </i> Set Report </a> 

                                                            <a  href="<?=url('report/dashboard/' . $user->uuid)?>" class="btn btn-success btn-sm"><i class="fa fa-folder"> </i>View </a>

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
    @endsection

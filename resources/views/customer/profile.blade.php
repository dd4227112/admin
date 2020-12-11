@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/';
define('SCHEMA', $schema);

function check_status($table, $where = null) {
    $schema = SCHEMA;
    if ($table == 'admin.vendors') {
        $report = \collect(DB::select('select created_at::date from ' . $table . '  ' . $where . ' order by created_at::date desc limit 1'))->first();
    }elseif ($table == 'invoices') {
        $report = \collect(DB::select('select date::date as created_at from ' . $table . '  ' . $where . ' order by date::date desc limit 1'))->first();
    } else {
        $report = \collect(DB::select('select created_at::date from ' . $schema . '.' . $table . '  ' . $where . ' order by created_at::date desc limit 1'))->first();
    }
    if (!empty($report)) {

        $echo = '<b class="label label-success">' . date('d M Y', strtotime($report->created_at)) . '</b>';
    } else {

        $echo = '<b class="label label-warning">Not Defined</b>';
    }
    return $echo;
}
?>


<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4><?= $school->sname ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!"><?= substr($school->sname, 0, 20) ?> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div>
                        <div class="content social-timeline">
                            <div class="">
                                <!-- Row Starts -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Social wallpaper start -->
                                        <div class="social-wallpaper">
                                            <div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=<?= $school->sname ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net/blog/nordvpn-coupon-code/">nordvpn coupon</a></div><style>.mapouter{position:relative;text-align:right;height:300px;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:100%;}</style></div>
                                            <div class="profile-hvr">
                                                <i class="icofont icofont-ui-edit p-r-10"></i>
                                                <i class="icofont icofont-ui-delete"></i>
                                            </div>
                                        </div>
                                        <!-- Social wallpaper end -->
                                        <!-- Timeline button start -->
                                        <div class="timeline-btn">

                                            <a href="#" class="btn btn-primary waves-effect waves-light">Send Message</a>
                                        </div>
                                        <!-- Timeline button end -->
                                    </div>
                                </div>
                                <!-- Row end -->
                                <!-- Row Starts -->
                                <div class="row">
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-xs-12">
                                        <!-- Social timeline left start -->
                                        <div class="social-timeline-left">
                                            <!-- social-profile card start -->
                                            <div class="card">
                                                <div class="social-profile">
                                                    <?php
                                                    $image = strlen($school->photo) > 3 ? 'storage/uploads/images/' . $school->photo : 'storage/uploads/images/defualt.png';
                                                    ?>
                                                    <img class="img-fluid width-100" src="https://demo.shulesoft.com/<?= $image ?>" alt="">
                                                    <div class="profile-hvr m-t-15">
                                                        <i class="icofont icofont-ui-edit p-r-10"></i>
                                                        <i class="icofont icofont-ui-delete"></i>
                                                    </div>
                                                </div>
                                                <div class="card-block social-follower">
                                                    <h4><?= $school->sname ?></h4>
                                                    <h5><?= $school->address ?></h5>
                                                    <?php
                                                    if ($is_client == 1) {
                                                        ?>
                                                        <div class="row follower-counter">
                                                            <div class="col-md-12 col-lg-3">
                                                                <div class="txt-primary"><?= \DB::table($schema . '.student')->where('status', 1)->count() ?></div>
                                                                <div>Students</div>
                                                            </div>
                                                            <div class="col-md-12 col-lg-3">
                                                                <div class="txt-primary"><?= \DB::table($schema . '.parent')->where('status', 1)->count() ?></div>
                                                                <div>Parents</div>
                                                            </div>

                                                            <div class="col-md-12 col-lg-3">
                                                                <div class="txt-primary"><?= \DB::table($schema . '.user')->where('status', 1)->count() ?></div>
                                                                <div>Staff</div>
                                                            </div>

                                                            <div class="col-md-12 col-lg-3">
                                                                <div class="txt-primary"><?= \DB::table($schema . '.teacher')->where('status', 1)->count() ?></div>
                                                                <div>Teacher</div>
                                                            </div>
                                                            <div class="col-md-12 col-lg-12">
                                                                <hr>
                                                                <div class="txt-primary">School Status</div>
                                                                <?php
                                                                $st = DB::table($schema . '.setting')->first();
                                                                echo '<a data-toggle="modal" data-target="#status-Modal">';
                                                                if ($st->school_status == 1) {
                                                                    echo '<div class="btn btn-primary">Active Paid</div>';
                                                                } elseif ($st->school_status == 2) {
                                                                    echo '<div class="btn btn-success">Active</div>';
                                                                } elseif ($st->school_status == 3) {
                                                                    echo '<div class="btn btn-warning">Resale</div>';
                                                                } elseif ($st->school_status == 4) {
                                                                    echo '<div class="btn btn-warning"> Inactive </div>';
                                                                } else {
                                                                    echo '<div>Not defined</div>';
                                                                }
                                                                echo '</a>';
                                                                ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <!-- social-profile card end -->
                                            <!-- Who to follow card start -->
                                            <?php
                                            if ($is_client == 1) {
                                                ?>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-header-text">Top USER Logins</h5>
                                                    </div>
                                                    <div class="card-block user-box">
                                                        <?php
                                                        if (!empty($top_users)) {
                                                            foreach ($top_users as $log) {
                                                                ?>
                                                                <div class="media m-b-10">
                                                                    <a class="media-left" href="#!">
                                                                        <?php
                                                                        $user_image = 'storage/uploads/images/defualt.png';
                                                                        ?>

                                                                        <img class="media-object img-circle" src="https://demo.shulesoft.com/<?= $user_image ?>" alt="Image">
                                                                        <div class="live-status bg-danger"></div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <div class="chat-header"><?= $log->name ?></div>
                                                                        <div class="text-muted social-designation"><?= $log->usertype ?></div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <!--                                                    <div class="card-header contact-user">
                                                    <img class="img-circle" src="assets/images/user-profile/contact-user.jpg" alt="support manager">
                                                    <h4>Angelica Ramos</h4>
                                                  </div>-->

                                                    <div class="card-block groups-contact">
                                                        <h4>Training Reports</h4>
                                                        <ul class="list-group">
                                                            <li class="list-group-item justify-content-between">
                                                                <a href="<?= url('customer/training/config/null?id=' . encrypt($schema)) ?>" target="_blank">Configuration</a>
                                                                <a href="#" title="copy link"><span class="badge badge-default badge-pill">&></span></a>

                                                            </li>
                                                            <li class="list-group-item justify-content-between">
                                                                <a href="<?= url('customer/training/account/null?id=' . encrypt($schema)) ?>" target="_blank"> Accounts</a>
                                                                <span class="badge badge-default badge-pill">&></span>
                                                            </li>
                                                            <li class="list-group-item justify-content-between">
                                                                <a href="<?= url('customer/training/exam/null?id=' . encrypt($schema)) ?>" target="_blank"> Exams</a>
                                                                <span class="badge badge-default badge-pill">&></span>
                                                            </li>
                                                            <!--                                                            <li class="list-group-item justify-content-between">
                                                            Other Modules
                                                            <span class="badge badge-default badge-pill">50</span>
                                                          </li>-->
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- Who to follow card end -->
                                            <?php } ?>
                                        </div>
                                        <!-- Social timeline left end -->
                                    </div>
                                    <div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 ">
                                        <!-- Nav tabs -->
                                        <div class="card social-tabs">
                                            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab" aria-expanded="false">Activities</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#about" role="tab" aria-expanded="false">About</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#implementation" role="tab" aria-expanded="false"> Implementation</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#photos" role="tab" aria-expanded="false"> Usage</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link " data-toggle="tab" href="#friends" role="tab" aria-expanded="true">Staff Members</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link " data-toggle="tab" href="#payments" role="tab" aria-expanded="true">Payments</a>
                                                    <div class="slide"></div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <!-- Timeline tab start -->
                                            <div class="tab-pane active" id="timeline" aria-expanded="false">
                                                <div class="row">
                                                    <div class="card-block">
                                                        <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#large-Modal">Create Task</button>
                                                        <!-- <a href="<?= url('Customer/activity/add') ?>" class="btn btn-primary waves-effect">Create Task</a> -->
                                                        <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1050; display: none;">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Create Task/Activity</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <form action="#" method="post">
                                                                        <div class="modal-body">
                                                                            <span>
                                                                                Create a task for this school with implementation deadline</span>

                                                                            <div class="form-group">
                                                                                <textarea class="form-control" rows="4" placeholder="Create Task" name="activity"></textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="row">

                                                                                    <div class="col-md-6">
                                                                                        Task Type
                                                                                        <select name="task_type_id"  class="form-control select2">
                                                                                            <?php
                                                                                            $types = DB::table('task_types')->where('department', Auth::user()->department)->get();
                                                                                            if (!empty($types)) {
                                                                                                foreach ($types as $type) {
                                                                                                    ?>
                                                                                                    <option value="<?= $type->id ?>"><?= $type->name ?></option>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                            ?>

                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        Person Allocated to do
                                                                                        <select name="to_user_id" class="form-control select2">
                                                                                            <?php
                                                                                            $staffs = DB::table('users')->where('status', 1)->where('role_id', '<>', 7)->get();
                                                                                            if (!empty($staffs)) {
                                                                                                foreach ($staffs as $staff) {
                                                                                                    ?>
                                                                                                    <option value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                            ?>

                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <strong> Start Date</strong>
                                                                                        <input type="datetime-local" class="form-control" placeholder="Deadline" name="start_date">
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <strong> End Date </strong>
                                                                                        <input type="datetime-local" class="form-control" placeholder="Time" name="end_date">
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                            <div class="form-group">
                                                                                <strong>  Pick Modules where task will be Performed</strong>
                                                                                <hr>
                                                                                <?php
                                                                                $modules = DB::table('modules')->get();
                                                                                if (!empty($modules)) {
                                                                                    foreach ($modules as $module) {
                                                                                        ?>
                                                                                        <input type="checkbox" id="feature<?= $module->id ?>" value="{{$module->id}}" name="module_id[]" >  <?php echo $module->name; ?>  &nbsp; &nbsp;

                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <div class="row">

                                                                                    <div class="col-md-12">
                                                                                        <strong> Task Executed Successfully</strong>
                                                                                        <select name="status" class="form-control" required>

                                                                                            <option value='new'> Select Task Status Here...</option>
                                                                                            <option value='complete'> Yes and Completed </option>
                                                                                            <option value='on progress'> Yes but on Progress </option>
                                                                                            <option value='schedule'> Not yet (Schedule) </option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                                                                        </div>
                                                                        <input type="hidden" value="<?= $client_id ?>" name="client_id"/>
                                                                        <?= csrf_field() ?>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 timeline-dot">
                                                        <?php
                                                        $tasks_ids = \App\Models\TaskSchool::whereIn('school_id', \App\Models\ClientSchool::where('client_id', $client_id)->get(['school_id']))->get(['task_id']);
                                                        $tasks = \App\Models\Task::whereIn('id', \App\Models\TaskClient::where('client_id', $client_id)->get(['task_id']))->orWhereIn('id', $tasks_ids)->orderBy('created_at', 'desc')->get();
                                                        if (!empty($tasks)) {
                                                            foreach ($tasks as $task) {
                                                                ?>
                                                                <div class="social-timelines p-relative o-hidden" id="removetag<?= $task->id ?>">
                                                                    <div class="row">
                                                                        <div class="col-xs-2 col-sm-1">
                                                                            <div class="social-timelines-left">
                                                                                <img class="img-circle timeline-icon" src="<?= Auth::user()->photo ?>" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xs-10 col-sm-11 p-l-5 p-b-35">
                                                                            <div class="card m-0">
                                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">Actions</span>
                                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                                    <a class="dropdown-item" href="#" onmousedown="removeTag(<?= $task->id ?>)">Remove tag</a>
                                                                                    <a class="dropdown-item" href="#">Report Photo</a>
                                                                                    <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                                    <a class="dropdown-item" href="#">Blog User</a>
                                                                                </div>

                                                                                <div class="card-block">
                                                                                    <div class="timeline-details">
                                                                                        <div class="chat-header">
                                                                                            <?= $task->user->firstname ?> - <span class="text-muted"><?= date("d M Y", strtotime($task->created_at)) ?></span>
                                                                                        </div>
                                                                                        <p class="text-muted"><?= $task->activity ?></p>
                                                                                        <?php
                                                                                        $modules = $task->modules()->get();
                                                                                        if (count($modules)>0) {
                                                                                            echo '<p>Task Module Performed</p>';
                                                                                            foreach ($modules as $module) {
                                                                                                ?>
                                                                                             <?= $module->module->name ?>  &nbsp; &nbsp; |
                                                                                            <?php } } ?>
                                                                                        <p>Start Date- <?= $task->start_date ?>  &nbsp; &nbsp; | &nbsp; &nbsp; End Date - <?= $task->end_date ?></p>

                                                                                    </div>

                                                                                    <div class="user-box">

                                                                                        <?php
                                                                                        $comments = $task->taskComments()->get();
                                                                                        if (count($comments) > 0) {
                                                                                            ?>
                                                                                            <div class="mt-1"> <span class="f-14"><a href="#">What have been done</a></span></div>
                                                                                            <?php
                                                                                            foreach ($comments as $comment) {
                                                                                                ?>
                                                                                                <div class="media" class="pb-1">
                                                                                                    <a class="media-left" href="#">
                                                                                                        <img class="media-object img-circle m-r-20" src="<?= $root . '/assets/images/avatar-2.png'; ?>" alt="Image">
                                                                                                    </a>
                                                                                                    <div class="media-body b-b-muted social-client-description">
                                                                                                        <div class="chat-header"><?= $comment->user->name ?><span class="text-muted"><?= date('d M Y', strtotime($comment->created_at)) ?></span></div>
                                                                                                        <p class="text-muted"><?= $comment->content ?></p>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                        <div class="new_comment<?= $task->id ?>"></div>
                                                                                        <div class="media">
                                                                                            <a href="#" class="btn btn-success btn-sm right" onclick="return false" onmousedown="$('#comment_area<?= $task->id ?>').toggle()"><i class="ti-comment"></i>  Comment </a>
                                                                                            <div class="media-body"  id="comment_area<?= $task->id ?>" style="display:none">
                                                                                                <form class="">
                                                                                                    <div class="">
                                                                                                        <textarea rows="4" class="form-control" id="task_comment<?= $task->id ?>" placeholder="Write Your comment Here......"></textarea>
                                                                                                        <input type="hidden" class="form-control" value="<?= $task->id ?>" id="task_id<?= $task->id ?>" />
                                                                                                        <span class="input-group-btn">
                                                                                                            <button type="button" class="btn btn-primary" onmousedown="save_comment(<?= $task->id ?>)">Send</button>
                                                                                                        </span>

                                                                                                        <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- Timeline tab end -->
                                            <!-- About tab start -->
                                            <div class="tab-pane " id="about" aria-expanded="true">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-header-text">Basic Information</h5>

                                                                <button id="edit-btn" type="button" class="btn btn-primary waves-effect waves-light f-right" data-toggle="modal" data-target="#school_details">
                                                                    <i class="icofont icofont-edit"></i> Change school Details
                                                                </button>
                                                            </div>
                                                            <div class="card-block">
                                                                <div id="view-info" class="row">
                                                                    <div class="col-lg-6 col-md-12">
                                                                        <form>
                                                                            <table class="table m-b-0">
                                                                                <tbody><tr>
                                                                                        <th class="social-label b-none p-t-0">School Name
                                                                                        </th>
                                                                                        <td class="social-user-name b-none p-t-0 text-muted"><?= $school->sname ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th class="social-label b-none">Location</th>
                                                                                        <td class="social-user-name b-none text-muted"><?= $school->address ?></td>
                                                                                    </tr>
<?php if ($is_client == 1) { ?>
                                                                                        <tr>
                                                                                            <th class="social-label b-none">Date On boarded</th>
                                                                                            <td class="social-user-name b-none text-muted"><?= date('d M Y h:i', strtotime($school->created_at)) ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th class="social-label b-none">Contact Details</th>
                                                                                            <td class="social-user-name b-none text-muted"><?= $school->phone ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th class="social-label b-none p-b-0">School Level</th>
                                                                                            <td class="social-user-name b-none p-b-0 text-muted"><?php
                                                                                                if (!empty($levels)) {
                                                                                                    foreach ($levels as $level) {
                                                                                                        echo $level->name . ' - ' . $level->result_format . '<br/>';
                                                                                                    }
                                                                                                }
                                                                                                ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th class="social-label b-none p-b-0">School Access</th>
                                                                                            <td class="social-user-name b-none p-b-0 text-muted">
                                                                                                <?php
                                                                                                echo 'Username - ' . $school->username . '
                                            <br><a href="' . url('customer/resetPassword/' . $schema) . '" class="btn btn-success btn-sm" ><i class="icofont icofont-refresh"></i> Reset Password</a>';
                                                                                                ?></td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                </tbody></table>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div id="edit-info" class="row" style="display: none;">
                                                                    <div class="col-lg-12 col-md-12">
                                                                        <form>
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" placeholder="Full Name">
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <div class="form-radio">
                                                                                    <div class="form-radio">
                                                                                        <label class="md-check p-0">Gender</label>
                                                                                        <div class="radio radio-inline">
                                                                                            <label>
                                                                                                <input type="radio" name="radio" checked="checked">
                                                                                                <i class="helper"></i>Male
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="radio radio-inline">
                                                                                            <label>
                                                                                                <input type="radio" name="radio">
                                                                                                <i class="helper"></i>Female
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <input id="dropper-default" class="form-control" type="text" placeholder="Birth Date">
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <select id="hello-single" class="form-control">
                                                                                    <option value="">---- Marital Status ----</option>
                                                                                    <option value="married">Married</option>
                                                                                    <option value="unmarried">Unmarried</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="md-group-add-on">
                                                                                <textarea rows="5" cols="5" class="form-control" placeholder="Address..."></textarea>
                                                                            </div>
                                                                            <div class="text-center m-t-20">
                                                                                <a href="javascript:;" id="edit-save" class="btn btn-primary waves-effect waves-light m-r-20">Save</a>
                                                                                <a href="javascript:;" id="edit-cancel" class="btn btn-default waves-effect waves-light">Cancel</a>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-header-text">School Allocation Information</h5>
                                                                <button id="edit-Contact" type="button" class="btn btn-primary waves-effect waves-light f-right">
                                                                    <i class="icofont icofont-edit"></i>
                                                                </button>
                                                            </div>
                                                            <div class="card-block">
                                                                <div id="contact-info" class="row">
                                                                    <div class="col-lg-6 col-md-12">
                                                                        <table class="table m-b-0">
                                                                            <tbody>
                                                                                <?php
                                                                                if ($school->school_id == null) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <th class="social-label b-none">School Mapping </th>
                                                                                        <td class="social-user-name b-none text-muted">



                                                                                            <input class="form-control" id="school_id" name="school_id" type="text" style="width:18em" placeholder="Click here to Map">
                                                                                            <span id="search_result"></span>



                                                                                        </td>
                                                                                        <td class="social-user-name b-none text-muted">  Type at least 3 characters</td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                                <tr>
                                                                                    <th class="social-label b-none">Support Personnel </th>
                                                                                    <td class="social-user-name b-none text-muted">
                                                                                        <?php
                                                                                        $school_allocations = \collect(DB::select("select b.id from admin.users_schools a join admin.users b on b.id=a.user_id join admin.schools c on c.id=a.school_id where a.role_id=8 and a.status=1 and c.schema_name='" . $schema . "'"))->first();
                                                                                        ?>    <select class="form-control" id="support_id" name="support_id">
                                                                                        <?php
                                                                                        if (!empty($shulesoft_users)) {
                                                                                            foreach ($shulesoft_users as $user) {
                                                                                                ?>
                                                                                                    <option value="<?= $user->id ?>" <?php
                                                                                                    if (!empty($school_allocations) && $user->id == $school_allocations->id) {
                                                                                                        $support_person = $user->firstname . ' ' . $user->lastname;
                                                                                                        echo 'selected="selected"';
                                                                                                    } else {
                                                                                                        echo '';
                                                                                                    }
                                                                                                    ?>><?= $user->firstname . ' ' . $user->lastname ?></option>
                                                                                                            <?php
                                                                                                        }
                                                                                                    }
                                                                                                    ?>
                                                                                        </select>


                                                                                    </td>
                                                                                    <td class="social-user-name b-none text-muted">   <input type="button" value="save" onmousedown="allocate($('#support_id').val(), 8)" class="btn btn-success btn-sm"> <span id="supportl"> </span> </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th class="social-label b-none">Sales Personnel </th>
                                                                                    <td class="social-user-name b-none text-muted">
                                                                                        <?php
                                                                                        $school_sales_allocations = \collect(DB::select("select b.id from admin.users_schools a join admin.users b on b.id=a.user_id join admin.schools c on c.id=a.school_id where a.role_id=3 and a.status=1 and c.schema_name='" . $schema . "'"))->first();
                                                                                        ?>                            <select class="form-control" id="sales_id" name="sales_id">

                                                                                            <?php
                                                                                            if (!empty($school_sales_allocations)) {
                                                                                                foreach ($shulesoft_users as $user) {
                                                                                                    ?>
                                                                                                    <option value="<?= $user->id ?>" <?php
                                                                                                    if (!empty($school_sales_allocations) && $user->id == $school_sales_allocations->id) {
                                                                                                        $sales_person = $user->firstname . ' ' . $user->lastname;
                                                                                                        echo 'selected="selected"';
                                                                                                    } else {
                                                                                                        echo '';
                                                                                                    }
                                                                                                    ?>><?= $user->firstname . ' ' . $user->lastname ?></option>
                                                                                                            <?php
                                                                                                        }
                                                                                                    }
                                                                                                    ?>
                                                                                        </select>


                                                                                    </td>
                                                                                    <td class="social-user-name b-none text-muted">   <input type="button" value="save" onmousedown="allocate($('#sales_id').val(), 3)" class="btn btn-success btn-sm"></td>
                                                                                </tr>


                                                                            </tbody></table>
                                                                    </div>
                                                                </div>
                                                                <div id="edit-contact-info" class="row" style="display: none;">
                                                                    <div class="col-lg-12 col-md-12">
                                                                        <form>
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" placeholder="Mobile number">
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" placeholder="Email address">
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" placeholder="Twitter id">
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" placeholder="Skype id">
                                                                            </div>
                                                                            <div class="text-center m-t-20">
                                                                                <a href="javascript:;" id="contact-save" class="btn btn-primary waves-effect waves-light m-r-20">Save</a>
                                                                                <a href="javascript:;" id="contact-cancel" class="btn btn-default waves-effect waves-light">Cancel</a>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-header-text">Customer Contracts</h5>

                                                                <button id="edit-Contact" type="button" class="btn btn-primary waves-effect waves-light f-right"  data-toggle="modal" data-target="#customer_contracts_model">
                                                                    Add New Contract
                                                                </button>
                                                            </div>
                                                            <div class="card-block">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h5>About</h5>
                                                                        <span>All customer legal documents are included in this part </div>
                                                                    <div class="card-block table-border-style">
                                                                        <div class="table-responsive">
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>#</th>
                                                                                        <th>Contract Name</th>
                                                                                        <th>Contract Type</th>
                                                                                        <th>Start Date</th>
                                                                                        <th>End Date</th>
                                                                                        <th>Uploaded By</th>
                                                                                        <th>Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    $client_contracts = \App\Models\ClientContract::where('client_id', $client_id)->get();
                                                                                    $i = 1;
                                                                                    if (!empty($client_contracts)) {
                                                                                        foreach ($client_contracts as $client_contract) {
                                                                                            //  $contract = \App\Models\Contract::where('id', $client_contracts->contract_id)->get();
                                                                                            //  if(!empty($contract)){

                                                                                            ?>
                                                                                            <tr>
                                                                                                <th scope="row"><?= $i ?></th>
                                                                                                <td><?= $client_contract->contract->name ?></td>
                                                                                                <td><?= isset($client_contract->contract->contract_type_id) ? $client_contract->contract->contractType->name : 'Not Defined' ?></td>
                                                                                                <td><?= $client_contract->contract->start_date ?></td>
                                                                                                <td><?= $client_contract->contract->end_date ?></td>
                                                                                                <td><?= $client_contract->contract->user->name ?></td>
                                                                                                <td>
                                                                                                    <a type="button" class="btn btn-primary btn-sm waves-effect" target="_blank" href="<?= url('customer/viewContract/' . $client_contract->contract->id) ?>">View</a>
                                                                                                    <a type="button" class="btn btn-warning btn-sm waves-effect" href="<?= url('customer/deleteContract/' . $client_contract->contract->id) ?>">Delete</a>
                                                                                                </td>
                                                                                            </tr>

                                                                                            <?php
                                                                                            $i++;
                                                                                        }
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

                                                </div>
                                            </div>

                                            <div class="tab-pane" id="implementation" aria-expanded="false">


                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Project Implementation Schedule</h5>
                                                        <span>This part have to be followed effectively </span>
                                                        <p align="right">
                                                            <a href="<?= url('customer/download/' . $client_id) ?>" class="btn btn-warning btn-sx">Download Implementation Plan</a>
                                                        </p>
                                                    </div>
                                                    <div class="card-block table-border-style">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered dataTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Task</th>
                                                                        <th>ShuleSoft Person </th>
                                                                        <th><?= ucfirst($schema) ?> Person Allocated</th>
                                                                        <th>Start Date : Time</th>
                                                                        <th>End Date : Time</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $x = 1;
                                                                    $customer = new \App\Http\Controllers\Customer();
                                                                    $trainings = \App\Models\TrainItemAllocation::where('client_id', $client_id)->orderBy('id', 'asc')->get();
                                                                    foreach ($trainings as $training) {
                                                                        ?>
                                                                        <tr>
                                                                            <th scope="row"><?= $x ?></th>
                                                                            <td><?= $training->trainItem->content ?></td>
                                                                            <td>
                                                                                <?php
                                                                                ?>
                                                                                <select class="task_allocated_id"  name="" task-id="<?= $training->task->id ?>" id="task_user<?= $training->task->id ?>">
                                                                                    <?php
                                                                                    if (!empty($shulesoft_users)) {
                                                                                        foreach ($shulesoft_users as $user) {
                                                                                            ?>
                                                                                            <option value="<?= $user->id ?>" <?php
                                                                                            if ($user->id == $training->user->id) {

                                                                                                echo 'selected="selected"';
                                                                                            } else {
                                                                                                echo '';
                                                                                            }
                                                                                            ?>><?= $user->firstname . ' ' . $user->lastname ?></option>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                </select>
                                                                            </td>
                                                                            <td> <b data-attr="school_person" task-id="<?= $training->task->id ?>"  contenteditable="true" class="task_school_group"> <?= strlen($training->school_person_allocated) > 4 ? $training->school_person_allocated : 'Not Allocated' ?></b> </td>
                                                                            <td>

                                                                                <select id="<?= $training->task->id ?>" class="task_group" data-task-id="<?= $training->task->id ?>" data-user_id="<?= $training->task->user_id ?>"><?= $customer->getDate($training->task->user_id, $training->task->start_date) ?></select>
                                                                                <select data-id="<?= $training->task->id ?>" id="start_slot<?= $training->task->id ?>"  data-task-id="<?= $training->task->id ?>"  data-attr="start_date" class="slot"><?= '<option>' . date('H:i', strtotime($training->task->start_date)) . '</option>' ?></select>
                                                                            </td>
                                                                            <td>

                                                                                <b data-attr="end_date" id="task_end_date_id<?= $training->task->id ?>"><?= $training->task->end_date ?> </b>

                                                                            </td>
                                                                            <td> <?= $training->task->status ?> </td>
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

                                            </div>
                                            <!-- About tab end -->
                                            <!-- Photos tab start -->
                                            <div class="tab-pane" id="photos" aria-expanded="false">
                                                <!--                                                <div class="card">
                                                <div class="card-footer">
                                                <div class="row text-center">
                                                <div class="col-sm-4">
                                                <div class="social-media">
                                                <span>Weekly Logins Users</span>
                                                <i class="icofont  icofont-ui-user"></i>
                                                <h5 class="counter">2587</h5>
                                              </div>
                                            </div>
                                            <div class="col-sm-4">
                                            <div class="social-media">
                                            <span>Weekly Logins Parents</span>
                                            <i class="icofont icofont-ui-user"></i>
                                            <h5 class="counter">5987</h5>
                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                        <div class="social-media">
                                        <span>Weekly Logins Users</span>
                                        <i class="icofont  icofont-ui-user"></i>
                                        <h5 class="counter">58,158</h5>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>-->

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Client Usage Stages</h5>
                                                        <span>This part analyze customer system usage and provide a guidance for account manager to guide properly a school to reach the highest stage. </span>

                                                    </div>
                                                    <div class="card-block table-border-style">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Module</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row" colspan="3">
                                                                            <div class="label-main">
                                                                                <label class="label label-primary">Stage 1</label>
                                                                            </div>
                                                                        </th>

                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">1</th>
                                                                        <td>Basic Configuration</td>
                                                                        <td>
                                                                            <?php
                                                                            //classlevel
                                                                            $levels = DB::table($schema . '.classlevel')->get();
                                                                            if (empty($levels)) {
                                                                                echo '<b class="label label-warning">Class Level Not Defined</b>';
                                                                            }
                                                                            /**
                                                                             * --Check if Academic Years defined
                                                                             */
                                                                            if (!empty($levels)) {
                                                                                foreach ($levels as $level) {

                                                                                    $academic_year = DB::table($schema . '.academic_year')->where('class_level_id', $level->classlevel_id)->where('start_date', '<', date('Y-m-d'))->where('end_date', '>', date('Y-m-d'))->first();
                                                                                    if (empty($academic_year)) {
                                                                                        echo '<b class="label label-warning">Academic Year Not Defined for ' . $level->name . ' (' . date('Y') . ')</b><br/>';
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                echo '<b class="label label-warning">Academic Year Not Defined</b><br/>';
                                                                            }
                                                                            /**
                                                                             *
                                                                             * Check if terms have been defined
                                                                             */
                                                                            if (!empty($levels)) {
                                                                                foreach ($levels as $level) {

                                                                                    $academic_year = DB::table($schema . '.academic_year')->where('class_level_id', $level->classlevel_id)->where('start_date', '<', date('Y-m-d'))->where('end_date', '>', date('Y-m-d'))->first();
                                                                                    if (empty($academic_year)) {
                                                                                        echo '<b class="label label-warning">No Terms Defined for ' . $level->name . ' (' . date('Y') . ')</b><br/>';
                                                                                    } else {
                                                                                        //check terms for this defined year
                                                                                        $terms = DB::table($schema . '.semester')->where('academic_year_id', $academic_year->id)->where('start_date', '<', date('Y-m-d'))->where('end_date', '>', date('Y-m-d'))->count();

                                                                                        echo $terms == 0 ? '<b class="label label-warning">No Terms Defined for ' . $level->name . ' (' . date('Y') . ')</b><br/>' : '<label class="label label-success">' . $level->name . ' (' . $academic_year->name . ') at ' . date('d M Y', strtotime($academic_year->created_at)) . '</label>';
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                echo '<b class="label label-warning">Not Defined</b><br/>';
                                                                            }
                                                                            /**
                                                                             *
                                                                             * --check if stamp has been defined
                                                                             *
                                                                             */
                                                                            if (!empty($levels)) {
                                                                                foreach ($levels as $level) {
                                                                                    if (strlen($level->stamp) < 3) {
                                                                                        echo '<b class="label label-warning">No Stamp for ' . $level->name . '</b><br/>';
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?>

                                                                        </td>
                                                                        <td>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">2</th>
                                                                        <td>Marking</td>
                                                                        <td>
                                                                            <?= check_status('mark'); ?>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">3</th>
                                                                        <td>Exam Published</td>
                                                                        <td><?= check_status('exam_report'); ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">4</th>
                                                                        <td>Invoice Created</td>
                                                                        <td> <?= check_status('invoices'); ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">5</th>
                                                                        <td>Payments Received</td>
                                                                        <td> <?= check_status('payments'); ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">6</th>
                                                                        <td>SMS sents</td>
                                                                        <td> <?= check_status('sms'); ?>
                                                                            <br/>
                                                                            <?php
                                                                            /*
                                                                              $karibu = DB::connection('karibusms')->table('client')->where('keyname', $schema)->first();
                                                                              $karibu_shulesoft = DB::connection('karibusms')->table('client')->where('client_id', 318)->first();
                                                                              if (!empty($karibu) && !empty($karibu_shulesoft) && $karibu->gcm_id = $karibu_shulesoft->gcm_id) {

                                                                              $last_online = $karibu->last_reported_online;

                                                                              $time = strtotime($last_online);
                                                                              $tz_date = strtotime('-4 hours', $time);



                                                                              $sms_time = date('d-m-Y H:i', $tz_date);
                                                                              ?>
                                                                              Sent From <label class="label label-success"> ShuleSoft Phone</label><br/>
                                                                              Last Seen <label class="label label-info">
                                                                              <?= $sms_time ?>
                                                                              </label>
                                                                              <?php
                                                                              } else if (!empty($karibu)) {
                                                                              $last_online = $karibu->last_reported_online;

                                                                              $time = strtotime($last_online);
                                                                              $tz_date = strtotime('-4 hours', $time);



                                                                              $sms_time = date('d-m-Y H:i', $tz_date);
                                                                              ?>
                                                                              Sent From <label class="label label-success"> <?= $schema ?> Phone</label><br/>
                                                                              Last Seen <label class="label label-info">
                                                                              <?= $sms_time ?>
                                                                              </label>
                                                                              <?php } */
                                                                            ?>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">7</th>
                                                                        <td>Expenses</td>
                                                                        <td> <?= check_status('expense', ' WHERE refer_expense_id in (select id from ' . $schema . '.refer_expense where financial_category_id in (2,3)) '); ?>
                                                                            <br/></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row" colspan="3">
                                                                            <div class="label-main">
                                                                                <label class="label label-info">Stage 2</label>
                                                                            </div>
                                                                        </th>

                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">1</th>
                                                                        <td>Payroll Usage</td>
                                                                        <td> <?= check_status('salaries'); ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">2</th>
                                                                        <td>Electronic Payments</td>
                                                                        <td>
                                                                            Integration Date: <?= check_status('bank_accounts_integrations'); ?><br/>
                                                                            Last Online Transaction Date: <?= check_status('payments', ' WHERE token is not null'); ?>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">3</th>
                                                                        <td>Inventory Usage</td>
                                                                        <td>Vendors Registered: <?= check_status('admin.vendors', "WHERE schema_name='" . $schema . "'"); ?><br/>
                                                                            Items Registered:<?= check_status('product_alert_quantity'); ?>

                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">4</th>
                                                                        <td>Other Transactions</td>
                                                                        <td>
                                                                            Revenue: <?= check_status('revenues', ' WHERE refer_expense_id in (select id from ' . $schema . '.refer_expense where financial_category_id=1) '); ?>
                                                                            <br/>

                                                                            Capital : <?= check_status('revenues', ' WHERE refer_expense_id in (select id from ' . $schema . '.refer_expense where financial_category_id=7) '); ?><br/>
                                                                            Fixed Assets: <?= check_status('expense', ' WHERE refer_expense_id in (select id from ' . $schema . '.refer_expense where financial_category_id=4) '); ?><br/>
                                                                            Liabilities : <?= check_status('expense', ' WHERE refer_expense_id in (select id from ' . $schema . '.refer_expense where financial_category_id=6) '); ?><br/>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row" colspan="3">
                                                                            <div class="label-main">
                                                                                <label class="label label-success">Stage 3</label>
                                                                            </div>
                                                                        </th>

                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">1</th>
                                                                        <td>Library Usage</td>
                                                                        <td>
                                                                            Books Added: <?= check_status('book'); ?><br/>
                                                                            Book Issue:  <?= check_status('issue'); ?>

                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">1</th>
                                                                        <td>Attendance Usage</td>
                                                                        <td>
                                                                            Student: <?= check_status('sattendances'); ?>
                                                                            <br/>
                                                                            Teacher:  <?= check_status('tattendance'); ?>
                                                                            <br/>
                                                                            Exam:  <?= check_status('eattendance'); ?> <br/>
                                                                            Teacher on Duty:  <?= check_status('teacher_duties'); ?>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">2</th>
                                                                        <td>Routine Usage</td>
                                                                        <td> <?= check_status('routine'); ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <!-- Row start -->
                                                    <div class="row">
                                                        <!-- Gallery start -->
                                                        <div class="card-block">
                                                            <div class="card">
                                                                <div class="title_left">
                                                                    <br/>
                                                                    <h3>System usage by month</h3>
                                                                    <br/>
                                                                </div>
                                                                <script src="https://code.highcharts.com/highcharts.js"></script>
                                                                <script src="https://code.highcharts.com/modules/data.js"></script>
                                                                <script type="text/javascript">
                                                                                        graph_disc = function () {
                                                                                            Highcharts.chart('container', {
                                                                                                chart: {
                                                                                                    type: 'column'
                                                                                                },
                                                                                                title: {
                                                                                                    text: "System usage by Month"
                                                                                                },
                                                                                                subtitle: {
                                                                                                    text: ''
                                                                                                },
                                                                                                xAxis: {
                                                                                                    type: 'category'
                                                                                                },
                                                                                                yAxis: {
                                                                                                    title: {
                                                                                                        text: 'Log Requests'
                                                                                                    }

                                                                                                },
                                                                                                legend: {
                                                                                                    enabled: false
                                                                                                },
                                                                                                plotOptions: {
                                                                                                    series: {
                                                                                                        borderWidth: 0,
                                                                                                        dataLabels: {
                                                                                                            enabled: true,
                                                                                                            format: '{point.y:.1f}'
                                                                                                        }
                                                                                                    }
                                                                                                },
                                                                                                tooltip: {
                                                                                                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                                                                                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                                                                                                },
                                                                                                series: [{
                                                                                                        name: 'Log Requests',
                                                                                                        colorByPoint: true,
                                                                                                        data: [
<?php
$logs = DB::select('select count(*), extract(month from created_at) as month from ' . $schema . '.log where user_id is not null and extract(year from created_at)=' . date('Y') . '  group by extract(month from created_at) order by extract(month from created_at) asc');
if (!empty($logs)) {
    foreach ($logs as $log) {
        $dateObj = DateTime::createFromFormat('!m', $log->month);
        $month = $dateObj->format('F');
        ?>
                                                                                                                    {
                                                                                                                        name: '<?= ucwords($month) ?>',
                                                                                                                        y: <?php
        echo $log->count;
        ?>,
                                                                                                                        drilldown: ''
                                                                                                                    },
        <?php
    }
}
?>
                                                                                                        ]
                                                                                                    }]
                                                                                            });
                                                                                        }
                                                                                        $(document).ready(graph_disc);
                                                                </script>


                                                                <div id="container" style="min-width: 70%;  height: 480px; margin: 0 auto"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Gallery end -->
                                                </div>
                                            </div>
                                            <!-- Photos tab end -->
                                            <!-- Friends tab start -->
                                            <div class="tab-pane" id="friends" aria-expanded="false">
                                                <div class="row">
                                                    <div class="card table-responsive">
                                                        <table class="table dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Name</th>
                                                                    <th>Phone</th>
                                                                    <th>Email</th>
                                                                    <th>Title</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $users = DB::table($schema . '.user')->where('status', 1)->get();
                                                                if (!empty($users)) {
                                                                    foreach ($users as $user) {
                                                                        ?>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td><?= $user->name ?></td>
                                                                            <td><?= $user->phone ?></td>
                                                                            <td><?= $user->email ?></td>
                                                                            <td><?= $user->usertype ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Friends tab end -->
                                            <div class="tab-pane" id="payments" aria-expanded="false">
                                                <div class="row">
                                                    <div class="card table-responsive">
                                                         <table id="invoice_table" class="table table-striped table-bordered nowrap dataTable">
                                        <thead>
                                            <tr>
                                                <th>Client Name</th>
                                                <th>Reference #</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Remained Amount</th>
                                                <th>Due Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_amount = 0;
                                            $total_paid = 0;
                                            $total_unpaid = 0;
                                            $i = 1;
                                            foreach ($invoices as $invoice) {

                                                $amount = $invoice->invoiceFees()->sum('amount');
                                                $paid = $invoice->payments()->sum('amount');
                                                $unpaid = $amount - $paid;
                                                $total_paid += $paid;
                                                $total_amount += $amount;
                                                $total_unpaid += $unpaid;
                                                ?>


                                                <tr>
                                                    <td><?= $invoice->client->username ?></td>
                                                    <td><?= $invoice->reference ?></td>
                                                    <td><?= money($amount) ?></td>
                                                    <td><?= money($paid) ?></td>
                                                    <td><?= money($unpaid) ?></td>
                                                    <td><?= date('d M Y', strtotime($invoice->due_date)) ?></td>
                                                    <td>


<div class="dropdown-secondary dropdown f-right"><button class="btn btn-success btn-mini dropdown-toggle waves-effect waves-light" type="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button><div class="dropdown-menu" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"><a class="dropdown-item waves-light waves-effect" href="<?= url('account/invoiceView/' . $invoice->id) ?>"  ><span class="point-marker bg-danger"></span>View</a> <a class="dropdown-item waves-light waves-effect" href="<?= url('account/invoice/edit/' . $invoice->id) ?>"><span class="point-marker bg-warning"></span>Edit</a><a class="dropdown-item waves-light waves-effect" href="<?= url('account/invoice/delete/' . $invoice->id) ?>"><span class="point-marker bg-warning"></span>Delete</a>
<?php if ((int) $unpaid > 0) { ?>
    <hr/>
    <a class="dropdown-item waves-light waves-effect" href="<?= url('account/payment/' . $invoice->id) ?>"><span class="point-marker bg-warning"></span>Add Payments</a>
    <?php }  ?>
    <?php if((int) $unpaid >0){ ?>
        <a class="dropdown-item waves-light waves-effect" href="#" data-toggle="modal" data-target="#large-Modal" onclick="$('#invoice_id').val('<?=$invoice->id?>')"><span class="point-marker bg-warning"></span>Send Invoice</a>
         <?php }  ?>
          <?php if((int) $paid >0){ ?>
<a class="dropdown-item waves-light waves-effect" href="<?= url('account/receipts/' . $invoice->id) ?>" target="_blank"><span class="point-marker bg-warning"></span>Receipt</a>
                                                       <?php }
                                                        ?>
    </div></div>

                                                       
                                                     
                                                    
                                                    </td>
                                                </tr>
                                            <?php $i++; } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">Total</td>
                                                <td><?= money($total_amount) ?></td>
                                                <td><?= money($total_paid) ?></td>
                                                <td><?= money($total_unpaid) ?></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
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
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>
<div class="card-block">
    <div class="modal fade" id="status-Modal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1050; display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Change Schools Status</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= url('customer/schoolStatus') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" value="<?= $schema ?>" name="schema_name"/>
                        </div>
                        <div class="form-group">
                            School <?= ucfirst($schema) ?> status
                            <select name="status"  class="form-control select2">
                                <option value="">Select status</option>
                                <option value="1">Active Paid</option>
                                <option value="2">Active</option>
                                <option value="3">Resale</option>
                                <option value="4">Inactive</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                    </div>
                    <?= csrf_field() ?>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="customer_contracts_model" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Contract</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p align='center'><span class="label label-danger">Once you upload a contract, you cannot EDIT</span></p>
                <form action="<?= url('customer/contract/' . $client_id) ?>" method="POST" enctype="multipart/form-data">



                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Contract Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control"  name="name" required="">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Agreement Type</label>
                        <div class="col-sm-10">
                            <select name="contract_type_id" class="form-control">

                                <?php
                                $ctypes = DB::table('admin.contracts_types')->get();
                                if (!empty($ctypes)) {
                                    foreach ($ctypes as $ctype) {
                                        ?>
                                        <option value="<?= $ctype->id ?>"><?= $ctype->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Contract Start Date</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" value="" name="start_date" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Contract Start Date</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="end_date" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Upload Document</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" accept=".pdf" name="file" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Notes</label>
                        <div class="col-sm-10">
                            <textarea rows="5" cols="5" name="description" class="form-control" placeholder="Any important details about this document"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-success" placeholder="Default textarea">Submit</button>
                        </div>
                    </div>
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php $root = url('/') . '/public/' ?>
<?php
if (!empty($profile)) {
    ?>
    <div class="modal fade" id="school_details" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card-block">

                        <div id="view-info" class="row">
                            <div class="col-lg-12 col-md-12">
                                <form action="<?= url('customer/contract/' . $client_id) ?>" method="POST" enctype="multipart/form-data">
                                    <table class="table m-b-0">
                                        <tbody><tr>
                                                <th class="social-label b-none p-t-0">School Name
                                                </th>
                                                <td class="social-user-name b-none p-t-0 text-muted"><?= $profile->school->name ?></td>
                                            </tr>
                                            <tr>
                                                <th class="social-label b-none">Region</th>
                                                <td class="social-user-name b-none text-muted"><?= $profile->school->region ?></td>
                                            </tr>
                                            <tr>
                                                <th class="social-label b-none">District</th>
                                                <td class="social-user-name b-none text-muted"><?= $profile->school->district ?></td>
                                            </tr>
                                            <tr>
                                                <th class="social-label b-none">Ward</th>
                                                <td class="social-user-name b-none text-muted"><?= $profile->school->ward ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                            </div>
                        </div>
                        </form>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Submit</button>
                        </div>
                    </div>
                    <br/>
                </div>
            </div>

        </div>
    </div>
<?php } ?>
<!-- notify js Fremwork -->
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.brighttheme.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.buttons.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.history.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.mobile.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/pnotify/notify.css">

<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.desktop.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.buttons.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.confirm.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.callbacks.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.animate.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.history.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.mobile.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.nonblock.js"></script>
<script type="text/javascript" src="<?= $root ?>assets/pages/pnotify/notify.js"></script>
<script type="text/javascript">

                                                                                        function save_comment(id) {
                                                                                            var content = $('#task_comment' + id).val();
                                                                                            var task_id = $('#task_id' + id).val();
                                                                                            $.ajax({
                                                                                                type: 'POST',
                                                                                                url: "<?= url('customer/taskComment/null') ?>",
                                                                                                data: {content: content, task_id: task_id},
                                                                                                dataType: "html",
                                                                                                success: function (data) {
                                                                                                    $('input[type="text"],textarea').val('');
                                                                                                    $('.new_comment' + id).after(data);
                                                                                                }
                                                                                            });
                                                                                        }

                                                                                        notify = function (title, message, type) {
                                                                                            new PNotify({
                                                                                                title: title,
                                                                                                text: message,
                                                                                                type: type,
                                                                                                hide: 'false',
                                                                                                icon: 'icofont icofont-info-circle'
                                                                                            });
                                                                                        }

                                                                                        allocate = function (a, role_id) {
                                                                                            $.ajax({
                                                                                                url: '<?= url('customer/allocate/null') ?>',
                                                                                                data: {user_id: a, school_id: '<?= $school->school_id ?>', role_id: role_id, schema: '<?= $schema ?>'},
                                                                                                dataType: 'html',
                                                                                                success: function (data) {
                                                                                                    $('#supportl').html(data);
                                                                                                }
                                                                                            });
                                                                                        }

                                                                                        show_tabs = function (a) {
                                                                                            $('.live_tabs').hide(function () {
                                                                                                $('#' + a).show();
                                                                                            });
                                                                                        }

                                                                                        $('#school_id').click(function () {
                                                                                            var val = $(this).val();
                                                                                            $.ajax({
                                                                                                url: '<?= url('customer/search/null') ?>',
                                                                                                data: {val: val, type: 'school', schema: '<?= $schema ?>'},
                                                                                                dataType: 'html',
                                                                                                success: function (data) {

                                                                                                    $('#search_result').html(data);
                                                                                                }
                                                                                            });
                                                                                        });

                                                                                        removeTag = function (a) {
                                                                                            $.ajax({
                                                                                                url: '<?= url('customer/removeTag') ?>/null',
                                                                                                method: 'get',
                                                                                                data: {id: a},
                                                                                                success: function (data) {
                                                                                                    if (data == '1') {
                                                                                                        $('#removetag' + a).fadeOut();
                                                                                                    }
                                                                                                }
                                                                                            });
                                                                                        }

                                                                                        task_group = function () {
                                                                                            $('.task_group').change(function () {
                                                                                                var val = $(this).val();
                                                                                                var task_id = $(this).attr('data-task-id');
                                                                                                var data_attr = $('#task_user' + task_id).val();
                                                                                                $.ajax({
                                                                                                    url: '<?= url('customer/getAvailableSlot') ?>/null',
                                                                                                    method: 'get',
                                                                                                    data: {start_date: val, user_id: data_attr},
                                                                                                    success: function (data) {
                                                                                                        $('#start_slot' + task_id).html(data);
                                                                                                    }
                                                                                                });
                                                                                            });

                                                                                            $('.task_school_group').blur(function () {
                                                                                                var val = $(this).text();
                                                                                                var data_attr = $(this).attr('data-attr');
                                                                                                var task_id = $(this).attr('task-id');
                                                                                                // var date=$('#'+task_id).val();
                                                                                                $.ajax({
                                                                                                    url: '<?= url('customer/editTrain') ?>/null',
                                                                                                    method: 'get',
                                                                                                    dataType: 'html',
                                                                                                    data: {task_id: task_id, value: val, attr: data_attr},
                                                                                                    success: function (data) {
                                                                                                        // $(this).after(data).addClass('label label-success');
                                                                                                        notify('Success', 'Success', 'success');
                                                                                                    }
                                                                                                });
                                                                                            });

                                                                                            $('.slot').change(function () {
                                                                                                var val = $(this).val();
                                                                                                //var data_attr = $(this).attr('data-attr');
                                                                                                var task_id = $(this).attr('data-id');
                                                                                                var date = $('#' + task_id).val();
                                                                                                $.ajax({
                                                                                                    url: '<?= url('customer/editTrain') ?>/null',
                                                                                                    method: 'get',
                                                                                                    dataType: 'json',
                                                                                                    data: {task_id: task_id, value: date, slot_id: val, attr: 'start_date'},
                                                                                                    success: function (data) {
                                                                                                        $('#task_end_date_id' + data.task_id).html(data.end_date);
                                                                                                        notify('Success', 'Success', 'success');
                                                                                                    }
                                                                                                });
                                                                                            });

                                                                                            $('.task_allocated_id').change(function () {
                                                                                                var task_allocated_id = $(this).val();
                                                                                                var task_id = $(this).attr('task-id');
                                                                                                $.ajax({
                                                                                                    url: '<?= url('customer/editTrain') ?>/null',
                                                                                                    method: 'get',
                                                                                                    data: {task_id: task_id, user_id: task_allocated_id},
                                                                                                    success: function (data) {
                                                                                                        notify('Success', data, 'success');
                                                                                                    }
                                                                                                });
                                                                                            });
                                                                                        }

                                                                                        $(document).ready(task_group);
</script>
@endsection

@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/';
define('SCHEMA', $schema);

function check_status($table,$where=null) {
    $schema = SCHEMA;
    $report = \collect(DB::select('select created_at::date from ' . $schema . '.' . $table . '  '.$where.' order by created_at::date desc limit 1'))->first();

    if (count($report) == 1) {

        $echo = '<b class="label label-success">' . date('d M Y', strtotime($report->created_at)) . '</b>';
    } else {

        $echo = '<b class="label label-warning">Not Defined</b>';
    }
    return $echo;
}
?>


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.9/select2-bootstrap.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>

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
                    <li class="breadcrumb-item"><a href="#!"><?= $school->sname ?> </a>
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
                                                                if ($st->status == 1) {
                                                                    echo '<div class="btn btn-primary">Active Paid</div>';
                                                                } elseif ($st->status == 2) {
                                                                    echo '<div class="btn btn-success">Active</div>';
                                                                } elseif ($st->status == 3) {
                                                                    echo '<div class="btn btn-warning">Resale</div>';
                                                                } elseif ($st->status == 4) {
                                                                    echo '<div class="btn btn-warning">Inactive</div>';
                                                                } else {
                                                                    echo '<div>not defined</div>';
                                                                }
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
                                                        <?php } ?>

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
                                                    <a class="nav-link" data-toggle="tab" href="#timeline" role="tab" aria-expanded="false">Activities</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#about" role="tab" aria-expanded="false">About</a>
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
                                            </ul>
                                        </div>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <!-- Timeline tab start -->
                                            <div class="tab-pane" id="timeline" aria-expanded="false">
                                                <div class="row">
                                                    <div class="card-block">
                                                        <!--  <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#large-Modal">Create Task</button>-->
                                                        <a href="<?= url('Customer/activity/add') ?>" class="btn btn-primary waves-effect">Create Task</a>
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
                                                                                <textarea class="form-control" placeholder="Create Task" name="activity"></textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="row">

                                                                                    <div class="col-md-6">
                                                                                        Task Type
                                                                                        <select name="task_type_id"  class="form-control select2">
                                                                                            <?php
                                                                                            $types = DB::table('task_types')->where('department', Auth::user()->department)->get();
                                                                                            foreach ($types as $type) {
                                                                                                ?>
                                                                                                <option value="<?= $type->id ?>"><?= $type->name ?></option>
                                                                                            <?php } ?>

                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        Person Allocated to do
                                                                                        <select name="to_user_id" class="form-control select2">
                                                                                            <?php
                                                                                            $staffs = DB::table('users')->where('status', 1)->get();
                                                                                            foreach ($staffs as $staff) {
                                                                                                ?>
                                                                                                <option value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                                                                                            <?php } ?>

                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="row">

                                                                                    <div class="col-md-6">
                                                                                        Deadline Date
                                                                                        <input type="date" class="form-control" placeholder="Deadline" name="date">
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        Deadline Time
                                                                                        <input type="time" class="form-control" placeholder="Time" name="time">
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                            <div class="form-group">
                                                                                <strong>  Pick Modules where task will be Performed</strong> 
                                                                                <hr>
                                                                                <?php
                                                                                $modules = DB::table('modules')->get();
                                                                                foreach ($modules as $module) {
                                                                                    ?>
                                                                                    <input type="checkbox" id="feature<?= $module->id ?>" value="{{$module->id}}" name="module_id[]" >  <?php echo $module->name; ?>  &nbsp; &nbsp;

                                                                                <?php } ?>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <div class="row">

                                                                                    <div class="col-md-6">
                                                                                        <strong> Task Executed Successfully</strong> 
                                                                                        <select name="action" class="form-control" required>
                                                                                            <option value=''> Select Task Status Here...</option>
                                                                                            <option value='Yes'> Yes </option>
                                                                                            <option value='No'> No </option>
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

                                                        foreach ($tasks as $task) {
                                                            ?>
                                                            <div class="social-timelines p-relative o-hidden" id="removetag<?= $task->id ?>">
                                                                <div class="row timeline-right p-t-35">
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
                                                                                </div>

                                                                                <div class="user-box">
                                                                                    <div class="p-b-30"> <span class="f-14"><a href="#">What have been done</a></span></div>
                                                                                    <?php
                                                                                    $comments = $task->taskComments()->get();
                                                                                    if (count($comments) > 0) {
                                                                                        foreach ($comments as $comment) {
                                                                                            ?>
                                                                                            <div class="media m-b-1" style="margin: 0px; padding: 0px">
                                                                                                <a class="media-left" href="#">
                                                                                                    <img class="media-object img-circle m-r-2" src="<?= $root ?>assets/images/avatar-1.png" alt="Image">
                                                                                                </a>
                                                                                                <div class="media-body b-b-muted social-client-description">
                                                                                                    <div class="chat-header"><?= $comment->user->firstname ?> - <span class="text-muted"><?= date('d M Y', strtotime($comment->created_at)) ?></span></div>
                                                                                                    <p class="text-muted"><?= $comment->content ?></p>
                                                                                                </div>
                                                                                            </div>

                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                    <div class="new_comment<?= $task->id ?>"></div>
                                                                                    <div class="media">
                                                                                        <a class="media-left" href="#">
                                                                                            <img class="media-object img-circle m-r-20" src="<?= $root ?>assets/images/avatar-blank.jpg" alt="Image">
                                                                                        </a>
                                                                                        <div class="media-body">
                                                                                            <form class="">
                                                                                                <div class="">
                                                                                                    <textarea rows="5" cols="5" id="task_comment<?= $task->id ?>" class="form-control" placeholder="Write Something here..."></textarea>
                                                                                                    <div class="text-right m-t-20"><a href="#" class="btn btn-primary waves-effect waves-light" onclick="return false" onmousedown="$.get('<?= url('customer/taskComment/null') ?>', {content: $('#task_comment<?= $task->id ?>').val(), task_id:<?= $task->id ?>}, function (data) {
                                                                                                                $('.new_comment<?= $task->id ?>').after(data);
                                                                                                                $('#task_comment<?= $task->id ?>').val('')
                                                                                                            })">Post</a></div>
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
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- Timeline tab end -->
                                            <!-- About tab start -->
                                            <div class="tab-pane active" id="about" aria-expanded="true">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-header-text">Basic Information</h5>
                                                                <button id="edit-btn" type="button" class="btn btn-primary waves-effect waves-light f-right" data-toggle="modal" data-target="#status-Modal">
                                                                    <i class="icofont icofont-edit"></i> Change school Status
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
                                                                                                foreach ($levels as $level) {
                                                                                                    echo $level->name . ' - ' . $level->result_format . '<br/>';
                                                                                                }
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
                                                                                        <?php foreach ($shulesoft_users as $user) { ?>
                                                                                                <option value="<?= $user->id ?>" <?php
                                                                                                if (count($school_allocations) == 1 && $user->id == $school_allocations->id) {
                                                                                                    $support_person = $user->firstname . ' ' . $user->lastname;
                                                                                                    echo 'selected="selected"';
                                                                                                } else {
                                                                                                    echo '';
                                                                                                }
                                                                                                ?>><?= $user->firstname . ' ' . $user->lastname ?></option>
                                                                                                    <?php }
                                                                                                    ?>
                                                                                        </select>


                                                                                    </td>
                                                                                    <td class="social-user-name b-none text-muted">   <input type="button" value="save" onmousedown="allocate($('#support_id').val(), 8)" class="btn btn-success btn-sm"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th class="social-label b-none">Sales Personnel </th>
                                                                                    <td class="social-user-name b-none text-muted">
                                                                                        <?php
                                                                                        $school_sales_allocations = \collect(DB::select("select b.id from admin.users_schools a join admin.users b on b.id=a.user_id join admin.schools c on c.id=a.school_id where a.role_id=3 and a.status=1 and c.schema_name='" . $schema . "'"))->first();
                                                                                        ?>                            <select class="form-control" id="sales_id" name="sales_id">

                                                                                            <?php foreach ($shulesoft_users as $user) { ?>
                                                                                                <option value="<?= $user->id ?>" <?php
                                                                                                if (count($school_sales_allocations) == 1 && $user->id == $school_sales_allocations->id) {
                                                                                                    $sales_person = $user->firstname . ' ' . $user->lastname;
                                                                                                    echo 'selected="selected"';
                                                                                                } else {
                                                                                                    echo '';
                                                                                                }
                                                                                                ?>><?= $user->firstname . ' ' . $user->lastname ?></option>
                                                                                                    <?php }
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
                                                                                    foreach ($client_contracts as $client_contract) {
                                                                                        ?>
                                                                                        <tr>
                                                                                            <th scope="row"><?= $i ?></th>
                                                                                            <td><?= $client_contract->contract->name ?></td>
                                                                                            <td><?= $client_contract->contract->contractType->name ?></td>
                                                                                            <td><?= $client_contract->contract->start_date ?></td>
                                                                                            <td><?= $client_contract->contract->end_date ?></td>
                                                                                            <td><?= $client_contract->contract->user->name ?></td>
                                                                                            <td><a type="button" class="btn btn-primary btn-xs waves-effect" target="_blank" href="<?= url('customer/viewContract/' . $client_contract->contract->id) ?>">View</a></td>
                                                                                        </tr>

                                                                                        <?php
                                                                                        $i++;
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
                                                                            if (count($levels) == 0) {
                                                                                echo '<b class="label label-warning">Class Level Not Defined</b>';
                                                                            }
                                                                            /**
                                                                             * --Check if Academic Years defined
                                                                             */
                                                                            if (count($levels) > 0) {
                                                                                foreach ($levels as $level) {

                                                                                    $academic_year = DB::table($schema . '.academic_year')->where('class_level_id', $level->classlevel_id)->where('start_date', '<', date('Y-m-d'))->where('end_date', '>', date('Y-m-d'))->first();
                                                                                    if (count($academic_year) == 0) {
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
                                                                            if (count($levels) > 0) {
                                                                                foreach ($levels as $level) {

                                                                                    $academic_year = DB::table($schema . '.academic_year')->where('class_level_id', $level->classlevel_id)->where('start_date', '<', date('Y-m-d'))->where('end_date', '>', date('Y-m-d'))->first();
                                                                                    if (count($academic_year) == 0) {
                                                                                        echo '<b class="label label-warning">No Terms Defined for ' . $level->name . ' (' . date('Y') . ')</b><br/>';
                                                                                    } else {
                                                                                        //check terms for this defined year
                                                                                        $terms = DB::table($schema . '.semester')->where('academic_year_id', $academic_year->id)->where('start_date', '<', date('Y-m-d'))->where('end_date', '>', date('Y-m-d'))->count();

                                                                                        echo $terms == 0 ? '<b class="label label-warning">No Terms Defined for ' . $level->name . ' (' . date('Y') . ')</b><br/>' : '';
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
                                                                            if (count($levels) > 0) {
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
                                                                        <td> <?= check_status('sms'); ?></td>
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
                                                                            Integration Date: <?=check_status('bank_accounts_integrations'); ?><br/>
                                                                             Last Online Transaction Date: <?=check_status('payments',' WHERE token is not null'); ?>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">3</th>
                                                                        <td>Inventory Usage</td>
                                                                        <td>Vendors Registered: <?= check_status('vendors'); ?><br/>
                                                                            Items Registered:<?= check_status('items'); ?> 
                                                                            
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">4</th>
                                                                        <td>Other Transactions</td>
                                                                        <td>
                                                                        Revenue: <?= check_status('revenues',' WHERE refer_expense_id in (select id from '.$schema.'.refer_expense where financial_category_id=1) '); ?>
                                                                        <br/>
                                                                        Expenses: <?= check_status('expense',' WHERE refer_expense_id in (select id from '.$schema.'.refer_expense where financial_category_id in (2,3)) '); ?>
                                                                        <br/>
                                                                        Capital : <?= check_status('revenues',' WHERE refer_expense_id in (select id from '.$schema.'.refer_expense where financial_category_id=7) '); ?><br/>
                                                                        Fixed Assets: <?= check_status('expense',' WHERE refer_expense_id in (select id from '.$schema.'.refer_expense where financial_category_id=4) '); ?><br/>
                                                                        Liabilities : <?= check_status('expense',' WHERE refer_expense_id in (select id from '.$schema.'.refer_expense where financial_category_id=6) '); ?><br/>
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
                                                                foreach ($users as $user) {
                                                                    ?>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><?= $user->name ?></td>
                                                                        <td><?= $user->phone ?></td>
                                                                        <td><?= $user->email ?></td>
                                                                        <td><?= $user->usertype ?></td>
                                                                    </tr>
<?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Friends tab end -->
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
                                foreach ($ctypes as $ctype) {
                                    ?>
                                    <option value="<?= $ctype->id ?>"><?= $ctype->name ?></option>
<?php } ?>

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
                    <button type="button" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        allocate = function (a, role_id) {
            $.ajax({
                url: '<?= url('customer/allocate/null') ?>',
                data: {user_id: a, school_id: '<?= $school->school_id ?>', role_id: role_id, schema: '<?= $schema ?>'},
                dataType: 'html',
                success: function (data) {
                    if (data == 1) {
                        alert('success');
                    }
                }
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
    </script>
    @endsection

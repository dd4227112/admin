@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

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
                        <a href="index-2.html">
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
                                            <img src="<?= $root ?>assets/images/social/img1.jpg" class="img-fluid width-100" alt="">
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
                                                    <img class="img-fluid width-100" src="<?= $root ?>assets/images/social/profile.jpg" alt="">
                                                    <div class="profile-hvr m-t-15">
                                                        <i class="icofont icofont-ui-edit p-r-10"></i>
                                                        <i class="icofont icofont-ui-delete"></i>
                                                    </div>
                                                </div>
                                                <div class="card-block social-follower">
                                                    <h4><?= $school->sname ?></h4>
                                                    <h5><?= $school->address ?></h5>
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
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- social-profile card end -->
                                            <!-- Who to follow card start -->
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
                                                                <img class="media-object img-circle" src="<?= $root ?>assets/images/avatar-1.png" alt="Generic placeholder image">
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
                                            <!-- Who to follow card end -->

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
                                                    <a class="nav-link" data-toggle="tab" href="#photos" role="tab" aria-expanded="false">Modules Usage</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link " data-toggle="tab" href="#friends" role="tab" aria-expanded="true">Friends</a>
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
                                                        <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#large-Modal">Create Task</button>
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

                                                                                        <input type="date" class="form-control" placeholder="Deadline" name="date">
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <input type="time" class="form-control" placeholder="Time" name="time">
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
                                                        $tasks = \App\Models\Task::where('client_id', $client_id)->get();
                                                        foreach ($tasks as $task) {
                                                            ?>
                                                            <div class="social-timelines p-relative o-hidden">
                                                                <div class="row timeline-right p-t-35">
                                                                    <div class="col-xs-2 col-sm-1">
                                                                        <div class="social-timelines-left">
                                                                            <img class="img-circle timeline-icon" src="<?= $root ?>assets/images/avatar-2.png" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-10 col-sm-11 p-l-5 p-b-35">
                                                                        <div class="card m-0">
                                                                            <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                                                            <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                                <a class="dropdown-item" href="#">Remove tag</a>
                                                                                <a class="dropdown-item" href="#">Report Photo</a>
                                                                                <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                                <a class="dropdown-item" href="#">Blog User</a>
                                                                            </div>
                                                                            <div class="card-block post-timelines">

                                                                                <div class="social-time text-muted">
                                                                                    <?= date("d M Y", strtotime($task->date)) ?>
                                                                                </div>
                                                                            </div>


                                                                            <div class="card-block">
                                                                                <div class="timeline-details">
                                                                                    <div class="chat-header"><?= $task->user->name ?></div>
                                                                                    <p class="text-muted"><?= $task->activity ?></p>
                                                                                </div>
                                                                            </div>

                                                                            <div class="card-block user-box">
                                                                                <div class="p-b-30"> <span class="f-14"><a href="#">What have been done</a></span></div>
                                                                                <?php
                                                                                $comments = $task->comment()->get();
                                                                                foreach ($comments as $comment) {
                                                                                    ?>
                                                                                    <div class="media m-b-20">
                                                                                        <a class="media-left" href="#">
                                                                                            <img class="media-object img-circle m-r-20" src="<?= $root ?>assets/images/avatar-1.png" alt="Generic placeholder image">
                                                                                        </a>
                                                                                        <div class="media-body b-b-muted social-client-description">
                                                                                            <div class="chat-header">About Marta Williams<span class="text-muted">Jane 10, 2015</span></div>
                                                                                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } ?>

                                                                                <div class="media">
                                                                                    <a class="media-left" href="#">
                                                                                        <img class="media-object img-circle m-r-20" src="<?= $root ?>assets/images/avatar-blank.jpg" alt="Generic placeholder image">
                                                                                    </a>
                                                                                    <div class="media-body">
                                                                                        <form class="">
                                                                                            <div class="">
                                                                                                <textarea rows="5" cols="5" class="form-control" placeholder="Write Something here..."></textarea>
                                                                                                <div class="text-right m-t-20"><a href="#" class="btn btn-primary waves-effect waves-light">Post</a></div>
                                                                                            </div>
                                                                                        </form>
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
                                                <div class="f-30 text-muted text-center">2014</div>

                                            </div>
                                            <!-- Timeline tab end -->
                                            <!-- About tab start -->
                                            <div class="tab-pane active" id="about" aria-expanded="true">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-header-text">Basic Information</h5>
                                                                <button id="edit-btn" type="button" class="btn btn-primary waves-effect waves-light f-right">
                                                                    <i class="icofont icofont-edit"></i>
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
                                                                <h5 class="card-header-text">Contact Information</h5>
                                                                <button id="edit-Contact" type="button" class="btn btn-primary waves-effect waves-light f-right">
                                                                    <i class="icofont icofont-edit"></i>
                                                                </button>
                                                            </div>
                                                            <div class="card-block">
                                                                <div id="contact-info" class="row">
                                                                    <div class="col-lg-6 col-md-12">
                                                                        <table class="table m-b-0">
                                                                            <tbody><tr>
                                                                                    <th class="social-label b-none p-t-0">Mobile Number</th>
                                                                                    <td class="social-user-name b-none p-t-0 text-muted">eg. (0123) - 4567891</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th class="social-label b-none">Email Address</th>
                                                                                    <td class="social-user-name b-none text-muted">test@gmail.com</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th class="social-label b-none">Twitter</th>
                                                                                    <td class="social-user-name b-none text-muted">@phonixcoded</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th class="social-label b-none p-b-0">Skype</th>
                                                                                    <td class="social-user-name b-none p-b-0 text-muted">@phonixcoded demo</td>
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
                                                                <h5 class="card-header-text">Work</h5>
                                                                <button id="edit-work" type="button" class="btn btn-primary waves-effect waves-light f-right">
                                                                    <i class="icofont icofont-edit"></i>
                                                                </button>
                                                            </div>
                                                            <div class="card-block">
                                                                <div id="work-info" class="row">
                                                                    <div class="col-lg-6 col-md-12">
                                                                        <table class="table m-b-0">
                                                                            <tbody><tr>
                                                                                    <th class="social-label b-none p-t-0">Occupation &nbsp; &nbsp; &nbsp;
                                                                                    </th>
                                                                                    <td class="social-user-name b-none p-t-0 text-muted">Developer</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th class="social-label b-none">Skills</th>
                                                                                    <td class="social-user-name b-none text-muted">C#, Javascript, Anguler</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th class="social-label b-none">Jobs</th>
                                                                                    <td class="social-user-name b-none p-b-0 text-muted">Phoenixcoded</td>
                                                                                </tr>
                                                                            </tbody></table>
                                                                    </div>
                                                                </div>
                                                                <div id="edit-contact-work" class="row" style="display: none;">
                                                                    <div class="col-lg-12 col-md-12">
                                                                        <form>
                                                                            <div class="input-group">
                                                                                <select id="occupation" class="form-control">
                                                                                    <option value=""> Select occupation </option>
                                                                                    <option value="married">Developer</option>
                                                                                    <option value="unmarried">Web Design</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <select id="skill" class="form-control">
                                                                                    <option value=""> Select Skills </option>
                                                                                    <option value="married">C# &amp; .net</option>
                                                                                    <option value="unmarried">Angular</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <select id="job" class="form-control">
                                                                                    <option value=""> Select Job </option>
                                                                                    <option value="married">Phoenixcoded</option>
                                                                                    <option value="unmarried">Other</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="text-center m-t-20">
                                                                                <a href="javascript:;" id="work-save" class="btn btn-primary waves-effect waves-light m-r-20">Save</a>
                                                                                <a href="javascript:;" id="work-cancel" class="btn btn-default waves-effect waves-light">Cancel</a>
                                                                            </div>
                                                                        </form>
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
                                                <div class="card">
                                                    <!-- Row start -->
                                                    <div class="row">
                                                        <!-- Gallery start -->
                                                        <div class="card-block">
                                                            <div class="demo-gallery">
                                                                <ul id="profile-lightgallery">
                                                                    <li class="col-md-4 col-lg-2 col-sm-6 col-xs-12  p-3">
                                                                        <a href="<?= $root ?>assets/images/light-box/l1.jpg" data-toggle="lightbox" data-title="A random title" data-footer="A custom footer text">
                                                                            <img src="<?= $root ?>assets/images/light-box/sl1.jpg" class="img-fluid" alt="">
                                                                        </a>
                                                                    </li>
                                                                    <li class="col-md-4 col-lg-2 col-sm-6 col-xs-12  p-3">
                                                                        <a href="<?= $root ?>assets/images/light-box/l1.jpg" data-toggle="lightbox" data-title="A random title" data-footer="A custom footer text">
                                                                            <img src="<?= $root ?>assets/images/light-box/sl1.jpg" class="img-fluid" alt="">
                                                                        </a>
                                                                    </li>
                                                                    <li class="col-md-4 col-lg-2 col-sm-6 col-xs-12  p-3">
                                                                        <a href="<?= $root ?>assets/images/light-box/l1.jpg" data-toggle="lightbox" data-title="A random title" data-footer="A custom footer text">
                                                                            <img src="<?= $root ?>assets/images/light-box/sl1.jpg" class="img-fluid" alt="">
                                                                        </a>
                                                                    </li>
                                                                    <li class="col-md-4 col-lg-2 col-sm-6 col-xs-12  p-3">
                                                                        <a href="<?= $root ?>assets/images/light-box/l1.jpg" data-toggle="lightbox" data-title="A random title" data-footer="A custom footer text">
                                                                            <img src="<?= $root ?>assets/images/light-box/sl1.jpg" class="img-fluid" alt="">
                                                                        </a>
                                                                    </li>
                                                                </ul>
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
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="card">
                                                            <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                                            <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                <a class="dropdown-item" href="#">Remove tag</a>
                                                                <a class="dropdown-item" href="#">Report Photo</a>
                                                                <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                <a class="dropdown-item" href="#">Blog User</a>
                                                            </div>
                                                            <div class="media bg-white d-flex p-10">
                                                                <div class="media-left media-middle">
                                                                    <a href="#">
                                                                        <img class="media-object" src="<?= $root ?>assets/images/timeline/img2.png" alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body friend-elipsis">
                                                                    <div class="f-15 f-bold m-b-5">Josephin Doe</div>
                                                                    <div class="text-muted social-designation">Softwear Engineer at phoenixcoded</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="card">
                                                            <div class="input-group wall-elips">
                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                    <a class="dropdown-item" href="#">Remove tag</a>
                                                                    <a class="dropdown-item" href="#">Report Photo</a>
                                                                    <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                    <a class="dropdown-item" href="#">Blog User</a>
                                                                </div>
                                                            </div>
                                                            <div class="media bg-white d-flex p-10">
                                                                <div class="media-left media-middle">
                                                                    <a href="#">
                                                                        <img class="media-object" src="<?= $root ?>assets/images/timeline/img2.png" alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body friend-elipsis">
                                                                    <div class="f-15 f-bold m-b-5">Josephin Doe</div>
                                                                    <div class="text-muted social-designation">Softwear Engineer at phoenixcoded</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="card">
                                                            <div class="input-group wall-elips">
                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                    <a class="dropdown-item" href="#">Remove tag</a>
                                                                    <a class="dropdown-item" href="#">Report Photo</a>
                                                                    <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                    <a class="dropdown-item" href="#">Blog User</a>
                                                                </div>
                                                            </div>
                                                            <div class="media bg-white d-flex p-10">
                                                                <div class="media-left media-middle">
                                                                    <a href="#">
                                                                        <img class="media-object" src="<?= $root ?>assets/images/timeline/img2.png" alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body friend-elipsis">
                                                                    <div class="f-15 f-bold m-b-5">Josephin Doe</div>
                                                                    <div class="text-muted social-designation">Softwear Engineer at phoenixcoded</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="card">
                                                            <div class="input-group wall-elips">
                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                    <a class="dropdown-item" href="#">Remove tag</a>
                                                                    <a class="dropdown-item" href="#">Report Photo</a>
                                                                    <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                    <a class="dropdown-item" href="#">Blog User</a>
                                                                </div>
                                                            </div>
                                                            <div class="media bg-white d-flex p-10">
                                                                <div class="media-left media-middle">
                                                                    <a href="#">
                                                                        <img class="media-object" src="<?= $root ?>assets/images/timeline/img2.png" alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body friend-elipsis">
                                                                    <div class="f-15 f-bold m-b-5">Josephin Doe</div>
                                                                    <div class="text-muted social-designation">Softwear Engineer at phoenixcoded</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="card">
                                                            <div class="input-group wall-elips">
                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                    <a class="dropdown-item" href="#">Remove tag</a>
                                                                    <a class="dropdown-item" href="#">Report Photo</a>
                                                                    <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                    <a class="dropdown-item" href="#">Blog User</a>
                                                                </div>
                                                            </div>
                                                            <div class="media bg-white d-flex p-10">
                                                                <div class="media-left media-middle">
                                                                    <a href="#">
                                                                        <img class="media-object" src="<?= $root ?>assets/images/timeline/img2.png" alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body friend-elipsis">
                                                                    <div class="f-15 f-bold m-b-5">Josephin Doe</div>
                                                                    <div class="text-muted social-designation">Softwear Engineer at phoenixcoded</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="card">
                                                            <div class="input-group wall-elips">
                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                    <a class="dropdown-item" href="#">Remove tag</a>
                                                                    <a class="dropdown-item" href="#">Report Photo</a>
                                                                    <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                    <a class="dropdown-item" href="#">Blog User</a>
                                                                </div>
                                                            </div>
                                                            <div class="media bg-white d-flex p-10">
                                                                <div class="media-left media-middle">
                                                                    <a href="#">
                                                                        <img class="media-object" src="<?= $root ?>assets/images/timeline/img2.png" alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body friend-elipsis">
                                                                    <div class="f-15 f-bold m-b-5">Josephin Doe</div>
                                                                    <div class="text-muted social-designation">Softwear Engineer at phoenixcoded</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="card">
                                                            <div class="input-group wall-elips">
                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                    <a class="dropdown-item" href="#">Remove tag</a>
                                                                    <a class="dropdown-item" href="#">Report Photo</a>
                                                                    <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                    <a class="dropdown-item" href="#">Blog User</a>
                                                                </div>
                                                            </div>
                                                            <div class="media bg-white d-flex p-10">
                                                                <div class="media-left media-middle">
                                                                    <a href="#">
                                                                        <img class="media-object" src="<?= $root ?>assets/images/timeline/img2.png" alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body friend-elipsis">
                                                                    <div class="f-15 f-bold m-b-5">Josephin Doe</div>
                                                                    <div class="text-muted social-designation">Softwear Engineer at phoenixcoded</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="card">
                                                            <div class="input-group wall-elips">
                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                    <a class="dropdown-item" href="#">Remove tag</a>
                                                                    <a class="dropdown-item" href="#">Report Photo</a>
                                                                    <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                    <a class="dropdown-item" href="#">Blog User</a>
                                                                </div>
                                                            </div>
                                                            <div class="media bg-white d-flex p-10">
                                                                <div class="media-left media-middle">
                                                                    <a href="#">
                                                                        <img class="media-object" src="<?= $root ?>assets/images/timeline/img2.png" alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body friend-elipsis">
                                                                    <div class="f-15 f-bold m-b-5">Josephin Doe</div>
                                                                    <div class="text-muted social-designation">Softwear Engineer at phoenixcoded</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="card">
                                                            <div class="input-group wall-elips">
                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                    <a class="dropdown-item" href="#">Remove tag</a>
                                                                    <a class="dropdown-item" href="#">Report Photo</a>
                                                                    <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                    <a class="dropdown-item" href="#">Blog User</a>
                                                                </div>
                                                            </div>
                                                            <div class="media bg-white d-flex p-10">
                                                                <div class="media-left media-middle">
                                                                    <a href="#">
                                                                        <img class="media-object" src="<?= $root ?>assets/images/timeline/img2.png" alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body friend-elipsis">
                                                                    <div class="f-15 f-bold m-b-5">Josephin Doe</div>
                                                                    <div class="text-muted social-designation">Softwear Engineer at phoenixcoded</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="card">
                                                            <div class="input-group wall-elips">
                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                    <a class="dropdown-item" href="#">Remove tag</a>
                                                                    <a class="dropdown-item" href="#">Report Photo</a>
                                                                    <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                    <a class="dropdown-item" href="#">Blog User</a>
                                                                </div>
                                                            </div>
                                                            <div class="media bg-white d-flex p-10">
                                                                <div class="media-left media-middle">
                                                                    <a href="#">
                                                                        <img class="media-object" src="<?= $root ?>assets/images/timeline/img2.png" alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body friend-elipsis">
                                                                    <div class="f-15 f-bold m-b-5">Josephin Doe</div>
                                                                    <div class="text-muted social-designation">Softwear Engineer at phoenixcoded</div>
                                                                </div>
                                                            </div>
                                                        </div>
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
@endsection
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

                                  <img class="media-object img-circle" src="https://demo.shulesoft.com/<?= $user_image ?>" alt="Generic placeholder image">
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
                                          Task Type
                                          <select name="task_type_id"  class="form-control">
                                            <?php
                                            $types = DB::table('task_types')->whereNull('department')->get();
                                            foreach ($types as $type) {
                                              ?>
                                              <option value="<?= $type->id ?>"><?= $type->name ?></option>
                                            <?php } ?>

                                          </select>
                                        </div>
                                        <div class="col-md-6">
                                          Person Allocated to do
                                          <select name="to_user_id" class="form-control">
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
                                      <div class="row">
                                        <?php
                                        $modules = DB::table('modules')->get();
                                        foreach ($modules as $module) {
                                          ?>
                                          <div class="col-md-4">
                                            Task on <?=$module->name?>
                                            <br>
                                            <?php
                                            $subs = DB::table('sub_modules')->where('module_id', $module->id)->orderBy('id', 'DESC')->get();
                                            foreach ($subs as $sub) { ?>
                                              <input type="checkbox" id="feature<?= $sub->id ?>" value="{{$sub->id}}" name="data{{$sub->id}}[]" onchange="send_comment(<?= $sub->id ?>)">  <?php echo $sub->name; ?>
                                              <br>
                                            <?php } ?>

                                          </div>
                                        <?php } ?>

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
                          $tasks = \App\Models\Task::where('client_id', $client_id)->orderBy('created_at', 'desc')->get();
                          foreach ($tasks as $task) {
                            ?>
                            <div class="social-timelines p-relative o-hidden" id="removetag<?=$task->id?>">
                              <div class="row timeline-right p-t-35">
                                <div class="col-xs-2 col-sm-1">
                                  <div class="social-timelines-left">
                                    <img class="img-circle timeline-icon" src="<?= $root ?>assets/images/avatar-2.png" alt="">
                                  </div>
                                </div>
                                <div class="col-xs-10 col-sm-11 p-l-5 p-b-35">
                                  <div class="card m-0">
                                    <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">Actions</span>
                                    <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                      <a class="dropdown-item" href="#" onmousedown="removeTag(<?=$task->id?>)">Remove tag</a>
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
                                                <img class="media-object img-circle m-r-2" src="<?= $root ?>assets/images/avatar-1.png" alt="Generic placeholder image">
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
                                            <img class="media-object img-circle m-r-20" src="<?= $root ?>assets/images/avatar-blank.jpg" alt="Generic placeholder image">
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
                          <!--                                                    <div class="col-sm-12">
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
</div>-->
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

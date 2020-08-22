@extends('layouts.app')
@section('content')

<?php $root = url('/') . '/public/' ?>

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-header-title">
            <h4>School </h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Sales</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">School Profile</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
        <div class="card">
            <!-- Email-card start -->
            <div class="card-block email-card">
                <div class="row">
                    <!-- Left-side section start -->
                    <div class="col-lg-12 col-xl-3">
                        <div class="user-head row">
                            <div class="user-face">
                                <img src="<?= url('/') ?>/public/assets/images/auth/shulesoft_logo.png" class="img-60" alt="School Logo">

                            </div>
                            <div class="user-name">
                                <span><?= $school->name ?></span>
                                <span>Type: <?= $school->type ?></span>
                                <span>   <?= $school->ward . ' - ' . $school->district . ' - ' . $school->region ?></span>
                            </div>
                            <div class="btn-group">
                                <small style="margin-left:1em">Person Allocated</small>
                                <p align="center">  

                                    <?php
                                    $user_allocated = \App\Models\UsersSchool::where('school_id', $school->id)->where('role_id', '<>', 6)->first();
                                    if (count($user_allocated) == 1) {
                                        echo '                  <a href="#" class="btn btn-outline-primary waves-effect text-white"><i class="icofont icofont-ui-user m-r-10"></i>' . $user_allocated->user->firstname . ' ' . $user_allocated->user->lastname . ' </a>';
                                    } else {
                                        echo 'No Person Allocated';
                                    }
                                    ?>


                                </p>
                            </div>
                        </div>
                        <div class="user-body" style="min-height: 625px;">
                            <?php
                            $school_clients = DB::table('client_schools')->where('school_id', $school->id)->first();
                            if (count($school_clients) == 0) {
                                ?>
                                <div class="card-block">
                                    <button class="btn btn-danger btn-block" id="onboard_school">Onboard School</button>
                                </div>
                            <?php
                            } else {
                                $client_id = $school_clients->client_id;
                                ?>
                                <br/>
                                <div class="card-block alert alert-warning">
                                    <b class="">Already Onboarded</b>
                                </div>

                                <div class="card-block">
                                    <a href="<?= url('customer/download/' . $client_id) ?>" class="btn btn-warning btn-sx">Download Implentation Plan</a>
                                </div>
<?php } ?>
                            <ul class="page-list">
                                <li class="active">
                                    <div class="mail-section"  onclick="show_tabs('activities')">
                                        <a href="#">
                                            <i class="icofont icofont-inbox"></i> Activities
                                        </a>
                                        <label class="label label-primary f-right" id="task_count_"></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="mail-section" onclick="show_tabs('contacts')">
                                        <a href="#" >
                                            <i class="icofont icofont-star"></i> Contacts
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="mail-section"  onclick="show_tabs('school_details')">
                                        <a href="#" >
                                            <i class="icofont icofont-file-text"></i> School Details
                                        </a>
                                    </div>
                                </li>
                                <!--                                <li>
                                                                    <div class="mail-section"  onclick="show_tabs('contracts')">
                                                                        <a href="#" >
                                                                            <i class="icofont icofont-paper-plane"></i> Contracts
                                                                        </a>
                                                                    </div>
                                                                </li>-->
                                <script type="text/javascript">
                                    show_tabs = function (a) {
                                        $('.live_tabs').hide(function () {
                                            $('#' + a).show();
                                        });
                                    }
                                </script>

                            </ul>

                        </div>
                    </div>
                    <!-- Left-side section end -->
                    <!-- Right-side section start -->
                    <div class="col-lg-12 col-xl-9">
                        <div class="mail-box-head row">
                            <div class="col-sm-8">
                                <h3><?= $school->name ?>-<?= $school->type ?> School</h3>
                            </div>
                            <div class="col-md-4">
                                <div class="row follower-counter">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="txt-primary" contenteditable="true" onblur="$.get('<?= url('sales/updateStudent/null/') ?>', {no: $(this).text(), school_id:<?= $school->id ?>}, function (data) {
                                                    alert(data)
                                                })"><?= (int) $school->students ?></div>
                                        <div>Estimated Students</div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="mail-body">
                            <div class="mail-body-header">


                            </div>
                            <div class="mail-body-content">

                                <div class="timeline live_tabs" id="activities" style="margin-left:2em">
                                    <div class="row">
                                        <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#large-Modal">Create Task</button>
                                        <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1050; display: none;">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Create a Report/Task/Activity</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <form action="#" method="post">
                                                        <div class="modal-body">
                                                            <span>
                                                                Write what have been done </span>

                                                            <div class="form-group">
                                                                <textarea class="form-control" placeholder="Create Activity" name="activity"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">

                                                                    <div class="col-md-6">
                                                                        Sales Type
                                                                        <select name="task_type_id"  class="form-control">
                                                                            <?php
                                                                            $types = DB::table('task_types')->where('department', 1)->get();
                                                                            foreach ($types as $type) {
                                                                                ?>
                                                                                <option value="<?= $type->id ?>"><?= $type->name ?></option>
<?php } ?>

                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        Next action
                                                                        <select name="next_action" class="form-control">

                                                                            <option value="call">Call to remind</option>
                                                                            <option value="agreement form">Send Agreement Form</option>
                                                                            <option value="school visit">School Visit</option>
                                                                            <option value="closed">Closed</option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">

                                                                    <div class="col-md-6">
                                                                        Activity Deadline Date
                                                                        <input type="date" class="form-control" placeholder="Deadline" name="date">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        Deadline Time
                                                                        <input type="time" class="form-control" placeholder="Time" name="time">
                                                                    </div>
                                                                </div>
                                                            </div>



                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                                                        </div>
                                                        <input type="hidden" value="<?= $school->id ?>" name="client_id"/>
<?= csrf_field() ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 timeline-dot">
                                            <?php
                                            $tasks = \App\Models\Task::whereIn('id', \App\Models\TaskSchool::where('school_id', $school->id)->get(['task_id']))->orderBy('created_at', 'desc')->get();
                                            // dd($tasks);
                                            echo '<input type="hidden" value="' . count($tasks) . '" id="task_count"/>';
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
                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                    <a class="dropdown-item" href="#" onmousedown="removeTag(<?= $task->id ?>)">Remove tag</a>
                                                                    <a class="dropdown-item" href="#">Report Photo</a>
                                                                    <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                    <a class="dropdown-item" href="#">Blog User</a>
                                                                </div>
                                                                <div class="card-block post-timelines">

                                                                    <div class="social-time text-muted">
    <?= date("d M Y", strtotime($task->created_at)) ?>
                                                                    </div>
                                                                </div>


                                                                <div class="card-block">
                                                                    <div class="timeline-details">
                                                                        <div class="chat-header"><?= $task->user->name ?></div>
                                                                        <p class="text-muted"><?= $task->activity ?></p>
                                                                    </div>
                                                                </div>

                                                                <div class="card-block user-box">
                                                                    <div class="p-b-30"> <span class="f-14"><a href="#">Comments</a></span></div>
                                                                    <?php
                                                                    $comments = $task->taskComments()->get();
                                                                    if (count($comments) > 0) {
                                                                        foreach ($comments as $comment) {
                                                                            ?>
                                                                            <div class="media m-b-20">
                                                                                <a class="media-left" href="#">
                                                                                    <img class="media-object img-circle m-r-20" src="<?= Auth::user()->photo ?>" alt="Image">
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
                                                                        <a class="media-left" href="#">
                                                                            <img class="media-object img-circle m-r-20" src="<?= Auth::user()->photo ?>" alt="Image">
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
<?php } ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="school_contacts live_tabs" id="contacts" style="display:none">           
                                    <div class="table-responsive">
                                        <div class="card-block user-box">
                                            <?php
                                            $contacts = $school->contacts()->get();

                                            foreach ($contacts as $contact) {
                                                ?>
                                                <div class="media m-b-10">
                                                    <a class="media-left" href="#!">
                                                        <img class="media-object img-circle" src="<?= Auth::user()->photo ?>" alt="Image">
                                                        <div class="live-status bg-danger"></div>
                                                    </a>
                                                    <div class="media-body">
                                                        <div class="chat-header"><?= $contact->name ?></div>
                                                        <div class="text-muted social-designation"><?= ucfirst($contact->title) ?></div>
                                                        <div class="text-muted social-designation"><?= $contact->phone ?></div>
                                                        <div class="text-muted social-designation"><?= $contact->email ?></div>
                                                    </div>
                                                </div>
<?php } ?>


                                            <a href="#" class="waves-effect" data-toggle="modal" data-target="#large-Modal-add-person">Add Key Person</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="live_tabs" id='school_details' style="display:none">
                                    <div class="card-block">
                                        <button id="edit-btn" type="button" class="btn btn-primary waves-effect waves-light f-right" data-toggle="modal" data-target="#large-Modal-edit-school">
                                            <i class="icofont icofont-edit"></i>
                                        </button>
                                        <div id="view-info" class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <form>
                                                    <table class="table m-b-0">
                                                        <tbody><tr>
                                                                <th class="social-label b-none p-t-0">School Name
                                                                </th>
                                                                <td class="social-user-name b-none p-t-0 text-muted"><?= $school->name ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="social-label b-none">Region</th>
                                                                <td class="social-user-name b-none text-muted"><?= $school->region ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="social-label b-none">District</th>
                                                                <td class="social-user-name b-none text-muted"><?= $school->district ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="social-label b-none">Ward</th>
                                                                <td class="social-user-name b-none text-muted"><?= $school->ward ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="social-label b-none p-b-0">Use NMB</th>
                                                                <td class="social-user-name b-none p-b-0 text-muted"><?= strlen($school->nmb_branch) > 2 ? 'YES : ' . ucwords($school->nmb_branch) . ' Branch' : 'NO' ?></td>
                                                            </tr>
                                                        </tbody></table>
                                                </form>
                                                <br/>
                                                <?php
                                                if (isset($client_id) && (int) $client_id > 0) {
                                                    $client = DB::table('admin.clients')->where('id', $client_id)->first();
                                                    ?>
                                                    <h3>Onboarding Details</h3>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Client Phone</th>
                                                                <th>Client Try Code</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">1</th>
                                                                <td><?= $client->name ?></td>
                                                                <td><?= $client->phone ?></td>
                                                                <td><?= $client->code ?></td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="live_tabs" id='contracts' style="display:none">
                                    <table>
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Username</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">1</th>
                                                            <td>Mark</td>
                                                            <td>Otto</td>
                                                            <td>@mdo</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                                <div class="live_tabs" id="onboard_school_content">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right-side section end -->
                </div>
            </div>
            <!-- Email-card end -->
        </div>
    </div>






    <div class="modal fade" id="large-Modal-add-person" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1050; display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Person</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="#" method="post">
                    <div class="modal-body">
                        <span>Person Details </span>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    Name
                                    <input type="text" name="name" class="form-control"/> 
                                </div>
                                <div class="col-md-6">
                                    Phone
                                    <input type="text" name="phone" class="form-control"/> 
                                </div>
                                <div class="col-md-6">
                                    Email
                                    <input type="text" name="email" class="form-control"/> 
                                </div>
                                <div class="col-md-6">
                                    Title
                                    <select name="title" class="form-control">

                                        <option value="director">Director/Owner</option>
                                        <option value="manager">School Manager</option>                      
                                        <option value="head teacher">Head Teacher</option>
                                        <option value="Second Master/Mistress">Second Master/Mistress</option>
                                        <option value="academic master">Academic Master</option>
                                        <option value="teacher">Normal Teacher</option>
                                        <option value="Accountant">Accountant</option>
                                        <option value="Other Staff">Other Non Teaching Staff</option>


                                    </select>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                    </div>
                    <input type="hidden" value="<?= $school->id ?>" name="school_id"/>
                    <input type="hidden" value="1" name="add_user"/>
                    <?= csrf_field() ?>
                </form>
            </div>
        </div>
    </div>


    <!-- Page-body end -->
</div>
<div class="modal fade" id="large-Modal-edit-school" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1050; display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit School</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="#" method="post">
                <div class="modal-body">
                    <?php
                    $school_info = DB::table('schools')->where('id', $school->id)->first();

                    $vars = get_object_vars($school_info);
                    ?>
                    <?php
                    foreach ($vars as $key => $variable) {
                        if (!in_array($key, array('id', 'created_at', 'updated_at', 'status', 'schema_name', 'registration_number'))) {
                            $name = ucfirst(str_replace('_', ' ', $key));
                            ?>
                            <div class="form-group">
                                <div class="row">

                                    <div class="col-md-12">
                                        <?php
                                        echo $name;
                                        ?>

                                        <input type="text" name="<?= $key ?>" value="<?= $variable ?>" class="form-control"/>

                                    </div>

                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                </div>
                <input type="hidden" value="<?= $school->id ?>" name="client_id"/>
                <input type="hidden" name="add_sale" value="1"/>
                <?= csrf_field() ?>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    onboard = function () {
        $('#task_count_').html($('#task_count').val());
        $('#onboard_school').mousedown(function () {
            $('#onboard_tabs').hide();
            $.ajax({
                type: 'GET',
                url: '<?= url('sales/onboard/' . request()->segment(3)) ?>',
                data: {id: '<?= $school->id ?>'},
                dataType: "html",
                success: function (data) {
                    $('.live_tabs').hide();
                    $('#onboard_school_content').html(data).show();
                }
            });

        })
    }
    $(document).ready(onboard);
</script>
@endsection
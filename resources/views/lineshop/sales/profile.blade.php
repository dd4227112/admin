@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<style>
    input {
        width: 300px;
    }

    #map {
        width: 400px;
        height: 400px;
    }
</style>
<!-- Page-header start -->
<div class="page-header">
    <div class="page-header-title">
        <h4>Pharmacy Profile </h4>
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
            <li class="breadcrumb-item"><a href="#!">Pharmacy Profile</a>
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
                            <span><?= $pharmacy->name ?></span>
                            <span>Type: <?= $pharmacy->type ?></span>
                        </div>
                        <div class="btn-group">
                            <small style="margin-left:1em">Person Allocated</small>
                            <p align="center">

                                <?php
                                $user_allocated = \App\Models\UsersPharmacy::where('pharmacy_id', $pharmacy->id)->where('role_id', '<>', 6)->first();
                                if (!empty($user_allocated)) {
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
                        $pharmacy_clients = DB::table('client_pharmacy')->where('pharmacy_id', (int) $pharmacy->id)->first();
                        if (empty($pharmacy_clients)) {
                        ?>
                            <div class="card-block">
                                <?php
                                echo '<a href="' . url('lineshop/onboardPharmacy/' . $pharmacy->id) . '" class="btn btn-primary btn-sm btn-round" id="onboard_pharmacy">Onboard Pharmacy</a>';
                                ?>
                            </div>
                        <?php
                        } else {
                            $client_id = $pharmacy_clients->client_id;
                        ?>
                            <br />
                            <div class="card-block alert alert-warning">
                                <b class="">Already Onboarded</b>
                                <div class="">
                                    <br>
                                    <a target="_blank" href="<?= $link?>" class="btn btn-primary btn-sm">Install/Login</a>
                                </div>
                            </div>

                            <div class="card-block">
                                <a href="<?= url('customer/download/' . $client_id) ?>" class="btn btn-warning btn-sx">Download Implentation Plan</a>
                            </div>
                        <?php } ?>
                        <ul class="list-group">
                            <li class="list-group-item active">
                                <div class="mail-section" onclick="show_tabs('activities')">
                                    <a href="#">
                                        <i class="icofont icofont-inbox"></i> Activities
                                    </a>
                                    <label class="label label-secondary f-right" id="task_count_"></label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="mail-section" onclick="show_tabs('contacts')">
                                    <a href="#">
                                        <i class="icofont icofont-star"></i> Contacts
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="mail-section" onclick="show_tabs('pharmacy_details')">
                                    <a href="#">
                                        <i class="icofont icofont-file-text"></i> Pharmacy Details
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
                                show_tabs = function(a) {
                                    $('.live_tabs').hide(function() {
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
                            <h3><?= $pharmacy->name ?>-<?= $pharmacy->type ?></h3>
                        </div>
                        <div class="col-md-4">
                            <div class="row follower-counter">
                                <div class="col-md-12 col-lg-12">
                                    <div class="text-white " contenteditable="true" onblur="$.get('<?= url('sales/updateStudent/null/') ?>', {no: $(this).text(), school_id:<?= $pharmacy->id ?>}, function (data) {
                                                alert(data)
                                            })"></div>
                                    <div class="text-white">No. of Warehouse</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mail-body">
                        <div class="mail-body-header">
                        </div>
                        <div class="mail-body-content">

                            <div class="timeline live_tabs mb-20" id="activities" style="margin-left:2em">
                                <div class="row">
                                    <button type="button" class="btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#large-Modal">Create Task</button>
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
                                                                    <select name="task_type_id" class="form-control">
                                                                        <?php
                                                                        $types = DB::table('task_types')->where('department', 1)->get();
                                                                        foreach ($types as $type) {
                                                                        ?>
                                                                            <option value="<?= $type->id ?>">
                                                                                <?= $type->name ?></option>
                                                                        <?php } ?>

                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    Next action
                                                                    <select name="next_action" class="form-control">
                                                                        <option value="new">New</option>
                                                                        <option value="pipeline">Pipeline</option>
                                                                        <option value="closed">Closed</option>
                                                                        <option value="call">Call to remind</option>
                                                                        <option value="agreement form">Send
                                                                            Agreement Form</option>
                                                                        <option value="pharmacy visit">pharmacy Visit
                                                                        </option>
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
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <strong> Task Executed Successfully</strong>
                                                                    <select name="status" class="form-control" required>

                                                                        <option value='new'> Select Task Status
                                                                            Here...</option>
                                                                        <option value='complete'> Yes and Completed
                                                                        </option>
                                                                        <option value='on progress'> Yes but on
                                                                            Progress </option>
                                                                        <option value='schedule'> Not yet (Schedule)
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Save
                                                            changes</button>
                                                    </div>
                                                    <input type="hidden" value="<?= $pharmacy->id ?>" name="client_id" />
                                                    <?= csrf_field() ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 timeline-dot">
                                        <?php
                                        $tasks = \App\Models\Task::whereIn('id', \App\Models\TaskPharmacy::where('pharmacy_id', $pharmacy->id)->get(['task_id']))->orderBy('created_at', 'desc')->get();
                                        if (sizeof($tasks)) {
                                            // dd($tasks);
                                            echo '<input type="hidden" value="' . sizeof($tasks) . '" id="task_count"/>';
                                            foreach ($tasks as $task) {
                                        ?>

                                                <div class="social-timelines p-relative o-hidden" id="removetag<?= $task->id ?>">
                                                    <div class="row">
                                                        <div class="col-xs-2 col-sm-1">
                                                            <div class="social-timelines-left">
                                                                <?php
                                                                $path = \collect(DB::select("select f.path from admin.users a join admin.company_files f on a.company_file_id = f.id where a.id = '{$task->user->id}'"))->first();
                                                                $local = $root . 'assets/images/user.png';
                                                                ?>
                                                                <img src="<?= isset($path->path) && ($path->path != '') ? $path->path : $local ?>" class="img-circle" style="position: relative;
                                                                     width: 25px;
                                                                     height: 25px;
                                                                     border-radius: 50%;
                                                                     overflow: hidden;">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-10 col-sm-11 p-l-5 p-b-35">
                                                            <div class="card m-0">

                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                    <a class="dropdown-item" href="#" onmousedown="removeTag(<?= $task->id ?>)">Remove
                                                                        tag</a>
                                                                    <a class="dropdown-item" href="#">Report Photo</a>
                                                                    <a class="dropdown-item" href="#">Hide From Timeline</a>
                                                                    <a class="dropdown-item" href="#">Blog User</a>
                                                                </div>


                                                                <div class="card-block">
                                                                    <div class="timeline-details">

                                                                        <div class="social-time text-muted">
                                                                            <?= date("d M Y", strtotime($task->created_at)) ?>
                                                                            (<code><?= $task->status ?></code>)
                                                                        </div>
                                                                        <div class="chat-header"><?= $task->user->name ?>
                                                                        </div>
                                                                        <p class="text-muted"><?= $task->activity ?></p>
                                                                        <p>Start Date- <?= $task->start_date ?> &nbsp; &nbsp;
                                                                            | &nbsp; &nbsp; End Date - <?= $task->end_date ?>
                                                                        </p>
                                                                    </div>

                                                                    <?php
                                                                    $comments = $task->taskComments()->get();
                                                                    if (sizeof($comments) > 0) {
                                                                    ?>
                                                                        <div class="p-b-30"> <span class="f-14"><a href="#">Comments</a></span></div>

                                                                        <?php foreach ($comments as $comment) { ?>
                                                                            <div class="media" style="padding-bottom: 2px;">
                                                                                <a class="media-left" href="#">

                                                                                    <?php
                                                                                    $path = \collect(DB::select("select f.path from admin.users a join admin.company_files f on a.company_file_id = f.id where a.id = '{$comment->user->id}'"))->first();
                                                                                    $local = $root . 'assets/images/user.png';
                                                                                    ?>
                                                                                    <img src="<?= isset($path->path) && ($path->path != '') ? $path->path : $local ?>" class="img-circle" style="position: relative;
                                                                                         width: 25px;
                                                                                         height: 25px;
                                                                                         border-radius: 50%;
                                                                                         overflow: hidden;">
                                                                                </a>
                                                                                <div class="media-body b-b-muted social-client-description">
                                                                                    <div class="chat-header">
                                                                                        <?= $comment->user->name ?><span class="text-muted"><?= date('d/M/Y', strtotime($comment->created_at)) ?></span>
                                                                                    </div>
                                                                                    <p class="text-muted"><?= $comment->content ?>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <div class="new_comment<?= $task->id ?>"></div>
                                                                    <div class="media">
                                                                        <a href="#" class="btn btn-success btn-sm btn-round" onclick="return false" onmousedown="$('#comment_area<?= $task->id ?>').toggle()"><i class="ti-comment"></i> Comment </a>
                                                                        <div class="media-body" id="comment_area<?= $task->id ?>" style="display:none">
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
                                        <?php
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>

                            <div class="pharmacy_contacts live_tabs" id="contacts" style="display:none">
                                <div class="table-responsive">
                                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#large-Modal-add-person">Add Key Person</a>
                                    <br /><!-- comment -->
                                    <hr />
                                    <br />
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Phone Number</th>
                                                <th>Email</th>
                                                <th>Title</th>
                                                <th>Notes</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $contacts = DB::table('pharmacy_contacts')->where('pharmacy_id', $pharmacy->id)->get();
                                            // $contacts = $pharmacy->contacts()->get();
                                            if (sizeof($contacts)) {
                                                $i = 1;
                                                foreach ($contacts as $contact) {
                                            ?>
                                                    <tr>
                                                        <td> <?= $i ?></td>
                                                        <td><img height="30" class="media-object img-circle" src="<?= url('public/assets/images/user.png') ?>" alt="Image">
                                                            <?= $contact->name ?>
                                                        </td>
                                                        <td><?= $contact->phone ?> </td>
                                                        <td> <?= $contact->email ?> </td>
                                                        <td> <?= ucfirst($contact->title) ?></td>
                                                        <td><?= ucfirst($contact->notes) ?> </td>
                                                        <td>
                                                            <!--<a href="#" class="btn btn-sm btn-primary">Edit</a>-->
                                                            <a href="<?= url('sales/deleteContact/' . $contact->id) ?>" class="btn btn-sm btn-danger">Delete</a>
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
                            <div class="live_tabs" id='pharmacy_details' style="display:none">
                                <div class="card-block">
                                    <?php if (can_access('edit_school')) { ?>
                                        <button id="edit-btn" type="button" class="btn btn-primary waves-effect waves-light f-right" data-toggle="modal" data-target="#large-Modal-edit-pharmacy">
                                            <i class="icofont icofont-edit"></i>
                                        </button>
                                    <?php } ?>
                                    <div id="view-info" class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <form>
                                                <table class="table m-b-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="b-none p-t-0">Pharmacy Name
                                                            </th>
                                                            <td class="social-user-name b-none p-t-0 text-muted">
                                                                <?= $pharmacy->name ?? '' ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="b-none p-t-0">Number of warehouse
                                                            </th>
                                                            <td class="social-user-name b-none p-t-0 text-muted">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="b-no">Owership</th>
                                                            <td class="social-user-nam-none text-muted">
                                                                <?= $pharmacy->ownership ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="b-no">Account name</th>
                                                            <td class="social-user-nam-none text-muted">

                                                        </tr>
                                                        <tr>
                                                            <th class="b-no">Account number</th>
                                                            <td class="social-user-nam-none text-muted">

                                                        </tr>
                                                        <tr>
                                                            <th class="b-no p-b-0">Use NMB</th>
                                                            <td class="social-user-nam-none p-b-0 text-muted">

                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th class="b-no">Contact person name</th>
                                                            <td class="social-user-nam-none text-muted">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="b-no">Contact person phone</th>
                                                            <td class="social-user-nam-none text-muted">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th class="b-no">Contact person designation</th>
                                                            <td class="social-user-nam-none text-muted">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th class="b-no"> Agreement date</th>
                                                            <td class="social-user-nam-none text-muted">
                                                                <?= '' ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th class="b-no"> Agreement document</th>
                                                            <td class="social-user-nam-none text-muted">
                                                                <?php if (!empty($pharmacy->company_file_id)) { ?>
                                                                    <a target="_blank" href="<?php
                                                                                                $view_url = "customer/viewContract/$pharmacy->agreement_id/agreement";
                                                                                                echo url($view_url)
                                                                                                ?>" class="btn btn-primary btn-mini btn-round">View</a>
                                                                <?php } else { ?>
                                                                    <b> Document not uploaded</b>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </form>
                                            <br />

                                            <?php
                                            if (isset($client_id) && (int) $client_id > 0) {
                                                $client = DB::table('admin.lineshop_clients')->where('id', (int) $client_id)->first();
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
                                <input type="text" name="name" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                Phone
                                <input type="text" name="phone" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                Email
                                <input type="text" name="email" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                Title
                                <select name="title" class="form-control">
                                    <option value="owner">Manager/Owner</option>
                                    <option value="admin">Admin</option>
                                    <option value="seller">Sales Person</option>
                                    <option value="store_keeper">Store Keeper</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                Notes <small>(notes or anything else)</small>
                                <input type="text" name="notes" class="form-control" />
                            </div>
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                </div>
                <input type="hidden" value="<?= $pharmacy->id ?>" name="school_id" />
                <input type="hidden" value="1" name="add_user" />
                <?= csrf_field() ?>
            </form>
        </div>
    </div>
</div>


<!-- Page-body end -->
</div>
<div class="modal fade" id="large-Modal-edit-pharmacy" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1050; display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Pharmacy</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php
                    //   $spharmacy_info = DB::table('pharmacies')->where('id', $pharmacy->id)->first();
                    //   $vars = get_object_vars($spharmacy_info);
                    //   if(sizeof($vars)){
                    //     
                    ?>
                    <?php
                    //     foreach ($vars as $key => $variable) {
                    //       if (!in_array($key, array('id', 'created_at', 'updated_at', 'status', 'registration_number'))) {
                    //         $name = ucfirst(str_replace('_', ' ', $key));
                    //         
                    ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <label> Pharmacy Name </label>
                                <input type="text" name="pharmacy_name" value="<?= $pharmacy->name ?>" class="form-control" required />
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label> nmb account name </label>
                                <input type="text" name="nmb_school_name" value="" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label> Account number </label>
                                <input type="text" name="account_number" value="<?= $pharmacy->account_number ?>" class="form-control" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label> Number of Warehouses </label>

                            </div>
                            <div class="col-md-6">
                                <label> Pharmacy type </label>
                                <select name="type" class="form-control" required>
                                    <option value='Retail'> Retail</option>
                                    <option value='whole sale'> Whole sale </option>
                                    <option value='both'> Whole sale & Retail </option>

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label> Pharmacy Contact person </label>
                                <input type="text" name="contact_person_name" value="" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label> Pharmacy Contact phone </label>
                                <input type="text" name="contact_person_phone" value="" class="form-control" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label> Pharmacy Contact Designation </label>
                                <input type="text" name="contact_person_designation" value="" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label> Agreement date </label>
                                <input type="date" name="agreement_date" value="" class="form-control" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label> Document type </label>
                                <select name="form_type" class="form-control">
                                    <option value='Lineshop'> Lineshop</option>
                                    <option value='NMB'> NMB </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label> Document </label>
                                <input type="file"   accept=".pdf"  name="agreement_file" class="form-control" />
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                </div>
                <input type="hidden" value="<?= $pharmacy->id ?>" name="pharmacy_id" />
                <input type="hidden" name="add_sale" value="1" />
                <?= csrf_field() ?>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function save_comment(id) {
        var content = $('#task_comment' + id).val();
        var task_id = $('#task_id' + id).val();
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "<?= url('customer/taskComment/null') ?>",
            data: {
                content: content,
                task_id: task_id
            },
            dataType: "html",
            success: function(data) {
                $('input[type="text"],textarea').val('');
                $('.new_comment' + id).after(data);
            }
        });
    }

    onboard = function() {
        $('#task_count_').html($('#task_count').val());
        $('#onboard_pharmacy').mousedown(function() {
            $('#onboard_tabs').hide();
            $.ajax({
                type: 'GET',
                url: '<?= url('lineshop/onboardPharmacy/' . request()->segment(3)) ?>',
                data: {
                    id: '<?= $pharmacy->id ?>'
                },
                dataType: "html",
                success: function(data) {
                    $('.live_tabs').hide();
                    $('#onboard_pharmacy_content').html(data).show();
                }
            });

        })
    }
    $(document).ready(onboard);
</script>
@endsection
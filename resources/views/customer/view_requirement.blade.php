@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4> CUSTOMER REQUIREMENT</h4>
                <span>This Part Show requirement Requested by schools</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Company Minutes</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">minutes</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <!-- tab panel personal start -->
                    <div class="tab-pane active" id="personal" role="tabpanel">
                        <!-- personal card start -->
                        <div class="card">
                            <div class="card-block">
                                <div class="view-info">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="general-info">
                                                <div class="row">
                                                    <div class="col-lg-12 col-xl-12">
                                                        <table class="table m-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Added Date</th>
                                                                    <th>{{ $requirement->created_at }} </th>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Staff Members</th>
                                                                    <th>
                                                                        <?php
                                                                        if ($requirement->user_id == $requirement->to_user_id) {
                                                                            echo $requirement->user->firstname . ' ' . $requirement->user->lastname;
                                                                        } else {
                                                                            echo 'By ' . $requirement->user->firstname . ' ' . $requirement->user->lastname . ' To ';
                                                                           /* $to_users =
                                                                            $person = '';
                                                                            foreach ($to_users as $user) {
                                                                                if (isset($user->user->firstname) && isset($user->user->lastname)) {
                                                                                    $person .= $user->user->firstname . ' ' . $user->user->lastname . ',';
                                                                                }
                                                                            } */
                                                                            echo $requirement->toUser->name;
                                                                        }
                                                                        ?>
                                                                </tr>
                                                                <tr>
                                                                    <th> Client Name</th>
                                                                    <th><?= isset($requirement->school->name) ? $requirement->school->name : 'General requirement' ?>
                                                                    <code><?= isset($requirement->school->type) ? $requirement->school->type : ''  ?></code>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th> Client Contact</th>
                                                                    <th><?= $requirement->contact?></th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- end of row -->
                                            </div>
                                            <!-- end of general info -->
                                        </div>
                                        <!-- end of col-lg-12 -->
                                    </div>
                                    <!-- end of row -->
                                </div>

                                <!-- end of card-block -->
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">

                                        <div class="card-block user-desc">
                                            <div class="view-desc">
                                                <h4>About This Requirement </h4>
                                                <hr>
                                                <span style="float: right;"><b>Task Excuted:</b>
                                                    <select id="action" class="form-control">
                                                        <option value='{{ $requirement->status }}'>{{ $requirement->status }}</option>
                                                        <option value='On Progres'>On Progres</option>
                                                        <option value='Completed'>Completed</option>
                                                        <option value='Resolved'>Resolved</option>
                                                        <option value='Canceled'>Canceled</option>
                                                        <option value='New'>New</option>
                                                    </select>
                                                </span>
                                                <p> <?= $requirement->note ?></p>

                                            </div>
                                            <?php /*
                                            <div class="card-block user-desc">
                                                <div class="view-desc">
                                                    <b>Task Comments</b>
                                                    <div class="user-box">
                                                        <?php
                                                        $comments = $requirement->taskComments()->get();
                                                        if (sizeof($comments) > 0) {
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
                                                        <div class="new_comment<?= $requirement->id ?>"></div>
                                                        <div class="media">
                                                            <a class="media-left" href="#">
                                                                <img class="media-object img-circle m-r-20" src="<?= $root ?>assets/images/avatar-blank.jpg" alt="Image">
                                                            </a>
                                                            <div class="media-body">
                                                                <form class="">
                                                                    <div class="">
                                                                        <textarea rows="5" cols="5" id="task_comment<?= $requirement->id ?>" class="form-control" placeholder="Write Something here..."></textarea>
                                                                        <div class="text-right m-t-20"><a href="#" class="btn btn-primary waves-effect waves-light" onclick="return false" onmousedown="$.get('<?= url('customer/taskComment/null') ?>', {content: $('#task_comment<?= $requirement->id ?>').val(), task_id:<?= $requirement->id ?>}, function (data) {
                                                            $('.new_comment<?= $requirement->id ?>').after(data);
                                                            $('#task_comment<?= $requirement->id ?>').val('')
                                                        })">Post</a></div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> */
                                            ?>
                                        </div>
                                    </div>
                                    <p>  <a href="<?=url('Customer/requirements')?>" class="btn btn-success" style="float: left;"> Go Back</a> </p>
                                    <p>  <a href="<?=url('Customer/requirements/show/'.$next)?>" class="btn btn-success" style="float: right;"> Go Next</a> </p>
                                <br>
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
<!-- personal card end-->
</div>
<script>
    $('#action').change(function () {
        var val = $(this).val();
        $.ajax({
            type: 'POST',
            url: "<?= url('Customer/updateReq') ?>",
            data: "id=" + <?= $requirement->id ?> + "&action=" + val,
            dataType: "html",
            success: function (data) {
                window.location.href = '#';
            }
        });
    });
</script>
@endsection

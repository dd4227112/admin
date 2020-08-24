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
                <h4> TASK PERFORMED</h4>
                <span>This Part Show Task performed on a school</span>
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
                                                                    <th scope="row">Deadline Date</th>
                                                                    <th>{{ $activity->date }} <?= $activity->time ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Staff Members</th>
                                                                    <th>
                                                                        <?php
                                                                        if ($activity->user_id == $activity->to_user_id) {
                                                                            echo $activity->user->firstname . ' ' . $activity->user->lastname;
                                                                        } else {
                                                                            echo 'By ' . $activity->user->firstname . ' ' . $activity->user->lastname . ' To ';
                                                                            $to_users = $activity->taskUsers()->get();
                                                                            $person = '';
                                                                            foreach ($to_users as $user) {
                                                                                if (isset($user->user->firstname) && isset($user->user->lastname)) {
                                                                                    $person .= $user->user->firstname . ' ' . $user->user->lastname . ',';
                                                                                }
                                                                            }
                                                                            echo $person;
                                                                        }
                                                                        ?>
                                                                </tr>
                                                                <tr>
                        }
                                                                    <th> Client Name</th>
                                                                    <th><?php
                                                                    if(isset($school) && count($school)){
                                                                        echo '<a href="'. url('sales/profile/'.$school->school_id) .'">'. $school->school->name .' - '. $school->school->type .'</a>';
                                                                    }elseif(isset($client) && count($client)){
                                                                        echo $client->client->name;
                                                                        echo '<a href="'. url('customer/profile/'.$client->client->username) .'">'. $client->client->name .'</a>';
                                                                    }else{
                                                                        echo '<a href="'. url('customer/profile/'.$activity->client->username) .'">'. $activity->client->name .'</a>';
                                                                    }
                                                                     ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Task Type</th>
                                                                    <th> <?= $activity->taskType->name ?></th> 
                                                                </tr>
                                                                <tr>
                                                                    <th>Modules</th>
                                                                    <td>
                                                                        <?php
                                                                        $modules = $activity->modules()->get();
                                                                        if (count($modules) > 0) {
                                                                            foreach ($modules as $module) {
                                                                                echo $module->module->name;
                                                                                ?>  &nbsp;|
                                                                                <?php
                                                                            }
                                                                        } else {
                                                                            echo "No Mudule Specified";
                                                                        }
                                                                        ?>
                                                                    </td>
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
                                                <h4>About This Activity </h4>
                                                <span style="float: right;"><b>Task Excuted:</b>
                                                    <select id="action" class="form-control">
                                                        <option value='{{ $activity->action }}'>{{ $activity->action }}</option>
                                                        <option value='Yes'>Yes</option>
                                                        <option value='No'>No</option>
                                                        <option value='Resolved'>Resolved</option>
                                                    </select>
                                                </span>
                                                <p> <?= $activity->activity ?></p>

                                            </div>

                                            <div class="card-block user-desc">
                                                <div class="view-desc">
                                                    <b>Task Comments</b>
                                                    <div class="user-box">
                                                        <?php
                                                        $comments = $activity->taskComments()->get();
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
                                                        <div class="new_comment<?= $activity->id ?>"></div>
                                                        <div class="media">
                                                            <a class="media-left" href="#">
                                                                <img class="media-object img-circle m-r-20" src="<?= $root ?>assets/images/avatar-blank.jpg" alt="Image">
                                                            </a>
                                                            <div class="media-body">
                                                                <form class="">
                                                                    <div class="">
                                                                        <textarea rows="5" cols="5" id="task_comment<?= $activity->id ?>" class="form-control" placeholder="Write Something here..."></textarea>
                                                                        <div class="text-right m-t-20"><a href="#" class="btn btn-primary waves-effect waves-light" onclick="return false" onmousedown="$.get('<?= url('customer/taskComment/null') ?>', {content: $('#task_comment<?= $activity->id ?>').val(), task_id:<?= $activity->id ?>}, function (data) {
                                                            $('.new_comment<?= $activity->id ?>').after(data);
                                                            $('#task_comment<?= $activity->id ?>').val('')
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
            url: "<?= url('Customer/updateTask') ?>",
            data: "id=" + <?= $activity->id ?> + "&action=" + val,
            dataType: "html",
            success: function (data) {
                window.location.href = '#';
            }
        });
    });
</script>
@endsection

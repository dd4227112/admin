@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<div>
    <div class="page-header">
        <div class="page-header-title">
            <h4>Task</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                 <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Task Allocated</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">summary</a>
                </li>
            </ul>
        </div>
    </div> 
  </div>

        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                        <!-- personal card start -->
                        <div class="card">
                            <div class="card-block">
                               
                                  <table class="table m-0">
                                        <tbody>
                                                <tr>
                                                    <th scope="row">Task Period</th>
                                                    <th>Start {{ date('d-m-Y H:i:s', strtotime($activity->start_date)) }} &nbsp;&nbsp; &nbsp;  to  &nbsp;&nbsp; &nbsp;   <?=  date('d-m-Y H:i:s', strtotime($activity->end_date)) ?></th>
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
                                                                    <th> Client Name</th>
                                                                    <th><?php
                                                                    if(isset($school) && !empty($school)){
                                                                        echo '<a href="'. url('sales/profile/'.$school->school_id) .'">'. $school->school->name .' - '. $school->school->type .'</a>';
                                                                    }elseif(isset($client) && !empty($client)){
                                                                        echo '<a href="'. url('customer/profile/'.$client->client->username) .'">'. $client->client->name .'</a>';
                                                                    }else{
                                                                        echo '<a href="#">'. $activity->client->name .'</a>';
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
                                                                        if (!empty($modules)) {
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
                                                                @if(!empty($activity->attachment))
                                                                <tr>
                                                                    <th scope="row">Attachment</th>
                                                                    <th> <p>Attachment - {{$activity->attachment_type}}</p><small>Click on school name above to view attachment</small></th>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- end of row -->
                                            </div>
                                            <!-- end of general info -->
                                     

                                <!-- end of card-block -->
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">

                                        <div class="card-block user-desc">
                                            <div class="view-desc">
                                                <h4>About This Activity </h4>
                                              
                                                <p> <?= $activity->activity ?></p>

                                            </div>

                                            <div class="card-block user-desc">
                                                <div class="view-desc">
                                                    <b>Task Comments</b>
                                                    <div class="user-box">
                                                        <?php
                                                        $comments = $activity->taskComments()->get();
                                                        if (!empty($comments)) {
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


                                            <p style="float: right;"> <span style="float: right;" id="added_"> </span>
                                                <b>Task Excuted:</b>
                                                    <select id="action" class="form-control">
                                                        <option value='{{ $activity->action }}'>{{ $activity->status }}</option>
                                                        <option value='complete'>Complete</option>
                                                        <option value='Pending'>Pending</option>
                                                        <option value='on progress'>Progress</option>
                                                        <option value='Resolved'>Resolved</option>
                                                        <option value='Cancelled'>Cancelled</option>
                                                    </select>
                                                </p>

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
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            url: "<?= url('Customer/updateTask') ?>",
            data: "id=" + <?= $activity->id ?> + "&action=" + val,
            dataType: "html",
            success: function (data) {
                toastr.success(data);

            }
        });
    });
</script>
@endsection

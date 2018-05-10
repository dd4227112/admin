@extends('layouts.app')
@section('content')
<?php
?>
<?php $root = url('/') . '/public/' ?>
<link href="<?= $root ?>plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

<div class="row">
    <div class="col-md-4 col-xs-12">
        <div class="white-box">
            <div class="user-bg"> <img width="100%" alt="user" src="../plugins/images/large/img1.jpg">
                <div class="overlay-box">
                    <div class="user-content">
                        <a href="javascript:void(0)"><img src="<?= url('https://' . $schema . '/storage/uploads/images/' . $user->photo) ?>" class="thumb-lg img-circle" alt="img"></a>
                        <h4 class="text-white"><?= $user->name ?></h4>
                        <h5 class="text-white"><?= $user->email ?> </h5>
                        <h5 class="text-white"><?= $user->phone ?> </h5>
                        <h5 class="text-white"><?= $table ?> </h5>
                    </div>
                </div>
            </div>
            <div class="user-btm-box">
                <div class="col-md-4 col-sm-4 text-center">
                    <p class="text-purple"><i class="fa fa-list"></i><br/> Logs</p>
                    <h1><?= $all_logs ?></h1> </div>
                <div class="col-md-4 col-sm-4 text-center">
                    <p class="text-blue"><i class="fa fa-inbox"></i> Messages</p>
                    <h1><?= count($messages) ?></h1> </div>
                
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xs-12">
        <div class="white-box">
            <ul class="nav nav-tabs tabs customtab">
                <li class="tab active">
                    <a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">Activity</span> </a>
                </li>
                <li class="tab">
                    <a href="#profile" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Profile</span> </a>
                </li>
                <li class="tab">
                    <a href="#messages" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-envelope-o"></i></span> <span class="hidden-xs">Messages</span> </a>
                </li>
<!--                <li class="tab">
                    <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Settings</span> </a>
                </li>-->
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="home">
                    <div class="steamline">
                       
                            <div class="sl-item">
                                <div class="sl-left"></div>
                                <div class="sl-right">
                                     <?php
                                     $i=1;
                        foreach ($logs as $log) {
                            ?>
                                    <div class="m-l-40">
                                        <a href="#" class="text-info"><?= $i ?> : </a> 
                                        <span class="sl-date"><?= date('d M Y h:i',strtotime($log->created_at)).' , '.timeAgo($log->created_at) ?></span>
                                        <p>Page Visit url: <a href="#"> <?= $log->url ?></a></p>
                                        <div class="m-t-20 row">
                                            <ul>
                                                <li>
                                                    <b>
                                                     Platform:   <span class="label label-success"><?= $log->platform ?></span> 
                                    </b>
                                                    <b>Platform Name: <span class="label label-warning"><?= $log->platform_name ?></span> </b>
                                                    <b>Browser:<span class="label label-info"><?= $log->user_agent ?></span> </b></li>
                                            </ul>
                                        </div>
                                    </div>
                                     <?php $i++; } ?>
                                </div>
                                <?=$logs->links()?>
                            </div>
                       

                    </div>
                </div>
                <div class="tab-pane" id="profile">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Field Name</th>
                                        <th>Field Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Full Name</strong></td>
                                        <td> <p class="text-muted" contenteditable="" id="name"><?= $user->name ?></p></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td> <p class="text-muted" contenteditable="" id="email"><?= $user->email ?></p></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone</strong></td>
                                        <td> <p class="text-muted" contenteditable="" id="phone"><?= $user->phone ?></p></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Location</strong></td>
                                        <td> <p class="text-muted" contenteditable="" id="address"><?= $user->address ?></p></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Username</strong></td>
                                        <td> <p class="text-muted" contenteditable="" id="username"><?= $user->username ?></p></td>
                                    </tr>
                                    <?php if(isset($user->dob)){?>
  <tr>
                                        <td><strong>Date of Birth</strong></td>
                                        <td> <p class="text-muted" contenteditable="" id="dob"><?= $user->dob ?></p></td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td><strong>Reset Password</strong></td>
                                        <td> <p class="text-muted"><a href="#" id="reset_password" class="btn btn-rounded">Reset</a></p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <?php if (isset($students)) { ?>
                        <p class="m-t-30">Parent Student </p>

                        <h4 class="font-bold m-t-30">Student List</h4>
                        <hr/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Admission Number</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($students as $student) {
                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $student->name ?></td>
                                            <td><?= $student->roll ?></td>
                                            <td><?= $student->username ?></td>
                                            <td><span class="label label-danger">admin</span> </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                         <?php if (isset($parents)) { ?>
                        <p class="m-t-30">Parent Student </p>

                        <h4 class="font-bold m-t-30">Student List</h4>
                        <hr/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Relation</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($parents as $parent) {
                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><a href="<?=url('profile/'.$schema.'/parent/'.$parent->parentID)?>"><?= $parent->name ?></a></td>
                                            <td><?= $parent->relation ?></td>
                                            <td><?= $parent->username ?></
                                            <td><span class="label label-danger">Parent</span> </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
                <div class="tab-pane" id="messages">
                    <div class="steamline">
                        <?php
                        if (isset($messages)) {

                            foreach ($messages as $message) {
                                if ($message->is_sent == 1) {
                                    ?>
                                    <div class="sl-item">
                                        <div class="sl-left"> <img src="<?= url("storage/uploads/images/" . $user->photo); ?>" alt="user" class="img-circle"> </div>
                                        <div class="sl-right">
                                            <div class="m-l-40"><a href="#" class="text-info"><?= $user->name ?></a> <span class="sl-date"><?= timeAgo($message->created_at) ?></span>
                                                <p><?= $message->body ?></p>
                                                <div class="m-t-20 row">
                                                    <div class="el-overlay scrl-up">
                                                        <ul class="el-info">
                                                            <a class="btn btn-success" href="#" onclick="resend_message(<?= $message->sms_id ?>)"><i class="icon-reload"></i> Resend Message</a>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>  <?php } else { ?>
                                    <div class="sl-item">
                                        <div class="sl-left"> <img src="<?= url("storage/uploads/images/defualt.png"); ?>" alt="user" class="img-circle"> </div>
                                        <div class="sl-right">
                                            <div class="m-l-40"><a href="#" class="text-info"><?= $user->name ?></a> <span class="sl-date"><?= timeAgo($message->created_at) ?></span>
                                                <p><?= $message->body ?></p>
                                                <div class="m-t-20 row"><img src="../plugins/images/img1.jpg" alt="user" class="col-md-3 col-xs-12"> <img src="../plugins/images/img2.jpg" alt="user" class="col-md-3 col-xs-12"> <img src="../plugins/images/img3.jpg" alt="user" class="col-md-3 col-xs-12"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
<!--                <div class="tab-pane" id="settings">
                    <form class="form-horizontal form-material">
                        <div class="form-group">
                            <label class="col-md-12">Full Name</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="Johnathan Doe" class="form-control form-control-line"> </div>
                        </div>
                        <div class="form-group">
                            <label for="example-email" class="col-md-12">Email</label>
                            <div class="col-md-12">
                                <input type="email" placeholder="johnathan@admin.com" class="form-control form-control-line" name="example-email" id="example-email"> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Password</label>
                            <div class="col-md-12">
                                <input type="password" value="password" class="form-control form-control-line"> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Phone No</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="123 456 7890" class="form-control form-control-line"> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Message</label>
                            <div class="col-md-12">
                                <textarea rows="5" class="form-control form-control-line"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Select Country</label>
                            <div class="col-sm-12">
                                <select class="form-control form-control-line">
                                    <option>London</option>
                                    <option>India</option>
                                    <option>Usa</option>
                                    <option>Canada</option>
                                    <option>Thailand</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="btn btn-success">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    reset_password = function () {
        $('#reset_password').click(function () {
            $.get('<?= url('profile/reset') ?>', {schema: '<?= $schema ?>', table: '<?= $table ?>', user_id: '<?= $user_id ?>'}, function (data) {
                swal('success', 'message sent successfully. Mesagge  ID=' + data);
            });
        });
    };
    resend_message = function (a) {
        $.get('<?= url('profile/resend') ?>', {schema: '<?= $schema ?>', message_id: a}, function (data) {
            swal('success', data);
        });
    };
    edit_records = function () {
        $('.text-muted').keyup(function (e) {
            if (e.keyCode == 13) {
                var tag = $(this).attr('id');
                var val = $(this).text();
                $.get('<?= url('profile/update') ?>', {schema: '<?= $schema ?>', table: '<?= $table ?>', val: val,tag:tag,user_id: '<?= $user_id ?>'}, function (data) {
                    swal('success',data);
                });
            }
        });
    };
    $(document).ready(edit_records);
    $(document).ready(reset_password);
</script>
<!-- Sweet-Alert  -->
<script src="<?= $root ?>plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="<?= $root ?>plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>

@endsection
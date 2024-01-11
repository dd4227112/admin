@extends('layouts.app')
@section('content')

    
        <!-- Page-header start -->
         <div class="page-header">
            <div class="page-header-title">
                <h4><?='Customer feedback' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">feedback</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Feedbacks</h5>
                            <span>If you click "Show to Pharmacy" then pharmacy will be able to view this feedback. If you click "reply", then you can write your message and user will get a notification on it </span>
                        </div>

                        <div class="card-block">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="white-box">
                                        <?php
                                        $i = 1;
                                        foreach ($feedbacks as $feedback) {

                                            $user = \DB::table('admin.all_users')->where('id', $feedback->user_id)->where('table', $feedback->table)->where('schema_name', $feedback->schema)->first();
                                            ?>
                                            <div class="col-lg-12">
                                                <div class="card card-border-primary">
                                                    <div class="card-header">
                                                        <h5><?= !empty($user) ? $user->name : $feedback->username ?></h5>
                                                        <!-- <span class="label label-default f-right"> 28 January, 2015 </span> -->
                                                        <div class="dropdown-secondary dropdown f-right">
                                                            <input type="checkbox" <?= (int) $feedback->shared == 1 ? 'checked' : '' ?> value="<?= $feedback->shared ?>" id="checkbox<?= $feedback->id ?>" onmousedown="show_to_school(<?= $feedback->id ?>)"/>Show to School <span id="replystatus<?= $feedback->id ?>"></span>

                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <ul class="list list-unstyled">
                                                                    <?= $feedback->feedback ?>
                                                                </ul>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="task-list-table">
                                                            <p class="task-due"><strong> From : <b class="label label-success"><?= $feedback->schema ?></b> </strong>
                                                                At:  <strong class="label label-default"><?= date('d M Y h:m:i', strtotime($feedback->created_at)) ?></strong></p>
                                                        </div>
                                                      <?php if(can_access('reply_feeback')) { ?>
                                                        <div class="task-board m-0">
                                                            <a href="#" onclick="return false" onmousedown="$('#mess<?= $feedback->id ?>').toggle()" class="btn btn-info btn-mini b-none"><i class="icofont icofont-eye-alt m-0"></i> Reply</a>
                                                        </div>
                                                      <?php } ?>

                                                        <?php
                                                        $replies = $feedback->reply()->get();
                                                        ?>
                                                        <!-- end of pull-right class -->
                                                        <p>Replies (<?= sizeof($replies) ?>) </p>
                                                        <div>
                                                            <?php
                                                            foreach ($replies as $reply) {
                                                                ?>
                                                                <div class="col-lg-12 col-sm-12 col-xs-12 m-t-40">
                                                                    <span class="m-b-0"><b><?= \Carbon\Carbon::createFromTimeStamp(strtotime($reply->created_at))->diffForHumans() . ' by ' . $reply->user->firstname ?></b></span>
                                                                    <p class="text-muted"><?= $reply->message ?></p>
                                                                </div>
                                                           <?php } ?>
                                                        </div>
                                                        <div class="form-group" id="mess<?= $feedback->id ?>" style="display:none">
                                                            <textarea class="form-control" placeholder="write a message" id="message<?= $feedback->id ?>"></textarea>
                                                            <button class="btn btn-primary" data-id='<?= $feedback->id ?>' id='idmessage<?= $feedback->id ?>' onmousedown="submit_reply('message<?= $feedback->id ?>')">Submit</button>
                                                            <p id="statmessage<?= $feedback->id ?>"></p>
                                                        </div> 
                                                    </div>
                                                    <!-- end of card-footer -->
                                                </div>
                                            </div>



    <?php
    $i++;
    
    $feedback->update(array('opened' => 1));
}
?>


                                    </div>
<?= $feedbacks->links() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.pagination li').addClass('btn btn-sm btn-primary btn-outline-success');
    function submit_reply(a) {
        var message = $('#' + a).val();
        var message_id = $('#id' + a).attr('data-id');
        $.ajax({
            type: 'GET',
            url: "<?= url('message/reply/null') ?>",
            data: {
                "message": message,
                "message_id": message_id
            },
            dataType: "html ",
            beforeSend: function (xhr) {
                $('#stat' + a).html('<a href="#/refresh"><i class="fa fa-spin fa-refresh"></i> </a>');
            },
            complete: function (xhr, status) {
                $('#stat' + a).html('<span class="label label-success label-rouded">' + status + '</span>');
            },

            success: function (data) {
                $('#stat' + a).after(data);
            }
        });
    }
    function show_to_school(a) {
        var val = $('#checkbox' + a).prop('checked');
        // alert(val);
        $.ajax({
            type: 'GET',
            url: "<?= url('message/showreply/null') ?>",
            data: {
                "status": val,
                "message_id": a
            },
            dataType: "html ",
            beforeSend: function (xhr) {
                $('#replystatus' + a).html('<a href="#/refresh"><i class="fa fa-spin fa-refresh"></i> </a>');
            },
            complete: function (xhr, status) {
                $('#replystatus' + a).html('<span class="label label-success label-rouded">' + status + '</span>');
            },

            success: function (data) {
                // $('#replystatus' + a).after(data);
            }
        });

    }
</script>
@endsection

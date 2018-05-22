@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <ul class="timeline">
                <?php
                $i = 1;
                foreach ($feedbacks as $feedback) {

                    $user = \DB::table('admin.all_users')->where('id', $feedback->user_id)->where('table', $feedback->table)->where('schema_name', $feedback->schema)->first();
                    ?>
                    <li <?= $i % 2 == 0 ? 'class="timeline-inverted"' : '' ?> >
                        <div class="timeline-badge success"><i class="fa fa-user"></i> </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title"><?= count($user) == 1 ? $user->name : $feedback->username ?></h4>
                                <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d M Y h:m:i', strtotime($feedback->created_at)) . ' From: ' . $feedback->schema ?></small> </p>
                            </div>
                            <div class="timeline-body">
                                <p><?= $feedback->feedback ?></p>
                            </div>
                            <hr>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-gear"></i> <span class="caret"></span> </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" onclick="return false" onmousedown="$('#mess<?= $feedback->id ?>').toggle()">Reply</a> </li>
                                </ul>

                               
                            </div>
                             <p>Replies</p>
                                <div>
                                    <?php
                                    $replies = $feedback->reply()->get();
                                   
                                    foreach ($replies as $reply) {
                                      
                                        ?>
                                    <div class="col-lg-12 col-sm-12 col-xs-12 m-t-40">
                                        <span class="m-b-0"><b><?= \Carbon\Carbon::createFromTimeStamp(strtotime($reply->created_at))->diffForHumans().' by '.$reply->user->firstname?></b></span>
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
                    </li>
                    <?php
                    $i++;
                    $feedback->update(array('opened' => 1));
                }
                ?>

            </ul>
        </div>
        <?= $feedbacks->links() ?>
    </div>
</div>
<script type="text/javascript">
    function submit_reply(a) {
        var message = $('#' + a).val();
        var message_id = $('#id' + a).attr('data-id');
        $.ajax({
            type: 'GET',
            url: "<?= url('message/reply') ?>",
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
</script>
@include('layouts.datatable')
@endsection

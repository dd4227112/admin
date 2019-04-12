@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
  <link rel="stylesheet" href="<?= $root ?>plugins/bower_components/html5-editor/bootstrap-wysihtml5.css" />
<div class="white-box">
    <code id="mycode"></code>  
    <?= isset($message_success) ? '<div class="alert alert-info">' . $message_success . '</div>' : '' ?>
    <form action="<?= url('message/createUpdate') ?>" method='post' class="form-horizontal form-bordered">
        {{ csrf_field() }}
        <div class="form-body">

            <div class="form-group last">
                <label class="control-label">Update For:</label>
                <div class="col-md-12">
                     <?php foreach ($usertypes as $user) { ?>
                    <input type="checkbox" name="for[]" value="<?= $user->usertype ?>"><?= $user->usertype ?>
                        <?php } ?>
                    <span></span>
                </div>
            </div>
            <div class="form-group last">
                <label class="control-label">Update Type:</label>
                <div class="col-md-12">
                    <select name="update_type" class="form-control">
                        <option value="Issue Resolved">Issue Resolved</option>
                        <option value="Added Feature">Added Feature</option>
                        <option value="Modified Feature">Modified Feature</option>
                    </select>
                    <span></span>
                </div>
            </div>
            <div class="form-group last">
                <label class="control-label">Release Date:</label>
                <div class="col-md-12">
                    <input type="date" value="<?= request('skip') ?>" class="form-control" name="released_date" placeholder="separate by comma schema name to skip">
                    <span></span>
                </div>
            </div>
 
            <div class="form-group">
                <label class="control-label">Write Message to notify users</label>
                <div class="col-md-12">
                    <textarea class="form-control textarea_editor" rows="5" name="message"><?= request('message') ?></textarea>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <input type="hidden" name="version" value="V2.1"/>
            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Submit</button>
            <button type="button" class="btn btn-default">Cancel</button>


        </div>
    </form>

</div>
<script src="<?= $root ?>plugins/bower_components/html5-editor/wysihtml5-0.3.0.js"></script>
<script src="<?= $root ?>plugins/bower_components/html5-editor/bootstrap-wysihtml5.js"></script>
<script>
$(document).ready(function () {
$('.textarea_editor').wysihtml5();
            });
    </script>
<script src="<?= $root ?>js/clipboard.min.js"></script>
<script>
var clipboard = new Clipboard('.mycode');

clipboard.on('success', function (e) {
    alert('copied');
});

clipboard.on('error', function (e) {
    alert('error,try again');
});
</script>
@endsection
@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<link rel="stylesheet" href="<?= $root ?>plugins/bower_components/html5-editor/bootstrap-wysihtml5.css" />
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>ShuleSoft User Guide</h4>
                <span>This specify instructions on how to use ShuleSoft system</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Customer Support</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">ShuleSoft Guide</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <code id="mycode"></code>  
                        <?= isset($message_success) ? '<div class="alert alert-info">' . $message_success . '</div>' : '' ?>
                        <form action="" method='post' class="form-horizontal form-bordered">
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
                                    <label class="control-label">Email Subject(optional):</label>
                                    <div class="col-md-12">
                                        <input type="text" value="" class="form-control" name="subject" placeholder="Email subject (optional)">
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
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
<script type="text/javascript">

wywg = function () {
    tinymce.init({
        selector: "textarea",
        //theme: "modern",
        height: 300,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

    });

}

$(document).ready(wywg);
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
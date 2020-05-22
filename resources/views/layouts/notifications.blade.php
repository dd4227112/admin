@if ($errors->any() || Session::get('success') || Session::get('error') || Session::get('warning') || Session::get('info'))
<?php $root = url('/') . '/public/' ?>

<!-- notify js Fremwork -->
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.brighttheme.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.buttons.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.history.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.mobile.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/pnotify/notify.css">

<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.desktop.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.buttons.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.confirm.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.callbacks.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.animate.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.history.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.mobile.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.nonblock.js"></script>
<script type="text/javascript" src="<?= $root ?>assets/pages/pnotify/notify.js"></script>

<script type="text/javascript">

    notify = function (title, message, type) {
        new PNotify({
            title: title,
            text: message,
            type: type,
            hide: 'false',
            icon: 'icofont icofont-info-circle'
        });
    }

</script>
@if ($errors->any())
<script type="text/javascript">notify('Error', 'Please check the form below for errors', 'error');</script>
@endif
@if ($message = Session::get('success'))
<script type="text/javascript">notify('Success', '<?= $message ?>', 'success');</script>
@endif

@if ($message = Session::get('error'))
<script type="text/javascript">notify('Error', '<?= $message ?>', 'error');</script>
@endif

@if ($message = Session::get('warning'))
<script type="text/javascript">notify('Warning', '<?= $message ?>', 'warning');</script>
@endif

@if ($message = Session::get('info'))
<script type="text/javascript">notify('Info', '<?= $message ?>', 'default');</script>
@endif


@endif

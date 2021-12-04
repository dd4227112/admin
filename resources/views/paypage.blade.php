<?php $root = url('/') . '/public/' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>ShuleSoft Admin Panel</title>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Phoenixcoded">
    <meta name="keywords"
        content=", Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="Phoenixcoded">
    <!-- Favicon icon -->

    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

    <!-- Required Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" />

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/icon/icofont/css/icofont.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/style.css?v=2">
    <link rel="stylesheet" href="https://intl-tel-input.com/node_modules/intl-tel-input/examples/css/prism.css">
    <link rel="stylesheet"
        href="https://intl-tel-input.com/node_modules/intl-tel-input/build/css/intlTelInput.css?1613236686837">
    <link rel="stylesheet" href="https://intl-tel-input.com/node_modules/intl-tel-input/examples/css/prism.css">
    <link rel="stylesheet"
        href="https://intl-tel-input.com/node_modules/intl-tel-input/examples/css/isValidNumber.css?1613236686837">

    <link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2.css">
    <link rel="stylesheet" href="<?= $root ?>assets/select2/css/gh-pages.css">
    <script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>

    <link rel="stylesheet" href="<?= $root ?>/files/bower_components/select2/css/select2.min.css">
    <!-- Multi Select css -->
    <script type="text/javascript" src="<?= $root ?>/files/bower_components/select2/js/select2.full.min.js"></script>
    <script src="https://intl-tel-input.com/node_modules/intl-tel-input/examples/js/prism.js"></script>
    <script src="https://intl-tel-input.com/node_modules/intl-tel-input/build/js/intlTelInput.js?1613236686837">
    </script>

</head>

<body class="fix-menu" style="overflow-y:auto; height: auto;">
    <!-- Container-fluid starts -->
    <div class="container-fluid">
        <div class="page-wrapper">
            <div class="page-body">
  
                     
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header ">
                                <h1 class="text-center" style="color: black; font-weight: bold;">
                                    <img src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="logo.png"
                                        width="80" height="80">
                                </h1>
                                <hr>
                                <h4 class="text-center"><b>{{ $event->title }}</b></h4>
                                <br>
                                <h3 class=" box-title" align="center" style="padding-top: 2px">Conglatulations,
                                you have succefully been registered for the Event </h3>
                                <div class="card-body ml-2">
        <hr>                @if (isset($status) && $status==1)
            
                                    <!-- <h4>How to join in Zoom Meeting</h4> -->
                                    <h4>How to join a Zoom meeting on a web browser</h4>
                                    <p>Open Browser ie Chrome.</p>
                                    <ol>
                                        <li> Go to join.zoom.us.</li>
                                        <li>Enter your meeting ID provided by the host/organizer.</li>
                                        <li>Click Join. If this is your first time joining from Google Chrome, you will
                                            be asked to open the Zoom client to join the meeting.</li>
                                        <li>To learn more how to use Zoom Meeting Watch this video >>> <a
                                                href="https://youtu.be/hIkCmbvAHQQ" target="_blank"
                                                rel="noopener noreferrer">https://youtu.be/hIkCmbvAHQQ</a> </li>
                                    </ol>
                                    <hr>

                                    <h4>HOW TO JOIN ZOOM MEETING BY PHONE</h4>
                                    <p>** Open the Zoom mobile app. If you have not downloaded the Zoom mobile app yet,
                                        you can download it from the Google Play Store or App Store.</p>
                                    <p>Join a meeting using one of these methods:</p>
                                    <ol>
                                        <li>Tap Join a Meeting if you want to join without signing in.
                                            Sign in to Zoom then tap Join.</li>
                                        <li>Enter the meeting ID number and your display name.</li>
                                        <li>If you're signed in, change your name if you don't want your default name
                                            to appear. </li>
                                            <li>If you're not signed in, enter a display name. </li>
                                            <li>Select if you would like to connect audio and/or video and tap Join
                                            Meeting.</li>
                                    </ol>
                                    @else
                                        <h4 align="center">This event charges <b> 150,000/-</b> Tsh for Schools that do not use Shulesoft.</b></h4>
                                    <hr>
                                        <h4>How to Pay Event Fee</h4>
                                        <ul>
                                            <li> <b>Account Details :</b></li>
                                            <li> - Account Name: INETS COMPANY LIMITED</li>
                                            <li> - Bank Name: NMB BANK PLC</li>
                                            <li> - Account Number: 22510028669</li>
                                            <li><code>Please notify us after a deposit</code></li>
                                        </ul>
                                        <br>  <br>
                                        <h4>Does ShuleSoft have a free Events?</h4>

                                    <p>
                                    Yes! All school using ShuleSoft system are free to join  all events organized by ShuleSoft — we only charge schools which they don't use our system yet each time we have an event. <br>
                                  <br>  <b>Note:</b> For Schools using ShuleSoft system have free access to our meetings/events organized by ShuleSoft.

                                    </p>
                                    @endif
                                    </div>

                                    <br>
                                    <h3 class="btn btn-primary">For more call/whatsapp: 0655406004</h3>
                                </div>


                                <div class="modal-footer text-center">
                                <h2>
                                            <!-- <a href="{{url('public/files/brochure.jpeg')}}" download target="_blank"
                                                class="btn btn-primary"><i class="fa fa-download"></i>Download Event
                                                Flyer</a> -->
                                            <a href="ShuleSoft.com" class="btn btn-warning"><i
                                                    class="fa fa-link"></i>Close</a>
                                        </h2>
                                </div>
                                <?= csrf_field() ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Authentication card end -->
        </div>
        <!-- end of col-sm-12 -->

</body>

</html>
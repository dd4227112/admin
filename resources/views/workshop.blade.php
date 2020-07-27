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
  <meta name="keywords" content=", Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
  <meta name="author" content="Phoenixcoded">
  <!-- Favicon icon -->
  <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

  <script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>


  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
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
  <style>
  body {
  background-image: url('https://www.google.com/url?sa=i&url=https%3A%2F%2Fblog.shulesoft.com%2Fwe-are-hiring-customer-service-representative%2F&psig=AOvVaw2NmKYK6GxDzNF0XW0u-doz&ust=1595928552348000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCKC01qyP7eoCFQAAAAAdAAAAABAV');
  background-repeat: repeat;
}
</style>
</head>
<body class="fix-menu"   style="overflow: scroll; background-image: url(https://www.google.com/url?sa=i&url=https%3A%2F%2Fblog.shulesoft.com%2Fwe-are-hiring-customer-service-representative%2F&psig=AOvVaw2NmKYK6GxDzNF0XW0u-doz&ust=1595928552348000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCKC01qyP7eoCFQAAAAAdAAAAABAV); background-repeat: repeat; background-color: #cccccc;" >
            <!-- Container-fluid starts -->
            <div class="container-fluid">
                 <div class="page-wrapper">
        <div class="page-body">
          <div class="row">
            <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header ">
                    <h1 class="text-center" style="color: black; font-weight: bold;">
                    <img src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="logo.png" width="80" height="80">
                     </h1>
                    <h4 class="text-center"><b>{{ $event->title }}</b></h4>

                    </div>

                    <div class="card-block text-center">
                          <div class="col-lg-12"  style="color: black;">
                                <div class="col-sm-12">Event Date:&nbsp;&nbsp; {{ $event->event_date }}</div>
                                <div class="col-sm-12">Start - {{ $event->start_time }} &nbsp;&nbsp; - &nbsp;&nbsp; End - {{ $event->end_time }} </div>
                              </div>

                            </div>
                            <a data-toggle="modal" data-target="#large-Modal" class="btn btn-info f-right">Register Here</a>

                          </div>
                        </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card" style="color: black; text-align: left;">
                      <div class="card-header">
                        <h5 class="card-header-text"> About This Workshop</h5>
                        <a href="<?=url('/register')?>" class="btn btn-info btn-sm f-right">Register Here</a>
                      </div>
                      <div class="card-block user-desc"  >
                        <div class="view-desc">
                                <?= $event->note ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Authentication card end -->
          </div>
        </section>
                <div class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="large-Modal">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title text-center">
                          <img src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="small-logo.png" width="30" height="30">
                          School Financial Management Workshop
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <div class="col-lg-12">
                      <img src="<?= url('/storage/uploads/images/' . $event->attach)?>" class="img-responsive" style="width: 100%; height: auto;">
                      </div>
                      </div>
                      <div class="modal-footer">
                        <a href="<?= url('/register')?>" class="btn btn-primary waves-effect waves-light "> Click to Join</a>
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
      </div>
      <!-- end of row -->
    </div>
  </div>
</div>

<!-- Warning Section Ends -->
<!-- Required Jquery -->
<script type="text/javascript" src="<?= $root ?>bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/tether/dist/js/tether.min.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="<?= $root ?>bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>
<!-- modernizr js -->
<script type="text/javascript" src="<?= $root ?>bower_components/modernizr/modernizr.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/modernizr/feature-detects/css-scrollbars.js"></script>
<!-- i18next.min.js -->
<script type="text/javascript" src="<?= $root ?>bower_components/i18next/i18next.min.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/jquery-i18next/jquery-i18next.min.js"></script>
<!-- Custom js -->
<script type="text/javascript" src="<?= $root ?>assets/js/script.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $(".select2").select2({
    dropdownParent: $("#myModal"),
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true,

});

});
        </script>
      </body>
      </html>

<?php $root = url('/') . '/public/' ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ShuleSoft Admin Panel</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="Phoenixcoded">
  <meta name="keywords" content=", Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
  <meta name="author" content="Phoenixcoded">
  <!-- Favicon icon -->

<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>

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
.select2-container--default .select2-selection--single {
    height: 46px !important;
    padding: 10px 16px;
    font-size: 18px;
    line-height: 1.33;
    border-radius: 6px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow b {
    top: 85% !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 26px !important;
}
.select2-container--default .select2-selection--single {
    border: 1px solid #CCC !important;
    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
}
</style>
</head>
<body class="fix-menu"   style=" overflow-y:auto; height: auto;">
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
                    <h4 class="text-center"><b>{{ $title }}</b></h4>

                    </div>
                        <?php dd($questions); ?>
  
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






<?php $root = url('/') . '/public/' ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ShuleSoft - School Management System</title>
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
  <meta name="keywords" content="ShuleSoft - School Management System, Shulesoft System, Shulesoft">
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
<body class="fix-menu">
  <!-- Container-fluid starts -->
  <div class="container-fluid">
    <div class="page-wrapper">
      <div class="page-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header ">
                <h1 class="text-center" style="color: black; font-weight: bold;">
                  <a href="https://www.shulesoft.com/">
                    <img src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="logo.png" width="80" height="80">
                  </a>
                </h1>
                <h4 class="text-center"><b>{{ $profile->name }}</b></h4>
                <?php echo '<h3 class="text-center">Role: '. $profile->role->name .'</h3>'; ?>
                <div class="text-center">
                  <?php
                  $role = DB::table('departments')->where('id', $profile->department)->first();
                  if(sizeof($role)){
                    echo '<h4 class="text-center">Department: '. $role->name .'</h4>';
                  }
                  ?>
                  <h4>Email: <?=$profile->email?></h4>
                  <h4>Phone: <?=$profile->phone?></h4>
                </div>


              </div>

              <div class="col-lg-12 col-xl-12">
                <div class="card-block">
                  <div class="mb-md text-center">
                    <a href="https://www.shulesoft.com/"><b>A Real Solution to </a> Real Problems</b>
                    <h2 class="text-dark my-4">
                      <span class="d-block">ShuleSoft <strong class="font-weight-bold">School Management System</strong></span>
                    </h2>
                    <!-- <p class="lead text-dark">ShuleSoft is an extensible, scalable and easy to use school management system that  simplifies school operations <br>and interconnects parents, teachers, students and other school stakeholders</p> -->
                    <div class="mt-5">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-12 col-xl-12">
          <br>
            <br>
            <br>
            <br>
            <br>
            <div class="row align-items-center justify-content-md-between" style="background-color: #cccc; height: 100px;">
              <div class="col-md-6">
                <div class="copyright text-sm font-weight-bold text-center">
                  &copy; <script>document.write(new Date().getFullYear());</script>  <a href="http://inetstz.com/" class="font-weight-bold text-center" target="_blank">INETS Co Ltd</a>. All rights reserved.
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end of col-sm-12 -->

</body>
</html>

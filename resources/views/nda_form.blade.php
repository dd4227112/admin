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
  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

  <!-- Google font-->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" 
  integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" 
  crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" />
 

<style>
  .ui-datepicker-calendar {
   display: none;
}
.ui-datepicker-month {
   display: none;
}
.ui-datepicker-next,.ui-datepicker-prev {
  display:none;
}

.select2-container--default .select2-selection--single {
    height: 42px !important;
    padding: 10px 16px;
    font-size: 18px;
    line-height: 1.33;
    border-radius: 3px;
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
   <?php  ?>
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

                     <form class="form-group" enctype="multipart/form-data" method="POST" action="<?=url('/sendndaform')?>" >
                      
                          <div class="form-group">
                            <div class="col-sm-12 col-xs-12">
                              <div class="row">
                                <div class="col-md-6">
                                    Download NDA form here
                                    <a href="https://drive.google.com/file/d/1FKvv0xIzaT7Os_5EwCmteXuPsNXbN6wM/view?usp=sharing"  target="_blank" class="badge badge-warning">Download</a>
                                </div>
                                <div class="col-md-6">
                                   Upload form
                                   <input type="file" name="nda_form" class="form-control"  required>
                                </div>
                            </div>
                          </div>
                        </div>

            
                      <div class="modal-footer">
                        <input type="hidden" name="applicant_id"  value="<?=$id?>">
                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Submit Here</button>
                      </div>
                      <?= csrf_field() ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
     
        </div>
     
</body>
</html>










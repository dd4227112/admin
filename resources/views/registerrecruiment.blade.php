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
                    <h4 class="text-center"><b>{{ $title }}</b></h4>

                    </div>

                     <form class="form-group" enctype="multipart/form-data" method="POST" action="<?=url('/addrecruiment')?>" >
                      
                          <div class="form-group">
                            <div class="col-sm-12 col-xs-12">
                              <div class="row">
                                <div class="col-md-4">
                                  Your Fullname
                                 <input type="text" name="fullname" class="form-control" placeholder="Enter your full name here..."  required>
                                </div>
                                <div class="col-md-4">
                                   Email
                                   <input type="email" name="email" class="form-control" placeholder="Enter your email"  required>
                                </div>
                                <div class="col-md-4">
                                   Phone number
                                   <input type="text" name="phone" class="form-control" placeholder="Enter your phone number"  required>
                                </div>
                            </div>
                          </div>
                        </div>

                          <div class="form-group">
                            <div class="col-sm-12 col-xs-12">
                              <div class="row">
                                <div class="col-md-4">
                                  Your country
                                 <select name="country"  class="form-control select2"  required>
                                   <?php
                                   $countries = DB::table('constant.refer_countries')->get();
                                   if (!empty($countries)) { 
                                       foreach ($countries as $country)
                                    { ?>
                                   <
                                   <option
                                       value="<?= $country->id ?>">
                                       <?= $country->country ?>
                                   </option>
                                   <?php
                                       }
                                   }
                                   ?>
                               </select>
                                </div>
                                <div class="col-md-4">
                                   Date of birth
                                   <input type="date" name="dob" class="form-control"  required>
                                </div>
                                <div class="col-md-4">
                                   Gender
                                   <select name="sex" class="form-control" required>
                                      <option value=""></option>
                                      <option value="Male">Male</option>
                                      <option value="Female">Female</option>
                                  </select>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12">
                              <div class="row">

                                <div class="col-md-4">
                                  Current Location
                                 <input type="text" name="location" class="form-control" placeholder="Enter your location"  required>
                                </div>

                                <div class="col-md-4">
                                   Marital status
                                   <select name="marital_status"  class="form-control" required>
                                   <?php
                                   $status = DB::table('constant.marital_status')->get();
                                   if (!empty($status)) { foreach ($status as $type)
                                    
                                    { ?>
                                   <
                                   <option
                                       value="<?= $type->id ?>">
                                       <?= $type->name ?>
                                   </option>
                                   <?php
                                       }
                                   }
                                   ?>
                               </select>
                                </div>

                                <div class="col-md-4">
                                    Education Level
                                   <select name="education_level" class="form-control" required>
                                      <option value=""></option>
                                      <option value="Ordinary Level certificate">Ordinary Level certificate</option>
                                      <option value="Advanced Level certificate">Advanced Level certificate</option>
                                      <option value="Diploma">Diploma</option>
                                      <option value="Bachelor degree">Bachelor degree</option>
                                      <option value="Master's degree">Master's degree</option>
                                      <option value="Ph D">Ph D</option>
                                      <option value="Others">Others</option>
                                  </select>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12">
                              <div class="row">
                                <div class="col-md-4">
                                    Field of study
                                   <select name="field" class="form-control" required>
                                      <option value=""></option>
                                      <option value="Sales">Sales</option>
                                      <option value="Marketing">Marketing</option>
                                      <option value="Education">Education</option>
                                      <option value="Economics">Economics</option>
                                      <option value="Customer care">Customer care</option>
                                      <option value="Public relations">Public relations</option>
                                      <option value="Customer support">Customer support</option>
                                      <option value="Procurement and Logistics">Procurement and Logistics</option>
                                      <option value="Financial services and banking">Financial services and banking</option>
                                      <option value="Finance,Accounting and Commerce">Finance,Accounting and Commerce</option>
                                      <option value="Information and communication technology">Information and communication technology</option>
                                      <option value="Software Engineering">Software Engineering</option>
                                      <option value="Business administration,Business development">Business administration,Business development</option>
                                      <option value="Computer science">Computer science</option>
                                      <option value="Telecommunication Engineering">Telecommunication Engineering</option>
                                      <option value="Human resources">Human resources</option>
                                      <option value="Others">Others</option>
                                  </select>
                                </div>
                                <div class="col-md-4">
                                    Year of graduation
                                   <input type="date" id="date" name="year_of_graduation" class="form-control"  required>
                                </div>
                                <div class="col-md-4">
                                   Which skills you have
                                    <input type="text" name="skills" class="form-control"  required>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12">
                              <div class="row">
                                <div class="col-md-4">
                                    Work Experience
                                   <select name="experience" class="form-control" required>
                                      <option value=""></option>
                                      <option value="Less than a year">Less than a year</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4 </option>
                                      <option value="5">5</option>
                                      <option value="More than 6 years">More than 6 years</option>
                                  </select>
                                </div>
                                <div class="col-md-4">
                                    Job Type
                                  <select name="jobtypes"  required
                                    class="form-control">
                                    <?php
                                    $jobtypes = DB::table('constant.employment_type')->get();
                                    if (!empty($jobtypes)) {
                                        foreach ($jobtypes as $type) {
                                            ?>
                                    <option value=""></option>
                                    <option
                                        value="<?= $type->name ?>">
                                        <?= $type->name ?>
                                    </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                                </div>

                                  <div class="col-md-4">
                                    How did you hear about this ad?
                                    <select name="source" id="source" class="form-control" required>
                                        <option value=""></option>
                                      <option>Website </option>
                                      <option>Friend</option>
                                      <option>Email</option>
                                      <option>Advertisement</option>
                                      <option>LinkedIn</option>
                                      <option>Instagram</option>
                                      <option>Twitter</option>
                                      <option>WhatsApp</option>
                                      <option>Facebook</option>
                                      <option>Others</option>
                                    </select>
                                </div>
                            </div>
                          </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12">
                              <div class="row">
                                <div class="col-md-4">
                                    What do you prefer and expect to do in the future?
                                   <select name="career" class="form-control" required>
                                      <option value=""></option>
                                      <option value="Entrepreneur">Entrepreneur</option>
                                      <option value="Programmer">Programmer</option>
                                      <option value="Sales and Marketing professional">Sales and Marketing professional</option>
                                      <option value="Business Man/Woman">Business Man/Woman</option>
                                      <option value="Expert In IT">Expert In IT</option>
                                      <option value="Professional accounting and Finance officer">Professional accounting and Finance officer</option>
                                      <option value="Professional bank and Economics">Professional bank and Economics</option>
                                      <option value="Software Engineer">Software Engineer</option>
                                      <option value="Analyst">Analyst</option>
                                  </select>
                                </div>
                                <div class="col-md-4">
                                    Scope of Operations 
                                    <select name="scope_of_operation" class="form-control" required>
                                        <option value=""></option>
                                        <option value="Within my district">Within my district</option>
                                        <option value="Within my region">Within my region</option>
                                        <option value="Within my zonal">Within my zonal</option>
                                        <option value="Within my Country">Within my Country</option>
                                        <option value="Within my East Africa">Within  East Africa</option>
                                        <option value="Within  Africa">Within Africa</option>
                                    </select>
                                </div>

                                  <div class="col-md-4">
                                    Do you own computer
                                    <select name="own_computer"  class="form-control" required>
                                      <option value=""></option>
                                      <option>YES </option>
                                      <option>NO</option>
                                    </select>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12">
                              <div class="row">
                                <div class="col-md-4">
                                    Documents (CV,ID and certificates)
                                    <input type="file" name="documents" class="form-control"  required>
                                </div>
                             
                            </div>
                          </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12">
                                  About you
                             <textarea type="text" name="about" class="form-control"  required> </textarea>
                          </div>
                        </div>

                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Submit Here</button>
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


<script type="text/javascript">
   $(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
});

    $(function() {
       $( "#date" ).datepicker({dateFormat: 'yy'});
    });
  </script>



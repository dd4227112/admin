@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<?php
$arr = [];
foreach ($user_permission as $permis) {
    array_push($arr, $permis->id);
}
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title"><?= $user->name ?> Profile </h4>
                <span></span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">User</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <!--profile cover start-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-12 col-xl-4">
                            <div class="card counter-card-1">
                                <div class="card-block-big">
                                    <div class="media-left">
                                        <a href="#" class="profile-image">
                                            <img class="user-img img-circle" src="<?= $root ?>assets/images/user.png" alt="User-Profile-Image">
                                        </a>
                                    </div>
                                    <i class="icofont icofont-comment"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card counter-card-2">
                                <div class="card-block-big">
                                    <div>
                                        <h3>Tsh <?= number_format($user->salary) ?></h3>
                                        <p>Basic Salary
                                            <span class="f-right text-success">
                                                <i class="icofont icofont-arrow-up"></i>
                                                increase every 3 months
                                            </span>
                                        </p>
                                        <div class="progress ">
                                            <div class="progress-bar progress-bar-striped progress-xs progress-bar-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <i class="icofont icofont-coffee-mug"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card counter-card-3">
                                <div class="card-block-big">
                                    <div>
                                        <h3>Tsh 0/=</h3>
                                        <p>This Month Bonus
                                            <span class="f-right text-default">
                                                <i class="icofont icofont-arrow-up"></i>
                                                Based on performance
                                            </span></p>
                                        <div class="progress ">
                                            <div class="progress-bar progress-bar-striped progress-xs progress-bar-default" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <i class="icofont icofont-upload"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--profile cover end-->
            <div class="row">
                <div class="col-lg-12">
                    <!-- tab header start -->
                    <div class="tab-header">
                        <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal Info</a>
                                <div class="slide"></div>
                            </li>
                            <!--                            <li class="nav-item">
                                                            <a class="nav-link" data-toggle="tab" href="#binfo" role="tab">User's Services</a>
                                                            <div class="slide"></div>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-toggle="tab" href="#contacts" role="tab">User's Contacts</a>
                                                            <div class="slide"></div>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-toggle="tab" href="#review" role="tab">Reviews</a>
                                                            <div class="slide"></div>
                                                        </li>-->
                            <?php
                            if ($user->id == 2) {
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#permissions" role="tab">Permissions</a>
                                    <div class="slide"></div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- tab header end -->
                    <!-- tab content start -->
                    <div class="tab-content">
                        <!-- tab panel personal start -->
                        <div class="tab-pane active" id="personal" role="tabpanel">
                            <!-- personal card start -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">About Me</h5>
                                    <?php
                                    if ($user->id == 2) {
                                        ?>
                                        <a id="edit-btn" href="<?= url('users/edit/' . $user->id) ?>" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                            <i class="icofont icofont-edit"></i>
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="card-block">
                                    <div class="view-info">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="general-info">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-xl-6">
                                                            <table class="table m-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">Full Name</th>
                                                                        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Gender</th>
                                                                        <td>{{ $user->sex }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Birth Date</th>
                                                                        <td>October 25th, 1990</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Marital Status</th>
                                                                        <td>{{ $user->marital }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Location</th>
                                                                        <td> {{ $user->town }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- end of table col-lg-6 -->
                                                        <div class="col-lg-12 col-xl-6">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">Email</th>
                                                                        <td><a href="#!">{{ $user->email }}</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Mobile Number</th>
                                                                        <td>{{ $user->phone }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Twitter</th>
                                                                        <td>shulesoft</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Role</th>
                                                                        <td>{{ $user->role->display_name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Skills</th>
                                                                        <td><a href="#!"> {{ $user->skills }}</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-nowrap"></td>
                                                                        <td>                      <a href="<?= url('users/resetPassword/' . $user->id) ?>" class="btn btn-warning btn-sm">Reset Password</a></td>
                                                                    </tr>


                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- end of table col-lg-6 -->
                                                    </div>
                                                    <!-- end of row -->
                                                </div>
                                                <!-- end of general info -->
                                            </div>
                                            <!-- end of col-lg-12 -->
                                        </div>
                                        <!-- end of row -->
                                    </div>
                                    <!-- end of view-info -->
                                    <div class="edit-info" style="display: none;">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="general-info">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"><i class="icofont icofont-user"></i></span>
                                                                                <input type="text" class="form-control" placeholder="Full Name">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-radio">
                                                                                <div class="group-add-on">
                                                                                    <div class="radio radiofill radio-inline">
                                                                                        <label>
                                                                                            <input type="radio" name="radio" checked=""><i class="helper"></i> Male
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="radio radiofill radio-inline">
                                                                                        <label>
                                                                                            <input type="radio" name="radio"><i class="helper"></i> Female
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <input id="dropper-default" class="form-control" type="text" placeholder="Select Your Birth Date">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <select id="hello-single" class="form-control">
                                                                                <option value="">---- Marital Status ----</option>
                                                                                <option value="married">Married</option>
                                                                                <option value="unmarried">Unmarried</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"><i class="icofont icofont-location-pin"></i></span>
                                                                                <input type="text" class="form-control" placeholder="Address">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- end of table col-lg-6 -->
                                                        <div class="col-lg-6">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"><i class="icofont icofont-mobile-phone"></i></span>
                                                                                <input type="text" class="form-control" placeholder="Mobile Number">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"><i class="icofont icofont-social-twitter"></i></span>
                                                                                <input type="text" class="form-control" placeholder="Twitter Id">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon" id="basic-addon1">@</span>
                                                                                <input type="text" class="form-control" placeholder="Twitter Id">
                                                                            </div>
                                                                        </td>
                                                                    </tr> -->
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"><i class="icofont icofont-social-skype"></i></span>
                                                                                <input type="email" class="form-control" placeholder="Skype Id">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"><i class="icofont icofont-earth"></i></span>
                                                                                <input type="text" class="form-control" placeholder="website">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- end of table col-lg-6 -->
                                                    </div>
                                                    <!-- end of row -->
                                                    <div class="text-center">
                                                        <a href="#!" class="btn btn-primary waves-effect waves-light m-r-20">Save</a>
                                                        <a href="#!" id="edit-cancel" class="btn btn-default waves-effect">Cancel</a>
                                                    </div>
                                                </div>
                                                <!-- end of edit info -->
                                            </div>
                                            <!-- end of col-lg-12 -->
                                        </div>
                                        <!-- end of row -->
                                    </div>
                                    <!-- end of edit-info -->
                                    <form class="form-horizontal form-material" method="post" action="<?= url('user/changePhoto/' . $user->id) ?>" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <label class="col-md-12">Photo</label>
                                            <div class="col-md-12">
                                                <input type="file" name="photo" accept=".png,.jpg,.jpeg,.gif" class="form-control form-control-line">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <?= csrf_field() ?>
                                                <button class="btn btn-success">Update Profile</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end of card-block -->
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Description About Me</h5>
                                            <button id="edit-info-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                                <i class="icofont icofont-edit"></i>
                                            </button>
                                        </div>
                                        <div class="card-block user-desc">
                                            <div class="view-desc">
                                                <p><?= $user->about ?></p>
                                            </div>
                                            <div class="edit-desc" style="display: none;">
                                                <div class="col-md-12">
                                                    <textarea id="description" style="visibility: hidden;">                                                            &lt;p&gt;But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?" "On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able To Do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pain.&lt;/p&gt;
                                                    </textarea>
                                                </div>
                                                <div class="text-center">
                                                    <a href="#!" class="btn btn-primary waves-effect waves-light m-r-20 m-t-20">Save</a>
                                                    <a href="#!" id="edit-cancel-btn" class="btn btn-default waves-effect m-t-20">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- personal card end-->
                        </div>
                        <!-- tab pane personal end -->
                        <!-- tab pane info start -->
                        <div class="tab-pane" id="binfo" role="tabpanel">
                            <!-- info card start -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">User Services</h5>
                                </div>
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card b-l-success business-info services m-b-20">
                                                <div class="card-header">
                                                    <div class="service-header">
                                                        <a href="#"><h5 class="card-header-text">Shivani Hero</h5></a>
                                                    </div>
                                                    <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <p class="task-detail">Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.</p>
                                                        </div>
                                                        <!-- end of col-sm-8 -->
                                                    </div>
                                                    <!-- end of row -->
                                                </div>
                                                <!-- end of card-block -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card b-l-danger business-info services">
                                                <div class="card-header">
                                                    <div class="service-header">
                                                        <a href="#"><h5 class="card-header-text">Dress and Sarees</h5></a>
                                                    </div>
                                                    <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <p class="task-detail">Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.</p>
                                                        </div>
                                                        <!-- end of col-sm-8 -->
                                                    </div>
                                                    <!-- end of row -->
                                                </div>
                                                <!-- end of card-block -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card b-l-info business-info services">
                                                <div class="card-header">
                                                    <div class="service-header">
                                                        <a href="#"><h5 class="card-header-text">Shivani Auto Port</h5></a>
                                                    </div>
                                                    <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <p class="task-detail">Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.</p>
                                                        </div>
                                                        <!-- end of col-sm-8 -->
                                                    </div>
                                                    <!-- end of row -->
                                                </div>
                                                <!-- end of card-block -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card b-l-warning business-info services">
                                                <div class="card-header">
                                                    <div class="service-header">
                                                        <a href="#"><h5 class="card-header-text">Hair stylist</h5></a>
                                                    </div>
                                                    <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <p class="task-detail">Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.</p>
                                                        </div>
                                                        <!-- end of col-sm-8 -->
                                                    </div>
                                                    <!-- end of row -->
                                                </div>
                                                <!-- end of card-block -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card b-l-danger business-info services">
                                                <div class="card-header">
                                                    <div class="service-header">
                                                        <a href="#"><h5 class="card-header-text">BMW India</h5></a>
                                                    </div>
                                                    <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <p class="task-detail">Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.</p>
                                                        </div>
                                                        <!-- end of col-sm-8 -->
                                                    </div>
                                                    <!-- end of row -->
                                                </div>
                                                <!-- end of card-block -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card b-l-success business-info services">
                                                <div class="card-header">
                                                    <div class="service-header">
                                                        <a href="#"><h5 class="card-header-text">Shivani Hero</h5></a>
                                                    </div>
                                                    <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <p class="task-detail">Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.</p>
                                                        </div>
                                                        <!-- end of col-sm-8 -->
                                                    </div>
                                                    <!-- end of row -->
                                                </div>
                                                <!-- end of card-block -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Profit</h5>
                                        </div>
                                        <div class="card-block">
                                            <div id="main" style="height: 300px; width: 100%; -webkit-tap-highlight-color: transparent; user-select: none; background-color: rgba(0, 0, 0, 0);" _echarts_instance_="1578858203986"><div style="position: relative; overflow: hidden; width: 100px; height: 300px;"><div data-zr-dom-id="bg" class="zr-element" style="position: absolute; left: 0px; top: 0px; width: 100px; height: 300px; user-select: none;"></div><canvas width="100" height="300" data-zr-dom-id="0" class="zr-element" style="position: absolute; left: 0px; top: 0px; width: 100px; height: 300px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas><canvas width="100" height="300" data-zr-dom-id="1" class="zr-element" style="position: absolute; left: 0px; top: 0px; width: 100px; height: 300px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas><canvas width="100" height="300" data-zr-dom-id="_zrender_hover_" class="zr-element" style="position: absolute; left: 0px; top: 0px; width: 100px; height: 300px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- info card end -->
                        </div>
                        <!-- tab pane info end -->
                        <!-- tab pane contact start -->
                        <div class="tab-pane" id="contacts" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-3">
                                    <!-- user contact card left side start -->
                                    <div class="card">
                                        <div class="card-header contact-user">
                                            <img class="img-circle" src="assets/images/user-profile/contact-user.jpg" alt="contact-user">
                                            <h4>Angelica Ramos</h4>
                                        </div>
                                        <div class="card-block">
                                            <ul class="list-group list-contacts">
                                                <li class="list-group-item active"><a href="#">All Contacts</a></li>
                                                <li class="list-group-item"><a href="#">Recent Contacts</a></li>
                                                <li class="list-group-item"><a href="#">Favourite Contacts</a></li>
                                            </ul>
                                        </div>
                                        <div class="card-block groups-contact">
                                            <h4>Groups</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item justify-content-between">
                                                    Project
                                                    <span class="badge badge-default badge-pill">30</span>
                                                </li>
                                                <li class="list-group-item justify-content-between">
                                                    Notes
                                                    <span class="badge badge-default badge-pill">20</span>
                                                </li>
                                                <li class="list-group-item justify-content-between">
                                                    Activity
                                                    <span class="badge badge-default badge-pill">100</span>
                                                </li>
                                                <li class="list-group-item justify-content-between">
                                                    Schedule
                                                    <span class="badge badge-default badge-pill">50</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Contacts<span class="f-15"> (100)</span></h4>
                                        </div>
                                        <div class="card-block">
                                            <div class="connection-list">
                                                <a href="#"><img class="img-fluid img-circle" src="assets/images/user-profile/follower/f-1.jpg" alt="f-1" data-toggle="tooltip" data-placement="top" data-original-title="Airi Satou">
                                                </a>
                                                <a href="#"><img class="img-fluid img-circle" src="assets/images/user-profile/follower/f-2.jpg" alt="f-2" data-toggle="tooltip" data-placement="top" data-original-title="Angelica Ramos">
                                                </a>
                                                <a href="#"><img class="img-fluid img-circle" src="assets/images/user-profile/follower/f-3.jpg" alt="f-3" data-toggle="tooltip" data-placement="top" data-original-title="Ashton Cox">
                                                </a>
                                                <a href="#"><img class="img-fluid img-circle" src="assets/images/user-profile/follower/f-4.jpg" alt="f-4" data-toggle="tooltip" data-placement="top" data-original-title="Cara Stevens">
                                                </a>
                                                <a href="#"><img class="img-fluid img-circle" src="assets/images/user-profile/follower/f-5.jpg" alt="f-5" data-toggle="tooltip" data-placement="top" data-original-title="Garrett Winters">
                                                </a>
                                                <a href="#"><img class="img-fluid img-circle" src="assets/images/user-profile/follower/f-1.jpg" alt="f-6" data-toggle="tooltip" data-placement="top" data-original-title="Cedric Kelly">
                                                </a>
                                                <a href="#"><img class="img-fluid img-circle" src="assets/images/user-profile/follower/f-3.jpg" alt="f-7" data-toggle="tooltip" data-placement="top" data-original-title="Brielle Williamson">
                                                </a>
                                                <a href="#"><img class="img-fluid img-circle" src="assets/images/user-profile/follower/f-5.jpg" alt="f-8" data-toggle="tooltip" data-placement="top" data-original-title="Jena Gaines">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- user contact card left side end -->
                                </div>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- contact data table card start -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-header-text">Contacts</h5></div>
                                                <div class="card-block contact-details">
                                                    <div class="data_table_main table-responsive dt-responsive">
                                                        <div id="simpletable_wrapper" class="dataTables_wrapper dt-bootstrap4"><div class="row"><div class="col-xs-12 col-sm-12 col-sm-12 col-md-6"><div class="dataTables_length" id="simpletable_length"><label>Show <select name="simpletable_length" aria-controls="simpletable" class="form-control input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-xs-12 col-sm-12 col-md-6"><div id="simpletable_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="simpletable"></label></div></div></div><div class="row"><div class="col-xs-12 col-sm-12"><table id="simpletable" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="simpletable_info">
                                                                        <thead>
                                                                            <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="simpletable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 0px;">Name</th><th class="sorting" tabindex="0" aria-controls="simpletable" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 0px;">Email</th><th class="sorting" tabindex="0" aria-controls="simpletable" rowspan="1" colspan="1" aria-label="Mobileno.: activate to sort column ascending" style="width: 0px;">Mobileno.</th><th class="sorting" tabindex="0" aria-controls="simpletable" rowspan="1" colspan="1" aria-label="Favourite: activate to sort column ascending" style="width: 0px;">Favourite</th><th class="sorting" tabindex="0" aria-controls="simpletable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 0px;">Action</th></tr>
                                                                        </thead>
                                                                        <tbody>



















































                                                                            <tr role="row" class="odd">
                                                                                <td class="sorting_1">Garrett Winters</td>
                                                                                <td>abc123@gmail.com</td>
                                                                                <td>9989988988</td>
                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr><tr role="row" class="even">
                                                                                <td class="sorting_1">Garrett Winters</td>
                                                                                <td>abc123@gmail.com</td>
                                                                                <td>9989988988</td>
                                                                                <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr><tr role="row" class="odd">
                                                                                <td class="sorting_1">Garrett Winters</td>
                                                                                <td>abc123@gmail.com</td>
                                                                                <td>9989988988</td>
                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr><tr role="row" class="even">
                                                                                <td class="sorting_1">Garrett Winters</td>
                                                                                <td>abc123@gmail.com</td>
                                                                                <td>9989988988</td>
                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr><tr role="row" class="odd">
                                                                                <td class="sorting_1">Garrett Winters</td>
                                                                                <td>abc123@gmail.com</td>
                                                                                <td>9989988988</td>
                                                                                <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr><tr role="row" class="even">
                                                                                <td class="sorting_1">Garrett Winters</td>
                                                                                <td>abc123@gmail.com</td>
                                                                                <td>9989988988</td>
                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr><tr role="row" class="odd">
                                                                                <td class="sorting_1">Garrett Winters</td>
                                                                                <td>abc123@gmail.com</td>
                                                                                <td>9989988988</td>
                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr><tr role="row" class="even">
                                                                                <td class="sorting_1">Garrett Winters</td>
                                                                                <td>abc123@gmail.com</td>
                                                                                <td>9989988988</td>
                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr><tr role="row" class="odd">
                                                                                <td class="sorting_1">Garrett Winters</td>
                                                                                <td>abc123@gmail.com</td>
                                                                                <td>9989988988</td>
                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr><tr role="row" class="even">
                                                                                <td class="sorting_1">Garrett Winters</td>
                                                                                <td>abc123@gmail.com</td>
                                                                                <td>9989988988</td>
                                                                                <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr></tbody>
                                                                        <tfoot>
                                                                            <tr><th rowspan="1" colspan="1">Name</th><th rowspan="1" colspan="1">Email</th><th rowspan="1" colspan="1">Mobileno.</th><th rowspan="1" colspan="1">Favourite</th><th rowspan="1" colspan="1">Action</th></tr>
                                                                        </tfoot>
                                                                    </table></div></div><div class="row"><div class="col-xs-12 col-sm-12 col-md-5"><div class="dataTables_info" id="simpletable_info" role="status" aria-live="polite">Showing 1 to 10 of 51 entries</div></div><div class="col-xs-12 col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="simpletable_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="simpletable_previous"><a href="#" aria-controls="simpletable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="simpletable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="simpletable" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="simpletable" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="simpletable" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="simpletable" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="simpletable" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="simpletable_next"><a href="#" aria-controls="simpletable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- contact data table card end -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- tab pane contact end -->
                        <div class="tab-pane" id="review" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Review</h5>
                                </div>
                                <div class="card-block">
                                    <ul class="media-list">
                                        <li class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img class="media-object img-circle comment-img" src="assets/images/avatar-1.png" alt="Generic placeholder image">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Sortino media<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                <div class="stars-example-css review-star">
                                                    <i class="icofont icofont-star"></i>
                                                    <i class="icofont icofont-star"></i>
                                                    <i class="icofont icofont-star"></i>
                                                    <i class="icofont icofont-star"></i>
                                                    <i class="icofont icofont-star"></i>
                                                </div>
                                                <p class="m-b-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                <div class="m-b-25">
                                                    <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                </div>
                                                <hr>
                                                <!-- Nested media object -->
                                                <div class="media mt-2">
                                                    <a class="media-left" href="#">
                                                        <img class="media-object img-circle comment-img" src="assets/images/avatar-2.png" alt="Generic placeholder image">
                                                    </a>
                                                    <div class="media-body">
                                                        <h6 class="media-heading">Larry heading <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                        <div class="stars-example-css review-star">
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                        </div>
                                                        <p class="m-b-0"> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                        <div class="m-b-25">
                                                            <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                        </div>
                                                        <hr>
                                                        <!-- Nested media object -->
                                                        <div class="media mt-2">
                                                            <div class="media-left">
                                                                <a href="#">
                                                                    <img class="media-object img-circle comment-img" src="assets/images/avatar-3.png" alt="Generic placeholder image">
                                                                </a>
                                                            </div>
                                                            <div class="media-body">
                                                                <h6 class="media-heading">Colleen Hurst <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                <div class="stars-example-css review-star">
                                                                    <i class="icofont icofont-star"></i>
                                                                    <i class="icofont icofont-star"></i>
                                                                    <i class="icofont icofont-star"></i>
                                                                    <i class="icofont icofont-star"></i>
                                                                    <i class="icofont icofont-star"></i>
                                                                </div>
                                                                <p class="m-b-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                                <div class="m-b-25">
                                                                    <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Nested media object -->
                                                <div class="media mt-2">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object img-circle comment-img" src="assets/images/avatar-1.png" alt="Generic placeholder image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="media-heading">Cedric Kelly<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                        <div class="stars-example-css review-star">
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                        </div>
                                                        <p class="m-b-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                        <div class="m-b-25">
                                                            <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="media mt-2">
                                                    <a class="media-left" href="#">
                                                        <img class="media-object img-circle comment-img" src="assets/images/avatar-4.png" alt="Generic placeholder image">
                                                    </a>
                                                    <div class="media-body">
                                                        <h6 class="media-heading">Larry heading <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                        <div class="stars-example-css review-star">
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                        </div>
                                                        <p class="m-b-0"> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                        <div class="m-b-25">
                                                            <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                        </div>
                                                        <hr>
                                                        <!-- Nested media object -->
                                                        <div class="media mt-2">
                                                            <div class="media-left">
                                                                <a href="#">
                                                                    <img class="media-object img-circle comment-img" src="assets/images/avatar-3.png" alt="Generic placeholder image">
                                                                </a>
                                                            </div>
                                                            <div class="media-body">
                                                                <h6 class="media-heading">Colleen Hurst <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                <div class="stars-example-css review-star">
                                                                    <i class="icofont icofont-star"></i>
                                                                    <i class="icofont icofont-star"></i>
                                                                    <i class="icofont icofont-star"></i>
                                                                    <i class="icofont icofont-star"></i>
                                                                    <i class="icofont icofont-star"></i>
                                                                </div>
                                                                <p class="m-b-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                                <div class="m-b-25">
                                                                    <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="media mt-2">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object img-circle comment-img" src="assets/images/avatar-2.png" alt="Generic placeholder image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="media-heading">Mark Doe<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                        <div class="stars-example-css review-star">
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                            <i class="icofont icofont-star"></i>
                                                        </div>
                                                        <p class="m-b-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                        <div class="m-b-25">
                                                            <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="md-float-material d-flex">
                                        <div class="md-group-add-on p-relative col-lg-12">
                                            <div class="input-group input-group-button input-group-primary">
                                                <span class="input-group-addon"><i class="icofont icofont-comment"></i></span>
                                                <input type="text" class="form-control" placeholder="Write Comment">
                                                <span class="input-group-addon">
                                                    <button class="btn btn-primary"><i class="icofont icofont-plus"></i>Add Comment</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="permissions" role="tabpanel" aria-expanded="false">
                            <div class="email-card p-0">
                                <div class="card-block">
                                    <h6>
                                        <b>Permissions</b>
                                    </h6>
                                    <div class="mail-body-content">
                                        <table class="table table-responsive">
                                            <tbody>

                                                <?php
                                                $permissions = \App\Models\Permission::all();
                                                foreach ($permissions as $permission) {
                                                    ?>
                                                    <?php
                                                    $checked = in_array($permission->id, $arr) ? 'checked' : '';
                                                    ?>
                                                    <tr class="read">
                                                        <td>
                                                            <div class="check-star">
                                                                <div class="checkbox-fade fade-in-primary checkbox">
                                                                    <label>
                                                                        <input type="checkbox" class="permission" value="<?= $permission->id ?>" <?= $checked ?>>
                                                                        <span class="cr"><i class="cr-icon icofont icofont-verification-check txt-primary"></i></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><a href="#!" class="email-name"><?= $permission->display_name ?></a></td>
                                                        <td><?= $permission->description ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- tab content end -->
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    permission = function () {
        $('.permission').click(function () {
            var id = $(this).val();
            var role_id = '<?= $user->role_id ?>';
            if (parseInt(id)) {
                if (!this.checked) {
                    // It is not checked, show your div...
                    var url_obj = "<?= url('Users/removePermission') ?>";
                } else {
                    var url_obj = "<?= url('Users/addPermission') ?>";
                }
                $.ajax({
                    type: 'POST',
                    url: url_obj,
                    data: {"id": id, role_id: role_id},
                    dataType: "html",
                    success: function (data) {
                        toast(data);
                    }
                });
            }
        });
    }
    $(document).ready(permission);
</script>
@endsection
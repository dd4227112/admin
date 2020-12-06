
<?php $root = url('/') . '/public/' ?>
@extends('layouts.app_no_session')
@section('content')
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
                                            <img class="user-img img-circle" src="<?= preg_match('/http/', $user->photo) ? $user->photo : $root . 'assets/images/user.png' ?>" alt="User-Profile-Image" height="90">
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
                                        <h3> <?= number_format($user->salary) ?></h3>
                                        <p>Total Tasks
                                            <span class="f-right text-success">
                                                <i class="icofont icofont-arrow-up"></i>
                                                Performed on Schools
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
                                        <h3> 5</h3>
                                        <p>Avarage Ratings
                                            <span class="f-right text-default">
                                                <i class="icofont icofont-arrow-up"></i>
                                                Based on Tasks
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
            <div class="row ">
                <div class="col-lg-12 col-xl-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs md-tabs tabs-left b-none" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home5" role="tab" aria-expanded="true">Personal Info</a>
                            <div class="slide"></div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#messages5" role="tab" aria-expanded="false">Activities</a>
                            <div class="slide"></div>
                        </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabs-left-content card-block" style="width:100%; padding-top: 0; padding-right: 0;">
                        <div class="tab-pane active" id="home5" role="tabpanel" aria-expanded="true">
                            <!-- personal card start -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">About</h5>

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
                                                                        <td>{{ $user->date_of_birth }}</td>
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
                                                                        <td><a href="#!">{{ $user->email }}</a>, <a href="#!">{{ $user->personal_email }}</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Mobile Number</th>
                                                                        <td>{{ $user->phone }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">National ID</th>
                                                                        <td>{{ $user->national_id }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Role</th>
                                                                        <td>{{ $user->role_id }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Employment Category</th>
                                                                        <td> <?php echo ucfirst($user->employment_category); ?></td>
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

                                </div>
                                <!-- end of card-block -->
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Description About <?= $user->name() ?></h5>

                                        </div>
                                        <div class="card-block user-desc">
                                            <div class="view-desc">
                                                <p><?= $user->about ?></p>
                                                <hr />
                                                <b>Skills: <?php echo $user->skills; ?></b>
                                            </div>
                                            <div class="edit-desc" style="display: none;">
                                                <div class="col-md-12">
                                                    <textarea id="description" style="visibility: hidden;">&lt;p&gt;But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?" "On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able To Do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pain.&lt;/p&gt;
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
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Job Application Details</h5>

                                        </div>
                                        <div class="card-block user-desc">
                                            <?php
                                            $except = array('id', 'updated_at');
                                            $applicant = (int) $user->applicant_id > 0 ? DB::table('applicants')->where('id', $user->applicant_id)->first() : [];
                                            if ($applicant) {
                                                $vars = get_object_vars($applicant);
                                                ?>
                                                <div class="view-desc">
                                                    <table class="table">
                                                        <?php
                                                        foreach ($vars as $key => $value) {
                                                            if (!in_array($key, $except)) {
                                                                ?> 
                                                                <tr>
                                                                    <td><?= ucwords(str_replace('_', ' ', $key)) ?></td>
                                                                    <td>
                                                                        <?php
                                                                        $content = $applicant->{$key};
                                                                        if (preg_match('/https/', $content)) {
                                                                            echo '<a href="' . $content . '" target="_blank">' . $content . '</a>';
                                                                        } else if (preg_match('/-/', $content)) {
                                                                            $pieces = explode('-', $content);
                                                                            foreach ($pieces as $piece) {
                                                                                echo $piece . '<br/>';
                                                                            }
                                                                        } else {
                                                                            echo $content;
                                                                        }
                                                                        ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </table>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="messages5" role="tabpanel" aria-expanded="false">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Activities</h5>
                                </div>
                                <div class="card-block">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Training</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>   </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    search_report = function () {
        $('#search_report').mousedown(function () {
            var from = $('#from').val();
            var to = $('#to').val();
            $.ajax({
                type: 'POST',
                url: "<?= url('users/report') ?>",
                data: {
                    "from": from,
                    to: to,
                    user_id: <?= $user->id ?>
                },
                dataType: "html",
                success: function (data) {
                    $('#report_section').html(data);
                }
            });
        })
    };
    $(document).ready(search_report);
</script>
@endsection
@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>


<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Applicant profile</h4>
                <span></span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Applicant</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
     
            <!--profile cover end-->
            <div class="row ">
                <div class="col-lg-12 col-xl-12">
           
                    <div class="tab-content tabs-left-content card-block" style="width:100%; padding-top: 0; padding-right: 0;">
                        <div class="tab-pane active" role="tabpanel" aria-expanded="true">
                            <!-- personal card start -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text"><?= $applicant->fullname ?> </h5>
                                </div>
                                <?php if($applicant->status == '') { ?>
                                 <div class="card-header">
                                 <div class="row float-right"> 
                                    <a href="<?= url('Applicants/rejectapplicant/'.$applicant->id)?>" class="btn btn-sm btn-danger mr-4">
                                       REJECT
                                    </a>
                                    <a  href="<?= url('Applicants/acceptapplicant/'.$applicant->id)?>" class="btn btn-sm btn-primary ">
                                      ACCEPT
                                    </a>
                                </div>
                              </div>
                              <?php } ?>

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
                                                                        <td>{{ $applicant->fullname }} </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Gender</th>
                                                                        <td>{{ $applicant->sex }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Birth Date</th>
                                                                        <td>{{ $applicant->dob }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Marital Status</th>
                                                                        <?php $status = DB::table('constant.marital_status')->where('id',$applicant->marital_status)->first()->name; ?>
                                                                        <td>{{ $status }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Location</th>
                                                                        <td> {{ $applicant->location }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Experience</th>
                                                                        <td> {{ $applicant->experience }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Job type</th>
                                                                        <td> {{ $applicant->jobtypes }}</td>
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
                                                                        <td><a href="#!">{{ $applicant->email }}</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Mobile Number</th>
                                                                        <td>{{ $applicant->phone }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Education</th>
                                                                        <td>{{ $applicant->education_level }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Field</th>
                                                                        <td>{{ $applicant->field}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Year of Graduation</th>
                                                                        <td> <?= $applicant->year_of_graduation ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Scope of operation</th>
                                                                        <td><?= $applicant->scope_of_operation ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Score</th>
                                                                        <td><?= $applicant->score ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
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
                                                    <h5 class="card-header-text">Description About Me</h5>
                                                </div>
                                                <div class="card-block user-desc">
                                                    <div class="view-desc">
                                                        <p style="font-size: 18px"><?= $applicant->about ?></p>
                                                        <hr />
                                                        <h5>Skills: <?php echo $applicant->skills; ?></h5>
                                                    </div>
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
@endsection
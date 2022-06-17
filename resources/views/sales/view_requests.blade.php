@extends('layouts.app')
@section('content')

    <div class="page-header">
            <div class="page-header-title">
                <h4>Websites school request</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">sales</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">schools</a>
                    </li>
                </ul>
            </div>
        </div> 


          <div class="tab-content">
            <div class="tab-pane active" id="personal" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">About School </h5>
                    </div>

                    <div class="card-block">
                        <div class="view-info">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="general-info">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-6">
                                                <div class="table-responsive">
                                                    <table class="table m-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">School Name</th>
                                                                <td> <?= $school->school_name ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Registration number</th>
                                                                <td> <?= $school->school_registration_number ?? '' ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Contact name</th>
                                                                <td><?= $school->contact_name ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">School ownership</th>
                                                                <td><?= $school->school->ownership ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Number of students</th>
                                                                <td><?= $school->school->students ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-6">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Address</th>
                                                                <td><?=$school->school_address?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Mobile Number</th>
                                                                <td><?= $school->contact_phone ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Email</th>
                                                                <td><?= $school->contact_email ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Date</th>
                                                                <td><?= date('d-m-Y',strtotime($school->created_at)) ?></td>
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

                    <div class="card-block">
                        <div class="view-info">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="general-info">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-6">
                                                <div class="table-responsive">
                                                    <table class="table m-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Last activity</th>
                                                                <td>
                                                                 <?php 
                                                                    $task = \App\Models\Task::whereIn('id', \App\Models\TaskSchool::where('school_id', $school->id)->get(['task_id']))->latest('created_at')->first();
                                                                     echo   $task ? warp($task->activity,60) : '';
                                                                  ?>
                                                              </td>
                                                            </tr>

                                                             <tr>
                                                               <th scope="row">Last comment</th>
                                                                <?php 
                                                                   $comments = $task ?  $task->taskComments()->latest('created_at')->first() : '';
                                                                ?>
                                                               <td><?= isset($comments->content) ? warp($comments->content,10) : '' ?></td>
                                                            </tr>
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-6">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Last ShuleSoft contact</th>
                                                                <td><?= $task ? $task->user->name : ''?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">School sales Profile</th>
                                                                <td>
                                                              <?php  echo '<a target="_blank" href="'.url('sales/profile/'. $school->school_id).'" class="btn btn-primary btn-sm btn-round" id="onboard_school">view</a>'; ?>
                                                                    
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
                </div>
            </div>
        </div>

@endsection
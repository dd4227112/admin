@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Shulesoft Meeting Minutes</h4>
        <span>The Part holds all written record of everything that's happened during a meeting.</span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Company Minutes</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">minutes</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">
          <!-- tab panel personal start -->
          <div class="tab-pane active" id="personal" role="tabpanel">
            <!-- personal card start -->
            <div class="card">
              <div class="card-header">
                <h5 class="card-header-text">Title: {{ $minute->title }}</h5>
              </div>
              <div class="card-block">
                <div class="view-info">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="general-info">
                        <div class="row">
                          <div class="col-lg-12 col-xl-12">
                            <table class="table m-0">
                              <tbody>
                                <tr>
                                  <th scope="row">Date</th>
                                    <td>{{ $minute->date }}</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">Start Time</th>
                                      <td><?=$minute->start_time?></td>
                                      </tr>
                                      <tr>
                                      <th style="border-left: 1px solid grey;"> End Time</td>
                                        <td> <?=$minute->end_time?></td>
                                      </tr>
                                      <tr>
                                        <th scope="row">Department</th>
                                        <td> <?=$minute->department->name?></td>
                                      </tr>
                                      <tr>
                                      <th>Attendee's</th>
                                      <td>
                                      <?php
                                      $users = $minute->minuteuser()->get();
                                        if (count($users) > 0) {
                                          foreach ($users as $user) {
                                             echo '<u>'.$user->user->name.'</u>'; ?>  &nbsp;|
                                              <?php
                                          }
                                        }else{
                                            echo "Meeting Attendee no Added.";
                                        }
                                        ?>
                                      </td>
                                      <tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                              <!-- end of row -->
                            </div>
                            <!-- end of general info -->
                          </div>
                          <!-- end of col-lg-12 -->
                        </div>
                        <!-- end of row -->
                      </div>

                      <!-- end of card-block -->
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="card">
                          <div class="card-header">
                            <h5 class="card-header-text">Description of this Meeting</h5>
                            <a href="<?= url('/storage/uploads/images/' . $minute->attached)?>" class="btn btn-info  f-right"> <i class="icofont icofont-cloud"></i> Document</a>
                          </div>
                          <div class="card-block user-desc">
                            <div class="view-desc">
                              <p><?= $minute->note ?></p>
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
        <!-- personal card end-->
      </div>

      @endsection

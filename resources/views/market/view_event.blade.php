@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Shulesoft Workshop Event Post</h4>
        <span> Event Date <u><?=$event->event_date?> </u></span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Workshop Post</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">posts</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <?php
    $medias = \App\Models\EventAttendee::where('event_id', $event->id)->get();
    ?>
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">
          <!-- tab panel personal start -->
          <div class="tab-pane active" id="personal" role="tabpanel">
            <!-- personal card start -->
            <div class="card">
              <div class="card-header">
                <h5 class="card-header-text">Title: {{ $event->title }}</h5>
                <table class="table m-0">
                  <tbody>
                    <tr>
                      <th scope="row">Event Date</th>
                      <th>Start Time</th>
                      <th> End Time</td>
                        <th> Registers</td>
                        </tr>
                        <tr>
                          <td><?=ucfirst($event->event_date)?></td>
                          <td><?=$event->start_time?></td>
                          <td><?=$event->end_time?></td>
                          <td>Total - <?=count($medias)?></td>
                          <tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="card-block">
                        <div class="view-info">

                          <h4 class="card-header-text">Social Media Engagement</h4>
                            <a data-toggle="modal" data-target="#large-Modal" class="btn btn-success btn-sm  f-right"> <i class="icofont icofont-picture"></i> View Poster </a>
                          </div>
                          <div class="card-block user-desc">

                            <div class="col-lg-12 col-xl-12">
                              <table class="table m-0">
                                <tr>
                                  <thead>
                                    <th>Icon </th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>School Name</th>
                                    <th>phone</th>
                                    <th>Email</th>
                                    <th>Source</th>
                                    <!-- <th>Joined At</th> -->
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php if (count($medias) > 0) {
                                    $i = 1;
                                    foreach ($medias as $media) {
                                      ?>
                                      <tr>
                                        <td><strong> <i class="ti-user"> </i> </strong></td>
                                        <td><?=$media->name?></td>
                                        <td><?=$media->position?></td>
                                        <td><?=$media->school->name?> - <?=$media->school->region?></td>
                                        <td><?=$media->phone?></td>
                                        <td><?=$media->email?></td>
                                        <td><?=$media->source?></td>
                                        <!-- <td><?=$media->created_at?></td> -->
                                      </tr>
                                    <?php } } ?>
                                  </tbody>
                                </table>
                              </div>

                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="card">
                                    <div class="card-header">
                                      <h5 class="card-header-text">More About this Event</h5>
                                    </div>
                                    <div class="card-block user-desc">
                                      <div class="view-desc">
                                        <?= $event->note ?>
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
              <div class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="large-Modal">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title text-center">
                        <img src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="small-logo.png" width="30" height="30">
                        <?=$event->title?>
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
        <script type="text/javascript">

        $(".mark").blur(function (event) {

          var inputs = $(this).text();
          var socialmedia_id = $(this).attr('socialmedia_id');
          var post_id = $(this).attr('post_id');
          var type_id = $(this).attr('type_id');

          if (inputs == null) {

          } else if (inputs >= 0) {
            $.ajax({
              type: 'POST',
              url: "<?= url('Marketing/socialMediaUpdate') ?>",
              data: {
                "type_id": type_id,
                "socialmedia_id": socialmedia_id,
                "post_id": post_id,
                "inputs": inputs
              },
              dataType: "html ",
              success: function (data) {
                toast(data);
              }
            });
          } else {
            swal('Error', 'Mark cannot be greater than 100, please enter it correctly');
          }

        });
      </script>
      @endsection

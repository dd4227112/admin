@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>


  
     
      <div class="page-header">
            <div class="page-header-title">
                <h4><?=' View event' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">new events</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
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
                          <td>Total - <?=sizeof($medias)?></td>
                          <tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="card-block">
                        
                          <h4 class="card-header-text">Event Registered Attendees</h4>
                            <?php if(can_access('send_message'))  { ?>
                            <a data-toggle="modal" data-target="#sendMessage" class="btn btn-primary btn-mini btn-round float-right">  Send Message </a>
                          <?php } ?>
                          </div>

                          <div class="card-block">
                            <div class="col-lg-12 col-xl-12">
                            <div class="table-responsive">
                                  <table class="table table-bordered dataTable">
                                    <thead>
                                    <tr>
                                    <th># </th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>School Name</th>
                                    <th>phone</th>
                                    <th>Email</th>
                                    <th>Source</th>
                                   <th>Joined At</th> 
                                   <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php if (sizeof($medias) > 0) {
                                    $i = 1;
                                    foreach ($medias as $media) {
                                      $school = (int)($media->school_id) > 0 ? $media->school->name : $media->school_id;
                                      ?>
                                      <tr>
                                        <td><strong> <?= $i ?></strong></td>
                                        <td><?=$media->name?></td>
                                        <td><?=$media->position?></td>
                                        <td> <?=$school?></td>
                                        <td><?=$media->phone?></td>
                                        <td><?=$media->email?></td>
                                        <td><?=$media->source?></td>
                                        <td><?=$media->created_at?></td> 
                                        <td> <a class="btn btn-danger btn-sm" href="{{ url('workshop/deleteUser/'.$media->id) }}">Delete</a></td>
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
                                      <a data-toggle="modal" data-target="#large-Modal" class="btn btn-success btn-sm  f-right"> <i class="icofont icofont-picture"></i> View Poster </a>

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
              <div class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="sendMessage">
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
                    <form action="" method="POST">
                    <div class="modal-body">
                    
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                  <input type="hidden" class="form-control" value="<?=$event->id?>" name="event">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <strong>Add Details About This Message:</strong>
                    <textarea name="message" rows="5" id="content_part" placeholder="Write More details Here .." class="form-control"> </textarea>
                  </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                        <strong>  Select Mode of this Message Below.</strong> 
                          <hr>
                   
                          &nbsp;  &nbsp; &nbsp;<input type="checkbox" name="sms" value='1'>  Send SMS  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;
                      <input type="checkbox" name="email" value="1" >  Send Email 

                    </div>
                </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light "> <i class="ti-comments"> </i> Send</button>
                    </div>
                    <?= csrf_field() ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
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
                        <img src="<?=!empty($event->attach_id) && isset($event->attach->path)? $event->attach->path : '' ?>" class="img-responsive" style="width: 100%; height: auto;">
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

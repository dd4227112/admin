@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
      <h4>Shulesoft Social Media Posts</h4>
      <span> Social Media Post of <u><?=$post->created_at?> </u></span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Company Post</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">posts</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <?php
                $medias = \App\Models\SocialMediaPost::where('post_id', $post->id)->get();
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
                <h5 class="card-header-text">Title: {{ $post->title }}</h5>
                <table class="table m-0">
                              <tbody>
                                <tr>
                                  <th scope="row">Category</th>
                                      <th>Type</th>
                                      <th> Staff</td>
                                      <th>Social Media Account</th>
                                     </tr>
                                     <tr>
                                     <th>{{ $post->category }}</th>
                                     <th><?=ucfirst($post->type)?></th>
                                     <th> <?=$post->user->name?></th>
                                      <th>
                                      <?php
                                        if (count($medias) > 0) {
                                          foreach ($medias as $media) {
                                             echo '<u>'.$media->media->name.'</u>'; ?>  &nbsp;|
                                              <?php
                                          }
                                        }else{
                                            echo "Social Media not Defined.";
                                        }
                                        ?>
                                      </th>
                                      <tr>
                                    </tbody>
                                  </table>
              </div>
              <div class="card-block">
                <div class="view-info">
                
                          <h5 class="card-header-text">Social Media Engagement</h4>
                          <a href="<?= url('/Marketing/socialMedia/show/' . $post->id.'/0')?>" class="btn btn-info  f-right"> <i class="icofont icofont-edit"></i> Update </a>
                          </div>
                          <div class="card-block user-desc">
                          
                          <div class="col-lg-12 col-xl-12">
                            <table class="table m-0">
                            <tr>
                        <thead>
                          <th>Icon </th>
                          <th>Source</th>
                          <th>Views</th>
                          <th>Likes</th>
                          <th>Comment</th>
                          <th>Shares</th>
                          <th>Reach</th>
                          <th>Last Update</th>
                          </tr>
                          </thead>
                          <tbody>
                             <?php if (count($medias) > 0) { 
                               $i = 1;
                                foreach ($medias as $media) {
                              ?>
                                <tr>
                                <td><strong> <i class="<?=$media->media->icon?>"> </i> </strong></td>
                                <td><?=$media->media->name?></td>
                                <td>
                                <span type="number" value="" <?=$published==0 ? 'contenteditable="true"':''?>  class="form-control mark" socialmedia_id="<?= $media->socialmedia_id ?>" post_id="<?= $post->id ?>" type_id="views" data-title="" >
                                <?=$media->views?>
                                </span>  
                                <span id="<?= $media->socialmedia_id . $post->id ?>views"></span>
                                </td>
                                <td>
                                <span type="number" value="" <?=$published==0 ? 'contenteditable="true"':''?>  class="form-control mark" socialmedia_id="<?= $media->socialmedia_id ?>" post_id="<?= $post->id ?>" type_id="likes" data-title="" >
                                <?=$media->likes?>
                                <span id="<?= $media->socialmedia_id . $post->id ?>likes"></span>
                                </td>
                                <td>
                                <span type="number" value="" <?=$published==0 ? 'contenteditable="true"':''?>  class="form-control mark" socialmedia_id="<?= $media->socialmedia_id ?>" post_id="<?= $post->id ?>" type_id="comments" data-title="" >
                                <?=$media->comments?>
                                <span id="<?= $media->socialmedia_id . $post->id ?>comments"></span>
                                </td>
                                <td>
                                <span type="number" value="" <?=$published==0 ? 'contenteditable="true"':''?>  class="form-control mark" socialmedia_id="<?= $media->socialmedia_id ?>" post_id="<?= $post->id ?>" type_id="share" data-title="" >
                                <?=$media->share?>
                                <span id="<?= $media->socialmedia_id . $post->id ?>share"></span>
                                </td>
                                <td>
                                <span type="number" value="" <?=$published==0 ? 'contenteditable="true"':''?>  class="form-control mark" socialmedia_id="<?= $media->socialmedia_id ?>" post_id="<?= $post->id ?>" type_id="reach" data-title="" >
                                <?=$media->reach?>
                                <span id="<?= $media->socialmedia_id . $post->id ?>reach"></span>
                                </td>
                                <td><?=$media->updated_at=='' ? $media->created_at : $media->updated_at?></td>
                                </tr>
                              <?php } } ?>
                              </tbody>
                              </table>
                          </div>

                    <div class="row">
                      <div class="col-lg-12">
                        <div class="card">
                          <div class="card-header">
                            <h5 class="card-header-text">More About this Post</h5>
                          </div>
                          <div class="card-block user-desc">
                            <div class="view-desc">
                              <p><?= $post->note ?></p>
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
                  $(inputs).html(data);
                }
            });
        } else {
            swal('Error', 'Mark cannot be greater than 100, please enter it correctly');
        }

    });
</script>
      @endsection

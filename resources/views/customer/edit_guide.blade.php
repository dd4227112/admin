@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<link rel="stylesheet" href="<?= $root ?>plugins/bower_components/html5-editor/bootstrap-wysihtml5.css" />

<div class="main-body">
    <div class="page-wrapper">
       <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Guide</h5>
                            <span></span>
                           

                        </div>

                        <div class="card-block">


<div class="modal-content">
    <div class="modal-header">
       
    </div>
    <form method="post" action="<?= url('customer/guide/edit/'.$guide->id) ?>">
        <div class="modal-body" id="message_result">

            <div class="form-group">
                <label for="recipient-name" class="control-label">Main Module:</label>
                <select class="form-control" id="permission_group">
                    <option value=""></option>
                    <?php
                    $permission_groups = \DB::table('constant.permission_group')->get();
                    foreach ($permission_groups as $group) {
                        ?>
                        <option value="<?= $group->id ?>" <?= $guide->permission->permissionGroup->id == $group->id ? 'selected' : '' ?>><?= $group->name ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="recipient-name" class="control-label">Content For :</label>
                <span id="content_for">
                    <?php
                    $permissions = \DB::table('constant.permission')->where('permission_group_id', $guide->permission->permissionGroup->id)->get();
                    foreach ($permissions as $value) { ?>
                       <input type="radio" name="permission_id" value="<?= $value->id ?>" <?= $guide->permission_id == $value->id ? 'checked' : '' ?>/><?=$value->display_name;?>
             <?php       }
                    ?>
                </span> </div>
            <div class="form-group">
                <label for="message-text" class="control-label">Content:</label>
                <textarea class="form-control" id="message-text1" id="mymce" name="content"><?= $guide->content ?></textarea>
            </div>

            <div ></div>
        </div>
        <div class="modal-footer">
            <input type="hidden" value="1" name="is_edit">
            <input type="hidden" value="<?=$guide->id?>" name="guide_id">
            <button type="submit" class="btn btn-primary" id="add_faq">Submit</button>
        </div>
        <?= csrf_field() ?>
    </form>
</div>
                        </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

<!-- This Page JS -->
<!--<script src="<?= $root ?>plugins/bower_components/tinymce/tinymce.min.js"></script>-->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5.4.2-90/tinymce.min.js"></script>
 <!--<script>tinymce.init({ selector:'textarea' });</script>-->
<script type="text/javascript">

    wywg = function () {

        tinymce.init({
            selector: "textarea",
            //theme: "modern",
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                     images_upload_url: '<?=url('upload.php')?>',
  //images_upload_credentials: true,
  images_upload_base_path: '/storage/images/',
  images_upload_handler: function (blobInfo, success, failure, progress) {
    var xhr, formData;

    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', '<?=url('upload.php')?>');

    xhr.upload.onprogress = function (e) {
      progress(e.loaded / e.total * 100);
    };

    xhr.onload = function() {
      var json;

      if (xhr.status < 200 || xhr.status >= 300) {
        failure('HTTP Error: ' + xhr.status);
        return;
      }
console.log(xhr);
     json = JSON.parse(xhr.responseText);

      if (!json || typeof json.location != 'string') {
        failure('Invalid JSON: ' + xhr.responseText);
        return;
      }

      success('<?=url('/')?>/'+json.location);
    };

    xhr.onerror = function () {
      failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
    };

    formData = new FormData();
    formData.append('file', blobInfo.blob(), blobInfo.filename());

    xhr.send(formData);
  }

        });



    }

    $(document).ready(wywg);
</script>
<script type="text/javascript">

    content_for = function () {
        $('#permission_group').change(function () {
            var group_id = $(this).val();
            if (group_id === '0') {
                $('#content_for').val(0);
            } else {
                $.ajax({
                    type: 'get',
                    url: "<?= url('customer/getPermission') ?>",
                    data: "group_id=" + group_id,
                    dataType: "html",
                    success: function (data) {
                        $('#content_for').html(data);
                    }
                });
            }
        });
    }
    $(document).ready(content_for);
</script>
@endsection
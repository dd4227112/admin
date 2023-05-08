@extends('layouts.app')
@section('content')
        <div class="page-header">
            <div class="page-header-title">
                <h4> Add guide</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">guide</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Guide</h5>
                            <span>Add new content and if content already exists, it will be updated</span>
                        </div>

                        <div class="card-block">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel1">Add New Guide</h4> </div>
                                <form method="post" action="<?= url('customer/createGuide') ?>"  enctype="multipart/form-data">
                                    <div class="modal-body" id="message_result">
                                    <div class="form-group">
                                            <label for="guide_type" class="control-label">Guide Type</label>
                                            <select class="form-control select2" id="guide_type" name ="guide_type" required>
                                            <?php
                                                $guide_types = [
                                                    '1' =>'Product requirement documentation',
                                                    '2' =>'UX design documentation',
                                                    '3'=>'Software architecture design documentation',
                                                    '4'=>'Source code documentation',
                                                    '5'=>'Quality assurance documentation',
                                                    '6'=>'Maintanance nad help guide',
                                                    '7'=>'API documentation',
                                                    '8'=>'End -user documentation',
                                                    '9'=>'System admin documentation',
                                                ];?>
                                                <?php foreach($guide_types as $key=>$value){?>
                                                    <option  value="<?=$key?>"><?=$value?></option>
                                            <?php  } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Main Module:</label>
                                            <select class="form-control select2" id="permission_group" required>
                                                <option value=""></option>
                                                <?php
                                                $permission_groups = \DB::table('admin.permission_groups')->get();
                                                foreach ($permission_groups as $group) {
                                                    ?>
                                                    <option value="<?= $group->id ?>"><?= $group->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Content For :</label>
                                            <span id="content_for"></span> 
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Image :</label>
                                            <input type="file" name="image_file" class="form-control col-sm-4"/>
                                        </div>

                                        <div class="form-group">
                                            <label for="message-text" class="control-label">Content:</label>
                                            <textarea class="form-control" id="message-text1" id="mymce" name="content"></textarea>
                                        </div>

                                        <div ></div>
                                    </div>
                                    <div class="modal-footer">
                                        <a type="button" href="<?=base_url('customer/guide')?>" class="btn btn-danger" data-dismiss="modal">Cancel</a>
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

<script src="https://cdn.tiny.cloud/1/invalid-origin/tinymce/5.4.2-90/tinymce.min.js" referrerpolicy="origin"></script>
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
    //var token = document.getElementsByName("csrfToken").value;

    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', '<?=url('upload.php')?>');

    xhr.upload.onprogress = function (e) {
      progress(e.loaded / e.total * 100);
    };

    xhr.onload = function() {
      if (xhr.status < 200 || xhr.status >= 300) {
        failure('HTTP Error: ' + xhr.status);
        return;
      }
     // console.log(xhr);
      var json = JSON.parse(xhr.responseText);
      console.log(json);

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
    content_for = function () {
        $('#permission_group').change(function () {
            var group_id = $(this).val();
            if (group_id === '0') {
                $('#content_for').val(0);
            } else {
                $.ajax({
                    type: 'get',
                    url: "<?= url('customer/getPermission/null') ?>",
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
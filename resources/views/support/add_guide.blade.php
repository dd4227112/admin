@extends('layouts.app')
@section('content')
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="exampleModalLabel1">Add New FAQ</h4> </div>
          <form method="post" action="<?=url('support')?>">
    <div class="modal-body" id="message_result">
      
            <div class="form-group">
                <label for="recipient-name" class="control-label">Main Module:</label>
                <select class="form-control" id="permission_group">
                    <option value=""></option>
                    <?php
                    $permission_groups = \DB::table('constant.permission_group')->get();
                    foreach ($permission_groups as $group) {
                        ?>
                        <option value="<?= $group->id ?>"><?= $group->name ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="recipient-name" class="control-label">Content For :</label>
                <span id="content_for"></span> </div>
            <div class="form-group">
                <label for="message-text" class="control-label">Content:</label>
                <textarea class="form-control" id="message-text1" id="mymce" name="content"></textarea>
            </div>
       
        <div ></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="add_faq">Submit</button>
    </div>
              <?= csrf_field()?>
     </form>
</div>


@section('footer')

 <script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
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
                    type: 'POST',
                    url: "<?= url('support/getPermission') ?>",
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
@endsection
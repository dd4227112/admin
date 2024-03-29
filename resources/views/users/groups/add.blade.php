@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/';
?>
      <div class="page-header">
            <div class="page-header-title">
                <h4><?='Add Group' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">groups</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Operations</a>
                    </li>
                </ul>
            </div>
        </div> 
      
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                        
                                <form action="#" method="post">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong> Group name</strong> 
                                                    <input type="text" class="form-control" placeholder="Group name" name="name">
                                                </div>
                                                <div class="col-md-6">
                                                    <strong> Email</strong> 
                                                    <input type="email" class="form-control" placeholder="Group Email" name="email">
                                                </div>
                                            </div>
                                        </div>
                                       
                                    
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong> Group clients</strong> 
                                                    <select multiple="" name="to_client_id[]" class="form-control select2" required>
                                                        <?php
                                                      $clients = \DB::select('select A.*,B.client_id from admin.clients A left join admin.client_groups B on A.id = B.client_id where B.client_id is  null');
                                                        foreach ($clients as $client) { ?>
                                                            <option value="<?= $client->id ?>"><?= $client->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <strong> Phone number</strong> 
                                                    <input type="text" class="form-control" placeholder="Phone number" name="phone">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <textarea class="form-control col-xs-9" rows="4" name="note" id="content_part" ></textarea>
                                        </div>
                                      
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sm btn-round">Save changes</button>
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
</div>

<script type="text/javascript">

$(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
});

      

$(document).ready(department);
$(document).ready(get_schools);
</script>

<script src="<?= url('public/assets/tinymce/tinymce.min.js') ?>"></script>
   <script type="text/javascript">   
                wywig = function () {
                    tinymce.init({
                        selector: 'textarea#content_part',
                        height: 200,
                        plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table contextmenu paste code'
                        ],
                        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                        content_css: [
                            '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                            '//localhost/shule/public/assets/tinymce/codepan.css' 
                        ]
                    });
                }
                wywig();
</script>
@endsection

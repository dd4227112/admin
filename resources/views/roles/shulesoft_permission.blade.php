@extends('layouts.app')

@section('content')
<?php
$root = url('/') . '/public/';
$i = 1;
?>
<div id="newUser">
    <div id="outer" class="container">
        <div id="wrapper" class="layout" style="background-color: #fff; margin-bottom: 40px;">
            <div id="editorForm">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>User Permission</h2>
                        </div>

                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
                <div class="table-responsive">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($permission_groups as $permission)
                    <tr>
                        <td>{{ ++$i }}</td>

                        <td>
                            <h1>{{ $permission->name }}</h1>

                            <div class="col-lg-10">
                                <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>name</th>
                                        <th>Display Name</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <body>

                                    <?php foreach ($permission->permission()->get() as $value) {
                                        ?>
                                    <tr>
                                        <td><p class="change_this" contenteditable="true" permission_id="<?=$value->id?>" col='name'><?= $value->name ?></p>
                                        </td>
                                        <td><p class="change_this" contenteditable="true" permission_id="<?=$value->id?>" col='display_name'><?= $value->display_name ?></p>
                                             <span id="statusdisplay_name<?= $value->id ?>"></span>
                                        </td>
                                        <td><p class="change_this" contenteditable="true" permission_id="<?=$value->id?>" col='description'><?= $value->description ?></p>
                                             <span id="statusdescription<?= $value->id ?>"></span>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </body>
                            </table>
                            </div>
                        </td>
                       
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        $('.change_this').blur(function () {
                var inputValue = $(this).text();
                var col=$(this).attr('col');
                var id=$(this).attr('permission_id');
                $.ajax({
                    type: 'GET',
                    url: "<?= url('roles/update_tag') ?>",
                    data: {newvalue: inputValue, 'column': col, 'id': id},
                    dataType: "html",
                    beforeSend: function (xhr) {
                        $('#status' + col + id).html('<a href="#/refresh"><i class="fa fa-spinner"></i> </a>');
                    },
                    complete: function (xhr, status) {
                        console.log(xhr);
                        if(xhr.status===500){
                             $('#status' + col + id).html('<span class="label label-danger">' + xhr.responseText + '</span>');
                        }else{
                             $('#status' + col + id).html('<span class="label label-success">' + status + '</span>');
                        }
                       
                    },
                    success: function (data) {
                        
                        //$('#' + col + id).html(inputValue);
                    }
                });
            });
</script>
@endsection
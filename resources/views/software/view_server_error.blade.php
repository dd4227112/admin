@extends('layouts.app')
@section('content')


 

        <div class="page-header">
        <div class="page-header-title">
            <h4><?='Server Error details' ?></h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">errors</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">software</a>
                </li>
            </ul>
        </div>
    </div> 


        <div class="page-body">
            <div class="card">
                <div class="card-header" style="margin-bottom: -20px;">
                <h6 class="text-right" >
                    <select id="<?= $error->id ?>" name="status" class="badge badge-inverse-primary">
                    <option value ='New' <?=$error->status=='New'?'selected':''?>> New</option>
                    <option value ='Resolved' <?=$error->status=='Resolved'?'selected':''?>> Resolved</option>
                    </select>
                    <a href="" class="float-right btn btn-mini btn-round btn-danger delete_error" id="<?=$error->id?>">delete</a>
                </h6> 
                </div>
                <div class="card-block">
                        <p style="font-weight: 500;margin-bottom:-15px;">Error  Message</p> <br>
                        <p style="font-weight: 600"> <?= $error->message ?></p>
</div>


                </div>
         </div>


<script type="text/javascript">;
    $(document).ready(function() {
    $('.delete_error').on('click',function () {
        var id = $(this).attr('id');
        $.ajax({
            url: '<?= url('software/serverlogsDelete') ?>',
            method: 'post',
            data: {id: id},
            success: function (data) {
                if (data == '1') {
                    window.location ="<?=base_url('Software/serverErrors')?>";
                    toastr.success('Error deleted successfully!');
                } else{
                    toastr.error('No Error deleted!');
                }
            }
        });
        });

        $('select[name =status]').change(function() {
            var val = $(this).val();
            var id =$(this).attr('id');
            $.ajax({
                url: '<?= url('Software/updateServerErrors') ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    error_id: id,
                    status: val,
                },
                success: function(data) {
                    toastr.success(data);
                    window.location.reload();
                }
            });
        });
    });


</script>
@endsection

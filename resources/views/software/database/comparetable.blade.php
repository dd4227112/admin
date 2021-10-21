@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
        
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                      <div class="card-block">
                        <div class="white-box"><?= $data ?></div>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    sync_table = function () {
        $(".sync_table").mousedown(function (event) {
            var slave = $(this).attr('data-slave');
            var table = $(this).attr('data-table');
            $(this).hide();
            $.ajax({
                type: 'post',
                url: "<?= url('Software/syncTable') ?>",
                data: {
                    "table": table,
                    "slave": slave
                },
                dataType: "html ",
                beforeSend: function (xhr) {
                    $('#' + table + slave).html('<a href="#/refresh"><i class="feather icon-refresh-ccw"></i></a>');
                },
                complete: function (xhr, status) {
                    $('#' + table + slave).html('<label class="badge badge-success">' + status + '</label>');
                },

                success: function (data) {
                    $(this).hide();
                    toastr.success('Sync success')
                    window.location.reload(); 
                }
            });


        });
    }
    $(document).ready(sync_table);

</script>
@endsection

@extends('layouts.app')
@section('content')

    


         <div class="page-header">
            <div class="page-header-title">
                <h4><?='Compare tables' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">database tables</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Engineering</a>
                    </li>
                </ul>
            </div>
        </div> 
        
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

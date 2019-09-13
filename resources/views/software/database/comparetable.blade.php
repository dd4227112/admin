@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Database</h4>
                <span></span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Database</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Tables</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="white-box"><?= $data ?></div>
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
                type: 'GET',
                url: "<?= url('database/syncTable') ?>",
                data: {
                    "table": table,
                    "slave": slave
                },
                dataType: "html ",
                beforeSend: function (xhr) {
                    $('#' + table + slave).html('<a href="#/refresh"><i class="ti-reload rotate-refresh"></i></a>');
                },
                complete: function (xhr, status) {
                    $('#' + table + slave).html('<span class="label label-success label-rouded">' + status + '</span>');
                },

                success: function (data) {
                    $(this).hide();
                }
            });


        });
    }
    $(document).ready(sync_table);

</script>
@endsection

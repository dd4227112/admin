@extends('layouts.app')
@section('content')

<div class="white-box"><?=$data?></div>
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
                    $('#' + table + slave).html('<a href="#/refresh"><i class="fa fa-spin fa-refresh"></i> </a>');
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

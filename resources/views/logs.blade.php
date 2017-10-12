@extends('layouts.app')
@section('content')

<div class="white-box">
    <h5 class="box-title">System Error Logs</h5>

    <div class="table-responsive"> 
        <table id="example23" class="display nowrap table color-table success-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Log Name</th>
                    <th>Last Modified</th>
                    <th>Size</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $path = '../shulesoft_live/storage' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;
                foreach ($data as $key => $value) {
                    if ($value == '.' || $value == '..')
                        continue;
                    $size = filesize($path . '/' . $value) / 1024;
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><a href="<?= url('readLog/') . '/' . $value ?>"><?= $value ?></a></td>
                        <td><?= date("F d Y H:i:s.", fileatime($path . '/' . $value)) ?></td>
                        <td><?= round($size, 2) . ' kb' ?></td>
                        <td><a href="#" onclick="call_page('deleteLog/<?= $value ?>'); window.location.reload()" class="btn btn-danger">
                                Delete</a></td>
                    </tr>
    <?php $i++;
} ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $('#example23').DataTable({
        dom: 'Bfrtip'
        , buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
@endsection

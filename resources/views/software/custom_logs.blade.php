<div class="card-block">
    <div class="dt-responsive table-responsive">
        <table id="simpletable" class="table table-striped table-bordered nowrap dataTable">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Error Message</th>
                    <th>File</th>
                    <th>url</th>
                    <th>Created By</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($logs) && count($logs) > 0) {
                    ?>
                    @foreach($logs as $log)

                    <tr id="log{{$log->id}}">
                        <td >{{$log->schema_name}}</td>
                        <td>{{$log->error_message}}</td>
                        <td>{{$log->file}}</td>
                        <td>{{$log->url}}</td>
                        <td>ID: {{$log->created_by}}, Table: {{$log->created_by_table}}</td>
                        <td>{{$log->created_at}}</td>
                        <td><a href="#" id="{{$log->id}}" onclick="return false" onmousedown="delete_log({{$log->id}})" class="btn btn-sm btn-danger dlt_log">Delete</a></td>
                    </tr>
                    @endforeach
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Client Name</th>
                    <th>Error Message</th>
                    <th>File</th>
                    <th>url</th>
                    <th>Created By</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
 <script type="text/javascript">
                                               $(document).ready(function () {
                                                   $('.dataTable').DataTable();
                                               });
    </script>
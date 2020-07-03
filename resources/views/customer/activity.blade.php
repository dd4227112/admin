@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>SCHOOL ACTIVITIES OR TASK PERFORMED</h4>
                <span>This Part Show all added Task performed on schools</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Customer Support</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Activities</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Ajax data source (Arrays) table start -->
                    <div class="card">
                        <div class="card-header">
                        <a class="btn btn-success btn-sm" href="<?= url('customer/activity/add') ?>"> Add New Task</a>

                        </div>

                        <div class="card-block">

                            <div class="table-responsive dt-responsive">
                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                    <thead>
                                        <tr>
                                        <th>No.</th>
                                        <th>Task type</th>
                                        <th>Task Performed</th>
                                        <th>Added By</th>
                                            <th>School</th>
                                            <th> Deadline</th>
                                            <th>Added On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($activities as $activity) {
                                            ?>
                                            <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $activity->taskType->name ?></td>
                                                <td><a href="<?= url('customer/activity/show/' . $activity->id) ?>"><?= substr($activity->activity, 0, 60) ?></a></td>

                                                <td><?= $activity->user->firstname ?></td>
                                                <td><?= $activity->client->username ?></td>
                                                <td><?= $activity->date ?> <?= $activity->time ?></td>

                                                <td><?= $activity->created_at ?></td>
                                                <td><a href="<?= url('customer/activity/show/' . $activity->id) ?>" class="btn btn-mini waves-effect waves-light btn-primary"> <i class="icofont icofont-eye-alt"></i> View</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                    <th>No</th>
                                    <th>Task type</th>
                                        <th>Task Title</th>
                                            <th>Added By</th>
                                            <th>School</th>
                                            <th>Added On</th>
                                            <th> Deadline</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Page-body end -->
        </div>
    </div>
    <!-- Main-body end -->
    @endsection
    @section('footer')
    <!-- data-table js -->
    <?php $root = url('/') . '/public/' ?>

    <script type="text/javascript">
      
        get_statistic = function () {
            // var data = getData();
            // console.log(data);
            //        $(".get_data").each(function (index) {
            //            var tag = $(this).attr('tag');
            //            var schema = $(this).attr('schema');
            //            //$(schema + tag).html(1);
            //
            //
            //        });
        }
        function getData() {
            $.ajax({
                type: 'get',
                url: '<?= url('customer/getData/null/') ?>',
                data: {tag: 'users'},
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (i, info)
                    {
                        $(".get_data").each(function (index) {
                            var tag = $(this).attr('tag');
                            var schema = $(this).attr('schema');

                            if (tag == info.table && schema == info.schema_name) {
                                $('#' + schema + tag).html(info.count);
                            }


                        });

                    });
                    return data;
                },
                error: function () {
                    return 2;
                }

            });
        }
        $(document).ready(get_statistic);
    </script>
    @endsection

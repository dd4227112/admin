@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Basic DataTables</h4>
                <span>Basic initialisation of DataTables</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Data Table</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Basic Initialization</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Zero Configuration</h5>
                            <span>DataTables has most features enabled by default, so all you need to do to use it with your own ables is to call the construction function: $().DataTable();.</span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                                <i class="icofont icofont-close-circled"></i>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Reference #</th>
                                            <th>Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Remained Amount</th>
                                            <th>Due Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_amount = 0;
                                        $total_paid = 0;
                                        $total_unpaid = 0;
                                        $i = 1;
                                        ?>
                                        @foreach($invoices as $invoice)

                                        <tr>
                                            <td>Hermione Butler</td>
                                            <td>Regional Director</td>
                                            <td>London</td>
                                            <td>47</td>
                                            <td>2011/03/21</td>
                                            <td>$356,250</td><td>$356,250</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">Total</td>
                                            <td><?= money($total_amount) ?></td>
                                            <td></td>
                                            <td><?= money($total_paid) ?></td>
                                            <td><?= money($total_unpaid) ?></td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>
<script type="text/javascript">
    dashboard_summary = function () {
        $.ajax({
            url: '<?= url('analyse/summary/null') ?>',
            data: {},
            dataType: 'JSONP',
            success: function (data) {
                console.log(data);
                $('#all_users').html(data.users);
                $('#all_students').html(data.students);
                $('#all_parents').html(data.parents);
                $('#all_teachers').html(data.teachers);
                $('#schools_with_shulesoft').html(data.total_schools);
                $('#schools_with_students').html(data.total_schools - data.schools_with_students);
                //
                $('#active_users').html(data.active_users);
                $('#active_students').html(data.active_students);
                $('#active_parents').html(data.active_parents);
                $('#active_teachers').html(data.active_teachers);
            }
        });
    }
    // $(document).ready(dashboard_summary);
</script>
@endsection
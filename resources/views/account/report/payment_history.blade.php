@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Payment History</h4>
                <span>Show list of all payments in summary</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Payments</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12 card">
                    <p>List of all payments recorded</p>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="all_payments_table" class="table table-striped table-bordered table-hover no-footer display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="col-sm-1">#</th>
                                        <th class="col-sm-1">Client Name</th>
                                       
                                        <th class="col-sm-2">Amount</th>
                                        <th class="col-sm-1">Date</th>
                                         <th class="col-sm-1">Service</th>
                                        <th class="col-sm-2">Method</th>
                                        

                                        <th class="col-sm-1">Bank</th>
                                        <th class="col-sm-1">Payment Type</th>
                                        <th class="col-sm-2"><?= __('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>                                        
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">


    $(document).ready(function () {
        $('#all_payments_table').DataTable({
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
                'url': "<?= url('sales/show/null?page=payments') ?>"
            },
            "columns": [

                {"data": "id"},
                {"data": "name"},
                {"data": "amount"},
                {"data": "created_at"},
                {"data": "method"},
                {"data": "method"},
                {"data": "bank_name"},
                {"data": "payment_type"},
                {"data": ""}
            ],
            "columnDefs": [
                {
                    "targets": 8,
                    "data": null,
                    "render": function (data, type, row, meta) {

                        return '';
                        //'<a href="#" id="' + row.id + '" class="label label-danger dlt_log" onmousedown="delete_log(' + row.id + ')" onclick="return false">Delete</a>' + '<a href="#" id="' + row.id + '" class="label label-info dlt_log" onmousedown="View_log(' + row.id + ')" onclick="return false">View</a>';


                    }

                }
            ],

            rowCallback: function (row, data) {
                //$(row).addClass('selectRow');
                $(row).attr('id', 'log' + data.id);
            }
        });
    });

</script>
@endsection
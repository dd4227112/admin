@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company</h4>
                <span>Show Invoices summary</span>
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
                    <li class="breadcrumb-item"><a href="#!">Invoices</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <!-- form start -->
                <div class="card">

                    <div class="col-sm-12">
                        <br>
                            <form class="form-horizontal" role="form" method="post"> 
                                    <div class="form-group row">
                                        <div class="col-md-4 col-sm-6">
                                            <input type="date" class="form-control calendar" id="from_date" name="from_date" value="<?= old('from_date',$from) ?>" >
                                        </div>
                                  
                                        <div class="col-md-4 col-sm-6">
                                            <input type="date" class="form-control calendar" id="to_date" name="to_date" value="<?= old('to_date',$to) ?>" >
                                        </div>
                                    
                                        <div class="col-md-3 col-sm-2 col-xs-6">
                                            <input type="submit" class="btn btn-success" value="Submit"  style="float: right;">
                                        </div>
                                    </div>
                                <?= csrf_field() ?>
                            </form>
                        </div>            
                        <div class="card">
                            <div class="table-responsive dt-responsive "> 
                                <hr>
                                   <table id="invoice_table" class="table table-striped table-bordered nowrap dataTable">
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
                                            foreach ($invoices as $invoice) {

                                                $amount = $invoice->invoiceFees()->sum('amount');
                                                $paid = $invoice->payments()->sum('amount');
                                                $unpaid = $amount - $paid;
                                                $total_paid += $paid;
                                                $total_amount += $amount;
                                                $total_unpaid += $unpaid;
                                                ?>


                                                <tr>
                                                    <td><?= $invoice->client->username ?></td>
                                                    <td><?= $invoice->reference ?></td>
                                                    <td><?= money($amount) ?></td>
                                                    <td><?= money($paid) ?></td>
                                                    <td><?= money($unpaid) ?></td>
                                                    <td><?= date('d M Y', strtotime($invoice->due_date)) ?></td>
                                                    <td>
                                                        <a class="btn btn-success btn-sm" href="<?= url('account/invoiceView/' . $invoice->id) ?>"  > <span class="point-marker bg-danger"></span>View</a>
                                                    </td>
                                        </tr>
                                    <?php $i++; } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">Total</td>
                                                <td><?= money($total_amount) ?></td>
                                                <td><?= money($total_paid) ?></td>
                                                <td><?= money($total_unpaid) ?></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block">
                                    <div id="container"></div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript" src="<?= url('/') . '/public/' ?>bower_components/jquery/dist/jquery.min.js"></script>

                        <script src="<?= url('/public') ?>/code/highcharts.js"></script>
                        <script src="<?= url('/public') ?>/code/modules/exporting.js"></script>
                        <script src="<?= url('/public') ?>/code/modules/export-data.js"></script>
                        <script src="<?= url('/public') ?>/code/modules/series-label.js"></script>
                        <script src="<?= url('/public') ?>/code/modules/data.js"></script>
                        <table id="users_table" style="display:none">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Amount (Tsh)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = 'select sum(amount) as total,extract(month from date) as month from admin.invoices where extract(year from date)=' . date('Y', strtotime($to)) . ' group by month order by month';
                                //dd($sql);
                                $logs = DB::select($sql);
                                foreach ($logs as $log) {
                                    $monthNum = $log->month;
                                    $dateObj = DateTime::createFromFormat('!m', $monthNum);
                                    $monthName = $dateObj->format('F'); // March
                                    ?>
                                    <tr>
                                        <th><?= $monthName ?></th>
                                        <td><?= $log->total ?></td>
                                    </tr>
                                <?php }
                                ?> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    Highcharts.chart('container', {
        data: {
            table: 'users_table'
        },
        chart: {
            type: 'column'
        },
        title: {
            text: 'Expense Per Month in <?=date('Y', strtotime($to)) ?>'
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Amounts (Tsh)'
            }
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                        this.point.y + ' ' + this.point.name.toLowerCase();
            }
        }
    });
    $('.calendar').on('click', function (e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");
    });
</script>
@endsection
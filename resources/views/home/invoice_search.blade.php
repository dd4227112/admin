@extends('layouts.app')
@section('content')
@role('Bank')
<div class="row">

    <div class="col-md-12 col-lg-8">
        <div class="white-box">
            <div class="row">
                <div class="col-sm-8">
                    <h2 class="m-b-0 font-medium">Search Invoice</h2>
                    <h5 class="text-muted m-t-0">Payment Reference Number</h5></div>
                <div class="col-sm-12">
                    <form action="<?= url('searchInvoice') ?>" method="post"/>
                    <div class="form-group">
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="invoice_search_box" name="invoice" placeholder="Seach"> 
                        </div>
                        <div class="col-md-4">
                            <?= csrf_field() ?>
                            <input type="submit" class="btn btn-small btn-success" value="search"/>
                        </div>
                    </div>
                    </form>
                    <li class="dropdown" id="invoice_search_results">
                        <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> 
                            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        </a>
                        <ul class="dropdown-menu mailbox animated bounceInDown">
                            <li>
                                <div class="drop-title">You have <span id="search_counts"></span> results</div>
                            </li>
                            <li>
                                <div class="message-center" id="invoice_search_content">


                                </div>
                            </li>
                            <li>
                                <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="white-box">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="m-b-0 font-medium">Tsh 356,000,000</h2>
                    <h5 class="text-muted m-t-0">Total Posted Today</h5></div>

            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="white-box">
            <div class="row">
                <?php if (isset($results) && count($results) > 0) { ?>

                    <div class="table-responsive">
                        <table  class="table color-table inverse-table">
                            <thead>
                                <tr>

                                    <th>Student Name</th>
                                    <th>Invoice#</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>School Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($results as $result) {
                                    ?>
                                    <tr>
                                        <td><?= $result->student_name ?></td>
                                        <td><?= $result->invoiceNO ?></td>
                                        <td><?= number_format($result->amount) ?></td>
                                        <td><?php
                                            $status = $result->status;

                                            $setstatus = '';
                                            $btn_class = 'success';
                                            if ($status == '0') {
                                                $check_status = '0';
                                                $status = 'not paid';
                                                $btn_class = 'danger';
                                            } elseif ($status == '1') {
                                                $check_status = '1';
                                                $status = 'paid ';
                                                $btn_class = 'success';
                                            } elseif ($status == '2') {
                                                $check_status = '2';

                                                $status = 'partially paid';

                                                $btn_class = 'warning';
                                            } elseif ($status == '3') {
                                                $check_status = '3';
                                                $status = 'fully paid';
                                                $btn_class = 'info';
                                            } elseif ($status == '4') {
                                                $check_status = '4';
                                                $status = 'Rejected';
                                                $btn_class = 'secondary';
                                            }

                                            echo "<button class='btn btn-" . $btn_class . " btn-xs'>" . $status . "</button>";
                                            ?></td>
                                        <td><?= $result->school_name ?></td>
                                        <td>
                                            <!--<a href="" class="btn btn-sm btn-success">clear</a>-->
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php }
                ?> 
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    invoice_search_box = function () {
        $('#invoice_search_box').keyup(function () {
            var val = $(this).val();
            if (val != '') {
                $.ajax({
                    url: '{{ url("search") }}',
                    data: {q: val,type:'2'},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (data) {
                        $('#invoice_search_content').html(data.result);
                        $('#search_counts').html(data.total);
                        $('#invoice_search_results').addClass('open');
                    }
                });
            }
        });
    }
    $(document).ready(invoice_search_box);
</script>
@endrole
@endsection

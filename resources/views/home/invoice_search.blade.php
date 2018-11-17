@extends('layouts.app')
@section('content')
@role('Bank')
<div class="row">

    <div class="col-md-12 col-lg-8">
        <div class="white-box">
            <div class="row">
                <div class="col-sm-8">
                    <h2 class="m-b-0 font-medium">Search Invoice</h2>
                    <h5 class="text-muted m-t-0">Enter Payment Reference Number or Student Name</h5></div>
                <div class="col-sm-12">
                    <form action="<?= url('searchInvoice') ?>" method="post">
                        <div class="form-group">
                            <div class="col-md-3"> <label>Select School</label></div>
                            <div class="col-md-5">  
                                <?php
                                $schools = \DB::select('select * from all_setting where payment_integrated=1');
                                ?>
                                <select class="js-example-basic-single form-control" name="school">
                                    <option value="all">All</option>
                                    <?php foreach ($schools as $school) { ?>
                                        <option value="<?=$school->schema_name?>"><?=$school->sname?></option>
                                    <?php }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <br/>
                        <div class="form-group">
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="invoice" placeholder="Seach"> 
                            </div>
                            <div class="col-md-4">
                                <?= csrf_field() ?>
                                <input type="submit" class="btn btn-small btn-success" value="search"/>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="white-box">
            <div class="row">
                <div class="col-sm-12">
                    <!--                    <h2 class="m-b-0 font-medium">Tsh 356,000,000</h2>
                                        <h5 class="text-muted m-t-0">Total Posted Today</h5></div>-->

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
                            <table class="table color-table inverse-table dataTable">
                                <thead>
                                    <tr>

                                        <th>Student Name</th>
                                        <th>Invoice#</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>School Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($results as $result) {
                                        ?>
                                        <tr>
                                            <td><?= $result->student_name ?></td>
                                            <td><?= $result->reference ?></td>
                                            <td><?= number_format($result->amount) ?></td>
                                            <td><?php
                                $setstatus = '';
                                $btn_class = 'success';
                                if ($result->amount > 0) {
                                    $check_status = '0';
                                    $status = 'not paid';
                                    $btn_class = 'danger';
                                } elseif ($result->amount == 0) {
                                    $check_status = '1';
                                    $status = 'paid ';
                                    $btn_class = 'success';
                                } else {
                                    $check_status = '2';

                                    $status = 'partially paid';

                                    $btn_class = 'warning';
                                }

                                echo "<button class='btn btn-" . $btn_class . " btn-xs'>" . $status . "</button>";
                                        ?></td>
                                            <td><?= $result->school_name ?></td>
                                           
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php }
                    ?> 
                    <?php if (isset($results) && count($results) == 0) { ?>
                        <h5 class="alert alert-warning">Invoice or Student Name does not exists</h5></div>

                <?php } ?>
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
                    data: {q: val, type: '2'},
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
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
</script>
@include('layouts.datatable')
@endrole
@endsection

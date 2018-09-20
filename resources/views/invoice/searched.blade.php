@extends('layouts.app')
@section('content')
<div class="row">
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
                                            <td><?= $result->reference ?></td>
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
</div>
<?php $root = url('/') . '/public/' ?>
<script src="<?= $root ?>js/jquery.PrintArea.js" type="text/JavaScript"></script>
<script>
    $(document).ready(function () {
        $("#print").click(function () {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode
                , popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });
</script>
@endsection
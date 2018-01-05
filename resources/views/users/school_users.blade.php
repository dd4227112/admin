@extends('layouts.app')
@section('content')

<div class="row">
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <h3 class="box-title">Schools</h3>
            <!--<div id="basicgrid"></div>-->

            <table id="example23" class="table display nowrap table color-table success-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>School Name</th>
                        <th>Students</th>
                        <th>Amount Expected</th>
                        <th>Parents</th>
                        <th>Teachers</th>
                        <th>Non Teaching</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;

                    if (isset($users) && count($users) > 0) {
                        $students = 0;
                        $parents = 0;
                        $teachers = 0;
                        $staff = 0;
                        $total = 0;
                        $total_price = 0;
                        foreach ($users as $key => $value) {
                            $price = \DB::table($value->schema_name . '.setting')->where('settingID', 1)->value('price_per_student');
                            $students += $value->student;
                            $parents += $value->parent;
                            $teachers += $value->teacher;
                            $staff += $value->user;
                            $total += $value->student + $value->parent + $value->teacher + $value->user;
                            $price_per_school = $price * $value->student;
                            $total_price += $price_per_school;
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $value->schema_name ?></td>
                                <td><?= $value->student ?></td>
                                <td><?= number_format($price_per_school) ?></td>
                                <td><?= $value->parent ?></td>
                                <td><?= $value->teacher ?></td>
                                <td><?= $value->user ?></td>
                                <td><?= $value->student + $value->parent + $value->teacher + $value->user ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><?= $students ?></td>
                            <td><?= number_format($total_price) ?></td>
                            <td><?= $parents ?></td>
                            <td><?= $teachers ?></td>
                            <td><?= $staff ?></td>
                            <td><?= $total ?></td>
                        </tr>
                    </tfoot>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('layouts.datatable')
@endsection

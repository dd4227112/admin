@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <h5 class="page-header">
                            <a class="btn btn-success" href="<?php echo url('exam/globalExam/add') ?>">
                                <i class="fa fa-plus"></i> 
                                <?= __('add Exam') ?>
                            </a>
                        </h5>
            <h3 class="box-title">Exams Definition</h3>
            <!--<div id="basicgrid"></div>-->
<!--            <select id="school_region">
                <option value="">Select Year</option>
                <?php
                $regions=['2018'=>'2018'];
                foreach ($regions as $key=>$region) {
                    ?>
                    <option value="<?= $key ?>"><?= $region ?></option>
                <?php } ?>
            </select>-->
            <table class="table table-striped table-bordered table-hover dataTable no-footer">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Exam Name</th>
                        <th>Association</th>
                        <th>Class Level</th>
                        <th>Date created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if (count($exams) > 0) {
                        foreach ($exams as $exam) {
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $exam->name ?></td>
                                <td><?= $exam->association->name ?></td>
                                <td><?= $exam->class_level_id ?></td>
                                <td><?= $exam->created_at ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm" href="#">Show</a>
                                <a class="btn btn-info btn-sm" href="#">Edit</a>
                                <a class="btn btn-danger btn-sm" href="#">Delete</a></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('layouts.datatable')
@endsection

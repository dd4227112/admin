
@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <h5 class="page-header">
                            <a class="btn btn-success" href="<?php echo url('exam/schedule/add') ?>">
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
                        <th>Academic Year</th>
                        <th>Date</th>
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
                                <td><?= $exam->globalExamDefinition->name ?></td>
                                <td><?= $exam->globalExamDefinition->association->name ?></td>
                                <td><?= $exam->year ?></td>
                                 <td><?= $exam->date ?></td>
                                <td><?= $exam->globalExamDefinition->schoolLevel->name ?></td>
                                <td><?= $exam->created_at ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm" href="<?php echo url('exam/globalExam/show/'.$exam->id) ?>">Show</a>
                                <a class="btn btn-info btn-sm" href="<?php echo url('exam/schedule/edit/'.$exam->id) ?>">Edit</a>
                                <a class="btn btn-danger btn-sm" href="<?php echo url('exam/schedule/delete/'.$exam->id) ?>">Delete</a></td>
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

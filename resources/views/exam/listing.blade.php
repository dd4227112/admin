@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Exams List</h4>
                <span>This parts show exams that are defined only once for quick reference</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Exams</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Listing</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <h5 class="card-header">
                            <a class="btn btn-success" href="<?php echo url('exam/globalExam/add') ?>">
                                <i class="fa fa-plus"></i> 
                                <?= __('add Exam') ?>
                            </a>
                        </h5>


                        <div class="card-block">

                            <div class="table-responsive dt-responsive ">
                                <table id="dt-ajax-array" class="table table-striped dataTable table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Exam Name</th>
                                            <th>Association</th>
                                            <th>Class Level</th>
                                            <th>Date created</th>
                                            <th>Note</th>
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
                                                    <td><?= $exam->schoolLevel->name ?></td>
                                                    <td><?= date('d M Y',strtotime($exam->created_at)) ?></td>
                                                    <td><?= $exam->note ?></td>
                                                    <td>
                                            
                                                        <a class="btn btn-info btn-sm" href="<?php echo url('exam/globalExam/edit/' . $exam->id) ?>">Edit</a>
                                                        <a class="btn btn-danger btn-sm" href="<?php echo url('exam/globalExam/delete/' . $exam->id) ?>">Delete</a></td>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

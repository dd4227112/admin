@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Exam Marking</h4>
        
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Exam</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Marking</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page header end -->
        <!-- Page body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
<br/>
                        <div class="col-sm-6 col-sm-offset-3 list-group" style="margin-left: 27%">
                            <div class="list-group-item">
                              
                            </div>

                        </div> 

                        <div id="hide-table" class="card-block">
                            <table class="table table-striped table-bordered table-hover no-footer dataTable">
                                <thead>
                                    <tr>
                                        <th><?= __('slno') ?></th>
                                        <th><?= __('school name') ?></th>
                                        <th><?= __('marks entered') ?></th>
                                        <th><?= __('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                   
                                    if (isset($marks) && sizeof($marks)>0) {
                                        $i = 1;
                                        foreach ($marks as $mark) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                <td >
                                                    <?php echo $mark->schema_name; ?>
                                                </td>
                                                <td>
                                                    <?php echo $mark->count ?>
                                                </td>

                                                <td>
 <a  href="<?= url("exam/deleteMark/$exam_id/".$mark->schema_name) ?> " class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Delete all</a>

                                                </td>
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
        @endsection
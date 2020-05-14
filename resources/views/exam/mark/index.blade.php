@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Exam Marking</h4>
                <span>You can upload marks from excel sheet and system will generate reports for you automatically</span>
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
                                <form class="form-horizontal" role="form" method="post">

                                    <div class='form-group row' >
                                        <label for="class_id" class="col-sm-6 col-sm-offset-2 control-label">
                                            <?= __('Classes') ?>
                                        </label>

                                        <div class="col-sm-6">
                                            <?php
                                            $array = array("0" => __("select class"));
                                            foreach ($classes as $classa) {
                                                $array[$classa->id] = $classa->name;
                                            }

                                            echo form_dropdown("class_id", $array, old("class_id"), " id='classesmodelID' class='form-control'");
                                            ?>
                                        </div>
                                    </div>

                                    <div class='form-group row' >
                                        <label for="sectionID" class="col-sm-6 col-sm-offset-2 control-label">
                                            <?= __('Year') ?>
                                        </label>
                                        <div class="col-sm-6">
                                            <?php
                                            $array = array("0" => __("select Year"));
                                            $array['2019'] = 2019;


                                            echo form_dropdown("academic_year_id", $array, old("academic_year_id"), "id='academic_year_id' class='form-control'");
                                            ?>
                                        </div>
                                    </div>
                                    <?= csrf_field() ?>
                                </form>
                            </div>

                        </div> 

                        <div id="hide-table" class="card-block">
                            <table class="table table-striped table-bordered table-hover no-footer">
                                <thead>
                                    <tr>
                                        <th><?= __('slno') ?></th>
                                        <th><?= __('exam') ?></th>
                                        <th><?= __('date') ?></th>
                                        <th><?= __('marking status') ?></th>
                                        <!--<th><?= __('action') ?></th>-->
                                        <th><?= __('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                   
                                    if (isset($exams) && count($exams)>0) {
                                         $subjects=\App\Models\Subject::where('class_id', $class_id)->count();
                                         $students=\DB::select('select distinct name from marks');
                                         
                                         $total_subject_count=count($students)*$subjects;
                                        $i = 1;
                                        foreach ($exams as $exam) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                <td >
                                                    <?php echo $exam->name; ?>
                                                </td>
                                                <td>
                                                    <?php echo date("d M Y", strtotime($exam->date)); ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $marked = $exam->marks()->where('refer_class_id', $class_id)->whereNotNull('mark')->count();
                                                    echo $marked . ' out of ' . $total_subject_count;
                                                    echo ': <b class="badge label-success">' . ($total_subject_count - $marked) . ' remains</b>';
                                                    ?>
                                                </td>

<!--                                                <td>
                                                    

                                                </td>-->
                                                <td>
 <a  href="<?= url("exam/uploadMark/$exam->id/$class_id") ?> " class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Upload Marks </a>
 <a  href="<?= url("exam/viewMark/$exam->id/$class_id") ?> " class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> View</a>

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

        <script type="text/javascript">
            $('#classesmodelID').change(function (event) {

                var class_id = $(this).val();
                if (class_id === '0') {
                    $('#academic_year_id').val(0);
                } else {
                    $.ajax({
                        type: 'POST',
                        url: "<?= url('exam/get_academic_years') ?>",
                        data: "id=" + class_id,
                        dataType: "html",
                        success: function (data) {
                            $('#academic_year_id').html(data);
                        }
                    });
                }
            });
            $('#academic_year_id').change(function (event) {

                var academic_year_id = $(this).val();
                var class_id = $('#classesmodelID').val();
                if (academic_year_id === '0') {
                    return false;
                } else {
                    window.location.href = "<?= url('exam/marking') ?>/" + class_id + "/" + academic_year_id;
                }
            });
        </script>
        @endsection
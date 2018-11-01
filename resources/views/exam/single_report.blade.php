@extends('layouts.app')
@section('content')

<div class="row">

    <div class="col-sm-6 col-sm-offset-3 list-group">
        <div class="list-group-item list-group-item-warning">

            <p align="center"><span class="label label-info">Exam report</span></p>
            <form class="form-horizontal" role="form" method="post">
                <div class='form-group' >
                    <label for="exam_id" class="col-sm-2 col-sm-offset-2 control-label">
                        Exam
                    </label>
                    <div class="col-sm-6">
                        <?php
                        $exam_array = array("0" => 'Select Exam');
                        if (isset($exams)) {
                            foreach ($exams as $exam) {
                                $exam_array[$exam->id] = $exam->name;
                            }
                        }

                        echo form_dropdown("exam_id", $exam_array, old("exam_id"), "id='exam_id' class='form-control'");
                        ?>
                    </div>
                </div>
                <div class='form-group' >
                    <label for="class_id" class="col-sm-2 col-sm-offset-2 control-label">
                        Class
                    </label>
                    <div class="col-sm-6">
                        <?php
                        $array = array("0" => 'select Class');
                        foreach ($classes as $class) {
                            $array[$class->id] = $class->name;
                        }
                        $class_id = isset($class_id) ? $class_id : '0';
                        $class_name = $array[$class_id];
                        echo form_dropdown("class_id", $array, NULL, "id='class_id' class='form-control'");
                        ?>
                    </div>
                </div>
                <div id="report_filter_div">
                    <div class='form-group' >
                        <label for="year" class="col-sm-2 col-sm-offset-2 control-label">
                            Academic Year
                        </label>
                        <div class="col-sm-6">
                            <?php
                            $ac_array = array("0" => 'select Year');
                            if (isset($academic_years)) {
                                foreach ($academic_years as $academic) {
                                    $ac_array[$academic->academic_year] = $academic->academic_year;
                                }
                            }

                            echo form_dropdown("academic_year_id", $ac_array, old("academic_year_id"), "id='academic_year_id' class='form-control'");
                            ?>
                        </div>
                    </div>


                    <div class='form-group' >
                        <label for="type_id" class="col-sm-2 col-sm-offset-2 control-label">
                            Report Type
                        </label>
                        <div class="col-sm-6">
                            <?php
                            $type_array = array("0" => 'Select Type');
                            $type_array['school'] = 'School Average Report';
                            $type_array['student'] = 'Student Average Report';
                            $type_array['subject'] = 'Student Subjects Report';
                            echo form_dropdown("type_id", $type_array, old("type_id"), "id='type_id' class='form-control'");
                            ?>
                        </div> <span id="sem_id"></span>
                    </div>
                    <div class='form-group' >
                        <label for="subject_id" class="col-sm-2 col-sm-offset-2 control-label">
                            Subject
                        </label>
                        <div class="col-sm-6">
                            <?php
                            $subject_array = array("0" => 'Select Subject');
                            if (isset($subjects)) {
                                $subject_array['all'] = 'All Subjects';
                                foreach ($subjects as $subject) {
                                    $subject_array[$subject->subject_name] = $subject->subject_name;
                                }
                            }
                            echo form_dropdown("subject_id", $subject_array, old("subject_id"), "id='subject_id' class='form-control'");
                            ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">

                            <input type="submit" class="btn btn-success" style="margin-bottom:0px" value="View Report" >
                        </div>
                    </div>
                </div>
                <?= csrf_field() ?>
            </form>
        </div>

    </div>

</div>
<div class="row">
    <div class="col-lg-12">

        <div class="white-box">
            <h3 class="box-title">Exams</h3>
            <?php
            if (count($reports) > 0 && request('type_id') != 'subject') {
                ?>
                <table id="example23" class="display nowrap table color-table success-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= request('type_id') == 'school' ? 'School ' : 'Student ' ?> Name</th>
                            <th>Subject</th>
                            <th>Average</th>
                            <th>Grade</th>
                            <th>Rank</th>
                            <?= request('type_id') == 'school' ? '<th>Action</th>' : '<th>School</th>' ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;

                        foreach ($reports as $report) {
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= request('type_id') == 'school' ? $report->schema_name : $report->name ?></td>
                                <td><?= ucfirst(request('subject_id')) ?></td>
                                <td><?= $report->average ?></td>
                                <td><?= $report->grade ?></td>
                                <td><?= $report->rank ?></td>
                                <?php
                                if (request('type_id') == 'school') {
                                    ?>
                                    <td>
                                        <a class="btn btn-success btn-sm" href="#">View</a>
                                    </td>
                                <?php } else { ?>
                                    <td>
                                        <?= $report->schema_name ?>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>        
            <?php } ?>


            <?php
            if (count($reports) > 0 && request('type_id') == 'subject') {
                ?>
                @include('exam.single_subject_report')    
            <?php } ?>
        </div>
    </div>

</div>
<script type="text/javascript">
    $('#academic_year_id').change(function (event) {
        var academic_year_id = $(this).val();
        var class_id = $('#class_id').val();
        if (academic_year_id === '0') {
            $('#exam_id').val(0);
        } else {
//            $.ajax({
//                type: 'POST',
//                url: "<?= url('exam/getExams') ?>",
//                data: "class_id=" + class_id + '&academic_year_id=' + academic_year_id,
//                dataType: "html",
//                success: function (data) {
//                    $('#exam_id').html(data);
//                }
//            });
            $.ajax({
                type: 'POST',
                url: "<?= url('exam/getSubjects') ?>",
                data: "class_id=" + class_id + '&academic_year_id=' + academic_year_id,
                dataType: "html",
                success: function (data) {
                    $('#subject_id').html(data);
                }
            });
        }
    });
</script>
@include('layouts.datatable')
@endsection

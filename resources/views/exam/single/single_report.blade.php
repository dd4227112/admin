@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Exams Reports</h4>
                <span>You can view different types of reports here</span>
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
                    <li class="breadcrumb-item"><a href="#!">Reports</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="card">
                <div class="row">
                    <div class="col-sm-12 col-xl-3"></div>
                    <div class="col-sm-12 col-xl-6 ">

                        <p align="center"></p>
                        <form class="form-horizontal col-lg-12" role="form" method="post">
                            <div class="form-group row">
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

                                    echo form_dropdown("exam_id", $exam_array, old("exam_id"), "id='exam_id' class='form-control '");
                                    ?>
                                </div>
                            </div>
                            <input type="hidden" name="class_id" value="8"/>
                            <div id="option_exam_parts" style="display: none;">
<!--                                <div class='form-group row' >
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
                                </div>-->
                                <div id="report_filter_div">
<!--                                    <div class='form-group row' >
                                        <label for="year" class="col-sm-2 col-sm-offset-2 control-label">
                                            Academic Year
                                        </label>
                                        <div class="col-sm-6">
                                            <?php
                                            $ac_array = array("0" => 'select Year');
                                            if (isset($academic_years) && count($academic_years) > 0) {

//                                            foreach ($academic_years as $academic) {
//                                                $ac_array[$academic->academic_year] = $academic->academic_year;
//                                            }
                                            }

                                            echo form_dropdown("academic_year_id", $academic_years, old("academic_year_id"), "id='academic_year_id' class='form-control'");
                                            ?>
                                        </div>
                                    </div>-->


                                    <div class='form-group row' >
                                        <label for="type_id" class="col-sm-2 col-sm-offset-2 control-label">
                                            Report Type
                                        </label>
                                        <div class="col-sm-6">
                                            <?php
                                            $type_array = array("0" => 'Select Type');
                                            $type_array['school'] = 'School Ranking Report';
                                            $type_array['student'] = 'Student Average Report';
                                            $type_array['subject'] = 'Student Overall Report';
                                            echo form_dropdown("type_id", $type_array, old("type_id"), "id='type_id' class='form-control'");
                                            ?>
                                        </div> <span id="sem_id"></span>
                                    </div>
                                    <div class='form-group row' >
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


                                    <div class="form-group row">
                                        <label for="subject_id" class="col-sm-2 col-sm-offset-2 control-label">

                                        </label>
                                        <div class="col-sm-6">
                                            <div id="grade_option" style="display: none">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="gender" id="gender-1" value="average" checked=""> Rank By AVG
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="gender" id="gender-2" value="total"> Rank by Total
                                                    </label>
                                                </div>
                                            </div>
                                            <input type="submit" class="btn btn-success" style="margin-bottom:0px" value="View Report" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= csrf_field() ?>
                        </form>
                    </div>
                    <div class="col-sm-12 col-xl-3"></div>
                </div>
            </div>


            <div class="card">
                <h5 class="card-header">Exam Reports</h5>
                <?php if (isset($exam_definition) && count($exam_definition) > 0) { ?>
                    <div class="row">
                        <div class="col-sm-12 col-xl-3"></div>
                        <div class="col-sm-12 col-xl-6">
                            <div class="table-responsive" style="border: 1px solid #cccccc">
                                <div class="table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Exam Name</th>
                                                <th>Exam Date</th>
                                                <th>Class Name</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= $exam_definition->name ?></td>
                                                <td><?= $exam_definition->date ?></td>
                                                <td><?= $class_info->name ?></td>
                                                <td>
                                                    <?php
                                                    $report_published = DB::table('exam_reports')->where('token', sha1(md5($exam_definition->id)))->first();
                                                    if (count($report_published) == 1) {
                                                        ?>
                                                        <a href="<?= url('exam/report/single/null?token=' . $report_published->token) ?>" class="label label-success label-sm waves-effect">Exam Published</a>  
                                                    <?php } else {
                                                        ?>
                                                        Not Published: <br/>
                                                        <a href="#" class="label label-warning label-sm waves-effect" data-toggle="modal" data-target="#large_modal">Click to Publish</a>
                                                        <?php
                                                        if (isset($schools) && count($schools) > 0) {
                                                            ?>
                                                            <div class="modal fade" id="large_modal" tabindex="-1" role="dialog">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <form action="<?= url('exam/createReport') ?>" method="post">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Publish Exam Report</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p>Fill this form to publish this Exam </p>
                                                                                <br/>

                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-2 col-form-label">Report Name</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" name="name" value="<?= $exam_definition->name ?>" disabled="">
                                                                                    </div>
                                                                                </div>


                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-2 col-form-label">Schools To Exclude</label>
                                                                                    <div class="col-sm-10">
                                                                                        <select name="schools[]" class="form-control col-sm-12" multiple="multiple">
                                                                                            <option value="0">Select One or more school</option>
                                                                                            <?php
                                                                                            foreach ($schools as $school) {
                                                                                                ?>
                                                                                                <option value="<?= $school->school ?>"><?= $school->school ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>


                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <?= csrf_field() ?>
                                                                                <input type="hidden" name="exam_id" value="<?= $exam_definition->id ?>"/>
                                                                                <input type="hidden" name="class_id" value="<?= $class_info->id ?>"/>
                                                                                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary waves-effect waves-light ">Publish Exam</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xl-3"></div>
                    </div>

                    <?php
                }
                if (count($reports) > 0 && request('type_id') != 'subject') {

                    $schools = [];
                    ?>
                    <div class="sttabs tabs-style-iconbox">

                        <ul class="nav nav-tabs md-tabs " role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home7" role="tab" aria-expanded="true"><i class="icofont icofont-home"></i>General Report</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile7" role="tab" aria-expanded="false"><i class="icofont icofont-ui-user "></i>Summary</a>
                                <div class="slide"></div>
                            </li>
                        </ul>

                        <div class="tab-content card-block">
                            <div class="tab-pane active" id="home7" role="tabpanel" aria-expanded="true">

                                <div class="col-lg-12 table-responsive">

                                    <table id="example23" class="dataTable nowrap table color-table success-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?= request('type_id') == 'school' ? 'School ' : 'Student ' ?> Name</th>
                                                <?php // request('type_id') == 'school' ? '' : '<th>Sex</th>'   ?>      
                                                <th>Subject</th>
                                                <th>Average</th>
                                                <th>Grade</th>
                                                <?= request('type_id') == 'school' ? '' : '<th class="col-sm-2">School Rank</th>' ?>
                                                <th class="col-sm-2">Overall Rank</th>
                                                <?= request('type_id') == 'school' ? '<th>Action</th>' : '<th>School</th>' ?>
                                                <!--<th>Region</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $grade_school = [];
                                            foreach ($grades as $grade) {
                                                $grade_{$grade->grade} = 0;
                                                //$grade_school[$grade->grade]=[];
                                            }

                                            foreach ($reports as $report) {
                                                $grade_{$report->grade} ++;

                                                array_push($grade_school, [$report->schema_name => $report->grade]);
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= request('type_id') == 'school' ? $report->schema_name : $report->name ?></td>
                                                    <!--                                                 <?php // request('type_id') == 'school' ? '' : '<td>'.$report->sex.'</td>'                      ?> -->
                                                    <td><?= ucfirst(request('subject_id')) == '0' ? 'All Subjects' : ucfirst(request('subject_id')) ?></td>
                                                    <td><?= $report->average ?></td>
                                                    <td><?= $report->grade ?></td>
                                                    <?= request('type_id') == 'school' ? '' : '<td>' . $report->school_rank . '</td>' ?>
                                                    <td><?= $report->rank ?></td>
                                                    <?php
                                                    if (request('type_id') == 'school') {
                                                        ?>
                                                        <td>


                                                            <form action="<?= url('exam/report/single/null?token=' . request('token')) ?>" method="post">
                                                                <input type="hidden" value="<?= $exam_definition->id ?>" name="exam_id"/>
                                                                <input type="hidden" value="<?= $class_info->id ?>" name="class_id"/>
                                                                <input type="hidden" value="all" name="subject_id"/>
                                                                <input type="hidden" value="subject" name="type_id"/>
                                                                <input type="hidden" value="<?= $report->schema_name ?>" name="school"/>
                                                                <input type="hidden" value="<?= request('token') ?>" name="token"/>
                                                                <?= csrf_field() ?>
                                                                <button type="submit" class="btn btn-sm btn-success btn-sm" href="#">View </button>
                                                                <a href="#" onclick="return false" data-toggle="modal" data-target="#large-Modal" class="btn btn-info btn-sm">Link with ShuleSoft</a>
                                                            </form>


                                                        </td>
                                                    <?php } else { ?>
                                                        <td>
                                                            <?= $report->schema_name ?>
                                                        </td>
                                                    <?php } ?>
        <!--<td><?php //$report->region                     ?></td>-->
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>        
                                </div>
                            </div>
                            <div  class="tab-pane" id="profile7" role="tabpanel" aria-expanded="false">
                                <h2>Summary</h2>
                                <div class="col-lg-12 table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <?php foreach ($grades as $grade) { ?>
                                                    <th><?= $grade->grade ?></th>                                 
                                                <?php }
                                                ?>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>No of <?= request('type_id') == 'school' ? 'Schools ' : 'Students ' ?></td>
                                                <?php foreach ($grades as $grade) { ?>
                                                    <td><?= $grade_{$grade->grade} ?></td>                                 
                                                <?php }
                                                ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <h2>Grading Summary per School</h2>

                                <?php
                                $vals = array_values($grade_school);
                                $schemas = [];
                                $mc = [];
                                foreach ($vals as $key => $val) {
                                    foreach ($val as $k => $sc) {
                                        array_push($schemas, $k);
                                        $mc[$k][$sc] = 0;
                                    }
                                }
                                foreach ($vals as $key => $val) {
                                    foreach ($val as $k => $sc) {
                                        $mc[$k][$sc] ++;
                                    }
                                }
                                $uschemas = (array_unique($schemas));
                                ?>
                                <div class="col-lg-12 table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>School</th>
                                                <?php foreach ($grades as $grade) { ?>
                                                    <th><?= $grade->grade ?></th>                                 
                                                <?php }
                                                ?>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($uschemas as $sname) {
                                                ?>
                                                <tr>
                                                    <td><?= $sname ?></td>
                                                    <?php foreach ($grades as $grade) { ?>
                                                        <td><?= isset($mc[$sname][$grade->grade]) ? $mc[$sname][$grade->grade] : 0 ?></td>                                 
                                                    <?php }
                                                    ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 

                    </div>


                <?php } ?>
                <?php
                if (request('type_id') == 'subject') {
                    ?>
                    @include('exam.single.ajax_report')    
                <?php } ?>
            </div>


        </div>
    </div>
</div>

<div class="modal fade" id="large-Modal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1050; display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Link Mofet Results with ShuleSoft</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Do you use ShuleSoft in your School ?</h5>
                <div id="shulesoft_instruction">
                    <p>You can link these results to your school and get these benefits</p>
                    <ul class="list-group">
                        <li class="list-group-item "> 
                            <i class="icofont icofont-eye-alt text-success"></i> 
                            All parents will be able to view these results in their ShuleSoft account or via SMS notifications</li>
                        <li  class="list-group-item "> <i class="icofont icofont-eye-alt text-success"></i>  You will get more statistics and analysis to help you analyze your performance and improve. These includes comparison charts from previous exams, class wise average, comparison with other exams, correlation of your school performance with age, distance from school, teachers qualifications etc</li>

                        <li  class="list-group-item "> 
                            <i class="icofont icofont-eye-alt text-success"></i>  Automated generated student report cards</li>
                    </ul>
                </div>
                <a href="#" onclick="return false" onmousedown="$('#shulesoft_instruction,#login_form').toggle()">Click here to link with ShuleSoft</a> or if you are not using ShuleSoft,  <a href="https://www.shulesoft.com/join-now" target="_blank">click here to join shulesoft</a>
                <div id="ajax_res"></div>
                <div class="card-block" style="display: none;" id="login_form">
                    <form id="main" method="post" action="#" novalidate="">
                        <div class="form-group row has-success">
                            <label class="col-sm-2 col-form-label">Select Your School </label>
                            <div class="col-sm-10">
                                <select name="school" id="school_name" class="form-control col-sm-12">
                                    <option value="0">Select school</option>
                                    <?php
                                    $shulesoft_schools = DB::select('select distinct "schema_name" from admin.all_setting');
                                    foreach ($shulesoft_schools as $sschool) {
                                        ?>
                                        <option value="<?= $sschool->schema_name ?>"><?= $sschool->schema_name ?></option>
                                    <?php } ?>
                                </select>
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10">
                                <button type="button" onmousedown="link_shulesoft()" class="btn btn-primary m-b-0">Submit to Link</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#exam_id').change(function (event) {
        var exam_id = $(this).val();
        var class_id = 8;
        if (exam_id === '0') {
            $('#subject_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('exam/getSubjects/null') ?>",
                data: "class_id=" + class_id + '&exam_id=' + exam_id + '&token=<?= request('token') ?>',
                dataType: "html",
                success: function (data) {
                    $('#subject_id').html(data);
                }
            });
        }
    });
    $('#exam_id').change(function (event) {

        var exam_id = $(this).val();
        if (exam_id === '0') {
            $('#option_exam_parts').hide();
        } else {
            $('#option_exam_parts').show();
        }
    });
    link_shulesoft = function () {
        var school = $('#school_name').val();
        if (school === '0') {
            $('#ajax_res').html('<div class="alert alert-danger">Please Select School Name First</div>');
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('exam/remoteLogin/null') ?>",
                data: "school=" + school + '&token=<?= request('token') ?>&password',
                dataType: "html",
                success: function (data) {
                    $('#ajax_res').hide();
                    $('#login_form').hide();
                    $('#login_form').after(data);
                }
            });
        }
    }
</script>
@endsection

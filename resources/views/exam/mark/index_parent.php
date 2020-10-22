
<link href="<?php echo base_url('public/css/tabs.css'); ?>" rel="stylesheet">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>User Profile</h3>
        </div>
        <?php if (sizeof($allstudents) > 0) { ?>
            <div class="title_right">
                <div class="list-group-item list-group-item-warning">
                    <form style="" class="form-horizontal" role="form" method="post">  
                        <div class="form-group">              
                            <label for="student_id" class="col-sm-2 col-sm-offset-2 control-label">
                                <?= $data->lang->line("mark_student") ?>
                            </label>
                            <div class="col-sm-6">
                                <?php
                                $array = array("0" => $data->lang->line("mark_select_student"));
                                if ($allstudents) {
                                    foreach ($allstudents as $allstudent) {
                                        $array[$allstudent->student->student_id] = $allstudent->student->name;
                                    }
                                }
                                echo form_dropdown("student_id", $array, old("student_id", $set), "id='student_id' class='form-control'");
                                ?>
                            </div>
                        </div>
                        <?= csrf_field() ?>
                    </form>

                </div>
                <br/>
            </div>
        <?php } ?>
    </div>

    <div class="clearfix"></div>

    <div class="row" id="load_information">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Student  <small>Activity report</small></h2>
                    <ul class="nav navbar-right panel_toolbox">

                        <li><a class="close-link" onclick="printDiv('load_information')"><i class="fa fa-print"></i>print</a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-lg-3 profile_left">
                        <div class="profile_img">
                            <div id="crop-avatar">
                                <!-- Current avatar -->  
                                <img class="img-responsive avatar-view center" src="<?= base_url('storage/uploads/images/' . $student->photo) ?>" alt="ShuleSoft" title="<?= $student->name ?>" width="100%" height="100%">
                            </div>
                        </div>
                        <br/>
                        <h3><?= $student->name ?></h3>
                        <br/>
                        <ul class="list-unstyled user_data">
                            <li>
                                <i class="fa fa-file user-profile-icon"></i> 
                                <span><?= $data->lang->line("mark_roll") ?> </span>: <?= $student->roll ?>

                            </li>
                            <li>
                                <i class="fa fa-map-marker user-profile-icon"></i> 
                                <span><?= $data->lang->line("mark_address") ?> </span>: <?= $student->address ?>

                            </li>

                            <li>
                                <i class="fa fa-briefcase user-profile-icon"></i> 
                                <?= $student->classes->classes ?> :- <?= $student->section->section ?>
                            </li>


                        </ul>
                        <?php
                        echo can_access('view_student') ? '<a  href="' . base_url("/student/view/$student->student_id/$student->classesID") . ' " class="btn btn-success btn-xs"><i class="fa fa-folder"></i>View </a>' : '';
                        ?>
                        <?php if (can_access('view_student')) { ?>
                            <a class="btn btn-success btn-xs" href="<?= base_url('student/edit/' . $student->student_id . "/" . $student->classesID) ?>"><i class="fa fa-edit m-right-xs"></i>Edit</a>
                        <?php } ?>
<!--<a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>-->
                        <br>
                        <br>
                        <!-- start skills -->
                        <!--                        <h4>Other Information</h4>
                                                <ul class="list-unstyled user_data">
                                                    <li>
                        
                                                        <a href="#"><p>View Invoices</p></a>
                        
                                                    </li>
                                                    <li>
                        
                                                        <a href="#"> <p>View Payments</p></a>
                                                    </li>
                        
                                                </ul>-->
                        <!-- end of skills -->

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                        <div class="profile_title">
                            <div class="col-md-6">
                                <h2>Student Graphical Progress Report</h2>
                            </div>
                            <div class="col-md-6">
                                <div id="reportrange" class="pull-right" style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span>Year</span> <select name="academic_year_graph" id="academic_year_graph">
                                        <option value="">Select</option>
                                        <?php foreach ($student_archive as $archive) { ?> 
                                            <option value="<?= $archive->academicYear->id ?>"><?= $archive->academicYear->name ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- start of user-activity-graph -->
                        <div id="">
                            <script type="text/javascript">
                                $(function () {

                                    $('#container').highcharts({
                                        chart: {
                                            type: 'column'
                                        },
                                        title: {
                                            text: "<?= ucfirst($student->name) . " - " ?>Performance Evaluation"
                                        },
                                        subtitle: {
                                            text: 'Performance average on each exam done by <?= ucfirst($student->name) ?>'
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Average %'
                                            }

                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },

                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                                        },

                                        series: [{
                                                name: 'Exam Average',
                                                colorByPoint: true,
                                                data: [
<?php
$i = 0;
if (sizeof($student_avg) > 0) {
    foreach ($student_avg as $key => $value) {
        ?>
                                                            {
                                                                name: "<?= $value->exam ?>",
                                                                y: <?= $value->average ?>,
                                                                drilldown: '<?= $value->average ?>'
                                                            },
        <?php
        $i++;
    }
}
?>
                                                ]
                                            }]
                                    });
                                });

                            </script>
                            <script src="<?= base_url('public/assets/js/highchart.js') ?>"></script>
                            <script src="<?= base_url('public/assets/js/exporting.js') ?>"></script>
                            <?php
                            $validity = (new \App\Http\Controllers\Mark())->checkReportValidityToShow($siteinfos, $student, $academic_year_id, $current_class_id);

                            if ($validity[0] == TRUE) {
                                echo '<div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>';
                            } else {
                                echo $validity[1];
                            }
                            ?>
                        </div>


                        <!-- end of user-activity-graph -->
                        <section class="m-t-40">
                            <div class="sttabs tabs-style-iconbox">
                                <nav>
                                    <ul>
                                        <?php
                                        $ix = 1;
                                        foreach ($student_archive as $archive) {
                                            $class_name = \App\Model\Classes::find($archive->section->classesID);
                                            ?>
                                            <li class="<?= $i == 1 ? 'tab-current' : '' ?>"><a href="#section-iconbox-<?= $archive->id ?>" class="sticon ti-home fa fa-file"><?= $archive->section->classes->classes ?>-<?= $archive->academicYear->name ?></a></li>
                                            <?php
                                            $ix++;
                                        }
                                        ?>

                                    </ul>
                                </nav>
                                <div class="content-wrap">
                                    <?php
                                    foreach ($student_archive as $archive) {
                                        $j = 1;

                                        $semesters = \App\Model\Semester::where('academic_year_id', $archive->academic_year_id)->get();
                                        $student_subject = \App\Model\SubjectCount::where('student_id', $archive->student_id)->where('academic_year_id', $archive->academic_year_id)->count();
                                        ?>
                                        <section id="section-iconbox-<?= $archive->id ?>" class="<?= $j == 1 ? 'content-current' : '' ?>">
                                            <div class="x_panel">

                                                <div class="x_content">
                                                    <ul class="list-unstyled">
                                                        <?php
                                                        $j + 1;
                                                        $k = 1;
                                                        $student_record = $archive->student;
                                                        $student_report_validity = (new \App\Http\Controllers\Mark())->checkReportValidityToShow($siteinfos, $student_record, $archive->academic_year_id, $archive->section->classesID);
                                                        if ($student_report_validity[0] == false) {
                                                            echo $student_report_validity[1];
                                                        } else {
                                                            foreach ($semesters as $key => $semester) {
                                                                ?>

                                                                <h2 class="tags lead green">
                                                                    <?= $semester->name ?>
                                                                </h2>
                                                                <hr/>
                                                                <ul style="margin-left:1em">
                                                                    <div>
                                                                        <div>
                                                                            <div>
                                                                                <p class="lead"><?= $data->lang->line("report_information") ?></p>
                                                                                <h3>Single Exams Reports</h3>
                                                                                <br/>
                                                                                <?php
                                                                                if ($siteinfos->publish_exam == 0) {
                                                                                    $exams = \DB::select('select  a."examID", a.academic_year_id, a."classesID", b.date, b.exam from ' . set_schema_name() . 'student_exams a JOIN ' . set_schema_name() . 'exam b on a."examID"=b."examID"  WHERE a."student_id"=' . $archive->student_id . ' and b.semester_id=' . $semester->id . ' and a."examID" IN (SELECT exam_id from ' . set_schema_name() . 'exam_report where academic_year_id=' . $archive->academic_year_id . ') order by b.date');
                                                                                } else {
                                                                                    $exams = \DB::select('select  a."examID", a.academic_year_id, a."classesID", b.date, b.exam from ' . set_schema_name() . 'student_exams a JOIN ' . set_schema_name() . 'exam b on a."examID"=b."examID"  WHERE a."student_id"=' . $archive->student_id . ' and b.semester_id=' . $semester->id . ' order by b.date');
                                                                                }
                                                                                if (sizeof($exams) > 0) {
                                                                                    ?>
                                                                                    <div id="hide-table">
                                                                                        <table class="table table-striped table-bordered">
                                                                                            <thead class="headings">
                                                                                                <tr>
                                                                                                    <th class="col-sm-2"><?= $data->lang->line('exam_name') ?></th>
                                                                                                    <th class="col-sm-2"><?= $data->lang->line('exam_date') ?></th>
                                                                                                    <th class="col-sm-2"><?= $data->lang->line('marking_status') ?></th>
                                                                                                    <th class="col-sm-4"><?= $data->lang->line('action') ?></th>

                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php
                                                                                                foreach ($exams as $exam) {
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td  data-title="<?= $data->lang->line('exam_name') ?>"><?= ucfirst($exam->exam) ?></td>
                                                                                                        <td data-title="<?= $data->lang->line('exam_date') ?>"><?= date('d M Y', strtotime($exam->date)) ?></td>
                                                                                                        <td data-title="<?= $data->lang->line('marking_status') ?>"><?php
                                                                                                          
                                                                                                                $marked_subjects = \collect(\DB::select('select count(distinct "subjectID") FROM ' . set_schema_name() . 'mark_info where "student_id"=' . $archive->student_id . ' and academic_year_id=' . $archive->academic_year_id . ' and "examID"=' . $exam->examID))->first();
                                                                                                            

                                                                                                            $diff = $student_subject - $marked_subjects->count;
                                                                                                            if ($diff == 0) {
                                                                                                                echo '<b class="badge tag badge-success">complete</b>';
                                                                                                            } else {
                                                                                                                echo $marked_subjects->count . ' out of ' . $student_subject;
                                                                                                            }
                                                                                                            ?></td>
                                                                                                        <td  data-title="<?= $data->lang->line('action') ?>"><a href="<?= base_url("exam/singlereport/" . $student->student_id . "?exam=" . $exam->examID . '&class_id=' . $exam->classesID . '&year_no=' . $exam->academic_year_id) ?>" class="btn btn-xs mrg btn-info"> <i class="fa fa-file"></i>  <?= $data->lang->line('view_report') ?></a>

                                                                                                            <a href="<?= base_url("exam/singleReportAnalysis/" . $student->student_id . "/" . $exam->examID . '/' . $exam->academic_year_id) ?>" class="btn btn-xs mrg btn-success"> <i class="fa fa-file-o"></i><?= $data->lang->line('view_graph') ?> </a>

                                                                                                        </td>
                                                                                                    </tr>

                                                                                                    <?php // base_url('exam/singlereport/' . $student->student_id . '?exam=' . $examID.'&class_id='.$classesID.'&year_no='.$academic_year_id)          ?>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                    <?php
                                                                                } else {
                                                                                    $message = sprintf($data->lang->line('no_single_report'), $siteinfos->phone);
                                                                                    // echo '<div class="alert alert-info">'.$message.'</div>';
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                            <?php
                                                                            $qualitative_exams = \DB::select('select distinct b.exam, b."examID", b.date from ' . set_schema_name() . 'student_characters a JOIN ' . set_schema_name() . 'exam b on a.exam_id=b."examID"  WHERE a.student_id=' . $archive->student_id . ' and b.semester_id=' . $semester->id . ' order by b.date');
                                                                            if (sizeof($qualitative_exams) > 0) {
                                                                                ?>
                                                                                <h2>Qualitative Assessment Reports</h2>

                                                                                <div id="hide-table">
                                                                                    <table class="table table-striped table-bordered">
                                                                                        <thead class="headings">
                                                                                            <tr>
                                                                                                <th class="col-sm-2"><?= $data->lang->line('exam_name') ?></th>
                                                                                                <th class="col-sm-2"><?= $data->lang->line('exam_date') ?></th>

                                                                                                <th class="col-sm-4"><?= $data->lang->line('action') ?></th>

                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php
                                                                                            foreach ($qualitative_exams as $qexam) {
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td  data-title="<?= $data->lang->line('exam_name') ?>"><?= ucfirst($qexam->exam) ?></td>
                                                                                                    <td data-title="<?= $data->lang->line('exam_date') ?>"><?= date('d M Y', strtotime($qexam->date)) ?></td>

                                                                                                    <td  data-title="<?= $data->lang->line('action') ?>">                         <?php echo btn_view('general_character_assessment/report/' . $qexam->examID . '/' . $archive->section_id . '/' . $archive->student_id . '/' . $archive->academic_year_id, $data->lang->line('view')); ?>


                                                                                                    </td>
                                                                                                </tr>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <br/>
                                                                            <h1>School Official Reports</h1>
                                                                            <div id="hide-table">
                                                                                <?php
                                                                                $exams_report = \DB::select('SELECT a.* from ' . set_schema_name() . 'exam_report a where a.classes_id in (select "classesID" FROM ' . set_schema_name() . 'section where "sectionID"=' . $archive->section_id . ') and a.combined_exams !=\'0\'  and a.academic_year_id=' . $archive->academic_year_id . ' and a.semester_id=' . $semester->id . '');
                                                                                if (sizeof($exams_report) > 0) {
                                                                                    ?>
                                                                                    <table class="table table-striped table-bordered">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th class="col-sm-2"><?= $data->lang->line('exam_name') ?></th>
                                                                                                <th class="col-sm-2"><?= $data->lang->line('exam_date') ?></th>
                                                                                                <th class="col-sm-2"><?= $data->lang->line('action') ?></th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php
                                                                                            foreach ($exams_report as $rep) {
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td   data-title="<?= $data->lang->line('exam_name') ?>"><?= $rep->name == '' ? 'Academic Report' : $rep->name ?></td>
                                                                                                    <td   data-title="<?= $data->lang->line('exam_date') ?>"><?= date('d M Y', strtotime($rep->created_at)) ?></td>
                                                                                                    <td   data-title="<?= $data->lang->line('action') ?>"><a href='<?= base_url("exam/singlecombined/" . $student->student_id . "?exam=" . $rep->combined_exams . "&year_no=" . $rep->academic_year_id . "&exam_percent=" . $rep->percent) ?>' class="btn btn-xs mrg btn-info"> <i class="fa fa-file"></i> <?= $data->lang->line('view_report') ?></a>
                                                                                                        <a href="<?php echo base_url('exam/evaluation/' . $student->student_id . '?year_no=' . $rep->academic_year_id . '&exam=' . $rep->combined_exams . '&percent=' . $rep->percent) ?>&tag=all" class="btn btn-success btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Analyse Report"><i class="fa fa-file-text-o"> 
                                                                                                                <?= $data->lang->line('view_graph') ?>

                                                                                                        </a>

                                                                                                    </td>
                                                                                                </tr>
                                                                                            <?php } ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    <?php
                                                                                } else {
                                                                                    $official_message = sprintf($data->lang->line('no_official_report'), $siteinfos->phone);
                                                                                    //  echo '<div class="alert alert-info">'.$official_message.'</div>';
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </ul>
                                                                <?php
                                                                $k++;
                                                            }
                                                        }
                                                        ?>

                                                    </ul>

                                                </div>
                                            </div>

                                        </section>
                                        <?php
                                    }
                                    ?>


                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('public/js/cbpFWTabs.js') ?>"></script>
<script type="text/javascript">
                                (function () {
                                    [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                                        new CBPFWTabs(el);
                                    });
                                })();
</script>
<script type="text/javascript">
    $('#student_id').change(function () {
        var student_id = $(this).val();
        if (student_id == 0) {
            $('#hide-table').hide();
        } else {
            window.location.href = "<?= base_url('mark/index/') ?>/" + student_id;
        }
    });

    $('#academic_year_graph').change(function () {
        var academic_year_graph = $(this).val();
        var student_id = $('#student_id').val();
        if (academic_year_graph == 0 || student_id == 0) {
            return false;
        } else {
            window.location.href = "<?= base_url('mark/index') ?>/" + student_id + '/' + academic_year_graph;
        }
    });
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;
    }
</script>

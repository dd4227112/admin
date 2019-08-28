<?php
/**
 * Description of report
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<style>
    /*    .verticalTableHeader {
            text-align:center;
            transform: rotate(-90deg);
    
        }
        .verticalTableHeader p {
            margin:0 -100% ;
            display:inline-block;
            font-weight: bolder;
        }
        .verticalTableHeader p:before{
            content:'';
            width:0;
            padding-top:110%; takes width as reference, + 10% for faking some extra padding 
            display:inline-block;
            vertical-align:middle;
        }*/
</style>

<div class="sub-title">Tab With Icon</div>                                        
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
            <h3>Exam General Report</h3>
            <div id="hide-table" class="table-responsive">
                <?php
                $subjectID = 0;
                $pass_mark = 50;
                $examID = 1;
                $classesID = 1;
                $academic_year_id = 1;
                $show_grade = 1;

                $col_span = isset($show_grade) && $show_grade == 1 ? 'colspan="2"' : '';
                $row_span = isset($show_grade) && $show_grade == 1 ? 'rowspan="2"' : '';
                ?>

                <table  id="example23" class="table table-bordered dataTable">
                    <thead>
                        <tr>
                            <th class="col-sm-1" <?= $row_span ?>>#</th>
                            <th class="col-sm-2" <?= $row_span ?>>Name</th>
                            <th class="col-sm-2" <?= $row_span ?>>Sex</th>
                            <th class="col-sm-1" <?= $row_span ?>>Admission Number</th>

                            <?php
                            if ($subjectID == 0) {
                                $average = 'AVG';
                                //Loop in all subjects to show list of them here
                                if (isset($subjects)) {
                                    foreach ($subjects as $subject) {
                                        $subj = strtolower($subject->subject_name);
                                        $sum_subj[$subj] = 0;
                                        $pass["$subj"] = 0;
                                        $fail["$subj"] = 0;
                                        $subject_sum["$subj"] = 0;
                                        echo!empty($subject) ?
                                                '<th class="col-sm-1 verticalTableHeader" ' . $col_span . '>'
                                                . '<p>' . substr(strtoupper($subject->subject_name), 0, 4) . ''
                                                . '</p></th>' : '<th></th>';
                                    }
                                }
                            } else {
                                $average = 'Subject Average';
                                echo '<th class="col-sm-2">Subject Name</th>';
                            }
                            ?>

                            <th class="col-sm-2" <?= $row_span ?>>Total Marks</th>

                            <th class="col-sm-2" <?= $row_span ?>><?= $average ?></th>
                            <th class="col-sm-2" <?= $row_span ?>>Grade</th>

                            <?php if (true) { ?>
                                                                    <!--                    <th <?= $row_span ?>>Div</th>
                                                                                        <th <?= $row_span ?>>Point</th>-->
                            <?php } ?>
                            <th class="col-sm-2" <?= $row_span ?>>School Rank</th>
                            <th class="col-sm-2" <?= $row_span ?>>Overall Rank</th>
                            <!--<th class="col-sm-2">Total Point</th>-->
                            <th class="col-sm-3" id="action_option" <?= $row_span ?>>School</th>
                        </tr>
                        <?php if (isset($subjects) && isset($show_grade) && $show_grade == 1) { ?>
                            <tr>
                                <?php
                                foreach ($subjects as $subject) {
                                    if (!empty($subject)) {
                                        ?>
                                        <th  class="col-sm-1"><?= substr(strtoupper($subject->subject_name), 0, 3) ?></th> <th class="col-sm-1">GD</th>
                                        <?php
                                    }
                                }
                                ?>
                            </tr>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php
                        if (count($reports)) {
                            $i = 1;
                            $student_pass = 0;
                            $total_average = 0;
                            $total_div_I = 0;
                            $total_div_II = 0;
                            $total_div_III = 0;
                            $total_div_IV = 0;
                            $total_div_0 = 0;

                            foreach ($subjects as $subject) {
                                $subject_name = strtolower($subject->subject_name);
                                foreach ($grades as $grade) {
                                    ${$subject_name . '_' . $grade->grade} = 0;
                                }
                            }
                            $boys = 0;
                            $girls = 0;
                            $boys_pass = 0;
                            $girls_pass = 0;
                            $boys_average = 0;
                            $girls_average = 0;

                            foreach ($reports as $student) {
                                strtolower($student->sex) == 'male' ? $boys++ : $girls++;
                                ?>
                                <tr>
                                    <td data-title="#">
                                        <?php echo $i ?>
                                    </td>
                                    <td data-title="Name">
                                        <?= $student->name; ?>
                                    </td>
                                    <td data-title="Sex">
                                        <?= $student->sex; ?>
                                    </td>
                                    <td data-title="Roll">
                                        <?= $student->roll ?>
                                    </td>
                                    <?php
                                    /*
                                     * 
                                     * -----------------------------------------
                                     * This part show list of all subjects or ONE
                                     *  subject depends on user selection
                                     * -----------------------------------------
                                     * 
                                     */

                                    if ($subjectID == 0) {

                                        $point[$student->student_id] = [];
                                        foreach ($subjects as $subject) {
                                            $subject_name = strtolower($subject->subject_name);


                                            if (isset($student->{$subject_name})) {
                                                if ($student->{$subject_name} < $pass_mark && $student->{$subject_name} != NULL) {

                                                    $color = "pink";
                                                    $fail["$subject_name"] ++;
                                                } else {
                                                    $color = "";
                                                    $student->{$subject_name} != NULL ? $pass["$subject_name"] ++ : '';
                                                }
                                                $subject_sum["$subject_name"] += $student->{$subject_name};

                                                echo '<td  class="mark" subject_id="" student_id="' . $student->student_id . '" data-title="' . $subject_name . '" style="background: ' . $color . ';">';
                                                echo $student->{$subject_name};
                                                echo '</td>';
                                                if (isset($show_grade) && $show_grade == 1) {
                                                    foreach ($grades as $grade) {
                                                        if ($grade->gradefrom <= round($student->{$subject_name}, 0) && $grade->gradeupto >= round($student->{$subject_name}, 0)) {


                                                            echo ' <td>' . $grade->grade . '</td>';
                                                        }
                                                    }
                                                }

                                                $sum_subj[$subject_name] += $student->{$subject_name};
//
                                                foreach ($grades as $grade) {
                                                    if ($grade->gradefrom <= round($student->{$subject_name}, 0) && $grade->gradeupto >= round($student->{$subject_name}, 0)) {
                                                        ${$subject_name . '_' . $grade->grade} ++;
                                                        $sub = [
                                                            'subject_mark' => round($student->{$subject_name}, 0),
                                                            'point' => $grade->point,
                                                            'penalty' => isset($subject->is_penalty) ? 1 : 1,
                                                            'pass_mark' => isset($subject->pass_mark) ? 1 : 1,
                                                            'is_counted_indivision' => isset($subject->is_counted_indivision) ? 1 : 1
                                                        ];
                                                        array_push($point[$student->student_id], $sub);
                                                    }
                                                }
                                            } else {
                                                //here you will check if this student subscribe to this subject or not . if yes, place a yellow box, if not disable the input if result format is based on the subject counted otherwise, place yellow and content editable in all cases
                                                echo '<td  data-title="' . $subject_name . '" class="mark" subject_id="" student_id="' . $student->student_id . '"></td>';
                                                echo isset($show_grade) && $show_grade == 1 ? '<td></td>' : '';
                                            }
                                        }
                                    } else {

                                        echo '<td data-title="subject">';
                                        echo $student['subject'];
                                        echo '</td>';
                                    }

                                    if ($subjectID == '0') {
                                        echo '<td data-title="Total">' . $student->total . ' </td>';
                                    } else {
                                        if ((isset($student['mark']) && $student['mark'] < $pass_mark)) {

                                            $color = "pink";
                                        } else {
                                            $color = "";
                                            $student_pass++;
                                            strtolower($student->sex) == 'male' ? $boys_pass++ : $girls_pass++;
                                        }

                                        //

                                        echo '<td style="background-color:' . $color . '">' . $student->mark . '</td>';
                                    }
                                    ?>
                                    <?php if ($subjectID == 0) { ?> 

                                    <?php } ?>
                                    <?php
                                    if ($subjectID == '0') {

                                        /**
                                         * For the whole class, find total marks of that student
                                         * and devide by total subjects taken by such student
                                         */
                                        if ((isset($student) && $student->average < $pass_mark)) {

                                            $color = "pink";
                                        } else {
                                            $color = "";
                                            $student_pass++;
                                            strtolower($student->sex) == 'male' ? $boys_pass++ : $girls_pass++;
                                        }
                                        $total_average += $student->average;
                                        strtolower($student->sex) == 'male' ? $boys_average += $student->average : $girls_average += $student->average;
                                        echo '<td data-title="" style="background: ' . $color . ';">';
                                        echo $student->average;
                                        echo '</td>';


                                        foreach ($grades as $grade) {
                                            if ($grade->gradefrom <= round($student->average, 0) && $grade->gradeupto >= round($student->average, 0)) {
                                                echo '<td>' . $grade->grade . '</td>';
                                                break;
                                            }
                                        }
                                    } else {
                                        /*
                                         * For one subject, just find total marks 
                                         * for that subject and devide by number of students
                                         */
                                        $total_marks = 0;
                                        foreach ($students as $student_sum) {

                                            $total_marks += $student_sum->mark;
                                        }
                                        $class_average_marks = $total_marks / count($students);
                                        $color = $class_average_marks < $pass_mark ? "pink" : "";
                                        echo '<td data-title="AVG" style="background: ' . $color . ';">';
                                        echo round($class_average_marks, 2);
                                        echo '</td>';
                                    }
                                    ?>
                                    <?php if (true) { ?>
                                                                                                                                                                                                                                        <!--<td data-title='Div'>-->
                                        <?php
//                                                    if ($classlevel->result_format == 'ACSEE') {
////                                                        echo '<span  class="division" format="' . $classlevel->result_format . '" student_id="' . $student['student_id'] . '" exam_id="' . $examID . '" class_id="' . $classesID . '" id="div' . $student['student_id'] . $examID . $classesID . '"></span>';
//                                                        $div = (new \app\Http\Controllers\exam())->getAcseeDivision($student['student_id'], $examID, $classesID);
//                                                        echo $division[0] = acseeDivision($div[0], $div[1]);
//                                                        $division[1] = $div[0];
//                                                    } else {
//                                                        $division = (new \app\Http\Controllers\exam())->getDivision($student['student_id'], $examID, $classesID);
//                                                        echo $division[0];
//                                                    }
//                                $division = getDivisionBySort($point[$student->student_id], 'CSEE');
//
//                                echo $division[0];
//
//
//
//
//                                $total_div_0 += $division[0] == '0' ? 1 : 0;
//                                $total_div_I += $division[0] == 'I' ? 1 : 0;
//                                $total_div_II += $division[0] == 'II' ? 1 : 0;
//                                $total_div_III += $division[0] == 'III' ? 1 : 0;
//                                $total_div_IV += $division[0] == 'IV' ? 1 : 0;
                                        ?>
                                        <!--</td>--> 
                        <!--                            <td data-title='points'>
                                                <span class="point" id="points<?= $student->student_id . $examID . $classesID ?>"></span>
                                        <?php
                                        //echo $division[1];
                                        ?></td>-->
                                    <?php } ?>
                                    <td data-title="School Rank">
                                        <?php echo $student->school_rank; ?>
                                    </td>
                                    <td data-title="Overall Rank">
                                        <?php echo $student->rank; ?>
                                    </td>

                                    <td data-title="Action" class="action_btn">
                                        <?php echo $student->schema_name; ?>

                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                    <?php
                    if (true) {
                        ?>
                        <tfoot>

                            <tr>
                                <th class="col-sm-1"></th>
                                <!--<th class="col-sm-2">Photo</th>-->
                                <th class="col-sm-2">AVG</th>
                                <th class="col-sm-1"></th>
                                <th class="col-sm-1"></th>

                                <?php
                                if ($subjectID == 0) {
                                    //Loop in all subjects to show list of them here
                                    if (isset($subjects)) {
                                        foreach ($subjects as $subject) {
                                            if (isset($subject_evaluations)) {
                                                foreach ($subject_evaluations as $subject_class_ev) {

                                                    if ($subject->subject_name == $subject_class_ev->subject_name) {
                                                        echo '<th class="col-sm-2"> ' . $subject_class_ev->average . '</th>';
                                                        if (isset($show_grade) && $show_grade == 1) {
                                                            foreach ($grades as $grade) {
                                                                if ($grade->gradefrom <= round($subject_class_ev->average, 0) && $grade->gradeupto >= round($subject_class_ev->average, 0)) {


                                                                    echo ' <td>' . $grade->grade . '</td>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {

                                    echo '<th class="col-sm-2">Subject Name</th>';
                                }
                                ?>

                                <th class="col-sm-2"></th>
                                <?php if ($subjectID == 0) { ?> 
                                                                                                                                                                                                                <!--<th class="col-sm-2">Subject Counted</th>-->
                                <?php } ?>
                                <th class="col-sm-2"></th>

                                <th class="col-sm-2"></th>
                                <th class="col-sm-2"></th>
                                <th class="col-sm-2"></th>
                               <!--<th class="col-sm-2">Point</th>-->
                                <th class="col-sm-3" id="action_option"></th>
                            </tr>
                            <tr>
                                <th class="col-sm-1"></th>
                                <!--<th class="col-sm-2">Rank</th>-->
                                <th class="col-sm-2">Rank</th>
                                <th class="col-sm-1"></th>
<th class="col-sm-1"></th>
                                <?php
                                if ($subjectID == 0) {
                                    //Loop in all subjects to show list of them here
                                    if (isset($subjects)) {
                                        foreach ($subjects as $subject) {
                                            if (isset($subject_evaluations)) {
                                                foreach ($subject_evaluations as $subject_class_ev) {

                                                    if ($subject->subject_name == $subject_class_ev->subject_name) {
                                                        echo '<th class="col-sm-2" ' . $col_span . '> ' . $subject_class_ev->ranking . '</th>';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {

                                    echo '<th class="col-sm-2">Subject Name</th>';
                                }
                                ?>

                                <th class="col-sm-2"></th>
                                <?php if ($subjectID == 0) { ?> 
                                                                                                                                                                                                                <!--<th class="col-sm-2">Subject Counted</th>-->
                                <?php } ?>
                                <th class="col-sm-2"></th>

                                <th class="col-sm-2"></th>
                                <th class="col-sm-2"></th>
                                <th class="col-sm-2"></th>
                                <!--<th class="col-sm-2">Points</th>-->
                                <th class="col-sm-3" id="action_option"></th>
                            </tr>
                        </tfoot>
                    <?php } ?>
                </table>

            </div>
        </div>
        <div  class="tab-pane" id="profile7" role="tabpanel" aria-expanded="false">
            <h2>Summary</h2>
            <div id="hide-table">
                <?php if ($subjectID == '0') { ?>
                    <div class="card">
                        <div class="">
                            <br/>

                            <h3>OVERALL PERFORMANCE</h3>
                            <br/>
                        </div>

                        <table  class="table table-striped table-bordered  table-hover no-footer">
                            <thead>
                                <tr>
                                    <th class="col-sm-1" rowspan="2" colspan="2">Students</th>
                                    <th class="col-sm-2">ABSENT</th>
                                    <th class="col-sm-2" >SAT</th>
                                    <th class="col-sm-2" >PASS</th>
                                    <th class="col-sm-2" >FAIL</th>
                                    <th class="col-sm-2">Class Exam Average</th>
                                </tr>
                                <tr>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>BOYS</td>
                                    <td><?= $boys ?></td>
                                    <td><?= count($reports) - count($reports) ?></td>
                                    <td><?= $boys ?></td>
                                    <td><?= $boys_pass ?></td>	
                                    <td><?= $boys - $boys_pass ?></td>
                                    <td><?= round($boys_average / $boys, 2) ?></td>	
                                </tr>
                                <tr>
                                    <td>GIRLS</td>
                                    <td><?= $girls ?></td>
                                    <td><?= count($reports) - count($reports) ?></td>
                                    <td><?= $girls ?></td>
                                    <td><?= $girls_pass ?></td>	
                                    <td><?= $girls - $girls_pass ?></td>
                                    <td><?= round($girls_average / $girls, 2) ?></td>	
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><?= count($reports) ?></td>
                                    <td><?= count($reports) - count($reports) ?></td>
                                    <td><?= count($reports) ?></td>
                                    <td><?= $student_pass ?></td>

                                    <td><?= count($reports) - $student_pass ?></td>
                                    <td><?= round($total_average / count($reports), 2) ?></td>	
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!--                    <h3>Average By Region with graphs</h3>
                                        <h3>SUBJECTS PERFORMANCE by average and sex</h3>
                                        <h3>SUBJECTS PERFORMANCE by region</h3>
                                        <h3>top 10 students by gender and overall</h3>
                                        <h3>SUBJECTS PERFORMANCE top students by subject</h3>-->

                    <div class="card">
                        <div class="title_left">
                            <br/>
                            <h3>Subjects Performance by Average</h3>
                            <br/>
                        </div>
                        <script src="https://code.highcharts.com/highcharts.js"></script>
                        <script src="https://code.highcharts.com/modules/data.js"></script>
                        <script type="text/javascript">
                            graph_disc = function () {
                                Highcharts.chart('container', {
                                    chart: {
                                        type: 'column'
                                    },
                                    title: {
                                        text: "Subject Performance Evaluation"
                                    },
                                    subtitle: {
                                        text: ''
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Avarage %'
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
                                            name: 'Avarage',
                                            colorByPoint: true,
                                            data: [
    <?php
    foreach ($subject_evaluations as $subject_ev) {
        $subj = strtolower($subject_ev->subject_name);
        $total_sat = $pass[$subj] + $fail[$subj];
        ?>
                                                    {
                                                        name: '<?= ucwords($subject_ev->subject_name) ?>',
                                                        y: <?php
        if ($total_sat == 0) {
            echo '0';
        } else {
            echo $subject_ev->average;
        }
        ?>,
                                                        drilldown: ''
                                                    },
        <?php
        $i++;
    } //}  
    ?>
                                            ]
                                        }]
                                });
                            }
                            $(document).ready(graph_disc);


                        </script>


                        <div id="container" style="min-width: 70%;  height: 480px; margin: 0 auto"></div>
                    </div>
                    <div class="card">
                        <table  class="table table-striped table-bordered  table-hover no-footer">
                            <thead>
                                <tr>
                                    <th class="col-sm-1">CODE</th>
                                    <th class="col-sm-3">NAME</th>
                                    <th class="col-sm-3">TYPE</th>
                                    <!--<th class="col-sm-2">REGISTERED</th>-->
                                    <th class="col-sm-1">SAT</th>
                                    <th class="col-sm-1">ABSENT</th>
                                    <th class="col-sm-2">PASS</th>
                                    <th class="col-sm-2">FAIL</th>
                                    <th class="col-sm-2">Average</th>
                                    <?php
                                    if (count($grades)) {
                                        foreach ($grades as $grade) {
                                            ?>
                                            <th class="col-sm-2"><?= $grade->grade ?></th>

                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_grade=[];
                                 foreach ($grades as $grade) {
                                     $total_grade[$grade->grade]=0;
                                 }
                                foreach ($subjects as $subject) {
                                    $subj = strtolower($subject->subject_name);
                                    $total_sat = $pass[$subj] + $fail[$subj];
                                    ?>
                                    <tr>
                                        <td>AB12</td>
                                        <td><?= ucwords($subject->subject_name) ?></td>
                                        <td><?= 'Core' ?></td>
                                        <td><?= $total_sat ?></td>
                                        <td><?= count($reports) - $total_sat ?></td>

                                        <td><?= $pass[$subj] ?></td>
                                        <td><?= $fail[$subj] ?></td>
                                        <td><?php
                                            if ($total_sat == 0) {
                                                echo '0';
                                            } else {
                                                echo round($subject_sum[$subj] / $total_sat, 2);
                                            }
                                            ?></td>

                                        <?php
                                        if (count($grades)) {
                                            foreach ($grades as $grade) {
                                                
                                                ?>
                                                <td><?= ${$subj . '_' . $grade->grade} ?></td>

                                                <?php
                                                $total_grade[$grade->grade]+=${$subj . '_' . $grade->grade};
                                            }
                                        }
                                        ?>
                                    </tr>
                                <?php } ?>
                                     <tr>
                                    <td colspan="8">Total</td>
                                    <?php
                                    if (count($grades)) {
                                        foreach ($grades as $grade) {
                                            ?>
                                            <td><?=$total_grade[$grade->grade]?></td>

                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                            </tbody>
                            <tfoot>
                               
                            </tfoot>
                            <tbody>
                                <tr>
                                    <td colspan="8">
                                        <br/>
                                        <br/>
                                        <h2>Percentage Equivalent</h2>
                                    </td>
                                    <?php
                                    if (count($grades)) {
                                        foreach ($grades as $grade) {
                                            ?>
                                            <td></td>

                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                            </tbody>
                            <tbody>
                                <?php
                                foreach ($subjects as $subject) {
                                    $subj = strtolower($subject->subject_name);
                                    $total_sat = $pass[$subj] + $fail[$subj];
                                    ?>
                                    <tr>
                                        <td>AB12</td>
                                        <td><?= ucwords($subject->subject_name) ?></td>
                                        <td><?= 'Core' ?></td>
                                        <td><?= round($total_sat * 100 / count($reports), 2) . '%' ?></td>
                                        <td><?php
                                            $absent = count($reports) - $total_sat;
                                            echo round($absent * 100 / count($reports), 2) . '%';
                                            ?></td>

                                        <td><?= round($pass[$subj] * 100 / count($reports), 2) . '%' ?></td>
                                        <td><?= round($fail[$subj] * 100 / count($reports), 2) . '%' ?></td>
                                        <td><?php
                                            if ($total_sat == 0) {
                                                echo '0';
                                            } else {
                                                echo round($subject_sum[$subj] / $total_sat, 2);
                                            }
                                            ?></td>

                                        <?php
                                        if (count($grades)) {
                                            foreach ($grades as $grade) {
                                                ?>
                                                <td><?= round(${$subj . '_' . $grade->grade} * 100 / count($reports), 2) . '%' ?></td>

                                                <?php
                                            }
                                        }
                                        ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if (false) { ?>

                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
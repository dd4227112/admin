
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-flask"></i> <?= $data->lang->line('panel_title') ?></h3>

        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i
                        class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li><a href="<?= base_url("mark/index") ?>"><?= $data->lang->line('menu_mark') ?></a></li>
            <li class="active"><?= $data->lang->line('menu_add') ?> <?= $data->lang->line('menu_mark') ?></li>
        </ol>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <a href="<?= base_url('mark/upload') ?>" id="upload_excel"  class="btn btn-success btn-sm mrg" data-placement="top" data-toggle="tooltip" data-original-title="Import From Excel"><i class="fa fa-cloud-upload"></i> <?= $data->lang->line("upload_mark") ?> (Excel)</a>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-6 col-xs-12 col-sm-offset-3 list-group">
                    <div class="list-group-item list-group-item-warning">
                        <form class="form-horizontal" method="post">


                            <?php
                            if (form_error($errors, 'classesID'))
                                echo "<div class='form-group has-error' >";
                            else
                                echo "<div class='form-group' >";
                            ?>
                            <label for="classesID" class="col-sm-2 col-sm-offset-2 control-label">
                                <?= $data->lang->line('mark_classes') ?>
                            </label>

                            <div class="col-sm-6 col-xs-12">
                                <?php
                                $array = array("0" => $data->lang->line("mark_select_classes"));
                                if (isset($classes) && count($classes) > 0) {
                                    foreach ($classes as $classa) {
                                        $array[$classa->classesID] = $classa->classes;
                                    }
                                }
                                echo form_dropdown("classesID", $array, old("classesID", null), " id='classesID' class='form-control'");
                                ?>
                            </div>
                    </div>

<?php
if (form_error($errors, 'academic_year_id'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
                    <label for="exam_academic_year" class="col-sm-2 col-sm-offset-2 control-label">
                    <?= $data->lang->line('exam_academic_year') ?>
                    </label>
                    <div class="col-sm-6 col-xs-12">
<?php
$ac_array = array("0" => $data->lang->line("exam_select_year"));
if (isset($academic_year) && count($academic_years) > 0) {
    foreach ($academic_years as $academic) {
        $ac_array[$academic->id] = $academic->name;
    }
}

echo form_dropdown("academic_year_id", $ac_array, old("academic_year_id"), "id='academic_year_id_mark' class='form-control'");
?>
                    </div>
                </div>
                        <?php
                        if (form_error($errors, 'sectionID'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                        ?>
                <label for="sectionID" class="col-sm-2 col-sm-offset-2 control-label">
                <?= $data->lang->line('mark_section') ?>
                </label>
                <div class="col-sm-6 col-xs-12">
                    <?php
                    $array = array("0" => $data->lang->line("mark_select_section"));
                    if (isset($sections) && count($sections) > 0) {
                        foreach ($sections as $section) {
                            $array[$section->sectionID] = $section->section;
                        }
                    }
                    echo form_dropdown("sectionID", $array, old("sectionID"), "id='sectionID' class='form-control'");
                    ?>
                </div> <span id="section_id"></span>
            </div>
                    <?php
                    if (form_error($errors, 'semester_id'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
            <label for="sectionID" class="col-sm-2 col-sm-offset-2 control-label">
            <?= $data->lang->line('mark_semester') ?>
            </label>
            <div class="col-sm-6 col-xs-12">
                <?php
                $array = array("0" => $data->lang->line("mark_select_semester"));
                if (isset($semesters) && count($semesters) > 0) {
                    foreach ($semesters as $semester) {
                        $array[$semester->id] = $semester->name;
                    }
                }
                echo form_dropdown("semester_id", $array, old("semester_id"), "id='semester_id' class='form-control'");
                ?>
            </div> <span id="sem_id"></span>
        </div>
                <?php
                if (form_error($errors, 'examID'))
                    echo "<div class='form-group has-error' >";
                else
                    echo "<div class='form-group' >";
                ?>
        <label for="examID" class="col-sm-2 col-sm-offset-2 control-label">
        <?= $data->lang->line('mark_exam') ?>
        </label>

        <div class="col-sm-6 col-xs-12">
            <?php
            $array = array("0" => $data->lang->line("mark_select_exam"));
//                                foreach ($exams as $exam) {
//                                    $array[$exam->examID] = $exam->exam;
//                                }
            echo form_dropdown("examID", $array, old("examID", $set_exam), "id='examID' class='form-control'");
            ?>
        </div>
    </div>


<?php
if (form_error($errors, 'subjectID'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
    <label for="subjectID" class="col-sm-2 col-sm-offset-2 control-label">
    <?= $data->lang->line('mark_subject') ?>
    </label>

    <div class="col-sm-6 col-xs-12">
        <?php
        $array = array();
        if (isset($subjects) && count($subjects) > 0) {
            foreach ($subjects as $subject) {
                $array[$subject->subjectID] = $subject->subject;
            }
        }
        echo form_dropdown("subjectID[]", $array, old("subjectID", $set_subject), "  id='subjectID' class='form-control select2' multiple ");
        ?>
    </div><span id="subjectID"></span>
</div>

<div class="form-group">
    <div class="col-sm-offset-4 col-sm-6 col-xs-12">
        <input type="submit" class="btn btn-success btn-block" style="margin-bottom:0px"
               value="<?= $data->lang->line("add_mark") ?>">
    </div>
</div>
<?= csrf_field() ?>
</form>


<a style="float:right">
    <i class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="<?= $data->lang->line("marking") ?>" title="" data-original-title="<?= $data->lang->line("mark_instructions") ?>"></i></a>
</div>

<?php if (isset($exam_report) && count($exam_report) > 0) { ?>
    <div class="alert alert-warning"><?= $data->lang->line("published") ?></div>
<?php } ?>
</div>

<?php if (isset($exam_info) && count($exam_info) == 1) { ?>
    <div class="row">
        <div class="col-sm-6 col-xs-12 col-sm-offset-3 list-group">
            <div class="list-group-item">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?= $data->lang->line("exam") ?></th>
                            <th><?= $data->lang->line("exam_date") ?></th>
                            <th><?= $data->lang->line("menu_classes") ?></th>
                            <th><?= $data->lang->line("subject") ?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td><?= $exam_info->exam ?></td>
                            <td><?= date('d M Y', isset($exam_info->date) ? strtotime($exam_info->date) : time()) ?></td>
                            <td><?= isset($class->classes) ? $class->classes : '' ?>
    <?= isset($section) ? ' ' . $section->section : '' ?></td>
                            <td><?php
    if (isset($subjects) && count($subjects) > 0) {
        foreach ($subjects as $subj) {
            echo $subj->subject . ',';
        }
    }
    ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-12">


        <?php } if (count($students) > 0) { ?>

            <div id="alert"></div>
            <div class="table-responsive">
                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer ">
                    <thead>
                        <tr>
                            <th class="col-sm-1"><?= $data->lang->line('slno') ?></th>
                            <?php if (!in_array(device(), array('Android', 'iPhone', 'Mobile'))) { ?>
                                <th class="col-sm-2"><?= $data->lang->line('mark_photo') ?></th>
                            <?php } ?>
                            <th class="col-sm-2"><?= $data->lang->line('mark_name') ?></th>
                            <th class="col-sm-2"><?= $data->lang->line('mark_section') ?></th>
                            <?php
                            if (count($subjects) > 0) {
                                foreach ($subjects as $subj) {
                                    ?>
                                    <th class="col-sm-3"><?= $subj->subject ?>
                                    </th>
                                <?php }
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($students) > 0) {

                            $i = 1;
                            $student_mark = array();
//                        if(!empty($marks)){
//                             foreach ($marks as $mark) {
//                                $student_mark[$mark->student_id]=$mark->mark;
//                             }
//                        }
                            foreach ($students as $student) {

                                $student_id = isset($student->student_id) ? $student->student_id : $student->student_id;
                                ?>
                                <tr>
                                    <td data-title="<?= $data->lang->line('slno') ?>">
                                    <?php echo $i; ?>
                                    </td>
                                        <?php if (!in_array(device(), array('Android', 'iPhone', 'Mobile'))) { ?>
                                        <td data-title="<?= $data->lang->line('mark_photo') ?>">
                                            <?php
                                            $array = array(
                                                "src" => base_url('storage/uploads/images/' . $student->photo),
                                                'width' => '30px',
                                                'height' => '30px',
                                                'class' => 'img-rounded'
                                            );
                                            echo img($array);
                                            ?>
                                        </td>
                                        <?php } ?>
                                    <td data-title="<?= $data->lang->line('mark_name') ?>">
            <?php echo $student->name; ?>
                                    </td>
                                    <td data-title="<?= $data->lang->line('mark_section') ?>">
                                    <?php echo $student->section; ?>
                                    </td>
                                    <?php
                                    if (count($subjects) > 0) {
                                        foreach ($subjects as $subj) {
                                            ?>
                                            <td data-title='Action'>
                                                <input class="form-control mark" type="number" min="0" max="100" subject_id="<?= $subj->subjectID ?>" student_id="<?= $student_id ?>" exam_id="<?= $set_exam ?>" data-title="" name="<?= $student_id ?>"
                                                       id="<?= $student_id ?>"
                                                       <?php if (isset($exam_report) && count($exam_report) > 0) { ?>
                                                           disabled="disabled"
                                                       <?php } ?>
                                                       value="<?php
                                                       if (isset($marks[$student_id][$subj->subjectID])) {

                                                           echo $marks[$student_id][$subj->subjectID][0]->mark;
                                                       }
                                                       ?>"/>
                                                <span id="<?= $subj->subjectID . $student_id . $set_exam ?>"></span>
                                            </td>
                                        <?php }
                                    }
                                    ?>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!--            <div class="col-sm-2 col-sm-offset-5">
            <?php if (isset($exam_report) && empty($exam_report) || session('usertype') == 'Admin') { ?>
                                        <input type="button" class="btn btn-success" id="add_mark" name="add_mark"
                                               value="<?= $data->lang->line("add_mark") ?>"/>
            <?php } ?>
                        </div>-->
<?php } ?>
    </div>



</div>
</div>
</div>
</div>


<script>
    $('.mark').keyup(function () {
        var mark = $(this).val();
        if (mark > 100) {
            swal('Error', 'Mark cannot be greater than 100, please enter it correctly');
            $(this).val('');
            $(this).css('border', '1px solid red');
        }
        if (mark < 0) {
            swal('Error', 'Mark cannot be negative, please enter only positive marks');
            $(this).val('');
            $(this).css('border', '1px solid red');
        }
    });

    $(".mark").keyup(function (event) {
        if (event.keyCode == 13) {
            $("#add_mark").click();
        }
    });
    $("#add_mark").click(function () {

        var inputs = "";
        var inputs_value = "";
        $('.mark').each(function (index, value) {
            inputs_value = $(this).val();
            if (inputs_value == '' || inputs_value == null) {
                inputs += $(this).attr("id") + ":" + "-" + "$";
            } else {
                inputs += $(this).attr("id") + ":" + inputs_value + "$";
            }

        });

        $.ajax({
            type: 'POST',
            url: "<?= base_url('mark/mark_send') ?>",
            data: {
                "examID": "<?= $set_exam ?>",
                "classesID": "<?= $set_classes ?>",
                "subjectID": "<?php //$set_subject      ?>",
                "academic_year_id": "<?= $year_id ?>",
                "inputs": inputs
            },
            dataType: "html ",

            success: function (data) {
                toastr["success"](data);
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "500",
                    "hideDuration": "500",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
            }
        });
    });

    $('#academic_year_id_mark').change(function (event) {
        var academic_year_id = $(this).val();
        var classesID = $('#classesID').val();
        if (academic_year_id === '0') {
            $('#sectionID').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('student/sectioncall') ?>",
                data: "id=" + classesID + '&academic_year_id=' + academic_year_id,
                dataType: "html",
                success: function (data) {
                    if (data === '0') {
                        $('#sectionID').html('');
                        $('#section_id').html('<span class="red"><?= $data->lang->line("no_sections") ?> <a href="<?= base_url('section/add') ?>" class="btn btn-primary" role="button"><?= $data->lang->line("add_section") ?> </a> <?= $data->lang->line("for_class") ?></span>');
                    } else {
                        $('#section_id').html('');
                        $('#sectionID').html(data);
                    }
                }
            });
        }
    });
    $('#academic_year_id_mark').change(function (event) {
        var academic_year_id = $(this).val();
        if (academic_year_id === '0') {
            $('#semester_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('semester/get_semester') ?>",
                data: "academic_year_id=" + academic_year_id,
                dataType: "html",
                success: function (data) {
                    if (data === '0') {
                        $('#semester_id').html('');
                        swal('warning', 'No semester(s) have been added in this level. Please define semester(s) first in this academic year', 'warning');
                    } else {
                        $('#sem_id').html('');
                        $('#semester_id').html(data);
                    }
                }
            });
            var class_id = $('#classesID').val();
            $.ajax({
                type: 'POST',
                url: "<?= base_url('mark/getSubjectByClass') ?>",
                data: "year_id=" + academic_year_id + "&id=" + class_id,
                dataType: "html",
                success: function (data) {
                    $('#subjectID').html(data);
                }
            });
        }
    });

    $('#semester_id').change(function (event) {
        var academic_year_id = $('#academic_year_id_mark').val();
        var semester_id = $(this).val();
        var classesID = $('#classesID').val();
        if (academic_year_id === '0') {
            $('#examID').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('exam/getExamByClass') ?>",
                data: "id=" + classesID + "&academic_year_id=" + academic_year_id + '&semester_id=' + semester_id,
                dataType: "html",
                success: function (data) {
                    $('#examID').html(data);
                }
            });
        }
    });

    $('#classesID').change(function (event) {
        var classesID = $(this).val();
        if (classesID === '0') {
            $('#academic_year_id_mark').val(0);
        } else {
            /*   $.each(classes, function( i, val ) {
             //$( "#" + val ).text( "Mine is " + val + "." );
             if(classesID===val.classesID){
             var class_level_id=val.classlevel_id;
             $.each(years,function(x,year_val){
             if(class_level_id==x){
             
             //alert('class id is '+x+' and from array is value '+year_val.name);
             }
             //console.log(year_val);
             });
             
             }
             // alert('class id is '+classesID+' and from array is value '+val.classesID);
             //console.log(val);
             // Will stop running after "three"
             //return ( val !== "three" );
             //}); */
            $.ajax({
                type: 'POST',
                url: "<?= base_url('exam/get_academic_years') ?>",
                data: "id=" + classesID,
                dataType: "html",
                success: function (data) {
                    $('#academic_year_id_mark').html(data);
                }
            });
        }
    });

    $('#sectionID').change(function (event) {
        var sectionID = $(this).val();
        if (sectionID === '0' || sectionID === 'all') {
            $('#sectionID').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('mark/getSubjectBySection') ?>",
                data: "id=" + sectionID,
                dataType: "html",
                success: function (data) {
                    $('#subjectID').html(data);
                }
            });
        }
    });
    $('.mark').keyup(function () {
        var mark = $(this).text();
        if (mark > 100) {
            swal('Error', 'Mark cannot be greater than 100, please enter it correctly');
            $(this).val('');
            $(this).css('border', '1px solid red');
        }
        if (mark < 0) {
            swal('Error', 'Mark cannot be negative, please enter only positive marks');
            $(this).val('');
            $(this).css('border', '1px solid red');
        }
    });
    $(".mark").blur(function (event) {

        var inputs = $(this).val();
        var subject_id = $(this).attr('subject_id');
        var student_id = $(this).attr('student_id');
        var exam_id = $(this).attr('exam_id');

        if (inputs == null) {

        } else if (inputs <= 100 && inputs >= 0) {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('mark/mark_send_one') ?>",
                data: {
                    "examID": exam_id,
                    "classesID": "<?= isset($class->classesID) ? $class->classesID : '' ?>",
                    "subjectID": subject_id,
                    "year_id": "<?= isset($year_id) ? $year_id : '' ?>",
                    "student_id": student_id,
                    "inputs": inputs
                },
                dataType: "html ",
                beforeSend: function (xhr) {
                    $('#' + subject_id + student_id + exam_id).html('<a href="#/refresh"><i class="fa fa-spinner"></i> </a>');
                },
                complete: function (xhr, status) {
                    $('#' + subject_id + student_id + exam_id).html('<span class="label label-success">' + status + '</span>');
                    var mk_remaining = $('#mark_remaining').text();
                    $('#mark_remaining').html(mk_remaining - 1);
                },
                error: function (xhr, status) {
                    //jQuery('#loader-content').fadeOut('slow');
                    $('#' + subject_id + student_id + exam_id).html('<span class="label label-danger">' + status + '</span>');
                },

                success: function (data) {
                    toast(data);
                }
            });
        } else {
            swal('Error', 'Mark cannot be greater than 100, please enter it correctly');
        }

    });

</script>


<script type="text/javascript">

    function fill_subject(id) {

        if (parseInt(id)) {
            if (id === '0') {

                $('#subjectID').val(0);
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url('mark/subjectcall') ?>",
                    data: {"id": id},
                    dataType: "html",
                    success: function (data) {
                        $('#subjectID').html(data);
                    }
                });
            }
        }

    }
</script>
<?php
/**
 * upload EXCEL modal
 */
?>

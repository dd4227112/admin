
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-invoice"></i> <?= $data->lang->line('panel_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li class="active"><?= $data->lang->line('menu_invoice') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Marking Status</h1>

                    <div class="clearfix"></div>

                </div>
                <div class="x_content">


                    <?php
                    $usertype = session("usertype");
                    $i = 1;
                    //if (sizeof($marks) > 0) {
                    ?>
                    <div class="heading2">
                        <h1 class="heading"><b></b></h1>
                    </div>
                    <br/>
                    <div class="col-sm-6 col-sm-offset-3 list-group">
                        <div class="list-group-item list-group-item-warning">
                            <form class="form-horizontal" role="form" method="post">



                                <?php
                                if (form_error($errors, 'subjectID'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                                ?>
                                <label for="classesID" class="col-sm-2 col-sm-offset-2 control-label">
                                    <?= $data->lang->line('subject') ?>
                                </label>

                                <div class="col-sm-6">
                                    <?php
                                    $array = array("0" => $data->lang->line("mark_select_subject"));

                                    foreach ($subjects as $subject) {
                                        $array[$subject->subjectID] = $subject->subject_name;
                                    }
                                    $array['0'] = 'All Subjects';
                                    echo form_dropdown("subjectID", $array, old("subjectID", $subject_id), " id='subjectID' class='form-control'");
                                    ?>
                                </div>
                        </div>
                        <?= csrf_field() ?>
                        </form>
                    </div>
                </div>

                <?php if ($subject_id == 0 || $subject_id == '') { ?>
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="list-group-item">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Class Name</th>
                                            <th>Exam Name</th>
                                            <th>Total Students</th>
                                            <th>Marking Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= $class->classes->classes ?></td>
                                            <td><?= $exam->exam ?></td>
                                            <td><?= sizeof($students) ?></td>
                                            <td><?= $mark_remaining == 0 ? '<span class="label label-success">complete</span>' : ' <span class="label label-danger"><b id="mark_remaining">' . $mark_remaining . '</b> remains</span>' ?></td>

                                        </tr>
                                        <?php if ($usertype == "Admin") { ?>
                                            <tr> <td colspan="3"> <a  href="<?= base_url('mark/delete/' . $exam_id . '/' . $class_id . '/' . $subject_id . '?a=' . $academic_year_id) ?>"class="btn btn-danger btn-xs pull-right delete_all_invoices link" id="delete_all_invoices" tags=''  name="" onclick="return confirm('you are about to delete all Marks in this class. This cannot be undone. are you sure? ')"><i class="fa fa-delete"></i> Click Here to delete All Marks of  this Exam</a></td></tr>            


                                        <?php } ?> 

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-3">

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered dataTable" >
                            <thead>
                                <tr>
                                    <th class="col-sm-2">Student Name</th>
                                    <th class="col-sm-2">Section</th>
                                    <?php
                                    foreach ($subjects as $subject) {
                                        ?>
                                        <th class="col-sm-2"><?= strtoupper($subject->subject_name) ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($students as $student) {
                                    ?>
                                    <tr>
                                        <td>{{$student->name}}</td>
                                        <td>{{$student->section}}</td>
                                        <?php
                                        foreach ($subjects as $subject) {
                                            ?>
                                            <td>
                                                <span type="number" value="" contenteditable="true" class="form-control mark" subject_id="<?= $subject->subjectID ?>" student_id="<?= $student->student_id ?>" exam_id="<?= $exam_id ?>" data-title="" >
                                                    <?php
                                                    $m_exists = 0;
                                                    if (isset($marks[$student->student_id][$subject->subjectID])) {
                                                        echo $marks[$student->student_id][$subject->subjectID][0]->mark;
                                                        $m_exists = 1;
                                                    }
                                                    ?>
                                                </span>  
                                                <span id="<?= $subject->subjectID . $student->student_id . $exam_id ?>" at_exist="<?= $m_exists ?>"></span>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <br/>
                    <?php
                    $i++;
                } else {
                    ?>
                    <div class="col-sm-6 col-sm-offset-3 list-group">
                        <div class="list-group-item">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Class Name</th>
                                        <th>Exam Name</th>
                                        <th>Total Students</th>
                                        <th>Marking Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $class->classes->classes ?></td>
                                        <td><?= $exam->exam ?></td>
                                        <td><?= sizeof($marks) ?></td>
                                        <td><?= $mark_remaining == 0 ? '<span class="label label-success">complete</span>' : ' <span class="label label-danger">' . $mark_remaining . ' remains</span>' ?></td>
                                    </tr>
                                    <tr>
                                        <?php if ($usertype == "Admin") { ?>
                                        <tr> <td colspan="3"> <a  href="<?= base_url('mark/delete/' . $exam_id . '/' . $class_id . '/' . $subject_id . '?a=' . $academic_year_id) ?>"class="btn btn-danger btn-xs pull-right delete_all_invoices link" id="delete_all_invoices" tags=''  name="" onclick="return confirm('you are about to delete all Marks of this subject in this class. This cannot be undone. are you sure? ')"><i class="fa fa-delete"></i> Click Here to delete All Marks of this subject Exam</a></td></tr>            


                                    <?php } ?>                

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <table class="table table-responsive table-bordered dataTable">
                        <thead>
                            <tr>
                                <th class="col-sm-2">Student Name</th>
                                <th>Mark</th>
                                <th>Created at</th>
                                <th>Created By</th>
                                <th>Last Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($marks as $mark) {
                                ?>
                                <tr>
                                    <td>{{$mark->student->name}}</td>
                                    <td>{{$mark->mark}}</td>
                                    <td>{{date('jS M Y, h:i:s A ',strtotime($mark->created_at)).' , '.\Carbon\Carbon::createFromTimeStamp(strtotime($mark->created_at))->diffForHumans()}}</td>
                                    <td><?php
                                        if (in_array($mark->table, array('student', 'teacher', 'user', 'setting', 'parent'))) {
                                            $user = \App\Model\User::where('id', $mark->created_by)->where('table', $mark->table)->first();
                                            echo $user->name;
                                        }
                                        ?></td>
                                    <td><?php
                                        if ($mark->updated_at != '') {
                                            echo date('jS M Y, h:i:s a', strtotime($mark->updated_at)) . ' , ' . \Carbon\Carbon::createFromTimeStamp(strtotime($mark->updated_at))->diffForHumans();
                                        }
                                        ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <?php
                }
                //}
                ?>

            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
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

        var inputs = $(this).text();
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
                    "classesID": "<?= isset($class->classes->classesID) ? $class->classes->classesID : '' ?>",
                    "subjectID": subject_id,
                    "year_id": "<?= isset($class->academic_year_id) ? $class->academic_year_id : '' ?>",
                    "student_id": student_id,
                    "inputs": inputs
                },
                dataType: "html ",
                beforeSend: function (xhr) {
                    //jQuery('#loader-content').show();
                    $('#' + subject_id + student_id + exam_id).html('<a href="#/refresh"><i class="fa fa-spinner"></i> </a>');
                },
                complete: function (xhr, status) {
                    //jQuery('#loader-content').fadeOut('slow');
                    $('#' + subject_id + student_id + exam_id).html('<span class="label label-success">' + status + '</span>');
                    var at_exist = $('#' + subject_id + student_id + exam_id).attr('at_exist');
                    if (at_exist == 0) {
                        var mk_remaining = $('#mark_remaining').text();
                        $('#mark_remaining').html(mk_remaining - 1);
                    }
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
    $('#subjectID').change(function (event) {
        var a = $(this).val();
        window.location.href = "<?= base_url('mark/status') ?>/" +<?= $exam_id ?> + "/" +<?= $set ?> + '/' + a + '?a=' +<?= isset($class->academic_year_id) ? $class->academic_year_id : '' ?>;
    });
</script>
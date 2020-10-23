
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-flask"></i> <?= $data->lang->line('panel_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li class="active"><?= $data->lang->line('menu_mark') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">

                <div class="col-sm-6 col-sm-offset-3 list-group">
                    <div class="list-group-item list-group-item-warning">
                        <form style="" class="form-horizontal" role="form" method="post">  
                            <div class="form-group">              
                                <label for="student_id" class="col-sm-2 col-sm-offset-2 control-label">
                                    <?= $data->lang->line("mark_student") ?>
                                </label>
                                <div class="col-sm-6">
                                    <?php
                                    $array = array("0" => $data->lang->line("mark_select_student"));
                                    if (sizeof($allstudents) > 0) {
                                        foreach ($allstudents as $allstudent) {
                                            $array[$allstudent->student->student_id] = $allstudent->student->name;
                                        }
                                    }
                                    echo form_dropdown("student_id", $array, old("student_id"), "id='student_id' class='form-control'");
                                    ?>
                                </div>
                            </div>
                            <?= csrf_field() ?>
                        </form>
                    </div>
                </div>

            </div> <!-- col-sm-12 -->

        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->
<script type="text/javascript">
    $('#student_id').change(function () {
        var student_id = $(this).val();
        if (student_id == 0) {
            $('#hide-table').hide();
        } else {
            window.location.href ='<?= base_url("mark/index/") ?>/'+ student_id;
        }
    });
</script>
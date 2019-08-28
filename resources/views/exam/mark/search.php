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

                <?php
                $usertype = session("usertype");

                if (can_access('add_mark')) {
                    ?>
                    <h5 class="page-header">
                        <a class="btn btn-success" href="<?php echo base_url('mark/add') ?>">
                            <i class="fa fa-plus"></i> 
                            <?= $data->lang->line('add_title') ?>
                        </a>
                         <a href="<?= base_url('mark/upload')?>" id="upload_excel"  class="btn btn-success btn-sm mrg" data-placement="top" data-toggle="tooltip" data-original-title="Import From Excel"><i class="fa fa-cloud-upload"></i> <?= $data->lang->line("upload_mark") ?> (Excel)</a>
                    </h5>
                
                <?php } ?>

                <div class="col-sm-6 col-xs-12 col-sm-offset-3 list-group">
                    <div class="list-group-item list-group-item-warning">
                        <form class="form-horizontal" role="form" method="post">



                            <?php
                            if (form_error($errors, 'classesID'))
                                echo "<div class='form-group has-error' >";
                            else
                                echo "<div class='form-group' >";
                            ?>
                            <label for="classesID" class="col-sm-2 col-sm-offset-2 control-label">
                                <?= $data->lang->line('mark_classes') ?>
                            </label>

                            <div class="col-sm-6">
                                <?php
                                $array = array("0" => $data->lang->line("mark_select_classes"));
                                foreach ($classes as $classa) {
                                    $array[$classa->classesID] = $classa->classes;
                                }
                                echo form_dropdown("classesID", $array, old("classesID"), " id='classesmodelID' class='form-control'");
                                ?>
                            </div>
                    </div>

                    <?php
                    if (form_error($errors, 'academic_year_id'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                    <label for="sectionID" class="col-sm-2 col-sm-offset-2 control-label">
                        <?= $data->lang->line('exam_academic_year') ?>
                    </label>
                    <div class="col-sm-6">
                        <?php
                        $array = array("0" => $data->lang->line("exam_select_year"));
                        if (isset($academic_years)) {
                            foreach ($academic_years as $academic) {
                                $array[$academic->id] = $academic->name;
                            }
                        }

                        echo form_dropdown("academic_year_id", $array, old("academic_year_id"), "id='academic_year_id' class='form-control'");
                        ?>
                    </div>
                </div>
                <?= csrf_field() ?>
                </form>
            </div>
        </div> <!-- col-sm-6 -->  
    </div> <!-- col-sm-12 -->

</div><!-- row -->
</div><!-- Body -->
</div><!-- /.box -->

<script type="text/javascript">
    $('#classesmodelID').change(function (event) {

        var classesID = $(this).val();
        if (classesID === '0') {
            $('#academic_year_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('exam/get_academic_years') ?>",
                data: "id=" + classesID,
                dataType: "html",
                success: function (data) {
                    $('#academic_year_id').html(data);
                }
            });
        }
    });
    $('#academic_year_id').change(function (event) {

        var academic_year_id = $(this).val();
        var classesID = $('#classesmodelID').val();
        if (academic_year_id === '0') {
            return false;
        } else {
            window.location.href = "<?= base_url('mark/index') ?>/" + classesID + "/" + academic_year_id;
        }
    });
</script>

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
           
		</div>
	    </div> <!-- col-sm-6 --> 
            <div class="alert alert-info">If you click optimize, system will insert 0 mark to students who miss certain exams</div>
            
	    <div id="hide-table">
                
		<table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
		    <thead>
			<tr>
			  <th class="col-sm-2"><?= $data->lang->line('slno') ?></th>
			    <th class="col-sm-2"><?= $data->lang->line('mark_name') ?></th>
			    <th class="col-sm-2"><?= $data->lang->line('mark_roll') ?></th>
			    <th class="col-sm-2"><?= $data->lang->line('action') ?></th>
			</tr>
		    </thead>
		    <tbody>
			<?php if (sizeof($classes)) {
			    $i = 1;
			    foreach ($classes as $class) { ?>
				<tr>
				    <td data-title="<?= $data->lang->line('slno') ?>">
					<?php echo $i; ?>
				    </td>
				   
				    <td data-title="<?= $data->lang->line('mark_name') ?>">
					<?php echo $class->classes; ?>
				    </td>
				    <td data-title="<?/*=$data->lang->line('mark_roll')*/?>">
				    <?php echo $class->teacherID; ?>
				    </td>
				    <td data-title="<?= $data->lang->line('action') ?>">
					<?php
					if (can_access('view_mark')) {
					    echo '<a  href="'.base_url("/mark/updateMarking/$class->classesID").' " class="btn btn-success btn-xs"><i class="fa fa-folder-open-o"></i> Optimize </a>';
					}
					?>
				    </td>
				</tr>
	<?php $i++;
    }
} ?>

		    </tbody>
		</table>
	    </div>


	</div>
    </div>
</div>
</div>

<script type="text/javascript">
    $('#classesID').change(function () {
	var classesID = $(this).val();
	if (classesID == 0) {
	    $('#hide-table').hide();
	} else {
	    $.ajax({
		type: 'POST',
		url: "<?= base_url('mark/mark_list') ?>",
		data: "id=" + classesID,
		dataType: "html",
		success: function (data) {
		    window.location.href = data;
		}
	    });
	}
    });
</script>
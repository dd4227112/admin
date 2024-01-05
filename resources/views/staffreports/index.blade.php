<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><?= $data->lang->line('menu_dashboard') ?></a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><?= ucwords(str_replace('_', ' ', request()->segment(1))) ?></a></li>
                    <li class="breadcrumb-item active"><?= request()->segment(2) ?></li>
                </ol>
            </div>
            <h4 class="page-title"><?= $data->lang->line('staff_report') ?></h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

<!--                <form style="" class="my-4 form-horizontal" role="form" method="post">  
                    <div class="row">
                        <div class="col-sm-5 mx-auto">
                            <div class="input-group row"> 
                                <div class="col-sm-4">
                                    <input type="date" required class="form-control calendar" id="from_date" name="from_date" value="<?= old('from_date') ?>" >
                                </div>
                                <div class="col-sm-4">
                                    <input type="date" required class="form-control calendar" id="to_date" name="to_date" value="<?= old('to_date') ?>" >
                                </div>
                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary btn-block" value="<?= $data->lang->line('view_report') ?>" >
                                </div>
                            </div>
                            <?= csrf_field() ?>
                        </div>
                    </div>
                </form>-->

                <!--<hr>-->
                <?php if (!empty($users)) { ?>
                    <div class="col-sm-12">
                        <br>
                        <div id="hide-table">
                            <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th><?= $data->lang->line('slno') ?></th>
                                        <th><?= $data->lang->line('photo') ?></th>
                                        <th><?= $data->lang->line('name') ?></th>
                                        <th><?= $data->lang->line('usertype') ?></th>
                                        <th><?= $data->lang->line('total_kpi') ?></th>
                                        <th><?= $data->lang->line('reports_submitted') ?></th>
                                        <th><?= $data->lang->line('avarage_performance') ?></th>
                                        <th><?= $data->lang->line('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($users) > 0) {
                                        $i = 1;
                                        foreach ($users as $user) {
                                            ?>
                                            <tr>
                                                <td data-title="<?= $data->lang->line('slno') ?>">
                                                    <?php echo $i; ?>
                                                </td>

                                                <td data-title="<?= $data->lang->line('student_photo') ?>">
                                                    <?= profilePic($user->photo); ?>
                                                </td>
                                                <td data-title="<?= $data->lang->line('student_name') ?>">
                                                    <?= $user->name; ?>
                                                </td>
                                                <td data-title="<?= $data->lang->line('student_name') ?>">
                                                    <?= $user->usertype; ?>
                                                </td>
                                                <td data-title="<?= $data->lang->line('student_sex') ?>">
                                                    <?php
                                                    echo $user->staffTargets()->count();
                                                    ?>
                                                </td>

                                                <td data-title="<?= $data->lang->line('student_sex') ?>">
                                                    <?php
                                                    echo $user->staffReports()->count();
                                                    ?>
                                                </td>
                                                <td data-title="<?= $data->lang->line('student_sex') ?>">
                                                    <?php
                                                    $r = 1;
                                                    $avg_performance = 0;
                                                    foreach ($user->staffTargets()->get() as $target) {
                                                        if ((int) $target->is_derived == 1) {
                                                            $cur_value = \collect(DB::select($target->is_derived_sql))->first();
                                                           $performance =  $cur_value->current_value;
                                                        } else {
                                                            $performance = $target->staffTargetsReports()->max('current_value');
                                                        }
                                                      
                                                        $avg_performance += (float) $target->value > 0 ? round($performance * 100 / $target->value) : 0;
                                                        $r++;
                                                    }
                                                    $avg = (int) $r == 1 ? 0 : round($avg_performance / ($r - 1));
                                                    echo $avg . '%';
                                                    ?>
                                                </td>

                                                <td data-title="<?= $data->lang->line('action') ?>">

                                                    <?php
                                                    echo can_access('view_system_report') ?
                                                            '<a  href="' . url('report/setreport/' . $user->uuid) . '" class="btn btn-primary btn-sm"><i class="fa fa-plus"> </i> Set Report </a> ' : '';

                                                    echo can_access('view_system_report') ?
                                                            '<a  href="' . url('report/dashboard/' . $user->uuid) . '" class="btn btn-success btn-sm"><i class="fa fa-folder"> </i>View </a>' : '';
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--<h2>Summary</h2>-->

                        </div>
                    </div>
                <?php } ?>
            </div> <!-- col-sm-12 -->

        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->
<!-- email modal starts here -->
<div class="modal fade" id="studentDocs">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h2 class="modal-title">Add Staff Daily Report</h2>
            </div>
            <form action="<?= base_url('Report/addReport'); ?>" method="post"  enctype="multipart/form-data">
                <div class="modal-body">
                    <div class='form-group'>
                        <label for="subject" class="col-sm-6 control-label">
                            Report Title.
                        </label>
                        <input type="text" class="form-control" id="documents" name="title"/>

                    </div>
                    <div class='form-group'>
                        <label for="subject" class="col-sm-6 control-label">
                            Select Date.
                        </label>
                        <input type="text" class="form-control calendar" id="documents" name="date"/>

                    </div>
                    <div class='form-group'>
                        <label for="message" class="col-sm-6 control-label">
                            Attach Document Here
                        </label>
                        <input type="file"   accept=".pdf" class="form-control" id="documents" name="attachment"/>
                    </div>
                    <div class='form-group'>
                        <br>
                        <textarea name="comment" class="form-control"  rows="5" placeholder="Write Your Report Comment Here...."></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?= $data->lang->line('close') ?></button>
                    <input type="submit" class="btn btn-success" value="<?= $data->lang->line("send") ?>" />
                </div>
                <?= csrf_field() ?>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#user_group').change(function (event) {
        var user_group = $(this).val();
        if (user_group === '0') {
        } else {
            window.location.href = "<?= base_url('report/default_password') ?>/" + user_group;
        }
    });
</script>

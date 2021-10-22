@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>


<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4><?=' Communication' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">communication</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">sales</a>
                    </li>
                </ul>
            </div>
        </div> 

        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-block">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="white-box">
                                        <div class="row">
                                            <div class="col-lg-4"></div>
                                            <div class="col-lg-4">
                                                <?php
                                                $array = array('0' => trans('select school'));
                                                foreach ($schemas as $schema_name) {
                                                    $array[$schema_name->table_schema] = $schema_name->table_schema;
                                                }

                                                echo form_dropdown("refer_bank_id", $array, old("refer_bank_id"), "id='refer_bank_id' class=' select2' ");
                                                ?>
                                            </div>
                                            <div class="col-lg-4"></div>
                                        </div>
                                        <br/>
                                        <br/>

                                        <?php if (strlen($schema) > 2) { ?>
                                               <div class="table-responsive">
                                                  <table class="table dataTable table-sm table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Task</th>
                                                            <th>ShuleSoft Expert</th>
                                                            <th><?= ucfirst($schema) ?> Person </th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $x = 1;
                                                        $customer = new \App\Http\Controllers\Customer();
                                                        $trainings = \App\Models\TrainItemAllocation::where('client_id', $client->id)->orderBy('id', 'asc')->get();
                                                        foreach ($trainings as $training) {
                                                            $status = check_implementation($training->trainItem->content, $schema);
                                                            ?>
                                                            <tr>
                                                                <th scope="row"><input type="checkbox"/></th>
                                                                <td><?= $training->trainItem->content ?></td>
                                                                <td>
                                                                    <?php
                                                                    ?>
                                                                    <select class="task_allocated_id" name=""
                                                                        task-id="<?= $training->task->id ?>"
                                                                        id="task_user<?= $training->id ?>">
                                                                        <?php
                                                                        if (!empty($shulesoft_users)) {
                                                                            foreach ($shulesoft_users as $user) { ?>
                                                                            <option value="<?= $user->id ?>" <?php
                                                                            if ($user->id == $training->user->id) {

                                                                                echo 'selected="selected"';
                                                                            } else {
                                                                                echo '';
                                                                            }
                                                                            ?>>
                                                                            <?= $user->firstname . ' ' . $user->lastname ?>
                                                                            </option>
                                                                            <?php
                                                                        } } ?>
                                                                    </select>
                                                                </td>
                                                                <td> <b data-attr="school_person"
                                                                        task-id="<?= $training->task->id ?>"
                                                                        id="school_person<?= $training->id ?>"
                                                                        contenteditable="true"
                                                                        class="task_school_group"><?= strlen($training->school_person_allocated) > 4 ? $training->school_person_allocated : 'Not Allocated' ?></b>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    if (preg_match('/not implemented/i', $status)) {
                                                                        if (date('Y', strtotime($training->start_date)) == 1970 || strtotime($training->start_date) < time()) {
                                                                            ?>
                                                                            <select id="start_date<?= $training->id ?>"
                                                                                    class="task_group"
                                                                                    data-task-id="<?= $training->id ?>"
                                                                                    data-user_id="<?= $training->task->user_id ?>"><?= $customer->getDate($training->task->user_id, $training->start_date) ?></select>
                                                                                    <?php
                                                                                } else {
                                                                                    echo date('d M Y', strtotime($training->start_date));
                                                                                }
                                                                            }
                                                                            ?>         
                                                                </td>
                                                                <td>

                                                                    <b data-attr="end_date"
                                                                       id="task_end_date_id<?= $training->id ?>"><?=date('Y', strtotime($training->end_date))==1970?'': date('d M Y', strtotime($training->end_date)) ?>
                                                                    </b>

                                                                </td>
                                                                <td> 
                                                                    <?php
                                                                    echo $status;
                                                                    ?>

                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    if (preg_match('/not implemented/i', $status)) {
                                                                        ?>
                                                                        <button task-id="<?= $training->id ?>" section_id="<?= $training->trainItem->id ?>" class="btn btn-primary btn-mini btn-round btn-sm task_allocated_id">Save</button>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $x++;
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.brighttheme.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.buttons.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.history.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/pnotify/dist/pnotify.mobile.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>assets/pages/pnotify/notify.css">

<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.desktop.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.buttons.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.confirm.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.callbacks.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.animate.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.history.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.mobile.js"></script>
<script type="text/javascript" src="<?= $root ?>bower_components/pnotify/dist/pnotify.nonblock.js"></script>
<script type="text/javascript" src="<?= $root ?>assets/pages/pnotify/notify.js"></script>
<script>
    notify = function (title, message, type) {
        new PNotify({
            title: title,
            text: message,
            type: type,
            hide: 'false',
            icon: 'icofont icofont-info-circle'
        });
    }
    task_group = function () {

        $('.task_allocated_id').mousedown(function () {
            var task_id = $(this).attr('task-id');
            var start_date = $('#start_date' + task_id).val();
            var school_person = $('#school_person' + task_id).text();
            var section_id = $(this).attr('section_id');
            var task_user = $('#task_user' + task_id).val();
            $.ajax({
                url: '<?= url('customer/editTrain') ?>/null',
                method: 'get',
                data: {
                    task_id: task_id,
                    start_date: start_date,
                    school_person: school_person,
                    section_id: section_id,
                    task_user: task_user
                },
                success: function (data) {
                    notify('Success', data, 'success');
                }
            });
        });
        $('#refer_bank_id').change(function () {
            var schema = $(this).val();
            window.location.href = '<?= url('customer/logs') ?>/' + schema;
        })
    }
    $(document).ready(task_group);

    $(".select2").select2({
      theme: "bootstrap",
      dropdownAutoWidth: false,
      allowClear: false,
      debug: true
  }); 

  
</script>


@endsection
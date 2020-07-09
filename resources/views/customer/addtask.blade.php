@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>

<div class="main-body">
    <div class="page-wrapper">

        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="card-block">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Create Task/Activity</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="#" method="post">
                                    <div class="modal-body">
                                        <span>
                                            Create a task with implementation deadline</span>
                                        <div class="form-group">
                                            <strong> Department</strong> 
                                            <select name="dep_id" id="department" class="form-control " required>
                                                <?php
                                                $departments = DB::table('departments')->get();
                                                foreach ($departments as $department) {
                                                    ?>
                                                    <option value="<?= $department->id ?>"><?= $department->name ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="Create Task" rows="4" name="activity"></textarea>
                                        </div>
                                     
                                          
                                        <div class="form-group">
                                            <strong>  Select School</strong> 

                                            <input type="text" class="form-control" id="get_schools" name="school_id" value="<?= old('school_id') ?>" >

                                        </div>

<!--                                        <div class="form-group"  id="client_id">
                                            <strong>  Select School or Client</strong> 

                                            <select name="client_id"  class="form-control select2">
                                                <option value=''> Select Client Here...</option>
                                                <?php
                                                foreach ($clients as $client) {
                                                    ?>
                                                    <option value='<?php echo $client->id; ?>'><?= $client->name ?>  (<?= $client->username ?>)</option>
                                                <?php } ?>
                                            </select>
                                        </div>-->
                                        <div class="form-group">

                                            <strong> Task Type</strong> 
                                            <select name="task_type_id" id="task_type_id" required class="form-control select2">
                                                <option value=''> Select Here...</option>
                                                <?php
                                                $types = DB::table('task_types')->get();
                                                foreach ($types as $type) {
                                                    ?>
                                                    <option value="<?= $type->id ?>"> <?= $type->name ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <strong> Person Allocated to do</strong> 
                                                    <select multiple="" name="to_user_id[]" class="form-control select2" required>
                                                        <?php
                                                        $staffs = DB::table('users')->where('status', 1)->get();
                                                        foreach ($staffs as $staff) {
                                                            ?>
                                                            <option value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                                                        <?php } ?>

                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <strong> Task Executed Successfully</strong> 
                                                    <select name="action" class="form-control" required>
                                                        <option value=''> Select Task Status Here...</option>
                                                        <option value='Yes'> Yes </option>
                                                        <option value='No'> No </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <strong> Deadline Date</strong> 
                                                    <input type="date" class="form-control" placeholder="Deadline" name="date">
                                                </div>
                                                <div class="col-md-6">
                                                    <strong> Estimated Hours</strong> 
                                                    <input type="number" class="form-control" placeholder="Time" name="time">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group" id="modules">
                                            <strong>  Pick Modules where task will be Performed</strong> 
                                            <hr>
                                            <?php
                                            $modules = DB::table('modules')->get();
                                            foreach ($modules as $module) {
                                                ?>
                                                <input type="checkbox" id="feature<?= $module->id ?>" value="{{$module->id}}" name="module_id[]" >  <?php echo $module->name; ?>  &nbsp; &nbsp;

                                            <?php } ?>
                                            <?php /*
                                              <div class="col-md-3">
                                              Task on <?=$module->name?>
                                              <br>
                                              <?php
                                              $subs = DB::table('sub_modules')->where('module_id', $module->id)->orderBy('id', 'ASC')->get();
                                              foreach ($subs as $sub) { ?>
                                              <input type="checkbox" id="feature<?= $sub->id ?>" value="{{$sub->id}}" name="taskmodule[]" >  <?php echo $sub->name; ?>
                                              <br>
                                              <?php } ?>

                                              </div>
                                              </div>
                                             */ ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                                    </div>
                                    <?= csrf_field() ?>
                                </form>
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

<script type="text/javascript">

$(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
});
department = function () {
    $('#department').change(function () {
        var val = $(this).val();
        if (val > 4) {
            $('#modules,#client_id').hide();
        } else {
            $('#modules,#client_id').show();
        }
        $.ajax({
            data: {dep_id: val},
            method: 'get',
            url: '<?= url('customer/getTaskByDepartment/null') ?>',
            success: function (data) {
                $('#task_type_id').html(data);
            }
        })
    })
}
get_schools = function () {
    $("#get_schools").select2({
        minimumInputLength: 2,
       // tags: [],
        ajax: {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            url: '<?= url('student/getschools/null') ?>',
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term,
                    token: $('meta[name="csrf-token"]').attr('content')
                };
            },
            results: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        };
                    })
                };
            }
        }
    });
}

$(document).ready(department);
$(document).ready(get_schools);
</script>
@endsection

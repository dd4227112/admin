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
                                    <h4 class="modal-title">Create a task with implementation deadline</h4>
                                </div>
                                <form action="#" method="post">
                                    <div class="modal-body">
                                        
                                        <div class="form-group">
                                            <strong> Department</strong> 
                                            <select name="dep_id" id="department" class="form-control " required>
                                                <?php
                                                
                                                foreach ($departments as $department) {
                                                    ?>
                                                    <option value="<?= $department->id ?>"><?= $department->name ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                       
                                          
                                        <div class="form-group" id="client_id">
                                            <strong>  Select School</strong> 

                                            <input type="text" class="form-control" id="get_schools" name="school_id" value="<?= old('school_id') ?>" >

                                        </div>
                                                                             <!--                         

                                        <div class="form-group"  id="client_id">
                                            <strong>  Select School or Client</strong> 

                                            <select name="client_id"  class="form-control select2">
                                                <option value=''> Select Client Here...</option>
                                                <?php
                                               // foreach ($clients as $client) {
                                                 ?>
                                            </select>
                                        </div> -->
                                        <div class="form-group">

                                            <strong> Task Type</strong> 
                                            <select name="task_type_id" id="task_type_id" required class="form-control select2">
                                                <option value=''> Select Here...</option>
                                                <?php
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
                                                        $staffs = DB::table('users')->where('status', 1)->where('role_id', '<>', 7)->get();
                                                        foreach ($staffs as $staff) {
                                                            ?>
                                                            <option value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                                                        <?php } ?>

                                                    </select>
                                                </div>

                                                {{-- <div class="col-md-6">
                                                    <strong> Task Executed Successfully</strong> 
                                                    <select name="status" class="form-control" required>
                                                        <option value='new'> Select Task Status Here...</option>
                                                        <option value='new'> New Task </option>
                                                        <option value='complete'> Yes and Completed </option>
                                                        <option value='on progress'> Yes but on Progress </option>
                                                        <option value='schedule'> Not yet (Schedule) </option>
                                                    </select>
                                                </div> --}}

                                                
                                                <div class="col-md-6">
                                                    <strong> Priority</strong> 
                                                    <select name="priority" class="form-control" required>
                                                        <option value=''> Select priority here...</option>
                                                        <option value='1'> High priority </option>
                                                        <option value='2'> Medium priority </option>
                                                        <option value='3'> Less priority</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <strong> Start Date</strong> 
                                                    <input type="datetime-local" class="form-control" placeholder="Deadline" name="start_date">
                                                </div>
                                                <div class="col-md-6">
                                                    <strong> End Date </strong> 
                                                    <input type="datetime-local" class="form-control" placeholder="Time" name="end_date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control col-xs-9" rows="4" name="activity" id="content_part" ></textarea>
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

<script src="<?= url('public/assets/tinymce/tinymce.min.js') ?>"></script>
   <script type="text/javascript">   
                wywig = function () {
                    tinymce.init({
                        selector: 'textarea#content_part',
                        height: 200,
                        plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table contextmenu paste code'
                        ],
                        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                        content_css: [
                            '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                            '//localhost/shule/public/assets/tinymce/codepan.css' 
                        ]
                    });
                }
                wywig();
</script>
@endsection

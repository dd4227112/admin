<?php
if (request()->ajax() == FALSE) {
    ?>
    @extends('layouts.app')
    @section('content')

<?php } ?>
<div class="card">
    <div class="card-header">
        <h5>Customer Onboarding</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title">Basic Inputs</h4>
        <form action="<?= url('sales/onboard/' . $school->id) ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">School Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Add School Namee eg, canossa" name="name" value="<?= strtoupper($school->name) ?> <?= strtoupper($school->type) ?> SCHOOL" required="" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Sales Person</label>
                <div class="col-sm-10">
                    <select name="sales_user_id" class="form-control">
                        <?php foreach ($staffs as $staff) { ?>
                            <option user_id="<?= $staff->id ?>" school_id="" value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Sales Method</label>
                <div class="col-sm-10">
                    <select name="task_type_id"  class="form-control">
                        <?php
                        $types = DB::table('task_types')->where('department', 2)->get();
                        foreach ($types as $type) {
                            ?>
                            <option value="<?= $type->id ?>"><?= $type->name ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Price Per Student</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control transaction_amount" value="10000" name="price" required="">
                </div>
            </div>
            <?php
            $school_contact = DB::table('admin.school_contacts')->where('school_id', $school->id)->first();
            if (empty($school_contact)) { ?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Customer Official Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" value="" name="email" required="">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Customer Official Mobile Phone </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="" name="phone" required="">
                    </div>
                </div>
                <?php } ?>
            <div class="form-group row" style="border: 1px dashed; ">
                <label class="col-sm-2 col-form-label">Account Name</label>
                <div class="row">
                    <div class="col-lg-2">  <b style="font-size: 1.4em;"> https://</b> </div>
                    <div id="col-lg-6">
                        <input style="max-width: 17em;
                               resize: none" class="form-control " id="school_username" name="username" type="text" placeholder="school name" value="<?= strtolower($school->name) ?>" required="" onkeyup="validateForm()"> 
                    </div>
                    <div id="col-lg-4">
                        <b style="font-size: 1.4em;">.shulesoft.com</b>
                    </div>
                </div>
                <small style="max-width: 13em;" id="username_message_reply"></small>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Estimated Students</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" value="<?= $school->students ?>" name="students" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Data Format Available</label>
                <div class="col-sm-10">
                    <select name="data_type_id" class="form-control">
                        <option value="1">Excel With Parent Phone Numbers</option>
                        <option value="2">Physical Files Format</option>
                        <option value="3">Softcopy but without parents phone numbers</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Implementation Start Date</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control" value="" name="implementation_date" required="">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 col-form-label"> Module Selected by school</label>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="col-sm-2">#</th>
                                    <th class="col-sm-5">Tasks</th>
                                    <th class="col-sm-5">Person Responsible <br/>at School (Name & Phone)</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php
                                $sections = \App\Models\TrainItem::where('status', 1)->orderBy('id', 'asc')->get();
                                foreach ($sections as $section) {
                                    ?>
                                    <tr>
                                        <td><b><input type="checkbox" value="<?=$section->id?>" name="module[]" multiple="" /></b></td>
                                        <td><?= $section->content ?></td>
                                        <td><input type="text" class="form-control" value="" name="train_item<?= $section->id ?>" ></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>

                    
                    <div class="card-block table-border-style">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="width:20%">Task</th>
                                        <th>ShuleSoft Person Allocated</th>
                                        <th>School Person/Role Allocated</th>
                                        <th>Start Date : Time</th>
                                        <th>End Date : Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $x = 1;

                                    $trainings = \App\Models\trainItem::orderBy('id', 'asc')->get();
                                    $trainings = [];
                                    foreach ($trainings as $training) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?= $x ?></th>
                                            <td><?= $training->content ?></td>
                                            <td> 
                                                <?php ?>   
                                                <select class="task_allocated_id"  name="person<?= $training->id ?>" id="<?= $training->id ?>" >
                                                    <?php
                                                    foreach ($staffs as $staff) {
                                                        ?>
                                                        <option value="<?= $staff->id ?>">
                                                            <?= $staff->firstname . ' ' . $staff->lastname ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td> 
                                                <input type="text" class="form-control" value="" name="train_item<?= $training->id ?>" required="">
                                            </td>
                                            <td>
                                                <select class="task_group" name="slot_date<?= $training->id ?>" id="slot_for<?= $training->id ?>" data-task-id="<?= $training->id ?>"><?= $customer->getDate($staff->id) ?></select>
                                                <select type="text" data-attr="start_date" class="slot" id="start_slot<?= $training->id ?>"  name="slot_id<?= $training->id ?>"></select>
                                            </td>
                                            <td>
                                                <b data-attr="end_date" id="task_end_date_id<?= $training->id ?>"> </b>
                                            </td>
                                        </tr>
                                        <?php
                                        $x++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Agreement Type</label>
                <div class="col-sm-10">
                    <select name="contract_type_id" class="form-control">
                        <?php
                        $ctypes = DB::table('admin.contracts_types')->get();
                        foreach ($ctypes as $ctype) {
                            ?>
                            <option value="<?= $ctype->id ?>"><?= $ctype->name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div> 

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Contract Start Date</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" value="" name="start_date" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Contract End Date</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="end_date" required="">
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Upload Agreement Form</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" accept=".pdf" name="file" required="">
                </div>
            </div>

            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Payment Option</label>
                <div class="col-sm-10">
                    <select name="payment_option" class="form-control">
                        <option value="cash">Cash</option>
                        <option value="standing order">Standing order</option>
                        <option value="bank transfer">Bank transfer </option>
                    </select>
                </div>
            </div>  

            <div class="row">
                <label class="col-sm-2 col-form-label">Upload document Form</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" accept=".pdf" name="agree_document" required="">
                    <span class="messages">Client MUST sign a standing order to specify which date he/she will start to pay. <a href="#">Click Here to download </a> Standing Order Template</span>
                </div>
            </div>

            <br/><br/>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Areas much interested</label>
                <div class="col-sm-10"> 
                    <textarea rows="5" cols="5" name="description" class="form-control" placeholder="Clarify if this client has any special needs or areas much interested to start ?"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success" placeholder="Default textarea">Submit</button>
                </div>
            </div>
        </form>


    </div>
</div>
<script type="text/javascript">

    notify = function (title, message, type) {
        new PNotify({
            title: title,
            text: message,
            type: type,
            hide: 'false',
            icon: 'icofont icofont-info-circle'
        });
    }

    $('form').each(function (i, form) {
        var $form = $(form);

        if (!$form.find('input[name="_token"]').length) {
            $('form').prepend('<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').prop('content') + '"/>');
        }
    });

    task_group = function () {
        $('.task_group').change(function () {
            var val = $(this).val();
            var task_id = $(this).attr('data-task-id');
            var data_attr = $('#' + task_id).val();
            $.ajax({
                url: '<?= url('customer/getAvailableSlot') ?>/null',
                method: 'get',
                data: {start_date: val, user_id: data_attr},
                success: function (data) {
                    $('#start_slot' + task_id).html(data);
                }
            });
        });
        $('.task_school_group').blur(function () {
            var val = $(this).text();
            var data_attr = $(this).attr('data-attr');
            var task_id = $(this).attr('task-id');
            // var date=$('#'+task_id).val();
            $.ajax({
                url: '<?= url('customer/editTrain') ?>/null',
                method: 'get',
                dataType: 'html',
                data: {task_id: task_id, value: val, attr: data_attr},
                success: function (data) {
                    // $(this).after(data).addClass('label label-success');
                    notify('Success', 'Success', 'success');
                }
            });
        });
        $('.slot').change(function () {
            var val = $(this).val();
            //var data_attr = $(this).attr('data-attr');
            var task_id = $(this).attr('data-id');
            var date = $('#' + task_id).val();
            $.ajax({
                url: '<?= url('customer/editTrain') ?>/null',
                method: 'get',
                dataType: 'json',
                data: {task_id: task_id, value: date, slot_id: val, attr: 'start_date'},
                success: function (data) {
                    $('#task_end_date_id' + data.task_id).html(data.end_date);
                    notify('Success', 'Success', 'success');
                }
            });
        });
        $('.task_allocated_id').change(function () {
            var task_allocated_id = $(this).val();
            var training_id = $(this).attr('id');
            $.ajax({
                url: '<?= url('customer/getDate') ?>/null',
                method: 'get',
                data: {user_id: task_allocated_id},
                success: function (data) {
                    $('#slot_for' + training_id).html(data);
                }
            });
        });
    }
    function validateForm() {
        var regex = new RegExp("^[a-z]+$");
        var x = $('#school_username').val();
        if (x == null || x == "") {
            $('#username_message_reply').html("Name must not be blank").addClass('alert alert-danger');
            return false;
        } else if (!regex.test(x)) {
            $('#username_message_reply').html("Name contains invalid characters (Only letters with no spaces !)").addClass('alert alert-danger');
            return false;
        } else {
            $('#username_message_reply').html('').removeClass('alert alert-danger');
            ;
            return true;
        }
    }
    $(document).ready(task_group);

</script>
<?php
if (request()->ajax() == FALSE) {
    ?>
    @endsection
<?php
}?>
<?php
if (request()->ajax() == FALSE) {
    ?>
    @extends('layouts.app')
    @section('content')
<?php } ?>

  

  <div class="page-header">
      <div class="page-header-title">
        <h4><?='Onboard new school' ?></h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">new school</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">sales</a>
                </li>
            </ul>
        </div>
    </div> 


    <div class="card">
        <div class="card-block">
               <ul class="list-group">
                <li class="list-group-item"> <strong>School name </strong>&nbsp; <?= $client->name ?> &nbsp;&nbsp; &nbsp;&nbsp; <strong>Estmated students </strong>&nbsp; <?= $client->estimated_students ?? '0' ?></li>
                <li class="list-group-item"><strong> School Email </strong> &nbsp;<?= $client->email ?>  &nbsp;&nbsp; <strong> School phone </strong> <?= $client->phone ?></li>
                <li class="list-group-item"><strong> School address </strong> &nbsp;<?= $client->address ?> </li>  
                <li class="list-group-item"><strong> Onboarded by </strong> &nbsp; <?= $client->createdBy->name(); ?>  &nbsp;&nbsp; <strong> Phone </strong> <?=$client->createdBy->phone; ?></li>
                {{-- <li class="list-group-item"><strong> Agreement Form  </strong> &nbsp; <?= 'y'; ?>  &nbsp;&nbsp; <strong> Standing Order </strong> <?php echo !is_null($client->standingorder) ? '<a target="_break" href="" class="btn btn-primary btn-mini btn-round">View</a>' : '<label class="badge badge-inverse-warning">Not Defined</label>' ; ?></li>  --}}

                <li class="list-group-item"><strong> School Description </strong> <br>
                <p class="text-muted">
                     <?= $client->note ?? '' ?> 
                 </p>
                </li>

              </ul>
        </div>
    </div>




<div class="card">
    <div class="card-block">
        <form action="<?= url('sales/implementation/'. $client_id) ?>" method="POST" enctype="multipart/form-data">
          
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Data Format Available</label>
                <div class="col-sm-4">
                    <select name="data_type_id" class="form-control" required>
                        <option value="1">Excel With Parent Phone Numbers</option>
                        <option value="2">Physical Files Format</option>
                        <option value="3">Softcopy but without parents phone numbers</option>
                    </select>
                </div>

                <label class="col-sm-2 col-form-label">Implementation Start </label>
                <div class="col-sm-4">
                    <input type="datetime-local" class="form-control" value="" name="implementation_date" required="">
                </div>
            </div>          

            <div class="form-group row" id="period"  style="display: none;">
                 <label class="col-sm-3 col-form-label">Trial period (Days)</label>
                 <div>
                    <input type="number" name="trial_period" class="form-control">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-form-label"> Module Selected by school</label>
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
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-primary btn-round btn-sm">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
</div>
<script type="text/javascript">

   $(document).ready(function(){
        $("input[type='radio']").click(function(){
            var radioValue = $("input[name='check_trial']:checked").val();             
             if(radioValue == 0){
                $('#period').hide();
                $('#paymentption').show();
             } else {
               $('#period').show();
               $('#paymentption').hide();
            }
        });
    });



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
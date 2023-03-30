@extends('layouts.app')
@section('content')
<?php  
 $deductionType = 'Subscription - deduction';
  ?>


    
      
        <div class="page-header">
            <div class="page-header-title">
                <h4><?= $deductionType ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">deduction</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">payroll</a>
                    </li>
                </ul>
            </div>
           </div>

        
        <div class="page-body">
          <div class="row">
            <div class="col-sm-12">
             <div class="card">

			<div  class="card-block">
                <?php if ($type == 'allowance' || $type == 'deduction') { ?>
                    <div class="col-sm-12 col-xs-12 col-sm-offset-3 list-group">
                        <div class="list-group-item">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> <strong>Type </strong></th>
                                        <th> <strong> name </strong></th>
                                        <th> <strong> Description </strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                        <td><?= ucfirst($type) ?></td>
                                        <td><?= $udeduction->name ?></td>
                                        <td><?= $udeduction->description ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
             </div>
              

				         <div  class="card-block">
                            <div class="table-responsive">
                            <?php if (isset($users) && !empty($users)) { ?>
                                <table id="example1" class="table table-striped table-bordered table-hover no-footer dataTable tablesubscriber">
                                    <thead>
                                        <tr>
                                            <th><?= __('#') ?></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Amount</th>
                                            <th>Deadline</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($users)) {
                                            $i = 1;
                                            foreach ($users as $user) {
                                                $arr = array(
                                                    'user_id' => $user->id,
                                                    'table' => $user->table
                                                );
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $user->firstname.' '.$user->lastname; ?>
                                                    </td>
                                             
                                                    <td>
                                                        <?php echo $user->email; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $user->phone; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $deduction = \App\Models\UserDeduction::where('user_id', $user->id)->where('deduction_id', $udeduction->id)->where('deadline', '>', date('Y-m-d'))->first();
                                                        $amount = !empty($deduction)  ? $deduction->amount : '';
                                                        $deadline = !empty($deduction)  ? $deduction->deadline : '';
                                                        ?>
                                                        <input placeholder="Amount" style="width:100px;" type="number" class="form-control" id="amount<?= $user->id ?>" name="amount" value="<?= $amount ?>" >
                                                    </td>
                                                    <td>
                                                        <input  type="date" style="width:150px;" class="form-control" id="deadline<?= $user->id ?>" name="deadline" value="<?= date($deadline)?>" >
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        if (in_array($user->id, $subscriptions)) {
                                                            ?>
                                                            <a href="#" onclick="return false" onmousedown="remove_user('<?= $user->id ?>')" style="font-size: 10px;" class="btn btn-round btn-mini  btn-danger"> Remove</a>
                                                        <?php } else { ?>
                                                            <a href="#" onclick="return false" onmousedown="submit_deduction('<?= $user->id ?>')" style="font-size: 10px;" class="btn btn-round btn-mini btn-success">Save</a>
                                                        <?php } ?>
                                                        <span id="stat<?= $user->id ?>"></span>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                         }
                                        ?>
                                    </tbody>
                                </table>
                               <?php }  ?>
								 
                     </div>									
                 </div>
            </div> 
        </div>
     </div>
  </div>
</div>

   
<script type="text/javascript">
    function submit_deduction(a, b) {
        var amount = $('#amount' + a).val();
        var deadline = $('#deadline' + a).val();
        if(amount == '' && deadline == ''){ 
             toastr.error(" You must provide amount and deadline date to subscribe");
        } else{
        $.ajax({
            type: 'POST',
             headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            url: "<?= url('deduction/monthlyAddSubscriber/null') ?>",
            data: {user_id: a, amount: amount, deadline: deadline, deduction_id: '<?= $set ?>', type: 0},
            dataType: "html ",
            beforeSend: function (xhr) {
                $('#stat' + a ).html('<a href="#/refresh"><i class="feather icon-refresh-cw f-15 text-c-greenfeather icon-refresh-cw f-15 text-c-green"></i> </a>');
            },
            complete: function (xhr, status) {
                $('#stat' + a ).html('<label class="badge badge-info">' + status + '</label>');
            },
            success: function (data) {
                toastr.success(data);
                window.location.reload();
            }
        });
      }
    }

    function remove_user(a) {
        $.ajax({
            type: 'GET',
            url: "<?= url('payroll/deleteSubscriber/null/') ?>",
            data: {user_id: a, set: '<?= $set ?>', type: 'deduction'},
            dataType: "html ",
            beforeSend: function (xhr) {
                $('#stat' + a ).html('<a href="#/refresh"><i class="feather icon-refresh-cw f-15 text-c-green"></i> </a>');
            },
            complete: function (xhr, status) {
                $('#stat' + a ).html('<label class="badge badge-info">' + status + '</label>');
            },
            success: function (data) {
                 toastr.success(data);
                 window.location.reload();
            }
        }
        );
    }
    function check_all(a) {
        if ($('.check' + a).is(":checked")) {
            $('.check' + a).prop('checked', false);
        } else {
            $('.check' + a).prop('checked', true);
        }
    }
    delete_subscriber = function (a) {
        $.ajax({
            type: 'POST',
            url: "<?= url('payroll/deleteSubscriber/null') ?>",
            data: "id=" + a,
            dataType: "html",
            success: function (data) {
               // swal('success', data, 'success');
                 toastr.success(data);
                 window.location.reload();

                $('#std' + a).hide();
            }
        });
    }

    $('.subscribe').click(function () {
        var user_id = $(this).attr("id");
        var tag_id = "<?= $set ?>";
        var table = $(this).attr("table");
        var datatype = $(this).attr("datatype");
        if (datatype == 'pension') {
            swal({
                title: "Subscribe",
                text: "Please add employee checknumber :",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                inputPlaceholder: "Write valid checknumber"
            }, function (inputValue) {
                if (inputValue === false)
                    return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write  valid checknumber!");
                    return false;
                } else {
                    subscribeUser(datatype, user_id, tag_id, table, inputValue);
                    swal("Success!", "success ", "success");
                }
            });
        } else {
            subscribeUser(datatype, user_id, tag_id, table);
        }

    });

    function subscribeUser(datatype, user_id, tag_id, table, inputValue = null) {
        if (parseInt(user_id) && parseInt(tag_id)) {
            $.ajax({
                type: 'POST',
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: "<?= url('payroll/subscribe') ?>",
                data: {"user_id": user_id, "tag_id": tag_id, table: table, datatype: datatype, checknumber: inputValue},
                dataType: "html",
                success: function (data) {
                    toastr["success"](data)
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "500",
                        "hideDuration": "500",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }

                }
            });
    }
    }

</script>

@endsection



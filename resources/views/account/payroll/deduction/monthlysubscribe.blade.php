@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4> Subscription -<?= $type ?></h4>
                <span></span>
            </div>
        </div>
    

        <div class="page-body">
          <div class="row">
            <div class="col-sm-12">
             <div class="card">

                
                <?php if ($type == 'allowance' || $type == 'deduction') { ?>
                    <div class="col-sm-12 col-xs-12 col-sm-offset-3 list-group">
                        <div class="list-group-item">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th><?= __("name") ?></th>
                                        <th><?= __("description") ?></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                        <td><?= ucfirst($type) ?></td>
                                        <td><?= $allowance->name ?></td>
                                        <td><?= $allowance->description ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>

				         <div  class="card-block">
					      <div class="table-responsive table-sm table-striped table-bordered table-hover">
                            <?php if (isset($users) && !empty($users)) { ?>
                                <table id="example1" class="table table-striped table-bordered table-hover no-footer dataTable tablesubscriber">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-1"><?= __('slno') ?></th>
                                            <th class="col-sm-2">Name</th>
                                            <th class="col-sm-2">User type</th>
                                            <th class="col-sm-2">Email</th>
                                            <th class="col-sm-2">Phone Number</th>
                                            <th class="col-sm-2">Amount</th>
                                            <th class="col-sm-2">Deadline</th>
                                            <th class="col-sm-2"><?= __('action') ?></th>
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
                                                <tr id="std<?= $user->id; ?>">
                                                    <td data-title="<?= __('slno') ?>">
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td data-title="<?= __('student_name') ?>">
                                                        <?php echo $user->name; ?>
                                                    </td>
                                                    <td data-title="<?= __('usertype') ?>">
                                                        <?php echo $user->usertype; ?>
                                                    </td>
                                                    <td data-title="<?= __('email') ?>">
                                                        <?php echo $user->email; ?>
                                                    </td>
                                                    <td data-title="<?= __('phone') ?>">
                                                        <?php echo $user->phone; ?>
                                                    </td>
                                                    <td data-title="<?= __('amount') ?>">
                                                        <?php
                                                        $deduction = \App\Models\UserDeduction::where('user_id', $user->id)->where('deduction_id', $allowance->id)->where('deadline', '>', date('Y-m-d'))->first();
                                                        $amount = !empty($deduction)  ? $deduction->amount : '';
                                                        $deadline = !empty($deduction)  ? $deduction->deadline : '';
                                                        ?>
                                                        <input placeholder="<?= __("amount") ?>" type="number" class="form-control" id="amount<?= $user->id ?>" name="amount" value="<?= $amount ?>" >
                                                    </td>
                                                    <td data-title="<?= __('student_section') ?>">
                                                        <input  type="date" class="form-control calendar" id="deadline<?= $user->id ?>" name="deadline" value="<?= date($deadline)?>" >
                                                    </td>
                                                    <td data-title="<?= __('action') ?>">
                                                        <?php
                                                        if (in_array($user->id . $user->table, $subscriptions)) {
                                                            ?>
                                                            <a href="#" onclick="return false" onmousedown="remove_user('<?= $user->id ?>')" class="btn btn-danger btn-xs mrg"><i class="fa fa-trash-o"></i> Remove</a>
                                                        <?php } else { ?>
                                                            <a href="#" onclick="return false" onmousedown="submit_deduction('<?= $user->id ?>')" class="btn btn-sx btn-success">Save</a>
                                                           
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
        $.ajax({
            type: 'POST',
            url: "<?= url('deduction/monthlyAddSubscriber/null') ?>",
            data: {user_id: a, amount: amount, deadline: deadline, deduction_id: '<?= $set ?>', type: 0},
            dataType: "html ",
            beforeSend: function (xhr) {
                $('#stat' + a ).html('<a href="#/refresh"><i class="fa fa-spinner"></i> </a>');
            },
            complete: function (xhr, status) {
                $('#stat' + a ).html('<span class="label label-success">' + status + '</span>');
            },
            success: function (data) {
                $('#stat' + a ).html(data);
                window.location.reload();
            }
        }
        );
    }

    function remove_user(a) {
        $.ajax({
            type: 'GET',
            url: "<?= url('payroll/deleteSubscriber/null/') ?>",
            data: {user_id: a, set: '<?= $set ?>', type: 'deduction'},
            dataType: "html ",
            beforeSend: function (xhr) {
                $('#stat' + a ).html('<a href="#/refresh"><i class="fa fa-spinner"></i> </a>');
            },
            complete: function (xhr, status) {
                $('#stat' + a ).html('<span class="label label-success">' + status + '</span>');
            },
            success: function (data) {
                $('#stat' + a ).html(data);
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
                swal('success', data, 'success');
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



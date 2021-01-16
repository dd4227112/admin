<?php
/**
 * Description of subject_subscriber
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-subject"></i> <?= __('panel_title') ?>
            Subscription -<?= $type ?></h3>

        <ol class="breadcrumb">
            <li><a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
            <li class="active"><?= __('menu_subject') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="row">    
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-info">This section show employee who subscribe to this <?= $type ?> type. To add new employee in subscription,  tick employee who is affected by this <?= $type ?></div>
                <?php if ($type == 'allowance' || $type == 'deduction') { ?>
                    <div class="col-sm-6 col-xs-12 col-sm-offset-3 list-group">
                        <div class="list-group-item">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th><?= __("name") ?></th>
                                        <th><?= __("amount") ?></th>
                                        <th><?= __("description") ?></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                        <td><?= ucfirst($type) ?></td>
                                        <td><?= $allowance->name ?></td>
                                        <td><?= $allowance->amount ?></td>
                                        <td><?= $allowance->description ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>

                <!--Table one will be here with list of all student subscribe to that subject-->
                <table id="example1" class="table table-striped table-bordered table-hover no-footer dataTable tablesubscriber">
                    <thead>
                        <tr>
                            <th class="col-sm-2"><?= __('slno') ?></th>
                            <!--<th class="col-sm-2">Photo</th>-->
                            <th class="col-sm-2">Name</th>
                            <th class="col-sm-2">User type</th>
                            <th class="col-sm-2">Email</th>
                            <th class="col-sm-2">Phone Number</th>
                            <?php if ($type == 'pension') { ?>
                                <th class="col-sm-2">National ID/Check  Number</th>
                            <?php } ?>
                            <?php if ($type == 'allowance' || $type == 'deduction') { ?>
                                <th class="col-sm-2"><?= (bool) $allowance->is_percentage == false ? __('amount') : __('percent') ?></th>
                                <?php
                            }
                            if ($type == 'deduction') {
                                ?>
                                <th class="col-sm-2"><?= (bool) $allowance->is_percentage == false ? __('employer_amount') : __('employer_percent') ?></th>
                            <?php } ?> 
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

                                                                                                                                                                                                    <!--<td data-title="<?= __('promotion_photo') ?>">-->
                                    <?php
//                                        $array = array(
//                                            "src" => url('storage/uploads/images/'),
//                                            'width' => '35px',
//                                            'height' => '35px',
//                                            'class' => 'img-rounded'
//                                        );
//                                        echo img($array);
                                    ?>
                                    <!--</td>-->
                                    <td data-title="<?= __('student_name') ?>">
                                        <?php echo $user->name; ?>
                                    </td>
                                    <td data-title="<?= __('student_roll') ?>">
                                        <?php echo $user->usertype; ?>
                                    </td>
                                    <td data-title="<?= __('student_section') ?>">
                                        <?php echo $user->email; ?>
                                    </td>
                                    <td data-title="<?= __('student_section') ?>">
                                        <?php echo $user->phone; ?>
                                    </td>
                                    <?php if ($type == 'allowance' || $type == 'deduction') { ?>
                                        <td data-title="<?= __('amount') ?>">
                                            <?php
                                            if ($type == 'allowance') {
                                                $user_allowance = \App\Model\UserAllowance::where('user_id', $user->id)->where('table', $user->table)->where('allowance_id', $set)->first();

                                                $amount = (bool) $allowance->is_percentage == false ?
                                                        (!empty($user_allowance) && $user_allowance->amount > 0 ? $user_allowance->amount : $allowance->amount) :
                                                        (!empty($user_allowance)  && (int) $user_allowance->percent > 0 ? $user_allowance->percent : $allowance->percent);

                                                $deadline = !empty($user_allowance)? $user_allowance->deadline : '';
                                            } else if ($type == 'deduction') {
                                                $user_deduction = \App\Model\UserDeduction::where('user_id', $user->id)->where('table', $user->table)->where('deduction_id', $set)->first();
                                                $amount = (bool) $allowance->is_percentage == false ?
                                                        (!empty($user_deduction)  && $user_deduction->amount > 0 ? $user_deduction->amount : $allowance->amount) :
                                                        (!empty($user_deduction)  && (int) $user_deduction->percent > 0 ? $user_deduction->percent : $allowance->percent);

                                                $employer_amount = (bool) $allowance->is_percentage == false ?
                                                        (!empty($user_deduction)  && $user_deduction->amount > 0 ? $user_deduction->employer_amount : $allowance->employer_amount) :
                                                        (!empty($user_deduction)  && (int) $user_deduction->percent > 0 ? $user_deduction->employer_percent : $allowance->employer_percent);

                                                $deadline = !empty($user_deduction) ? $user_deduction->deadline : '';
                                            }
                                            ?>

                                            <input placeholder="<?= (bool) $allowance->is_percentage == false ? __('amount') : __('percent') ?>" type="number" class="form-control all_deduc" id="amount<?= $user->id . $user->table ?>" name="amount" data-is_percent="<?= (bool) $allowance->is_percentage == false ? 0 : 1 ?>" value="<?= $amount ?>" >


                                        </td>
                                        <?php
                                        if ($type == 'deduction') {
                                            ?>  
                                            <td>
                                                <input placeholder="<?= (bool) $allowance->is_percentage == false ? __('employer_amount') : __('employer_percent') ?>" type="number" class="form-control all_deduc" id="employer_amount<?= $user->id . $user->table ?>" name="amount" data-is_percent="<?= (bool) $allowance->is_percentage == false ? 0 : 1 ?>" value="<?= $employer_amount ?>" ></td>
                                        <?php }
                                    }
                                    ?>
                                        <?php if ($type == 'pension') { ?>
                                        <td data-title="<?= __('student_section') ?>">
                                            <?php
                                            $user_pension = DB::table('user_pensions')->where('user_id', $user->id)->where('table', $user->table)->where('pension_id', $set)->first();
                                           
                                            ?>
                                            <input type="text" <?php
                                            if (!empty($user_pension) && in_array($user->id . $user->table, $subscriptions)) {
                                                echo strlen($user_pension->checknumber) > 1 ? ' value="' . $user_pension->checknumber . '" ' : ' value="' . $user->national_id . '"';
                                                echo ' pension="' . $user_pension->id . '"';
                                            } else {
                                                echo 'disabled';
                                            }
                                            ?> class="checknumber" id="<?= $user->id ?>" table="<?= $user->table ?>"/>
                                            <span id="check<?= $user->id ?><?= $user->table ?>"></span>
                                        </td>
                                        <?php } ?>
                                    <td data-title="<?= __('action') ?>">
                                        <?php
                                        if (in_array($user->id . $user->table, $subscriptions)) {
                                            ?>
                                            <a href="<?= url('payroll/deleteSubscriber/null/?user_id=' . $user->id . '&table=' . $user->table . '&set=' . $set . '&type=' . $type) ?>" class="btn btn-danger btn-xs mrg"><i class="fa fa-trash-o"></i> Remove</a>
                                        <?php } else { ?>
                                            <input type="checkbox" value="<?= $user->id; ?>" name="result<?= $user->id; ?>" class="subscribe" id="<?= $user->id ?>" datatype="<?= $type ?>" table="<?= $user->table ?>" class="check<?= $user->id ?>">
        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>




            </div> <!-- col-sm-12 for tab -->
        </div>
    </div>
</div>

<script type="text/javascript">

    $(".checknumber").blur(function (event) {

        var inputs = $(this).val();
        var user_id = $(this).attr('id');
        var table = $(this).attr('table');
        var pension_id = $(this).attr('pension');
        if (inputs == null) {

        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('payroll/checknumber') ?>",
                data: {
                    "inputs": inputs,
                    user_id: user_id,
                    table: table,
                    'pension_id': pension_id
                },
                dataType: "html ",
                beforeSend: function (xhr) {
                    $('#check' + user_id + table).html('<a href="#/refresh"><i class="fa fa-spinner"></i> </a>');
                },
                complete: function (xhr, status) {
                    $('#check' + user_id + table).html('<span class="label label-success">' + status + '</span>');
                },

                success: function (data) {
                    toast(data);
                }
            });
        }

    });
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
        var amount = $('#amount' + user_id + table).val();
        var employer_amount = $('#employer_amount' + user_id + table).val();
        var is_percentage = $('#amount' + user_id + table).attr('data-is_percent');
        $('#' + user_id).removeAttr('disabled');
//        if (datatype == 'pension') {
//            swal({
//                title: "Subscribe",
//                text: "Please add employee checknumber :",
//                type: "input",
//                showCancelButton: true,
//                closeOnConfirm: false,
//                inputPlaceholder: "Write valid checknumber"
//            }, function (inputValue) {
//                if (inputValue === false)
//                    return false;
//                if (inputValue === "") {
//                    swal.showInputError("You need to write  valid checknumber!");
//                    return false;
//                } else {
//                    subscribeUser(datatype, user_id, tag_id, table, inputValue);
//                    swal("Success!", "success ", "success");
//                }
//            });
//        } else {
        subscribeUser(datatype, user_id, tag_id, table, is_percentage, amount, employer_amount);
        //  }

    });

    function subscribeUser(datatype, user_id, tag_id, table, is_percentage, inputValue = null, employer_amount = null) {

        if (parseInt(user_id) && parseInt(tag_id)) {
            $.ajax({
                type: 'POST',
                url: "<?= url('payroll/subscribe') ?>",
                data: {"user_id": user_id, "tag_id": tag_id, table: table, datatype: datatype, is_percentage: is_percentage, checknumber: inputValue, employer_amount: employer_amount},
                dataType: "html",
                success: function (data) {
                    toast(data);
                }
            });
    }
    }
 
</script>
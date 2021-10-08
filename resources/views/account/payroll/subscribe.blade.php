@extends('layouts.app') 
@section('content') 
<?php  
 if($type == 'allowance'){
   $types =  'allowance';
 }elseif($type == 'deduction'){
    $types = 'deduction';
 }else{
    $types = 'pension';
 }
 $deductionType = 'Subscription - '.$types;
 $breadcrumb = array('title' => $deductionType,'subtitle'=>'accounts','head'=>'payroll');
?>

<div class="main-body">
    <div class="page-wrapper">
      <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
      					
        <div class="page-body">
          <div class="row">
            <div class="col-sm-12">
             <div class="card">



                
                                        
                                              <div class="card-header">
                                                <?php if ($type == 'allowance' || $type == 'deduction') { ?>
                                                    <div class="col-sm-12 col-xs-12 col-sm-offset-3 list-group">
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
                                                                        <td><?= money($allowance->amount) ?></td>
                                                                        <td><?= $allowance->description ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                                <div class="card-block">
                                                    <div class="dt-responsive table-responsive">
                                                        <table id="simpletable" class="table table-striped table-bordered nowrap dataTable">
                                                            <thead>
                                                                 <tr>
                                                                    <th> #</th>
                                                                    <th>Name</th>
                                                                    <th>User role</th>
                                                                    <th>Email</th>
                                                                    <th>Phone Number</th>
                                                                    <?php if ($type == 'pension') { ?>
                                                                    <th>National ID/Check  Number</th>
                                                                    <?php } ?>
                                                                    <?php if ($type == 'allowance' || $type == 'deduction') { ?>
                                                                    <th><?= (bool) $allowance->is_percentage == false ? 'Amount &nbsp;' : 'Percent' ?></th>
                                                                    <?php }
                                                                    if ($type == 'deduction') {?>
                                                                    <th><?= (bool) $allowance->is_percentage == false ? 'Employer amount' : 'Employer percent' ?></th>
                                                                    <?php } ?> 
                                                                    <th> Action </th>
                                                                </tr>
                                                            </thead>
                                                                 
                                                            <tbody>
                                                            <?php
                                                            if (!empty($users)) { $i = 1;
                                                                foreach ($users as $user) {
                                                                    $arr = array('user_id' => $user->id ); ?>
                                                                    <tr>
                                                                        <td> <?php echo $i; ?> </td>
                                                                        <td> <?php echo ucfirst($user->firstname.' '.$user->lastname); ?> </td>
                                                                        <td> <?php echo $user->role->name; ?> </td>
                                                                        <td> <?php echo $user->email; ?> </td>
                                                                        <td> <?php echo $user->phone; ?> </td>
                                                                        <?php if ($type == 'allowance' || $type == 'deduction') { ?>
                                                                        <td> <?php
                                                                                if ($type == 'allowance') {
                                                                                    $user_allowance = \App\Models\UserAllowance::where('user_id', $user->id)->where('allowance_id', $set)->first();
                                                                                    $amount = (bool) $allowance->is_percentage == false ?
                                                                                            (!empty($user_allowance) && $user_allowance->amount > 0 ? $user_allowance->amount : $allowance->amount) :
                                                                                            (!empty($user_allowance)  && (int) $user_allowance->percent > 0 ? $user_allowance->percent : $allowance->percent);
                                                                                    $deadline = !empty($user_allowance)? $user_allowance->deadline : '';
                                                                                } else if ($type == 'deduction') {
                                                                                    $user_deduction = \App\Models\UserDeduction::where('user_id', $user->id)->where('deduction_id', $set)->first();
                                                                                    $amount = (bool) $allowance->is_percentage == false ?
                                                                                            (!empty($user_deduction)  && $user_deduction->amount > 0 ? $user_deduction->amount : $allowance->amount) :
                                                                                            (!empty($user_deduction)  && (int) $user_deduction->percent > 0 ? $user_deduction->percent : $allowance->percent);
                                    
                                                                                    $employer_amount = (bool) $allowance->is_percentage == false ?
                                                                                            (!empty($user_deduction)  && $user_deduction->amount > 0 ? $user_deduction->employer_amount : $allowance->employer_amount) :
                                                                                            (!empty($user_deduction)  && (int) $user_deduction->percent > 0 ? $user_deduction->employer_percent : $allowance->employer_percent);
                                    
                                                                                    $deadline = !empty($user_deduction) ? $user_deduction->deadline : '';
                                                                                }
                                                                                ?>
                                                                                <input placeholder="<?= (bool) $allowance->is_percentage == false ? __('Amount') : __('percent') ?>" type="number" class="form-control" style="width:70px;"  id="amount<?= $user->id ?>" name="amount" data-is_percent="<?= (bool) $allowance->is_percentage == false ? 0 : 1 ?>" value="<?= $amount ?>" >
                                                                            </td>
                                                                            <?php
                                                                            if ($type == 'deduction') { ?>  
                                                                                <td>
                                                                                    <input placeholder="<?= (bool) $allowance->is_percentage == false ? __('Employer amount') : __('Employer percent') ?>" type="number" class="form-control"  style="width:130px;" id="employer_amount<?= $user->id  ?>" name="amount" data-is_percent="<?= (bool) $allowance->is_percentage == false ? 0 : 1 ?>" value="<?= $employer_amount ?>" >
                                                                                </td>
                                                                                <?php }
                                                                                }
                                                                                ?>
                                                                            <?php if ($type == 'pension') { ?>
                                                                            <td>
                                                                            <?php $user_pension = DB::table('user_pensions')->where('user_id', $user->id)->where('pension_id', $set)->first(); ?>
                                                                                <input type="text" <?php
                                                                                if (!empty($user_pension) && in_array($user->id, $subscriptions)) {
                                                                                    echo strlen($user_pension->checknumber) > 1 ? ' value="' . $user_pension->checknumber . '" ' : ' value="' . $user->national_id . '"';
                                                                                    echo ' pension="' . $user_pension->id . '"';
                                                                                } else {
                                                                                    echo 'disabled';
                                                                                }
                                                                                ?> class="checknumber" style="width:160px;" id="<?= $user->id ?>" />
                                                                                <span id="check<?= $user->id ?>"></span>
                                                                            </td>
                                                                            <?php } ?>
                                                                            <td>
                                                                            <?php
                                                                            if (in_array($user->id, $subscriptions)) {?>
                                                                                <a href="<?= url('payroll/deleteSubscriber/null/?user_id=' . $user->id  . '&set=' . $set . '&type=' . $type) ?>" class="btn btn-sm btn-danger"> REMOVE </a>
                                                                            <?php } else { ?>
                                                                                <input type="checkbox" value="<?= $user->id; ?>" name="result<?= $user->id; ?>" class="subscribe" id="<?= $user->id ?>" datatype="<?= $type ?>"  class="check<?= $user->id ?>">
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php $i++; } }?>
                                                                </tbody>
                                                          
                                                        </table>
                                                    </div>
                                                </div>
                                            
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>


      <script type="text/javascript">
    
      
    $(".checknumber").blur(function (event) {
        var inputs = $(this).val();
        var user_id = $(this).attr('id');
        var pension_id = $(this).attr('pension');
        if (inputs == null) {
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('payroll/checknumber') ?>",
                data: {
                    "inputs": inputs,
                     user_id: user_id,
                    'pension_id': pension_id
                },
                dataType: "html ",
                beforeSend: function (xhr) {
                    $('#check' + user_id).html('<a href="#/refresh"> </a>');
                },
                complete: function (xhr, status) {
                   $('#check' + user_id).html('<span class="label label-info">' + status + '</span>');
                },
                success: function (data) {
                    toast(data);
                    window.location.reload();
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
                window.location.reload();
            }
        });
    }

    $('.subscribe').click(function () {
        var user_id = $(this).attr("id");
        var tag_id = "<?= $set ?>";
        var datatype = $(this).attr("datatype");
        var amount = $('#amount' + user_id ).val();
        var employer_amount = $('#employer_amount' + user_id).val();
        var is_percentage = $('#amount' + user_id).attr('data-is_percent');
        
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
        subscribeUser(datatype, user_id, tag_id, is_percentage, amount, employer_amount);
        //  }
    });

  function subscribeUser(datatype, user_id, tag_id, is_percentage, inputValue = null, employer_amount = null) {
        if (parseInt(user_id) && parseInt(tag_id)) {
            $.ajax({
                type: 'POST',
                url: "<?= url('payroll/subscribe') ?>",
                data: {"user_id": user_id, "tag_id": tag_id, datatype: datatype, is_percentage: is_percentage, checknumber: inputValue, employer_amount: employer_amount},
                dataType: "html",
                success: function (data) {
                    toast(data);
                    window.location.reload();
                }
            });
       }
    }
 
</script>

@endsection

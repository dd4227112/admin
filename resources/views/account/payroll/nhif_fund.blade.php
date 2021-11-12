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
?>

<div class="main-body">
    <div class="page-wrapper">

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
                    <li class="breadcrumb-item"><a href="#!">accounts</a>
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


                    <div class="card-header">
                        <?php if ($type == 'allowance' || $type == 'deduction') { ?>
                            <div class="col-sm-12 col-xs-12 col-sm-offset-3 list-group">
                                <div class="list-group-item">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th><?= ("name") ?></th>
                                                <th><?= ("members") ?></th>
                                                <th><?= ("description") ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <tr>
                                            <td><?= ucfirst($type) ?></td>
                                            <td><?= $allowance->name ?></td>
                                            <td><?= $allowance->userDeductions()->count();  ?></td>
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
                                        <th class="col-sm-1"><?= ('#') ?></th>
                                        <th class="col-sm-2">Name</th>
                                        <th class="col-sm-2">Membership No</th>
                                        <th class="col-sm-1">Basic Salary</th>
                                        <th class="col-sm-1">Gross Pay</th>
                                        <th class="col-sm-1">Employee 3%</th>
                                        <th class="col-sm-1">Employer 3%</th>
                                        <th class="col-sm-1">Topup</th>
                                        <th class="col-sm-1">Total</th>
                                        <th class="col-sm-1"><?= ('action') ?></th>
                                    </thead>
                                            
                                     <tbody>
                        <?php
                        if (!empty($users)) {
                          
                            $i = 1;
                            $allowance_total_amount = 0;
                            $total_topup_amount = 0;
                            $deduction_total_amount = 0;
                            $total_employer_amount = 0;
                            foreach ($users as $user) {
                                $basic_salary =  $user->salary;
                        
                                $arr = array('user_id' => $user->id);?>

                                <tr id="std<?= $user->id; ?>">
                                    <td data-title="<?= ('slno') ?>">
                                        <?php echo $i; ?>
                                    </td>    
                                    <td>
                                        <?php echo $user->firstname. '' .$user->lastname; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $user_pension = DB::table('user_deductions')->where('user_id', $user->id)->where('deduction_id', $set)->first();
                                        ?>
                                        <input style="width: 120px;" type="text" <?php echo !empty($user_pension->member_id) ? ' value="' . $user_pension->member_id . '" ' : ' value=""';
                                        ?> class="form-control checknumber" id="<?= $user->id ?>"/>
                                        <span id="check<?= $user->id ?>"></span>
                                    </td>
                                    
                                    <td data-title="<?= ('student_section') ?>">
                                    <?php echo $user->salary; ?>
                                    </td>

                                    <td>
                                            <?php
                                            //calculate user allowances
                                            $allowances = \App\Models\UserAllowance::where('user_id', $user->id)->get();
                                            $allowance_ids = array();
                                            $total_allowance = 0;
                                            $taxable_allowances = 0;
                                            $non_taxable_allowances = 0;
                                            $no_pension_allowances = 0;
                                            if (count($allowances)>0 ) {
                                                foreach ($allowances as $value) {
                                                    $all_amount = (float) $value->amount > 0 ? $value->amount : $value->allowance->amount;
                                                    $all_percent = (float) $value->percent > 0 ? $value->percent : $value->allowance->percent;
                                        
                                                    $all_end_date = date_create(date('Y-m-d', strtotime($value->deadline)));
                                                    $all_now = date_create(date('Y-m-d'));
                                                    $all_diffi = date_diff($all_now, $all_end_date);
                                                    $all_time_diff = $all_diffi->format("%R%a");
                                                  
                                                    if ($value->allowance->type == 0) {
                                                        //means non-taxable allowances
                                                        if ($value->allowance->category == 2 && (int) $all_time_diff > 0) {
                                                            $allowance_tax_amount = $value->allowance->is_percentage == 1 ? $basic_salary * $all_percent / 100 : $all_amount;
                                                            //  echo $allowance_tax_amount.'<br/>';
                                                            $taxable_allowances += $allowance_tax_amount;
                                                            array_push($allowance_ids, [$allowance_tax_amount => $value->allowance_id]);
                                                        }
                                                        if ($value->allowance->category == 1) {
                                                            //means fixed-allowance
                                                            $allowance_tax_amount = $value->allowance->is_percentage == 1 ? $basic_salary * $all_percent / 100 : $all_amount;
                                                            //  echo $allowance_tax_amount.'<br/>';
                                                            $taxable_allowances += $allowance_tax_amount;
                                                            array_push($allowance_ids, [$allowance_tax_amount => $value->allowance_id]);
                                                        }
                                                    }
                                                    if ($value->allowance->type == 1) {
                                                        //means taxable allowance
                                                        if ($value->allowance->category == 2 && (int) $all_time_diff > 0) {
                                                            //not taxable allowances
                                                            $allowance_nontax_amount = $value->allowance->is_percentage == 1 ? $basic_salary * $all_percent / 100 : $all_amount;
                                                            // echo $allowance_nontax_amount.'<br/>';
                                                            $non_taxable_allowances += $allowance_nontax_amount;
                                                            array_push($allowance_ids, [$allowance_nontax_amount => $value->allowance_id]);
                                                        }
                                                        if ($value->allowance->category == 1) {
                                                            //not taxable allowances
                                                            $allowance_nontax_amount = $value->allowance->is_percentage == 1 ? $basic_salary * $all_percent / 100 : $all_amount;
                                                            // echo $allowance_nontax_amount.'<br/>';
                                                          
                                                            $non_taxable_allowances += $allowance_nontax_amount;
                                                            array_push($allowance_ids, [$allowance_nontax_amount => $value->allowance_id]);
                                                        }
                                                    } 

                                                    if ($value->allowance->pension_included == 1) {
                                                        // included
                                                        if ($value->allowance->category == 2 && (int) $all_time_diff > 0) {
                                                            //monthly 
                                                            $allowance_with_no_pension = $value->allowance->is_percentage == 1 ? $basic_salary * $all_percent / 100 : $all_amount;
                                                            // echo $allowance_nontax_amount.'<br/>';
                                                            $no_pension_allowances += $allowance_with_no_pension;
                                                        }
                                                        if ($value->allowance->category == 1) {
                                                            //fixed
                                                            $allowance_with_no_pension = $value->allowance->is_percentage == 1 ? $basic_salary * $all_percent / 100 : $all_amount;
                                                            // echo $allowance_nontax_amount.'<br/>';
                                                            $no_pension_allowances += $allowance_with_no_pension;
                                                           
                                                        }
                                                    }
                                                    $allowance_amount = $non_taxable_allowances + $taxable_allowances;
                                                    $total_allowance = $allowance_amount;
                                                 
                                                }
                                            }

                                          
                                        
                                            // echo ($total_allowance);
                                            // $sum_of_total_allowances += $total_allowance;
                                             $gross_pay = $basic_salary + $total_allowance;
                                                echo $gross_pay;
                                                $total_topup =  (($basic_salary + $total_allowance)*0.03)*2;

                                                if($total_topup < 40000){
                                                    $total_cost = $total_topup + (40000 - $total_topup);
                                                    $top_up = 40000 - $total_topup;
                                                }else{
                                                    $total_cost = $total_topup;
                                                    $top_up = 0;
                                                }
                                                $total_topup_amount += $top_up;
                                                money($total_employer_amount += $gross_pay*0.03);
                                            ?>
                                        </td>
                                    <td>
                                    <?php echo money($gross_pay*0.03); ?>
                                    </td>
                                    
                                    <td >
                                        <?php echo money($gross_pay*0.03); ?>
                                    </td>
                                    <td>
                                        <?php echo money($top_up); ?>
                                    </td>
                                    
                                    <td>
                                        <?php echo money($total_cost); ?>
                                    </td>
                                    <td data-title="<?= ('action') ?>">
                                        <?php
                                        if (in_array($user->id, $subscriptions)) {
                                            ?>
                                            <a href="<?= base_url('payroll/deleteSubscriber/null/?user_id=' . $user->id .'&set=' . $set . '&type=' . $type) ?>" class="btn btn-danger btn-mini btn-round"> Remove</a>
                                        <?php } else { ?>
                                            <input type="checkbox" value="<?= $user->id; ?>" name="result<?= $user->id; ?>" class="subscribe" id="<?= $user->id ?>" datatype="<?= $type ?>" class="check<?= $user->id ?>">
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
        var pension_id = <?=$allowance->id?>;

        if (inputs == null) {
        } else {
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?= url('deduction/nhifNumber') ?>",
                data: {
                    "inputs": inputs,
                    user_id: user_id,
                    'pension_id': pension_id
                },
                dataType: "html ",
                beforeSend: function (xhr) {
                    $('#check' + user_id).html('<a href="#/refresh"<i class="feather icon-refresh-ccw f-13"></i> </a>');
                },
                complete: function (xhr, status) {
                   $('#check' + user_id).html('<label class="badge badge-info ">' + status + '</label>');
                },
                success: function (data) {
                     toastr.success(data);
                  //   window.location.reload();
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
               // swal('success', data, 'success');
                toastr.success(data);

               // $('#std' + a).hide();
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
        subscribeUser(datatype, user_id, tag_id, is_percentage, amount, employer_amount);
        
    });

  function subscribeUser(datatype, user_id, tag_id, is_percentage, inputValue = null, employer_amount = null) {
        if (parseInt(user_id) && parseInt(tag_id)) {
            $.ajax({
                type: 'POST',
                 headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?= url('payroll/subscribe') ?>",
                data: {"user_id": user_id, "tag_id": tag_id, datatype: datatype, is_percentage: is_percentage, checknumber: inputValue, employer_amount: employer_amount},
                dataType: "html",
                success: function (data) {
                  //  toast(data);
                    toastr.success(data);
                    window.location.reload();
                }
            });
       }
    }
 
</script>

@endsection

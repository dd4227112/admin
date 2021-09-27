@extends('layouts.app')
@section('content')

<?php if($type == 2) {
    $deductionType = 'Monthly deductions';
  }else{
    $deductionType = 'Fixed Deductions';
  } ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Payroll</h4>
                <span>Deductions (<?php echo $deductionType; ?>) </span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Deductions</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-body">
          <div class="row">
            <div class="col-sm-12">
             <div class="card">
                {{-- $usertype = session("usertype"); --}}
              
                   <div class="card-header row">
                     <?php  if(can_access('add_deduction')) { ?>
                       <div class="col-sm-6 col-sm-offset-3">
                        <h5 class="page-header"> 
                        <a class="btn btn-success" href="<?php echo url('deduction/add/'.$type) ?>">
                            <i class="fa fa-plus"></i> 
                               Add New Deduction
                          </a>
                        </h5>
                      </div>
                      <?php } ?>
                      <div class="col-sm-6">
                        <form style="" class="form-horizontal" role="form" method="post">  
                            <div class="form-group">              
                                <label for="deduction_type" class="col-sm-5 control-label">
                                   <?= __("Choose category") ?>
                                </label>
                                <div class="col-sm-6">
                                    <?php
                                    $array = array("0" => __("select"));
                                    $deduction_types = [
                                        '1' => 'Fixed Deductions',
                                        '2' => 'Monthly Deductions'
                                    ];
                                    foreach ($deduction_types as $key => $value) {
                                        $array[$key] = $value;
                                    }
                                    echo form_dropdown("deduction_type", $array, old("deduction_type", $type), "id='deduction_type' class='form-control'");
                                    ?>
                                </div>
                            </div>
                             <?= csrf_field() ?>
                        </form>
                      </div>
                     </div>
                 
				         <div id="hide-table"  class="card-block">
					      <div class="table-responsive table-sm table-striped table-bordered table-hover">
                            <?php if (isset($deductions) && !empty($deductions)) { ?>
								<table class="table dataTable">
									<thead>
                                        <tr>
                                            <th ><?= __('#') ?></th>
                                            <th ><?= __('Name') ?></th>
                                            <th ><?= __('Category') ?></th>
                                            <th ><?= __('Amount') ?></th>
                                            <th ><?= __('Members') ?><i class="fa fa-question-circle" title="This is the total number of users who are (or ware ) in this plan. It include active and in active users"></i></th>
                                            <th ><?= __('Percentage') ?></th>
                                            <th ><?= __('Description') ?></th>
                                            <th ><?= __('Bank account') ?></th>
                                            <th ><?= __('Account number') ?></th>
                                            <th ><?= __('Action') ?></th>
                                        </tr>
									</thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($deductions as $deduction) {
                                            ?>
                                            <tr>
                                                <td data-title="<?= __('slno') ?>">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td data-title="<?= __('name') ?>">
                                                    <?php echo $deduction->name; ?>
                                                </td>
                                                <td data-title="<?= __('name') ?>">
                                                    <?php echo $deduction->category == 1 ? 'Fixed' : 'Monthly'; ?>
                                                </td>
                                                <td data-title="<?= __('amount') ?>">
                                                    <?php echo money($deduction->amount); ?>
                                                </td>
                                                 <td data-title="<?= __('amount') ?>">
                                                    <?php echo $deduction->userDeductions()->count(); ?>
                                                </td>
                                                <td data-title="<?= __('percentage') ?>">
                                                    <?php echo $deduction->is_percentage == null ? 'NONE' : $deduction->percent; ?>
                                                </td>
                                                <td data-title="<?= __('description') ?>">
                                                    <?php echo warp($deduction->description,20); ?>
                                                </td>
                                                 <td data-title="<?= __('description') ?>">
                                                    <?php echo $deduction->bankAccount->account_name ?? ''?>
                                                </td>
                                                 <td data-title="<?= __('description') ?>">
                                                    <?php echo $deduction->account_number; ?>
                                                </td>
                                                <td data-title="<?= __('action') ?>">
                                                    <?php echo '<a  href="' . url("deduction/edit/$deduction->id") . ' " class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> ' . __('edit') . ' </a>' ?>
                                                    <?php
                                                    echo (int) $deduction->predefined ==1 ? "": '<a  href="' . url("deduction/delete/$deduction->id") . ' " class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> ' . __('delete') . ' </a>';
                                                    $sub = $type == 1 ? 'subscribe' : 'monthlysubscribe';
                                                    ?>
                                                    <a href="<?= url('deduction/' . $sub . '/' . $deduction->id) ?>" class="btn btn-primary btn-sm mrg" ><i class="fa fa-users"></i> members</a>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                              </table>
                           <?php }else{?>
 
                            <div class="table-responsive table-sm table-striped table-bordered table-hover">
                            <table id="example1" class="table dataTable">
                                <thead>
                                    <tr>
                                        <th ><?= __('slno') ?></th>
                                        <th ><?= __('name') ?></th>
                                        <th ><?= __('category') ?></th>
                                        <th ><?= __('amount') ?></th>
                                        <th ><?= __('members') ?><i class="fa fa-question-circle" title="This is the total number of users who are (or ware ) in this plan. It include active and in active users"></i></th>
                                        <th ><?= __('percentage') ?></th>
                                        <th ><?= __('description') ?></th>
                                          <th ><?= __('bank_account') ?></th>
                                        <th ><?= __('account_number') ?></th>
                                        <th ><?= __('action') ?></th>
                                    </tr>
                                </thead>
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


<script type="text/javascript">
    $('#deduction_type').change(function () {
        var deduction_type = $(this).val();
        if (deduction_type === 0) {
            $('#hide-table').hide();
            $('.nav-tabs-custom').hide();
        } else {
            window.location.href = "<?= url('deduction/index') ?>/" + deduction_type;
        }
    });
</script>
@endsection
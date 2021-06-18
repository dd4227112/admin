@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Loan</h4>
                <span>New loan </span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li><a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a></li>
                    <li class="active"><?= __('borrowers') ?></li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
		
							
        <div class="page-body">
          <div class="row">
            <div class="col-sm-12">
             <div class="card">
                <?php
               // $usertype = session("usertype");
                if(can_access('manage_payroll')) { ?>
				   <div class="card-header row">
                     <div class="col-sm-6">
                         <div>&nbsp;</div>
                        <a class="btn btn-success" href="<?php echo url('loan/loanAdd') ?>">
                            <i class="fa fa-plus"></i> 
                            Add New Application
                         </a>
					  </div>
					 
                        <div class="col-sm-6">
                            <form style="" class="form-horizontal" role="form" method="post">  
                                <div class="form-group">              
                                    <label for="deduction_type" class="col-sm-2 col-sm-offset-2 control-label">
                                        <?= __("category") ?>
                                    </label>
                                    <div class="col-sm-6">
                                        <?php
                                        $array = array("0" => __("select"));
                                        $deduction_types = [
                                            '1' => 'Approved',
                                            '0' => 'All Applications'
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
                   <?php } ?>

                      
				         <div id="hide-table"  class="card-block">
					      <div class="table-responsive table-sm table-striped table-bordered table-hover">
						  <?php if (isset($applications) && count($applications) > 0) { ?>
								<table class="table dataTable">
									<thead>
                                        <tr>
                                            <th class="col-lg-1"><?= __('#') ?></th>
                                            <th class="col-lg-2"><?= __('Name') ?></th>
                                            <th class="col-lg-2"><?= __('Loan type') ?></th>
                                            <th class="col-lg-1"><?= __('Amount') ?></th>
                                            <th class="col-lg-1"><?= __('Date requested') ?></th>
                                            <th class="col-lg-1"><?= __('Date approved') ?></th>
                                            <th class="col-lg-1"><?= __('Paid amount') ?></th>
                                            <th class="col-lg-1"><?= __('Remain amount') ?></th>
                                            <th class="col-lg-1"><?= __('Interest') ?></th>
                                            <th class="col-lg-2"><?= __('Action') ?></th>
                                        </tr>
									</thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($applications as $application) {
                                            ?>
                                            <tr>
                                                <td data-title="<?= __('slno') ?>">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td data-title="<?= __('name') ?>">
                                                    <?php echo $application->user()->name ?? ''; ?>
                                                </td>
                                                <td data-title="<?= __('loan_type') ?>">
                                                    <?php echo $application->loanType->name;  ?>
                                                </td>
                                                <td data-title="<?= __('amount') ?>">
                                                    <?php echo money($application->amount); ?>
                                                </td>
                                                <td data-title="<?= __('date_requested') ?>">
                                                    <?php echo date('d-m-Y', strtotime($application->created_at)); ?>
                                                </td>
                                                <td data-title="<?= __('date_approved') ?>">
                                                    <?php echo (int) $application->approval_status==1 ?
                                                            '<b class="badge badge-success">Approved</b>':
                                                            '<b class="badge badge-warning">Pending</b>' ?>
                                                </td>
                                                <td data-title="<?= __('paid_amount') ?>">
                                                    <?php //calculated from salary ?>
                                                </td>
                                                <td data-title="<?= __('remain_amount') ?>">
                                                    <?php //calculated from total amount - salary loan paid ?>
                                                </td>
                                                <td data-title="<?= __('interest') ?>">
                                                    <?php //auto calculated from interest and current date
                                                    // I=PRT
                                                    $interest=$application->amount*$application->loanType->interest_rate*$application->months/1200;
                                                    echo money($interest);
                                                    ?>
                                                </td>
                                                <td data-title="<?= __('action') ?>">
                                                      
                                                    <?php //echo can_access('manage_payroll') ?  '<a  href="' . url("loan/edit/$application->id") . ' " class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> ' . __('edit') . ' </a>':'' ?>
                                                    <?php
                                                    echo '<a  href="' . url("loan/delete/$application->id") . ' " class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> ' . __('delete') . ' </a>';
                                                 if((int) $application->approval_status <>1 && can_access('manage_payroll')){
                                                    ?>
                                                    <a href="<?= url('loan/approveLoan/' . $application->id) ?>" class="btn btn-primary btn-sm mrg" > Approve</a>
                                                 <?php }?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
								 <?php } else { ?>
								 
								 <table class="table dataTable">
									<thead>
                                        <tr>
                                            <th class="col-lg-1"><?= __('slno') ?></th>
                                           <th class="col-lg-2"><?= __('name') ?></th>
                                           <th class="col-lg-2"><?= __('loan_type') ?></th>
                                           <th class="col-lg-1"><?= __('amount') ?></th>
                                           <th class="col-lg-1"><?= __('date_requested') ?></th>
                                           <th class="col-lg-1"><?= __('date_approved') ?></th>
                                           <th class="col-lg-1"><?= __('paid_amount') ?></th>
                                           <th class="col-lg-1"><?= __('remain_amount') ?></th>
                                           <th class="col-lg-1"><?= __('profit') ?></th>
                                           <th class="col-lg-2"><?= __('action') ?></th>
                                       </tr>
									</thead>
								 </table>
								<?php } ?>
                             </div>
																
                 </div>
            </div> 
        </div>
    </div>
  </div>
</div>


<script type="text/javascript">
    $('#classlevel_id').change(function () {
        var classesID = $(this).val();
        if (classesID == 0) {
            $('#hide-table').hide();
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('grade/grade_list') ?>",
                data: "id=" + classesID,
                dataType: "html",
                success: function (data) {
                    window.location.href = data;
                }
            });
        }
    });

    $('#deduction_type').change(function () {
        var deduction_type = $(this).val();
        if (deduction_type === 0) {
            $('#hide-table').hide();
            $('.nav-tabs-custom').hide();
        } else {
            window.location.href = "<?= url('loan/index') ?>/" + deduction_type;
        }
    });
</script>
@endsection
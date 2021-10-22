@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
      <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
    		
        <div class="page-body">
          <div class="row">
            <div class="col-sm-12">
             <div class="card">
                <?php
        
                if(can_access('manage_payroll')) { ?>
				   <div class="card-header row">
                     <div class="col-sm-6">
                        <x-button url="loan/loanAdd" color="primary" btnsize="sm"  title="Add New Application"></x-button>
					  </div>
					 
                        <div class="col-sm-6 offset-sm-9">
                            <form  class="form-horizontal" role="form" method="post">  
                                <div class="form-group">              
                                    <label class="col-sm-6">
                                        Category
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

                      
				         <div class="card-block">
					      <div class="table-responsive">
						  <?php if (isset($applications) && count($applications) > 0) { ?>
								<table class="table dataTable  table-sm table-striped table-bordered table-hover">
									<thead>
                                        <tr>
                                            <th><?= __('#') ?></th>
                                            <th><?= __('Name') ?></th>
                                            <th><?= __('Loan type') ?></th>
                                            <th><?= __('Amount') ?></th>
                                            <th><?= __('Date requested') ?></th>
                                            <th><?= __('Date approved') ?></th>
                                            <th><?= __('Paid amount') ?></th>
                                            <th><?= __('Remain amount') ?></th>
                                            <th><?= __('Interest') ?></th>
                                            <th><?= __('Action') ?></th>
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
                                                            '<label class="badge badge-inverse-success">Approved</label>':
                                                            '<label class="badge badge-inverse-warning">Pending</label>' ?>
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
                                                    <?php $delete_url = "loan/delete/$application->id"; $edit_url = "loan/edit/$application->id"; ?>
                                                    <?php  if(can_access('manage_payroll')){ ?>
                                                        {{-- <x-button :url="$edit_url" color="info" btnsize="mini" shape="round" title="Edit" toggleTitle="Edit loan"></x-button> --}}
                                                     <?php } ?>
                                                      
                                                     <x-button :url="$delete_url" color="danger" btnsize="mini"  title="delete" shape="round" toggleTitle="Delete"></x-button>
                                                    <?php  $approve_url = "loan/approveLoan/$application->id";
                                                     if((int) $application->approval_status <> 1 && can_access('manage_payroll')){  ?>
                                                     <x-button :url="$approve_url" color="primary" btnsize="mini"  title="Approve" shape="round" toggleTitle="Approve loan"></x-button>
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
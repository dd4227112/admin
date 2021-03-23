@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Loan</h4>
                <span>Loan types </span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= __('menu_dashboard') ?></a>
                    </li>
                    <li class="active"><?= __('loan_types') ?></li>
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
				   <div class="card-header">
                    <h5 class="page-header">
                        <a class="btn btn-success btn-xs" href="<?php echo url('loan/add') ?>">
                            <i class="fa fa-plus"></i> 
                            Add New Loan Type
                        </a>
                     </h5>
					</div>
                   <?php } ?>
				         <div id="hide-table"  class="card-block">
					      <div class="table-responsive table-sm table-striped table-bordered table-hover">
						    <?php if(isset($types) && count($types) > 0) { ?>
								<table class="table dataTable">
									<thead>
									   <tr>
											<th> <?= __('slno')?>           </th>
											<th> <?= __('name')?>           </th>
											<th> <?= __('minimum_amount')?> </th>
											<th> <?= __('maximum_amount')?> </th>
											<th> <?= __('minimum_tenor') ?> </th>
											<th> <?= __('maximum_tenor') ?> </th>
											<th> <?= __('interest_rate') ?> </th>
											<th> <?= __('credit_ratio') ?>  </th>
											<th> <?= __('created_by') ?>    </th>
											<th> <?= __('description') ?>   </th>
											<th> <?= __('action') ?>        </th>
									  </tr>
									</thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($types as $loan_type) {
                                        ?>
                                        <tr>
                                            <td data-title="<?= __('slno') ?>">
                                                <?php echo $i; ?>
                                            </td>
                                            <td data-title="<?= __('name') ?>">
                                                <?php echo $loan_type->name; ?>
                                            </td>
                                            <td data-title="<?= __('minimum_amount') ?>">
                                                <?php echo money($loan_type->minimum_amount) ?>
                                            </td>
                                            <td data-title="<?= __('maximum_amount') ?>">
                                                <?php echo money($loan_type->maximum_amount); ?>
                                            </td>
                                            <td data-title="<?= __('minimum_tenor') ?>">
                                                <?php echo $loan_type->minimum_tenor; ?>
                                            </td>
                                            <td data-title="<?= __('maximum_tenor') ?>">
                                                <?php echo $loan_type->maximum_tenor; ?>
                                            </td>
                                            <td data-title="<?= __('interest_rate') ?>">
                                                <?php echo $loan_type->interest_rate; ?>
                                            </td>
                                            <td data-title="<?= __('credit_ratio') ?>">
                                                <?php echo $loan_type->credit_ratio; ?>
                                            </td>
                                            <td data-title="<?= __('name') ?>">
                                                <?php echo $loan_type->createdBy()->name; ?>
                                            </td>
                                              <td data-title="<?= __('description') ?>">
                                                <?php echo $loan_type->description; ?>
                                            </td>
                                            <td data-title="<?= __('action') ?>">
                                             <?php echo '<a  href="' . url("loan/type/edit/$loan_type->id") . ' " class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> ' . __('edit') . ' </a>' ?>
                                             <?php
                                                echo '<a  href="' . url("loan/type/delete/$loan_type->id") . ' " class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> ' . __('delete') . ' </a>';
                                               ?>
                                            </td>
                                        </tr>
                                        <?php $i++;} ?>
                                  </tbody>
                                </table>
								 <?php } else { ?>
								 
								 <table class="table dataTable">
									<thead>
									   <tr>
											<th> <?= __('slno')?>           </th>
											<th> <?= __('name')?>           </th>
											<th> <?= __('minimum_amount')?> </th>
											<th> <?= __('maximum_amount')?> </th>
											<th> <?= __('minimum_tenor') ?> </th>
											<th> <?= __('maximum_tenor') ?> </th>
											<th> <?= __('interest_rate') ?> </th>
											<th> <?= __('credit_ratio') ?>  </th>
											<th> <?= __('created_by') ?>    </th>
											<th> <?= __('description') ?>   </th>
											<th> <?= __('action') ?>        </th>
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
            window.location.href = "<?= url('deduction/index') ?>/" + deduction_type;
        }
    });
</script>
@endsection




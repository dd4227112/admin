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
               // $usertype = session("usertype");
                if(!can_access('manage_loans')) { ?>
				     <div class="card-header">
                         <x-button url="loan/add" color="primary" btnsize="sm" title="Add new loan type"></x-button> 
					</div>
                   <?php } ?>

				         <div class="card-block">
					      <div class="table-responsive">
						    <?php if(isset($types) && count($types) > 0) { ?>
								<table class="table dataTable table-sm table-striped table-bordered table-hover">
									<thead>
									   <tr>
											<th> <?= __('#')?>           </th>
											<th> <?= __('Name')?>           </th>
											<th> <?= __('Minimum amount')?> </th>
											<th> <?= __('Maximum amount')?> </th>
											<th> <?= __('Minimum tenor') ?> </th>
											<th> <?= __('Maximum tenor') ?> </th>
											<th> <?= __('Interest rate') ?> </th>
											<th> <?= __('Credit ratio') ?>  </th>
											<th> <?= __('Created by') ?>    </th>
											<th> <?= __('Description') ?>   </th>
											<th> <?= __('Action') ?>        </th>
									  </tr>
									</thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($types as $loan_type) {
                                        ?>
                                        <tr>
                                            <td data-title="<?= __('#') ?>">
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
                                                <?php echo money($loan_type->minimum_tenor); ?>
                                            </td>
                                            <td data-title="<?= __('maximum_tenor') ?>">
                                                <?php echo money($loan_type->maximum_tenor); ?>
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
                                            <td class="text-center">
                                                 <?php $edit_url = "loan/type/edit/$loan_type->id"; $delete_url = "loan/type/delete/$loan_type->id"; ?>
                                                <x-button :url="$edit_url" color="primary"  shape="round"  title="Edit"></x-button>
                                                <x-button :url="$delete_url"  color="danger"  shape="round" title="Delete"></x-button> 
                                             {{-- <?php echo '<a  href="' . url("loan/type/edit/$loan_type->id") . ' " class="btn btn-info btn-sm"> ' . __('edit') . ' </a>' ?> --}}
                                             {{-- <?php
                                                echo '<a  href="' . url("loan/type/delete/$loan_type->id") . ' " class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> ' . __('delete') . ' </a>';
                                               ?> --}}
                                
                                            </td>
                                        </tr>
                                        <?php $i++;} ?>
                                  </tbody>
                                </table>
								 <?php } else { ?>
								 
								 <table class="table dataTable">
									<thead>
									  <tr>
											<th> <?= __('#')?>           </th>
											<th> <?= __('Name')?>           </th>
											<th> <?= __('Minimum amount')?> </th>
											<th> <?= __('Maximum amount')?> </th>
											<th> <?= __('Minimum tenor') ?> </th>
											<th> <?= __('Maximum tenor') ?> </th>
											<th> <?= __('Interest rate') ?> </th>
											<th> <?= __('Credit ratio') ?>  </th>
											<th> <?= __('Created by') ?>    </th>
											<th> <?= __('Description') ?>   </th>
											<th> <?= __('Action') ?>        </th>
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




@extends('layouts.app')
@section('content')

<?php  
if($type == 2) {
    $deductionType = 'Monthly deductions';
  }else{
    $deductionType = 'Fixed Deductions';
  } 
  

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
      
              <div class="card">  
                    <div class="card-block">
                     <div class="row">
                         <div class="col-sm-6">
                               <?php $add_url = "deduction/add/$type"; ?>
                                <a href="<?= url($add_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Add New Deduction"> Add Deduction </a> 

                            </div>
                            <div class="col-sm-6 offset-sm-9 m-b-30">
                                <form  class="form-horizontal" role="form" method="post">  
                                    <div class="form-group">              
                                        <label for="category" class="col-sm-12 col-sm-offset-2 control-label">
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

                          <div class="table-responsive">
                            <?php if (isset($deductions) && !empty($deductions)) { ?>
                            <table class="table dataTable table-sm table-striped table-bordered nowrap">
                                
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
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                <td>
                                                    <?php echo $deduction->name; ?>
                                                </td>
                                                <td>
                                                    <?php echo $deduction->category == 1 ? 'Fixed' : 'Monthly'; ?>
                                                </td>
                                                <td>
                                                    <?php echo money($deduction->amount); ?>
                                                </td>
                                                 <td>
                                                    <?php echo $deduction->userDeductions()->count(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $deduction->is_percentage == null ? 'NONE' : $deduction->percent; ?>
                                                </td>
                                                <td>
                                                    <?php echo warp($deduction->description,20); ?>
                                                </td>
                                                 <td>
                                                    <?php echo $deduction->bankAccount->account_name ?? ''?>
                                                </td>
                                                 <td>
                                                    <?php echo $deduction->account_number; ?>
                                                </td>
                                                <td>
                                                     <?php $sub = $type == 1 ? 'subscribe' : 'monthlysubscribe';$members_url="deduction/$sub/$deduction->id";$edit_url="deduction/edit/$deduction->id";
                                                           $delete_url = "deduction/delete/$deduction->id"; ?>
                                                           <a href="<?= url($edit_url) ?>" class="btn btn-info btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Edit members"> edit </a> 
                                                    
                                                    <?php if((int) $deduction->predefined !=1){ ?>
                                                       <a href="<?= url($delete_url) ?>" class="btn btn-danger btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Delete members"> delete </a> 

                                                    <?php } ?>
                                                    <a href="<?= url($members_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Deduction members"> members </a> 

                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                              </table>
                           <?php }else{?>
 
                           
                         <div class="table-responsive">
                          <table class="table dataTable table-sm table-striped table-bordered nowrap">
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
@extends('layouts.app')
@section('content')


    
        <?php $title = isset($allowance_type) ? $allowance_type : 'Allowances';  ?>

           <div class="page-header">
            <div class="page-header-title">
                <h4><?= $title ?></h4>
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

                <div class="card">  
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 col-xl-6 m-b-30">
                                  <?php $url = "allowance/add/$category"; ?>
                                     <a href="<?= url($url) ?>" class="btn btn-primary btn-sm  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="add allowance"> Add allowance </a> 
                            

                            </div>
                            <div class="col-sm-12 col-xl-6 m-b-30">
                                <form style="" class="form-horizontal" role="form" method="post">  
                                    <div class="form-group">              
                                        <label for="category" class="col-sm-12 col-sm-offset-2 control-label">
                                            <?= __("Choose category") ?>
                                        </label>
                                        <div class="col-sm-12">
                                            <?php
                                            $array = array("0" => __("Select"));
                                            $deduction_types = [
                                                '1' => 'Fixed Allowances',
                                                '2' => 'Monthly Allowances'
                                            ];
                                            foreach ($deduction_types as $key => $value) {
                                                $array[$key] = $value;
                                            }
                                            echo form_dropdown("category", $array, old("type", $category), "id='category' class='form-control'");
                                            ?>
                                        </div>
                                    </div>
                                    <?= csrf_field() ?>
                                </form>
                            </div>
                        </div>


   
                        <div class="table-responsive">
                            <?php if (isset($allowances) && !empty($allowances)) { ?>   
                            <table class="table dataTable table-sm table-striped table-bordered nowrap">
									<thead>
                                        <tr>
                                            <th ><?= __('#') ?></th>
                                            <th><?= __('name') ?></th>
                                            <th ><?= __('category') ?></th>
                                            <th ><?= __('type') ?></th>
                                            <th ><?= __('pension') ?></th>
                                            <th ><?= __('amount') ?></th>
                                            <th ><?= __('percentage') ?></th>
                                            <th ><?= __('description') ?></th>
                                            <th><?= __('action') ?></th>
                                        </tr>
									</thead>
                             <tbody>
                                <?php
                                $i = 1;
                    
                                foreach ($allowances as $allowance) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $allowance->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $allowance->category == 1 ? 'Fixed' : 'Monthly'; ?>
                                        </td>
                                        <td>
                                            <?php echo $allowance->type == 0 ? 'Taxable' : 'Non Taxable'; ?>
                                        </td>
                                        <td>
                                            <?php echo $allowance->pension_included == 1 ? 'Included' : 'Non Included'; ?>
                                        </td>
                                        <td>
                                            <?php echo money($allowance->amount); ?>
                                        </td>
                                        <td>
                                            <?php echo (bool) $allowance->is_percentage == false ? 'NONE' : $allowance->percent; ?>
                                        </td>
                                        <td>
                                            <?php echo warp($allowance->description,20); ?>
                                        </td>
                                        <td>
                                            <?php $sub = $category == 1 ? 'subscribe' : 'monthlysubscribe';$edit_url = "allowance/edit/$allowance->id"; $delete_url = "allowance/delete/$allowance->id"; $members_url="allowance/$sub/$allowance->id";?>
                                       
                                            <a href="<?= url($edit_url) ?>" class="btn btn-info btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Edit member"> edit </a> 
                                            <a href="<?= url($delete_url) ?>" class="btn btn-danger btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Delete member"> delete </a> 
                                            <a href="<?= url($members_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="View member"> members </a> 

                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
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
 

<script type="text/javascript">
    $('#category').change(function () {
        var category = $(this).val();
        if (category === 0) {
            $('#hide-table').hide();
            $('.nav-tabs-custom').hide();
        } else {
            window.location.href = "<?= url('allowance/index') ?>/" + category;
        }
    });
</script>
@endsection
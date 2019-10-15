@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-title">
            <h4>Projections </h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Pages</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
<div class="card">
    <div class="box-header">
        <h3 class="box-title" data-original-title="Add all other school accounts here" data-toggle="tooltip" data-placement="right"><i class="fa icon-expense"></i>Charts of Accounts</h3>


    </div><!-- /.box-header --><div class="box-body">
    <div class="row">
        <div class="col-sm-12">
            
  
                <div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-sm-1"><?= __('slno') ?></th>
                                <th class="col-sm-1"><?= __('account_code') ?></th>
                                <th class="col-sm-2"><?= __('account_name') ?></th>
                                <th class="col-sm-2"><?= __('account_type') ?></th>
                                <th class="col-sm-2" ><?= __('account_group') ?></th>
                                <th class="col-sm-2"><?= __('expense_note') ?></th>
                                <?php if (can_access('edit_expense')) { ?>
                                    <th class="col-sm-2"><?= __('action') ?></th>
                                    <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        
                            $total_expense = 0;
                            if (count($expenses)) {
                                $i = 1;
                                foreach ($expenses as $expense) {
                                    ?>
                                    <tr>
                                        <td data-title="<?= __('slno') ?>">
                                            <?php echo $i; ?>
                                        </td>
                                        <td data-title="<?= __('expense_code') ?>">
                                            <?php echo $expense->code; ?>
                                        </td>
                                        <td data-title="<?= __('expense_expense') ?>">
                                            <?php echo $expense->name; ?>
                                        </td>
                                        <td data-title="<?= __('account_type') ?>">
                                            <?php
                                            foreach ($expense->financialCategory()->get() as $cat) {
                                              
                                                    echo $cat->name;
                                                
                                            }
                                            ?>
                                        </td>
                                        <td data-title="<?= __('account_group') ?>">
                                            <?php
                                            foreach ($expense->accountGroup()->get() as $group) {
                                                 echo $group->name;
                                                 }
                                            ?>
                                        </td>

                                        <?php if (can_access('add_chart_of_account')) { ?>
                                            <td data-title="<?= __('expense_note') ?>">
                                                <?php echo $expense->note; ?>
                                            </td>
                                        <?php } else { ?>
                                            <td data-title="<?= __('expense_note') ?>">
                                                <?php echo $expense->note; ?>
                                            </td>
                                        <?php } ?>

                                        <?php if (can_access('edit_chart_of_account')) { ?>
                                            <td data-title="<?= __('action') ?>">
                                                
                                                <?php if($expense->predefined==0){ echo btn_edit('expense/category_edit/' . $expense->id . '/' . $id, __('edit')); ?>
                                                <?php echo btn_delete('expense/category_delete/' . $expense->id . '/' . $id, __('delete')); }else{     echo ' <i class="fa fa-question-circle" title="This cannot be deleted or edited because it has been defined somewhere else. Please check in fee section or in banking section and edit/delete it there"></i>'; }?>
                                               
                                            </td>
                                        <?php } ?>


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
@endsection

<div class="box">
    <div class="box-header">
        <h3 class="box-title" data-original-title="Add all other school accounts here" data-toggle="tooltip" data-placement="right"><i class="fa icon-expense"></i> <?= $data->lang->line('panel_category_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li><a href="<?= base_url("expense/index") ?>"><?= $data->lang->line('panel_category_title') ?></a></li>
            <li class="active"></li>
        </ol>
    </div><!-- /.box-header --><div class="box-body">
    <div class="row">
        <div class="col-sm-12">
            
                    <h5 class="page-header">
                        <a class="btn btn-success" href="<?php echo base_url('expense/add_chart') ?>">

                            <i class="fa fa-plus"></i>
                            Add New Chart of Account

                        </a>
                    </h5>

            <?php
             if (count($expenses)==0) {
                 echo '<a href="'. base_url('expense/addDefaultChart').'">Import Default Charts</a>'; 
             }else
            if (can_access('view_chart_of_account')) {
                ?>
                <div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-sm-1"><?= $data->lang->line('slno') ?></th>
                                <th class="col-sm-1"><?= $data->lang->line('account_code') ?></th>
                                <th class="col-sm-2"><?= $data->lang->line('account_name') ?></th>
                                <th class="col-sm-2"><?= $data->lang->line('account_type') ?></th>
                                <th class="col-sm-2" ><?= $data->lang->line('account_group') ?></th>
                                <th class="col-sm-2"><?= $data->lang->line('expense_note') ?></th>
                                <?php if (can_access('edit_expense')) { ?>
                                    <th class="col-sm-2"><?= $data->lang->line('action') ?></th>
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
                                        <td data-title="<?= $data->lang->line('slno') ?>">
                                            <?php echo $i; ?>
                                        </td>
                                        <td data-title="<?= $data->lang->line('expense_code') ?>">
                                            <?php echo $expense->code; ?>
                                        </td>
                                        <td data-title="<?= $data->lang->line('expense_expense') ?>">
                                            <?php echo $expense->name; ?>
                                        </td>
                                        <td data-title="<?= $data->lang->line('account_type') ?>">
                                            <?php
                                            foreach ($expense->financialCategory()->get() as $cat) {
                                              
                                                    echo $cat->name;
                                                
                                            }
                                            ?>
                                        </td>
                                        <td data-title="<?= $data->lang->line('account_group') ?>">
                                            <?php
                                            foreach ($expense->accountGroup()->get() as $group) {
                                                 echo $group->name;
                                                 }
                                            ?>
                                        </td>

                                        <?php if (can_access('add_chart_of_account')) { ?>
                                            <td data-title="<?= $data->lang->line('expense_note') ?>">
                                                <?php echo $expense->note; ?>
                                            </td>
                                        <?php } else { ?>
                                            <td data-title="<?= $data->lang->line('expense_note') ?>">
                                                <?php echo $expense->note; ?>
                                            </td>
                                        <?php } ?>

                                        <?php if (can_access('edit_chart_of_account')) { ?>
                                            <td data-title="<?= $data->lang->line('action') ?>">
                                                
                                                <?php if($expense->predefined==0){ echo btn_edit('expense/category_edit/' . $expense->id . '/' . $id, $data->lang->line('edit')); ?>
                                                <?php echo btn_delete('expense/category_delete/' . $expense->id . '/' . $id, $data->lang->line('delete')); }else{     echo ' <i class="fa fa-question-circle" title="This cannot be deleted or edited because it has been defined somewhere else. Please check in fee section or in banking section and edit/delete it there"></i>'; }?>
                                               
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



            <?php } ?>
        </div>  

    </div>
</div>
</div>
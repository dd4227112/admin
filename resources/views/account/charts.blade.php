@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
       <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

        <div class="page-body">
            <!-- form start -->
            <div class="page-body">
                <div class="card">
                   
                    <div class="col-sm-12">

                        &nbsp;  <h5 class="page-header">

                            <a class="btn btn-success" href="#" type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#large-Modal">
                                <i class="fa fa-plus"></i> 
                                Add New Account
                            </a>
                        </h5>
                        <div class="table-responsive dt-responsive "> 


                            <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th class="col-sm-1"><?= __('slno') ?></th>
                                        <th class="col-sm-1"><?= __('Account code') ?></th>
                                        <th class="col-sm-2"><?= __('Account name') ?></th>
                                        <th class="col-sm-2"><?= __('Financial Category') ?></th>
                                        <th class="col-sm-2" ><?= __('Account group') ?></th>
                                        <th class="col-sm-2"><?= __('Expense note') ?></th>
                                        <th class="col-sm-2"><?= __('action') ?></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_expense = 0;
                                    if (!empty($expenses)) {
                                        $i = 1;
                                        foreach ($expenses as $expense) {
                                            ?>
                                            <tr>
                                                <td data-title="<?= __('slno') ?>">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td data-title="<?= __('expense_code') ?>">
                                                    <p id="code<?=$expense->id?>"><?php echo $expense->code; ?></p>
                                                </td>
                                                <td data-title="<?= __('expense_expense') ?>">
                                                    <p id="name<?=$expense->id?>"><?php echo $expense->name; ?></p>
                                                </td>
                                                <td data-title="<?= __('account_type') ?>">
                                                    <?php
                                                      echo warp($expense->financialCategory->name,20);

                                                    ?>
                                                </td>
                                                <td data-title="<?= __('account_group') ?>">
                                                    <?php
                                                      echo warp($expense->accountGroup->name,20);
                                                    ?>
                                                </td>

                                                <td data-title="<?= __('expense_note') ?>">
                                                    <p id="note<?=$expense->id?>"><?php echo warp($expense->note,20); ?></p>
                                                </td>

                                                <td data-title="<?= __('action') ?>">

                                                    <?php
                                                    if ($expense->predefined == 0) {
                                                        echo '<a class="btn btn-info btn-sm" href="#" data-toggle="modal" data-target="#large-Modal"  onmousedown="fill_form('.$expense->id.')">edit</a>';
                                                        ?>
                                                        <?php
                                                      //  echo '<a class="btn btn-danger btn-sm" href="' . url('account/chart/delete/' . $expense->id . '/' . $id) . '">delete</a>';
                                                    } else {
                                                        echo ' <i class="fa fa-question-circle" title="This cannot be deleted or edited because it has been defined somewhere else. Please check in fee section or in banking section and edit/delete it there"></i>';
                                                    }
                                                    ?>

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
<div class="modal fade" id="large-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="form-horizontal" role="form" method="post">  <div class="modal-body">
                <h5> Fields marked <span class="red">*</span> are mandatory</h5>
                <div class="col-sm-12">
                    <p></p>

                  
                        <div class='form-group row' >
                            <label for="subcategory" class="col-sm-2 control-label">
                                <?= __("Account Code") ?> <span class="red">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="code" required="true" 
                                       placeholder="E.g AB-123" name="code" value="<?= old('code') ?>" >
                            </div>
                            <span class="col-sm-4 control-label">
                                <?php echo form_error($errors, 'code'); ?>
                            </span>
                        </div>
                        <div class='form-group row' >
                            <label for="subcategory" class="col-sm-2 control-label">
                                <?= __("Account Name") ?> <span class="red">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="chart_name" required="true" 
                                       placeholder="E.g <?php
                                       if ($set == 1) {
                                           echo "Office Chairs";
                                       } else if ($set == 2) {
                                           echo "Accounts payable";
                                       } else if ($set == 3) {
                                           echo "Owner Equity";
                                       } else {
                                           echo "Stationary";
                                       }
                                       ?>" name="subcategory" value="<?= old('subcategory') ?>" >
                            </div>
                            <span class="col-sm-4 control-label">
                                <?php echo form_error($errors, 'subcategory'); ?>
                            </span>
                        </div>
                        <div class='form-group row' >
                            <label for="financial_category_id" class="col-sm-2 control-label">
                                <?= __("Account Type") ?><span class="red">*</span>
                            </label>
                            <div class="col-sm-6">

                                <?php
                                $array = array('0' => __("category"));
                                foreach ($category as $categ) {
                                    $array[$categ->id] = $categ->name;
                                }
                                echo form_dropdown("financial_category_id", $array, old("financial_category_id"), "id='financial_category_id' class='form-control'");
                                ?>

                                <div id="opening_balance" style="display:none">
                                    <span id="open" ><?= __("open_balance") ?></span>
                                    <input type="text"   name='open_balance' value="<?= old('subcategory') ?>" id='open_id' class='form-control'/>
                                </div>



                            </div>
                            <span class="col-sm-4 control-label">
                                <?php echo form_error($errors, 'financial_category_id'); ?>
                            </span>
                        </div>
                        <div class="form-group  row">
                            <label for="note" class="col-sm-2 control-label">Custom Group</label>
                            <div class="col-sm-6">
                                <select name="account_group_id" class="form-control" id="account_group_id" >
                                    <option value=" ">Select Group</option>
                                    <?php
                                    if (!empty($groups)) {
                                        foreach ($groups as $group) {
                                            ?>
                                            <option value="<?= $group->id ?>"><?= $group->name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
 
                            <div class="info col-lg-offset-2 blockquote-reverse"><i class="fa fa-question-circle"></i> If you skip to select a group, system will automatically add this chart name into a group</div>
                            <span class="col-sm-2 small"></span>
                        </div>

                        <div class='form-group row' >
                            <label for="note" class="col-sm-2 control-label">
                                <?= __("expense Note") ?> 
                            </label>
                            <div class="col-sm-6">
                                <textarea style="resize:none;" placeholder="Any description about this " class="form-control" id="note" name="note"><?= old('note') ?></textarea>
                            </div>
                            <span class="col-sm-4 control-label">
                                <?php echo form_error($errors, 'note'); ?>
                            </span>
                        </div>

                        <?= csrf_field() ?>    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                <input type="hidden" value="" name="expense_id" id="expense_id"/>
                <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
            </div>
             </form>
        </div>
    </div>
</div>
<script type="text/javascript">

    function fill_form(id) {
        $('#code').val($('#code'+id).text());
       $('#chart_name').val($('#name'+id).text());
        $('#note').text($('#note'+id).text());
        $('#expense_id').val(id);
       
    }
    $('#financial_category_id').change(function () {	
        var financial_category_id = $(this).val();
	
	 if (financial_category_id ==='0') {
          
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('account/checkCategory') ?>",
                data: {"financial_category_id": financial_category_id },
                dataType: "html",
                success: function (data) {
                       $('#account_group_id').html(data);
                    
                }
            });
        }
    });
</script>
@endsection
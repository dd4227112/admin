@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Our Banks</h4>
                <span>List of bank Accounts</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?=url('/')?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Banking</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                  <div class="col-sm-12">
                <div class="card">
                    
                    <div class="card-header">
                <?php
                //$usertype = session("usertype");
                if (can_access('view_expense')) {
                    ?>
                    <h5 class="page-header">

                        <?php if (can_access('add_expense')) { ?>
                            <button class="btn-success btn" data-toggle="modal" data-target="#group"><span class="fa fa-plus"></span><?= __('add_group') ?></button>
                        <?php } ?>

                    </h5>
                    <div class="alert alert-info">
                        Groups to be displayed in the balance sheet </div>
                    <div id="hide-table">
                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="col-sm-1"><?= __('slno') ?></th>
                                    <th class="col-sm-2"><?= __('group_name') ?></th>
                                    <th class="col-sm-2"><?= __('financial_category') ?></th>
                                    <th class="col-sm-2"><?= __('group_note') ?></th>

                                    <?php if (can_access('edit_expense')) { ?>
                                        <th class="col-sm-2"><?= __('action') ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_expense = 0;
                                if (count($groups) > 0) {
                                    $i = 1;
                                    foreach ($groups as $group) {
                                        ?>
                                        <tr>
                                            <td data-title="<?= __('slno') ?>">
                                                <?php echo $i; ?>
                                            </td>
                                            <td data-title="<?= __('group_name') ?>">
                                                <?php echo $group->name; ?>
                                            </td>
                                            <td data-title="<?= __('group_name') ?>">
                                                <?php echo $group->financialCategory->name; ?>
                                            </td>


                                            <td data-title="<?= __('group_note') ?>">
                                                <?php echo $group->note; ?>
                                            </td>

                                            <?php if (can_access('edit_expense')) { ?>

                                                <td data-title="<?= __('action') ?>">
                                                    <?php if ($group->predefined == 0) {
                                                        echo btn_edit('group/edit/' . $group->id . '/', __('edit'));
                                                        ?>
                                                        <?php echo btn_delete('group/delete/' . $group->id . '/', __('delete'));
                                                    } else {
                                                        echo ' <i class="fa fa-question-circle" title="This cannot be deleted or edited"></i>';
                                                    }
                                                    ?></td>


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
 </div>
        </div> </div>
      
<!-- Modal content start here -->
<div class="modal fade" id="group">
    <div class="modal-dialog">
        <form action="#" method="post" class="form-horizontal group_form" role="form">

            <div class="modal-content">

                <div class="modal-header">
                    Groups
                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <div class="col-sm-6">

                            <label class="control-label required">Name of Group</label>
                            <input type="text" id="ember12" name="value" class="form-control col-md-4 ember-text-field text-left ember-view">

                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col-sm-6">
                            <label class="control-label required">Account Type</label>
                            <?php
                            $array = array('0' => 'Select Type');
                            foreach ($category as $categ) {


                                $array[$categ->id] = $categ->name;
                            }
                            echo form_dropdown("financial_category_id", $array, old("financial_category_id"), "id='financial_category_id' class='form-control' name='category'");
                            ?>

                            <span class="col-sm-4 control-label">
<?php echo form_error($errors, 'category'); ?>
                            </span>   </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8">
                            <label class="control-label required">Notes</label>
                            <textarea name="note" placeholder="Max 500 characters" id="ember125" class="form-control ember-text-area ember-view"></textarea>
                        </div>
                    </div>


                </div>


                <div class="modal-footer">
                    <button type="button" style="margin-bottom:0px;" class="btn btn-default" data-dismiss="modal" ><?= __('close') ?></button>
                    <button type="button" onmousedown="createGroup()" class="btn btn-primary">Save</button>
                </div>
<?= csrf_field() ?>
            </div>
        </form>
    </div>
</div>

<!-- Modal content End here -->
<script type="text/javascript">

    function createGroup() {
        var val = $('#ember12').val();
        var note = $('#ember125').val();
        var financial_category_id = $('#financial_category_id').val();
        if (val === '') {
            swal('Warning', 'Please fill correct group name', 'error');
        }
        if (financial_category_id == 0) {
            swal('Warning', 'Please select a correct financial category', 'error');
        }
        if (financial_category_id !== '' && val !== '') {
            $.ajax({
                type: 'GET',
                url: "<?= url('group/add/null') ?>",
                data: {"val": val, note: note, "financial_category_id": financial_category_id},
                dataType: "html",
                success: function (obj) {
                    swal('success', obj);
                }
            });
        }
    }
</script>
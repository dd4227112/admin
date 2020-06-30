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
                        <a href="<?= url('/') ?>">
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

                            <h5 class="page-header">

                              
                                <button class="btn-success btn" data-toggle="modal" data-target="#group" onmousedown="$('#group_id').val('')"><span class="fa fa-plus"></span>Add New Group</button>
                           

                            </h5>
                            <div class="alert alert-info">
                                Groups to be displayed in the balance sheet </div>
                            <div id="hide-table">
                                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-1">#</th>
                                            <th class="col-sm-2">Group Name</th>
                                            <th class="col-sm-2">Financial Category</th>
                                            <th class="col-sm-2">Note</th>

                                                <th class="col-sm-2">Action</th>
                                           
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
                                                        <p id="name<?=$group->id?>"><?php echo $group->name; ?></p>
                                                    </td>
                                                    <td data-title="<?= __('group_name') ?>">
                                                        <?php  echo $group->financialCategory->name; ?>
                                                        <span id="fin_id<?=$group->id?>" style="display:none"><?=$group->financial_category_id?></span>
                                                    </td>


                                                    <td data-title="<?= __('group_note') ?>">
                                                        <span id="note<?=$group->id?>"><?php echo $group->note; ?></span>
                                                    </td>

                                                 
                                                        <td data-title="<?= __('action') ?>">

                                                            <?php
                                                           echo '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#group" href="#" onmousedown="fill_form('.$group->id.')">edit</a>';
                                                            ?>
                                                            <?php
                                                            echo '<a  class="btn btn-danger btn-sm" href="'.url('account/group/delete/' . $group->id . '/').'">delete</a>';

                                                            ?></td>


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

                    <div class="form-group row">

                        <div class="col-sm-12">

                            <label class="control-label required">Name of Group</label>
                            <input type="text" id="group_name" name="name" class="form-control  ember-text-field text-left ember-view">

                        </div>
                    </div>
                    <div class="form-group row">

                        <div class="col-sm-12">
                            <label class="control-label required">Financial Category Type</label>
                            <?php
                            $array = array('0' => 'Select Type');
                            foreach ($category as $categ) {


                                $array[$categ->id] = $categ->name;
                            }
                            echo form_dropdown("financial_category_id", $array, old("financial_category_id"), "id='financial_category_id' class='form-control' name='category'");
                            ?>

                             </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="control-label required">Notes</label>
                            <textarea name="note" placeholder="Max 500 characters" id="group_note" class="form-control ember-text-area ember-view"></textarea>
                        </div>
                    </div>


                </div>


                <div class="modal-footer">
                    <button type="button" style="margin-bottom:0px;" class="btn btn-default" data-dismiss="modal" ><?= __('close') ?></button>
                    <input type="hidden" value="" name="group_id" id="group_id"/>
                    <button type="submit"  class="btn btn-primary">Save</button>
                </div>
                <?= csrf_field() ?>
            </div>
        </form>
    </div>
</div>

<!-- Modal content End here -->
<script type="text/javascript">

    function fill_form(id) {
        $('#group_name').val($('#name'+id).text());
        var fin_id = $('#fin_id'+id).text();
        $('#group_note').text($('#note'+id).text());
        $('#group_id').val(id);
       
    }
</script>
@endsection
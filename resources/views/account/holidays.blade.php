@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>General Holidays</h4>
                <span>List of Holidays</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Holidays</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Account Holidays</a>
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
                                <button class="btn-success btn" data-toggle="modal" data-target="#group" onmousedown="$('#group_id').val('')"><span class="fa fa-plus"></span>Add holiday</button>
                            </h5>
                         
                            <div id="hide-table">
                                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-1">#</th>
                                            <th class="col-sm-2">Holiday Name</th>
                                            <th class="col-sm-2">Date</th>
                                            <th class="col-sm-2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_expense = 0;
                                        if (!empty($holidays)) { 
                                            $i = 1;
                                            foreach ($holidays as $holiday) {
                                                ?>
                                                <tr>
                                                    <td data-title="<?= __('slno') ?>">
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td data-title="<?= __('holiday_name') ?>">
                                                        <p><?php echo $holiday->name; ?></p>
                                                    </td>
                                                    <td data-title="<?= __('holiday_name') ?>">
                                                        <?= date('d-m-Y', strtotime($holiday->date)); ?>
                                                        
                                                    </td>

                                                    <td data-title="<?= __('action') ?>">
                                                      <?php
                                                       echo '<a  class="btn btn-danger btn-sm" href="'.url('account/holidays/delete/' . $holiday->id . '/').'">delete</a>';
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
    </div> </div>

<!-- Modal content start here -->
<div class="modal fade" id="group">
    <div class="modal-dialog">
        <form action="#" method="post" class="form-horizontal group_form" role="form" action="<?= url('account/holidays') ?>">

            <div class="modal-content">

                <div class="modal-header">
                    Holidays
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="control-label required">Name of Holiday</label>
                            <input type="text" id="holiday_name" name="holiday_name" class="form-control  ember-text-field text-left ember-view" required>
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="control-label required">Date of Holiday</label>
                            <input type="date" id="holiday_date" name="holiday_date" class="form-control  ember-text-field text-left ember-view" required>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" style="margin-bottom:0px;" class="btn btn-default" data-dismiss="modal" ><?= __('close') ?></button>
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
@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<?php $chart_files = base_url('public/theme/default/clearbar'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Users</a></li>
                    <li class="breadcrumb-item"><a href="<?=base_url(ucwords(request()->segment(1)).'/staffs')?>"><?= ucwords(str_replace('_', ' ', request()->segment(1))) ?></a></li>
                    <li class="breadcrumb-item active">Set Report</li>
                </ol>
            </div>
            <h4 class="page-title">Set KPI Targets for user: <?=$user->name?></h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h5 class="page-header">

                    <button class="btn btn-success btn-square btn-skew waves-effect waves-light" data-toggle="modal" data-target="#group"><span class="fa fa-plus"></span>Add KPI Target</button>
                       <button class="btn btn-primary btn-square btn-skew waves-effect waves-light" data-toggle="modal" data-target="#set_key_performance"><span class="fa fa-plus"></span>Add Key Performance</button>
                    </h5> 
                <div class="alert alert-info">
                    KPI helps you to manage your staff </div>
                <div id="hide-table">
                    <table id="example1" class="table dataTable">
                        <thead>
                            <tr>
                                <th>S/No</th>
                                <th>KPI</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Target</th>  
                                <th>Is Derived</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($user->staffTargets()->get()) > 0) {
                                $i = 1;
                                foreach ($user->staffTargets()->get() as $target) {
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $target->kpi ?></td>
                                        <td><?= $target->start_date ?></td>
                                        <td><?= $target->end_date ?></td>
                                        <td><?= $target->value ?></td>
                                       <td><?= $target->is_derived == 1 ? 'Yes' : 'No' ?></td>
                                        <td class="text-center"> 
                                            <a title="Delete KPI"  href="<?= url('report/deletetarget/' . $target->uuid) ?>"><i class="icofont icofont-trash text-danger"></i></a>
                                        </td>
                                    </tr><!--end tr-->   
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

<!-- Modal content start here -->
<div class="modal fade" id="group">
    <div class="modal-dialog">
        <form action="" method="post" class="form-horizontal group_form set_performance" role="form">

            <div class="modal-content">

                <div class="modal-header">
                    Set Key Performance Indicator for your staff <?= $user->name ?>
                </div>

                <div class="modal-body">

                    <div class="form-group row">

                        <div class="col-sm-12">

                            <label class="control-label required">KPI Type</label>
                            <div class="row">
                                <div class="col-lg-4 offset-3"><input type="radio" checked="" onmousedown="$('#kpi_not_derived').hide(); $('#kpi_derived').show();" value="1" name="is_derived" class="form-control  " required> Derived</div>
                                <div class="col-lg-4"> <input type="radio" onmousedown="$('#kpi_not_derived').show(); $('#kpi_derived').hide();"  value="0" name="is_derived" class="form-control " required> Not Derived</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="kpi_derived" style="">

                        <div class="col-sm-12">
                            <label class="control-label">KPI Name</label>
                            <select name="kpi_derived" id='kpi' class='form-control kpi_derived'>
                                <option value=""> Select Type</option>
                                <?php foreach ($key_performances as $key => $categ) {?>
                                    <option value="<?=$categ->id?>"> <?=$categ->name?></option>
                            <?php }?>
                            </select>
                            <span class="col-sm-4 control-label kpi_derived_alert text-danger">
                                <?php echo form_error($errors, 'kpi'); ?>
                            </span>   </div>
                    </div>
                    <div class="form-group row" id="kpi_not_derived" style="display:none">
                        <div class="col-sm-12">
                            <label class="control-label required">KPI Name</label>
                            <input type="text" name="kpi" class="form-control ">
                            <span class="col-sm-4 control-label kpi_alert text-danger">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="control-label required">Target Value</label>
                            <input type="text" name="value" class="form-control ">
                            <span class="col-sm-4 control-label value_alert text-danger">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="control-label required">Start Date</label>
                            <input type="date" name="start_date" class="form-control " required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="control-label required">End Date</label>
                            <input type="date" name="end_date" class="form-control " required>

                        </div>
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" >close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
                <input type="hidden" name="user_sid" value="<?= $user->id ?>">
                <?= csrf_field() ?>
            </div>
        </form>
    </div>
</div>

<!-- Modal content start here -->
<div class="modal fade" id="set_key_performance">
    <div class="modal-dialog">
        <form action="<?=base_url('report/performances')?>" method="post" class="form-horizontal group_form" role="form">

            <div class="modal-content">

                <div class="modal-header">
                    Set Key Performances for all staffs
                </div>

                <div class="modal-body">

                    <div class="form-group row" id="name">

                        <div class="col-sm-12">
                        <label for="name" class="control-label required">Name</label>
                            <input type="text" name="name" id="name" class="form-control ">  
                        </div>
                    </div>
                    <div class="form-group row"  id="connection">
                        <div class="col-sm-12">
                        <label for="connection" class="control-label required"> Connection</label>
                            <select  name="connection" id="connection" class="form-control ">
                                <?php 
                                 foreach ($connection as $key => $value) {?>
                                 <option value="<?=$key?>"><?=$key?></option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>
                    <div class="form-group row"  id="custom_query">
                        <div class="col-sm-12">
                        <label for="custom_query" class="control-label required"> Custom Query</label>
                            <input type="text" name="custom_query" id="custom_query" class="form-control ">

                        </div>
                    </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" >close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
                <input type="hidden" name="user_sid" value="<?= $user->id ?>">
                <?= csrf_field() ?>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.set_performance').on('submit', function(){
            var is_derived =  $('input[name="is_derived"]:checked').val();
            var kpi =  $('input[name="kpi"]').val();
            var kpi_derived = $('.kpi_derived').val();
            var target_value = $('input[name ="value"]').val();
           if (is_derived == 1 && kpi_derived =='') {
            $('.kpi_derived_alert').text('Please select a KPI Name');
            return false;
           }
           if (is_derived == 0 && kpi =='') {
            $('.kpi_alert').text('Please enter a KPI Name');
            return false;
           } 
           if(target_value == ''){
            $('.value_alert').text('Please enter a target value');
            return false;
           }
           
        });
    });
</script>
@endsection

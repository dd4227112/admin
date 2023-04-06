@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">menu_dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><?= ucwords(str_replace('_', ' ', request()->segment(1))) ?></a></li>
                    <li class="breadcrumb-item active"><?= ucwords(str_replace('_', ' ', request()->segment(2))) ?></li>
                </ol>
            </div>
            <h4 class="page-title">Set KPI Targets</h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h5 class="page-header">

                    <button class="btn btn-success btn-square btn-skew waves-effect waves-light" data-toggle="modal" data-target="#group"><span class="fa fa-plus"></span>Add KPI Target</button>

                </h5>
                <div class="alert alert-info">
                    KPI helps you to manage your staff </div>
                <div id="hide-table">
                    <table id="example1" class="table dataTable">
                        <thead>
                            <tr>
                                <th>slno</th>
                                <th>KPI</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Target</th>  
                                <th>Is Derived</th>
                                <th>Action</th>
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
                                        <td> 
                                                                                                
                                            <!--<a href="#" class="mr-2"><i class="las la-pen text-info font-18"></i></a>-->
                                            <a class="btn btn-sm btn-danger" href="<?= url('report/deletetarget/' . $target->uuid) ?>">delete</a>
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
        <form action="" method="post" class="form-horizontal group_form" role="form">

            <div class="modal-content">

                <div class="modal-header">
                    Set Key Performance Indicator for your staff <?= $user->name ?>
                </div>

                <div class="modal-body">

                    <div class="form-group row">

                        <div class="col-sm-12">

                            <label class="control-label required">KPI Type</label>
                            <div class="row">
                                <div class="col-lg-4 offset-3"><input type="radio" checked="" onmousedown="$('#kpi_not_derived').hide(); $('#kpi_derived').show();" value="1" name="is_derived" class="form-control " required> Derived</div>
                                <div class="col-lg-4"> <input type="radio" onmousedown="$('#kpi_not_derived').show(); $('#kpi_derived').hide();"  value="0" name="is_derived" class="form-control " required> Not Derived</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="kpi_derived" style="">

                        <div class="col-sm-12">
                            <label class="control-label">KPI Name</label>
                            <?php
                            $array = array('0' => 'Select Type');
                            $category = [1 => 'Total Students', 2 => 'Revenue collections', 3 => 'School AVG Academic Performance'];

                            foreach ($category as $key => $categ) {
                                $array[$key] = $categ;
                            }
                            echo form_dropdown("kpi_derived", $array, old("kpi_derived"), "id='kpi' class='form-control'");
                            ?>

                            <span class="col-sm-4 control-label">
                                <?php echo form_error($errors, 'kpi'); ?>
                            </span>   </div>
                    </div>
                    <div class="form-group row" id="kpi_not_derived" style="display:none">
                        <div class="col-sm-12">
                            <label class="control-label required">KPI Name</label>
                            <input type="text" name="kpi" class="form-control ">

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="control-label required">Target Value</label>
                            <input type="text" name="value" class="form-control " required>

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
                <input type="hidden" name="user_sid" value="<?= $user->sid ?>">
                <?= csrf_field() ?>
            </div>
        </form>
    </div>
</div>
</script>
    @endsection

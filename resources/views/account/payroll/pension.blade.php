@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Payroll</h4>
                <span>Pension Fund Status</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Payroll</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <?php
                        $usertype = session("usertype");
                        //if(can_access('add_payroll')) {
                        ?>
                        <div class="card-header">
                            <h5 class="page-header">
                                <a class="btn btn-success btn-sm" href="<?php echo url('payroll/addPension') ?>">
                                    <i class="fa fa-plus"></i> 
                                    Add Pension Fund
                                </a>

                            </h5>
                        </div>
                        <?php //} ?>
                        <div id="hide-table"  class="card-block">
                            <?php if (isset($pensions) && !empty($pensions)) { ?>
                                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th class="col-lg-1">#</th>
                                            <th class="col-lg-2">Name</th>
                                            <th class="col-lg-1">Employer Percentage</th>
                                            <th class="col-lg-1">Employee Percentage</th>
                                            <th class="col-lg-1">Address</th>
                                            <th class="col-lg-1">Members</th>
                                            <th class="col-lg-1">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($pensions as $pension) {
                                            ?>
                                            <tr>
                                                <td data-title="<?= __('slno') ?>">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td data-title="<?= __('payroll_name') ?>">
                                                    <?php echo $pension->name; ?>
                                                </td>
                                                <td data-title="<?= __('employer_percentage') ?>">
                                                    <?php echo $pension->employer_percentage; ?> %
                                                </td>
                                                <td data-title="<?= __('employee_percentage') ?>">
                                                    <?php echo $pension->employee_percentage; ?>%
                                                </td>
                                                <td data-title="<?= __('employee_percentage') ?>">
                                                    <?php echo $pension->address; ?>
                                                </td>
                                                <td data-title="<?= __('members') ?>">
                                                    <?php //echo $pension->userPensions->count(); ?>
                                                </td>
                                                <td data-title="<?= __('employee_percentage') ?>">
                                                    <a href="<?= url('payroll/pension/' . $pension->id) ?>" class="btn btn-info btn-sm mrg" ><i class="fa fa-users"></i> members</a>
<!--                                                    <a href="<?= url('payroll/editPension/' . $pension->id) ?>" class="btn btn-primary btn-sm mrg" ><i class="fa fa-edit"></i> <?= __('edit') ?></a>
                                                    <a href="<?= url('payroll/deletePension/' . $pension->id) ?>" class="btn btn-danger btn-sm mrg" ><i class="fa fa-trash-o"></i> <?= __('delete') ?></a>-->
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>
                    </div>

                </div> <!-- col-sm-12 -->
            </div><!-- row -->
        </div><!-- Body -->
    </div><!-- /.box -->
</div>
@endsection
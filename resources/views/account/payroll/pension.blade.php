@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
      <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

        <div class="page-body">
          <div class="row">

            <div class="col-sm-12">
                <div class="card">
                <div class="card-block">
                    <div class="card-header">
                        <a class="btn btn-success" href="<?php echo url('payroll/addPension') ?>">
                            Add Pension Fund
                        </a>
                    </div>

                            
                        <div class="table-responsive">
                            <table class="table dataTable table-sm table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Employer Percentage</th>
                                    <th>Employee Percentage</th>
                                    <th>Address</th>
                                    <th>Members</th>
                                    <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                <?php
                                $i = 1;
                                foreach ($pensions as $pension) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $pension->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $pension->employer_percentage; ?> %
                                        </td>
                                        <td>
                                            <?php echo $pension->employee_percentage; ?>%
                                        </td>
                                        <td>
                                            <?php echo $pension->address; ?>
                                        </td>
                                        <td>
                                            <?php echo $pension->userPensions->count(); ?>
                                        </td>
                                        <td data-title="<?= __('employee_percentage') ?>">
                                            <a href="<?= url('payroll/pension/' . $pension->id) ?>" class="btn btn-info btn-sm mrg" ><i class="fa fa-users"></i> members</a>
                                            <a href="<?= url('payroll/editPension/' . $pension->id) ?>" class="btn btn-primary btn-sm mrg" ><i class="fa fa-edit"></i> <?= __('Edit') ?></a>
                                            <a href="<?= url('payroll/deletePension/' . $pension->id) ?>" class="btn btn-danger btn-sm mrg" ><i class="fa fa-trash-o"></i> <?= __('Delete') ?></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Employer Percentage</th>
                                    <th>Employee Percentage</th>
                                    <th>Address</th>
                                    <th>Members</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                            </div>
                            
                        </div>
                    </div>


            </div><!-- row -->
        </div><!-- Body -->
    </div><!-- /.box -->
</div>
@endsection
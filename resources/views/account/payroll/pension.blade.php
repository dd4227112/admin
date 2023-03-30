@extends('layouts.app')
@section('content')

    

        <div class="page-header">
            <div class="page-header-title">
                <h4><?=' Pensions' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">pensions</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">payroll</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-body">
          <div class="row">

            <div class="col-sm-12">
                <div class="card">
                <div class="card-block">
                    <div class="m-b-15">
                          <a href="<?= url("payroll/addPension") ?>" class="btn btn-primary btn-sm  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Add Pension Fund"> Add pension </a> 
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
                                        <td>
                                            <?php $pension_url = "payroll/pension/$pension->id";$edit_url="payroll/editPension/$pension->id"; $delete_url = "payroll/deletePension/$pension->id";?>
                                            <a href="<?= url($pension_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Pension members"> members </a> 
                                            <a href="<?= url($edit_url) ?>" class="btn btn-info btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Edit Pension"> edit </a> 
                                            <a href="<?= url($delete_url) ?>" class="btn btn-danger btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Delete Pension"> delete </a> 
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
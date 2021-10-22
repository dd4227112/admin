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
                    <div class="m-b-15">
                        <x-button url="payroll/addPension" color="primary" btnsize="sm"  title="Add Pension Fund"></x-button>
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
                                             <x-button :url="$pension_url" color="primary" btnsize="mini"  title="members" shape="round" toggleTitle="Pension members"></x-button>
                                             <x-button :url="$edit_url" color="info" btnsize="mini"  title="Edit" shape="round" toggleTitle="Edit Pension"></x-button>
                                             <x-button :url="$delete_url" color="danger" btnsize="mini"  title="delete" shape="round" toggleTitle="Delete Pension"></x-button>
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
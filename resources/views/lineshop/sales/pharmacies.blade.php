@extends('layouts.app')
@section('content')

<div class="page-header">
    <div class="page-header-title">
        <h4>Pharmacies</h4>
    </div>
    <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#!">Sales</a>
            </li>
            <li class="breadcrumb-item"><a href="#!">Pharmacies</a>
            </li>
        </ul>
    </div>
</div>

<div class="page-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="row mt-10">
                <?php //if (can_access('add_pharmacy')) { 
                ?>
                <div class="col-lg-3">
                    <div class="card-body">
                        <a href="<?= url("lineshop/addPharmacy") ?>" class="btn btn-primary btn-sm  btn-round" data-placement="top" data-toggle="tooltip" data-original-title="Add new Pharmacy"> Add Pharmacy </a>
                    </div>
                </div>
                <?php //} 
                ?>

                <div class="col-sm-6">
                    <select class="form-control" id="pharmacies_selector">
                        <option value=""></option>
                        <option value="1" <?=$group==1?'selected':''?>>ALL </option>
                        <option value="2"  <?=$group==2?'selected':''?>>CLIENTS</option>
                    </select>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>List of all pharmacies</h5>
                        </div>
                        <div class="card-block">
                            <div class="">
                                <table id="list_of_pharmacies" class="table  table-striped table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Pharmacy Name</th>
                                            <th>Region</th>
                                            <th>District</th>
                                            <th>Ward</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        if (!empty($pharmacies)) {

                                            foreach ($pharmacies as $pharmacy) {
                                        ?>
                                                <tr>
                                                    <td>{{$no}}</td>
                                                    <td>{{$pharmacy->name}}</td>
                                                    <td>{{$pharmacy->wards->district->region->name}}</td>
                                                    <td>{{$pharmacy->wards->district->name}}</td>
                                                    <td>{{$pharmacy->wards->name}}</td>
                                                    <?php $client_check =App\Models\ClientPharmacy::where('pharmacy_id', $pharmacy->id)->first();?>
                                                    @if(!empty($client_check))
                                                    <td><i class="badge badge-primary">Already Client</i> </td>
                                                    @else
                                                    <td><i class="badge badge-warning">Not Client</i></td>
                                                    @endif
                                                    @if(!empty($client_check))
                                                    <td> <a href="<?= url("lineshop/profile/" . $pharmacy->id) ?>" class="btn btn-secondary btn-sm" data-placement="top" data-toggle="tooltip">Profile </a></td>
                                                    @else
                                                    <td> <a href="<?= url("lineshop/onboardPharmacy/" . $pharmacy->id) ?>" class="btn btn-success btn-sm" data-placement="top" data-toggle="tooltip">Onboard </a>
                                                    <a href="<?= url("lineshop/profile/" . $pharmacy->id) ?>" class="btn btn-secondary btn-sm" data-placement="top" data-toggle="tooltip">Profile </a></td>
                                                    @endif
                                                </tr>

                                        <?php
                                                $no++;
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
</div>


<script>
    $(document).ready(function() {
        $('#list_of_pharmacies').DataTable();

        $('#pharmacies_selector').change(function () {
            var val = $(this).val();
            window.location.href = '<?= url('lineshop/pharmacies') ?>/' + val;
        });
    });
    
    
</script>
@endsection
@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>


<div class="page-header">
    <div class="page-header-title">
        <h4><?= ' Add school' ?></h4>
    </div>
    <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#!">new school</a>
            </li>
            <li class="breadcrumb-item"><a href="#!">marketing</a>
            </li>
        </ul>
    </div>
</div> 

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">

            <div class="card">

                <div class="card-block">
                    <form action="#" method="post">

                        <div class="row">
                            <div class="col-sm-12 col-xl-3 m-b-30">
                                <h4 class="sub-title">School name</h4>
                                <input name="name"  class="form-control" placeholder="Enter School  Name.." autofocus required>
                            </div>
                            <div class="col-sm-12 col-xl-3 ">
                                <h4 class="sub-title">Select Region</h4>
                                <select type="text" name="region" id="region" style="text-transform:uppercase" required class="js-example-basic-singlet form-control form-control-primary">
                                    <option value="">Select here...</option>
                                    <?php
                                    $regions = \App\Models\Region::where('country_id', 1)->get();
                                    foreach ($regions as $region) {
                                        echo '<option value="' . $region->id . '">' . $region->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-12 col-xl-3 m-b-30">
                                <h4 class="sub-title"> Select District</h4>
                                <select type="text" name="district" id="district" style="text-transform:uppercase" required class="form-control select2">
                                    <option value="">Select Here...</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-xl-3 m-b-30">
                                <h4 class="sub-title">Select Ward</h4>
                                <select type="text" name="ward" id="ward" style="text-transform:uppercase" required class="form-control select2">
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-xl-3 m-b-30">
                                <h4 class="sub-title"> Select  zone</h4>
                                <select name="zone" class="form-control select2" required>
                                    <?php
                                    $zones = DB::table('constant.refer_zones')->where('country_id', 1)->get();
                                    foreach ($zones as $zone) {
                                        echo '<option value="' . $zone->id . '">' . $zone->name . '</option>';
                                    }
                                    ?>
                            
                                </select>
                            </div>
                            <div class="col-sm-12 col-xl-3 m-b-30">
                                <h4 class="sub-title">Select Ownership</h4>
                                <select name="ownership" class="form-control" required>
                                    <option value="Non-Government">Non-Government</option>
                                    <option value="Government">Government</option>
                                </select>
                            </div>  

                            <div class="col-sm-12 col-xl-3 m-b-30">
                                <h4 class="sub-title">Select School Type</h4>
                                <select type="text" name="type" class="form-control" required>
                                    <option value="primary"> Primary School</option>
                                    <option value="secondary"> Secondary School</option>
                                    <option value="college"> College</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-xl-3 m-b-30">
                                <h4 class="sub-title">&nbsp;</h4>
                                <button type="submit" class="btn btn-primary btn-sm btn-round">Save changes</button>
                            </div>
                        </div>
                        <?= csrf_field() ?>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
</div>

<script type="text/javascript">

    $('#region').change(function () {
        var val = $(this).val();

        $.ajax({
            method: 'get',
            url: '<?= url('Marketing/getDistrict/null') ?>',
            data: {region: val},
            dataType: 'html',
            success: function (data) {
                $('#district').html(data);
            }
        });
    });
    $('#district').change(function () {
        var val = $(this).val();
        $.ajax({
            method: 'get',
            url: '<?= url('Marketing/getWard/null') ?>',
            data: {district: val},
            dataType: 'html',
            success: function (data) {
                $('#ward').html(data);
            }
        });
    });
</script>
@endsection

@extends('layouts.app')
@section('content')

<div class="row">
    <?php
    foreach ($school_types as $school) {
        ?>
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title"><?= $school->type ?></h3>
                <div class="text-right">
                    <h1><sup></sup> <?= $school->count ?></h1> </div> <span class="text-success"><?= round($school->percent * 100) ?>%</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only">20% Complete</span> </div>
                </div>
            </div>
        </div>
        <?php
    }
    foreach ($ownerships as $ownership) {
        ?>

        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title"><?= $ownership->ownership ?></h3>
                <div class="text-right">
                    <h1><sup></sup><?= $ownership->count ?></h1> </div> <span class="text-info"><?= round($ownership->percent * 100) ?>%</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:60%;"> <span class="sr-only">20% Complete</span> </div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <h3 class="box-title">Schools</h3>
            <!--<div id="basicgrid"></div>-->
            <select id="school_region">
                <option value="">Select Region</option>
                <?php foreach ($regions as $region) {
                      ?>
                <option value="<?=$region->region?>"><?=$region->region?></option>
                <?php } ?>
            </select>
            <table id="example23" class="display nowrap table color-table success-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>School Name</th>
                        <th>Region</th>
                        <th>District</th>
                        <th>Ward</th>
                        <th>Type</th>
                        <th>Ownership</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if(count($schools)>0){
                    foreach ($schools as $key => $value) {
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $value->name ?></td>
                            <td><?= $value->region ?></td>
                            <td><?= $value->district ?></td>
                            <td><?= $value->ward ?></td>
                            <td><?= $value->type ?></td>
                            <td><?= $value->ownership ?></td>
                        </tr>
                        <?php $i++;
                    }
                    }
                    ?>
                </tbody>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#school_region').change(function(){
        var id=$(this).val();
        window.location.href='?region='+id;
    });
</script>
@endsection

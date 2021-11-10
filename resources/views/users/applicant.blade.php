
@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/';
?>
<div class="page-wrapper">
    <div class="page-header">
    
      <div class="page-header">
            <div class="page-header-title">
                <h4> Applicants</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">applicants</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 
    
    <div class="page-body">
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="card" style="height: 65em"> 
                    <div class="card-block tab-icon">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <!-- <h6 class="sub-title">Tab With Icon</h6> -->
                                <div class="sub-title">Applicants</div>                                        
                                <div class="col-md-12 col-xl-12">

                                    <div class="form-group row col-lg-offset-6">
                                        <label class="col-sm-4 col-form-label">Select Location</label>
                                        <div class="col-sm-4">
                                            <select name="select" class=" select2" id="schema_select">
                                                <option value="0">Select</option>
                                                <?php
                                                $locations = \DB::select('select distinct current_location from applicants');
                                                foreach ($locations as $location) {
                                                    ?>
                                                    <option value="<?= $location->current_location ?>" selected><?= $location->current_location ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row col-lg-offset-6"  selected id="year_id">
                                        <label class="col-sm-4 col-form-label">Select Status</label>
                                        <div class="col-sm-4">
                                            <select name="select" class="form-control" id="year_select">
                                                 <option value=""></option>
                                                <option value="0">All</option>
                                                <option value="1" >Finish Trainings</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive dt-responsive">
                                        <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" name="all" id="toggle_all"> </th>
                                                        <?php
                                                        $vars = get_object_vars($applicant);
                                                        $except = array('id');
                                                        ?>

                                                    <?php
                                                    foreach ($vars as $key => $value) {
                                                        if (!in_array($key, $except)) {
                                                            ?>
                                                            <th><?= $key ?></th>

                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($applicants as $content) {
                                                    $i++;
                                                    ?> 

                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <?php
                                                        foreach ($vars as $key => $value) {
                                                            if (!in_array($key, $except)) {
                                                                ?> 
                                                                <td><?= $content->{$key} ?></td>



                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Row end -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $('#year_select').change(function () {
        var year = $(this).val();
        var project = $('#schema_select').val();
        if (year == 0) {
            return false;
        } else {
            window.location.href = "<?= url('account/invoice') ?>/" + project + '/' + year;
        }
    });


    $(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
});
</script>
@endsection


@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<div class="page-header">
    <div class="page-header-title">
        <h4>Payment Fee</h4>
    </div>
    <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#!">accounts</a>
            </li>
            <li class="breadcrumb-item"><a href="#!">Set fee</a>
            </li>
        </ul>
    </div>
</div>

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    <div class="col-sm-12 col-xl-4 m-b-30">

                    </div>
                    <div class="row d-flex justify-content-center">

                        <div class="col-sm-10 col-xl-4 m-b-30">
                            <h4 class="sub-title">Select No of Students</h4>
                            <select name="select" onchange="window.location.href='<?=url('account/fee')?>/'+this.value" class="form-control form-control-primary"  id="schema_project">
                                <option value="">Select</option>
                                <option value="400">0-400</option>
                                <option value="1000">401-1000</option>
                                <option value="1001">1000+</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Material tab card start -->
            <div class="card">

                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered border-success">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php
                                    foreach ($modules as $module) {
                                        ?>
                                        <th scope="col"><?= $module ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <tr>                                                        
                                    
                                    <td class="border-0 font-14 text-dark"><b>Total Students</b></td>
                                    <td class="border-0 font-14 text-dark"><b><?=$students?></b></td>
                                    <td colspan="5" class="border-0"></td>
                                </tr><!--end tr-->

                                <?php
                                $packages = ['Basic', 'Standard', 'Premium'];
                                $p = 0;
                                foreach ($packages as $package) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $package ?></th>
                                        <?php
                                        $m = 1;
                                        foreach ($modules as $module) {
                                             $price = DB::table('admin.price_packages')
                                                     ->where('package_type',$package)
                                                     ->where('module_name',$module)
                                                     ->where('number', $p)->where('maximum_students', $students)
                                                     ->first();
                                        
                                            ?>
                                            <td>
                                                <input type="text" required="" class="radio_input" name="<?= $module ?>" data-number="<?= $p ?>" value="<?=!empty($price) ? $price->price:0?>">
                                            </td>
                                            <?php
                                            $p++;
                                        }
                                        ?>

                                    </tr>
                                    <?php
                                  
                                }
                                ?>

                            </tbody>
                        </table>

                    </div>
                    <script>
                        calculate_price = function () {

                            $('.radio_input').change(function () {

                                var selectedValues = []; // Array to store selected values

                                // Loop through all checked radio buttons and push their values into the array
                                $('input[type="text"]').each(function () {
                                    selectedValues.push($(this).val());
                                });

                                // Display selected values in the console (for demonstration)
                                console.log(selectedValues);

                                $.ajax({
                                    type: 'POST',
                                    url: "<?= base_url('account/setPrice') ?>",
                                    data: {select: selectedValues,student:'<?=$students?>'},
                                    dataType: "html",
                                    success: function (data) {
                                       toastr.success(data);
                                    }
                                });
                            });

                        }

                        $(document).ready(calculate_price);
                    </script>
                </div>
            </div>
            <!-- Material tab card end -->
        </div>
    </div>
</div>


</div>
</div>
<script type="text/javascript">
    $('.calendar').on('click', function (e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");
    });

    $('#schema_project').change(function () {
        var schema = $(this).val();
        if (schema > 0) {
            $('#year_id').show();
            return false;
        } else {
            //  window.location.href = "<?= url('account/invoice') ?>/" + schema;
        }
    });
    $('#year_project').change(function () {
        var type = $(this).val();
        var project = $('#schema_project').val();
        var year = $('#year_select').val();
        if (year == 0) {
            return false;
        } else {
            window.location.href = "<?= url('account/invoice') ?>/" + project + '/' + year + '/' + type;
        }
    });
</script>

@endsection


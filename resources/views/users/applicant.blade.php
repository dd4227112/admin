
@extends('layouts.app')
@section('content')
<?php
$root = url('/') . '/public/';
?>
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-title">
            <h4>Human Resources </h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Users</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Applicants</a>
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
@endsection


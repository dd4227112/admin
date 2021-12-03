@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

    <div class="page-header">
        <div class="page-header-title">
            <h4>Dashboard</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Summary</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-block">

                        <div class="row">
                            <?php
                            $i = 1;
                            $total = 0;
                            ?>
                            <div class="col-md-12 col-xl-4">
                                <div class="card counter-card-<?= $i ?>">
                                    <div class="card-block-big">
                                        <div>
                                            <h3><?= sizeof($schools) ?></h3>
                                            <p>Private Schools</p>
                                            <div class="progress ">
                                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-<?= $i == 1 ? 'pink' : 'success' ?>" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small><a href="<?=url('sales/school')?>" class="btn btn-default btn-sm"> View</a></small>
                                        </div>
                                        <i class="icofont icofont-gift"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-4">
                                <div class="card counter-card-<?= $i ?>">
                                    <div class="card-block-big">
                                        <div>
                                            <h3><?= $use_shulesoft ?></h3>
                                            <p>Schools in Shulesoft</p>
                                            <div class="progress ">
                                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-info" role="progressbar" style="width: 40%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small><a href="<?= url('sales/schoolStatus/shulesoft') ?>" class="btn btn-default btn-sm"> View</a></small>

                                        </div>
                                        <i class="icofont icofont-crown"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="card counter-card-<?= $i ?>">
                                    <div class="card-block-big">
                                        <div>
                                            <h3><?= $nmb_shulesoft_schools ?></h3>
                                            <p> Bank Intagration</p>
                                            <div class="progress ">
                                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small><a href="<?= url('sales/schoolStatus/bank') ?>" class="btn btn-default btn-sm"> View</a></small>
                                        </div>
                                        <i class="icofont icofont-trophy-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
<?php if($refer_bank_id==22){ ?>

        <!-- Monthly Growth Chart start-->
        <div class="row" id="schools">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <?php if (isset($branch) && !empty($branch)) { ?>
                            <h5>List of Private Schools in <?= $branch->branch->district->name ?>, <?= $branch->branch->district->region->name ?></h5>
                        <?php } else { ?>
                            <h5>List of Private Schools in <?= Auth::user()->name ?></h5>
                        <?php } ?>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>School Name</th>
                                        <th>Region</th>
                                        <th>District</th>
                                        <th>Ward</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($schools as $school) {
                                        echo '<tr>';
                                        echo '<td>' . $i++ . '</td>';
                                        echo '<td>' . $school->name . '</td>';
                                        echo '<td>' . $school->region . '</td>';
                                        echo '<td>' . $school->district . '</td>';
                                        echo '<td>' . $school->ward . '</td>';
                                        echo '<td>' . $school->type . '</td>';
                                        echo '<td>';
                                        if ($school->schema_name != '') {
                                            $school_with_bank = DB::table('admin.all_bank_accounts')->where('schema_name', $school->schema_name)->where('refer_bank_id',22)->first();
                                            if (empty($school_with_bank)) {
                                                echo '<span class="btn btn-info btn-sm"> Use NMB but not ShuleSoft</span>';
                                            } else {
                                                echo '<span class="btn btn-success btn-sm"> Use NMB and use ShuleSoft </span>';
                                            }
                                        } else {
                                            echo '<span class="btn btn-warning btn-sm"> New </span>';
                                        }
                                        echo '</td>';
                                        echo '<td>';
                                        if ($school->schema_name != '') {
                                            echo '<a href="' . url('customer/profile/' . $school->schema_name) . '" class="btn btn-success btn-sm"> View </a>';
                                        } else {
                                            echo '<a href="' . url('sales/profile/' . $school->id) . '" class="btn btn-success btn-sm"> View</a>';
                                        }
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (isset($branch) && !empty($branch)) {
                // echo bcrypt('khairaatislamic20');
            } else {
                ?>


                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header">
                                <h5>Monthly Onboarded Schools</h5>
                                <!--    <div style="float: right;">
                                    <button class="btn btn-primary btn-sm">Week</button>
                                    <button class="btn btn-primary btn-sm">Month</button>
                                    <button class="btn btn-primary btn-sm">Year</button>
                                    </div> -->
                            </div>
                            <div class="card-block">
                                <?php
                                $year = date('Y-m-d');
                                $new_schools = 'select count(*),extract(month from created_at) as month from admin.all_setting a
                                where extract(year from a.created_at)=' . $year . '  group by month order by month';
                                echo $insight->createChartBySql($new_schools, 'month', 'Onboarded Schools', 'line', false);
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        
        <?php }?>
    </div>
</div>
<script type="text/javascript" src="<?= $root ?>bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">

    school_selector = function () {
        $('#school_selector').change(function () {
            var val = $(this).val();
            window.location.href = '<?= url('sales/school') ?>/' + val;
        })
    }
    $(document).ready(school_selector);
</script>


@endsection

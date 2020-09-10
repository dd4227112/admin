@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Schools</h4>
                <?php
                        if(isset($branch) && count($branch)){ ?>
                            <span>List of Private Schools in <?=$branch->branch->district->name?>, <?= $branch->branch->district->region->name?></span>
                        <?php }else{ ?>
                            <span>List of Private Schools in <?=Auth::user()->name?></span>
                      <?php  } ?>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Sales</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Report</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>List of <?=$title?></h5>
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
                                                    <th>Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                           <?php 
                                                $i = 1;
                                                if(count($all_schools)){
                                            foreach($all_schools as $school){
                                            echo '<tr>';
                                            echo '<td>'.$i++.'</td>';
                                            echo '<td>'.$school->name.'</td>';
                                            echo '<td>'.$school->region.'</td>';
                                            echo '<td>'.$school->district.'</td>';
                                            echo '<td>'.$school->type.'</td>';
                                            echo '<td>';
                                            if($school->schema_name != ''){
                                                echo '<a href="'. url('customer/profile/'.$school->schema_name) .'" class="btn btn-success btn-sm"> View </a>';
                                            }else{
                                                echo '<a href="'. url('sales/profile/'.$school->id) .'" class="btn btn-success btn-sm"> View</a>';

                                            }
                                                echo '</tr>';
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

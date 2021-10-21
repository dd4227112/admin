@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        
       <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
   
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">

                            <div class="row">
                                <?php
                                $i = 1;
                                $total = 0;
                                foreach ($school_types as $type) {
                                    ?>
                                    <div class="col-lg-3 col-xl-3 col-sm-12">
                                
                                          <?php $opt =  $i == 1 ? 'yellow' : 'green' ?>
                                          <x-smallCard :title="$type->type"
                                                :value="$type->count"
                                                icon="feather icon-book f-40 text-c-red"
                                                cardcolor="bg-c-blue text-white"
                                                >
                                        </x-smallCard>

            
                                    </div>
                                    <?php
                                    $total += $type->count;
                                    $i++;
                                }
                                ?>
                                 <div class="col-lg-6 col-xl-6 col-sm-12">
                        
                                 <?php $percent = $nmb_schools.'  Use nmb '. $use_shulesoft .' use ShuleSoft, ' .$nmb_shulesoft_schools. ' use NMB & ShuleSoft'; ?>
                                    <x-analyticCard :value="$total" name="Total" icon="feather icon-trending-up text-white f-16"  
                                    color="bg-c-yellow"  topicon="feather icon-file f-50" :subtitle="$percent"></x-analyticCard>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                           <?php if(can_access('add_school')) { ?>
                             <div class="col-lg-3"> 
                                    <div class="card-body">
                                    <x-button url="sales/addSchool" color="primary" btnsize="mini"  title="Add school" shape="round" toggleTitle="Add new school"></x-button>              
                                  </div>
                             </div>
                           <?php } ?>
                        
                            <div class="col-lg-6">
                                <?php
                                if (can_access('manage_customers')) {
                                    ?>
                                    <p align="center">
                                        <?php
                                        ?>
                                        <a href="<?= url('sales/prospect/demo') ?>"> <button class="btn btn-success btn-skew"> Demo Requests <span class="badge badge-danger"><?php //echo $demo     ?></span></button></a>
                                        <a href="<?= url('sales/prospect/join') ?>"> <button class="btn btn-info btn-skew">Join Requests <span class="badge badge-danger"><?php // echo $join      ?></span></button></a>
                                    </p>
                                <?php } ?>
                                <select class="form-control" id="school_selector">
                                    <option value="1" <?php // selected(1)  ?>>All Schools</option>
                                    <option value="2" <?php // selected(2)  ?>>Use ShuleSoft Only</option>
                                    <option value="3"<?php // selected(3)  ?>>Sales On Progress</option>
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                
                                    <div class="card-header">
                                        <h5>List of all schools</h5>
                                    </div>
                                        <div class="card-block">
                                        <div class="table-responsive">
                                            <table id="list_of_schools" class="table dataTable table-striped table-bordered nowrap">
                                              <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>School Name</th>
                                                    <th>Region</th>
                                                    <th>District</th>
                                                    <th>Ward</th>
                                                    <th>Type</th>
                                                    <!--<th>Use NMB</th>-->
                                                    <th>Students</th>
                                                    <th>Activities</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

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
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#list_of_schools').DataTable({
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
                  'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "<?= url('sales/show/null?page=schools&type=' . request()->segment(3)) ?>"
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "region"},
                {"data": "district"},
                {"data": "ward"},
                {"data": "type"},
//                {"data": "nmb_branch"}, 
                {"data": "students"},
                {"data": "activities"},
                {"data": ""}
            ],
            "columnDefs": [
                {
                    "targets": 8,
                    "data": null,
                    "render": function (data, type, row, meta) {
                        if (row.client_id != null) {
                            return '<a href="<?= url('customer/profile') ?>/' + row.username + '" class="label label-inverse-warning"> Already Customer  </a>';
                        } else {
                            return '<a href="<?= url('sales/') ?>/profile/' + row.id + '" class="badge badge-primary">Onboard School</a>';
                        }

                    }

                }
            ]
        });
    }
    );
    school_selector = function () {
        $('#school_selector').change(function () {
            var val = $(this).val();
            console.log(val)
            window.location.href = '<?= url('sales/school') ?>/' + val;
        })
    }
    $(document).ready(school_selector);
</script>

@endsection

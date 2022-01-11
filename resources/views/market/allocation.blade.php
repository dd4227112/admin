@extends('layouts.app')
@section('content')


    
        
        <div class="page-header">
            <div class="page-header-title">
                <h4><?=' Schools' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">sales schools</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">sales</a>
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
                                foreach ($school_types as $type) {
                                    ?>
                                    <div class="col-lg-3 col-xl-3 col-sm-12">
                                
                                 <?php $opt =  $i == 1 ? 'white' : 'gray' ?>
                                         
                                <div class="card bg-c-{{$opt}} shadow">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">{{$type->type}}</p>
                                                <h4 class="m-b-0">{{ number_format($type->count) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-book f-40" style="color: #19b99a;"></i>
                                            </div>
                                    </div>
                                     </div>
                                </div>

            
                                    </div>
                                    <?php
                                    $total += $type->count;
                                    $i++;
                                }
                                ?>
                                 <div class="col-lg-6 col-xl-6 col-sm-12">
                        
                                 <?php $percent = $nmb_schools.'  Use nmb '. $use_shulesoft .' use ShuleSoft, ' .$nmb_shulesoft_schools. ' use NMB & ShuleSoft'; ?>
                                  
                                        <div class="card">
                                            <div class="card-block">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <h4 class="text-c-green f-w-700">{{ number_format($total)}} </h4>
                                                        <h6 class="text-muted m-b-0">Total</h6>
                                                    </div>
                                                    <div class="col-4 text-right">
                                                        <i class="feather icon-activity f-30"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-c-blue">
                                                <div class="row align-items-center">
                                                    <div class="col-9">
                                                        <p class="text-white m-b-0">{{$percent}}</p>
                                                    </div>
                                                    <div class="col-3 text-right">
                                                        <i class="feather icon-trending-up text-white f-16"></i>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                </div> 
                            </div>
                        </div>

                    <div class="row">
                        <?php if(can_access('add_school')) { ?>
                            <div class="col-lg-3"> 
                                <div class="card-body">
                                    <a href="<?= url("sales/addSchool") ?>" class="btn btn-primary btn-sm  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Add new school"> Add School </a>
                                </div>
                            </div>
                        <?php } ?>
                    
                        <div class="col-lg-6">
                            <select class="form-control" id="school_selector">
                                <option value=""></option>
                                <option value="1">All schools</option>
                                <option value="2">Client Schools</option>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                      <div class="col-lg-12">
                       <?php if(isset($schools))  { ?>

                        <div class="card">
                        <div class="card-header row">
                         <div class="col-sm-8">
                            <h5>List of Schools Under&nbsp;ShuleSoft </h5>
                         </div>
                               <div class="col-sm-4">
                                    <select class="select2" style="width:300px;" id='region_selector'>
                                        <option></option>
                                        <?php 
                                            $regions = \App\Models\Region::all();
                                           foreach ($regions as $region) { ?>
                                            <option value="<?= $region->id ?>" ><?= $region->name ?></option>
                                        <?php } ?>
                                    </select>
                               </div>
                        </div>
                        
                        <div class="card-block">
                        <div class="table-responsive analytic-table">
                            <table id="res-config" class="table table-bordered w-100 dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School Name</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>School Link</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php 
                                        $i = 1;
                                           if(count($schools) > 0) {
                                            foreach ($schools as $school) {
                                            ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= warp($school->client->name,20) ?></td>
                                                <td><?= warp($school->client->address,20) ?></td>
                                                <td><?= $school->client->phone ?></td>
                                                <td>
                                                    <a href="https://<?=$school->client->username?>.shulesoft.com/" target="_blank" rel="noopener noreferrer"><?=warp($school->client->name,20)?></a>
                                                </td>
                                               
                                                <?php
                                                 echo '<td>';
                                                 echo '<a href="' . url('customer/profile/' . $school->client->username) . '" class="btn btn-primary btn-mini btn-round"> View</a>';
                                                 echo '</td>';
                                                 echo '</tr>';
                                                  }
                                                }
                                            ?>
                                       </tbody>
                                   </table>
                                  </div>
                               </div>
                            </div>  
                                
                          <?php } else { ?>


                                    <div class="card">
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

                               <?php } ?>
                            
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
            window.location.href = '<?= url('sales/school') ?>/' + val;
        })

        $('#region_selector').change(function () {
            var val = $('#school_selector').val();
            alert(val)
            var reg = $(this).val();
            window.location.href = '<?= url('sales/school') ?>/' + val + '/' + reg;
        })
    }
    $(document).ready(school_selector);
</script>

@endsection

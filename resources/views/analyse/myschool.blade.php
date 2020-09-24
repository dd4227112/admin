@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="page-wrapper">
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
    <?php
        if(count($schools)>0){ 
    ?>
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
                                                    <h3><?= count($schools) ?></h3>
                                                    <p>Private Schools</p>
                                                    <div class="progress ">
                                                        <div class="progress-bar progress-bar-striped progress-xs progress-bar-<?= $i == 1 ? 'pink' : 'success' ?>" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <i class="icofont icofont-gift"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-4">
                                    <div class="card counter-card-<?= $i ?>">
                                        <div class="card-block-big">
                                            <div>
                                                <h3><?= count($users) ?></h3>
                                                <p> With Zero Student</p>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <i class="icofont icofont-warning"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-4">
                                    <div class="card counter-card-<?= $i ?>">
                                        <div class="card-block-big">
                                            <div>
                                                <h3><?= count($active) ?></h3>
                                                <p> Active Schools</p>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-success" role="progressbar" style="width: 70%" aria-valuenow="<?=count($active)?>" aria-valuemin="0" aria-valuemax="<?=count($schools)?>"></div>
                                                </div>
                                            </div>
                                            <i class="icofont icofont-trophy-alt"></i>
                                        </div>
                                    </div>
                                </div>
                                    <?php 
                                        if(count($users) > 0){
                                        foreach($users as $user){
                                     ?>
                                    <div class="col-md-12 col-xl-3">
                                        <div class="card counter-card-<?= $i ?>">
                                            <div class="card-block-big">
                                                <div>
                                                    <h3><?= ($user->user_count) ?></h3>
                                                    <p>Total <?=ucfirst($user->table)?>s</p>
                                                    <div class="progress ">
                                                        <div class="progress-bar progress-bar-striped progress-xs progress-bar-info" role="progressbar" style="width: 40%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <i class="icofont icofont-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                   <?php
                                    }
                                   }
                                ?>
                              
                            </div>
                        </div>
                    <?php } ?>
                </div>
                
                </div>
                    
                </div>
 

            <!-- Monthly Growth Chart start-->
            <div class="row" id="schools">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>List of Schools Under <u><?=$staff->name?></u></h5>

                            <?php
                            if (Auth::user()->role_id == 1) {
                                $users = \App\Models\User::where('status', 1)->whereIn('role_id', [8,14])->get();
                            ?>
                                <span style="float: right">
                                    <select class="form-control" style="width:300px;" id='taskdate'>
                                        <option></option>
                                        <?php foreach ($users as $user) { ?>
                                            <option value="<?= $user->id ?>" <?= (int) request('user_id') > 0 && request('user_id') == $user->id ? 'selected' : '' ?>><?= $user->firstname . ' ' . $user->lastname ?></option>
                                        <?php } ?>
                                    </select>

                                </span>

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
                                                    <th>Type</th>
                                                    <th>Phone</th>
                                                    <th>Allocated</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                           <?php 
                                                $i = 1;
                                            foreach($schools as $school){
                                             echo '<tr>';
                                                echo '<td>'.$i++.'</td>';
                                                echo '<td>'.$school->client->name.'</td>';
                                                echo '<td>'.$school->school->region.'</td>';
                                                echo '<td>'.$school->school->type.'</td>';
                                                echo '<td>'.$school->client->phone.'</td>';
                                                echo '<td>';
                                                ?>
                                                
                                                    <select name="support_id" class="allocate">
                                                        <option></option>
                                                        <?php
                                                        foreach ($staffs as $user) {
                                                            ?>
                                                            <option user_id="<?= $user->id ?>" role_id="8" schema="<?= $school->client->username ?>" school_id="" value="<?= $user->id ?>"><?= $user->firstname . ' ' . $user->lastname ?></option>
                                                        <?php } ?>

                                                    </select>
                                                    <span id="status_result_8_<?= $school->client->username ?>"></span>

                                            </td>
                                            <?php
                                                echo '<td>';
                                            if($school->client->username != ''){
                                                echo '<a href="'. url('customer/profile/'.$school->client->username) .'" class="btn btn-success btn-sm"> View </a>';

                                            }else{
                                                echo '<a href="'. url('sales/profile/'.$school->school->id) .'" class="btn btn-success btn-sm"> View</a>';

                                            }
                                            echo '</td>';
                                        echo '</tr>';
                                        }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                </div>
                    </div>
                  </div>
   

                  
                  <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Weekly Schools Logs Activities</h5>
                        
                            </div>
                        <div class="card-block">
                        <?php
                                  echo $insight->createChartBySql($logs, 'schema_name', ' Schools Activities ', 'bar', false);

                            ?>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</div>
    <script type="text/javascript" src="<?= $root ?>bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript">
            $('#taskdate').change(function(event) {
                var taskdate = $(this).val();
                if (taskdate === '') {} else {
                    window.location.href = '<?= url('Analyse/myschools') ?>/' + taskdate;
                }
            });

        allocate = function () {
            $('.allocate').change(function () {
                var user_id = $('option:selected', this).attr('user_id');
                var school_id = $('option:selected', this).attr('school_id');
                var role_id = $('option:selected', this).attr('role_id');
                var schema = $('option:selected', this).attr('schema');
                var val = $(this).val();
                $.ajax({
                    type: 'post',
                    url: '<?= url('customer/allocate') ?>',
                    data: {
                        user_id: user_id,
                        school_id: school_id,
                        role_id: role_id,
                        schema: schema,
                        val: val
                    },
                    dataType: 'html',
                    success: function (data) {
                        /// alert('success',data);
                        $('#status_result_' + role_id + '_' + schema).html('<b class="label label-success">success</b>');

                    }
                });
            });
        }
    $(document).ready(allocate);

</script>


@endsection

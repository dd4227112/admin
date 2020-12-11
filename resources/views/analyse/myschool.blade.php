@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="main-body">
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-title">
            <h4>Dashboard</h4>
        </div>
        <?php
                                if (!preg_match('/crdb/i', Auth::user()->email)) {
                                    ?>
        <div class="page-header-breadcrumb">
        <a data-toggle="modal" data-target="#sendMessage" class="btn btn-info btn-sm  f-right"> <i class="ti-comments"></i> Send Message </a>
        </div>
                                <?php }?>
    </div>
    <div class="page-body">
    <div class="row">
    <?php
        if(sizeof($schools)>0){ 
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
                                                    <h3><?= sizeof($schools) ?></h3>
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
                                                <h3><?= sizeof($users) ?></h3>
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
                                                <h3><?= sizeof($active) ?></h3>
                                                <p> Active Schools</p>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-success" role="progressbar" style="width: 70%" aria-valuenow="<?=sizeof($active)?>" aria-valuemin="0" aria-valuemax="<?=sizeof($schools)?>"></div>
                                                </div>
                                            </div>
                                            <i class="icofont icofont-trophy-alt"></i>
                                        </div>
                                    </div>
                                </div>
                                    <?php 
                                        if(sizeof($users) > 0){
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
   
                    <?php if(count($schools) > 0){ ?>
                  
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
              
                    <?php } ?>
                </div>
            </div>
        </div>
</div>


<div class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="sendMessage">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title text-center">
                       Send Message To  <?=number_to_words(count($schools))?> Clients
                      </h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="<?=url('analyse/sendMessage')?>" method="POST">
                    <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <strong>Select Language:</strong>
                    <select name="lang"  class="form-control">
                    <option value="swahili">Kiswahili</option>
                    <option value="english">English</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <strong>Add Details About This Message:</strong>
                    <textarea name="message" rows="6" placeholder="Write Your Message.." class="form-control"></textarea>
                  </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                        <strong>  Select Mode of this Message Below.</strong> 
                          <hr>
                          &nbsp;  &nbsp; &nbsp;<input type="checkbox" name="sms" value='1'>  Send SMS  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;
                      <input type="checkbox" name="email" value="1" >  Send Email 

                    </div>
                </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">  Send <i class="ti-telegram"> </i></button>
                    </div>
                    <?= csrf_field() ?>
                  </form>
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

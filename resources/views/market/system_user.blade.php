@extends('layouts.app')
@section('content')
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4 class="box-title">Schools</h4>
        <span>List of private schools in Tanzania</span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
              <a href="<?= url('/') ?>">
          <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Sales</a></li>
          <li class="breadcrumb-item"><a href="#!">Report</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->

    <div class="page-body">
        <div class="row">

                <div class="col-md-12 col-xl-12">
                    <!-- table card start -->
                    <div class="card table-card">
                        <div class="">
                            <div class="row-table">
                            <?php
                            if(sizeof($users)){
                                foreach($users as $user){
                                    $active_users =  \collect(DB::SELECT('SELECT  count(*) as count from admin.all_users where status=1 and ("table",id) in (select "table", user_id from admin.all_log a where ' . $where .' and "table"=\''.$user->table.'\' group by "table",user_id)'))->first()->count;
                                    if($active_users ==''){
                                        $active_users = 0;
                                    }
                                    ?>
                                    <div class="col-sm-3 card-block-big br">
                                    <div class="row">
                                    <div class="col-sm-4 text-center">
                                        <h5 id="all_users"><?=$user->count?></h5>
                                            <span><?=ucfirst($user->table)?></span>
                                            <small><a href="<?=url('Marketing/systemUser/all/'.$user->table)?>">Total</a></small>
                                            </div>
                                        <div class="col-sm-4 text-center">
                                            <h5 id="all_users"><?=$active_users?></h5>
                                            <span><?=ucfirst($user->table)?></span>
                                            <small> <a href="<?=url('Marketing/systemUser/active/'.$user->table)?>">Active </a></small>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <h5 id="all_users"><?=$user->count - $active_users?></h5>
                                            <span><?=ucfirst($user->table)?></span>
                                            <small><a href="<?=url('Marketing/systemUser/notactive/'.$user->table)?>">Not Active</a></small>
                                        </div>
                                    </div>
                                </div>
                                <?php } }    ?>
                                
                                </div>
                                </div>
                </div>
                
                </div>
                </div>
    <div class="col-lg-12">
      <div class="card">
      <div class="card-header">
      <a href="">List of <?=$status?> <?=$type?>s</a>
      <a href="<?= url('Marketing/systemUser/'.$type .'/'.$status) ?>" style="float: right" data-i18n="nav.navigate.navbar" class="btn btn-success"> <i class="icofont icofont-comment"></i> Send Message</a>

      </div>
        <div class="card-block">
         
                  <div class="table-responsive">
                    <table id="list_of_schools" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>School Name</th>
                          <th>count</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $i = 1;
                      if(isset($list_of_users) && sizeof($list_of_users)){
                        foreach($list_of_users as $list){
                          echo '<tr>';
                          echo '<td>'.$i++.'</td>';
                          echo '<td>'.$list->schema_name.'</td>';
                          echo '<td>'.$list->count.'</td>';
                          echo '<td>
                          <a href="'. url('Markerting/SentSMS/'.$status.'/'.$type). '" class="btn btn-primary btn-sm">View</a>
                          <a href="'. url('Markerting/SentSMS/'.$status.'/'.$type). '" class="btn btn-primary btn-sm">Send SMS</a>
                          </td>';
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
  </div>
</div>
<script type="text/javascript">
    //     dashboard_summary = function () {
    //         $.ajax({
    //             url: '<?= url('Marketing/Users/null') ?>',
    //             data: {},
    //             dataType: 'JSONP',
    //             success: function (data) {
    //                 //console.log(data);
    //                 $('#all_users').html(data.users);
    //                 $('#all_students').html(data.students);
    //                 $('#all_parents').html(data.parents);
    //                 $('#all_teachers').html(data.teachers);
    //                 $('#schools_with_shulesoft').html(data.total_schools);
    //                 $('#schools_with_students').html(data.total_schools - data.schools_with_students);
    //                 //
    //                 $('#active_users').html(data.active_users);
    //                 $('#active_students').html(data.active_students);
    //                 $('#active_parents').html(data.active_parents);
    //                 $('#active_teachers').html(data.active_teachers);
    //             }
    //         });
    //     }
    // $(document).ready(dashboard_summary);
</script>

@endsection

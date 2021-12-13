@extends('layouts.app')
@section('content')

  


    <div class="page-header">
            <div class="page-header-title">
                <h4>School group</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">school list</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Operations</a>
                    </li>
                </ul>
            </div>
        </div> 

    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-block">
                <div class="">
                    <?php $url="users/usergroup/add"; ?>  
                     <a href="<?= url($url) ?>" class="btn btn-primary btn-mini btn-round"> Add group </a>         

                </div>
               </div>

              <div class="card-block">
                  <div class="table-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Group name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(sizeof($groups) > 0){
                        $i = 1;
                        foreach($groups as $group){ ?>
                      <tr>
                          <td><?=$i++?> </td>
                          <td><?=$group->name?></td>
                          <td><?=$group->email?></td>
                          <td><?=$group->phone_number?></td>  
                          <td class="text-center">
                              <?php $v_url = "users/group_clients/$group->id"; ?>
                             <a href="<?= url($v_url) ?>" class="btn btn-primary btn-mini btn-round"> View </a>         

                          </td>
                        </tr>
                        <?php }  ?>
                       <?php }  ?>
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
@endsection

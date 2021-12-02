@extends('layouts.app')
@section('content')

  
    <!-- Page-header start -->

       <div class="page-header">
            <div class="page-header-title">
                <h4><?= $group->name ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">School group</a>
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
                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>School name</th>
                          <th>Email</th>
                          <th>Students</th>
                          <th>Address</th>
                          <th>Phone</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $i = 1;
                      if(sizeof($schools) > 0){
                        foreach($schools as $group){ ?>
                      <tr>
                          <td><?=$i++?> </td>
                          <td><?= warp($group->name,15)?></td>
                          <td><?=$group->email?></td>
                          <td><?=$group->estimated_students?></td>
                          <td><?=warp($group->address,15) ?></td>
                          <td><?=$group->phone?></td>
                          <td><?php $view_url = "customer/profile/$group->username"; ?>
                            <a href="<?= url($view_url) ?>" class="btn btn-primary btn-mini btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="School profile"> view </a>
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

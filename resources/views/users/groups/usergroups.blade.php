@extends('layouts.app')
@section('content')
<div class="main-body">
  <div class="page-wrapper">

    <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-block">
                <div class="">
                    <x-button url="users/usergroup/add" color="primary" btnsize="sm"  title="Add Schools" shape="round" toggleTitle="Add School Group"></x-button>              
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
                             <x-button :url="$v_url" color="primary" btnsize="mini"  title="view" shape="round" toggleTitle="view schools"></x-button>              

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

@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
      <h4>KPI </h4>
      <span>  </u></span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Company Post</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">kpis</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
            <?php
              //  $medias = \App\Models\SocialMediaPost::where('post_id', $post->id)->get();
                  ?>
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">
          <!-- tab panel personal start -->
          <div class="tab-pane active" id="personal" role="tabpanel">
            <!-- personal card start -->
            <div class="card">
              <div class="card-header">
                <table class="table m-0">
                     <tbody>
                         <tr>
                           <th scope="row">KPI Title: &nbsp;&nbsp; <?= $data->name ?></th>
                          </tr>
                          <tr>
                            <th scope="row"> Value: &nbsp;&nbsp;<?= $data->value ?></th>
                          </tr>
                           <tr>
                            <th scope="row"> Query: &nbsp;&nbsp;<?= $data->query ?></th>
                          </tr>
                       <tr>
                       </tr>
                    </tbody>
                </table>
                <hr>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                   <div class="form-group">
                         <h3>  Query parameters</h3> 
                          <?php
                          $parameters = \App\Models\QueryParameter::where('kpi_id',$data->id)->get();
                          foreach ($parameters as $parameter) { ?>
                          <div class="row">
                            <h4>  <?= $parameter->parameter; ?> </h4> &nbsp; &nbsp;
                          </div>
                      <?php } ?>
                    </div>
                  </div>
              </div>

              <div class="card-block">
                <div class="view-info">
                     <h5 class="card-header-text">Employee assigned kpi</h4>
                 </div>
                   <div class="card-block user-desc"> 
                     <div class="col-lg-12 col-xl-12">
                        <table class="table m-0">
                        <thead>
                          <th># </th>
                          <th>Name</th>
                          <th>Role</th>
                          <th>Department</th>
                          <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                          <?php $i = 1; 
                           $users = \App\Models\User::whereIn('id',\App\Models\KPIUser::where('kpi_id',$data->id)->get(['user_id']))->get();
                          ?>
                          @foreach ($users as $key => $user)
                          <tr>
                              <td><?= $i ?></td>
                              <td><?= $user->name ?></td>
                              <td><?= $user->role->display_name ?></td>
                              <td></td>
                              <td>
                                <a class="btn btn-warning btn-sm" href="{{ url('users/evaluatekpi/'.$data->id .'/'.$user->id) }}">Evaluate</a>
                              </td>
                          </tr>
                          <?php $i++; ?>
                          @endforeach
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
        <!-- personal card end-->
      </div>

      @endsection

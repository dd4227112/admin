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
      <span> KPI evaluation </u></span>
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
    
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">
          <!-- tab panel personal start -->
          <div class="tab-pane active" id="personal" role="tabpanel">
            <!-- personal card start -->
            <div class="card">
              <div class="card-header">

                <div>
                  <form method="post" action="<?= url('users/evaluateKpi/'.$id.'/'.$userid) ?>">
                    {{ csrf_field() }}
                    <div class="card-block">
                      <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                          <strong>Start date</strong>
                          <input type="date" class="form-control"  name="start_date" value="<?= date('Y-01-01')?>">
                        </div>
                      </div>
                  
                      <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-12">
                              <strong>End date</strong>
                              <input type="date" class="form-control"  name="end_date" value="<?= date('Y-m-d')?>">
                            </div>
                          </div>
                        </div>
                      </div>
                
                      <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                         <div id="savebtnWrapper" class="form-group mt-10">
                          <button type="submit" class="btn btn-primary">
                             &emsp;Submit&emsp;
                         </button>
                        </div>
                       </div>
                      </div>
                    </div>
                 </form>
                </div>

                <table class="table m-0">
                     <tbody>
                          <tr>
                            <th scope="row"> Full name:&nbsp;&nbsp;&nbsp;&nbsp; <?= $info->firstname ?> &nbsp;&nbsp; <?= $info->lastname ?></th>
                           </tr>
                         <tr>
                           <th scope="row">KPI Title: &nbsp;&nbsp; <?= $data->name ?></th>
                          </tr>
                          <tr>
                            <th scope="row"> Value: &nbsp;&nbsp;<?= $data->value ?></th>
                          </tr>
                         <tr>
                            <th scope="row"> Evaluation value: &nbsp;&nbsp;<?= $value ?></th>
                         </tr>
                         <tr>
                            <th scope="row"> Percentage of success: &nbsp;&nbsp; <?php $total=$data->value; echo $value/$total .' % ' ?></th>
                         </tr>
                    </tbody>
                  </table>
              </div>

              <div class="card-block">
                <div class="view-info">
                     <h5 class="card-header-text">  </h4>
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

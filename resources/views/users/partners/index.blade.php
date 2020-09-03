@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Shulesoft Partners List</h4>
        <span>The Part holds all list of partners and their branches.</span>

      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Company partners</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">partners</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <!-- Ajax data source (Arrays) table start -->
          <div class="card tab-card">
          <?php if($set > 0 ){ $title = 'Branch/'.$set; }else{  $title = 'Partner'; }?>

            <div class="card-block">
            <span>
        <a class="btn btn-success btn-sm" href="<?= url('users/add'.$title) ?>"> Add New <?=$title?></a>
        </span>
              <div class="steamline">
                <div class="card-block">

                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                          <th>Id </th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th><?=$set > 0 ? 'Staffs' : 'Branches'; ?></th>
                          <th>Schools</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(count($partners) > 0){
                        $i = 1;
                        foreach($partners as $partner){
                          ?>
                      <tr>
                          <td><?=$i++?> </td>
                          <td><a href="{{ url('users/showpartner/'.$partner->id) }}"><?=substr($partner->name, 0, 60)?></a></td>
                          <td><?=$partner->email?></td>
                          <td><?=$partner->phone_number?></td>
                          <?php if($set >0){ ?>
                            <td><?=$partner->user->count()?></td>
                          <td><?=$partner->school->count()?></td>
                        <?php  }else{ ?>
                          <td><?=$partner->branch->count()?></td>
                          <td>
                          <?php
                            $school = \App\Models\PartnerSchool::whereIn('branch_id', \App\Models\PartnerBranch::where('partner_id', $partner->id)->get(['id']))->count();
                            echo $school;
                          ?>
                          </td>
                            <?php } ?>
                          <td>
                          <?php 
                                if($set > 0 ){ $path = 'Staffs'; }else{  $path = 'partners'; }
                                $school == 1 ? $school1 = $partner->id.'/branch' :  $school1 = $partner->id;
                            ?>
                          <a class="btn btn-info btn-sm" href="{{ url('users/'. $path . '/'.$partner->id) }}"><?=$path?></a>
                          <a class="btn btn-info btn-sm" href="{{ url('users/partnerSchool/'.$school1) }}">View Schools</a>
                          <a class="btn btn-warning btn-sm" href="{{ url('users/deletepartner/'.$partner->id) }}">Delete</a>
                          </td>
                        </tr>
                        <?php } } ?>
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
@endsection

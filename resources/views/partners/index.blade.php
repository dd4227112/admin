@extends('layouts.app')
@section('content')

  
 
    <?php if($set > 0 ){ $top = 'Branch'; }else{  $top = 'Partner'; }?>
      <?php $name_ = $set > 0 ? ' Partner Branches List' : 'Shulesoft Partners List'; 
      ?>

  
       <div class="page-header">
            <div class="page-header-title">
                <h4> <?=$name_?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">our partners</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 
      
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <!-- Ajax data source (Arrays) table start -->
          <div class="card tab-card">
          <?php if($set > 0 ){ $title = 'Branch'; }else{  $title = 'Partner'; }?>

            <div class="card-block">
            <span>
        <a class="btn btn-success btn-mini btn-round" href="<?= url('Partner/add'.$title) ?>"> Add New <?=$title?></a>
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
                      if(!empty($partners)){
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
                              if($set > 0 ){ $path = 'partner Staff'; }else{  $path = 'partners'; }
                              if($set > 0 ){ $path1 = 'Staffs'; }else{  $path1 = 'Branches'; }
                              $school == 1 ? $school1 = $partner->id.'/branch' :  $school1 = $partner->id;
                            ?>
                          <a class="btn btn-info btn-mini btn-round" href="{{ url('Partner/'. str_replace(' ', '', $path) . '/'.$partner->id) }}"><?=$path1?></a>
                          <a class="btn btn-primary btn-mini btn-round" href="{{ url('Partner/partnerSchool/'.$school1) }}">View Schools</a>
                          <a class="btn btn-danger btn-mini btn-round" href="{{ url('Partner/deletepPartner/'.$partner->id) }}">Delete</a>
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

@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<link rel="stylesheet" type="text/css" href="<?= $root ?>bower_components/fullcalendar/dist/fullcalendar.css">
<link rel="stylesheet" type="text/css" href="<?= $root ?>/bower_components/fullcalendar/dist/fullcalendar.print.css"
    media='print'>
<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>STANDING ORDERS </h4>
                <span>This Part Show all standing orders</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Customer Support</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Activities</a>
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
                    <div class="card">
                        <div class="card-header">

                              <span style="float: left">
                                <select class="form-control" style="width:300px;" id='schoolid'>
                                    <option></option>
                                     <?php  
                                     foreach ($schools as $school) { ?>
                                            <option value="<?= $school->id ?>"  ><?= $school->username; ?></option>
                                        <?php } ?>
                                    </select>
                                </span>

                                <span style="float: right">
                                  <?php if(can_access('add_si')){?>
                                  <button class="btn btn-primary btn-sm" data-toggle="modal" role="button"
                                 data-target="#standing-Modal"> Add standing order </button>
                                 <?php }?>
                                </span>
                          </div>
                        <div class="col-lg-12 col-xl-12">
                            <div class="card-block">
                                <!-- Tab panes -->
                                <div class="tab-content tabs">
                                    <div class="tab-pane active" id="home1" role="tabpanel">
                                        <div class="table-responsive dt-responsive">
                                            <table id="dt-ajax-array" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>School</th>
                                                        <th>Branch</th>
                                                        <th>School contact</th>
                                                        <th>Occurance</th>
                                                        <th>Basis</th>
                                                        <th>Occurance amount</th>
                                                        <th>Total amount</th>
                                                        <th>Maturity date</th>
                                                        <th colspan="2" class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <?php $i = 1; ?>
                                                    @foreach ($standingorders as $key => $standing)
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td>{{ $standing->client->name }} </td>
                                                        <td>{{ $standing->branch->name }}</td>
                                                        <td>{{ $standing->schoolcontact->name }}</td>
                                                        <td>{{ $standing->occurrence }}</td>
                                                        <td>{{ $standing->basis }}</td>
                                                        <td>{{ $standing->occurance_amount }}</td>
                                                        <td>{{ $standing->total_amount }}</td>
                                                        <td><?= date('d M Y', strtotime($standing->date)) ?></td>
                                                       @if(can_access('manage_finance'))
                                                   
                                                        <td>
                                                          <a  target="_break" href="<?= url('customer/viewContract/'.$standing->id.'/standing') ?>" class="btn btn-sm btn-success">View</a>

                                                          @if($standing->status == 0)
                                                          <a  href="<?= url('account/approveStandingOrder/'.$standing->id) ?>" class="btn btn-sm btn-success"> Confirm </a>
                                                          <a href="<?= url('account/rejectStandingOrder/'.$standing->id) ?>" class="btn btn-sm btn-danger">Reject</a>
                                                          @else
                                                           <a  class="btn btn-sm btn-secondary">Approved</a>
                                                          @endif 
                                                        </td>
                                                        
                                                     @endif
                                                    </tr>
                                                    <?php $i++; ?>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>


                                    <div class="tab-pane" id="profile1" role="tabpanel">
                                        <p class="m-0">
                                        <div id='calendar'></div>
                                        </p>
                                    </div>
                                </div>

                                
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
     
       <?php if(isset($client_id) && !empty($client_id)) {  ?>

        <div class="modal fade" id="standing-Modal" tabindex="-1" role="dialog" aria-hidden="true"
            style="z-index: 1050; display: none;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Standing Order</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('Customer/addStandingOrder') }}" method="post" enctype="multipart/form-data">
                        <div class="modal-body">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong> Branch name </strong>
                                        <select name="branch_id" required class="form-control select2">
                                            <?php
                                                $branches = \App\Models\PartnerBranch::orderBy('id','asc')->get();
                                                if (!empty($branches)) {
                                                    foreach ($branches as $branch) {
                                                 ?>
                                            <option value="<?= $branch->id ?>">
                                                <?= $branch->name ?>
                                            </option>
                                            <?php
                                            }
                                        }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <strong> Contact person </strong>
                                        <select name="school_contact_id" required class="form-control select2">
                                            <?php
                                                 $school_id = \App\Models\ClientSchool::where('client_id', $client_id)->first()->school_id;
                                                 $contact_staffs = \App\Models\SchoolContact::where('school_id',  $school_id)->get();
                                                if (!empty($contact_staffs)) {
                                                    foreach ($contact_staffs as $contact_staff) {?>
                                               <option value="<?= $contact_staff->id ?>">
                                                  <?= $contact_staff->name ?>
                                               </option>
                                              <?php
                                                }
                                              }
                                            ?>

                                        </select>
                                    </div>

                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong> Number of occurrence </strong>
                                        <input type="number" class="form-control" name="number_of_occurrence" required>
                                    </div>
                                    <div class="col-md-6">
                                        <strong> Basis </strong>
                                        <input type="text" class="form-control" placeholder="eg. Quarter"
                                            name="which_basis" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong> Total amount</strong>
                                        <input type="text" class="form-control" name="total_amount" required>
                                    </div>
                                    <div class="col-md-6">
                                        <strong> Amount for Every Occurrence </strong>
                                        <input type="text" class="form-control" name="occurance_amount" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong> Maturity Date</strong>
                                        <input type="date" class="form-control" name="maturity_date" required>
                                    </div>
                                    <div class="col-md-6">
                                        <strong> Standing order </strong>
                                        <input type="file" class="form-control" name="standing_order_file" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect "
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light ">Save
                                changes</button>
                        </div>
                         <input type="hidden" value="<?= $client_id ?>" name="client_id" />
                        <?= csrf_field() ?> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

  <?php }  ?>

    <script>
      
    $('#schoolid').change(function(event) {
      var id = $(this).val();
       if (id === '') {} else {
         window.location.href = '<?= url('Account/standingOrders') ?>/' + id;
      }
   });







    </script>


    @endsection
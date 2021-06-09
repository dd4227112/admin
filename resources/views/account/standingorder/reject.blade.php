@extends('layouts.app')
@section('content')

<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
      <h4>Rejected Standing order </h4>
    
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Company </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Standing order</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">
          <!-- tab panel personal start -->
             <div class="tab-pane active" id="personal" role="tabpanel">
          
                <div class="card">
                 <div class="card-header">

                    <div class="row">
                        <div class="col-lg-12 col-xl-6">
                            <table class="table m-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">School Name</th>
                                        <td> <?= isset($standing->client) ? $standing->client->name: ''?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">School Contact</th>
                                        <td><?= isset($standing->schoolcontact) ? $standing->schoolcontact->name: ''?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Type</th>
                                        <td><?=$standing->type?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-lg-12 col-xl-6">
                            <table class="table m-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Occurance Amount</th>
                                        <td><?=money($standing->occurance_amount)?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total Amount</th>
                                        <td><?=money($standing->total_amount)?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Maturity Date</th>
                                        <td><?=isset($standing->payment_date) ? date('d M Y', strtotime($standing->payment_date)) : ''?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-lg-12 col-xl-12">
                            <table class="table m-0">
                                 <tbody>
                                   <tr>
                                        <td colspan="2">
                                         <form class="form-horizontal form-material" method="post" action="<?= url('account/rejectstandingorder/'.$standing->id) ?>" >
                                             <div class="form-group row">
                                                 <strong class="col-md-12 m-2">Rejection reason </strong>
                                                 <div class="col-md-10">
                                                     <input type="text" name="reason" class="form-control" required>
                                                 </div>
                                            
                                                 <div class="col-sm-2">
                                                     <?= csrf_field() ?>
                                                     <button class="btn btn-success" type="submit"> Submit</button>
                                                 </div>
                                             </div>
                                         </form>
                                        </td>
                                   </tr>
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

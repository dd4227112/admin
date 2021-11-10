@extends('layouts.app')
@section('content')
<div class="main-body">
  <div class="page-wrapper">

 
   <div class="page-header">
        <div class="page-header-title">
            <h4><?='Learning details' ?></h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">learning</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Operations</a>
                </li>
            </ul>
        </div>
    </div> 
   
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
                           <th scope="row">Course name: &nbsp;&nbsp; <?= $learning->course_name ?></th>
                          </tr>
                          <tr>
                            <th scope="row">Learning Source: &nbsp;&nbsp;<?= $learning->source ?></th>
                          </tr>
                           <tr>
                            <th scope="row"> Details: &nbsp;&nbsp;<?= $learning->descriptions ?></th>
                          </tr>
                         <tr>
                           <th scope="row"> Start date: &nbsp;&nbsp;&nbsp;&nbsp;<?= date('F j, Y', strtotime($learning->from_date)) ?></th>
                           <th scope="row"> End date: &nbsp;&nbsp;&nbsp;&nbsp;<?= date('F j, Y', strtotime($learning->to_date)) ?></th>
                        </tr>
 
                        <?php if(isset($learning->course_link)) { ?>
                        <tr>
                          <th><a target="_break" href='<?= $learning->course_link ?>'>Course link</a></th>
                       </tr>
                       <?php } ?>

                        <?php if($learning->has_certificate == 1) { ?>
                        <tr>
                          <?php if($learning->company_file_id > 0) { ?>
                            <th scope="row">
                              <?php $viw_url = "customer/viewFile/$learning->id/course_certificate"; ?>
                               <a href="<?= url($viw_url)?>" class="btn btn-primary btn-mini btn-round">View</a>
                            </th>
                          <?php } else { ?>
                            <th scope="row">   
                              <form class="form-horizontal form-material" method="post" action="<?= url('users/certification/' . $learning->id) ?>" enctype="multipart/form-data">
                                  <div class="form-group row">
                                      <label class="col-md-12">Certificate</label>
                                      <div class="col-md-4">
                                          <input type="file" name="certificate" accept=".png,.jpg,.jpeg,.doc,.pdf,.docx" class="form-control form-control-line" required>
                                      </div>
                                      <div class="col-sm-6">
                                          <?= csrf_field() ?>
                                        <button color="primary" class="btn btn-primary btn-mini btn-round"> Upload</button>
                                      </div>
                                  </div>
                              </form>
                            </th>
                          <?php } ?>
                       </tr>
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
      @endsection

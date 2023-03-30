@extends('layouts.app')
@section('content')

          <div class="page-header">
            <div class="page-header-title">
                <h4><?='Weekly error logs' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">errors</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">system errors</a>
                    </li>
                </ul>
            </div>
        </div> 

        <div class="page-body">
            <div class="">
               
              <form method="post">
               <div class="row">
                    <div class="col-sm-12 col-lg-3 m-b-20">
                       <h6>Pick Week </h6>
                       <input type="week" name="week" id="camp-week"  class="form-control"
                       min="2018-W18" max="2022-W26" required value="">
                   </div>
                   <div class="col-sm-12 col-lg-3 m-b-20">
                       <h6> &nbsp; </h6>
                       <button id="search_custom" class="btn btn-mini btn-round btn-primary"> submit </button>
                   </div>
               </div>
               <?= csrf_field() ?>
              </form>
            
                <div class="card">
                    <div class="card-block">
                         <h5><?= isset($first_day) && isset($end_week) ? 'FROM   ' .date('d-m-Y', strtotime($first_day)) . '        TO   '. date('d-m-Y', strtotime($end_week)) : ''  ?> </h5>
                         <br>
        
                        <div class="table-responsive">
                            <table id="example"  class="table dataTable table-mini table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> Error Message</th>
                                        <th class="text-center"> Error counts</th>
                                        <th class="text-center">Resolved Error counts</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                    <?php $i = 1; if(isset($finals)){  
                                        foreach ($finals as $key => $final) { ?>
                                        <tr>
                                        <td><?= $i ?></td>
                                        <td><strong> <?= ($final['message']) ?> </strong></td>
                                        <td class="text-center"> 
                                          <?= '<label class="badge badge-danger">' . ($final['error_count']) . '</label>' ?>
                                        </td>
                                        <td>
                                          <?= '<label class="badge badge-primary">' . ($final['solved_error_count']) . '</label>' ?>
                                        </td>
                                    </tr>
                                    <?php  $i++; } } ?>
                                 </tbody>
                               
                              </table>
                            </div>
                           </div>
                        </div>

             
          
        
        </div>
    </div>
  </div>




  @endsection

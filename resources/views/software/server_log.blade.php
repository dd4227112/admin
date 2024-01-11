@extends('layouts.app')
@section('content')
          <div class="page-header">
            <div class="page-header-title">
                <h4><?='Server logs' ?></h4>
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
                    <li class="breadcrumb-item"><a href="#!">server errors</a>
                    </li>
                </ul>
            </div>
        </div> 

        <div class="page-body">
            <div class="">
               <div class="row">
                    <div class="col-md-6 col-xl-4">
                      
                         <div class="card bg-c-yellow text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">All errors</p>
                                                <h4 class="m-b-0">{{ number_format($all_errors->total) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-layers f-50 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                    </div>
               
                    <div class="col-md-6 col-xl-4">
                       
                         <div class="card bg-c-pink text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5"> Pending errors </p>
                                                <h4 class="m-b-0">{{ number_format($pending->total) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-book f-50 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                       
                       <div class="card bg-c-green text-white">
                                  <div class="card-block">
                                      <div class="row align-items-center">
                                          <div class="col">
                                              <p class="m-b-5">Resolved errors</p>
                                              <h4 class="m-b-0">{{ number_format($resolved->total) }}</h4>
                                          </div>
                                          <div class="col col-auto text-right">
                                              <i class="feather icon-check-circle f-50 text-c-red"></i>
                                          </div>
                                  </div>
                              </div>
                      </div>
                  </div>
               </div>
            

           <div class="card">
            <div class="card-block">
                <div class="table-responsive">
                    <table id="example"  class="table dataTable table-mini table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> Error Message</th>
                                <th>Status</th>
				                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; $error_total = 0; foreach($errors as $error) { ?>
                                <tr>
                                    <td> <?= $i?></td>
                                    <td> <?= warp(substr($error->message,0,200),180)  ?></td>
                                    <td> <?= $error->status ?></td>
                                    <td>
                                         <a href="<?=base_url('Software/viewServerError/'.$error->id)?>" class="btn btn-primary btn-sm  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="View error">view </a>

                                       <a href="#" class="btn btn-sm btn-round btn-danger delete_error" title="Delete error" id ="<?= $error->id ?>">delete</a>
                                    </td>
                                    
                                </tr>
                            <?php $i++; } ?>
                         </tbody>
                       
                      </table>
                    </div>
                   </div>
                </div>
             
            <div class="row">
             <div class="col-xl-12">
                <div class="card">
                    <div class="card-body container">
                        <figure class="highcharts-figure">
                                <div id="errors" style="height: 300px;"></div>
                         </figure>
                       </div>
                  </div>
                </div>
            </div>
        
        </div>
    </div>
  </div>


  <script type="text/javascript">

    // $(document).ready(function() {
    //    $('#example').DataTable();
    // });

      $('#schema_select').select2({
        placeholder: "Select a State",
        allowClear: true
     });

    $(document).ready(function() {
    $('.delete_error').on('click',function () {
        var id = $(this).attr('id');
        $.ajax({
            url: '<?= url('software/serverlogsDelete') ?>',
            method: 'post',
            data: {id: id},
            success: function (data) {
                if (data == '1') {
                    window.location.reload();
                    toastr.success('Error deleted successfully!');
                } else{
                    toastr.error('No Error deleted!');
                }
            }
        });
        });
    });
    
  </script>

  @endsection

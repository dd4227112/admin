@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

    <div class="page-header">
        <div class="page-header-title">
            <h4>Requirements</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                <a href="<?= url('/') ?>">
                    <i class="feather icon-home"></i>
                </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">user requirements</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Operations</a>
                </li>
            </ul>
        </div>
    </div> 

        <div class="page-body">

            <div class="card">
                <div class="card-header" style="margin-bottom: -10px;">
                    <h6>
                    <?php $back_url = "Customer/requirements"; $next_url = "Customer/requirements/show/$next"; ?>
                     <a href="<?= url($back_url) ?>" class="btn btn-primary btn-mini btn-round float-left" data-placement="top"  data-toggle="tooltip" data-original-title="Go Back"> back </a>
                     <?php if(!is_null($next)) { ?>
                       {{-- <a href="<?= url($next_url) ?>" class="btn btn-info btn-mini  btn-round float-right" data-placement="top"  data-toggle="tooltip" data-original-title="Go next"> next </a>  --}}
                     <?php } ?>
                    </h6> 
                </div>
                <div class="card-block">
                        <p style="font-weight: 600;margin-bottom:0px;">Requirement &nbsp;&nbsp; <?= isset($requirement->school->name) ? '<label class="badge badge-inverse-primary">' .$requirement->school->name. '</label>' : ' <label class="badge badge-inverse-success">General requirement</label>' ?></p> 
                        <p style="font-weight: 600"> <?= $requirement->note ?></p>
                </div>
       
                <div class="card-block">
                        <p style="font-weight: 600;">Added date &nbsp;&nbsp; <label class="badge badge-inverse-primary"> <?= date('d-m-Y', strtotime($requirement->created_at)) ?></label> &nbsp;&nbsp;&nbsp;&nbsp;
                        Staff Members &nbsp;&nbsp;&nbsp;  <?php  if ($requirement->user_id == $requirement->to_user_id) { echo $requirement->user->firstname . ' ' . $requirement->user->lastname;
                        } else { echo 'By ' . $requirement->user->firstname . ' ' . $requirement->user->lastname . ' To ';echo $requirement->toUser->name;}?>
                        &nbsp;&nbsp;&nbsp; Client Contact &nbsp;&nbsp;&nbsp;<label class="badge badge-inverse-primary"><?= $requirement->contact ?></label> &nbsp;&nbsp;&nbsp; Status &nbsp;&nbsp;&nbsp; <label class="badge badge-inverse-info"><?= $requirement->status ?></label>
                       </p>


                        <div class="form-radio m-b-30">
                                     <?php
                                       $check = \App\Models\Requirement::where(['id' => $requirement->id,'status'=>$requirement->status])->first();
                                        !empty($check->status) ? $checked = 'checked' : $checked = '';
                                        echo $check->status;
                                        ?>
                                <div class="radio radiofill radio-primary radio-inline">
                                    <label>
                                        <input type="radio" id="On Progres"  name="radio" value="On Progres" {{$checked}} >
                                             <i class="helper"></i>On Progres
                                    </label>
                                </div>
                                <div class="radio radiofill radio-primary radio-inline">
                                    <label>
                                        <input type="radio"  id="Completed" name="radio" value="Completed" {{$checked}} >
                                        <i class="helper"></i>Completed
                                    </label>
                                </div>
                                <div class="radio radiofill radio-primary radio-inline">
                                    <label>
                                        <input type="radio" id="Resolved"  name="radio" value="Resolved" {{$checked}} >
                                        <i class="helper"></i>Resolved
                                    </label>
                                </div>
                                <div class="radio radiofill radio-primary radio-inline">
                                    <label>
                                        <input type="radio" id="Canceled"  name="radio" value="Canceled" {{$checked}} >
                                        <i class="helper"></i>Canceled
                                    </label>
                                </div>
                          </div>
                       </div>
                       </div>

                       <div class="card">
                        <div class="card-header"> My new requirements </div>
                        
                        <div class="card-block">
                        <div class="table-responsive dt-responsive">
                          <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Priority </th>
                                <th>School</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 1; 
                                 $requirements = \App\Models\Requirement::where('to_user_id',$requirement->to_user_id)
                                 ->where('id','<>',$requirement->id)->where('status','<>','Completed')->latest()->get();
                                  if(count($requirements) > 0){ 
                                 foreach ($requirements as $req) {   
                                 ?>
                              <tr>
                                  <td><?= $i ?></td>
                                  <td><?= $req->priority ?? 'Medium Priority' ?></td>
                                  <td><?= isset($req->school->name) ? ucfirst($req->school->name) : 'General Requirement' ?></td>
                                  <td><?= $req->created_at ?? '' ?></td>
                                  <td><?= $req->status ?? '' ?></td>
                                  <td>
                                     <?php $view_url="customer/requirements/show/$req->id"; $edit_url="customer/requirements/edit/$req->id"; ?>
                                     <a href="<?= url($view_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Requirement"> view </a>
                                        <a href="<?= url($edit_url) ?>" class="btn btn-info btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Edit"> Edit </a>
                                  </td>
                              </tr>

                              <?php $i++; } }  ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>#</th>
                              <th>Priority</th>
                              <th>School</th>
                              <th>Issued Date</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </tfoot>
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
<script>
  $('input[type="radio"]').click(function(){  
        var val = $(this).val();  
        $.ajax({
            type: 'POST',
             headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            url: "<?= url('Customer/updateReq') ?>",
            data: "id=" + <?= $requirement->id ?> + "&action=" + val,
            dataType: "html",
            success: function (data) {
                toastr.success(data);
                window.location.reload();
            }
        });
    });
</script>
@endsection

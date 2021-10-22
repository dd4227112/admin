@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="main-body">
    <div class="page-wrapper">
      
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
                     <a href="<?= url($next_url) ?>" class="btn btn-info btn-mini  btn-round float-right" data-placement="top"  data-toggle="tooltip" data-original-title="Go next"> next </a>


                    </h6> 
                </div>
                <div class="card-block">
                        <p style="font-weight: 600;margin-bottom:0px;">Requirement &nbsp;&nbsp; <?= isset($requirement->school->name) ? '<label class="badge badge-inverse-primary">' .$requirement->school->name. '</label>' : ' <label class="badge badge-inverse-success">General requirement</label>' ?></p> 
                        
                        <p style="font-weight: 600"> <?= $requirement->note ?></p>
                </div>
          </div>

          <div class="card">
                <div class="card-block">
                        <p style="font-weight: 600;">Added date &nbsp;&nbsp; <label class="badge badge-inverse-primary"> <?= date('d-m-Y', strtotime($requirement->created_at)) ?></label> &nbsp;&nbsp;&nbsp;&nbsp;
                        Staff Members &nbsp;&nbsp;&nbsp;  <?php  if ($requirement->user_id == $requirement->to_user_id) { echo $requirement->user->firstname . ' ' . $requirement->user->lastname;
                        } else { echo 'By ' . $requirement->user->firstname . ' ' . $requirement->user->lastname . ' To ';echo $requirement->toUser->name;}?>
                        &nbsp;&nbsp;&nbsp; Client Contact &nbsp;&nbsp;&nbsp;<label class="badge badge-inverse-primary"><?= $requirement->contact ?></label> &nbsp;&nbsp;&nbsp; Status &nbsp;&nbsp;&nbsp; <label class="badge badge-inverse-info"><?= $requirement->status ?></label>
                       </p>


                        <div class="form-radio m-b-30">
                                     <?php
                                       $check = \App\Models\Requirement::where('id', $requirement->id)->first();
                                            !empty($check) ? $checked = 'checked' : $checked = '';
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

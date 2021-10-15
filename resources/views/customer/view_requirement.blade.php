@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>


<div class="main-body">
    <div class="page-wrapper">
      <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>
       
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <!-- tab panel personal start -->
                    <div class="tab-pane active" id="personal" role="tabpanel">
                        <!-- personal card start -->


                        <div class="card">
                            <div class="card-block">
                                    <div class="row">
                                        <div class="col-lg-12">
                                                <div class="row">
                                                      <div class="table-responsive">
                                                         <table class="table dataTable table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Added Date</th>
                                                                    <th>{{ date('d-m-Y', strtotime($requirement->created_at)) }} </th>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Staff Members</th>
                                                                    <th>
                                                                        <?php
                                                                        if ($requirement->user_id == $requirement->to_user_id) {
                                                                            echo $requirement->user->firstname . ' ' . $requirement->user->lastname;
                                                                        } else {
                                                                            echo 'By ' . $requirement->user->firstname . ' ' . $requirement->user->lastname . ' To ';
                                                                         
                                                                            echo $requirement->toUser->name;
                                                                        }
                                                                        ?>
                                                                </tr>
                                                                <tr>
                                                                    <th> Client Name</th>
                                                                    <th><?= isset($requirement->school->name) ? $requirement->school->name : ' <label class="badge badge-inverse-success">General requirement</label>' ?>
                                                                    <code><?= isset($requirement->school->type) ? $requirement->school->type : ''  ?></code>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th> Client Contact</th>
                                                                    <th><?= $requirement->contact?></th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                           </div>
                                       </div>
                                  </div>
                               </div>


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">

                                        <div class="card-block user-desc">
                                            <div class="view-desc">
                                                <h4>About This Requirement </h4>
                                                <hr>
                                                <span style="float: right;"><b>Task Excuted:</b>
                                                    <select id="action" class="form-control">
                                                        <option value='{{ $requirement->status }}'>{{ $requirement->status }}</option>
                                                        <option value='On Progres'>On Progres</option>
                                                        <option value='Completed'>Completed</option>
                                                        <option value='Resolved'>Resolved</option>
                                                        <option value='Canceled'>Canceled</option>
                                                        <option value='New'>New</option>
                                                    </select>
                                                </span>
                                                <p> <?= $requirement->note ?></p>

                                            </div>
                                            <?php 
                                 
                                            ?>
                                        </div>
                                    </div>
                                    <div class="justify-content-between mb-10">
                                        <p>  <a href="<?=url('Customer/requirements')?>" class="btn btn-success" style="float: left;"> Go Back</a> </p>
                                        <p>  <a href="<?=url('Customer/requirements/show/'.$next)?>" class="btn btn-success" style="float: right;"> Go Next</a> </p>
                                    </div>
                                <br>
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
<!-- personal card end-->
</div>
<script>
    $('#action').change(function () {
        var val = $(this).val();
        $.ajax({
            type: 'POST',
            url: "<?= url('Customer/updateReq') ?>",
            data: "id=" + <?= $requirement->id ?> + "&action=" + val,
            dataType: "html",
            success: function (data) {
                window.location.href = '#';
            }
        });
    });
</script>
@endsection

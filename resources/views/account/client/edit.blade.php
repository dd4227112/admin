@extends('layouts.app')

@section('content')

    
           <div class="page-header">
            <div class="page-header-title">
                <h4><?='Edit client' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">client</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">setting</a>
                    </li>
                </ul>
            </div>
        </div> 

        <div class="page-body">
            <div class="row">

                <div class="col-sm-12">
                    <!-- Zero config.table start -->

                    <div class="card-block">

                        <div class="card-header">
                           Fill all basic information correctly

                        </div>
                        <div class="card-body">
                            <div id="error_area"></div>
                            <div class=" form">
                                <form class="cmxform form-horizontal " method="post" action="<?= url('account/client/edit/'.$client->id) ?>">
                                    <div class=" form-control">
                                        <div class="form-group ">
                                            <label for="name" class="control-label col-lg-3">Name (required)</label>
                                            <div class="col-lg-6">
                                                <input class=" form-control" id="name" name="name" minlength="2" type="text" required="" value="<?=$client->name?>">
                                            </div>
                                             <?php echo form_error($errors, 'name'); ?>
                                        </div>
                                        <div class="form-group ">
                                            <label for="email" class="control-label col-lg-3">Email (required)</label>
                                            <div class="col-lg-6">
                                                <input class=" form-control" id="name" name="email" minlength="2" type="email" required=""  value="<?=$client->email?>">
                                            </div>
                                             <?php echo form_error($errors, 'email'); ?>
                                        </div>
                                        <div class="form-group ">
                                            <label for="phone" class="control-label col-lg-3">Phone (required)</label>
                                            <div class="col-lg-6">
                                                <input class=" form-control" id="name" name="phone" minlength="2" type="text" required=""  value="<?=$client->phone?>">
                                            </div>
                                             <?php echo form_error($errors, 'phone'); ?>
                                        </div>
                                        <div class="form-group ">
                                            <label for="address" class="control-label col-lg-3">Address (required)</label>
                                            <div class="col-lg-6">
                                                <input class=" form-control" id="name" name="address" minlength="2" type="text" required=""  value="<?=$client->address?>">
                                            </div>
                                             <?php echo form_error($errors, 'address'); ?>
                                        </div>
                                        <div class="form-group ">
                                            <label for="project" class="control-label col-lg-3">Projects (required)</label>
                                            <div class="col-lg-6">
                                                <?php
                                                foreach ($projects as $proj) {
                                                    ?>
                                                    <input class=" form-control" id="project_ids" name="project_ids[]" minlength="2" type="checkbox" value="<?= $proj->id ?>" <?=$client->clientProjects()->where('project_id',$proj->id)->count()==0 ? '': 'checked'?>> <?= $proj->name ?>
                                                <?php } ?>
                                            </div>
                                             <?php echo form_error($errors, 'project_ids'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <?= csrf_field() ?>
                                            <button  class="btn btn-primary" type="submit" >Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
 
   
</script>
@endsection



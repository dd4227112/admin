@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
       <?php $breadcrumb = array('title' => 'Create Clients','subtitle'=>'clients','head'=>'operations'); ?>

        <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                
                    <div class="card">
                       <div class="card-block">
                        <div class="card-header">
                           Fill all basic information correctly
                        </div>
                        <div class="card-block">
                            <div id="error_area"></div>

                            <div class="col-sm-12">
                                <form  method="post" action="<?= url('account/createClient') ?>">
                                    
                                     <div class="row">
                                        <div class="col-xl-6 col-md-6">
                                            <label for="name" class="control-label col-lg-6">Name (required)</label>
                                            <div class="col-lg-12">
                                                <input class=" form-control" id="name" name="name" minlength="2" type="text" required="">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6">
                                            <label for="email" class="control-label col-lg-6">Email (required)</label>
                                            <div class="col-lg-12">
                                                <input class=" form-control" id="name" name="email" minlength="2" type="email" required="">
                                            </div>
                                        </div>
                                     </div>

                                     <div class="row">
                                        <div class="col-xl-6 col-md-6">
                                            <label for="phone" class="control-label col-lg-6">Phone (required)</label>
                                            <div class="col-lg-12">
                                                <input class=" form-control" id="name" name="phone" minlength="2" type="text" required="">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6">
                                            <label for="address" class="control-label col-lg-6">Address (required)</label>
                                            <div class="col-lg-12">
                                                <input class=" form-control" id="name" name="address" minlength="2" type="text" required="">
                                            </div>
                                        </div>
                                     </div>

                                     <div class="row">
                                        <div class="col-xl-12 col-md-12">
                                            <label for="project" class="control-label col-lg-3">Projects (required)</label>
                                            <div class="col-lg-12">
                                                <?php
                                                foreach ($projects as $proj) {
                                                    ?>
                                                    <input class=" form-control" id="project_ids" name="project_ids[]" minlength="2" type="checkbox" value="<?= $proj->id ?>"> <?= $proj->name ?>
                                                <?php } ?>
                                            </div>
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
</div>
<script type="text/javascript">
 
   
</script>
@endsection



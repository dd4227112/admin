@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
   
      <div class="page-header">
            <div class="page-header-title">
                <h4> <?= 'Digital marketing' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">digital</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">marketing</a>
                    </li>
                </ul>
            </div>
        </div> 

    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">

          <div class="card">
            <div class="card-block">
              <div class="m-10">
                <?php if(can_access('manage_marketing')) { ?>
                    <a class="btn btn-primary btn-sm btn-round" href="<?= url('Marketing/socialMedia/add') ?>"> Add New Post </a>
                <?php } ?>
              </div>
           
                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                          <th>Id </th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Type</th>
                          <th>Created By</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(sizeof($posts) > 0){
                        $i = 1;
                        foreach($posts as $post){
                          ?>
                      <tr>
                          <td><?=$i++?> </td>
                          <td><a href="{{ url('Marketing/socialMedia/show/'.$post->id) }}"><?=substr($post->title, 0, 60)?></a></td>
                          <td><?=$post->category?></td>
                          <td><?=ucfirst($post->type)?></td>
                          <td><?=$post->user->name?></td>

                          <td>
                          <a class="btn btn-info btn-mini btn-round" href="{{ url('Marketing/socialMedia/show/'.$post->id.'/1') }}">Show</a>
                          <?php if(can_access('manage_marketing')) { ?>
                            <a class="btn btn-warning btn-mini btn-round" href="{{ url('Marketing/DeleteMedia/'.$post->id) }}">Delete</a>
                          <?php } ?>
                          </td>
                        </tr>
                        <?php } } ?>
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
@endsection

@extends('layouts.app')
@section('content')

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Shulesoft Meeting Minutes</h4>
        <span>The Part holds all written record of everything that's happened during a meeting.</span>

      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Company Minutes</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">posts</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <!-- Ajax data source (Arrays) table start -->
          <div class="card tab-card">
            <div class="card-block">
            <span>
        <a class="btn btn-success btn-sm" href="<?= url('Marketing/socialMedia/add') ?>"> Add New Post</a>
        </span>
              <div class="steamline">
                <div class="card-block">

                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                          <th>Id </th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Type</th>
                          <th>End Time</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if(count($posts) > 0){
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
                          <a class="btn btn-info btn-sm" href="{{ url('Marketing/socialMedia/show/'.$post->id) }}">Show</a>
                          <a class="btn btn-warning btn-sm" href="{{ url('Marketing/DeleteMedia/'.$post->id) }}">Delete</a>
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
  </div>
</div>
@endsection

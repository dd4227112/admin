@extends('layouts.app')
@section('content') 
<?php $root = url('/') . '/public/' ?>
<div class="main-body">
    <div class="page-wrapper">
        <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

        <?php if (can_access('manage_users')) { ?>
            <div class="page-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div  class="card">
                                <div class="card-block">
                                        <x-button url="users/create" color="primary float-left" btnsize="sm"  title="new user" shape="round" toggleTitle="Create New User"></x-button>
                                        <a class="btn btn-primary btn-round btn-sm float-right" data-toggle="modal"  role="button" data-target="#status-Modal">Upload users</a>                   
                                </div>
                                  
                                <div  class="card">
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table table-bordered dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Photo</th>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th>Email</th>
                                                        <th>Joining Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($users as $key => $user)
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td>
                                                           <?php
                                                            $path = \collect(DB::select("select f.path from admin.users a join admin.company_files f on a.company_file_id = f.id where a.id = '$user->id'"))->first(); 
                                                            $local = $root . 'assets/images/user.png';
                                                           ?>
                                                          <img src="<?= isset($path->path) && ($path->path != '')  ? $path->path : $local ?>" class="img-circle" style="position: relative;
                                                                 width: 30px;
                                                                 height: 30px;
                                                                 border-radius: 50%;
                                                                 overflow: hidden;">
                                                        </td>
                                                        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                                        <td>{{ $user->phone }}</td>
                                                        <td>{{ $user->email }}</td>
                                                         <td>{{ date('d M Y',strtotime($user->created_at)) }}</td>
                                                        <td class="text-center">
                                                            <?php $view_url = "users/show/$user->id"; $edit_url = "users/edit/$user->id"; ?>
                                                            <x-button :url="$view_url" color="primary" btnsize="sm"  title="Show" shape="round" toggleTitle="View employee"></x-button>
                                                            <x-button :url="$edit_url" color="info" btnsize="sm"  title="Edit" shape="round" toggleTitle="Edit employee"></x-button>              
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                  </div>
                            
                        </div>
                    </div>
                </div>
            </div>
           <?php } ?>

        </div>
    </div>

<div class="modal fade" id="status-Modal">
<div class="modal-dialog modal-lg" role="document">
<form id="add-form" action="{{ url('users/userUpload') }}" method="POST" enctype="multipart/form-data">
<?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add New Members</h5>
            <a href="<?=url('public/sample_files/users.csv')?>"> <u><b>Download Sample</b></u> </a>
        </div>
      <div class="modal-body">
      <p>Import users from a CSV file. In Excel, add an required column of  New Users, and save the file in a CSV format. Click A CSV file, then drag and drop your .csv file, or click choose file to browse files on your computer. Then click <b>Submit. <br>  <br> #Remember to Remove First Row.</b></p>
          <div class="form-group">
            <label>Attach File Name</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-file"></i>
                </div>
              </div>
              <input type="file" class="form-control" placeholder="Enter group name..." name="user_file" required>
            </div>
          </div>
        <!-- </div> -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
  </div>





<div class="modal" id="status-Modal-form">
 <div class="modal-dialog modal-md"> 
   <form id="add-form" action="" method="POST">
    <?= csrf_field() ?>  
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add New Members</h5>
        </div>
      <div class="modal-body">
  
          <div class="form-group">
            <label>Attach File Name</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-file"></i>
                </div>
              </div>
              <input type="file" class="form-control" placeholder="Enter group name..." name="" required>
            </div>
          </div>
        <!-- </div> -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
  </div>








  <script type="text/javascript">
      
          $(document).on("click", ".user_dialog", function () {
                var UserName = $(this).data('id');
                $(".modal-body #job_date").val(UserName);
            });
  </script>
@endsection


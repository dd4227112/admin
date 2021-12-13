@extends('layouts.app')
@section('content') 
<?php $root = url('/') . '/public/' ?>

    
        
        <div class="page-header">
            <div class="page-header-title">
                <h4> Courses/Learning</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">learning</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">operations</a>
                    </li>
                </ul>
            </div>
        </div> 

        <?php if (can_access('manage_users')) { ?>
            <div class="page-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div  class="card">
                              <div class="card-block">
                                  <a class="btn btn-primary btn-round btn-sm float-left text-light" data-toggle="modal"  role="button" data-target="#status-Modal">Create course</a>                   
                              </div>
                                  
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table table-bordered dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Course Name</th>
                                                        <th>Start date</th>
                                                        <th>End date</th>
                                                        <th>Source</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($courses as $key => $value)
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td>{{ $value->course_name }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($value->from_date)) }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($value->to_date)) }}</td>
                                                        <td>{{ warp($value->source,10) }}</td>
                                                  
                                                        <td class="text-center">
                                                        <?php $delete_url = "users/learningDelete/$value->id"; $view_url = "users/learning/$value->id";?>
                                                        <a href="<?= url($view_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="View course">view  </a>
                                                        <a href="<?= url($delete_url) ?>" class="btn btn-danger btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Delete course">delete  </a>
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
           <?php } ?>

        </div>
    </div>



    
<div class="modal fade" id="status-Modal" tabindex="-1"
role="dialog" aria-hidden="true"
style="z-index: 1050; display: none;">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Create Course
</h4>
<button type="button" class="close"
data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<form action="<?= url('users/courses') ?>" method="post">
<div class="modal-body">
<div class="form-group">

<div class="row">
<div class="col-md-12">
<strong> Course name</strong>
<input type="text" class="form-control" name="course_name" required> </div>
</div>
<br>

<div class="row">
<div class="col-md-4">
<strong> Start date</strong>
<input type="date"
class="form-control"
value="<?= date('Y-m-d') ?>"
name="from_date" required>
</div>

<div class="col-md-4">
<strong>End date</strong>
<input type="date"
class="form-control"
name="to_date" required>
</div>

<div class="col-md-4">
<strong> Source</strong>
<select name="source" type="text" class="form-control" required>
  <option value="LinkedIn">LinkedIn</option>
  <option value="Youtube">Youtube</option>
  <option value="Book">Book</option>
  <option value="other">other</option>
</select>
</div>
</div>
<br>

<div class="col-md-4">
<div class="row">
<strong> Certification</strong>
<input type="checkbox" class="form-control" name="has_certificate">
</div>
</div>

<div class="form-group">
<strong> Pick Participants of the course</strong>
<hr>
<?php
if (!empty($users)) {
foreach ($users as $user) {
?>
<input type="checkbox" id="features<?= $user->id ?>" value="{{$user->id}}"  name="user_ids[]">
    <?php echo $user->name(); ?> &nbsp;
&nbsp;
<?php
} }
?>
</div>

<div class="row">
  <div class="col-md-12">
    <strong> Course link</strong>
     <input class="form-control" type="url" name="url" id="url" placeholder="https://example.com" pattern="https://.*" size="30">
  </div>
</div>
<br>

<div class="row">
<div class="col-md-12">
<strong> Description</strong>
<textarea name="description" rows="2" class="form-control">
</textarea>
</div>
</div>

</div>

<div class="modal-footer">
<button type="button"
class="btn btn-default btn-mini btn-round"
data-dismiss="modal">Close</button>
   <button type="submit" class="btn btn-primary btn-mini btn-round">Save changes</button>
</div>

<?= csrf_field() ?>
</form>
</div>
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


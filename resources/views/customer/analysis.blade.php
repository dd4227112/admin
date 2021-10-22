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
      <div class="row">
        <div class="col-md-12 col-xl-12">
          <div class="card">
            <div class="card-block tab-icon">
              <!-- Row start -->
              <div class="row">
                <div class="col-lg-12 col-xl-12">
                
                  <ul class="nav nav-tabs md-tabs " role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#requirements" role="tab"><strong>Customer Requirements</strong></a>
                      <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#addnew" role="tab"><strong>Add New </strong></a>
                      <div class="slide"></div>
                    </li>
                  </ul>


                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div class="tab-pane active" id="requirements" role="tabpanel">
                      <div class="card-block">
                        <div class="table-responsive dt-responsive">
                          <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>School Name</th>
                                <th>Contact</th>
                                <th> Allocated </th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 1;
                              if(count($requirements) > 0){ 
                              foreach ($requirements as $req) {  ?>
                              <tr>
                                  <td><?= $i ?></td>
                                  <td><?= isset($req->school->name) ? ucfirst($req->school->name) : 'General Requirement' ?></td>
                                  <td><?php echo $req->contact; ?></td>
                                  <td><?php echo $req->toUser->name;?> </td>
                                  <td><?= $req->created_at ?></td>
                                  <td><?= $req->status ?></td>
                                  <td>
                                     <?php $view_url="customer/requirements/show/$req->id"; $edit_url="customer/requirements/edit/$req->id"; ?>
                                     <a href="<?= url($view_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Requirement"> view </a>
                                    <?php if($req->status != 'Completed') {  ?>
                                        <a href="<?= url($edit_url) ?>" class="btn btn-info btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Edit"> Edit </a>
                                    <?php } ?>
                                  </td>
                              </tr>
                              <?php 
                                $i++; }
                               }  
                               ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>#</th>
                              <th>School Name</th>
                              <th>Contact</th>
                              <th> Allocated </th>
                              <th>Issued Date</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane" id="addnew" role="tabpanel">
               

                         <div class="card">
                          <div class="card-block">
                             <form method="post">
                              <div class="row">
                                  <div class="col-sm-12 col-xl-4 m-b-30">
                                      <h4 class="sub-title">Select School</h4>
                                       <input type="number" class="form-control" id="get_schools" name="school_id">
                                  </div>
                                  <div class="col-sm-12 col-xl-4 m-b-30">
                                      <h4 class="sub-title">School Contact</h4>
                                      <input type="text" name="contact" style="text-transform:uppercase" class="form-control">
                                  </div>
                                  <div class="col-sm-12 col-xl-4 m-b-30">
                                      <h4 class="sub-title">Allocated person</h4>
                                        <select name="to_user_id" class="form-control select2" required>
                                          <?php
                                          $staffs = DB::table('users')->where('status', 1)->whereNotIn('role_id',array(7,15))->get();
                                          foreach ($staffs as $staff) {
                                            ?>
                                            <option value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                                          <?php } ?>
                                      </select>
                                  </div>
                                
                              </div>
                                 <div class="row">
                                      <h4 class="sub-title">Allocated person</h4>
                                      <div class="col-sm-12">
                                          <textarea rows="3" cols="7" id="content_part" class="form-control"></textarea>
                                      </div>
                                  </div>

                                   <div class="col-sm-3 m-10">
                                       
                                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Submit Here</button>
                                  </div>
                                  <?= csrf_field() ?>
                                
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
    </div>
  </div>
</div>
</div>
</div>
<script>
$(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
}); 

get_schools = function () {
  $("#get_schools").select2({
    minimumInputLength: 2,
    // tags: [],
    ajax: {
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '<?= url('customer/getschools/null') ?>',
      dataType: 'json',
      type: "GET",
      quietMillis: 50,
      data: function (term) {
        return {
          term: term,
          token: $('meta[name="csrf-token"]').attr('content')
        };
      },
      results: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              text: item.name,
              id: item.id
            };
          })
        };
      }
    }
  });
}

$(document).ready(get_schools);

</script>

<script src="<?= url('public/assets/tinymce/tinymce.min.js') ?>"></script>
   <script type="text/javascript">
        wywig = function () {
            tinymce.init({
                selector: 'textarea#content_part',
                height: 200,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code'
                ],
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                content_css: [
                    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                    '//localhost/shule/public/assets/tinymce/codepan.css'
                ]
            });
        }
        wywig();
</script>
@endsection

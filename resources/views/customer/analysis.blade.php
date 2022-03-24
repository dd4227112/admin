@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/';
    $from = '2021-12-01 00:00:01';
    $to = '2022-03-01 00:00:01';
    //dd($requirements->whereBetween('created_at', [$from, $to])->get());


?>

  

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


    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
   @endif

    <div class="page-body">
      <div class="row">
        <div class="col-md-12 col-xl-12">
          <div class="card">
            <div class="card-block tab-icon">
              <div class="row">
                <div class="col-lg-12 col-xl-12">
                  <div class="tab-content">
                    <div class="">
                        <h6> Search requirements by date </h6>
                    </div>

                   <div class="card-block button-list">
                    <form class="form-horizontal" role="form" method="post"> 
                      <div class="form-group row">
                          <div class="col-md-4 col-sm-12">
                              <input type="date" class="form-control" id="from_date" name="from_date" value="<?= old('from_date') ?>" >
                          </div>
                    
                          <div class="col-md-4 col-sm-12">
                              <input type="date" class="form-control" id="to_date" name="to_date" value="<?= old('to_date') ?>" >
                          </div>
                      
                          <div class="col-md-2 col-sm-2 col-xs-6">
                              <input type="submit" class="btn btn-success btn-sm btn-round" value="Submit"  style="float: right;">
                          </div>
                      </div>
                     <?= csrf_field() ?>
                   </form>
                  </div>


                   <div class="card-block button-list">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="tooltip" data-placement="top">
                         New Tasks
                        <span class="badge">90</span>
                    </button>
                    <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="tooltip" data-placement="top">
                      On Progres Tasks
                        <span class="badge">70</span>
                    </button>
                    <button type="button" class="btn btn-warning waves-effect waves-light" data-toggle="tooltip" data-placement="top">
                      Canceled Tasks
                        <span class="badge">170</span>
                    </button>
                   
                    <button type="button" class="btn btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top">
                      Completed Tasks
                        <span class="badge">80</span>
                    </button>
                </div>
                  
                 </div>
               </div>
             </div>
           </div>
        </div>


          <div class="card">
            <div class="card-block tab-icon">
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

                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#addExcel" role="tab"><strong>Add Tasks by Excel </strong></a>
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
                              if(count($requirements->get()) > 0){ 
                              foreach ($requirements->get() as $req) {  ?>
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
                      <br><br>
                             <form method="post">
                              <div class="row">
                                  <div class="col-sm-12 col-xl-4">
                                      <h4 class="sub-title">Select School</h4>
                                       <input type="number" class="form-control" id="get_schools" name="school_id">
                                  </div>
                                  <div class="col-sm-12 col-xl-4">
                                      <h4 class="sub-title">School Contact</h4>
                                      <input type="text" required name="contact" style="text-transform:uppercase" class="form-control">
                                  </div>
                                  <div class="col-sm-12 col-xl-4">
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
                              <hr>
                              <div class="row">
                                <div class="col-sm-12 col-md-4 m-b-30">
                                     <select name="story_priority" class="form-control" required>
                                       <option value="">Requirement Priority</option>
                                      <option value="null">None</option>
                                      <option value="P0">Critical</option>
                                      <option value="P1">High</option>
                                      <option value="P2">Medium</option>
                                      <option value="P3">Low</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4 m-b-30">
                                     <select name="current_state" class="form-control" required>
                                      <option value="unscheduled">Current Requirement State</option>
                                      <option value="unstarted">Unstarted</option>
                                      <option value="started">Started</option>
                                      <option value="finished">Finished</option>
                                      <option value="delivered">Delivered</option>
                                      <option value="rejected">Rejected</option>
                                      <option value="accepted">Accepted</option>
                                      <option value="unscheduled">Unscheduled</option>
                                      <option value="planned">Planned</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4 m-b-30">
                                      <select name="module" class="form-control select2" required>
                                        <option value="">Requirement Module</option>
                                        <?php
                                        $staffs = DB::table('modules')->get();
                                        foreach ($staffs as $staff) {
                                          ?>
                                          <option value="<?= $staff->name ?>"><?= $staff->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                              
                            </div>
                                 <div class="row">
                                      <div class="col-sm-12">
                                          <textarea rows="7" minlength="30" required="" class="form-control" placeholder="Explain about this requirement" name="note"></textarea>
                                      </div>
                                  </div>

                                   <div class="col-sm-3 m-10">
                                       
                                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Submit Here</button>
                                  </div>
                                  <?= csrf_field() ?>
                                
                              </form>
                          </div>


                          
                      <div class="tab-pane" id="addExcel" role="tabpanel">
                       
                          <div class="card">
                            <div class="card-header">
                            <h5>Add New requirements</h5>
                              <span>Import Calls  from a CSV file. In Excel<br></b>
                                <a href="<?=url('public/sample_files/upload_customer_requirements.csv')?>" class="right"> <u><b>#Download Sample</b></u> </a>
                            </span>
                        </div>
                      </div>
                           <form method="post" action="{{ url('customer/requirementUpload') }}" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12 col-xl-4">
                                    <h4 class="sub-title">Upload excel file</h4>
                                     <input type="file" class="form-control"  name="excel_tasks">
                                </div>
                              </div>
                          
                                 <div class="col-sm-3 m-10">
                                      <button type="submit" class="btn btn-primary btn-sm btn-round">Submit Here</button>
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

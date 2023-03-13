@extends('layouts.app')
@section('content')

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

   <div class="row">
    <div class="col-sm-12 col-lg-3 m-b-20">
       <h6>Pick date </h6>
       <input type="text" name="dates" id="rangeDate" class="form-control">
   </div>
   <div class="col-sm-12 col-lg-3 m-b-20">
       <h6> &nbsp; </h6>
       <input type="submit" id="search_custom" class="input-sm btn btn-sm btn-primary">
   </div>
</div>

    <div class="page-body">
      <div class="row">
        <div class="col-md-12 col-xl-12">
          <div class="card">
            <div class="card-block tab-icon">
              <div class="row">
                <div class="col-lg-12 col-xl-12">
                  <div class="tab-content">
                    <div class="">
                       <h6>  <b> Tasks statistics (Numbers)  </b> </h6>
                    </div>
                    <br>

                   <div class=" button-list">
                    <button type="button" class="btn btn-primary waves-effect waves-light">
                        New
                        <span class="badge"><?= isset($stats->new_task) ? $stats->new_task:  0 ?></span>
                    </button>
                    <button type="button" class="btn btn-success waves-effect waves-light">
                      On Progres 
                        <span class="badge"><?= isset($stats->progress) ? $stats->progress : 0 ?></span>
                    </button>
                    <button type="button" class="btn btn-warning waves-effect waves-light">
                      Resolved 
                        <span class="badge"><?= isset($stats->resolved) ? $stats->resolved : 0 ?></span>
                    </button>
                   
                    <button type="button" class="btn btn-info waves-effect waves-light">
                      Completed 
                        <span class="badge"><?= isset($stats->complete) ? $stats->complete : 0  ?></span>
                    </button>

                    <button type="button" class="btn btn-default waves-effect waves-light">
                      Cancelled 
                        <span class="badge"> <?= isset($stats->canceled) ? $stats->canceled : 0 ?></span>
                    </button>

                    <button type="button" class="btn btn-info waves-effect waves-light">
                      Total
                        <span class="badge"> <?= isset($stats->total) ? $stats->total : 0 ?></</span>
                    </button>
                  </div>
                   <br>

                  <div class="">
                    <h6>  <b>  Percentages </b> </h6>
                 </div>
                  <br>

                  <div class=" button-list">
                    <button type="button" class="btn btn-primary waves-effect waves-light">
                        New
                        <span class="badge"><?= isset($stats->percentage_new) ? percent($stats->percentage_new) : 0 ?></span>
                    </button>
                    <button type="button" class="btn btn-success waves-effect waves-light">
                      On Progres 
                        <span class="badge"><?= isset($stats->percentage_progress) ? percent($stats->percentage_progress): 0 ?></span>
                    </button>
                    <button type="button" class="btn btn-warning waves-effect waves-light">
                      Resolved 
                        <span class="badge"><?= isset($stats->percentage_resolved) ? percent($stats->percentage_resolved) : 0 ?></span>
                    </button>
                   
                    <button type="button" class="btn btn-info waves-effect waves-light">
                      Completed 
                        <span class="badge"><?= isset($stats->percentage_complete) ? percent($stats->percentage_complete) : 0 ?></span>
                    </button>

                    <button type="button" class="btn btn-default waves-effect waves-light">
                      Cancelled 
                        <span class="badge"><?= isset($stats->percentage_canceled) ? percent($stats->percentage_canceled) : 0 ?></span>
                    </button>

                    <button type="button" class="btn btn-info waves-effect waves-light">
                      Total
                        <span class="badge">100</span>
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

                    
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#personali" role="tab"><strong> Individual Tasks </strong></a>
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
                                <th>Priority</th>
                                <th>Allocated </th>
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
                                  <td><?php echo $req->priority ?? 'Medium Priority'; ?></td>
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
                              <th>Priority</th>
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
                      <br>
                             <form method="post">
                              <div class="row">
                                  <div class="col-sm-12 col-xl-4">
                                      <h4 class="sub-title">Select School</h4>
                                       <input type="number" class="form-control" id="get_schools" name="school_id">
                                  </div>
                                  <div class="col-sm-12 col-xl-4">
                                      <h4 class="sub-title">Task Due Date</h4>
                                      <input type="date" required name="due_date" style="text-transform:uppercase" class="form-control">
                                  </div>
                                  <div class="col-sm-12 col-xl-4">
                                      <h4 class="sub-title">Task Type</h4>
                                        <select name="story_type" class="form-control select2" required>
                                              <option value="">Select Task Type</option>
                                              <option value="bug">Bug</a>
                                              <option value="feature">New Feature</a>
                                              <option value="chore">Change Request</a>
                                          <option value="Rrelease">Release</a>
                                          <?php
                                          $staff = DB::table('users')->where('status', 1)->inRandomOrder()->first();
                                         ?>
                                            <input type="hidden"  value="<?= $staff->id ?>" name="to_user_id">
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
                                     <input type="file" class="form-control"  name="excel_tasks" required>
                                </div>
                              </div>
                          
                                 <div class="col-sm-3 m-10">
                                      <button type="submit" class="btn btn-primary btn-sm btn-round">Submit Here</button>
                                </div>
                                <?= csrf_field() ?>
                              
                            </form>
                        </div>


                        <div class="tab-pane" id="personali" role="tabpanel">
                            <div class="col-xl-12">
                                <div class="cardt">
                                    <div class="card-body">
                                      <form method="post" action="<?= url('customer/requirements/allocated') ?>">
                                        <div class="row">
                                        
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

                                              <div class="col-sm-12 col-xl-4">
                                                <h4 class="sub-title">Week</h4>
                                                <input type="week" name="week" id="camp-week"  class="form-control"
                                                min="2018-W18" max="2023-W26" required>
                                              </div>

                                              <div class="col-sm-12 col-xl-4">
                                                <h4 class="sub-title">  &nbsp; </h4>
                                                 <button class="btn btn-primary btn-mini btn-round">Submit</button>
                                              </div>

                                             </div>
                                           </form>

                                        
                                             <br>
                                           <div class="row">
                                            <div class="col-xl-2 col-md-6">
                                                <div class="card statustic-progress-card">
                                                    <div class="card-header">
                                                        <h5>New</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <label class="label label-success">
                                                                  <?= isset($person_stats->percentage_new) ? percent($person_stats->percentage_new) : 0 ?> <i class="m-l-10 feather icon-arrow-up"></i>
                                                                </label>
                                                            </div>
                                                            <div class="col text-right">
                                                                <h5 class=""><?= isset($person_stats->new_task) ? $person_stats->new_task:  0 ?></h5>
                                                            </div>
                                                        </div>
                                                        <div class="progress m-t-15">
                                                            <div class="progress-bar bg-c-green" style="width:35%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-6">
                                                <div class="card statustic-progress-card">
                                                    <div class="card-header">
                                                        <h5>On Progress</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <label class="label label-success">
                                                                  <?= isset($person_stats->percentage_progress) ? percent($person_stats->percentage_progress) : 0 ?>
                                                                  <i class="m-l-10 feather icon-arrow-up"></i>
                                                                </label>
                                                            </div>
                                                            <div class="col text-right">
                                                                <h5 class=""><?= isset($person_stats->progress) ? $person_stats->progress:  0 ?></h5>
                                                            </div>
                                                        </div>
                                                        <div class="progress m-t-15">
                                                            <div class="progress-bar bg-c-green" style="width:28%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-6">
                                                <div class="card statustic-progress-card">
                                                    <div class="card-header">
                                                        <h5>Resolved</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <label class="label label-success">
                                                                  <?= isset($person_stats->percentage_resolved) ? percent($person_stats->percentage_resolved) : 0 ?>
                                                                    <i class="m-l-10 feather icon-arrow-up"></i>
                                                                </label>
                                                            </div>
                                                            <div class="col text-right">
                                                                <h5 class=""><?= isset($person_stats->resolved) ? $person_stats->resolved:  0 ?></h5>
                                                            </div>
                                                        </div>
                                                        <div class="progress m-t-15">
                                                            <div class="progress-bar bg-c-green" style="width:87%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-6">
                                                <div class="card statustic-progress-card">
                                                    <div class="card-header">
                                                        <h5> Completed</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <label class="label label-success">
                                                                  <?= isset($person_stats->percentage_complete) ? percent($person_stats->percentage_complete) : 0 ?>
                                                                  <i class="m-l-10 feather icon-arrow-up"></i>
                                                                </label>
                                                            </div>
                                                            <div class="col text-right">
                                                                <h5 class=""><?= isset($person_stats->complete) ? $person_stats->complete:  0 ?></h5>
                                                            </div>
                                                        </div>
                                                        <div class="progress m-t-15">
                                                            <div class="progress-bar bg-c-green" style="width:32%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-2 col-md-6">
                                              <div class="card statustic-progress-card">
                                                  <div class="card-header">
                                                      <h5> Cancelled</h5>
                                                  </div>
                                                  <div class="card-block">
                                                      <div class="row align-items-center">
                                                          <div class="col">
                                                              <label class="label label-success">
                                                                <?= isset($person_stats->percentage_canceled) ? percent($person_stats->percentage_canceled) : 0 ?>
                                                                  <i class="m-l-10 feather icon-arrow-up"></i>
                                                              </label>
                                                          </div>
                                                          <div class="col text-right">
                                                              <h5 class=""><?= isset($person_stats->canceled) ? $person_stats->canceled:  0 ?></h5>
                                                          </div>
                                                      </div>
                                                      <div class="progress m-t-15">
                                                          <div class="progress-bar bg-c-green" style="width:32%"></div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>

                                          <div class="col-xl-2 col-md-6">
                                            <div class="card statustic-progress-card">
                                                <div class="card-header">
                                                    <h5>Total</h5>
                                                </div>
                                                <div class="card-block">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <label class="label label-success">
                                                                100% <i class="m-l-10 feather icon-arrow-up"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col text-right">  
                                                            <h5 class=""><?= isset($person_stats->total) ? $person_stats->total:  0 ?> </h5>
                                                        </div>
                                                    </div>
                                                    <div class="progress m-t-15">
                                                        <div class="progress-bar bg-c-green" style="width:32%"></div>
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

  submit_search = function () {
        $('#search_custom').mousedown(function () {
            var alldates = $('#rangeDate').val();
            alldates = alldates.trim();
            alldates = alldates.split("-");
            start_date = formatDate(alldates[0]);
            end_date = formatDate(alldates[1]);
            window.location.href = '<?= url('customer/requirements/range') ?>/5?start=' + start_date + '&end=' + end_date;
        });
    }

     $('input[name="dates"]').daterangepicker();

    formatDate = function (date) {
        date = new Date(date);
        var day = ('0' + date.getDate()).slice(-2);
        var month = ('0' + (date.getMonth() + 1)).slice(-2);
        var year = date.getFullYear();
        return year + '-' + month + '-' + day;
    }

    $(document).ready(submit_search);
    $(document).ready(formatDate);


get_schools = function () {
  $("#get_schools").select2({
    minimumInputLength: 2,
    // tags: [],
    ajax: {
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '<?= url('customer/getCLientschools/null') ?>',
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

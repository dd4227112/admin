@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<div class="main-body">
  <div class="page-wrapper">
 

       <div class="page-header">
        <div class="page-header-title">
            <h4>Edit requirements</h4>
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
                  <div class="col-sm-12">
                      <!-- Default select start -->
                      <div class="card">
                          <div class="card-block">
                             <form action="<?= url('customer/editReq') ?>" method="post">
                              <div class="row">
                                  <div class="col-sm-12 col-xl-4 m-b-30">
                                      <h4 class="sub-title">Select School</h4>
                                       <input type="number" class="form-control" id="get_schools" name="school_id">
                                  </div>
                                  <div class="col-sm-12 col-xl-4 m-b-30">
                                      <h4 class="sub-title">School Contact</h4>
                                      <input type="text" name="contact" style="text-transform:uppercase" class="form-control" value="<?= $requirement->contact ?>">
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
                                      <h4 class="sub-title">More details</h4>
                                      <div class="col-sm-12">
                                          <textarea rows="3" cols="7" id="content_part" class="form-control"><?= $requirement->note ?></textarea>
                                      </div>
                                  </div>

                                   <div class="col-sm-3 m-10">
                                        <input type="hidden" name="req_id" value="<?= $requirement->id ?>">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Submit Here</button>
                                  </div>
                                  <?= csrf_field() ?>
                                
                              </form>
                          </div>
                      </div>

                      </div>
                  </div>
                         </div>
                                          
   
              <!-- Row start -->
                   {{-- <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Edit Requirement</h4>
                        <span>This Part Allow you to edit requirement </span>
                      </div>
                      <div class="modal-body">


                       <form action="<?= url('customer/editReq') ?>" method="post">
                          <div class="form-group">
                            <div class="row">

                              <div class="col-md-6">
                                <strong>  Select School</strong>
                                <input type="number" class="form-control" id="get_schools" name="school_id">
                              </div>
                              <div class="col-md-6">
                                <strong>School Contacts Phone/Email</strong>
                                <input type="text" name="contact" style="text-transform:uppercase" class="form-control" value="<?= $requirement->contact ?>">
                              </div>
                            </div>
                          </div>

                             <div class="form-group">
                                <strong> Person Allocated to do</strong>
                                <select name="to_user_id" class="form-control select2" required>
                                  <?php
                                  $staffs = DB::table('users')->where('status', 1)->whereNotIn('role_id',array(7,15))->get();
                                  foreach ($staffs as $staff) {
                                    ?>
                                    <option value="<?= $staff->id ?>"><?= $staff->firstname . ' ' . $staff->lastname ?></option>
                                  <?php } ?>

                                </select>
                             </div>

                          <div class="form-group">
                            <strong> More Details</strong>
                             <textarea name="note" rows="3" id="content_part" style="text-transform:uppercase"  class="form-control"  value="<?= $requirement->note ?>">
                               <?= $requirement->note ?>
                            </textarea> 
                          </div>

                        </div>
                        <div class="modal-footer">
                          <input type="hidden" name="req_id" value="<?= $requirement->id ?>">
                          <button type="submit" class="btn btn-primary waves-effect waves-light ">Submit Here</button>
                        </div>
                        <?= csrf_field() ?>
                      </form> 
                    </div>  --}}
                
             
          
      
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

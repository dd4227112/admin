@extends('layouts.app')
@section('content')

  
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4 class="box-title">Database</h4>
        <span></span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Database</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Create Script</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">

            <form action="<?= url('software/upgrade') ?>" method='post' class="form-horizontal form-bordered" style="padding-left: 130px;">
              {{ csrf_field() }}
              <div class="form-body">
                <br>
                <div class="form-group">
                  <label class="col-md-3 col-xs-12">Select Type</label>
                  <div class="col-md-9">
                    <?php echo form_error($errors, 'class_level_id'); ?>
                    <select class="select2 form-control" tabindex="-1" required="true"  name="request_type" id="request_type">
                      <option value="0">Select Task Source Here...</option>
                      <option value="4">Number of new Users (students, parents, teachers)</option>
                      <option value="16">Sms sent and email sent</option>
                      <option value="14">Number of Reply Sms</option>
                      <option value="1">Number of Login failed attempts</option>
                      <option value="2">Number of Log activities (students, parents, teachers)</option>
                      <option value="3">Number of errors recorded</option>
                      <option value="9">Number of Files uploaded</option>
                      <option value="7">Number of Forum Questions Asked</option>
                      <option value="8">Number of Forum Question Answered</option>
                      <option value="13">Number of Videos Uploaded</option>
                      <option value="12">Number of Total Viewers</option>
                      <option value="11">Number of Total Likes</option>
                      <option value="10">Number of Media Comments</option>
                      <option value="15">Online exams Published</option>
                      <option value="5">Assignment Published</option>
                      <option value="6">Assignment Submits</option>
                      <!--  <option value="0">Number of join requests from shulesoft.com website</option>
                      <option value="19">Total payment received</option>
                      <option value="21">Exams done&nbsp;</option>
                      <option value="1">Number of sales calls done today</option>
                      <option value="2">New schools onboarded today</option>
                      <option value="3">Schools trained today</option>
                      <option value="8">Number of features requested</option>
                      <option value="9">Number of features released</option>
                    -->  </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Report Type</label>
                  <div class="col-md-9">
                    <?php echo form_error($errors, 'academic_year'); ?>
                    <select class="select2 form-control" name="date_criteria" id="date_criteria" required="true">
                      <option value="0">Select Type</option>
                      <option value="day">Per Today</option>
                      <option value="week">This Week</option>
                      <!-- <option value="month">This Month</option>
                      <option value="year">This Year</option>
                      <option value="date">Based on Date</option> -->
                    </select>
                  </div>
                </div>
                <?php /*

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $data->lang->line('select_class') ?></label>
                <div class="col-sm-6">
                <?php echo form_error($errors, 'classesID'); ?>
                <select class="select2 form-control" tabindex="-1" name="classesID" id="classID">
                </select>
                </div>

                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $data->lang->line('section') ?></label>

                </label>
                <div class="col-sm-6">
                <select name="section_id" id="section_id" class="form-control">

                </select>
                </div>

                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $data->lang->line('installment') ?></label>
                <div class="col-sm-6">
                <?php echo form_error($errors, 'installment'); ?>
                <select class="select2 form-control" tabindex="-1"  required="true" name="installment" id="installment_id">
                </select>
                </div>
                */ ?>

              </div>
              <?= csrf_field() ?>
            </form>
          </div>

          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  $('#date_criteria').change(function () {
    var request_type =  $('#request_type').val();
    var date_criteria =  $('#date_criteria').val();
    if (request_type == '' && date_criteria == 0) {
      return false;
    } else {
      window.location.href = "<?= url('report/systemReport/') ?>/" + request_type + "/" + date_criteria;
    }
  });
  </script>

  @endsection

@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
 <link rel="stylesheet" href="<?= $root ?>assets/select2/css/select2.css">
<script type="text/javascript" src="<?php echo url('public/assets/select2/select2.js'); ?>"></script>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Payment Api Requests</h4>
                <span>This parts show all api requests done with a bank</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Customer Support</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Modules Usage</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
          
                    <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#home3" role="tab" aria-expanded="false">
                                      <button class="btn-success btn" data-toggle="modal" data-target="#group" onmousedown="$('#group_id').val('')"><span class="fa fa-plus"></span>Add holiday</button>
                                </a>
                                <div class="slide"></div>
                            </li>
                              
                             <li class="m-10 col-sm-3 text-center">
                              <form>
                                <div class="form-group">
                                    <select class="form-control select2" id="check_key">
                                        <option></option>
                                        <?php
                                        if (isset($settings) && sizeof($settings) > 0) {

                                            foreach ($settings as $school) {
                                                ?>
                                                <option value="{{$school->schema_name}}">{{$school->sname}}</option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                              </form>
                             </li>
                            
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                <div class="card-block">
                                    <div class="steamline">
                                        <div class="card-block">

                                            <div class="table-responsive dt-responsive">
                                                <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                         <tr>
                                                            <th>#</th>
                                                            <th>Bank Name</th>
                                                            <th>Account Number</th>
                                                            <th>Invoice Prefix</th>
                                                            <th>Live username</th>
                                                            <th>Live password </th>
                                                            <th>Action</th>
                                                         </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                        
                                                       
                                                    </tbody>
                                               
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                                <div class="email-card p-0">
                                    <div class="card-block">
                                        <h6>
                                            <b>User Allocation Summary</b>
                                        </h6>
                                        <div class="mail-body-content">
                                            <table class="table">

                                           
                                            
                                               
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <!-- Page-body end -->
        </div>
    </div>




    <div class="modal fade" id="group">
    <div class="modal-dialog">
        <form action="#" method="post" class="form-horizontal group_form" role="form" action="<?= url('account/holidays') ?>">

            <div class="modal-content">

                <div class="modal-header">
                    Holidays
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-12">
                         <label class="control-label required">School name</label>
                
                           <select class="form-control " id="check_key">
                            <option></option>
                            <?php
                            if (isset($settings) && sizeof($settings) > 0) {

                                foreach ($settings as $school) {
                                    ?>
                                    <option value="{{$school->schema_name}}">{{$school->sname}}</option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                      </div>
                    </div>
                   
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="control-label required">Date of</label>
                            <input type="date" id="holiday_date" name="holiday_date" class="form-control  ember-text-field text-left ember-view" required>
                        </div>
                    </div>

                   
                
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="control-label required">Date of Holiday</label>
                            <input type="date" id="holiday_date" name="holiday_date" class="form-control  ember-text-field text-left ember-view" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="control-label required">Date of Holiday</label>
                            <input type="date" id="holiday_date" name="holiday_date" class="form-control  ember-text-field text-left ember-view" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="control-label required">Date of Holiday</label>
                            <input type="date" id="holiday_date" name="holiday_date" class="form-control  ember-text-field text-left ember-view" required>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" style="margin-bottom:0px;" class="btn btn-default" data-dismiss="modal" ><?= __('close') ?></button>
                    <button type="submit"  class="btn btn-primary">Save</button>
                </div>
                <?= csrf_field() ?>
            </div>
        </form>
    </div>
</div>
    <!-- Main-body end -->

    <script type="text/javascript">
    $('#check_key').change(function () {
        var val = $(this).val();
        window.location.href = "<?= url('software/banksetup2') ?>/" + val;
    })

    edit_bank_accounts = function (tag, val, schema, bank_id) {
        if (val !== '') {
            $.get('<?= url('software/updateProfile/null') ?>', {schema: schema, table: 'bank', val: val, tag: tag, bank_id: bank_id}, function (data) {
                swal('success', data);
            });
        }
    };

    $(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
});
</script>
    @endsection
  

    

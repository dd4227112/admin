@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="box-title">Add Prospect</h4>
                <span>Specify information correctly</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Sales</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">add prospect</a>
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
            <div class="card-header">
                <h5>Customer Onboarding</h5>
            </div>
            <div class="card-block">
                <form action="<?= url('sales/onboard/' . $school->id) ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                <label class="col-sm-2 col-form-label">School Username</label>
                        <div class="col-sm-10">
                        <input type="username" class="form-control" placeholder="Add School username eg, canossa" name="username" required="" autofocus>
                        
                        </div>
                    </div>

                    <div class="form-group row" style="border: 1px dashed; ">
                                        <label class="col-sm-2 col-form-label">Domain Name</label>
                                        <div class="row">
                                            <div class="col-lg-2">  <b style="font-size: 1.4em;"> https://</b> </div>
                                            <div id="col-lg-6">
                                                <input style="max-width: 20em;
                                                       resize: none" class="form-control " id="school_username" name="username" type="text" placeholder="school name" value="" required="" onkeyup="validateForm()"> 

                                            </div>
                                            <div id="col-lg-4">
                                                <b style="font-size: 1.4em;">.shulesoft.com</b>
                                            </div>
                                        </div>
                                        <small style="max-width: 13em;" id="username_message_reply"></small>
                                    </div>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Estimated Students</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" value="<?= $school->students ?>" name="students" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Data Format Available</label>
                <div class="col-sm-10">
                    <select name="data_type_id" class="form-control">
                        <option value="1">Excel With Parent Phone Numbers</option>
                        <option value="2">Physical Files Format</option>
                        <option value="3">Softcopy but without parents phone numbers</option>

                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Implementation Start Date</label>
                <div class="col-sm-10">

                    <input type="datetime-local" class="form-control" value="" name="implementation_date" required="">
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Agreement Type</label>
                <div class="col-sm-10">
                    <select name="contract_type_id" class="form-control">

                        <?php
                        $ctypes = DB::table('admin.contracts_types')->get();
                        foreach ($ctypes as $ctype) {
                            ?>
                            <option value="<?= $ctype->id ?>"><?= $ctype->name ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Contract Start Date</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" value="" name="start_date" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Contract End Date</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="end_date" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Upload Agreement Form(pdf)</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" accept=".pdf" name="file" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Areas much interested</label>
                <div class="col-sm-10">
                    <textarea rows="5" cols="5" name="description" class="form-control" placeholder="Default textarea"></textarea>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 col-form-label">Joining Status</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="payment_status" id="gender-1" value="1" required=""> All Information Verified 
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="payment_status" id="gender-2" value="2" required=""> School Still on-progress
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="payment_status" id="gender-2" value="2" required=""> School Under ShuleSoft Follow-up
                        </label>
                    </div>
                    <span class="messages"></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success" placeholder="Default textarea">Submit</button>
                </div>
            </div>
        </form>


    </div>
</div>
    <script type="text/javascript">

notify = function (title, message, type) {
    new PNotify({
        title: title,
        text: message,
        type: type,
        hide: 'false',
        icon: 'icofont icofont-info-circle'
    });
}

        function validateForm() {
            var regex = new RegExp("^[a-z]+$");
            var x = $('#school_username').val();
            if (x == null || x == "") {
                $('#username_message_reply').html("Name must not be blank").addClass('alert alert-danger');
                return false;
            } else if (!regex.test(x)) {
                $('#username_message_reply').html("Name contains invalid characters (Only letters with no spaces !)").addClass('alert alert-danger');
                return false;
            } else {
                $('#username_message_reply').html('').removeClass('alert alert-danger');;
                return true;
            }
        }

    software_status = function () {
        $('#software_status').change(function () {
            var type = $(this).val();
            if (type == '0') {
                $('#software_name').hide();
            } else {
                $('#software_name').show();
            }
        });
    }
    $(document).ready(software_status);
                    </div>              
                </div>
                </div>              
            </div>
        </div>              
     </div>
</script>
@endsection
    </script>
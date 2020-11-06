<!-- @extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<!-- Sidebar inner chat end-->
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-6">
                <p>
                    <a  onclick="javascript:printDiv('print_all')" class="btn btn-default btn-sm">Print</a>
                    <a class="approve btn btn-success btn-sm right" href="#"  data-toggle="modal" data-target="#customer_contracts_model">  <i class="ti-plus"> </i> Comment</a>
            </p>
                
            </div>

        </div>

        <!-- Page-body start -->
        <div class="page-body" id="print_all">
            <div class="row">
                <div class="col-lg-12">
                    <!-- tab panel personal start -->
                    <!-- personal card start -->
                    <div class="card">
                        <div class="card-header text-center" style="background-color:#8CDDCD; !important">
                            <h5  style="border-bottom: 5px solid #8CDDCD; color: #ffffff">
                                <?= $request->client->name ?>
                            </h5>
                        </div>
                        <div class="card-block">
                            <div class="view-info">
                                <div class="col-lg-12">
                                    <div class="general-info">
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <h3>School Profile</h3>
                                                <table class="table m-0">

                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">School Name</th>
                                                            <th>
                                                                <?php
                                                                echo '<a href="#">' . isset($request->client->name) ? $request->client->name : '' . '</a>';
                                                                ?>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Location</th>
                                                            <th>
                                                                <?php
                                                                if ($request->user_id != '') {
                                                                    echo isset($client->school) && !empty($client->school) ? $client->school->district . ' - ' . $client->school->region : '';
                                                                }
                                                                ?>
                                                        </tr>
                                                        <tr>
                                                            <th> Registration No. </th>
                                                            <th>
                                                                <?php
                                                                echo isset($client->school) && !empty($client->school) ? $client->school->ownership : '';
                                                                ?>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Number of Students</th>
                                                            <th> <?= $request->client->estimated_students ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th>School Levels</th>
                                                            <td>
                                                                <?php
//                                    $levels = DB::table('admin.school_levels')->where('client_id', $request->client_id)->get();
//                                    foreach($levels as $level){
//                                      echo '<b>'.$level->name.'</b>,   &nbsp; &nbsp;';
//                                    }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-sm-6">
                                                <h3>Key Person Contacts</h3>
                                                <?php if (!empty($school)) { ?>
                                                    <table class="table m-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Full Name</th>
                                                                <th> <?= $school->name ?> </th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Position</th>
                                                                <th>
                                                                    <?php
                                                                    echo $school->title;
                                                                    ?>
                                                            </tr>
                                                            <tr>
                                                                <th> Phone </th>
                                                                <th>
                                                                    <?php
                                                                    echo $school->phone;
                                                                    ?>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Email</th>
                                                                <th> <?= $school->email ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Modules</th>
                                                                <td>
                                                                    <?php
                                                                    echo "No Module Specified";
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of row -->
                                </div>
                                <!-- end of general info -->
                            </div>
                            <!-- end of col-lg-12 -->
                        </div>
                        <!-- end of row -->
                    </div>

                    <!-- end of card-block -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Bank Account Details</h5>
                        </div>
                        <?php
                    $checksystem = DB::table('admin.all_setting')->where('schema_name', $request->client->username)->first();
                        $bank = \App\Models\IntegrationBankAccount::where('integration_request_id', $request->id)->first();
                        if (empty($bank)) {
                            $bank = DB::table($request->client->username . '.bank_accounts')->where('refer_bank_id', 8)->first();
                            $refer_bank = $bank->name;
                            $user = DB::table($request->client->username . '.users')->where("table", $request->table)->where('id', $request->user_id)->first();
                            $user_name = $user->name;
                            $usertype = ucfirst($user->usertype);
                        } else {
                            $refer_bank = $bank->referBank->name;
                            $user_name = $bank->requests->user->name;
                            $usertype = 'Sales Manager';
                        }
                        ?>
                        <div class="card-block user-desc">
                            <div class="view-desc">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3>Account</h3>

                                        <table class="table m-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Bank Name</th>
                                                    <th><?= $refer_bank ?></th>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Account Name</th>
                                                    <th>
                                                        <?php
                                                        if ($request->user_id != '') {
                                                            echo $bank->name;
                                                        }
                                                        ?>
                                                </tr>
                                                <tr>
                                                    <th> Account Number </th>
                                                    <th><?php echo $bank->number; ?> </th>
                                                </tr>

                                                <tr>
                                                    <th>Branch Name</th>
                                                    <th> <?= $bank->branch ?></th>
                                                </tr>
                                                <?php
                                                if ((int) $request->bank_approved == 1) {
                                                    if(!empty($checksystem)){
                                                        ?>
                                                <?php 

                                                     $integrated = \DB::table($request->client->username . '.bank_accounts_integrations')->where('id', $request->bank_accounts_integration_id)->first();
                                                    ?>
                                                    <tr>
                                                        <th>Invoice Prefix</th>
                                                        <th> <?= $integrated->invoice_prefix ?></th>
                                                    </tr>
                                                <?php } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-sm-6">
                                        <h3> Application Docs Attachments</h3>
                                        <?php
                                        $bank_docs = \App\Models\IntegrationRequestDocument::where('integration_request_id', $request->id)->get();
                                        if (!empty($bank_docs)) {
                                            ?>
                                            <table class="table m-0">
                                                <tbody>
                                                    <?php
                                                    foreach ($bank_docs as $bank_doc) {
                                                        ?>
                                                        <tr>
                                                            <th scope="row"><?= $bank_doc->bankdocs->companyfile->name ?> </th>

                                                            <th> <a href="<?= url('Partner/viewfile/' . $bank_doc->bankdocs->company_file_id) ?>" target="_blank" class="btn btn-info btn-sm" rel="noopener noreferrer"> <i class="ti-cloud"></i> View Doc</a> </th>
                                                        </tr>
                                                    <?php } ?>

       <!-- <tr>
         <th scope="row">Implemetantion Start</th>
         <th> <?php // $client->contract->start_date  ?></th>
       </tr> -->

                                                </tbody>
                                            </table>
                                        <?php } ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="table-responsive">

                                            <table class="table">

                                                <thead>
                                                    <tr  style="border-bottom: 5px solid #8CDDCD;">
                                                        <th colspan="2" style="background:#8CDDCD;text-align: center;
                                                            font-size: 18px;
                                                            color: white;">
                                                            <?= $refer_bank ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>On behalf of <b> <?= $refer_bank ?></b> Limited, the aforementioned services headed by</p>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Name:</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Designation:</td>
                                                    </tr>
                                                    <!-- <tr>
                                                    <td>Department:</td>
                                                  </tr> -->
                                                    <tr>
                                                        <td>Signature</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="table-responsive">
                                            <table class="table">

                                                <thead>
                                                    <tr  style="border-bottom: 5px solid #8CDDCD;">
                                                        <th colspan="2" style="background:#8CDDCD;text-align: center;
                                                            font-size: 18px;
                                                            color: white;">INETS COMPANY LIMITED</th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <p>On behalf of <b>INETS Company Limited</b>, the aforementioned services headed by</p>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Name:   &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; <?= $user_name ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Designation:   &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; <?= $usertype ?></td>
                                                    </tr>
                                                    <!-- <tr>
                                                    <td>Department:</td>
                                                  </tr> -->
                                                    <tr>
                                                        <td>Signature   &nbsp; &nbsp;  &nbsp; &nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <table class="table">
                                    <tr>
                                        <td style="width: 60% !important;">
                                            <img src="<?= url('public/images/ShuleSoft-TM.png') ?>" width="350" height="" style=""/>
                                        </td>
                                        <td style="width: 60% !important;">
                                            <span>
                                                INETS is a Private Company Limited by shares and registered <br/>under the Company Act 2012 with registration number 9216.<br/> INETS deals solely with Software Development. <br/>Currently focused on a School Management System ShuleSoft </span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="validate">
                        <div class="col-sm-6">
                            <?php if ((int) $request->shulesoft_approved == 1) { ?>
                                <a href="<?= url('Partner/InvoicePrefix/' . $request->id) ?>" style="float: left;" class="btn btn-success">Shulesoft Validate This Application</a>
                            <?php } ?>
                        </div>

                        <div class="col-sm-6 text-right">
                            <?php if ((int) $request->bank_approved <> 1) { ?>
                                <a href="<?= url('Partner/InvoicePrefix/' . $request->id) ?>" style="float: right;" class="btn btn-success">Bank Validate This Application</a>
                            <?php } ?>
                        </div>
                        <hr>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- personal card end-->

<div class="modal fade" id="customer_contracts_model" role="dialog" style="z-index: 99999;" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Comment For this Application Request</h4>
        <span id="modeltitle"></span>

      </div>
      <form action="<?=url('Partner/RequestComment')?>" class="form-card" method="post">
      <div class="modal-body">
        
    <div class="form-group">
        <div class="row">
        <div class="col-md-12">
            <strong> Select Comment Status</strong>
            <input type="hidden" name="integration_request_id" value="<?=$request->id?>"  class="form-control">
            <input type="hidden" name="user_id" value="<?=Auth::user()->id?>"  class="form-control">
            <select type="text" name="status" required class="form-control select2">
                <option value='1'>Select Here...</option>
                <option value='Accepted'>Accepted</option>
                <option value='Rejected'>Rejected</option>
                <option value='Pending'>Pending</option>
            </select>
            </div>
        </div>
    </div>
    <div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <strong> Write your Comment</strong>
            <textarea name="comment" value="" rows="5" class="form-control"></textarea>
        </div>
    </div>
    </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light "> Submit </button>
    </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div> 
</div>
</div>
</div> 

<script>
    function printDiv(divID) {

        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
                '<html><head><title></title></head><body>' +
                divElements + '</body>';
        //Print Page
        $('#validate').hide();
        window.print();
        //Restore orignal HTML
        document.body.innerHTML = oldPage;
    }
</script>
<script>
    
    $('#approve').click(function () {
        var vals = $('.approve').val();
        $('#modeltitle').html(vals);
    });
        $('#action').change(function () {
        var val = $(this).val();
        $.ajax({
            type: 'POST',
            url: "<?= url('Customer/updateTask') ?>",
            data: "id=" + <?= $request->id ?> + "&action=" + val,
            dataType: "html",
            success: function (data) {
                $('#added_').html(data);
            }
        });
    });
</script>
@endsection -->

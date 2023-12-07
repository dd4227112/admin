<!-- @extends('layouts.app')
@section('content')
<?php  $root = url('/') . '/public/' ?>

<!-- Sidebar inner chat end-->
<!-- Main-body start -->


<div class="row">
    <div class="col-sm-12">
        <a  onclick="javascript:printDiv('print_all')" class="btn btn-secondary btn-sm">Print</a>   
        <a  class="approve btn btn-sm btn-success" href="#"  data-toggle="modal" data-target="#customer_contracts_model"> Approve <i class="ti-plus"> </i> </a>      
        <hr>          
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
                                                            echo isset($client->school) && !empty($client->school) ? $client->school->district . ' - ' . $client->school->region : $request->client->address;
                                                        }
                                                        ?>
                                                </tr>
                                                <tr>
                                                    <th> Registration No. </th>
                                                    <th>
                                                        <?php
                                                        echo isset($client->school) && !empty($client->school) ? $client->school->ownership : 'Private';
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
                                                        $levels = DB::table('admin.school_levels')->where('client_id', $request->client_id)->get();
                                                        if (count($levels)) {
                                                            foreach ($levels as $level) {
                                                                echo '<b>' . $level->name . '</b>,   &nbsp; &nbsp;';
                                                            }
                                                        }
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
                    <h5>Intergration Request Details</h5>
                </div>
                <?php
                $refer_bank = '';
                $number = '';
                $branch = '';
                $user_name = '';
                $usertype = '';
                $checksystem = collect(DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES WHERE table_schema='" . $request->client->username . "'"))->first();
                //  table('admin.all_setting')->where('schema_name', $request->client->username)->first();
                $bank = \App\Models\IntegrationBankAccount::where('integration_request_id', $request->id)->first();
                if (!empty($request)) {
                    $bank = \DB::table('shulesoft.bank_accounts')->where('id', $request->bank_account_id)->where('schema_name', $request->client->username)->first();
                    if (!empty($bank)) {
                        $refer_bank = $bank->name;
                        $number = $bank->number;
                        $branch = $bank->branch;
                    } elseif (!empty($checksystem)) {

                        $bank = DB::table($request->client->username . '.bank_accounts')->where('id', $request->bank_account_id)->first();
                        if (!empty($bank)) {
                            $refer_bank = $bank->name;
                            $number = $bank->number;
                            $branch = $bank->branch;
                        }
                    }
                    $user = \DB::table('shulesoft.users')->where("table", $request->table)->where('id', $request->user_id)->where('schema_name', $request->client->username)->first();
                    if (!empty($user)) {
                        $user_name = $user->name;
                        $usertype = ucfirst($user->usertype);
                    } elseif (!empty($integrated) && !empty($checksystem)) {
                        $user = DB::table($request->client->username . '.users')->where("table", $request->table)->where('id', $request->user_id)->first();
                        if (!empty($user)) {
                            $user_name = $user->name;
                            $usertype = ucfirst($user->usertype);
                        }
                    }
                } elseif (!empty($bank)) {
                    $refer_bank = 'Bank';
                    $number = $bank->number;
                    $branch = $bank->branch;
                    $user_name = $bank->requests->user->name;
                    $usertype = 'Sales Manager';
                } else {
                    $refer_bank = 'Not Defined';
                }
                ?>
                <div class="card-block user-desc">
                    <div class="view-desc">

                        <div class="row">
                            <div class="col-sm-6">
                                <table class="table m-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Channel Name</th>
                                            <th>Quick SMS(Bulk SMS)</th>
                                        </tr>
                                        <tr>
                                            <th scope="row">Sender Name</th>
                                            <th>
                                               {{ $sender_name->phone_number }}
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-6">
                                <h3>Attachments</h3>
                                <?php
                                if (isset($sender_name->file_path)) {
                                    ?>
                                    <table class="table m-0">
                                        <tbody>
                                                    <tr>
                                                        <th scope="row"></th>
                                                        <th> <a href=" {{ $sender_name->file_path }}" target="_blank" class="btn btn-info btn-sm" rel="noopener noreferrer"> <i class="ti-cloud"></i> View Doc</a> </th>
                                                    </tr>
                                        </tbody>
                                    </table>
                                <?php } ?>
                            </div>
                        </div>
                        <hr>

                        <table class="table">
                            <tr>
                                <td style="width: 60% !important;">
                                    <img src="<?= url('public/images/ShuleSoft-TM.png') ?>" width="350" height="" style=""/>
                                </td>
                                <td style="width: 60% !important;">
                                    <span>
                                        <?php if ($request->type_id == 1) { ?>
                                            ShuleSoft Limited to provide ShuleSoft Services to the client which is integrated with CRDB <br>
                                            Bank System to accept Electronic Payments via CRDB Bank channels</span>
                                    <?php } ?>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row" id="validate">
                    <!-- <div class="col-sm-6">
                    <?php /* if ((int) $request->shulesoft_approved == 1) { ?>
                      <a href="<?= url('Partner/InvoicePrefix/' . $request->id) ?>" style="float: left;" class="btn btn-success">Shulesoft Validate This Application</a>
                      <?php } */ ?>
                    </div> -->

                    <div class="col-sm-6 text-right">
                        <?php if ((int) $request->bank_approved <> 1 && $request->type_id == 4) { ?>
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
            </div>
            <form action="<?= url('Partner/RequestComment') ?>" class="form-card" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <div class="row">
                            <?php
                            $i = 1;
                            if (sizeof($comments)) {
                                ?>
                                <div class="col-sm-12">
                                    <?php foreach ($comments as $act) { ?>
                                        <div class="media chat-messages">
                                            <a class="media-left photo-table" href="#!">
                                                <img class="media-object img-circle m-t-5" src="<?= $root ?>assets/images/avatar-1.png" alt="Image">
                                            </a>
                                            <div class="media-body chat-menu-content">
                                                <div class="">
                                                    <p class="chat-cont"><?= $act->comment ?><br>
                                                        <b>By</b> - <?= $act->user->name ?>   &nbsp; &nbsp; &nbsp; &nbsp;
                                                        <b>On</b> - <?= timeAgo($act->created_at) ?>   &nbsp; &nbsp; &nbsp; &nbsp;
                                                        <b>Status</b> - <?= ucfirst($act->status) ?>   &nbsp; &nbsp; &nbsp; &nbsp;
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="col-md-12">
                                <strong> Select Comment Status</strong>
                                <input type="hidden" name="integration_request_id" value="<?= $request->id ?>"  class="form-control">
                                <input type="hidden" name="user_id" value="<?= Auth::user()->id ?>"  class="form-control">
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

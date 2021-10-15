@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>

<div class="main-body">
    <div class="page-wrapper">
      <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

        <div class="page-body">
            <div class="row">
                <?php
                if (sizeof($schools) > 0) {
                    ?>
                    <div class="col-lg-12">
                            <div class="row">

                                    <div class="col-md-12 col-xl-4">
                                          <x-smallCard title="Private Schools"
                                            :value="count($schools)"
                                            icon="feather icon-book f-50 text-c-red"
                                            cardcolor="bg-c-pink text-white"
                                            >
                                         </x-smallCard>
                                    </div>

                                    <div class="col-md-12 col-xl-4">
                                           <?php $value = count($schools)*407*10000; ?>
                                          <x-smallCard title="Estimated Value"
                                            :value="$value"
                                            icon="feather icon-book f-50 text-c-red"
                                            cardcolor="bg-c-green text-white"
                                            >
                                         </x-smallCard>
                                    </div>

                                    <div class="col-md-12 col-xl-4">
                                           <?php $value_ = sizeof($schools)*407*10000*0.03 + sizeof($schools)*100000; ?>
                                          <x-smallCard title="Your Revenue Estimate"
                                            :value="$value_"
                                            icon="feather icon-book f-50 text-c-red"
                                            cardcolor="bg-c-blue text-white"
                                            >
                                         </x-smallCard>
                                    </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>

            </div>


            <!-- Monthly Growth Chart start-->
            <div class="row" id="schools">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header row">
                         <div class="col-sm-8">
                            <h5>List of Schools Under &nbsp;&nbsp;ShuleSoft </h5>
                         </div>
                   

                          {{-- <div class="col-sm-4">
                            <?php if (Auth::user()->role_id == 1) { ?>
                                <span style="float: right2">
                                    <select class="form-control select2" style="width:200px;" id='taskdate'>
                                        <option></option>
                                        <?php foreach ($users as $user) { ?>
                                            <option value="<?= $user->id ?>" <?= (int) request('user_id') > 0 && request('user_id') == $user->id ? 'selected' : '' ?>><?= $user->firstname . ' ' . $user->lastname ?></option>
                                        <?php } ?>
                                    </select>
                                </span>
                            <?php } ?>
                        </div> --}}
                     </div>
                        
                        <div class="card-block">
                             <div class="table-responsive dt-responsive">
                                 <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School Name</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>School Link</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php 
                                        $i = 1;
                                           if(count($schools) > 0) {
                                            foreach ($schools as $school) {
                                            ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= warp($school->client->name,20) ?></td>
                                                <td><?= warp($school->client->address,20) ?></td>
                                                <td><?= $school->client->phone ?></td>
                                                <td>
                                                    <a href="https://<?=$school->client->username?>.shulesoft.com/" target="_blank" rel="noopener noreferrer"><?=warp($school->client->name,20)?></a>
                                                </td>
                                               
                                                <?php
                                                 echo '<td>';
                                                 echo '<a href="' . url('customer/profile/' . $school->client->username) . '" class="btn btn-success btn-sm"> View</a>';
                                                 echo '</td>';
                                                 echo '</tr>';
                                                  }
                                                }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (count($schools) > 0) { ?>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Weekly Schools Logs Activities</h5>

                            </div>
                            <div class="card-block">
                                <?php
                                //echo $insight->createChartBySql($logs, 'schema_name', ' Schools Activities ', 'bar', false);
                                ?>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>



        <div class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="sendMessage">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">
                            Send Message To  <?= number_to_words(count($schools)) ?> Clients
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="<?= url('analyse/sendMessage') ?>" method="POST">
                        <div class="modal-body">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Select Language:</strong>
                                    <select name="lang"  class="form-control">
                                        <option value="swahili">Kiswahili</option>
                                        <option value="english">English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Add Details About This Message:</strong>
                                    <textarea name="message" rows="6" placeholder="Write Your Message.." class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>  Select Mode of this Message Below.</strong> 
                                    <hr>
                                    &nbsp;  &nbsp; &nbsp;<input type="checkbox" name="sms" value='1'>  Send SMS  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;
                                    <input type="checkbox" name="email" value="1" >  Send Email 

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary waves-effect waves-light ">  Send <i class="ti-telegram"> </i></button>
                        </div>
                        <?= csrf_field() ?>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>


<script type="text/javascript">

    $(".select2").select2({
        theme: "bootstrap",
        dropdownAutoWidth: false,
        allowClear: false,
        debug: true
    });
    
    $('#taskdate').change(function (event) {
        var taskdate = $(this).val();
        if (taskdate === '') {
        } else {
            window.location.href = '<?= url('Analyse/myschools') ?>/' + taskdate;
        }
    });

    allocate = function () {
        $('.allocate').change(function () {
            var user_id = $('option:selected', this).attr('user_id');
            var school_id = $('option:selected', this).attr('school_id');
            var role_id = $('option:selected', this).attr('role_id');
            var schema = $('option:selected', this).attr('schema');
            var val = $(this).val();
            $.ajax({
                type: 'post',
                url: '<?= url('customer/allocate') ?>',
                data: {
                    user_id: user_id,
                    school_id: school_id,
                    role_id: role_id,
                    schema: schema,
                    val: val
                },
                dataType: 'html',
                success: function (data) {
                    /// alert('success',data);
                    $('#status_result_' + role_id + '_' + schema).html('<b class="label label-success">success</b>');

                }
            });
        });
    }
    $(document).ready(allocate);

</script>


@endsection

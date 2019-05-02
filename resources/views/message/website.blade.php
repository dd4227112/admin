@extends('layouts.app')
@section('content')

<div class="sttabs tabs-style-iconbox">
    <nav>
        <ul>
            <li class="tab-current"><a href="#section-iconbox-1" class="sticon ti-home"><span>Joining Requests</span></a></li>
            <li><a href="#section-iconbox-2" class="sticon ti-gift"><span>Demo Requests</span></a></li>
            <li><a href="#section-iconbox-3" class="sticon ti-upload"><span>Contact Us Requests</span></a></li>
        </ul>
    </nav>
    <div class="content-wrap">
        <section id="section-iconbox-1" class="content-current">
            <h3>ShuleSoft Joining Requests</h3>
            <div class="table-responsive"> 
                <table id="example23" class="display nowrap table color-table success-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>School name</th>
                            <th>Registration number</th>
                            <th>Address</th>
                            <th>Number of Students</th>
                            <th>Message</th>
                            <th>Contact Name</th>
                            <th>Contact Phone</th>
                            <th>Contact Email</th>
                            <th>Date Registered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $join_requests = \DB::table('website_join_shulesoft')->orderBy('id', 'desc')->get();
                        $i = 1;
                        foreach ($join_requests as $key => $request) {
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $request->school_name ?></td>
                                <td><?= $request->school_registration_number ?></td>
                                <td><?= $request->school_address ?></td>
                                <td><?= $request->students_number ?></td>
                                <td><?= $request->message ?></td>
                                <td><?= $request->contact_name ?></td>
                                <td><?= $request->contact_phone ?></td>
                                <td><?= $request->contact_email ?></td>
                                <td><?= date('d M Y h:m:i', strtotime($request->created_at)) ?></td>
                                    <td>
                                        <!--<a class="btn btn-success">Attend</a>-->
                                    </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section id="section-iconbox-2">
           <h3>ShuleSoft Demo Requests</h3>
            <div class="table-responsive"> 
                <table id="example23" class="display nowrap table color-table success-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>School name</th>
                            <th>Registration number</th>
                            <th>Address</th>
                            <th>Message</th>
                            <th>Contact Name</th>
                            <th>Contact Phone</th>
                            <th>Contact Email</th>
                            <th>Date Registered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $demo_requests = \DB::table('website_demo_requests')->orderBy('id', 'desc')->get();
                        $i = 1;
                        foreach ($demo_requests as $key => $request) {
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $request->school_name ?></td>
                                <td><?= $request->school_registration_number ?></td>
                                <td><?= $request->school_location ?></td>
                                <td><?= $request->message ?></td>
                                <td><?= $request->contact_name ?></td>
                                <td><?= $request->contact_phone ?></td>
                                <td><?= $request->contact_email ?></td>
                                <td><?= date('d M Y h:m:i', strtotime($request->created_at)) ?></td>
                                    <td>
                                        <!--<a class="btn btn-success">Attend</a>-->
                                    </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section id="section-iconbox-3">
           <h3>Contact Us Requests</h3>
            <div class="table-responsive"> 
                <table id="example23" class="display nowrap table color-table success-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date Registered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contact_us_requests = \DB::table('website_contact_us')->orderBy('id', 'desc')->get();
                        $i = 1;
                        foreach ($contact_us_requests as $key => $request) {
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $request->name ?></td>
                                <td><?= $request->phone ?></td>
                                <td><?= $request->email ?></td>
                                <td><?= $request->message ?></td>
                                <td><?= date('d M Y h:m:i', strtotime($request->created_at)) ?></td>
                                    <td>
                                        <!--<a class="btn btn-success">Attend</a>-->
                                    </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
<?php $root = url('/') . '/public/' ?>
<script src="<?= $root ?>js/waves.js"></script>
<script src="<?= $root ?>js/cbpFWTabs.js"></script>
<script type="text/javascript">
    (function () {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });
    })();
</script>
@include('layouts.datatable')
@endsection

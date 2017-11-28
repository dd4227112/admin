@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<link href="<?= $root ?>plugins/bower_components/jquery-wizard-master/css/wizard.css" rel="stylesheet">

<!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">How to Market ShuleSoft</h3>
            <p class="text-muted m-b-30 font-13"> For effective marketing, you need to know exactly what problems face these schools and what shulesoft can offer to solve those problems. Each school has specific problem, so its important to do a rough research before you start to market</p>
            <div id="exampleBasic" class="wizard">
                <ul class="wizard-steps" role="tablist">
                    <li class="active current" role="tab" aria-expanded="true">
                        <h4><span>1</span>Introduction</h4> </li>
                    <li role="tab" class="disabled" aria-expanded="false">
                        <h4><span>2</span>Step</h4> </li>
                    <li role="tab" class="disabled" aria-expanded="false">
                        <h4><span>3</span>Step</h4> </li>
                </ul>
                <div class="wizard-content">
                    <div class="wizard-pane active" role="tabpanel" aria-expanded="true">

                        <blockquote>  <h3>Our Vision</h3>
                            <p>To be a platform that promotes education growth through interconnect all stakeholders involved in education.</p>
                        </blockquote>
                        <blockquote>  <h3>Our Mission</h3>
                            <p>To connect schools and colleges with ShuleSoft system and enable digitization of education sector in Tanzania.</p>
                        </blockquote>
                        <blockquote>
                            <h3 class="box-title">Problem Statement</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th> Current Scenario</th>
                                            <th> What ShuleSoft do</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Information organization</th>
                                            <td>
                                                <div>
                                                    <p>School informations are in physical documents (files). Each student information, employee's information,past paper, academic records, etc are in specific file(s). Some schools have some information in one software (eg accounting package), other information in excel, other in certain computer etc.</p>
                                                    <h3 class="box-title">Problems</h3>
                                                    <ul class="list-icons">
                                                        <li><i class="ti-angle-right"></i> Difficult to find information on time</li>
                                                        <li><i class="ti-angle-right"></i> High cost to store information and high cost in maintenance of records</li>
                                                        <li><i class="ti-angle-right"></i> Difficult to Manage information (add, edit, delete, maintain access and permissions (restict some users to view certain records) etc)</li>
                                                        <li><i class="ti-angle-right"></i> High risk to rodents and natural calamities like Fire, Water etc </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <p>ShuleSoft allow school to store all school information in the system. This includes all student records, employee's records, library information, etc . Information are secure stored online in cloud servers (distributed servers). All school information are in centralized one system.</p>
                                                    <h3 class="box-title">Solution Offered</h3>
                                                    <ul class="list-icons">
                                                        <li><i class="ti-angle-right"></i> Any school information can be found very easy and on time</li>
                                                        <li><i class="ti-angle-right"></i> No costs for buying files and additional papers for keeping records</li>
                                                        <li><i class="ti-angle-right"></i> Records can be easily viewed, edited, deleted. Only authorized users will be able to manage certain information as specified by school administrator (headmaster, director etc)</li>
                                                        <li><i class="ti-angle-right"></i> No risk of any information loss either by natural calamities or other conditions </li>
                                                    </ul>
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>Exams</th>
                                            <td><div>
                                                    <p>School Academic master, school secretary or IT People are always involved in preparation of reports. In other schools, all teachers are involved in preparation of reports. Without software, teachers needs to prepare mark sheet and submit to academic master. Academic master will then sum up marks for each student and prepare a consolidated sheet which contains total marks, avarage and ranking, (divisions and points are included in some exams in specific classes)</p>
                                                    <h3 class="box-title">Problem</h3>
                                                    <ul class="list-icons">
                                                        <li><i class="ti-angle-right"></i> The process takes long time to be accomplished </li>
                                                        <li><i class="ti-angle-right"></i> After creating consolidated sheets, teachers/secretary have to fill information in report cards and sign on each report</li>
                                                        <li><i class="ti-angle-right"></i> Process is complex and can easily results in errors in calculations</li>
                                                        <li><i class="ti-angle-right"></i> Difficult to change ranks and positions especially when certain marks appeared to be incorrect</li>
                                                    </ul>
                                                </div></td>
                                            <td><div>
                                                    <p>ShuleSoft allow school to store all school information in the system. This includes all student records, employee's records, library information, etc . Information are secure stored online in cloud servers (distributed servers). All school information are in centralized one system.</p>
                                                    <h3 class="box-title">Solution Offered</h3>
                                                    <ul class="list-icons">
                                                        <li><i class="ti-angle-right"></i> Any school information can be found very easy and on time</li>
                                                        <li><i class="ti-angle-right"></i> No costs for buying files and additional papers for keeping records</li>
                                                        <li><i class="ti-angle-right"></i> Records can be easily viewed, edited, deleted. Only authorized users will be able to manage certain information as specified by school administrator (headmaster, director etc)</li>
                                                        <li><i class="ti-angle-right"></i> No risk of any information loss either by natural calamities or other conditions </li>
                                                    </ul>
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>Communication</th>
                                            <td><code>.col-xs-</code> </td>
                                            <td><code>.col-sm-</code> </td>

                                        </tr>
                                        <tr>
                                            <th>School Accounting</th>
                                            <td><code>.col-xs-</code> </td>
                                            <td><code>.col-sm-</code> </td>
                                        </tr>
                                        <tr>
                                            <th>Reporting</th>
                                            <td><code>.col-xs-</code> </td>
                                            <td><code>.col-sm-</code> </td>

                                        </tr>
                                        <tr>
                                            <th>Academic Materials</th>
                                            <td><code>.col-xs-</code> </td>
                                            <td><code>.col-sm-</code> </td>

                                        </tr>
                                        <tr>
                                            <th>Monitoring and Evaluation</th>
                                            <td><code>.col-xs-</code> </td>
                                            <td><code>.col-sm-</code> </td>

                                        </tr>
                                        <tr>
                                            <th>Summary</th>
                                            <td colspan="2">Yes</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </blockquote>
                    </div>
                    <div class="wizard-pane" role="tabpanel" aria-expanded="false">
                        step 2
                    </div>
                    <div class="wizard-pane" role="tabpanel" aria-expanded="false">
                        step 3
                    </div>
                </div>
                <div class="wizard-buttons">
                    <a class="wizard-back disabled" href="#exampleBasic" data-wizard="back" role="button">Back</a>
                    <a class="wizard-next" href="#exampleBasic" data-wizard="next" role="button">Next</a>
                    <a class="wizard-finish hide" href="#exampleBasic" data-wizard="finish" role="button">Finish</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
@include('layouts.datatable')
<script src="<?= $root ?>plugins/bower_components/jquery-wizard-master/dist/jquery-wizard.min.js"></script>

<script type="text/javascript">
    wizard = function () {
        $('#exampleBasic').wizard({
            onFinish: function () {
                alert("Message Finish!");
            }
        });
    };
    $(document).ready(wizard);
</script>
<!--Style Switcher -->
<script src="<?= $root ?>plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
@endsection

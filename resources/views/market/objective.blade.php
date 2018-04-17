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
                        <h4><span>2</span>Negotiation</h4> </li>
                    <li role="tab" class="disabled" aria-expanded="false">
                        <h4><span>3</span>Closing and Support</h4> </li>
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
                                                        <li><i class="ti-angle-right"></i> Difficult to generate different statistics and reports necessary for evaluation and management </li>
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
                                                        <li><i class="ti-angle-right"></i>To generate annual reports (that combines multiple exams) and statistics associated like teachers performance, student performance trends, class performances, subject performance is difficult and in most schools is not practical </li>
                                                    </ul>
                                                </div></td>
                                            <td><div>
                                                    <p>ShuleSoft allow each teacher (on secretary) to only enter marks for each student in a certain exam. Once marks are entered in ShuleSoft, System will generate all reports required by schools including consolidated sheets, ranking, division, grading, averages, etc. Teachers will not touch any report as reports will be automatic generated with all signature in place. Class teachers may write comments (character assessment) in the system and each report may also go with specific comment. For more information, download product profile</p>
                                                    <h3 class="box-title">Solution Offered by Exam Management Module</h3>
                                                    <ul class="list-icons">
                                                        <li><i class="ti-angle-right"></i> Generate consolidated sheets (mkeka) with avarages, ranks, division , points etc automatically after entering marks per exam and per subject</li>
                                                        <li><i class="ti-angle-right"></i> Generate student report cards automatically</li>
                                                        <li><i class="ti-angle-right"></i>Generate performance summary. This include subject performance, class averages, grading, number of divisions, etc</li>
                                                        <li><i class="ti-angle-right"></i>Generate accumulative reports that combines multiple exams with ranks, grading, student report cards, performance summary etc </li>
                                                        <li><i class="ti-angle-right"></i>Generate graphical reports to show teachers performance, student performance and exam performance </li>
                                                        <li><i class="ti-angle-right"></i> Reports once generated, each parent will receive SMS notification in their normal phone informing about his/her child performance. SMS format says "Hello PARENT_NAME, mtoto wako CHILD NAME amekua wa 3 kati ya wanafunzi 43 kwenye mtihani wa EXAMNAME. kwa taarifa zaidi, ingia ....."</li>
                                                        <li><i class="ti-angle-right"></i>Parents can also login in the system at anytime to view their child exam reports. In this case, school can decide not to print any report and parent can view a report once login in their smartphones </li>
                                                        <li><i class="ti-angle-right"></i>School can limit parents who have not paid school fees, to view exam reports once they login </li>
                                                        <li><i class="ti-angle-right"></i> Reports once generated, they remains in the system, teacher cannot modify any mark unless by Admin permission. Reports remains in the system all years for school evaluation and performance management </li>
                                                    </ul>
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>Communication</th>
                                            <td><div>
                                                    <p>School always want to communicate with parents, teachers and even other staff members. Most schools only send SMS to parents for payment reminders only. In rare cases, they also send SMS to inform parents about meetings, or special events like graduation etc. <br/>
                                                        Once they want to send SMS, these schools have list of parents phone numbers, and they just give that task to secretary, or IT person or headmaster, then, they start to type one number to another and send SMS to each parent. <br/>
                                                        In another cases, they just store those numbers in their phones with groups, then they start to send SMS one by one or by group. <br/>
                                                        In another case, they opt to use Bulk SMS software where they upload parents phone numbers and send SMS to those parents. These services are not for FREE and they usually get charged per SMS. Minimum market price is Tsh 20 per SMS (with 160 characters) but the price range from Tsh 20 to Tsh 50 per one SMS (160 characters). </p>
                                                    <h3 class="box-title">Problem</h3>
                                                    <ul class="list-icons">
                                                        <li><i class="ti-angle-right"></i> Troublesome. It takes a long time to accomplish the task</li>
                                                        <li><i class="ti-angle-right"></i> Filtering is difficult especially if  you want to send SMS to certain class only, or parents who have not paid their school fee, etc . It takes a long time to accomplish the task</li>
                                                        <li><i class="ti-angle-right"></i> Communication is only done in emergence and does not really create a sense of community</li>
                                                    </ul>
                                                </div>

                                            </td>
                                            <td><div>
                                                    <p>ShuleSoft comes with SMS and Email communication integrated with all modules available in the system <br/>
                                                        Since all users are registered with their information including phone numbers, emails, associated classes and streams( for students), gender, location, account reports (see account module), transport, hostel, library , exam performance etc, then school can decide to send customized SMS or Email to specific group of people. <br/>
                                                        In this cases, they just store those numbers in their phones with groups, then they start to send SMS one by one or by group. <br/>
                                                        In another case, they opt to use Bulk SMS software where they upload parents phone numbers and send SMS to those parents. These services are not for FREE and they usually get charged per SMS. Minimum market price is Tsh 20 per SMS (with 160 characters) but the price range from Tsh 20 to Tsh 50 per one SMS (160 characters). </p>
                                                    <h3 class="box-title">SOLUTION OFFERED </h3>
                                                    <ul class="list-icons">
                                                        <li><i class="ti-angle-right"></i> School can send SMS per class, section, gender, location, payment balances etc. Each message is custom to specific person. Ex. Hello PARENT_NAME, .....</li>
                                                        <li><i class="ti-angle-right"></i> ShuleSoft send automatic notification to parents, teachers and staff members for event type messages. Once you upload school calender in the system, then THREE days before the event, ShuleSoft will send SMS and Email notification to respective group affected by such event</li>
                                                        <li><i class="ti-angle-right"></i>With ShuleSoft you can opt to send SMS to parents with pending payments. Each message sent will pick amount required to be paid by that parent. This message can also be sent automatically to remind parents to make payment when installment is close to the due date</li>
                                                        <li><i class="ti-angle-right"></i>With ShuleSoft, SMS is FREE, school don't pay anything more to send unlimited no of SMS</li>                        
                                                    </ul>
                                                </div></td>

                                        </tr>
                                        <tr>
                                            <th>School Accounting</th>
                                            <td><div>
                                                    <p>The school accountant or any appointed teacher will prepare all the account related issues., this includes:</p>
                                                    <ul class="list-icons">
                                                        <li><i class="ti-angle-right"></i>
                                                            Prepare all the signed invoices that a student is supposed to pay
                                                        <li><i class="ti-angle-right"></i>   Print and sign receipts for the  transactions made for particular fee</li>
                                                        <li><i class="ti-angle-right"></i>  Make calculations to know the paid and the unpaid amount for every student</li>
                                                        <li><i class="ti-angle-right"></i>  Write all the daily expenses on a paper form or excel and later calculate the SUM </li>
                                                        <li><i class="ti-angle-right"></i>  No preparation of the income statement and balance sheet (No cash flow analysis)</li>
                                                        <li><i class="ti-angle-right"></i>  Manual reconciliation with banks</li>
                                                        <li><i class="ti-angle-right"></i>  Manual preparation of the payroll</li>

                                                        <h3 class="box-title">PROBLEMS</h3>
                                                        <ul class="list-icons">
                                                            <li><i class="ti-angle-right"></i>  Inaccurate records of fees being paid are recorded on papers and the receipts for payment are also on paper base
                                                            </li> <li><i class="ti-angle-right"></i>  The invoices for student’s parents are manually generated and signed one by one or orally communicated
                                                            </li> <li><i class="ti-angle-right"></i>    Difficult tracing of the amount to be collected,amount collected and amount remaining 
                                                            </li> <li><i class="ti-angle-right"></i>   Time consuming due to long and many processes involved
                                                            </li> <li><i class="ti-angle-right"></i>   Erroneous report generation since statementthey involve  manually processed data 
                                                            </li> <li><i class="ti-angle-right"></i>   Complex and time consuming preparation of the salary for the school staff users</li>
                                                        </ul>
                                                </div>

                                            </td>
                                            <td><div>
                                                    <p>ShuleSoft system </p>
                                                    <div>
                                                        <ul class="list-icons">
                                                            <li><i class="ti-angle-right"></i>   generates all the invoices for all registered students
                                                            </li> <li><i class="ti-angle-right"></i> Generates automatic receipts when payment is made
                                                            </li> <li><i class="ti-angle-right"></i> Shulesoft system generates accurate payment statistics like amount paid, unpaid,expenses etc.

                                                            </li> <li><i class="ti-angle-right"></i> Shulesoft system  allows parents to see the payment plans for their child right in the system, allows parent can make payment through  payment channels connected in the system 


                                                            </li> <li><i class="ti-angle-right"></i>  Shulesoft system helps account create and see salary report</li>
                                                    </div>
                                                    <h3 class="box-title"> SOLUTION OFFERED</h3>

                                                    <ul class="list-icons">
                                                        <li><i class="ti-angle-right"></i>   Save time in preparing the invoices and receipts  for students
                                                        </li> <li><i class="ti-angle-right"></i>  Monitoring  and tracking of the school expenses
                                                        </li> <li><i class="ti-angle-right"></i>  Easy retrieval of the student payment details
                                                        </li> <li><i class="ti-angle-right"></i>  Generation of the important account reports like income ,Balance sheet etc.
                                                        </li> <li><i class="ti-angle-right"></i>   Easy and timed preparation of the payroll for school user staff </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Monitoring and Evaluation</th>
                                            <td><p>Currently it’s need your physical presence at the school in order to monitor and control School Staff and some activities at the school, which it’s difficult to do so if you’re not at the school</p>

                                                <p>      Challenge on analysing teachers’ performance at the schools, it’s very hard to collect, evaluate and produce results for  those information collected by papers</p> 
                                            </td>
                                            <td>
                                                <p>By using ShuleSoft you can monitor School staff wherever you are, by checking their activities performed electronically. </p>


                                                <p>  ShuleSoft simplify means of evaluating teachers performance by using subjects’ performance charts per specified subject teacher. To view teachers’ attendance on daily weekly or monthly basis</p>
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </blockquote>
                    </div>
                    <div class="wizard-pane" role="tabpanel" aria-expanded="false">
                        <div>
                            <h3>Basics</h3>
                            <p>To perform negotiation with a school, needs a proper consideration in different groups available in school.Each group in a school have different motivation and hence you should negotiate with each group based on their interest</p>
                            <p>The following are groups available in School and how you should negotiate with each one</p>
                            <div>

                                <h3 class="box-title">School Owner : Main interest</h3>
                                <p>These is what you will focus</p>
                                <ul class="list-icons">
                                    <li>Account Module: Explain how system will help him to track revenue and expenses in account module. System generate account reports (income statement, balance sheet, cash flow statements) on fly without a need to request those reports from Accountant. Manager/owner can login in his mobile phone or computer at any time and view account reports with daily transactions. </li>
                                    <li>Exam Module: Explain how system will help him to track employee performance (teachers evaluation based on exams done), exam class evaluation, subject evaluation etc which will help him to take quick action on where to improve</li>
                                     <li>Communication Module: Explain how communication will help him to get students in school, to help parents to pay fee on time, to share information easily with parents, to improve customer satisfaction which in turn will add more school reputation.</li>
                      
                                </ul>
                            </div>
                              <div>

                                <h3 class="box-title">Academic Master : Main interest</h3>
                                <p>These is what you will focus</p>
                                <ul class="list-icons">
                                 
                                    <li>Exam Module: Explain how system will help him to generate exam reports, ranking, grading, student report cards, digital signature, divisions, class performance, subject performance, graphical reports. <br/> Also explain how system will reduce the time taken to prepare reports for up to one day or few hours after all teachers upload marks in the system</li>
                                     <li>Communication Module: Explain how communication will help school to improve performance. Since each parent will get exam report in their mobile phone, and parents can login to view reports, parents can easily monitor their child performance which in turn will push their child to study more and hence improve performance.</li>
                      
                                </ul>
                            </div>
                                   <div>

                                <h3 class="box-title">Accountant : Main interest</h3>
                                <p>These is what you will focus</p>
                                <ul class="list-icons">
                                 
                                  <li>Account Module: Explain how system will help him to create invoices in simple steps, track student balances, automate SMS to remind parents, record revenue and expenses, add  track revenue and expenses in account module. System generate account reports (income statement, balance sheet, cash flow statements) on fly without a need to request those reports from Accountant. Manager/owner can login in his mobile phone or computer at any time and view account reports with daily transactions. </li>
                      
                                </ul>
                            </div>
                        </div>
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


<?php
// /**
//  * select distinct &quot;schema_name&quot; from admin.all_student where extract (year from
//   created_at)=&#39;2019&#39; order by &quot;schema_name&quot; -to get the schools that have recorded
//   students this year.
//   ● select distinct &quot;schema_name&quot; from admin.all_marks where extract (year from
//   created_at)=&#39;2019&#39; -to get the schools that have recorded marks in the system.
//   ● select distinct &quot;schema_name&quot; from admin.all_invoices where extract (year from
//   created_at)=&#39;2019&#39; -to get the schools that have created invoices in the system.
//   ● select distinct &quot;schema_name&quot; from admin.all_bank_accounts_integrations where
//   extract (year from created_at)=&#39;2019&#39; -to get the schools that have been integrated
//   with NMB.
//   ● select distinct &quot;schema_name&quot; from admin.all_payments where extract (year from
//   created_at)=&#39;2019&#39; -to get the schools that have recorded payments.
//   ● select distinct &quot;schema_name&quot; from admin.all_payments where extract (year from
//   created_at)=&#39;2019&#39; and &quot;token&quot; is not null -to get the schools that have recorded
//   payments electronically.
//   ● select distinct &quot;schema_name&quot; from admin.all_expense where extract (year from
//   created_at)=&#39;2019&#39; -to
//  */

$month = request()->segment(3);
$year = request()->segment(4);
$where = (int) $month > 0 && (int) $year > 0 ? ' WHERE extract(year from created_at)>=' . $year . ' AND extract(month from created_at) >=' . $month : '';
$marks = DB::select('select distinct "schema_name", max(created_at) as created_at from admin.all_mark ' . $where . ' group by schema_name');
$mark_status = [];
foreach ($marks as $mark) {
    $mark_status[$mark->schema_name] = $mark->created_at;
}


$exam_reports = DB::select('select distinct "schema_name", max(created_at) as created_at from admin.all_exam_report  ' . $where . '  group by schema_name');
$exam_report_status = [];
foreach ($exam_reports as $report) {
    $exam_report_status[$report->schema_name] = $report->created_at;
}


$smsstatus = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_sms ' . $where . '   group by schema_name');
$sms_status = [];
$sms_status_count = [];
foreach ($smsstatus as $smss) {
    $sms_status[$smss->schema_name] = $smss->created_at;
    $sms_status_count[$smss->schema_name] = $smss->count;
}


$expenses = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_expense   ' . $where . '  group by schema_name');
$expense_status = [];
$expense_status_count = [];
foreach ($expenses as $expense) {
    $expense_status[$expense->schema_name] = $expense->created_at;
    $expense_status_count[$expense->schema_name] = $expense->count;
}

$payments = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_payments  ' . $where . '  group by schema_name');
$payment_status = [];
$payment_count = [];
foreach ($payments as $payment) {
    $payment_status[$payment->schema_name] = $payment->created_at;
    $payment_count[$payment->schema_name] = $payment->count;
}


$payroll = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_salaries ' . $where . '   group by schema_name');
$payroll_status = [];
$payroll_status_count = [];
foreach ($payroll as $pay) {
    $payroll_status[$pay->schema_name] = $pay->created_at;
    $payroll_status_count[$pay->schema_name] = $pay->count;
}


$inventories = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_product_alert_quantity ' . $where . '   group by schema_name');
$inventory_status = [];
$inventory_status_count = [];
foreach ($inventories as $inventory) {
    $inventory_status[$inventory->schema_name] = $inventory->created_at;
    $inventory_status_count[$inventory->schema_name] = $inventory->count;
}


$tmembers = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_tmembers ' . $where . '   group by schema_name');
$tmember_status = [];
$tmember_status_count = [];
foreach ($tmembers as $tmember) {
    $tmember_status[$tmember->schema_name] = $tmember->created_at;
    $tmember_status_count[$tmember->schema_name] = $tmember->count;
}


$hmembers = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_hmembers ' . $where . '   group by schema_name');
$hmember_status = [];
$hmember_status_count = [];
foreach ($hmembers as $hmember) {
    $hmember_status[$hmember->schema_name] = $hmember->created_at;
    $hmember_status_count[$hmember->schema_name] = $hmember->count;
}


$sattendances = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_sattendances ' . $where . '   group by schema_name');
$sattendance_status = [];
$sattendance_status_count = [];
foreach ($sattendances as $sattendance) {
    $sattendance_status[$sattendance->schema_name] = $sattendance->created_at;
    $sattendance_status_count[$sattendance->schema_name] = $sattendance->count;
}


$characters = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_general_character_assessment ' . $where . '   group by schema_name');
$character_status = [];
$character_status_count = [];
foreach ($characters as $character) {
    $character_status[$character->schema_name] = $character->created_at;
    $character_status_count[$character->schema_name] = $character->count;
}


// $parents = DB::select('select distinct "schema_name",  count(distinct user_id) as count,  extract(month from created_at) as created_at from admin.all_login_locations a ' . $where . ' and "table"=\'parent\'   group by schema_name,extract(month from created_at)  having count(distinct user_id)>(select count(*)*0.2 from admin.all_parent where "schema_name"=a."schema_name" and status=1)');
// $parent_status = [];
// $parent_status_count = [];
// foreach ($parents as $parent) {
//     $character_status[$parent->schema_name] = $parent->created_at;
//     $character_status_count[$parent->schema_name] = $parent->count;
// }

// $login_staffs = DB::select('select distinct "schema_name",  count(distinct user_id) as count,  extract(month from created_at) as created_at from admin.all_login_locations a ' . $where . ' and "table" in (\'user\',\'teacher\' )  group by schema_name ,extract(month from created_at)  having count(distinct user_id)>(select count(*)*0.2 from admin.all_users where "table" in (\'user\',\'teacher\') and "schema_name"=a."schema_name" and status=1)');
// $staff_status = [];
// $staff_status_count = [];
// foreach ($login_staffs as $staff) {
//     $staff_status[$staff->schema_name] = $staff->created_at;
//     $staff_status_count[$staff->schema_name] = $staff->count;
// }

// $login_parents = DB::select('select distinct "schema_name",  count(distinct user_id) as count,  extract(month from created_at) as created_at from admin.all_login_locations a ' . $where . ' and "table" in (\'parent\' )  group by schema_name ,extract(month from created_at)  having count(distinct user_id)>(select count(*)*0.2 from admin.all_users where "table" in (\'user\',\'teacher\') and "schema_name"=a."schema_name" and status=1)');
// $parents_status = [];
// $parents_status_count = [];
// foreach ($login_parents as $staff) {
//     $parents_status[$staff->schema_name] = $staff->created_at;
//     $parents_status_count[$staff->schema_name] = $staff->count;
// }

$epayments = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_payments ' . $where . ' and token is not null  group by schema_name');
$epayment_status = [];
$epayment_status_count = [];
foreach ($epayments as $epayment) {
    $epayment_status[$epayment->schema_name] = $epayment->created_at;
    $epayment_status_count[$epayment->schema_name] = $epayment->count;
}


$ediaries = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_diaries ' . $where . ' group by schema_name');
$ediary_status = [];
$ediary_status_count = [];
foreach ($ediaries as $ediary) {
    $ediary_status[$ediary->schema_name] = $ediary->created_at;
    $ediary_status_count[$ediary->schema_name] = $ediary->count;
}

$digitals = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_assignments ' . $where . ' group by schema_name');
$digital_status = [];
$digital_status_count = [];
foreach ($digitals as $digital) {
    $digital_status[$digital->schema_name] = $digital->created_at;
    $digital_status_count[$digital->schema_name] = $digital->count;
}


$admissions = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_admissions ' . $where . ' group by schema_name');
$admission_status = [];
$admission_status_count = [];
foreach ($admissions as $admission) {
    $admission_status[$admission->schema_name] = $admission->created_at;
    $admission_status_count[$admission->schema_name] = $admission->count;
}


$school_allocations = DB::select('select c.schema_name,c.source, c.sname,b.firstname, b.lastname from admin.user_clients a join admin.users b on b.id=a.user_id join admin.clients z on z.id=a.client_id join admin.all_setting c on c."schema_name"=z."username" where a.status=1 and c.schema_name is not null');
$allocation = [];
$users_allocation = [];
foreach ($school_allocations as $school_allocation) {
    $allocation[$school_allocation->schema_name] = $school_allocation->firstname . ' ' . $school_allocation->lastname;
}


$sources = [];
$schools_data = DB::table('admin.all_setting')->get();
foreach ($schools_data as $value) {
    $sources[$value->schema_name] = $value->source;
}

$invoice_issued = [];
$invoices_current = DB::select('select distinct "schema_name", max(date) as created_at, count(*) from admin.all_invoices  ' . $where . '  group by schema_name');
foreach ($invoices_current as $invoice_info) {    
    $invoice_issued[$invoice_info->schema_name] = $invoice_info->created_at;
    $invoice_issued_count[$invoice_info->schema_name] = $invoice_info->count;
}

function select($value, $schema, $sources) {
    return isset($sources[$schema]) && strtolower($sources[$schema]) == strtolower($value) ? 'Selected' : '';
}
?>
<div class="table-responsive dt-responsive">
    <table>
        <thead>
            <tr>
                <th>School Name</th>                                                          
                <td>Date Onboarded</td>                                                
                <td>Students</td>
                <th>Exam  Published</th>	
                <th>Fee collection</th>	
                <th>Expense</th>	
                <th>Invoice Issued</th>
                <th>SMS</th>	
                <th>Payroll</th>
                <th>Inventory</th>
                <th>Transport</th>
                <th>Hostel</th>
                <th>Attendance</th>
                <th>Library</th>
                <th>Character</th>
                <th>Parents login >20%</th>	
                <th>Staff login >20%</th>	
                <th>Electronic Payments</th> 
                <th>Diary</th>
                <th>Digital Learning</th>
                <th>Online Admission</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no_students = 0;
            $no_marks = 0;
            $no_exams_published = 0;
            $no_invoice = 0;
            $no_expense = 0;
            $no_payment = 0;
            $a = 0;
            foreach ($schools as $school) {
                $students = DB::table($school->schema_name . '.student')->where('status', 1)->count();
                ?>
                <tr>
                    <td><?= $school->schema_name ?></td>
                    <td><?=date('d M Y', strtotime($school->created_at))?>
                    </td>
                    
                    <td>
                        <?php
                        if ($students == 0) {
                            echo 0;
                            $no_students++;
                        } else {
                            echo $students;
                        }
                        ?>
                        </td>

                    <td>
                        <?php
                        //exam report published

                        if (isset($exam_report_status[$school->schema_name])) {
                            echo 'YES';
                        } else {
                            $no_exams_published++;
                            echo 'NO';
                        }
                        ?>
                    </td>
                    <td> <?php
                        //fee collection
                        if (isset($payment_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            $no_payment++;
                            echo 'NO';
                        }
                        ?></td>

                    <td> <?php
                        //expense management
                        if (isset($expense_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            $no_expense++;
                            echo 'NO';
                        }
                        ?></td>

                    <td>
                        <?php
                        //Invoice Issued STATUS
                        if (isset($invoice_issued[$school->schema_name])) {
                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?></td>
                    <td>
                        <?php
                        //SMS STATUS
                        if (isset($sms_status_count[$school->schema_name])) {
                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?></td>


                    <td> <?php
                        //PAYROLL

                        if (isset($payroll_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        //Inventory
                        if (isset($inventory_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>


                    <td>
                        <?php
                        //transport
                        if (isset($tmember_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        //Hostel
                        if (isset($hmember_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        //Attendance
                        if (isset($sattendance_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        //Library
                        if (isset($issue_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        //Character
                        if (isset($character_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            $no_invoice++;
                            echo 'NO';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        //Parents Login >50%
                        if (isset($parents_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        //Staff login >50%
                        if (isset($staff_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        //Electronic Payment
                        if (isset($epayment_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        //Diary
                        if (isset($ediary_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        //Digital Learning
                        if (isset($digital_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        //Online admission
                        if (isset($admission_status[$school->schema_name])) {

                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
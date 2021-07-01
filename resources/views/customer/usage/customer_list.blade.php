
<?php
$month = empty(request()->segment(3)) ? date('m') : request()->segment(3);
$year =  empty(request()->segment(4)) ? date('Y') : request()->segment(4);
$where = (int) $month > 0 && (int) $year > 0 ? ' WHERE extract(year from created_at)=' . $year . ' AND extract(month from created_at)=' . $month : '';

$school_locations = DB::select("select s.name,b.name as ward,d.name as district,r.name as region,c.client_id,e.username as schema_name,z.name as zone_name                
from admin.schools s join admin.wards b on s.ward_id = b.id join admin.districts as d on d.id=b.district_id
join admin.regions r on r.id=d.region_id left join admin.client_schools c on c.school_id = s.id 
left join admin.clients e on e.id=c.client_id join constant.refer_zones z on z.id = r.refer_zone_id where lower(s.ownership) <>'government'");
$regions = [];
$zones = [];
foreach ($school_locations as $school_location) {
    $regions[$school_location->schema_name] = $school_location->region;
    $zones[$school_location->schema_name] = $school_location->zone_name;
}


$invoice_issued = [];
$invoices_current = DB::select('select * from admin.invoices_sent where extract(year from created_at)=' . $year);
foreach ($invoices_current as $invoice_info) {
    $invoice_issued[$invoice_info->schema_name] = 'Due: ' . date('d M Y', strtotime('30 days', strtotime($invoice_info->date)));
}


$logins = [];
$last_logins = DB::select('select distinct "schema_name", max(created_at) as created_at from admin.all_login_locations where "table" in (\'user\',\'setting\' )  group by schema_name');
foreach ($last_logins as $last_login) {
    $logins[$last_login->schema_name] = $last_login->created_at;
}

$comment = [];
$last_comments = DB::select('select distinct a.client_id,max(c.created_at) as created_at,d.username from admin.tasks a join admin.tasks_clients b on a.client_id = b.client_id join admin.task_comments c on c.task_id = a.id join admin.clients d on d.id = a.client_id group by a.client_id,d.username');
foreach ($last_comments as $last_comment) {
    $comment[$last_comment->username] = $last_comment->created_at;
}

// Modules
$epayments = DB::select('select distinct "schema_name", max(created_at) as created_at, count(*) from admin.all_payments ' . $where . ' and token is not null  group by schema_name');
$epayment_status = [];
$epayment_status_count = [];
foreach ($epayments as $epayment) {
    $epayment_status[$epayment->schema_name] = $epayment->created_at;
    $epayment_status_count[$epayment->schema_name] = $epayment->count;
}

$marks = DB::select('select distinct "schema_name", count(*)  from admin.all_mark ' . $where . ' group by schema_name,created_at');
$mark_status = [];
$mark_status_count = [];
foreach ($marks as $mark) {
    $mark_status[$mark->schema_name] = 'Marks:';
    $mark_status_count[$mark->schema_name] = 'Marks:'.$mark->count;
}

$exam_reports = DB::select('select distinct "schema_name", count(*) from admin.all_exam_report  ' . $where . '  group by schema_name');
$exam_report_status = [];
$exam_report_count = [];
foreach ($exam_reports as $report) {
    $exam_report_status[$report->schema_name] = 'Exams:';
    $exam_report_count[$report->schema_name] = 'Exams:'.$report->count;
}

$smsstatus = DB::select('select distinct "schema_name", count(*) from admin.all_sms ' . $where . '   group by schema_name');
$sms_status = [];
$sms_status_count = [];
foreach ($smsstatus as $smss) {
    $sms_status[$smss->schema_name] = 'sms';
    $sms_status_count[$smss->schema_name] = 'sms:'.$smss->count;
}

$expenses = DB::select('select distinct "schema_name", count(*) from admin.all_expense   ' . $where . '  group by schema_name');
$expense_status = [];
$expense_status_count = [];
foreach ($expenses as $expense) {
    $expense_status[$expense->schema_name] = 'expense';
    $expense_status_count[$expense->schema_name] ='expens:'. $expense->count;
}

$payments = DB::select('select distinct "schema_name", count(*) from admin.all_payments  ' . $where . '  group by schema_name');
$payment_status = [];
$payment_count = [];
foreach ($payments as $payment) {
    $payment_status[$payment->schema_name] = 'payment';
    $payment_count[$payment->schema_name] = 'payment: '.$payment->count;
}

$payroll = DB::select('select distinct "schema_name", count(*) from admin.all_salaries ' . $where . '   group by schema_name');
$payroll_status = [];
$payroll_status_count = [];
foreach ($payroll as $pay) {
    $payroll_status[$pay->schema_name] = 'payroll';
    $payroll_status_count[$pay->schema_name] =  'payroll: '.$pay->count;
}

$inventories = DB::select('select distinct "schema_name", count(*) from admin.all_product_alert_quantity ' . $where . '   group by schema_name');
$inventory_status = [];
$inventory_status_count = [];
foreach ($inventories as $inventory) {
    $inventory_status[$inventory->schema_name] = 'inventories';
    $inventory_status_count[$inventory->schema_name] = 'inventories:'.$inventory->count;
}

$tmembers = DB::select('select distinct "schema_name", count(*) from admin.all_tmembers ' . $where . '   group by schema_name');
$tmember_status = [];
$tmember_status_count = [];
foreach ($tmembers as $tmember) {
    $tmember_status[$tmember->schema_name] = 'tmembers';
    $tmember_status_count[$tmember->schema_name] = 'Transport: '.$tmember->count;
}

$hmembers = DB::select('select distinct "schema_name", count(*) from admin.all_hmembers ' . $where . '   group by schema_name');
$hmember_status = [];
$hmember_status_count = [];
foreach ($hmembers as $hmember) {
    $hmember_status[$hmember->schema_name] ='hmembers';
    $hmember_status_count[$hmember->schema_name] = 'hostel: '.$hmember->count;
}


$sattendances = DB::select('select distinct "schema_name",  count(*) from admin.all_sattendances ' . $where . '   group by schema_name');
$sattendance_status = [];
$sattendance_status_count = [];
foreach ($sattendances as $sattendance) {
    $sattendance_status[$sattendance->schema_name] = 'sattendances';
    $sattendance_status_count[$sattendance->schema_name] = 'Attendance: '.$sattendance->count;
}


$characters = DB::select('select distinct "schema_name", count(*) from admin.all_general_character_assessment ' . $where . '   group by schema_name');
$character_status = [];
$character_status_count = [];
foreach ($characters as $character) {
    $character_status[$character->schema_name] = 'characters';
    $character_status_count[$character->schema_name] = 'characters:'.$character->count;
}

$ediaries = DB::select('select distinct "schema_name", count(*) from admin.all_diaries ' . $where . ' group by schema_name');
$ediary_status = [];
$ediary_status_count = [];
foreach ($ediaries as $ediary) {
    $ediary_status[$ediary->schema_name] = 'diary';
    $ediary_status_count[$ediary->schema_name] = 'diary:'.$ediary->count;
}

$digitals = DB::select('select distinct "schema_name", count(*) from admin.all_assignments ' . $where . ' group by schema_name');
$digital_status = [];
$digital_status_count = [];
foreach ($digitals as $digital) {
    $digital_status[$digital->schema_name] = 'digital';
    $digital_status_count[$digital->schema_name] = 'digital:'.$digital->count;
}

$admissions = DB::select('select distinct "schema_name", count(*) from admin.all_admissions ' . $where . ' group by schema_name');
$admission_status = [];
$admission_status_count = [];
foreach ($admissions as $admission) {
    $admission_status[$admission->schema_name] = 'admission';
    $admission_status_count[$admission->schema_name] = 'admission:'.$admission->count;
}

$invoices = DB::select('select distinct "schema_name", count(*) from admin.all_invoices ' . $where . ' group by schema_name');
$invoices_status = [];
$invoices_status_count = [];
foreach ($invoices as $invoice) {
    $invoices_status[$invoice->schema_name] = 'invoice';
    $invoice_status_count[$invoice->schema_name] = 'invoice:'.$invoice->count;
}


//Paid invoices
$paid = [];
$all_invoices = DB::select("select a.id,a.client_id,c.username from admin.invoices a join admin.clients c on a.client_id = c.id where a.id in (select invoice_id from admin.invoice_fees where project_id = '1') and extract(year from a.created_at)=". $year);
foreach ($all_invoices as $all_inv) {                                 
   // $paid[$all_inv->username] = $all_inv->payments()->sum('amount');
    $paid[$all_inv->username] =  \collect(DB::select('select sum(coalesce(amount,0)) from admin.payments where invoice_id=' . $all_inv->id . ''))->first();
}

?>
<div class="table-responsive dt-responsive">
    <table>
        <thead>
            <tr>
                <th>#</th>                                                          
                <th>School Name</th>                                                          
                <th>Region</th>                                                
                <th>Zone</th>
                <th>Total students</th>	
                <th>Invoiced</th>	
                <th>Paid Amount</th>
                <th>Active modules</th>
                <th>Last Login</th>
                <th>Last comment</th>
            </tr>
        </thead>
        <tbody>
            <?php $i =1;
            foreach ($customers as $customer) { 
              $students = DB::table($customer->schema_name . '.student')->where('status', 1)->count();
                ?>
                <tr>
                     <td><?= $i ?></td>

                     <td> 
                         <?php
                        if (isset($customer->schema_name)) {
                            echo warp($customer->schema_name);
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>
                     <td>
                         <?php
                        if (isset($regions[$customer->schema_name])) {
                            echo $regions[$customer->schema_name];
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                     <td>
                        <?php
                        if (isset($zones[$customer->schema_name])) {
                            echo $zones[$customer->schema_name];
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                    <td>
                         <?php
                        if ($students == 0) {
                            echo 0;
                        } else {
                            echo $students;
                        }
                        ?>
                    </td>

                    <td>
                       <?php
                        //Invoice Issued STATUS
                        if (isset($invoice_issued[$customer->schema_name])) {
                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                    </td>

                    <td>  
                         <?php
                        //Invoice paid
                        if (isset($paid[$customer->schema_name]->sum)) {
                            echo money($paid[$customer->schema_name]->sum);
                        } else {
                            echo '0';
                        }
                        ?>
                    </td>

                    <td> 
                         <?php
                        if (isset($mark_status_count[$customer->schema_name])) {
                            echo $mark_status_count[$customer->schema_name].',';
                        } 

                        if (isset($exam_report_count[$customer->schema_name])) {
                            echo $exam_report_count[$customer->schema_name].',';
                        } 

                        if (isset($sms_status_count[$customer->schema_name])) { 
                            echo $sms_status_count[$customer->schema_name].',';
                        } 

                        if (isset($expense_status_count[$customer->schema_name])) {  
                            echo $expense_status_count[$customer->schema_name].',';
                        } 

                        if (isset($payment_count[$customer->schema_name])) {  
                            echo $payment_count[$customer->schema_name].',';
                        } 

                         if (isset($payroll_status_count[$customer->schema_name])) {  
                            echo $payroll_status_count[$customer->schema_name].',';
                        } 

                        if (isset($inventory_status_count[$customer->schema_name])) {  
                            echo $inventory_status_count[$customer->schema_name].',';
                        } 

                        if (isset($tmember_status_count[$customer->schema_name])) {  
                            echo $tmember_status_count[$customer->schema_name].',';
                        } 

                         if (isset($hmember_status_count[$customer->schema_name])) {  
                            echo $hmember_status_count[$customer->schema_name].',';
                        } 

                        if (isset($sattendance_status_count[$customer->schema_name])) { 
                            echo $sattendance_status_count[$customer->schema_name].',';
                        } 

                        if (isset($character_status_count[$customer->schema_name])) { 
                            echo $character_status_count[$customer->schema_name].',';
                        } 

                         if(isset($ediary_status_count[$customer->schema_name])) { 
                            echo $ediary_status_count[$customer->schema_name].',';
                        } 

                        if(isset($digital_status_count[$customer->schema_name])) { 
                            echo $digital_status_count[$customer->schema_name].',';
                        } 

                        if(isset($admission_status_count[$customer->schema_name])) { 
                            echo $admission_status_count[$customer->schema_name].',';
                        } 

                         if(isset($invoice_status_count[$customer->schema_name])) { 
                            echo $invoice_status_count[$customer->schema_name].',';
                        } 
                        ?>

                      
                    </td>

                    <td> 
                        <?php
                        if (isset($logins[$customer->schema_name])) {
                            echo $logins[$customer->schema_name];
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                      <td> 
                        <?php
                        if (isset($comment[$customer->schema_name])) {
                            echo $comment[$customer->schema_name];
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>
                </tr>
            <?php $i++; } ?>
        </tbody>
    </table>
</div>
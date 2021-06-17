
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
$where = (int) $month > 0 && (int) $year > 0 ? ' WHERE extract(year from created_at)=' . $year . ' AND extract(month from created_at)=' . $month : '';


$transactions = DB::select('select count(*),extract(day from created_at) as day from admin.all_payments  ' . $where . ' and token is not null  group by extract(day from created_at)');
$transactions_report_status = [];

foreach ($transactions as $transaction) {
    $transactions_report_status[$transaction->day] = $transaction->count;
}

$schools = DB::select('select count(distinct "schema_name"),extract(day from created_at) as day from admin.all_payments  ' . $where . ' and token is not null  group by extract(day from created_at)');
$school_report_status = [];
foreach ($schools as $school) {
    $school_report_status[$school->day] = $school->count;
}

?>
<div class="table-responsive dt-responsive">
    <table>
        <thead>
            <tr>
                <th>KPI</th>  
                <?php
                for ($i = 1; $i <= 31; $i++) {
                    ?>
                    <th><?=$i?></th>  
                <?php } ?>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Transactions</td>
                <?php
                for ($i = 1; $i <= 31; $i++) {
                    ?>
                    <td><?= isset($transactions_report_status[$i]) ? $transactions_report_status[$i] :0?></td>  
                <?php } ?>
            </tr>
            
             <tr>
                <td>Revenue Collection</td>
                <?php
                for ($i = 1; $i <= 31; $i++) {
                    ?>
                    <td><?= isset($transactions_report_status[$i]) ? $transactions_report_status[$i]*250 :0 ?></td>  
                <?php } ?>
            </tr>
            
            
             <tr>
                <td>Active Schools</td>
                <?php
                for ($i = 1; $i <= 31; $i++) {
                    ?>
                    <td><?= isset($school_report_status[$i]) ? $school_report_status[$i] :0?></td>  
                <?php } ?>
            </tr>
            
        </tbody>
    </table>
</div>
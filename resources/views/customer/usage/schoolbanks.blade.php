
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
$marks = DB::select('select distinct "schema_name", max(created_at) as created_at from admin.all_mark ' . $where . ' group by schema_name');
$mark_status = [];
foreach ($marks as $mark) {
    $mark_status[$mark->schema_name] = $mark->created_at;
}


$sources = [];
$schools_data = DB::table('admin.all_setting')->get();
foreach ($schools_data as $value) {
    $sources[$value->schema_name] = $value->source;
}


$school_locations = DB::select("select s.name,b.name as ward,d.name as district,r.name as region,c.client_id,e.username as schema_name                 
from admin.schools s join admin.wards b on s.ward_id = b.id join admin.districts as d on d.id=b.district_id
join admin.regions r on r.id=d.region_id left join admin.client_schools c on c.school_id = s.id 
left join admin.clients e on e.id=c.client_id where lower(s.ownership) <>'government'");
$location = [];
$districts = [];
$ward = [];
foreach ($school_locations as $school_location) {
    $location[$school_location->schema_name] = $school_location->region;
    $districts[$school_location->schema_name] = $school_location->district;
    $ward[$school_location->schema_name] = $school_location->ward;
}

$bankaccounts = DB::select('select distinct A.schema_name,B.name FROM admin.all_bank_accounts A join constant.refer_banks B on A.refer_bank_id=B.id group by A.schema_name,B.name');
$banks = [];
foreach ($bankaccounts as $bankaccount) {
    $banks[$bankaccount->schema_name] = $bankaccount->name;
}

function select($value, $schema, $sources) {
    return isset($sources[$schema]) && strtolower($sources[$schema]) == strtolower($value) ? 'Selected' : '';
}
?>
<div class="table-responsive dt-responsive">
    <table>
        <thead>
            <tr>
                <th>#</th>                                                          
                <th>School Name</th>                                                          
                <td>Type</td>                                                
                <td>Region</td>
                <th>District</th>	
                <th>Ward</th>	
            </tr>
        </thead>
        <tbody>
            <?php $i =1;
        
            foreach ($schools as $school) {

                $students = DB::table($school->schema_name . '.student')->where('status', 1)->count();
                ?>
                <tr>
                     <td><?= $i ?></td>

                     <td><?= $school->schema_name ?></td>

                     <td>
                         <?php
                        if (isset($banks[$school->schema_name])) {
                            echo warp($banks[$school->schema_name],20);
                        } else {

                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        if (isset($location[$school->schema_name])) {
                            echo $location[$school->schema_name];
                        } else {

                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        if (isset($districts[$school->schema_name])) {
                            echo $districts[$school->schema_name];
                        } else {

                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                    <td> 
                        <?php
                        if (isset($ward[$school->schema_name])) {
                            echo $ward[$school->schema_name];
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

<?php
$month = request()->segment(3);
$year =  empty(request()->segment(4)) ? date('Y') : request()->segment(4);
$where = (int) $month > 0 && (int) $year > 0 ? ' WHERE extract(year from created_at)=' . $year . ' AND extract(month from created_at)=' . $month : '';

$school_locations = DB::select("select s.name,b.name as ward,d.name as district,r.name as region,c.client_id,e.username as schema_name,z.name as zone_name                
from admin.schools s join admin.wards b on s.ward_id = b.id join admin.districts as d on d.id=b.district_id
join admin.regions r on r.id=d.region_id left join admin.client_schools c on c.school_id = s.id 
left join admin.clients e on e.id=c.client_id join constant.refer_zones z on z.id = r.refer_zone_id where lower(s.ownership) <>'government'");
$regions = [];
$wards = [];
$zones = [];

foreach ($school_locations as $school_location) {
    $regions[$school_location->schema_name] = $school_location->region;
    $wards[$school_location->schema_name] = $school_location->ward;
    $zones[$school_location->schema_name] = $school_location->zone_name;
}

$invoice_issued = [];
$invoices_current = DB::select('select * from admin.invoices_sent where extract(year from created_at)=' . $year);
foreach ($invoices_current as $invoice_info) {
    $invoice_issued[$invoice_info->schema_name] = 'Due: ' . date('d M Y', strtotime('30 days', strtotime($invoice_info->date)));
}

$bank_integration = [];
$integrations = DB::select('select * from admin.all_bank_accounts_integrations');
foreach ($integrations as $integration) {
    $bank_integration[$integration->schema_name] = $integration->schema_name;
}

$bank_accounts = [];
$accounts_number = [];
$banks = DB::select('select * from admin.all_bank_accounts');
foreach ($banks as $bank) {
    $bank_accounts[$bank->schema_name] = $bank->branch;
    $accounts_number[$bank->schema_name] = $bank->number;
}

$logins = [];
$last_logins = DB::select('select distinct "schema_name", max(created_at) as created_at from admin.all_login_locations group by schema_name');
foreach ($last_logins as $last_login) {
    $logins[$last_login->schema_name] = $last_login->created_at;
}
?>
<div class="table-responsive dt-responsive">
    <table>
        <thead>
            <tr>
                <th>S/N</th>                                                          
                <th>School Name</th>                                                          
                <th>Region</th>                                               
                <th>Zone</th>                                               
                <th>Branch</th>	
                <th>Account No</th>	
                <th>Total students</th>
                <th>Last login</th>
                <th>Onboarding status</th>
                <th>Integrated</th>
                <th>Active Using</th>
            </tr>
        </thead>
        <tbody>
            <?php $i =1;
            foreach ($schools as $school) { 
                $students = DB::table($school->schema_name . '.student')->where('status', 1)->count();
                $school_logs = DB::table($school->schema_name . '.log')->whereDate('created_at', '>', \Carbon\Carbon::now()->subDays(30))->get();
                ?>
                <tr>
                     <td><?= $i ?></td>

                     <td> 
                        <?= $school->schema_name ?? '' ?>
                    </td>
                     <td>
                          <?php
                        if (isset($regions[$school->schema_name])) {
                            echo $regions[$school->schema_name];
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                     <td>
                          <?php
                        if (isset($zones[$school->schema_name])) {
                            echo $zones[$school->schema_name];
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        if (isset($bank_accounts[$school->schema_name])) {
                            echo $bank_accounts[$school->schema_name];
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        if (isset($accounts_number[$school->schema_name])) {
                            echo $accounts_number[$school->schema_name];
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
                        if (isset($logins[$school->schema_name])) {
                            echo date('d-m-Y',strtotime($logins[$school->schema_name]));
                        } else {
                             echo 'Undefined';
                        }
                        ?>
                    </td>

                    <td> 
                        <?php
                        if (isset($invoice_issued[$school->schema_name])) {
                            echo 'YES';
                        } else {
                             echo 'NO';
                        }
                        ?>
                    </td>

                      <td> 
                          <?php
                        if (isset($bank_integration[$school->schema_name])) {
                            echo 'YES';
                        } else {
                             echo 'NO';
                        }
                        ?>
                     </td>
                     <td> 
                         <?php
                        if (count($school_logs)) {
                            echo 'YES';
                        } else {
                             echo 'NO';
                        }
                        ?>
                    </td>
                </tr>
            <?php $i++; } ?>
        </tbody>
    </table>
</div>
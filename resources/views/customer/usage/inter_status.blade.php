
<?php
$month = request()->segment(3);
$year = request()->segment(4);
$where = (int) $month > 0 && (int) $year > 0 ? ' WHERE extract(year from created_at)=' . $year . ' AND extract(month from created_at)=' . $month : '';

$school_locations = DB::select("select s.name,b.name as ward,d.name as district,r.name as region,c.client_id,e.username as schema_name,z.name as zone_name                
from admin.schools s join admin.wards b on s.ward_id = b.id join admin.districts as d on d.id=b.district_id
join admin.regions r on r.id=d.region_id left join admin.client_schools c on c.school_id = s.id 
left join admin.clients e on e.id=c.client_id join constant.refer_zones z on z.id = r.refer_zone_id where lower(s.ownership) <>'government'");
$regions = [];
$districts = [];
$wards = [];
$zones = [];

foreach ($school_locations as $school_location) {
    $regions[$school_location->schema_name] = $school_location->region;
    $districts[$school_location->schema_name] = $school_location->district;
    $wards[$school_location->schema_name] = $school_location->ward;
    $zones[$school_location->schema_name] = $school_location->zone_name;
}

$bankbranches = DB::select('select distinct A.schema_name,A.branch,B.name as Bank_name FROM admin.all_bank_accounts A join constant.refer_banks B on A.refer_bank_id=B.id group by A.schema_name,A.branch,B.name');
$banks = [];
$branchs = [];
foreach ($bankbranches as $branch) {
    $banks[$branch->schema_name] = $branch->bank_name;
    $branchs[$branch->schema_name] = $branch->branch;
}

$contact_person = DB::select('select c.schema_name,b.firstname, b.lastname from admin.user_branches a left join admin.users b on b.id=a.user_id  join admin.partner_branches p on p.id=a.branch_id join admin.all_bank_accounts c on c."branch"=p."name"');
$contacts = [];
foreach ($contact_person as $person) {
    $contacts[$person->schema_name] = $person->firstname . ' ' . $person->lastname;
}

function select($value, $schema, $sources) {
    return isset($sources[$schema]) && strtolower($sources[$schema]) == strtolower($value) ? 'Selected' : '';
}

function acc_data($schema,$bank_account_id){
    return \collect(DB::select("SELECT a.branch,a.number as acc_number,b.bank_account_id,b.created_at as integration_date FROM  $schema.bank_accounts a join   $schema.bank_accounts_integrations b on a.id = b.bank_account_id join 
    admin.all_bank_accounts_integrations c on c.bank_account_id = b.bank_account_id where c.bank_account_id = '" . $bank_account_id . "'"))->first();
}
?>
<div class="table-responsive dt-responsive">
    <table>
        <thead>
            <tr>
                <th>S/N</th>                                                          
                <th>Account branch</th>                                                          
                <th>Zone</th>                                                
                <th>Name of school</th>
                <th>Collection Account</th>	
                <th>Integration date</th>	
            </tr>
        </thead>
        <tbody>
            <?php $i =1;
            foreach ($accounts as $account) {
                ?>
                <tr>
                     <td><?= $i ?></td>
                     <td> 
                        <?php
                        if (isset($account->bank_account_id)) { 
                            echo acc_data($account->schema_name,$account->bank_account_id)->branch;
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                     <td>
                        <?php
                        if (isset($zones[$account->schema_name])) {
                            echo $zones[$account->schema_name];
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                    <td>
                         <?php
                        if (isset($account->schema_name)) {
                            echo warp($account->schema_name);
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                     
                    </td>

                    <td>
                        <?php
                        if (isset($account->bank_account_id)) { 
                            echo acc_data($account->schema_name,$account->bank_account_id)->acc_number;
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                      
                    </td>

                    <td> 
                        <?php
                        if (isset($account->bank_account_id)) { 
                            echo acc_data($account->schema_name,$account->bank_account_id)->integration_date;
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
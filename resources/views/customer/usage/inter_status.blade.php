
<?php
$month = request()->segment(3);
$year = request()->segment(4);
$where = (int) $month > 0 && (int) $year > 0 ? ' WHERE extract(year from created_at)=' . $year . ' AND extract(month from created_at)=' . $month : '';

$school_locations = DB::select("select s.name,b.name as ward,d.name as district,r.name as region,c.client_id,e.username as schema_name,z.name as zone_name                
from admin.schools s join admin.wards b on s.ward_id = b.id join admin.districts as d on d.id=b.district_id
join admin.regions r on r.id=d.region_id left join admin.client_schools c on c.school_id = s.id 
left join admin.clients e on e.id=c.client_id join constant.refer_zones z on z.id = r.refer_zone_id where lower(s.ownership) <>'government'");

$zones = [];
foreach ($school_locations as $school_location) {
    $zones[$school_location->schema_name] = $school_location->zone_name;
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
            <?php $i =1;  $bran = [];$acc_no= [];$dates = [];
            foreach ($schools as $school) {
               $branches = DB::select("select a.bank_account_id,a.created_at as integration_date ,b.number,b.branch,b.id from $school->schema_name.bank_accounts_integrations a join $school->schema_name.bank_accounts b on a.bank_account_id = b.id");
                ?>
                <tr>
                     <td><?= $i ?></td>
                     <td> 
                        <?php
                           foreach ($branches as $branch) {
                               echo isset($branch->branch ) ? $branch->branch . ',<br>' : 'Undefined';
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
                        if (isset($school->schema_name)) {
                            echo warp($school->schema_name);
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                    <td>
                      <?php
                       foreach ($branches as $branch) {
                               echo isset($branch->number ) ? $branch->number . ',<br>' : 'Undefined';
                           } 
                        ?>
                    </td>

                    <td> 
                       <?php
                         foreach ($branches as $branch) {
                               echo isset($branch->integration_date ) ? date('d-m-Y', strtotime($branch->integration_date)) . ',<br>' : 'Not Specified';
                           } 
                        ?>
                    </td>
                </tr>
            <?php $i++; } ?>
        </tbody>
    </table>
</div>
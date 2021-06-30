
<?php
$month = request()->segment(3);
$year = request()->segment(4);
$where = (int) $month > 0 && (int) $year > 0 ? ' WHERE extract(year from created_at)=' . $year . ' AND extract(month from created_at)=' . $month : '';

$clients = DB::select('select c.id,c.name as client_name,s.school_id,p.branch_id from admin.clients c 
join admin.client_schools s on c.id = s.client_id left join admin.partner_schools p on 
p.school_id =s.school_id');
$schools = [];
foreach ($clients as $client) {
    $schools[$client->branch_id] = $client->client_name;
}

?>
<div class="table-responsive dt-responsive">
    <table>
        <thead>
            <tr>
                <th>S/N</th>                                                          
                <th>Branch Name</th>                                                          
                <th>Region</th>                                                
                <th>District</th>
                <th>Branch code</th>	
                <th>Contact Person</th>	
                <th>No of schools</th>
                <th>Connected schools</th>
                <th>Zone</th>
            </tr>
        </thead>
        <tbody>
            <?php $i =1;
            foreach ($branches as $branch) { ?>
                <tr>
                     <td><?= $i ?></td>

                     <td> 
                         <?php
                        if (isset($branch->name)) {
                            echo warp($branch->name);
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>
                     <td>
                        <?php
                        if (isset($branch->region)) {
                            echo warp($branch->region);
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                     <td>
                           <?php
                        if (isset($branch->district)) {
                            echo warp($branch->district);
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                    <td>
                      
                    </td>

                    <td>
                          <?php
                        if (isset($branch->uname)) {
                            echo warp($branch->uname);
                        } else {
                            echo 'Not Specified';
                        }
                        ?>
                    </td>

                    <td> 
                      
                    </td>

                    <td><?php 
                       if(isset($branch->schools)){
                           echo $branch->schools;
                       } else {
                            echo 'Not Specified';
                        }
                      ?>
                    </td>

                    <td> 
                        <?php
                        if (isset($schools[$branch->id])) {
                            echo $schools[$branch->id];
                        } else {
                            echo 'No school';
                        }
                        ?>
                    </td>

                      <td> 
                         <?php
                        if (isset($branch->zone_name)) {
                            echo $branch->zone_name;
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
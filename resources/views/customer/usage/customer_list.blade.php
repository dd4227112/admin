
<?php
$month = request()->segment(3);
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
                      
                    </td>

                    <td><?php 
                       if(isset($customer->schools)){
                           echo $customer->schools;
                       } else {
                            echo 'Not Specified';
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
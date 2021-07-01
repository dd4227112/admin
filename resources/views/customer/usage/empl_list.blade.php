
<?php
$month = request()->segment(3);
$year = request()->segment(4);
$where = (int) $month > 0 && (int) $year > 0 ? ' WHERE extract(year from created_at)=' . $year . ' AND extract(month from created_at)=' . $month : '';


$departs = [];
$departments = DB::select("select u.id,d.name from admin.users u join admin.departments d on u.department = d.id where u.status = '1' and role_id not in (7,15)");
foreach ($departments as $department) {
    $departs[$department->id] = $department->name;
}
?>
<div class="table-responsive dt-responsive">
    <table>
        <thead>
            <tr>
                <th>#</th>                                                          
                <th>Name</th>                                                          
                <th>Phone</th>                                                
                <th>Email</th>
                <th>Title</th>	
                <th>Department</th>	
                <th>Perfomance</th>	
                <th>CV</th>	
                <th>JOD</th>	
            </tr>
        </thead>
        <tbody>
            <?php $i =1;
            foreach ($users as $user) {
                ?>
                <tr>
                     <td><?= $i ?></td>
                     <td> 
                          <?= $user->firstname. ' '.$user->lastname ?? 'Undefined' ?>
                    </td>
                      
                     <td>
                         <?= $user->phone ?? 'Not specified'?>
                    </td>

                    <td>
                        <?= $user->email ?? 'Not specified'?>
                    </td>

                    <td>
                        <?= $user->designation->name ?? 'Not specified'?>
                    </td>

                    <td> 
                          <?php
                        if (isset($departs[$user->id])) {
                            echo $departs[$user->id];
                        } else {
                            echo 'Not specified';
                        }
                        ?>
                    </td>

                    <td> 
                        PERFOMANCE
                    </td>

                     <td> 
                        CV
                    </td>

                    <td> 
                          <?= $user->joining_date ?? 'Not specified'?>
                    </td>
                </tr>
            <?php $i++; } ?>
        </tbody>
    </table>
</div>
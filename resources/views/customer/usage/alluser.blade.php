
<?php
$clients = DB::select("select c.id,c.name as client_name,c.username,s.school_id,p.branch_id from admin.clients c 
join admin.client_schools s on c.id = s.client_id left join admin.partner_schools p on 
p.school_id =s.school_id");
$schools = [];
foreach ($clients as $client) {
    $schools[$client->username] = $client->client_name;
}

  function FormatPhoneNumber($phonenumber){
    if (strlen($phonenumber) > 6 && substr($phonenumber, 0, 1) == '0'){
      $phonenumber = "0".substr($phonenumber,1);
    }else if (strlen($phonenumber) > 6 && substr($phonenumber, 0, 4) == '+255') {
      $phonenumber = substr($phonenumber,1);
    }else if (strlen($phonenumber) > 6 && substr($phonenumber, 0, 1) == '6' || substr($phonenumber, 0,1) == '7') {
      $phonenumber = "0".substr($phonenumber,1);
    }
     // return preg_replace('/\D+/', '', $phonenumber);
      return $phonenumber;
  }


?>
<div class="table-responsive dt-responsive">
    <table>
        <thead>
            <tr>
                <th>S/N</th>                                                          
                <th>Full name</th>                                                          
                <th>Usertype</th>                                                          
                <th>Phone number</th>                                                
                <th>School</th>	
                <th>Created Date</th>	
            </tr>
        </thead>
        <tbody>
            <?php $i =1;  
            foreach ($allusers as $user) {
            
                ?>
                <tr>
                     <td><?= $i ?></td>
                     <td> 
                        <?= $user->name ?>
                    </td>

                     <td>
                       <?= $user->usertype ?>
                    </td>

                    <td>
                       <?= FormatPhoneNumber($user->phone) ?? 'Not defined' ?>
                    </td>

                    <td>
                       <?php 
                        if (isset($schools[$user->schema_name])) {
                            echo $schools[$user->schema_name];
                        } else {
                            echo  $user->schema_name;
                        }
                        ?>
                    </td>

                    <td> 
                       <?= date('Y-m-d', strtotime($user->created_at))
                        ?>
                    </td>
                </tr>
            <?php $i++; } ?>
        </tbody>
    </table>
</div>
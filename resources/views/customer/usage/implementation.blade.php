<?php    if(!empty($headers)){ ?>
<table>
    <thead>
        <tr>
            <th></th>
            <?php
         
            $vars = get_object_vars($headers);
            ?>

            <?php
            foreach ($vars as $key => $value) {
                ?>
                <th><?= $key ?></th>

                <?php
            }
            ?>

        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($contents as $content) {
            $i++;
            ?> 

            <tr>
                <td><?= $i ?></td>
                <?php
                $status = '';
                foreach ($vars as $key => $value) {
                    ?> 

                    <?php
                    if ($key == 'completed_at') {
                        ?>
                  <td></td>
                        <td>
                            <?php                           
                           echo check_implementation($content->activity,$content->school_name);
                            ?>
                        </td>
                    <?php } else if ($key == 'status') { ?>
                       
                        <td><?= $status ?></td>

                    <?php } else { ?>
                        <td><?= $content->{$key} ?></td>

                        <?php
                    }
                }
                ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php } else {
     echo '<table>
    <thead>
        <tr>
            <th>Status</th>
            </tr>
            </thead><tbody><tr><td>No Data</td></tr></tbody></table>';            
} ?>

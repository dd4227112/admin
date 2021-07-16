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
                        <td>
                            <?php
                            if (preg_match('/exam/i', strtolower($content->activity))) {
                                //all classes have published an exam


                                $status = 'complete';
                            } else if (preg_match('/account/i', strtolower($content->activity))) {
                                //receive at least 10 payments
                                
                                
                            } elseif (preg_match('/onboarding/i', strtolower($content->activity))) {
                                //track no of users
                                
                            } else if (preg_match('/operation/i', strtolower($content->activity))) {
                                echo 'checke operations';
                                
                            }
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

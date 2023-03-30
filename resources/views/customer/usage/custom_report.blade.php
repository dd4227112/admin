<?php if (!empty($headers)) { ?>
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
                    foreach ($vars as $key => $value) {
                        ?> 
                        <td><?= $content->{$key} ?></td>



                        <?php
                    }
                    ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
} else {
    echo '<table>
    <thead>
        <tr>
            <th>Status</th>
            </tr>
            </thead><tbody><tr><td>No Data</td></tr></tbody></table>';
}
?>

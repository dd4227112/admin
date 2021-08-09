<table>
    <thead>
        <tr>

            <?php
            foreach ($expenses as $expense) {
                ?>
                <th><?= $expense->month_name ?></th>

                <?php
            }
            ?>

        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
      
            foreach ($expenses as $expense) {
                ?> 


                <td><?=$expense->total_amount ?></td>

            <?php } ?>
        </tr>
    </tbody>
</table>

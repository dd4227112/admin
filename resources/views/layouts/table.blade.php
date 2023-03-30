<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <?php foreach ($titles as $value_) { ?>
                <th><?=$value_?></th>
            <?php }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data as $value) {
            ?>
            <tr>
                <th scope="row"><?=$i?></th>
                <?php foreach ($titles as $title) { ?>
                    <td><?= isset($value->{$title}) ? $value->{$title} : '' ?></td>  
                <?php }
                ?>
            </tr>
        <?php $i++; } ?>

    </tbody>
</table>
<table cellspacing="3" cellpadding="5" border="1" >
    <thead>
        <tr>
            <th></th>
            <?php
            $month = 0;
            for ($i = 1; $i <= 12; $i++) {
                ?>
                <th><?= date('F', mktime(0, 0, 0, $i, 10)) ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($items as $key => $item) {
            ?>
            <tr>
                <td><?= strtoupper($key) ?></td>
                <?php
                for ($sx = 1; $sx <= 12; $sx++) {
                    foreach ($item as $fee) {

                        if ((int) $fee->months == (int) $sx) {
                            $table = ${$key . '_table'};
                            $custom_sql = '';
                            if (in_array($key, ['parents', 'login_staffs', 'epayments_nmb', 'epayments_crdb', 'students'])) {

                                switch ($key) {
                                    case 'parents':
                                        $custom_sql = ' and "table"=\'parent\'';
                                        break;
                                    case 'login_staffs':
                                        $custom_sql = '  and "table" in (\'user\',\'teacher\' )  ';
                                        break;
                                    case 'epayments_nmb':
                                        $custom_sql = " and token like '%E%'  ";
                                        break;
                                    case 'epayments_crdb':
                                        $custom_sql = "  and token like '%cbb%'  ";
                                        break;
                                    case 'students':
                                        $custom_sql = ' and "table"=\'student\' ';

                                        break;

                                    default:
                                        $custom_sql = '';
                                        break;
                                }
                            }
                            $sql = "SELECT distinct schema_name from admin.$table where extract(year from created_at)=$year and extract(month from created_at)=$sx  $custom_sql and  schema_name not in ('public','betatwo','jifunze','beta_testing')";
                            ?>
                            <td><a href="<?= $fetch_url . $sql ?>"><?= $fee->count ?></a></td>
                            <?php
                        }
                    }
                }
                ?>
            </tr>
            <tr>
                <td><p align="right"><?= $key ?> New Customers</p></td>
                <?php
                for ($s = 1; $s <= 12; $s++) {
                    $val_count = 0;
                    if (isset(${'new_customers_' . $key})) {


                        foreach (${'new_customers_' . $key} as $val) {
                            if (isset($val->months) && (int) $val->months == (int) $s) {
                                $val_count = $val->count;
                            }
                        }
                    }
                    $sql_new = '  select schema_name from (
select distinct schema_name,extract(month from created_at) as months from admin.' . $table . ' where extract(year from created_at)=' . $year . ' and extract(month from created_at)=' . $s . ' ' . $custom_sql . ' and  schema_name not in (\'public\',\'betatwo\',\'jifunze\',\'beta_testing\') ) x LEFT OUTER JOIN (
select distinct schema_name,extract(month from created_at) as months from admin.' . $table . ' where extract(year from created_at)=' . $year . ' and extract(month from created_at)<' . $s . ' ' . $custom_sql . ' and  schema_name not in (\'public\',\'betatwo\',\'jifunze\',\'beta_testing\')  ) y using(schema_name) where y.schema_name is null';
                    ?>

                    <td><a href="<?= $fetch_url . $sql_new ?>"><?= $val_count ?></a></td>
                <?php } ?>
            </tr>

            <tr>
                <td><p align="right"><?= $key ?> Churn Customers</p></td>
                <?php
                for ($s = 1; $s <= 12; $s++) {
                    $val_count = 0;
                    if (isset(${'new_customers_' . $key})) {


                        foreach (${'new_customers_' . $key} as $val) {
                            if (isset($val->months) && (int) $val->months == (int) $s) {
                                $val_count = $val->count;
                            }
                        }
                    }
                    $l=$s - 1;
                    $churn_sql_new = 'select distinct schema_name from admin.all_payments a  left outer join (  (select distinct schema_name from admin.all_payments where  extract(year from created_at)=' . $year . ''
                            . ' and extract(month from created_at)=' . $s . ' ' . $custom_sql . '  and  schema_name not in '
                            . ' (\'public\',\'betatwo\',\'jifunze\',\'beta_testing\') ) ) v  using(schema_name) where extract(year from created_at)=' . $year . ' '
                            . ' (\'public\',\'betatwo\',\'jifunze\',\'beta_testing\')  and v.schema_name is null ' ;
                    ?>

                    <td><a href="<?= $fetch_url . $churn_sql_new ?>">churn</a></td>
                <?php } ?>
            </tr>


        <?php } ?>
    </tbody>
</table>
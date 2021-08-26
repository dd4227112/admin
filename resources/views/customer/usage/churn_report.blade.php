<table>
    <thead>
        <tr>
            <th></th>
            <?php
            $month = 0;
            for ($i = 1; $i <= 12; $i++) {
                ?>
                <th><?=  date('F', mktime(0, 0, 0, $i, 10)) ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($items as $key => $item) {
            ?>
            <tr>
                <td><?= $key ?></td>
                <?php
                for ($s = 1; $s <= 12; $s++) {
                    foreach ($item as $fee) {
                        if ((int) $fee->months == $s) {

                            if (in_array($key, ['parents', 'login_staffs', 'epayments_nmb', 'epayments_crdb','students'])) {

                                switch ($key) {
                                    case 'parents':
                                        $sql = 'select distinct schema_name from '
                                                . 'admin.all_login_locations a where extract(year from a.created_at)=' . $year . ' and extract(month from a.created_at)=' . $s . ' and "table"=\'parent\' and  schema_name not in (\'public\',\'betatwo\',\'jifunze\',\'beta_testing\') ';
                                        break;
                                    case 'login_staffs':
                                       $sql= 'select distinct schema_name  from '
                                                . 'admin.all_login_locations a where extract(year from a.created_at)=' . $year . ' and extract(month from a.created_at)=' . $s . '  and "table" in (\'user\',\'teacher\' )  and  schema_name not in (\'public\',\'betatwo\',\'jifunze\',\'beta_testing\') ';
                                        break;
                                    case 'epayments_nmb':
                                        $sql = 'select distinct schema_name from admin.all_payments '
                                                . " where extract(year from created_at)=$year and extract(month from created_at)=" . $s . "  and token like '%E%'  and  schema_name not in ('public','betatwo','jifunze','beta_testing')";
                                        break;
                                    case 'epayments_crdb':
                                        $sql = 'select distinct schema_name from admin.all_payments '
                                                . " where extract(year from created_at)=$year and extract(month from created_at)=" . $s . "   and token like '%cbb%'  and  schema_name not in ('public','betatwo','jifunze','beta_testing')";
                                        break;
                                    
                                        case 'students':
                                           $sql ='select distinct schema_name from '
                        . 'admin.all_login_locations a where extract(year from a.created_at)=' . $year . ' and extract(month from created_at)=' . $s . ' and "table"=\'student\'    and  schema_name not in (\'public\',\'betatwo\',\'jifunze\',\'beta_testing\') ';

                                            break;

                                    default:
                                        break;
                                }
                            } else {
                                $table = ${$key . '_table'};
                                $sql = "SELECT distinct schema_name from admin.$table where extract(year from created_at)=$year and extract(month from created_at)=$s  and  schema_name not in ('public','betatwo','jifunze','beta_testing')";
                            }
                            ?>
                            <td><?= $fee->count ?></td>
                            <?php
                        }
                    }
                }
                ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
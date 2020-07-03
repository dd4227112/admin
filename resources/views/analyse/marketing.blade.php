<div class="col-sm-12" id="age_correlation">
    <?php
    $sql_ = 'select count(*) as count, "schema_name" as periods from admin.all_users group by "schema_name" ';
    echo $insight->createChartBySql($sql_, 'periods', 'Overall total_days', 'bar', false);
    //$corr2 = \collect(DB::SELECT('select corr(count,periods) from (' . $sql_ . ' ) x '))->first();
    //echo '<p>Correlation Factor : ' . round($corr2->corr, 3) . '</p>';
    ?>
</div>
<div class="col-sm-12" id="age_correlation">
    <?php
    $sql_ = 'select count(*) as count, "schema_name" as periods from admin.all_users group by "schema_name" ';
    echo $insight->createChartBySql($sql_, 'periods', 'Overall total_days', 'bar', false);
    ?>
</div>
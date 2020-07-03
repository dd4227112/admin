<div class="col-sm-12" id="age_correlation">
    <?php
    $sql_ = 'select avg as count, periods from (select avg(a.mark),a."subjectID",a."classesID", b."teacherID", EXTRACT(YEAR FROM age(cast(c.dob as date))) as age, c.salary,c.sex, (select count(*) from routine where "subjectID"=a."subjectID") as periods  from mark_info a join section_subject_teacher b on b."subject_id"=a."subjectID" join teacher c on c."teacherID"=b."teacherID" ' . $and_class_id . ' GROUP BY a."classesID",a."subjectID", b."teacherID",c.dob,c.salary,c.sex ORDER BY a."subjectID") p';
    echo $insight->createChartBySql($sql_, 'periods', 'Overall total_days', 'scatter', false);
    $corr2 = \collect(DB::SELECT('select corr(count,periods) from (' . $sql_ . ' ) x '))->first();
    echo '<p>Correlation Factor : ' . round($corr2->corr, 3) . '</p>';
    ?>
</div>
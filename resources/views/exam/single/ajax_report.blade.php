<?php
/**
 * Description of report
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>

<div class="sub-title"></div>                                        
<div class="sttabs tabs-style-iconbox">

    <ul class="nav nav-tabs md-tabs " role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home7" role="tab" aria-expanded="true"><i class="icofont icofont-home"></i>General Report</a>
            <div class="slide"></div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#profile7" role="tab" aria-expanded="false"><i class="icofont icofont-ui-user "></i>Summary</a>
            <div class="slide"></div>
        </li>
    </ul>

    <div class="tab-content card-block">
        <div class="tab-pane active" id="home7" role="tabpanel" aria-expanded="true">
            <h3>Exam General Report</h3>
            <p> <a href="<?= url('exam/export/null?class_id=' . $class_info->id . '&school='.request('school').'&exam_id=' . $exam_definition->id . '&token=' . request('token')) ?>" class="btn btn-sm btn-warning"><i class="fa fa-download"></i> Export to Excel</a>
                <br/></p>
            <div id="" class="table-responsive">


                <table  id="result_table" class="table table-bordered dataTable">
                    <thead>
                        <tr>
                            <th class="col-sm-1" >#</th>
                            <th class="col-sm-2" >Name</th>
                            <th class="col-sm-2" >Sex</th>
                            <?php foreach ($subjects as $subject) { ?>
                                <th class="col-sm-1" ><?= $subject->subject_name ?></th>
                                <th class="col-sm-1" >GD</th>
                            <?php } ?>
                            <th class="col-sm-2" >Total Marks</th>
                            <th class="col-sm-2" >Average</th>
                            <th class="col-sm-2" >Grade</th>
                            <th class="col-sm-2" >School Rank</th>
                            <th class="col-sm-2" >Overall Rank</th>
                            <th class="col-sm-3">School</th>
                            <th class="col-sm-3">Region</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
        <div  class="tab-pane" id="profile7" role="tabpanel" aria-expanded="false">
            <div class="card">
                <div class="title_left">
                    <br/>
                    <h3>Subjects Performance by Average</h3>
                    <br/>
                </div>
                <script src="https://code.highcharts.com/highcharts.js"></script>
                <script src="https://code.highcharts.com/modules/data.js"></script>
                <script type="text/javascript">
                    graph_disc = function () {
                    Highcharts.chart('container', {
                    chart: {
                    type: 'column'
                    },
                            title: {
                            text: "Subject Performance Evaluation"
                            },
                            subtitle: {
                            text: ''
                            },
                            xAxis: {
                            type: 'category'
                            },
                            yAxis: {
                            title: {
                            text: 'Avarage %'
                            }

                            },
                            legend: {
                            enabled: false
                            },
                            plotOptions: {
                            series: {
                            borderWidth: 0,
                                    dataLabels: {
                                    enabled: true,
                                            format: '{point.y:.1f}%'
                                    }
                            }
                            },
                            tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                            },
                            series: [{
                            name: 'Avarage',
                                    colorByPoint: true,
                                    data: [
<?php
foreach ($subjects_perfomance as $subject_ev) {
    $subj = strtolower($subject_ev->subject_name);
    ?>
                                        {
                                        name: '<?= ucwords($subject_ev->subject_name) ?>',
                                                y: <?php
        echo $subject_ev->average;
    ?>,
                                                drilldown: ''
                                        },
    <?php
 
}   
?>
                                    ]
                            }]
                    });
                    }
                    $(document).ready(graph_disc);
                </script>


                <div id="container" style="min-width: 70%;  height: 480px; margin: 0 auto"></div>
            </div>
            <div class="card">
                <h3>Best Students - Top Ten</h3>
                <div class="table-responsive">
                <table  id="result_table_top_ten" class="table table-bordered dataTable">
                    <thead>
                        <tr>
                            <th class="col-sm-1" >#</th>
                            <th class="col-sm-2" >Name</th>
                            <th class="col-sm-2" >Sex</th>
                            <?php foreach ($subjects as $subject) { ?>
                                <th class="col-sm-1" ><?= $subject->subject_name ?></th>
                                <th class="col-sm-1" >GD</th>
                            <?php } ?>
                            <th class="col-sm-2" >Total Marks</th>
                            <th class="col-sm-2" >Average</th>
                            <th class="col-sm-2" >Grade</th>
                            <th class="col-sm-2" >School Rank</th>
                            <th class="col-sm-2" >Overall Rank</th>
                            <th class="col-sm-3">School</th>
                            <th class="col-sm-3">Region</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            </div>
            
             <div class="card">
                <h3>Best Students - GIRLS</h3>
                <div class="table-responsive">
                <table  id="result_table_girls" class="table table-bordered dataTable">
                    <thead>
                        <tr>
                            <th class="col-sm-1" >#</th>
                            <th class="col-sm-2" >Name</th>
                            <th class="col-sm-2" >Sex</th>
                            <?php foreach ($subjects as $subject) { ?>
                                <th class="col-sm-1" ><?= $subject->subject_name ?></th>
                                <th class="col-sm-1" >GD</th>
                            <?php } ?>
                            <th class="col-sm-2" >Total Marks</th>
                            <th class="col-sm-2" >Average</th>
                            <th class="col-sm-2" >Grade</th>
                            <th class="col-sm-2" >School Rank</th>
                            <th class="col-sm-2" >Overall Rank</th>
                            <th class="col-sm-3">School</th>
                            <th class="col-sm-3">Region</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
             </div>
            </div>
             <div class="card">
                <h3>Best Students - BOYS</h3>
                <div class="table-responsive">
                <table  id="result_table_boys" class="table table-bordered dataTable">
                    <thead>
                        <tr>
                            <th class="col-sm-1" >#</th>
                            <th class="col-sm-2" >Name</th>
                            <th class="col-sm-2" >Sex</th>
                            <?php foreach ($subjects as $subject) { ?>
                                <th class="col-sm-1" ><?= $subject->subject_name ?></th>
                                <th class="col-sm-1" >GD</th>
                            <?php } ?>
                            <th class="col-sm-2" >Total Marks</th>
                            <th class="col-sm-2" >Average</th>
                            <th class="col-sm-2" >Grade</th>
                            <th class="col-sm-2" >School Rank</th>
                            <th class="col-sm-2" >Overall Rank</th>
                            <th class="col-sm-3">School</th>
                            <th class="col-sm-3">Region</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
    var table = $('#result_table').DataTable({
    "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
            'url': "<?= url('exam/ajaxResults/null?class_id=' . $class_info->id . '&school='.request('school').'&exam_id=' . $exam_definition->id . '&type=all&token=' . request('token')) ?>"
            },
            "columns": [
            {"data": "roll"},
            {"data": "name"},
            {"data": "sex"},
<?php foreach ($subjects as $subject) { ?>
                {"data": "<?= $subject->subject_name ?>"},
                {"data": ""}
                ,
<?php } ?>
            {"data": "total"}
            ,
            {"data": "average"}
            ,
            {"data": "grade"}
            ,
            {"data": "school_rank"}
            ,
            {"data": "rank"}
            ,
            {"data": "schema_name"}
            ,
            {"data": "region"
            }
            ],
            "columnDefs": [

<?php
$i = 4;
foreach ($subjects as $subject) {
    ?>
                {
                "targets": <?= $i ?>,
                        "data": null,
                        "render": function (data, type, row, meta) {
                        var grades = <?= json_encode($grades) ?>;
                        var value = Math.round(row['<?= $subject->subject_name ?>']);
                        var g;
                        $.each(grades, function(i, item) {

                        if (grades[i].gradefrom <= value && grades[i].gradeupto >= value){
                        g = grades[i].grade;
                        }
                        });
                        return g;
                        // console.log(row['<?= $subject->subject_name ?>']);

                        }

                },
    <?php
    $i = $i + 2;
}
?>
            ],
    });
  
    }
    );
</script>

<script type="text/javascript">
    $(document).ready(function () {
    var table = $('#result_table_top_ten').DataTable({
    "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
            'url': "<?= url('exam/ajaxResults/null?class_id=' . $class_info->id . '&school='.request('school').'&exam_id=' . $exam_definition->id . '&type=result_table_top_ten&token=' . request('token')) ?>"
            },
            "columns": [
            {"data": "roll"},
            {"data": "name"},
            {"data": "sex"},
<?php foreach ($subjects as $subject) { ?>
                {"data": "<?= $subject->subject_name ?>"},
                {"data": ""}
                ,
<?php } ?>
            {"data": "total"}
            ,
            {"data": "average"}
            ,
            {"data": "grade"}
            ,
            {"data": "school_rank"}
            ,
            {"data": "rank"}
            ,
            {"data": "schema_name"}
            ,
            {"data": "region"
            }
            ],
            "columnDefs": [

<?php
$i = 4;
foreach ($subjects as $subject) {
    ?>
                {
                "targets": <?= $i ?>,
                        "data": null,
                        "render": function (data, type, row, meta) {
                        var grades = <?= json_encode($grades) ?>;
                        var value = Math.round(row['<?= $subject->subject_name ?>']);
                        var g;
                        $.each(grades, function(i, item) {

                        if (grades[i].gradefrom <= value && grades[i].gradeupto >= value){
                        g = grades[i].grade;
                        }
                        });
                        return g;
                        // console.log(row['<?= $subject->subject_name ?>']);

                        }

                },
    <?php
    $i = $i + 2;
}
?>
            ],
    });
  
    }
    );
</script>

<script type="text/javascript">
    $(document).ready(function () {
    var table = $('#result_table_girls').DataTable({
    "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
            'url': "<?= url('exam/ajaxResults/null?class_id=' . $class_info->id . '&school='.request('school').'&exam_id=' . $exam_definition->id . '&type=result_table_girls&token=' . request('token')) ?>"
            },
            "columns": [
            {"data": "roll"},
            {"data": "name"},
            {"data": "sex"},
<?php foreach ($subjects as $subject) { ?>
                {"data": "<?= $subject->subject_name ?>"},
                {"data": ""}
                ,
<?php } ?>
            {"data": "total"}
            ,
            {"data": "average"}
            ,
            {"data": "grade"}
            ,
            {"data": "school_rank"}
            ,
            {"data": "rank"}
            ,
            {"data": "schema_name"}
            ,
            {"data": "region"
            }
            ],
            "columnDefs": [

<?php
$i = 4;
foreach ($subjects as $subject) {
    ?>
                {
                "targets": <?= $i ?>,
                        "data": null,
                        "render": function (data, type, row, meta) {
                        var grades = <?= json_encode($grades) ?>;
                        var value = Math.round(row['<?= $subject->subject_name ?>']);
                        var g;
                        $.each(grades, function(i, item) {

                        if (grades[i].gradefrom <= value && grades[i].gradeupto >= value){
                        g = grades[i].grade;
                        }
                        });
                        return g;
                        // console.log(row['<?= $subject->subject_name ?>']);

                        }

                },
    <?php
    $i = $i + 2;
}
?>
            ],
    });
  
    }
    );
</script>

<script type="text/javascript">
    $(document).ready(function () {
    var table = $('#result_table_boys').DataTable({
    "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
            'url': "<?= url('exam/ajaxResults/null?class_id=' . $class_info->id . '&school='.request('school').'&exam_id=' . $exam_definition->id . '&type=result_table_boys&token=' . request('token')) ?>"
            },
            "columns": [
            {"data": "roll"},
            {"data": "name"},
            {"data": "sex"},
<?php foreach ($subjects as $subject) { ?>
                {"data": "<?= $subject->subject_name ?>"},
                {"data": ""}
                ,
<?php } ?>
            {"data": "total"}
            ,
            {"data": "average"}
            ,
            {"data": "grade"}
            ,
            {"data": "school_rank"}
            ,
            {"data": "rank"}
            ,
            {"data": "schema_name"}
            ,
            {"data": "region"
            }
            ],
            "columnDefs": [

<?php
$i = 4;
foreach ($subjects as $subject) {
    ?>
                {
                "targets": <?= $i ?>,
                        "data": null,
                        "render": function (data, type, row, meta) {
                        var grades = <?= json_encode($grades) ?>;
                        var value = Math.round(row['<?= $subject->subject_name ?>']);
                        var g;
                        $.each(grades, function(i, item) {

                        if (grades[i].gradefrom <= value && grades[i].gradeupto >= value){
                        g = grades[i].grade;
                        }
                        });
                        return g;
                        // console.log(row['<?= $subject->subject_name ?>']);

                        }

                },
    <?php
    $i = $i + 2;
}
?>
            ],
    });
  
    }
    );
</script>

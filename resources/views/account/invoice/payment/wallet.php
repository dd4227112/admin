

<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-payment"></i> <?= $data->lang->line('panel_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li class="active">Wallet</li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
<div class="row">

<div class="col-sm-12">


<?php
$usertype = session("usertype");
?>

<div class="col-sm-6 col-sm-offset-3 list-group">
    <div class="list-group-item list-group-item-warning">
        <form style="" class="form-horizontal" role="form" method="post">

            <?php
            if (form_error($errors, 'class_level'))
                echo "<div class='form-group has-error' >";
            else
                echo "<div class='form-group' >";
            ?>
            <label for="class_level" class="col-sm-2 col-sm-offset-2 control-label">
                Class Level
            </label>
            <div class="col-sm-6">
                <?php
                $array = array("0" => 'Select Class Level');
                if (isset($classlevels) && !empty($classlevels)) {
                    foreach ($classlevels as $level) {
                        $array[$level->classlevel_id] = $level->name;
                    }
                }
                echo form_dropdown("class_level", $array, old("class_level"), "id='class_level' class='form-control'");
                ?>
            </div>
    </div>
    <?php
    if (form_error($errors, 'academic_year'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
    <label for="sectionID" class="col-sm-2 col-sm-offset-2 control-label">
        <?= $data->lang->line('academic_year') ?>
    </label>
    <div class="col-sm-6">
        <?php
        $array = array("0" => $data->lang->line("select_year"));
       if (isset($academic_years) && !empty($academic_years)) {
            foreach ($academic_years as $academic) {
                $array[$academic->id] = $academic->name;
            }
        }

        echo form_dropdown("academic_year_id", $array, old("academic_year_id"), "id='academic_year_id' class='form-control'");
        ?>
    </div>
</div>
<div class="form-group">
    <label for="classesID" class="col-sm-2 col-sm-offset-2 control-label">
    Select Classes
    </label>


    <div class="col-sm-6">
        <?php
        $array = array("0" => 'Select Classes');
        if (isset($classes) && !empty($classes)) {
            foreach ($classes as $classa) {
                $array[$classa->classesID] = $classa->classes;
            }
        }
        echo form_dropdown("classesID", $array, old("classesID"), "id='classesID' class='form-control'");
        ?>
    </div>
</div>
<div class="form-group">
    <label for="section_id" class="col-sm-2 col-sm-offset-2 control-label">
        Section
    </label>
    <div class="col-sm-6">
        <select name="section_id" id="section_id" class="form-control">

        </select>                    
    </div>

</div>

</form>
</div>
</div>

</div>


        <div class="row">
            <div class="col-sm-12">










                <?php
                if (can_access('view_collection')) {
                    ?>
                    <h5 class="page-header">
                        Advance Payments  per  <?php if(isset($year)){
echo '('.$year->year.')';

                        }?>

                    </h5>
                    <div class="col-sm-12">
                        <div id="hide-table">
                            <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th class="col-sm-1"><?= $data->lang->line('slno') ?></th>
                                        <th class="col-sm-1">Name</th>
                                        <th class="col-sm-1">Amount</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_wallet = 0;
                                    if (isset($students) && count($students)>0) {
                                        $i = 1;
                                        foreach ($students as $student) {

                                            $first_carry_over = \collect(DB::select('select sum(coalesce(amount,0)) as total_due_amount from ' . set_schema_name() . ' due_amounts where student_id=' . $student->student_id . ''))->first();
  
                                            $payment_in_advance = \collect(DB::select('select sum(coalesce(amount,0)) as total_advance_amount from ' . set_schema_name() . ' advance_payments where student_id=' . $student->student_id . ' and payment_id is null'))->first(); 
                                            $payments= \App\Model\Payment::where('student_id', $student->student_id)->whereYear('created_at', '<=',$year->year)->sum('amount');
                                           
                                            $balance= ($student->amount+$first_carry_over->total_due_amount)-($payment_in_advance->total_advance_amount+$payments);


                                            ?>
                                            <tr>
                                                <td data-title="No.">
                                                    <?php echo $i; ?>
                                                </td>

                                                <td data-title="<?= $data->lang->line('fee_name') ?>">
                                                    <a href="<?= base_url('student/view/' . $student->student_id . '/' . $year->id) ?>"> <?php echo $student->name; ?></a>
                                                </td>

                                                
                                                <td data-title="Total paid Amount">
                                                    <?php
                                                  
                                                    echo money($balance);
                                                    $total_wallet += $balance;
                                                    ?>
                                                </td>
                                             


                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-sm-4 col-sm-offset-8 total-marg">
                            <div class="well well-sm">
                                <table style="width:100%; margin:0px;">
                                    <tr>
                                        <td width="50%">
                                            Total Amount
                                        </td>
                                        <td style="width:50%;padding-left:10px">
                                            <?php
                                            echo money($total_wallet);
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>


                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

$('#class_level').change(function (event) {
var class_level_id = $(this).val();
if (class_level_id === '0') {
$('#class_level').val(0);
} else {
$.ajax({
type: 'POST',
        url: "<?= base_url('classes/call_all_classes') ?>",
        data: {class_level_id:class_level_id, not_all:0},
        dataType: "html",
        success: function (data) {
        $('#classesID').html(data);
        }
});
$.ajax({
type: 'POST',
        url: "<?= base_url('academicyear/call_academicyear') ?>",
        data: "class_level_id=" + class_level_id,
        dataType: "html",
        success: function (data) {
        $('#academic_year_id').html(data);
        }
});
}
});
$('#classesID').change(function (event) {
var class_id = $(this).val();
var academic_year_id = $('#academic_year_id').val();
if (class_id === '0' || academic_year_id === '0') {
$('#fee_id').val(0);
} else {

$.ajax({
type: 'POST',
        url: "<?= base_url('student/sectioncall') ?>",
        data: {id:class_id, academic_year_id:academic_year_id, all_section:1},
        dataType: "html",
        success: function (data) {
        $('#section_id').html(data);
        }
});
}
});
$('#section_id').change(function () {
var section_id = $(this).val();
var academic_year_id = $('#academic_year_id').val();
var classesID = $('#classesID').val();
var section_id = $('#section_id').val();
if (classesID === 0 || academic_year_id === 0  || section_id === '') {
alert('Make proper selection first');
$('#hide-table').hide();
$('.nav-tabs-custom').hide();
} else {
    
window.location.href = '<?= base_url("invoices/wallet/") ?>/' + classesID + '/' + academic_year_id +  '/' + section_id;
}
});

</script>
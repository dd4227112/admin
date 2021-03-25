@extends('layouts.app')
@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-invoice"></i> Electronic</h3>


        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $data->lang->line('menu_dashboard') ?></a></li>
            <li class="active"><?= $data->lang->line('menu_student') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">

                <?php
                $set = 9;
                if (can_access('edit_invoice')) {
                    ?>



                    <?php
                }
                ?>


                <?php if (!empty($students)) { ?>

                    <div class="col-sm-12">
                        
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#all" aria-expanded="true">Electronic Payments(s)  (<?=$total_payments ?>)</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="all" class="tab-pane active">
                                    <div id="hide-table">
                                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-1"><?= $data->lang->line('slno') ?></th>
                                                    <th class="col-sm-2">Student Name</th>
                                                    <th class="col-sm-2">Amount</th>
                                                    <th class="col-sm-2">Bank Name</th>
                                                     <th class="col-sm-2">Date</th>

                                               
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($students)) {
                                                    $i = 1;
                                                    foreach ($students as $student) {
                                                        ?>
                                                        <tr>
                                                            <td data-title="<?= $data->lang->line('slno') ?>">
                                                                <?php echo $i; ?>
                                                            </td>

                                                            <td data-title="<?= $data->lang->line('student_name') ?>">
                                                                <?php echo $student->name; ?>
                                                            </td>

                                                            <td data-title="<?= $data->lang->line('student_name') ?>">
                                                                <?php echo $student->amount;  ?>
                                                            </td>
                                                            <td data-title="<?= $data->lang->line('bank_name') ?>">
                                                                <?php
                                                                
                                                                if(isset($student->account_name)) {
                                                                echo  $student->account_name.'('.$student->number.')';      
                                                                }
                                                                
                                                                ?>
                                                            </td>
                                                            
                                                             <td data-title="<?= $data->lang->line('payment_date') ?>">
                                                                <?php echo $student->date;  ?>
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
                                    <div></div>
                                </div>

                            </div>

                        </div> <!-- nav-tabs-custom -->
                    </div> <!-- col-sm-12 for tab -->

<?php } ?>

            </div> <!-- col-sm-12 -->

        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->
<script type="text/javascript">



</script>

@endsection

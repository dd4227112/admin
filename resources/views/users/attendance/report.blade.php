@extends('layouts.app') 
@section('content') 
<?php $seven_day_weeks = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'); ?>

<div class="main-body">
  <div class="page-wrapper">

     <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-blocko">
                
                <form style="" class="form-horizontal" role="form" method="post">
                    <br>
                    <div class="form-group row">
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">Select Type</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="request_type" id="category_id">
                                <option value="0">Select Task Source Here...</option>
                                <option value="date">Day Atteandance</option>
                                <option value="week">Weekly Atteandance</option>
                                <option value="month">Monthly Attendance</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <input type="date" style="display: none;" class="form-control request_type" name="dates" id="dates">

                        <select class="form-control request_type" style="display: none;"  name="request_type" id="month">
                        <?php
                            for($m=1; $m<=12; ++$m){
                                echo '<option value="'.$m.'">'.date('F', mktime(0, 0, 0, $m, 1)).'</option>';
                            }
                            ?>
                        </select>
                        
                        <select class="request_type form-control" style="display: none;" id="weeks">
                            <option value="0">Select Task Source Here...</option>
                            <?php echo($weeks); ?>
                        </select>
                        </div>

                        <?= csrf_field() ?>
                    </div>
                </form> 
           </div>

      


                 
                  <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item complete">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true">
                                    User Information
                                </a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item complete">
                                <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false">Summary</a>
                                <div class="slide"></div>
                            </li>
                          
                        </ul>
                

                     <div class="tab-content">
                       <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                         <div class="card-block">

                        <div id="printablediv">
                            <section class="card">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php
                                            if(isset($type) && isset($set)){
                                             $users =  \App\Models\User::where('status', 1)->whereNotIn('role_id',array(7,15))->get();
                                            //  for ($m = 1; $m <= (int) date('m'); $m++) {
                                                    $m = date('m');
                                                    $dateObj = DateTime::createFromFormat('!m', $m);
                                                    $monthName = $dateObj->format('F');
                                                ?>
                                            <h3><?= $monthName ?></h3>
                                            <div id="hide-table">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                    <?php
                                                        echo "<th>Name</th>";
                                                        for ($i = 1; $i <= 31; $i++) {
                                                            echo "<th>" . ('attendance_' . $i) . "</th>";
                                                        }
                                                        echo "<th>Att</th>";
                                                        echo "<th>Abs</th>";
                                                        echo "<th>Per</th>";
                                                    ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $fi=1;
                                                            foreach($users as $user){
                                                            $total_abs = 0;
                                                            $total_press = 0;
                                                            $total_per = 0;
                                                        ?>
                                                        <tr>
                                                            <td><?=$fi++?></td>
                                                            <td><?=$user->name?></td>

                                                            <?php
                                        if($type == 'month'){
                                            for ($i = 1; $i <= 31; $i++) {

                                                $att = $user->uattendance()->where('date', date('Y-m-d', strtotime(date('Y') . '-' . $m . '-' . $i)))->first();
                                                
                                                if (!empty($att) && $att->present == 1) {
                                                    $att = "P";
                                                    $total_press++;
                                                } elseif(!empty($att->absent_reason_id)) {
                                                    $reason = \DB::table('constant.absent_reasons')->where('id', $att->absent_reason_id)->first();
                                                    if (!empty($reason)) {
                                                        $att = $reason->reason;
                                                        $total_per++;
                                                    }else{
                                                        $att = 'ABS';
                                                    }
                                                }else {
                                                    $att = '';
                                                    $total_abs++;
                                                }
                                                echo "<td>" . $att . "</td>";
                                            }
                                        }elseif($type == 'week'){
                                            $dd = explode('_', $set);
                                            $date1 = date("Y-m-d", $dd[0]);
                                            $date2 = date("Y-m-d", $dd[1]);
                                            
                                            //Find All Payment on This Dates
                                            $period = new DatePeriod(
                                                new DateTime($date1),
                                                new DateInterval('P1D'),
                                                new DateTime($date2)
                                           );
                                            //To iterate
                                        foreach ($period as $key) {
                                            //dd($value->format('Y-m-d'));    
                                            dd($date1);
                                        }
                                      //  dd($period);
                                        exit;
                                            
                
                                         $att = $user->uattendance()->where('date', date('Y-m-d', strtotime(date('Y') . '-' . $m . '-' . $i)))->first();


                                            if (!empty($att) && $att->present == 1) {
                                                $att = "P";
                                                $total_press++;
                                            } elseif(!empty($att->absent_reason_id)) {
                                                $reason = \DB::table('constant.absent_reasons')->where('id', $att->absent_reason_id)->first();
                                                if (!empty($reason)) {
                                                    $att = $reason->reason;
                                                    $total_per++;
                                                }else{
                                                    $att = 'ABS';
                                                }
                                            }else {
                                                $att = '';
                                                $total_abs++;
                                            }
                                            echo "<td>" . $att . "</td>";
                                        }else{
                                            $att = $user->uattendance()->where('date', $set)->first();

                                            if (!empty($att) && $att->present == 1) {
                                                $att = "P";
                                                $total_press++;
                                            } elseif(!empty($att->absent_reason_id)) {
                                                $reason = \DB::table('constant.absent_reasons')->where('id', $att->absent_reason_id)->first();
                                                if (!empty($reason)) {
                                                    $att = $reason->reason;
                                                    $total_per++;
                                                }else{
                                                    $att = 'ABS';
                                                }
                                            }else {
                                                $att = '';
                                                $total_abs++;
                                            }
                                            echo "<td>" . $att . "</td>";
                                        }
                                         
                                            ?>
                                                            <td><?=$total_press?></td>
                                                            <td><?=$total_abs?></td>
                                                            <td><?=$total_per?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>

                                                </table>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                
                            </section>
                        </div>
                    </div>
                 </div>
                </div>
                      

                        <script type="text/javascript">
                            $('#category_id').change(function () {
                                var type = $('#category_id').val();
                                if(type == 'week'){
                                    $('#weeks').show();
                                    $('#dates').hide();
                                    $('#month').hide();
                                }else if(type == 'date'){
                                    $('#weeks').hide();
                                    $('#dates').show();
                                    $('#month').hide();
                                }else{
                                    $('#weeks').hide();
                                    $('#dates').hide();
                                    $('#month').show();
                                }

                            });
                                $('#weeks').change(function () {
                                    var request_type =  $('#weeks').val();
                                    var date_criteria = $('#category_id').val();
                                    if (request_type == '' && date_criteria == '') {
                                        return false;
                                    } else {
                                    window.location.href = "<?= url('tattendance/report/') ?>/" + date_criteria + "/" + request_type;
                                    }
                                });
                                $('#dates').change(function () {
                                    var request_type =  $('#weeks').val();
                                    var date_criteria = $('#category_id').val();
                                    if (request_type == '' && date_criteria == '') {
                                        return false;
                                    } else {
                                    window.location.href = "<?= url('tattendance/report/') ?>/" + date_criteria + "/" + request_type;
                                    }
                                });
                                $('#month').change(function () {
                                    var request_type =  $('#weeks').val();
                                    var date_criteria = $('#category_id').val();
                                    if (request_type == '' && date_criteria == '') {
                                        return false;
                                    } else {
                                        window.location.href = "<?= url('tattendance/report/') ?>/" + date_criteria + "/" + request_type;
                                    }
                                });
                                </script>

@endsection
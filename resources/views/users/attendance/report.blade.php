<?php if(isset($export)) { ?>
<style>
table {
    border-right: 0;
    width: 100%;
    border-top: 0;
    border-bottom: 0;
    border-collapse: collapse;
}
table td {
    border-right: 0.01em solid black;
    border-left: 0.01em solid black;
    border-top: 0.01em solid black;
    padding-left: 5px;
    border-bottom: 0.01em solid black;
}
</style>
<?php } ?>

<?php if(!isset($export) ) { ?>
@extends('layouts.app')
@section('content')
<?php }?>

<?php
    if(isset($type) && $type == 'week'){
        $dd = explode('_', $set);
        //Find All Attendance on This Dates
        $period = new DatePeriod(
            new DateTime(date('Y-m-d', $dd[1])),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', $dd[0]))
       );
    }else{
        $period = [];
    }
  
 if(!isset($export)){  ?>


    
       

         <div class="page-header">
            <div class="page-header-title">
                <h4>Attendances</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Report</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Operations</a>
                    </li>
                </ul>
            </div>
        </div> 


        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                <div class="">
               <div class="col-md-12 col-xl-12">
                           
                <div >
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
                         
         </div>

                  <div class="card tab-card">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                           <li  class="nav-item complete active">
                             <a class="nav-link active" href="#home3" id="home-tab" role="tab"  aria-expanded="true"
                                data-toggle="tab" aria-expanded="true">Staff Attendance</a>
                           </li>
                           <!-- <li class="nav-link">
                               <a  class="nav-link" target="_blank" href="<?php echo $_SERVER['REQUEST_URI']; ?>/export"> <b>Print Report</b> </a>
                          </li> -->
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                <div class="card-block">
                                </div>
                            </div>

                            <div id="printablediv">
                            <section class="card">
                                <div class="card-body">
                        
                                    <?php
                                }
                                if(isset($export) && !empty($export)){
                                    $array = array(
                                            "src" => url('storage/uploads/images/default-logo.png'),
                                            'width' => '120',
                                            'height' => '120',
                                            'class' => 'img-rounded',
                                        );
                                        ?>

                                    <div class="row">
                                        <div class="col-sm-12">
                                        <h2 style="text-align: center; ">  </h2>
                                            <table class="table table">
                                                <tr>
                                                    <th style="width: 25%;"><?= img($array); ?></th>
                                                    <th style="width: 50%;">
                                                        <h6 style="margin-top: 0px;">
                                                           
                                                            <br> Email: support@shulesoft.com<br>
                                                            Phone Number: +255 655/754 406004
                                                            <br> Website: <a href="https://www.shulesoft.com/">www.shulesoft.com/ </a>
                                                            </h6>
                                                    </th>
                                                    <th style="width: 25%;">
                                                        <span class="img_right"><?= img($array); ?></span>
                                                    </th>

                                                </tr>
                                            </table>
                                            <hr> 
                                         <?php } if(isset($type) && isset($set)){    ?>
                                            <h5 style="text-align: center">Staffs Attendance Report  
                                                <?php echo $type == 'date' ? ' on '. $set : '' ?>
                                                <?php echo $type == 'week' ?  ' from '.date('Y-m-d', $dd[1]). ' to '.date('Y-m-d', $dd[0]) : '' ;?>
                                            </h5>
                                            
                                            <div id="hide-table" class="table-responsive">
                                                <table   class="table dataTable table-mini table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                        <td>#</td>
                                                         <?php
                                                        echo "<td class='col-sm-2'><strong>Staff Name</strong></td>";
                                                        echo $type == 'date' ? "<td class='col-sm-1'><strong>Role</strong></td>" : '';
                                                        if($type == 'month'){
                                                        for ($i = 1; $i <= 30; $i++) {
                                                            echo "<td>" . ($i) . "</td>";
                                                        }
                                                    }elseif($type == 'week'){
                                                        foreach ($period as $key => $value) {
                                                            echo "<td  style='text-align: center;'><strong>" . $value->format('D') . "</strong></td>";
                                                        }
                                                    }else{
                                                        echo "<td><strong>Status</strong></td>";
                                                    }
                                                    if($type == 'week' || $type == 'month'){

                                                        echo "<td>Att</td>";
                                                        echo "<td>Abs</td>";
                                                        echo "<td>Per</td>";
                                                        echo "<td>Lates</td>";
                                                        echo "<td>Early leaves</td>";
                                                    } 
                                                    //    echo !isset($export) ? "<td>Action</td>" : '';
                                                    ?>
                                                        </tr>
                                                </thead>
                                                        <tbody>
                                                        <?php 
                                                            $fi=1;
                                                            $the_timein = '08:00:00';
                                                            $the_timeout = '17:00:00';
                                                            foreach($users as $user){
                                                            $total_abs = 0;
                                                            $total_press = 0;
                                                            $total_per = 0;
                                                            $total_lates = 0;
                                                            $total_early_leaves = 0;
                                                        ?>
                                                        <tr>
                                                        <td><?=$fi++?></td>
                                                        <td><?=$user->name()?></td>
                                                        <?php echo $type == 'date' ? '<td>'.$user->role->name.'</td>' : ''; ?>
                                                        <?php
                                        
                                               if($type == 'month'){
                                                  $m = $set;
                                                  for ($i = 1; $i <= 31; $i++) {
                                                      $att = $user->uattendance()->where('date', date('Y-m-d', strtotime(date('Y') . '-' . $m . '-' . $i)))->first();
                                                    if((date('D', strtotime(date('Y') . '-' . $m . '-' . $i)) == 'Sat') || (date('D', strtotime(date('Y') . '-' . $m . '-' . $i)) == 'Sun')){
                                                          $att = '<label class="badge badge-default">S</label>';
                                                    } elseif (!empty($att) && $att->present == 1) {
                                                          if(date("H:i:s",strtotime($att->timein)) > $the_timein){
                                                             $att = '<label class="badge badge-warning">P</label>';
                                                          }elseif(!empty($att->timeout) && date("H:i:s",strtotime($att->timeout)) < $the_timeout){
                                                             $att = '<label class="badge badge-danger">P</label>';
                                                          }else{
                                                             $att = '<label class="badge badge-info">P</label>';
                                                          }
                                                } elseif(!empty($att->absent_reason_id)) {
                                                    $reason = \DB::table('constant.absent_reasons')->where('id', $att->absent_reason_id)->first();
                                                    if (!empty($reason)) {
                                                        $att = substr($reason->reason, 0, 4);
                                                        $total_per++;
                                                    }else{
                                                        $att = 'AB';
                                                    }
                                                }else {
                                                    $att = '';
                                                    $total_abs++;
                                                }
                                                echo "<td style='text-align: center'>" . $att . "</td>";
                                            }
                                        }elseif($type == 'week'){
                                            $dats = 1;
                                            foreach ($period as $key => $value) {                                       
                                            $dats++;
                                            $att = $user->uattendance()->where('date', $value->format('Y-m-d'))->first();
                                           // $early_leaves = $user->uattendance()->where('date', $value->format('Y-m-d'))->where(DB::raw('CAST(timeout::timestamp as time) '), '<', $the_timeout)->where('present',1)->first();
                                             if( (date('D', strtotime($value->format('Y-m-d'))) == 'Sat') || (date('D', strtotime($value->format('Y-m-d'))) == 'Sun') ){
                                                $att = '<label class="badge badge-default">S</label>';
                                              }elseif (!empty($att) && $att->present == 1) {
                                                    if(date('H:i:s',strtotime($att->timein)) > $the_timein){
                                                      $att = '<label class="badge badge-warning">P</label>';
                                                      $total_lates++;
                                                    }elseif(!empty($att->timeout) && date("H:i:s",strtotime($att->timeout)) < $the_timeout){
                                                      $att = '<label class="badge badge-danger">P</label>';
                                                      $total_early_leaves++;
                                                    } else{
                                                       $att = '<label class="badge badge-info">P</label>';
                                                    }
                                                       $total_press++;
                                          
                                            } elseif(!empty($att->absent_reason_id)) {
                                                $reason = \DB::table('constant.absent_reasons')->where('id', $att->absent_reason_id)->first();
                                                if (!empty($reason)) {
                                                    $att = substr($reason->reason, 0,4);
                                                    $total_per++;
                                                }else{
                                                    $att = 'AB';
                                                }
                                            }else {
                                                $att = '';
                                                $total_abs++;
                                            }
                                            echo "<td style='text-align: center'>" . $att . "</td>";
                                        }
                                        }else{
                                            $att = $user->uattendance()->where('date', $set)->first();
                                            if (!empty($att) && $att->present == 1) {
                                                $att = date('H:s:i', strtotime($att->timein)) > '08:00:00' ? "Present(Late)" : "Present";
                                                $total_press++;
                                            } elseif(!empty($att->absent_reason_id)) {
                                                $reason = \DB::table('constant.absent_reasons')->where('id', $att->absent_reason_id)->first();
                                                if (!empty($reason)) {
                                                    $att = $reason->reason;
                                                    $total_per++;
                                                  }else{
                                                    $att = 'Abs';
                                                  }
                                                   }else {
                                                   $att = 'Absent';
                                                   $total_abs++;
                                                 }
                                                 echo "<td style='text-align: center'>" . $att . "</td>";
                                                  }
                                                   if($type == 'week' || $type == 'month'){
                                                                ?>
                                                            <td style='text-align: center'><?=$total_press?></td>
                                                            <td style='text-align: center'><?=$total_abs?></td>
                                                            <td style='text-align: center'><?=$total_per?></td>
                                                            <td style='text-align: center'><?=$total_lates?></td>
                                                            <td style='text-align: center'><?=$total_early_leaves ?></td>
                                                            <?php } ?>
                                                            {{-- <?php echo !isset($export) ? "<td> <a class='btn btn-primary btn-mini btn-round' href=<?= url('attendance/index/'.$user->id) ?> view</a> </td>" : ''; ?> --}}
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                             </section>
                           </div>


                        
                         </div> 
                     </div>
                 </div>

                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>

 <script type="text/javascript">
    $('#category_id').change(function () {
        var type = $('#category_id').val();
        if (type == 'week') {
            $('#weeks').show();
            $('#dates').hide();
            $('#month').hide();
        } else if (type == 'date') {
            $('#weeks').hide();
            $('#dates').show();
            $('#month').hide();
        } else {
            $('#weeks').hide();
            $('#dates').hide();
            $('#month').show();
        }

    });
    $('#weeks').change(function () {
        var request_type = $('#weeks').val();
        var date_criteria = $('#category_id').val();
        if (request_type == '' && date_criteria == '') {
            return false;
        } else {
            window.location.href = "<?= url('attendance/report/') ?>/" +
                date_criteria + "/" + request_type;
        }
    });
    $('#dates').change(function () {
        var request_type = $('#dates').val();
        var date_criteria = $('#category_id').val();
        if (request_type == '' && date_criteria == '') {
            return false;
        } else {
            window.location.href = "<?= url('attendance/report/') ?>/" +
                date_criteria + "/" + request_type;
        }
    });
    $('#month').change(function () {
        var request_type = $('#month').val();
        var date_criteria = $('#category_id').val();
        if (request_type == '' && date_criteria == '') {
            return false;
        } else {
            window.location.href = "<?= url('attendance/report/') ?>/" +
                date_criteria + "/" + request_type;
        }
    });
</script>

<?php if(!isset($export)) { ?>
@endsection
<?php }  ?>


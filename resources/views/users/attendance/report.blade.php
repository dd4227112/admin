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

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>ShuleSoft Attendances</h4>
                <span>Show employee attendance summary</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= url('/') ?>">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Home</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Attendance</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                <div class="">
               <div class="col-md-12 col-xl-12">
                           
                <div class="card-header">
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
                           <li class="nav-link">
                               <a  class="nav-link" target="_blank" href="<?php echo $_SERVER['REQUEST_URI']; ?>/export"> <b>Print Report</b> </a>
                          </li>
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
                                            <table class="table">
                                                <tr>
                                                    <th style="width: 25%;"><?= img($array); ?></th>
                                                    <th style="width: 50%;">
                                                        <h style="margin-top: 0px;">
                                                           
                                                            <br> Email: support@shulesoft.com<br>
                                                            Phone Number: +255 655/754 406004
                                                            <br> Website: <a href="https://www.shulesoft.com/">www.shulesoft.com/ </a>
                                                            </h>
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
                                                <?php echo $type == 'week' ?  ' from '.date('Y-m-d', $dd[1]). ' to '.date('Y-m-d', $dd[1]) : '' ;?>
                                            </h5>
                                            
                                            <div id="hide-table">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr style="background-color: #cccc;">
                                                        <td class="col-sm-1">#</td>
                                                         <?php
                                                        echo "<td class='col-sm-2'><strong>Staff Name</strong></td>";
                                                        echo "<td class='col-sm-2'><strong>Phone  Number</strong></td>";
                                                        echo $type == 'date' ? "<td class='col-sm-1'><strong>Role</strong></td>" : '';
                                                        if($type == 'month'){
                                                        
                                                        for ($i = 1; $i <= 30; $i++) {
                                                            echo "<td class='col-sm-1'>" . ($i) . "</td>";
                                                        }
                                                    }elseif($type == 'week'){
                                                        foreach ($period as $key => $value) {
                                                            echo "<td  style='text-align: center;' class='col-sm-1'><strong>" . $value->format('D') . "</strong></td>";
                                                        }
                                                    }else{
                                                        echo "<td class='col-sm-1'><strong>Status</strong></td>";
                                                    }
                                                    if($type == 'week' || $type == 'month'){

                                                        echo "<td class='col-sm-1'>Att</td>";
                                                        echo "<td class='col-sm-1'>Abs</td>";
                                                        echo "<td class='col-sm-1'>Per</td>";
                                                    } 
                                                 echo !isset($export) ? "<td class='col-sm-1'>Action</td>" : '';
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
                                                            <td style="text-align: center;"><?=$fi++?></td>
                                                            <td><?=$user->name()?></td>
                                                            <td><?=$user->phone?></td>
                                                            <?php echo $type == 'date' ? '<td>'.$user->role->name.'</td>' : ''; ?>
                                                            <?php
                                        
                                               if($type == 'month'){
                                                  $m = $set;
                                                  for ($i = 1; $i <= 31; $i++) {
                                                  $att = $user->uattendance()->where('date', date('Y-m-d', strtotime(date('Y') . '-' . $m . '-' . $i)))->first();
                                                   if (!empty($att) && $att->present == 1) {
                                                     $att = "P";
                                                     $total_press++;
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
                                            if (!empty($att) && $att->present == 1) {
                                                $att = "P";
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
                                      // dd($dats);
                                        }else{
                                            $att = $user->uattendance()->where('date', $set)->first();
                                            if (!empty($att) && $att->present == 1) {
                                                $att = "PRESENT";
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
                                                $att = 'ABSENT';
                                                $total_abs++;
                                                 }
                                                      echo "<td style='text-align: center'>" . $att . "</td>";
                                                       }
                                                   if($type == 'week' || $type == 'month'){
                                                                ?>
                                                            <td style='text-align: center'><?=$total_press?></td>
                                                            <td style='text-align: center'><?=$total_abs?></td>
                                                            <td style='text-align: center'><?=$total_per?></td>
                                                            <?php } ?>
                                                            <?php echo !isset($export) ? "<td> <a href='<?=url('attendance/index/'.$user->id) ?>view</a> </td>" : ''; ?>
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


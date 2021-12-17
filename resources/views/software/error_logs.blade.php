@extends('layouts.app')
@section('content')
<?php  function get_Date($id){
     $date = \collect(DB::select("select created_at from admin.error_logs where id =$id"))->first();
     return date('d-m-Y H:i:s',strtotime($date->created_at));
}
 ?>

          <div class="page-header">
            <div class="page-header-title">
                <h4><?='Error logs' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">errors</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">system errors</a>
                    </li>
                </ul>
            </div>
        </div> 

        <div class="page-body">
            <div class="">
                <div class="row">
                   <p style="font-size:18px;"> <strong class="pl-10">Schema with highest Error Logs</strong>  <label class="badge badge-inverse-danger"> <?= !empty($danger_schema)? $danger_schema->schema_name : '' ?> </label> </p>
                </div>

               <div class="row">
                    <div class="col-md-6 col-xl-4">
                      
                         <div class="card bg-c-yellow text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">All errors</p>
                                                <h4 class="m-b-0">{{ number_format(sizeof($all_errors)) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-layers f-50 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                    </div>
               
                    <div class="col-md-6 col-xl-4">
                       
                         <div class="card bg-c-pink text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5"> Fatal errors </p>
                                                <h4 class="m-b-0">{{ number_format($fatal_errors->total) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-book f-50 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4">
                       
                         <div class="card bg-c-green text-white">
                                    <div class="card-block">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="m-b-5">Resolved errors</p>
                                                <h4 class="m-b-0">{{ number_format($error_log_resolved->total) }}</h4>
                                            </div>
                                            <div class="col col-auto text-right">
                                                <i class="feather icon-check-circle f-50 text-c-red"></i>
                                            </div>
                                    </div>
                                </div>
                        </div>
                    </div>
               </div>
            

               
                 <div class="col-md-12 col-xl-12">
                    <div class="form-group row col-lg-offset-6">
                        <h5 class="col-sm-4"><?= isset($schema_name) ? $schema_name. ' errors': 'Select School' ?></h5>
                        <div class="col-sm-4">
                            <select name="select" class="select2" id="schema_select">
                                <option value="0">Select</option>
                                <?php
                                $schemas = DB::select('select distinct "schema_name" from admin.error_logs');
                                foreach ($schemas as $schema) {
                                    ?>
                                    <option value="<?php echo $schema->schema_name ?>"><?php echo $schema->schema_name ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                </div> 



           <div class="card">
            <div class="card-block">
                <div class="table-responsive">
                    <table id="example"  class="table dataTable table-mini table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> Error Message</th>
                                <th> Created Date</th>
                                <th> Error Instance</th>
                                <th> No. of Occurance</th>
				                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; $error_total = 0; foreach($all_errors as $error) { ?>
                                <tr>
                                    <td> <?= $i?></td>
                                    <td> <?= warp(substr($error->error_message,0,150),40)  ?></td>
                                    <td> <?= get_Date($error->max_id)?></td>
                                    <td> <?= $error->error_instance ?></td>
                                     <td class="text-center h6"> 
                                        <?php $error_total+=$error->total; 
                                         echo $error->total >= 10 ? '<label class="badge badge-danger">' .$error->total. '</label>': $error->total 
                                         ?> 
                                    </td> 
                                    <td>
                                        <?php $view_url =  isset($schema_name) ? "software/readlogs/$error->max_id/$schema_name" : "software/readlogs/$error->max_id"; ?>
                                         <a href="<?= url($view_url) ?>" class="btn btn-primary btn-sm  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="View error">view </a>

                                       <a href="#" class="btn btn-sm btn-round btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="Delete error"
                                       onmousedown="delete_log('<?= $error->max_id ?>')" onclick="return false">delete</a>
                                    </td>
                                    
                                </tr>
                            <?php $i++; } ?>
                         </tbody>
                       
                      </table>
                    </div>
                   </div>
                </div>
             
            <div class="row">
             <div class="col-xl-12">
                <div class="card">
                    <div class="card-body container">
                        <figure class="highcharts-figure">
                                <div id="errors" style="height: 300px;"></div>
                         </figure>
                       </div>
                  </div>
                </div>
            </div>
        
        </div>
    </div>
  </div>


  <script type="text/javascript">

    $(document).ready(function() {
       $('#example').DataTable();
    });

      $('#schema_select').select2({
        placeholder: "Select a State",
        allowClear: true
     });

    $(document).ready(function() {
     delete_log = function (a) {
        $.ajax({
            url: '<?= url('software/logsDelete') ?>/null',
            method: 'get',
            data: {id: a},
            success: function (data) {
                if (data == '1') {
                    window.location.reload();
                    toastr.success('Error deleted successfully!');
                } else{
                    toastr.error('No Error deleted!');
                }
            }
        });
       }


        $('#schema_select').change(function () {
        var schema = $(this).val();
        if (schema == 0) {
            return false;
        } else {
            window.location.href = "<?= url('software/logs') ?>/" + schema;
        }
      });

    });
   
Highcharts.chart('errors', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Error logs'
    },
    subtitle: {
        text: 'All errors, resolved errors and unresolved erros based on month'
    },
    xAxis: {
       categories: [  
            <?php foreach($monthly_errors as $value){  ?> '<?= date('M',strtotime($value->mon)) ?>',
            <?php } ?>
         ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number of errors'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:1f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'All erros',
        data: [
            <?php foreach($monthly_errors as $value){ ?> {
                name: '<?= date('F', strtotime($value->mon)) ?>',
                y: <?=$value->count?>,
                drilldown: <?=$value->count ?>
            },
            <?php } ?>
             ]

    }, {
        name: 'Resolved errors',
        data: [
                <?php foreach($monthly_solved as $value){ ?> {
                name: '<?=  date('F', strtotime($value->mon)) ?>',
                y: <?=$value->count?>,
                drilldown: <?=$value->count ?>
            },
            <?php } ?>
        ]

    }, {
        name: 'Unresolved errors',
        data: [
              <?php foreach($monthly_unsolved as $value){ ?> {
                name: '<?= date('F', strtotime($value->mon)) ?>',
                y: <?=$value->count?>,
                drilldown: <?=$value->count ?>
            },
            <?php } ?>
        ]
    }
    // {
    //     type: 'pie',
    //     name: 'Total errors',
    //     data: [{
    //         name: 'All errors',
    //         y: <?php $sum=0; foreach($monthly_errors as $value){ $sum+=$value->count;} echo $sum; ?>,
    //         color: Highcharts.getOptions().colors[0] 
    //     }, {
    //         name: 'Resolved errors',
    //         y: <?php $sum1=0; foreach($monthly_solved as $value){ $sum1+=$value->count;} echo $sum1; ?>,
    //         color: Highcharts.getOptions().colors[1] 
    //     }, {
    //         name: 'Unresolved errors',
    //         y: <?php $sum2=0; foreach($monthly_unsolved as $value){ $sum2+=$value->count;} echo $sum2; ?>,
    //         color: Highcharts.getOptions().colors[2] 
    //     }],
    //     center: [100, 80],
    //     size: 100,
    //     showInLegend: false,
    //     dataLabels: {
    //         enabled: false
    //     }
    // }
  ]
});


    
  </script>

  @endsection

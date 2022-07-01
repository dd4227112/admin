@extends('layouts.app')
@section('content')

    <div class="page-header">
            <div class="page-header-title">
                <h4>Websites school requests </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">sales</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">schools</a>
                    </li>
                </ul>
            </div>
        </div> 
      
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="table-responsive dt-responsive">
                                <table id="example" class="table table-striped table-bordered nowrap dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School Name</th>
                                            <th>Contact name</th>
                                            <th>Phone number</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                            foreach ($allrequests as $request) { 
                                            ?>
                                            <tr>
                                                <td> <?= $i ?> </td>
                                                <td> <?= !empty($request->school_name) ? $request->school_name : '' ?></td>
                                                <td> <?= $request->contact_name ?></td> 
                                                <td> <?= $request->contact_phone ?></td> 
                                                <td> <?= $request->contact_email ?></td> 
                                                <td> 
                                                    <?php $view_url="sales/viewRequest/$request->id"; ?>
                                                 <a href="<?= url($view_url) ?>" class="btn btn-primary btn-mini  btn-round" data-placement="top"  data-toggle="tooltip" data-original-title="Request"> view </a>
                                                    

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
                            <div class="card-body">
                                <figure class="highcharts-figure">
                                  <div id="onboardBar" style="height: 400px;"></div>
                                </figure>
                            </div>
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

    Highcharts.chart('onboardBar', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Schools Vs Months'
    },
    subtitle: {
        text: 'Overall schools onboarded'
    },
    xAxis: {
        type: 'Months',
       
        categories: [
        <?php foreach($requests as $value){  ?> '<?=date("M", strtotime($value->month))?>',
        <?php } ?>
      ]
    },
    yAxis: {
        title: {
            text: 'Schools'
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Months',
        colorByPoint: true,
        data: [
            <?php foreach($requests as $value){ ?> {
                name: '<?=date("M", strtotime($value->month))?>',
                y: <?=$value->schools?>,
                drilldown: <?=$value->schools ?>
            },
            <?php } ?>
        ]
    }]
});
</script>
@endsection
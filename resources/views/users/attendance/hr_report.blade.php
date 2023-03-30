@extends('layouts.app')
@section('content')

  

        <div class="page-header">
            <div class="page-header-title">
                <h4>Employees Attendances</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Attendance</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Operations</a>
                    </li>
                </ul>
            </div>
        </div> 
   
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
           <div class="card">
            <div class="card-block">
               
              <div class="row">
                 <div class="col-sm-4">
                     <div class="card">
                        <div class="card-header">
                            Choose Date
                        </div>
                       <div class="card-block">
                        <input type="date" name="search_date" id="search_date" class="form-control" value="<?= date('Y-m-d', strtotime($day)) ?>" />
                      </div>  
                     </div>  
                  </div>  
                </div>  
    
                  <div class="table-responsive">
                    <table id="dt-ajax-array" class="table dataTable table-mini table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th># </th>
                          <th>Name</th>
                          <th>Date</th>
                          <th>Time In </th>
                          <th>Time out </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php  $i = 1; if(!empty($attendances)){
                        foreach($attendances as $attendance){ ?>
                      <tr>
                          <td><?= $i?></td>
                          <td><?= $attendance->name ?></td>
                          <td><?= date('d-m-Y', strtotime($attendance->date)) ?></td>
                          <td><?= date('d-m-Y H:i:s', strtotime($attendance->timein)) ?></td>
                          <td><?= isset($attendance->timeout) ? date('d-m-Y H:i:s', strtotime($attendance->timeout)) : '' ?></td>
                        
                      </tr>
                        <?php $i++;} } ?>
                      </tbody>

                    </table>
                  </div>
                 </div>
                
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

 <script type="text/javascript">

   $('#search_date').change(function () {
        var request_date = $('#search_date').val();
        if (request_date == '') {
            return false;
        } else {
            window.location.href = "<?= url('attendance/hr_report/') ?>/" + request_date;
        }
    });
 </script>

@endsection

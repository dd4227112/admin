@extends('layouts.app')
@section('content')


<!-- Sidebar inner chat end-->
<!-- Main-body start -->

  
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4 class="box-title">Applicants </h4>
        <span>This Part show all Applicants applied for various positions</span>

      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Applicants</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Listing</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <!-- Ajax data source (Arrays) table start -->
          <div class="card tab-card">
            <div class="card-block">
         
              <div class="steamline">
                <div class="card-block">

                  <div class="table-responsive dt-responsive">
                    <table id="dt-ajax-array" class="table table-striped table-bordered nowrap dataTable">
                      <thead>
                        <tr>
                            <th >#</th>
                            <th >Name</th>
                            <th >Phone</th>
                            <th >D.O.B</th>
                            <th >Gender</th>
                            <th >Field</th>
                            <th >Location</th>
                            <th >Action</th>
                        </tr>
                      </thead>
                       
                      <tbody>
                        <?php $i = 1; if(!empty($applicants)) { ?>
                        @foreach ($applicants as $key => $value)
                        <tr>
                            <td><?= $i ?></td>
                            <td>{{ $value->fullname }} </td>
                            <td>{{ $value->phone }}</td>
                            <td>{{ date('d M Y',strtotime($value->dob)) }}</td>
                            <td>{{ $value->sex }}</td>
                            <td>{{ $value->skills }}</td>
                            <td>{{ $value->location }}</td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ url('applicants/show/'.$value->id) }}">view</a>
                                <?php if($value->status == '0') { ?>
                                  <span class="badge badge-danger">Rejected</span>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach 
                        <?php } ?>
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
  </div>
</div>
@endsection



@extends('layouts.app')
@section('content')
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4 class="box-title">Key Perfomance Indicator </h4>
        <span>Register all key performance indicator</span>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="<?= url('/') ?>">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Company </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">KPI</a>
          </li>
        </ul>
      </div>
    </div>
 
    <div class="page-body">
      <div class="row">
        <div id="outer" class="container">
          <div id="wrapper" class="layout" style="background-color: #fff; margin-bottom: 40px;">
            <div id="editorForm">
           
              {{ csrf_field() }}
              <div class="card-block">
              
                <table class="table m-0">
                  <tbody>
                      <tr>
                        <th scope="row">KPI Title: &nbsp;&nbsp; <?= $data->name ?></th>
                       </tr>
                       <tr>
                         <th scope="row"> Value: &nbsp;&nbsp;<?= $data->value ?></th>
                       </tr>
                        <tr>
                         <th scope="row"> Query: &nbsp;&nbsp;<?= $data->query ?></th>
                       </tr>
                    <tr>
                    </tr>
                 </tbody>
             </table>
                
            <form method="post" action="<?= url('users/assignkpi/'.$data->id) ?>">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                          <h5>  Choose employee to assign KPI</h5> 
                            <hr>
                            <?php
                            $ids = \App\Models\KPIUser::where('kpi_id',$data->id)->get(['user_id']);
                            $users = DB::table('users')->where('status', 1)->where('role_id', '<>', 7)->whereNotIn('id',$ids)->get();
                            foreach ($users as $user) {
                              ?>
                              <input type="checkbox" id="feature<?= $user->id ?>" value="{{$user->id}}" name="user_id[]">  <?php echo $user->name; ?>  &nbsp; &nbsp;
                        <?php } ?>
                      </div>
                   </div>

                   <div id="savebtnWrapper" class="form-group">
                    <button type="submit" class="btn btn-primary">
                      &emsp;Assign&emsp;
                    </button>
                  </div>
              </form>

                
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

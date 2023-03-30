@extends('layouts.app')

@section('content') 
<?php $root = url('/') . '/public/' ?>

    
      <x-breadcrumb :breadcrumb="$breadcrumb"> </x-breadcrumb>

        <?php if (can_access('manage_users')) { ?>
            <div class="page-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="wrapper" class="card">
                                    <div class="card-header">
                                    <a class="approve btn btn-success btn-sm right" href="#"  data-toggle="modal" data-target="#customer_contracts_model">  <i class="ti-plus"> </i> New Staff</a>
                                    </div>
                                   
                                    <div class="card-block">

                                        <div class="table-responsive dt-responsive ">
                                            <table class="table table-bordered dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <!-- <th>Photo</th> -->
                                                        <th>Name</th>
                                                        <th>Sex</th>
                                                        <th>Phone</th>
                                                        <th>Email</th>
                                                        <th>Personal Email</th>
                                                        <th>Role</th>
                                                        <th>Joining Date</th>
                                                        <th width="280px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($staffs as $key => $staff)
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <!-- <td><img src="{{$root.'images/'.$staff->user->dp }}" class="img-circle" style="position: relative;
                                                                 width: 30px;
                                                                 height: 30px;
                                                                 border-radius: 50%;
                                                                 overflow: hidden;"></td> -->
                                                        <td>{{ $staff->user->firstname }} {{ $staff->user->lastname }}</td>
                                                        <td>{{ $staff->user->sex }}</td>
                                                        <td>{{ $staff->user->phone }}</td>
                                                        <td>{{ $staff->user->email }}</td>
                                                        <td>{{ $staff->user->personal_email }}</td>
                                                        <td>{{ $staff->user->position }}</td>
                                                         <td>{{ date('d M Y',strtotime($staff->user->created_at)) }}</td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="{{ url('users/show/'.$staff->user->id) }}">Show</a>

                                                            <a class="btn btn-primary btn-sm" href="{{ url('users/edit/'.$staff->user->id) }}">Edit</a>


                                                            <a class="btn btn-danger btn-sm" href="{{ url('users/destroy/'.$staff->user->id) }}">Delete</a>

                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="customer_contracts_model" role="dialog" style="z-index: 99999;" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add New Staff on <?=$branch->name?> Branch </h4>
        <span id="modeltitle"></span>

      </div>
      <form action="<?=url('Partner/AddStaff')?>" class="form-card" method="post">
      <div class="modal-body">
      <div class="card-block">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group row">
            <div class="col-sm-6">
                <strong>First Name:</strong>
                {!! Form::text('firstname', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
        <div class="col-sm-6">
                <strong>Last Name:</strong>
                {!! Form::text('lastname', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
            </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group row">
            <div class="col-sm-6">
                <strong>Company Email:</strong>
                {!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control ','type'=>'email','id'=>'email')) !!}
               
            </div>
            <div class="col-sm-6">
                <strong>Personal Email:</strong>
                {!! Form::email('personal_email', null, array('placeholder' => 'Personal Email','class' => 'form-control ','type'=>'email','id'=>'personal_email')) !!}
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group row">
            <div class="col-sm-6">
            <strong>Phone:</strong>
                {!! Form::text('phone', null, array('placeholder' => 'Phone Number','class' => 'form-control','type'=>'text','id'=>'phone')) !!}
            </div>
        <div class="col-sm-6">
            <strong>Gender:</strong>
                <br/>
                <select name='sex' class="form-control">
                    <option value="male">Male </option>
                    <option value="female">Female </option>
                </select>
               </div>
            </div>
        </div>
     
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                <br/>
                <select name='position' class="form-control">
                    <option value="">Select Role Here...</option>
                    <option value="System Administrator">System Administrator </option>
                    <option value="Sales Agent">Sales Agent </option>
                    <option value="Marketing Agent">Marketing Agent </option>
                    <option value="Manager">Manager </option>
                    <option value="Customer Service">Customer Service </option>
                    <option value="Client Support">Client Support </option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                
            </div>
        </div>
     
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <!-- <strong>Attach Picture*:</strong>  <br/>
                <input type="file" class="form-control" name="picture" value="" required> -->
                
            </div>
        </div>
    </div>
    <div class="modal-footer">
    <input type="hidden" name="branch_id" value="<?=$branch->id?>" >
        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light "> Submit </button>
    </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div> 
</div>
</div>
</div> 
<script>

</script>
    @endsection
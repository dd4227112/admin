@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
  

  
    <!-- Page-header start -->
       
         <div class="page-header">
            <div class="page-header-title">
                <h4><?='Add Partner School' ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">updates</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Marketing</a>
                    </li>
                </ul>
            </div>
        </div> 

    
    <!-- Page-body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
              @if (sizeof($errors) > 0)
              <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
             
              <div class="card-block">
              <form method="post" action="#" enctype='multipart/form-data'>
              {{ csrf_field() }}
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <strong>Select School:</strong>
                    <input type="text" class="form-control" id="get_schools" name="school_id" value="<?= old('school_id') ?>" >

                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">
                  <div class="row">
                  <div class="col-md-6">
                  <strong>Account Name:</strong>
                    <input type="text" class="form-control" placeholder="Enter Partner name here..." autofocus="1" name="account_name" required>
                    </div>
                      <div class="col-md-6">
                    <strong>Account Number:</strong>
                    <input type="text" class="form-control" placeholder="Type Account Number Here..." name="account_number" required>
                  </div>
                  </div>
                  </div>
                  </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                  <div class="row">
                  <div class="col-md-6">
                    <strong>Select Region Branch:</strong>
                    <select name=''  id="region" class="form select2" required>
                     
                     <option value="">Select Region Here... </option>
                     @foreach($regions as $value)

                     <option value="{{$value->id}}">{{ucfirst($value->name)}} </option>

                     @endforeach
                   </select>
                    </div>
                      <div class="col-md-6">
                    <strong>Select Branches:</strong>
                    <select name='branch_id'  id="branch_id" class="form-conttrol select2" required>
                     <option value="">Select Branch Here... </option>
                    
                   </select>
                   <a href="#"> Add New Branch </a>

                  </div>
                    </div>
                    </div>
                    </div>
                
                          <hr>
                <div id="savebtnWrapper" class="form-group">
                  <button type="submit" class="btn btn-primary btn-sm btn-round">
                    &emsp;Submit&emsp;
                  </button>
                </div>
              </div>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

$(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
});
</script>
   <script type="text/javascript">   
   
        $('#region').change(function () {
            var val = $(this).val();
            $.ajax({
                method: 'get',
                url: '<?= url('Users/getBranch/null') ?>',
                data: {region: val, partner_id: <?=$partner->id?>},
                dataType: 'html',
                success: function (data) {
                    $('#branch_id').html(data);
                }
            });
        });

get_schools = function () {
    $("#get_schools").select2({
        minimumInputLength: 2,
       // tags: [],
        ajax: {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            url: '<?= url('customer/getschools/null') ?>',
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term,
                    token: $('meta[name="csrf-token"]').attr('content')
                };
            },
            results: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        };
                    })
                };
            }
        }
    });
}

$(document).ready(get_schools);
</script>
@endsection

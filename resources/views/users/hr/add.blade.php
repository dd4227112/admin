@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?>
<div class="main-body">
    <div class="page-wrapper">

        
       <div class="page-header">
            <div class="page-header-title">
                <h4>Add request</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">hr</a>
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
                                <div class="card-block">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <strong> Request Type</strong>

                                                    <select type="text" name="task_type_id"  style="text-transform:uppercase" required class="form-control select2">
                                                        <option value="1">Select Here...</option>
                                                        <?php
                                                        $users = DB::table('task_types')->where('department', 2)->get();
                                                        foreach ($users as $school) {
                                                            ?>
                                                            <option value="<?= $school->id ?>"><?= $school->name ?></option>
<?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong> Select Sub Type</strong>
                                                    <select name="next_action" class="form-control">
                                                        <option value="new">New</option>
                                                        <option value="pipeline">Pipeline</option>
                                                        <option value="closed">Closed</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong> Budget(any) -Tsh</strong>
                                                    <input type="number" name="budget" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">

                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <strong> Start Date</strong>
                                                    <input type="datetime-local" class="form-control" placeholder="Deadline" name="start_date">
                                                </div>
                                                <div class="col-md-6">
                                                    <strong> End Date </strong>
                                                    <input type="datetime-local" class="form-control" placeholder="Time" name="end_date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong> Add More Details Here...</strong>
                                            <textarea name="activity" rows="5" id="content_part" placeholder="Write More details Here .." class="form-control"> </textarea>
                                        </div>
                                    </div>

                                    <div id="savebtnWrapper" class="form-group">
                                        <button type="submit" class="btn btn-primary">
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

<script type="text/javascript">

$(".select2").select2({
    theme: "bootstrap",
    dropdownAutoWidth: false,
    allowClear: false,
    debug: true
});
$('#region').change(function () {
    var val = $(this).val();
    $.ajax({
        method: 'get',
        url: '<?= url('Users/getBranch/null') ?>',
        data: {region: val},
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

@extends('layouts.app')
@section('content')
<style>
    .click_view {
        cursor: pointer;
    }

    .loader-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 120px;
        margin-left: 130%;
    }

    /* Style for the loading animation */
    .loader {
        border: 4px solid #f3f3f3;
        /* Light gray border */
        border-top: 4px solid #3498db;
        /* Blue border for animation */
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 2s linear infinite;
        /* Animation called "spin" */
    }

    /* Keyframes animation for the spinner */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Style for the loading text */
    .loading-text {
        margin-top: 0px;
    }
</style>
<div class="page-header">
    <div class="page-header">
        <div class="page-header-title">
            <h4> Fee Collection Summary</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="<?= url('/') ?>">
                        <i class="feather icon-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">home</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">account Usage</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-12 col-lg-3 m-b-20">
            <form action="" method="POST" class="form">
                @csrf
                <h6>Pick date </h6>
                <input type="date" name="date1" value="{{$dates[0]}}" class="form-control">
        </div>
        <div class="col-sm-12 col-lg-3 m-b-20">
            <h6>Duration </h6>
            <select name="duration" required class="form-control">
                <option value="Week" <?= $duration == 'Week' ? 'selected' : '' ?>>Weekly</option>
                <option value="Month" <?= $duration == 'Month' ? 'selected' : '' ?>>Month</option>
                <option value="Year" <?= $duration == 'Year' ? 'selected' : '' ?>>Yearly</option>

            </select>
        </div>
        <div class="col-sm-12 col-lg-3 m-b-20">
            <h6> &nbsp; </h6>
            <input type="submit" value="Search" class="input-sm btn btn-sm btn-success">
        </div>
        </form>
    </div>
    <input type="hidden" name="date1" value="{{$dates[0]}}"> 
    <input type="hidden" name="date2" value="{{$dates[1]}}">
    <input type="hidden" name="date3" value="{{$dates[2]}}">
    <input type="hidden" name="date4" value="{{$dates[3]}}">
    <input type="hidden" name="difference" value="{{$difference}}">
    <div class="row">
        <div class="col-md-6 col-xl-4 click_view this_month">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green f-w-700">{{ number_format($current)}} </h4>
                            <h6 class="text-muted m-b-0">This {{$duration}} </h6>
                            <h6 class="text-muted m-b-0">{{$dates[0]}} - {{$dates[1]}} </h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-activity f-30"></i>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <div class="col-md-6 col-xl-4 click_view last_month">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green f-w-700">{{ number_format($last)}} </h4>
                            <h6 class="text-muted m-b-0">Last {{$duration}}</h6>
                            <h6 class="text-muted m-b-0">{{$dates[2]}} - {{$dates[3]}} </h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-activity f-30"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4 click_view difference_btn">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-<?=$difference<0?'danger':'success'?> f-w-700">{{ number_format($difference)}} </h4>
                            <h6 class="text-muted m-b-0">Not Issues this {{ $duration }} but Issued last {{ $duration }}</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-activity f-30"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- list schools -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Schools</h5>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered " id="load_data">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Last Date</th>
                                </tr>
                            </thead>
                            <tbody class="body">

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end list school -->
    </div>

</div>
</div>
</div>
<script type="text/javascript">
    function fetch_data(item) {
        $('.body').html("<div class='loader-container'><div class='loader'></div><div class='loading-text'>Please Wait...</div></div>");
        var date1 = $('input[name =date1]').val();
        var date2 = $('input[name =date2]').val();
        var date3 = $('input[name =date3]').val();
        var date4 = $('input[name =date4]').val();

        var difference  = $('input[name =difference]').val();
        $.ajax({
            url: "fetch_school/" + date1 + "/" + date2 + "/" + date3 + "/"+date4+"/" + item+"/"+difference,
            type: 'POST',
            dataType: 'json', // Assuming the response is in JSON format
            success: function(data) {
                var table = $('#load_data').DataTable();
                table.destroy();
                $('#load_data').DataTable({
                    ajax: {
                        url: "fetch_school/" + date1 + "/" + date2 + "/" + date3 + "/"+date4+"/" + item+"/"+difference,
                        dataSrc: 'data',
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'schema_name'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'created_at'
                        }
                    ]
                });
            }
        });
    }
    last = function() {
        $('.last_month').on('click', function() {

            fetch_data('last');
        });

    }
    current = function() {

        $('.this_month').on('click', function() {
            fetch_data('current');
        });

    }
    difference = function() {
        $('.difference_btn').on('click', function() {
            var difference  = $('input[name =difference]').val();
            fetch_data('difference');
        });

    }
    $(document).ready(last);
    $(document).ready(current);
    $(document).ready(difference);
    $(document).ready(function(){
        $('select[name =duration]').on('change', function(){
            var duration = $(this).val();
            if (duration =="Year") {
                alert(' Warning!!This selection may take too long to load data.If not much neccessary, don\'t use it');
            }
        });

    });



    formatDate = function(date) {
        date = new Date(date);
        var day = ('0' + date.getDate()).slice(-2);
        var month = ('0' + (date.getMonth() + 1)).slice(-2);
        var year = date.getFullYear();
        return year + '-' + month + '-' + day;
    }
</script>
@endsection
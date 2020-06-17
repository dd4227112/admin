@extends('layouts.app')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Customer Analysis</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Error Logs</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row"><iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQoKa03HKhOJyUEWt3mi4PqJvqy9EFmoj8ZTZX7lfNWTI5FbHFTHl40xrBBsi7k2x2vY8htOPJ1wHN8/pubhtml?widget=true&amp;headers=false" width="100%" height="450"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Clients</h4>
                <span>List of clients that we serve</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Clients</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">

                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Clients</h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                            <br/>
                            <a href="<?= url('account/createClient') ?>" class="btn btn-sm btn-primary">Create New Client</a>
                        </div>
                        <div class="col-md-12 col-xl-12">

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Client Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Total Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_amount = 0;
                                        $total_paid = 0;
                                        $total_unpaid = 0;
                                        $i = 1;
                                        ?>
                                        @foreach($clients as $client)

                                        <tr>
                                            <td><?= $i ?></td>
                                            <td>{{$client->name}}</td>
                                            <td>{{$client->email}}</td>
                                            <td>{{$client->phone}}</td>
                                            <td>{{$client->address}}</td>
                                            <td>{{$total_amount+=$client->payments()->sum('amount')}}</td>
                                            <td>    
                                                <a href="<?= url('account/client/edit/' . $client->id) ?>" class="btn btn-sm btn-primary">Edit</a>
                                                <a href="<?= url('account/client/delete/' . $client->id) ?>" class="btn btn-sm btn-danger">Delete</a></td>
                                        </tr>
                                        <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td  colspan="2">Total</td>


                                            <td><?= $total_amount ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>
@endsection
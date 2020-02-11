@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/'; ?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Projects/Services</h4>
                <span>List of Services and Projects</span>
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
                    <li class="breadcrumb-item"><a href="#!">Projects</a>
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
                            <h5>Projects</h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                            <br/>
                        </div>
                        <div class="col-md-12 col-xl-12">

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Project Name</th>
                                            <th>Total Amount</th>
                                            <th>Collected Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_amount = 0;
                                        $total_paid = 0;
                                        $total_unpaid = 0;
                                        $total_collected=0;
                                        $i = 1;
                                        ?>
                                        @foreach($projects as $project)

                                        <tr>
                                            <td><?= $i ?></td>
                                            <td>{{$project->name}}</td>
                                            <td>{{number_format($project->invoiceFees()->sum('amount'))}}</td>
                                            <?php
                                            $paid=\App\Models\InvoiceFeesPayment::whereIn('invoice_fee_id',$project->invoiceFees()->get(['id']))->join('payments','payments.id','invoice_fees_payments.payment_id')->sum('amount');
                                            ?>
                                            <td>{{number_format($paid)}}</td>
                                        </tr>
                                        <?php 
                                        $total_amount += $project->invoiceFees()->sum('amount');
                                        $total_collected +=$paid;
                                        $i++; ?>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td  colspan="2">Total</td>


                                            <td><?= number_format($total_amount) ?></td>
                                            <td><?= number_format($total_collected) ?></td>
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
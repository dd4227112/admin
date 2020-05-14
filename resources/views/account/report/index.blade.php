@extends('layouts.app')
@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Company Financial Reports</h4>
                <span>View and analyse financial performance</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Reports</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-block">
                            <div class="box-header">

                                <div class="x_content">

                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                        <ul class="stats-overview">
                                            <li>
                                                <table class="data table no-margin">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th><i class="fa fa-book"></i>Financial Statements</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-left">
                                                                <a href="<?php echo url('expense/financial_index/1') ?>">income_statement</a>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-left"><a href="<?php echo url('expense/financial_index/3'); ?>">cash_flow</a></td>

                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-left">     <a href="<?php echo url('expense/financial_index/2'); ?>">report_balance</td>

                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-left"><a href="<?php echo url('expense/financial_index/4'); ?>">Trial Balance</a></td>

                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </li>
                                            <li>
                                                <table class="data table no-margin">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th><i class="fa fa-book"></i>Payment Report</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-left">     <a href=" <?php echo url('invoices/payment_history') ?>">Invoice Payment</a></td>

                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-left">
                                                                <a href=" <?php echo url('revenue/index'); ?>">non_invoiced_revenue</a></td>

                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-left"><a href="<?php echo url('invoices/wallet'); ?>">Advanced Payment</a></td>

                                                        </tr>



                                                    </tbody>
                                                </table>
                                            </li>
                                            <li class="hidden-phone">
                                                <table class="data table  no-margin">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th><i class="fa fa-book"></i>Balance Reports</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-left"></td>

                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-left">
                                                                <a href="<?= url('expense/summary'); ?>">expense revenue</a>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-left"><a href="<?php url('fee_detail/due_amount') ?>"> Due Amount </a></td>

                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-left"></td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </li>
                                        </ul>
                                        <br>

                                        <!--<div id="mainb" style="height:350px;"></div>-->

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